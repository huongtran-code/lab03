<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Thư Viện - Lab 08</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .table-hover tbody tr:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>

<?php
// =======================================================
// 1. KẾT NỐI CƠ SỞ DỮ LIỆU (Cấu hình chuẩn cho XAMPP)
// =======================================================
$servername = "localhost";
$username = "root";     // Mặc định XAMPP là root
$password = "";         // Mặc định XAMPP không có pass
$dbname = "db_thuvien_nangcao"; // Tên DB chúng ta đã tạo

// Tạo kết nối bằng MySQLi Object-Oriented
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("<div class='alert alert-danger text-center'>Kết nối thất bại: " . $conn->connect_error . "</div>");
}

// Thiết lập font chữ tiếng Việt không bị lỗi
$conn->set_charset("utf8mb4");

// =======================================================
// 2. XỬ LÝ TRUY VẤN DỮ LIỆU
// =======================================================

// Query 1: Lấy danh sách sách (Tương ứng câu Q1 trong Lab)
$sql_books = "SELECT b.book_id, b.title, c.name AS category_name, p.name AS publisher_name, b.price, b.stock
              FROM books b
              JOIN categories c ON b.category_id = c.category_id
              JOIN publishers p ON b.publisher_id = p.publisher_id
              ORDER BY b.book_id DESC";
$result_books = $conn->query($sql_books);

// Query 2: Top 5 sách mượn nhiều nhất (Tương ứng câu Q5 trong Lab)
$sql_top = "SELECT b.title, SUM(li.qty) AS total_borrowed
            FROM loan_items li
            JOIN books b ON li.book_id = b.book_id
            GROUP BY li.book_id, b.title
            ORDER BY total_borrowed DESC
            LIMIT 5";
$result_top = $conn->query($sql_top);
?>

<div class="container py-5">
    <h1 class="text-center mb-4 text-primary fw-bold">HỆ THỐNG QUẢN LÝ THƯ VIỆN</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📚 Danh Sách Sách (Query Q1)</h5>
                    <span class="badge bg-light text-dark">Tổng: <?php echo $result_books->num_rows; ?></span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Sách</th>
                                    <th>Thể Loại</th>
                                    <th>NXB</th>
                                    <th>Giá (VNĐ)</th>
                                    <th>Kho</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_books->num_rows > 0): ?>
                                    <?php while($row = $result_books->fetch_assoc()): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $row["book_id"]; ?></td>
                                            <td class="fw-bold"><?php echo htmlspecialchars($row["title"]); ?></td>
                                            <td><span class="badge bg-info text-dark"><?php echo $row["category_name"]; ?></span></td>
                                            <td><?php echo $row["publisher_name"]; ?></td>
                                            <td class="text-end text-success fw-bold">
                                                <?php echo number_format($row["price"], 0, ',', '.'); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php 
                                                    if($row["stock"] > 0) 
                                                        echo "<span class='badge bg-success'>".$row["stock"]."</span>";
                                                    else 
                                                        echo "<span class='badge bg-danger'>Hết hàng</span>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="text-center">Chưa có dữ liệu sách</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">🔥 Top 5 Sách Hot (Query Q5)</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <?php if ($result_top->num_rows > 0): ?>
                        <?php $rank = 1; while($row = $result_top->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <span class="badge rounded-pill bg-secondary me-2">#<?php echo $rank++; ?></span>
                                    <?php echo htmlspecialchars($row["title"]); ?>
                                </span>
                                <span class="badge bg-danger rounded-pill"><?php echo $row["total_borrowed"]; ?> lượt</span>
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li class="list-group-item text-center">Chưa có dữ liệu mượn</li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Ghi chú Lab 08</h5>
                    <p class="card-text">
                        Trang web này sử dụng kết nối <code>mysqli</code> để hiển thị dữ liệu từ database <code>db_thuvien_nangcao</code>.
                        Dữ liệu được lấy realtime từ các bảng Books, Categories, Publishers và Loan_items.
                    </p>
                    <a href="http://localhost/phpmyadmin" target="_blank" class="btn btn-light btn-sm">Mở phpMyAdmin</a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-4 text-muted border-top mt-4">
    <p>Bài tập thực hành MySQL Nâng cao & PHP - IT3220</p>
</footer>

</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>