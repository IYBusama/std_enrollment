<?php

require_once 'classes/Teacher.php';

$teacher = new Teacher();
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email      = $_POST['email'];

    if (isset($_POST['add'])) {
        $teacher->create($first_name, $last_name, $email);
    } elseif (isset($_POST['update'])) {
        $teacher->update($id, $first_name, $last_name, $email);
    }
    header('Location: teachers.php');
    exit;
}

if ($action === 'delete' && $id) {
    $teacher->delete($id);
    header('Location: teachers.php');
    exit;
}

$edit_data = ($action === 'edit' && $id) ? $teacher->getById($id) : null;
$teachers  = $teacher->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Manage Teachers</h2>
    <form method="POST">
        <div class="mb-3"><label>First Name</label><input type="text" name="first_name" class="form-control" value="<?= $edit_data['first_name'] ?? '' ?>" required></div>
        <div class="mb-3"><label>Last Name</label><input type="text" name="last_name" class="form-control" value="<?= $edit_data['last_name'] ?? '' ?>" required></div>
        <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="<?= $edit_data['email'] ?? '' ?>" required></div>
        <?php if ($action === 'edit'): ?>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        <?php else: ?>
            <button type="submit" name="add" class="btn btn-primary">Add</button>
        <?php endif; ?>
    </form>

    <table class="table mt-4">
        <thead><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($teachers as $row): ?>
            <tr>
                <td><?= $row['teacher_id'] ?></td>
                <td><?= htmlspecialchars($row['first_name']) ?></td>
                <td><?= htmlspecialchars($row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>
                    <a href="teachers.php?action=edit&id=<?= $row['teacher_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="teachers.php?action=delete&id=<?= $row['teacher_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.html" class="btn btn-secondary">Back to Menu</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>