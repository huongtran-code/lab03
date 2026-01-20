<?php include APP_ROOT . '/views/layouts/header.php'; ?>

<h2>Tạo Phiếu Mượn Sách</h2>
<hr>

<form action="index.php?controller=borrow&action=store" method="POST">
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 mb-3">
                <h5>Thông tin chung</h5>
                <div class="mb-3">
                    <label>Người mượn:</label>
                    <select name="borrower_id" class="form-select" required>
                        <?php foreach($borrowers as $b): ?>
                            <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['full_name']) ?> - <?= $b['phone'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Ngày mượn:</label>
                    <input type="date" name="borrow_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="mb-3">
                    <label>Ghi chú:</label>
                    <textarea name="note" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2">Lưu Phiếu Mượn</button>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card p-3">
                <h5>Chọn sách muốn mượn</h5>
                <small class="text-muted mb-3 d-block">Bạn có thể chọn tối đa 3 sách cho 1 lần mượn</small>
                
                <?php for($i=1; $i<=3; $i++): ?>
                <div class="row mb-2 pb-2 border-bottom">
                    <div class="col-md-1 d-flex align-items-center">
                        <strong>#<?= $i ?></strong>
                    </div>
                    <div class="col-md-8">
                        <select name="book_ids[]" class="form-select">
                            <option value="">-- Chọn sách --</option>
                            <?php foreach($books as $book): ?>
                                <option value="<?= $book['id'] ?>" <?= $book['qty'] < 1 ? 'disabled' : '' ?>>
                                    <?= htmlspecialchars($book['title']) ?> (Còn: <?= $book['qty'] ?>)
                                    <?= $book['qty'] < 1 ? '[HẾT HÀNG]' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="quantities[]" class="form-control" placeholder="Số lượng" value="1" min="1">
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</form>

<?php include APP_ROOT . '/views/layouts/footer.php'; ?>