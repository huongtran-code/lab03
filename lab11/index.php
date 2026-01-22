<?php
session_start();
require_once 'db.php';

// Xử lý tìm kiếm
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM categories";
$params = [];

if (!empty($search)) {
    // Tìm theo name hoặc slug
    $sql .= " WHERE name LIKE :s OR slug LIKE :s";
    $params[':s'] = "%$search%";
}

$sql .= " ORDER BY id DESC"; // Mới nhất lên đầu

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2 class="mb-4">Danh sách Danh mục</h2>

    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?= $_SESSION['flash_type']; ?> alert-dismissible fade show">
            <?= $_SESSION['flash_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php 
            unset($_SESSION['flash_message']); 
            unset($_SESSION['flash_type']);
        ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between mb-3">
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Tìm tên hoặc slug..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Tìm</button>
            <?php if($search): ?>
                <a href="index.php" class="btn btn-secondary ms-2">Reset</a>
            <?php endif; ?>
        </form>
        
        <a href="create.php" class="btn btn-success"> + Thêm mới</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Mô tả</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th width="150">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($categories) > 0): ?>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= htmlspecialchars($cat['id']) ?></td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td><?= htmlspecialchars($cat['slug']) ?></td>
                    <td><?= htmlspecialchars($cat['description']) ?></td>
                    <td>
                        <?php if ($cat['status'] == 1): ?>
                            <span class="badge bg-success">Hiển thị</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Ẩn</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($cat['created_at']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $cat['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="delete.php?id=<?= $cat['id'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Không tìm thấy dữ liệu</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>