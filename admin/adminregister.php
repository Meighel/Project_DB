<?php
include '../includes/webconnect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admins (username, email, password) VALUES (?, ?, ?)";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                header("Location: ../login-admin.html");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $con->error;
        }

        $con->close();
    }
}
?>
