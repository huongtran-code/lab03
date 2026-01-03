<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 3 - Vòng lặp & Bảng cửu chương</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        /* Style cho bảng cửu chương ma trận */
        table.multiplication-table {
            border-collapse: collapse;
            margin-top: 20px;
        }
        table.multiplication-table th, 
        table.multiplication-table td {
            border: 1px solid #ccc;
            width: 40px;
            height: 40px;
            text-align: center;
        }
        /* Tô màu tiêu đề hàng và cột */
        table.multiplication-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        /* Tô màu ô giao nhau (góc trên trái) */
        .corner {
            background-color: #333 !important;
            color: #fff;
        }
        /* Hiệu ứng hover cho dễ nhìn */
        table.multiplication-table td:hover {
            background-color: #e2e6ea;
            font-weight: bold;
            cursor: default;
        }
    </style>
</head>
<body>

    <a href="index.php">&laquo; Quay lại Index</a>
    <h2>Bài 3: Bảng cửu chương tổng hợp (1 - 9)</h2>
    <p>Dưới đây là bảng nhân dạng ma trận có tiêu đề hàng và cột.</p>

    <table class="multiplication-table">
        <tr>
            <th class="corner">x</th>
            <?php
            // In tiêu đề cột từ 1 đến 9
            for ($col = 1; $col <= 9; $col++) {
                echo "<th>$col</th>";
            }
            ?>
        </tr>

        <?php
        for ($row = 1; $row <= 9; $row++) {
            echo "<tr>";
            
            // Cột tiêu đề của hàng (Header Column)
            echo "<th>$row</th>";
            
            // Các ô dữ liệu phép nhân
            for ($col = 1; $col <= 9; $col++) {
                $result = $row * $col;
                echo "<td>$result</td>";
            }
            
            echo "</tr>";
        }
        ?>
    </table>

    <hr>
    
    <?php
    $n = isset($_GET["n"]) ? (int)$_GET["n"] : 12345;
    ?>
    
    <h3>Demo Loop với n = <?php echo $n; ?> (Sửa URL ?n=...)</h3>
    
    <p><strong>B. Tổng chữ số (While loop):</strong> 
    <?php
    $tempN = abs($n);
    $sum = 0;
    while ($tempN > 0) {
        $sum += $tempN % 10;
        $tempN = (int)($tempN / 10);
    }
    echo $sum;
    ?>
    </p>

    <p><strong>C. Số lẻ từ 1..15 (For loop + Continue/Break):</strong> 
    <?php
    for ($i = 1; $i <= $n; $i++) {
        if ($i % 2 == 0) continue; // Bỏ qua số chẵn
        if ($i > 15) {
            echo " [Dừng vì > 15]";
            break; 
        }
        echo "<span style='border:1px solid #999; padding:2px 5px; margin:2px;'>$i</span>";
    }
    ?>
    </p>

</body>
</html>