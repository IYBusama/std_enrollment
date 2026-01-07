<?php
include 'db.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    if (isset($_POST['add'])) {
        $sql = "INSERT INTO teachers (first_name, last_name, email) VALUES ('$first_name', '$last_name', '$email')";
        $conn->query($sql);
    } elseif (isset($_POST['update'])) {
        $sql = "UPDATE teachers SET first_name='$first_name', last_name='$last_name', email='$email' WHERE teacher_id=$id";
        $conn->query($sql);
    }
}

if ($action == 'delete') {
    $sql = "DELETE FROM teachers WHERE teacher_id=$id";
    $conn->query($sql);
    header('Location: teachers.php');
}

$edit_data = null;
if ($action == 'edit') {
    $result = $conn->query("SELECT * FROM teachers WHERE teacher_id=$id");
    $edit_data = $result->fetch_assoc();
}

$result = $conn->query("SELECT * FROM teachers");
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
        <h2>Teachers</h2>
        <form method="POST">
            <div class="mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo $edit_data['first_name'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?php echo $edit_data['last_name'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $edit_data['email'] ?? ''; ?>" required>
            </div>
            <?php if ($action == 'edit') { ?>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            <?php } else { ?>
                <button type="submit" name="add" class="btn btn-primary">Add</button>
            <?php } ?>
        </form>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['teacher_id']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="teachers.php?action=edit&id=<?php echo $row['teacher_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="teachers.php?action=delete&id=<?php echo $row['teacher_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="index.html" class="btn btn-secondary">Back</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>