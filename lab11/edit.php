<?php
session_start();
require_once 'db.php';

// Kiểm tra ID
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$errors = [];

// Lấy dữ liệu hiện tại
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$category = $stmt->fetch();

if (!$category) {
    die("Danh mục không tồn tại!");
}

// Gán giá trị ban đầu cho form
$name = $category['name'];
$slug = $category['slug'];
$description = $category['description'];
$status = $category['status'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;

    // --- VALIDATION ---
    if (empty($name)) {
        $errors['name'] = 'Tên danh mục là bắt buộc.';
    } elseif (strlen($name) < 3 || strlen($name) > 100) {
        $errors['name'] = 'Tên danh mục phải từ 3 đến 100 ký tự.';
    }

    if (empty($slug)) {
        $errors['slug'] = 'Slug là bắt buộc.';
    } elseif (!preg_match('/^[a-z0-9-]+$/', $slug)) {
        $errors['slug'] = 'Slug không hợp lệ (a-z, 0-9, -).';
    } else {
        // Check Unique (TRỪ ID HIỆN TẠI RA)
        $stmt = $conn->prepare("SELECT COUNT(*) FROM categories WHERE slug = ? AND id != ?");
        $stmt->execute([$slug, $id]);
        if ($stmt->fetchColumn() > 0) {
            $errors['slug'] = 'Slug này đã được sử dụng bởi danh mục khác.';
        }
    }

    if (!in_array($status, [0, 1])) {
        $errors['status'] = 'Trạng thái sai.';
    }

    // --- UPDATE DATA ---
    if (empty($errors)) {
        try {
            $sql = "UPDATE categories 
                    SET name = :name, slug = :slug, description = :desc, status = :status, updated_at = NOW() 
                    WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':slug' => $slug,
                ':desc' => $description,
                ':status' => $status,
                ':id' => $id
            ]);

            $_SESSION['flash_message'] = "Cập nhật thành công!";
            $_SESSION['flash_type'] = "success";
            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            $errors['db'] = "Lỗi: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Cập nhật Danh mục: <?= htmlspecialchars($category['name']) ?></h4>
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
                            <label class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" class="form-control <?= isset($errors['slug']) ? 'is-invalid' : '' ?>" 
                                   value="<?= htmlspecialchars($slug) ?>">
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
                                <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Hiển thị</option>
                                <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Ẩn</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="index.php" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>