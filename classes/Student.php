<?php
require_once 'classes/db.php';

class Student {
    private $db;
    private $table = 'students';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $result = $this->db->query("SELECT * FROM $this->table ORDER BY last_name");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $id = (int)$id;
        $result = $this->db->query("SELECT * FROM $this->table WHERE id = $id");
        return $result->fetch_assoc();
    }

    public function create($first_name, $last_name, $email) {
        $first_name = $this->db->real_escape_string($first_name);
        $last_name  = $this->db->real_escape_string($last_name);
        $email      = $this->db->real_escape_string($email);
        $sql = "INSERT INTO $this->table (first_name, last_name, email) VALUES ('$first_name', '$last_name', '$email')";
        return $this->db->query($sql);
    }

    public function update($id, $first_name, $last_name, $email) {
        $id = (int)$id;
        $first_name = $this->db->real_escape_string($first_name);
        $last_name  = $this->db->real_escape_string($last_name);
        $email      = $this->db->real_escape_string($email);
        $sql = "UPDATE $this->table SET first_name='$first_name', last_name='$last_name', email='$email' WHERE id=$id";
        return $this->db->query($sql);
    }

    public function delete($id) {
        $id = (int)$id;
        return $this->db->query("DELETE FROM $this->table WHERE id=$id");
    }
}
?>