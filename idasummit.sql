-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 21 Eki 2024, 12:59:22
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
-- Veritabanı: `idasummit`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `katilimcilar`
--

CREATE TABLE `katilimcilar` (
  `id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `katilimcilar`
--

INSERT INTO `katilimcilar` (`id`, `image_name`, `name`, `title`) VALUES
(1, 'gurkan.jpg', 'Gürkan Yılmaz', 'Site Geliştirici'),
(2, 'a.png', 'Mehmet Çam', 'Kim Milyoner Olmak İster Yapımcı'),
(3, 'a1.png', 'Ömer Barbaros Yiş', 'Lc-Waikiki E-Ticaret CEO'),
(4, 'a2.png', 'Ozan Acar', 'Trendyol - İcra Kurulu Üyesi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `partnerler`
--

CREATE TABLE `partnerler` (
  `id` int(11) NOT NULL,
  `logo_name` varchar(255) NOT NULL,
  `partner_name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `partnerler`
--

INSERT INTO `partnerler` (`id`, `logo_name`, `partner_name`, `link`) VALUES
(1, 'trendyol.png', 'TRENDYOL', 'https://trendyol.com'),
(2, 'turkcell.png', 'TURKCELL', 'https://https://www.turkcell.com.tr'),
(3, 'guhem.png', 'GUHEM', 'https://www.guhem.org.tr/'),
(4, 'turkiyesigorta.png', 'TÜRKİYE SİGORTA', 'https://www.turkiyesigorta.com.tr/'),
(5, 'siesta.png', 'SİESTA', 'https://www.siesta.com.tr/tr');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `katilimcilar`
--
ALTER TABLE `katilimcilar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `partnerler`
--
ALTER TABLE `partnerler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `katilimcilar`
--
ALTER TABLE `katilimcilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `partnerler`
--
ALTER TABLE `partnerler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
