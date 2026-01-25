<?php
class CategoryController extends Controller {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    // --- Action: Hiển thị danh sách ---
    public function index() {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $categories = $this->categoryModel->getAll($keyword);

        $this->view('categories/index', [
            'categories' => $categories,
            'keyword'    => $keyword
        ]);
    }

    // --- Action: Hiển thị form thêm mới ---
    public function create() {
        $this->view('categories/create');
    }

    // --- Action: Lưu dữ liệu thêm mới ---
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $errors = [];

            // Validate
            if (empty($name)) {
                $errors[] = "Tên danh mục không được để trống.";
            } elseif (strlen($name) < 2) {
                $errors[] = "Tên danh mục phải có ít nhất 2 ký tự.";
            }

            if (empty($errors)) {
                $this->categoryModel->insert($name);
                $this->redirect('index.php?c=category&a=index');
            } else {
                // Nếu lỗi, load lại form và hiển thị lỗi
                $this->view('categories/create', [
                    'errors'   => $errors,
                    'old_name' => $name
                ]);
            }
        }
    }

    // --- Action: Hiển thị form sửa ---
    public function edit() {
        $id = $_GET['id'] ?? null;
        $category = $this->categoryModel->findById($id);

        if (!$category) {
            die("Không tìm thấy danh mục này!");
        }

        $this->view('categories/edit', ['category' => $category]);
    }

    // --- Action: Lưu dữ liệu cập nhật ---
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = trim($_POST['name'] ?? '');
            $status = $_POST['status'];
            $errors = [];

            if (empty($name)) {
                $errors[] = "Tên danh mục không được để trống.";
            } elseif (strlen($name) < 2) {
                $errors[] = "Tên danh mục phải có ít nhất 2 ký tự.";
            }

            if (empty($errors)) {
                $this->categoryModel->update($id, $name, $status);
                $this->redirect('index.php?c=category&a=index');
            } else {
                // Load lại form sửa kèm lỗi
                $currentCategory = $this->categoryModel->findById($id);
                $currentCategory['name'] = $name; // Giữ lại tên vừa nhập

                $this->view('categories/edit', [
                    'errors'   => $errors,
                    'category' => $currentCategory
                ]);
            }
        }
    }

    // --- Action: Xóa ---
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->categoryModel->delete($id);
        }
        $this->redirect('index.php?c=category&a=index');
    }
}