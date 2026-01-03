<?php
header('Content-Type: text/html; charset=utf-8');

$a = (float)($_GET["a"] ?? 0);
$b = (float)($_GET["b"] ?? 0);
$op = $_GET["op"] ?? "add"; // Các giá trị: add, sub, mul, div

echo "<h3>Máy tính Mini (Switch-Case)</h3>";
echo "Input: a = $a, b = $b, op = $op <br><br>";

$result = 0;
$symbol = "";

switch ($op) {
    case 'add':
        $result = $a + $b;
        $symbol = "+";
        echo "$a $symbol $b = <strong>$result</strong>";
        break;

    case 'sub':
        $result = $a - $b;
        $symbol = "-";
        echo "$a $symbol $b = <strong>$result</strong>";
        break;

    case 'mul':
        $result = $a * $b;
        $symbol = "*";
        echo "$a $symbol $b = <strong>$result</strong>";
        break;

    case 'div':
        $symbol = "/";
        if ($b == 0) {
            echo "Lỗi: <strong>Không thể chia cho 0</strong>";
        } else {
            $result = $a / $b;
            echo "$a $symbol $b = <strong>$result</strong>";
        }
        break;

    default:
        echo "Phép toán không hợp lệ (chỉ hỗ trợ add, sub, mul, div).";
        break;
}
?>