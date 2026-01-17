<?php
require_once __DIR__ . '/../models/StudentModel.php';

class StudentController {
    private $model;

    public function __construct() {
        $this->model = new StudentModel();
    }

    // 1. Hiển thị giao diện chính
    public function index() {
        require_once __DIR__ . '/../views/students/index.php';
    }

    // 2. API lấy danh sách sinh viên (Trả về JSON)
    public function get_list() {
        $students = $this->model->getAll();
        echo json_encode(['success' => true, 'data' => $students]);
    }

    // 3. API Thêm mới
    public function create() {
        $code = $_POST['code'] ?? '';
        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $dob = $_POST['dob'] ?? null;

        // Validate cơ bản
        if (empty($code) || empty($full_name) || empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đủ thông tin!']);
            return;
        }

        $result = $this->model->create(['code' => $code, 'full_name' => $full_name, 'email' => $email, 'dob' => $dob]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Thêm thành công!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi! Mã SV hoặc Email có thể đã tồn tại.']);
        }
    }

    // 4. API Lấy thông tin để sửa
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $student = $this->model->getById($id);
        if ($student) {
            echo json_encode(['success' => true, 'data' => $student]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy sinh viên!']);
        }
    }

    // 5. API Cập nhật
    public function update() {
        $id = $_POST['id'] ?? 0;
        $code = $_POST['code'] ?? '';
        $full_name = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $dob = $_POST['dob'] ?? null;

        $result = $this->model->update($id, ['code' => $code, 'full_name' => $full_name, 'email' => $email, 'dob' => $dob]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Cập nhật thành công!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật!']);
        }
    }

    // 6. API Xóa
    public function delete() {
        $id = $_POST['id'] ?? 0;
        if ($this->model->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa thành công!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa!']);
        }
    }
}