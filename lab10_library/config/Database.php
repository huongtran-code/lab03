<?php
class Database {
    // Thông số cấu hình Database
    // Nếu dùng XAMPP mặc định: user='root', pass=''
    // Nếu dùng MAMP: user='root', pass='root'
    private static $host = 'localhost';
    private static $db_name = 'lab10_library';
    private static $username = 'root'; 
    private static $password = ''; 
    
    public static $conn = null;

    /**
     * Phương thức lấy kết nối (Singleton pattern)
     * Giúp không phải khởi tạo lại kết nối nhiều lần
     */
    public static function getConnection() {
        if (self::$conn === null) {
            try {
                // Chuỗi kết nối DSN
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4";
                
                // Các tùy chọn quan trọng
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Báo lỗi dạng Exception để dễ bắt lỗi (Try-Catch)
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Mặc định trả về mảng kết hợp
                    PDO::ATTR_EMULATE_PREPARES => false, // Sử dụng Prepare Statement thực của MySQL (An toàn hơn)
                ];

                self::$conn = new PDO($dsn, self::$username, self::$password, $options);
                
            } catch(PDOException $exception) {
                // Xử lý lỗi kết nối
                echo "Lỗi kết nối CSDL: " . $exception->getMessage();
                exit();
            }
        }
        return self::$conn;
    }
}
?>