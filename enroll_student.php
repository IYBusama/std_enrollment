<?php
require_once 'classes/Student.php';
require_once 'classes/Course.php';
require_once 'classes/Enrollment.php';

$studentObj = new Student();
$courseObj  = new Course();
$enrollObj  = new Enrollment();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id      = (int)$_POST['student_id'];
    $course_id       = (int)$_POST['course_id'];
    $enrollment_date = $_POST['enrollment_date'];

    if ($enrollObj->enroll($student_id, $course_id, $enrollment_date)) {
        $message = '<div class="alert alert-success">Student successfully enrolled!</div>';
    } else {
        $message = '<div class="alert alert-danger">Enrollment failed. Possible duplicate?</div>';
    }
}

$students     = $studentObj->getAll();
$courses      = $courseObj->getAll();
$enrollments  = $enrollObj->getAllEnrollments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Student in Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Enroll Student in Course</h2>

    <?= $message ?>

    <form method="POST" class="row g-3 mb-5">
        <div class="col-md-4">
            <label class="form-label">Select Student</label>
            <select name="student_id" class="form-select" required>
                <option value="">-- Choose Student --</option>
                <?php foreach ($students as $s): ?>
                    <option value="<?= $s['id'] ?>">
                        <?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Select Course</label>
            <select name="course_id" class="form-select" required>
                <option value="">-- Choose Course --</option>
                <?php foreach ($courses as $c): ?>
                    <option value="<?= $c['id'] ?>">
                        <?= htmlspecialchars($c['course_code'] . ' - ' . $c['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Enrollment Date</label>
            <input type="date" name="enrollment_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Enroll</button>
        </div>
    </form>

    <h4>Current Enrollments</h4>
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>Student</th>
                <th>Course</th>
                <th>Enrollment Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($enrollments)): ?>
                <tr>
                    <td colspan="3" class="text-center text-muted">No enrollments yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($enrollments as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['s_first'] . ' ' . $row['s_last']) ?></td>
                        <td><?= htmlspecialchars($row['c_title']) ?></td>
                        <td><?= $row['enrollment_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="index.html" class="btn btn-secondary mt-3">← Back to Menu</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>