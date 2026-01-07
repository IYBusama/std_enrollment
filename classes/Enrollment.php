<?php
require_once 'classes/db.php';

class Enrollment {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function enroll($student_id, $course_id, $enrollment_date) {
        $student_id = (int)$student_id;
        $course_id  = (int)$course_id;
        $enrollment_date = $this->db->real_escape_string($enrollment_date);
        $sql = "INSERT INTO enrollments (student_id, course_id, enrollment_date) 
                VALUES ($student_id, $course_id, '$enrollment_date')";
        return $this->db->query($sql);
    }

    public function getAllEnrollments() {
        $sql = "SELECT e.id, e.enrollment_date,
                       s.first_name AS s_first, s.last_name AS s_last,
                       c.title AS c_title
                FROM enrollments e
                JOIN students s ON e.student_id = s.id
                JOIN courses c ON e.course_id = c.id
                ORDER BY s.last_name";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Reports
    public function getStudentCoursesReport() {
        $sql = "SELECT s.first_name AS s_first, s.last_name AS s_last, 
                       c.title AS c_title, e.enrollment_date
                FROM students s
                JOIN enrollments e ON s.id = e.student_id
                JOIN courses c ON e.course_id = c.id
                ORDER BY s.last_name, c.title";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTeacherCoursesReport() {
        $sql = "SELECT t.first_name AS t_first, t.last_name AS t_last, 
                       c.title AS c_title
                FROM teachers t
                JOIN teacher_courses tc ON t.teacher_id = tc.teacher_id
                JOIN courses c ON tc.course_id = c.id
                ORDER BY t.last_name, c.title";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>