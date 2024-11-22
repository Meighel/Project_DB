<?php
include 'webconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['FirstName'];
    $lastname = $_POST['LastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
    } else {
        // SQL query
        $sql = "INSERT INTO admins (first_name, last_name, email, password)
                VALUES ('$firstname', '$lastname', '$email', '$password')";

        // Execute query
        if (mysqli_query($con, $sql)) {
            header("Location: ../login-admin.html");
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }

        // Close the connection
        mysqli_close($con);
    }
}
?>
