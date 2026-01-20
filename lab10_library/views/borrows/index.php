<?php include APP_ROOT . '/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>📝 Danh sách Phiếu Mượn</h2>
    <a href="index.php?controller=borrow&action=create" class="btn btn-success">+ Tạo phiếu mượn</a>
</div>

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Mã Phiếu</th>
            <th>Người mượn</th>
            <th>Ngày mượn</th>
            <th>Ghi chú</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($borrows as $b): ?>
        <tr>
            <td>#<?= $b['id'] ?></td>
            <td><strong><?= htmlspecialchars($b['full_name']) ?></strong></td>
            <td><?= date('d/m/Y', strtotime($b['borrow_date'])) ?></td>
            <td><?= htmlspecialchars($b['note']) ?></td>
            <td>
                <a href="index.php?controller=borrow&action=show&id=<?= $b['id'] ?>" class="btn btn-sm btn-info text-white">Xem chi tiết</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include APP_ROOT . '/views/layouts/footer.php'; ?>