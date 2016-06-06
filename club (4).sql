-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2016 a las 03:17:25
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `club`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE IF NOT EXISTS `asistencia` (
  `id` int(11) NOT NULL,
  `id_socio` int(11) NOT NULL,
  `fecha_hora` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_social`
--

CREATE TABLE IF NOT EXISTS `categoria_social` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria_social`
--

INSERT INTO `categoria_social` (`id`, `descripcion`) VALUES
(1, 'Cadete'),
(2, 'Mayor'),
(3, 'Damas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE IF NOT EXISTS `ciudad` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id`, `descripcion`) VALUES
(1, 'Parana'),
(2, 'San Benito'),
(3, 'Colonia Avellaneda'),
(4, 'Oro Verde'),
(5, 'Diamante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobrador`
--

CREATE TABLE IF NOT EXISTS `cobrador` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(40) NOT NULL,
  `comision` decimal(15,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cobrador`
--

INSERT INTO `cobrador` (`id`, `descripcion`, `comision`) VALUES
(1, 'Administracion Central', '10.00'),
(2, 'Juan Bupo', '10.00'),
(3, 'Karina Fontana', '100.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE IF NOT EXISTS `cuenta` (
  `id` int(11) NOT NULL,
  `codigo` char(10) NOT NULL,
  `concepto` varchar(60) NOT NULL,
  `tipo_cuenta` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`id`, `codigo`, `concepto`, `tipo_cuenta`) VALUES
(1, '1', 'Activo', NULL),
(2, '2', 'Pasivo', NULL),
(3, '3', 'Patrimonio', NULL),
(4, '4', 'Resultado', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `debito`
--

CREATE TABLE IF NOT EXISTS `debito` (
  `id` int(11) NOT NULL,
  `concepto` varchar(60) NOT NULL,
  `importe` decimal(15,2) NOT NULL,
  `subcuenta_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `debito`
--

INSERT INTO `debito` (`id`, `concepto`, `importe`, `subcuenta_id`) VALUES
(19, 'Cuota Activo', '10.00', 38),
(20, 'CD Voley', '100.00', 42),
(21, 'CD Futbol', '150.00', 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_cuenta`
--

CREATE TABLE IF NOT EXISTS `estado_cuenta` (
  `id` int(11) NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `periodo_mes` int(11) NOT NULL,
  `periodo_anio` int(11) NOT NULL,
  `socio_id` int(11) NOT NULL,
  `fecha_pago` date DEFAULT NULL,
  `importe_apagar` decimal(15,2) NOT NULL,
  `importe_pagado` decimal(15,2) DEFAULT NULL,
  `subcuenta_id` int(11) NOT NULL,
  `nro_recibo` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_cuenta`
--

INSERT INTO `estado_cuenta` (`id`, `fecha_vencimiento`, `periodo_mes`, `periodo_anio`, `socio_id`, `fecha_pago`, `importe_apagar`, `importe_pagado`, `subcuenta_id`, `nro_recibo`) VALUES
(1, '1970-01-01', 1, 2016, 1, NULL, '10.00', NULL, 38, NULL),
(2, '1970-01-01', 1, 2016, 1, NULL, '100.00', NULL, 42, NULL),
(3, '1970-01-01', 1, 2016, 1, NULL, '150.00', NULL, 41, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE IF NOT EXISTS `movimiento` (
  `id` int(11) NOT NULL,
  `nro_recibo` int(11) DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `fk_prov` int(11) DEFAULT NULL,
  `fk_cliente` int(11) DEFAULT NULL,
  `obs` varchar(150) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `movimiento`
--

INSERT INTO `movimiento` (`id`, `nro_recibo`, `fecha_pago`, `fk_prov`, `fk_cliente`, `obs`) VALUES
(1, NULL, '2016-06-01', NULL, 1, NULL),
(2, NULL, '2016-06-01', NULL, 1, NULL),
(3, 90, '2016-06-01', NULL, 1, NULL),
(5, NULL, NULL, NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_detalle`
--

CREATE TABLE IF NOT EXISTS `movimiento_detalle` (
  `id` int(11) NOT NULL,
  `tipo` char(1) NOT NULL,
  `movimiento_id` int(11) NOT NULL,
  `subcuenta_id` int(11) NOT NULL,
  `subcuenta_id_fp` int(11) DEFAULT NULL COMMENT 'forma de pago (efectivo cheque) id de la subcuenta',
  `importe` varchar(15) DEFAULT NULL,
  `periodo_mes` int(11) DEFAULT NULL,
  `periodo_anio` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `movimiento_detalle`
--

INSERT INTO `movimiento_detalle` (`id`, `tipo`, `movimiento_id`, `subcuenta_id`, `subcuenta_id_fp`, `importe`, `periodo_mes`, `periodo_anio`) VALUES
(1, 'i', 1, 38, 4, '10.00', 1, 2016),
(2, 'i', 1, 42, 4, '100.00', 1, 2016),
(4, 'i', 2, 41, 4, '0', 1, 2016),
(5, 'i', 3, 38, 4, '10.00', 2, 2016),
(6, 'i', 3, 42, 4, '100.00', 2, 2016),
(7, 'i', 3, 41, 4, '150.00', 2, 2016),
(8, 'i', 5, 38, NULL, '10.00', 1, 2016),
(9, 'i', 5, 42, NULL, '100.00', 1, 2016);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE IF NOT EXISTS `proveedor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `cuit` varchar(15) NOT NULL,
  `cond_iva` varchar(20) NOT NULL,
  `direccion` varchar(80) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `rubro` varchar(80) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `nombre`, `cuit`, `cond_iva`, `direccion`, `telefono`, `email`, `rubro`) VALUES
(1, 'Enersa', '30-12345678-0', '1', 'lala', '43488788', '', 'energia'),
(2, 'Arnet', '33-54878787-9', '1', 'Ni idea', '43488788', 'lala@jojo.com', 'Internet');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE IF NOT EXISTS `provincia` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`id`, `descripcion`) VALUES
(1, 'Entre Rios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo`
--

CREATE TABLE IF NOT EXISTS `recibo` (
  `id` int(11) NOT NULL,
  `i` int(11) DEFAULT NULL,
  `e` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `recibo`
--

INSERT INTO `recibo` (`id`, `i`, `e`) VALUES
(1, 90, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE IF NOT EXISTS `socio` (
  `id` int(11) NOT NULL,
  `apellido_nombre` varchar(80) NOT NULL,
  `cp` char(15) DEFAULT NULL,
  `direccion` varchar(60) DEFAULT NULL,
  `dni` int(11) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL,
  `obs` varchar(150) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `nombre_foto` varchar(25) DEFAULT NULL,
  `id_categoria_social` int(11) DEFAULT NULL,
  `id_ciudad` int(11) DEFAULT '2',
  `id_cobrador` int(11) DEFAULT NULL,
  `matricula` int(11) DEFAULT NULL,
  `id_provincia` int(11) DEFAULT '1',
  `sexo` char(1) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `telefono2` varchar(15) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=537 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`id`, `apellido_nombre`, `cp`, `direccion`, `dni`, `email`, `fecha_alta`, `fecha_baja`, `obs`, `fecha_nacimiento`, `nombre_foto`, `id_categoria_social`, `id_ciudad`, `id_cobrador`, `matricula`, `id_provincia`, `sexo`, `telefono`, `telefono2`) VALUES
(1, 'Chajud Canete Thiago Benjamin', '', '', 50072357, '', NULL, NULL, '', '2010-08-11', NULL, 1, 2, 1, NULL, 1, '', '', ''),
(2, 'Cucuzza Guillermo Tomas', NULL, NULL, 49860014, NULL, NULL, NULL, NULL, '2010-01-12', NULL, 2, 2, 1, NULL, 1, NULL, NULL, NULL),
(3, 'David Lautoro Isaias', NULL, NULL, 50072314, NULL, NULL, NULL, NULL, '2010-06-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(4, 'Fontanini Aguirre Juan Andres', NULL, NULL, 50248110, NULL, NULL, NULL, NULL, '2010-04-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(5, 'Godoy Berlari Mateo Valentin', NULL, NULL, 49792111, NULL, NULL, NULL, NULL, '2010-01-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(6, 'Godoy Santino Genaro', NULL, NULL, 50747597, NULL, NULL, NULL, NULL, '2011-02-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(7, 'Gregorutti Genaro', NULL, NULL, 50731852, NULL, NULL, NULL, NULL, '2011-01-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(8, 'Regner Yoel Santino', NULL, NULL, 50183359, NULL, NULL, NULL, NULL, '2010-04-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(9, 'Sarquis Leonel', NULL, NULL, 50445505, NULL, NULL, NULL, NULL, '2010-09-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(10, 'Barreto Lucas Sebastian', NULL, NULL, 49440970, NULL, NULL, NULL, NULL, '2009-03-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(11, 'Chimento Santa Maria  Isai', NULL, NULL, 49792109, NULL, NULL, NULL, NULL, '2009-12-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(12, 'Franco Axel', NULL, NULL, 49512180, NULL, NULL, NULL, NULL, '2009-10-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(13, 'Mendoza Varisco Valentino Roman', NULL, NULL, 48906483, NULL, NULL, NULL, NULL, '2009-02-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(14, 'Milocoo Radamel Eros Bartolome', NULL, NULL, 49819455, NULL, NULL, NULL, NULL, '2009-10-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(15, 'Neto Joaquin', NULL, NULL, 49296815, NULL, NULL, NULL, NULL, '2009-04-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(16, 'Orega Juan Ignacio', NULL, NULL, 49512197, NULL, NULL, NULL, NULL, '2009-11-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(17, 'Rodriguez Gael', NULL, NULL, 49334475, NULL, NULL, NULL, NULL, '2009-06-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(18, 'Silva Aaron Jesus', NULL, NULL, 48906495, NULL, NULL, NULL, NULL, '2009-02-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(19, 'Tarabini Amilcar', NULL, NULL, 49296764, NULL, NULL, NULL, NULL, '2009-03-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(20, 'Vicentin Nemias', NULL, NULL, 49512173, NULL, NULL, NULL, NULL, '2009-10-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(21, 'Rodriguez Musich Lautaro', NULL, NULL, 49512183, NULL, NULL, NULL, NULL, '2009-10-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(22, 'Moreyra Misael Leonel', NULL, NULL, 49512105, NULL, NULL, NULL, NULL, '2009-06-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(23, 'Dumon Emiliano Tomas', NULL, NULL, 48960633, NULL, NULL, NULL, NULL, '2008-09-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(24, 'Garzon Stang Vladimir', NULL, NULL, 48823370, NULL, NULL, NULL, NULL, '2008-07-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(25, 'Hengenreder Axel Elias', NULL, NULL, 48402976, NULL, NULL, NULL, NULL, '2008-01-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(26, 'Hillairet Lucas Emanuel', NULL, NULL, 48202262, NULL, NULL, NULL, NULL, '2008-01-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(27, 'Maidana Agustin', NULL, NULL, 48824662, NULL, NULL, NULL, NULL, '2008-05-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(28, 'Molina Felipe', NULL, NULL, 48823355, NULL, NULL, NULL, NULL, '2008-06-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(29, 'Paez Facundo Jesus', NULL, NULL, 48621799, NULL, NULL, NULL, NULL, '2008-04-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(30, 'Paez Lagorio Guillermo Oscar', NULL, NULL, 48907015, NULL, NULL, NULL, NULL, '2008-08-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(31, 'Rodriguez Ballejo Franisco Jesus', NULL, NULL, 48476334, NULL, NULL, NULL, NULL, '2008-05-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(32, 'Sosa Geronimo Benjamin', NULL, NULL, 48202286, NULL, NULL, NULL, NULL, '2008-02-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(33, 'Vilte Franco Benjamin', NULL, NULL, 48409479, NULL, NULL, NULL, NULL, '2008-01-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(34, 'Ali Naim Jesus', NULL, NULL, 47756999, NULL, NULL, NULL, NULL, '2007-03-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(35, 'Almada Zahir', NULL, NULL, 47705622, NULL, NULL, NULL, NULL, '2007-01-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(36, 'Almarante Gaspar Valentin ', NULL, NULL, 47925860, NULL, NULL, NULL, NULL, '2007-04-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(37, 'Bergara Pereira Tadeo Juan Manuel ', NULL, NULL, 47705649, NULL, NULL, NULL, NULL, '2007-02-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(38, 'Bernard Ignacio Genardo', NULL, NULL, 48202252, NULL, NULL, NULL, NULL, '2007-12-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(39, 'Bertolami Ramiro Alejandro', NULL, NULL, 47705613, NULL, NULL, NULL, NULL, '2007-01-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(40, 'Cejas Pablo Benicio', NULL, NULL, 47982169, NULL, NULL, NULL, NULL, '2007-05-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(41, 'Dabin Francisco', NULL, NULL, 48138646, NULL, NULL, NULL, NULL, '2007-07-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(42, 'Diaz Diego  Ulises', NULL, NULL, 43539680, NULL, NULL, NULL, NULL, '2007-08-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(43, 'Diaz Rodrigo Leonardo Exequiel', NULL, NULL, 47925986, NULL, NULL, NULL, NULL, '2007-04-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(44, 'Duro Lautaro Jose', NULL, NULL, 47705676, NULL, NULL, NULL, NULL, '2007-04-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(45, 'Gasparin Santiago Nicolas', NULL, NULL, 48335368, NULL, NULL, NULL, NULL, '2007-12-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(46, 'Giusti Gabriel', NULL, NULL, 47397266, NULL, NULL, NULL, NULL, '2007-08-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(47, 'Godoy Berlari Pilar Angelina', NULL, NULL, 47982175, NULL, NULL, NULL, NULL, '2007-07-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(48, 'Godoy Leyes Tomas', NULL, NULL, 48335554, NULL, NULL, NULL, NULL, '2007-12-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(49, 'Perez Thiago Demian', NULL, NULL, 48202206, NULL, NULL, NULL, NULL, '2007-09-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(50, 'Portillo Xavier Hugo Gadiel', NULL, NULL, 47705697, NULL, NULL, NULL, NULL, '2007-05-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(51, 'Retamar Leonel Emiliano', NULL, NULL, 47705685, NULL, NULL, NULL, NULL, '2007-04-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(52, 'Retamar Pablo Nicolas', NULL, NULL, 47844116, NULL, NULL, NULL, NULL, '2007-03-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(53, 'Rivero Maximo Gabriel', NULL, NULL, 48202233, NULL, NULL, NULL, NULL, '2007-10-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(54, 'Robles Jesuan Jair', NULL, NULL, 48202207, NULL, NULL, NULL, NULL, '2007-08-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(55, 'Salinas Herera Enzo MARTIN', NULL, NULL, 47705664, NULL, NULL, NULL, NULL, '2007-04-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(56, 'Sarquis Nehemias Nahuel', NULL, NULL, 48824495, NULL, NULL, NULL, NULL, '2008-08-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(57, 'Segovia Cristian Exequiel', NULL, NULL, 48337112, NULL, NULL, NULL, NULL, '2007-08-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(58, 'Zuiani Juan Cruz', NULL, NULL, 47926404, NULL, NULL, NULL, NULL, '2007-04-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(59, 'Banno Cristobal Giovani', NULL, NULL, 47623129, NULL, NULL, NULL, NULL, '2006-10-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(60, 'Basso Nicolas Agustin ', NULL, NULL, 47522355, NULL, NULL, NULL, NULL, '2006-09-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(61, 'Benite Weser Amilcar Lautaro', NULL, NULL, 47522379, NULL, NULL, NULL, NULL, '2006-10-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(62, 'Butus Tomas Agustin', NULL, NULL, 47244535, NULL, NULL, NULL, NULL, '2006-03-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(63, 'Ferreira Valentin ', NULL, NULL, 47409082, NULL, NULL, NULL, NULL, '2006-05-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(64, 'Flematti Dylan Ivan', NULL, NULL, 46976975, NULL, NULL, NULL, NULL, '2006-02-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(65, 'Flores Isaias Fabian', NULL, NULL, 47522357, NULL, NULL, NULL, NULL, '2006-09-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(66, 'Godoy Nelson Ariel', NULL, NULL, 47706661, NULL, NULL, NULL, NULL, '2006-11-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(67, 'Gomez Samuel Gustavo Isaias', NULL, NULL, 46592937, NULL, NULL, NULL, NULL, '2006-03-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(68, 'Lopez Milton Ernesto', NULL, NULL, 47175651, NULL, NULL, NULL, NULL, '2006-05-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(69, 'Lopez Santiago Valentin', NULL, NULL, 47408881, NULL, NULL, NULL, NULL, '2006-07-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(70, 'Maldonado Ignacio', NULL, NULL, 47244617, NULL, NULL, NULL, NULL, '2006-02-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(71, 'Martinez Prinsich Lisandro', NULL, NULL, 47410376, NULL, NULL, NULL, NULL, '2006-09-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(72, 'Monzon Martin Leonel', NULL, NULL, 47410371, NULL, NULL, NULL, NULL, '2006-06-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(73, 'Orega  Luciano Hernan', NULL, NULL, 47527950, NULL, NULL, NULL, NULL, '2006-09-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(74, 'Pisech Franchescon julian', NULL, NULL, 46779076, NULL, NULL, NULL, NULL, '2006-02-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(75, 'Saavedra Tomas', NULL, NULL, 46779090, NULL, NULL, NULL, NULL, '2006-02-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(76, 'Tomasini Maximo ', NULL, NULL, 47244544, NULL, NULL, NULL, NULL, '2006-03-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(77, 'Ceparo Francisco Daniel', NULL, NULL, 46319485, NULL, NULL, NULL, NULL, '2005-03-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(78, 'Dibur Emanuel Ernesto', NULL, NULL, 46519401, NULL, NULL, NULL, NULL, '2005-05-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(79, 'Ducret Marcos Hernan', NULL, NULL, 46927595, NULL, NULL, NULL, NULL, '2005-12-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(80, 'Duro Ivan Leonel', NULL, NULL, 46466980, NULL, NULL, NULL, NULL, '2005-06-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(81, 'Giles Cristian Alexis', NULL, NULL, 46466934, NULL, NULL, NULL, NULL, '2005-04-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(82, 'Leguizamon Alexis Exequiel', NULL, NULL, 46466952, NULL, NULL, NULL, NULL, '2005-05-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(83, 'Maciel Perez Laureano', NULL, NULL, 46318818, NULL, NULL, NULL, NULL, '2005-01-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(84, 'Muller Lucas Emanuel', NULL, NULL, 46779015, NULL, NULL, NULL, NULL, '2005-09-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(85, 'Nani Tobias Agustin', NULL, NULL, 46083000, NULL, NULL, NULL, NULL, '2005-02-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(86, 'Pereira Axel José', NULL, NULL, 46082986, NULL, NULL, NULL, NULL, '2005-01-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(87, 'Quiñones Facundo Javier', NULL, NULL, 46519257, NULL, NULL, NULL, NULL, '2005-03-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(88, 'Rey Nicolas', NULL, NULL, 46779701, NULL, NULL, NULL, NULL, '2005-10-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(89, 'Riggio Joaquin Exequiel', NULL, NULL, 46779036, NULL, NULL, NULL, NULL, '2005-11-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(90, 'Silva Gabriel Alejandro', NULL, NULL, 46466961, NULL, NULL, NULL, NULL, '2005-05-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(91, 'Alarcon Moorman Valentino', NULL, NULL, 45755359, NULL, NULL, NULL, NULL, '2004-05-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(92, 'Barreto Brian', NULL, NULL, 46150750, NULL, NULL, NULL, NULL, '2004-09-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(93, 'Bertolami Cabrera Ibar Jesus Alberto', NULL, NULL, 46082903, NULL, NULL, NULL, NULL, '2004-09-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(94, 'Camejo Emiliano Misael ', NULL, NULL, 46319311, NULL, NULL, NULL, NULL, '2004-12-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(95, 'Comas Jacob Lucas', NULL, NULL, 45946415, NULL, NULL, NULL, NULL, '2004-07-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(96, 'Deharbe Donda Enzo Gabriel', NULL, NULL, 45552743, NULL, NULL, NULL, NULL, '2004-03-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(97, 'Espinosa Valentin  Nicolas', NULL, NULL, 46082925, NULL, NULL, NULL, NULL, '2004-09-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(98, 'Holzman Aaron Maximiliano ', NULL, NULL, 45846642, NULL, NULL, NULL, NULL, '2004-08-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(99, 'Jesus Dominguez Italo Roberto', NULL, NULL, 45436978, NULL, NULL, NULL, NULL, '2004-05-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(100, 'Lencina Lucas German', NULL, NULL, 46150894, NULL, NULL, NULL, NULL, '2004-10-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(101, 'Messeder Schmunk Ian Ayrton Nicolas', NULL, NULL, 46082979, NULL, NULL, NULL, NULL, '2004-12-31', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(102, 'Monzon Emanuel', NULL, NULL, 45617179, NULL, NULL, NULL, NULL, '2004-04-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(103, 'Noguera Ian', NULL, NULL, 46151099, NULL, NULL, NULL, NULL, '2004-12-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(104, 'Perez Leandro Agustin Sebastian', NULL, NULL, 46082975, NULL, NULL, NULL, NULL, '2004-12-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(105, 'Perez Yanz Magali Gianella', NULL, NULL, 46082904, NULL, NULL, NULL, NULL, '2004-07-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(106, 'Pross Joaquin', NULL, NULL, 46150791, NULL, NULL, NULL, NULL, '2004-10-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(107, 'Puntin Matias Axel', NULL, NULL, 45845172, NULL, NULL, NULL, NULL, '2004-07-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(108, 'Rapisarda Alejo Ruben Ignacio', NULL, NULL, 46150873, NULL, NULL, NULL, NULL, '2004-10-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(109, 'Retamar Marcos Sebastian', NULL, NULL, 45846624, NULL, NULL, NULL, NULL, '2004-10-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(110, 'Romero Fernandez Aron', NULL, NULL, 46319137, NULL, NULL, NULL, NULL, '2004-12-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(111, 'Russian Gianfranco', NULL, NULL, 46150092, NULL, NULL, NULL, NULL, '2004-11-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(112, 'Tarabini Valentin Alejandro', NULL, NULL, 45150550, NULL, NULL, NULL, NULL, '2004-08-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(113, 'Uhrig Alejandro', NULL, NULL, 45952819, NULL, NULL, NULL, NULL, '2004-07-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(114, 'Aguilar Mirko Sergio ', NULL, NULL, 45216201, NULL, NULL, NULL, NULL, '2003-08-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(115, 'Amado Hernan Valentin', NULL, NULL, 44862963, NULL, NULL, NULL, NULL, '2003-07-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(116, 'Ayala Naim German', NULL, NULL, 44702463, NULL, NULL, NULL, NULL, '2003-04-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(117, 'Balbuena Fernando Jose', NULL, NULL, 45336678, NULL, NULL, NULL, NULL, '2003-11-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(118, 'Barreto Agustin Alejandro', NULL, NULL, 44843305, NULL, NULL, NULL, NULL, '2003-09-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(119, 'Bernhard Loana Magali', NULL, NULL, 44862930, NULL, NULL, NULL, NULL, '2003-05-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(120, 'Bonaldi Israel', NULL, NULL, 45087634, NULL, NULL, NULL, NULL, '2003-04-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(121, 'Cardozo Bruno Alberto', NULL, NULL, 45167755, NULL, NULL, NULL, NULL, '2003-10-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(122, 'Carrere Valentino Agustin ', NULL, NULL, 44644362, NULL, NULL, NULL, NULL, '2003-01-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(123, 'Corradini Facundo Javier', NULL, NULL, 45167766, NULL, NULL, NULL, NULL, '2003-10-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(124, 'Espinosa Felipe Dario', NULL, NULL, 44903757, NULL, NULL, NULL, NULL, '2003-07-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(125, 'Franco Fernando Exequiel', NULL, NULL, 44843333, NULL, NULL, NULL, NULL, '2003-05-31', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(126, 'Ledesma Martin ', NULL, NULL, 45167139, NULL, NULL, NULL, NULL, '2003-12-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(127, 'Ledesma Tobias Ivan', NULL, NULL, 44843347, NULL, NULL, NULL, NULL, '2003-07-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(128, 'Mayer Joan Joel Jesus', NULL, NULL, 45387841, NULL, NULL, NULL, NULL, '2003-11-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(129, 'Merlo Eduardo Emanuel', NULL, NULL, 44843306, NULL, NULL, NULL, NULL, '2003-04-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(130, 'Perez Vladimir Yonatan Santiago', NULL, NULL, 45167727, NULL, NULL, NULL, NULL, '2003-08-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(131, 'Pisech carlos Gabriel  Alexsander', NULL, NULL, 44644391, NULL, NULL, NULL, NULL, '2003-03-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(132, 'Puntin Kevin', NULL, NULL, 44763514, NULL, NULL, NULL, NULL, '2003-05-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(133, 'Retamar Milton José', NULL, NULL, 45387845, NULL, NULL, NULL, NULL, '2003-11-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(134, 'Salinas Herrera Axel Nicolas Alejandro', NULL, NULL, 45167726, NULL, NULL, NULL, NULL, '2003-09-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(135, 'Schamne Kevin Guillermo', NULL, NULL, 44556398, NULL, NULL, NULL, NULL, '2003-02-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(136, 'Tentor Theo Carlos Maria', NULL, NULL, 45387842, NULL, NULL, NULL, NULL, '2003-12-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(137, 'Thomas Jeremias Ezequiel', NULL, NULL, 45168200, NULL, NULL, NULL, NULL, '2003-11-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(138, 'Torne Renzo Mariano', NULL, NULL, 44843326, NULL, NULL, NULL, NULL, '2003-04-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(139, 'Velazquez Federico Ruben', NULL, NULL, 44644392, NULL, NULL, NULL, NULL, '2003-03-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(140, 'Yanes Lautaro Tomas Natanael', NULL, NULL, 45617143, NULL, NULL, NULL, NULL, '2003-05-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(141, 'Zatti Lautaro Juan Gabriel', NULL, NULL, 45167713, NULL, NULL, NULL, NULL, '2003-08-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(142, 'Buxman Cramaro Cesar Martin', NULL, NULL, 44497199, NULL, NULL, NULL, NULL, '2002-11-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(143, 'Cabrera Rodrigo Alexis', NULL, NULL, 44104092, NULL, NULL, NULL, NULL, '2002-06-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(144, 'Cardozo Jeremias Gabriel', NULL, NULL, 44104096, NULL, NULL, NULL, NULL, '2002-06-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(145, 'Centurion Lucas Jose Maria', NULL, NULL, 43755876, NULL, NULL, NULL, NULL, '2002-01-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(146, 'Franco Enzo ', NULL, NULL, 44368805, NULL, NULL, NULL, NULL, '2002-07-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(147, 'Gomez Juan Fransisco', NULL, NULL, 44644356, NULL, NULL, NULL, NULL, '2002-12-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(148, 'Leiva Gabriel Hernan', NULL, NULL, 44525338, NULL, NULL, NULL, NULL, '2002-10-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(149, 'Maciel Perez Ibar Juan Cruz', NULL, NULL, 44283881, NULL, NULL, NULL, NULL, '2002-07-31', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(150, 'Montero Roskoff Emanuel Esteban', NULL, NULL, 44034827, NULL, NULL, NULL, NULL, '2002-05-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(151, 'Palacio  Mateo Eduardo', NULL, NULL, 44644363, NULL, NULL, NULL, NULL, '2002-12-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(152, 'Ramirez Deharbe Nazareno Fabian', NULL, NULL, 44104068, NULL, NULL, NULL, NULL, '2002-05-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(153, 'Ramirez Rodrigo Alejandro', NULL, NULL, 44034688, NULL, NULL, NULL, NULL, '2002-03-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(154, 'Silva Facundo Agustin', NULL, NULL, 43937243, NULL, NULL, NULL, NULL, '2002-02-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(155, 'Suarez de Mondesert Adriel Ezequiel', NULL, NULL, 44497188, NULL, NULL, NULL, NULL, '2002-11-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(156, 'Tomasini Franco Dario', NULL, NULL, 44152040, NULL, NULL, NULL, NULL, '2002-08-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(157, 'Walter Gonzalo Exequiel', NULL, NULL, 44367684, NULL, NULL, NULL, NULL, '2002-08-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(158, 'Balbuena Guillermo Alejandro', NULL, NULL, 43294849, NULL, NULL, NULL, NULL, '2001-04-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(159, 'Bovier Fabricio Hernan', NULL, NULL, 43296252, NULL, NULL, NULL, NULL, '2001-04-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(160, 'Brizuela Facundo', NULL, NULL, 43350279, NULL, NULL, NULL, NULL, '2001-06-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(161, 'Cardozo Tomas Uriel', NULL, NULL, 43350265, NULL, NULL, NULL, NULL, '2001-06-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(162, 'De Mondesert Adrian', NULL, NULL, 43539643, NULL, NULL, NULL, NULL, '2001-07-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(163, 'Diaz Diego  Ulises', NULL, NULL, 43539680, NULL, NULL, NULL, NULL, '2001-08-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(164, 'Espinosa Daniel Alejandro', NULL, NULL, 43538630, NULL, NULL, NULL, NULL, '2001-09-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(165, 'Gallardo Axel Nataniel', NULL, NULL, 43513570, NULL, NULL, NULL, NULL, '2001-12-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(166, 'Gomez Villaverde Enzo', NULL, NULL, 43348751, NULL, NULL, NULL, NULL, '2001-05-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(167, 'Pereira Roman Ariel', NULL, NULL, 43350292, NULL, NULL, NULL, NULL, '2001-07-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(168, 'Perez Cristian Nicolas  José', NULL, NULL, 43827262, NULL, NULL, NULL, NULL, '2001-11-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(169, 'Quiroga Mateo', NULL, NULL, 43296226, NULL, NULL, NULL, NULL, '2001-02-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(170, 'Retamar Sergio Agustin', NULL, NULL, 43350274, NULL, NULL, NULL, NULL, '2001-04-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(171, 'Rios Lucas Franco', NULL, NULL, 43113837, NULL, NULL, NULL, NULL, '2001-01-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(172, 'Barrios Axel Daniel', NULL, NULL, 42241245, NULL, NULL, NULL, NULL, '2000-01-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(173, 'Bevilacqua Tomas Santiago', NULL, NULL, 42601019, NULL, NULL, NULL, NULL, '2000-05-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(174, 'Bovier Alcides Gabino', NULL, NULL, 42241232, NULL, NULL, NULL, NULL, '2000-01-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(175, 'Caisso Nicolas Andres', NULL, NULL, 42464892, NULL, NULL, NULL, NULL, '2000-02-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(176, 'Cuadra  Jean Franco', NULL, NULL, 42920160, NULL, NULL, NULL, NULL, '2000-09-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(177, 'Franco Diego Lucas Nahuel', NULL, NULL, 42732316, NULL, NULL, NULL, NULL, '2000-07-31', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(178, 'Garcia Matias Agustin', NULL, NULL, 43296230, NULL, NULL, NULL, NULL, '2001-02-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(179, 'Gervazoni Gabriel', NULL, NULL, 42601050, NULL, NULL, NULL, NULL, '2000-08-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(180, 'Monzon Ivan Gerardo', NULL, NULL, 42852345, NULL, NULL, NULL, NULL, '2000-09-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(181, 'Nani Lucas Hernan', NULL, NULL, 42852341, NULL, NULL, NULL, NULL, '2000-10-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(182, 'Perez Alexis Hector Jesus', NULL, NULL, 42464599, NULL, NULL, NULL, NULL, '2000-05-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(183, 'Perez Matias', NULL, NULL, 42852336, NULL, NULL, NULL, NULL, '2000-10-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(184, 'Sahian Thiago Agustin', NULL, NULL, 43114203, NULL, NULL, NULL, NULL, '2000-11-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(185, 'Sanchez Walter Andres', NULL, NULL, 42852303, NULL, NULL, NULL, NULL, '2000-04-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(186, 'Sangoy Nahuel Agustin', NULL, NULL, 42470657, NULL, NULL, NULL, NULL, '2000-03-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(187, 'Silva Enzo Nahuel', NULL, NULL, 42464554, NULL, NULL, NULL, NULL, '2000-02-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(188, 'Vener Matias', NULL, NULL, 43114234, NULL, NULL, NULL, NULL, '2000-12-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(189, 'Walter Juan Manuel', NULL, NULL, 42464574, NULL, NULL, NULL, NULL, '2000-01-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(190, 'Almada  Giaccio  Lautaro Gabriel', NULL, NULL, 42263550, NULL, NULL, NULL, NULL, '1999-11-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(191, 'Barzola Jeremias Joel', NULL, NULL, 41907961, NULL, NULL, NULL, NULL, '1999-08-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(192, 'Basso Nicolas', NULL, NULL, 41268395, NULL, NULL, NULL, NULL, '1999-10-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(193, 'Beron Axel Joel Agustin', NULL, NULL, 41754470, NULL, NULL, NULL, NULL, '1999-02-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(194, 'Bovier Martin Nincolas', NULL, NULL, 40819030, NULL, NULL, NULL, NULL, '1998-02-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(195, 'Campa Nahuel Agustin', NULL, NULL, 41610787, NULL, NULL, NULL, NULL, '1998-10-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(196, 'Campoamor Alejo Elias', NULL, NULL, 42464553, NULL, NULL, NULL, NULL, '1999-11-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(197, 'Correa Abel Dario', NULL, NULL, 41630094, NULL, NULL, NULL, NULL, '1999-08-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(198, 'Delgado wALter David', NULL, NULL, 42070766, NULL, NULL, NULL, NULL, '1999-08-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(199, 'Espindola Walter ', NULL, NULL, 41819284, NULL, NULL, NULL, NULL, '1999-04-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(200, 'Espinosa Bettoni Agustin', NULL, NULL, 42241221, NULL, NULL, NULL, NULL, '1999-12-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(201, 'Galvez Manuel Augusto', NULL, NULL, 40819085, NULL, NULL, NULL, NULL, '1998-07-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(202, 'Gasparin Alejandro Joel', NULL, NULL, 41754991, NULL, NULL, NULL, NULL, '1999-02-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(203, 'Gimenez Diego Martin', NULL, NULL, 41980293, NULL, NULL, NULL, NULL, '1999-05-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(204, 'Gomez Elias Fabian ', NULL, NULL, 41195191, NULL, NULL, NULL, NULL, '1998-05-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(205, 'Ibarra Sione Nahuel Nicolas', NULL, NULL, 42070939, NULL, NULL, NULL, NULL, '1999-09-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(206, 'Insaurralde Martin Carlos Alberto', NULL, NULL, 41868221, NULL, NULL, NULL, NULL, '1999-06-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(207, 'Ledesma Agustin Rodrigo', NULL, NULL, 40819078, NULL, NULL, NULL, NULL, '1998-07-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(208, 'Martinez Matias', NULL, NULL, 41610687, NULL, NULL, NULL, NULL, '1998-12-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(209, 'Mayor Celso', NULL, NULL, 41980224, NULL, NULL, NULL, NULL, '1999-05-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(210, 'Michelin Daian Hugo Jesus', NULL, NULL, 41282076, NULL, NULL, NULL, NULL, '1999-01-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(211, 'Moreno Juan Cruz', NULL, NULL, 41696797, NULL, NULL, NULL, NULL, '1999-06-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(212, 'Perez Yanz Alan Exequiel', NULL, NULL, 41907992, NULL, NULL, NULL, NULL, '1999-09-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(213, 'Picech Lucas Gaston', NULL, NULL, 40819044, NULL, NULL, NULL, NULL, '1998-04-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(214, 'Piro Leandro Ariel', NULL, NULL, 41249787, NULL, NULL, NULL, NULL, '1998-08-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(215, 'Reyes Matias Nicolas', NULL, NULL, 40310636, NULL, NULL, NULL, NULL, '1999-03-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(216, 'Rivero Alejandro', NULL, NULL, 42070948, NULL, NULL, NULL, NULL, '1998-10-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(217, 'Rodriguez Gustavo Ariel', NULL, NULL, 40819014, NULL, NULL, NULL, NULL, '1998-01-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(218, 'Ruiz Diaz Enzo Jesus', NULL, NULL, 41907984, NULL, NULL, NULL, NULL, '1999-10-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(219, 'Salinas Castaño Lautaro Jesus', NULL, NULL, 41249842, NULL, NULL, NULL, NULL, '1998-09-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(220, 'Segovia JOSE', NULL, NULL, 41868062, NULL, NULL, NULL, NULL, '1999-02-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(221, 'Simino Javier Manuel Ignacio', NULL, NULL, 41683605, NULL, NULL, NULL, NULL, '1999-08-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(222, 'Viviani Giani Franco ', NULL, NULL, 41979905, NULL, NULL, NULL, NULL, '1999-06-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(223, 'Arce César Jesús', NULL, NULL, 40564404, NULL, NULL, NULL, NULL, '1997-08-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(224, 'Baron Enzo Raul Leonel', NULL, NULL, 40406301, NULL, NULL, NULL, NULL, '1997-04-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(225, 'Fontana Elian Exequiel', NULL, NULL, 40168065, NULL, NULL, NULL, NULL, '1997-03-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(226, 'Fontana Nahuel Adrian', NULL, NULL, 40693167, NULL, NULL, NULL, NULL, '1997-11-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(227, 'Lopez Oscar Andres', NULL, NULL, 40407493, NULL, NULL, NULL, NULL, '1997-07-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(228, 'Mayor Enzo David', NULL, NULL, 40406343, NULL, NULL, NULL, NULL, '1997-04-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(229, 'Medrano Ian Marco', NULL, NULL, 40691918, NULL, NULL, NULL, NULL, '1997-08-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(230, 'Monzon Kevin Mario Raul', NULL, NULL, 40167632, NULL, NULL, NULL, NULL, '1997-03-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(231, 'Monzon Sebastian Nahuel', NULL, NULL, 40165336, NULL, NULL, NULL, NULL, '1997-07-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(232, 'Retamar Luis Agustin', NULL, NULL, 40694650, NULL, NULL, NULL, NULL, '1997-12-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(233, 'Walter Daniel Francisco', NULL, NULL, 40693184, NULL, NULL, NULL, NULL, '1997-10-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(234, 'Cancio Daniel Sebastian Francisco', NULL, NULL, 39580823, NULL, NULL, NULL, NULL, '1996-06-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(235, 'Jacob Brian Nahuel', NULL, NULL, 39838568, NULL, NULL, NULL, NULL, '1996-12-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(236, 'Pereira Matias Oscar', NULL, NULL, 39838528, NULL, NULL, NULL, NULL, '1996-08-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(237, 'Perez Jeremiaz Emmanuel', NULL, NULL, 39683607, NULL, NULL, NULL, NULL, '1996-02-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(238, 'Petersen Alan Daian', NULL, NULL, 39257694, NULL, NULL, NULL, NULL, '1996-03-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(239, 'Viola Gian Franco Gabriel ', NULL, NULL, 40045427, NULL, NULL, NULL, NULL, '1996-10-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(240, 'Zaragoza Gabriel Horacio', NULL, NULL, 39684930, NULL, NULL, NULL, NULL, '1996-07-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(241, 'Izaguirre Elias Juan Martin', NULL, NULL, 38769008, NULL, NULL, NULL, NULL, '1995-01-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(242, 'Moyano Jose Antonio', NULL, NULL, 39257653, NULL, NULL, NULL, NULL, '1995-12-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(243, 'Pereira Leonardo Andres', NULL, NULL, 38769018, NULL, NULL, NULL, NULL, '1995-01-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(244, 'Ascua Gustavo Federico', NULL, NULL, 37921104, NULL, NULL, NULL, NULL, '1994-02-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(245, 'Demartin Santana Marcos Lautaro', NULL, NULL, 38172004, NULL, NULL, NULL, NULL, '1994-05-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(246, 'Ledesma Ivo Leonel', NULL, NULL, 38172339, NULL, NULL, NULL, NULL, '1994-07-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(247, 'Vazquez Luis Facundo Pedro', NULL, NULL, 38769007, NULL, NULL, NULL, NULL, '1994-12-31', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(248, 'Franco Cristian Gabriel', NULL, NULL, 37470887, NULL, NULL, NULL, NULL, '1993-10-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(249, 'Petersen Santiago Gabriel', NULL, NULL, 37703248, NULL, NULL, NULL, NULL, '1993-12-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(250, 'Rodriguez Alan Lautaro', NULL, NULL, 37223231, NULL, NULL, NULL, NULL, '1993-01-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(251, 'Ruhl Facundo Raul', NULL, NULL, 37562593, NULL, NULL, NULL, NULL, '1993-08-31', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(252, 'Cardozo Fabio Julian', NULL, NULL, 36709288, NULL, NULL, NULL, NULL, '1992-12-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(253, 'Pereyra Leonel Rodrigo Eduardo', NULL, NULL, 36910375, NULL, NULL, NULL, NULL, '1992-06-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(254, 'Perez Leonardo Exequiel', NULL, NULL, 36910968, NULL, NULL, NULL, NULL, '1992-07-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(255, 'Cardozo Brian Oscar', NULL, NULL, 36208708, NULL, NULL, NULL, NULL, '1991-11-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(256, 'Romero Franco Nahuel', NULL, NULL, 35175575, NULL, NULL, NULL, NULL, '1991-08-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(257, 'Romero Leandro', NULL, NULL, 35443134, NULL, NULL, NULL, NULL, '1991-01-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(258, 'Cespedes Carlos Antonio', NULL, NULL, 35440453, NULL, NULL, NULL, NULL, '1990-07-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(259, 'Luna Leonardo Emmanuel', NULL, NULL, 35384071, NULL, NULL, NULL, NULL, '1990-06-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(260, 'Pisech Gustavo Ariel', NULL, NULL, 37080513, NULL, NULL, NULL, NULL, '1990-09-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(261, 'Villanueva Emmanuel Horacio', NULL, NULL, 34808838, NULL, NULL, NULL, NULL, '1990-02-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(262, 'Zampieri Almada Emiliano', NULL, NULL, 35175488, NULL, NULL, NULL, NULL, '1990-03-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(263, 'Cavallo Alberto Santiago', NULL, NULL, 34495585, NULL, NULL, NULL, NULL, '1989-04-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(264, 'Zampieri Almada Maximiliano', NULL, NULL, 33502720, NULL, NULL, NULL, NULL, '1988-02-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(265, 'Petersen Luis Matias', NULL, NULL, 33129899, NULL, NULL, NULL, NULL, '1987-06-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(266, 'Yfran Luis Francisco', NULL, NULL, 32619434, NULL, NULL, NULL, NULL, '1987-04-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(267, 'Gomez Leguizamon Jonathan', NULL, NULL, 31995199, NULL, NULL, NULL, NULL, '1986-02-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(268, 'Maldonado Falcon Uriel Ignacio', NULL, NULL, 32669091, NULL, NULL, NULL, NULL, '1986-11-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(269, 'Zampieri Ivan Matias', NULL, NULL, 32096348, NULL, NULL, NULL, NULL, '1986-02-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(270, 'Donda Adrian Leonardo', NULL, NULL, 31847704, NULL, NULL, NULL, NULL, '1985-09-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(271, 'Palacios Martin Ruben', NULL, NULL, 31995302, NULL, NULL, NULL, NULL, '1985-12-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(272, 'Satler Fabio Agustin', NULL, NULL, 31908194, NULL, NULL, NULL, NULL, '1985-11-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(273, 'Pross Ivan Alberto', NULL, NULL, 30558988, NULL, NULL, NULL, NULL, '1984-01-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(274, 'Cabrera Juan Carlos', NULL, NULL, 29795250, NULL, NULL, NULL, NULL, '1982-11-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(275, 'Balbuena David Ariel', NULL, NULL, 27359268, NULL, NULL, NULL, NULL, '1979-06-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(276, 'Toffolini Mariano Agustin Exequiel', NULL, NULL, 26332626, NULL, NULL, NULL, NULL, '1978-04-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(277, 'Pacher Tarabini Lisandro Santiago', NULL, NULL, 40774060, NULL, NULL, NULL, NULL, '1997-11-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(278, 'Fraco Mario Armando', NULL, NULL, 36703689, NULL, NULL, NULL, NULL, '1992-01-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(279, 'Almarante Edgar', NULL, NULL, 48825366, NULL, NULL, NULL, NULL, '2008-05-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(280, 'Arriaga Lautaro Ignacio', NULL, NULL, 43755189, NULL, NULL, NULL, NULL, '2001-10-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(281, 'Berlari Nicolas Agustin', NULL, NULL, 46779003, NULL, NULL, NULL, NULL, '2005-08-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(282, 'Bottaro Facundo ', NULL, NULL, 42918850, NULL, NULL, NULL, NULL, '2000-10-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(283, 'Cerrudo Agustin Alejandro ', NULL, NULL, 46975092, NULL, NULL, NULL, NULL, '2005-12-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(284, 'Cerrudo Jessica Alejandra', NULL, NULL, 48476349, NULL, NULL, NULL, NULL, '2008-05-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(285, 'Chiama Juan Bautista', NULL, NULL, 48906473, NULL, NULL, NULL, NULL, '2009-02-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(286, 'Cottonaro Aureliano', NULL, NULL, 50685204, NULL, NULL, NULL, NULL, '2010-11-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(287, 'Cottonaro Laurentino ', NULL, NULL, 48960576, NULL, NULL, NULL, NULL, '2008-08-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(288, 'Dieterle Adriel', NULL, NULL, 47522361, NULL, NULL, NULL, NULL, '2006-09-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(289, 'Dittler Perez Tiziano Gabriel', NULL, NULL, 48906801, NULL, NULL, NULL, NULL, '2008-07-31', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(290, 'Donda Fausto Gabriel', NULL, NULL, 49512136, NULL, NULL, NULL, NULL, '2009-08-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(291, 'Donda Mateo', NULL, NULL, 46466999, NULL, NULL, NULL, NULL, '2005-08-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(292, 'Fontana Martin', NULL, NULL, 49819601, NULL, NULL, NULL, NULL, '2009-11-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(293, 'Franco Tadeo Nicolas ', NULL, NULL, 46082958, NULL, NULL, NULL, NULL, '2004-12-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(294, 'Frank Rocio Abigail', NULL, NULL, 48202236, NULL, NULL, NULL, NULL, '2009-09-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(295, 'Garbezza Juan Cruz', NULL, NULL, 42852468, NULL, NULL, NULL, NULL, '2000-09-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(296, 'Gasparin Gianni', NULL, NULL, 48202243, NULL, NULL, NULL, NULL, '2007-11-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(297, 'Gimenez Visintin Candela Denise', NULL, NULL, 50248171, NULL, NULL, NULL, NULL, '2010-07-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(298, 'Gimenez Visintin Jeremias Damian', NULL, NULL, 50383336, NULL, NULL, NULL, NULL, '2010-09-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(299, 'Gonzales Franco Cesar Ezequiel', NULL, NULL, 41610840, NULL, NULL, NULL, NULL, '1999-01-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(300, 'Gonzalez Montalvan Joaquin ', NULL, NULL, 46367674, NULL, NULL, NULL, NULL, '2005-02-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(301, 'Herrlein Ulises Daniel', NULL, NULL, 44644388, NULL, NULL, NULL, NULL, '2002-10-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(302, 'Huck Picotti Federico', NULL, NULL, 48906458, NULL, NULL, NULL, NULL, '2009-01-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(303, 'Ibarra Matias', NULL, NULL, 47705689, NULL, NULL, NULL, NULL, '2007-05-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(304, 'Jesus Dominguez  Alberto', NULL, NULL, 46169563, NULL, NULL, NULL, NULL, '2007-08-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(305, 'Jesus Dominguez  Luciano Agustin ', NULL, NULL, 50248117, NULL, NULL, NULL, NULL, '2010-06-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(306, 'Lapera  Abril Micaela', NULL, NULL, 47527754, NULL, NULL, NULL, NULL, '2006-10-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(307, 'Lapera Alejo Gaspar', NULL, NULL, 49296718, NULL, NULL, NULL, NULL, '2009-02-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(308, 'Lapera Silvio Nahuel', NULL, NULL, 49296718, NULL, NULL, NULL, NULL, '2009-02-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(309, 'Lencinas Axel Agustin', NULL, NULL, 42601009, NULL, NULL, NULL, NULL, '2000-05-31', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(310, 'Lencinas Camila', NULL, NULL, 45387854, NULL, NULL, NULL, NULL, '2004-01-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(311, 'Lencinas Francisco Exequiel', NULL, NULL, 43350270, NULL, NULL, NULL, NULL, '2001-06-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(312, 'Mantay Miguel', NULL, NULL, 43113723, NULL, NULL, NULL, NULL, '2001-01-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(313, 'Montero Roskoff Ismael', NULL, NULL, 42852490, NULL, NULL, NULL, NULL, '2000-11-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(314, 'Murador Lasaro', NULL, NULL, 48264219, NULL, NULL, NULL, NULL, '2007-10-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(315, 'Narvaez Juan David', NULL, NULL, 44980297, NULL, NULL, NULL, NULL, '2003-08-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(316, 'Ostrosky Valentin', NULL, NULL, 46975246, NULL, NULL, NULL, NULL, '2006-02-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(317, 'Pacco Lautaro Gabriel', NULL, NULL, 48202246, NULL, NULL, NULL, NULL, '2007-11-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(318, 'Pereyra Theo', NULL, NULL, 48202210, NULL, NULL, NULL, NULL, '2007-09-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(319, 'Pesoa Carolina', NULL, NULL, 50383336, NULL, NULL, NULL, NULL, '2010-09-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(320, 'Pirola Jesus', NULL, NULL, 46779079, NULL, NULL, NULL, NULL, '2006-01-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(321, 'Quijano Santino ', NULL, NULL, 46779390, NULL, NULL, NULL, NULL, '2005-08-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(322, 'Quiroga Mariano Valentin', NULL, NULL, 44862858, NULL, NULL, NULL, NULL, '2003-07-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(323, 'Quiroga Matias Agustin', NULL, NULL, 46082966, NULL, NULL, NULL, NULL, '2004-12-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(324, 'Regner Federica', NULL, NULL, 48201196, NULL, NULL, NULL, NULL, '2007-09-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(325, 'Roda ALEJO Guillermo Natanael', NULL, NULL, 49225880, NULL, NULL, NULL, NULL, '2008-12-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(326, 'Russian Mirco Gabriel', NULL, NULL, 47552366, NULL, NULL, NULL, NULL, '2006-10-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(327, 'Schalpeter Matias Nicolas', NULL, NULL, 43827272, NULL, NULL, NULL, NULL, '2002-01-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(328, 'Sosa Maximiliano Andres', NULL, NULL, 43296231, NULL, NULL, NULL, NULL, '2001-02-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(329, 'Sosa Nicolas Agustin', NULL, NULL, 44367663, NULL, NULL, NULL, NULL, '2002-07-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(330, 'Soto Mariano Javier', NULL, NULL, 44466994, NULL, NULL, NULL, NULL, '2005-07-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(331, 'Valin Cristian Alberto', NULL, NULL, 44846351, NULL, NULL, NULL, NULL, '2003-07-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(332, 'Zuleta Agustin  Emanuel', NULL, NULL, 47986084, NULL, NULL, NULL, NULL, '2007-07-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(333, 'Zuleta Cristian Benjamin', NULL, NULL, 49295165, NULL, NULL, NULL, NULL, '2009-01-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(334, 'Rodriguez Milton Nahuel', NULL, NULL, 44104075, NULL, NULL, NULL, NULL, '2002-05-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(335, 'Fernandez Yedro Facundo', NULL, NULL, 46150231, NULL, NULL, NULL, NULL, '2004-09-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(336, 'Dieterle Kiara', NULL, NULL, 49512185, NULL, NULL, NULL, NULL, '2009-11-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(337, ' Goroz Yanz Agustin Ismanol', NULL, NULL, 46082952, NULL, NULL, NULL, NULL, '2004-12-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(338, 'Rodriguez Movile Candela', NULL, NULL, 51039823, NULL, NULL, NULL, NULL, '2011-06-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(339, 'Baldi Luana', NULL, NULL, 46779077, NULL, NULL, NULL, NULL, '2006-02-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(340, 'Balta Camila', NULL, NULL, 46927220, NULL, NULL, NULL, NULL, '2005-09-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(341, 'Benavides Agustina Marianela', NULL, NULL, 44769430, NULL, NULL, NULL, NULL, '2003-04-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(342, 'Beron Antonella', NULL, NULL, 43540099, NULL, NULL, NULL, NULL, '2001-10-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(343, 'Biaggini Tiara Teresa', NULL, NULL, 42601046, NULL, NULL, NULL, NULL, '2000-08-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(344, 'Buxman Daiana', NULL, NULL, 47779050, NULL, NULL, NULL, NULL, '2005-12-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(345, 'Chiama Valentina', NULL, NULL, 46082967, NULL, NULL, NULL, NULL, '2004-12-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(346, 'De Mondesert Selene', NULL, NULL, 44367700, NULL, NULL, NULL, NULL, '2002-09-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(347, 'Figueroa Priscila', NULL, NULL, 46674951, NULL, NULL, NULL, NULL, '2005-03-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(348, 'Fontana Micaela Belen', NULL, NULL, 47705651, NULL, NULL, NULL, NULL, '2007-02-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(349, 'Franco Fabiana Fiorella', NULL, NULL, 43296246, NULL, NULL, NULL, NULL, '2001-04-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(350, 'Gauna Emilia Valentina', NULL, NULL, 44644390, NULL, NULL, NULL, NULL, '2003-03-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(351, 'Gavilan Ana Paula', NULL, NULL, 47177302, NULL, NULL, NULL, NULL, '2006-01-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(352, 'Gavilan Mayda  Ailen', NULL, NULL, 44622891, NULL, NULL, NULL, NULL, '2003-01-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(353, 'Gimenez Dure Jazmin Natali', NULL, NULL, 45167752, NULL, NULL, NULL, NULL, '2003-10-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(354, 'Godoy Berlari Sofia Faustina', NULL, NULL, 46082996, NULL, NULL, NULL, NULL, '2005-02-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(355, 'Godoy Camila', NULL, NULL, 46256344, NULL, NULL, NULL, NULL, '2004-12-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(356, 'Grinovero Antonela Jazmin', NULL, NULL, 44644364, NULL, NULL, NULL, NULL, '2003-01-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(357, 'Guilleron Arhai', NULL, NULL, 43296247, NULL, NULL, NULL, NULL, '2001-03-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(358, 'La Paz Grandolio Florenca Ayelen', NULL, NULL, 46779408, NULL, NULL, NULL, NULL, '2005-07-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(359, 'Labraga Rosario', NULL, NULL, 47360969, NULL, NULL, NULL, NULL, '2014-05-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(360, 'Lencina Fadil Naiara Zair', NULL, NULL, 46779084, NULL, NULL, NULL, NULL, '2006-01-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(361, 'Netto  Antonela Lujan', NULL, NULL, 46150616, NULL, NULL, NULL, NULL, '2004-08-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(362, 'Nunez Luana Irina', NULL, NULL, 48477111, NULL, NULL, NULL, NULL, '2008-03-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(363, 'Paez Malena Ailen', NULL, NULL, 46151073, NULL, NULL, NULL, NULL, '2004-11-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(364, 'Perez Lara', NULL, NULL, 45757608, NULL, NULL, NULL, NULL, '2004-07-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(365, 'Pesoa Serena Abril', NULL, NULL, 45948166, NULL, NULL, NULL, NULL, '2004-07-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(366, 'Picotti Huck Nayla', NULL, NULL, 47247347, NULL, NULL, NULL, NULL, '2006-05-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(367, 'Portillo Micaela Magali', NULL, NULL, 46779089, NULL, NULL, NULL, NULL, '2006-02-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(368, 'Reisenauer Nayla Catalina', NULL, NULL, 46466985, NULL, NULL, NULL, NULL, '2005-07-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL);
INSERT INTO `socio` (`id`, `apellido_nombre`, `cp`, `direccion`, `dni`, `email`, `fecha_alta`, `fecha_baja`, `obs`, `fecha_nacimiento`, `nombre_foto`, `id_categoria_social`, `id_ciudad`, `id_cobrador`, `matricula`, `id_provincia`, `sexo`, `telefono`, `telefono2`) VALUES
(369, 'Riggio Daiana Stefania', NULL, NULL, 45617177, NULL, NULL, NULL, NULL, '2004-05-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(370, 'Scipioni Sabrina', NULL, NULL, 46466932, NULL, NULL, NULL, NULL, '2005-07-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(371, 'Troncoso Ailen', NULL, NULL, 47706942, NULL, NULL, NULL, NULL, '2007-02-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(372, 'Valinotti Sofia', NULL, NULL, 46779094, NULL, NULL, NULL, NULL, '2006-02-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(373, 'Villaverde Micaela', NULL, NULL, 43827276, NULL, NULL, NULL, NULL, '2002-01-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(374, 'Vince Ariadna Micaela', NULL, NULL, 43347728, NULL, NULL, NULL, NULL, '2001-04-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(375, 'Vince Gianella Maira', NULL, NULL, 45755228, NULL, NULL, NULL, NULL, '2004-05-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(376, 'Vince Nayla Mariana', NULL, NULL, 47522584, NULL, NULL, NULL, NULL, '2006-08-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(377, 'Yacob  Camila Marisol', NULL, NULL, 48476324, NULL, NULL, NULL, NULL, '2008-04-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(378, 'Zatti Avril Agostina', NULL, NULL, 46779065, NULL, NULL, NULL, NULL, '2006-01-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(379, 'Frasconi Julieta', NULL, NULL, 45387465, NULL, NULL, NULL, NULL, '2004-04-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(380, 'Rodriguez Mia Ailen', NULL, NULL, 49648830, NULL, NULL, NULL, NULL, '2009-10-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(381, 'Aragone Tiago', NULL, NULL, 49296827, NULL, NULL, NULL, NULL, '2009-04-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(382, 'Biase Francesca ', NULL, NULL, 52056995, NULL, NULL, NULL, NULL, '2011-12-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(383, 'Bregant Khair', NULL, NULL, 49512135, NULL, NULL, NULL, NULL, '2009-06-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(384, 'Donda Fausto Gabriel', NULL, NULL, 49512136, NULL, NULL, NULL, NULL, '2009-08-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(385, 'Engelberger Fausto', NULL, NULL, 50589178, NULL, NULL, NULL, NULL, '2010-12-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(386, 'Fontana Melina', NULL, NULL, 49819158, NULL, NULL, NULL, NULL, '2009-12-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(387, 'Machiavello Theo Santino', NULL, NULL, 52259844, NULL, NULL, NULL, NULL, '2012-05-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(388, 'Pereyra Flores Sebastian Ezequiel', NULL, NULL, 52257494, NULL, NULL, NULL, NULL, '2012-08-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(389, 'Pesoa Carolina', NULL, NULL, 50383336, NULL, NULL, NULL, NULL, '2010-09-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(390, 'Pesoa Sebastian', NULL, NULL, 52261093, NULL, NULL, NULL, NULL, '2012-06-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(391, 'Pisech Santiago', NULL, NULL, 50732765, NULL, NULL, NULL, NULL, '2011-05-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(392, 'Rodriguez Movile Candela', NULL, NULL, 51039823, NULL, NULL, NULL, NULL, '2011-06-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(393, 'Albornoz Jasmin', NULL, NULL, 49295454, NULL, NULL, NULL, NULL, '2009-01-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(394, 'Avila Delfina', NULL, NULL, 48476356, NULL, NULL, NULL, NULL, '2008-05-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(395, 'Bergara Tentor Morena ', NULL, NULL, 48906416, NULL, NULL, NULL, NULL, '2008-10-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(396, 'Bertolami Ludmila Lucila Aridna', NULL, NULL, 48906415, NULL, NULL, NULL, NULL, '2008-09-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(397, 'Cabrol Sofiaa', NULL, NULL, 48477122, NULL, NULL, NULL, NULL, '2008-03-20', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(398, 'Dabin Valentina', NULL, NULL, 48960214, NULL, NULL, NULL, NULL, '2008-08-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(399, 'Ditler Ayelen Anahi', NULL, NULL, 48202219, NULL, NULL, NULL, NULL, '2008-01-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(400, 'Falconier Montalvan  Jazmin ', NULL, NULL, 50070633, NULL, NULL, NULL, NULL, '2010-02-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(401, 'Filippo Valentina Ailen', NULL, NULL, 48476341, NULL, NULL, NULL, NULL, '2008-05-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(402, 'Fontanini KLOSTER Isabella ', NULL, NULL, 48906474, NULL, NULL, NULL, NULL, '2009-02-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(403, 'Gimenez Visintin Candela Denise', NULL, NULL, 50248171, NULL, NULL, NULL, NULL, '2010-07-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(404, 'Gonzalez Kiara Micaela', NULL, NULL, 48476328, NULL, NULL, NULL, NULL, '2008-04-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(405, 'Mancini Malvina ', NULL, NULL, 49296569, NULL, NULL, NULL, NULL, '2009-03-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(406, 'Piray Morena  Abril Oriana', NULL, NULL, 48475988, NULL, NULL, NULL, NULL, '2008-01-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(407, 'Rodrguez Leonela ', NULL, NULL, 49792164, NULL, NULL, NULL, NULL, '2010-03-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(408, 'Ruht Lopez Barbara Anabella', NULL, NULL, 48906477, NULL, NULL, NULL, NULL, '2009-02-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(409, 'Suarez Bustamante Valentina Gisel', NULL, NULL, 48476373, NULL, NULL, NULL, NULL, '2008-06-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(410, 'Varisco Cabrol Dulce Abril', NULL, NULL, 49261361, NULL, NULL, NULL, NULL, '2009-05-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(411, 'Bobadilla Martina', NULL, NULL, 46975261, NULL, NULL, NULL, NULL, '2006-02-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(412, 'Bonacci Celeste', NULL, NULL, 47522363, NULL, NULL, NULL, NULL, '2006-10-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(413, 'Chaves Godoy Lourdes Veronica', NULL, NULL, 47982198, NULL, NULL, NULL, NULL, '2007-08-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(414, 'Flematti Solange Selene', NULL, NULL, 48203359, NULL, NULL, NULL, NULL, '2007-09-14', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(415, 'Franco Wanda ', NULL, NULL, 47409069, NULL, NULL, NULL, NULL, '2006-07-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(416, 'Giorgio Melani', NULL, NULL, 47982185, NULL, NULL, NULL, NULL, '2007-07-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(417, 'Gonzalez Milagros lute', NULL, NULL, 47522378, NULL, NULL, NULL, NULL, '2006-10-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(418, 'Herenu Isabella ', NULL, NULL, 48202229, NULL, NULL, NULL, NULL, '2007-10-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(419, 'Honeker Ariza Abigail Diamela', NULL, NULL, 48140974, NULL, NULL, NULL, NULL, '2007-06-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(420, 'Lapera  Abril Micaela', NULL, NULL, 47527754, NULL, NULL, NULL, NULL, '2006-10-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(421, 'Maldonado Nerina Abigail', NULL, NULL, 47706931, NULL, NULL, NULL, NULL, '2007-01-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(422, 'Moreira Gonzalez Abril', NULL, NULL, 47784479, NULL, NULL, NULL, NULL, '2007-04-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(423, 'Pereira Damaris', NULL, NULL, 48476345, NULL, NULL, NULL, NULL, '2007-04-12', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(424, 'Picoti Camila Ayelen', NULL, NULL, 47705699, NULL, NULL, NULL, NULL, '2007-05-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(425, 'Ruhl Lopez Ximena Antonella ', NULL, NULL, 48337281, NULL, NULL, NULL, NULL, '2007-12-31', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(426, 'Ruiz Diaz Sabrina', NULL, NULL, 47327579, NULL, NULL, NULL, NULL, '2006-06-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(427, 'Segovia Maria Eliana', NULL, NULL, 48337195, NULL, NULL, NULL, NULL, '2007-12-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(428, 'Sosa Cindy', NULL, NULL, 47326775, NULL, NULL, NULL, NULL, '2006-05-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(429, 'Villanueva Emily Abril', NULL, NULL, 47932180, NULL, NULL, NULL, NULL, '2007-07-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(430, 'Zatti Avril aGostina', NULL, NULL, 46779065, NULL, NULL, NULL, NULL, '2006-01-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(431, 'Alaniz Debra Morena', NULL, NULL, 46466970, NULL, NULL, NULL, NULL, '2005-02-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(432, 'Almada Fernanda', NULL, NULL, 45552657, NULL, NULL, NULL, NULL, '2004-05-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(433, 'Arce Lujan', NULL, NULL, 45617159, NULL, NULL, NULL, NULL, '2004-04-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(434, 'Barreto Milagros Kiara Anabela', NULL, NULL, 46927421, NULL, NULL, NULL, NULL, '2005-10-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(435, 'Bernhardt Jennifer Aldana', NULL, NULL, 46779064, NULL, NULL, NULL, NULL, '2005-12-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(436, 'Bertolami Daiana', NULL, NULL, 45617171, NULL, NULL, NULL, NULL, '2004-04-30', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(437, 'Calderon Cielo Milen', NULL, NULL, 46150639, NULL, NULL, NULL, NULL, '2004-09-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(438, 'Cancio Nieve', NULL, NULL, 45403872, NULL, NULL, NULL, NULL, '2004-02-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(439, 'Comar Mariangel', NULL, NULL, 46466915, NULL, NULL, NULL, NULL, '2004-04-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(440, 'Deganutti Sofia Caterina', NULL, NULL, 45901064, NULL, NULL, NULL, NULL, '2004-07-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(441, 'Diaz Abril', NULL, NULL, 45552302, NULL, NULL, NULL, NULL, '2004-03-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(442, 'Figueroa Priscila Aylin', NULL, NULL, 46674951, NULL, NULL, NULL, NULL, '2005-03-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(443, 'Franco Fabia Florencia', NULL, NULL, 45387866, NULL, NULL, NULL, NULL, '2004-02-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(444, 'Frasconi Julieta ', NULL, NULL, 45387465, NULL, NULL, NULL, NULL, '2004-04-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(445, 'Giles Oriana Valentina', NULL, NULL, 45047171, NULL, NULL, NULL, NULL, '2004-07-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(446, 'Godoy Guillermina', NULL, NULL, 46466940, NULL, NULL, NULL, NULL, '2005-05-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(447, 'Godoy Sabrina', NULL, NULL, 46466941, NULL, NULL, NULL, NULL, '2005-05-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(448, 'Lo Bello Araceli Mailen', NULL, NULL, 46319024, NULL, NULL, NULL, NULL, '2005-02-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(449, 'Lopez Bianca Antonella', NULL, NULL, 46082916, NULL, NULL, NULL, NULL, '2004-09-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(450, 'Lopez Celeste Marisol', NULL, NULL, 45847179, NULL, NULL, NULL, NULL, '2004-03-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(451, 'Lorenzon Iara Abigail', NULL, NULL, 45847157, NULL, NULL, NULL, NULL, '2004-06-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(452, 'Monte Ailen Natalia', NULL, NULL, 46779039, NULL, NULL, NULL, NULL, '2005-11-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(453, 'Perez Milagros Valentina', NULL, NULL, 46779037, NULL, NULL, NULL, NULL, '2005-11-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(454, 'Perez Valentina Florencia', NULL, NULL, 45617158, NULL, NULL, NULL, NULL, '2004-04-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(455, 'Piedrabuena Sheila Jacqueline', NULL, NULL, 46082948, NULL, NULL, NULL, NULL, '2004-11-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(456, 'Portillo Yasmin Abigail', NULL, NULL, 45847164, NULL, NULL, NULL, NULL, '2004-06-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(457, 'Presidente Virginia Luana', NULL, NULL, 45157894, NULL, NULL, NULL, NULL, '2004-10-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(458, 'Quiroga Giuliana Agostina', NULL, NULL, 46466963, NULL, NULL, NULL, NULL, '2005-05-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(459, 'Quiroga Melina Anabel', NULL, NULL, 46466964, NULL, NULL, NULL, NULL, '2005-05-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(460, 'Sarubi Camila Maria Belen', NULL, NULL, 45757548, NULL, NULL, NULL, NULL, '2004-06-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(461, 'Toledano Selene ABIGAIL ', NULL, NULL, 46082995, NULL, NULL, NULL, NULL, '2005-02-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(462, 'Albornoz Fatima', NULL, NULL, 44862815, NULL, NULL, NULL, NULL, '2003-06-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(463, 'Alcaraz Rebeca Micaela', NULL, NULL, 43068498, NULL, NULL, NULL, NULL, '2000-12-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(464, 'Alvarez Jhoana', NULL, NULL, 42263700, NULL, NULL, NULL, NULL, '1999-11-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(465, 'Barrios Maria Belen', NULL, NULL, 44981233, NULL, NULL, NULL, NULL, '2003-08-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(466, 'Barrios Maria de los Angeles ', NULL, NULL, 44981232, NULL, NULL, NULL, NULL, '2003-08-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(467, 'Blason Jacob Micaela Soledad', NULL, NULL, 44104091, NULL, NULL, NULL, NULL, '2002-07-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(468, 'Brunengo Delfina Magali', NULL, NULL, 44862794, NULL, NULL, NULL, NULL, '2003-07-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(469, 'Calderon Juliana', NULL, NULL, 42464561, NULL, NULL, NULL, NULL, '2000-03-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(470, 'Camusso Nicole Florencia', NULL, NULL, 44344384, NULL, NULL, NULL, NULL, '2003-02-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(471, 'Camusso Oriana', NULL, NULL, 44344384, NULL, NULL, NULL, NULL, '2003-02-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(472, 'Castaño Fiorella Nataly', NULL, NULL, 43030083, NULL, NULL, NULL, NULL, '2000-11-23', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(473, 'Ceballos Centurion Jasmin Ailen', NULL, NULL, 41154353, NULL, NULL, NULL, NULL, '1998-07-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(474, 'Ceparo Milagros', NULL, NULL, 44819584, NULL, NULL, NULL, NULL, '2003-07-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(475, 'Colman Flavia', NULL, NULL, 40819034, NULL, NULL, NULL, NULL, '1998-03-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(476, 'Colman Tamara', NULL, NULL, 41093337, NULL, NULL, NULL, NULL, '1998-05-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(477, 'Comar Luisina', NULL, NULL, 42731964, NULL, NULL, NULL, NULL, '2000-06-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(478, 'De Mondeser Jaqueline', NULL, NULL, 42852324, NULL, NULL, NULL, NULL, '2000-09-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(479, 'Demartin Luz', NULL, NULL, 41907957, NULL, NULL, NULL, NULL, '1999-07-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(480, 'Detler Yedro Camila Anabel', NULL, NULL, 44644376, NULL, NULL, NULL, NULL, '2002-01-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(481, 'Detler Yedro Sofia Ailen', NULL, NULL, 42206988, NULL, NULL, NULL, NULL, '1999-11-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(482, 'Dominguez Cintia Tamara', NULL, NULL, 42355853, NULL, NULL, NULL, NULL, '2000-01-31', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(483, 'Ducasse Valentina', NULL, NULL, 42263561, NULL, NULL, NULL, NULL, '1999-11-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(484, 'Garcia Nahir Ailen', NULL, NULL, 42464552, NULL, NULL, NULL, NULL, '2000-02-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(485, 'Hereñu Sabrina', NULL, NULL, 41907996, NULL, NULL, NULL, NULL, '1999-11-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(486, 'Jacob Milagros', NULL, NULL, 42919123, NULL, NULL, NULL, NULL, '2000-11-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(487, 'Leal Agustina', NULL, NULL, 41907998, NULL, NULL, NULL, NULL, '1999-11-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(488, 'Lopez AbRIL', NULL, NULL, 43113842, NULL, NULL, NULL, NULL, '2001-02-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(489, 'Loureiro Ana Valentina', NULL, NULL, 44843344, NULL, NULL, NULL, NULL, '2003-06-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(490, 'Meier Barbara', NULL, NULL, 45386060, NULL, NULL, NULL, NULL, '2003-12-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(491, 'Meier Catelina', NULL, NULL, 45660061, NULL, NULL, NULL, NULL, '2003-03-27', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(492, 'Muñoz Milagros', NULL, NULL, 44497820, NULL, NULL, NULL, NULL, '2002-10-19', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(493, 'Neto Fiamma Ailen', NULL, NULL, 45167762, NULL, NULL, NULL, NULL, '2003-10-02', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(494, 'Nicolin Mariana Leonela', NULL, NULL, 42602359, NULL, NULL, NULL, NULL, '2000-12-29', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(495, 'Patat Luna Maria', NULL, NULL, 44497155, NULL, NULL, NULL, NULL, '2002-08-04', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(496, 'Pereira Carolina', NULL, NULL, 45167762, NULL, NULL, NULL, NULL, '2003-11-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(497, 'Perez Brenda', NULL, NULL, 43350864, NULL, NULL, NULL, NULL, '2002-04-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(498, 'Petrussi Micaela Ailen', NULL, NULL, 41867169, NULL, NULL, NULL, NULL, '1999-05-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(499, 'Riedel Zamira', NULL, NULL, 41907904, NULL, NULL, NULL, NULL, '1999-05-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(500, 'Rodriguez Brisa Anabel', NULL, NULL, 44862984, NULL, NULL, NULL, NULL, '2003-07-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(501, 'Ruhl Fiamma', NULL, NULL, 42852312, NULL, NULL, NULL, NULL, '2000-10-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(502, 'Russian Martina', NULL, NULL, 41980121, NULL, NULL, NULL, NULL, '1999-10-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(503, 'Santa Maria Melanie Soledad', NULL, NULL, 42601033, NULL, NULL, NULL, NULL, '2000-07-05', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(504, 'Sicer Sofia', NULL, NULL, 42852301, NULL, NULL, NULL, NULL, '2000-08-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(505, 'Soto Gisela Romina ', NULL, NULL, 43350295, NULL, NULL, NULL, NULL, '2001-07-21', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(506, 'Thomas Denise Ailen', NULL, NULL, 44162362, NULL, NULL, NULL, NULL, '2001-09-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(507, 'Tovani Juliana Eleonora', NULL, NULL, 45387837, NULL, NULL, NULL, NULL, '2003-11-26', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(508, 'Valdemarin Romina Lucia', NULL, NULL, 41907911, NULL, NULL, NULL, NULL, '1999-05-25', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(509, 'Vazquez Laura', NULL, NULL, 45167742, NULL, NULL, NULL, NULL, '2003-09-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(510, 'Vicentin Jesica', NULL, NULL, 40819028, NULL, NULL, NULL, NULL, '1998-02-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(511, 'Baldi Maira Belen', NULL, NULL, 39717177, NULL, NULL, NULL, NULL, '1996-06-18', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(512, 'Benitez Liliana Soledad', NULL, NULL, 30360898, NULL, NULL, NULL, NULL, '1983-09-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(513, 'Cano Karen', NULL, NULL, 40160089, NULL, NULL, NULL, NULL, '1997-02-10', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(514, 'Cogno Carla Maria', NULL, NULL, 33624572, NULL, NULL, NULL, NULL, '1988-07-03', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(515, 'De Mondesert Celeste Vanina', NULL, NULL, 40167650, NULL, NULL, NULL, NULL, '1988-10-17', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(516, 'De Mondesert Estefania Griselda', NULL, NULL, 40167661, NULL, NULL, NULL, NULL, '1990-04-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(517, 'De Mondesert Mirta del Carmen', NULL, NULL, 27617602, NULL, NULL, NULL, NULL, '1980-08-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(518, 'De Mondesert Vanesa elisabeth', NULL, NULL, 30322148, NULL, NULL, NULL, NULL, '1983-08-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(519, 'De Mondesert Viviana', NULL, NULL, 40167660, NULL, NULL, NULL, NULL, '1990-04-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(520, 'Dure Daiana', NULL, NULL, 38769012, NULL, NULL, NULL, NULL, '1995-02-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(521, 'Franco Natalia Gisela', NULL, NULL, 31847947, NULL, NULL, NULL, NULL, '1985-09-08', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(522, 'Gonzalez Giuliana Noemi', NULL, NULL, 38172119, NULL, NULL, NULL, NULL, '1994-05-09', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(523, 'Iacobacci Antonella', NULL, NULL, 39838517, NULL, NULL, NULL, NULL, '1996-08-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(524, 'Martinez Natalia', NULL, NULL, 27466776, NULL, NULL, NULL, NULL, '1979-10-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(525, 'Moretti Martina', NULL, NULL, 37290990, NULL, NULL, NULL, NULL, '1993-04-24', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(526, 'Palacio Karen Priscila', NULL, NULL, 40838488, NULL, NULL, NULL, NULL, '1997-09-13', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(527, 'Passerini Jesica', NULL, NULL, 32405567, NULL, NULL, NULL, NULL, '1986-05-22', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(528, 'Pesoa Jesica Mariana', NULL, NULL, 32096252, NULL, NULL, NULL, NULL, '1986-02-01', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(529, 'Pesoa Johana Janet', NULL, NULL, 35706520, NULL, NULL, NULL, NULL, '1991-05-07', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(530, 'Romero Olga Gabriela', NULL, NULL, 24488767, NULL, NULL, NULL, NULL, '1975-12-28', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(531, 'SCHIMPC Natalia Soledad', NULL, NULL, 36380298, NULL, NULL, NULL, NULL, '1991-04-06', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(532, 'SCHIMPC Veronica Anrea', NULL, NULL, 30393690, NULL, NULL, NULL, NULL, '1983-11-16', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(533, 'Soto Ema Cecilia', NULL, NULL, 31521737, NULL, NULL, NULL, NULL, '1985-04-11', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(534, 'Zampieri Luciana', NULL, NULL, 35706004, NULL, NULL, NULL, NULL, '1991-02-15', NULL, NULL, 2, 1, NULL, 1, NULL, NULL, NULL),
(535, 'Juan Perez Garcia', '3107', '', 31288522, '', '2016-03-25', NULL, '', '1985-08-25', NULL, 1, 2, 1, 31288522, 1, 'm', '', ''),
(536, 'Cejas Gabriel', '3107', 'lala', 31724990, 'lala@hotmail.com', '2016-05-31', NULL, '', '1985-08-18', NULL, 2, 2, 1, 31724990, 1, 'm', '1236446', '46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio_debito`
--

CREATE TABLE IF NOT EXISTS `socio_debito` (
  `id` int(11) NOT NULL,
  `id_socio` int(11) NOT NULL,
  `id_debito` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `socio_debito`
--

INSERT INTO `socio_debito` (`id`, `id_socio`, `id_debito`) VALUES
(75, 1, 19),
(76, 1, 20),
(78, 1, 21),
(79, 2, 19),
(80, 2, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcuenta`
--

CREATE TABLE IF NOT EXISTS `subcuenta` (
  `id` int(11) NOT NULL,
  `id_cuenta` char(15) NOT NULL,
  `codigo` char(15) DEFAULT NULL,
  `concepto` varchar(60) NOT NULL,
  `nsubcuenta` varchar(40) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `subcuenta`
--

INSERT INTO `subcuenta` (`id`, `id_cuenta`, `codigo`, `concepto`, `nsubcuenta`) VALUES
(1, '1', '1.1', 'Activo Corriente', '3-4-12-20-43-44'),
(2, '1', '1.2', 'Activo no Corriente', '45-46-47-48-49'),
(3, '0', '1.1.1', 'Caja', NULL),
(4, '0', '1.1.2', 'Efectivo', NULL),
(12, '0', '1.1.3', 'Cheque', '30-31'),
(30, '0', '1.1.3.1', 'Cheque Propio', NULL),
(31, '0', '1.1.3.2', 'Cheque de Tercero', '32'),
(32, '0', '1.1.3.2.1', 'prueba', NULL),
(33, '4', '4.1', 'Resultado Positivo', '35-36'),
(34, '4', '4.2', 'Resultado Negativo', '39-40'),
(35, '0', '4.1.1', 'Cuota Societaria', '37-38'),
(36, '0', '4.1.2', 'Cuota Deportiva', '41-42'),
(37, '0', '4.1.1.1', 'Cuota Socio Vitalicio', NULL),
(38, '0', '4.1.1.2', 'Cuota Activo', NULL),
(39, '0', '4.2.1', 'Alquileres', NULL),
(40, '0', '4.2.2', 'Gastos Varios', NULL),
(41, '0', '4.1.2.1', 'CD Futbol Mayor', NULL),
(42, '0', '4.1.2.2', 'CD Voley', NULL),
(44, '0', '1.1.4', 'Cheque Banco', NULL),
(46, '0', '1.2.2', 'Prueba 2', NULL),
(48, '0', '1.2.3', 'prueba 3', NULL),
(49, '0', '1.2.1', 'prueba 1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `auth_key`, `password_reset_token`) VALUES
(1, 'gabriel', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `pasword` varchar(15) NOT NULL,
  `fecha_alta` date DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `usuario`, `pasword`, `fecha_alta`, `fecha_baja`) VALUES
(1, 'Administrador', 'admin', '123456', NULL, NULL),
(2, 'Gabriel Cejas', 'gabrieljcejas', '123456', '2015-11-30', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria_social`
--
ALTER TABLE `categoria_social`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cobrador`
--
ALTER TABLE `cobrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `debito`
--
ALTER TABLE `debito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_cuenta`
--
ALTER TABLE `estado_cuenta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimiento_detalle`
--
ALTER TABLE `movimiento_detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socio_debito`
--
ALTER TABLE `socio_debito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subcuenta`
--
ALTER TABLE `subcuenta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `categoria_social`
--
ALTER TABLE `categoria_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `cobrador`
--
ALTER TABLE `cobrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `debito`
--
ALTER TABLE `debito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `estado_cuenta`
--
ALTER TABLE `estado_cuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `movimiento_detalle`
--
ALTER TABLE `movimiento_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `provincia`
--
ALTER TABLE `provincia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `recibo`
--
ALTER TABLE `recibo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=537;
--
-- AUTO_INCREMENT de la tabla `socio_debito`
--
ALTER TABLE `socio_debito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT de la tabla `subcuenta`
--
ALTER TABLE `subcuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
