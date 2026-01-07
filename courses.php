<?php
include 'db.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_code = $_POST['course_code'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (isset($_POST['add'])) {
        $sql = "INSERT INTO courses (course_code, title, description) VALUES ('$course_code', '$title', '$description')";
        $conn->query($sql);
    } elseif (isset($_POST['update'])) {
        $sql = "UPDATE courses SET course_code='$course_code', title='$title', description='$description' WHERE id=$id";
        $conn->query($sql);
    }
}

if ($action == 'delete') {
    $sql = "DELETE FROM courses WHERE id=$id";
    $conn->query($sql);
    header('Location: courses.php');
}

$edit_data = null;
if ($action == 'edit') {
    $result = $conn->query("SELECT * FROM courses WHERE id=$id");
    $edit_data = $result->fetch_assoc();
}

$result = $conn->query("SELECT * FROM courses");
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
        <h2>Courses</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Course Code</label>
                <input type="text" name="course_code" class="form-control" value="<?php echo $edit_data['course_code'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $edit_data['title'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"><?php echo $edit_data['description'] ?? ''; ?></textarea>
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
                    <th>Code</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['course_code']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>
                            <a href="courses.php?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="courses.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
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