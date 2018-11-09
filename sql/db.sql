-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-10-2018 a las 22:29:39
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tptickets` . Sos muy crack por no haber incluido lo MAS FUNDAMENTAL de la DB.
--

DROP DATABASE IF EXISTS tptickets;
CREATE DATABASE tptickets;
use tptickets;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
  `id_artist` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id_artist`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `artists`
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
-- Estructura de tabla para la tabla `artists_calendars`
--

CREATE TABLE IF NOT EXISTS `artists_calendars` (
  `id_artist_calendar` int(11) NOT NULL AUTO_INCREMENT,
  `id_calendar` int(11) NOT NULL,
  `id_artist` int(11) NOT NULL,
  PRIMARY KEY (`id_artist_calendar`),
  KEY `id_calendar` (`id_calendar`),
  KEY `id_artist` (`id_artist`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendars`
--

CREATE TABLE IF NOT EXISTS `calendars` (
  `id_calendar` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `id_event` int(11) NOT NULL,
  PRIMARY KEY (`id_calendar`),
  KEY `id_event` (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcado de datos para la tabla `calendars`
--

INSERT INTO calendars (id_calendar, date, id_event) VALUES (1, "2018/11/20", 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id_category`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id_category`, `type`) VALUES
(1, 'Concierto'),
(2, 'Obra Teatral');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `id_category` int(11) NOT NULL,
  `image` varchar(60) NOT NULL,
  PRIMARY KEY (`id_event`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id_event`, `name`, `id_category`, `image`) VALUES
(1, 'Luis Miguel en Argentina', 1, 'http://localhost/tptickets/img/events/imagen1.png'),
(2, 'Woodstock 2018', 1, 'http://localhost/tptickets/img/events/imagen2.png'),
(3, 'Una Obra Teatral Cualquiera', 2, 'http://localhost/tptickets/img/events/imagen3.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `places_events`
--

CREATE TABLE IF NOT EXISTS `places_events` (
  `id_place_event` int(11) NOT NULL AUTO_INCREMENT,
  `id_calendar` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id_place_event`),
  KEY `id_calendar` (`id_calendar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `id_purchase` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id_purchase`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchases_lines`
--

CREATE TABLE IF NOT EXISTS `purchases_lines` (
  `id_purchase_line` int(11) NOT NULL AUTO_INCREMENT,
  `id_seat_event` int(11) NOT NULL,
  `id_purchase` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id_purchase_line`),
  KEY `id_seat_event` (`id_seat_event`),
  KEY `id_purchase` (`id_purchase`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seat_event`
--

CREATE TABLE IF NOT EXISTS `seat_event` (
  `id_seat_event` int(11) NOT NULL AUTO_INCREMENT,
  `id_calendar` int(11) NOT NULL,
  `id_seat_type` int(11) NOT NULL,
  `quantity_available` int(11) NOT NULL,
  `price` double NOT NULL,
  `remainder` int(11) NOT NULL,
  PRIMARY KEY (`id_seat_event`),
  KEY `id_calendar` (`id_calendar`),
  KEY `id_seat_type` (`id_seat_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seat_type`
--

CREATE TABLE IF NOT EXISTS `seat_type` (
  `id_seat_type` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  PRIMARY KEY (`id_seat_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcado de datos para la tabla `seat_type`
--

INSERT INTO `seat_type` (`id_seat_type`, `description`) VALUES
(1, 'Campo'),
(2, 'Campo VIP'),
(3, 'Platea'),
(4, 'Platea Preferencial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id_ticket` int(11) NOT NULL AUTO_INCREMENT,
  `id_purchase_line` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `qr` text NOT NULL,
  PRIMARY KEY (`id_ticket`),
  KEY `id_purchase_line` (`id_purchase_line`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `is_admin` int(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `first_name`, `last_name`, `is_admin`) VALUES
(1, 'admin@tptickets.com', 'lapassword', 'El', 'Admin', 1),
(2, 'user@email.com', 'thecontra', 'Sr', 'Usuario', 0);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `artists_calendars`
--
ALTER TABLE `artists_calendars`
  ADD CONSTRAINT `artists_calendars_ibfk_2` FOREIGN KEY (`id_artist`) REFERENCES `artists` (`id_artist`) ON UPDATE CASCADE,
  ADD CONSTRAINT `artists_calendars_ibfk_1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars` (`id_calendar`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `calendars`
--
ALTER TABLE `calendars`
  ADD CONSTRAINT `calendars_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `places_events`
--
ALTER TABLE `places_events`
  ADD CONSTRAINT `places_events_ibfk_1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars` (`id_calendar`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `purchases_lines`
--
ALTER TABLE `purchases_lines`
  ADD CONSTRAINT `purchases_lines_ibfk_2` FOREIGN KEY (`id_purchase`) REFERENCES `purchases` (`id_purchase`),
  ADD CONSTRAINT `purchases_lines_ibfk_1` FOREIGN KEY (`id_seat_event`) REFERENCES `seat_event` (`id_seat_event`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `seat_event`
--
ALTER TABLE `seat_event`
  ADD CONSTRAINT `seat_event_ibfk_2` FOREIGN KEY (`id_seat_type`) REFERENCES `seat_type` (`id_seat_type`) ON UPDATE CASCADE,
  ADD CONSTRAINT `seat_event_ibfk_1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars` (`id_calendar`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`id_purchase_line`) REFERENCES `purchases_lines` (`id_purchase_line`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
