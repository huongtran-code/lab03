<?php include APP_ROOT . '/views/layouts/header.php'; ?>

<h2>Thêm Người Mượn Mới</h2>
<hr>

<form action="index.php?controller=borrower&action=store" method="POST" class="w-50 mx-auto">
    
    <div class="mb-3">
        <label class="form-label">Họ và tên:</label>
        <input type="text" name="full_name" class="form-control" placeholder="Ví dụ: Nguyễn Văn A" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Số điện thoại:</label>
        <input type="text" name="phone" class="form-control" placeholder="Ví dụ: 0987654321" required>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="index.php?controller=borrower&action=index" class="btn btn-secondary">Quay lại</a>
        <button type="submit" class="btn btn-primary">Lưu người mượn</button>
    </div>
</form>

<?php include APP_ROOT . '/views/layouts/footer.php'; ?>