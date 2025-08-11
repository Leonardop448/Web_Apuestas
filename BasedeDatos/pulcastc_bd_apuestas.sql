-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 03-07-2025 a las 20:42:52
-- Versión del servidor: 8.0.37
-- Versión de PHP: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pulcastc_bd_apuestas`
--
CREATE DATABASE IF NOT EXISTS `pulcastc_bd_apuestas` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci;
USE `pulcastc_bd_apuestas`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `ActualizarUsuarios`$$
CREATE DEFINER=`pulcastc`@`localhost` PROCEDURE `ActualizarUsuarios` (IN `p_nombre` VARCHAR(100), IN `p_telefono` VARCHAR(100), IN `p_email` VARCHAR(100), IN `p_token` VARCHAR(255))   BEGIN
    UPDATE usuarios
    SET
        nombre = p_nombre,
        telefono = p_telefono,
        email = p_email
    WHERE tokenUsuario = p_token;
END$$

DROP PROCEDURE IF EXISTS `Balance`$$
CREATE DEFINER=`pulcastc`@`localhost` PROCEDURE `Balance` (IN `p_tokenUsuario` VARCHAR(255))   BEGIN
    SELECT saldo
    FROM usuarios
    WHERE tokenUsuario = p_tokenUsuario;
END$$

DROP PROCEDURE IF EXISTS `ContarMovimientos`$$
CREATE DEFINER=`pulcastc`@`localhost` PROCEDURE `ContarMovimientos` (IN `p_token` VARCHAR(255))   BEGIN
    SELECT COUNT(*) AS Cantidad
    FROM movimientos
    WHERE token = p_token;
END$$

DROP PROCEDURE IF EXISTS `Login`$$
CREATE DEFINER=`pulcastc`@`localhost` PROCEDURE `Login` (IN `p_email` VARCHAR(100))   BEGIN
    SELECT id, nombre, email, contrasena, cedula, privilegios, tokenUsuario, telefono, fecha_registro, saldo, activo
    FROM usuarios
    WHERE email = p_email;
END$$

DROP PROCEDURE IF EXISTS `Movimientos`$$
CREATE DEFINER=`pulcastc`@`localhost` PROCEDURE `Movimientos` (IN `p_token` VARCHAR(255), IN `paginas` INT, IN `porPagina` INT)   BEGIN
    DECLARE offsetPaginas INT;
    SET offsetPaginas = (paginas - 1) * porPagina;

    SELECT *
    FROM movimientos
    WHERE token = p_token
    ORDER BY fecha DESC
    LIMIT porPagina OFFSET offsetPaginas;
END$$

DROP PROCEDURE IF EXISTS `Recargar`$$
CREATE DEFINER=`pulcastc`@`localhost` PROCEDURE `Recargar` (IN `p_tokenUsuario` VARCHAR(255), IN `p_cantidad` INT, IN `p_gestor` VARCHAR(255))   BEGIN
    DECLARE v_saldo_actual INT;

    SELECT saldo INTO v_saldo_actual
    FROM usuarios
    WHERE tokenUsuario = p_tokenUsuario;

    UPDATE usuarios
    SET saldo = v_saldo_actual + p_cantidad
    WHERE tokenUsuario = p_tokenUsuario;

    INSERT INTO movimientos (
        descripcion,
        fecha,
        ingresos,
        egresos,
        token,
        gestor
    ) VALUES (
        CONCAT('Recarga de ', p_cantidad),
        NOW(),
        p_cantidad,
        0,
        p_tokenUsuario,
        p_gestor
    );

    SELECT LAST_INSERT_ID() AS id_movimiento;
END$$

DROP PROCEDURE IF EXISTS `RegistrarUsuario`$$
CREATE DEFINER=`pulcastc`@`localhost` PROCEDURE `RegistrarUsuario` (IN `p_nombre` VARCHAR(100), IN `p_contrasena` VARCHAR(255), IN `p_cedula` INT, IN `p_telefono` VARCHAR(100), IN `p_email` VARCHAR(100))   BEGIN
    DECLARE token VARCHAR(64);
    SET token = UPPER(SHA2(UUID(), 256));

    INSERT INTO usuarios (nombre, contrasena, cedula, telefono, email, tokenUsuario)
    VALUES (p_nombre, p_contrasena, p_cedula, p_telefono, p_email, token);

    SELECT LAST_INSERT_ID() AS id, token;
END$$

DROP PROCEDURE IF EXISTS `verificarRecargas`$$
CREATE DEFINER=`pulcastc`@`localhost` PROCEDURE `verificarRecargas` (IN `p_cedula` INT, IN `p_cantidad` INT)   BEGIN
    SELECT
        u.tokenUsuario AS token,
        u.nombre,
        u.telefono,
        u.email,
        p_cantidad AS cantidad
    FROM usuarios u
    WHERE u.cedula = p_cedula;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apuestas`
--

DROP TABLE IF EXISTS `apuestas`;
CREATE TABLE `apuestas` (
  `id` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_carrera` int NOT NULL,
  `id_piloto` int NOT NULL,
  `tipo_apuesta` enum('ganador','podio') NOT NULL,
  `monto` int NOT NULL,
  `ganancia_esperada` float NOT NULL,
  `resultado` enum('pendiente','ganada','perdida') DEFAULT 'pendiente',
  `creada_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `apuestas`
--

INSERT INTO `apuestas` (`id`, `id_usuario`, `id_carrera`, `id_piloto`, `tipo_apuesta`, `monto`, `ganancia_esperada`, `resultado`, `creada_en`, `categoria`) VALUES
(49, 2, 9, 4, 'ganador', 20000, 40000, 'ganada', '2025-06-29 14:58:33', 'Novatos'),
(50, 2, 9, 1, 'ganador', 20000, 40000, 'perdida', '2025-06-29 21:33:21', 'Élite'),
(51, 2, 9, 2, 'podio', 20000, 28000, 'ganada', '2025-06-29 21:45:02', 'Expertos'),
(53, 6, 11, 2, 'ganador', 45000, 90000, 'ganada', '2025-07-01 21:30:57', 'Novatos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

DROP TABLE IF EXISTS `carreras`;
CREATE TABLE `carreras` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` enum('pendiente','finalizada') DEFAULT 'pendiente',
  `creada_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `categorias` varchar(255) NOT NULL DEFAULT 'SinCategoria'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `nombre`, `fecha`, `estado`, `creada_en`, `categorias`) VALUES
(9, 'Carrera Callejera La Estacion Cartago', '2025-07-06 18:00:00', 'finalizada', '2025-06-29 13:48:40', 'Novatos,Élite,150 cc,Master,Expertos'),
(10, 'Carrera Estación ', '2025-07-02 18:00:00', 'finalizada', '2025-07-01 01:13:06', 'Novatos,Élite,150 cc'),
(11, 'Carrera Anserma Caldas', '2025-08-01 18:00:00', 'finalizada', '2025-07-01 16:03:19', 'Novatos,Élite,150 cc,Master,200cc 2T,Expertos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera_pilotos`
--

DROP TABLE IF EXISTS `carrera_pilotos`;
CREATE TABLE `carrera_pilotos` (
  `id` int NOT NULL,
  `id_carrera` int NOT NULL,
  `id_piloto` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `carrera_pilotos`
--

INSERT INTO `carrera_pilotos` (`id`, `id_carrera`, `id_piloto`) VALUES
(14, 9, 2),
(15, 9, 4),
(16, 9, 1),
(17, 9, 3),
(18, 10, 2),
(19, 10, 4),
(20, 10, 1),
(21, 10, 3),
(22, 11, 2),
(23, 11, 4),
(24, 11, 1),
(25, 11, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

DROP TABLE IF EXISTS `movimientos`;
CREATE TABLE `movimientos` (
  `id` int NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ingresos` int NOT NULL DEFAULT '0',
  `egresos` int NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL,
  `gestor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `descripcion`, `fecha`, `ingresos`, `egresos`, `token`, `gestor`) VALUES
(5, 'Recarga de 5000', '2025-06-08 17:09:02', 5000, 0, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(6, 'Recarga de 2000', '2025-06-08 17:14:35', 2000, 0, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(7, 'Recarga de 2000', '2025-06-08 17:15:57', 2000, 0, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(8, 'Recarga de 3000', '2025-06-08 17:19:48', 3000, 0, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(9, 'Recarga de 2000', '2025-06-08 17:24:02', 2000, 0, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(10, 'Recarga de 3000', '2025-06-08 17:26:40', 3000, 0, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(11, 'Recarga de 10000', '2025-06-23 18:28:14', 10000, 0, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(12, 'Recarga de 5000', '2025-06-23 18:32:31', 5000, 0, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(13, 'Recarga de 2000', '2025-06-23 18:38:43', 2000, 0, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(16, 'Recarga de 30000', '2025-06-24 13:54:14', 30000, 0, '6ED317BEFBA02BDBF3A65F248E81F8602A770FDCFE31DFC15C8410B6F92CA906', 'Jose Leonardo Pulgarin'),
(65, 'Apuesta en Carrera Callejera La Estacion Cartago (ganador)', '2025-06-29 11:33:21', 0, 20000, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(66, 'Apuesta en Carrera Callejera La Estacion Cartago (podio) (Expertos)', '2025-06-29 11:45:02', 0, 20000, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(67, 'Ganancia en carrera Carrera Callejera La Estacion Cartago (Ganador)', '2025-06-29 12:07:58', 40000, 0, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(68, 'Ganancia en carrera Carrera Callejera La Estacion Cartago (Podio)', '2025-06-29 12:36:59', 28000, 0, 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', 'Jose Leonardo Pulgarin'),
(69, 'Recarga de 50000', '2025-06-30 20:10:41', 50000, 0, 'DD0B218D8F1C031E765CBA94FC284898B59C0D03013572EA04F2D500D12673E5', 'Jose Leonardo Pulgarin'),
(72, 'Recarga de 100000', '2025-07-01 15:58:01', 100000, 0, '98F69895C801A70F453FD8D80C12073D5327CE4DCB1BFB50A5303342158C5D29', 'Jose Leonardo Pulgarin'),
(73, 'Recarga de 100000', '2025-07-01 16:23:11', 100000, 0, '27625FCDA4CAB9558348DF99B0F6ABA16CE017079585CCB46B0ED3DFFCC3C54D', 'Jose Leonardo Pulgarin'),
(74, 'Apuesta en Carrera Anserma Caldas (ganador) (Novatos)', '2025-07-01 16:30:57', 0, 45000, '27625FCDA4CAB9558348DF99B0F6ABA16CE017079585CCB46B0ED3DFFCC3C54D', 'Beimar'),
(75, 'Ganancia en carrera Carrera Anserma Caldas (Ganador)', '2025-07-02 09:14:38', 90000, 0, '27625FCDA4CAB9558348DF99B0F6ABA16CE017079585CCB46B0ED3DFFCC3C54D', 'Beimar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pilotos`
--

DROP TABLE IF EXISTS `pilotos`;
CREATE TABLE `pilotos` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `pilotos`
--

INSERT INTO `pilotos` (`id`, `nombre`, `creado_en`) VALUES
(1, 'SANTIAGO ARDILA #118', '2025-06-23 23:19:53'),
(2, 'FELIPE ARDILA #241', '2025-06-24 00:19:34'),
(3, 'STIVEN PRIMO FELIPE #671', '2025-06-24 00:19:53'),
(4, 'LEONARDO EL PROPIO #768', '2025-06-24 00:20:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_carrera`
--

DROP TABLE IF EXISTS `resultados_carrera`;
CREATE TABLE `resultados_carrera` (
  `id` int NOT NULL,
  `id_carrera` int NOT NULL,
  `id_piloto` int NOT NULL,
  `posicion` int NOT NULL,
  `categoria` varchar(100) NOT NULL DEFAULT 'SinCategoria'
) ;

--
-- Volcado de datos para la tabla `resultados_carrera`
--

INSERT INTO `resultados_carrera` (`id`, `id_carrera`, `id_piloto`, `posicion`, `categoria`) VALUES
(74, 9, 4, 1, 'Novatos'),
(75, 9, 2, 2, 'Novatos'),
(76, 9, 3, 3, 'Novatos'),
(79, 9, 2, 1, 'Élite'),
(80, 9, 4, 2, 'Élite'),
(81, 9, 1, 3, 'Élite'),
(82, 9, 4, 1, 'Expertos'),
(83, 9, 2, 2, 'Expertos'),
(84, 9, 3, 3, 'Expertos'),
(85, 10, 2, 1, 'Élite'),
(86, 10, 4, 2, 'Élite'),
(87, 10, 1, 3, 'Élite'),
(88, 11, 2, 1, 'Novatos'),
(89, 11, 1, 2, 'Novatos'),
(90, 11, 4, 3, 'Novatos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `cedula` int NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `privilegios` varchar(50) NOT NULL DEFAULT 'usuario',
  `tokenUsuario` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` int NOT NULL DEFAULT '0',
  `saldo` int NOT NULL DEFAULT '0',
  `token_recuperacion` varchar(255) DEFAULT NULL,
  `token_expiracion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contrasena`, `cedula`, `telefono`, `email`, `privilegios`, `tokenUsuario`, `fecha_registro`, `activo`, `saldo`, `token_recuperacion`, `token_expiracion`) VALUES
(2, 'Leonardo Pulgarin C', '$2y$10$ZFTafYGBlqon/PhOoFiMB.e/1nJxnt0Y.sT6mr/QgPF.9wR0eeqFe', 1112768898, '3233022983', 'leonardop448@hotmail.com', 'admin', 'CB07619C9EE6AB27A07A1784B85D471342601E345BCD12FFEE5CC154E998F922', '2025-06-08 12:30:31', 1, 108000, NULL, NULL),
(5, 'Felipe Ardila ', '$2y$10$LHP53tht7zI2En04rm.Y8OJeK.35GmcDW8aegUeTYHgayent1EMni', 1112782138, '3122688378', 'felipeardila1902@hotmail.com', 'usuario', '98F69895C801A70F453FD8D80C12073D5327CE4DCB1BFB50A5303342158C5D29', '2025-07-01 16:06:47', 1, 100000, NULL, NULL),
(6, 'Beimar', '$2y$10$YBpkJI8ygmUYUb/lBiu50eVIlktMrN8af1NHXQPR1/mdNFFk8a/XK', 2147483647, '3', 'alarconbeimar@gmail.com', 'usuario', '27625FCDA4CAB9558348DF99B0F6ABA16CE017079585CCB46B0ED3DFFCC3C54D', '2025-07-01 19:53:05', 1, 145000, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apuestas`
--
ALTER TABLE `apuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_carrera` (`id_carrera`),
  ADD KEY `id_piloto` (`id_piloto`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carrera_pilotos`
--
ALTER TABLE `carrera_pilotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_carrera` (`id_carrera`),
  ADD KEY `id_piloto` (`id_piloto`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pilotos`
--
ALTER TABLE `pilotos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resultados_carrera`
--
ALTER TABLE `resultados_carrera`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_resultado_unico` (`id_carrera`,`categoria`,`id_piloto`),
  ADD UNIQUE KEY `idx_posicion_unica` (`id_carrera`,`categoria`,`posicion`),
  ADD KEY `id_piloto` (`id_piloto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `tokenUsuario` (`tokenUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apuestas`
--
ALTER TABLE `apuestas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `carrera_pilotos`
--
ALTER TABLE `carrera_pilotos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `pilotos`
--
ALTER TABLE `pilotos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `resultados_carrera`
--
ALTER TABLE `resultados_carrera`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `apuestas`
--
ALTER TABLE `apuestas`
  ADD CONSTRAINT `apuestas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `apuestas_ibfk_2` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`),
  ADD CONSTRAINT `apuestas_ibfk_3` FOREIGN KEY (`id_piloto`) REFERENCES `pilotos` (`id`);

--
-- Filtros para la tabla `carrera_pilotos`
--
ALTER TABLE `carrera_pilotos`
  ADD CONSTRAINT `carrera_pilotos_ibfk_1` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrera_pilotos_ibfk_2` FOREIGN KEY (`id_piloto`) REFERENCES `pilotos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `resultados_carrera`
--
ALTER TABLE `resultados_carrera`
  ADD CONSTRAINT `resultados_carrera_ibfk_1` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resultados_carrera_ibfk_2` FOREIGN KEY (`id_piloto`) REFERENCES `pilotos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
