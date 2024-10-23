-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 23 Eki 2024, 15:19:01
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
(1, 'tanitim', 'Ida Summit 2024', 'Ida Summit 2024 | 27 Kasım 2024 | Altınoluk', '2024-11-27 15:18:00', '2024-10-22 12:18:36', '2024-10-23 11:13:33');

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
(2, 'a.png', 'Mehmet Çam', 'Kim Milyoner Olmak İster Yapımcı'),
(3, 'a1.png', 'Ömer Barbaros Yiş', 'Lc-Waikiki E-Ticaret CEO'),
(4, 'a2.png', 'Ozan Acar', 'Trendyol - İcra Kurulu Üyesi'),
(5, 'grkn.jpg', 'Gürkan Yılmaz', 'Site Geliştirici'),
(6, 'eminreis.jpg', 'Emin Ahmet Tanrıöven', 'Denizbank  Yapay Zeka ve Optimizasyon Grup Müdürü');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `katilim_formu`
--

CREATE TABLE `katilim_formu` (
  `id` int(11) NOT NULL,
  `ad_soyad` varchar(100) DEFAULT NULL,
  `okul` varchar(100) DEFAULT NULL,
  `bolum` varchar(100) DEFAULT NULL,
  `sinif` varchar(50) DEFAULT NULL,
  `cep_tel` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `katilim_formu`
--

INSERT INTO `katilim_formu` (`id`, `ad_soyad`, `okul`, `bolum`, `sinif`, `cep_tel`, `email`) VALUES
(1, 'Gürkan Yılmaz', 'Altınoluk MYO', 'Bilgisayar Programcılığı', '2', '05378625555', 'ggrkn.y@gmail.com'),
(3, 'İrem Büyükturan', 'Altınoluk MYO', 'Bilgisayar Programcılığı', '2', '05305563102', 'irembyktrn123@gmail.com'),
(4, 'Mehmet Can', 'Edremit MYO', 'Bilgisayar Programcılığı', '1', '05438921654', 'mehmetcan@myo.com'),
(5, 'Ayşe Yılmaz', 'Edremit MYO', 'Muhasebe ve Vergi Uygulamaları', '2', '05546781234', 'ayseyilmaz@myo.com'),
(6, 'Ahmet Kılıç', 'Havran MYO', 'İnşaat Teknolojisi', '1', '05329874561', 'ahmetkilic@myo.com'),
(7, 'Zeynep Kaya', 'Edremit Sivil Havacılık YO', 'Sivil Havacılık Kabin Hizmetleri', '2', '05346712345', 'zeynepkaya@myo.com'),
(8, 'Ali Vural', 'Altınoluk MYO', 'Turizm ve Otel İşletmeciliği', '2', '05498761234', 'alivural@myo.com');

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
-- Tablo için tablo yapısı `section_content`
--

CREATE TABLE `section_content` (
  `id` int(11) NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `content_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `section_content`
--

INSERT INTO `section_content` (`id`, `section_name`, `image_url`, `content_text`) VALUES
(1, 'hakkinda', 'ida2.png', 'İdasummer 24, teknoloji ve inovasyon dünyasına adım atmak isteyen genç zihinleri, alanında uzman kişilerle buluşturan bir etkinlik olarak tasarlanmıştır. Etkinlik, teknolojinin hızla gelişen dünyasında gençlerin yaratıcılıklarını ve potansiyellerini en üst düzeye çıkararak, onları geleceğin liderleri ve yenilikçileri haline getirmeyi hedefler.'),
(2, 'motivasyon', 'ida3.png', 'Etkinliğimiz, gençlerin sürdürülebilir bir gelecek için yaratıcılıklarını teşvik etmeyi amaçlamaktadır. Her katılımcı, çevreye duyarlı projeler geliştirme konusunda motive edilir.');

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
-- Tablo için indeksler `katilim_formu`
--
ALTER TABLE `katilim_formu`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `partnerler`
--
ALTER TABLE `partnerler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `section_content`
--
ALTER TABLE `section_content`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `katilim_formu`
--
ALTER TABLE `katilim_formu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `partnerler`
--
ALTER TABLE `partnerler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `section_content`
--
ALTER TABLE `section_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
