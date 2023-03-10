-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2023 at 05:59 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalsecode`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrador`
--

CREATE TABLE `administrador` (
  `IDAdministrador` int(3) NOT NULL,
  `Correo` varchar(40) NOT NULL,
  `Contraseña` varchar(90) NOT NULL,
  `Nombre` varchar(35) NOT NULL,
  `Documento` int(11) NOT NULL,
  `TipoRol` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `afiliacion`
--

CREATE TABLE `afiliacion` (
  `IDAfiliacion` int(2) NOT NULL,
  `Afiliacion` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `afiliacion`
--

INSERT INTO `afiliacion` (`IDAfiliacion`, `Afiliacion`) VALUES
(1, 'Cotizante'),
(2, 'Beneficiario');

-- --------------------------------------------------------

--
-- Table structure for table `alergiamedicamento`
--

CREATE TABLE `alergiamedicamento` (
  `IDAlergiaMedicamento` int(2) NOT NULL,
  `AlergiaMedicamento` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alergiamedicamento`
--

INSERT INTO `alergiamedicamento` (`IDAlergiaMedicamento`, `AlergiaMedicamento`) VALUES
(1, 'Visual'),
(2, 'Oral'),
(3, 'Epitelial');

-- --------------------------------------------------------

--
-- Table structure for table `atributosqr`
--

CREATE TABLE `atributosqr` (
  `IDAtributosQr` int(2) NOT NULL,
  `Atributosqr` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `codigo_qr`
--

CREATE TABLE `codigo_qr` (
  `id_codigo` int(5) NOT NULL,
  `Titulo` varchar(30) DEFAULT 'sin titulo',
  `nombre` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Duracion` date NOT NULL,
  `RutaArchivo` varchar(80) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Ndocumento` int(11) NOT NULL,
  `DatosClinicos` int(4) DEFAULT NULL,
  `FormularioMedicamentos` int(4) DEFAULT NULL,
  `Atributos` int(2) DEFAULT NULL,
  `Atributo` varchar(200) DEFAULT '&centerImageUrl=https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png&size=300&ecLevel=H&centerImageWidth=120&centerImageHeight=120'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `codigo_qr`
--

INSERT INTO `codigo_qr` (`id_codigo`, `Titulo`, `nombre`, `Fecha`, `Duracion`, `RutaArchivo`, `Descripcion`, `Ndocumento`, `DatosClinicos`, `FormularioMedicamentos`, `Atributos`, `Atributo`) VALUES
(18, '', '80e6fa50b31197f66559a91357ba3f8e.pdf', NULL, '2023-03-05', 'http://127.0.0.1/secodeqr/views/pdf/80e6fa50b31197f66559a91357ba3f8e.pdf', NULL, 123456789, 17, NULL, NULL, '&centerImageUrl=https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png&size=300&ecLevel=H&centerImageWidth=120&centerImageHeight=120'),
(24, '', 'c4662d2e4ef0ae962acca34fbf11b903.pdf', NULL, '2023-03-08', 'http://127.0.0.1/secodeqr/views/pdf/c4662d2e4ef0ae962acca34fbf11b903.pdf', NULL, 123456789, 22, NULL, NULL, '&centerImageUrl=https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png&size=300&ecLevel=H&centerImageWidth=120&centerImageHeight=120');

-- --------------------------------------------------------

--
-- Table structure for table `condicionclinica`
--

CREATE TABLE `condicionclinica` (
  `IDCondicionClinica` int(2) NOT NULL,
  `CondicionClinica` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `condicionclinica`
--

INSERT INTO `condicionclinica` (`IDCondicionClinica`, `CondicionClinica`) VALUES
(1, 'Presión alta'),
(2, 'Diabetes'),
(3, 'Afecciones cardíacas'),
(4, 'Covid-19'),
(5, 'Enfermedades respiratorias');

-- --------------------------------------------------------

--
-- Table structure for table `datos_clinicos`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `datos_clinicos`
--

INSERT INTO `datos_clinicos` (`IDDatosClinicos`, `NDocumento`, `TipoAfiliacion`, `TipoSubsidio`, `Tipo_de_sangre`, `RH`, `CondicionClinica`, `AlergiaMedicamento`, `arraycond`) VALUES
(1, 123456789, 2, 2, 3, 2, 1, 1, '{\"1\":\"Covid-19\", \"2\":\"otra\",\"3\":\"Enfermedades respiratorias\"}'),
(17, 123456789, 2, NULL, 3, 2, NULL, 1, '{\"1\":\"Enfermedades respiratorias\"}'),
(22, 123456789, 2, NULL, 3, 2, NULL, 1, '{\"1\":\"Enfermedades respiratorias\"}');

-- --------------------------------------------------------

--
-- Table structure for table `eps`
--

CREATE TABLE `eps` (
  `id` int(2) NOT NULL,
  `NombreEps` varchar(25) NOT NULL,
  `Direccion` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eps`
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
-- Table structure for table `estrato`
--

CREATE TABLE `estrato` (
  `IDEstrato` int(2) NOT NULL,
  `Estrato` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estrato`
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
-- Table structure for table `formulariomedicamentos`
--

CREATE TABLE `formulariomedicamentos` (
  `IDFormularioMedicamentos` int(4) NOT NULL,
  `Ndocumento` int(11) NOT NULL,
  `CodigoQR` int(4) NOT NULL,
  `ArchivoFormulaMedica` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genero`
--

CREATE TABLE `genero` (
  `IDGenero` int(2) NOT NULL,
  `Genero` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genero`
--

INSERT INTO `genero` (`IDGenero`, `Genero`) VALUES
(1, 'Masculino'),
(2, 'Femenino');

-- --------------------------------------------------------

--
-- Table structure for table `localidad`
--

CREATE TABLE `localidad` (
  `IDLocalidad` int(2) NOT NULL,
  `Localidad` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `localidad`
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
-- Table structure for table `rh`
--

CREATE TABLE `rh` (
  `IDRH` int(1) NOT NULL,
  `RH` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rh`
--

INSERT INTO `rh` (`IDRH`, `RH`) VALUES
(1, '+'),
(2, '-');

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `id` int(2) NOT NULL,
  `rol` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `rol`) VALUES
(1, 'Usuario'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Table structure for table `suscripcion`
--

CREATE TABLE `suscripcion` (
  `IDSuscripcion` int(4) NOT NULL,
  `Ndocumento` int(11) NOT NULL,
  `FechaExpiracion` date DEFAULT NULL,
  `TipoSuscripcion` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `numero_recibo` bigint(20) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suscripcion`
--

INSERT INTO `suscripcion` (`IDSuscripcion`, `Ndocumento`, `FechaExpiracion`, `TipoSuscripcion`, `fecha_inicio`, `numero_recibo`, `token`) VALUES
(29, 123456789, NULL, 3, '2023-03-08', 2459909968, 'ceeddb86b995ded82e974be21d2d1c43');

-- --------------------------------------------------------

--
-- Table structure for table `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `IDTipoDoc` int(2) NOT NULL,
  `TipoDocumento` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipodocumento`
--

INSERT INTO `tipodocumento` (`IDTipoDoc`, `TipoDocumento`) VALUES
(1, 'Cedula'),
(2, 'Tarjeta de identidad');

-- --------------------------------------------------------

--
-- Table structure for table `tiposangre`
--

CREATE TABLE `tiposangre` (
  `IDTipoSangre` int(1) NOT NULL,
  `TipoSangre` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tiposangre`
--

INSERT INTO `tiposangre` (`IDTipoSangre`, `TipoSangre`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'AB'),
(4, 'O');

-- --------------------------------------------------------

--
-- Table structure for table `tiposubsidio`
--

CREATE TABLE `tiposubsidio` (
  `IDTipoSubsidio` int(2) NOT NULL,
  `TipoSubsidio` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tiposubsidio`
--

INSERT INTO `tiposubsidio` (`IDTipoSubsidio`, `TipoSubsidio`) VALUES
(1, 'Cotizante'),
(2, 'Subsidiado');

-- --------------------------------------------------------

--
-- Table structure for table `tiposuscripcion`
--

CREATE TABLE `tiposuscripcion` (
  `IDTipoSuscripcion` int(1) NOT NULL,
  `TipoSuscripcion` varchar(25) DEFAULT NULL,
  `nombre_archivo` varchar(15) DEFAULT NULL,
  `precio` int(8) DEFAULT NULL,
  `cantidad_qr` int(2) DEFAULT NULL,
  `Editar` varchar(2) NOT NULL,
  `citas` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tiposuscripcion`
--

INSERT INTO `tiposuscripcion` (`IDTipoSuscripcion`, `TipoSuscripcion`, `nombre_archivo`, `precio`, `cantidad_qr`, `Editar`, `citas`) VALUES
(1, 'Gratis', '', 0, 1, 'NO', 'NO'),
(2, 'Básico', 'basico.php', 9900, 5, 'NO', 'NO'),
(3, 'Estandar', 'estandar.php', 26000, 8, 'SI', 'NO'),
(4, 'Premium', 'premium.php', 52000, 10, 'SI', 'SI');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `Ndocumento` int(11) NOT NULL,
  `TipoDoc` int(2) DEFAULT 1,
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
  `Telefono` int(12) DEFAULT NULL,
  `Img_perfil` longblob DEFAULT NULL,
  `token_reset` varchar(40) DEFAULT NULL,
  `TipoImg` varchar(10) DEFAULT NULL,
  `Contrasena` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`Ndocumento`, `TipoDoc`, `Nombre`, `Apellidos`, `Correo`, `Direccion`, `Localidad`, `Genero`, `Estrato`, `id`, `rol`, `FechaNacimiento`, `Telefono`, `Img_perfil`, `token_reset`, `TipoImg`, `Contrasena`) VALUES
(123456789, 1, 'Andres    ', 'Suarez', 'lfchaparro37@misena.edu.co', 'calle 13    ', 14, 2, 3, 3, 2, '2022-12-05', 0, NULL, '65465465435432', 'image/jpeg', '$2y$10$nhNqQtihE6TWMRHuUyVwm.NkV8eYuLvp5uomtMeHdYryOQhtcUVuu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`IDAdministrador`),
  ADD KEY `TipoRol` (`TipoRol`);

--
-- Indexes for table `afiliacion`
--
ALTER TABLE `afiliacion`
  ADD PRIMARY KEY (`IDAfiliacion`);

--
-- Indexes for table `alergiamedicamento`
--
ALTER TABLE `alergiamedicamento`
  ADD PRIMARY KEY (`IDAlergiaMedicamento`);

--
-- Indexes for table `atributosqr`
--
ALTER TABLE `atributosqr`
  ADD PRIMARY KEY (`IDAtributosQr`);

--
-- Indexes for table `codigo_qr`
--
ALTER TABLE `codigo_qr`
  ADD PRIMARY KEY (`id_codigo`),
  ADD KEY `Ndocumento` (`Ndocumento`),
  ADD KEY `DatosClinicos` (`DatosClinicos`),
  ADD KEY `codigo_qr_ibfk_3` (`FormularioMedicamentos`),
  ADD KEY `Atributos` (`Atributos`) USING BTREE;

--
-- Indexes for table `condicionclinica`
--
ALTER TABLE `condicionclinica`
  ADD PRIMARY KEY (`IDCondicionClinica`);

--
-- Indexes for table `datos_clinicos`
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
-- Indexes for table `eps`
--
ALTER TABLE `eps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estrato`
--
ALTER TABLE `estrato`
  ADD PRIMARY KEY (`IDEstrato`);

--
-- Indexes for table `formulariomedicamentos`
--
ALTER TABLE `formulariomedicamentos`
  ADD PRIMARY KEY (`IDFormularioMedicamentos`),
  ADD KEY `Ndocumento` (`Ndocumento`),
  ADD KEY `FormularioMedicamentos_ibfk_2` (`CodigoQR`);

--
-- Indexes for table `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`IDGenero`);

--
-- Indexes for table `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`IDLocalidad`);

--
-- Indexes for table `rh`
--
ALTER TABLE `rh`
  ADD PRIMARY KEY (`IDRH`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suscripcion`
--
ALTER TABLE `suscripcion`
  ADD PRIMARY KEY (`IDSuscripcion`),
  ADD KEY `Ndocumento` (`Ndocumento`),
  ADD KEY `TipoSuscripcion` (`TipoSuscripcion`);

--
-- Indexes for table `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`IDTipoDoc`);

--
-- Indexes for table `tiposangre`
--
ALTER TABLE `tiposangre`
  ADD PRIMARY KEY (`IDTipoSangre`);

--
-- Indexes for table `tiposubsidio`
--
ALTER TABLE `tiposubsidio`
  ADD PRIMARY KEY (`IDTipoSubsidio`);

--
-- Indexes for table `tiposuscripcion`
--
ALTER TABLE `tiposuscripcion`
  ADD PRIMARY KEY (`IDTipoSuscripcion`);

--
-- Indexes for table `usuario`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrador`
--
ALTER TABLE `administrador`
  MODIFY `IDAdministrador` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alergiamedicamento`
--
ALTER TABLE `alergiamedicamento`
  MODIFY `IDAlergiaMedicamento` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `atributosqr`
--
ALTER TABLE `atributosqr`
  MODIFY `IDAtributosQr` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `codigo_qr`
--
ALTER TABLE `codigo_qr`
  MODIFY `id_codigo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `condicionclinica`
--
ALTER TABLE `condicionclinica`
  MODIFY `IDCondicionClinica` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `datos_clinicos`
--
ALTER TABLE `datos_clinicos`
  MODIFY `IDDatosClinicos` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `formulariomedicamentos`
--
ALTER TABLE `formulariomedicamentos`
  MODIFY `IDFormularioMedicamentos` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suscripcion`
--
ALTER TABLE `suscripcion`
  MODIFY `IDSuscripcion` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tiposubsidio`
--
ALTER TABLE `tiposubsidio`
  MODIFY `IDTipoSubsidio` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tiposuscripcion`
--
ALTER TABLE `tiposuscripcion`
  MODIFY `IDTipoSuscripcion` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `Administrador_ibfk_1` FOREIGN KEY (`TipoRol`) REFERENCES `rol` (`id`);

--
-- Constraints for table `codigo_qr`
--
ALTER TABLE `codigo_qr`
  ADD CONSTRAINT `codigo_qr_ibfk_1` FOREIGN KEY (`Ndocumento`) REFERENCES `usuario` (`Ndocumento`),
  ADD CONSTRAINT `codigo_qr_ibfk_2` FOREIGN KEY (`DatosClinicos`) REFERENCES `datos_clinicos` (`IDDatosClinicos`),
  ADD CONSTRAINT `codigo_qr_ibfk_3` FOREIGN KEY (`FormularioMedicamentos`) REFERENCES `formulariomedicamentos` (`IDFormularioMedicamentos`),
  ADD CONSTRAINT `codigo_qr_ibfk_4` FOREIGN KEY (`Atributos`) REFERENCES `atributosqr` (`IDAtributosQr`);

--
-- Constraints for table `datos_clinicos`
--
ALTER TABLE `datos_clinicos`
  ADD CONSTRAINT `datos_clinicos_ibfk_1` FOREIGN KEY (`NDocumento`) REFERENCES `usuario` (`Ndocumento`),
  ADD CONSTRAINT `datos_clinicos_ibfk_2` FOREIGN KEY (`TipoAfiliacion`) REFERENCES `afiliacion` (`IDAfiliacion`),
  ADD CONSTRAINT `datos_clinicos_ibfk_3` FOREIGN KEY (`CondicionClinica`) REFERENCES `condicionclinica` (`IDCondicionClinica`),
  ADD CONSTRAINT `datos_clinicos_ibfk_4` FOREIGN KEY (`AlergiaMedicamento`) REFERENCES `alergiamedicamento` (`IDAlergiaMedicamento`),
  ADD CONSTRAINT `datos_clinicos_ibfk_5` FOREIGN KEY (`TipoSubsidio`) REFERENCES `tiposubsidio` (`IDTipoSubsidio`),
  ADD CONSTRAINT `datos_clinicos_ibfk_6` FOREIGN KEY (`Tipo_de_sangre`) REFERENCES `tiposangre` (`IDTipoSangre`),
  ADD CONSTRAINT `datos_clinicos_ibfk_7` FOREIGN KEY (`RH`) REFERENCES `rh` (`IDRH`);

--
-- Constraints for table `formulariomedicamentos`
--
ALTER TABLE `formulariomedicamentos`
  ADD CONSTRAINT `FormularioMedicamentos_ibfk_1` FOREIGN KEY (`Ndocumento`) REFERENCES `usuario` (`Ndocumento`),
  ADD CONSTRAINT `FormularioMedicamentos_ibfk_2` FOREIGN KEY (`CodigoQR`) REFERENCES `codigo_qr` (`id_codigo`);

--
-- Constraints for table `suscripcion`
--
ALTER TABLE `suscripcion`
  ADD CONSTRAINT `Suscripcion_ibfk_1` FOREIGN KEY (`Ndocumento`) REFERENCES `usuario` (`Ndocumento`),
  ADD CONSTRAINT `Suscripcion_ibfk_2` FOREIGN KEY (`TipoSuscripcion`) REFERENCES `tiposuscripcion` (`IDTipoSuscripcion`);

--
-- Constraints for table `usuario`
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
