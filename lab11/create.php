<?php
session_start();
require_once 'db.php';

$errors = [];
// Khởi tạo biến để giữ giá trị (Sticky form)
$name = '';
$slug = '';
$description = '';
$status = 1; // Default Active

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu và trim khoảng trắng
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;

    // --- VALIDATION ---
    // 1. Name: Bắt buộc, 3-100 ký tự
    if (empty($name)) {
        $errors['name'] = 'Tên danh mục là bắt buộc.';
    } elseif (strlen($name) < 3 || strlen($name) > 100) {
        $errors['name'] = 'Tên danh mục phải từ 3 đến 100 ký tự.';
    }

    // 2. Slug: Bắt buộc, regex, unique
    if (empty($slug)) {
        $errors['slug'] = 'Slug là bắt buộc.';
    } elseif (!preg_match('/^[a-z0-9-]+$/', $slug)) {
        $errors['slug'] = 'Slug chỉ được chứa chữ thường (a-z), số (0-9) và dấu gạch ngang (-).';
    } else {
        // Check Unique
        $stmt = $conn->prepare("SELECT COUNT(*) FROM categories WHERE slug = ?");
        $stmt->execute([$slug]);
        if ($stmt->fetchColumn() > 0) {
            $errors['slug'] = 'Slug này đã tồn tại, vui lòng chọn slug khác.';
        }
    }

    // 3. Status: Chỉ 0 hoặc 1
    if (!in_array($status, [0, 1])) {
        $errors['status'] = 'Trạng thái không hợp lệ.';
    }

    // --- SAVE DATA ---
    if (empty($errors)) {
        try {
            $sql = "INSERT INTO categories (name, slug, description, status, created_at, updated_at) 
                    VALUES (:name, :slug, :desc, :status, NOW(), NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':slug' => $slug,
                ':desc' => $description,
                ':status' => $status
            ]);

            // Flash message
            $_SESSION['flash_message'] = "Thêm mới thành công!";
            $_SESSION['flash_type'] = "success";
            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            $errors['db'] = "Lỗi hệ thống: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Thêm Danh mục mới</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($errors['db'])): ?>
                        <div class="alert alert-danger"><?= $errors['db'] ?></div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                                   value="<?= htmlspecialchars($name) ?>">
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback"><?= $errors['name'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug (URL) <span class="text-danger">*</span></label>
                            <input type="text" name="slug" class="form-control <?= isset($errors['slug']) ? 'is-invalid' : '' ?>" 
                                   value="<?= htmlspecialchars($slug) ?>">
                            <div class="form-text">Chỉ nhập a-z, 0-9 và dấu gạch ngang (-).</div>
                            <?php if (isset($errors['slug'])): ?>
                                <div class="invalid-feedback"><?= $errors['slug'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($description) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Hiển thị (Active)</option>
                                <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Ẩn (Inactive)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                        <a href="index.php" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>