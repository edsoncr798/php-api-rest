-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para phpapidb
CREATE DATABASE IF NOT EXISTS `phpapidb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `phpapidb`;

-- Volcando estructura para tabla phpapidb.employee
CREATE TABLE IF NOT EXISTS `employers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `age` int NOT NULL,
  `designation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla phpapidb.employee: ~10 rows (aproximadamente)
INSERT INTO `employers` (`id`, `name`, `email`, `age`, `designation`, `created`) VALUES
	(1, 'John Doe', 'johndoe@gmail.com', 32, 'Data Scientist', '2012-06-01 02:12:30'),
	(2, 'David Costa', 'sam.mraz1996@yahoo.com', 29, 'Apparel Patternmaker', '2013-03-03 01:20:10'),
	(3, 'Todd Martell', 'liliane_hirt@gmail.com', 36, 'Accountant', '2014-09-20 03:10:25'),
	(4, 'Adela Marion', 'michael2004@yahoo.com', 42, 'Shipping Manager', '2015-04-11 04:11:12'),
	(5, 'Matthew Popp', 'krystel_wol7@gmail.com', 48, 'Chief Sustainability Officer', '2016-01-04 05:20:30'),
	(6, 'Alan Wallin', 'neva_gutman10@hotmail.com', 37, 'Chemical Technician', '2017-01-10 06:40:10'),
	(7, 'Joyce Hinze', 'davonte.maye@yahoo.com', 44, 'Transportation Planner', '2017-05-02 02:20:30'),
	(8, 'Donna Andrews', 'joesph.quitz@yahoo.com', 49, 'Wind Energy Engineer', '2018-01-04 05:15:35'),
	(9, 'Andrew Best', 'jeramie_roh@hotmail.com', 51, 'Geneticist', '2019-01-02 02:20:30'),
	(10, 'Joel Ogle', 'summer_shanah@hotmail.com', 45, 'Space Sciences Teacher', '2020-02-01 06:22:50');

-- Volcando estructura para tabla phpapidb.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('ADMIN','USER') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'USER',
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'https://img.freepik.com/premium-vector/anonymous-user-flat-icon-vector-illustration-with-long-shadow_520826-1932.jpg?w=200',
  `api_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `api_token` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla phpapidb.users: ~8 rows (aproximadamente)
INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `photo`, `api_token`, `created_at`, `updated_at`) VALUES
	(1, 'Angel Marthans', '$2y$10$1sffhxxWu7XVEw.oeJcs2OFIIJ6w3MfWc/.w2S6C2hlhmTYFPWZoi', 'angel@gmail.com', 'ADMIN', 'https://img.freepik.com/premium-vector/anonymous-user-flat-icon-vector-illustration-with-long-shadow_520826-1932.jpg?w=200', 'f5af65f714ec19189b5b918202874d48', '2024-02-12 00:37:00', '2024-02-12 01:44:09'),
	(2, 'Usuario Administrador', '$2y$10$oBCXRXQR6XXqQ8DHfLt5Y.go/rFheWqOdtGnoiQK6Yptw4Ew8DOiG', 'admin001@gmail.com', 'ADMIN', 'https://img.freepik.com/premium-vector/anonymous-user-flat-icon-vector-illustration-with-long-shadow_520826-1932.jpg?w=200', '8f10b044d6b030dadb25c4720cda8732', '2024-02-12 01:28:41', '2024-02-19 04:21:52'),
	(3, 'Usuario 1', '$2y$10$TpaXsRNRiLMYqHAqyhTR3eGfsWpmPVOXI19Azz2BR54drQAe/XgRa', 'user1@gmail.com', 'USER', 'https://img.freepik.com/premium-vector/anonymous-user-flat-icon-vector-illustration-with-long-shadow_520826-1932.jpg?w=200', 'cc6aa37ed931cbfc17a7dadcbe255d04', '2024-02-12 01:28:55', '2024-02-12 01:44:13'),
	(4, 'Usuario 2', '$2y$10$LqZG2ArWZvm1l.pZEAJlde9mjRsK.y/m1CPWjPj2cfYudMbzeOBDq', 'user2@gmail.com', 'USER', 'https://img.freepik.com/premium-vector/anonymous-user-flat-icon-vector-illustration-with-long-shadow_520826-1932.jpg?w=200', '31399a65cdf3d586318cef9fc452bd94', '2024-02-12 01:29:03', '2024-02-12 01:44:14'),
	(5, 'Usuario 3', '$2y$10$4wp2kaZpOlqV64Qd.uOVDOEiSzt.j.zKL36j9ImcjLAVpad67SF8O', 'user3@gmail.com', 'USER', 'https://img.freepik.com/premium-vector/anonymous-user-flat-icon-vector-illustration-with-long-shadow_520826-1932.jpg?w=200', 'e2309a1656017ecbd176bd1cd2fe4f12', '2024-02-12 01:29:10', '2024-02-12 01:44:15'),
	(6, 'Usuario 4', '$2y$10$UoyEYw2MMokGG31jeXBzgOGR/55YyqwSbDGpxVplCdtHkW3B4jhuu', 'user4@gmail.com', 'USER', 'https://img.freepik.com/premium-vector/anonymous-user-flat-icon-vector-illustration-with-long-shadow_520826-1932.jpg?w=200', '82d0e31a8f9f75671355df991e33c41d', '2024-02-12 01:29:20', '2024-02-12 01:44:17'),
	(14, 'User new token 64', '$2y$10$fdH24MeODCQypi0l28dtwuZxHRq8qoZpACy628iqdm9LBA8sSMeMS', 'uuuuu@rrr.com', 'USER', 'https://img.freepik.com/premium-vector/anonymous-user-flat-icon-vector-illustration-with-long-shadow_520826-1932.jpg?w=200', '89536b816391df9e6272d89f4a70f93e79f7bd7ca4b8128599a293518ef9bcb5098e486c378e4b328e654b1cf7c9fe2ecade5a81a196edc7bf13f002b4d8d205', '2024-02-19 15:51:20', '2024-02-19 15:51:20'),
	(15, 'user token 32', '$2y$10$RMNx0XzGXqWc1liYbmwlFeRLbBmYHMqbbyi5NYTWhYzQNjXpUC36y', 'eweew@ererere.com', 'USER', 'https://img.freepik.com/premium-vector/anonymous-user-flat-icon-vector-illustration-with-long-shadow_520826-1932.jpg?w=200', '2782896e1237d34fc471de563462f659a8a9cab28415123aedab3f77bcc0f3d5', '2024-02-19 15:53:50', '2024-02-19 15:53:50');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
