-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2020 a las 22:51:14
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `segundo_parcial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `materia` varchar(35) COLLATE utf8_spanish2_ci NOT NULL,
  `cuatrimestre` int(11) NOT NULL,
  `cupos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `materia`, `cuatrimestre`, `cupos`, `created_at`, `updated_at`) VALUES
(1, 'Matematica I', 1, 4, '2020-11-28 23:36:24', '2020-11-29 16:14:39'),
(2, 'Programcion II', 2, 4, '2020-11-28 23:36:24', '2020-12-01 11:35:59'),
(3, 'Legislacion', 4, 5, '2020-11-28 23:36:24', '2020-11-28 23:36:24'),
(4, 'P3', 3, 20, '2020-11-29 05:06:45', '2020-11-29 05:06:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias_usuarios`
--

CREATE TABLE `materias_usuarios` (
  `id` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nota` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `materias_usuarios`
--

INSERT INTO `materias_usuarios` (`id`, `id_materia`, `id_usuario`, `nota`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 6, '2020-11-29 16:14:39', '2020-12-01 13:59:36'),
(4, 1, 5, 0, '2020-12-01 15:28:53', '2020-12-01 15:28:53'),
(5, 1, 8, 0, '2020-12-01 15:29:21', '2020-12-01 15:29:21'),
(6, 2, 7, 0, '2020-12-01 15:29:40', '2020-12-01 15:29:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `clave`, `tipo`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Mariano', '1234', 'admin', 'marianoovelar200@gmail.com', '2020-11-04 21:36:41', '2020-11-18 21:36:41'),
(2, 'Juan', '1234', 'profesor', 'juan88@gmail.com', '2020-11-24 02:25:30', '2020-11-24 02:25:30'),
(3, 'Pepe', '1234', 'alumno', 'pepe@mail.com', '2020-11-24 02:27:28', '2020-11-24 02:27:28'),
(4, 'Rosa', '1234', 'admin', 'rosa@mail.com', '2020-11-29 00:35:47', '2020-11-29 00:35:47'),
(5, 'pepe2', '1234', 'alumno', 'pepe2@gmail.com', '2020-12-01 15:26:26', '2020-12-01 15:26:26'),
(6, 'pepe3', '1234', 'alumno', 'pepe3@gmail.com', '2020-12-01 15:26:40', '2020-12-01 15:26:40'),
(7, 'pepe4', '1234', 'alumno', 'pepe4@gmail.com', '2020-12-01 15:26:57', '2020-12-01 15:26:57'),
(8, 'pepe5', '1234', 'alumno', 'pepe5@gmail.com', '2020-12-01 15:27:10', '2020-12-01 15:27:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materias_usuarios`
--
ALTER TABLE `materias_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `materias_usuarios`
--
ALTER TABLE `materias_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `materias_usuarios`
--
ALTER TABLE `materias_usuarios`
  ADD CONSTRAINT `materias_usuarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `materias_usuarios_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
