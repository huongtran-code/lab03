<?php
require_once APP_ROOT . '/config/Database.php';

class BookRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll($keyword = '', $sort = 'id', $dir = 'desc') {
        // Whitelist sorting (Giữ nguyên logic cũ)
        $allowedSorts = ['title', 'price', 'qty', 'created_at', 'id'];
        $sort = in_array($sort, $allowedSorts) ? $sort : 'id';
        $dir = strtoupper($dir) === 'ASC' ? 'ASC' : 'DESC';

        // --- ĐOẠN CẦN SỬA ---
        // 1. Đổi :kw thành :kw1 và :kw2 trong câu SQL
        $sql = "SELECT * FROM books WHERE title LIKE :kw1 OR author LIKE :kw2 ORDER BY $sort $dir";
        
        $stmt = $this->db->prepare($sql);
        
        // 2. Truyền giá trị cho cả kw1 và kw2
        $search = "%$keyword%";
        $stmt->execute([
            'kw1' => $search,
            'kw2' => $search
        ]);
        // --- HẾT ĐOẠN SỬA ---

        return $stmt->fetchAll();
    }

    // Các hàm dưới giữ nguyên
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO books (title, author, price, qty) VALUES (:title, :author, :price, :qty)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($data) {
        $sql = "UPDATE books SET title=:title, author=:author, price=:price, qty=:qty WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM books WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>