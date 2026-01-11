<?php
// 1. Bật hiển thị lỗi để dễ debug (quan trọng khi bị trang trắng)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Khởi tạo biến và đường dẫn
$file_path = '../data/books.json'; // Đường dẫn tương đối: ra ngoài thư mục bai2 -> vào data
$errors = [];
$success = "";
$book = [
    'id' => '', 
    'title' => '', 
    'author' => '', 
    'year' => '', 
    'cat' => 'Giáo trình', 
    'qty' => ''
];

// 3. Xử lý khi người dùng bấm Submit (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ Form
    $book['id'] = trim($_POST['id'] ?? '');
    $book['title'] = trim($_POST['title'] ?? '');
    $book['author'] = trim($_POST['author'] ?? '');
    $book['year'] = (int)($_POST['year'] ?? 0);
    $book['cat'] = $_POST['cat'] ?? 'Giáo trình';
    $book['qty'] = (int)($_POST['qty'] ?? 0);

    // Đọc dữ liệu sách cũ để kiểm tra trùng mã
    $current_books = [];
    if (file_exists($file_path)) {
        $json_content = file_get_contents($file_path);
        $current_books = json_decode($json_content, true);
        if (!is_array($current_books)) $current_books = [];
    } else {
        // Nếu file chưa tồn tại, kiểm tra xem thư mục data có chưa
        if (!is_dir('../data')) {
            $errors[] = "Lỗi: Không tìm thấy thư mục 'data'. Hãy tạo thư mục 'data' ngang hàng với thư mục 'bai2'.";
        }
    }

    // --- VALIDATE DỮ LIỆU ---
    
    // Kiểm tra các trường bắt buộc
    if (empty($book['id']) || empty($book['title']) || empty($book['author'])) {
        $errors[] = "Vui lòng nhập đầy đủ Mã sách, Tên sách và Tác giả.";
    }

    // Kiểm tra trùng mã sách
    foreach ($current_books as $b) {
        if ($b['id'] === $book['id']) {
            $errors[] = "Mã sách '{$book['id']}' đã tồn tại. Vui lòng chọn mã khác.";
            break;
        }
    }
    
    // Kiểm tra năm xuất bản
    $current_year = date('Y');
    if ($book['year'] < 1900 || $book['year'] > $current_year) {
        $errors[] = "Năm xuất bản phải từ 1900 đến $current_year.";
    }

    // Kiểm tra số lượng
    if ($book['qty'] < 0) {
        $errors[] = "Số lượng sách phải lớn hơn hoặc bằng 0.";
    }

    // 4. Lưu file nếu không có lỗi
    if (empty($errors)) {
        $current_books[] = $book; // Thêm sách mới vào mảng
        
        // Ghi lại vào file JSON (JSON_PRETTY_PRINT để file đẹp dễ đọc, UNESCAPED_UNICODE để không lỗi tiếng Việt)
        $save_result = file_put_contents($file_path, json_encode($current_books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        if ($save_result === false) {
            $errors[] = "Không thể ghi file. Kiểm tra quyền ghi (permission) của thư mục data.";
        } else {
            $success = "Thêm sách thành công!";
            // Reset form sau khi thêm thành công
            $book = ['id'=>'', 'title'=>'', 'author'=>'', 'year'=>'', 'cat'=>'Giáo trình', 'qty'=>''];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sách mới</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 20px auto; }
        .error { color: red; margin-bottom: 10px; }
        .success { color: green; font-weight: bold; margin-bottom: 10px; }
        label { display: inline-block; width: 120px; font-weight: bold; margin-bottom: 10px; }
        input[type=text], input[type=number], select { width: 300px; padding: 5px; }
        button { padding: 8px 15px; cursor: pointer; }
    </style>
</head>
<body>

    <h2>Thêm sách vào kho thư viện</h2>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
        <p><a href="list_books.php">Xem danh sách sách</a></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label>Mã sách:</label>
            <input type="text" name="id" value="<?= htmlspecialchars($book['id']) ?>" placeholder="Ví dụ: ISBN-001">
        </div>
        
        <div>
            <label>Tên sách:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>">
        </div>

        <div>
            <label>Tác giả:</label>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>">
        </div>

        <div>
            <label>Năm xuất bản:</label>
            <input type="number" name="year" value="<?= htmlspecialchars($book['year']) ?>">
        </div>

        <div>
            <label>Thể loại:</label>
            <select name="cat">
                <option value="Giáo trình" <?= $book['cat']=='Giáo trình'?'selected':'' ?>>Giáo trình</option>
                <option value="Kỹ năng" <?= $book['cat']=='Kỹ năng'?'selected':'' ?>>Kỹ năng</option>
                <option value="Văn học" <?= $book['cat']=='Văn học'?'selected':'' ?>>Văn học</option>
                <option value="Khoa học" <?= $book['cat']=='Khoa học'?'selected':'' ?>>Khoa học</option>
                <option value="Khác" <?= $book['cat']=='Khác'?'selected':'' ?>>Khác</option>
            </select>
        </div>

        <div>
            <label>Số lượng:</label>
            <input type="number" name="qty" value="<?= htmlspecialchars($book['qty']) ?>">
        </div>

        <div style="margin-top: 20px;">
            <label></label>
            <button type="submit">Thêm sách</button>
            <button type="reset">Nhập lại</button>
        </div>
    </form>

</body>
</html>