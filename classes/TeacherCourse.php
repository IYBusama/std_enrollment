<?php
require_once 'classes/db.php';

class TeacherCourse {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function assign($teacher_id, $course_id) {
        $teacher_id = (int)$teacher_id;
        $course_id  = (int)$course_id;
        $sql = "INSERT IGNORE INTO teacher_courses (teacher_id, course_id) VALUES ($teacher_id, $course_id)";
        return $this->db->query($sql);
    }

    public function getAllAssignments() {
        $sql = "SELECT tc.teacher_id, tc.course_id, 
                       t.first_name AS t_first, t.last_name AS t_last, 
                       c.title AS c_title
                FROM teacher_courses tc
                JOIN teachers t ON tc.teacher_id = t.teacher_id
                JOIN courses c ON tc.course_id = c.id
                ORDER BY t.last_name";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}   
?>