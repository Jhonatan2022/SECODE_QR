
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Administrador`
--

CREATE TABLE `Administrador` (
  `IDAdministrador` int(3) NOT NULL,
  `Correo` varchar(40) NOT NULL,
  `Descripcion` varchar(40) DEFAULT NULL,
  `TipoRol` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `Administrador`
--

INSERT INTO `Administrador` (`IDAdministrador`, `Correo`, `Descripcion`, `TipoRol`) VALUES
(3, 'glovitos@outlook.com', NULL, 2),
(53, 'jssossa2@misena.edu.co', NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afiliacion`
--

CREATE TABLE `afiliacion` (
  `IDAfiliacion` int(2) NOT NULL,
  `Afiliacion` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `afiliacion`
--

INSERT INTO `afiliacion` (`IDAfiliacion`, `Afiliacion`) VALUES
(1, 'Cotizante'),
(2, 'Beneficiario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AlergiaMedicamento`
--

CREATE TABLE `AlergiaMedicamento` (
  `IDAlergiaMedicamento` int(2) NOT NULL,
  `AlergiaMedicamento` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `AlergiaMedicamento`
--

INSERT INTO `AlergiaMedicamento` (`IDAlergiaMedicamento`, `AlergiaMedicamento`) VALUES
(1, 'Visual'),
(2, 'Oral'),
(3, 'Epitelial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AtributosQr`
--

CREATE TABLE `AtributosQr` (
  `IDAtributosQr` int(2) NOT NULL,
  `Atributosqr` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_qr`
--

CREATE TABLE `codigo_qr` (
  `id_codigo` int(5) NOT NULL,
  `Titulo` varchar(30) DEFAULT 'sin titulo',
  `nombre` varchar(60) CHARACTER SET latin1 NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Duracion` date NOT NULL,
  `RutaArchivo` varchar(130) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Ndocumento` int(11) NOT NULL,
  `DatosClinicos` int(4) DEFAULT NULL,
  `FormularioMedicamentos` int(4) DEFAULT NULL,
  `Atributos` int(2) DEFAULT NULL,
  `Atributo` varchar(200) DEFAULT '&centerImageUrl=https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png&size=300&ecLevel=H&centerImageWidth=120&centerImageHeight=120',
  `Privacidad` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CondicionClinica`
--

CREATE TABLE `CondicionClinica` (
  `IDCondicionClinica` int(2) NOT NULL,
  `CondicionClinica` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `CondicionClinica`
--

INSERT INTO `CondicionClinica` (`IDCondicionClinica`, `CondicionClinica`) VALUES
(1, 'Presión alta'),
(2, 'Diabetes'),
(3, 'Afecciones cardíacas'),
(4, 'Covid-19'),
(5, 'Enfermedades respiratorias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_clinicos`
--

CREATE TABLE `datos_clinicos` (
  `IDDatosClinicos` int(4) NOT NULL,
  `NDocumento` int(11) NOT NULL,
  `TipoAfiliacion` int(1) DEFAULT NULL,
  `TipoSubsidio` int(1) DEFAULT NULL,
  `Tipo_de_sangre` int(1) DEFAULT NULL,
  `RH` int(1) DEFAULT NULL,
  `CondicionClinica` int(2) DEFAULT NULL,
  `AlergiaMedicamento` int(2) DEFAULT NULL,
  `arraycond` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `datos_clinicos`
--

INSERT INTO `datos_clinicos` (`IDDatosClinicos`, `NDocumento`, `TipoAfiliacion`, `TipoSubsidio`, `Tipo_de_sangre`, `RH`, `CondicionClinica`, `AlergiaMedicamento`, `arraycond`) VALUES
(1, 123456789, 2, 2, 3, 2, 1, 1, '{\"1\":\"Covid-19\", \"2\":\"otra\",\"3\":\"Enfermedades respiratorias\"}'),
(34, 123456789, 2, NULL, 3, 2, NULL, 3, '{\"1\":\"Enfermedades respiratorias\"}'),
(42, 123456789, 2, NULL, 3, 2, NULL, 1, '{\"1\":\"Enfermedades respiratorias\"}'),
(43, 1022928166, 1, NULL, 1, 2, NULL, 1, '{\"1\":\"Enfermedades respiratorias\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eps`
--

CREATE TABLE `eps` (
  `id` int(2) NOT NULL,
  `NombreEps` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Direccion` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `eps`
--

INSERT INTO `eps` (`id`, `NombreEps`, `Direccion`) VALUES
(1, 'Capital Salud', NULL),
(2, 'Sanitas', NULL),
(3, 'Compesar', NULL),
(4, 'Colsubsidio', NULL),
(5, 'Famisanar', NULL),
(6, 'Eps Convida', NULL),
(7, 'Comfenalco', NULL),
(10, 'No afiliado', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estrato`
--

CREATE TABLE `estrato` (
  `IDEstrato` int(2) NOT NULL,
  `Estrato` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estrato`
--

INSERT INTO `estrato` (`IDEstrato`, `Estrato`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FormularioMedicamentos`
--

CREATE TABLE `FormularioMedicamentos` (
  `IDFormularioMedicamentos` int(4) NOT NULL,
  `Ndocumento` int(11) NOT NULL,
  `CodigoQR` int(4) NOT NULL,
  `ArchivoFormulaMedica` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `IDGenero` int(2) NOT NULL,
  `Genero` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`IDGenero`, `Genero`) VALUES
(1, 'Masculino'),
(2, 'Femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `IDLocalidad` int(2) NOT NULL,
  `Localidad` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`IDLocalidad`, `Localidad`) VALUES
(1, 'Usme'),
(2, 'Kenedy'),
(3, 'Suba'),
(4, 'Tunjuelito'),
(5, 'Ciudad Bolivar'),
(6, 'Chapinero'),
(7, 'Antonio Nariño'),
(8, 'Barrios Unidos'),
(9, 'Bosa'),
(10, 'Engativa'),
(11, 'Fontibón'),
(12, 'La Candelaria'),
(13, 'Los Mártires'),
(14, 'Puente Aranda'),
(15, 'Rafael Uribe Ur'),
(16, 'San Cristóbal'),
(17, 'Santa Fe'),
(18, 'Sumapaz'),
(19, 'Teusaquillo'),
(20, 'Usaquén');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RH`
--

CREATE TABLE `RH` (
  `IDRH` int(1) NOT NULL,
  `RH` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `RH`
--

INSERT INTO `RH` (`IDRH`, `RH`) VALUES
(1, '+'),
(2, '-');

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
(1, 'Usuario'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Suscripcion`
--

CREATE TABLE `Suscripcion` (
  `IDSuscripcion` int(4) NOT NULL,
  `Ndocumento` int(11) NOT NULL,
  `FechaExpiracion` date DEFAULT NULL,
  `TipoSuscripcion` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `numero_recibo` bigint(20) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `Suscripcion`
--
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `IDTipoDoc` int(2) NOT NULL,
  `TipoDocumento` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`IDTipoDoc`, `TipoDocumento`) VALUES
(1, 'Cedula'),
(2, 'Tarjeta de identidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoSangre`
--

CREATE TABLE `TipoSangre` (
  `IDTipoSangre` int(1) NOT NULL,
  `TipoSangre` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `TipoSangre`
--

INSERT INTO `TipoSangre` (`IDTipoSangre`, `TipoSangre`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'AB'),
(4, 'O');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoSubsidio`
--

CREATE TABLE `TipoSubsidio` (
  `IDTipoSubsidio` int(2) NOT NULL,
  `TipoSubsidio` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `TipoSubsidio`
--

INSERT INTO `TipoSubsidio` (`IDTipoSubsidio`, `TipoSubsidio`) VALUES
(1, 'Cotizante'),
(2, 'Subsidiado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoSuscripcion`
--

CREATE TABLE `TipoSuscripcion` (
  `IDTipoSuscripcion` int(1) NOT NULL,
  `TipoSuscripcion` varchar(25) DEFAULT NULL,
  `nombre_archivo` varchar(15) DEFAULT NULL,
  `precio` int(8) DEFAULT NULL,
  `cantidad_qr` int(2) DEFAULT NULL,
  `Editar` varchar(2) NOT NULL,
  `citas` varchar(2) NOT NULL,
  `tiempo` int(2) NOT NULL,
  `EditarQR` varchar(2) NOT NULL,
  `CompartirPerfil` varchar(2) NOT NULL,
  `RellenarFormulario` varchar(2) NOT NULL,
  `EnviarMensaje` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `TipoSuscripcion`
--

INSERT INTO `TipoSuscripcion` (`IDTipoSuscripcion`, `TipoSuscripcion`, `nombre_archivo`, `precio`, `cantidad_qr`, `Editar`, `citas`, `tiempo`, `EditarQR`, `CompartirPerfil`, `RellenarFormulario`, `EnviarMensaje`) VALUES
(1, 'Gratis', 'iniciar.php', 0, 1, 'NO', 'NO', 0, 'NO', 'NO', 'NO', 'NO'),
(2, 'Básico', 'basico.php', 9900, 5, 'NO', 'NO', 1, 'NO', 'NO', 'NO', 'NO'),
(3, 'Estandar', 'estandar.php', 26000, 8, 'SI', 'NO', 3, 'NO', 'SI', 'SI', 'NO'),
(4, 'Premium', 'premium.php', 52000, 10, 'SI', 'SI', 6, 'SI', 'SI', 'SI', 'SI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Ndocumento` int(11) NOT NULL COMMENT 'Llave primaria, que identifica un usuario.',
  `TipoDoc` int(2) DEFAULT 1 COMMENT 'Llave foranea, para tipo de documento',
  `Nombre` varchar(30) NOT NULL,
  `Apellidos` varchar(30) DEFAULT NULL,
  `Correo` varchar(60) NOT NULL,
  `Direccion` varchar(40) DEFAULT NULL,
  `Localidad` int(2) DEFAULT NULL,
  `Genero` int(2) DEFAULT NULL,
  `Estrato` int(2) DEFAULT NULL,
  `id` int(2) DEFAULT 10 COMMENT 'esta tabla referencia la eps ',
  `rol` int(2) DEFAULT 1,
  `FechaNacimiento` date DEFAULT NULL,
  `Telefono` bigint(12) DEFAULT NULL,
  `Img_perfil` longblob DEFAULT NULL,
  `CompartirUrl` varchar(60) DEFAULT NULL,
  `Compartido` int(1) DEFAULT NULL,
  `Verificado` int(1) DEFAULT NULL,
  `token_reset` varchar(40) DEFAULT NULL,
  `TipoImg` varchar(10) DEFAULT NULL,
  `Contrasena` varchar(80) NOT NULL,
  `fechaCreacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indices de la tabla `Administrador`
--
ALTER TABLE `Administrador`
  ADD PRIMARY KEY (`IDAdministrador`),
  ADD KEY `TipoRol` (`TipoRol`);

--
-- Indices de la tabla `afiliacion`
--
ALTER TABLE `afiliacion`
  ADD PRIMARY KEY (`IDAfiliacion`);

--
-- Indices de la tabla `AlergiaMedicamento`
--
ALTER TABLE `AlergiaMedicamento`
  ADD PRIMARY KEY (`IDAlergiaMedicamento`);

--
-- Indices de la tabla `AtributosQr`
--
ALTER TABLE `AtributosQr`
  ADD PRIMARY KEY (`IDAtributosQr`);

--
-- Indices de la tabla `codigo_qr`
--
ALTER TABLE `codigo_qr`
  ADD PRIMARY KEY (`id_codigo`),
  ADD KEY `Ndocumento` (`Ndocumento`),
  ADD KEY `DatosClinicos` (`DatosClinicos`),
  ADD KEY `codigo_qr_ibfk_3` (`FormularioMedicamentos`),
  ADD KEY `Atributos` (`Atributos`) USING BTREE;

--
-- Indices de la tabla `CondicionClinica`
--
ALTER TABLE `CondicionClinica`
  ADD PRIMARY KEY (`IDCondicionClinica`);

--
-- Indices de la tabla `datos_clinicos`
--
ALTER TABLE `datos_clinicos`
  ADD PRIMARY KEY (`IDDatosClinicos`),
  ADD KEY `NDocumento` (`NDocumento`),
  ADD KEY `TipoSubsidio` (`TipoSubsidio`),
  ADD KEY `RH` (`RH`),
  ADD KEY `CondicionClinica` (`CondicionClinica`),
  ADD KEY `AlergiaMedicamento` (`AlergiaMedicamento`),
  ADD KEY `TipoAfiliacion` (`TipoAfiliacion`),
  ADD KEY `Tipo_de_sangre` (`Tipo_de_sangre`);

--
-- Indices de la tabla `eps`
--
ALTER TABLE `eps`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estrato`
--
ALTER TABLE `estrato`
  ADD PRIMARY KEY (`IDEstrato`);

--
-- Indices de la tabla `FormularioMedicamentos`
--
ALTER TABLE `FormularioMedicamentos`
  ADD PRIMARY KEY (`IDFormularioMedicamentos`),
  ADD KEY `Ndocumento` (`Ndocumento`),
  ADD KEY `FormularioMedicamentos_ibfk_2` (`CodigoQR`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`IDGenero`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`IDLocalidad`);

--
-- Indices de la tabla `RH`
--
ALTER TABLE `RH`
  ADD PRIMARY KEY (`IDRH`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Suscripcion`
--
ALTER TABLE `Suscripcion`
  ADD PRIMARY KEY (`IDSuscripcion`),
  ADD KEY `Ndocumento` (`Ndocumento`),
  ADD KEY `TipoSuscripcion` (`TipoSuscripcion`);

--
-- Indices de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`IDTipoDoc`);

--
-- Indices de la tabla `TipoSangre`
--
ALTER TABLE `TipoSangre`
  ADD PRIMARY KEY (`IDTipoSangre`);

--
-- Indices de la tabla `TipoSubsidio`
--
ALTER TABLE `TipoSubsidio`
  ADD PRIMARY KEY (`IDTipoSubsidio`);

--
-- Indices de la tabla `TipoSuscripcion`
--
ALTER TABLE `TipoSuscripcion`
  ADD PRIMARY KEY (`IDTipoSuscripcion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Ndocumento`),
  ADD KEY `TipoDoc` (`TipoDoc`),
  ADD KEY `Localidad` (`Localidad`,`Genero`,`Estrato`,`rol`),
  ADD KEY `Estrato` (`Estrato`),
  ADD KEY `Genero` (`Genero`),
  ADD KEY `rol` (`rol`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Administrador`
--
ALTER TABLE `Administrador`
  MODIFY `IDAdministrador` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `AlergiaMedicamento`
--
ALTER TABLE `AlergiaMedicamento`
  MODIFY `IDAlergiaMedicamento` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `AtributosQr`
--
ALTER TABLE `AtributosQr`
  MODIFY `IDAtributosQr` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `codigo_qr`
--
ALTER TABLE `codigo_qr`
  MODIFY `id_codigo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `CondicionClinica`
--
ALTER TABLE `CondicionClinica`
  MODIFY `IDCondicionClinica` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `datos_clinicos`
--
ALTER TABLE `datos_clinicos`
  MODIFY `IDDatosClinicos` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `FormularioMedicamentos`
--
ALTER TABLE `FormularioMedicamentos`
  MODIFY `IDFormularioMedicamentos` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Suscripcion`
--
ALTER TABLE `Suscripcion`
  MODIFY `IDSuscripcion` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `TipoSubsidio`
--
ALTER TABLE `TipoSubsidio`
  MODIFY `IDTipoSubsidio` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `TipoSuscripcion`
--
ALTER TABLE `TipoSuscripcion`
  MODIFY `IDTipoSuscripcion` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Administrador`
--
ALTER TABLE `Administrador`
  ADD CONSTRAINT `Administrador_ibfk_1` FOREIGN KEY (`TipoRol`) REFERENCES `rol` (`id`);

--
-- Filtros para la tabla `codigo_qr`
--
ALTER TABLE `codigo_qr`
  ADD CONSTRAINT `codigo_qr_ibfk_1` FOREIGN KEY (`Ndocumento`) REFERENCES `usuario` (`Ndocumento`),
  ADD CONSTRAINT `codigo_qr_ibfk_2` FOREIGN KEY (`DatosClinicos`) REFERENCES `datos_clinicos` (`IDDatosClinicos`),
  ADD CONSTRAINT `codigo_qr_ibfk_3` FOREIGN KEY (`FormularioMedicamentos`) REFERENCES `FormularioMedicamentos` (`IDFormularioMedicamentos`),
  ADD CONSTRAINT `codigo_qr_ibfk_4` FOREIGN KEY (`Atributos`) REFERENCES `AtributosQr` (`IDAtributosQr`);

--
-- Filtros para la tabla `datos_clinicos`
--
ALTER TABLE `datos_clinicos`
  ADD CONSTRAINT `datos_clinicos_ibfk_1` FOREIGN KEY (`NDocumento`) REFERENCES `usuario` (`Ndocumento`),
  ADD CONSTRAINT `datos_clinicos_ibfk_2` FOREIGN KEY (`TipoAfiliacion`) REFERENCES `afiliacion` (`IDAfiliacion`),
  ADD CONSTRAINT `datos_clinicos_ibfk_3` FOREIGN KEY (`CondicionClinica`) REFERENCES `CondicionClinica` (`IDCondicionClinica`),
  ADD CONSTRAINT `datos_clinicos_ibfk_4` FOREIGN KEY (`AlergiaMedicamento`) REFERENCES `AlergiaMedicamento` (`IDAlergiaMedicamento`),
  ADD CONSTRAINT `datos_clinicos_ibfk_5` FOREIGN KEY (`TipoSubsidio`) REFERENCES `TipoSubsidio` (`IDTipoSubsidio`),
  ADD CONSTRAINT `datos_clinicos_ibfk_6` FOREIGN KEY (`Tipo_de_sangre`) REFERENCES `TipoSangre` (`IDTipoSangre`),
  ADD CONSTRAINT `datos_clinicos_ibfk_7` FOREIGN KEY (`RH`) REFERENCES `RH` (`IDRH`);

--
-- Filtros para la tabla `FormularioMedicamentos`
--
ALTER TABLE `FormularioMedicamentos`
  ADD CONSTRAINT `FormularioMedicamentos_ibfk_1` FOREIGN KEY (`Ndocumento`) REFERENCES `usuario` (`Ndocumento`),
  ADD CONSTRAINT `FormularioMedicamentos_ibfk_2` FOREIGN KEY (`CodigoQR`) REFERENCES `codigo_qr` (`id_codigo`);

--
-- Filtros para la tabla `Suscripcion`
--
ALTER TABLE `Suscripcion`
  ADD CONSTRAINT `Suscripcion_ibfk_1` FOREIGN KEY (`Ndocumento`) REFERENCES `usuario` (`Ndocumento`),
  ADD CONSTRAINT `Suscripcion_ibfk_2` FOREIGN KEY (`TipoSuscripcion`) REFERENCES `TipoSuscripcion` (`IDTipoSuscripcion`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id`) REFERENCES `eps` (`id`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`TipoDoc`) REFERENCES `tipodocumento` (`IDTipoDoc`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`Localidad`) REFERENCES `localidad` (`IDLocalidad`),
  ADD CONSTRAINT `usuario_ibfk_4` FOREIGN KEY (`Estrato`) REFERENCES `estrato` (`IDEstrato`),
  ADD CONSTRAINT `usuario_ibfk_5` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `usuario_ibfk_6` FOREIGN KEY (`Genero`) REFERENCES `genero` (`IDGenero`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
