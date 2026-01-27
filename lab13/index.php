<?php
// Route đơn giản dựa trên tham số ?page=... & action=...
include_once 'controllers/ProductController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Định tuyến API
if ($page === 'api') {
    $controller = new ProductController();
    
    if ($action === 'search') {
        // GET api/products/search?q=...
        $controller->search();
    } elseif ($action === 'delete') {
        // POST api/products/delete (Chỉ chấp nhận POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->delete();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(["success" => false, "message" => "Method not allowed"]);
        }
        if ($action === 'search') {
        $controller->search();
        } 
        elseif ($action === 'delete') { // POST
        $controller->delete();
        }
        // --- Bổ sung ---
        elseif ($action === 'store') { // POST: Thêm
        $controller->store();
        }
        elseif ($action === 'show') { // GET: Lấy chi tiết
        $controller->show();
        }
        elseif ($action === 'update') { // POST: Sửa
        $controller->update();
        }
    }
} else {
    // Mặc định load View
    include_once 'views/index.php';
}
?>