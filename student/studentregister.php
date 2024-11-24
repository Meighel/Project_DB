<?php
include '../includes/webconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['studentNumber'];
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $phone = $_POST['phone'];
    $corp_email = $_POST['corpEmail'];
    $password = $_POST['password'] ?? ''; // Optional password field

    // Use last name as the default password if none is provided
    $final_password = empty($password) ? $lastname : $password;

    // Hash the password
    $hashed_password = password_hash($final_password, PASSWORD_DEFAULT);

    // SQL query
    $sql = "INSERT INTO students (student_id, student_firstname, student_lastname, student_mobile, student_email, password)
            VALUES ('$student_id', '$firstname', '$lastname', '$phone', '$corp_email', '$hashed_password')";

    // Execute query
    if (mysqli_query($con, $sql)) {
        header("Location: ../dashboard-admin.html");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }

    // Close the connection
    mysqli_close($con);
}
?>
