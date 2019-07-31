-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 192.168.1.105
-- Erstellungszeit: 31. Jul 2019 um 19:24
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
-- Tabellenstruktur für Tabelle `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL,
  `username` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `apikey` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `api_keys`
--

INSERT INTO `api_keys` (`id`, `username`, `apikey`) VALUES
(1, 'SpReeD', '3Nyz7YNYFB3ukY9r5F5BBwLyyKxL8dtPdDUApgBReyyvzzmbGJxqpGmDhVe7ssw83ugX9eFJ7AktDdh6TT3jQka8S9KuPAzWj9PdbxhDgsHESwD2s2FVc2dsHT24LfAZ');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `sockets` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `name`, `sockets`) VALUES
(1, 'All', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cronjobs`
--

CREATE TABLE `cronjobs` (
  `id` int(11) NOT NULL,
  `socketname` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `socketid` int(11) NOT NULL,
  `task` tinyint(1) NOT NULL,
  `setlist` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '* * * * *'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `cronjobs`
--

INSERT INTO `cronjobs` (`id`, `socketname`, `socketid`, `task`, `setlist`) VALUES
(3, 'Brunnen', 3, 0, '* * * * *');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dip_list`
--

CREATE TABLE `dip_list` (
  `id` int(11) NOT NULL,
  `dip_main` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `dip_list`
--

INSERT INTO `dip_list` (`id`, `dip_main`) VALUES
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
(11, 'cupboard'),
(4, 'ex5000'),
(5, 'extern_hdd'),
(10, 'fan'),
(8, 'mouse'),
(9, 'pc'),
(6, 'socket'),
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
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `nodes`
--

INSERT INTO `nodes` (`id`, `name`, `location`, `ip`, `port`, `is_active`) VALUES
(1, 'node1', 'NAS', '192.168.1.105', '13337', 1),
(3, 'nxn-nodeMCU-107', 'Büro', '192.168.1.107', '13337', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sockets`
--

CREATE TABLE `sockets` (
  `id` int(11) NOT NULL,
  `dip_main` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `dip_second` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `controlled_device` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `hardware_active` tinyint(1) NOT NULL DEFAULT '1',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `needs_permit` tinyint(1) NOT NULL DEFAULT '0',
  `needs_confirmation` tinyint(1) NOT NULL DEFAULT '0',
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `sockets`
--

INSERT INTO `sockets` (`id`, `dip_main`, `dip_second`, `controlled_device`, `hardware_active`, `state`, `needs_permit`, `needs_confirmation`, `icon`) VALUES
(1, '10011', '1', 'Mosquito EX-5000', 1, 0, 0, 1, 'ex5000'),
(2, '10011', '2', 'Nintendo Wii', 1, 1, 0, 0, 'wii0'),
(3, '10011', '3', 'Brunnen', 1, 0, 0, 0, 'brunnen'),
(4, '10011', '4', 'Schranklicht', 1, 1, 0, 0, 'cupboard'),
(5, '10011', '5', 'AMPLIFi 75', 1, 0, 0, 1, 'amp'),
(6, '10111', '1', 'Festplatte Extern', 1, 0, 0, 1, 'extern_hdd'),
(7, '10111', '2', 'Deckenlicht', 0, 0, 0, 0, 'ceiling_light');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `system`
--

CREATE TABLE `system` (
  `id` int(11) NOT NULL,
  `company` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `homepage` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `developer` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `versionstring` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `versionint` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `system`
--

INSERT INTO `system` (`id`, `company`, `homepage`, `developer`, `versionstring`, `versionint`) VALUES
(1, 'neXn-System', 'nexn.systems', 'Markus Karl Wackermann', '2.9.7', 2970);

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
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'UNUSED !!!',
  `show_raspinfo` tinyint(1) NOT NULL DEFAULT '0',
  `login_timeout` int(10) UNSIGNED NOT NULL DEFAULT '60' COMMENT 'In Minutes',
  `allow_usersadmin` tinyint(1) NOT NULL DEFAULT '0',
  `allow_timedevents` tinyint(1) NOT NULL DEFAULT '0',
  `allow_terminal` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `last_login`, `is_admin`, `show_raspinfo`, `login_timeout`, `allow_usersadmin`, `allow_timedevents`, `allow_terminal`) VALUES
(1, 'SpReeD', 'a9d136dbc7d3a367$UNs2YbHr/rdAsX/VsO2./mFVQoQ/H12U8wY9/SPLS2l8WwITimKdx7DKeybZ3phNqGfMckvEUm4Js65oPTwN./', 'a9d136dbc7d3a367', 1564593803, 0, 1, 120, 1, 1, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `apikey` (`apikey`),
  ADD KEY `constraint_username` (`username`);

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cronjobs`
--
ALTER TABLE `cronjobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `constraint_socketname` (`socketname`),
  ADD KEY `constraint_socketid` (`socketid`);

--
-- Indizes für die Tabelle `dip_list`
--
ALTER TABLE `dip_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dip_main` (`dip_main`);

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
-- Indizes für die Tabelle `sockets`
--
ALTER TABLE `sockets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `constraint_dip_main` (`dip_main`),
  ADD KEY `constraint_icon` (`icon`),
  ADD KEY `controlled_device` (`controlled_device`);

--
-- Indizes für die Tabelle `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT für Tabelle `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `cronjobs`
--
ALTER TABLE `cronjobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `dip_list`
--
ALTER TABLE `dip_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `icons`
--
ALTER TABLE `icons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `nodes`
--
ALTER TABLE `nodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `sockets`
--
ALTER TABLE `sockets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `system`
--
ALTER TABLE `system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `api_keys`
--
ALTER TABLE `api_keys`
  ADD CONSTRAINT `constraint_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `cronjobs`
--
ALTER TABLE `cronjobs`
  ADD CONSTRAINT `constraint_socketid` FOREIGN KEY (`socketid`) REFERENCES `sockets` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_socketname` FOREIGN KEY (`socketname`) REFERENCES `sockets` (`controlled_device`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `sockets`
--
ALTER TABLE `sockets`
  ADD CONSTRAINT `constraint_dip_main` FOREIGN KEY (`dip_main`) REFERENCES `dip_list` (`dip_main`) ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_icon` FOREIGN KEY (`icon`) REFERENCES `icons` (`icon`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
