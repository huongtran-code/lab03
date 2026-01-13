<?php
// =================================================================================
// PHẦN 1: LOGIC & XỬ LÝ DỮ LIỆU (PHP)
// =================================================================================
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qltv_db";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

$message = "";
$msg_type = ""; // success, danger, warning

// --- XỬ LÝ CÁC ACTION TỪ FORM ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Chức năng Reset Dữ liệu (Bài tập 2)
    if (isset($_POST['action']) && $_POST['action'] == 'reset_data') {
        $conn->query("SET FOREIGN_KEY_CHECKS = 0");
        $conn->query("TRUNCATE TABLE borrows");
        $conn->query("TRUNCATE TABLE books");
        $conn->query("TRUNCATE TABLE readers");
        $conn->query("SET FOREIGN_KEY_CHECKS = 1");

        // Insert Books
        $conn->query("INSERT INTO books (title, author, price, published_year) VALUES 
        ('Clean Code', 'Robert C. Martin', 12.50, 2008),
        ('Design Patterns', 'GoF', 15.00, 1994),
        ('PHP & MySQL', 'Murach', 18.99, 2014),
        ('Lập trình C++', 'Phạm Văn Ất', 10.00, 2010),
        ('Dế Mèn Phiêu Lưu Ký', 'Tô Hoài', 5.50, 1941)");

        // Insert Readers
        $conn->query("INSERT INTO readers (full_name, phone) VALUES 
        ('Nguyễn Văn A', '0900000001'), ('Trần Thị B', '0900000002'), ('Lê Văn C', '0900000003')");

        // Insert Borrows
        $conn->query("INSERT INTO borrows (reader_id, book_id, borrow_date, return_date) VALUES 
        (1, 1, '2023-10-01', '2023-10-15'), (1, 2, '2023-10-05', NULL), (2, 3, '2023-10-02', '2023-10-10'),
        (3, 1, '2023-11-01', NULL), (2, 5, '2023-11-05', '2023-11-12')");

        $message = "Đã khôi phục dữ liệu mẫu thành công!";
        $msg_type = "success";
    }

    // 2. Chức năng Update Giá sách (Bài tập 4)
    if (isset($_POST['action']) && $_POST['action'] == 'update_price') {
        $id = intval($_POST['book_id']);
        $price = floatval($_POST['new_price']);
        $conn->query("UPDATE books SET price = $price WHERE id = $id");
        $message = "Đã cập nhật giá sách ID $id thành $price";
        $msg_type = "warning";
    }

    // 3. Chức năng Xóa sách (Bài tập 4)
    if (isset($_POST['action']) && $_POST['action'] == 'delete_book') {
        $id = intval($_POST['book_id']);
        // Kiểm tra ràng buộc khóa ngoại trước
        $check = $conn->query("SELECT * FROM borrows WHERE book_id = $id");
        if ($check->num_rows > 0) {
            $message = "Không thể xóa sách ID $id vì đang được mượn!";
            $msg_type = "danger";
        } else {
            $conn->query("DELETE FROM books WHERE id = $id");
            $message = "Đã xóa sách ID $id thành công";
            $msg_type = "primary";
        }
    }
}

// --- HÀM HỖ TRỢ LẤY DỮ LIỆU ---
function getData($conn, $sql) {
    $result = $conn->query($sql);
    return $result;
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 7 - Quản Lý Thư Viện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { background: #fff; min-height: 100vh; padding: 20px; box-shadow: 2px 0 5px rgba(0,0,0,0.05); }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 20px; transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); }
        .card-header { background-color: #fff; border-bottom: 1px solid #eee; font-weight: bold; padding: 15px 20px; border-radius: 12px 12px 0 0 !important; }
        .icon-box { font-size: 2rem; opacity: 0.8; }
        .table thead th { background-color: #f1f3f5; border-bottom: none; color: #495057; font-weight: 600; }
        .btn-custom { border-radius: 50px; padding: 5px 20px; }
        .nav-pills .nav-link.active { background-color: #0d6efd; border-radius: 50px; box-shadow: 0 4px 6px rgba(13, 110, 253, 0.3); }
        .nav-pills .nav-link { color: #555; border-radius: 50px; padding: 10px 20px; margin-right: 10px; }
        .alert-custom { border-radius: 10px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 bg-white shadow-sm p-3 mb-4 d-flex justify-content-between align-items-center">
            <h3 class="m-0 text-primary"><i class="fas fa-book-reader me-2"></i>Thư Viện IT3220</h3>
            <div>
                <span class="badge bg-secondary me-2">Lab 7</span>
                <span class="text-muted"><i class="fas fa-user-circle"></i> Admin</span>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show alert-custom" role="alert">
                <i class="fas fa-info-circle me-2"></i> <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <?php 
                $count_books = $conn->query("SELECT COUNT(*) as c FROM books")->fetch_assoc()['c'];
                $count_readers = $conn->query("SELECT COUNT(*) as c FROM readers")->fetch_assoc()['c'];
                $count_borrows = $conn->query("SELECT COUNT(*) as c FROM borrows")->fetch_assoc()['c'];
            ?>
            <div class="col-md-4">
                <div class="card p-3 border-start border-4 border-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Tổng số sách</p>
                            <h2 class="mb-0 text-primary"><?php echo $count_books; ?></h2>
                        </div>
                        <div class="icon-box text-primary"><i class="fas fa-book"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 border-start border-4 border-success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Độc giả</p>
                            <h2 class="mb-0 text-success"><?php echo $count_readers; ?></h2>
                        </div>
                        <div class="icon-box text-success"><i class="fas fa-users"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 border-start border-4 border-warning">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Lượt mượn</p>
                            <h2 class="mb-0 text-warning"><?php echo $count_borrows; ?></h2>
                        </div>
                        <div class="icon-box text-warning"><i class="fas fa-clipboard-list"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <ul class="nav nav-pills card-header-pills" id="myTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="books-tab" data-bs-toggle="tab" data-bs-target="#books" type="button"><i class="fas fa-list me-1"></i> Danh sách Sách</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="queries-tab" data-bs-toggle="tab" data-bs-target="#queries" type="button"><i class="fas fa-search me-1"></i> Báo cáo & Truy vấn</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button"><i class="fas fa-cogs me-1"></i> Quản trị</button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            
                            <div class="tab-pane fade show active" id="books" role="tabpanel">
                                <h5 class="card-title mb-4 text-primary">Kho Sách Hiện Tại</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên sách</th>
                                                <th>Tác giả</th>
                                                <th>Giá</th>
                                                <th>Năm XB</th>
                                                <th class="text-center">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $books = getData($conn, "SELECT * FROM books ORDER BY id ASC");
                                            if ($books->num_rows > 0):
                                                while($row = $books->fetch_assoc()):
                                            ?>
                                            <tr>
                                                <td>#<?php echo $row['id']; ?></td>
                                                <td class="fw-bold"><?php echo $row['title']; ?></td>
                                                <td><?php echo $row['author']; ?></td>
                                                <td><span class="badge bg-success"><?php echo number_format($row['price'], 2); ?> $</span></td>
                                                <td><?php echo $row['published_year']; ?></td>
                                                <td class="text-center">
                                                    <form method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                                                        <input type="hidden" name="action" value="delete_book">
                                                        <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
                                                        <button class="btn btn-sm btn-outline-danger border-0" title="Xóa"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php endwhile; else: ?>
                                                <tr><td colspan="6" class="text-center text-muted">Chưa có dữ liệu</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="queries" role="tabpanel">
                                <div class="accordion" id="accordionQueries">
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                                <i class="fas fa-filter me-2 text-info"></i> Sách có giá > 12.00
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionQueries">
                                            <div class="accordion-body">
                                                <?php 
                                                    $res = getData($conn, "SELECT * FROM books WHERE price > 12");
                                                    echo "<ul class='list-group'>";
                                                    while($r = $res->fetch_assoc()) { echo "<li class='list-group-item'>{$r['title']} - Price: {$r['price']}</li>"; }
                                                    echo "</ul>";
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                                <i class="fas fa-sort-amount-down me-2 text-info"></i> Top 3 Sách đắt nhất
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionQueries">
                                            <div class="accordion-body">
                                                <?php 
                                                    $res = getData($conn, "SELECT * FROM books ORDER BY price DESC LIMIT 3");
                                                    echo "<ol class='list-group list-group-numbered'>";
                                                    while($r = $res->fetch_assoc()) { echo "<li class='list-group-item d-flex justify-content-between align-items-start'><div class='ms-2 me-auto'><div class='fw-bold'>{$r['title']}</div>{$r['author']}</div><span class='badge bg-primary rounded-pill'>{$r['price']}</span></li>"; }
                                                    echo "</ol>";
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                                <i class="fas fa-link me-2 text-info"></i> Danh sách mượn sách (JOIN)
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionQueries">
                                            <div class="accordion-body">
                                                <table class="table table-sm table-striped">
                                                    <thead><tr><th>Người mượn</th><th>Sách</th><th>Ngày mượn</th></tr></thead>
                                                    <tbody>
                                                    <?php 
                                                        $sql_join = "SELECT r.full_name, bk.title, b.borrow_date FROM borrows b JOIN readers r ON b.reader_id = r.id JOIN books bk ON b.book_id = bk.id";
                                                        $res = getData($conn, $sql_join);
                                                        while($r = $res->fetch_assoc()) { echo "<tr><td>{$r['full_name']}</td><td>{$r['title']}</td><td>{$r['borrow_date']}</td></tr>"; }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="admin" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <h6 class="card-title text-danger"><i class="fas fa-exclamation-triangle"></i> Vùng nguy hiểm</h6>
                                                <p class="card-text small">Nút này sẽ xóa toàn bộ dữ liệu hiện tại và nạp lại dữ liệu mẫu ban đầu (Bài tập 2).</p>
                                                <form method="POST">
                                                    <input type="hidden" name="action" value="reset_data">
                                                    <button type="submit" class="btn btn-danger w-100"><i class="fas fa-undo"></i> Khôi phục Dữ liệu Gốc</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <h6 class="card-title text-primary"><i class="fas fa-edit"></i> Cập nhật nhanh giá sách (ID=1)</h6>
                                                <form method="POST" class="row g-2">
                                                    <input type="hidden" name="action" value="update_price">
                                                    <input type="hidden" name="book_id" value="1">
                                                    <div class="col-auto">
                                                        <input type="number" step="0.01" class="form-control" name="new_price" placeholder="Giá mới (VD: 20.00)" required>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                    </div>
                                                </form>
                                                <small class="text-muted d-block mt-2">Bài tập 4: Cập nhật giá sách có ID=1</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> </div>
                </div>
            </div>
        </div>

        <footer class="mt-5 text-center text-muted small">
            <p>&copy; 2024 Lab 7 PHP & MySQL - Student Name</p>
        </footer>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>