<?php
class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Lấy tất cả (có hỗ trợ tìm kiếm)
    public function getAll($keyword = '') {
        $sql = "SELECT * FROM categories";
        if (!empty($keyword)) {
            $sql .= " WHERE name LIKE :keyword";
        }
        $sql .= " ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        if (!empty($keyword)) {
            $stmt->bindValue(':keyword', "%$keyword%");
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Tìm theo ID
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Thêm mới
    public function insert($name) {
        $stmt = $this->db->prepare("INSERT INTO categories (name, status) VALUES (:name, 1)");
        return $stmt->execute([':name' => $name]);
    }

    // Cập nhật
    public function update($id, $name, $status) {
        $stmt = $this->db->prepare("UPDATE categories SET name = :name, status = :status WHERE id = :id");
        return $stmt->execute([
            ':name'   => $name,
            ':status' => $status,
            ':id'     => $id
        ]);
    }

    // Xóa
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}