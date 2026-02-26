-- =====================================================
-- ONLINE BOOK STORE - DATABASE DUY NHẤT
-- File này chứa: cấu trúc bảng (PK, FK), dữ liệu mẫu, cấu hình
-- Chạy file này để thiết lập database từ đầu (không cần file .sql khác)
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Tạo database
CREATE DATABASE IF NOT EXISTS `online_book_store_db`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `online_book_store_db`;

-- =====================================================
-- 1. BẢNG ADMIN
-- =====================================================
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tài khoản admin mặc định: admin@admin.com / admin123
INSERT INTO `admin` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$12$Rw75E2E765Derhpcn2z1puTndPoDsfkRUVZz.j/MiI/TTfCpy2yIa');

-- =====================================================
-- 2. BẢNG USERS (Khách hàng)
-- =====================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `balance` decimal(15,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `total_spent` decimal(12,2) DEFAULT '0.00' COMMENT 'Tổng tiền đã mua',
  `membership_level` varchar(20) DEFAULT 'normal' COMMENT 'Hạng thành viên: normal, silver, gold, diamond',
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) DEFAULT NULL,
  `banned_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. BẢNG AUTHORS (Tác giả)
-- =====================================================
DROP TABLE IF EXISTS `authors`;
CREATE TABLE `authors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. BẢNG CATEGORIES (Danh mục)
-- =====================================================
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. BẢNG BOOKS (Sách)
-- =====================================================
DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author_id` int NOT NULL,
  `description` text NOT NULL,
  `category_id` int NOT NULL,
  `cover` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `stock` int DEFAULT '10',
  `price` decimal(10,2) DEFAULT '50000.00',
  `is_new` tinyint DEFAULT '1',
  `is_bestseller` tinyint DEFAULT '0',
  `is_promotion` tinyint DEFAULT '0',
  `discount_percent` int DEFAULT '0',
  `view_count` int DEFAULT '0',
  `review_count` int DEFAULT '0',
  `average_rating` decimal(3,2) DEFAULT '0.00',
  `return_days` int DEFAULT '7',
  `is_rentable` tinyint(1) DEFAULT '0' COMMENT 'Có cho thuê không',
  `rental_price` decimal(10,2) DEFAULT '0.00' COMMENT 'Giá thuê mặc định',
  `rental_duration` int DEFAULT '7' COMMENT 'Số ngày thuê mặc định',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. BẢNG CART (Giỏ hàng)
-- =====================================================
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `promotion_id` int DEFAULT NULL COMMENT 'ID chương trình khuyến mãi khi thêm vào giỏ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 7. BẢNG WISHLIST (Yêu thích)
-- =====================================================
DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. BẢNG ORDERS (Đơn hàng)
-- =====================================================
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `payment_method` enum('balance','cod','online') NOT NULL DEFAULT 'balance',
  `payment_channel` varchar(50) DEFAULT 'balance' COMMENT 'Kênh thanh toán (balance, cod, momo_demo, zalopay_demo, card_demo)',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. BẢNG ORDER_ITEMS (Chi tiết đơn hàng)
-- =====================================================
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `book_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `book_type` varchar(20) DEFAULT 'hardcopy',
  `shipping_address` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 10. BẢNG TRANSACTIONS (Giao dịch tài chính)
-- =====================================================
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 11. BẢNG REVIEWS (Đánh giá sách)
-- =====================================================
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `book_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `comment` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 12. BẢNG RENTALS (Thuê sách)
-- =====================================================
DROP TABLE IF EXISTS `rentals`;
CREATE TABLE `rentals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Giá thuê đã thu',
  `start_date` datetime NOT NULL COMMENT 'Thời gian bắt đầu thuê',
  `end_date` datetime NOT NULL COMMENT 'Thời gian kết thúc thuê',
  `status` enum('active','expired','returned','cancelled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `auto_extend` tinyint(1) DEFAULT '0' COMMENT 'Tự động gia hạn',
  `late_count` int DEFAULT '0' COMMENT 'Số lần trễ hạn',
  `returned_at` datetime DEFAULT NULL COMMENT 'Ngày trả sách',
  `extend_count` int DEFAULT '0' COMMENT 'Số lần gia hạn',
  PRIMARY KEY (`id`),
  KEY `idx_rentals_user` (`user_id`),
  KEY `idx_rentals_book` (`book_id`),
  KEY `idx_rentals_status` (`status`),
  CONSTRAINT `fk_rentals_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_rentals_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 13. BẢNG COUPONS (Mã giảm giá)
-- =====================================================
DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `discount_percent` int NOT NULL,
  `discount_type` enum('percent','freeship') DEFAULT 'percent' COMMENT 'Loại giảm giá',
  `apply_to_promotion_only` tinyint DEFAULT '1',
  `apply_type` varchar(20) DEFAULT 'all' COMMENT 'all, category, book, promotion',
  `apply_to_ids` text COMMENT 'JSON array of category_ids or book_ids',
  `is_active` tinyint DEFAULT '1',
  `usage_limit` int DEFAULT NULL COMMENT 'Số lượt sử dụng tối đa, NULL = vô tận',
  `usage_count` int DEFAULT '0' COMMENT 'Tổng số lượt đã sử dụng',
  `max_usage_per_user` int DEFAULT NULL COMMENT 'Số lần tối đa mỗi user, NULL = vô tận',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 14. BẢNG COUPON_USAGE (Theo dõi sử dụng mã)
-- =====================================================
DROP TABLE IF EXISTS `coupon_usage`;
CREATE TABLE `coupon_usage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `coupon_id` int NOT NULL,
  `user_id` int NOT NULL,
  `usage_count` int DEFAULT '0' COMMENT 'Số lần user này đã dùng mã này',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_coupon_user` (`coupon_id`, `user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `coupon_usage_ibfk_1` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `coupon_usage_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 15. BẢNG PROMOTIONS (Chương trình khuyến mãi)
-- =====================================================
DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Tên chương trình',
  `description` text COMMENT 'Mô tả chương trình',
  `discount_percent` int NOT NULL DEFAULT '0' COMMENT '% giảm giá',
  `start_date` datetime NOT NULL COMMENT 'Ngày bắt đầu',
  `end_date` datetime NOT NULL COMMENT 'Ngày kết thúc',
  `is_active` tinyint(1) DEFAULT '1' COMMENT 'Đang hoạt động',
  `banner_image` varchar(255) DEFAULT NULL COMMENT 'Ảnh banner',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 16. BẢNG PROMOTION_BOOKS (Sách trong khuyến mãi)
-- =====================================================
DROP TABLE IF EXISTS `promotion_books`;
CREATE TABLE `promotion_books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `promotion_id` int NOT NULL,
  `book_id` int NOT NULL,
  `custom_discount_percent` int DEFAULT NULL COMMENT 'Giảm giá riêng cho sách này',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_promo_book` (`promotion_id`, `book_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `promotion_books_ibfk_1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotion_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 17. BẢNG CHAT_MESSAGES (Tin nhắn chat)
-- =====================================================
DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE `chat_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL COMMENT 'ID của user (NULL nếu là admin)',
  `admin_id` int DEFAULT NULL COMMENT 'ID của admin (NULL nếu là user)',
  `message` text NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0' COMMENT '1 = tin nhắn từ admin, 0 = từ user',
  `is_read` tinyint(1) DEFAULT '0' COMMENT 'Đã đọc chưa',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `message_type` varchar(20) DEFAULT 'text' COMMENT 'text hoặc image',
  `image_url` varchar(255) DEFAULT NULL COMMENT 'Đường dẫn ảnh nếu message_type = image',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_admin_id` (`admin_id`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 18. BẢNG CHAT_SESSIONS (Phiên chat)
-- =====================================================
DROP TABLE IF EXISTS `chat_sessions`;
CREATE TABLE `chat_sessions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `status` enum('active','closed') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 19. BẢNG DOWNLOAD_HISTORY (Lịch sử tải sách)
-- =====================================================
DROP TABLE IF EXISTS `download_history`;
CREATE TABLE `download_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `order_id` int NOT NULL,
  `download_count` int DEFAULT '0',
  `max_downloads` int DEFAULT '3',
  `last_download_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `download_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `download_history_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `download_history_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 20. BẢNG SETTINGS (Cấu hình hệ thống)
-- =====================================================
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL COMMENT 'Tên cấu hình',
  `setting_value` text COMMENT 'Giá trị cấu hình',
  `description` varchar(255) DEFAULT NULL COMMENT 'Mô tả',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =====================================================
-- DỮ LIỆU MẪU
-- =====================================================

-- Danh mục sách
INSERT INTO `categories` (`name`) VALUES
('Văn học Việt Nam'),
('Văn học nước ngoài'),
('Tiểu thuyết'),
('Tâm lý - Kỹ năng sống'),
('Kinh tế'),
('Thiếu nhi'),
('Manga - Comic'),
('Khoa học'),
('Lịch sử'),
('Sách giáo khoa');

-- Tác giả
INSERT INTO `authors` (`name`) VALUES
('Nguyễn Nhật Ánh'),
('Paulo Coelho'),
('Dale Carnegie'),
('Nguyễn Ngọc Tư'),
('Haruki Murakami'),
('Robert Kiyosaki'),
('J.K. Rowling'),
('Gosho Aoyama'),
('Yuval Noah Harari'),
('Ngô Bảo Châu');

-- Sách mẫu: Văn học Việt Nam (category_id = 1)
INSERT INTO `books` (`title`, `author_id`, `description`, `category_id`, `cover`, `file`, `price`, `stock`, `is_new`, `is_bestseller`, `is_promotion`, `discount_percent`) VALUES
('Tôi thấy hoa vàng trên cỏ xanh', 1, 'Câu chuyện về tuổi thơ ở miền quê Việt Nam, với những kỷ niệm đẹp và cảm động.', 1, 'toi_thay_hoa_vang.jpg', 'toi_thay_hoa_vang.pdf', 85000, 50, 1, 1, 0, 0),
('Cho tôi xin một vé đi tuổi thơ', 1, 'Hành trình trở về tuổi thơ qua những trang sách đầy cảm xúc.', 1, 'cho_toi_xin_ve.jpg', 'cho_toi_xin_ve.pdf', 90000, 45, 1, 1, 1, 10),
('Mắt biếc', 1, 'Câu chuyện tình yêu đầy cảm động và lãng mạn.', 1, 'mat_biec.jpg', 'mat_biec.pdf', 80000, 40, 0, 1, 0, 0),
('Cô gái đến từ hôm qua', 1, 'Truyện ngắn về tình yêu và cuộc sống.', 1, 'co_gai_hom_qua.jpg', 'co_gai_hom_qua.pdf', 75000, 35, 0, 0, 0, 0),
('Ngồi khóc trên cây', 1, 'Câu chuyện về tình bạn và tình yêu tuổi học trò.', 1, 'ngoi_khoc.jpg', 'ngoi_khoc.pdf', 82000, 42, 1, 0, 1, 15),
('Kính vạn hoa', 1, 'Bộ truyện về những câu chuyện vui nhộn của học sinh.', 1, 'kinh_van_hoa.jpg', 'kinh_van_hoa.pdf', 70000, 38, 0, 0, 0, 0),
('Bảy bước tới mùa hè', 1, 'Hành trình của những đứa trẻ trong mùa hè đầy kỷ niệm.', 1, 'bay_buoc.jpg', 'bay_buoc.pdf', 88000, 48, 1, 1, 0, 0),
('Con chó nhỏ mang giỏ hoa hồng', 1, 'Câu chuyện cảm động về tình bạn giữa con người và động vật.', 1, 'con_cho.jpg', 'con_cho.pdf', 76000, 33, 0, 0, 1, 12),
('Lá nằm trong lá', 1, 'Truyện ngắn về cuộc sống và những điều bình dị.', 1, 'la_nam_trong_la.jpg', 'la_nam_trong_la.pdf', 79000, 36, 0, 0, 0, 0),
('Đảo mộng mơ', 1, 'Câu chuyện về những giấc mơ và khát vọng tuổi trẻ.', 1, 'dao_mong_mo.jpg', 'dao_mong_mo.pdf', 83000, 44, 1, 0, 0, 0);

-- Sách mẫu: Văn học nước ngoài (category_id = 2)
INSERT INTO `books` (`title`, `author_id`, `description`, `category_id`, `cover`, `file`, `price`, `stock`, `is_new`, `is_bestseller`, `is_promotion`, `discount_percent`) VALUES
('Nhà giả kim', 2, 'Hành trình tìm kiếm kho báu và ý nghĩa cuộc sống.', 2, 'nha_gia_kim.jpg', 'nha_gia_kim.pdf', 95000, 60, 1, 1, 0, 0),
('Veronika quyết chết', 2, 'Câu chuyện về cuộc sống và cái chết đầy triết lý.', 2, 'veronika.jpg', 'veronika.pdf', 88000, 55, 1, 1, 1, 10),
('O Alquimista', 2, 'Bản tiếng Bồ Đào Nha của Nhà giả kim.', 2, 'alquimista.jpg', 'alquimista.pdf', 92000, 50, 0, 0, 0, 0),
('Brida', 2, 'Câu chuyện về một phụ nữ tìm kiếm ý nghĩa cuộc sống.', 2, 'brida.jpg', 'brida.pdf', 87000, 48, 0, 0, 0, 0),
('Quỷ dữ và cô bé Prym', 2, 'Tiểu thuyết về thiện và ác trong con người.', 2, 'quy_du.jpg', 'quy_du.pdf', 90000, 52, 1, 0, 1, 15),
('Năm phút', 2, 'Tập truyện ngắn về những khoảnh khắc ý nghĩa.', 2, 'nam_phut.jpg', 'nam_phut.pdf', 85000, 45, 0, 0, 0, 0),
('Những kẻ mộng mơ', 2, 'Câu chuyện về những người theo đuổi giấc mơ.', 2, 'ke_mong_mo.jpg', 'ke_mong_mo.pdf', 93000, 58, 1, 1, 0, 0),
('Hippie', 2, 'Hành trình của một thế hệ tìm kiếm tự do.', 2, 'hippie.jpg', 'hippie.pdf', 89000, 50, 0, 0, 1, 12),
('Aleph', 2, 'Hành trình tâm linh qua không gian và thời gian.', 2, 'aleph.jpg', 'aleph.pdf', 91000, 54, 1, 0, 0, 0),
('Adultery', 2, 'Câu chuyện về sự phản bội và tìm lại chính mình.', 2, 'adultery.jpg', 'adultery.pdf', 86000, 47, 0, 0, 0, 0);

-- Sách mẫu: Tiểu thuyết (category_id = 3)
INSERT INTO `books` (`title`, `author_id`, `description`, `category_id`, `cover`, `file`, `price`, `stock`, `is_new`, `is_bestseller`, `is_promotion`, `discount_percent`) VALUES
('Rừng Na Uy', 5, 'Tiểu thuyết về tuổi trẻ, tình yêu và mất mát.', 3, 'rung_na_uy.jpg', 'rung_na_uy.pdf', 120000, 70, 1, 1, 0, 0),
('Kafka bên bờ biển', 5, 'Câu chuyện kỳ lạ về một cậu bé và những điều bí ẩn.', 3, 'kafka.jpg', 'kafka.pdf', 115000, 65, 1, 1, 1, 10),
('1Q84', 5, 'Tiểu thuyết khoa học viễn tưởng đầy hấp dẫn.', 3, '1q84.jpg', '1q84.pdf', 130000, 75, 1, 1, 0, 0),
('Biên niên ký chim vặn dây cót', 5, 'Câu chuyện về những điều kỳ lạ và bí ẩn.', 3, 'chim_van_day.jpg', 'chim_van_day.pdf', 110000, 60, 0, 0, 0, 0),
('Phía nam biên giới, phía tây mặt trời', 5, 'Tiểu thuyết về tình yêu và ký ức.', 3, 'phia_nam.jpg', 'phia_nam.pdf', 105000, 58, 0, 0, 1, 15),
('Sputnik Sweetheart', 5, 'Câu chuyện về tình yêu và sự cô đơn.', 3, 'sputnik.jpg', 'sputnik.pdf', 108000, 62, 1, 0, 0, 0),
('Nhảy múa, nhảy múa, nhảy múa', 5, 'Tiểu thuyết về cuộc sống đô thị hiện đại.', 3, 'nhay_mua.jpg', 'nhay_mua.pdf', 112000, 68, 0, 1, 0, 0),
('Người tình Sputnik', 5, 'Câu chuyện về những mối quan hệ phức tạp.', 3, 'nguoi_tinh.jpg', 'nguoi_tinh.pdf', 107000, 61, 0, 0, 1, 12),
('Sau nửa đêm', 5, 'Tiểu thuyết về những điều kỳ lạ xảy ra sau nửa đêm.', 3, 'sau_nua_dem.jpg', 'sau_nua_dem.pdf', 109000, 64, 1, 0, 0, 0),
('Lắng nghe gió hát', 5, 'Tiểu thuyết đầu tay của Haruki Murakami.', 3, 'lang_nghe_gio.jpg', 'lang_nghe_gio.pdf', 103000, 56, 0, 0, 0, 0);

-- Sách mẫu: Tâm lý - Kỹ năng sống (category_id = 4)
INSERT INTO `books` (`title`, `author_id`, `description`, `category_id`, `cover`, `file`, `price`, `stock`, `is_new`, `is_bestseller`, `is_promotion`, `discount_percent`) VALUES
('Đắc nhân tâm', 3, 'Nghệ thuật thu phục lòng người và thành công trong cuộc sống.', 4, 'dac_nhan_tam.jpg', 'dac_nhan_tam.pdf', 100000, 80, 1, 1, 0, 0),
('Quẳng gánh lo đi và vui sống', 3, 'Cách vượt qua lo âu và sống hạnh phúc hơn.', 4, 'quang_ganh_lo.jpg', 'quang_ganh_lo.pdf', 95000, 75, 1, 1, 1, 10),
('Nghệ thuật nói trước công chúng', 3, 'Kỹ năng thuyết trình và giao tiếp hiệu quả.', 4, 'nghe_thuat_noi.jpg', 'nghe_thuat_noi.pdf', 90000, 70, 0, 0, 0, 0),
('Làm chủ tư duy thay đổi vận mệnh', 3, 'Cách suy nghĩ tích cực để thay đổi cuộc sống.', 4, 'lam_chu_tu_duy.jpg', 'lam_chu_tu_duy.pdf', 92000, 72, 1, 0, 0, 0),
('Bí quyết thành công', 3, 'Những nguyên tắc vàng để đạt được thành công.', 4, 'bi_quyet_thanh_cong.jpg', 'bi_quyet_thanh_cong.pdf', 88000, 68, 0, 0, 1, 15),
('Nghệ thuật lãnh đạo', 3, 'Kỹ năng lãnh đạo và quản lý hiệu quả.', 4, 'nghe_thuat_lanh_dao.jpg', 'nghe_thuat_lanh_dao.pdf', 93000, 73, 1, 0, 0, 0),
('Cách sống hạnh phúc', 3, 'Bí quyết để có cuộc sống hạnh phúc và ý nghĩa.', 4, 'cach_song_happy.jpg', 'cach_song_happy.pdf', 87000, 67, 0, 0, 0, 0),
('Nghệ thuật giao tiếp', 3, 'Kỹ năng giao tiếp và xây dựng mối quan hệ.', 4, 'nghe_thuat_giao_tiep.jpg', 'nghe_thuat_giao_tiep.pdf', 91000, 71, 0, 1, 0, 0),
('Tự tin và thành công', 3, 'Xây dựng sự tự tin để đạt được thành công.', 4, 'tu_tin_thanh_cong.jpg', 'tu_tin_thanh_cong.pdf', 89000, 69, 1, 0, 1, 12),
('Nghệ thuật thuyết phục', 3, 'Cách thuyết phục người khác một cách hiệu quả.', 4, 'nghe_thuat_thuyet_phuc.jpg', 'nghe_thuat_thuyet_phuc.pdf', 94000, 74, 0, 0, 0, 0);

-- Sách mẫu: Kinh tế (category_id = 5)
INSERT INTO `books` (`title`, `author_id`, `description`, `category_id`, `cover`, `file`, `price`, `stock`, `is_new`, `is_bestseller`, `is_promotion`, `discount_percent`) VALUES
('Cha giàu cha nghèo', 6, 'Bài học về tài chính và đầu tư từ hai người cha.', 5, 'cha_giau.jpg', 'cha_giau.pdf', 110000, 85, 1, 1, 0, 0),
('Dạy con làm giàu', 6, 'Hướng dẫn về tài chính và đầu tư cho thế hệ trẻ.', 5, 'day_con_lam_giau.jpg', 'day_con_lam_giau.pdf', 105000, 80, 1, 1, 1, 10),
('Nhà đầu tư thông minh', 6, 'Chiến lược đầu tư thông minh và hiệu quả.', 5, 'nha_dau_tu.jpg', 'nha_dau_tu.pdf', 100000, 75, 0, 0, 0, 0),
('Tại sao người giàu ngày càng giàu', 6, 'Bí mật của những người giàu có.', 5, 'tai_sao_giau.jpg', 'tai_sao_giau.pdf', 108000, 82, 1, 0, 0, 0),
('Cách kiếm tiền của người giàu', 6, 'Phương pháp kiếm tiền và quản lý tài chính.', 5, 'cach_kiem_tien.jpg', 'cach_kiem_tien.pdf', 102000, 77, 0, 0, 1, 15),
('Đầu tư bất động sản', 6, 'Hướng dẫn đầu tư bất động sản hiệu quả.', 5, 'dau_tu_bds.jpg', 'dau_tu_bds.pdf', 107000, 81, 1, 0, 0, 0),
('Tự do tài chính', 6, 'Con đường dẫn đến tự do tài chính.', 5, 'tu_do_tai_chinh.jpg', 'tu_do_tai_chinh.pdf', 104000, 78, 0, 0, 0, 0),
('Quản lý tiền bạc', 6, 'Kỹ năng quản lý tài chính cá nhân.', 5, 'quan_ly_tien.jpg', 'quan_ly_tien.pdf', 101000, 76, 0, 1, 0, 0),
('Đầu tư cổ phiếu', 6, 'Hướng dẫn đầu tư chứng khoán cho người mới.', 5, 'dau_tu_co_phieu.jpg', 'dau_tu_co_phieu.pdf', 106000, 80, 1, 0, 1, 12),
('Tư duy triệu phú', 6, 'Cách suy nghĩ của những người thành công.', 5, 'tu_duy_trieu_phu.jpg', 'tu_duy_trieu_phu.pdf', 103000, 79, 0, 0, 0, 0);

-- Sách mẫu: Thiếu nhi (category_id = 6)
INSERT INTO `books` (`title`, `author_id`, `description`, `category_id`, `cover`, `file`, `price`, `stock`, `is_new`, `is_bestseller`, `is_promotion`, `discount_percent`) VALUES
('Harry Potter và Hòn đá phù thủy', 7, 'Câu chuyện về cậu bé phù thủy và cuộc phiêu lưu kỳ diệu.', 6, 'hp1.jpg', 'hp1.pdf', 150000, 100, 1, 1, 0, 0),
('Harry Potter và Phòng chứa bí mật', 7, 'Cuộc phiêu lưu tiếp theo của Harry Potter.', 6, 'hp2.jpg', 'hp2.pdf', 145000, 95, 1, 1, 1, 10),
('Harry Potter và Tù nhân Azkaban', 7, 'Harry gặp lại người cha đỡ đầu.', 6, 'hp3.jpg', 'hp3.pdf', 148000, 98, 1, 1, 0, 0),
('Harry Potter và Chiếc cốc lửa', 7, 'Giải đấu Tam Pháp Thuật đầy nguy hiểm.', 6, 'hp4.jpg', 'hp4.pdf', 152000, 102, 1, 1, 0, 0),
('Harry Potter và Hội Phượng Hoàng', 7, 'Cuộc chiến chống lại Chúa tể Voldemort.', 6, 'hp5.jpg', 'hp5.pdf', 147000, 97, 0, 0, 1, 15),
('Harry Potter và Hoàng tử lai', 7, 'Bí mật về quá khứ của Voldemort.', 6, 'hp6.jpg', 'hp6.pdf', 149000, 99, 1, 0, 0, 0),
('Harry Potter và Bảo bối Tử thần', 7, 'Trận chiến cuối cùng với Voldemort.', 6, 'hp7.jpg', 'hp7.pdf', 151000, 101, 1, 1, 0, 0),
('Fantastic Beasts', 7, 'Câu chuyện về thế giới phù thủy trước thời Harry Potter.', 6, 'fantastic.jpg', 'fantastic.pdf', 144000, 94, 0, 0, 0, 0),
('Quidditch Through the Ages', 7, 'Hướng dẫn về môn thể thao phù thủy.', 6, 'quidditch.jpg', 'quidditch.pdf', 143000, 93, 0, 0, 1, 12),
('The Tales of Beedle the Bard', 7, 'Những câu chuyện cổ tích trong thế giới phù thủy.', 6, 'beedle.jpg', 'beedle.pdf', 146000, 96, 1, 0, 0, 0);

-- Sách mẫu: Manga - Comic (category_id = 7)
INSERT INTO `books` (`title`, `author_id`, `description`, `category_id`, `cover`, `file`, `price`, `stock`, `is_new`, `is_bestseller`, `is_promotion`, `discount_percent`) VALUES
('Thám tử lừng danh Conan - Tập 1', 8, 'Câu chuyện về thám tử nhí Conan và những vụ án ly kỳ.', 7, 'conan1.jpg', 'conan1.pdf', 35000, 200, 1, 1, 0, 0),
('Thám tử lừng danh Conan - Tập 2', 8, 'Tiếp tục những vụ án hấp dẫn của Conan.', 7, 'conan2.jpg', 'conan2.pdf', 35000, 195, 1, 1, 1, 10),
('Thám tử lừng danh Conan - Tập 3', 8, 'Những vụ án mới đầy thử thách.', 7, 'conan3.jpg', 'conan3.pdf', 35000, 190, 1, 0, 0, 0),
('Thám tử lừng danh Conan - Tập 4', 8, 'Cuộc chiến với tổ chức đen.', 7, 'conan4.jpg', 'conan4.pdf', 35000, 185, 0, 0, 0, 0),
('Thám tử lừng danh Conan - Tập 5', 8, 'Những manh mối quan trọng được tiết lộ.', 7, 'conan5.jpg', 'conan5.pdf', 35000, 180, 1, 0, 1, 15),
('Thám tử lừng danh Conan - Tập 6', 8, 'Vụ án liên quan đến quá khứ.', 7, 'conan6.jpg', 'conan6.pdf', 35000, 175, 0, 0, 0, 0),
('Thám tử lừng danh Conan - Tập 7', 8, 'Cuộc đối đầu với kẻ thù nguy hiểm.', 7, 'conan7.jpg', 'conan7.pdf', 35000, 170, 1, 1, 0, 0),
('Thám tử lừng danh Conan - Tập 8', 8, 'Bí mật về thuốc teo nhỏ.', 7, 'conan8.jpg', 'conan8.pdf', 35000, 165, 0, 0, 1, 12),
('Thám tử lừng danh Conan - Tập 9', 8, 'Những đồng minh mới xuất hiện.', 7, 'conan9.jpg', 'conan9.pdf', 35000, 160, 1, 0, 0, 0),
('Thám tử lừng danh Conan - Tập 10', 8, 'Trận chiến cuối cùng sắp đến.', 7, 'conan10.jpg', 'conan10.pdf', 35000, 155, 0, 0, 0, 0);

-- Sách mẫu: Khoa học (category_id = 8)
INSERT INTO `books` (`title`, `author_id`, `description`, `category_id`, `cover`, `file`, `price`, `stock`, `is_new`, `is_bestseller`, `is_promotion`, `discount_percent`) VALUES
('Sapiens: Lược sử loài người', 9, 'Lịch sử tiến hóa của loài người.', 8, 'sapiens.jpg', 'sapiens.pdf', 180000, 90, 1, 1, 0, 0),
('Homo Deus: Lược sử tương lai', 9, 'Dự đoán về tương lai của loài người.', 8, 'homo_deus.jpg', 'homo_deus.pdf', 175000, 85, 1, 1, 1, 10),
('21 bài học cho thế kỷ 21', 9, 'Những thách thức và cơ hội của thế kỷ 21.', 8, '21_bai_hoc.jpg', '21_bai_hoc.pdf', 170000, 80, 1, 0, 0, 0),
('Lược sử thời gian', 9, 'Khám phá về vũ trụ và thời gian.', 8, 'luoc_su_thoi_gian.jpg', 'luoc_su_thoi_gian.pdf', 165000, 75, 0, 0, 0, 0),
('Vũ trụ trong vỏ hạt dẻ', 9, 'Giải thích về vật lý lượng tử và vũ trụ.', 8, 'vu_tru.jpg', 'vu_tru.pdf', 172000, 82, 1, 0, 1, 15),
('Lược sử vũ trụ', 9, 'Câu chuyện về sự hình thành của vũ trụ.', 8, 'luoc_su_vu_tru.jpg', 'luoc_su_vu_tru.pdf', 168000, 78, 0, 0, 0, 0),
('Trí tuệ nhân tạo', 9, 'Tương lai của AI và tác động đến nhân loại.', 8, 'tri_tue_nhan_tao.jpg', 'tri_tue_nhan_tao.pdf', 174000, 83, 1, 1, 0, 0),
('Sinh học và tiến hóa', 9, 'Khám phá về sự sống và tiến hóa.', 8, 'sinh_hoc.jpg', 'sinh_hoc.pdf', 169000, 79, 0, 0, 1, 12),
('Khoa học và tôn giáo', 9, 'Mối quan hệ giữa khoa học và tôn giáo.', 8, 'khoa_hoc_ton_giao.jpg', 'khoa_hoc_ton_giao.pdf', 171000, 81, 1, 0, 0, 0),
('Tương lai của nhân loại', 9, 'Dự đoán về tương lai của loài người.', 8, 'tuong_lai.jpg', 'tuong_lai.pdf', 167000, 77, 0, 0, 0, 0);

-- Sách mẫu: Lịch sử (category_id = 9)
INSERT INTO `books` (`title`, `author_id`, `description`, `category_id`, `cover`, `file`, `price`, `stock`, `is_new`, `is_bestseller`, `is_promotion`, `discount_percent`) VALUES
('Lịch sử Việt Nam', 10, 'Tổng quan về lịch sử Việt Nam từ cổ đại đến hiện đại.', 9, 'lich_su_vn.jpg', 'lich_su_vn.pdf', 140000, 70, 1, 1, 0, 0),
('Các triều đại Việt Nam', 10, 'Lịch sử các triều đại phong kiến Việt Nam.', 9, 'trieu_dai.jpg', 'trieu_dai.pdf', 135000, 65, 1, 1, 1, 10),
('Chiến tranh Việt Nam', 10, 'Lịch sử cuộc chiến tranh chống Mỹ.', 9, 'chien_tranh.jpg', 'chien_tranh.pdf', 138000, 68, 1, 0, 0, 0),
('Văn hóa Việt Nam', 10, 'Khám phá văn hóa truyền thống Việt Nam.', 9, 'van_hoa.jpg', 'van_hoa.pdf', 132000, 63, 0, 0, 0, 0),
('Đại Việt sử ký', 10, 'Bộ sử ký quan trọng của Việt Nam.', 9, 'dai_viet.jpg', 'dai_viet.pdf', 137000, 67, 1, 0, 1, 15),
('Lịch sử thế giới', 10, 'Tổng quan lịch sử thế giới.', 9, 'lich_su_tg.jpg', 'lich_su_tg.pdf', 136000, 66, 0, 0, 0, 0),
('Cách mạng tháng Tám', 10, 'Lịch sử cuộc cách mạng giành độc lập.', 9, 'cm_thang_tam.jpg', 'cm_thang_tam.pdf', 134000, 64, 0, 1, 0, 0),
('Hồ Chí Minh - Tiểu sử', 10, 'Cuộc đời và sự nghiệp của Chủ tịch Hồ Chí Minh.', 9, 'ho_chi_minh.jpg', 'ho_chi_minh.pdf', 139000, 69, 1, 0, 1, 12),
('Lịch sử Đảng Cộng sản', 10, 'Lịch sử hình thành và phát triển của Đảng.', 9, 'lich_su_dang.jpg', 'lich_su_dang.pdf', 133000, 62, 0, 0, 0, 0),
('Di tích lịch sử Việt Nam', 10, 'Khám phá các di tích lịch sử quan trọng.', 9, 'di_tich.jpg', 'di_tich.pdf', 141000, 71, 1, 0, 0, 0);

-- Sách mẫu: Sách giáo khoa (category_id = 10)
INSERT INTO `books` (`title`, `author_id`, `description`, `category_id`, `cover`, `file`, `price`, `stock`, `is_new`, `is_bestseller`, `is_promotion`, `discount_percent`) VALUES
('Toán học lớp 10', 10, 'Sách giáo khoa Toán học lớp 10 chương trình mới.', 10, 'toan_10.jpg', 'toan_10.pdf', 50000, 500, 1, 1, 0, 0),
('Văn học lớp 10', 10, 'Sách giáo khoa Ngữ văn lớp 10.', 10, 'van_10.jpg', 'van_10.pdf', 48000, 480, 1, 1, 1, 10),
('Vật lý lớp 10', 10, 'Sách giáo khoa Vật lý lớp 10.', 10, 'vat_ly_10.jpg', 'vat_ly_10.pdf', 49000, 490, 1, 0, 0, 0),
('Hóa học lớp 10', 10, 'Sách giáo khoa Hóa học lớp 10.', 10, 'hoa_10.jpg', 'hoa_10.pdf', 47000, 470, 0, 0, 0, 0),
('Sinh học lớp 10', 10, 'Sách giáo khoa Sinh học lớp 10.', 10, 'sinh_10.jpg', 'sinh_10.pdf', 51000, 510, 1, 0, 1, 15),
('Lịch sử lớp 10', 10, 'Sách giáo khoa Lịch sử lớp 10.', 10, 'su_10.jpg', 'su_10.pdf', 46000, 460, 0, 0, 0, 0),
('Địa lý lớp 10', 10, 'Sách giáo khoa Địa lý lớp 10.', 10, 'dia_10.jpg', 'dia_10.pdf', 52000, 520, 1, 1, 0, 0),
('Tiếng Anh lớp 10', 10, 'Sách giáo khoa Tiếng Anh lớp 10.', 10, 'anh_10.jpg', 'anh_10.pdf', 55000, 550, 0, 0, 1, 12),
('GDCD lớp 10', 10, 'Sách giáo khoa Giáo dục công dân lớp 10.', 10, 'gdcd_10.jpg', 'gdcd_10.pdf', 45000, 450, 1, 0, 0, 0),
('Tin học lớp 10', 10, 'Sách giáo khoa Tin học lớp 10.', 10, 'tin_10.jpg', 'tin_10.pdf', 53000, 530, 0, 0, 0, 0);

-- Cấu hình hệ thống
INSERT INTO `settings` (`setting_key`, `setting_value`, `description`) VALUES
('cod_fee_percent', '2', 'Phí COD (% giá trị đơn hàng sau giảm giá)'),
('momo_qr_url', 'uploads/qr/momo_qr.jpeg', 'URL ảnh QR thanh toán MoMo (demo)'),
('zalopay_qr_url', 'uploads/qr/zalopay_qr.jpeg', 'URL ảnh QR thanh toán ZaloPay (demo)'),
('rental_auto_extend', '1', 'Tự động gia hạn thuê sách'),
('rental_max_late', '1', 'Số lần trễ hạn tối đa'),
('rental_late_fee_percent', '100', 'Phí phạt trễ hạn (%)');

-- Mã giảm giá mẫu
INSERT INTO `coupons` (`code`, `description`, `discount_percent`, `discount_type`, `apply_type`, `usage_limit`, `is_active`) VALUES
('SALE10', 'Giảm 10% giá trị đơn hàng', 10, 'percent', 'all', NULL, 1),
('FREESHIP', 'Miễn phí vận chuyển', 0, 'freeship', 'all', NULL, 1);

-- User mẫu (mật khẩu: admin123)
INSERT INTO `users` (`full_name`, `email`, `password`, `phone`, `balance`) VALUES
('Nguyễn Văn A', 'user1@gmail.com', '$2y$12$Rw75E2E765Derhpcn2z1puTndPoDsfkRUVZz.j/MiI/TTfCpy2yIa', '0901234567', 500000),
('Trần Thị B', 'user2@gmail.com', '$2y$12$Rw75E2E765Derhpcn2z1puTndPoDsfkRUVZz.j/MiI/TTfCpy2yIa', '0912345678', 300000),
('Lê Văn C', 'user3@gmail.com', '$2y$12$Rw75E2E765Derhpcn2z1puTndPoDsfkRUVZz.j/MiI/TTfCpy2yIa', '0923456789', 1000000);

-- =====================================================
-- BỔ SUNG KHÓA NGOẠI (FK) CÒN THIẾU
-- =====================================================
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_author` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_books_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cart_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cart_promotion` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wishlist_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_items_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transactions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `chat_sessions`
  ADD CONSTRAINT `fk_chat_sessions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- =====================================================
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
-- =====================================================
-- HOÀN TẤT! Database đã sẵn sàng sử dụng.
-- Tài khoản Admin: admin@admin.com / admin123
-- Tài khoản User mẫu: user1@gmail.com / admin123
-- =====================================================
