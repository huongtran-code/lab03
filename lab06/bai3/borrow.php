<?php
// Bật báo lỗi
error_reporting(E_ALL);
ini_set('display_errors', 1);

$books_file = '../data/books.json';
$members_file = '../data/members.csv';
$borrows_file = '../data/borrows.json';

$message = "";
$error = "";

// --- 1. ĐỌC DỮ LIỆU CÓ SẴN ĐỂ HIỂN THỊ LÊN FORM ---

// Đọc sách
$books = file_exists($books_file) ? json_decode(file_get_contents($books_file), true) : [];

// Đọc thành viên từ CSV
$members = [];
if (file_exists($members_file)) {
    if (($handle = fopen($members_file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Giả sử cột 1 là Email (làm mã định danh), cột 0 là Tên
            // Kiểm tra nếu dòng có đủ dữ liệu
            if(isset($data[1])) {
                $members[] = ['name' => $data[0], 'email' => $data[1]]; 
            }
        }
        fclose($handle);
    }
}

// --- 2. XỬ LÝ KHI BẤM NÚT MƯỢN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_email = $_POST['member_email'] ?? '';
    $book_id = $_POST['book_id'] ?? '';
    $borrow_date = $_POST['borrow_date'] ?? date('Y-m-d');
    $days = (int)$_POST['days'];

    // Validate cơ bản
    if (empty($member_email) || empty($book_id)) {
        $error = "Vui lòng chọn thành viên và sách.";
    } elseif ($days < 1 || $days > 30) {
        $error = "Số ngày mượn phải từ 1 đến 30 ngày.";
    } else {
        // Tìm sách để check số lượng
        $book_index = -1;
        foreach ($books as $key => $b) {
            if ($b['id'] == $book_id) {
                $book_index = $key;
                break;
            }
        }

        if ($book_index === -1) {
            $error = "Mã sách không tồn tại.";
        } elseif ($books[$book_index]['qty'] <= 0) {
            $error = "Sách này đã hết, không thể mượn.";
        } else {
            // --- LOGIC QUAN TRỌNG: CẬP NHẬT DỮ LIỆU ---

            // 1. Giảm số lượng sách
            $books[$book_index]['qty']--; 
            file_put_contents($books_file, json_encode($books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // 2. Tính ngày trả dự kiến
            $return_date = date('Y-m-d', strtotime($borrow_date . " + $days days"));

            // 3. Tạo phiếu mượn mới
            $new_borrow = [
                'id' => uniqid('Phieu_'), // Tạo ID ngẫu nhiên
                'member_id' => $member_email,
                'book_id' => $book_id,
                'book_title' => $books[$book_index]['title'], // Lưu tên sách để dễ hiển thị
                'borrow_date' => $borrow_date,
                'return_date' => $return_date,
                'status' => 'Đang mượn'
            ];

            // 4. Lưu vào borrows.json
            $borrows = file_exists($borrows_file) ? json_decode(file_get_contents($borrows_file), true) : [];
            $borrows[] = $new_borrow;
            file_put_contents($borrows_file, json_encode($borrows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            $message = "Đã tạo phiếu mượn thành công! Mã phiếu: " . $new_borrow['id'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lập phiếu mượn sách</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 20px auto; }
        .msg { padding: 10px; margin-bottom: 10px; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
        select, input { width: 100%; padding: 8px; margin: 5px 0 20px 0; }
        label { font-weight: bold; }
        button { padding: 10px 20px; cursor: pointer; background: #007bff; color: white; border: none; }
        .nav { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="borrow.php">Mượn sách</a> | <a href="return.php">Trả sách</a>
    </div>

    <h2>Lập phiếu mượn sách</h2>

    <?php if($message) echo "<div class='msg success'>$message</div>"; ?>
    <?php if($error) echo "<div class='msg error'>$error</div>"; ?>

    <form method="POST">
        <label>Chọn thành viên (Email):</label>
        <select name="member_email">
            <option value="">-- Chọn thành viên --</option>
            <?php foreach($members as $m): ?>
                <option value="<?= htmlspecialchars($m['email']) ?>">
                    <?= htmlspecialchars($m['name']) ?> (<?= htmlspecialchars($m['email']) ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Chọn sách (Chỉ hiện sách còn hàng):</label>
        <select name="book_id">
            <option value="">-- Chọn sách --</option>
            <?php foreach($books as $b): ?>
                <option value="<?= htmlspecialchars($b['id']) ?>" <?= ($b['qty'] <= 0 ? 'disabled' : '') ?>>
                    <?= htmlspecialchars($b['title']) ?> - SL: <?= $b['qty'] ?> <?= ($b['qty'] <= 0 ? '(Hết hàng)' : '') ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Ngày mượn:</label>
        <input type="date" name="borrow_date" value="<?= date('Y-m-d') ?>">

        <label>Số ngày mượn (1-30):</label>
        <input type="number" name="days" value="7" min="1" max="30">

        <button type="submit">Xác nhận mượn</button>
    </form>
</body>
</html>