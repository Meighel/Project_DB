<?php
include __DIR__ . '/../includes/webconnect.php';

if (isset($_GET['grades_id'])) {
    $grades_id = $_GET['grades_id'];
    $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;

    $query = "DELETE FROM grades WHERE grades_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $grades_id);

    if ($stmt->execute()) {
        if ($subject_id) {
            header("Location: ../students-per-subject.php?subject_id=" . $subject_id . "&success=delete");
        } else {
            header("Location: ../manage-records.php?success=delete");
        }
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Missing required grades_id.";
}

mysqli_close($con);
?>

