<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'auth.php';
$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.05); transition: 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .navbar-brand { font-weight: bold; color: #0d6efd !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="products.php"><i class="bi bi-shop"></i> TechStore</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php if (is_logged_in()): ?>
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="products.php">Sản phẩm</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <a href="cart.php" class="btn btn-outline-primary position-relative">
                    <i class="bi bi-cart3"></i> Giỏ hàng
                    <?php if($cart_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $cart_count ?>
                    </span>
                    <?php endif; ?>
                </a>
                <div class="dropdown">
                    <a class="btn btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> <?= htmlspecialchars(current_user()) ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mt-4 mb-5">
    <?php 
    require_once 'flash.php';
    if ($msg = get_flash('success')) echo '<div class="alert alert-success alert-dismissible fade show"> <i class="bi bi-check-circle-fill"></i> '.$msg.' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($msg = get_flash('error')) echo '<div class="alert alert-danger alert-dismissible fade show"> <i class="bi bi-exclamation-triangle-fill"></i> '.$msg.' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    if ($msg = get_flash('info')) echo '<div class="alert alert-info alert-dismissible fade show"> <i class="bi bi-info-circle-fill"></i> '.$msg.' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    ?>