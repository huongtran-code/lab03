<?php
class Product {
    private $conn;
    private $table_name = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Tìm kiếm (Search)
    public function search($keyword) {
        // Tìm theo tên HOẶC mã
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE name LIKE :keyword OR code LIKE :keyword 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu và gán tham số
        $keyword = "%" . strip_tags($keyword) . "%";
        $stmt->bindParam(":keyword", $keyword);
        
        $stmt->execute();
        return $stmt;
    }

    // 2. Xóa (Delete)
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $id = strip_tags($id);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 3. Thêm mới
    public function create($code, $name, $price) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (code, name, price) VALUES (:code, :name, :price)";
        
        $stmt = $this->conn->prepare($query);
        
        // Clean data
        $code = strip_tags($code);
        $name = strip_tags($name);
        $price = strip_tags($price);

        $stmt->bindParam(":code", $code);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":price", $price);

        return $stmt->execute();
    }

    // 4. Lấy thông tin 1 sản phẩm (để hiển thị lên form sửa)
    public function getSingle($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 5. Cập nhật
    public function update($id, $code, $name, $price) {
        $query = "UPDATE " . $this->table_name . " 
                  SET code = :code, name = :name, price = :price 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        $code = strip_tags($code);
        $name = strip_tags($name);
        $price = strip_tags($price);
        $id = strip_tags($id);

        $stmt->bindParam(":code", $code);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
?>