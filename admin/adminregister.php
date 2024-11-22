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
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // SQL query with prepared statement
        $sql = "INSERT INTO admins (username, email, password) VALUES (?, ?, ?)";
        $stmt = $con->prepare($sql);

        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            // Execute the query
            if ($stmt->execute()) {
                header("Location: ../login-admin.html");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $con->error;
        }

        // Close the connection
        $con->close();
    }
}
?>
