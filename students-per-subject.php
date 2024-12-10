<?php
session_start();
include __DIR__ . '/includes/webconnect.php';

// Check if a subject_id is passed in the URL
if (!isset($_GET['subject_id'])) {
    die("No subject specified.");
}

// Fetch the subject details
$subject_id = $_GET['subject_id'];
$subjectQuery = "SELECT name, description FROM subjects WHERE subject_id = ?";
$stmt = $con->prepare($subjectQuery);
$stmt->bind_param("i", $subject_id);
$stmt->execute();
$subjectResult = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch students enrolled in the subject along with their grades
$studentsQuery = "
    SELECT g.grades_id, s.student_id, s.student_firstname, s.student_lastname, g.grade
    FROM students s
    INNER JOIN grades g ON s.student_id = g.student_id
    WHERE g.subject_id = ?";
$stmt = $con->prepare($studentsQuery);
$stmt->bind_param("i", $subject_id);
$stmt->execute();
$studentsResult = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students in <?php echo htmlspecialchars($subjectResult['name']); ?></title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Students Enrolled in <?php echo htmlspecialchars($subjectResult['name']); ?></h1>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($subjectResult['description']); ?></p>

        <!-- Search and Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form class="form-inline">
                    <input type="text" id="student-search" class="form-control form-control-sm col-sm-4" placeholder="Search by student ID or name">
                </form>
            </div>
        </div>

        <!-- Students Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="students-table-body">
                <?php while ($row = $studentsResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_firstname']) . ' ' . htmlspecialchars($row['student_lastname']); ?></td>
                        <td><?php echo htmlspecialchars($row['grade']); ?></td>
                        <td>
                            <button 
                                class="btn btn-sm btn-warning edit-btn" 
                                data-toggle="modal" 
                                data-target="#editGradeModal"
                                data-grades-id="<?php echo $row['grades_id']; ?>" 
                                data-grade="<?php echo htmlspecialchars($row['grade']); ?>">Edit
                            </button>
                            <a href="admin/delete-grade.php?grades_id=<?php echo $row['grades_id']; ?>&subject_id=<?php echo $subject_id; ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this record?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="manage-subjects.php" class="btn btn-primary">Back to Subjects</a>
    </div>

    <!-- Edit Grade Modal -->
    <div class="modal fade" id="editGradeModal" tabindex="-1" role="dialog" aria-labelledby="editGradeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin/edit-grade.php" method="POST">
                        <input type="hidden" id="edit_grades_id" name="grades_id">
                        <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                        <div class="form-group">
                            <label for="edit_grade">Grade</label>
                            <input type="text" id="edit_grade" name="grade" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter Students Table by student ID or name
        document.getElementById('student-search').addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#students-table-body tr');
            rows.forEach(row => {
                const studentIdCell = row.querySelector('td:nth-child(1)');
                const studentNameCell = row.querySelector('td:nth-child(2)');
                const studentId = studentIdCell ? studentIdCell.innerText.toLowerCase() : '';
                const studentName = studentNameCell ? studentNameCell.innerText.toLowerCase() : '';

                if (studentId.includes(searchValue) || studentName.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Populate the edit modal with grade data
        $('#editGradeModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var gradesId = button.data('grades-id');
            var grade = button.data('grade');

            var modal = $(this);
            modal.find('#edit_grades_id').val(gradesId);
            modal.find('#edit_grade').val(grade);
        });
    </script>
</body>

</html>
