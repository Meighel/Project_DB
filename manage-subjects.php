<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subjects</title>

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
                        <h1 class="h3 mb-4 text-gray-800">Manage Subjects</h1>
                    </div>

                    <!-- Add New Subject -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="admin/subject-process.php" method="POST">
                                <div class="form-group">
                                    <label for="subject_name">Subject Name:</label>
                                    <input type="text" id="subject_name" name="subject_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="subject_description">Description:</label>
                                    <textarea id="subject_description" name="subject_description" class="form-control" rows="3" required></textarea>
                                </div>
                                <button type="submit" name="add_subject" class="btn btn-primary btn-block">Add Subject</button>
                            </form>
                        </div>
                    </div>

                    <!-- Search and Filters for Subjects -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form class="form-inline">
                                <input type="text" id="subject-search" class="form-control form-control-sm col-sm-4" placeholder="Search by subject name">
                                <button type="button" id="filter-btn" class="btn btn-primary btn-sm">Filter</button>
                            </form>
                        </div>
                    </div>

                    <!-- List of Subjects -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Subjects</h6>
                        </div>
                        <div class="card-body">
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
                    
                    <a href="dashboard-admin.html" class="btn btn-primary">Back to Dashboard</a>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Edit Subject Modal -->
    <div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin/subject-process.php" method="POST">
                        <input type="hidden" id="edit_subject_id" name="subject_id">
                        <div class="form-group">
                            <label for="edit_subject_name">Subject Name:</label>
                            <input type="text" id="edit_subject_name" name="subject_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_subject_description">Description:</label>
                            <textarea id="edit_subject_description" name="subject_description" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" name="edit_subject" class="btn btn-primary btn-block">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        // Client-side filtering for subjects table
        document.getElementById('subject-search').addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#subjectsTable tbody tr');
            rows.forEach(row => {
                const subjectNameCell = row.querySelector('td:nth-child(2)'); // Subject Name column
                const subjectName = subjectNameCell ? subjectNameCell.innerText.toLowerCase() : '';
                row.style.display = subjectName.includes(searchValue) ? '' : 'none';
            });
        });

        // Populate edit modal with subject data
        $('#editSubjectModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var subjectId = button.data('id');
            var subjectName = button.data('name');
            var subjectDescription = button.data('description');

            var modal = $(this);
            modal.find('#edit_subject_id').val(subjectId);
            modal.find('#edit_subject_name').val(subjectName);
            modal.find('#edit_subject_description').val(subjectDescription);
        });
    </script>
</body>

</html>
