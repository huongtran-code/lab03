<?php
require_once 'includes/auth.php';
require_login();
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
    <h1>Chào mừng, <?= htmlspecialchars(current_user()) ?>!</h1>
    <nav>
        <ul>
            <li><a href="products.php">Danh sách sản phẩm</a></li>
            <li><a href="cart.php">Giỏ hàng</a></li>
            <li><a href="logout.php">Đăng xuất</a></li>
        </ul>
    </nav>
</body>
</html>