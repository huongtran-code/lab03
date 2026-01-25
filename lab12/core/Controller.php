<?php
class Controller {
    // Hàm gọi View và truyền dữ liệu xuống View
    public function view($viewPath, $data = []) {
        extract($data); // Biến mảng $data thành các biến riêng lẻ (vd: $data['cat'] thành $cat)
        
        $fullPath = __DIR__ . '/../app/Views/' . $viewPath . '.php';
        if (file_exists($fullPath)) {
            require_once $fullPath;
        } else {
            echo "View '$viewPath' không tồn tại.";
        }
    }

    // Hàm chuyển hướng trang
    public function redirect($url) {
        header("Location: $url");
        exit;
    }
}