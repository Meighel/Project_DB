<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Subjects</title>

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
                        <h1 class="h3 mb-4 text-gray-800">Register Subjects</h1>
                    </div>

                    <!-- Registration Form -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="register-subjects-process.php" method="POST" id="registerSubjectsForm">
                                <!-- Select Student -->
                                <div class="form-group">
                                    <label for="student">Select Student:</label>
                                    <select class="form-control" id="student" name="student_id" required>
                                        <option value="">-- Select a Student --</option>
                                        <?php
                                        // Fetch student list from database
                                        include 'includes/webconnect.php';
                                        $query = "SELECT student_id, CONCAT(student_firstname, ' ', student_lastname) AS name FROM students";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['student_id']}'>{$row['name']} (ID: {$row['student_id']})</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Select Subjects -->
                                <div class="form-group">
                                    <label for="subjects">Select Subjects:</label>
                                    <select class="form-control" id="subjects" name="subject_ids[]" multiple required>
                                        <?php
                                        // Fetch subject list from database
                                        $query = "SELECT subject_id, name FROM subjects";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['subject_id']}'>{$row['name']}</option>";
                                        }
                                        mysqli_close($con);
                                        ?>
                                    </select>
                                    <small class="form-text text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple subjects.</small>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary btn-block">Register Subjects</button>
                            </form>
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

</body>

</html>
