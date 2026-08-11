-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 11. Aug 2026 um 13:20
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `greenstay_booking`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buchung`
--

CREATE TABLE `buchung` (
  `buchung_id` int(11) NOT NULL,
  `standort_id` int(11) NOT NULL,
  `kunde_id` int(11) NOT NULL,
  `gutschein_id` int(11) DEFAULT NULL,
  `erwachsene` int(11) NOT NULL,
  `kinder` int(11) DEFAULT 0,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `ankunftszeit` time DEFAULT '15:00:00',
  `gesamtpreis` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'PENDING',
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `buchung`
--

INSERT INTO `buchung` (`buchung_id`, `standort_id`, `kunde_id`, `gutschein_id`, `erwachsene`, `kinder`, `checkin`, `checkout`, `ankunftszeit`, `gesamtpreis`, `status`, `erstellt_am`) VALUES
(1, 1, 1, NULL, 2, 0, '2026-05-17', '2026-05-19', '15:00:00', 560.00, 'pending', '2026-05-14 13:37:26'),
(2, 1, 2, NULL, 2, 0, '2026-05-15', '2026-05-16', '15:00:00', 280.00, 'pending', '2026-05-14 20:17:39'),
(3, 1, 3, NULL, 2, 0, '2026-05-19', '2026-05-20', '15:00:00', 280.00, 'pending', '2026-05-18 21:43:08'),
(4, 1, 4, 1, 2, 0, '2026-06-01', '2026-06-04', '15:00:00', 690.00, 'pending', '2026-05-24 17:51:19'),
(5, 1, 5, 4, 2, 0, '2026-07-01', '2026-07-04', '15:00:00', 690.00, 'pending', '2026-06-25 18:48:58'),
(6, 1, 6, 7, 2, 0, '2026-07-01', '2026-07-04', '15:00:00', 690.00, 'pending', '2026-06-26 15:50:36'),
(7, 1, 7, NULL, 2, 0, '2026-07-22', '2026-07-25', '15:00:00', 840.00, 'pending', '2026-07-15 09:54:58'),
(8, 1, 8, NULL, 2, 0, '2026-08-12', '2026-08-13', '15:00:00', 250.00, 'pending', '2026-08-11 11:02:50'),
(9, 1, 9, NULL, 2, 0, '2026-08-12', '2026-08-13', '15:00:00', 280.00, 'pending', '2026-08-11 11:13:24');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buch_zus`
--

CREATE TABLE `buch_zus` (
  `buchung_id` int(11) NOT NULL,
  `zusatz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `buch_zus`
--

INSERT INTO `buch_zus` (`buchung_id`, `zusatz_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(9, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gutschein`
--

CREATE TABLE `gutschein` (
  `gutschein_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `wert` decimal(10,2) NOT NULL,
  `gueltig_bis` date NOT NULL,
  `eingeloest_am` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `gutschein`
--

INSERT INTO `gutschein` (`gutschein_id`, `code`, `wert`, `gueltig_bis`, `eingeloest_am`) VALUES
(1, 'SAVE2026', 150.00, '2026-12-31', '2026-05-24 17:51:19'),
(2, 'BUBBLE50', 50.00, '2026-12-31', NULL),
(3, 'LUXUS800', 800.00, '2026-12-31', NULL),
(4, 'SOMMER26', 150.00, '2026-12-31', '2026-06-25 18:48:58'),
(6, 'SOMMER2026', 150.00, '2026-12-31', NULL),
(7, 'SOMMER2', 150.00, '2026-12-31', '2026-06-26 15:50:36');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kunde`
--

CREATE TABLE `kunde` (
  `kunde_id` int(11) NOT NULL,
  `anrede` varchar(6) DEFAULT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `strasse_hausNr` varchar(100) NOT NULL,
  `plz` varchar(10) NOT NULL,
  `ort` varchar(50) NOT NULL,
  `land` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `kunde`
--

INSERT INTO `kunde` (`kunde_id`, `anrede`, `vorname`, `nachname`, `email`, `telefon`, `strasse_hausNr`, `plz`, `ort`, `land`) VALUES
(1, '', 'Alessandro', 'Fortunato', 'alessandro19095@hotmail.it', '017631016572', 'Alfons Goppel Straße 8', '90455', 'Nürnberg', 'Italien'),
(2, '', 'Alessandro', 'Fortunato', 'alessandro19095@hotmail.it', '017631016572', 'Alfons Goppel Straße 8', '90455', 'Nürnberg', 'Italien'),
(3, '', 'Alessandro', 'Fortunato', 'alessandro19095@hotmail.it', '017631016572', 'Alfons Goppel Straße 8', '90455', 'Nürnberg', 'Italien'),
(4, '', 'Max', 'Mustermann', 'max@test.de', '015123456789', 'Max Straße 8', '99111', 'Nürnberg', 'Deutschland'),
(5, '', 'Max', 'Mustermann', 'max@test.de', '015123456789', 'Max Straße 8', '99111', 'Nürnberg', 'Deutschland'),
(6, '', 'Max', 'Mustermann', 'max@test.de', '015123456789', 'Max Straße 8', '99111', 'Nürnberg', 'Deutschland'),
(7, '', 'Max', 'Mustermann', 'max@test.de', '015123456789', 'Max Straße 8', '99118', 'Nürnberg', 'Deutschland'),
(8, '', 'Max', 'Mustermann', 'max@test.de', '015123456789', 'Max Straße 8', '99111', 'Nürnberg', 'Deutschland'),
(9, '', 'Max', 'Mustermann', 'max@test.de', '015123456789', 'Max Straße 8', '99111', 'Nürnberg', 'Deutschland');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `standort`
--

CREATE TABLE `standort` (
  `standort_id` int(11) NOT NULL,
  `bezeichnung` varchar(100) NOT NULL,
  `preis_pro_nacht` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `standort`
--

INSERT INTO `standort` (`standort_id`, `bezeichnung`, `preis_pro_nacht`) VALUES
(1, 'GreenStay Nürnberg', 250.00),
(2, 'GreenStay München', 320.00),
(3, 'GreenStay Hamburg', 290.00);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zusatzleistung`
--

CREATE TABLE `zusatzleistung` (
  `zusatz_id` int(11) NOT NULL,
  `bezeichnung` varchar(30) NOT NULL,
  `beschreibung` text DEFAULT NULL,
  `preis` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zusatzleistung`
--

INSERT INTO `zusatzleistung` (`zusatz_id`, `bezeichnung`, `beschreibung`, `preis`) VALUES
(1, 'Romantik-Upgrade', 'Dekoration und Sekt', 30.00);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `buchung`
--
ALTER TABLE `buchung`
  ADD PRIMARY KEY (`buchung_id`),
  ADD UNIQUE KEY `gutschein_id` (`gutschein_id`),
  ADD KEY `fk_buchung_standort` (`standort_id`),
  ADD KEY `fk_buchung_kunde` (`kunde_id`);

--
-- Indizes für die Tabelle `buch_zus`
--
ALTER TABLE `buch_zus`
  ADD PRIMARY KEY (`buchung_id`,`zusatz_id`),
  ADD KEY `fk_buch_zus_zusatz` (`zusatz_id`);

--
-- Indizes für die Tabelle `gutschein`
--
ALTER TABLE `gutschein`
  ADD PRIMARY KEY (`gutschein_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indizes für die Tabelle `kunde`
--
ALTER TABLE `kunde`
  ADD PRIMARY KEY (`kunde_id`);

--
-- Indizes für die Tabelle `standort`
--
ALTER TABLE `standort`
  ADD PRIMARY KEY (`standort_id`);

--
-- Indizes für die Tabelle `zusatzleistung`
--
ALTER TABLE `zusatzleistung`
  ADD PRIMARY KEY (`zusatz_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `buchung`
--
ALTER TABLE `buchung`
  MODIFY `buchung_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `gutschein`
--
ALTER TABLE `gutschein`
  MODIFY `gutschein_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `kunde`
--
ALTER TABLE `kunde`
  MODIFY `kunde_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `standort`
--
ALTER TABLE `standort`
  MODIFY `standort_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `zusatzleistung`
--
ALTER TABLE `zusatzleistung`
  MODIFY `zusatz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `buchung`
--
ALTER TABLE `buchung`
  ADD CONSTRAINT `fk_buchung_gutschein` FOREIGN KEY (`gutschein_id`) REFERENCES `gutschein` (`gutschein_id`),
  ADD CONSTRAINT `fk_buchung_kunde` FOREIGN KEY (`kunde_id`) REFERENCES `kunde` (`kunde_id`),
  ADD CONSTRAINT `fk_buchung_standort` FOREIGN KEY (`standort_id`) REFERENCES `standort` (`standort_id`);

--
-- Constraints der Tabelle `buch_zus`
--
ALTER TABLE `buch_zus`
  ADD CONSTRAINT `fk_buch_zus_buchung` FOREIGN KEY (`buchung_id`) REFERENCES `buchung` (`buchung_id`),
  ADD CONSTRAINT `fk_buch_zus_zusatz` FOREIGN KEY (`zusatz_id`) REFERENCES `zusatzleistung` (`zusatz_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
