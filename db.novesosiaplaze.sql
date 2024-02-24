/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.4.28-MariaDB : Database - db_web2_tipalsyah
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_web2_tipalsyah` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `db_web2_tipalsyah`;

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `follows` */

DROP TABLE IF EXISTS `follows`;

CREATE TABLE `follows` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `following_user_id` int(11) unsigned DEFAULT NULL,
  `notifikasi` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `following_user_id` (`following_user_id`),
  CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`),
  CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`following_user_id`) REFERENCES `login` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `follows` */

insert  into `follows`(`id`,`user_id`,`following_user_id`,`notifikasi`,`created_at`,`updated_at`) values 
(27,24,21,'sudah dibaca','2023-12-20 21:59:47','2023-12-20 22:32:39'),
(28,20,21,'sudah dibaca','2023-12-20 22:00:33','2023-12-20 22:32:39'),
(29,21,24,'sudah dibaca','2023-12-20 22:07:13','2023-12-21 18:00:52'),
(31,21,30,'belum dibaca','2024-01-06 17:19:21','2024-01-06 17:19:21'),
(32,27,21,'sudah dibaca','2024-01-11 12:13:23','2024-01-11 12:13:51'),
(33,36,21,'belum dibaca','2024-01-15 05:44:12','2024-01-15 05:44:12'),
(34,31,27,'belum dibaca','2024-01-20 04:07:39','2024-01-20 04:07:39'),
(35,31,21,'belum dibaca','2024-01-20 04:08:33','2024-01-20 04:08:33'),
(37,27,20,'belum dibaca','2024-01-30 19:33:46','2024-01-30 19:33:46'),
(38,27,31,'belum dibaca','2024-01-30 19:36:54','2024-01-30 19:36:54'),
(39,21,37,'belum dibaca','2024-01-31 06:27:16','2024-01-31 06:27:16');

/*Table structure for table `keranjang` */

DROP TABLE IF EXISTS `keranjang`;

CREATE TABLE `keranjang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `menu_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`),
  CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `postingan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `keranjang` */

insert  into `keranjang`(`id`,`user_id`,`menu_id`) values 
(3,20,28),
(4,24,29),
(5,24,31),
(6,24,28),
(7,20,31),
(8,24,34),
(9,31,33),
(10,21,36),
(11,27,36),
(12,21,49);

/*Table structure for table `likes` */

DROP TABLE IF EXISTS `likes`;

CREATE TABLE `likes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `like` int(11) unsigned DEFAULT NULL,
  `comentar` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_id` int(11) unsigned DEFAULT NULL,
  `notifikasi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`),
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=375 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `likes` */

insert  into `likes`(`id`,`user_id`,`like`,`comentar`,`created_at`,`updated_at`,`status_id`,`notifikasi`) values 
(306,24,NULL,'asik','2023-12-24 07:54:43','2024-01-10 21:30:58',12,'sudah dibaca'),
(307,24,1,NULL,'2023-12-24 07:54:54','2024-01-10 21:30:58',12,'sudah dibaca'),
(308,24,1,NULL,'2023-12-24 07:54:59','2023-12-24 07:54:59',44,'belum dibaca'),
(312,20,1,NULL,'2023-12-24 08:16:19','2023-12-24 08:16:19',44,'belum dibaca'),
(313,20,1,NULL,'2023-12-24 08:16:24','2024-01-10 21:30:58',12,'sudah dibaca'),
(319,21,1,NULL,'2023-12-24 08:22:15','2023-12-24 08:22:15',44,'belum dibaca'),
(325,29,1,NULL,'2023-12-24 08:24:55','2023-12-24 08:24:55',44,'belum dibaca'),
(326,29,1,NULL,'2023-12-24 08:25:00','2024-01-10 21:30:58',12,'sudah dibaca'),
(327,21,1,NULL,'2023-12-24 08:30:33','2024-01-10 21:30:58',12,'sudah dibaca'),
(330,30,1,NULL,'2023-12-24 08:37:15','2023-12-24 08:37:15',44,'belum dibaca'),
(331,30,1,NULL,'2023-12-24 08:37:18','2024-01-10 21:30:58',12,'sudah dibaca'),
(332,30,1,NULL,'2023-12-24 08:53:53','2023-12-24 08:53:53',52,'belum dibaca'),
(333,21,1,NULL,'2024-01-04 06:43:53','2024-01-04 06:43:53',52,'belum dibaca'),
(334,20,1,NULL,'2024-01-06 11:11:24','2024-01-06 11:11:24',52,'belum dibaca'),
(335,20,NULL,'asik','2024-01-06 11:14:05','2024-01-06 11:14:05',51,'belum dibaca'),
(336,24,1,NULL,'2024-01-06 11:21:46','2024-01-06 15:32:04',53,'sudah dibaca'),
(337,20,NULL,'cape kenapa','2024-01-06 11:22:56','2024-01-06 15:32:04',53,'sudah dibaca'),
(338,20,1,NULL,'2024-01-06 14:48:56','2024-01-06 14:48:56',51,'belum dibaca'),
(339,20,1,NULL,'2024-01-06 15:15:50','2024-01-06 15:32:04',53,'sudah dibaca'),
(340,21,1,NULL,'2024-01-06 15:34:47','2024-01-06 15:35:32',53,'sudah dibaca'),
(341,20,NULL,'cw baru ya?','2024-01-06 17:07:13','2024-01-06 17:07:13',44,'belum dibaca'),
(342,27,1,NULL,'2024-01-11 10:11:00','2024-01-11 11:41:09',12,'sudah dibaca'),
(343,36,1,NULL,'2024-01-15 05:43:12','2024-01-15 05:43:12',12,'belum dibaca'),
(344,36,1,NULL,'2024-01-15 05:43:25','2024-01-15 05:43:25',44,'belum dibaca'),
(345,36,1,NULL,'2024-01-15 05:43:46','2024-01-15 05:43:46',53,'belum dibaca'),
(347,27,1,NULL,'2024-01-18 08:53:40','2024-01-18 08:53:40',56,'belum dibaca'),
(348,27,1,NULL,'2024-01-18 08:53:46','2024-01-18 08:53:46',55,'belum dibaca'),
(349,27,1,NULL,'2024-01-18 09:04:48','2024-01-18 09:04:48',57,'belum dibaca'),
(350,27,1,NULL,'2024-01-18 09:05:19','2024-01-18 09:05:19',54,'belum dibaca'),
(351,27,1,NULL,'2024-01-18 09:05:24','2024-01-18 09:05:24',53,'belum dibaca'),
(352,24,1,NULL,'2024-01-19 19:14:40','2024-01-19 19:14:40',57,'belum dibaca'),
(353,21,1,NULL,'2024-01-20 01:23:39','2024-01-20 01:23:39',57,'belum dibaca'),
(354,37,1,NULL,'2024-01-20 01:46:57','2024-01-20 01:46:57',58,'belum dibaca'),
(355,37,1,NULL,'2024-01-20 01:48:14','2024-01-20 01:48:14',44,'belum dibaca'),
(356,37,1,NULL,'2024-01-20 01:48:29','2024-01-20 01:48:29',12,'belum dibaca'),
(357,21,1,NULL,'2024-01-20 01:56:35','2024-01-20 01:56:35',55,'belum dibaca'),
(358,21,1,NULL,'2024-01-20 01:56:46','2024-01-20 01:56:46',54,'belum dibaca'),
(359,21,1,NULL,'2024-01-20 01:56:57','2024-01-20 01:56:57',51,'belum dibaca'),
(360,21,1,NULL,'2024-01-20 03:45:16','2024-01-20 03:45:16',58,'belum dibaca'),
(361,31,1,NULL,'2024-01-20 04:03:20','2024-01-20 04:03:20',12,'belum dibaca'),
(363,31,1,NULL,'2024-01-20 04:05:32','2024-01-20 04:05:32',59,'belum dibaca'),
(364,20,1,NULL,'2024-01-20 05:28:39','2024-01-20 05:28:39',60,'belum dibaca'),
(365,21,1,NULL,'2024-01-20 05:30:16','2024-01-20 05:30:16',60,'belum dibaca'),
(367,21,1,NULL,'2024-01-28 17:46:54','2024-01-28 17:46:54',61,'belum dibaca'),
(368,31,1,NULL,'2024-01-30 02:37:04','2024-01-30 02:37:04',61,'belum dibaca'),
(370,27,1,NULL,'2024-01-30 12:09:11','2024-01-30 12:09:11',60,'belum dibaca'),
(371,27,1,NULL,'2024-01-30 12:10:06','2024-01-30 12:10:06',61,'belum dibaca'),
(372,27,NULL,NULL,'2024-01-30 19:18:13','2024-01-30 19:18:13',53,'belum dibaca'),
(373,27,NULL,'?','2024-01-30 19:20:13','2024-01-30 19:20:13',53,'belum dibaca'),
(374,21,1,NULL,'2024-01-31 06:26:56','2024-01-31 06:26:56',59,'belum dibaca');

/*Table structure for table `login` */

DROP TABLE IF EXISTS `login`;

CREATE TABLE `login` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `nomor_handphone` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL,
  `namadepan` varchar(50) NOT NULL,
  `namabelakang` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `login` */

insert  into `login`(`id`,`user`,`nomor_handphone`,`password`,`namadepan`,`namabelakang`,`created_at`,`updated_at`,`remember_token`,`role`) values 
(20,'cansa','0852312087','$2y$10$2lQG1.CIzPZYqizM5jiIYuGwFlvBi.SEbdmFpJ.6/X9tsU5loEH7i','cansa','amaida','2024-01-15 04:47:18',NULL,'e9xkf0ppJfSkqy1Drx4rYFupwXNNWvY0NrVNo2TjDMwb2kOs7ReJybs7Wbzr',NULL),
(21,'jinan_08','083153251613','$2y$10$mI2DWTc0wO/aigfBFRZldeU3iLBpmlqf5gk8yXIVKmKqIqM/3EjAi','jinan','naura','2024-01-15 04:47:21',NULL,'obmVT142TW9WnXGtTcOuyxUFedFZPPdWf3CWQlfERKn0iz69hb6SXcratWXz',NULL),
(24,'tipal123','','$2y$10$M7V3HWXGmvQZti42IdwrIuH8ty07hKqLGNdf4UxpVy5zmff.Y3jUu','tipal','syah','2024-01-15 04:47:23',NULL,'NS1LLgMoCNT3rPfGFiWCaB9SPU731F7OAh1HjiAoepBnPooC4XgircWLVMol',NULL),
(27,'nova17','087734232476','$2y$10$H6xH/jSYT2M3ARGzBuNMtu.3.ecyhpdhs.67JQjQ.0YNju6/L7E0a','nova','rusmayanti','2023-12-05 04:47:26',NULL,'5lqflrWk59Km0jKkA5BqATdIsUUCQDVWaQfWI5CMnmwUnIdbY1Hlqh8YpYIq',NULL),
(29,'adityas','','$2y$10$4m7BLA67Gp.lIzQ.RkKgSOgMljSaGl8BnNH.tuGuqd42ockUruWle','adit','sapura','2024-01-15 04:47:34',NULL,'A5OUHnxnH79MsjbguNP3ImnbGj8szjkh6xF9W0N4K0nieHR3Oz9jjViPkayU',NULL),
(30,'keduwarna_','','$2y$10$nM8XkOK8o7BBJnzSIWNCmO3GFX1fwX8duDgOWaNI/sStyC7jbOgHK','pantai','kedu warna','2024-01-15 04:47:36',NULL,'f74C6PJPsa7ZfAHb6qecC3V0XGIxBUlTQCDfKZRabrEwbMGj0QVfmMHwHGka',NULL),
(31,'ana_','8923892232','$2y$10$SG6FjFJgITqo7gXqI442X.TTinJu617ce/8UkecICDH6BeaXFkApq','triana','jelek','2024-01-15 04:47:38',NULL,'brM50PTev7ZxRjROEZugvRV7ktfwfX3VWvwsKpKlDIVOG3IIKJoNwiUPSV1s',NULL),
(34,'Novsosiaplaze_','0765642','$2y$10$ZFV6ThcqHcCn0BZ7kuq.se7.v9uRHl6TmdWCYDoYuZpPWXgoqpXyS','Novsosiaplaze','official','2024-01-01 04:47:42',NULL,'uft7tMC0LM9XeRQWRkmEcKjGRUrlU8MbgVMzlg3h1hfOfoqC8atXznK97cCU','admin'),
(36,'naora','0852775624','$2y$10$mwNSGoZyiCO6iwrdhoDBouvQ8.6Y4GQHT0Z4gjK9AEB2q.4F4s5B2','naora','cantika','2024-03-05 05:33:32','2024-01-16 08:37:43','wxXsJFBpgEuwdg8OsJUYq5dOEgFjsnRJHsa9gkZhOI3SzG3cq325fhKyhZfA',NULL),
(37,'fatimmm','+6288287221062','$2y$10$McROy5ylPq53aEp.MEJAk.RyQHiWu3/ojUkAtb54..thRHCaovS96','Fatimah','azahra','2024-01-19 18:51:11','2024-01-19 18:51:11','t1g178mgjD5sJh6ukl2Tb403W7udU5GBVGPzuGWBK9HvvDF03SSs6q7yxENu',NULL),
(38,'legoshopofficial','083153251614','$2y$10$ZWqKzwileAIPtdNCx6GD/eAXTtNBNCzH5RkRhzfIsBjGb9pVt.exu','lego','shop','2024-01-30 05:29:12','2024-01-30 05:29:12','k5J4HJHAMzd6gj3MxKdV8Kcpu5SpmU8bEavzyH9rBr9OiOdhBI5ravdHA9vv',NULL),
(39,'bosgitar','+6288287221061','$2y$10$lw63eajrGVPEcOVOJN8vPOZKOlF6eaPjGJLxYHG0ycarK84z30X2e','bos','gitar','2024-01-30 06:10:00','2024-01-30 06:10:00','dnmHCaMDe4VRaaX6RoIkirFXQj8fOpw7rveZnWYUYXKEhkVAoMm6KWod8ZJ1',NULL),
(40,'Hansaplast','083153251619','$2y$10$E5dHtSKcfX/YromAkX6VhOEyqDzyxy5LSeduIUrwBF2YLJazw8VUe','Hansaplast','Official Shop','2024-01-30 06:29:51','2024-01-30 06:29:51','t2g5XN13HvBOuClDZMVsrjrLhs5EKpdyRzI0sFhu0ObXNThGzrsEtQTKJhKT',NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2023_08_18_061426_create_genre_table',1),
(6,'2023_08_18_061440_create_cast_table',1),
(7,'2023_08_18_061501_create_profile_table',1),
(8,'2023_08_18_061515_create_film_table',1),
(9,'2023_08_18_061559_create_peran_table',1),
(10,'2023_08_18_061610_create_kritik_table',1),
(11,'2023_09_02_031959_add_remember_token_to_login_table',2),
(12,'2023_09_03_083448_add_reset_token_to_login_table',3),
(13,'2023_09_04_025445_add_reset_token_created_at_to_login',4),
(14,'2023_09_08_081558_create_npm_uts1_table',5),
(15,'2023_09_08_081751_create_npm_uts2_table',5),
(16,'2023_09_08_081829_create_npm_uts3_table',5),
(17,'2023_09_08_083442_create_21312071_uts1_table',6);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `postingan` */

DROP TABLE IF EXISTS `postingan`;

CREATE TABLE `postingan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `nama_menu` varchar(250) NOT NULL,
  `harga` varchar(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `image` varchar(500) NOT NULL,
  `jumlah_beli` int(11) unsigned DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jumlah_beli` (`jumlah_beli`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `postingan_ibfk_1` FOREIGN KEY (`jumlah_beli`) REFERENCES `product` (`id`),
  CONSTRAINT `postingan_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `postingan` */

insert  into `postingan`(`id`,`user_id`,`nama_menu`,`harga`,`deskripsi`,`image`,`jumlah_beli`,`jenis`,`kapasitas`) values 
(28,21,'PAKET BPOM DOUBLE GLOWING ISI 5 WHITENING |BRUNTUSAN FLEK JERAWAT ALL SKIN TYPE','300000','Memiliki kulit wajah yang sehat dan bersih merupakan dambaan setiap orang. Untuk mewujudkannya, Anda perlu menjaga kesehatan kulit wajah. Salah satu cara yang bisa Anda lakukan untuk menjaga kesehatan kulit wajah adalah dengan melakukan serangkaian perawatan kulit atau menggunakan skincare.','storage/images/1706620834_1704295730_OIP (1).jpeg,storage/images/1706620834_1704295730_OIP.jpeg,storage/images/1706620834_1704295730_Skincare-Wajah-Acne-Treatment-1024x1024.jpg',NULL,'kecantikan',500),
(29,20,'Official Xiaomi Redmi Note 12 (4GB/128GB) | (6GB/128GB) | (8GB/128GB) 50MP Triple Kamera 120Hz AMOLED NFC IP53 ROM 128GB','2490000','Semua model Redmi Note 12 menampilkan layar OLED yang mengesankan dan menarik. Tonton konten favorit kamu menjadi hidup dengan produksi ulang warna hitam dan cerah yang sempurna. 2400 x 1800 FHD+, 1150nits Kecerahan Maksimal, DCI-P3 Gamut warna lebar, Netflix HD Tersertifikasi, 4.500.000:1 Rasio kontras.\r\nNikmati pengalaman mulus tak tertandingi dengan kecepatan refresh rate hingga 120 Hz, baik saat bermain game atau menjelajahi media sosial. Mendukung 3 refresh rate (60Hz/90Hz/120Hz) untuk pengalaman visual yang lebih halus dan konsumsi energi yang rendah.','storage/images/1706627162_id-11134201-7r98r-lniwlkpdy5kq1c.jpg,storage/images/1706627162_id-11134201-7r98s-lniwlkt9sgp51c.jpg,storage/images/1706627162_id-11134201-7r98s-lopprvn95idj97.jpg,storage/images/1706627162_id-11134207-7qul0-ljwiz1kx2ae350.jpg',NULL,'elektronik',700),
(31,21,'liptin','50000','membuat bibir merah merona','storage/images/1704527153_OIP.jfif,storage/images/1704527153_Peripera-Ink-the-Velvet-Lip-Tint-reviews-and-user-guide.jpg',NULL,'kecantikan',150),
(32,24,'Sushi Siminimura Platter B (24 pcs) | Sushi Mate - Halal','75000','sushi ikan salmon menerima pembayaran cod dan antar ke alamat','storage/images/1706627650_id-11134207-7r98s-lnkkxz4mii6f70.jpg',NULL,'food',50),
(33,27,'otha Shoes - Flat Shoes Wanita -h394 olf','100000','Bahan Uper : PU\r\nOutsole : TPR\r\nTinggi : Flat\r\nUkuran : 36 37 38 39 40\r\nWarna : Black & Brown\r\n\r\nSepatu Flat santai yang di gunakan sehari hari , dengan outsole yang lentur yang akan nyaman di pakai berjalan seharian, bisa di gunakan untuk kerja atau berjalan jalan\r\n\r\nHarap sebelum Memesan Konfirmasi dulu ke kami mengenai ketersediaan ukuran dan warna , agar barang siap dan bisa langsung di proses .\r\n\r\nPanduan Ukuran : \r\n36 = 23 cm\r\n37 = 23,5 cm\r\n38 = 24 cm\r\n39 = 24,5 cm\r\n40 = 25 cm','storage/images/1704731058_731dbd2c1e725ef06f3ab669589ae242.jfif,storage/images/1704731058_8db055146e31b7b5f649d880d982692f.jfif,storage/images/1704731058_5e38e6bf476dd11da893aeef9ad46868.jfif,storage/images/1704731058_c55edf60ccafd500d1d5b2f3f3348cc8.jfif,storage/images/1704731058_d6ce5d9e16807113558f4b919c643c3c.jfif',NULL,'fesion',250),
(34,24,'Novel','10000','Buku Senja, Hujan, & Cerita yang Telah Usai merupakan sebuah karya yang lahir dari curhatan mengenai hal yang pernah dirasakan oleh penulisnya yaitu Boy Candra. Boy Candra sendiri adalah seorang penulis yang berkuliah dan lulus di jurusan Administrasi Pendidikan, Universitas Negeri Padang. Boy Candra lahir pada tanggal 21 November 1989 dan tumbuh besar di Padang.','storage/images/1705696386_S2.jpg',NULL,'studi',10),
(36,20,'Iphon x','3100000','Iphone x 64gb lengkap noken mulus\r\nFace id on\r\nTrue tone on\r\nHb 80% ori awet\r\nRp 3.300.000 nego\r\nDateng kerumah atau cod boleh','storage/images/1705702688_1705702612170.jpg,storage/images/1705702688_1705702616009.jpg',NULL,'elektronik',20),
(37,27,'PVN Taeyong Sepatu Sneakers Wanita Sport Shoes Cream 103','155999','Material Sepatu: High Quality Kanvas  \r\nMaterial Sole: Karet Non Slip\r\nTinggi sol: 4 cm\r\nUntuk model sepatu ini sizenya LEBIH KECIL dari ukuran biasanya ya kakak, jadi kami menyarankan untuk menaikkan 2 size di atas dari yang biasa kakak pakai (contoh size 37 order size 39, size 39 order size 41) \r\nJika kaki kakak lebih LEBAR dari biasa nya kami menyarankan untuk menaikkan 3 size di atas dari yang biasa kakak pakai (contoh size 37 order size 40, size 38 order size 41)\r\nDisarankan mengukur kaki terlebih dahulu lalu ditambah 0.5cm kemudian disamakan dengan chart size\r\nChart size (insole):\r\n37(2) : 22.5cm\r\n38(3) : 23cm\r\n39(4) : 23.5cm\r\n40(5) : 24cm\r\n41(6) : 24.5cm\r\n42(7) : 25cm\r\n43(8) : 25.5cm','storage/images/1706551561_sg-11134201-22110-2c1i7e58w0jvbd.jpg,storage/images/1706551561_sg-11134201-22110-elx7q148w0jv45.jpg,storage/images/1706551561_id-11134207-7r98y-lpvqm9dzkiia02.jpg',NULL,'fesion',350),
(38,31,'KKV - PORORO & FRIENDS BISCUIT CHEESE / CACAO KOREAN SNACK BISCUIT 65g','27900','Biskuit anak dalam bentuk karakter lucu dengan rasa yang lezat.','storage/images/1706560441_de535a3037d3ce0c043985f6fedda5af.jpg,storage/images/1706560441_29e308547bd60b14fe619c1cd5e2323a.jpg,storage/images/1706560441_ad0fa4db39383eba7008ce8d5ca3705b.jpg',NULL,'food',400),
(39,24,'Buku cerita','35000','buku cerita yang menyenangkan','storage/images/1706561758_f782ef88a1ad01c93aac54d1c904e361.jpg,storage/images/1706561758_3c72b8f50f28a861a036d324f6027102.jpg,storage/images/1706561758_ac9ed5abe302e2d44c5abb9079e8a756.jpg',NULL,'studi',20),
(40,29,'SUPRA Panci Set Alumunium Anti Lengket 4 Pcs Retro Collection','354900','4 Pcs RETRO COLLECTION, desain baru dengan tampilan vintage.\r\nKnob dan Handle dibuat kokoh dan tahan panas serta nyaman saat digenggam. Tersedia dengan tutup Alumunium yang sama dengan warna pancinya.\r\nSet of Content 4 Pcs Retro Collection\r\n- 20 Cm Dutch Oven + Lid (Alumunium/Glass)\r\n- 24 Cm Stir Wok \r\n- 20 Cm Fry pan\r\nTersedia dalam 3 pilihan warna yaitu Red, Yellow, Green. Dengan warna Retro yang unik ini akan membuat dapur teman supra lebih indah dan berwarna. \r\n- Bahan material alumunium \r\n- Ketebalan 2.5 mm\r\n- Bagian dalam anti lengket\r\n- Terdapat Spiral di bagian bawah\r\n- Food grade / aman untuk makanan\r\n- 3 Ply Nonstick Marble Coated\r\n- Phenolic Handle\r\n- Vented Lid\r\nDimensi : (42x28x18) cm','storage/images/1706562314_id-11134207-7r98y-ll4gm6nns09j4c.jpg,storage/images/1706562314_id-11134207-7r98y-ll4gm6nnqlp3ad.jpg',NULL,'alat masak',100),
(41,29,'Dejavu Tong Sampah Plastik Tertutup Minimalis Tempat Sampah Dengan Klik Otomatis Kotak Sampah Ruang Tamu Dapur Kamar Mandi','17200','Tempat Sampah merupakan merupakan produk tempat sampah dengan material Plastik yang terbaik. Memiliki kualitas terbaik yang membuat tempat sampah ini kuat dan tahan lama. Dengan desain yang menarik, simple dan harga yang ekonomis. Tempat sampah ini cocok digunakan dirumah, perkantoran, atau di ruang terbuka umum.','storage/images/1706562472_a079498c08dbedc029cb5a7c9b1078e5.jpg,storage/images/1706562472_123896dffc81918ade9cf7558c19c2c8.jpg,storage/images/1706562472_id-11134207-7r98w-lmzqdy4hpt4x5e.jpg',NULL,'peralatan rumah',231),
(42,29,'Goto Ramona Broom Sapu Pel Pembersih Lantai Otomatis Penyedot Debu','82000','Saatnya mengubah cara menyapu lama dengan yang super praktis menggunakan GOTO Broom Ramona.  Kenapa?\r\n\r\n \r\n\r\n1. Cocok digunakan untuk berbagai lantai seperti kayu, keramik, marbel, sampai semen.\r\n\r\n2. Sistem membersihkan hemat tenaga dalam menyapu debu lebih cepat serta menyerap kotoran lebih baik.\r\n\r\n3. Gagang yang dapat ditekuk mengikuti penggunaan sapu untuk membersihkan secara menyeluruh.\r\n\r\n4. Terdapat sikat pembersih yang lembut dan mampu menyapu lantai dengan baik.\r\n\r\n5. Dilengkapi tempat penyimpan debu yang kedap udara, debu mudah dibersihkan dan dibuang\r\n\r\n \r\n\r\nFaktanya banyak yang puas beli apapun di GOTO Living. Kenapa? \r\n\r\n1. Karena GOTO Living barangnya bener-bener berkualitas dan orisinil. \r\n\r\n2. Karena GOTO Living bener-bener tidak pernah mengecewakan selama 20 tahun.\r\n\r\n3. Karena GOTO Living Hebat - Hemat Banget. \r\n\r\n4. Karena Customer Service nya GOTO Living bener-bener ramah dan fast response.\r\n\r\n5. Karena pengemasan barangnya GOTO Living bener-bener rapih dan aman.','storage/images/1706566002_cf1c4ac9daef14b85b450fcb7c9d8f72.jpg,storage/images/1706566002_eea5197be6d062beb9f5b903d5da2f8d.jpg,storage/images/1706566002_2e82433d12c771fbfa4259640de1fbb0.jpg,storage/images/1706566002_id-11134207-7qul5-lh5r30n6oxyjc0.jpg',NULL,'peralatan rumah',1000),
(43,29,'GM Bear Rice Cooker/Panci Listrik 2in1 Serbaguna 1.2L P0437 - Electric Cooking Pot','169900','Alat masak ini bisa menjadi alternatif untuk menghangatkan makanan tanpa harus menggunakan kompor. Rice Cooker/Panci Elektrik mudah untuk dibawa kemana saja terbuat dari bahan berkualitas sehingga tidak lengket dan hemat listrik. Khawatir apabila perangkat dapur Anda memakan banyak tempat? Tenang saja karena dengan kabel yang bisa di lepas pasang memudahkan saat dibersihkan dan disimpan','storage/images/1706566239_id-11134207-7qul1-lfqdrka4qt7184.jpg,storage/images/1706566239_id-11134207-7qul5-lfqdrka4peml93.jpg',NULL,'alat masak',120),
(44,38,'【COD】Mini Building Block Cina Building Micro Partikel Blok Bangunan Building Block Bricks Rumah Building Block','158000','- Blok bangunan pendidikan: mainan blok bangunan dapat merangsang kemampuan anak-anak untuk memanipulasi, memvisualisasikan, memecahkan masalah, keterampilan sosial dan olahraga.\r\n- Meningkatkan interaksi anak-anak: mainan memungkinkan anak-anak untuk membangun, bermain, dan belajar dalam pendidikan dan rekreasi masa kecil. Bersatu dan merasakan pencapaian. Ini juga dapat meningkatkan interaksi antara orang tua dan anak-anak.\r\n- Merangsang imajinasi anak-anak: dapat mengembangkan rasa ruang tiga dimensi dan membuat mereka lebih imajinatif.\r\n- Hadiah terbaik untuk anak-anak: mainan blok bangunan adalah bentuk hewan lucu dan hadiah terbaik untuk anak laki-laki dan perempuan.','storage/images/1706568385_sg-11134201-7rbls-lpjbv65x2pld44.jpg,storage/images/1706568385_sg-11134201-7rbn0-lpjbv7ykhiga39.jpg,storage/images/1706568385_sg-11134201-7rbm5-lpjbv89xzfw728.jpg,storage/images/1706568385_sg-11134201-7rblm-lpjbv946r6lnbd.jpg',NULL,'mainan',700),
(45,38,'MAINAN BALOK 280 PCS / BUILDING BLOCK / BRICKS 280 PCS / MAINAN EDUKASI / BALOK SUSUN','68000','Mainan balok isi 280 pcs','storage/images/1706568485_id-11134201-7qukw-lg5zhiu8fzw539.jpg,storage/images/1706568485_id-11134207-7qul1-lhgzkqcpclln4c.jpg',NULL,'mainan',100),
(46,39,'GITAR AKUSTIK PEMULA YAMAHA FREE PACKING KAYU','195000','Gitar yamaha pemula dan gitar Yamaha apx seri 500ii\r\nDengan senar yg lembut dan empuk..di jamin ndak sakit di jari\r\nSuara garing','storage/images/1706569966_1c93e1208342f0e63ad8e4fcb8cdfdf4.jpg,storage/images/1706569966_9a2f7b10bc708cd56788fa6476059ff3.jpg',NULL,'musik',20),
(47,39,'Quick Change Clamp Key Acoustic Classic Guitar Capo','9000','Cocok dengan nyaman di tangan Anda.\r\nTidak diperlukan penyesuaian.\r\nDapat dijepit di sebagian besar fingerboard.\r\nUkuran kecil dan mudah dibawa.\r\nPegang tali dengan erat untuk membuatnya kencang.\r\nAnda bahkan dapat mengubah kunci saat lagu diputar.\r\nDigunakan untuk gitar listrik atau gitar akustik.\r\nDapat dibongkar dan diposisikan ulang dengan cepat dan mudah.\r\nCapos dapat digunakan untuk mengubah nada gitar akustik, gitar klasik, gitar listrik, bass, biola, dan ukulele dengan cepat.','storage/images/1706570791_0a6e5cd0c4c26e17fc7c0351d97526e0.jpg,storage/images/1706570791_02c4d5986fdf1bff7e137872f1ee308f - Copy.jpg,storage/images/1706570791_43fcebb2a7a7be1a8e74f29ee94b93ae.jpg',NULL,'musik',500),
(48,40,'Hansaplast Kain Elastis Jumbo - Best Value - Plester Lentur & Merekat Kuat','124500','Hansaplast Kain Elastis merupakan plester serba guna untuk semua jenis luka ringan. \r\nKeunggulan:\r\n- Melindungi dari kotoran dan bakteri, dan mencegah infeksi pada luka.\r\n- Dengan kain yang lentur dan berpori dapat membuat kulit leluasa bernapas.\r\n- Dapat mengikuti pergerakan Anda untuk pemakaian yang nyaman.\r\n- Bantalan luka yang tidak lengket, melindungi luka sehingga plester dapat dilepaskan dengan mudah dan tidak sakit.','storage/images/1706571289_af1c4f1e105c72a9ea53cd659c8927c1.jpg,storage/images/1706571289_1b091e6c95c136fe13f63cc747352f36 (3).jpg',NULL,'kesehatan',100),
(49,31,'Pororo Seaweed 2 x 5 g','17000','Pororo Seaweed 2 x 5 g adalah sebuah snack rumput laut yang berasal dari Korea. Dibuat dengan menggunakan rumput laut pilihan, yang diolah dengan cara dikeringkan menggunakan oven bershuhu tinggi. Rumput laut diolah secara higienis menggunakan teknologi tinggi. Dicetak dalam bentuk lembaran tipis yang dipotong dalam bentuk persegi panjang. Rumput laut dibalur dengan minyak wijen dan taburan garam yang memberikan sensasi rasa asin dan gurih serta aroma yang khas tanpa menghilangkan rasa dan aroma khas rumput laut. Cocok disantap sebagai cemilan atau dimakan bersama degan nasi atau mie. Memiliki kalori yang rendah, sehingga cocok disantap oleh orang yang sedang menjalani diet sekalipun. Dikemas dalam kemasan khusus berukuran 5 gram dan terdapat 2 kemasan dalam satu pack. Segera miliki Pororo Seaweed 2 x 5 g dan jadikan cemilan sehat anda dan keluarga anda.','storage/images/1706571535_id-11134201-7qukz-lk6fizgob7e2a5.jpg,storage/images/1706571535_id-11134201-7qul0-lk6fizcihane65.jpg',NULL,'food',200);

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `alamat_id` int(11) unsigned DEFAULT NULL,
  `jumlah_beli` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `is_new` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `notifikasi` varchar(30) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `user_id` (`user_id`),
  KEY `alamat_id` (`alamat_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `postingan` (`id`),
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`),
  CONSTRAINT `product_ibfk_3` FOREIGN KEY (`alamat_id`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `product` */

insert  into `product`(`id`,`menu_id`,`user_id`,`alamat_id`,`jumlah_beli`,`created_at`,`is_new`,`total_harga`,`status`,`notifikasi`,`updated_at`) values 
(81,28,20,7,4,'2024-01-04 08:49:21',1,1200000,'menunggu','belum dibaca','2024-01-15 11:20:57'),
(83,32,21,6,2,'2024-01-11 09:53:05',2,150000,'ditolak','sudah dibaca','2024-01-11 13:21:02'),
(84,33,21,6,1,'2024-01-11 10:20:49',3,10000,'disetujui','sudah dibaca','2024-01-11 13:21:02'),
(85,33,21,6,1,'2024-01-12 12:36:18',4,10000,'menunggu','belum dibaca','2024-01-12 12:36:18'),
(87,34,21,6,10,'2024-01-13 00:59:54',6,10000,'disetujui','sudah dibaca','2024-01-13 02:28:50'),
(88,29,21,6,1,'2024-02-15 13:26:30',7,1900000,'menunggu','belum dibaca','2024-03-15 13:26:30'),
(89,33,36,13,2,'2024-01-16 14:26:08',1,20000,'disetujui','belum dibaca','2024-01-17 20:24:17'),
(90,33,20,7,1,'2024-01-17 17:59:38',2,10000,'disetujui','belum dibaca','2024-01-17 18:00:02'),
(91,33,31,14,1,'2024-01-17 23:07:51',1,10000,'disetujui','sudah dibaca','2024-01-20 03:55:03'),
(93,36,21,6,1,'2024-01-29 18:03:07',8,3100000,'disetujui','belum dibaca','2024-01-29 18:05:42'),
(95,49,21,6,3,'2024-01-30 06:40:32',9,51000,'disetujui','belum dibaca','2024-01-30 06:46:51'),
(96,43,21,6,1,'2024-01-31 06:31:15',10,169900,'menunggu','belum dibaca','2024-01-31 06:31:15');

/*Table structure for table `profile` */

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_depan` varchar(30) NOT NULL,
  `nama_belakang` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `biodata` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `profile` */

insert  into `profile`(`id`,`nama_depan`,`nama_belakang`,`tanggal_lahir`,`alamat`,`gender`,`user_id`,`biodata`) values 
(6,'jinan','naura','2003-03-08','kalianda','Perempuan',21,'⚕'),
(7,'cansa','putri','2023-10-02','banding, rajabasa, lampung selatan','Perempuan',20,'cansa amaida putri'),
(10,'nova','rusmayanti','2000-11-17','tengkujuh','Perempuan',27,'Bio 18'),
(11,'Tifal','Dwiyansyah','2002-07-05','kalianda','Laki-laki',24,'Informatika 21'),
(12,'pantai','kedu warna','2023-12-10','jl.sinar laut kalianda','Laki-laki',30,'pantai kedu warna sunset for kalianda'),
(13,'naora','cantika','2005-11-14','Labuhan ratu, Bandar Lampung','Perempuan',36,'bersenang-senang'),
(14,'Triyana','sugiarti','2024-01-01','Bandar Lampung','Perempuan',31,'untuk bersenang-senang'),
(15,'Fatimah','Azahra','2020-06-10','Labuhan ratu, Bandar Lampung','Perempuan',37,'she/hear'),
(16,'adit','sapura','2003-05-17','gedung air','Laki-laki',29,'untuk bersenang-senang'),
(17,'lego','shop','2023-08-16','kabupaten tanggerang','Laki-laki',38,'lego asik'),
(18,'bos','gitar','2020-06-24','kebumen, jawa tengah','Laki-laki',39,'toko peralatan gitar'),
(19,'Hansaplast','Official Shop','2024-01-16','KOTA TANGERANG SELATAN','Perempuan',40,'kesehatan dan percegahan pertama');

/*Table structure for table `profile_images` */

DROP TABLE IF EXISTS `profile_images`;

CREATE TABLE `profile_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `image_path` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `profile_images_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `profile_images` */

insert  into `profile_images`(`id`,`user_id`,`image_path`) values 
(6,20,'images/hARjDfPstQR7rPw5uq1aNFa2aMoUmrfpjVIA1lVt.jpg'),
(7,21,'images/5EbA498Ipb28KaWDltNask1auIIuoQAfo9VZ8PqU.jpg'),
(12,27,'images/M7hHF1BVYjuTma1O43ogJM7Bq8mweYNBTAMamlav.jpg'),
(17,24,'images/5tcP25XOJISdMkbbCEkABFr52B6vysWNqGTEwajF.jpg'),
(18,30,'images/jIQiZBvl7sOVMV9Otj901rh3KwJvIkjIFDv6zkHX.png'),
(20,36,'images/0JWUzWtrunaa8ci9C5wf5ODNs7fMkFRfVuWA2aNG.jpg'),
(21,31,'images/ZDIwC9PllqCKCGRdDA2tFr5oOYFCKO1FAeRKw9vX.jpg'),
(22,37,'images/aH8tO1ga2QpsHk3PIrqZiGjVunfO7sTi2r28yg2z.jpg'),
(23,38,'images/PO6ceRBFR3LMcK42ZBYy4VWWZgo8GdTSdRq9sZnT.jpg'),
(24,40,'images/HTIQaPBzxa1oD0CX3ep4QsemWJLb3reRNP7VsI6v.jpg');

/*Table structure for table `rating` */

DROP TABLE IF EXISTS `rating`;

CREATE TABLE `rating` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `menu_id` int(11) unsigned DEFAULT NULL,
  `rating` int(5) DEFAULT NULL,
  `comentar` text DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`),
  CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `postingan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `rating` */

insert  into `rating`(`id`,`user_id`,`menu_id`,`rating`,`comentar`,`image`,`created_at`,`updated_at`) values 
(1,21,33,5,'bagus banget dengan harga segitu','storage/images/1705456676_7ffd60eb8e68e9be9126e0ad58918961.jfif,storage/images/1705456676_13.-Otha-Shoes-Flat-Shoes-Wanita-300x300@2x.jpg','2024-01-17 09:37:11','2024-01-17 09:37:13'),
(2,20,33,4,'bagus sekali','storage/images/1705489315_1701492315_atv.jpg','2024-01-17 18:01:55','2024-01-17 18:01:55'),
(3,36,33,5,'Gak pernah nyesel belanja di toko ini, kualitas bagus harga murah banget','storage/images/1705506586_id-11134103-22100-gx3qa6d7zpiv9a.jpg,storage/images/1705506586_id-11134103-22100-ichbdfr7zpivf2.jpg,storage/images/1705506586_id-11134103-22100-k53y8g76zpiv6d.jpg,storage/images/1705506586_id-11134103-22100-2135q857zpiv0e.jpg,storage/images/1705506586_id-11134103-22100-qjtgccj8zpiv0e.jpg','2024-01-17 22:49:46','2024-01-17 22:49:46'),
(4,31,33,4,'Bagus bgt, solnya empuk, kalo ada uk 35 pasti lebih bagus di aku, soalnya 36 ak masih agk longgar :( tp tetep bagussss, pengiriman 1 minggu karna dr medan ke jaksel. Adminnya fastresp keceee','storage/images/1705507863_id-11134103-7qukw-liffyozlbrtv0a.jpg,storage/images/1705507863_id-11134103-22110-4r7o8vl1ickv66.jpg,storage/images/1705507863_id-11134103-22110-e89rocozickv80.jpg,storage/images/1705507863_id-11134103-22110-g04bdue2ickv54.jpg,storage/images/1705507863_id-11134103-22110-on972e3zickvc6.jpg,storage/images/1705507863_id-11134103-22110-tatxbez1ickv7d.jpg,storage/images/1705507863_id-11134103-7qul3-liffyoyhdecsfe.jpg','2024-01-17 23:11:03','2024-01-17 23:11:03'),
(5,21,49,5,'Enak banget, kemasan rapi dan respon toko cepet sekali','storage/images/1706572288_images.jpeg','2024-01-30 06:51:28','2024-01-30 06:51:28');

/*Table structure for table `status` */

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `caption` text DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `comentar_id` int(11) unsigned DEFAULT NULL,
  `like` int(11) unsigned DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `like` (`like`),
  KEY `comentar_id` (`comentar_id`),
  CONSTRAINT `status_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `status` */

insert  into `status`(`id`,`user_id`,`caption`,`image`,`created_at`,`comentar_id`,`like`,`updated_at`) values 
(12,21,'yang deket-deket rumah aja asal mantai','storage/images/1704290850_jajal.jpg','2023-11-20 21:10:21',NULL,NULL,'2024-01-03 21:07:30'),
(44,24,'Love you to hany','storage/images/1704346652_ww.jpg','2023-12-24 04:08:17',NULL,NULL,'2024-01-04 12:37:32'),
(47,30,'kedu warna keren','storage/images/1703381881_1.jpg','2023-12-24 08:38:01',NULL,NULL,'2023-12-24 08:38:01'),
(48,30,'kedu warna keren','storage/images/1703381908_2.jpg','2023-12-24 08:38:28',NULL,NULL,'2023-12-24 08:38:28'),
(49,30,'kedu warna keren','storage/images/1703382170_3.jpg','2023-12-24 08:42:50',NULL,NULL,'2023-12-24 08:42:50'),
(50,30,'kedu warna keren','storage/images/1703382235_4.jpg','2023-12-24 08:43:55',NULL,NULL,'2023-12-24 08:43:55'),
(51,30,'kedu warna keren','storage/images/1703382336_5.jpg','2023-12-24 08:45:36',NULL,NULL,'2023-12-24 08:45:36'),
(52,30,'kedu warna keren','storage/images/1703382400_6.jpg','2023-12-24 08:46:40',NULL,NULL,'2023-12-24 08:46:40'),
(53,20,'Beautiful sunset','storage/images/1704535421_IMG-20210621-WA0068.jpg,storage/images/1704535421_IMG-20210621-WA0069.jpg,storage/images/1704535421_IMG-20210621-WA0070.jpg','2024-01-06 11:16:02',NULL,NULL,'2024-01-06 17:03:41'),
(54,36,'Light','storage/images/1705542617_jtaputri12_3155432757749310350.jpg,storage/images/1705542617_jtaputri12_3155432757757566962.jpg,storage/images/1705542617_jtaputri12_3155432757757598481.jpg,storage/images/1705542617_jtaputri12_3155432757824804486.jpg','2024-01-18 08:50:17',NULL,NULL,'2024-01-18 08:50:17'),
(55,36,'Calm','storage/images/1705542682_jtaputri12_3138462346469704207.jpg,storage/images/1705542682_jtaputri12_3138462346478319514.jpg,storage/images/1705542682_jtaputri12_3138462346469720840.jpg','2024-01-18 08:51:22',NULL,NULL,'2024-01-18 08:51:22'),
(56,36,'Love me','storage/images/1705542756_jtaputri12_3004706483975570901.jpg,storage/images/1705542756_jtaputri12_3004706483975571602.jpg,storage/images/1705542756_jtaputri12_3004706483983948803.jpg,storage/images/1705542756_jtaputri12_3004706484260904838.jpg,storage/images/1705542756_jtaputri12_3004706484294430168.jpg,storage/images/1705542756_jtaputri12_3004706483983965498.jpg','2024-01-18 08:52:36',NULL,NULL,'2024-01-18 08:52:36'),
(57,27,'smile for you','storage/images/1706613984_IMG-20220118-WA0029.jpg','2024-01-18 08:56:18',NULL,NULL,'2024-01-30 18:26:24'),
(58,37,'Love love','storage/images/1705689959_IMG-20240120-WA0000.jpg','2024-01-20 01:45:59',NULL,NULL,'2024-01-20 01:45:59'),
(59,31,'\"ibarat air laut di pantai, meski ia kadang pasang surut, percaylah, rasa air laut itu tidak akan berubah.\"','storage/images/1705697961_IMG-20240120-WA0004.jpg,storage/images/1705697961_IMG-20240120-WA0006.jpg,storage/images/1705697961_IMG-20240120-WA0002.jpg','2024-01-20 03:59:21',NULL,NULL,'2024-01-20 03:59:21'),
(60,21,'i\'m the one','storage/images/1705703276_1692300249675.jpg','2024-01-20 05:27:56',NULL,NULL,'2024-01-20 05:27:56'),
(61,27,'Luvluv❤️','storage/images/1706438705_Screenshot_20240128_040537_Instagram.jpg','2024-01-28 17:45:05',NULL,NULL,'2024-01-28 17:45:05');

/*Table structure for table `toko` */

DROP TABLE IF EXISTS `toko`;

CREATE TABLE `toko` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_depan` varchar(250) DEFAULT NULL,
  `nama_belakang` varchar(250) DEFAULT NULL,
  `alamat` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `detail` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `toko_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `toko` */

insert  into `toko`(`id`,`nama_depan`,`nama_belakang`,`alamat`,`email`,`user_id`,`detail`) values 
(1,'Jinan','Biuty','Kalianda, Lampung selatan','jinanauraa@gmail.com',21,'toko kecantikan menjual perawatan kecantikan yang terjamin ori'),
(4,'Cansa','Amaida','Kalianda, Lampung selatan','cansa@gmail.com',20,'cansa cell depan pasar impress kalianda'),
(7,'tifal','syah','sukamandi, kalianda, lampung selatan','tipalsyah@gmail.com',24,'toko sembako murah'),
(8,'novnov','store','Bandar Lampung','nova17@gmail.com',27,'Fesion wanita'),
(9,'ana','shop','labuhan ratu, bandar lampung','ana@gmail.com',31,'toko alat tulis'),
(10,'adit shop','official','gedung air','adit@gmail.com',29,'toko kecintaan ibu-ibu'),
(11,'lego','shop official','kabupaten tanggerang','legoofficial@gmail.com',38,'toko permainan lego'),
(12,'bos','gitar','kebumen, jawa tengah','bosgitar@gmail.com',39,'peralatan alat musik gitar'),
(13,'Hansaplast','Official Shop','KOTA TANGERANG SELATAN','hansaplas12@gmail.com',40,'pk3');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
