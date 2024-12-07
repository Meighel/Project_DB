<?php
include __DIR__ . '/../includes/webconnect.php'; // Include database connection

// Check if grades_id and subject_id are provided in the URL
if (isset($_GET['grades_id'], $_GET['subject_id'])) {
    $grades_id = $_GET['grades_id']; // The ID of the grade record to delete
    $subject_id = $_GET['subject_id']; // The subject ID for redirection

    // Prepare the query to delete the grade record by grades_id
    $query = "DELETE FROM grades WHERE grades_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $grades_id); // Bind grades_id as an integer

    // Execute the delete query
    if ($stmt->execute()) {
        // Redirect to students-per-subject.php with success message and subject_id
        header("Location: ../students-per-subject.php?subject_id=" . $subject_id . "&success=delete");
        exit();
    } else {
        // Output an error message if the delete fails
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    // If grades_id or subject_id is not provided, show an error
    echo "Missing required grades_id or subject_id.";
}

// Close the database connection
mysqli_close($con);
?>
