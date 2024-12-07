<?php
include __DIR__ . '/../includes/webconnect.php'; // Include your database connection file

// Fetch students
$studentsQuery = "SELECT s.student_id, s.student_firstname, s.student_lastname, s.student_email, s.student_mobile,
                  GROUP_CONCAT(sub.name SEPARATOR ', ') AS subjects
                  FROM students s
                  LEFT JOIN grades g ON s.student_id = g.student_id
                  LEFT JOIN subjects sub ON g.subject_id = sub.subject_id
                  GROUP BY s.student_id";
$studentsResult = mysqli_query($con, $studentsQuery);
if (!$studentsResult) {
    die("Error fetching students: " . mysqli_error($con));
}

// Output students table rows
if ($studentsResult) {
    while ($row = mysqli_fetch_assoc($studentsResult)) {
        echo '<tr>
                <td>' . $row['student_id'] . '</td>
                <td><a href="/Project_DB/admin/student-details.php?student_id=' . $row['student_id'] . '">' . $row['student_firstname'] . ' ' . $row['student_lastname'] . '</a></td>
                <td>' . $row['student_email'] . '</td>
                <td>' . $row['student_mobile'] . '</td>
                <td>' . htmlspecialchars($row['subjects']) . '</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editStudentModal"
                            data-id="' . $row['student_id'] . '"
                            data-firstname="' . $row['student_firstname'] . '"
                            data-lastname="' . $row['student_lastname'] . '"
                            data-email="' . $row['student_email'] . '"
                            data-mobile="' . $row['student_mobile'] . '">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteStudent(\'' . $row['student_id'] . '\')">Delete</button>
                </td>
              </tr>';
    }
}

mysqli_close($con);
?>
