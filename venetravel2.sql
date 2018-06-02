-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-06-2018 a las 00:19:59
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `venetravel2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agencias`
--

CREATE TABLE `agencias` (
  `id_agencia` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `direccion` text,
  `rif` varchar(25) DEFAULT NULL,
  `rtn` varchar(25) DEFAULT NULL,
  `vt` varchar(25) DEFAULT NULL,
  `gerente` varchar(50) DEFAULT NULL,
  `phone_ger` varchar(25) DEFAULT NULL,
  `celular_ger` varchar(25) DEFAULT NULL,
  `email_ger` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(10) UNSIGNED NOT NULL,
  `categoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `categoria`) VALUES
(1, 'Resort'),
(2, 'Boutique'),
(3, 'Ejecutivo'),
(4, 'Ciudad'),
(5, 'VIP'),
(6, 'Deluxe (Lujo)'),
(7, '1 Estrella'),
(8, '2 Estrellas'),
(9, '3 Estrellas'),
(10, '4 Estrellas'),
(11, '5 Estrellas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `features`
--

CREATE TABLE `features` (
  `id_feature` int(10) UNSIGNED NOT NULL,
  `feature` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `features`
--

INSERT INTO `features` (`id_feature`, `feature`) VALUES
(1, 'Piscina'),
(2, 'Club Infantil'),
(3, 'Restaurante'),
(4, 'Bodegón'),
(5, 'Gimnasio'),
(6, 'Spá'),
(7, 'Sala De Conferencia'),
(8, 'Estacionamiento'),
(9, 'Solarium'),
(10, 'Parque Infantil'),
(11, 'Salón De Juegos'),
(12, 'Lobby Bar'),
(13, 'Aire Acondicionado'),
(14, 'Caja De Seguridad'),
(15, 'Teléfono'),
(16, 'Nevera'),
(17, 'Comedor'),
(18, 'Plancha'),
(19, 'Cafetera'),
(20, 'Sala De Estar'),
(21, 'Cocina'),
(22, 'Mesa De Planchar'),
(23, 'Amenidades Especiales'),
(24, 'Secador De Cabello'),
(25, 'Horno Microondas'),
(26, 'Licuadora'),
(27, 'Lavaplatos'),
(28, 'Tostadora'),
(29, 'Cubertería'),
(30, 'Implementos De Cocina'),
(31, 'Cristaleria'),
(32, 'Estación Para Ipod'),
(33, 'TV'),
(34, 'Taxi'),
(35, 'Acepta Mascotas'),
(36, 'Playa'),
(37, 'WiFi'),
(38, 'Acceso Discapacitados'),
(39, 'MIniBar'),
(40, 'Lavandería'),
(41, 'Bar de Playa'),
(42, 'Business Center'),
(43, 'Toldos y Sillas Playa'),
(44, 'Coctail Binvenida'),
(45, 'Peluqueria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `freelancers`
--

CREATE TABLE `freelancers` (
  `id_freelancer` int(11) NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `direccion` text,
  `rif` varchar(25) DEFAULT NULL,
  `rtn` varchar(25) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habextras`
--

CREATE TABLE `habextras` (
  `id_habextra` int(10) UNSIGNED NOT NULL,
  `habextra` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `habextras`
--

INSERT INTO `habextras` (`id_habextra`, `habextra`) VALUES
(1, 'Vista al Mar'),
(2, 'Penthouse'),
(3, 'Balcón'),
(4, 'Botella de Vino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `id_plan` int(10) UNSIGNED NOT NULL,
  `plan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`id_plan`, `plan`) VALUES
(1, 'Todo Incluido'),
(2, 'Alojamiento y Desayunos'),
(3, 'Media Pensión'),
(4, 'Pensión Completa'),
(5, 'Sin Comidas'),
(6, 'HP'),
(7, 'CP'),
(8, 'EP'),
(9, 'Desayunos Continental'),
(10, 'Desayunos Buffet');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_alojamiento`
--

CREATE TABLE `tipos_alojamiento` (
  `id_tipo_alojamiento` int(10) UNSIGNED NOT NULL,
  `tipo_alojamiento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipos_alojamiento`
--

INSERT INTO `tipos_alojamiento` (`id_tipo_alojamiento`, `tipo_alojamiento`) VALUES
(1, 'Hotel'),
(2, 'Motel'),
(3, 'Apartamento Vacacional'),
(4, 'Resort'),
(5, 'Posada'),
(6, 'Campamento'),
(7, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `pass` varchar(90) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `type` smallint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0:usuario, 1:freelancer, 2:agencia, 3:agente, 4:administrador',
  `activo` smallint(1) UNSIGNED NOT NULL DEFAULT '0',
  `tmp_pass` varchar(100) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `name`, `email`, `pass`, `phone`, `type`, `activo`, `tmp_pass`, `token`) VALUES
(1, 'admin', 'admin@venetravel.net', '$2a$10$09d01ad6057dd1782338fuk2m9TobF9FWnnQoRbE1IUwCzKyd0ik2', '+584246668289', 4, 1, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agencias`
--
ALTER TABLE `agencias`
  ADD PRIMARY KEY (`id_agencia`),
  ADD UNIQUE KEY `rif` (`rif`),
  ADD UNIQUE KEY `rtn` (`rtn`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id_feature`);

--
-- Indices de la tabla `freelancers`
--
ALTER TABLE `freelancers`
  ADD PRIMARY KEY (`id_freelancer`),
  ADD UNIQUE KEY `rif` (`rif`),
  ADD UNIQUE KEY `rtn` (`rtn`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `habextras`
--
ALTER TABLE `habextras`
  ADD PRIMARY KEY (`id_habextra`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id_plan`);

--
-- Indices de la tabla `tipos_alojamiento`
--
ALTER TABLE `tipos_alojamiento`
  ADD PRIMARY KEY (`id_tipo_alojamiento`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agencias`
--
ALTER TABLE `agencias`
  MODIFY `id_agencia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `features`
--
ALTER TABLE `features`
  MODIFY `id_feature` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT de la tabla `freelancers`
--
ALTER TABLE `freelancers`
  MODIFY `id_freelancer` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `habextras`
--
ALTER TABLE `habextras`
  MODIFY `id_habextra` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `id_plan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `tipos_alojamiento`
--
ALTER TABLE `tipos_alojamiento`
  MODIFY `id_tipo_alojamiento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agencias`
--
ALTER TABLE `agencias`
  ADD CONSTRAINT `agencias_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Filtros para la tabla `freelancers`
--
ALTER TABLE `freelancers`
  ADD CONSTRAINT `freelancers_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
