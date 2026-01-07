<?php
include 'db.php';

$student_report = $conn->query("SELECT s.first_name AS s_first, s.last_name AS s_last, c.title AS c_title, e.enrollment_date 
                                FROM students s 
                                JOIN enrollments e ON s.id = e.student_id 
                                JOIN courses c ON e.course_id = c.id 
                                ORDER BY s.last_name");

$teacher_report = $conn->query("SELECT t.first_name AS t_first, t.last_name AS t_last, c.title AS c_title 
                                FROM teachers t 
                                JOIN teacher_courses tc ON t.teacher_id = tc.teacher_id 
                                JOIN courses c ON tc.course_id = c.id 
                                ORDER BY t.last_name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Student Courses Report</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Enrollment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $student_report->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['s_first'] . ' ' . $row['s_last']; ?></td>
                        <td><?php echo $row['c_title']; ?></td>
                        <td><?php echo $row['enrollment_date']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Teacher Courses Report</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Teacher</th>
                    <th>Course</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $teacher_report->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['t_first'] . ' ' . $row['t_last']; ?></td>
                        <td><?php echo $row['c_title']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="index.html" class="btn btn-secondary">Back</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>