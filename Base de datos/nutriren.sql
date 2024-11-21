-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2024 a las 16:51:45
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
-- Base de datos: `nutriren`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrativo`
--

CREATE TABLE `administrativo` (
  `ID` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `tipo_cuenta` enum('Medico','Admin') NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `paciente_id` int(11) DEFAULT NULL,
  `medico_id` int(11) DEFAULT NULL,
  `detalles_menu` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `paciente_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `genero` enum('Masculino','Femenino','Otro') DEFAULT NULL,
  `altura` float DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `nivel_erc` varchar(100) DEFAULT NULL,
  `comida_favorita` text DEFAULT NULL,
  `disgustos` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`paciente_id`, `usuario_id`, `nombre`, `edad`, `genero`, `altura`, `peso`, `nivel_erc`, `comida_favorita`, `disgustos`, `fecha_registro`) VALUES
(1, 1, 'Juan Pérez', 30, 'Masculino', 175, 70, 'Ninguno', 'Pizza', 'Ninguno', '2024-11-15 09:36:45'),
(2, NULL, 'Juan con miedo', 49, 'Masculino', 189, 75, '1', 'Pera', 'Manzana', '2024-11-15 09:54:23'),
(3, NULL, 'Juan sin miedo', 25, 'Masculino', 190, 80, '0', 'Todo', 'Nada', '2024-11-15 09:55:15'),
(4, NULL, 'Tetsys', 4, 'Masculino', 150, 50, '0', 'papirringas', 'pimientos', '2024-11-15 14:38:26'),
(5, NULL, 'Tetsys', 4, 'Masculino', 160, 48, '0', 'papirringas', 'pimientos', '2024-11-21 15:09:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Estado_Pago` enum('sin_realizar','pendiente','aceptado','rechazado') NOT NULL,
  `Comprobante` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `correo`, `contraseña`, `telefono`, `nombre`, `edad`, `fecha_creacion`, `Estado_Pago`, `Comprobante`) VALUES
(1, 'pepe@pepe.com', '$2y$10$9VJlQX5klJNH.QWVfhk4hOGh1USxKWfvEfBmecj1tAXIh6KmUIfhe', '5', 'Pepe', 25, '2024-11-15 09:11:50', 'sin_realizar', ''),
(2, 'gatomiu@gmail.com', '$2y$10$YZ8Kl2RbOM8RU7IHn9vp7uPFaPVUzW.HaEprfFYztUetj/foL25ky', '24617622435', 'Diana Lima García', 17, '2024-11-15 14:36:47', 'sin_realizar', ''),
(3, 'lo@gmail.com', '$2y$10$f1q9F5ioihXiSKQ2sn8raegmtld6764letjPtIjUDQh7ZZ9PDiJH6', '5555555555', 'Juan con algo de miedo', 28, '2024-11-21 15:12:11', 'sin_realizar', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_paciente`
--

CREATE TABLE `usuario_paciente` (
  `usuario_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_paciente`
--

INSERT INTO `usuario_paciente` (`usuario_id`, `paciente_id`, `activo`) VALUES
(1, 1, 0),
(1, 2, 1),
(1, 3, 1),
(1, 5, 0),
(2, 4, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrativo`
--
ALTER TABLE `administrativo`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`paciente_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `usuario_paciente`
--
ALTER TABLE `usuario_paciente`
  ADD PRIMARY KEY (`usuario_id`,`paciente_id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrativo`
--
ALTER TABLE `administrativo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `paciente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`paciente_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menus_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `administrativo` (`ID`) ON DELETE SET NULL;

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `pacientes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario_paciente`
--
ALTER TABLE `usuario_paciente`
  ADD CONSTRAINT `usuario_paciente_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_paciente_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`paciente_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
