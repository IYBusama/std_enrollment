<?php
require_once 'classes/db.php';

class Course {
    private $db;
    private $table = 'courses';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $result = $this->db->query("SELECT * FROM $this->table");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $id = (int)$id;
        $result = $this->db->query("SELECT * FROM $this->table WHERE id = $id");
        return $result->fetch_assoc();
    }

    public function create($course_code, $title, $description = '') {
        $course_code = $this->db->real_escape_string($course_code);
        $title       = $this->db->real_escape_string($title);
        $description = $this->db->real_escape_string($description);
        $sql = "INSERT INTO $this->table (course_code, title, description) 
                VALUES ('$course_code', '$title', '$description')";
        return $this->db->query($sql);
    }

    public function update($id, $course_code, $title, $description = '') {
        $id = (int)$id;
        $course_code = $this->db->real_escape_string($course_code);
        $title       = $this->db->real_escape_string($title);
        $description = $this->db->real_escape_string($description);
        $sql = "UPDATE $this->table SET course_code='$course_code', title='$title', description='$description' WHERE id=$id";
        return $this->db->query($sql);
    }

    public function delete($id) {
        $id = (int)$id;
        return $this->db->query("DELETE FROM $this->table WHERE id=$id");
    }
}
?>