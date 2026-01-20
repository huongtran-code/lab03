<?php include APP_ROOT . '/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>📖 Danh sách Sách</h2>
    <a href="index.php?controller=book&action=create" class="btn btn-success">+ Thêm sách mới</a>
</div>

<form action="" method="GET" class="row g-2 mb-4 bg-light p-3 rounded">
    <input type="hidden" name="controller" value="book">
    <input type="hidden" name="action" value="index">
    
    <div class="col-md-4">
        <input type="text" name="keyword" class="form-control" placeholder="Tìm tên sách hoặc tác giả..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
    </div>
    
    <div class="col-md-3">
        <select name="sort" class="form-select">
            <option value="id">-- Sắp xếp --</option>
            <option value="price" <?= ($_GET['sort']??'')=='price'?'selected':'' ?>>Giá tiền</option>
            <option value="qty" <?= ($_GET['sort']??'')=='qty'?'selected':'' ?>>Tồn kho</option>
            <option value="created_at" <?= ($_GET['sort']??'')=='created_at'?'selected':'' ?>>Ngày nhập</option>
        </select>
    </div>

    <div class="col-md-2">
        <select name="dir" class="form-select">
            <option value="desc" <?= ($_GET['dir']??'')=='desc'?'selected':'' ?>>Giảm dần</option>
            <option value="asc" <?= ($_GET['dir']??'')=='asc'?'selected':'' ?>>Tăng dần</option>
        </select>
    </div>
    
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Lọc dữ liệu</button>
    </div>
</form>

<table class="table table-hover table-bordered">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Tên sách</th>
            <th>Tác giả</th>
            <th>Giá</th>
            <th>Tồn kho</th>
            <th width="150">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($books)): ?>
            <tr><td colspan="6" class="text-center text-muted">Không tìm thấy dữ liệu</td></tr>
        <?php else: ?>
            <?php foreach($books as $book): ?>
            <tr>
                <td><?= $book['id'] ?></td>
                <td><strong><?= htmlspecialchars($book['title']) ?></strong></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= number_format($book['price']) ?> đ</td>
                <td>
                    <span class="badge <?= $book['qty'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                        <?= $book['qty'] ?>
                    </span>
                </td>
                <td>
                    <a href="index.php?controller=book&action=edit&id=<?= $book['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    
                    <form action="index.php?controller=book&action=delete" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa sách này?');">
                        <input type="hidden" name="id" value="<?= $book['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php include APP_ROOT . '/views/layouts/footer.php'; ?>