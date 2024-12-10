<?php
include __DIR__ . '/includes/webconnect.php'; // Include database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id']; // Selected student ID
    $subject_id = $_POST['subject_id']; // Selected subject ID
    $grade = $_POST['grade']; // Input grade (decimal)

    // Ensure all fields are filled
    if (!empty($student_id) && !empty($subject_id) && !empty($grade)) {
        // Check if this student is already registered for this subject
        $checkQuery = "SELECT * FROM grades WHERE student_id = ? AND subject_id = ?";
        $stmt = $con->prepare($checkQuery);
        $stmt->bind_param("si", $student_id, $subject_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<p style='color: red;'>This student is already registered for the selected subject.</p>";
        } else {
            // Insert the grade into the grades table
            $insertQuery = "INSERT INTO grades (student_id, subject_id, grade) VALUES (?, ?, ?)";
            $stmt = $con->prepare($insertQuery);
            $stmt->bind_param("sid", $student_id, $subject_id, $grade); // 'd' for decimal grade

            if ($stmt->execute()) {
                header("Location: manage-records.php");
                exit();
            } else {
                echo "<p style='color: red;'>Error: Could not register grade.</p>";
            }
            $stmt->close();
        }
    } else {
        echo "<p style='color: red;'>All fields are required.</p>";
    }
}

// Fetch all students for the dropdown
$studentsQuery = "SELECT student_id, student_firstname, student_lastname FROM students";
$studentsResult = mysqli_query($con, $studentsQuery);

// Fetch all subjects for the dropdown
$subjectsQuery = "SELECT subject_id, name FROM subjects";
$subjectsResult = mysqli_query($con, $subjectsQuery);

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Grade</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Register Grade</h1>

        <form action="register-grade.php" method="POST">
            <!-- Student Dropdown -->
            <div class="form-group">
                <label for="student_id">Select Student:</label>
                <select id="student_id" name="student_id" class="form-control" required>
                    <option value="">-- Select Student --</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($studentsResult)) {
                        echo "<option value='{$row['student_id']}'>{$row['student_firstname']} {$row['student_lastname']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Subject Dropdown -->
            <div class="form-group">
                <label for="subject_id">Select Subject:</label>
                <select id="subject_id" name="subject_id" class="form-control" required>
                    <option value="">-- Select Subject --</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($subjectsResult)) {
                        echo "<option value='{$row['subject_id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Grade Input -->
            <div class="form-group">
                <label for="grade">Enter Grade (Decimal):</label>
                <input type="number" id="grade" name="grade" class="form-control" step="0.01" min="0" max="100" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Register Grade</button>
        </form>
    </div>

    <!-- Include JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
