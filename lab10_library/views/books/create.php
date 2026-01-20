<?php include APP_ROOT . '/views/layouts/header.php'; ?>

<h2>Thêm Sách Mới</h2>
<hr>

<form action="index.php?controller=book&action=store" method="POST" class="w-50 mx-auto">
    <div class="mb-3">
        <label class="form-label">Tên sách:</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Tác giả:</label>
        <input type="text" name="author" class="form-control" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Giá (VNĐ):</label>
            <input type="number" name="price" class="form-control" min="0" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Số lượng nhập:</label>
            <input type="number" name="qty" class="form-control" min="0" value="0" required>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <a href="index.php?controller=book&action=index" class="btn btn-secondary">Quay lại</a>
        <button type="submit" class="btn btn-success">Lưu dữ liệu</button>
    </div>
</form>

<?php include APP_ROOT . '/views/layouts/footer.php'; ?>