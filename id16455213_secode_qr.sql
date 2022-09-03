-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-09-2022 a las 19:47:55
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `Ndocumento` int(15) NOT NULL,
  `Atributos` varchar(300) DEFAULT NULL,
  `Titulo` varchar(20) NOT NULL,
  `RutaArchivo` varchar(200) DEFAULT NULL,
  `Descripcion` varchar(430) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `codigo_qr`
--

INSERT INTO `codigo_qr` (`Id_codigo`, `Duracion`, `Ndocumento`, `Atributos`, `Titulo`, `RutaArchivo`, `Descripcion`) VALUES
(1, '2022-08-10', 1022928173, '&centerImageUrl=https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png&size=300&ecLevel=H&centerImageWidth=120&centerImageHeight=120', 'Titulo del codigo Qr', 'https://youtu.be/wmMbPh2K3-c', 'El proyecto surge debido a la problemática de la accesibilidad y coste de poseer su información médica, por lo tanto se plantea administrar o adjuntar a través de un código QR, el manejo de dicha información.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion`
--

CREATE TABLE `condicion` (
  `Id_condicion` int(5) NOT NULL,
  `Id_datos_clinicos` int(5) NOT NULL,
  `Condicion` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `Estrato` int(1) DEFAULT NULL,
  `EsAlergico` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datos_clinicos`
--

INSERT INTO `datos_clinicos` (`Id_datos_clinicos`, `Id_codigo`, `RH`, `TipoAfiliacion`, `Subsidio`, `Departamento`, `Tipo_de_sangre`, `Estrato`, `EsAlergico`) VALUES
(1, 1, '+', 'cotizante', 'si', 'cundinamarca', 'o', 2, 'si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eps`
--

CREATE TABLE `eps` (
  `id` int(9) NOT NULL,
  `Nombre` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Direccion` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `FechaNacimiento` date DEFAULT NULL,
  `Telefono` int(12) DEFAULT NULL,
  `id` int(9) NOT NULL,
  `Img_perfil` longblob DEFAULT NULL,
  `token_reset` varchar(40) DEFAULT NULL,
  `TipoImg` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Ndocumento`, `Nombre`, `Direccion`, `Genero`, `Correo`, `Contrasena`, `FechaNacimiento`, `Telefono`, `id`, `Img_perfil`, `token_reset`, `TipoImg`) VALUES
(12345, 'Gi6fti', NULL, NULL, 'user@gmail.com', '$2y$10$UHRmiKr00M05IDLuQCf6y.LZhYmYWZvh4RFjILYgkIDaLO.NGWsky', NULL, NULL, 10, NULL, NULL, NULL),
(123456, 'miuser', NULL, NULL, 'miuser@gmail.com', '$2y$10$0eWwIAO2E2RHm/evCtuLvONwsDmtdiPuZpL4h2hi2aTkdglSbyvTm', NULL, NULL, 10, NULL, '478740780211298', NULL),
(1022928173, 'luis', NULL, NULL, 'luis@gmail.com', '$2y$10$yTl8kqJtRbTTxQ0xIEx9ku2EjnpVWBqB/QZIt4/sthWJ5JzXDySKy', NULL, NULL, 10, NULL, NULL, NULL),
(1077772766, 'Johan Sebastián', NULL, NULL, 'JuanAlonxxo@gmail.com', '$2y$10$DsExOVmpARdWlAPitpNSZ.mgIltdOQ.V/XmdfuynNCNKE/G.WRvb6', NULL, NULL, 10, NULL, NULL, NULL);

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
-- AUTO_INCREMENT de la tabla `codigo_qr`
--
ALTER TABLE `codigo_qr`
  MODIFY `Id_codigo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
