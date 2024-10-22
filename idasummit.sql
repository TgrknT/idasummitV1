-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 22 Eki 2024, 15:59:24
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
-- Tablo için tablo yapısı `home_content`
--

CREATE TABLE `home_content` (
  `id` int(11) NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `header_text` varchar(255) DEFAULT NULL,
  `subheader_text` varchar(255) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `home_content`
--

INSERT INTO `home_content` (`id`, `video_url`, `header_text`, `subheader_text`, `event_date`, `created_at`, `updated_at`) VALUES
(1, 'tanitim', 'Ida Summit 2024', 'Ida Summit 2024 | 27 Kasım 2024 | Altınoluk', '2024-11-27 15:18:00', '2024-10-22 12:18:36', '2024-10-22 13:43:44');

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
(2, 'turkcell.png', 'TURKCELL', 'https://www.turkcell.com.tr'),
(3, 'guhem.png', 'GUHEM', 'https://www.guhem.org.tr/'),
(4, 'turkiyesigorta.png', 'TÜRKİYE SİGORTA', 'https://www.turkiyesigorta.com.tr/'),
(5, 'siesta.png', 'SİESTA', 'https://www.siesta.com.tr/tr'),
(6, 'trendyol.png', 'TRENDYOL', 'https://trendyol.com');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'grkn', '1');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `home_content`
--
ALTER TABLE `home_content`
  ADD PRIMARY KEY (`id`);

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
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `home_content`
--
ALTER TABLE `home_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `katilimcilar`
--
ALTER TABLE `katilimcilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `partnerler`
--
ALTER TABLE `partnerler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
