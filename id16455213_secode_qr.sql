-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 28-06-2022 a las 02:24:35
-- Versión del servidor: 10.5.12-MariaDB
-- Versión de PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";S
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id16455213_secode_qr`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_qr`
--

CREATE TABLE `codigo_qr` (
  `Id_codigo` int(5) NOT NULL,
  `Duracion` date NOT NULL,
  `Ndocumento` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `codigo_qr`
--

INSERT INTO `codigo_qr` (`Id_codigo`, `Duracion`, `Ndocumento`) VALUES
(1, '2022-05-31', 53456177),
(2, '2022-11-17', 62156197),
(3, '2022-05-26', 941571670),
(4, '2022-05-31', 528468419),
(5, '2022-05-13', 23025974),
(6, '2022-05-26', 542135741),
(7, '2022-05-26', 654687233);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion`
--

CREATE TABLE `condicion` (
  `Id_condicion` int(5) NOT NULL,
  `Id_datos_clinicos` int(5) NOT NULL,
  `Condicion` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `condicion`
--

INSERT INTO `condicion` (`Id_condicion`, `Id_datos_clinicos`, `Condicion`) VALUES
(0, 1, 'astigmatismo'),
(1, 1, 'astigmatismo'),
(2, 2, 'Anemia'),
(3, 3, 'alergia al mani');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_clinicos`
--

CREATE TABLE `datos_clinicos` (
  `Id_datos_clinicos` int(5) NOT NULL,
  `Id_codigo` int(5) NOT NULL,
  `RH` varchar(2) DEFAULT NULL,
  `TipoAfiliacion` varchar(15) NOT NULL,
  `Subsidio` varchar(15) NOT NULL,
  `Departamento` varchar(25) NOT NULL,
  `Tipo_de_sangre` varchar(2) NOT NULL,
  `Nombre` varchar(25) NOT NULL,
  `Telefono` int(15) NOT NULL,
  `Img_qr` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datos_clinicos`
--

INSERT INTO `datos_clinicos` (`Id_datos_clinicos`, `Id_codigo`, `RH`, `TipoAfiliacion`, `Subsidio`, `Departamento`, `Tipo_de_sangre`, `Nombre`, `Telefono`, `Img_qr`) VALUES
(1, 1, '+', 'subsidiado', 'false', 'cundinamarca', 'o', 'andres guarnizo', 31145688, NULL),
(2, 2, '-', 'subsidiado', 'true', 'cundinamarca', 'ab', 'dayana lopez', 311256489, NULL),
(3, 3, '+', 'cotizante', 'false', 'Boyaca', 'A', 'juana solorzano', 311256987, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eps`
--

CREATE TABLE `eps` (
  `id` int(9) NOT NULL,
  `Nombre` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Direccion` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `eps`
--

INSERT INTO `eps` (`id`, `Nombre`, `Direccion`) VALUES
(1, 'sanitas', 'calle 108 N 33'),
(2, 'Famisanar', 'calle 208 N 53'),
(3, 'capitaleps', 'calle 45 s 33'),
(10, 'prueba', 'calle');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario`
--

CREATE TABLE `formulario` (
  `Id_formulario` int(5) NOT NULL,
  `Estrato` varchar(2) DEFAULT NULL,
  `Id_codigo` int(5) NOT NULL,
  `Img_qr` longblob DEFAULT NULL,
  `Codigo_postal` int(10) NOT NULL,
  `Nombre_Medicamento` varchar(25) NOT NULL,
  `Cantidad_Medicamento` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `formulario`
--

INSERT INTO `formulario` (`Id_formulario`, `Estrato`, `Id_codigo`, `Img_qr`, `Codigo_postal`, `Nombre_Medicamento`, `Cantidad_Medicamento`) VALUES
(2, '3', 3, '', 66544, 'Dolex', 5),
(4, '3', 1, NULL, 65865, 'Dolex', 5),
(5, '1', 2, NULL, 66665, 'acetaminofem', 3),
(6, '1', 4, NULL, 52698, 'Omeprazol', 6),
(7, '2', 5, NULL, 965475, 'Salbutamol', 10),
(8, '2', 6, NULL, 89855, 'Aspirina', 1),
(9, '3', 7, NULL, 33215, 'Aspirina Bayer', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `QR_plus`
--

CREATE TABLE `QR_plus` (
  `Id_qr` int(5) NOT NULL,
  `Titulo` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Categoria` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Img_qr` longblob DEFAULT NULL,
  `Id_codigo` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `QR_plus`
--

INSERT INTO `QR_plus` (`Id_qr`, `Titulo`, `Categoria`, `Fecha`, `Img_qr`, `Id_codigo`) VALUES
(1, 'Codigo de datos', 'formulario', '2022-05-10', NULL, 1),
(2, 'Datos de la dfo', 'formulario', '2022-05-18', NULL, 2),
(3, 'Codigo de datos', 'formulario', '2022-05-10', NULL, 1),
(4, 'Datos formula', 'formulario', '2022-05-18', NULL, 2),
(5, 'Codigo de datos', 'datos envi', '2020-05-10', NULL, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Suscripcion`
--

CREATE TABLE `Suscripcion` (
  `Id_suscripcion` int(15) NOT NULL,
  `Tipo_suscripcion` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Tiempo_expiracion` date NOT NULL,
  `Ndocumento` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `Suscripcion`
--

INSERT INTO `Suscripcion` (`Id_suscripcion`, `Tipo_suscripcion`, `Tiempo_expiracion`, `Ndocumento`) VALUES
(1, 'mensual ', '2022-05-26', 53456177),
(2, 'gratis', '2022-06-24', 941571670),
(3, 'gratis', '2022-06-30', 62156197);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Ndocumento` int(11) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Direccion` varchar(30) DEFAULT NULL,
  `Genero` varchar(10) DEFAULT NULL,
  `Correo` varchar(30) NOT NULL,
  `Contrasena` varchar(80) NOT NULL,
  `FechaNacimineto` date DEFAULT NULL,
  `id` int(9) NOT NULL,
  `Img_perfil` longblob DEFAULT NULL,
  `token_reset` varchar(40) DEFAULT NULL,
  `TipoImg` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Ndocumento`, `Nombre`, `Direccion`, `Genero`, `Correo`, `Contrasena`, `FechaNacimineto`, `id`, `Img_perfil`, `token_reset`, `TipoImg`) VALUES
(429, 'luis', NULL, NULL, 'luis@gmail.com', '$2y$10$yTl8kqJtRbTTxQ0xIEx9ku2EjnpVWBqB/QZIt4/sthWJ5JzXDySKy', NULL, 10, NULL, NULL, NULL),
(679, 'nombre', NULL, NULL, 'nombre@gmail.com', '$2y$10$OV6AzVWPu49dGgfmRzyljOsNrgn8xKGrAYm628ITVxzx3Ch72x9f.', NULL, 10, NULL, NULL, NULL),
(748, 'Juan Rodriguez', NULL, NULL, 'JuanPajara@gmail.com', '$2y$10$/0Ncuahkzt5nNuNXAEnPC.5EYCRFJ4/LHnwFMdUqS1XAVBNOrYhm2', NULL, 10, NULL, NULL, NULL),
(866, 'nombre', NULL, NULL, 'nombre@gmail.com', '$2y$10$y4zrdFZeYeMBSxVJWQmdoeWK6v.fR./lgvXDXl1POuXf1DAtqIDc6', NULL, 10, NULL, NULL, NULL),
(23025974, 'Valentina Rodriguez ', 'Crr6 #34 bis 4-Este\'', 'Femenino', 'ValeRodriguez7@gmail.com', '265784', '2011-04-20', 3, NULL, NULL, NULL),
(53456177, 'deivid bautista', 'Crr6 #34 Este', 'Masculino', 'JuanCamiloP1@gmail.com', '123456', '2022-06-16', 1, NULL, NULL, NULL),
(62156197, 'Roberto Cama', 'Crr9 #13 Sur', 'Masculino', 'JCamaRoberto324@gmail.com', '7890431', '2022-11-01', 2, NULL, NULL, NULL),
(528468419, 'Andres Ramos', 'Crr8-100b 56', 'Masculino', 'Ramosandres@gmail.com', '2525', '2014-01-14', 2, NULL, NULL, NULL),
(542135741, 'valeria Zuares', 'Avenida 65N 67-3', NULL, 'Valeria5Z@gmail.com', 'fs4ef5s7fs6', NULL, 3, NULL, NULL, NULL),
(654687233, 'Juan Felipe oviedo', 'Diagonal 39 sur n35', 'masculino', 'Jfelipe59o@gamil.com', 'fjsdghf54fsa', '1195-12-17', 2, NULL, NULL, NULL),
(941571670, 'Maria Jose', 'Crr1 21 Sur Apart12', 'Femenino', 'Majo2131@gmail.com', '123456789', '2022-04-09', 3, NULL, NULL, NULL),
(1022928954, 'nombre', NULL, NULL, 'nombre@gmail.com', '$2y$10$pLAlmfcThzlcnuKihzNThe8IgGNXHLP1Wm/g6NwPBM2tBh53GE5m2', NULL, 10, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `codigo_qr`
--
ALTER TABLE `codigo_qr`
  ADD PRIMARY KEY (`Id_codigo`),
  ADD KEY `Ndocumento` (`Ndocumento`);

--
-- Indices de la tabla `condicion`
--
ALTER TABLE `condicion`
  ADD PRIMARY KEY (`Id_condicion`),
  ADD KEY `Id_datos_clinicos` (`Id_datos_clinicos`);

--
-- Indices de la tabla `datos_clinicos`
--
ALTER TABLE `datos_clinicos`
  ADD PRIMARY KEY (`Id_datos_clinicos`),
  ADD KEY `Id_codigo` (`Id_codigo`);

--
-- Indices de la tabla `eps`
--
ALTER TABLE `eps`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD PRIMARY KEY (`Id_formulario`),
  ADD KEY `Id_codigo` (`Id_codigo`);

--
-- Indices de la tabla `QR_plus`
--
ALTER TABLE `QR_plus`
  ADD PRIMARY KEY (`Id_qr`),
  ADD KEY `Id_codigo` (`Id_codigo`);

--
-- Indices de la tabla `Suscripcion`
--
ALTER TABLE `Suscripcion`
  ADD PRIMARY KEY (`Id_suscripcion`),
  ADD KEY `Ndocumento` (`Ndocumento`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Ndocumento`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `QR_plus`
--
ALTER TABLE `QR_plus`
  MODIFY `Id_qr` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `Suscripcion`
--
ALTER TABLE `Suscripcion`
  MODIFY `Id_suscripcion` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `codigo_qr`
--
ALTER TABLE `codigo_qr`
  ADD CONSTRAINT `codigo_qr_ibfk_1` FOREIGN KEY (`Ndocumento`) REFERENCES `usuario` (`Ndocumento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `condicion`
--
ALTER TABLE `condicion`
  ADD CONSTRAINT `condicion_ibfk_1` FOREIGN KEY (`Id_datos_clinicos`) REFERENCES `datos_clinicos` (`Id_datos_clinicos`);

--
-- Filtros para la tabla `datos_clinicos`
--
ALTER TABLE `datos_clinicos`
  ADD CONSTRAINT `datos_clinicos_ibfk_1` FOREIGN KEY (`Id_codigo`) REFERENCES `codigo_qr` (`Id_codigo`);

--
-- Filtros para la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD CONSTRAINT `formulario_ibfk_1` FOREIGN KEY (`Id_codigo`) REFERENCES `codigo_qr` (`Id_codigo`);

--
-- Filtros para la tabla `QR_plus`
--
ALTER TABLE `QR_plus`
  ADD CONSTRAINT `QR_plus_ibfk_1` FOREIGN KEY (`Id_codigo`) REFERENCES `codigo_qr` (`Id_codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Suscripcion`
--
ALTER TABLE `Suscripcion`
  ADD CONSTRAINT `Suscripcion_ibfk_1` FOREIGN KEY (`Ndocumento`) REFERENCES `usuario` (`Ndocumento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id`) REFERENCES `eps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
