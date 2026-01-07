<?php
require_once 'classes/Course.php';

$course = new Course();

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_code = $_POST['course_code'];
    $title       = $_POST['title'];
    $description = $_POST['description'] ?? '';

    if (isset($_POST['add'])) {
        $course->create($course_code, $title, $description);
    } elseif (isset($_POST['update'])) {
        $course->update($id, $course_code, $title, $description);
    }
    header('Location: courses.php');
    exit;
}

if ($action === 'delete' && $id) {
    $course->delete($id);
    header('Location: courses.php');
    exit;
}

$edit_data = ($action === 'edit' && $id) ? $course->getById($id) : null;
$courses   = $course->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Manage Courses</h2>

    <form method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Course Code</label>
                <input type="text" name="course_code" class="form-control" 
                       value="<?= htmlspecialchars($edit_data['course_code'] ?? '') ?>" 
                       placeholder="e.g. MATH101" required>
            </div>
            <div class="col-md-5">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" 
                       value="<?= htmlspecialchars($edit_data['title'] ?? '') ?>" 
                       placeholder="e.g. Introduction to Algebra" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Description (optional)</label>
                <input type="text" name="description" class="form-control" 
                       value="<?= htmlspecialchars($edit_data['description'] ?? '') ?>" 
                       placeholder="Short description">
            </div>
        </div>
        <div class="mt-3">
            <?php if ($action === 'edit'): ?>
                <button type="submit" name="update" class="btn btn-success">Update Course</button>
                <a href="courses.php" class="btn btn-secondary">Cancel</a>
            <?php else: ?>
                <button type="submit" name="add" class="btn btn-primary">Add Course</button>
            <?php endif; ?>
        </div>
    </form>

    <h4 class="mt-5">All Courses</h4>
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Course Code</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($courses)): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">No courses found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($courses as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['course_code']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description'] ?? '-') ?></td>
                    <td>
                        <a href="courses.php?action=edit&id=<?= $row['id'] ?>" 
                           class="btn btn-warning btn-sm">Edit</a>
                        <a href="courses.php?action=delete&id=<?= $row['id'] ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure you want to delete this course? This will also remove related assignments and enrollments.');">
                           Delete
                        </a>
                    </td>
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