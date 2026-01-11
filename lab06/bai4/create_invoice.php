<?php
// Bật báo lỗi để dễ debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

$folder_path = '../data/invoices';
// Tạo thư mục lưu trữ nếu chưa có (Sử dụng file_exists và thêm @ để chặn cảnh báo)
if (!file_exists($folder_path)) {
    @mkdir($folder_path, 0777, true);
}

$errors = [];
$invoice_data = null; // Biến chứa kết quả hóa đơn để hiển thị

// --- XỬ LÝ FORM KHI SUBMIT ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Lấy thông tin khách hàng
    $customer = [
        'name' => trim($_POST['customer_name'] ?? ''),
        'email' => trim($_POST['customer_email'] ?? ''),
        'phone' => trim($_POST['customer_phone'] ?? ''),
        'payment_method' => $_POST['payment_method'] ?? 'Tiền mặt'
    ];

    // Validate khách hàng
    if (empty($customer['name']) || empty($customer['phone'])) {
        $errors[] = "Vui lòng nhập tên và số điện thoại khách hàng.";
    }

    // 2. Xử lý danh sách hàng hóa
    $raw_items = $_POST['items'] ?? []; // Mảng lấy từ form items[0]...
    $valid_items = [];
    $subtotal = 0; // Tổng tiền hàng chưa thuế

    foreach ($raw_items as $item) {
        $name = trim($item['name'] ?? '');
        $qty = (int)($item['qty'] ?? 0);
        $price = (float)($item['price'] ?? 0);

        // Chỉ xử lý dòng nào có tên hàng và số lượng > 0
        if (!empty($name) && $qty > 0 && $price > 0) {
            $line_total = $qty * $price;
            $subtotal += $line_total;

            $valid_items[] = [
                'name' => $name,
                'qty' => $qty,
                'price' => $price,
                'line_total' => $line_total
            ];
        }
    }

    if (empty($valid_items)) {
        $errors[] = "Vui lòng nhập ít nhất 1 mặt hàng hợp lệ (Có tên, SL > 0, Giá > 0).";
    }

    // 3. Tính toán Thuế và Giảm giá
    if (empty($errors)) {
        $discount_percent = (float)($_POST['discount'] ?? 0);
        $vat_percent = (float)($_POST['vat'] ?? 0);

        // Giới hạn giá trị nhập
        if ($discount_percent < 0) $discount_percent = 0;
        if ($discount_percent > 30) $discount_percent = 30; // Max 30%
        if ($vat_percent < 0) $vat_percent = 0;
        if ($vat_percent > 15) $vat_percent = 15; // Max 15%

        // Tính tiền
        $discount_amount = $subtotal * ($discount_percent / 100);
        $after_discount = $subtotal - $discount_amount;
        
        $vat_amount = $after_discount * ($vat_percent / 100);
        $total_payment = $after_discount + $vat_amount;

        // Đóng gói dữ liệu hóa đơn
        $invoice_data = [
            'id' => time(), // Dùng timestamp làm mã hóa đơn
            'created_at' => date('Y-m-d H:i:s'),
            'customer' => $customer,
            'items' => $valid_items,
            'subtotal' => $subtotal,
            'discount_percent' => $discount_percent,
            'discount_amount' => $discount_amount,
            'vat_percent' => $vat_percent,
            'vat_amount' => $vat_amount,
            'total_payment' => $total_payment
        ];

        // 4. Lưu ra file JSON
        $filename = "invoice_" . $invoice_data['id'] . ".json";
        file_put_contents($folder_path . '/' . $filename, json_encode($invoice_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo hóa đơn bán hàng</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; background: #f9f9f9; }
        .container { background: white; padding: 20px; border: 1px solid #ccc; box-shadow: 2px 2px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .error { color: red; background: #ffe6e6; padding: 10px; margin-bottom: 15px; border: 1px solid red; }
        
        /* Form Style */
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 150px; font-weight: bold; }
        input[type=text], input[type=email], input[type=number] { padding: 5px; width: 250px; }
        
        /* Table Style */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        .num-col { text-align: right; }
        
        /* Invoice Result Style */
        .invoice-box { border: 1px solid #333; padding: 20px; margin-top: 20px; }
        .invoice-header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .total-row td { font-weight: bold; }
        .grand-total { font-size: 1.2em; color: #d35400; }
        
        .btn-submit { background: #2980b9; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; }
        .btn-new { background: #27ae60; color: white; text-decoration: none; padding: 10px 20px; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    
    <?php if ($invoice_data): ?>
        <div class="invoice-box">
            <h2>HÓA ĐƠN BÁN LẺ</h2>
            <div class="invoice-header">
                <div>
                    <strong>Khách hàng:</strong> <?= htmlspecialchars($invoice_data['customer']['name']) ?><br>
                    <strong>SĐT:</strong> <?= htmlspecialchars($invoice_data['customer']['phone']) ?><br>
                    <strong>Email:</strong> <?= htmlspecialchars($invoice_data['customer']['email']) ?>
                </div>
                <div style="text-align: right;">
                    <strong>Mã HĐ:</strong> #<?= $invoice_data['id'] ?><br>
                    <strong>Ngày:</strong> <?= $invoice_data['created_at'] ?><br>
                    <strong>TT:</strong> <?= $invoice_data['customer']['payment_method'] ?>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên hàng</th>
                        <th class="num-col">SL</th>
                        <th class="num-col">Đơn giá</th>
                        <th class="num-col">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoice_data['items'] as $index => $item): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td class="num-col"><?= $item['qty'] ?></td>
                        <td class="num-col"><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                        <td class="num-col"><?= number_format($item['line_total'], 0, ',', '.') ?> đ</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="num-col"><strong>Tổng tạm tính:</strong></td>
                        <td class="num-col"><?= number_format($invoice_data['subtotal'], 0, ',', '.') ?> đ</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="num-col">Chiết khấu (<?= $invoice_data['discount_percent'] ?>%):</td>
                        <td class="num-col">- <?= number_format($invoice_data['discount_amount'], 0, ',', '.') ?> đ</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="num-col">VAT (<?= $invoice_data['vat_percent'] ?>%):</td>
                        <td class="num-col">+ <?= number_format($invoice_data['vat_amount'], 0, ',', '.') ?> đ</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="4" class="num-col grand-total">TỔNG THANH TOÁN:</td>
                        <td class="num-col grand-total"><?= number_format($invoice_data['total_payment'], 0, ',', '.') ?> đ</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div style="text-align: center;">
            <a href="create_invoice.php" class="btn-new">Tạo hóa đơn mới</a>
        </div>
    
    <?php else: ?>
        <h2>Lập Hóa Đơn</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $e) echo "<div>- $e</div>"; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <h3>Thông tin khách hàng</h3>
            <div class="form-group">
                <label>Họ tên (*):</label> 
                <input type="text" name="customer_name" required>
            </div>
            <div class="form-group">
                <label>Số điện thoại (*):</label> 
                <input type="text" name="customer_phone" required>
            </div>
            <div class="form-group">
                <label>Email:</label> 
                <input type="email" name="customer_email">
            </div>

            <h3>Danh sách hàng hóa</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tên hàng hóa</th>
                        <th>Số lượng</th>
                        <th>Đơn giá (VND)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="items[0][name]" placeholder="Ví dụ: Áo thun"></td>
                        <td><input type="number" name="items[0][qty]" min="1" style="width: 80px;"></td>
                        <td><input type="number" name="items[0][price]" min="0" step="1000" style="width: 120px;"></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="items[1][name]"></td>
                        <td><input type="number" name="items[1][qty]" min="1" style="width: 80px;"></td>
                        <td><input type="number" name="items[1][price]" min="0" step="1000" style="width: 120px;"></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="items[2][name]"></td>
                        <td><input type="number" name="items[2][qty]" min="1" style="width: 80px;"></td>
                        <td><input type="number" name="items[2][price]" min="0" step="1000" style="width: 120px;"></td>
                    </tr>
                </tbody>
            </table>
            <p style="font-style: italic; color: #666; font-size: 0.9em;">* Nhập ít nhất 1 dòng hàng hóa.</p>

            <h3>Thông tin thanh toán</h3>
            <div class="form-group">
                <label>Giảm giá (%):</label>
                <input type="number" name="discount" value="0" min="0" max="30" style="width: 80px;"> (0 - 30%)
            </div>
            <div class="form-group">
                <label>Thuế VAT (%):</label>
                <input type="number" name="vat" value="0" min="0" max="15" style="width: 80px;"> (0 - 15%)
            </div>
            <div class="form-group">
                <label>Hình thức TT:</label>
                <input type="radio" name="payment_method" value="Tiền mặt" checked> Tiền mặt
                <input type="radio" name="payment_method" value="Chuyển khoản"> Chuyển khoản
            </div>

            <hr>
            <div style="text-align: center;">
                <button type="submit" class="btn-submit">Lập hóa đơn & Tính tiền</button>
            </div>
        </form>
    <?php endif; ?>
</div>

</body>
</html>