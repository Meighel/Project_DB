<?php
session_start();
include __DIR__ . '/../includes/webconnect.php';

// Check if student_id is passed in the URL
if (!isset($_GET['student_id'])) {
    die("No student specified.");
}

// Fetch student details
$student_id = $_GET['student_id'];
$sql = "SELECT student_id, CONCAT(student_firstname, ' ', student_lastname) AS full_name, student_email, student_mobile
        FROM students WHERE student_id = ?";
$stmt = $con->prepare($sql);

// Verify correct data type for student_id
$stmt->bind_param("s", $student_id); // Change "s" to "i" if student_id is integer
$stmt->execute();
$student_result = $stmt->get_result()->fetch_assoc();

// Check if student exists
if (!$student_result) {
    die("Student not found.");
}

$stmt->close();

// Fetch subjects and grades for the student
$grades_sql = "SELECT sub.name AS subject_name, g.grade
               FROM grades g
               INNER JOIN subjects sub ON g.subject_id = sub.subject_id
               WHERE g.student_id = ?";
$stmt = $con->prepare($grades_sql);
$stmt->bind_param("s", $student_id); // Change "s" to "i" if student_id is integer
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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column" style="padding: 2%;">

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Student Details: <?php echo htmlspecialchars($student_result['full_name']); ?></h1>

                <!-- Personal Details Card -->
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Personal Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student_result['student_id']); ?></p>
                        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($student_result['full_name']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($student_result['student_email']); ?></p>
                        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($student_result['student_mobile']); ?></p>
                    </div>
                </div>

                <!-- Grades and Subjects Card -->
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $grades_result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['grade']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Back to Student List -->
                <a href="../manage-students.php" class="btn btn-primary">Back to Student List</a>

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
