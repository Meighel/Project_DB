<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Records</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content" class="container-fluid" style="padding: 2%;">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Manage Records</h1>

                <!-- Students Section -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Students</h6>
                        <a href="register-student.html" class="btn btn-primary btn-sm">Register Student</a>
                    </div>
                    <div class="card-body">
                            <form class="form-inline mb-3">
                                <input type="text" id="student-search" class="form-control form-control-sm col-sm-4" placeholder="Search students by ID, name, mobile, or email">
                            </form>
                        <table class="table table-bordered" id="studentsTable">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Subjects</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'admin/fetch-students.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Grades Table -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Grades</h6>
                        <a href="register-grade.php" class="btn btn-success btn-sm">Add Grade</a>
                    </div>
                    <div class="card-body">
                        <form class="form-inline mb-3">
                            <input type="text" id="grade-search" class="form-control form-control-sm col-sm-4" placeholder="Search grades by student name or subject name">
                        </form>
                        <table class="table table-bordered" id="gradesTable">
                            <thead>
                                <tr>
                                    <th>Grade ID</th>
                                    <th>Student Name</th>
                                    <th>Subject Name</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'admin/fetch-grades.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Edit Grade Modal -->
                <div class="modal fade" id="editGradeModal" tabindex="-1" role="dialog" aria-labelledby="editGradeModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="admin/edit-grade.php" method="POST">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="edit_grades_id" name="grades_id">
                                    <div class="form-group">
                                        <label for="edit_grade">Grade</label>
                                        <input type="text" class="form-control" id="edit_grade" name="grade" required>
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

                <!-- Subjects Section -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-warning">Subjects</h6>
                        <a href="manage-subjects.php" class="btn btn-success btn-sm">Add Subject</a>
                    </div>
                    <div class="card-body">
                        <form class="form-inline mb-3">
                            <input type="text" id="subject-search" class="form-control form-control-sm col-sm-4" placeholder="Search by subject name">
                        </form>
                        <table class="table table-bordered" id="subjectsTable">
                            <thead>
                                <tr>
                                    <th>Subject ID</th>
                                    <th>Subject Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'admin/subject-process.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Edit Subject Modal -->
                <div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="admin/subject-process.php" method="POST">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="edit_subject_id" name="subject_id">
                                    <div class="form-group">
                                        <label for="edit_subject_name">Subject Name:</label>
                                        <input type="text" id="edit_subject_name" name="subject_name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_subject_description">Description:</label>
                                        <textarea id="edit_subject_description" name="subject_description" class="form-control" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="edit_subject" class="btn btn-primary">Save Changes</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <a href="dashboard-admin.html" class="btn btn-primary">Back to Dashboard</a>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        // General filtering function
        function applyFilter(inputId, tableId) {
            const searchValue = document.getElementById(inputId).value.toLowerCase();
            const rows = document.querySelectorAll(`#${tableId} tbody tr`);

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => 
                    cell.innerText.toLowerCase().includes(searchValue)
                );
                row.style.display = match ? '' : 'none';
            });
        }

        // Handle grade deletion with redirection
        function deleteGrade(gradesId, subjectId) {
            if (confirm("Are you sure you want to delete this grade record?")) {
                // Redirect to delete-grade.php with necessary parameters
                window.location.href = `admin/delete-grade.php?grades_id=${gradesId}&subject_id=${subjectId}&redirect_to_manage_records=1`;
            }
        }

        // Populate Edit Subject Modal
        $('#editSubjectModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const subjectId = button.data('id');
            const name = button.data('name');
            const description = button.data('description');

            const modal = $(this);
            modal.find('#edit_subject_id').val(subjectId);
            modal.find('#edit_subject_name').val(name);
            modal.find('#edit_subject_description').val(description);
        });

        // Apply filtering for the Students table
        document.getElementById('student-search').addEventListener('input', function () {
            applyFilter('student-search', 'studentsTable');
        });

        // Apply filtering for the Grades table
        document.getElementById('grade-search').addEventListener('input', function () {
            applyFilter('grade-search', 'gradesTable');
        });

        // Apply filtering for the Subjects table
        document.getElementById('subject-search').addEventListener('input', function () {
            applyFilter('subject-search', 'subjectsTable');
        });

        // Populate the Edit Grade Modal
        $('#editGradeModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var gradesId = button.data('grades-id');
            var grade = button.data('grade');

            // Set values in the modal
            $('#edit_grades_id').val(gradesId);
            $('#edit_grade').val(grade);
        });
    </script>
</body>
</html>
