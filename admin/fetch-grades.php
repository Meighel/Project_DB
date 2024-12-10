<?php
include __DIR__ . '/../includes/webconnect.php'; // Include database connection

// Fetch all grades along with student and subject details
$query = "
    SELECT 
        g.grades_id,
        CONCAT(s.student_firstname, ' ', s.student_lastname) AS student_name,
        sub.name AS subject_name,
        g.grade
    FROM grades g
    INNER JOIN students s ON g.student_id = s.student_id
    INNER JOIN subjects sub ON g.subject_id = sub.subject_id
    ORDER BY g.grades_id ASC";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error fetching grades: " . mysqli_error($con));
}

// Output rows for the grades table
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>
            <td>' . htmlspecialchars($row['grades_id']) . '</td>
            <td>' . htmlspecialchars($row['student_name']) . '</td>
            <td>' . htmlspecialchars($row['subject_name']) . '</td>
            <td>' . htmlspecialchars($row['grade']) . '</td>
            <td>
                <button 
                    class="btn btn-sm btn-warning edit-btn" 
                    data-toggle="modal" 
                    data-target="#editGradeModal"
                    data-grades-id="' . $row['grades_id'] . '"
                    data-grade="' . htmlspecialchars($row['grade']) . '"
                    data-student-name="' . htmlspecialchars($row['student_name']) . '"
                    data-subject-name="' . htmlspecialchars($row['subject_name']) . '">
                    Edit
                </button>
                <a href="admin/delete-grade.php?grades_id=' . $row['grades_id'] . '" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm(\'Are you sure you want to delete this grade?\');">
                   Delete
                </a>
            </td>
          </tr>';
}

mysqli_close($con);
?>
