<?php
session_start();
require_once 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Kiểm tra xem ID có tồn tại không trước khi xóa (Optional nhưng nên làm)
        $check = $conn->prepare("SELECT id FROM categories WHERE id = ?");
        $check->execute([$id]);

        if ($check->rowCount() > 0) {
            $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$id]);

            $_SESSION['flash_message'] = "Xóa danh mục thành công!";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_message'] = "Danh mục không tồn tại!";
            $_SESSION['flash_type'] = "danger";
        }

    } catch (PDOException $e) {
        $_SESSION['flash_message'] = "Lỗi không thể xóa: " . $e->getMessage();
        $_SESSION['flash_type'] = "danger";
    }
}

header("Location: index.php");
exit;
?>