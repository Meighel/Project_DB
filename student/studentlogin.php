<?php
include '../includes/webconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['studentNumber'];
    $password = $_POST['password'];

    $sql = "SELECT student_id, password FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['student_id'] = $row['student_id'];

            header("Location: ../dashboard-student.php");
            exit();
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "Student not found.";
    }

    mysqli_close($con);
}
?>
