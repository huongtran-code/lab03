CREATE DATABASE IF NOT EXISTS it3220_php CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE it3220_php;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE, -- Mã SV (duy nhất)
    full_name VARCHAR(100) NOT NULL,  -- Họ tên
    email VARCHAR(100) NOT NULL UNIQUE, -- Email (duy nhất)
    dob DATE NULL,                    -- Ngày sinh
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Thêm dữ liệu mẫu
INSERT INTO students (code, full_name, email, dob) VALUES 
('SV001', 'Nguyễn Văn A', 'a@example.com', '2000-01-01'),
('SV002', 'Trần Thị B', 'b@example.com', '2001-02-02'),
('SV003', 'Lê Văn C', 'c@example.com', '2002-03-03');