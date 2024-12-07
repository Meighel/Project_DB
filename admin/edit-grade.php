<?php
include __DIR__ . '/../includes/webconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grades_id = $_POST['grades_id'];
    $grade = $_POST['grade'];

    if (!empty($grades_id) && !empty($grade)) {
        $query = "UPDATE grades SET grade = ? WHERE grades_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("si", $grade, $grades_id);

        if ($stmt->execute()) {
            header("Location: ../students-per-subject.php?subject_id=" . $_POST['subject_id'] . "&success=edit");
            exit();
        } else {
            echo "Error updating grade: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}

mysqli_close($con);
?>