<?php
require_once "Student.php";

$studentList = [];
$message = "";
$avg = 0; $max = 0; $min = 0;
$stats = ["Giỏi" => 0, "Khá" => 0, "Trung bình" => 0];

// Dữ liệu mặc định cho form
$rawInput = isset($_POST['data']) ? $_POST['data'] : "SV001-An-3.2;SV002-Binh-2.6;SV003-Chi-3.5;SV004-Dung-3.8";
$threshold = isset($_POST['threshold']) ? floatval($_POST['threshold']) : 0;
$doSort = isset($_POST['sort']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 3. Parse chuỗi
    if (trim($rawInput) !== "") {
        $records = explode(";", $rawInput);
        
        foreach ($records as $rec) {
            $parts = explode("-", trim($rec));
            $parts = array_map('trim', $parts);

            // Validate: đủ 3 phần tử và GPA là số
            if (count($parts) === 3 && is_numeric($parts[2])) {
                $s = new Student($parts[0], $parts[1], $parts[2]);
                
                // 5. Filter theo threshold
                if ($s->getGpa() >= $threshold) {
                    $studentList[] = $s;
                }
            }
        }
    }

    // 4. Kiểm tra danh sách rỗng
    if (empty($studentList)) {
        $message = "Không tìm thấy sinh viên hợp lệ hoặc dữ liệu sai định dạng.";
    } else {
        // 5. Sort nếu được chọn
        if ($doSort) {
            usort($studentList, fn($a, $b) => $b->getGpa() <=> $a->getGpa());
        }

        // 6. Tính thống kê
        $gpas = array_map(fn($s) => $s->getGpa(), $studentList);
        $avg = round(array_sum($gpas) / count($gpas), 2);
        $max = max($gpas);
        $min = min($gpas);

        foreach ($studentList as $s) {
            $stats[$s->rank()]++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Bài 5: Student Manager</title>
    <style>
        .error { color: red; font-weight: bold; }
        .stats { background: #f0f0f0; padding: 10px; margin-top: 10px; }
    </style>
</head>
<body>
    <h2>Student Manager System</h2>
    
    <form method="POST" action="">
        <p>Nhập dữ liệu (ID-Name-GPA, cách nhau bằng dấu chấm phẩy):</p>
        <textarea name="data" rows="4" cols="80"><?php echo htmlspecialchars($rawInput); ?></textarea>
        <br><br>
        
        <label>Lọc GPA >=: </label>
        <input type="number" step="0.1" name="threshold" value="<?php echo $threshold; ?>" style="width: 60px;">
        
        <label style="margin-left: 20px;">
            <input type="checkbox" name="sort" <?php echo $doSort ? "checked" : ""; ?>> Sắp xếp GPA Giảm dần
        </label>
        
        <br><br>
        <button type="submit">Parse & Show</button>
    </form>
    
    <hr>
    
    <?php if ($message): ?>
        <p class="error"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (!empty($studentList)): ?>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <thead>
                <tr style="background: #ddd;">
                    <th>STT</th><th>ID</th><th>Name</th><th>GPA</th><th>Rank</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($studentList as $i => $s): ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo htmlspecialchars($s->getId()); ?></td>
                    <td><?php echo htmlspecialchars($s->getName()); ?></td>
                    <td><?php echo $s->getGpa(); ?></td>
                    <td><?php echo $s->rank(); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="stats">
            <strong>Thống kê:</strong><br>
            - GPA Trung bình: <?php echo $avg; ?><br>
            - Max GPA: <?php echo $max; ?> | Min GPA: <?php echo $min; ?><br>
            - Xếp loại: Giỏi (<?php echo $stats['Giỏi']; ?>), Khá (<?php echo $stats['Khá']; ?>), TB (<?php echo $stats['Trung bình']; ?>)
        </div>
    <?php endif; ?>
</body>
</html>