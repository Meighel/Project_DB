<?php
include __DIR__ . '/../includes/webconnect.php'; // Include your database connection

// Handle Add Subject
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_subject'])) {
    $subject_name = $_POST['subject_name'];
    $subject_description = $_POST['subject_description'];

    if (!empty($subject_name) && !empty($subject_description)) {
        $query = "INSERT INTO subjects (name, description) VALUES (?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $subject_name, $subject_description);

        if ($stmt->execute()) {
            header("Location: ../manage-subjects.php?success=add");
        } else {
            header("Location: ../manage-subjects.php?error=add");
        }
        $stmt->close();
        exit;
    }
}

// Handle Edit Subject
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_subject'])) {
    $subject_id = $_POST['subject_id'];
    $subject_name = $_POST['subject_name'];
    $subject_description = $_POST['subject_description'];

    if (!empty($subject_id) && !empty($subject_name) && !empty($subject_description)) {
        $query = "UPDATE subjects SET name = ?, description = ? WHERE subject_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ssi", $subject_name, $subject_description, $subject_id);

        if ($stmt->execute()) {
            header("Location: ../manage-subjects.php?success=edit");
        } else {
            header("Location: ../manage-subjects.php?error=edit");
        }
        $stmt->close();
        exit;
    }
}

// Handle Delete Subject
if (isset($_GET['delete_subject'])) {
    $subject_id = $_GET['delete_subject'];

    if (!empty($subject_id)) {
        $query = "DELETE FROM subjects WHERE subject_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $subject_id);

        if ($stmt->execute()) {
            header("Location: ../manage-subjects.php?success=delete");
        } else {
            header("Location: ../manage-subjects.php?error=delete");
        }
        $stmt->close();
        exit;
    }
}

// Fetch All Subjects
$query = "SELECT subject_id, name, description FROM subjects";
$subjectsResult = mysqli_query($con, $query);

// Output Subjects for the Table
while ($row = mysqli_fetch_assoc($subjectsResult)) {
    echo "
    <tr>
        <td>{$row['subject_id']}</td>
        <td><a href='students-per-subject.php?subject_id={$row['subject_id']}'>{$row['name']}</a></td>
        <td>{$row['description']}</td>
        <td>
            <button class='btn btn-sm btn-warning' data-toggle='modal' data-target='#editSubjectModal'
                data-id='{$row['subject_id']}'
                data-name='{$row['name']}'
                data-description='{$row['description']}'>Edit</button>
            <a href='admin/subject-process.php?delete_subject={$row['subject_id']}' class='btn btn-sm btn-danger'
                onclick='return confirm(\"Are you sure you want to delete this subject?\")'>Delete</a>
        </td>
    </tr>";
}

mysqli_close($con);
?>
