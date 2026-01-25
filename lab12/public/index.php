<?php
// 1. Require các file Core
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Controller.php';

// 2. Autoload đơn giản (Tự động load Model và Controller)
spl_autoload_register(function ($className) {
    $paths = [
        __DIR__ . '/../app/Controllers/',
        __DIR__ . '/../app/Models/'
    ];

    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// 3. Xử lý Routing (Router đơn giản)
// Mặc định chạy CategoryController và hàm index
$c = isset($_GET['c']) ? ucfirst($_GET['c']) : 'Category';
$a = isset($_GET['a']) ? $_GET['a'] : 'index';

$controllerName = $c . 'Controller';

// 4. Khởi tạo Controller và gọi Action
if (class_exists($controllerName)) {
    $controller = new $controllerName();
    
    if (method_exists($controller, $a)) {
        $controller->$a();
    } else {
        echo "Lỗi 404: Không tìm thấy Action '$a'";
    }
} else {
    echo "Lỗi 404: Không tìm thấy Controller '$controllerName'";
}