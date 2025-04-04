-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2025 a las 17:56:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `brandswap`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(100) NOT NULL,
  `id_usuario` int(100) NOT NULL,
  `id_producto` int(100) NOT NULL,
  `fecha_compra` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `metodo_pago` varchar(100) NOT NULL,
  `id_vendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compra`, `id_usuario`, `id_producto`, `fecha_compra`, `metodo_pago`, `id_vendedor`) VALUES
(1, 4, 6, '2025-03-20 22:10:47.000000', 'Tarjeta', 0),
(2, 4, 29, '2025-03-21 12:10:19.000000', 'Tarjeta', 0),
(3, 7, 23, '2025-03-21 12:21:31.000000', 'Tarjeta', 0),
(4, 7, 22, '2025-03-21 12:28:13.000000', 'Tarjeta', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(100) NOT NULL,
  `id_usuario` int(100) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(65,0) NOT NULL,
  `fecha_publicacion` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `imagen` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_usuario`, `nombre_producto`, `descripcion`, `precio`, `fecha_publicacion`, `imagen`) VALUES
(1, 4, 'sudadera azul', 'sudadera con capucha azul intenso', 25, '2025-03-20 19:11:43.914417', NULL),
(7, 4, 'Sudadera Verde', 'Sudadera con capucha', 30, '2025-03-20 19:14:14.000000', NULL),
(8, 4, 'Sudadera Naranja', 'Sudadera con capucha', 33, '2025-03-20 19:15:40.000000', NULL),
(21, 4, 'sudadera rosa', 'ss', 6, '2025-03-21 11:01:55.000000', NULL),
(30, 7, 'pantalon azul', '222', 23, '2025-03-21 12:12:01.000000', NULL),
(31, 7, 'sudadera rosa', 'con capcuha', 23, '2025-03-21 16:31:17.000000', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `foto_perfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `contrasena`, `fecha_registro`, `foto_perfil`) VALUES
(4, 'Victoria', 'victorialdc10@gmail.com', '$2y$10$x4tKaGdOJCdMHwqhrqD2Je1Il2pVElSwoGAHP/UgLVsbfgDJqDkhK', '2025-03-05 19:37:42', 'uploads/perfil_67c899f6d7190.jpg'),
(7, 'juan', 'juan@gmail.com', '$2y$10$gsNAScxxKnDclvZGxoNwVeicRVAuT7VOJP04XfIuyaKjqpUuMJgMK', '2025-03-06 12:12:47', 'uploads/perfil_67c9832f83cd8.jpg'),
(8, 'laura', 'laura@gmail.com', '$2y$10$S4LOS1UVL0QnvNtpe7OiR.f.woqd4Vz3QUAzVGYD/Jo5CT3SXN7he', '2025-03-20 12:30:33', 'uploads/default-avatar.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id_valoracion` int(11) NOT NULL,
  `id_comprador` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `fecha_valoracion` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoraciones`
--

INSERT INTO `valoraciones` (`id_valoracion`, `id_comprador`, `id_vendedor`, `puntuacion`, `comentario`, `fecha_valoracion`) VALUES
(7, 7, 4, 3, 'eeee', '2025-03-21 16:55:54.000000');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id_valoracion`),
  ADD UNIQUE KEY `id_comprador` (`id_comprador`),
  ADD UNIQUE KEY `id_vendedor` (`id_vendedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id_valoracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
