-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-12-2022 a las 17:59:30
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
  `nombre` varchar(60) NOT NULL,
  `Duracion` date NOT NULL,
  `Ndocumento` int(15) NOT NULL,
  `Atributos` varchar(300) DEFAULT '&centerImageUrl=https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png&size=300&ecLevel=H&centerImageWidth=120&centerImageHeight=120',
  `Titulo` varchar(20) NOT NULL,
  `RutaArchivo` varchar(200) DEFAULT NULL,
  `Descripcion` varchar(430) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `codigo_qr`
--

INSERT INTO `codigo_qr` (`Id_codigo`, `nombre`, `Duracion`, `Ndocumento`, `Atributos`, `Titulo`, `RutaArchivo`, `Descripcion`) VALUES
(47, '7119ee2e5e0ffad79c2408ec828d6bf2.pdf', '2022-12-07', 123456789, '&centerImageUrl=https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png&size=300&ecLevel=H&centerImageWidth=120&centerImageHeight=120', 'sdadas', 'http://127.0.0.1/secodeqr/views/pdf/7119ee2e5e0ffad79c2408ec828d6bf2.pdf', NULL);

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
  `Subsidio` int(1) NOT NULL DEFAULT 0,
  `Departamento` varchar(25) NOT NULL,
  `Tipo_de_sangre` varchar(2) NOT NULL,
  `Estrato` int(1) DEFAULT NULL,
  `EsAlergico` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(10, 'eps', 'tal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario`
--

CREATE TABLE `formulario` (
  `Id_formulario` int(5) NOT NULL,
  `Id_codigo` int(5) NOT NULL,
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
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(2) NOT NULL,
  `rol` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol`) VALUES
(1, 'user'),
(2, 'admin');

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
  `rol` int(2) NOT NULL DEFAULT 1,
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
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `id` (`id`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `codigo_qr`
--
ALTER TABLE `codigo_qr`
  MODIFY `Id_codigo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `QR_plus`
--
ALTER TABLE `QR_plus`
  MODIFY `Id_qr` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
