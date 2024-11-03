-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 03 Kas 2024, 14:26:14
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `hackathon_project`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `sur_name` varchar(100) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `accounts`
--

INSERT INTO `accounts` (`account_id`, `username`, `email`, `password_hash`, `full_name`, `sur_name`, `permission`) VALUES
(1, 'Ayrz', 'ahmet@ayrzdev.com', '1477761b4d78973f77a80ddd5dceb134', 'Ahmet', 'Doğru', 1),
(11, 'ayrz', 'zaza@gmail.com', '1477761b4d78973f77a80ddd5dceb134', 'zazaz', 'aza', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lessons`
--

CREATE TABLE `lessons` (
  `st_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `st_name` text NOT NULL,
  `st_description` text NOT NULL,
  `st_video` text NOT NULL,
  `st_image` text DEFAULT NULL,
  `st_u_id` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `lessons`
--

INSERT INTO `lessons` (`st_id`, `s_id`, `st_name`, `st_description`, `st_video`, `st_image`, `st_u_id`) VALUES
(1, 1, 'Yazılım Dersi', 'Yazılım öğreneceksin agaaaa', '/uploads/video/example.mp4', 'https://img.freepik.com/free-photo/coffee-cup-notebook-eyeglasses-pen-notepad-blackboard_23-2147909968.jpg', 'f30b2f57e22c21c97787cad0025148bc'),
(2, 1, 'Eray İzliyor', 'Yazılım öğreneceksin agaaaa', '/uploads/video/example2.mp4', 'https://img.freepik.com/free-photo/coffee-cup-notebook-eyeglasses-pen-notepad-blackboard_23-2147909968.jpg', 'f30b2f57e22c21c97787cad0025148ba');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lessons_categories`
--

CREATE TABLE `lessons_categories` (
  `s_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `lessons_categories`
--

INSERT INTO `lessons_categories` (`s_id`, `name`, `image`) VALUES
(1, 'Yazılım', 'https://i.pinimg.com/564x/90/73/74/907374231748636a1fc60025d5b6dcc0.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `question`
--

CREATE TABLE `question` (
  `q_id` int(11) NOT NULL,
  `q_quest` text NOT NULL,
  `q_language` varchar(30) NOT NULL DEFAULT '0',
  `lc_id` int(11) DEFAULT NULL,
  `q_u_id` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `question`
--

INSERT INTO `question` (`q_id`, `q_quest`, `q_language`, `lc_id`, `q_u_id`) VALUES
(1, 'Döngü ile Dizi Elemanlarını Yazdırma: Bir PHP döngüsü kullanarak bir dizi elemanını ekrana yazdırın. Diziyi [\"elma\", \"armut\", \"muz\"] olarak tanımlayın ve her bir elemanı alt alta yazdırın.', 'PHP', 1, 'afcb1cce258457895a2695dfde601aef'),
(2, 'Döngüsü ile Çarpım Tablosu: 1’den 10’a kadar olan sayılar için çarpım tablosunu PHP\'de for döngüsü kullanarak oluşturun.', 'PHP', 1, '43f43a7a55cf9d09a14bfa010268ad98'),
(3, 'foreach Döngüsü ile Dizideki Sayıları Çift ve Tek Olarak Ayırma: Bir dizi tanımlayın: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]. foreach döngüsü kullanarak çift ve tek sayıları ayırıp ekrana', 'PHP', 1, '43f43a7a55cf9d09a14bfa0102683d98');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Tablo için indeksler `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`st_id`);

--
-- Tablo için indeksler `lessons_categories`
--
ALTER TABLE `lessons_categories`
  ADD PRIMARY KEY (`s_id`);

--
-- Tablo için indeksler `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`q_id`) USING BTREE;

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `lessons`
--
ALTER TABLE `lessons`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `lessons_categories`
--
ALTER TABLE `lessons_categories`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `question`
--
ALTER TABLE `question`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
