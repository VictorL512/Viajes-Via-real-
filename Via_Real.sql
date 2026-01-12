-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql104.byetcluster.com
-- Tiempo de generación: 12-01-2026 a las 14:16:25
-- Versión del servidor: 11.4.9-MariaDB
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_40115718_practica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_usuarios`
--

CREATE TABLE `admin_usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `admin_usuarios`
--

INSERT INTO `admin_usuarios` (`id`, `usuario`, `password_hash`, `nombre_completo`) VALUES
(1, 'admin', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'Administrador Principal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_usuarios_simple`
--

CREATE TABLE `admin_usuarios_simple` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password_plano` varchar(255) NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `admin_usuarios_simple`
--

INSERT INTO `admin_usuarios_simple` (`id`, `usuario`, `password_plano`, `nombre_completo`) VALUES
(1, 'admin', '12345', 'Admin (Modo Simple)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Autobus`
--

CREATE TABLE `Autobus` (
  `Placa` varchar(10) NOT NULL,
  `Modelo` varchar(50) DEFAULT NULL,
  `Capacidad` tinyint(3) UNSIGNED NOT NULL
) ;

--
-- Volcado de datos para la tabla `Autobus`
--

INSERT INTO `Autobus` (`Placa`, `Modelo`, `Capacidad`) VALUES
('111-HHH', 'Volvo 9701', 22),
('123-ABC', 'Volvo 9700', 44),
('456-XYZ', 'Mercedes-Benz Irizar', 50),
('760-KJL', 'Volvo 9700', 13),
('890-FGH', 'Volvo 9700', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Boleto`
--

CREATE TABLE `Boleto` (
  `id_viaje` int(11) NOT NULL,
  `NumeroAsiento` smallint(5) UNSIGNED NOT NULL,
  `FechaVenta` timestamp NULL DEFAULT current_timestamp(),
  `Pasajero_CURP` varchar(18) NOT NULL,
  `id_tarifa` int(11) NOT NULL
) ;

--
-- Volcado de datos para la tabla `Boleto`
--

INSERT INTO `Boleto` (`id_viaje`, `NumeroAsiento`, `FechaVenta`, `Pasajero_CURP`, `id_tarifa`) VALUES
(1, 10, '2025-11-07 04:38:38', 'LOPJ850101ABCDEFGH', 1),
(1, 11, '2025-11-07 04:38:38', 'MARM900202IJKLMNOP', 2),
(1, 44, '2025-11-25 18:56:40', '123456789123456789', 1),
(2, 3, '2025-11-07 06:15:58', 'LICV050120HMCMRCA8', 1),
(2, 4, '2025-11-07 06:15:58', 'LICV050120HMCMRCA8', 1),
(2, 8, '2025-11-07 06:15:58', 'LICV050120HMCMRCA8', 1),
(2, 12, '2025-11-07 14:10:06', 'LAJN12345678912345', 2),
(3, 2, '2025-11-07 16:29:08', 'BBBBBBBBBBBBBBBBBB', 3),
(6, 7, '2026-01-07 05:11:17', '181818181818181818', 2),
(6, 12, '2026-01-07 18:22:15', '111111111111111111', 2),
(7, 12, '2026-01-09 00:44:58', 'LANUS6789654378654', 3),
(9, 7, '2026-01-09 06:43:03', 'LANUS6789654378654', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Conductor`
--

CREATE TABLE `Conductor` (
  `INE` varchar(18) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Telefono` varchar(15) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `Conductor`
--

INSERT INTO `Conductor` (`INE`, `Nombre`, `Apellido`, `Telefono`) VALUES
('123456789123333333', 'Hugo', 'Lopez', '5566778899'),
('AAAAAAAAAAAAAAAAAA', 'Pedro', 'Pascal', '5567896798'),
('ABC1234567890DEFGH', 'Juan', 'Perez', '5512345678'),
('VVVVVVVVVVVVVVVVVV', 'Gerardo', 'Martinez', '5544444444'),
('XYZ9876543210ZYXWV', 'Maria', 'Lopez', '5587654321');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Escala`
--

CREATE TABLE `Escala` (
  `id_viaje` int(11) NOT NULL,
  `NumeroEscala` smallint(5) UNSIGNED NOT NULL,
  `HoraEstimada` time NOT NULL
) ;

--
-- Volcado de datos para la tabla `Escala`
--

INSERT INTO `Escala` (`id_viaje`, `NumeroEscala`, `HoraEstimada`) VALUES
(1, 1, '12:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pasajero`
--

CREATE TABLE `Pasajero` (
  `CURP` varchar(18) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Telefono` varchar(15) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `Pasajero`
--

INSERT INTO `Pasajero` (`CURP`, `Nombre`, `Apellido`, `Telefono`) VALUES
('111111111111111111', 'Luis', 'Araujo', '828399'),
('123456789123456789', 'Omar', 'Lopez', '5567839389'),
('181818181818181818', 'Cintia', 'Rivas', ''),
('BBBBBBBBBBBBBBBBBB', 'Mariana', 'Juarez', '5544132456'),
('LAJN12345678912345', 'Luis', 'Araujo', '82839'),
('LANUS6789654378654', 'Enzo', 'Martinez', '5567897623'),
('LICV050120HMCMRCA8', 'Victor', 'Lima', '5539910372'),
('LOPJ850101ABCDEFGH', 'Jose Lopez', 'Garcia', '5511112222'),
('MARM900202IJKLMNOP', 'Ana Martinez', 'Rodriguez', '5533334444');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tarifa`
--

CREATE TABLE `Tarifa` (
  `id_tarifa` int(11) NOT NULL,
  `PrecioBase` decimal(10,2) NOT NULL,
  `Tipo` varchar(20) NOT NULL
) ;

--
-- Volcado de datos para la tabla `Tarifa`
--

INSERT INTO `Tarifa` (`id_tarifa`, `PrecioBase`, `Tipo`) VALUES
(1, '500.00', 'Regular'),
(2, '300.00', 'Nino'),
(3, '700.00', 'MasEspacio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tarifa_MasEspacio`
--

CREATE TABLE `Tarifa_MasEspacio` (
  `id_tarifa` int(11) NOT NULL,
  `AnchoAsiento` decimal(5,2) NOT NULL,
  `IncluyeSnack` tinyint(1) DEFAULT 0
) ;

--
-- Volcado de datos para la tabla `Tarifa_MasEspacio`
--

INSERT INTO `Tarifa_MasEspacio` (`id_tarifa`, `AnchoAsiento`, `IncluyeSnack`) VALUES
(3, '45.50', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tarifa_Nino`
--

CREATE TABLE `Tarifa_Nino` (
  `id_tarifa` int(11) NOT NULL,
  `EdadMaxima` tinyint(3) UNSIGNED NOT NULL,
  `DescuentoPorcentaje` decimal(5,2) NOT NULL
) ;

--
-- Volcado de datos para la tabla `Tarifa_Nino`
--

INSERT INTO `Tarifa_Nino` (`id_tarifa`, `EdadMaxima`, `DescuentoPorcentaje`) VALUES
(2, 12, '50.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tarifa_Regular`
--

CREATE TABLE `Tarifa_Regular` (
  `id_tarifa` int(11) NOT NULL,
  `IncluyeSeguro` tinyint(1) DEFAULT 0,
  `PorcentajeIVA` decimal(5,2) NOT NULL DEFAULT 16.00
) ;

--
-- Volcado de datos para la tabla `Tarifa_Regular`
--

INSERT INTO `Tarifa_Regular` (`id_tarifa`, `IncluyeSeguro`, `PorcentajeIVA`) VALUES
(1, 1, '16.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Viaje`
--

CREATE TABLE `Viaje` (
  `id_viaje` int(11) NOT NULL,
  `Origen` varchar(100) NOT NULL,
  `Destino` varchar(100) NOT NULL,
  `FechaSalida` date NOT NULL,
  `HoraSalida` time NOT NULL,
  `Conductor_INE` varchar(18) NOT NULL,
  `Autobus_Placa` varchar(10) NOT NULL
) ;

--
-- Volcado de datos para la tabla `Viaje`
--

INSERT INTO `Viaje` (`id_viaje`, `Origen`, `Destino`, `FechaSalida`, `HoraSalida`, `Conductor_INE`, `Autobus_Placa`) VALUES
(1, 'CDMX', 'Guadalajara', '2025-12-01', '10:00:00', 'ABC1234567890DEFGH', '123-ABC'),
(2, 'Monterrey', 'CDMX', '2025-12-02', '12:00:00', 'XYZ9876543210ZYXWV', '456-XYZ'),
(3, 'Puebla', 'Jalisco', '2025-11-11', '11:00:00', 'AAAAAAAAAAAAAAAAAA', '890-FGH'),
(4, 'Puebla', 'Jalisco', '2025-11-11', '11:00:00', 'AAAAAAAAAAAAAAAAAA', '890-FGH'),
(5, 'Oaxaca', 'Jalisco', '2025-11-27', '15:00:00', 'VVVVVVVVVVVVVVVVVV', '760-KJL'),
(6, 'Monterrey', 'Sinaloa', '2026-01-22', '16:30:00', '123456789123333333', '111-HHH'),
(7, 'Puebla', 'Guadalajara', '2026-01-15', '04:30:00', 'VVVVVVVVVVVVVVVVVV', '111-HHH'),
(8, 'Pachuca', 'Monterrey', '2026-01-30', '09:15:00', 'XYZ9876543210ZYXWV', '456-XYZ'),
(9, 'Oaxaca', 'Puebla', '2026-01-10', '22:00:00', 'ABC1234567890DEFGH', '123-ABC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin_usuarios`
--
ALTER TABLE `admin_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `admin_usuarios_simple`
--
ALTER TABLE `admin_usuarios_simple`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `Autobus`
--
ALTER TABLE `Autobus`
  ADD PRIMARY KEY (`Placa`);

--
-- Indices de la tabla `Boleto`
--
ALTER TABLE `Boleto`
  ADD PRIMARY KEY (`id_viaje`,`NumeroAsiento`),
  ADD KEY `FK_Boleto_Pasajero` (`Pasajero_CURP`),
  ADD KEY `FK_Boleto_Tarifa` (`id_tarifa`);

--
-- Indices de la tabla `Conductor`
--
ALTER TABLE `Conductor`
  ADD PRIMARY KEY (`INE`),
  ADD UNIQUE KEY `Telefono` (`Telefono`);

--
-- Indices de la tabla `Escala`
--
ALTER TABLE `Escala`
  ADD PRIMARY KEY (`id_viaje`,`NumeroEscala`);

--
-- Indices de la tabla `Pasajero`
--
ALTER TABLE `Pasajero`
  ADD PRIMARY KEY (`CURP`);

--
-- Indices de la tabla `Tarifa`
--
ALTER TABLE `Tarifa`
  ADD PRIMARY KEY (`id_tarifa`);

--
-- Indices de la tabla `Tarifa_MasEspacio`
--
ALTER TABLE `Tarifa_MasEspacio`
  ADD PRIMARY KEY (`id_tarifa`);

--
-- Indices de la tabla `Tarifa_Nino`
--
ALTER TABLE `Tarifa_Nino`
  ADD PRIMARY KEY (`id_tarifa`);

--
-- Indices de la tabla `Tarifa_Regular`
--
ALTER TABLE `Tarifa_Regular`
  ADD PRIMARY KEY (`id_tarifa`);

--
-- Indices de la tabla `Viaje`
--
ALTER TABLE `Viaje`
  ADD PRIMARY KEY (`id_viaje`),
  ADD KEY `FK_Viaje_Conductor` (`Conductor_INE`),
  ADD KEY `FK_Viaje_Autobus` (`Autobus_Placa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin_usuarios`
--
ALTER TABLE `admin_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `admin_usuarios_simple`
--
ALTER TABLE `admin_usuarios_simple`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `Tarifa`
--
ALTER TABLE `Tarifa`
  MODIFY `id_tarifa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Viaje`
--
ALTER TABLE `Viaje`
  MODIFY `id_viaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Boleto`
--
ALTER TABLE `Boleto`
  ADD CONSTRAINT `FK_Boleto_Pasajero` FOREIGN KEY (`Pasajero_CURP`) REFERENCES `Pasajero` (`CURP`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Boleto_Tarifa` FOREIGN KEY (`id_tarifa`) REFERENCES `Tarifa` (`id_tarifa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Boleto_Viaje` FOREIGN KEY (`id_viaje`) REFERENCES `Viaje` (`id_viaje`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `Escala`
--
ALTER TABLE `Escala`
  ADD CONSTRAINT `FK_Escala_Viaje` FOREIGN KEY (`id_viaje`) REFERENCES `Viaje` (`id_viaje`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Tarifa_MasEspacio`
--
ALTER TABLE `Tarifa_MasEspacio`
  ADD CONSTRAINT `FK_TarifaEsp_Tarifa` FOREIGN KEY (`id_tarifa`) REFERENCES `Tarifa` (`id_tarifa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Tarifa_Nino`
--
ALTER TABLE `Tarifa_Nino`
  ADD CONSTRAINT `FK_TarifaNino_Tarifa` FOREIGN KEY (`id_tarifa`) REFERENCES `Tarifa` (`id_tarifa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Tarifa_Regular`
--
ALTER TABLE `Tarifa_Regular`
  ADD CONSTRAINT `FK_TarifaReg_Tarifa` FOREIGN KEY (`id_tarifa`) REFERENCES `Tarifa` (`id_tarifa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Viaje`
--
ALTER TABLE `Viaje`
  ADD CONSTRAINT `FK_Viaje_Autobus` FOREIGN KEY (`Autobus_Placa`) REFERENCES `Autobus` (`Placa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Viaje_Conductor` FOREIGN KEY (`Conductor_INE`) REFERENCES `Conductor` (`INE`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
