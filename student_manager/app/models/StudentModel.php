<?php
require_once __DIR__ . '/../core/Database.php';

class StudentModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Lấy tất cả sinh viên
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM students ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy 1 sinh viên theo ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Thêm mới sinh viên
    public function create($data) {
        try {
            $sql = "INSERT INTO students (code, full_name, email, dob) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$data['code'], $data['full_name'], $data['email'], $data['dob']]);
            return true;
        } catch (PDOException $e) {
            return false; // Có thể do trùng mã SV hoặc Email
        }
    }

    // Cập nhật sinh viên
    public function update($id, $data) {
        try {
            $sql = "UPDATE students SET code=?, full_name=?, email=?, dob=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$data['code'], $data['full_name'], $data['email'], $data['dob'], $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa sinh viên
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE id = ?");
        return $stmt->execute([$id]);
    }
}