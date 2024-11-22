<?php
include 'webconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to check for the user
    $sql = "SELECT * FROM admins WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        // User exists
        session_start();
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['firstname'] = $row['first_name'];
        $_SESSION['lastname'] = $row['last_name'];

        echo "Login successful! Redirecting...";
        header("Location: ../index.html");
        exit();
    } else {
        // User not found
        echo "Invalid email or password. Please try again.";
    }

    // Close the connection
    mysqli_close($con);
}
?>
