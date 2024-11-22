<?php
include '../includes/webconnect.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a secure SQL query
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        // Bind the parameter to prevent SQL injection
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Start a session and store user details
                session_start();
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];

                // Redirect to the admin dashboard
                header("Location: ../dashboard-admin.html");
                exit();
            } else {
                echo "Invalid username or password. Please try again.";
            }
        } else {
            echo "Invalid username or password. Please try again.";
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $con->error;
    }

    // Close the database connection
    $con->close();
}
?>
