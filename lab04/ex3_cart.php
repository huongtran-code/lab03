<?php
// Hàm helper htmlspecialchars
function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

// 1. Khai báo mảng products
$products = [
    ['name' => 'iPhone 15', 'price' => 20000000, 'qty' => 2],
    ['name' => 'Samsung S24', 'price' => 18000000, 'qty' => 1],
    ['name' => 'AirPods Pro', 'price' => 5000000, 'qty' => 4],
    ['name' => 'Xiaomi 14', 'price' => 12000000, 'qty' => 3],
];

// 2. Tạo cột Amount = Price * Qty (Dùng array_map)
$products = array_map(function($p) {
    $p['amount'] = $p['price'] * $p['qty'];
    return $p;
}, $products);

// 6. Sắp xếp theo Price GIẢM dần (usort)
usort($products, fn($a, $b) => $b['price'] <=> $a['price']);

// 4. Tính tổng tiền (array_reduce hoặc loop)
$totalMoney = array_reduce($products, fn($sum, $item) => $sum + $item['amount'], 0);

// 5. Tìm sản phẩm có Amount lớn nhất
// (Sort amount giảm dần rồi lấy phần tử đầu, hoặc loop tìm max. Ở đây dùng loop tìm max)
$maxAmountProduct = null;
$maxVal = -1;
foreach ($products as $p) {
    if ($p['amount'] > $maxVal) {
        $maxVal = $p['amount'];
        $maxAmountProduct = $p;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Bài 3: Giỏ hàng</title>
    <style>table { border-collapse: collapse; width: 60%; } th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }</style>
</head>
<body>
    <h3>Giỏ hàng (Đã sắp xếp giá giảm dần)</h3>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $index => $p): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo h($p['name']); ?></td>
                <td><?php echo number_format($p['price']); ?></td>
                <td><?php echo $p['qty']; ?></td>
                <td><?php echo number_format($p['amount']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" align="right"><strong>Tổng tiền:</strong></td>
                <td><strong><?php echo number_format($totalMoney); ?> VNĐ</strong></td>
            </tr>
        </tfoot>
    </table>

    <p>
        <strong>Sản phẩm có thành tiền (Amount) lớn nhất:</strong> 
        <?php echo h($maxAmountProduct['name']); ?> 
        (<?php echo number_format($maxAmountProduct['amount']); ?> VNĐ)
    </p>
</body>
</html>