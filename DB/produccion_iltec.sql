-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-12-2024 a las 06:43:02
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `produccion_iltec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumo`
--

CREATE TABLE `consumo` (
  `Cantidad_Pintura` float NOT NULL,
  `Lavado` float NOT NULL,
  `Pintura` float NOT NULL,
  `Horneo` float NOT NULL,
  `id_Item` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consumo`
--

INSERT INTO `consumo` (`Cantidad_Pintura`, `Lavado`, `Pintura`, `Horneo`, `id_Item`) VALUES
(0.63, 3.3, 6.6, 3.3, 8910),
(0.09, 0.636, 1, 0.636, 25408),
(0.086, 0.66, 1.6, 0.7, 26801),
(0.09, 0.66, 1.6, 0.66, 27421),
(0.069, 0.6, 0.888, 0.65, 27749);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item`
--

CREATE TABLE `item` (
  `Numero_Item` int(8) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `CorreoRegistro` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `item`
--

INSERT INTO `item` (`Numero_Item`, `Nombre`, `CorreoRegistro`) VALUES
(8910, 'CILINDRO EN LAMINA C.R. (15.0 Cms)', 'iltecAdministrador@gmail.com'),
(25408, 'CILINDRO EN ALUMINIO P/BALA SATURNO 33W', 'iltecAdministrador@gmail.com'),
(26801, 'CILINDRO EN ALUMINIO P/BALA SATURNO 33W', 'iltecAdministrador@gmail.com'),
(27421, 'CILINDRO EN ALUMINIO P/BALA AURA 12W', 'iltecAdministrador@gmail.com'),
(27749, 'CILINDRO EN ALUMINIO P/BALA SATURNO 32W', 'iltecAdministrador@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `Correo` varchar(50) NOT NULL,
  `Contraseña` varchar(30) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`Correo`, `Contraseña`, `Usuario`, `Rol`) VALUES
('iltecAdministrador@gmail.com', 'wdo02', 'Administrador Iltec', 'Administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consumo`
--
ALTER TABLE `consumo`
  ADD KEY `Numero_Item` (`id_Item`);

--
-- Indices de la tabla `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`Numero_Item`),
  ADD KEY `item-registro` (`CorreoRegistro`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`Correo`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consumo`
--
ALTER TABLE `consumo`
  ADD CONSTRAINT `consumo-item` FOREIGN KEY (`id_Item`) REFERENCES `item` (`Numero_Item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item-registro` FOREIGN KEY (`CorreoRegistro`) REFERENCES `registro` (`Correo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
