<?php
require_once 'classes/Enrollment.php';

$enrollObj = new Enrollment();

$studentReport = $enrollObj->getStudentCoursesReport();
$teacherReport = $enrollObj->getTeacherCoursesReport();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Student Enrollment System - Reports</h1>

    <div class="row">
        <div class="col-12">
            <h3>📚 Students and Their Enrolled Courses</h3>
            <?php if (empty($studentReport)): ?>
                <p class="text-muted">No student enrollments recorded yet.</p>
            <?php else: ?>
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Student Name</th>
                            <th>Course Title</th>
                            <th>Enrollment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($studentReport as $row): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['s_first'] . ' ' . $row['s_last']) ?></strong></td>
                                <td><?= htmlspecialchars($row['c_title']) ?></td>
                                <td><?= date('M d, Y', strtotime($row['enrollment_date'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3>👩‍🏫 Teachers and Their Assigned Courses</h3>
            <?php if (empty($teacherReport)): ?>
                <p class="text-muted">No teacher-course assignments yet.</p>
            <?php else: ?>
                <table class="table table-striped table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Teacher Name</th>
                            <th>Assigned Course</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teacherReport as $row): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['t_first'] . ' ' . $row['t_last']) ?></strong></td>
                                <td><?= htmlspecialchars($row['c_title']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <a href="index.html" class="btn btn-primary btn-lg mt-4">← Back to Main Menu</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>