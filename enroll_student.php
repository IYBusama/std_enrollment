<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $enrollment_date = $_POST['enrollment_date'];
    $sql = "INSERT INTO enrollments (student_id, course_id, enrollment_date) VALUES ($student_id, $course_id, '$enrollment_date')";
    $conn->query($sql);
}

$students = $conn->query("SELECT * FROM students");
$courses = $conn->query("SELECT * FROM courses");

$enrollments = $conn->query("SELECT e.id, e.student_id, e.course_id, e.enrollment_date, s.first_name AS s_first, s.last_name AS s_last, c.title AS c_title 
                             FROM enrollments e 
                             JOIN students s ON e.student_id = s.id 
                             JOIN courses c ON e.course_id = c.id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Student to Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Enroll Student to Course</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Student</label>
                <select name="student_id" class="form-select" required>
                    <?php while ($row = $students->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Course</label>
                <select name="course_id" class="form-select" required>
                    <?php while ($row = $courses->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Enrollment Date</label>
                <input type="date" name="enrollment_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Enroll</button>
        </form>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $enrollments->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['s_first'] . ' ' . $row['s_last']; ?></td>
                        <td><?php echo $row['c_title']; ?></td>
                        <td><?php echo $row['enrollment_date']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="index.html" class="btn btn-secondary">Back</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>