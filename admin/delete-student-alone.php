<?php
include __DIR__ . '/../includes/webconnect.php';

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];


    $query = "DELETE FROM students WHERE student_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $student_id);

    if ($stmt->execute()) {
        header("Location: ../manage-records.php?success=delete");
    } else {
        header("Location: ../manage-records.php?error=delete");
    }

    $stmt->close();
} else {
    echo "Missing required student_id.";
}

mysqli_close($con);
?>
