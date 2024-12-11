<?php
// Include the database connection
include __DIR__ . '/../includes/webconnect.php';

// Fetch top students for each subject
$top_students_sql = "
    SELECT 
        sub.name AS subject_name,
        s.student_id,
        CONCAT(s.student_firstname, ' ', s.student_lastname) AS student_name,
        g.grade AS highest_grade
    FROM grades g
    INNER JOIN subjects sub ON g.subject_id = sub.subject_id
    INNER JOIN students s ON g.student_id = s.student_id
    WHERE g.grade = (
        SELECT MAX(grade) 
        FROM grades 
        WHERE subject_id = sub.subject_id
    )
    ORDER BY sub.name";

$stmt = $con->prepare($top_students_sql);
$stmt->execute();
$top_students_result = $stmt->get_result();
$stmt->close();
?>

<!-- Top Students in Each Subject -->
<div class="card mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">Top Students in Each Subject</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Student Name</th>
                    <th>Highest Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $top_students_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['highest_grade']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
