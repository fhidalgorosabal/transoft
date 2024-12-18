-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 22-05-2017 a las 08:24:07
-- Versión del servidor: 5.6.28
-- Versión de PHP: 5.5.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `transoft`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id_actividad` int(10) NOT NULL,
  `nombre_act` varchar(50) NOT NULL,
  `id_combustible` int(10) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`id_actividad`, `nombre_act`, `id_combustible`, `estado`) VALUES
(1, 'Distribución', 1, 'Activa'),
(2, 'Hielo-Pescado', 1, 'Activa'),
(3, 'Actividades Admin.', 1, 'Activa'),
(4, 'Servicios Admin-D', 1, 'Activa'),
(5, 'Servicios Admin-G', 2, 'Activa'),
(6, 'Dist.Croqueta', 1, 'Activa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ayudante`
--

CREATE TABLE `ayudante` (
  `id_ayudante` int(10) NOT NULL,
  `ci` varchar(11) NOT NULL,
  `nombre_ayd` varchar(30) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `baja` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ayudante`
--

INSERT INTO `ayudante` (`id_ayudante`, `ci`, `nombre_ayd`, `apellidos`, `baja`) VALUES
(1, '0', 'Ninguno', '', 0),
(2, '78061545698', 'Junior', 'Tamayo Blanco', 0),
(3, '20022952347', 'Julio', 'Rodríguez Pérez', 0),
(4, '84579658741', 'Héctor', 'Llorente Valdez', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carro`
--

CREATE TABLE `carro` (
  `id_carro` int(10) NOT NULL,
  `codigo` int(10) NOT NULL DEFAULT '0',
  `chapa` varchar(7) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `capacidad` double NOT NULL,
  `marca` varchar(20) NOT NULL,
  `anno` int(4) NOT NULL,
  `estado_tecnico` varchar(20) NOT NULL,
  `id_combustible` int(10) NOT NULL,
  `norma_consumo` double NOT NULL,
  `capacidad_tanque` double NOT NULL,
  `baja` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carro`
--

INSERT INTO `carro` (`id_carro`, `codigo`, `chapa`, `tipo`, `capacidad`, `marca`, `anno`, `estado_tecnico`, `id_combustible`, `norma_consumo`, `capacidad_tanque`, `baja`) VALUES
(5, 7, 'GSH918', 'C. Furgón', 6, 'Zil-130', 1988, 'Regular', 1, 5, 200, 1),
(8, 25, 'B063587', 'C. Furgón', 1.2, 'HYUNDAI', 1996, 'Bueno', 1, 9.39, 51.78, 0),
(9, 805, 'B004425', 'C. Furgón', 3.5, 'Gaz-66', 1989, 'Regular', 1, 3.83, 104.2, 0),
(11, 742, 'B004648', 'C. Furgón', 6, 'Zil-130', 1988, 'Bueno', 1, 4.45, 138.6, 0),
(12, 10200, 'B004491', 'C. Furgón', 6, 'Zil-130', 1985, 'Bueno', 1, 4.2, 138.4, 0),
(13, 523221, 'B063272', 'C. Furgón', 6, 'Zil-130', 1988, 'Bueno', 1, 4.1, 139, 0),
(14, 146, 'B086927', 'C. Plataforma', 6, 'Zil-130', 1979, 'Malo', 1, 4.6, 137.03, 0),
(15, 4023, 'B063643', 'Otro', 38, 'Giron-VI', 1996, 'Malo', 1, 4.17, 97, 0),
(16, 2500, 'B16157', 'Otro', 0, 'Jagua', 1999, 'Bueno', 2, 17, 20, 0),
(17, 998, 'B25765', 'Otro', 0, 'M-Z', 1998, 'Bueno', 2, 17, 20, 0),
(18, 194, 'B004536', 'Otro', 4, 'Lada-2107', 1988, 'Bueno', 2, 10, 40, 0),
(19, 195, 'B045200', 'Otro', 4, 'CHEROSKEE', 1993, 'Regular', 1, 9.5, 90, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carro_tarjeta`
--

CREATE TABLE `carro_tarjeta` (
  `id_carro_tarjeta` int(10) NOT NULL,
  `id_carro` int(10) NOT NULL,
  `id_tarjeta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chofer`
--

CREATE TABLE `chofer` (
  `id_chofer` int(10) NOT NULL,
  `ci` varchar(11) NOT NULL,
  `nombre_chf` varchar(30) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `id_licencia` int(10) NOT NULL,
  `baja` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `chofer`
--

INSERT INTO `chofer` (`id_chofer`, `ci`, `nombre_chf`, `apellidos`, `id_licencia`, `baja`) VALUES
(1, '63032406821', 'Pauside', 'Suárez', 4, 0),
(2, '67030907461', 'Ernesto', 'Sosa Milanés', 2, 0),
(3, '89112512263', 'Jorge', 'Pacheco', 1, 0),
(4, '55091806648', 'Tomaz', 'Guerra', 5, 0),
(5, '80060721547', 'Bernardo', 'Moreno', 6, 0),
(6, '75041314401', 'Luis', 'Blanco', 7, 0),
(7, '73110805529', 'Jose Antonio ', 'Navas Enamorado', 2, 0),
(8, '67030321908', 'Ricardo', 'Espinoza Figueredo', 8, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combustible`
--

CREATE TABLE `combustible` (
  `id_combustible` int(10) NOT NULL,
  `tipo_combustible` varchar(25) NOT NULL,
  `precio_combustible` double NOT NULL,
  `id_indicador` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `combustible`
--

INSERT INTO `combustible` (`id_combustible`, `tipo_combustible`, `precio_combustible`, `id_indicador`) VALUES
(1, 'Diesel', 0.65, 1),
(2, 'Gasolina', 0.92, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conduce`
--

CREATE TABLE `conduce` (
  `id_conduce` int(10) NOT NULL,
  `numero` varchar(15) NOT NULL,
  `distancia_total` double NOT NULL,
  `distancia_carga` double NOT NULL,
  `carga_transportada` double NOT NULL,
  `trafico_producido` double NOT NULL,
  `id_recorrido` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `conduce`
--

INSERT INTO `conduce` (`id_conduce`, `numero`, `distancia_total`, `distancia_carga`, `carga_transportada`, `trafico_producido`, `id_recorrido`) VALUES
(4, '1', 1, 1, 1, 1, 2),
(6, '2', 2, 2, 2, 4, 3),
(12, '1', 1, 1, 1, 1, 1),
(13, '4569', 10, 10, 45.5, 455, 4),
(14, '148-789', 9, 9, 68.36, 1298.84, 4),
(15, '', 19, 19, 0, 0, 4),
(16, '777', 8, 8, 9.36, 74.88, 5),
(17, '', 8, 0, 0, 0, 5),
(18, '331', 23, 23, 7.36, 169.28, 6),
(19, '', 24, 0, 0, 0, 6),
(20, '611', 14, 14, 8.36, 117.04, 7),
(21, '', 15, 0, 0, 0, 7),
(22, '333', 10, 10, 7.36, 73.6, 8),
(23, '', 10, 0, 0, 0, 8),
(24, '311', 8, 8, 7.36, 58.88, 9),
(25, '789-113', 8, 8, 9.58, 153.28, 9),
(26, '', 16, 0, 0, 0, 9),
(27, '199', 12, 12, 89.36, 1072.32, 10),
(28, '', 12, 0, 0, 0, 10),
(29, '369-789', 12, 12, 8.36, 100.32, 11),
(30, '', 12, 0, 0, 0, 11),
(31, '147', 10, 10, 4.58, 45.8, 12),
(32, '368', 12, 12, 7.15, 157.3, 12),
(33, '', 22, 0, 0, 0, 12),
(34, '257', 8, 8, 4.69, 37.52, 13),
(35, '', 8, 0, 0, 0, 13),
(36, '410', 11, 11, 9.47, 104.17, 14),
(37, '', 11, 0, 0, 0, 14),
(38, '0', 20, 0, 0, 0, 15),
(39, '0', 15, 0, 0, 0, 16),
(40, '133', 10, 10, 9.58, 95.8, 17),
(41, '685-504', 14, 14, 10.36, 248.64, 17),
(42, '', 24, 0, 0, 0, 17),
(43, '357', 10, 10, 4.7, 47, 18),
(44, '', 10, 0, 0, 0, 18),
(45, '0', 15, 0, 0, 0, 19),
(46, '123', 12, 12, 7.58, 90.96, 20),
(47, '', 12, 0, 0, 0, 20),
(48, '466', 10, 10, 4.36, 43.6, 21),
(49, '907', 11, 11, 5.69, 119.49, 21),
(50, '', 21, 0, 0, 0, 21),
(51, '477', 10, 10, 7.69, 76.9, 22),
(52, '', 10, 0, 0, 0, 22),
(53, '347', 14, 14, 9.58, 134.12, 23),
(54, '334', 9, 9, 8.24, 189.52, 23),
(55, '', 23, 0, 0, 0, 23),
(56, '122', 12, 12, 7.68, 92.16, 24),
(57, '', 12, 0, 0, 0, 24),
(58, '117', 10, 10, 9.58, 95.8, 25),
(59, '346', 14, 14, 10.58, 253.92, 25),
(60, '', 24, 0, 0, 0, 25),
(61, '449', 12, 12, 7.38, 88.56, 26),
(62, '', 12, 0, 0, 0, 26),
(63, '114', 9, 9, 8.36, 75.24, 27),
(64, '', 9, 0, 0, 0, 27),
(65, '667', 6, 6, 4.36, 26.16, 28),
(66, '354', 8, 8, 6.48, 90.72, 28),
(67, '', 14, 0, 0, 0, 28),
(68, '253', 14, 14, 7.36, 103.04, 29),
(69, '', 14, 0, 0, 0, 29),
(70, '337', 10, 10, 8.58, 85.8, 30),
(71, '', 10, 0, 0, 0, 30),
(72, '996', 10, 10, 7.36, 73.6, 31),
(73, '554', 8, 8, 5.89, 106.02, 31),
(74, '', 18, 0, 0, 0, 31),
(75, '368', 12, 12, 8.5, 102, 32),
(76, '', 12, 0, 0, 0, 32),
(77, '119', 9, 9, 4.6, 41.4, 33),
(78, '', 9, 0, 0, 0, 33),
(79, '0', 10, 0, 25, 0, 34),
(80, '0', 12, 0, 24, 0, 35),
(81, '0', 11, 0, 20, 0, 36),
(82, '0', 11, 0, 23, 0, 37),
(83, '0', 10, 0, 25, 0, 38),
(84, '0', 11, 0, 24, 0, 39),
(85, '33-58', 10, 10, 9.68, 96.8, 40),
(86, '257', 10, 10, 0, 0, 40),
(87, '', 20, 0, 0, 0, 40),
(88, '664', 10, 10, 8.39, 83.9, 41),
(89, '', 10, 0, 0, 0, 41),
(90, '121-891', 10, 10, 7.36, 73.6, 42),
(91, '458', 11, 11, 5.96, 125.16, 42),
(92, '', 21, 0, 0, 0, 42),
(93, '944', 8, 8, 4.58, 36.64, 43),
(94, '', 8, 0, 0, 0, 43),
(95, '557', 9, 9, 7.36, 66.24, 44),
(96, '', 9, 0, 0, 0, 44),
(97, '244', 10, 10, 4.58, 45.8, 45),
(98, '', 10, 0, 0, 0, 45),
(99, '411', 14, 14, 7.36, 103.04, 46),
(100, '', 14, 0, 0, 0, 46),
(101, '247-895', 8, 8, 7.56, 60.48, 47),
(102, '257-458', 7, 7, 5.23, 78.45, 47),
(103, '', 15, 0, 0, 0, 47);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id_configuracion` int(10) NOT NULL,
  `fecha` tinyint(1) NOT NULL,
  `numero_hoja_ruta` tinyint(1) NOT NULL,
  `viajes_carga` tinyint(1) NOT NULL,
  `consumo_combustible` tinyint(1) NOT NULL,
  `conduce` tinyint(1) NOT NULL,
  `distancia_total` tinyint(1) NOT NULL,
  `distancia_carga` tinyint(1) NOT NULL,
  `carga_transportada` tinyint(1) NOT NULL,
  `carro` tinyint(1) NOT NULL,
  `chofer` tinyint(1) NOT NULL,
  `ayudante` tinyint(1) NOT NULL,
  `id_actividad` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id_configuracion`, `fecha`, `numero_hoja_ruta`, `viajes_carga`, `consumo_combustible`, `conduce`, `distancia_total`, `distancia_carga`, `carga_transportada`, `carro`, `chofer`, `ayudante`, `id_actividad`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2),
(3, 1, 1, 0, 1, 0, 1, 0, 1, 1, 1, 0, 5),
(4, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 3),
(5, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrador'),
(2, 'jefe', 'Jefe de transporte'),
(3, 'tecnico', 'Técnico de transporte'),
(4, 'invitado', 'Usuario común');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilitar`
--

CREATE TABLE `habilitar` (
  `id_habilitar` int(10) NOT NULL,
  `cantidad_combustible` double NOT NULL,
  `fecha` date NOT NULL,
  `id_carro` int(10) NOT NULL,
  `id_tarjeta` int(10) NOT NULL,
  `id_recorrido` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicador_acumulado`
--

CREATE TABLE `indicador_acumulado` (
  `id_indicador_a` int(10) NOT NULL,
  `mes` int(2) NOT NULL,
  `anno` int(4) NOT NULL,
  `carros_existentes_p` int(10) NOT NULL,
  `carros_existentes_r` int(10) NOT NULL,
  `carros_trabajando_p` int(10) NOT NULL,
  `carros_trabajando_r` int(10) NOT NULL,
  `carga_transportada_p` double NOT NULL,
  `carga_transportada_r` double NOT NULL,
  `viajes_realizados_p` double NOT NULL,
  `viajes_realizados_r` double NOT NULL,
  `trafico_p` double NOT NULL,
  `trafico_r` double NOT NULL,
  `distancia_total_p` double NOT NULL,
  `distancia_total_r` double NOT NULL,
  `distancia_carga_p` double NOT NULL,
  `distancia_carga_r` double NOT NULL,
  `carga_posible_p` double NOT NULL,
  `carga_posible_r` double NOT NULL,
  `consumo_combustible_p` double NOT NULL,
  `consumo_combustible_r` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicador_mes`
--

CREATE TABLE `indicador_mes` (
  `id_indicador` int(10) NOT NULL,
  `mes_procesar` int(2) NOT NULL,
  `anno` int(4) NOT NULL,
  `carros_existentes` int(10) NOT NULL,
  `carros_trabajando` int(10) NOT NULL,
  `carga_transportada` double NOT NULL,
  `viajes_realizados` double NOT NULL,
  `trafico` double NOT NULL,
  `distancia_total` double NOT NULL,
  `distancia_carga` double NOT NULL,
  `carga_posible` double NOT NULL,
  `consumo_combustible` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `indicador_mes`
--

INSERT INTO `indicador_mes` (`id_indicador`, `mes_procesar`, `anno`, `carros_existentes`, `carros_trabajando`, `carga_transportada`, `viajes_realizados`, `trafico`, `distancia_total`, `distancia_carga`, `carga_posible`, `consumo_combustible`) VALUES
(1, 6, 2017, 8, 8, 0.232, 107, 0.010778, 4967, 9934, 0.503, 1453);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

CREATE TABLE `licencia` (
  `id_licencia` int(10) NOT NULL,
  `codigo_licencia` int(10) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `puntos_acumulados` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `licencia`
--

INSERT INTO `licencia` (`id_licencia`, `codigo_licencia`, `fecha_vencimiento`, `puntos_acumulados`) VALUES
(1, 6024480, '2020-03-03', 0),
(2, 9077722, '2019-09-19', 0),
(4, 2081136, '2020-07-16', 0),
(5, 5595018, '2019-04-01', 0),
(6, 4086925, '2020-04-01', 0),
(7, 2081174, '2019-02-01', 0),
(8, 4075273, '2020-12-01', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recorrido`
--

CREATE TABLE `recorrido` (
  `id_recorrido` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `numero_hoja_ruta` int(10) NOT NULL,
  `viajes_carga` int(10) NOT NULL,
  `combustible_habilitado` double NOT NULL,
  `consumo_combustible` double NOT NULL,
  `id_actividad` int(10) NOT NULL,
  `id_carro` int(10) NOT NULL,
  `id_chofer` int(10) NOT NULL,
  `id_ayudante` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `id_tarjeta` int(10) NOT NULL,
  `codigo_tarjeta` bigint(16) NOT NULL,
  `id_combustible` int(10) NOT NULL,
  `credito` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tarjeta`
--

INSERT INTO `tarjeta` (`id_tarjeta`, `codigo_tarjeta`, `id_combustible`, `credito`) VALUES
(1, 7605, 1, 30),
(2, 8184, 1, 25),
(3, 7305, 1, 30),
(4, 4250, 1, 8.5),
(5, 4268, 1, 25),
(6, 4095, 1, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', NULL, NULL, NULL, NULL, 1268889823, 1495326096, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(5, '::1', 'fernando', '$2y$08$kg839F6w8aipcMFDtgwaH.zQJKIUeLlITFkkISzazkW8tMSktbmHq', NULL, '', NULL, NULL, NULL, NULL, 1493275641, 1495461090, 1, 'Fernando', 'Hidalgo Rosabal', NULL, NULL),
(6, '::1', 'prueba', '$2y$08$J1UIC3CM6Yy6mHL4eZ.1DOl7qZpYKroE0PygWerJH9KxomC9tY1KW', NULL, '', NULL, NULL, NULL, NULL, 1493442893, 1493873012, 1, 'invitado', 'invitado', NULL, NULL),
(7, '::1', 'jefe', '$2y$08$yVGYr2K.DFCvs1tbiWiQk.dyDQK77y7Ee7OdKJQQKCNge7slyD0Bu', NULL, '', NULL, NULL, NULL, NULL, 1493448743, 1495183411, 1, 'Jefe Transporte', 'jefe', NULL, NULL),
(8, '::1', 'tecnico', '$2y$08$kY/vFMYV/aqtRPCC4CRozuf3UV23gMBC.QwU7iJbvBg5LXIciC.I2', NULL, '', NULL, NULL, NULL, NULL, 1493448832, 1494654495, 1, 'tecnico', 'tecnico', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(35, 1, 1),
(52, 5, 1),
(44, 6, 4),
(51, 7, 2),
(43, 8, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `id_combustible` (`id_combustible`);

--
-- Indices de la tabla `ayudante`
--
ALTER TABLE `ayudante`
  ADD PRIMARY KEY (`id_ayudante`);

--
-- Indices de la tabla `carro`
--
ALTER TABLE `carro`
  ADD PRIMARY KEY (`id_carro`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD UNIQUE KEY `chapa` (`chapa`),
  ADD KEY `id_combustible` (`id_combustible`);

--
-- Indices de la tabla `carro_tarjeta`
--
ALTER TABLE `carro_tarjeta`
  ADD PRIMARY KEY (`id_carro_tarjeta`),
  ADD KEY `id_tarjeta` (`id_tarjeta`),
  ADD KEY `id_carro` (`id_carro`);

--
-- Indices de la tabla `chofer`
--
ALTER TABLE `chofer`
  ADD PRIMARY KEY (`id_chofer`),
  ADD KEY `id_licencia` (`id_licencia`) USING BTREE;

--
-- Indices de la tabla `combustible`
--
ALTER TABLE `combustible`
  ADD PRIMARY KEY (`id_combustible`),
  ADD KEY `id_indicador` (`id_indicador`);

--
-- Indices de la tabla `conduce`
--
ALTER TABLE `conduce`
  ADD PRIMARY KEY (`id_conduce`),
  ADD KEY `id_recorrido` (`id_recorrido`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_configuracion`),
  ADD KEY `conf_ibfk_1` (`id_actividad`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `habilitar`
--
ALTER TABLE `habilitar`
  ADD PRIMARY KEY (`id_habilitar`),
  ADD KEY `id_carro` (`id_carro`) USING BTREE,
  ADD KEY `id_tarjeta` (`id_tarjeta`) USING BTREE,
  ADD KEY `id_recorrido` (`id_recorrido`);

--
-- Indices de la tabla `indicador_acumulado`
--
ALTER TABLE `indicador_acumulado`
  ADD PRIMARY KEY (`id_indicador_a`);

--
-- Indices de la tabla `indicador_mes`
--
ALTER TABLE `indicador_mes`
  ADD PRIMARY KEY (`id_indicador`);

--
-- Indices de la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD PRIMARY KEY (`id_licencia`),
  ADD UNIQUE KEY `codigo` (`codigo_licencia`);

--
-- Indices de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recorrido`
--
ALTER TABLE `recorrido`
  ADD PRIMARY KEY (`id_recorrido`),
  ADD KEY `id_actividad` (`id_actividad`),
  ADD KEY `id_chofer` (`id_chofer`),
  ADD KEY `id_carro` (`id_carro`),
  ADD KEY `id_ayudante` (`id_ayudante`);

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`id_tarjeta`),
  ADD UNIQUE KEY `codigo` (`codigo_tarjeta`),
  ADD KEY `id_combustible` (`id_combustible`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id_actividad` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `ayudante`
--
ALTER TABLE `ayudante`
  MODIFY `id_ayudante` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `carro`
--
ALTER TABLE `carro`
  MODIFY `id_carro` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `carro_tarjeta`
--
ALTER TABLE `carro_tarjeta`
  MODIFY `id_carro_tarjeta` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `chofer`
--
ALTER TABLE `chofer`
  MODIFY `id_chofer` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `combustible`
--
ALTER TABLE `combustible`
  MODIFY `id_combustible` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `conduce`
--
ALTER TABLE `conduce`
  MODIFY `id_conduce` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_configuracion` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `habilitar`
--
ALTER TABLE `habilitar`
  MODIFY `id_habilitar` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `indicador_acumulado`
--
ALTER TABLE `indicador_acumulado`
  MODIFY `id_indicador_a` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `indicador_mes`
--
ALTER TABLE `indicador_mes`
  MODIFY `id_indicador` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `licencia`
--
ALTER TABLE `licencia`
  MODIFY `id_licencia` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  MODIFY `id_tarjeta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_ibfk_1` FOREIGN KEY (`id_combustible`) REFERENCES `combustible` (`id_combustible`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `carro`
--
ALTER TABLE `carro`
  ADD CONSTRAINT `carro_ibfk_1` FOREIGN KEY (`id_combustible`) REFERENCES `combustible` (`id_combustible`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `carro_tarjeta`
--
ALTER TABLE `carro_tarjeta`
  ADD CONSTRAINT `carro_tarjeta_ibfk_1` FOREIGN KEY (`id_tarjeta`) REFERENCES `tarjeta` (`id_tarjeta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `carro_tarjeta_ibfk_2` FOREIGN KEY (`id_carro`) REFERENCES `carro` (`id_carro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `chofer`
--
ALTER TABLE `chofer`
  ADD CONSTRAINT `chofer_ibfk_1` FOREIGN KEY (`id_licencia`) REFERENCES `licencia` (`id_licencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `combustible`
--
ALTER TABLE `combustible`
  ADD CONSTRAINT `combustible_ibfk_1` FOREIGN KEY (`id_indicador`) REFERENCES `indicador_mes` (`id_indicador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `conduce`
--
ALTER TABLE `conduce`
  ADD CONSTRAINT `conduce_ibfk_1` FOREIGN KEY (`id_recorrido`) REFERENCES `recorrido` (`id_recorrido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD CONSTRAINT `conf_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `habilitar`
--
ALTER TABLE `habilitar`
  ADD CONSTRAINT `habilitar_ibfk_2` FOREIGN KEY (`id_tarjeta`) REFERENCES `tarjeta` (`id_tarjeta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `habilitar_ibfk_3` FOREIGN KEY (`id_carro`) REFERENCES `carro` (`id_carro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `habilitar_ibfk_4` FOREIGN KEY (`id_recorrido`) REFERENCES `recorrido` (`id_recorrido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `recorrido`
--
ALTER TABLE `recorrido`
  ADD CONSTRAINT `recorrido_ibfk_1` FOREIGN KEY (`id_carro`) REFERENCES `carro` (`id_carro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `recorrido_ibfk_2` FOREIGN KEY (`id_chofer`) REFERENCES `chofer` (`id_chofer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `recorrido_ibfk_3` FOREIGN KEY (`id_ayudante`) REFERENCES `ayudante` (`id_ayudante`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `recorrido_ibfk_4` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD CONSTRAINT `tarjeta_ibfk_1` FOREIGN KEY (`id_combustible`) REFERENCES `combustible` (`id_combustible`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
