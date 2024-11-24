<?php
include '../includes/webconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['studentNumber'];
    $password = $_POST['password'];

    // SQL query to fetch hashed password
    $sql = "SELECT password FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            echo "Login successful!";
            header("Location: ../dashboard-student.html");
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
