-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 12. Aug 2024 um 03:21
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tags` text DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`, `tags`, `stock`) VALUES
(1, 'Ergonomischer Bürostuhl', 'Ein hochwertiger ergonomischer Bürostuhl mit einstellbaren Einstellungen für maximalen Komfort.', 199.99, 'product_a.png', '2024-08-03 20:54:05', 'Keywords: Ergonomic Office Chair, Ergonomischer Bürostuhl, Silla de Oficina Ergonómica, Chaise de Bureau Ergonomique, Sedia da Ufficio Ergonomica, Office, Stuhl, Ergonomisch, Sitzkomfort, Büro. Description: An ergonomic office chair with adjustable settings for maximum comfort during long working hours. Ein ergonomischer Bürostuhl mit verstellbaren Einstellungen für maximalen Komfort bei langen Arbeitsstunden.', 0),
(2, 'Intelligente Kaffeemaschine', 'Eine Kaffeemaschine mit intelligenten Funktionen einschließlich Zeitplanung und Kontrolle der Brühstärke.', 129.99, 'product_b.png', '2024-08-03 20:54:05', 'Keywords: Smart Coffee Maker, Intelligente Kaffeemaschine, Cafetera Inteligente, Cafetière Intelligente, Macchina da Caffè Intelligente, Kaffee, Smart, Küche, Haushalt, Frühstück. Description: A smart coffee maker with programmable settings and smartphone integration. Eine intelligente Kaffeemaschine mit programmierbaren Einstellungen und Smartphone-Integration.', 15),
(3, 'Intelligenter Thermostat', 'Ein energieeffizienter intelligenter Thermostat, der Ihren Zeitplan lernt und die Temperaturen entsprechend anpasst.', 149.99, 'product_c.png', '2024-08-03 20:54:05', 'Keywords: Smart Thermostat, Intelligenter Thermostat, Termostato Inteligente, Thermostat Intelligent, Termostato Intelligente, Thermostat, Smart, Haushalt, Energie, Temperatur. Description: A smart thermostat that offers efficient temperature control and energy savings. Ein intelligenter Thermostat, der eine effiziente Temperaturregelung und Energieeinsparungen bietet.', 5),
(4, 'Wasserdichter Bluetooth-Lautsprecher', 'Ein tragbarer und wasserdichter Bluetooth-Lautsprecher mit kraftvollem Sound und langer Akkulaufzeit.', 79.99, 'product_d.png', '2024-08-03 20:54:05', 'Keywords: Waterproof Bluetooth Speaker, Wasserdichter Bluetooth-Lautsprecher, Altavoz Bluetooth Impermeable, Haut-parleur Bluetooth Étanche, Altoparlante Bluetooth Impermeabile, Bluetooth, Lautsprecher, Wasserdicht, Outdoor, Musik. Description: A waterproof Bluetooth speaker with powerful sound and long battery life. Ein wasserdichter Bluetooth-Lautsprecher mit kraftvollem Sound und langer Akkulaufzeit.', 20),
(5, 'Kopfhörer mit Geräuschunterdrückung', 'Over-Ear-Kopfhörer mit aktiver Geräuschunterdrückung und überragender Klangqualität.', 249.99, 'product_e.png', '2024-08-03 20:54:05', 'Keywords: Wireless Headphones, Kabellose Kopfhörer, Auriculares Inalámbricos, Casque Sans Fil, Cuffie Wireless, Kopfhörer, Wireless, Audio, Musik, Komfort. Description: High-quality wireless headphones with noise-cancelling technology. Hochwertige kabellose Kopfhörer mit Geräuschunterdrückungstechnologie.', 7),
(6, 'Multifunktionaler Schnellkochtopf', 'Ein vielseitiger Schnellkochtopf mit mehreren Kochmodi und großem Fassungsvermögen.', 99.99, 'product_f.png', '2024-08-03 20:54:05', 'Keywords: Multi-Cooker, Multifunktionskocher, Olla Multifuncional, Multicuiseur, Multicooker, Küche, Kochen, Smart, Haushalt, Kochen. Description: A versatile multi-cooker with pre-set cooking programs for easy meal preparation. Ein vielseitiger Multifunktionskocher mit voreingestellten Kochprogrammen für einfache Zubereitung.', 12),
(7, 'Roboterstaubsauger', 'Ein intelligenter Roboterstaubsauger mit fortschrittlicher Navigation und automatischer Aufladung.', 299.99, 'product_g.png', '2024-08-03 20:54:05', 'Keywords: Robot Vacuum Cleaner, Roboterstaubsauger, Aspiradora Robot, Aspirateur Robot, Robot Aspirapolvere, Staubsauger, Roboter, Haushalt, Reinigung, Smart. Description: A smart robot vacuum cleaner with powerful suction and automatic charging. Ein intelligenter Roboterstaubsauger mit starker Saugkraft und automatischer Aufladung.', 18),
(8, 'Intelligenter Wecker', 'Ein Wecker mit anpassbaren Alarmen, Wetteraktualisierungen und elegantem Design.', 49.99, 'product_h.png', '2024-08-03 20:54:05', 'Keywords: Smart Alarm Clock, Intelligenter Wecker, Despertador Inteligente, Réveil Intelligent, Sveglia Intelligente, Wecker, Smart, Haushalt, Schlafzimmer, Morgenroutine. Description: A smart alarm clock with customizable wake-up sounds and sunrise simulation. Ein intelligenter Wecker mit anpassbaren Wecktönen und Sonnenaufgangssimulation.', 9),
(9, 'Mikrowellenofen', 'Ein leistungsstarker Mikrowellenherd mit mehreren Kochfunktionen und benutzerfreundlichen Bedienelementen.', 119.99, 'product_i.png', '2024-08-03 20:54:05', 'Keywords: Microwave Oven, Mikrowellenofen, Horno Microondas, Four à Micro-ondes, Forno a Microonde, Mikrowelle, Küche, Kochen, Haushalt, Smart. Description: A high-efficiency microwave oven with multiple power settings and a sleek design. Ein hocheffizienter Mikrowellenofen mit mehreren Leistungsstufen und einem schlanken Design.', 22),
(10, 'Elektrische Zahnbürste', 'Eine fortschrittliche elektrische Zahnbürste mit mehreren Putzmodi und einer langlebigen Batterie.', 59.99, 'product_j.png', '2024-08-03 20:54:05', 'Keywords: Electric Toothbrush, Elektrische Zahnbürste, Cepillo de Dientes Eléctrico, Brosse à Dents Électrique, Spazzolino Elettrico, Zahnbürste, Elektrisch, Mundpflege, Smart, Gesundheit. Description: An electric toothbrush with multiple brushing modes and a long battery life. Eine elektrische Zahnbürste mit mehreren Putzmodi und langer Akkulaufzeit.', 14),
(11, 'Intelligente LED-Glühbirne', 'Eine intelligente LED-Glühbirne mit einstellbarer Farbtemperatur und Helligkeit, steuerbar über eine Smartphone-App.', 24.99, 'product_k.png', '2024-08-03 20:54:05', 'Keywords: Smart Light Bulb, Intelligente Glühbirne, Bombilla Inteligente, Ampoule Intelligente, Lampadina Intelligente, Glühbirne, Smart, Beleuchtung, Haushalt, Energie. Description: A smart light bulb with adjustable color settings and remote control via smartphone. Eine intelligente Glühbirne mit einstellbaren Farbeinstellungen und Fernbedienung über Smartphone.', 3),
(12, 'Kabellose Ladestation', 'Eine elegante kabellose Ladestation für mehrere Geräte, darunter Smartphones, Smartwatches und Ohrhörer.', 79.99, 'product_l.png', '2024-08-03 20:54:05', 'Keywords: Wireless Charging Station, Kabellose Ladestation, Estación de Carga Inalámbrica, Station de Charge Sans Fil, Stazione di Ricarica Wireless, Ladestation, Kabellos, Smartphone, Smart, Haushalt. Description: A wireless charging station compatible with multiple devices for efficient power management. Eine kabellose Ladestation, die mit mehreren Geräten kompatibel ist, für effizientes Energiemanagement.', 25),
(13, 'Kompaktes kabelloses Ladegerät', 'Ein kompaktes und effizientes kabelloses Ladegerät, das sich zum schnellen Aufladen moderner Smartphones eignet.', 39.99, 'product_m.png', '2024-08-03 20:54:05', 'Keywords: Qi Wireless Charger, Qi-Ladegerät, Cargador Inalámbrico Qi, Chargeur Sans Fil Qi, Caricatore Wireless Qi, Ladegerät, Kabellos, Smartphone, Smart, Haushalt. Description: A sleek and compact Qi wireless charger with fast charging capabilities. Ein elegantes und kompaktes Qi-Ladegerät mit Schnellladefunktionen.', 11),
(14, 'Luftreiniger mit Display', 'Ein moderner Luftreiniger mit Digitalanzeige, der eine Echtzeitüberwachung der Luftqualität und mehrstufige Filterung bietet.', 149.99, 'product_n.png', '2024-08-03 20:54:05', 'Keywords: Air Purifier, Luftreiniger, Purificador de Aire, Purificateur d’Air, Purificatore d’Aria, Luftqualität, Haushalt, Smart, Gesundheit, Luftreinigung. Description: An air purifier with HEPA filters and smart connectivity for improved indoor air quality. Ein Luftreiniger mit HEPA-Filtern und Smart-Verbindung zur Verbesserung der Raumluftqualität.', 19),
(15, 'Smarte Duschsteuerung', 'Ein fortschrittliches digitales Duschsteuerungssystem mit präziser Temperatureinstellung und Überwachung des Wasserverbrauchs.', 199.99, 'product_o.png', '2024-08-03 20:54:05', 'Keywords: Smart Shower Controller, Intelligente Duschsteuerung, Controlador de Ducha Inteligente, Contrôleur de Douche Intelligent, Controllore Doccia Intelligente, Dusche, Smart, Haushalt, Bad, Komfort. Description: A smart shower controller with temperature presets and water usage monitoring. Eine intelligente Duschsteuerung mit Temperatureinstellungen und Überwachung des Wasserverbrauchs.', 8),
(16, 'Intelligenter Badezimmerspiegel.', 'Ein intelligenter Badezimmerspiegel mit integriertem Display, Wetteraktualisierungen und Sprachsteuerungsfunktionen.', 299.99, 'product_p.png', '2024-08-03 20:54:05', 'Keywords: Smart Mirror, Intelligenter Spiegel, Espejo Inteligente, Miroir Intelligent, Specchio Intelligente, Spiegel, Smart, Haushalt, Badezimmer, Design. Description: A smart mirror with touch controls and integrated LED lighting for an enhanced user experience. Ein intelligenter Spiegel mit Touch-Bedienung und integrierter LED-Beleuchtung für ein verbessertes Benutzererlebnis.', 17),
(17, 'Mechanische Tastatur', 'Eine kompakte mechanische Tastatur mit anpassbaren Tasten und Hintergrundbeleuchtung, perfekt zum Spielen oder für den Einsatz im Büro.', 89.99, 'product_q.png', '2024-08-03 20:54:05', 'Keywords: Wireless Keyboard, Kabellose Tastatur, Teclado Inalámbrico, Clavier Sans Fil, Tastiera Wireless, Tastatur, Kabellos, Computer, Smart, Ergonomisch. Description: A wireless keyboard with ergonomic design and long-lasting battery life. Eine kabellose Tastatur mit ergonomischem Design und langer Akkulaufzeit.', 4),
(18, 'Digitaler Bilderrahmen', 'Ein digitaler Bilderrahmen mit WLAN-Konnektivität und hochauflösendem Display zur Präsentation Ihrer schönsten Momente.', 129.99, 'product_r.png', '2024-08-03 20:54:05', 'Keywords: Digital Photo Frame, Digitaler Bilderrahmen, Marco de Fotos Digital, Cadre Photo Numérique, Cornice Foto Digitale, Bilderrahmen, Digital, Smart, Haushalt, Erinnerungen. Description: A digital photo frame with slideshow functionality and wireless photo sharing. Ein digitaler Bilderrahmen mit Diashow-Funktion und drahtlosem Foto-Sharing.', 13),
(19, 'Intelligentes Waffeleisen', 'Ein intelligentes Waffeleisen mit digitaler Steuerung und mehreren Bräunungseinstellungen für jedes Mal perfekte Waffeln.', 59.99, 'product_s.png', '2024-08-03 20:54:05', 'Keywords: Waffle Maker, Waffeleisen, Gofrera, Gaufrier, Macchina per Waffle, Küche, Waffeln, Smart, Haushalt, Frühstück. Description: A waffle maker with non-stick plates and adjustable browning settings. Ein Waffeleisen mit antihaftbeschichteten Platten und einstellbaren Bräunungsstufen.', 23),
(20, 'Smartes Thermostat', 'Ein intuitiver intelligenter Thermostat, der Ihre Vorlieben lernt und die Temperatur automatisch anpasst, um Energie zu sparen.', 139.99, 'product_t.png', '2024-08-03 20:54:05', 'Keywords: Smart Thermostat, Intelligenter Thermostat, Termostato Inteligente, Thermostat Intelligent, Termostato Intelligente, Thermostat, Smart, Haushalt, Energie, Temperatur. \',\r\n    \'Description: A smart thermostat that offers efficient temperature control and energy savings. Ein intelligenter Thermostat, der eine effiziente Temperaturregelung und Energieeinsparungen bietet.\'', 6),
(21, 'Intelligenter Luftbefeuchter', 'Ein fortschrittlicher intelligenter Luftbefeuchter mit einstellbarer Luftfeuchtigkeit, Diffusor für ätherische Öle und digitaler Anzeige.', 89.99, 'product_u.png', '2024-08-03 20:54:05', 'Keywords: Ultrasonic Humidifier, Ultraschall-Luftbefeuchter, Humidificador Ultrasónico, Humidificateur à Ultrasons, Umidificatore ad Ultrasuoni, Luftbefeuchter, Smart, Haushalt, Gesundheit, Luftqualität. Description: An ultrasonic humidifier with adjustable mist settings and a large water tank for extended use. Ein Ultraschall-Luftbefeuchter mit einstellbaren Nebeleinstellungen und einem großen Wassertank für längere Nutzung.', 21),
(22, 'Drahtlose Maus', 'Eine elegante und ergonomische kabellose Maus mit hochpräzisem Tracking, perfekt für die Arbeit und zum Spielen.', 29.99, 'product_v.png', '2024-08-03 20:54:05', 'Keywords: Wireless Mouse, Kabellose Maus, Ratón Inalámbrico, Souris Sans Fil, Mouse Wireless, Maus, Kabellos, Computer, Ergonomisch, Smart. Description: A wireless mouse with ergonomic design and high precision tracking. Eine kabellose Maus mit ergonomischem Design und hochpräziser Verfolgung.', 2),
(23, 'Elektrischer Schnellkochtopf', 'Ein vielseitiger elektrischer Schnellkochtopf mit mehreren Kochmodi, ideal für die schnelle und einfache Zubereitung von Mahlzeiten.', 109.99, 'product_w.png', '2024-08-03 20:54:05', 'Keywords: Electric Pressure Cooker, Elektrischer Schnellkochtopf, Olla a Presión Eléctrica, Autocuiseur Électrique, Pentola a Pressione Elettrica, Schnellkochtopf, Elektrisch, Küche, Smart, Kochen. Description: An electric pressure cooker with multiple cooking modes and safety features. Ein elektrischer Schnellkochtopf mit mehreren Kochmodi und Sicherheitsfunktionen.', 16),
(24, 'Heizdecke', 'Eine flauschige Heizdecke mit anpassbarer Temperatureinstellung, die in kalten Nächten für Wärme und Komfort sorgt.', 59.99, 'product_x.png', '2024-08-03 20:54:05', 'Keywords: Heated Blanket, Beheizte Decke, Manta Calefactora, Couverture Chauffante, Coperta Riscaldante, Decke, Beheizt, Komfort, Haushalt, Smart. Description: A heated blanket with adjustable temperature settings and overheat protection. Eine beheizte Decke mit einstellbaren Temperatureinstellungen und Überhitzungsschutz.', 1),
(25, 'Heimkino-Projektor', 'Ein hochauflösender Heimkinoprojektor mit erweiterten Funktionen, der Ihnen ein Kinoerlebnis in Ihr Wohnzimmer bringt.', 299.99, 'product_y.png', '2024-08-03 20:54:05', 'Keywords: Home Projector, Heimprojektor, Proyector de Casa, Projecteur Domestique, Proiettore Domestico, Projektor, Heimkino, Smart, Haushalt, Unterhaltung. Description: A home projector with full HD resolution and multiple connectivity options. Ein Heimprojektor mit Full-HD-Auflösung und mehreren Anschlussmöglichkeiten.', 24),
(26, 'Standmixer', 'Eine leistungsstarke Küchenmaschine mit mehreren Geschwindigkeitseinstellungen und Aufsätzen, perfekt für alle Ihre Backbedürfnisse.', 199.99, 'product_z.png', '2024-08-03 20:54:05', 'Keywords: Stand Mixer, Küchenmaschine, Batidora de Pie, Mélangeur Sur Socle, Impastatrice Planetaria, Küchenmaschine, Haushalt, Smart, Küche, Backen. Description: A stand mixer with a powerful motor and multiple speed settings for versatile mixing. Eine Küchenmaschine mit einem leistungsstarken Motor und mehreren Geschwindigkeitsstufen für vielseitiges Mixen.', 7),
(27, 'Digitale Küchenwaage', 'Eine präzise digitale Küchenwaage mit mehreren Maßeinheiten, ideal zum genauen Wiegen von Lebensmitteln und Zutaten.', 34.99, 'product_aa.png', '2024-08-03 20:54:05', 'Keywords: Digital Kitchen Scale, Digitale Küchenwaage, Balanza de Cocina Digital, Balance de Cuisine Digitale, Bilancia da Cucina Digitale, Küchenwaage, Digital, Smart, Haushalt, Präzision. Description: A digital kitchen scale with precise measurements and an easy-to-read display. Eine digitale Küchenwaage mit präzisen Messungen und einem leicht ablesbaren Display.', 15),
(28, 'Professioneller Haartrockner', 'Ein professioneller Haartrockner mit mehreren Wärme- und Geschwindigkeitseinstellungen, der Ergebnisse in Salonqualität liefert.', 79.99, 'product_bb.png', '2024-08-03 20:54:05', 'Keywords: Professional Hair Dryer, Professioneller Haartrockner, Secador de Pelo Profesional, Sèche-cheveux Professionnel, Asciugacapelli Professionale, Haartrockner, Professionell, Smart, Schönheit, Haushalt. Description: A professional hair dryer with adjustable heat settings and ionic technology. Ein professioneller Haartrockner mit einstellbaren Hitzeeinstellungen und Ionen-Technologie.', 10),
(29, 'Intelligente Türklingel', 'Eine intelligente Türklingel mit hochauflösender Kamera und Zwei-Wege-Audio, die die Sicherheit Ihres Zuhauses erhöht.', 149.99, 'product_cc.png', '2024-08-03 20:54:05', 'Keywords: Video Doorbell, Video-Türklingel, Timbre de Video, Sonnette Vidéo, Videocitofono, Türklingel, Video, Smart, Sicherheit, Haushalt. Description: A video doorbell with HD video, two-way audio, and motion detection. Eine Video-Türklingel mit HD-Video, Zwei-Wege-Audio und Bewegungsmelder.', 5),
(30, 'Intelligenter Kühlschrank', 'Ein hochmoderner intelligenter Kühlschrank mit WLAN-Konnektivität, Touchscreen-Steuerung und erweiterten Funktionen zur Lebensmittelverwaltung.', 999.99, 'product_dd.png', '2024-08-03 20:54:05', 'Keywords: Smart Refrigerator, Intelligenter Kühlschrank, Refrigerador Inteligente, Réfrigérateur Intelligent, Frigorifero Intelligente, Kühlschrank, Smart, Haushalt, Küche, Lebensmittel. Description: A smart refrigerator with adjustable temperature zones and Wi-Fi connectivity. Ein intelligenter Kühlschrank mit einstellbaren Temperaturzonen und WLAN-Verbindung.', 20),
(31, 'Selbstreinigendes Schneidebrett', 'Ein innovatives, selbstreinigendes Schneidebrett mit integrierter UV-Sterilisation, das eine hygienische Oberfläche zur Lebensmittelzubereitung gewährleistet.', 59.99, 'product_ee.png', '2024-08-03 20:54:05', 'Keywords: UV Sterilizer Cutting Board, UV-Sterilisator Schneidebrett, Tabla de Cortar Esterilizadora UV, Planche à Découper Stérilisatrice UV, Tagliere Sterilizzatore UV, Schneidebrett, Sterilisator, Küche, Haushalt, Smart. Description: A cutting board with built-in UV sterilization to kill germs and bacteria. Ein Schneidebrett mit eingebauter UV-Sterilisation zur Abtötung von Keimen und Bakterien.', 12),
(32, 'Espressomaschine', 'Eine professionelle Espressomaschine mit anpassbaren Einstellungen, die Ihnen zu Hause kräftigen und aromatischen Kaffee liefert.', 249.99, 'product_ff.png', '2024-08-03 20:54:05', 'Keywords: Espresso Machine, Espressomaschine, Cafetera Espresso, Machine à Espresso, Macchina per Espresso, Kaffee, Espresso, Küche, Haushalt, Smart. Description: An espresso machine with adjustable settings for brewing the perfect cup. Eine Espressomaschine mit einstellbaren Einstellungen für den perfekten Kaffee.', 18),
(33, 'Intelligente Wetterstation', 'Eine intelligente Wetterstation mit Echtzeit-Updates zu Temperatur, Luftfeuchtigkeit und anderen Umweltfaktoren, gesteuert über eine Smartphone-App.', 129.99, 'product_gg.png', '2024-08-03 20:54:05', 'Keywords: Weather Station, Wetterstation, Estación Meteorológica, Station Météo, Stazione Meteo, Wetter, Smart, Haushalt, Temperatur, Luftfeuchtigkeit. Description: A smart weather station with real-time weather updates and Wi-Fi connectivity. Eine intelligente Wetterstation mit Echtzeit-Wetteraktualisierungen und WLAN-Verbindung.', 9),
(34, 'Intelligente Wasserflasche', 'Eine Hightech-Wasserflasche mit integriertem Display, das Ihren Flüssigkeitshaushalt überwacht und Sie daran erinnert, Wasser zu trinken.', 49.99, 'product_hh.png', '2024-08-03 20:54:05', 'Keywords: Smart Water Bottle, Intelligente Wasserflasche, Botella de Agua Inteligente, Bouteille d’Eau Intelligente, Bottiglia d’Acqua Intelligente, Wasserflasche, Smart, Gesundheit, Fitness, Haushalt. Description: A smart water bottle with hydration tracking and a digital display. Eine intelligente Wasserflasche mit Hydratationsüberwachung und digitaler Anzeige.', 22),
(35, 'Multikocher', 'Ein vielseitiger Multikocher mit verschiedenen Kochfunktionen, der die Essenszubereitung schnell und bequem macht.', 119.99, 'product_ii.png', '2024-08-03 20:54:05', 'Keywords: Rice Cooker, Reiskocher, Arrocera, Cuiseur à Riz, Cuociriso, Reiskocher, Küche, Smart, Haushalt, Kochen. Description: A smart rice cooker with multiple cooking modes and a non-stick inner pot. Ein intelligenter Reiskocher mit mehreren Kochmodi und einem antihaftbeschichteten Innenbehälter.', 14),
(36, 'Kabelloser Staubsauger', 'Ein leistungsstarker kabelloser Staubsauger mit mehreren Aufsätzen, perfekt, um Ihr Zuhause sauber und staubfrei zu halten.', 199.99, 'product_jj.png', '2024-08-03 20:54:05', 'Keywords: Cordless Vacuum Cleaner, Kabelloser Staubsauger, Aspiradora Inalámbrica, Aspirateur Sans Fil, Aspirapolvere Senza Fili, Staubsauger, Kabellos, Haushalt, Reinigung, Smart. Description: A cordless vacuum cleaner with powerful suction and a lightweight design. Ein kabelloser Staubsauger mit starker Saugkraft und leichtem Design.', 3);

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
(1, 'hans', '$2y$10$HLJ/o4HiCFn/kDYn5KNHne0YGF3bkv22HydRRELBhNkzQtKJOUPT6', 'hansi@gmx.de', '2024-08-03 20:55:09', 'meiningstraße 31 94276 Prackenbach', '1723267578_Motiv9.jpg', 'hansbert', 'meier', 'talstraße', '31', 'hamburg', '20359', 'Afghanistan'),
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
(19, 'uli', '$2y$10$So5rrrLC7QbI9YzK4IqKL.15RbDLf6m58EX8BC63o/NBXeCVXyYTy', 'uli@gmx.de', '2024-08-08 22:35:01', NULL, '1723157593_Motiv1.jpg', 'hermann', 'gitschorn', 'hermannstraße', '45', 'plauen', '65423', 'Polen'),
(20, 'rudolf', '$2y$10$2RYaPWS8qrOX3ZjtUKDI1evIlzz8lPTEeg.MVX0pNnR2Wqzc0B1fa', 'rufdolf@gmx.de', '2024-08-09 00:41:13', NULL, '1723171712_Motiv1.jpg', 'Otto', 'Kirchmeier', 'Juchelkstraße', '4', 'Kirchwerder', '65415', 'Österreich'),
(21, 'olga', '$2y$10$VGIOogjvHYhybCQI56pY/uvQSVfAgX3tHshmpiI8eevv3l1vBVnXC', 'olga@gmx.de', '2024-08-09 05:57:57', NULL, 'profil_icon_w.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'heinrich', '$2y$10$K467msyLqv7JJuqR9PyjZOUdTvIsJSUO1k69T.Cj96MRi6HLzK2Xm', 'heinrich@gmx.de', '2024-08-10 05:01:55', NULL, '1723266395_Motiv11.jpg', 'Heinrich', 'Jockel', 'Meiningstraße', '98', 'Prignitz', '84561', 'Deutschland'),
(23, 'heino', '$2y$10$4sVYcFP4BECJzIEPs8b.mO.RIdot7XEJp/uLCxdDnKpUhGkUAzrPq', 'heino@gmx.de', '2024-08-11 19:00:26', NULL, 'profil_icon_w.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
