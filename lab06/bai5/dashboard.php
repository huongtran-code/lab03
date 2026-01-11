<?php
// Bật hiển thị lỗi
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- CẤU HÌNH ĐƯỜNG DẪN ---
// Sử dụng __DIR__ để lấy đường dẫn tuyệt đối, tránh lỗi không tìm thấy file
$path_members  = __DIR__ . '/../data/members.csv';
$path_books    = __DIR__ . '/../data/books.json';
$path_borrows  = __DIR__ . '/../data/borrows.json';
$path_invoices = __DIR__ . '/../data/invoices/*.json'; // Dấu * để lấy tất cả file

// --- BIẾN THỐNG KÊ ---
$stats = [
    'members_count' => 0,
    'books_titles'  => 0, // Số đầu sách
    'books_total'   => 0, // Tổng số lượng sách vật lý
    'borrowing'     => 0, // Đang mượn
    'returned'      => 0, // Đã trả
    'revenue'       => 0, // Doanh thu bán hàng (Bài 4)
    'invoice_count' => 0  // Số đơn hàng
];

// 1. THỐNG KÊ THÀNH VIÊN (CSV)
if (file_exists($path_members)) {
    // Đọc file vào mảng, mỗi dòng là 1 phần tử
    $lines = file($path_members, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines !== false) {
        $stats['members_count'] = count($lines);
    }
}

// 2. THỐNG KÊ SÁCH (JSON)
if (file_exists($path_books)) {
    $books_data = json_decode(file_get_contents($path_books), true);
    if (is_array($books_data)) {
        $stats['books_titles'] = count($books_data);
        // Tính tổng số lượng (qty) của tất cả đầu sách
        foreach ($books_data as $b) {
            $stats['books_total'] += (int)($b['qty'] ?? 0);
        }
    }
}

// 3. THỐNG KÊ MƯỢN TRẢ (JSON)
if (file_exists($path_borrows)) {
    $borrows_data = json_decode(file_get_contents($path_borrows), true);
    if (is_array($borrows_data)) {
        foreach ($borrows_data as $br) {
            if ($br['status'] === 'Đang mượn') {
                $stats['borrowing']++;
            } else {
                $stats['returned']++;
            }
        }
    }
}

// 4. THỐNG KÊ DOANH THU (Folder Invoices)
// Dùng hàm glob để lấy danh sách tất cả file .json trong thư mục invoices
$invoice_files = glob($path_invoices);
if ($invoice_files) {
    $stats['invoice_count'] = count($invoice_files);
    foreach ($invoice_files as $file) {
        $inv_content = file_get_contents($file);
        $inv = json_decode($inv_content, true);
        if (isset($inv['total_payment'])) {
            $stats['revenue'] += $inv['total_payment'];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê hệ thống</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        h2 { text-align: center; color: #333; margin-bottom: 30px; }
        
        /* Grid Layout cho các thẻ thống kê */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Style cho từng thẻ (Card) */
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            border-bottom: 5px solid #ddd;
            transition: transform 0.2s;
        }
        .card:hover { transform: translateY(-5px); }
        
        .card-title { font-size: 14px; color: #666; text-transform: uppercase; letter-spacing: 1px; }
        .card-number { font-size: 36px; font-weight: bold; margin: 10px 0; color: #333; }
        .card-desc { font-size: 13px; color: #888; }

        /* Màu sắc riêng cho từng loại thẻ */
        .card.blue { border-bottom-color: #3498db; }
        .card.blue .card-number { color: #3498db; }

        .card.green { border-bottom-color: #2ecc71; }
        .card.green .card-number { color: #2ecc71; }

        .card.orange { border-bottom-color: #e67e22; }
        .card.orange .card-number { color: #e67e22; }

        .card.red { border-bottom-color: #e74c3c; }
        .card.red .card-number { color: #e74c3c; }

        /* Menu điều hướng nhanh */
        .nav-links {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            background: white;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 8px;
        }
        .nav-links a {
            text-decoration: none;
            color: #333;
            margin: 0 10px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .nav-links a:hover { background-color: #333; color: white; }
    </style>
</head>
<body>

    <h2>TỔNG QUAN HỆ THỐNG QUẢN LÝ</h2>

    <div class="dashboard-grid">
        
        <div class="card blue">
            <div class="card-title">Thành viên</div>
            <div class="card-number"><?= number_format($stats['members_count']) ?></div>
            <div class="card-desc">Người đăng ký trong hệ thống</div>
        </div>

        <div class="card green">
            <div class="card-title">Kho Sách</div>
            <div class="card-number"><?= number_format($stats['books_total']) ?></div>
            <div class="card-desc"><?= $stats['books_titles'] ?> đầu sách khác nhau</div>
        </div>

        <div class="card orange">
            <div class="card-title">Đang mượn</div>
            <div class="card-number"><?= number_format($stats['borrowing']) ?></div>
            <div class="card-desc">Đã trả: <?= $stats['returned'] ?> lượt</div>
        </div>

        <div class="card red">
            <div class="card-title">Doanh thu bán hàng</div>
            <div class="card-number"><?= number_format($stats['revenue'], 0, ',', '.') ?> đ</div>
            <div class="card-desc"><?= $stats['invoice_count'] ?> đơn hàng đã tạo</div>
        </div>

    </div>

    <div class="nav-links">
        <strong>Đi tới bài tập:</strong>
        <a href="../bai1/register_member.php">Bài 1: Đăng ký</a>
        <a href="../bai2/add_book.php">Bài 2: Thêm sách</a>
        <a href="../bai3/borrow.php">Bài 3: Mượn sách</a>
        <a href="../bai4/create_invoice.php">Bài 4: Bán hàng</a>
    </div>

</body>
</html>