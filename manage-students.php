<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>

    <!-- Include external CSS -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid" style="padding: 2%;"> 

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-4 text-gray-800">Manage Students</h1>
                        <div>
                            <a href="register-student.html" class="btn btn-primary btn-sm">Add Student</a>
                            <a href="register-grade.php" class="btn btn-secondary btn-sm">Register Grade</a>
                        </div>
                    </div>

                    <!-- Search and Filters for Students -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form class="form-inline">
                                <input type="text" id="student-search" class="form-control form-control-sm col-sm-4" placeholder="Search by ID, name, mobile, or email">
                                <button type="button" id="filter-btn" class="btn btn-primary btn-sm">Filter</button>
                            </form>
                        </div>
                    </div>

                    <!-- List of Students -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Students</h6>
                        </div>
                        <div class="card-body">
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
                                    <?php
                                    include 'admin/fetch-students.php'; // Include dynamic student rows
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Search and Filters for Subjects -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form class="form-inline">
                                <input type="text" id="subject-search" class="form-control form-control-sm col-sm-4" placeholder="Search by subject name">
                                <button type="button" id="subject-filter-btn" class="btn btn-primary btn-sm">Filter</button>
                            </form>
                        </div>
                    </div>

                    <!-- List of Subjects -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Subjects and Enrolled Students</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="subjectsTable">
                                <thead>
                                    <tr>
                                        <th>Subject ID</th>
                                        <th>Subject Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    include 'admin/fetch-subjects.php'; // Include dynamic subject rows
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <a href="dashboard-admin.html" class="btn btn-primary">Back to Dashboard</a>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Include JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        // Client-side filtering for students table
        document.getElementById('student-search').addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#studentsTable tbody tr');
            rows.forEach(row => {
                const studentIdCell = row.querySelector('td:nth-child(1)');
                const studentNameCell = row.querySelector('td:nth-child(2)');
                const studentEmailCell = row.querySelector('td:nth-child(3)');
                const studentMobileCell = row.querySelector('td:nth-child(4)');

                const studentId = studentIdCell ? studentIdCell.innerText.toLowerCase() : '';
                const studentName = studentNameCell ? studentNameCell.innerText.toLowerCase() : '';
                const studentEmail = studentEmailCell ? studentEmailCell.innerText.toLowerCase() : '';
                const studentMobile = studentMobileCell ? studentMobileCell.innerText.toLowerCase() : '';

                if (studentId.includes(searchValue) || studentName.includes(searchValue) || studentEmail.includes(searchValue) || studentMobile.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Client-side filtering for subjects table
        document.getElementById('subject-search').addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#subjectsTable tbody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = [...cells].some(cell => cell.innerText.toLowerCase().includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });

        // Delete confirmation for students
        function deleteStudent(studentId) {
            if (confirm("Are you sure you want to delete this student?")) {
                window.location.href = `delete-student-alone.php?student_id=${studentId}`;
            }
        }
    </script>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin/edit-student-process.php" method="POST">
                        <input type="hidden" id="edit_student_id" name="student_id">
                        <div class="form-group">
                            <label for="edit_firstname">First Name</label>
                            <input type="text" id="edit_firstname" name="student_firstname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_lastname">Last Name</label>
                            <input type="text" id="edit_lastname" name="student_lastname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input type="email" id="edit_email" name="student_email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_mobile">Mobile</label>
                            <input type="text" id="edit_mobile" name="student_mobile" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Populate the edit modal with the selected student's data
        $('#editStudentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var studentId = button.data('id');
            var firstname = button.data('firstname');
            var lastname = button.data('lastname');
            var email = button.data('email');
            var mobile = button.data('mobile');

            // Set values in the modal
            var modal = $(this);
            modal.find('#edit_student_id').val(studentId);
            modal.find('#edit_firstname').val(firstname);
            modal.find('#edit_lastname').val(lastname);
            modal.find('#edit_email').val(email);
            modal.find('#edit_mobile').val(mobile);
        });
    </script>

</body>

</html>
