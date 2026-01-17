<?php
// Tự động load controller
require_once __DIR__ . '/../app/controllers/StudentController.php';

// Lấy tham số từ URL, mặc định là Student và index
$controllerName = isset($_GET['c']) ? ucfirst($_GET['c']) . 'Controller' : 'StudentController';
$actionName = isset($_GET['a']) ? $_GET['a'] : 'index';

// Kiểm tra và gọi Controller
if (class_exists($controllerName)) {
    $controller = new $controllerName();
    if (method_exists($controller, $actionName)) {
        $controller->$actionName();
    } else {
        echo "Action '$actionName' không tồn tại!";
    }
} else {
    echo "Controller '$controllerName' không tồn tại!";
}