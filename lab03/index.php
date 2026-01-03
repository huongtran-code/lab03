<?php
// --- PHẦN 1: XỬ LÝ LOGIC (CONTROLLER) ---
require_once "functions.php";

// Khởi tạo giá trị mặc định
$a = $_POST['a'] ?? 0;
$b = $_POST['b'] ?? 0;
$n = $_POST['n'] ?? 0;
$action = $_POST['action'] ?? '';
$resultMessage = "";

// Chỉ xử lý khi người dùng nhấn nút "Thực hiện" (Submit form)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($action) {
        case 'max':
            $val = max2($a, $b);
            $resultMessage = "Max($a, $b) = <strong>$val</strong>";
            break;
        case 'min':
            $val = min2($a, $b);
            $resultMessage = "Min($a, $b) = <strong>$val</strong>";
            break;
        case 'prime':
            $check = isPrime((int)$n) ? "là số nguyên tố" : "không phải số nguyên tố";
            $resultMessage = "Số $n $check";
            break;
        case 'fact':
            $val = factorial((int)$n);
            $resultMessage = ($val === null) ? "Không tính giai thừa số âm" : "$n! = <strong>$val</strong>";
            break;
        case 'gcd':
            $val = gcd((int)$a, (int)$b);
            $resultMessage = "Ước chung lớn nhất của $a và $b là: <strong>$val</strong>";
            break;
        default:
            $resultMessage = "Vui lòng chọn một chức năng.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lab 03 - Index & Form</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 20px auto; line-height: 1.5; }
        .form-container { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 100px; font-weight: bold; }
        input[type="number"], select { padding: 5px; width: 200px; }
        button { padding: 8px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .result-box { margin-top: 20px; padding: 15px; background: #e3f2fd; border-left: 5px solid #2196f3; }
        .links { margin-bottom: 20px; text-align: center; }
        .links a { margin: 0 10px; color: #333; }
    </style>
</head>
<body>

    <div class="links">
        <a href="bai1_grade.php">Bài 1 (Điểm)</a> |
        <a href="bai2_calc.php">Bài 2 (Máy tính)</a> |
        <a href="bai3_loops.php">Bài 3 (Vòng lặp)</a>
    </div>

    <h2>Tiện ích Toán học (Functions)</h2>

    <div class="form-container">
        <form method="POST" action="">
            <div class="form-group">
                <label>Nhập a:</label>
                <input type="number" name="a" value="<?php echo htmlspecialchars($a); ?>">
            </div>
            <div class="form-group">
                <label>Nhập b:</label>
                <input type="number" name="b" value="<?php echo htmlspecialchars($b); ?>">
            </div>
            <div class="form-group">
                <label>Nhập n:</label>
                <input type="number" name="n" value="<?php echo htmlspecialchars($n); ?>">
                <small>(Dùng cho Prime/Factorial)</small>
            </div>
            <div class="form-group">
                <label>Chức năng:</label>
                <select name="action">
                    <option value="">-- Chọn chức năng --</option>
                    <option value="max" <?php if($action=='max') echo 'selected'; ?>>Tìm Max (a, b)</option>
                    <option value="min" <?php if($action=='min') echo 'selected'; ?>>Tìm Min (a, b)</option>
                    <option value="prime" <?php if($action=='prime') echo 'selected'; ?>>Kiểm tra Nguyên tố (n)</option>
                    <option value="fact" <?php if($action=='fact') echo 'selected'; ?>>Tính Giai thừa (n)</option>
                    <option value="gcd" <?php if($action=='gcd') echo 'selected'; ?>>Tìm UCLN (a, b)</option>
                </select>
            </div>
            <button type="submit">Thực hiện</button>
        </form>
    </div>

    <?php if ($resultMessage): ?>
        <div class="result-box">
            Kết quả: <?php echo $resultMessage; ?>
        </div>
    <?php endif; ?>

</body>
</html>