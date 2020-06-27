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

CREATE TABLE `artists_calendars` (
  `id_artist_calendar` int(11) NOT NULL,
  `id_calendar` int(11) NOT NULL,
  `id_artist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `calendars` (
  `id_calendar` int(11) NOT NULL,
  `date` date NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `categories` (`id_category`, `type`) VALUES
(1, 'Concierto'),
(2, 'Obra Teatral');

CREATE TABLE `events` (
  `id_event` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `id_category` int(11) NOT NULL,
  `image` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `events` (`id_event`, `name`, `id_category`, `image`) VALUES
(1, 'Luis Miguel en Argentina', 1, 'http://localhost/tptickets/img/default_event_img.png'),
(2, 'Woodstock 2021', 1, 'http://localhost/tptickets/img/default_event_img.png'),
(3, 'Una Obra Teatral Cualquiera', 2, 'http://localhost/tptickets/img/default_event_img.png');

CREATE TABLE `event_seats` (
  `id_event_seat` int(11) NOT NULL,
  `id_calendar` int(11) NOT NULL,
  `id_seat_type` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `remainder` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `places_events` (
  `id_place_event` int(11) NOT NULL,
  `id_calendar` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `purchases` (
  `id_purchase` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `purchases_lines` (
  `id_purchase_line` int(11) NOT NULL,
  `id_event_seat` int(11) NOT NULL,
  `id_purchase` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `seat_type` (
  `id_seat_type` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `seat_type` (`id_seat_type`, `description`) VALUES
(1, 'Campo'),
(2, 'Campo VIP'),
(3, 'Platea'),
(4, 'Platea Preferencial');

CREATE TABLE `tickets` (
  `id_ticket` int(11) NOT NULL,
  `id_purchase_line` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `qr` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD PRIMARY KEY (`id_artist_calendar`),
  ADD KEY `id_calendar` (`id_calendar`),
  ADD KEY `id_artist` (`id_artist`);

ALTER TABLE `calendars`
  ADD PRIMARY KEY (`id_calendar`),
  ADD KEY `id_event` (`id_event`);

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`),
  ADD KEY `id_category` (`id_category`);

ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `id_category` (`id_category`);

ALTER TABLE `event_seats`
  ADD PRIMARY KEY (`id_event_seat`),
  ADD KEY `id_calendar` (`id_calendar`),
  ADD KEY `id_seat_type` (`id_seat_type`);

ALTER TABLE `places_events`
  ADD PRIMARY KEY (`id_place_event`),
  ADD KEY `id_calendar` (`id_calendar`);

ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id_purchase`),
  ADD KEY `id_client` (`id_client`);

ALTER TABLE `purchases_lines`
  ADD PRIMARY KEY (`id_purchase_line`),
  ADD KEY `id_event_seat` (`id_event_seat`),
  ADD KEY `id_purchase` (`id_purchase`);

ALTER TABLE `seat_type`
  ADD PRIMARY KEY (`id_seat_type`);

ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id_ticket`),
  ADD UNIQUE KEY `id_purchase_line_2` (`id_purchase_line`),
  ADD KEY `id_purchase_line` (`id_purchase_line`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);


ALTER TABLE `artists`
  MODIFY `id_artist` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `artists_calendars`
  MODIFY `id_artist_calendar` int(11) NOT NULL AUTO_INCREMENT;

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

ALTER TABLE `seat_type`
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

ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`) ON UPDATE CASCADE;

ALTER TABLE `event_seats`
  ADD CONSTRAINT `event_seat_ibfk_1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars` (`id_calendar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_seat_ibfk_2` FOREIGN KEY (`id_seat_type`) REFERENCES `seat_type` (`id_seat_type`) ON UPDATE CASCADE;

ALTER TABLE `places_events`
  ADD CONSTRAINT `places_events_ibfk_1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars` (`id_calendar`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

ALTER TABLE `purchases_lines`
  ADD CONSTRAINT `purchases_lines_ibfk_1` FOREIGN KEY (`id_event_seat`) REFERENCES `event_seats` (`id_event_seat`) ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_lines_ibfk_2` FOREIGN KEY (`id_purchase`) REFERENCES `purchases` (`id_purchase`);

ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`id_purchase_line`) REFERENCES `purchases_lines` (`id_purchase_line`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
