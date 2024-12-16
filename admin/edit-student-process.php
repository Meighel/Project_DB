<?php
include __DIR__ . '/../includes/webconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $student_firstname = $_POST['student_firstname'];
    $student_lastname = $_POST['student_lastname'];
    $student_email = $_POST['student_email'];
    $student_mobile = $_POST['student_mobile'];

    if (!empty($student_id) && !empty($student_firstname) && !empty($student_lastname) && !empty($student_email) && !empty($student_mobile)) {
        $query = "UPDATE students SET student_firstname = ?, student_lastname = ?, student_email = ?, student_mobile = ? WHERE student_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssss", $student_firstname, $student_lastname, $student_email, $student_mobile, $student_id);

        if ($stmt->execute()) {
            header("Location: ../manage-records.php?success=edit");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}

mysqli_close($con);
?>
