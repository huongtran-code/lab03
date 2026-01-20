<?php include APP_ROOT . '/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>👥 Danh sách Người Mượn</h2>
    <a href="index.php?controller=borrower&action=create" class="btn btn-success">+ Thêm người mượn</a>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Họ và tên</th>
            <th>Số điện thoại</th>
            <th>Ngày tạo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($borrowers as $b): ?>
        <tr>
            <td><?= $b['id'] ?></td>
            <td><?= htmlspecialchars($b['full_name']) ?></td>
            <td><?= htmlspecialchars($b['phone']) ?></td>
            <td><?= $b['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include APP_ROOT . '/views/layouts/footer.php'; ?>