-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 09. Aug 2024 um 01:10
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `webshop`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
(1, 'Produkt A', 'Ein fantastisches Produkt für den täglichen Gebrauch.', 49.99, 'product_a.png', '2024-08-03 20:54:05'),
(2, 'Produkt B', 'Dieses Produkt bietet eine hervorragende Leistung.', 59.99, 'product_b.png', '2024-08-03 20:54:05'),
(3, 'Produkt C', 'Hochwertige Materialien für eine lange Lebensdauer.', 69.99, 'product_c.png', '2024-08-03 20:54:05'),
(4, 'Produkt D', 'Ergonomisches Design für maximalen Komfort.', 79.99, 'product_d.png', '2024-08-03 20:54:05'),
(5, 'Produkt E', 'Modernste Technologie in einem eleganten Gehäuse.', 89.99, 'product_e.png', '2024-08-03 20:54:05'),
(6, 'Produkt F', 'Zuverlässig und effizient für den täglichen Einsatz.', 99.99, 'product_f.png', '2024-08-03 20:54:05'),
(7, 'Produkt G', 'Ein vielseitiges Produkt für alle Situationen.', 109.99, 'product_g.png', '2024-08-03 20:54:05'),
(8, 'Produkt H', 'Kompakt und leicht, ideal für unterwegs.', 119.99, 'product_h.png', '2024-08-03 20:54:05'),
(9, 'Produkt I', 'Ausgezeichnetes Preis-Leistungs-Verhältnis.', 129.99, 'product_i.png', '2024-08-03 20:54:05'),
(10, 'Produkt J', 'Innovatives Design und erstklassige Qualität.', 139.99, 'product_j.png', '2024-08-03 20:54:05'),
(11, 'Produkt K', 'Hohe Leistung und geringer Energieverbrauch.', 149.99, 'product_k.png', '2024-08-03 20:54:05'),
(12, 'Produkt L', 'Perfekt für den Einsatz zu Hause oder im Büro.', 159.99, 'product_l.png', '2024-08-03 20:54:05'),
(13, 'Produkt M', 'Einfache Bedienung und hohe Zuverlässigkeit.', 169.99, 'product_m.png', '2024-08-03 20:54:05'),
(14, 'Produkt N', 'Hervorragende Funktionalität und Benutzerfreundlichkeit.', 179.99, 'product_n.png', '2024-08-03 20:54:05'),
(15, 'Produkt O', 'Robust und langlebig für den intensiven Gebrauch.', 189.99, 'product_o.png', '2024-08-03 20:54:05'),
(16, 'Produkt P', 'Kompaktes Design mit großartiger Leistung.', 199.99, 'product_p.png', '2024-08-03 20:54:05'),
(17, 'Produkt Q', 'Ideal für professionelle Anwendungen.', 209.99, 'product_q.png', '2024-08-03 20:54:05'),
(18, 'Produkt R', 'Hohe Präzision und exzellente Verarbeitung.', 219.99, 'product_r.png', '2024-08-03 20:54:05'),
(19, 'Produkt S', 'Leistungsstark und einfach zu bedienen.', 229.99, 'product_s.png', '2024-08-03 20:54:05'),
(20, 'Produkt T', 'Modernes Design und innovative Technik.', 239.99, 'product_t.png', '2024-08-03 20:54:05'),
(21, 'Produkt U', 'Hochwertige Materialien für eine lange Lebensdauer.', 249.99, 'product_u.png', '2024-08-03 20:54:05'),
(22, 'Produkt V', 'Ein Muss für jeden Haushalt.', 259.99, 'product_v.png', '2024-08-03 20:54:05'),
(23, 'Produkt W', 'Kompakt und leistungsstark zugleich.', 269.99, 'product_w.png', '2024-08-03 20:54:05'),
(24, 'Produkt X', 'Erstklassige Qualität zum fairen Preis.', 279.99, 'product_x.png', '2024-08-03 20:54:05'),
(25, 'Produkt Y', 'Ein zuverlässiges Produkt für den täglichen Gebrauch.', 289.99, 'product_y.png', '2024-08-03 20:54:05'),
(26, 'Produkt Z', 'Modernes Design und robuste Bauweise.', 299.99, 'product_z.png', '2024-08-03 20:54:05'),
(27, 'Produkt AA', 'Ein vielseitiges Produkt für jeden Bedarf.', 309.99, 'product_aa.png', '2024-08-03 20:54:05'),
(28, 'Produkt BB', 'Leicht und einfach zu handhaben.', 319.99, 'product_bb.png', '2024-08-03 20:54:05'),
(29, 'Produkt CC', 'Ideal für den Einsatz unterwegs.', 329.99, 'product_cc.png', '2024-08-03 20:54:05'),
(30, 'Produkt DD', 'Hohe Leistung und Effizienz.', 339.99, 'product_dd.png', '2024-08-03 20:54:05'),
(31, 'Produkt EE', 'Einfaches und benutzerfreundliches Design.', 349.99, 'product_ee.png', '2024-08-03 20:54:05'),
(32, 'Produkt FF', 'Perfekt für den Einsatz im Büro.', 359.99, 'product_ff.png', '2024-08-03 20:54:05'),
(33, 'Produkt GG', 'Langlebig und zuverlässig.', 369.99, 'product_gg.png', '2024-08-03 20:54:05'),
(34, 'Produkt HH', 'Ein großartiges Produkt zu einem großartigen Preis.', 379.99, 'product_hh.png', '2024-08-03 20:54:05'),
(35, 'Produkt II', 'Hohe Qualität und modernes Design.', 389.99, 'product_ii.png', '2024-08-03 20:54:05'),
(36, 'Produkt JJ', 'Ein vielseitiges Produkt für den täglichen Gebrauch.', 399.99, 'product_jj.png', '2024-08-03 20:54:05');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT 'default_profile.png',
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `housenumber` varchar(10) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `address`, `profile_image`, `firstname`, `lastname`, `street`, `housenumber`, `city`, `zipcode`, `country`) VALUES
(1, 'hans', '$2y$10$HLJ/o4HiCFn/kDYn5KNHne0YGF3bkv22HydRRELBhNkzQtKJOUPT6', 'hansi@gmx.de', '2024-08-03 20:55:09', 'meiningstraße 31 94276 Prackenbach', '66b5332e554e6.jpg', 'hansbert', 'meier', 'talstraße', '31', 'hamburg', '20359', 'Deutschland'),
(2, 'ernst', '$2y$10$qzraR3fdETJ9PdpasDRCXOcULTPgGu8dvl38dp9abTeUOEx1e2hfO', '', '2024-08-07 20:42:44', NULL, 'default_profile.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'peter', '$2y$10$uqnRCODDjpZCVcC7vYqFdu/icOQYmurpZb0Jyuyw0o/GPLZ53drb.', 'peterli@gmx.de', '2024-08-07 20:52:45', NULL, 'default_profile.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'otto', '$2y$10$CahU.aqTZ0feEhxbxGIAeuyvQX7V5r/43m0PkAliBVKCXNk8DTmXG', 'ottili@gmx.de', '2024-08-07 20:57:00', NULL, 'default_profile.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'berti', '$2y$10$wW1D.jy4Ko1wU5Xxk058f.ZsDfVqA9mC1wsQh9/Y3UHuYMLUtEM1m', 'bertili@gmx.de', '2024-08-07 20:58:20', NULL, 'default_profile.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'paul', '$2y$10$9sbbZuK/S.W3cnXnciTYHOfbWKNXK9mDR5kw5S0VhV4k49tYmiAOO', 'pauli@gmx.de', '2024-08-07 21:03:24', NULL, 'default_profile.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'berta', '$2y$10$NBiKdn1Wt3USS92Fo3/A..JIY9gIM2tJ/xaodtEoON01a64HoFf5G', 'berta@gmx.de', '2024-08-07 21:10:11', NULL, 'default_profile.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'heinz', '$2y$10$WWCFWKfxXl6gVWQdxsZfX.EQ/7uwILVns4e2Vs7YYGpVNI5riDCVq', 'heinzi@gmx.de', '2024-08-07 21:14:31', NULL, 'default_profile.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'henri', '$2y$10$s4s5VhOQmjVbd8uUd/00te8XhPKPpxP8VxTRpZBePEJomFPdek/Ry', 'henri@gmx.de', '2024-08-07 21:24:03', NULL, 'default_profile.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'xaver', '$2y$10$0QGIPe/TsQt4G3KkDru/xu7MpnNBqx7D9/SKlkCdKw4UcnVVLxTjK', 'xaver@gmx.de', '2024-08-08 00:43:59', NULL, 'default_profile.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'friedrich', '$2y$10$VaiSqNT1QPpWQdtEGbOE8OkmplZNXyYThMK8RxvMkefEc1Olq8wbK', 'friedrich@gmx.de', '2024-08-08 01:24:40', NULL, 'default_profile.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'sophie', '$2y$10$hee0hvom1pfskudihH6GqeZsRGlxLvDpo/J/EdhyZlkHKoZZpW0fa', 'sophie@gmx.de', '2024-08-08 14:41:56', NULL, 'default_profile.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'teo', '$2y$10$zEIWR1zezhN5d88z1snsG..Yk4nWxE.4OO0M/RxyviDlqg7L6gVOy', 'teo@gmx.de', '2024-08-08 17:10:52', NULL, '1723138299_FCKNZS.PNG', 'teho', 'steiner', 'Meierstraße', '41', 'Hamburg ', '94267', 'Dänemark'),
(16, 'herbert', '$2y$10$7eg703O22YgVm8YV0szE0.u8rzpQGuXVq77qGxf5GRTAEJWqPQEJy', 'herbert@gmx.de', '2024-08-08 21:51:25', NULL, 'profil_icon_w.png', 'herbert', 'meier', 'talstraße ', '45', 'hamburg', '230359', 'Deutschland'),
(17, 'julia', '$2y$10$rTjlTtHvmYmuv63XsULwTueEmmB35Ln9/7AOgYxrybfnPqHOZUGWu', 'julia@gmx.de', '2024-08-08 22:09:15', NULL, 'profil_icon_w.png', 'julia', 'hilmar', 'heimstraße', '43', 'Hamburg', '56874', 'Deutschland'),
(18, 'sissi', '$2y$10$oy1sOQT4GSUrIafJLSmcv.f2n79CPph1iqsHy9A2uCA.zt9RaX3iK', 'sissi@gmx.de', '2024-08-08 22:32:16', NULL, 'profil_icon_w.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'uli', '$2y$10$So5rrrLC7QbI9YzK4IqKL.15RbDLf6m58EX8BC63o/NBXeCVXyYTy', 'uli@gmx.de', '2024-08-08 22:35:01', NULL, '1723157593_Motiv1.jpg', 'hermann', 'gitschorn', 'hermannstraße', '45', 'plauen', '65423', 'Polen');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
