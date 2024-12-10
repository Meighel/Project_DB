<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login-student.html"); // Redirect to login page if not logged in
    exit();
}

include __DIR__ . '../includes/webconnect.php';

// Fetch student details
$student_id = $_SESSION['student_id'];
$sql = "SELECT student_id, CONCAT(student_firstname, ' ', student_lastname) AS full_name, student_email, student_mobile
        FROM students WHERE student_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$student_result = $stmt->get_result()->fetch_assoc();

// Fetch subjects and grades
$grades_sql = "SELECT sub.name AS subject_name, g.grade
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Student Dashboard</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard-student.php">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="sidebar-brand-text mx-3" style="font-family: 'Arial', sans-serif;">Student Dashboard</div>
            </a>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $student_result['full_name']; ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="index.html">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Welcome, <?php echo htmlspecialchars($student_result['full_name']); ?>!</h1>

                    <!-- Personal Details -->
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
                </div>
            </div>
        </div>
    </div>


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
