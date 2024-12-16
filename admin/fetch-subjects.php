<?php
include __DIR__ . '/../includes/webconnect.php'; 

$query = "SELECT subject_id, name, description FROM subjects";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error fetching subjects: " . mysqli_error($con));
}

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>
            <td>' . htmlspecialchars($row['subject_id']) . '</td>
            <td><a href="/Project_DB/students-per-subject.php?subject_id=' . urlencode($row['subject_id']) . '">' . htmlspecialchars($row['name']) . '</a></td>
            <td>
                <a href="/Project_DB/students-per-subject.php?subject_id=' . urlencode($row['subject_id']) . '" class="btn btn-sm btn-info">View Students</a>
            </td>
          </tr>';
}

mysqli_close($con);
?>
