<?php
require_once 'includes/header.php'; // Đã bao gồm auth check trong header logic nếu muốn, hoặc check lại ở đây
require_login();

// Dữ liệu sản phẩm với hình ảnh giả lập
$products = [
    1 => ['name' => 'iPhone 15 Pro Max', 'price' => 30000000, 'img' => 'https://placehold.co/300x200/png?text=iPhone+15'],
    2 => ['name' => 'Samsung S24 Ultra', 'price' => 28000000, 'img' => 'https://placehold.co/300x200/png?text=Samsung+S24'],
    3 => ['name' => 'MacBook Air M2', 'price' => 24500000, 'img' => 'https://placehold.co/300x200/png?text=Macbook+Air'],
    4 => ['name' => 'Sony WH-1000XM5', 'price' => 8500000, 'img' => 'https://placehold.co/300x200/png?text=Sony+Headphone'],
    5 => ['name' => 'iPad Air 5', 'price' => 14000000, 'img' => 'https://placehold.co/300x200/png?text=iPad+Air'],
    6 => ['name' => 'Apple Watch S9', 'price' => 10500000, 'img' => 'https://placehold.co/300x200/png?text=Apple+Watch'],
];

// Xử lý thêm vào giỏ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $id = (int)$_POST['id'];
    if (isset($products[$id])) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
        set_flash('success', "Đã thêm <b>{$products[$id]['name']}</b> vào giỏ hàng.");
        // Redirect để tránh resubmit form khi F5
        header('Location: products.php');
        exit();
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Sản phẩm nổi bật</h2>
    <span class="text-muted">Hiển thị <?= count($products) ?> sản phẩm</span>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($products as $id => $p): ?>
    <div class="col">
        <div class="card h-100">
            <img src="<?= $p['img'] ?>" class="card-img-top" alt="<?= $p['name'] ?>">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold"><?= $p['name'] ?></h5>
                <p class="card-text text-danger fs-5 fw-bold"><?= number_format($p['price']) ?> ₫</p>
                <form method="POST" class="mt-auto">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button type="submit" name="add_to_cart" class="btn btn-primary w-100">
                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require_once 'includes/footer.php'; ?>