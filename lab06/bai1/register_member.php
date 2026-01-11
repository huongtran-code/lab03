<?php
$errors = [];
$data = ['name' => '', 'email' => '', 'phone' => '', 'dob' => '', 'gender' => 'Nam', 'address' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu và sanitize cơ bản
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['phone'] = trim($_POST['phone'] ?? '');
    $data['dob'] = $_POST['dob'] ?? '';
    $data['gender'] = $_POST['gender'] ?? 'Nam';
    $data['address'] = trim($_POST['address'] ?? '');

    // 1. Validate
    if (empty($data['name'])) $errors[] = "Họ tên là bắt buộc.";
    
    if (empty($data['email'])) {
        $errors[] = "Email là bắt buộc.";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không đúng định dạng.";
    }

    if (empty($data['phone'])) {
        $errors[] = "Số điện thoại là bắt buộc.";
    } elseif (!preg_match('/^[0-9]{9,11}$/', $data['phone'])) {
        $errors[] = "Số điện thoại phải là số và dài từ 9-11 ký tự.";
    }

    if (empty($data['dob'])) $errors[] = "Ngày sinh là bắt buộc.";

    // 2. Xử lý nếu không lỗi
    if (empty($errors)) {
        $file = '../data/members.csv';
        // Mở file mode 'a' (append)
        $fp = fopen($file, 'a');
        // Ghi dòng dữ liệu: Tự động thêm dấu phẩy và xuống dòng
        fputcsv($fp, $data);
        fclose($fp);

        // Chuyển sang trang kết quả (hoặc include trực tiếp)
        include 'member_result.php'; 
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Đăng ký thành viên</title></head>
<body>
    <h2>Đăng ký thẻ thư viện</h2>
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
        </ul>
    <?php endif; ?>

    <form method="POST">
        Họ tên: <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>"><br><br>
        Email: <input type="text" name="email" value="<?= htmlspecialchars($data['email']) ?>"><br><br>
        SĐT: <input type="text" name="phone" value="<?= htmlspecialchars($data['phone']) ?>"><br><br>
        Ngày sinh: <input type="date" name="dob" value="<?= htmlspecialchars($data['dob']) ?>"><br><br>
        
        Giới tính: 
        <input type="radio" name="gender" value="Nam" <?= $data['gender']=='Nam'?'checked':'' ?>> Nam
        <input type="radio" name="gender" value="Nữ" <?= $data['gender']=='Nữ'?'checked':'' ?>> Nữ
        <input type="radio" name="gender" value="Khác" <?= $data['gender']=='Khác'?'checked':'' ?>> Khác
        <br><br>
        
        Địa chỉ: <textarea name="address"><?= htmlspecialchars($data['address']) ?></textarea><br><br>
        
        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
    </form>
</body>
</html>
