<?php
require_once 'includes/auth.php';
require_once 'includes/flash.php';

if (is_logged_in()) header('Location: products.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if (login($username, $password)) {
        header('Location: products.php');
        exit();
    } else {
        $error = "Sai thông tin đăng nhập!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - TechStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #eef2f7; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 100%; max-width: 400px; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="card login-card bg-white">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">TechStore</h3>
            <p class="text-muted">Đăng nhập để mua sắm</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="u" name="username" placeholder="name" required>
                <label for="u">Tên đăng nhập</label>
            </div>
            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="p" name="password" placeholder="Pass" required>
                <label for="p">Mật khẩu</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">ĐĂNG NHẬP</button>
            <div class="text-center mt-3">
                <small class="text-muted">admin / 123456</small><br>
                <small class="text-muted">user1 / 123456</small><br>
                <small class="text-muted">student / password</small>
            </div>
        </form>
    </div>
</body>
</html>