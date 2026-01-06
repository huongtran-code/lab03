<?php
// Helper để render an toàn (XSS prevention)
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// 1. Nhận Input
$rawNames = $_GET['names'] ?? ''; // Lấy dữ liệu từ URL, mặc định là chuỗi rỗng

// 2. Xử lý logic
$validNames = [];
if ($rawNames !== '') {
    // Tách chuỗi bằng dấu phẩy
    $parts = explode(',', $rawNames);
    
    // Trim khoảng trắng
    $parts = array_map('trim', $parts);
    
    // Lọc bỏ phần tử rỗng
    $validNames = array_filter($parts, function($item) {
        return $item !== '';
    });
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 1: Xử lý chuỗi tên</title>
</head>
<body>
    <h3>Bài 1: Xử lý danh sách tên</h3>
    
    <form method="GET" action="">
        <label>Nhập danh sách (ngăn cách bởi dấu phẩy):</label><br>
        <input type="text" name="names" value="<?php echo h($rawNames); ?>" size="50" placeholder="An, Binh, Chi, ,Dung">
        <button type="submit">Xử lý</button>
    </form>

    <hr>

    <p><strong>Chuỗi gốc:</strong> "<?php echo h($rawNames); ?>"</p>

    <?php if (empty($validNames)): ?>
        <p style="color: red;">Chưa có dữ liệu hợp lệ.</p>
    <?php else: ?>
        <p><strong>Số lượng tên hợp lệ:</strong> <?php echo count($validNames); ?></p>
        <strong>Danh sách tên:</strong>
        <ol>
            <?php foreach ($validNames as $name): ?>
                <li><?php echo h($name); ?></li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>
</body>
</html>