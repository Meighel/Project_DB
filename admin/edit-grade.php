<?php
include __DIR__ . '/../includes/webconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grades_id = $_POST['grades_id'];
    $grade = $_POST['grade'];
    $subject_id = $_POST['subject_id']; // Add subject_id if it comes from the form

    // Check if the grade and grades_id are not empty
    if (!empty($grades_id) && !empty($grade)) {
        $query = "UPDATE grades SET grade = ? WHERE grades_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("si", $grade, $grades_id);

        if ($stmt->execute()) {
            if (isset($subject_id)) {
                header("Location: ../students-per-subject.php?subject_id=" . $subject_id . "&success=edit");
            } else {
                header("Location: ../manage-students.php?success=edit");
            }
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
