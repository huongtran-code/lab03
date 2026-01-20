<?php
session_start();

// 1. ĐỊNH NGHĨA ĐƯỜNG DẪN GỐC
// dirname(__DIR__) sẽ trả về đường dẫn thư mục cha: C:\xampp\htdocs\lab10_library
define('APP_ROOT', dirname(__DIR__));

// 2. Lấy thông tin Controller và Action từ URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'book';
$action     = isset($_GET['action']) ? $_GET['action'] : 'index';

// 3. ĐIỀU HƯỚNG (ROUTING)
// Dùng APP_ROOT nối chuỗi để tìm đúng file
switch ($controller) {
    case 'book':
        require_once APP_ROOT . '/controllers/BookController.php';
        $obj = new BookController();
        break;
    
    case 'borrower':
        // Đảm bảo bạn đã tạo file BorrowerController.php trước khi chạy case này
        if (file_exists(APP_ROOT . '/controllers/BorrowerController.php')) {
            require_once APP_ROOT . '/controllers/BorrowerController.php';
            $obj = new BorrowerController();
        } else {
            die("Lỗi: Chưa tạo file controllers/BorrowerController.php");
        }
        break;

    case 'borrow':
        require_once APP_ROOT . '/controllers/BorrowController.php';
        $obj = new BorrowController();
        break;
        
    default:
        die("Lỗi: Controller '$controller' không tồn tại.");
}

// 4. GỌI ACTION
if (!method_exists($obj, $action)) {
    die("Lỗi: Action '$action' không tồn tại trong Controller này.");
}

$obj->$action();
?>