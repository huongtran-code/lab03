<?php
require_once APP_ROOT . '/models/BorrowerRepository.php';

class BorrowerController {
    private $repo;
    public function __construct() {
        $this->repo = new BorrowerRepository();
    }
    public function index() {
        $borrowers = $this->repo->getAll();
        require APP_ROOT . '/views/borrowers/index.php';
    }
    // 1. Hiển thị form thêm mới
    public function create() {
        require APP_ROOT . '/views/borrowers/create.php';
    }

    // 2. Xử lý lưu dữ liệu từ form
    public function store() {
        $full_name = trim($_POST['full_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        // Validate đơn giản
        if (empty($full_name) || empty($phone)) {
            $_SESSION['error'] = "Vui lòng nhập tên và số điện thoại!";
            header("Location: index.php?controller=borrower&action=create");
            exit;
        }

        // Gọi model để lưu
        $this->repo->create([
            'full_name' => $full_name,
            'phone' => $phone
        ]);

        $_SESSION['success'] = "Thêm người mượn thành công!";
        header("Location: index.php?controller=borrower&action=index");
    }
}
?>