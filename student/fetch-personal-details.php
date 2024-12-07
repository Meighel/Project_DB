<?php
include __DIR__ . '../includes/webconnect.php'; // Include database connection

function getPersonalDetails($student_id) {
    global $con;

    $query = "SELECT student_id, CONCAT(student_firstname, ' ', student_lastname) AS full_name, student_email, student_mobile 
              FROM students 
              WHERE student_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result;
}
?>
