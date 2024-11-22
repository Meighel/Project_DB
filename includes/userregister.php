<?php
include 'webconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['FirstName'];
    $lastname = $_POST['LastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password){
        echo "Passwords do not match. Please try again";
    } else {
        $sql = "INSERT INTO users (firstname, lastname, email, password)
        VALUES ('$firstname', '$lastname', '$email', '$password')";

        if (mysqli_query($con, $sql)){
            header("Location: login.html");
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }
        mysqli_close($con);
    }

    // if ($password !== $confirm_password) {
    //     echo "Passwords do not match. Please try again.";
    // } else {
    //     // Check if email already exists
    //     $checkEmailSql = "SELECT * FROM users WHERE email = ?";
    //     $stmt = mysqli_prepare($con, $checkEmailSql);
    //     mysqli_stmt_bind_param($stmt, "s", $email);
    //     mysqli_stmt_execute($stmt);
    //     $result = mysqli_stmt_get_result($stmt);

    //     if (mysqli_num_rows($result) > 0) {
    //         echo "Email already registered. Please use a different email.";
    //     } else {
    //         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    //         $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";

    //         $stmt = mysqli_prepare($con, $sql);
    //         mysqli_stmt_bind_param($stmt, "ssss", $firstname, $lastname, $email, $hashed_password);

    //         if (mysqli_stmt_execute($stmt)) {
    //             header("Location: login.html");
    //             exit();
    //         } else {
    //             echo "Error: " . mysqli_error($con);
    //         }        
    //     }

    //     mysqli_stmt_close($stmt);
    //     mysqli_close($con);
    // }
}
?>
