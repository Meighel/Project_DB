<?php
session_start();
include __DIR__ . '/../includes/webconnect.php';

// Check if student_id is passed in the URL
if (!isset($_GET['student_id'])) {
    die("No student specified.");
}

// Fetch student details along with the average grade
$student_id = $_GET['student_id'];
$sql = "SELECT student_id, student_firstname, student_lastname, student_email, student_mobile, average_grade
        FROM students WHERE student_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$student_result = $stmt->get_result()->fetch_assoc();

if (!$student_result) {
    die("Student not found.");
}

$stmt->close();

// Fetch subjects and grades for the student
$grades_sql = "SELECT g.grades_id, sub.name AS subject_name, g.grade
               FROM grades g
               INNER JOIN subjects sub ON g.subject_id = sub.subject_id
               WHERE g.student_id = ?";
$stmt = $con->prepare($grades_sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$grades_result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column" style="padding: 2%;"> 

        <!-- Main Content -->
        <div id="content">
            <div class="container-fluid">

                <h1 class="h3 mb-4 text-gray-800">Student Details: <?php echo htmlspecialchars($student_result['student_firstname'] . ' ' . $student_result['student_lastname']); ?></h1>

                <!-- Personal Details -->
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 font-weight-bold text-primary">Personal Details</h5>
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editStudentModal">Edit</button>
                    </div>
                    <div class="card-body">
                        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student_result['student_id']); ?></p>
                        <p><strong>First Name:</strong> <?php echo htmlspecialchars($student_result['student_firstname']); ?></p>
                        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($student_result['student_lastname']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($student_result['student_email']); ?></p>
                        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($student_result['student_mobile']); ?></p>
                    </div>
                </div>

                <!-- Grades and Subjects -->
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-info">Subjects and Grades</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $grades_result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['grade']); ?></td>
                                        <td>
                                            <button 
                                                class="btn btn-sm btn-warning edit-grade-btn" 
                                                data-toggle="modal" 
                                                data-target="#editGradeModal"
                                                data-grades-id="<?php echo $row['grades_id']; ?>" 
                                                data-grade="<?php echo htmlspecialchars($row['grade']); ?>">
                                                Edit
                                            </button>
                                            <a href="delete-grade.php?grades_id=<?php echo $row['grades_id']; ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Are you sure you want to delete this grade?');">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- Average Grade Display -->
                        <div class="mt-3">
                            <p><strong>Average Grade:</strong> <?php echo htmlspecialchars($student_result['average_grade']); ?></p>
                        </div>
                    </div>
                </div>

                <a href="../manage-students.php" class="btn btn-primary">Back to Student List</a>

            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="edit-student-process.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_result['student_id']); ?>">
                    <div class="form-group">
                        <label for="editFirstname">First Name</label>
                        <input type="text" class="form-control" name="student_firstname" id="editFirstname" value="<?php echo htmlspecialchars($student_result['student_firstname']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="editLastname">Last Name</label>
                        <input type="text" class="form-control" name="student_lastname" id="editLastname" value="<?php echo htmlspecialchars($student_result['student_lastname']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" name="student_email" id="editEmail" value="<?php echo htmlspecialchars($student_result['student_email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="editMobile">Mobile</label>
                        <input type="text" class="form-control" name="student_mobile" id="editMobile" value="<?php echo htmlspecialchars($student_result['student_mobile']); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Grade Modal -->
<div class="modal fade" id="editGradeModal" tabindex="-1" role="dialog" aria-labelledby="editGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="edit-grade.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="grades_id" id="editGradesId">
                    <input type="hidden" name="redirect_url" value="student-details.php?student_id=<?php echo $student_id; ?>">
                    <div class="form-group">
                        <label for="editGrade">Grade</label>
                        <input type="text" class="form-control" name="grade" id="editGrade" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Include JS -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    // Populate Edit Grade Modal
    $('#editGradeModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var gradesId = button.data('grades-id');
        var grade = button.data('grade');

        $('#editGradesId').val(gradesId);
        $('#editGrade').val(grade);
    });
</script>

</body>
</html>
