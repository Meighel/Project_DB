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
                            <a href="register-subjects.php" class="btn btn-secondary btn-sm">Register Subjects</a>
                        </div>
                    </div>

                    <!-- Search and Filters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form class="form-inline">
                                <input type="text" id="search" class="form-control form-control-sm col-sm-4" placeholder="Search by name, subject, or grade">
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
                                    include 'admin/fetch-students.php'; // Include dynamic student rows ?>
                                </tbody>
                            </table>
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
                                    <?php include 'admin/fetch-subjects.php'; // Include dynamic subject rows ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

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
        // Search and filter functionality
        document.getElementById('filter-btn').addEventListener('click', function () {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll('#studentsTable tbody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = [...cells].some(cell => cell.innerText.toLowerCase().includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });

        // Delete confirmation
        function deleteStudent(studentId) {
            if (confirm("Are you sure you want to delete this student?")) {
                window.location.href = `delete-student.php?student_id=${studentId}`;
            }
        }
    </script>

</body>

</html>
