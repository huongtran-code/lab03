<?php
require_once "Product.php";

$products = [];
$rawInput = isset($_POST['data']) ? $_POST['data'] : "P001-Rice Cooker-120-2;P002-Kettle-45-1;P003-Blender-80-3;P004-TV-500-0";
$minPrice = isset($_POST['minPrice']) ? floatval($_POST['minPrice']) : 0;
$sortAmount = isset($_POST['sortAmount']);

$totalMoney = 0;
$maxAmountProduct = null;
$avgPrice = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Parse Data
    $records = explode(";", $rawInput);
    foreach ($records as $rec) {
        $parts = array_map('trim', explode("-", $rec));
        
        // Validate: Đủ 4 trường, Price và Qty phải là số
        if (count($parts) === 4 && is_numeric($parts[2]) && is_numeric($parts[3])) {
            $p = new Product($parts[0], $parts[1], $parts[2], $parts[3]);
            
            // 4. Filter Min Price
            if ($p->price >= $minPrice) {
                $products[] = $p;
            }
        }
    }

    if (!empty($products)) {
        // 5. Sort Amount Desc
        if ($sortAmount) {
            usort($products, fn($a, $b) => $b->getAmount() <=> $a->getAmount());
        }

        // 3. Tính toán thống kê
        $totalMoney = array_reduce($products, fn($sum, $p) => $sum + $p->getAmount(), 0);
        
        $prices = array_map(fn($p) => $p->price, $products);
        $avgPrice = array_sum($prices) / count($prices);

        // Tìm sản phẩm amount lớn nhất
        $maxVal = -1;
        foreach ($products as $p) {
            if ($p->getAmount() > $maxVal) {
                $maxVal = $p->getAmount();
                $maxAmountProduct = $p;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Bài 6B: Sales Manager</title>
    <style>
        body { font-family: sans-serif; }
        .invalid { color: red; font-style: italic; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Mini Sales Manager</h2>
    
    <form method="POST">
        <strong>Data Input (ID-Name-Price-Qty):</strong><br>
        <textarea name="data" style="width: 100%; height: 80px;"><?php echo htmlspecialchars($rawInput); ?></textarea>
        <br><br>
        
        Min Price: <input type="number" name="minPrice" value="<?php echo $minPrice; ?>">
        
        <label style="margin-left: 15px;">
            <input type="checkbox" name="sortAmount" <?php echo $sortAmount ? "checked" : ""; ?>> 
            Sort Amount (High to Low)
        </label>
        
        <button type="submit" style="margin-left: 15px;">Process</button>
    </form>

    <?php if (!empty($products)): ?>
        <table>
            <thead>
                <tr>
                    <th>STT</th><th>ID</th><th>Name</th><th>Price ($)</th><th>Qty</th><th>Amount ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $i => $p): ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo htmlspecialchars($p->id); ?></td>
                    <td><?php echo htmlspecialchars($p->name); ?></td>
                    <td><?php echo number_format($p->price, 2); ?></td>
                    <td>
                        <?php 
                        if ($p->qty <= 0) echo "<span class='invalid'>Invalid ({$p->qty})</span>";
                        else echo $p->qty;
                        ?>
                    </td>
                    <td><strong><?php echo number_format($p->getAmount(), 2); ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="margin-top: 20px; background: #eef; padding: 15px; border-radius: 5px;">
            <h3>Thống kê báo cáo:</h3>
            <p><strong>Tổng doanh thu:</strong> $<?php echo number_format($totalMoney, 2); ?></p>
            <p><strong>Giá trung bình (Avg Price):</strong> $<?php echo number_format($avgPrice, 2); ?></p>
            <p>
                <strong>Sản phẩm doanh thu cao nhất:</strong> 
                <?php 
                if ($maxAmountProduct) {
                    echo htmlspecialchars($maxAmountProduct->name) . " ($" . number_format($maxAmountProduct->getAmount()) . ")";
                }
                ?>
            </p>
        </div>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p style="color:red; margin-top:20px;">Không có dữ liệu hợp lệ để hiển thị.</p>
    <?php endif; ?>
</body>
</html>