-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 11-01-2026 a las 22:28:53
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_online`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `id_usuario`, `id_producto`, `cantidad`) VALUES
(65, 14, 9, 2),
(73, 12, 11, 1),
(78, 15, 9, 1),
(79, 15, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categorias` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categorias`, `nombre`) VALUES
(1, 'ruedas'),
(2, 'cascos11'),
(3, 'maillots'),
(4, 'culottesss');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_productos` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` float NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(500) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `ventas` int(11) NOT NULL,
  `id_categorias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_productos`, `nombre`, `precio`, `stock`, `imagen`, `descripcion`, `ventas`, `id_categorias`) VALUES
(1, 'van rysel Casco Ciclismo carretera', 89.99, 10, './imagenes/cascoVanRisel.png', 'casco de carretera de color blanco ', 3, 2),
(2, 'Casco Met Trenta 3K Carbon Mips\r\n', 231, 5, './imagenes/cascoMet.png', 'casco de bicicleta de carretera ultima generación', 2, 2),
(3, 'casco Specialized Sworks 2026', 256, 15, './imagenes/cascoSworks.png', 'Casco Specialized S-Works Prevail 3 edición limitada', 8, 2),
(4, 'casco poc ventral air mips', 197.95, 20, './imagenes/cascoPoc.png', 'POC Ventral Air MIPS Casco Ciclismo - Hydrogen Blanco Matt', 6, 2),
(5, 'ruedas zipp 303 firecrest', 1994, 3, './imagenes/ruedasZipp.png', 'Las ruedas Zipp 303 Firecrest Disc Carbon para tubeless es más rápida, más ligera y más polivalente en terrenos variados.', 1, 1),
(6, 'Juego de Ruedas ENVE - SES 4.5', 3304.62, 3, './imagenes/ruedasEnve.png', 'ENVE Juego de Ruedas - SES 4.5 - 28\" | Carbon | Hookless | Straight Pull | Centerlock - 12x100mm', 12, 1),
(7, 'Juego de Ruedas DT Swiss - ARC 1100 DICUT db 50', 1778.39, 10, './imagenes/ruedasDtswiss.png', 'DT Swiss Juego de Ruedas - ARC 1100 DICUT db 50 - 28\" | Carbono | Clincher | Centerlock - 12x100mm | 12x142mm - HG-EV / XDR', 8, 1),
(8, 'MEILENSTEIN OBERMAYER Lightweight', 5509.1, 0, './imagenes/ruedasLighweigh.png', 'Todavía más ligera y aún más rígida. La rueda con radios de carbono más exclusiva.', 0, 1),
(9, 'Maillot Rapha manga larga', 136.5, 22, './imagenes/maillotRapha.png', 'El maillot siempre te mantiene seco, no se pega a la piel tras largas horas de uso.', 16, 3),
(10, 'Maillot Gore c3', 94.99, 19, './imagenes/maillotGore.png', 'Maillot manga larga apto para temperaturas de hasta 10ºC', 6, 3),
(11, 'Maillot Etxeondo Orhi', 139.9, 5, './imagenes/maillotEtxeondo.png', 'Maillot para epoca primavera con corte laser y ultra elastico', 9, 3),
(12, 'Maillot Gobik cxpro 2.0', 80.9, 10, './imagenes/maillotGobik.png', 'Maillot entre tiempo Gobik temporada 2024', 2, 3),
(13, 'Culotte etxeondo azul glaciar', 169.5, 0, './imagenes/culotteEtxeondo.png', 'Culotte profesional de Etxeondo que aúna rendimiento y comodidad.', 25, 4),
(14, 'Culotte Q36.5 verano dottore', 250, 1, './imagenes/culotteQ36.png', 'Salopette DOTTORE, el bibshort ergogénico, una versión fina y afinada de la Salopette L1.', 3, 4),
(15, 'Culotte Gobik Absolute 5.0', 109.95, 7, './imagenes/culotteGobik.png', 'CULOTTE CORTO ABSOLUTE 5.0 HOMBRE DEEP BLUE - K10', 4, 4),
(16, 'Culotte  Santini Verano RX69', 65.59, 15, './imagenes/culotteSantini.png', 'Culotte Santini gama basica verano ', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `fechaNacimiento` varchar(100) NOT NULL,
  `codigoPostal` int(11) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `sexo` varchar(50) NOT NULL,
  `municipio` varchar(100) NOT NULL,
  `disponibilidad` varchar(50) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `intentos` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `fechaNacimiento`, `codigoPostal`, `telefono`, `sexo`, `municipio`, `disponibilidad`, `password`, `intentos`) VALUES
(11, 'bbb', 'bbb@educa.madrid.org', '2000-02-02', 20500, '+66655544466', 'hombre', 'mejorada', '', '$2y$10$aOIFDcTztHizxTpG2DnHsu74gbAWi.RJ.bgST/tmX9.WlW91/ALQO', 0),
(12, 'aaa', 'aaa@educa.madrid.org', '2000-02-20', 20500, '+66655544499', 'hombre', 'mejorada', '', '$2y$10$NM202KA14yNk4ZmGuRlKh.2vZiRbwIGGACxosRM8OboyBCQTaeZ2K', 0),
(14, 'cesar', 'cesar@educa.madrid.org', '2025-05-05', 20500, '+66655544499', 'hombre', 'velilla', '', '$2y$10$KUxw9J3Nh4uZHUQPUR04OeNB0cQbvJNO3LOHntHoDYJ6R.u4U8oYu', 0),
(15, 'jose ', 'jose@educa.madrid.org', '2025-05-05', 20555, '+66655544455', 'hombre', 'velilla', '', '$2y$10$6Y2hvtHNVkjmwCEuOgZfIegAwets0gu9OVM7R3r4Lq/vBak0.XgXm', 0),
(16, 'luis', 'luis@educa.madrid.org', '2023-03-03', 20333, '+11122233344', 'otro', 'mejorada', '', '$2y$10$5Xl9vlKrgafLoBAm.zmfr.8GqkuseA5ktF8vfQKX0s8gi.Z2Z8Z2O', 0),
(20, 'pepe', 'pepe@educa.madrid.org', '2021-01-01', 20111, '+66655544499', 'hombre', 'mejorada', 'mt', '$2y$10$QHCmtIJ7Vpx7SrymFnmxtuXVGMdZaRKvCHG3aYxi6E430vgWkrcjq', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `FK_carrito_id_usuario` (`id_usuario`),
  ADD KEY `FK_carrito_id_producto` (`id_producto`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categorias`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_productos`),
  ADD KEY `FK_id_categoria` (`id_categorias`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categorias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_productos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `FK_carrito_id_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_productos`),
  ADD CONSTRAINT `FK_carrito_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `FK_id_categoria` FOREIGN KEY (`id_categorias`) REFERENCES `categorias` (`id_categorias`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
