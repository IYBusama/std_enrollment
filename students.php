<?php

require_once 'classes/Student.php';

$student = new Student();

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email      = $_POST['email'];

    if (isset($_POST['add'])) {
        $student->create($first_name, $last_name, $email);
    } elseif (isset($_POST['update'])) {
        $student->update($id, $first_name, $last_name, $email);
    }
    header('Location: students.php');
    exit;
}

if ($action === 'delete' && $id) {
    $student->delete($id);
    header('Location: students.php');
    exit;
}

$edit_data = ($action === 'edit' && $id) ? $student->getById($id) : null;
$students  = $student->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Manage Students</h2>

    <form method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" 
                       value="<?= htmlspecialchars($edit_data['first_name'] ?? '') ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" 
                       value="<?= htmlspecialchars($edit_data['last_name'] ?? '') ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" 
                       value="<?= htmlspecialchars($edit_data['email'] ?? '') ?>" required>
            </div>
        </div>
        <div class="mt-3">
            <?php if ($action === 'edit'): ?>
                <button type="submit" name="update" class="btn btn-success">Update Student</button>
                <a href="students.php" class="btn btn-secondary">Cancel</a>
            <?php else: ?>
                <button type="submit" name="add" class="btn btn-primary">Add Student</button>
            <?php endif; ?>
        </div>
    </form>

    <h4 class="mt-5">All Students</h4>
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($students)): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">No students found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($students as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['first_name']) ?></td>
                    <td><?= htmlspecialchars($row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <a href="students.php?action=edit&id=<?= $row['id'] ?>" 
                           class="btn btn-warning btn-sm">Edit</a>
                        <a href="students.php?action=delete&id=<?= $row['id'] ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
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