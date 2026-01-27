<?php
include_once 'config/Database.php';
include_once 'models/Product.php';

class ProductController {
    private $db;
    private $product;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
    }

    // Helper: Trả về JSON thống nhất
    private function sendResponse($success, $message, $data = null) {
        header('Content-Type: application/json');
        echo json_encode([
            "success" => $success,
            "message" => $message,
            "data" => $data
        ]);
        exit;
    }

    // API: GET /search
    public function search() {
        $q = isset($_GET['q']) ? $_GET['q'] : "";
        $stmt = $this->product->search($q);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->sendResponse(true, "OK", $products);
    }

    // API: POST /delete
    public function delete() {
        // Lấy ID từ POST body
        $id = isset($_POST['id']) ? $_POST['id'] : null;

        if (!$id) {
            $this->sendResponse(false, "Thiếu ID sản phẩm", null);
        }

        if ($this->product->delete($id)) {
            $this->sendResponse(true, "Xóa thành công", null);
        } else {
            $this->sendResponse(false, "Lỗi khi xóa sản phẩm", null);
        }
    }

    public function store() {
        $code = $_POST['code'] ?? '';
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? 0;

        if (empty($code) || empty($name)) {
            $this->sendResponse(false, "Vui lòng nhập Mã và Tên sản phẩm");
        }

        try {
            if ($this->product->create($code, $name, $price)) {
                $this->sendResponse(true, "Thêm sản phẩm thành công");
            } else {
                $this->sendResponse(false, "Lỗi: Mã sản phẩm có thể đã tồn tại");
            }
        } catch (Exception $e) {
            $this->sendResponse(false, "Lỗi hệ thống: " . $e->getMessage());
        }
    }

    // API: GET /show (Lấy 1 sp)
    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) $this->sendResponse(false, "Thiếu ID");

        $data = $this->product->getSingle($id);
        if ($data) {
            $this->sendResponse(true, "OK", $data);
        } else {
            $this->sendResponse(false, "Không tìm thấy sản phẩm");
        }
    }

    // API: POST /update (Cập nhật)
    public function update() {
        $id = $_POST['id'] ?? null;
        $code = $_POST['code'] ?? '';
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? 0;

        if (!$id) $this->sendResponse(false, "Thiếu ID sản phẩm");

        if ($this->product->update($id, $code, $name, $price)) {
            $this->sendResponse(true, "Cập nhật thành công");
        } else {
            $this->sendResponse(false, "Lỗi khi cập nhật");
        }
    }
}
?>