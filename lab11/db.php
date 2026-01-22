<?php
// db.php
$host = 'localhost';
$dbname = 'php_crud_topic1'; // Thay tên DB của bạn vào đây
$username = 'root';          // Thay user của bạn (mặc định XAMPP là root)
$password = '';              // Thay password của bạn (mặc định XAMPP là rỗng)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Cấu hình chế độ lỗi để ném Exception khi gặp lỗi SQL
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Cấu hình default fetch mode là mảng kết hợp
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}
?>