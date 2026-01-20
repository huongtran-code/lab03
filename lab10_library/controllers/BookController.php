<?php
// SỬA: Gọi Model bằng APP_ROOT
require_once APP_ROOT . '/models/BookRepository.php';

class BookController {
    private $bookRepo;

    public function __construct() {
        $this->bookRepo = new BookRepository();
    }

    public function index() {
        $keyword = $_GET['keyword'] ?? '';
        $sort = $_GET['sort'] ?? 'id';
        $dir = $_GET['dir'] ?? 'desc';
        
        $books = $this->bookRepo->getAll($keyword, $sort, $dir);
        // SỬA: Gọi View bằng APP_ROOT
        require APP_ROOT . '/views/books/index.php';
    }

    public function create() {
        require APP_ROOT . '/views/books/create.php';
    }

    public function store() {
        $title = trim($_POST['title']);
        $author = trim($_POST['author']);
        $price = $_POST['price'];
        $qty = $_POST['qty'];

        if (empty($title) || empty($author) || $qty < 0) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin hợp lệ.";
            header("Location: index.php?controller=book&action=create");
            exit;
        }

        $this->bookRepo->create([
            'title' => $title, 'author' => $author, 'price' => $price, 'qty' => $qty
        ]);
        
        $_SESSION['success'] = "Thêm sách thành công!";
        header("Location: index.php?controller=book&action=index");
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $book = $this->bookRepo->find($id);
        if (!$book) {
            die("Sách không tồn tại");
        }
        require APP_ROOT . '/views/books/edit.php';
    }

    public function update() {
        $id = $_POST['id'];
        $this->bookRepo->update([
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'price' => $_POST['price'],
            'qty' => $_POST['qty'],
            'id' => $id
        ]);
        
        $_SESSION['success'] = "Cập nhật thành công!";
        header("Location: index.php?controller=book&action=index");
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $this->bookRepo->delete($id);
            $_SESSION['success'] = "Đã xóa sách!";
        }
        header("Location: index.php?controller=book&action=index");
    }
}
?>