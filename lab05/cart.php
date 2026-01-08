<?php
require_once 'includes/header.php';
require_login();

// Copy lại mảng products để lấy info (Trong thực tế sẽ lấy từ DB)
$products = [
    1 => ['name' => 'iPhone 15 Pro Max', 'price' => 30000000, 'img' => 'https://placehold.co/50x50/png?text=IP'],
    2 => ['name' => 'Samsung S24 Ultra', 'price' => 28000000, 'img' => 'https://placehold.co/50x50/png?text=SS'],
    3 => ['name' => 'MacBook Air M2', 'price' => 24500000, 'img' => 'https://placehold.co/50x50/png?text=Mac'],
    4 => ['name' => 'Sony WH-1000XM5', 'price' => 8500000, 'img' => 'https://placehold.co/50x50/png?text=Sony'],
    5 => ['name' => 'iPad Air 5', 'price' => 14000000, 'img' => 'https://placehold.co/50x50/png?text=iPad'],
    6 => ['name' => 'Apple Watch S9', 'price' => 10500000, 'img' => 'https://placehold.co/50x50/png?text=AW'],
];

// Xử lý các hành động trong giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'inc': // Tăng
                $_SESSION['cart'][$id]++;
                break;
            case 'dec': // Giảm
                if ($_SESSION['cart'][$id] > 1) $_SESSION['cart'][$id]--;
                else unset($_SESSION['cart'][$id]); // Xóa nếu giảm về 0
                break;
            case 'remove': // Xóa hẳn
                unset($_SESSION['cart'][$id]);
                set_flash('info', 'Đã xóa sản phẩm khỏi giỏ hàng.');
                break;
            case 'clear': // Xóa hết
                unset($_SESSION['cart']);
                set_flash('info', 'Đã làm trống giỏ hàng.');
                break;
        }
        header('Location: cart.php'); // Refresh để cập nhật UI ngay lập tức
        exit();
    }
}

$cart = $_SESSION['cart'] ?? [];
$total_money = 0;
?>

<div class="row">
    <div class="col-md-8">
        <h3 class="mb-4">Giỏ hàng của bạn</h3>
        
        <?php if (empty($cart)): ?>
            <div class="text-center py-5 bg-white rounded shadow-sm">
                <i class="bi bi-cart-x display-1 text-muted"></i>
                <p class="mt-3">Giỏ hàng đang trống.</p>
                <a href="products.php" class="btn btn-primary">Mua sắm ngay</a>
            </div>
        <?php else: ?>
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $id => $qty): 
                                if (!isset($products[$id])) continue;
                                $p = $products[$id];
                                $subtotal = $p['price'] * $qty;
                                $total_money += $subtotal;
                            ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $p['img'] ?>" class="rounded me-3" width="50">
                                        <div>
                                            <h6 class="mb-0"><?= $p['name'] ?></h6>
                                            <small class="text-muted"><?= number_format($p['price']) ?> ₫</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <input type="hidden" name="action" value="dec">
                                            <button type="submit" class="btn btn-outline-secondary">-</button>
                                        </form>
                                        <button class="btn btn-light disabled" style="width: 40px; color:black; font-weight:bold"><?= $qty ?></button>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <input type="hidden" name="action" value="inc">
                                            <button type="submit" class="btn btn-outline-secondary">+</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="text-end fw-bold">
                                    <?= number_format($subtotal) ?> ₫
                                </td>
                                <td class="text-end">
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <input type="hidden" name="action" value="remove">
                                        <button type="submit" class="btn btn-link text-danger p-0" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-3">
                <form method="POST">
                    <input type="hidden" name="action" value="clear">
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn xóa hết?')">
                        <i class="bi bi-trash"></i> Xóa toàn bộ giỏ hàng
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4 mt-4 mt-md-0">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">Tóm tắt đơn hàng</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Tạm tính:</span>
                    <span><?= number_format($total_money) ?> ₫</span>
                </div>
                <div class="d-flex justify-content-between mb-3 text-success">
                    <span>Giảm giá:</span>
                    <span>0 ₫</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <strong class="fs-5">Tổng cộng:</strong>
                    <strong class="fs-5 text-primary"><?= number_format($total_money) ?> ₫</strong>
                </div>
                <button class="btn btn-primary w-100 py-2 fw-bold" <?= $total_money == 0 ? 'disabled' : '' ?>>
                    TIẾN HÀNH THANH TOÁN
                </button>
                <a href="products.php" class="btn btn-link w-100 mt-2 text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Tiếp tục mua hàng
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>