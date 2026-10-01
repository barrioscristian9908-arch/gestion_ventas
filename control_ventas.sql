-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-10-2026 a las 04:55:11
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
-- Base de datos: `control_ventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','vendedor','operador') NOT NULL DEFAULT 'vendedor',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `rol`, `activo`, `creado_en`) VALUES
(1, 'Administrador', 'admin', '$2y$10$cfD2NrLJ9HLJ4Axz9pltku1owUfOl5uGLZJQePaq5qcfMOCXho3Iu', 'admin', 1, '2026-09-26 00:12:13'),
(3, 'Ruben', 'ruben@gmail.com', '$2y$10$q7xuwnByYeUXMvkFiVSwG.zJN3KlMEULNUa3cQb5/hnK2jf8S5NJK', 'vendedor', 1, '2026-09-27 21:30:22'),
(4, 'Aldanaaa', 'aldana@gmail.com', '$2y$10$5SIvBjU4K.pcM0.Tn4wX1.t9jHFNlMzqWWhSWnkOh8tWfNqIHEAEW', 'vendedor', 1, '2026-09-27 21:43:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `vendedor_id` int(11) NOT NULL,
  `tipo_venta` enum('sorteo','moto','auto') NOT NULL DEFAULT 'sorteo',
  `cliente_nombre` varchar(150) NOT NULL,
  `cliente_dni` varchar(30) NOT NULL,
  `cliente_direccion` varchar(200) DEFAULT NULL,
  `cliente_telefono` varchar(30) DEFAULT NULL,
  `monto` decimal(12,2) NOT NULL,
  `cantidad_chances` int(11) DEFAULT 0,
  `medio_pago` varchar(50) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `vendedor_id`, `tipo_venta`, `cliente_nombre`, `cliente_dni`, `cliente_direccion`, `cliente_telefono`, `monto`, `cantidad_chances`, `medio_pago`, `creado_en`) VALUES
(1, 3, 'sorteo', 'juan perez', '44536544', 'ggrtgttrh4hdhh', '4356365465', 30000.00, 50, 'Transferencia', '2026-09-28 01:44:59'),
(2, 3, 'sorteo', 'fabian mancuello', '23423443', 'jtjjjhtyhtyh56y65y6gr', '4356365465', 50000.00, 90, 'Efectivo', '2026-09-28 01:47:36'),
(3, 3, 'sorteo', 'alberto fernandez', '', '8 De Octubre Bis M13 C8', '4356365465', 100000.00, 500, 'Tarjeta', '2026-09-29 00:27:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_comprobantes`
--

CREATE TABLE `venta_comprobantes` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendedor_id` (`vendedor_id`);

--
-- Indices de la tabla `venta_comprobantes`
--
ALTER TABLE `venta_comprobantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `venta_comprobantes`
--
ALTER TABLE `venta_comprobantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`vendedor_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `venta_comprobantes`
--
ALTER TABLE `venta_comprobantes`
  ADD CONSTRAINT `venta_comprobantes_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
