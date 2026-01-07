<?php
require_once 'classes/Teacher.php';
require_once 'classes/Course.php';
require_once 'classes/TeacherCourse.php';

$teacherObj = new Teacher();
$courseObj  = new Course();
$tcObj      = new TeacherCourse();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = (int)$_POST['teacher_id'];
    $course_id  = (int)$_POST['course_id'];

    if ($tcObj->assign($teacher_id, $course_id)) {
        $message = '<div class="alert alert-success">Teacher successfully assigned to course!</div>';
    } else {
        $message = '<div class="alert alert-warning">Assignment failed or already exists.</div>';
    }
}

$teachers    = $teacherObj->getAll();
$courses     = $courseObj->getAll();
$assignments = $tcObj->getAllAssignments();
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

    <?= $message ?>

    <form method="POST" class="row g-3 mb-5">
        <div class="col-md-5">
            <label class="form-label">Select Teacher</label>
            <select name="teacher_id" class="form-select" required>
                <option value="">-- Choose Teacher --</option>
                <?php foreach ($teachers as $t): ?>
                    <option value="<?= $t['teacher_id'] ?>">
                        <?= htmlspecialchars($t['first_name'] . ' ' . $t['last_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-5">
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
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Assign</button>
        </div>
    </form>

    <h4>Current Teacher-Course Assignments</h4>
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>Teacher</th>
                <th>Course</th>
                <th>Course Code</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($assignments)): ?>
                <tr>
                    <td colspan="3" class="text-center text-muted">No assignments yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($assignments as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['t_first'] . ' ' . $row['t_last']) ?></td>
                        <td><?= htmlspecialchars($row['c_title']) ?></td>
                        <td><?= htmlspecialchars($courseObj->getById($row['course_id'])['course_code'] ?? '') ?></td>
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