<?php
require_once "Student.php";

// 3. Tạo danh sách 5 sinh viên
$students = [
    new Student("SV001", "Nguyễn Văn An", 3.5),
    new Student("SV002", "Trần Thị Binh", 2.0),
    new Student("SV003", "Lê Chi", 3.9),
    new Student("SV004", "Phạm Dũng", 2.8),
    new Student("SV005", "Hoàng Em", 3.2),
];

// Tính toán thống kê
$gpas = array_map(fn($s) => $s->getGpa(), $students);
$avgGpa = count($gpas) > 0 ? array_sum($gpas) / count($gpas) : 0;

// Thống kê theo Rank
$stats = ["Giỏi" => 0, "Khá" => 0, "Trung bình" => 0];
foreach ($students as $s) {
    $r = $s->rank();
    if (isset($stats[$r])) {
        $stats[$r]++;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head><title>Bài 4: OOP Student</title></head>
<body>
    <h3>Danh sách Sinh viên (OOP)</h3>
    <table border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>STT</th><th>ID</th><th>Name</th><th>GPA</th><th>Rank</th>
        </tr>
        <?php foreach ($students as $i => $s): ?>
        <tr>
            <td><?php echo $i + 1; ?></td>
            <td><?php echo htmlspecialchars($s->getId()); ?></td>
            <td><?php echo htmlspecialchars($s->getName()); ?></td>
            <td><?php echo $s->getGpa(); ?></td>
            <td><?php echo $s->rank(); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h4>Thống kê:</h4>
    <ul>
        <li>GPA Trung bình lớp: <?php echo number_format($avgGpa, 2); ?></li>
        <li>Số lượng Giỏi: <?php echo $stats["Giỏi"]; ?></li>
        <li>Số lượng Khá: <?php echo $stats["Khá"]; ?></li>
        <li>Số lượng Trung bình: <?php echo $stats["Trung bình"]; ?></li>
    </ul>
</body>
</html>