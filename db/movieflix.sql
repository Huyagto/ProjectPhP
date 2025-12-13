-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2025 at 02:14 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movieflix`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE IF NOT EXISTS `authors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `bio`, `created_at`) VALUES
(57, 'Rich Lee', NULL, '2025-12-12 05:04:29'),
(56, 'Luc Besson', NULL, '2025-12-12 05:04:28'),
(55, 'Larry Yang', NULL, '2025-12-12 05:04:26'),
(54, 'James Nunn', NULL, '2025-12-12 05:04:24'),
(53, 'Lu Chuan', NULL, '2025-12-12 05:04:23'),
(52, 'Randall Emmett', NULL, '2025-12-12 05:04:21'),
(51, 'Dan Trachtenberg', NULL, '2025-12-12 05:04:20'),
(50, 'Tatsuya Yoshihara', NULL, '2025-12-12 05:04:18'),
(49, 'Raja Collins', NULL, '2025-12-12 05:04:17'),
(48, 'Rishab Shetty', NULL, '2025-12-12 05:04:15'),
(47, 'Yoshiharu Ashino', NULL, '2025-12-12 05:04:14'),
(46, 'Emma Tammi', NULL, '2025-12-12 05:04:12'),
(45, 'Roar Uthaug', NULL, '2025-12-12 05:04:11'),
(44, 'Joachim Rønning', NULL, '2025-12-12 05:04:09'),
(43, 'Potsy Ponciroli', NULL, '2025-12-12 05:04:07'),
(42, 'Jared Bush', NULL, '2025-12-12 05:04:06'),
(58, 'Mithun', NULL, '2025-12-12 05:04:31'),
(59, 'Oxide Pang Chun', NULL, '2025-12-12 05:04:32'),
(60, 'Byron Howard', NULL, '2025-12-12 05:04:34'),
(61, 'Guillermo del Toro', NULL, '2025-12-12 05:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(41, 'Phim Kinh Dị', NULL, '2025-12-12 05:04:12'),
(42, 'Phim Lãng Mạn', NULL, '2025-12-12 05:04:18'),
(40, 'Phim Gây Cấn', NULL, '2025-12-12 05:04:11'),
(39, 'Phim Giả Tượng', NULL, '2025-12-12 05:04:11'),
(38, 'Phim Khoa Học Viễn Tưởng', NULL, '2025-12-12 05:04:09'),
(37, 'Phim Chính Kịch', NULL, '2025-12-12 05:04:07'),
(36, 'Phim Hành Động', NULL, '2025-12-12 05:04:07'),
(35, 'Phim Miền Tây', NULL, '2025-12-12 05:04:07'),
(34, 'Phim Bí Ẩn', NULL, '2025-12-12 05:04:06'),
(33, 'Phim Gia Đình', NULL, '2025-12-12 05:04:06'),
(32, 'Phim Phiêu Lưu', NULL, '2025-12-12 05:04:06'),
(31, 'Phim Hài', NULL, '2025-12-12 05:04:06'),
(30, 'Phim Hoạt Hình', NULL, '2025-12-12 05:04:06'),
(43, 'Phim Hình Sự', NULL, '2025-12-12 05:04:21');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `year` int DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `poster` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backdrop` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tmdb_id` int DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `trailer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_movie_author` (`author_id`),
  KEY `tmdb_id` (`tmdb_id`),
  KEY `title` (`title`(250)),
  KEY `year` (`year`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `description`, `year`, `release_date`, `poster`, `backdrop`, `author_id`, `created_at`, `tmdb_id`, `rating`, `duration`, `trailer`) VALUES
(162, 'Phi Vụ Động Trời', 'Trong phim này, Zootopia là một thành phố kì lạ không giống bất kì thành phố nào trước đây của hãng Walt Disney sáng chế. Đây là khu đô thị vui vẻ của các loài động vật, từ voi, tê giác, cho đến những loài nhỏ bé như chuột, thỏ, cún. Cho đến một ngày cô cảnh sát thỏ Judy Hopps xuất hiện, thành phố Zootopia đã có những thay đổi rất là khác. Cô cùng người bạn đồng hành là chú cáo đầy “tiểu xảo” Nick Widle, đã cùng nhau phiêu lưu trong một vụ kỳ án, với mong muốn thiết lập lại trật tự cho thành phố zootopia.', 2016, '2016-02-11', '/oy5mQVAmswPFwLGsDFclJvlZRkc.jpg', '/9tOkjBEiiGcaClgJFtwocStZvIT.jpg', 60, '2025-12-12 05:21:58', 269149, 7.8, 109, 'jWM0ct-OLsM'),
(161, 'Khủng Bố Trên Không', 'Khủng Bố Trên Không (High Forces) bộ phim là câu chuyện về một vụ cướp máy bay và đòi tiền chuộc 3,5 tỷ nhân dân tệ với tính mạng hành khách bị đe dọa. Câu chuyện nghẹt thở trên chuyến bay quốc tế đầu tiên của chiếc A380 siêu sang trọng, khi máy bay bị một nhóm khủng bố do tên trùm Mike cầm đầu cướp.', 2024, '2024-09-29', '/b8xNJ39aOtEk3I7MFt8XJuN2bGS.jpg', '/8lqfrOBQ2EcY7znD3LxTYcvlh25.jpg', 59, '2025-12-12 05:21:56', 949709, 5.889, 115, 'ptAdDcpxtGo'),
(159, 'Cuộc Chiến Giữa Các Thế Giới', 'Will Radford — chuyên gia phân tích an ninh mạng hàng đầu của Bộ An ninh Nội địa — chuyên theo dõi các mối đe dọa đến an ninh quốc gia thông qua một chương trình giám sát diện rộng. Nhưng một cuộc tấn công bất ngờ từ một thực thể bí ẩn đã khiến anh bắt đầu nghi ngờ: phải chăng chính phủ đang che giấu điều gì đó… không chỉ với anh mà với toàn thế giới?', 2025, '2025-07-29', '/3e6GQvCA9hguxqfqA75BDvG7Vvp.jpg', '/iZLqwEwUViJdSkGVjePGhxYzbDb.jpg', 57, '2025-12-12 05:21:53', 755898, 4.279, 91, 'd9erkpdh5o0'),
(160, 'Stephen', 'Một bác sĩ tâm thần điều tra một sát nhân hàng loạt đã tự thú sau khi chín cô gái mất tích, song rốt cuộc phải đặt câu hỏi liệu hắn có tội hay là nạn nhân trong ván cờ đen tối hơn.', 2025, '2025-12-05', '/yUURUJzeSTc47T2VeNw7nZwZ8VJ.jpg', '/7cQjb8cRbRjF5tM5gOCnqsvC0iT.jpg', 58, '2025-12-12 05:21:54', 1561955, 6.833, 124, NULL),
(158, 'Dracula: Bản Tình Ca Bất Diệt', 'Một hoàng tử tuyệt vọng biến thành Dracula và lang thang bất tận qua thời gian, sống chỉ vì lời hứa tìm lại tình yêu của đời mình.', 2025, '2025-07-30', '/vevuZVvb72VrbDzHiz4D8Z8XuGF.jpg', '/otSXrUWOTX7tTigLBMFKOV8n47r.jpg', 56, '2025-12-12 05:21:51', 1246049, 7.117, 130, '3OBLPpuOM10'),
(156, 'Wildcat', '', 2025, '2025-11-19', '/h893ImjM6Fsv5DFhKJdlZFZIJno.jpg', '/pAyImoslSnpMgjRwhaS5ZEdl8UI.jpg', 54, '2025-12-12 05:21:48', 1448560, 6.1, 99, 'noU-vKiA9ts'),
(157, 'Bổ Phong Truy Ảnh', 'Wong Tak-Chung, một cựu chuyên gia giám sát được biết đến với khả năng phân tích dữ liệu và truy vết bậc thầy, bị cảnh sát Ma Cao mời trở lại hợp tác điều tra sau khi xuất hiện hàng loạt vụ cướp quy mô lớn do một tổ chức tội phạm công nghệ cao thực hiện.', 2025, '2025-08-16', '/5LGUvRBXoXHsMZsZrCGBOVmwOVd.jpg', '/4BtL2vvEufDXDP4u6xQjjQ1Y2aT.jpg', 55, '2025-12-12 05:21:50', 1419406, 6.5, 142, 'xvmADAJOoCg'),
(155, 'Cục 749', 'Một chàng trai trẻ bị tổn thương với những bất thường về thể chất buộc phải gia nhập một văn phòng bí ẩn để đối mặt với thảm họa lan rộng khắp trái đất do một sinh vật vô danh gây ra. Anh dấn thân vào một cuộc phiêu lưu khám phá những bí ẩn về cuộc đời mình.', 2024, '2024-10-01', '/xW640PVBXLlzhrkQnAcvWNsehIO.jpg', '/lf8IZ86ajGpgbuyHCZrXUeAMmvy.jpg', 53, '2025-12-12 05:21:46', 1033462, 6.145, 123, NULL),
(149, 'Первый отряд', '', 2009, '2009-05-13', '/mh2DUD5iHNs9VR8kxxJ8yVgZD0N.jpg', '/3k1PKmzNEosWFaOR1yC9ZKIYqmm.jpg', 47, '2025-12-12 05:21:37', 23527, 6.233, 73, NULL),
(150, 'ಕಾಂತಾರ: ಅಧ್ಯಾಯ - ೧', '', 2025, '2025-10-01', '/ehQPboTPaIMkMUOoNOh8e7pZ5Rp.jpg', '/w57nxiBIODAYHLRs1xmrCY9zEFe.jpg', 48, '2025-12-12 05:21:39', 1083637, 7, 165, 'TMQUFhWm8C0'),
(153, 'Quái Thú Vô Hình: Vùng Đất Chết Chóc', 'Trong tương lai, tại một hành tinh hẻo lánh, một Predator non nớt - kẻ bị chính tộc của mình ruồng bỏ - tìm thấy một đồng minh không ngờ tới là Thia và bắt đầu hành trình sinh tử nhằm truy tìm kẻ thù tối thượng. Bộ phim do Dan Trachtenberg - đạo diễn của Prey chỉ đạo và nằm trong chuỗi thương hiệu Quái Thú Vô Hình Predator.', 2025, '2025-11-05', '/6aPy2tMgQLVz2IcifrL1Z2Q9u1t.jpg', '/ebyxeBh56QNXxSJgTnmz7fXAlwk.jpg', 51, '2025-12-12 05:21:43', 1242898, 7.349, 107, '9PgcAIgpwPA'),
(154, 'Canh Bạc Cuối Cùng', 'Cốt truyện xoay quanh Mason Goddard (John Travolta), một siêu trộm đang tận hưởng cuộc sống mơ ước cùng đồng đội và người phụ nữ anh yêu, Amelia Decker (Gina Gershon). Tuy nhiên, khi kẻ thù không đội trời chung là Salazar bắt cóc Decker, Mason buộc phải thực hiện một vụ cướp sòng bạc gần như không thể để đổi lấy sự tự do của cô. Trong khi đó, anh phải đối mặt với các đối thủ tàn nhẫn khác của Salazar và sự truy đuổi gắt gao từ FBI, đặt cược tất cả để cứu Decker.', 2025, '2025-03-14', '/hHowAaChDjwueySmwVbsjHmpWa.jpg', '/me3SisKfnxwBP69aOVKAVMw9vDM.jpg', 52, '2025-12-12 05:21:45', 1149167, 6.4, 101, 'yE8qEz1lZbw'),
(151, 'Hunting Season', '', 2025, '2025-12-05', '/cbryTyaWdqrKpQCw6K7zm2jrB5v.jpg', '/wNamNv018mUVvxuhxkubSuHI81.jpg', 49, '2025-12-12 05:21:40', 1387382, 6.2, 93, 'iEXeoVFg5PQ'),
(152, 'Chainsaw Man - The Movie: Chương Reze', 'Tiếp nối series anime chuyển thể đình đám, Chainsaw Man lần đầu tiên oanh tạc màn ảnh rộng trong một cuộc phiêu lưu hoành tráng, ngập tràn các phân cảnh hành động. Ở phần trước, ta đã biết Denji từng làm Thợ Săn Quỷ cho yakuza để trả món nợ của cha mẹ nhưng bị họ phản bội và trừ khử. Trong khoảnh khắc hấp hối, chú chó quỷ cưa máy Pochita (người bạn đồng hành trung thành của Denji) đã đưa ra một khế ước, cứu sống cậu và hợp thể cùng cậu. Từ đó, một Quỷ Cưa bất khả chiến bại ra đời. Giờ đây ở Chainsaw Man – The Movie: Chương Reze, trong cuộc chiến tàn khốc giữa quỷ dữ, thợ săn quỷ và những kẻ thù trong bóng tối, một cô gái bí ẩn tên Reze xuất hiện trong thế giới của Denji. Denji buộc phải đối mặt với trận chiến sinh tử khốc liệt nhất của mình, một trận chiến được tiếp sức bởi tình yêu trong một thế giới nơi mọi người phải sinh tồn mà không biết bất kỳ luật lệ nào.', 2025, '2025-09-19', '/kywH6s7qTa64i0drx3pNvpQufWR.jpg', '/kfXgo2rMF1A19celCwLyQ4Xwpf8.jpg', 50, '2025-12-12 05:21:42', 1218925, 8.146, 100, 'GJ1jrCnm-t8'),
(147, 'Troll: Quỷ núi khổng lồ 2', 'Khi con quỷ núi nguy hiểm mới tàn phá quê nhà của họ, Nora, Andreas và Đại úy Kris dấn thân vào nhiệm vụ nguy hiểm nhất của họ từ trước đến nay.', 2025, '2025-11-30', '/plyEn5uDNXXDYihF8Z7YOe2PVKE.jpg', '/lZYMXx74pWmbj5Q5jp1QaMvmuuR.jpg', 45, '2025-12-12 05:21:34', 1180831, 6.79, 105, 'Hzk4ovnGOyw'),
(148, 'Năm Đêm Kinh Hoàng 2', 'Một năm sau cơn ác mộng siêu nhiên tại tiệm Pizza Freddy Fazbear, những câu chuyện xoay quanh sự kiện ấy đã bị bóp méo thành một huyền thoại kỳ quặc tại địa phương, truyền cảm hứng cho lễ hội Fazfest đầu tiên của thị trấn. Không hề biết sự thật bị che giấu, Abby lén trốn ra ngoài để gặp lại Freddy, Bonnie, Chica và Foxy — khởi đầu cho chuỗi sự kiện kinh hoàng, hé lộ bí mật đen tối về nguồn gốc thật sự của Freddy’s, và đánh thức một nỗi kinh hoàng bị chôn vùi suốt hàng thập kỷ.', 2025, '2025-12-03', '/512e7sOroI5InisAXpPI1pqvcHG.jpg', '/bhhgVjnZ69ZoCGYvVT3djnAWSJA.jpg', 46, '2025-12-12 05:21:36', 1228246, 6.4, 104, 'NQypHE9_Fm4'),
(145, 'Lão Henry', '', 2021, '2021-10-01', '/eE1SL0QoDsvAMqQly56IkRtlN1W.jpg', '/1uCX0fpYOdvrTIYulFymWOP08HT.jpg', 43, '2025-12-12 05:21:31', 785663, 7.273, 99, 'fHBdCN62gtk'),
(146, 'Trò Chơi Ảo Giác: Ares', 'Một chương trình trí tuệ nhân tạo siêu việt mang tên Ares được gửi từ thế giới số vào thế giới thực trong một nhiệm vụ đầy nguy hiểm — đánh dấu lần đầu tiên nhân loại tiếp xúc trực tiếp với một thực thể A.I. sống động.', 2025, '2025-10-08', '/lj7imLGAzI3zKvbJtPH01aYW9lU.jpg', '/min9ZUDZbiguTiQ7yz1Hbqk78HT.jpg', 44, '2025-12-12 05:21:33', 533533, 6.557, 119, 'gNa0j4mQo1k'),
(144, 'Phi Vụ Động Trời 2', 'Trong bộ phim \"Zootopia 2 - Phi Vụ Động Trời 2\" từ Walt Disney Animation Studios, hai thám tử Judy Hopps (lồng tiếng bởi Ginnifer Goodwin) và Nick Wilde (lồng tiếng bởi Jason Bateman) bước vào hành trình truy tìm một sinh vật bò sát bí ẩn vừa xuất hiện tại Zootopia và khiến cả vương quốc động vật bị đảo lộn. Để phá được vụ án, Judy và Nick buộc phải hoạt động bí mật tại những khu vực mới lạ của thành phố – nơi mối quan hệ đồng nghiệp của họ bị thử thách hơn bao giờ hết.', 2025, '2025-11-26', '/5wXpOF9WPUKliIzNBdAqwAStLHU.jpg', '/5h2EsPKNDdB3MAtOk9MB9Ycg9Rz.jpg', 42, '2025-12-12 05:21:30', 1084242, 7.683, 107, 'sEgPQ7HKoBA'),
(163, 'Frankenstein', 'Guillermo del Toro mang đến phiên bản mới đầy viễn kiến cho câu chuyện gothic của Mary Shelley về một nhà khoa học lỗi lạc mà kiêu ngạo bị chính tạo vật bi thảm của mình hủy hoại.', 2025, '2025-10-17', '/g4JtvGlQO7DByTI6frUobqvSL3R.jpg', '/hpXBJxLD2SEf8l2CspmSeiHrBKX.jpg', 61, '2025-12-12 05:21:59', 1062722, 7.771, 150, '9WZllcEgWrM'),
(166, 'Trốn Chạy Tử Thần', 'Trong bối cảnh xã hội tương lai gần, Trốn Chạy Tử Thần là chương trình truyền hình ăn khách nhất, một cuộc thi sinh tồn khốc liệt nơi các thí sinh, được gọi là “Runners”, phải trốn chạy suốt 30 ngày khỏi sự truy đuổi của các sát thủ chuyên nghiệp. Mọi bước đi của họ đều được phát sóng công khai cho khán giả theo dõi và phần thưởng tiền mặt sẽ tăng lên sau mỗi ngày sống sót. Vì cần tiền cứu chữa cho cô con gái bệnh nặng, Ben Richards, một người lao động nghèo, chấp nhận lời mời từ Dan Killian, nhà sản xuất chương trình bảnh bao nhưng tàn nhẫn, để tham gia cuộc chơi như một lựa chọn cuối cùng. Tuy nhiên, sự gan lì, nhạy bén và ý chí sinh tồn mãnh liệt của Ben lại khiến anh bất ngờ trở thành nhân vật được khán giả yêu thích nhất và là mối đe dọa với cả hệ thống. Khi lượng người xem tăng vọt, hiểm nguy cũng ngày càng bủa vây. Giờ đây, Ben không chỉ phải đối mặt với toán sát thủ mà còn cả một đất nước đang nghiện cảm giác chứng kiến anh gục ngã.', 2025, '2025-11-11', 'https://image.tmdb.org/t/p/w500/lSUUBWX1vp4WkjTUkd2mbRUuwt8.jpg', 'https://image.tmdb.org/t/p/original/aHj7d7wSLqrg5cjAcgHhiGr97Ih.jpg', NULL, '2025-12-13 02:10:48', 798645, 6.649, 133, '_iHJHYjq7XI');

-- --------------------------------------------------------

--
-- Table structure for table `movie_category`
--

DROP TABLE IF EXISTS `movie_category`;
CREATE TABLE IF NOT EXISTS `movie_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `movie_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=442 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movie_category`
--

INSERT INTO `movie_category` (`id`, `movie_id`, `category_id`) VALUES
(441, 162, 30),
(440, 162, 31),
(439, 162, 32),
(438, 162, 33),
(418, 161, 43),
(417, 161, 36),
(416, 160, 40),
(415, 159, 40),
(414, 159, 38),
(413, 158, 42),
(412, 158, 39),
(411, 158, 41),
(410, 157, 40),
(409, 157, 43),
(408, 157, 36),
(407, 156, 43),
(406, 156, 40),
(405, 156, 36),
(404, 155, 38),
(403, 155, 32),
(402, 155, 36),
(401, 154, 40),
(400, 154, 43),
(399, 154, 36),
(398, 153, 32),
(397, 153, 38),
(396, 153, 36),
(395, 152, 39),
(394, 152, 42),
(393, 152, 36),
(392, 152, 30),
(391, 151, 40),
(390, 151, 37),
(389, 151, 36),
(388, 150, 39),
(387, 150, 37),
(386, 150, 36),
(385, 149, 38),
(384, 149, 36),
(383, 149, 30),
(382, 149, 39),
(381, 148, 40),
(380, 148, 41),
(379, 147, 40),
(378, 147, 39),
(377, 147, 36),
(376, 146, 36),
(375, 146, 32),
(374, 146, 38),
(373, 145, 37),
(372, 145, 36),
(371, 145, 35),
(370, 144, 34),
(369, 144, 33),
(368, 144, 32),
(367, 144, 31),
(366, 144, 30),
(365, 143, 41),
(364, 143, 39),
(363, 143, 37),
(362, 142, 31),
(361, 142, 33),
(360, 142, 32),
(359, 142, 30),
(358, 141, 43),
(357, 141, 36),
(356, 140, 40),
(355, 139, 40),
(354, 139, 38),
(353, 138, 42),
(352, 138, 39),
(351, 138, 41),
(350, 137, 40),
(349, 137, 43),
(348, 137, 36),
(347, 136, 43),
(346, 136, 40),
(345, 136, 36),
(344, 135, 38),
(343, 135, 32),
(342, 135, 36),
(341, 134, 40),
(340, 134, 43),
(339, 134, 36),
(338, 133, 32),
(337, 133, 38),
(336, 133, 36),
(335, 132, 39),
(334, 132, 42),
(333, 132, 36),
(332, 132, 30),
(331, 131, 40),
(330, 131, 37),
(329, 131, 36),
(328, 130, 39),
(327, 130, 37),
(326, 130, 36),
(325, 129, 38),
(324, 129, 36),
(323, 129, 30),
(322, 129, 39),
(321, 128, 40),
(320, 128, 41),
(319, 127, 40),
(318, 127, 39),
(317, 127, 36),
(316, 126, 36),
(315, 126, 32),
(314, 126, 38),
(313, 125, 37),
(312, 125, 36),
(311, 125, 35),
(310, 124, 34),
(309, 124, 33),
(308, 124, 32),
(307, 124, 31),
(306, 124, 30);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` tinyint DEFAULT '0',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`(191))
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `display_name`, `password`, `created_at`, `role`, `avatar`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin', '$2y$10$wbg711ljmLJnaRwdB/o03eZUBkLrtCyvMUEP1I20f0jrNcUCz0hVq', '2025-12-10 07:15:11', 1, NULL),
(13, 'huygato', 'giahuynguyena@123', 'huygat', '$2y$10$ariw6piaTNwuCBGvRPAtEub2AmA/pfQjDYZA1jPA/SY15vd.IuY9C', '2025-12-12 08:40:27', 0, 'avatar_cartoon_1.png'),
(14, 'huy', 'huy@gg', 'huygato', '$2y$10$91c9QEALdFDDRVO6mVWjwuBt4tuZaHNlHVjc6XlfLAHjPDcpjjv/q', '2025-12-13 00:57:45', 0, 'avatar_cartoon_1.png');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

DROP TABLE IF EXISTS `watchlist`;
CREATE TABLE IF NOT EXISTS `watchlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `movie_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`id`, `user_id`, `movie_id`, `created_at`) VALUES
(26, 14, 160, '2025-12-13 00:58:07'),
(20, 13, 152, '2025-12-12 17:17:23');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
