<?php
include '../includes/webconnect.php';

if (isset($_GET['student_id'])) {
    $studentId = $_GET['student_id'];

    // Delete from grades table first to maintain referential integrity
    $deleteGrades = "DELETE FROM grades WHERE student_id = '$studentId'";
    mysqli_query($con, $deleteGrades);

    // Delete from students table
    $deleteStudent = "DELETE FROM students WHERE student_id = '$studentId'";
    if (mysqli_query($con, $deleteStudent)) {
        header("Location: manage-students.html");
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
