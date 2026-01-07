<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_id = $_POST['teacher_id'];
    $course_id = $_POST['course_id'];
    $sql = "INSERT INTO teacher_courses (teacher_id, course_id) VALUES ($teacher_id, $course_id)";
    $conn->query($sql);
}

$teachers = $conn->query("SELECT * FROM teachers");
$courses = $conn->query("SELECT * FROM courses");

$assignments = $conn->query("SELECT tc.teacher_id, tc.course_id, t.first_name AS t_first, t.last_name AS t_last, c.title AS c_title 
                             FROM teacher_courses tc 
                             JOIN teachers t ON tc.teacher_id = t.teacher_id 
                             JOIN courses c ON tc.course_id = c.id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Teacher to Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Assign Teacher to Course</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Teacher</label>
                <select name="teacher_id" class="form-select" required>
                    <?php while ($row = $teachers->fetch_assoc()) { ?>
                        <option value="<?php echo $row['teacher_id']; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></option>
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
            <button type="submit" class="btn btn-primary">Assign</button>
        </form>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Teacher</th>
                    <th>Course</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $assignments->fetch_assoc()) { ?>
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