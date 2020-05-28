-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 28, 2020 at 05:50 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tptickets`
--

DROP DATABASE IF EXISTS tptickets;
CREATE DATABASE tptickets;
use tptickets;

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id_artist` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id_artist`, `name`) VALUES
(1, 'Luis Miguel'),
(2, 'Metallica'),
(3, 'Red Hot Chili Peppers'),
(4, 'Bob Dylan'),
(5, 'Iron Maiden'),
(6, 'ZZ Top'),
(7, 'Rata Blanca');

-- --------------------------------------------------------

--
-- Table structure for table `artists_calendars`
--

CREATE TABLE `artists_calendars` (
  `id_artist_calendar` int(11) NOT NULL,
  `id_calendar` int(11) NOT NULL,
  `id_artist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artists_calendars`
--

INSERT INTO `artists_calendars` (`id_artist_calendar`, `id_calendar`, `id_artist`) VALUES
(1, 5, 5),
(2, 5, 6),
(3, 5, 7),
(4, 6, 1),
(5, 7, 2),
(6, 7, 3),
(7, 7, 5),
(8, 7, 6);

-- --------------------------------------------------------

--
-- Table structure for table `calendars`
--

CREATE TABLE `calendars` (
  `id_calendar` int(11) NOT NULL,
  `date` date NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendars`
--

INSERT INTO `calendars` (`id_calendar`, `date`, `id_event`) VALUES
(5, '2020-08-01', 4),
(6, '2020-08-15', 1),
(7, '2020-08-30', 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_category`, `type`) VALUES
(1, 'Concierto'),
(2, 'Obra Teatral');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id_event` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `id_category` int(11) NOT NULL,
  `image` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id_event`, `name`, `id_category`, `image`) VALUES
(1, 'Luis Miguel en Argentina', 1, 'http://localhost/tptickets/img/default_event_img.png'),
(2, 'Woodstock 2021', 1, 'http://localhost/tptickets/img/default_event_img.png'),
(3, 'Una Obra Teatral Cualquiera', 2, 'http://localhost/tptickets/img/default_event_img.png'),
(4, 'WTF Festival', 1, 'http://localhost/tptickets/img/monito.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `event_seats`
--

CREATE TABLE `event_seats` (
  `id_event_seat` int(11) NOT NULL,
  `id_calendar` int(11) NOT NULL,
  `id_seat_type` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `remainder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_seats`
--

INSERT INTO `event_seats` (`id_event_seat`, `id_calendar`, `id_seat_type`, `quantity`, `price`, `remainder`) VALUES
(5, 5, 1, 5000, 500, 5000),
(6, 5, 2, 3000, 1000, 3000),
(7, 5, 3, 1500, 2500, 1500),
(8, 5, 4, 500, 5000, 500),
(9, 6, 1, 15000, 500, 15000),
(10, 6, 2, 5000, 2000, 5000),
(11, 6, 3, 7000, 3000, 7000),
(12, 6, 4, 3000, 6000, 3000),
(13, 7, 1, 30000, 1000, 30000),
(14, 7, 2, 20000, 3000, 20000),
(15, 7, 3, 0, 0, 0),
(16, 7, 4, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `places_events`
--

CREATE TABLE `places_events` (
  `id_place_event` int(11) NOT NULL,
  `id_calendar` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `places_events`
--

INSERT INTO `places_events` (`id_place_event`, `id_calendar`, `capacity`, `description`) VALUES
(5, 5, 10000, 'WTF Stadium'),
(6, 6, 30000, 'Estadio Velez'),
(7, 7, 50000, 'XD Arena');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id_purchase` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchases_lines`
--

CREATE TABLE `purchases_lines` (
  `id_purchase_line` int(11) NOT NULL,
  `id_event_seat` int(11) NOT NULL,
  `id_purchase` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seat_type`
--

CREATE TABLE `seat_type` (
  `id_seat_type` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seat_type`
--

INSERT INTO `seat_type` (`id_seat_type`, `description`) VALUES
(1, 'Campo'),
(2, 'Campo VIP'),
(3, 'Platea'),
(4, 'Platea Preferencial');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id_ticket` int(11) NOT NULL,
  `id_purchase_line` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `qr` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(60) NOT NULL,
  `surname` varchar(70) NOT NULL,
  `is_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `name`, `surname`, `is_admin`) VALUES
(1, 'admin@tptickets.com', 'lapassword', 'El', 'Admin', 1),
(2, 'user@email.com', 'thecontra', 'Sr', 'Usuario', 0),
(3, 'a@test.com', 'password', 'A', 'Test', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id_artist`);

--
-- Indexes for table `artists_calendars`
--
ALTER TABLE `artists_calendars`
  ADD PRIMARY KEY (`id_artist_calendar`),
  ADD KEY `id_calendar` (`id_calendar`),
  ADD KEY `id_artist` (`id_artist`);

--
-- Indexes for table `calendars`
--
ALTER TABLE `calendars`
  ADD PRIMARY KEY (`id_calendar`),
  ADD KEY `id_event` (`id_event`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`),
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `event_seats`
--
ALTER TABLE `event_seats`
  ADD PRIMARY KEY (`id_event_seat`),
  ADD KEY `id_calendar` (`id_calendar`),
  ADD KEY `id_seat_type` (`id_seat_type`);

--
-- Indexes for table `places_events`
--
ALTER TABLE `places_events`
  ADD PRIMARY KEY (`id_place_event`),
  ADD KEY `id_calendar` (`id_calendar`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id_purchase`),
  ADD KEY `id_client` (`id_client`);

--
-- Indexes for table `purchases_lines`
--
ALTER TABLE `purchases_lines`
  ADD PRIMARY KEY (`id_purchase_line`),
  ADD KEY `id_event_seat` (`id_event_seat`),
  ADD KEY `id_purchase` (`id_purchase`);

--
-- Indexes for table `seat_type`
--
ALTER TABLE `seat_type`
  ADD PRIMARY KEY (`id_seat_type`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `id_purchase_line` (`id_purchase_line`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id_artist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `artists_calendars`
--
ALTER TABLE `artists_calendars`
  MODIFY `id_artist_calendar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `calendars`
--
ALTER TABLE `calendars`
  MODIFY `id_calendar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_seats`
--
ALTER TABLE `event_seats`
  MODIFY `id_event_seat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `places_events`
--
ALTER TABLE `places_events`
  MODIFY `id_place_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id_purchase` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases_lines`
--
ALTER TABLE `purchases_lines`
  MODIFY `id_purchase_line` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seat_type`
--
ALTER TABLE `seat_type`
  MODIFY `id_seat_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artists_calendars`
--
ALTER TABLE `artists_calendars`
  ADD CONSTRAINT `artists_calendars_ibfk_1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars` (`id_calendar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `artists_calendars_ibfk_2` FOREIGN KEY (`id_artist`) REFERENCES `artists` (`id_artist`) ON UPDATE CASCADE;

--
-- Constraints for table `calendars`
--
ALTER TABLE `calendars`
  ADD CONSTRAINT `calendars_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`) ON UPDATE CASCADE;

--
-- Constraints for table `event_seats`
--
ALTER TABLE `event_seats`
  ADD CONSTRAINT `event_seat_ibfk_1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars` (`id_calendar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_seat_ibfk_2` FOREIGN KEY (`id_seat_type`) REFERENCES `seat_type` (`id_seat_type`) ON UPDATE CASCADE;

--
-- Constraints for table `places_events`
--
ALTER TABLE `places_events`
  ADD CONSTRAINT `places_events_ibfk_1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars` (`id_calendar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

--
-- Constraints for table `purchases_lines`
--
ALTER TABLE `purchases_lines`
  ADD CONSTRAINT `purchases_lines_ibfk_1` FOREIGN KEY (`id_event_seat`) REFERENCES `event_seats` (`id_event_seat`) ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_lines_ibfk_2` FOREIGN KEY (`id_purchase`) REFERENCES `purchases` (`id_purchase`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`id_purchase_line`) REFERENCES `purchases_lines` (`id_purchase_line`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
