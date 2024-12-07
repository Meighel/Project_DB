<?php
include __DIR__ . '../includes/webconnect.php'; // Include database connection

function getGradesAndSubjects($student_id) {
    global $con;

    $query = "SELECT sub.name AS subject_name, g.grade 
              FROM grades g 
              INNER JOIN subjects sub ON g.subject_id = sub.subject_id 
              WHERE g.student_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $grades = [];
    while ($row = $result->fetch_assoc()) {
        $grades[] = $row;
    }

    return $grades;
}
?>
