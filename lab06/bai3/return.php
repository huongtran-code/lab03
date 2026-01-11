<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$books_file = '../data/books.json';
$borrows_file = '../data/borrows.json';
$message = "";

// Load dữ liệu
$borrows = file_exists($borrows_file) ? json_decode(file_get_contents($borrows_file), true) : [];
$books = file_exists($books_file) ? json_decode(file_get_contents($books_file), true) : [];

// --- XỬ LÝ TRẢ SÁCH ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrow_id = $_POST['borrow_id'];
    $return_date = $_POST['return_date']; // Ngày trả thực tế

    $borrow_index = -1;
    // Tìm phiếu mượn
    foreach ($borrows as $key => $br) {
        if ($br['id'] === $borrow_id && $br['status'] === 'Đang mượn') {
            $borrow_index = $key;
            break;
        }
    }

    if ($borrow_index !== -1) {
        // 1. Cập nhật trạng thái phiếu mượn
        $borrows[$borrow_index]['status'] = 'Đã trả';
        $borrows[$borrow_index]['actual_return_date'] = $return_date; // Lưu ngày trả thực tế
        
        // 2. Tăng số lượng sách trong kho
        $book_id_returned = $borrows[$borrow_index]['book_id'];
        foreach ($books as &$b) { // Tham chiếu &$b để sửa trực tiếp mảng
            if ($b['id'] == $book_id_returned) {
                $b['qty']++;
                break;
            }
        }

        // 3. Lưu lại cả 2 file
        file_put_contents($borrows_file, json_encode($borrows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        file_put_contents($books_file, json_encode($books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $message = "Đã trả sách thành công! Phiếu: " . $borrow_id;
    } else {
        $message = "Lỗi: Không tìm thấy phiếu mượn hoặc sách đã được trả trước đó.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trả sách</title>
    <style>
        body { font-family: sans-serif; max-width: 900px; margin: 20px auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .success { color: green; font-weight: bold; margin-bottom: 15px; }
        .btn-return { background: #28a745; color: white; border: none; padding: 5px 10px; cursor: pointer; }
        .nav { margin-bottom: 20px; }
        .status-active { color: orange; font-weight: bold; }
        .status-done { color: green; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="borrow.php">Mượn sách</a> | <a href="return.php">Trả sách</a>
    </div>

    <h2>Danh sách phiếu mượn / Trả sách</h2>

    <?php if($message) echo "<div class='success'>$message</div>"; ?>

    <table>
        <thead>
            <tr>
                <th>Mã phiếu</th>
                <th>Thành viên</th>
                <th>Tên sách</th>
                <th>Ngày mượn</th>
                <th>Hạn trả</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($borrows)): ?>
                <tr><td colspan="7">Chưa có dữ liệu mượn sách.</td></tr>
            <?php else: ?>
                <?php foreach(array_reverse($borrows) as $br): ?>
                    <tr>
                        <td><?= htmlspecialchars($br['id']) ?></td>
                        <td><?= htmlspecialchars($br['member_id']) ?></td>
                        <td><?= htmlspecialchars($br['book_title']) ?></td>
                        <td><?= htmlspecialchars($br['borrow_date']) ?></td>
                        <td><?= htmlspecialchars($br['return_date']) ?></td>
                        <td>
                            <span class="<?= $br['status'] == 'Đang mượn' ? 'status-active' : 'status-done' ?>">
                                <?= $br['status'] ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($br['status'] === 'Đang mượn'): ?>
                                <form method="POST" style="margin:0;">
                                    <input type="hidden" name="borrow_id" value="<?= $br['id'] ?>">
                                    <input type="hidden" name="return_date" value="<?= date('Y-m-d') ?>">
                                    <button type="submit" class="btn-return" onclick="return confirm('Xác nhận trả sách này?')">Trả sách</button>
                                </form>
                            <?php else: ?>
                                <small>Hoàn tất ngày <?= $br['actual_return_date'] ?? '' ?></small>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>