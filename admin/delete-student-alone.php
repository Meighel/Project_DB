<?php
include __DIR__ . '/../includes/webconnect.php'; // Include the database connection

// Check if student_id is provided in the URL
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Prepare the query to delete the student record
    $query = "DELETE FROM students WHERE student_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $student_id); // Bind student_id as a string (VARCHAR)

    // Execute the delete query
    if ($stmt->execute()) {
        // Redirect to manage-records.php with success message
        header("Location: ../manage-records.php?success=delete");
    } else {
        // Redirect to manage-records.php with error message
        header("Location: ../manage-records.php?error=delete");
    }

    $stmt->close();
} else {
    // If student_id is not provided, show an error message
    echo "Missing required student_id.";
}

mysqli_close($con);
?>
