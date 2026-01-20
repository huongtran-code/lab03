<?php
// SỬA CÁC ĐƯỜNG DẪN REQUIRE
require_once APP_ROOT . '/models/BorrowRepository.php';
require_once APP_ROOT . '/models/BookRepository.php';
// Lưu ý: Phải tạo file BorrowerRepository thì mới chạy được dòng dưới
require_once APP_ROOT . '/models/BorrowerRepository.php'; 

class BorrowController {
    private $borrowRepo;

    public function __construct() {
        $this->borrowRepo = new BorrowRepository();
    }

    public function index() {
        $borrows = $this->borrowRepo->getAll();
        require APP_ROOT . '/views/borrows/index.php';
    }

    public function show() {
        $id = $_GET['id'] ?? 0;
        $borrow = $this->borrowRepo->getById($id);
        require APP_ROOT . '/views/borrows/show.php';
    }

    public function create() {
        $bookRepo = new BookRepository();
        $borrowerRepo = new BorrowerRepository();
        
        $books = $bookRepo->getAll(); 
        $borrowers = $borrowerRepo->getAll(); 
        
        require APP_ROOT . '/views/borrows/create.php';
    }

    public function store() {
        $borrower_id = $_POST['borrower_id'];
        $borrow_date = $_POST['borrow_date'];
        $note = $_POST['note'];
        
        $book_ids = $_POST['book_ids'] ?? [];
        $quantities = $_POST['quantities'] ?? [];

        $items = [];
        for($i = 0; $i < count($book_ids); $i++) {
            if (!empty($book_ids[$i]) && !empty($quantities[$i])) {
                $items[] = [
                    'book_id' => $book_ids[$i],
                    'qty' => $quantities[$i]
                ];
            }
        }

        if (empty($items)) {
            $_SESSION['error'] = "Phải chọn ít nhất 1 cuốn sách.";
            header("Location: index.php?controller=borrow&action=create");
            exit;
        }

        try {
            $this->borrowRepo->createTransaction($borrower_id, $borrow_date, $note, $items);
            $_SESSION['success'] = "Tạo phiếu mượn thành công!";
            header("Location: index.php?controller=borrow&action=index");
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi: " . $e->getMessage();
            header("Location: index.php?controller=borrow&action=create");
        }
    }
}
?>