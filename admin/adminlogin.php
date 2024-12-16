<?php
include '../includes/webconnect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];

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

    $con->close();
}
?>
