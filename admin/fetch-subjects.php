<?php
include __DIR__ . '/../includes/webconnect.php'; // Include your database connection

// Fetch subjects
$query = "SELECT subject_id, name, description FROM subjects";
$result = mysqli_query($con, $query);

// Check for query errors
if (!$result) {
    die("Error fetching subjects: " . mysqli_error($con));
}

// Output subjects table rows
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>
            <td>' . htmlspecialchars($row['subject_id']) . '</td>
            <td><a href="/Project_DB/students-per-subject.php?subject_id=' . urlencode($row['subject_id']) . '">' . htmlspecialchars($row['name']) . '</a></td>
            <td>
                <a href="/Project_DB/students-per-subject.php?subject_id=' . urlencode($row['subject_id']) . '" class="btn btn-sm btn-info">View Students</a>
            </td>
          </tr>';
}

// Close the database connection
mysqli_close($con);
?>
