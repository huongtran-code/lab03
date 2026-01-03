<?php
// Đảm bảo hiển thị tiếng Việt có dấu
header('Content-Type: text/html; charset=utf-8');

$score = isset($_GET["score"]) ? (float)$_GET["score"] : null;

if ($score === null) {
    echo "Hãy truyền tham số điểm lên URL. Ví dụ: <a href='?score=8.5'>?score=8.5</a>";
    exit;
}

echo "<h3>Kết quả xếp loại học tập</h3>";

// Kiểm tra hợp lệ và phân loại
if ($score < 0 || $score > 10) {
    echo "Điểm số không hợp lệ (Phải từ 0 đến 10). Bạn nhập: $score";
} else {
    $xeploai = "";
    
    if ($score >= 8.5) {
        $xeploai = "Giỏi";
    } elseif ($score >= 7.0) {
        $xeploai = "Khá";
    } elseif ($score >= 5.0) {
        $xeploai = "Trung bình";
    } else {
        $xeploai = "Yếu";
    }
    
    echo "Điểm: <strong>$score</strong> – Xếp loại: <strong style='color:red'>$xeploai</strong>";
}
?>