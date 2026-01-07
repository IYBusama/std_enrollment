<?php
$conn = new mysqli('localhost', 'root', '', 'enrollment');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>