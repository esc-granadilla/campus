-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-03-2019 a las 12:31:07
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `esc-granadilla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `CODIGO` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `NOMBRE` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `GRADO` int(1) NOT NULL,
  `TIPO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `DESCRIPCION` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ESTADO` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_horario`
--

CREATE TABLE `curso_horario` (
  `ID_CURSO` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `ID_HORARIO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `CEDULA` int(9) NOT NULL,
  `NOMBRE` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `PRIMER_APELLIDO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `SEGUNDO_APELLIDO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `FECHA_NACIMIENTO` date NOT NULL,
  `PUESTO` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `FECHA_INGRESO` date NOT NULL,
  `TEL_1` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `TEL_2` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  `ESTADO` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargado`
--

CREATE TABLE `encargado` (
  `CEDULA` int(9) NOT NULL,
  `NOMBRE` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `PRIMER_APELLIDO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `SEGUNDO_APELLIDO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `PARENTESCO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `TELEFONO` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `CORREO` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='DATOS PERSONALES DEL PADRE O ENCARGADO DE FAMILIA DEL ESTUDIANTE';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `CEDULA` int(9) NOT NULL,
  `NOMBRE` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `PRIMER_APELLIDO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `SEGUNDO_APELLIDO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `FECHA_NACIMIENTO` date NOT NULL,
  `GRADO` int(1) NOT NULL,
  `ADECUACION` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  `ID_ENCARGADO` int(9) DEFAULT NULL,
  `ESTADO` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_curso`
--

CREATE TABLE `estudiante_curso` (
  `CEDULA` int(9) NOT NULL,
  `ID_PROFESOR` int(9) NOT NULL,
  `ID_CURSO` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `ID_HORARIO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `ID` int(11) NOT NULL,
  `ABREVIACION` varchar(12) COLLATE utf8_spanish2_ci NOT NULL,
  `BLOQUE` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `DIA` int(1) NOT NULL,
  `CICLO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `ESTADO` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota`
--

CREATE TABLE `nota` (
  `ID` int(11) NOT NULL,
  `TITULO` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `VALOR_PORCENTUAL` decimal(3,1) NOT NULL,
  `PORCENTAJE_OBTENIDO` decimal(4,2) NOT NULL,
  `TIPO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `CONDICION` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'REALIZADA',
  `DESCRIPCION` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `TRIMESTRE` int(1) NOT NULL,
  `ESTADO` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_estudiante_curso`
--

CREATE TABLE `nota_estudiante_curso` (
  `CEDULA` int(9) NOT NULL,
  `ID_NOTA` int(11) NOT NULL,
  `ID_PROFESOR` int(9) NOT NULL,
  `ID_CURSO` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `ID_HORARIO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `ID` int(11) NOT NULL,
  `TITULO` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `DESCRIPCION` varchar(1000) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `TIPO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'GRUPAL',
  `ESTADO` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia_imagen`
--

CREATE TABLE `noticia_imagen` (
  `ID` int(11) NOT NULL,
  `ID_NOTICIA` int(11) NOT NULL,
  `IMAGEN` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `TITULO` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `DESCRIPCION` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `LINK` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia_profesor_curso`
--

CREATE TABLE `noticia_profesor_curso` (
  `ID_NOTICIA` int(11) NOT NULL,
  `ID_PROFESOR` int(9) NOT NULL,
  `ID_CURSO` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `ID_HORARIO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia_video`
--

CREATE TABLE `noticia_video` (
  `ID` int(11) NOT NULL,
  `ID_NOTICIA` int(11) NOT NULL,
  `VIDEO` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `TITULO` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `DESCRIPCION` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_curso`
--

CREATE TABLE `profesor_curso` (
  `ID_PROFESOR` int(11) NOT NULL,
  `ID_CURSO` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `ID_HORARIO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `DESCRIPCION` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ESTADO` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE `tarea` (
  `ID` int(11) NOT NULL,
  `TITULO` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `TAREA_XML_NAME` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `DESCRIPCION` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `PORCENTAJE` decimal(3,1) NOT NULL,
  `N_PREGUNTAS` int(11) NOT NULL,
  `RESPUESTAS` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `FECHA_INICIO` datetime NOT NULL,
  `FECHA_FIN` datetime NOT NULL,
  `TRIMESTRE` int(1) NOT NULL,
  `ESTADO` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea_profesor_curso`
--

CREATE TABLE `tarea_profesor_curso` (
  `ID_TAREA` int(11) NOT NULL,
  `ID_PROFESOR` int(9) NOT NULL,
  `ID_CURSO` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `ID_HORARIO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea_respuesta`
--

CREATE TABLE `tarea_respuesta` (
  `CEDULA` int(9) NOT NULL,
  `ID_TAREA` int(11) NOT NULL,
  `ID_PROFESOR` int(9) NOT NULL,
  `ID_CURSO` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `ID_HORARIO` int(11) NOT NULL,
  `RESPUESTA` varchar(300) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL,
  `USER` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `PASSWORD` varchar(32) COLLATE utf8_spanish2_ci NOT NULL,
  `MAIL` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `ESTADO` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `ID_USUARIO` int(11) NOT NULL,
  `ID_ROL` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`CODIGO`),
  ADD UNIQUE KEY `NOMBRE_UNIQUE` (`NOMBRE`);

--
-- Indices de la tabla `curso_horario`
--
ALTER TABLE `curso_horario`
  ADD PRIMARY KEY (`ID_CURSO`,`ID_HORARIO`),
  ADD KEY `fk_curso_horario_2` (`ID_HORARIO`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`CEDULA`),
  ADD KEY `fk_empleado_usuario_idx` (`ID_USUARIO`);

--
-- Indices de la tabla `encargado`
--
ALTER TABLE `encargado`
  ADD PRIMARY KEY (`CEDULA`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`CEDULA`),
  ADD KEY `fk_estudiante_encargado_idx` (`ID_ENCARGADO`),
  ADD KEY `fk_estudiante_usuario_idx` (`ID_USUARIO`);

--
-- Indices de la tabla `estudiante_curso`
--
ALTER TABLE `estudiante_curso`
  ADD PRIMARY KEY (`CEDULA`,`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`),
  ADD KEY `fk_estudiante_curso_2_idx` (`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ABREVIACION_UNIQUE` (`ABREVIACION`);

--
-- Indices de la tabla `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `nota_estudiante_curso`
--
ALTER TABLE `nota_estudiante_curso`
  ADD PRIMARY KEY (`CEDULA`,`ID_NOTA`,`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`),
  ADD KEY `fk_nota_estudiante_curso_2_idx` (`ID_NOTA`),
  ADD KEY `fk_nota_estudiante_curso_3_idx` (`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `noticia_imagen`
--
ALTER TABLE `noticia_imagen`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_noticia_imagen_idx` (`ID_NOTICIA`);

--
-- Indices de la tabla `noticia_profesor_curso`
--
ALTER TABLE `noticia_profesor_curso`
  ADD PRIMARY KEY (`ID_NOTICIA`,`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`),
  ADD KEY `fk_noticia_profesor_curso_2_idx` (`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`);

--
-- Indices de la tabla `noticia_video`
--
ALTER TABLE `noticia_video`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_noticia_video_idx` (`ID_NOTICIA`);

--
-- Indices de la tabla `profesor_curso`
--
ALTER TABLE `profesor_curso`
  ADD PRIMARY KEY (`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`),
  ADD KEY `fk_profesor_curso_2_idx` (`ID_CURSO`,`ID_HORARIO`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `NOMBRE_UNIQUE` (`NOMBRE`);

--
-- Indices de la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `TAREA_XML_NAME_UNIQUE` (`TAREA_XML_NAME`);

--
-- Indices de la tabla `tarea_profesor_curso`
--
ALTER TABLE `tarea_profesor_curso`
  ADD PRIMARY KEY (`ID_TAREA`,`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`),
  ADD KEY `fk_tarea_profesor_curso_2_idx` (`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`);

--
-- Indices de la tabla `tarea_respuesta`
--
ALTER TABLE `tarea_respuesta`
  ADD PRIMARY KEY (`CEDULA`,`ID_TAREA`,`ID_HORARIO`,`ID_CURSO`,`ID_PROFESOR`),
  ADD KEY `fk_tarea_respuesta_2_idx` (`ID_TAREA`,`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `USER_UNIQUE` (`USER`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`ID_USUARIO`,`ID_ROL`),
  ADD KEY `fk_usuario_rol_2_idx` (`ID_ROL`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticia_imagen`
--
ALTER TABLE `noticia_imagen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticia_video`
--
ALTER TABLE `noticia_video`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `curso_horario`
--
ALTER TABLE `curso_horario`
  ADD CONSTRAINT `fk_curso_horario_1` FOREIGN KEY (`ID_CURSO`) REFERENCES `curso` (`CODIGO`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_curso_horario_2` FOREIGN KEY (`ID_HORARIO`) REFERENCES `horario` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleado_usuario` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_estudiante_encargado` FOREIGN KEY (`ID_ENCARGADO`) REFERENCES `encargado` (`CEDULA`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estudiante_usuario` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `estudiante_curso`
--
ALTER TABLE `estudiante_curso`
  ADD CONSTRAINT `fk_estudiante_curso_1` FOREIGN KEY (`CEDULA`) REFERENCES `estudiante` (`CEDULA`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estudiante_curso_2` FOREIGN KEY (`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`) REFERENCES `profesor_curso` (`ID_PROFESOR`, `ID_CURSO`, `ID_HORARIO`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `nota_estudiante_curso`
--
ALTER TABLE `nota_estudiante_curso`
  ADD CONSTRAINT `fk_nota_estudiante_curso_1` FOREIGN KEY (`CEDULA`) REFERENCES `estudiante` (`CEDULA`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota_estudiante_curso_2` FOREIGN KEY (`ID_NOTA`) REFERENCES `nota` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota_estudiante_curso_3` FOREIGN KEY (`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`) REFERENCES `profesor_curso` (`ID_PROFESOR`, `ID_CURSO`, `ID_HORARIO`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `noticia_imagen`
--
ALTER TABLE `noticia_imagen`
  ADD CONSTRAINT `fk_noticia_imagen` FOREIGN KEY (`ID_NOTICIA`) REFERENCES `noticia` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `noticia_profesor_curso`
--
ALTER TABLE `noticia_profesor_curso`
  ADD CONSTRAINT `fk_noticia_profesor_curso_1` FOREIGN KEY (`ID_NOTICIA`) REFERENCES `noticia` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_noticia_profesor_curso_2` FOREIGN KEY (`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`) REFERENCES `profesor_curso` (`ID_PROFESOR`, `ID_CURSO`, `ID_HORARIO`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `noticia_video`
--
ALTER TABLE `noticia_video`
  ADD CONSTRAINT `fk_noticia_video` FOREIGN KEY (`ID_NOTICIA`) REFERENCES `noticia` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `profesor_curso`
--
ALTER TABLE `profesor_curso`
  ADD CONSTRAINT `fk_profesor_curso_1` FOREIGN KEY (`ID_PROFESOR`) REFERENCES `empleado` (`CEDULA`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_profesor_curso_2` FOREIGN KEY (`ID_CURSO`,`ID_HORARIO`) REFERENCES `curso_horario` (`ID_CURSO`, `ID_HORARIO`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tarea_profesor_curso`
--
ALTER TABLE `tarea_profesor_curso`
  ADD CONSTRAINT `fk_tarea_profesor_curso_1` FOREIGN KEY (`ID_TAREA`) REFERENCES `tarea` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tarea_profesor_curso_2` FOREIGN KEY (`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`) REFERENCES `profesor_curso` (`ID_PROFESOR`, `ID_CURSO`, `ID_HORARIO`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tarea_respuesta`
--
ALTER TABLE `tarea_respuesta`
  ADD CONSTRAINT `fk_tarea_respuesta_1` FOREIGN KEY (`CEDULA`) REFERENCES `estudiante` (`CEDULA`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tarea_respuesta_2` FOREIGN KEY (`ID_TAREA`,`ID_PROFESOR`,`ID_CURSO`,`ID_HORARIO`) REFERENCES `tarea_profesor_curso` (`ID_TAREA`, `ID_PROFESOR`, `ID_CURSO`, `ID_HORARIO`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `fk_usuario_rol_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_rol_2` FOREIGN KEY (`ID_ROL`) REFERENCES `rol` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
