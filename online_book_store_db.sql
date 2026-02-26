-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 07:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_book_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$12$Rw75E2E765Derhpcn2z1puTndPoDsfkRUVZz.j/MiI/TTfCpy2yIa');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`) VALUES
(1, 'Nguyễn Nhật Ánh'),
(2, 'Paulo Coelho'),
(3, 'Dale Carnegie'),
(4, 'Nguyễn Ngọc Tư'),
(5, 'Haruki Murakami'),
(6, 'Robert Kiyosaki'),
(7, 'J.K. Rowling'),
(8, 'Gosho Aoyama'),
(9, 'Yuval Noah Harari'),
(10, 'Ngô Bảo Châu');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `stock` int(11) DEFAULT 10,
  `price` decimal(10,2) DEFAULT 50000.00,
  `is_new` tinyint(4) DEFAULT 1,
  `is_bestseller` tinyint(4) DEFAULT 0,
  `is_promotion` tinyint(4) DEFAULT 0,
  `discount_percent` int(11) DEFAULT 0,
  `view_count` int(11) DEFAULT 0,
  `review_count` int(11) DEFAULT 0,
  `average_rating` decimal(3,2) DEFAULT 0.00,
  `return_days` int(11) DEFAULT 7,
  `is_rentable` tinyint(1) DEFAULT 0 COMMENT 'Có cho thuê không',
  `rental_price` decimal(10,2) DEFAULT 0.00 COMMENT 'Giá thuê mặc định',
  `rental_duration` int(11) DEFAULT 7 COMMENT 'Số ngày thuê mặc định'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author_id`, `description`, `category_id`, `cover`, `file`, `stock`, `price`, `is_new`, `is_bestseller`, `is_promotion`, `discount_percent`, `view_count`, `review_count`, `average_rating`, `return_days`, `is_rentable`, `rental_price`, `rental_duration`) VALUES
(1, 'Tôi thấy hoa vàng trên cỏ xanh', 1, 'Câu chuyện về tuổi thơ ở miền quê Việt Nam, với những kỷ niệm đẹp và cảm động.', 1, 'toi_thay_hoa_vang.jpg', 'toi_thay_hoa_vang.pdf', 50, 85000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(2, 'Cho tôi xin một vé đi tuổi thơ', 1, 'Hành trình trở về tuổi thơ qua những trang sách đầy cảm xúc.', 1, 'cho_toi_xin_ve.jpg', 'cho_toi_xin_ve.pdf', 45, 90000.00, 1, 1, 1, 10, 0, 0, 0.00, 7, 0, 0.00, 7),
(3, 'Mắt biếc', 1, 'Câu chuyện tình yêu đầy cảm động và lãng mạn.', 1, 'mat_biec.jpg', 'mat_biec.pdf', 40, 80000.00, 0, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(4, 'Cô gái đến từ hôm qua', 1, 'Truyện ngắn về tình yêu và cuộc sống.', 1, 'co_gai_hom_qua.jpg', 'co_gai_hom_qua.pdf', 35, 75000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(5, 'Ngồi khóc trên cây', 1, 'Câu chuyện về tình bạn và tình yêu tuổi học trò.', 1, 'ngoi_khoc.jpg', 'ngoi_khoc.pdf', 42, 82000.00, 1, 0, 1, 15, 0, 0, 0.00, 7, 0, 0.00, 7),
(6, 'Kính vạn hoa', 1, 'Bộ truyện về những câu chuyện vui nhộn của học sinh.', 1, 'kinh_van_hoa.jpg', 'kinh_van_hoa.pdf', 38, 70000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(7, 'Bảy bước tới mùa hè', 1, 'Hành trình của những đứa trẻ trong mùa hè đầy kỷ niệm.', 1, 'bay_buoc.jpg', 'bay_buoc.pdf', 48, 88000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(8, 'Con chó nhỏ mang giỏ hoa hồng', 1, 'Câu chuyện cảm động về tình bạn giữa con người và động vật.', 1, 'con_cho.jpg', 'con_cho.pdf', 33, 76000.00, 0, 0, 1, 12, 0, 0, 0.00, 7, 0, 0.00, 7),
(9, 'Lá nằm trong lá', 1, 'Truyện ngắn về cuộc sống và những điều bình dị.', 1, 'la_nam_trong_la.jpg', 'la_nam_trong_la.pdf', 36, 79000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(10, 'Đảo mộng mơ', 1, 'Câu chuyện về những giấc mơ và khát vọng tuổi trẻ.', 1, 'dao_mong_mo.jpg', 'dao_mong_mo.pdf', 44, 83000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(11, 'Nhà giả kim', 2, 'Hành trình tìm kiếm kho báu và ý nghĩa cuộc sống.', 2, 'nha_gia_kim.jpg', 'nha_gia_kim.pdf', 60, 95000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(12, 'Veronika quyết chết', 2, 'Câu chuyện về cuộc sống và cái chết đầy triết lý.', 2, 'veronika.jpg', 'veronika.pdf', 55, 88000.00, 1, 1, 1, 10, 0, 0, 0.00, 7, 0, 0.00, 7),
(13, 'O Alquimista', 2, 'Bản tiếng Bồ Đào Nha của Nhà giả kim.', 2, 'alquimista.jpg', 'alquimista.pdf', 50, 92000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(14, 'Brida', 2, 'Câu chuyện về một phụ nữ tìm kiếm ý nghĩa cuộc sống.', 2, 'brida.jpg', 'brida.pdf', 48, 87000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(15, 'Quỷ dữ và cô bé Prym', 2, 'Tiểu thuyết về thiện và ác trong con người.', 2, 'quy_du.jpg', 'quy_du.pdf', 51, 90000.00, 1, 0, 1, 15, 0, 0, 0.00, 7, 0, 0.00, 7),
(16, 'Năm phút', 2, 'Tập truyện ngắn về những khoảnh khắc ý nghĩa.', 2, 'nam_phut.jpg', 'nam_phut.pdf', 45, 85000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(17, 'Những kẻ mộng mơ', 2, 'Câu chuyện về những người theo đuổi giấc mơ.', 2, 'ke_mong_mo.jpg', 'ke_mong_mo.pdf', 58, 93000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(18, 'Hippie', 2, 'Hành trình của một thế hệ tìm kiếm tự do.', 2, 'hippie.jpg', 'hippie.pdf', 50, 89000.00, 0, 0, 1, 12, 0, 0, 0.00, 7, 0, 0.00, 7),
(19, 'Aleph', 2, 'Hành trình tâm linh qua không gian và thời gian.', 2, 'aleph.jpg', 'aleph.pdf', 54, 91000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(20, 'Adultery', 2, 'Câu chuyện về sự phản bội và tìm lại chính mình.', 2, 'adultery.jpg', 'adultery.pdf', 47, 86000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(21, 'Rừng Na Uy', 5, 'Tiểu thuyết về tuổi trẻ, tình yêu và mất mát.', 3, 'rung_na_uy.jpg', 'rung_na_uy.pdf', 70, 120000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(22, 'Kafka bên bờ biển', 5, 'Câu chuyện kỳ lạ về một cậu bé và những điều bí ẩn.', 3, 'kafka.jpg', 'kafka.pdf', 65, 115000.00, 1, 1, 1, 10, 0, 0, 0.00, 7, 0, 0.00, 7),
(23, '1Q84', 5, 'Tiểu thuyết khoa học viễn tưởng đầy hấp dẫn.', 3, '1q84.jpg', '1q84.pdf', 75, 130000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(24, 'Biên niên ký chim vặn dây cót', 5, 'Câu chuyện về những điều kỳ lạ và bí ẩn.', 3, 'chim_van_day.jpg', 'chim_van_day.pdf', 60, 110000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(25, 'Phía nam biên giới, phía tây mặt trời', 5, 'Tiểu thuyết về tình yêu và ký ức.', 3, 'phia_nam.jpg', 'phia_nam.pdf', 58, 105000.00, 0, 0, 1, 15, 0, 0, 0.00, 7, 0, 0.00, 7),
(26, 'Sputnik Sweetheart', 5, 'Câu chuyện về tình yêu và sự cô đơn.', 3, 'sputnik.jpg', 'sputnik.pdf', 62, 108000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(27, 'Nhảy múa, nhảy múa, nhảy múa', 5, 'Tiểu thuyết về cuộc sống đô thị hiện đại.', 3, 'nhay_mua.jpg', 'nhay_mua.pdf', 68, 112000.00, 0, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(28, 'Người tình Sputnik', 5, 'Câu chuyện về những mối quan hệ phức tạp.', 3, 'nguoi_tinh.jpg', 'nguoi_tinh.pdf', 61, 107000.00, 0, 0, 1, 12, 0, 0, 0.00, 7, 0, 0.00, 7),
(29, 'Sau nửa đêm', 5, 'Tiểu thuyết về những điều kỳ lạ xảy ra sau nửa đêm.', 3, 'sau_nua_dem.jpg', 'sau_nua_dem.pdf', 64, 109000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(30, 'Lắng nghe gió hát', 5, 'Tiểu thuyết đầu tay của Haruki Murakami.', 3, 'lang_nghe_gio.jpg', 'lang_nghe_gio.pdf', 56, 103000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(31, 'Đắc nhân tâm', 3, 'Nghệ thuật thu phục lòng người và thành công trong cuộc sống.', 4, 'dac_nhan_tam.jpg', 'dac_nhan_tam.pdf', 80, 100000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(32, 'Quẳng gánh lo đi và vui sống', 3, 'Cách vượt qua lo âu và sống hạnh phúc hơn.', 4, 'quang_ganh_lo.jpg', 'quang_ganh_lo.pdf', 75, 95000.00, 1, 1, 1, 10, 0, 0, 0.00, 7, 0, 0.00, 7),
(33, 'Nghệ thuật nói trước công chúng', 3, 'Kỹ năng thuyết trình và giao tiếp hiệu quả.', 4, 'nghe_thuat_noi.jpg', 'nghe_thuat_noi.pdf', 70, 90000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(34, 'Làm chủ tư duy thay đổi vận mệnh', 3, 'Cách suy nghĩ tích cực để thay đổi cuộc sống.', 4, 'lam_chu_tu_duy.jpg', 'lam_chu_tu_duy.pdf', 72, 92000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(35, 'Bí quyết thành công', 3, 'Những nguyên tắc vàng để đạt được thành công.', 4, 'bi_quyet_thanh_cong.jpg', 'bi_quyet_thanh_cong.pdf', 68, 88000.00, 0, 0, 1, 15, 0, 0, 0.00, 7, 0, 0.00, 7),
(36, 'Nghệ thuật lãnh đạo', 3, 'Kỹ năng lãnh đạo và quản lý hiệu quả.', 4, 'nghe_thuat_lanh_dao.jpg', 'nghe_thuat_lanh_dao.pdf', 73, 93000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(37, 'Cách sống hạnh phúc', 3, 'Bí quyết để có cuộc sống hạnh phúc và ý nghĩa.', 4, 'cach_song_happy.jpg', 'cach_song_happy.pdf', 66, 87000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(38, 'Nghệ thuật giao tiếp', 3, 'Kỹ năng giao tiếp và xây dựng mối quan hệ.', 4, 'nghe_thuat_giao_tiep.jpg', 'nghe_thuat_giao_tiep.pdf', 71, 91000.00, 0, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(39, 'Tự tin và thành công', 3, 'Xây dựng sự tự tin để đạt được thành công.', 4, 'tu_tin_thanh_cong.jpg', 'tu_tin_thanh_cong.pdf', 69, 89000.00, 1, 0, 1, 12, 0, 0, 0.00, 7, 0, 0.00, 7),
(40, 'Nghệ thuật thuyết phục', 3, 'Cách thuyết phục người khác một cách hiệu quả.', 4, 'nghe_thuat_thuyet_phuc.jpg', 'nghe_thuat_thuyet_phuc.pdf', 74, 94000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(41, 'Cha giàu cha nghèo', 6, 'Bài học về tài chính và đầu tư từ hai người cha.', 5, 'cha_giau.jpg', 'cha_giau.pdf', 85, 110000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(42, 'Dạy con làm giàu', 6, 'Hướng dẫn về tài chính và đầu tư cho thế hệ trẻ.', 5, 'day_con_lam_giau.jpg', 'day_con_lam_giau.pdf', 80, 105000.00, 1, 1, 1, 10, 0, 0, 0.00, 7, 0, 0.00, 7),
(43, 'Nhà đầu tư thông minh', 6, 'Chiến lược đầu tư thông minh và hiệu quả.', 5, 'nha_dau_tu.jpg', 'nha_dau_tu.pdf', 75, 100000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(44, 'Tại sao người giàu ngày càng giàu', 6, 'Bí mật của những người giàu có.', 5, 'tai_sao_giau.jpg', 'tai_sao_giau.pdf', 82, 108000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(45, 'Cách kiếm tiền của người giàu', 6, 'Phương pháp kiếm tiền và quản lý tài chính.', 5, 'cach_kiem_tien.jpg', 'cach_kiem_tien.pdf', 77, 102000.00, 0, 0, 1, 15, 0, 0, 0.00, 7, 0, 0.00, 7),
(46, 'Đầu tư bất động sản', 6, 'Hướng dẫn đầu tư bất động sản hiệu quả.', 5, 'dau_tu_bds.jpg', 'dau_tu_bds.pdf', 81, 107000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(47, 'Tự do tài chính', 6, 'Con đường dẫn đến tự do tài chính.', 5, 'tu_do_tai_chinh.jpg', 'tu_do_tai_chinh.pdf', 78, 104000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(48, 'Quản lý tiền bạc', 6, 'Kỹ năng quản lý tài chính cá nhân.', 5, 'quan_ly_tien.jpg', 'quan_ly_tien.pdf', 76, 101000.00, 0, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(49, 'Đầu tư cổ phiếu', 6, 'Hướng dẫn đầu tư chứng khoán cho người mới.', 5, 'dau_tu_co_phieu.jpg', 'dau_tu_co_phieu.pdf', 80, 106000.00, 1, 0, 1, 12, 0, 0, 0.00, 7, 0, 0.00, 7),
(50, 'Tư duy triệu phú', 6, 'Cách suy nghĩ của những người thành công.', 5, 'tu_duy_trieu_phu.jpg', 'tu_duy_trieu_phu.pdf', 79, 103000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(51, 'Harry Potter và Hòn đá phù thủy', 7, 'Câu chuyện về cậu bé phù thủy và cuộc phiêu lưu kỳ diệu.', 6, 'hp1.jpg', 'hp1.pdf', 100, 150000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(52, 'Harry Potter và Phòng chứa bí mật', 7, 'Cuộc phiêu lưu tiếp theo của Harry Potter.', 6, 'hp2.jpg', 'hp2.pdf', 95, 145000.00, 1, 1, 1, 10, 0, 0, 0.00, 7, 0, 0.00, 7),
(53, 'Harry Potter và Tù nhân Azkaban', 7, 'Harry gặp lại người cha đỡ đầu.', 6, 'hp3.jpg', 'hp3.pdf', 98, 148000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(54, 'Harry Potter và Chiếc cốc lửa', 7, 'Giải đấu Tam Pháp Thuật đầy nguy hiểm.', 6, 'hp4.jpg', 'hp4.pdf', 102, 152000.00, 1, 1, 0, 0, 2, 0, 0.00, 7, 0, 0.00, 7),
(55, 'Harry Potter và Hội Phượng Hoàng', 7, 'Cuộc chiến chống lại Chúa tể Voldemort.', 6, 'hp5.jpg', 'hp5.pdf', 97, 147000.00, 0, 0, 1, 15, 0, 0, 0.00, 7, 0, 0.00, 7),
(56, 'Harry Potter và Hoàng tử lai', 7, 'Bí mật về quá khứ của Voldemort.', 6, 'hp6.jpg', 'hp6.pdf', 99, 149000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(57, 'Harry Potter và Bảo bối Tử thần', 7, 'Trận chiến cuối cùng với Voldemort.', 6, 'hp7.jpg', 'hp7.pdf', 101, 151000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(58, 'Fantastic Beasts', 7, 'Câu chuyện về thế giới phù thủy trước thời Harry Potter.', 6, 'fantastic.jpg', 'fantastic.pdf', 94, 144000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(59, 'Quidditch Through the Ages', 7, 'Hướng dẫn về môn thể thao phù thủy.', 6, 'quidditch.jpg', 'quidditch.pdf', 93, 143000.00, 0, 0, 1, 12, 0, 0, 0.00, 7, 0, 0.00, 7),
(60, 'The Tales of Beedle the Bard', 7, 'Những câu chuyện cổ tích trong thế giới phù thủy.', 6, 'beedle.jpg', 'beedle.pdf', 96, 146000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(61, 'Thám tử lừng danh Conan - Tập 1', 8, 'Câu chuyện về thám tử nhí Conan và những vụ án ly kỳ.', 7, 'conan1.jpg', 'conan1.pdf', 200, 35000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(62, 'Thám tử lừng danh Conan - Tập 2', 8, 'Tiếp tục những vụ án hấp dẫn của Conan.', 7, 'conan2.jpg', 'conan2.pdf', 195, 35000.00, 1, 1, 1, 10, 0, 0, 0.00, 7, 0, 0.00, 7),
(63, 'Thám tử lừng danh Conan - Tập 3', 8, 'Những vụ án mới đầy thử thách.', 7, 'conan3.jpg', 'conan3.pdf', 190, 35000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(64, 'Thám tử lừng danh Conan - Tập 4', 8, 'Cuộc chiến với tổ chức đen.', 7, 'conan4.jpg', 'conan4.pdf', 185, 35000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(65, 'Thám tử lừng danh Conan - Tập 5', 8, 'Những manh mối quan trọng được tiết lộ.', 7, 'conan5.jpg', 'conan5.pdf', 180, 35000.00, 1, 0, 1, 15, 0, 0, 0.00, 7, 0, 0.00, 7),
(66, 'Thám tử lừng danh Conan - Tập 6', 8, 'Vụ án liên quan đến quá khứ.', 7, 'conan6.jpg', 'conan6.pdf', 175, 35000.00, 0, 0, 0, 0, 1, 0, 0.00, 7, 0, 0.00, 7),
(67, 'Thám tử lừng danh Conan - Tập 7', 8, 'Cuộc đối đầu với kẻ thù nguy hiểm.', 7, 'conan7.jpg', 'conan7.pdf', 170, 35000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(68, 'Thám tử lừng danh Conan - Tập 8', 8, 'Bí mật về thuốc teo nhỏ.', 7, 'conan8.jpg', 'conan8.pdf', 165, 35000.00, 0, 0, 1, 12, 0, 0, 0.00, 7, 0, 0.00, 7),
(69, 'Thám tử lừng danh Conan - Tập 9', 8, 'Những đồng minh mới xuất hiện.', 7, 'conan9.jpg', 'conan9.pdf', 160, 35000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(70, 'Thám tử lừng danh Conan - Tập 10', 8, 'Trận chiến cuối cùng sắp đến.', 7, 'conan10.jpg', 'conan10.pdf', 155, 35000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(71, 'Sapiens: Lược sử loài người', 9, 'Lịch sử tiến hóa của loài người.', 8, 'sapiens.jpg', 'sapiens.pdf', 90, 180000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(72, 'Homo Deus: Lược sử tương lai', 9, 'Dự đoán về tương lai của loài người.', 8, 'homo_deus.jpg', 'homo_deus.pdf', 85, 175000.00, 1, 1, 1, 10, 0, 0, 0.00, 7, 0, 0.00, 7),
(73, '21 bài học cho thế kỷ 21', 9, 'Những thách thức và cơ hội của thế kỷ 21.', 8, '21_bai_hoc.jpg', '21_bai_hoc.pdf', 80, 170000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(74, 'Lược sử thời gian', 9, 'Khám phá về vũ trụ và thời gian.', 8, 'luoc_su_thoi_gian.jpg', 'luoc_su_thoi_gian.pdf', 75, 165000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(75, 'Vũ trụ trong vỏ hạt dẻ', 9, 'Giải thích về vật lý lượng tử và vũ trụ.', 8, 'vu_tru.jpg', 'vu_tru.pdf', 82, 172000.00, 1, 0, 1, 15, 0, 0, 0.00, 7, 0, 0.00, 7),
(76, 'Lược sử vũ trụ', 9, 'Câu chuyện về sự hình thành của vũ trụ.', 8, 'luoc_su_vu_tru.jpg', 'luoc_su_vu_tru.pdf', 78, 168000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(77, 'Trí tuệ nhân tạo', 9, 'Tương lai của AI và tác động đến nhân loại.', 8, 'tri_tue_nhan_tao.jpg', 'tri_tue_nhan_tao.pdf', 83, 174000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(78, 'Sinh học và tiến hóa', 9, 'Khám phá về sự sống và tiến hóa.', 8, 'sinh_hoc.jpg', 'sinh_hoc.pdf', 79, 169000.00, 0, 0, 1, 12, 0, 0, 0.00, 7, 0, 0.00, 7),
(79, 'Khoa học và tôn giáo', 9, 'Mối quan hệ giữa khoa học và tôn giáo.', 8, 'khoa_hoc_ton_giao.jpg', 'khoa_hoc_ton_giao.pdf', 81, 171000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(80, 'Tương lai của nhân loại', 9, 'Dự đoán về tương lai của loài người.', 8, 'tuong_lai.jpg', 'tuong_lai.pdf', 77, 167000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(81, 'Lịch sử Việt Nam', 10, 'Tổng quan về lịch sử Việt Nam từ cổ đại đến hiện đại.', 9, 'lich_su_vn.jpg', 'lich_su_vn.pdf', 70, 140000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(82, 'Các triều đại Việt Nam', 10, 'Lịch sử các triều đại phong kiến Việt Nam.', 9, 'trieu_dai.jpg', 'trieu_dai.pdf', 65, 135000.00, 1, 1, 1, 10, 0, 0, 0.00, 7, 0, 0.00, 7),
(83, 'Chiến tranh Việt Nam', 10, 'Lịch sử cuộc chiến tranh chống Mỹ.', 9, 'chien_tranh.jpg', 'chien_tranh.pdf', 68, 138000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(84, 'Văn hóa Việt Nam', 10, 'Khám phá văn hóa truyền thống Việt Nam.', 9, 'van_hoa.jpg', 'van_hoa.pdf', 63, 132000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(85, 'Đại Việt sử ký', 10, 'Bộ sử ký quan trọng của Việt Nam.', 9, 'dai_viet.jpg', 'dai_viet.pdf', 67, 137000.00, 1, 0, 1, 15, 0, 0, 0.00, 7, 0, 0.00, 7),
(86, 'Lịch sử thế giới', 10, 'Tổng quan lịch sử thế giới.', 9, 'lich_su_tg.jpg', 'lich_su_tg.pdf', 66, 136000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(87, 'Cách mạng tháng Tám', 10, 'Lịch sử cuộc cách mạng giành độc lập.', 9, 'cm_thang_tam.jpg', 'cm_thang_tam.pdf', 64, 134000.00, 0, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(88, 'Hồ Chí Minh - Tiểu sử', 10, 'Cuộc đời và sự nghiệp của Chủ tịch Hồ Chí Minh.', 9, 'ho_chi_minh.jpg', 'ho_chi_minh.pdf', 69, 139000.00, 1, 0, 1, 12, 0, 0, 0.00, 7, 0, 0.00, 7),
(89, 'Lịch sử Đảng Cộng sản', 10, 'Lịch sử hình thành và phát triển của Đảng.', 9, 'lich_su_dang.jpg', 'lich_su_dang.pdf', 62, 133000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(90, 'Di tích lịch sử Việt Nam', 10, 'Khám phá các di tích lịch sử quan trọng.', 9, 'di_tich.jpg', 'di_tich.pdf', 71, 141000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(91, 'Toán học lớp 10', 10, 'Sách giáo khoa Toán học lớp 10 chương trình mới.', 10, 'toan_10.jpg', 'toan_10.pdf', 500, 50000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(92, 'Văn học lớp 10', 10, 'Sách giáo khoa Ngữ văn lớp 10.', 10, 'van_10.jpg', 'van_10.pdf', 480, 48000.00, 1, 1, 1, 10, 0, 0, 0.00, 7, 0, 0.00, 7),
(93, 'Vật lý lớp 10', 10, 'Sách giáo khoa Vật lý lớp 10.', 10, 'vat_ly_10.jpg', 'vat_ly_10.pdf', 490, 49000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(94, 'Hóa học lớp 10', 10, 'Sách giáo khoa Hóa học lớp 10.', 10, 'hoa_10.jpg', 'hoa_10.pdf', 470, 47000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(95, 'Sinh học lớp 10', 10, 'Sách giáo khoa Sinh học lớp 10.', 10, 'sinh_10.jpg', 'sinh_10.pdf', 510, 51000.00, 1, 0, 1, 15, 0, 0, 0.00, 7, 0, 0.00, 7),
(96, 'Lịch sử lớp 10', 10, 'Sách giáo khoa Lịch sử lớp 10.', 10, 'su_10.jpg', 'su_10.pdf', 460, 46000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(97, 'Địa lý lớp 10', 10, 'Sách giáo khoa Địa lý lớp 10.', 10, 'dia_10.jpg', 'dia_10.pdf', 520, 52000.00, 1, 1, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(98, 'Tiếng Anh lớp 10', 10, 'Sách giáo khoa Tiếng Anh lớp 10.', 10, 'anh_10.jpg', 'anh_10.pdf', 550, 55000.00, 0, 0, 1, 12, 0, 0, 0.00, 7, 0, 0.00, 7),
(99, 'GDCD lớp 10', 10, 'Sách giáo khoa Giáo dục công dân lớp 10.', 10, 'gdcd_10.jpg', 'gdcd_10.pdf', 450, 45000.00, 1, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7),
(100, 'Tin học lớp 10', 10, 'Sách giáo khoa Tin học lớp 10.', 10, 'tin_10.jpg', 'tin_10.pdf', 530, 53000.00, 0, 0, 0, 0, 0, 0, 0.00, 7, 0, 0.00, 7);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `promotion_id` int(11) DEFAULT NULL COMMENT 'ID chương trình khuyến mãi khi thêm vào giỏ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Văn học Việt Nam'),
(2, 'Văn học nước ngoài'),
(3, 'Tiểu thuyết'),
(4, 'Tâm lý - Kỹ năng sống'),
(5, 'Kinh tế'),
(6, 'Thiếu nhi'),
(7, 'Manga - Comic'),
(8, 'Khoa học'),
(9, 'Lịch sử'),
(10, 'Sách giáo khoa');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'ID của user (NULL nếu là admin)',
  `admin_id` int(11) DEFAULT NULL COMMENT 'ID của admin (NULL nếu là user)',
  `message` text NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0 COMMENT '1 = tin nhắn từ admin, 0 = từ user',
  `is_read` tinyint(1) DEFAULT 0 COMMENT 'Đã đọc chưa',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `message_type` varchar(20) DEFAULT 'text' COMMENT 'text hoặc image',
  `image_url` varchar(255) DEFAULT NULL COMMENT 'Đường dẫn ảnh nếu message_type = image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `admin_id`, `message`, `is_admin`, `is_read`, `created_at`, `message_type`, `image_url`) VALUES
(1, 1, NULL, 'hello', 0, 1, '2026-02-24 09:54:31', 'text', NULL),
(2, 1, 1, 'xin chào!', 1, 0, '2026-02-24 09:55:09', 'text', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chat_sessions`
--

CREATE TABLE `chat_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('active','closed') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `discount_percent` int(11) NOT NULL,
  `discount_type` enum('percent','freeship') DEFAULT 'percent' COMMENT 'Loại giảm giá',
  `apply_to_promotion_only` tinyint(4) DEFAULT 1,
  `apply_type` varchar(20) DEFAULT 'all' COMMENT 'all, category, book, promotion',
  `apply_to_ids` text DEFAULT NULL COMMENT 'JSON array of category_ids or book_ids',
  `is_active` tinyint(4) DEFAULT 1,
  `usage_limit` int(11) DEFAULT NULL COMMENT 'Số lượt sử dụng tối đa, NULL = vô tận',
  `usage_count` int(11) DEFAULT 0 COMMENT 'Tổng số lượt đã sử dụng',
  `max_usage_per_user` int(11) DEFAULT NULL COMMENT 'Số lần tối đa mỗi user, NULL = vô tận',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `description`, `discount_percent`, `discount_type`, `apply_to_promotion_only`, `apply_type`, `apply_to_ids`, `is_active`, `usage_limit`, `usage_count`, `max_usage_per_user`, `created_at`, `expires_at`) VALUES
(1, 'SALE10', 'Giảm 10% giá trị đơn hàng', 10, 'percent', 1, 'all', NULL, 1, NULL, 1, NULL, '2026-02-23 16:45:12', NULL),
(2, 'FREESHIP', 'Miễn phí vận chuyển', 0, 'freeship', 1, 'all', NULL, 1, NULL, 0, NULL, '2026-02-23 16:45:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usage`
--

CREATE TABLE `coupon_usage` (
  `id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `usage_count` int(11) DEFAULT 0 COMMENT 'Số lần user này đã dùng mã này',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupon_usage`
--

INSERT INTO `coupon_usage` (`id`, `coupon_id`, `user_id`, `usage_count`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 1, '2026-02-24 11:06:54', '2026-02-24 11:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `download_history`
--

CREATE TABLE `download_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `download_count` int(11) DEFAULT 0,
  `max_downloads` int(11) DEFAULT 3,
  `last_download_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `download_history`
--

INSERT INTO `download_history` (`id`, `user_id`, `book_id`, `order_id`, `download_count`, `max_downloads`, `last_download_at`, `created_at`) VALUES
(1, 1, 66, 1, 0, 3, NULL, '2026-02-24 09:03:31'),
(2, 1, 43, 2, 0, 3, NULL, '2026-02-24 09:50:52'),
(3, 5, 59, 3, 0, 3, NULL, '2026-02-24 10:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `payment_method` enum('balance','cod','online') NOT NULL DEFAULT 'balance',
  `payment_channel` varchar(50) DEFAULT 'balance' COMMENT 'Kênh thanh toán (balance, cod, momo_demo, zalopay_demo, card_demo)',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `payment_method`, `payment_channel`, `created_at`) VALUES
(1, 1, 35000.00, 'completed', 'balance', 'balance', '2026-02-24 09:03:31'),
(2, 1, 100000.00, 'completed', 'balance', 'balance', '2026-02-24 09:50:52'),
(3, 5, 113256.00, 'completed', 'balance', 'balance', '2026-02-24 10:57:15'),
(4, 5, 108740.00, 'completed', 'cod', 'balance', '2026-02-24 11:03:58'),
(5, 5, 88850.00, 'completed', 'balance', 'balance', '2026-02-24 11:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `book_type` varchar(20) DEFAULT 'hardcopy',
  `shipping_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `book_id`, `quantity`, `price`, `book_type`, `shipping_address`) VALUES
(1, 1, 66, 1, 35000.00, 'pdf', NULL),
(2, 2, 43, 1, 100000.00, 'pdf', NULL),
(3, 3, 59, 1, 125840.00, 'pdf', NULL),
(4, 4, 37, 1, 87000.00, 'hardcopy', 'ngõ 109 doãn kế thiện, Phường Mỹ Đình 1, Quận Nam Từ Liêm, Thành phố Hà Nội'),
(5, 5, 15, 1, 76500.00, 'hardcopy', 'ngõ 109 doãn kế thiện, Phường Mỹ Đình 1, Quận Nam Từ Liêm, Thành phố Hà Nội');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Tên chương trình',
  `description` text DEFAULT NULL COMMENT 'Mô tả chương trình',
  `discount_percent` int(11) NOT NULL DEFAULT 0 COMMENT '% giảm giá',
  `start_date` datetime NOT NULL COMMENT 'Ngày bắt đầu',
  `end_date` datetime NOT NULL COMMENT 'Ngày kết thúc',
  `is_active` tinyint(1) DEFAULT 1 COMMENT 'Đang hoạt động',
  `banner_image` varchar(255) DEFAULT NULL COMMENT 'Ảnh banner',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_books`
--

CREATE TABLE `promotion_books` (
  `id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `custom_discount_percent` int(11) DEFAULT NULL COMMENT 'Giảm giá riêng cho sách này',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Giá thuê đã thu',
  `start_date` datetime NOT NULL COMMENT 'Thời gian bắt đầu thuê',
  `end_date` datetime NOT NULL COMMENT 'Thời gian kết thúc thuê',
  `status` enum('active','expired','returned','cancelled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `auto_extend` tinyint(1) DEFAULT 0 COMMENT 'Tự động gia hạn',
  `late_count` int(11) DEFAULT 0 COMMENT 'Số lần trễ hạn',
  `returned_at` datetime DEFAULT NULL COMMENT 'Ngày trả sách',
  `extend_count` int(11) DEFAULT 0 COMMENT 'Số lần gia hạn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL COMMENT 'Tên cấu hình',
  `setting_value` text DEFAULT NULL COMMENT 'Giá trị cấu hình',
  `description` varchar(255) DEFAULT NULL COMMENT 'Mô tả',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `created_at`, `updated_at`) VALUES
(1, 'cod_fee_percent', '2', 'Phí COD (% giá trị đơn hàng sau giảm giá)', '2026-02-23 16:45:12', '2026-02-23 16:45:12'),
(2, 'momo_qr_url', 'uploads/qr/momo_qr.jpeg', 'URL ảnh QR thanh toán MoMo (demo)', '2026-02-23 16:45:12', '2026-02-23 16:45:12'),
(3, 'zalopay_qr_url', 'uploads/qr/zalopay_qr.jpeg', 'URL ảnh QR thanh toán ZaloPay (demo)', '2026-02-23 16:45:12', '2026-02-23 16:45:12'),
(4, 'rental_auto_extend', '1', 'Tự động gia hạn thuê sách', '2026-02-23 16:45:12', '2026-02-23 16:45:12'),
(5, 'rental_max_late', '1', 'Số lần trễ hạn tối đa', '2026-02-23 16:45:12', '2026-02-23 16:45:12'),
(6, 'rental_late_fee_percent', '100', 'Phí phạt trễ hạn (%)', '2026-02-23 16:45:12', '2026-02-23 16:45:12');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `type`, `amount`, `description`, `created_at`) VALUES
(1, 1, 'purchase', 35000.00, 'Thanh toán đơn hàng #1', '2026-02-24 09:03:31'),
(2, NULL, 'revenue_order', 35000.00, 'Đơn hàng #1', '2026-02-24 09:03:31'),
(3, 1, 'purchase', 100000.00, 'Thanh toán đơn hàng #2', '2026-02-24 09:50:52'),
(4, NULL, 'revenue_order', 100000.00, 'Đơn hàng #2', '2026-02-24 09:50:52'),
(5, 5, 'deposit', 10000000000.00, '', '2026-02-24 09:57:36'),
(6, 5, 'purchase', 113256.00, 'Thanh toán đơn hàng #3', '2026-02-24 10:57:15'),
(7, NULL, 'revenue_order', 113256.00, 'Đơn hàng #3 (giảm 10% từ hạng Kim cương)', '2026-02-24 10:57:15'),
(8, NULL, 'revenue_order', 108740.00, 'Đơn hàng #4 (bao gồm phí ship 21.740đ) (COD - Đã thanh toán)', '2026-02-24 11:04:49'),
(9, 5, 'purchase', 88850.00, 'Thanh toán đơn hàng #5', '2026-02-24 11:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `total_spent` decimal(12,2) DEFAULT 0.00 COMMENT 'Tổng tiền đã mua',
  `membership_level` varchar(20) DEFAULT 'normal' COMMENT 'Hạng thành viên: normal, silver, gold, diamond',
  `is_banned` tinyint(1) NOT NULL DEFAULT 0,
  `ban_reason` varchar(255) DEFAULT NULL,
  `banned_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `address`, `balance`, `created_at`, `reset_token`, `reset_token_expires`, `total_spent`, `membership_level`, `is_banned`, `ban_reason`, `banned_at`) VALUES
(1, 'Nguyễn Văn A', 'user1@gmail.com', '$2y$12$Rw75E2E765Derhpcn2z1puTndPoDsfkRUVZz.j/MiI/TTfCpy2yIa', '0901234567', NULL, 365000.00, '2026-02-23 16:45:12', NULL, NULL, 135000.00, 'normal', 0, NULL, NULL),
(2, 'Trần Thị B', 'user2@gmail.com', '$2y$12$Rw75E2E765Derhpcn2z1puTndPoDsfkRUVZz.j/MiI/TTfCpy2yIa', '0912345678', NULL, 300000.00, '2026-02-23 16:45:12', NULL, NULL, 0.00, 'normal', 0, NULL, NULL),
(3, 'Lê Văn C', 'user3@gmail.com', '$2y$12$Rw75E2E765Derhpcn2z1puTndPoDsfkRUVZz.j/MiI/TTfCpy2yIa', '0923456789', NULL, 1000000.00, '2026-02-23 16:45:12', NULL, NULL, 0.00, 'normal', 0, NULL, NULL),
(5, 'Phạm Thị T', 'T123@gmail.com', '$2y$10$fOB7vkdaW6yZt3/MWmUwluJqYZpGt3FBaDi6rAa2heXOwaohF0WDS', '0523979936', NULL, 9999797894.00, '2026-02-24 09:11:53', NULL, NULL, 276756.00, 'normal', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_books_author` (`author_id`),
  ADD KEY `fk_books_category` (`category_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_user` (`user_id`),
  ADD KEY `fk_cart_book` (`book_id`),
  ADD KEY `fk_cart_promotion` (`promotion_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_admin_id` (`admin_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_chat_sessions_user` (`user_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `coupon_usage`
--
ALTER TABLE `coupon_usage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_coupon_user` (`coupon_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `download_history`
--
ALTER TABLE `download_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_user` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_items_order` (`order_id`),
  ADD KEY `fk_order_items_book` (`book_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotion_books`
--
ALTER TABLE `promotion_books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_promo_book` (`promotion_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rentals_user` (`user_id`),
  ADD KEY `idx_rentals_book` (`book_id`),
  ADD KEY `idx_rentals_status` (`status`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reviews_book` (`book_id`),
  ADD KEY `fk_reviews_user` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transactions_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_wishlist_user` (`user_id`),
  ADD KEY `fk_wishlist_book` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupon_usage`
--
ALTER TABLE `coupon_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `download_history`
--
ALTER TABLE `download_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotion_books`
--
ALTER TABLE `promotion_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_author` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_books_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cart_promotion` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD CONSTRAINT `fk_chat_sessions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `coupon_usage`
--
ALTER TABLE `coupon_usage`
  ADD CONSTRAINT `coupon_usage_ibfk_1` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usage_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `download_history`
--
ALTER TABLE `download_history`
  ADD CONSTRAINT `download_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `download_history_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `download_history_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promotion_books`
--
ALTER TABLE `promotion_books`
  ADD CONSTRAINT `promotion_books_ibfk_1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promotion_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `fk_rentals_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rentals_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transactions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
