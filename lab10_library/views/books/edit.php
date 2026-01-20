<?php include APP_ROOT . '/views/layouts/header.php'; ?>

<h2>Cập nhật Sách: #<?= $book['id'] ?></h2>
<hr>

<form action="index.php?controller=book&action=update" method="POST" class="w-50 mx-auto">
    <input type="hidden" name="id" value="<?= $book['id'] ?>">

    <div class="mb-3">
        <label class="form-label">Tên sách:</label>
        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($book['title']) ?>" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Tác giả:</label>
        <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($book['author']) ?>" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Giá (VNĐ):</label>
            <input type="number" name="price" class="form-control" min="0" value="<?= $book['price'] ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Số lượng kho:</label>
            <input type="number" name="qty" class="form-control" min="0" value="<?= $book['qty'] ?>" required>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <a href="index.php?controller=book&action=index" class="btn btn-secondary">Hủy</a>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </div>
</form>

<?php include APP_ROOT . '/views/layouts/footer.php'; ?>