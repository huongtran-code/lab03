<?php
// 1. Khai báo mảng điểm
$scores = [8.5, 7.0, 9.25, 6.5, 8.0, 8.0];

// 2. Tính trung bình
$total = array_sum($scores);
$count = count($scores);
$avg = $count > 0 ? round($total / $count, 2) : 0;

// 3. Đếm và liệt kê điểm >= 8.0
$goodScores = array_filter($scores, fn($s) => $s >= 8.0);

// 4. Tìm Max, Min
$maxScore = max($scores);
$minScore = min($scores);

// 5. Sắp xếp (Copy mảng để không mất mảng gốc)
$ascScores = $scores;
sort($ascScores); // Tăng dần

$descScores = $scores;
rsort($descScores); // Giảm dần
?>

<!DOCTYPE html>
<html lang="vi">
<head><title>Bài 2: Thống kê điểm</title></head>
<body>
    <h3>Thống kê mảng điểm</h3>
    
    <p><strong>Mảng gốc:</strong> [<?php echo implode(', ', $scores); ?>]</p>
    
    <ul>
        <li>Điểm trung bình: <strong><?php echo number_format($avg, 2); ?></strong></li>
        <li>Điểm cao nhất: <strong><?php echo $maxScore; ?></strong></li>
        <li>Điểm thấp nhất: <strong><?php echo $minScore; ?></strong></li>
        <li>
            Số lượng điểm >= 8.0: <strong><?php echo count($goodScores); ?></strong> 
            (Danh sách: <?php echo implode(', ', $goodScores); ?>)
        </li>
    </ul>

    <h4>Danh sách sau khi sắp xếp:</h4>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Tăng dần</th>
            <th>Giảm dần</th>
        </tr>
        <tr>
            <td valign="top"><?php echo implode('<br>', $ascScores); ?></td>
            <td valign="top"><?php echo implode('<br>', $descScores); ?></td>
        </tr>
    </table>
</body>
</html>