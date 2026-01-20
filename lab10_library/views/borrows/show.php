<?php include APP_ROOT . '/views/layouts/header.php'; ?>

<div class="card">
    <div class="card-header bg-info text-white">
        <h3 class="mb-0">Chi tiết Phiếu Mượn #<?= $borrow['id'] ?></h3>
    </div>
    <div class="card-body">
        <p><strong>Người mượn:</strong> <?= htmlspecialchars($borrow['full_name']) ?></p>
        <p><strong>Ngày mượn:</strong> <?= date('d/m/Y', strtotime($borrow['borrow_date'])) ?></p>
        <p><strong>Ghi chú:</strong> <?= htmlspecialchars($borrow['note']) ?></p>
        
        <h4 class="mt-4">Danh sách sách đã mượn:</h4>
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalQty = 0;
                if (isset($borrow['items'])):
                    foreach($borrow['items'] as $item): 
                        $totalQty += $item['qty'];
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['title']) ?></td>
                        <td><?= htmlspecialchars($item['author']) ?></td>
                        <td><?= $item['qty'] ?></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
            <tfoot>
                <tr class="table-secondary">
                    <td colspan="2" class="text-end"><strong>Tổng số lượng:</strong></td>
                    <td><strong><?= $totalQty ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-3">
            <a href="index.php?controller=borrow&action=index" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
</div>

<?php include APP_ROOT . '/views/layouts/footer.php'; ?>