-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 192.168.1.105
-- Erstellungszeit: 08. Aug 2019 um 12:07
-- Server-Version: 10.1.38-MariaDB-0+deb9u1
-- PHP-Version: 7.0.33-0+deb9u3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `nxn_esocket`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dip_list`
--

CREATE TABLE `dip_list` (
  `id` int(11) NOT NULL,
  `housecode` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `dip_list`
--

INSERT INTO `dip_list` (`id`, `housecode`) VALUES
(1, '10011'),
(2, '10111');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `icons`
--

CREATE TABLE `icons` (
  `id` int(11) NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `icons`
--

INSERT INTO `icons` (`id`, `icon`) VALUES
(1, '3dprinter'),
(2, 'amp'),
(3, 'brunnen'),
(7, 'ceiling_light'),
(14, 'ceiling_light1'),
(15, 'ceiling_light2'),
(11, 'cupboard'),
(4, 'ex5000'),
(5, 'extern_hdd'),
(10, 'fan'),
(8, 'mouse'),
(9, 'pc'),
(6, 'socket'),
(16, 'standlamp_light'),
(12, 'wii0'),
(13, 'wii1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nodes`
--

CREATE TABLE `nodes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `port` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `is_inUse` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `nodes`
--

INSERT INTO `nodes` (`id`, `name`, `location`, `ip`, `port`, `is_inUse`, `is_active`) VALUES
(1, 'node1', 'NAS', '192.168.1.105', '13337', 1, 1),
(3, 'nxn-nodeMCU-107', 'Büro', '192.168.1.107', '13337', 1, 1),
(4, 'nxn-nodeMCU-108', NULL, '192.168.1.108', '13337', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `socketcodes`
--

CREATE TABLE `socketcodes` (
  `id` int(11) NOT NULL,
  `socketcode` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `socketcodes`
--

INSERT INTO `socketcodes` (`id`, `socketcode`) VALUES
(1, '00000'),
(2, '00001'),
(3, '00011'),
(4, '00100'),
(5, '00101'),
(6, '00110'),
(7, '00111'),
(8, '01000'),
(9, '01001'),
(10, '01010'),
(11, '01011'),
(12, '01100'),
(13, '01101'),
(14, '01110'),
(15, '01111'),
(16, '10000'),
(17, '10001'),
(18, '10010'),
(19, '10011'),
(20, '10100'),
(21, '10101'),
(22, '10110'),
(23, '10111'),
(24, '11000'),
(25, '11001'),
(26, '11010'),
(27, '11011'),
(28, '11100'),
(29, '11101'),
(30, '11110'),
(31, '11111');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sockets`
--

CREATE TABLE `sockets` (
  `id` int(11) NOT NULL,
  `housecode` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `socketcode` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `controlled_device` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `hardware_active` tinyint(1) NOT NULL DEFAULT '1',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `needs_permit` tinyint(1) NOT NULL DEFAULT '0',
  `needs_confirmation` tinyint(1) NOT NULL DEFAULT '0',
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `displayOrder` int(11) NOT NULL DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `sockets`
--

INSERT INTO `sockets` (`id`, `housecode`, `socketcode`, `controlled_device`, `hardware_active`, `state`, `needs_permit`, `needs_confirmation`, `icon`, `displayOrder`) VALUES
(1, '10011', '00000', 'Mosquito EX-5000', 1, 0, 0, 1, 'ex5000', 1),
(2, '10011', '00001', 'Nintendo Wii', 1, 0, 0, 0, 'wii0', 4),
(3, '10011', '00011', 'Brunnen', 1, 0, 0, 0, 'brunnen', 99),
(4, '10011', '00100', 'Schranklicht', 1, 0, 0, 0, 'cupboard', 99),
(5, '10011', '00101', 'Laptop', 1, 0, 0, 0, NULL, 3),
(6, '10011', '00110', 'Festplatte Extern', 1, 0, 0, 1, 'extern_hdd', 99),
(7, '10011', '00111', 'Schlafzimmer', 1, 0, 0, 0, 'ceiling_light1', 2),
(8, '10011', '01000', 'Empty', 0, 0, 0, 0, NULL, 99),
(9, '10011', '01001', 'Empty', 0, 0, 0, 0, NULL, 99),
(10, '10011', '01010', 'Empty', 0, 0, 0, 0, NULL, 99),
(11, '10011', '01011', 'Empty', 0, 0, 0, 0, NULL, 99),
(12, '10011', '01100', 'Empty', 0, 0, 0, 0, NULL, 99),
(13, '10011', '01101', 'Empty', 0, 0, 0, 0, NULL, 99),
(14, '10011', '01110', 'Empty', 0, 0, 0, 0, NULL, 99);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'SHA-512 with SALT',
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` int(10) UNSIGNED NOT NULL,
  `show_raspinfo` tinyint(1) NOT NULL DEFAULT '0',
  `login_timeout` int(10) UNSIGNED NOT NULL DEFAULT '60' COMMENT 'In Minutes',
  `allow_terminal` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `last_login`, `show_raspinfo`, `login_timeout`, `allow_terminal`) VALUES
(1, 'SpReeD', 'a9d136dbc7d3a367$UNs2YbHr/rdAsX/VsO2./mFVQoQ/H12U8wY9/SPLS2l8WwITimKdx7DKeybZ3phNqGfMckvEUm4Js65oPTwN./', 'a9d136dbc7d3a367', 1565240197, 1, 120, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `dip_list`
--
ALTER TABLE `dip_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dip_main` (`housecode`);

--
-- Indizes für die Tabelle `icons`
--
ALTER TABLE `icons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `icon` (`icon`);

--
-- Indizes für die Tabelle `nodes`
--
ALTER TABLE `nodes`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `socketcodes`
--
ALTER TABLE `socketcodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `socketcode` (`socketcode`);

--
-- Indizes für die Tabelle `sockets`
--
ALTER TABLE `sockets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `constraint_icon` (`icon`),
  ADD KEY `controlled_device` (`controlled_device`),
  ADD KEY `constraint_socketcode` (`socketcode`),
  ADD KEY `constraint_housecode` (`housecode`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `dip_list`
--
ALTER TABLE `dip_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `icons`
--
ALTER TABLE `icons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `nodes`
--
ALTER TABLE `nodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `socketcodes`
--
ALTER TABLE `socketcodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT für Tabelle `sockets`
--
ALTER TABLE `sockets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `sockets`
--
ALTER TABLE `sockets`
  ADD CONSTRAINT `constraint_housecode` FOREIGN KEY (`housecode`) REFERENCES `dip_list` (`housecode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_icon` FOREIGN KEY (`icon`) REFERENCES `icons` (`icon`) ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_socketcode` FOREIGN KEY (`socketcode`) REFERENCES `socketcodes` (`socketcode`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
