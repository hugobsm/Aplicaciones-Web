-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-04-2025 a las 12:23:28
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
-- Base de datos: `brandswap`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Mujer'),
(2, 'Hombre'),
(3, 'Niño'),
(4, 'Unisex'),
(5, 'Blusas'),
(6, 'Vestidos'),
(7, 'Sudaderas'),
(8, 'Abrigos'),
(9, 'Tops'),
(10, 'Accesorios'),
(11, 'Calzado'),
(12, 'Camisetas'),
(13, 'Pantalones'),
(14, 'Color Negro'),
(15, 'Color Verde'),
(16, 'Color Rosa'),
(17, 'Color Amarillo'),
(18, 'Color Naranja'),
(19, 'Color Rojo'),
(20, 'Color Azul'),
(21, 'Color Morado'),
(22, 'Color Lila'),
(23, 'Color Marrón'),
(24, 'Color Blanco'),
(25, 'Talla S'),
(26, 'Talla XS'),
(27, 'Talla M'),
(28, 'Talla L'),
(29, 'Talla XL'),
(30, 'Color Multicolor');

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
(13, 7, 133, '2025-04-25 11:36:43.000000', 'Tarjeta', 4),
(15, 4, 135, '2025-04-25 11:44:27.000000', 'Tarjeta', 7),
(16, 7, 134, '2025-04-25 11:45:26.000000', 'Tarjeta', 4);

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
(131, 4, 'camiseta', 'Unisex, camisetas, verde, M', 15, '2025-04-25 11:32:13.000000', 'uploads/img_680b72bda4ffd.png'),
(136, 7, 'camiseta', 'Hombre, rojo', 25, '2025-04-27 11:10:22.000000', 'uploads/img_680e109e4cf78.png'),
(137, 26, 'camiseta', 'camiseta amarilla', 20, '2025-04-27 23:33:57.000000', 'uploads/img_680ebee5e482c.jpeg'),
(138, 26, 'camiseta', 'camiseta naranja', 12, '2025-04-27 23:34:24.000000', 'uploads/img_680ebf0090dd9.jpeg'),
(139, 26, 'camiseta', 'camiseta morada', 11, '2025-04-27 23:35:04.000000', 'uploads/img_680ebf2816d7a.jpeg'),
(140, 26, 'camiseta', 'camiseta azul', 22, '2025-04-27 23:35:47.000000', 'uploads/img_680ebf5314b14.jpeg'),
(141, 26, 'camiseta', 'camiseta rosa', 13, '2025-04-27 23:36:23.000000', 'uploads/img_680ebf7712de1.jpeg'),
(142, 26, 'camiseta', 'camiseta negra', 11, '2025-04-27 23:37:06.000000', 'uploads/img_680ebfa2d0786.jpeg'),
(143, 26, 'camiseta', 'camiseta lila', 22, '2025-04-27 23:41:29.000000', 'uploads/img_680ec0a97e060.jpeg'),
(144, 26, 'camiseta', 'camiseta marron', 20, '2025-04-27 23:42:11.000000', 'uploads/img_680ec0d35a184.jpeg'),
(145, 26, 'camiseta', 'camiseta blanca', 12, '2025-04-27 23:42:58.000000', 'uploads/img_680ec1021862c.jpeg'),
(146, 26, 'camiseta', 'camiseta blanca hombre', 21, '2025-04-27 23:43:20.000000', 'uploads/img_680ec1189de40.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_categoria`
--

CREATE TABLE `producto_categoria` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_categoria`
--

INSERT INTO `producto_categoria` (`id_producto`, `id_categoria`) VALUES
(131, 4),
(131, 12),
(131, 15),
(131, 27),
(136, 2),
(136, 19),
(137, 4),
(137, 12),
(137, 17),
(137, 25),
(138, 1),
(138, 12),
(138, 18),
(138, 26),
(139, 4),
(139, 12),
(139, 21),
(139, 29),
(140, 4),
(140, 12),
(140, 20),
(140, 28),
(141, 2),
(141, 12),
(141, 16),
(141, 27),
(142, 1),
(142, 12),
(142, 14),
(142, 25),
(143, 2),
(143, 12),
(143, 22),
(143, 27),
(144, 1),
(144, 12),
(144, 23),
(144, 25),
(145, 1),
(145, 12),
(145, 24),
(145, 25),
(146, 2),
(146, 12),
(146, 24),
(146, 28);

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
  `foto_perfil` varchar(255) DEFAULT NULL,
  `tipo` varchar(20) NOT NULL DEFAULT 'user',
  `edad` int(11) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `genero` enum('Hombre','Mujer','Otro') DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `contrasena`, `fecha_registro`, `foto_perfil`, `tipo`, `edad`, `pais`, `genero`, `telefono`) VALUES
(4, 'Victoria', 'victorialdc10@gmail.com', '$2y$10$x4tKaGdOJCdMHwqhrqD2Je1Il2pVElSwoGAHP/UgLVsbfgDJqDkhK', '2025-03-05 19:37:42', 'uploads/perfil_67c899f6d7190.jpg', 'user', 22, 'España', 'Mujer', '+34600111222'),
(7, 'juan', 'juan@gmail.com', '$2y$10$gsNAScxxKnDclvZGxoNwVeicRVAuT7VOJP04XfIuyaKjqpUuMJgMK', '2025-03-06 12:12:47', 'uploads/perfil_67c9832f83cd8.jpg', 'user', 30, 'México', 'Hombre', '+525511223344'),
(15, 'lucia', 'lucai@gmail.com', '$2y$10$j.9JzpuBYGdKpgGtGtta7.P/HCLIo5FGNgRQESBhzp8QEXBNs0PN2', '2025-04-23 18:47:13', 'uploads/perfil_68091990eecc5.jpg', 'admin', 27, 'Argentina', 'Mujer', '+541131112233'),
(17, 'carlos', 'carlos@gmail.com', '$2y$10$WFs1VRcZHQdThfiYxBwDH.hx6FfOPvu9L3V19eqoa8lrn8UodV3yu', '2025-04-24 20:45:53', 'uploads/default-avatar.png', 'usuario', NULL, NULL, NULL, NULL),
(25, 'laura', 'laura@gmail.com', '$2y$10$okVoQ6fzpu6/bfk9xkkEVeUldGzaX.BrgGrREePv1wGeodAYTZk9G', '2025-04-27 18:51:13', 'uploads/default-avatar.png', 'usuario', 25, 'España', 'Mujer', '+34678 456 453'),
(26, 'Mario', 'Mario@ucm.es', '$2y$10$Sg0MfHmdgJ8tbYdo3UJwcOwuOIh6NVC14UWJ5wgrUSBiTS6NzeuVm', '2025-04-28 00:31:53', 'uploads/perfil_680eb05971924.jpg', 'usuario', 22, 'España', 'Hombre', '+34633921795');

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
  `fecha_valoracion` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoraciones`
--

INSERT INTO `valoraciones` (`id_valoracion`, `id_comprador`, `id_vendedor`, `puntuacion`, `comentario`, `fecha_valoracion`, `id_producto`) VALUES
(12, 7, 4, 4, 'Buen servicio, muy atenta y servicial', '2025-04-25 11:37:10.000000', 0),
(15, 4, 7, 5, 'Buen trato, la calidad es perfecta', '2025-04-25 11:44:43.000000', 0),
(20, 7, 4, 4, 'Buena comunicación y envío rápido', '2025-04-25 11:51:22.164116', 0),
(23, 7, 4, 4, 'Buena comunicación y envío rápido', '2025-04-25 11:55:49.438323', 0),
(25, 7, 4, 4, 'Ideal', '2025-04-25 11:55:49.438323', 0),
(26, 17, 4, 2, 'Producto no era como esperaba', '2025-04-25 12:00:55.437694', 0),
(28, 4, 7, 3, 'e', '2025-04-27 10:45:07.000000', 135);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `compras_ibfk_1` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `producto_categoria`
--
ALTER TABLE `producto_categoria`
  ADD PRIMARY KEY (`id_producto`,`id_categoria`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id_valoracion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id_valoracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_categoria`
--
ALTER TABLE `producto_categoria`
  ADD CONSTRAINT `producto_categoria_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `producto_categoria_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
