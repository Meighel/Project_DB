<?php
include 'webconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['StudentNumber'];
    $firstname = $_POST['FirstName'];
    $lastname = $_POST['LastName'];
    $corp_email = $_POST['CorpEmail'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
    } else {
        // SQL query
        $sql = "INSERT INTO students (student_id, first_name, last_name, corp_email, password)
                VALUES ('$student_id', '$firstname', '$lastname', '$corp_email', '$password')";

        // Execute query
        if (mysqli_query($con, $sql)) {
            header("Location: ../login-student.html");
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }

        // Close the connection
        mysqli_close($con);
    }
}
?>
