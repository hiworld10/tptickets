SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `tptickets` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tptickets`;

DROP TABLE IF EXISTS `artists`;
CREATE TABLE `artists` (
  `id_artist` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `artists` (`id_artist`, `name`) VALUES
(1, 'Luis Miguel'),
(2, 'Metallica'),
(3, 'Red Hot Chili Peppers'),
(4, 'Bob Dylan'),
(5, 'Iron Maiden'),
(6, 'ZZ Top'),
(7, 'Rata Blanca');

DROP TABLE IF EXISTS `artists_calendars`;
CREATE TABLE `artists_calendars` (
  `id_calendar` int(11) NOT NULL,
  `id_artist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `artists_calendars` (`id_calendar`, `id_artist`) VALUES
(1, 1),
(2, 1),
(3, 2),
(3, 3),
(3, 4),
(4, 5),
(4, 6),
(4, 7);

DROP TABLE IF EXISTS `bundles`;
CREATE TABLE `bundles` (
  `id_bundle` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `bundles` (`id_bundle`, `description`, `discount`) VALUES
(1, 'Woodstock 2021', 20);

DROP TABLE IF EXISTS `calendars`;
CREATE TABLE `calendars` (
  `id_calendar` int(11) NOT NULL,
  `date` date NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `calendars` (`id_calendar`, `date`, `id_event`) VALUES
(1, '2020-12-01', 1),
(2, '2020-12-02', 1),
(3, '2021-07-31', 2),
(4, '2021-08-01', 3);

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `categories` (`id_category`, `type`) VALUES
(1, 'Concierto'),
(2, 'Obra Teatral');

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id_event` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `id_category` int(11) NOT NULL,
  `image` varchar(60) NOT NULL,
  `id_bundle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `events` (`id_event`, `name`, `id_category`, `image`, `id_bundle`) VALUES
(1, 'Luis Miguel en Argentina', 1, 'http://localhost/tptickets/img/default_event_img.png', NULL),
(2, 'Woodstock 2021 - Día 1', 1, 'http://localhost/tptickets/img/default_event_img.png', 1),
(3, 'Woodstock 2021 - Día 2', 1, 'http://localhost/tptickets/img/default_event_img.png', 1),
(4, 'Una Obra Teatral Cualquiera', 2, 'http://localhost/tptickets/img/default_event_img.png', NULL);

DROP TABLE IF EXISTS `event_seats`;
CREATE TABLE `event_seats` (
  `id_event_seat` int(11) NOT NULL,
  `id_calendar` int(11) NOT NULL,
  `id_seat_type` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `remainder` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `event_seats` (`id_event_seat`, `id_calendar`, `id_seat_type`, `quantity`, `price`, `remainder`) VALUES
(1, 1, 1, 10000, 1000, 10000),
(2, 1, 2, 5000, 1500, 5000),
(3, 1, 3, 4000, 2000, 4000),
(4, 1, 4, 1000, 3000, 1000),
(5, 2, 1, 10000, 1000, 10000),
(6, 2, 2, 5000, 1500, 5000),
(7, 2, 3, 4000, 2000, 4000),
(8, 2, 4, 1000, 3000, 1000),
(9, 3, 1, 50000, 2000, 50000),
(10, 3, 2, 0, 0, 0),
(11, 3, 3, 0, 0, 0),
(12, 3, 4, 0, 0, 0),
(13, 4, 1, 50000, 2000, 50000),
(14, 4, 2, 0, 0, 0),
(15, 4, 3, 0, 0, 0),
(16, 4, 4, 0, 0, 0);

DROP TABLE IF EXISTS `places_events`;
CREATE TABLE `places_events` (
  `id_place_event` int(11) NOT NULL,
  `id_calendar` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `places_events` (`id_place_event`, `id_calendar`, `capacity`, `description`) VALUES
(1, 1, 20000, 'Estadio Arena'),
(2, 2, 20000, 'Estadio Arena'),
(3, 3, 50000, 'XD Arena'),
(4, 4, 50000, '');

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `id_purchase` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total` double NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `purchases_lines`;
CREATE TABLE `purchases_lines` (
  `id_purchase_line` int(11) NOT NULL,
  `id_event_seat` int(11) NOT NULL,
  `id_purchase` int(11) NOT NULL,
  `quantity` int NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `seat_types`;
CREATE TABLE `seat_types` (
  `id_seat_type` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `seat_types` (`id_seat_type`, `description`) VALUES
(1, 'Campo'),
(2, 'Campo VIP'),
(3, 'Platea'),
(4, 'Platea Preferencial');

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `id_ticket` int(11) NOT NULL,
  `id_purchase_line` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `qr` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(60) NOT NULL,
  `surname` varchar(70) NOT NULL,
  `is_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id_user`, `email`, `password`, `name`, `surname`, `is_admin`) VALUES
(1, 'admin@tptickets.com', '$2y$10$vVgK8vkRGI4/j8rJ3hqNmuuZg23MpObqTZLZ3wmEpHIdGyhAtvb/W', 'Admin', 'El', 1);


ALTER TABLE `artists`
  ADD PRIMARY KEY (`id_artist`);

ALTER TABLE `artists_calendars`
  ADD PRIMARY KEY (`id_calendar`,`id_artist`),
  ADD KEY `id_calendar` (`id_calendar`),
  ADD KEY `id_artist` (`id_artist`);

ALTER TABLE `bundles`
  ADD PRIMARY KEY (`id_bundle`);

ALTER TABLE `calendars`
  ADD PRIMARY KEY (`id_calendar`),
  ADD KEY `id_event` (`id_event`);

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`),
  ADD KEY `id_category` (`id_category`);

ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_bundle` (`id_bundle`);

ALTER TABLE `event_seats`
  ADD PRIMARY KEY (`id_event_seat`),
  ADD KEY `id_calendar` (`id_calendar`),
  ADD KEY `id_seat_type` (`id_seat_type`);

ALTER TABLE `places_events`
  ADD PRIMARY KEY (`id_place_event`),
  ADD KEY `id_calendar` (`id_calendar`);

ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id_purchase`),
  ADD KEY `id_user` (`id_user`);

ALTER TABLE `purchases_lines`
  ADD PRIMARY KEY (`id_purchase_line`),
  ADD KEY `id_event_seat` (`id_event_seat`),
  ADD KEY `id_purchase` (`id_purchase`);

ALTER TABLE `seat_types`
  ADD PRIMARY KEY (`id_seat_type`);

ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id_ticket`),
  ADD UNIQUE KEY `id_purchase_line_2` (`id_purchase_line`),
  ADD KEY `id_purchase_line` (`id_purchase_line`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);


ALTER TABLE `artists`
  MODIFY `id_artist` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `bundles`
  MODIFY `id_bundle` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `calendars`
  MODIFY `id_calendar` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `events`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `event_seats`
  MODIFY `id_event_seat` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `places_events`
  MODIFY `id_place_event` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `purchases`
  MODIFY `id_purchase` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `purchases_lines`
  MODIFY `id_purchase_line` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `seat_types`
  MODIFY `id_seat_type` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tickets`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `artists_calendars`
  ADD CONSTRAINT `artists_calendars_ibfk_1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars` (`id_calendar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `artists_calendars_ibfk_2` FOREIGN KEY (`id_artist`) REFERENCES `artists` (`id_artist`) ON UPDATE CASCADE;

ALTER TABLE `calendars`
  ADD CONSTRAINT `calendars_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON UPDATE CASCADE;

ALTER TABLE `event_seats`
  ADD CONSTRAINT `event_seat_ibfk_1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars` (`id_calendar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_seat_ibfk_2` FOREIGN KEY (`id_seat_type`) REFERENCES `seat_types` (`id_seat_type`) ON UPDATE CASCADE;

ALTER TABLE `places_events`
  ADD CONSTRAINT `places_events_ibfk_1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars` (`id_calendar`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

ALTER TABLE `purchases_lines`
  ADD CONSTRAINT `purchases_lines_ibfk_1` FOREIGN KEY (`id_event_seat`) REFERENCES `event_seats` (`id_event_seat`) ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_lines_ibfk_2` FOREIGN KEY (`id_purchase`) REFERENCES `purchases` (`id_purchase`);

ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`id_purchase_line`) REFERENCES `purchases_lines` (`id_purchase_line`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
