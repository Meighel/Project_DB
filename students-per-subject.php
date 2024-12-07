<?php
include __DIR__ . 'includes/webconnect.php'; // Include database connection

// Get the subject ID from the URL
$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;

// Fetch subject details
$subjectQuery = "SELECT name, description FROM subjects WHERE subject_id = ?";
$stmt = $con->prepare($subjectQuery);
$stmt->bind_param("i", $subject_id);
$stmt->execute();
$subjectResult = $stmt->get_result()->fetch_assoc();

// Fetch students and their grades for this subject
$studentsQuery = "
    SELECT s.student_id, s.student_firstname, s.student_lastname, g.grade
    FROM students s
    INNER JOIN grades g ON s.student_id = g.student_id
    WHERE g.subject_id = ?";
$stmt = $con->prepare($studentsQuery);
$stmt->bind_param("i", $subject_id);
$stmt->execute();
$studentsResult = $stmt->get_result();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Enrolled in <?php echo htmlspecialchars($subjectResult['name']); ?></title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Students Enrolled in <?php echo htmlspecialchars($subjectResult['name']); ?></h1>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($subjectResult['description']); ?></p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $studentsResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['student_id']; ?></td>
                        <td><?php echo $row['student_firstname'] . ' ' . $row['student_lastname']; ?></td>
                        <td><?php echo $row['grade']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="manage-students.php" class="btn btn-primary">Back to Subjects</a>
    </div>

    <!-- Include JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
