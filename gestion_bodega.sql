-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-07-2019 a las 12:21:54
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_bodega`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
  `rut` varchar(20) NOT NULL,
  `cod_producto` varchar(50) NOT NULL,
  `cantidad` varchar(50) NOT NULL,
  `fecha_entrega` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entregas`
--

INSERT INTO `entregas` (`rut`, `cod_producto`, `cantidad`, `fecha_entrega`) VALUES
('123', '101', '40', '10/10/2017'),
('204837104', '008', '25', '11/10/17'),
('204837104', '100', '25', '10/10/2017'),
('705867584', '100', '25', '10/10/2017'),
('12121', '008', '34', '11/10/17'),
('204837104', '101', '6', '10/10/2017');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `rut` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`rut`, `nombre`, `apellido`, `cargo`, `contrasena`) VALUES
('17150258', 'florentino', 'vargas', 'Admin', '202cb962ac59075b964b07152d234b70'),
('18150258', 'junior', 'vargas ', 'Bodega', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `cod_producto` varchar(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `stock` varchar(20) NOT NULL,
  `proveedor` varchar(50) NOT NULL,
  `fecha_ingreso` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`cod_producto`, `descripcion`, `stock`, `proveedor`, `fecha_ingreso`) VALUES
('007', 'PC Gamer', '1', 'PcFactory', '10/10/2017'),
('008', 'Auto', '6', 'AutoLavo', '10/10/2017'),
('100', 'Casco de seguridad', '17', 'Vicsa S.A', '20-04-2016'),
('101', 'Guantes de seguridad', '44', 'Fesam LTDA', '2016-04-22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`rut`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`cod_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
