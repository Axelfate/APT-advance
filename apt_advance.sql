-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-07-2017 a las 01:08:43
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `apt_advance_pr`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `idDepartamento` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `localizacion` int(11) DEFAULT NULL,
  `encargado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`idDepartamento`, `nombre`, `localizacion`, `encargado`) VALUES
(1, 'Tecnologias de la informacion', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `idNota` int(11) NOT NULL,
  `nota` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `idStatus` int(11) NOT NULL,
  `status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`idStatus`, `status`) VALUES
(1, 'Iniciado'),
(2, 'Cancelado'),
(3, 'Alerta'),
(4, 'Vencido'),
(5, 'Concluido'),
(6, 'Revision');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE `tarea` (
  `idTarea` int(20) NOT NULL,
  `descripcion_corta` varchar(50) NOT NULL,
  `descripcion_larga` varchar(300) NOT NULL,
  `ubicacion` int(11) DEFAULT NULL,
  `asignado_a` int(11) DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `notas` int(11) DEFAULT NULL,
  `departamento_asignado` int(11) DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_propuesta_fin` date NOT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `idTipo` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`idTipo`, `tipo`) VALUES
(1, 'Gerente'),
(2, 'Jefe departamento'),
(3, 'Ingeniero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `idUbicacion` int(11) NOT NULL,
  `hotel` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`idUbicacion`, `hotel`, `pais`, `estado`, `direccion`) VALUES
(1, 'CEDIS palace', 'Mexico', 'Quintana Roo', 'Km 19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `establecimiento` int(11) DEFAULT NULL,
  `pertenece_departamento` int(11) DEFAULT NULL,
  `password` varchar(20) NOT NULL,
  `cargo` int(11) DEFAULT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombres`, `apellidos`, `establecimiento`, `pertenece_departamento`, `password`, `cargo`, `username`) VALUES
(1, 'Mario', 'Olarte', 1, 1, 'molarte', 1, 'molarte'),
(2, 'Mario', 'Olarte', 1, 1, 'molarte', 1, 'molarte');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`idDepartamento`),
  ADD KEY `localizacion` (`localizacion`),
  ADD KEY `encargado` (`encargado`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`idNota`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`idStatus`);

--
-- Indices de la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`idTarea`),
  ADD KEY `asignado_a` (`asignado_a`),
  ADD KEY `creado_por` (`creado_por`),
  ADD KEY `notas` (`notas`),
  ADD KEY `departamento_asignado` (`departamento_asignado`),
  ADD KEY `estado` (`estado`),
  ADD KEY `ubicacion` (`ubicacion`);

--
-- Indices de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`idUbicacion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `establecimiento` (`establecimiento`),
  ADD KEY `pertenece_departamento` (`pertenece_departamento`),
  ADD KEY `cargo` (`cargo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `idNota` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `idStatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `idTarea` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `idUbicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `departamento_ibfk_1` FOREIGN KEY (`localizacion`) REFERENCES `ubicacion` (`idUbicacion`),
  ADD CONSTRAINT `departamento_ibfk_2` FOREIGN KEY (`encargado`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD CONSTRAINT `tarea_ibfk_1` FOREIGN KEY (`asignado_a`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `tarea_ibfk_2` FOREIGN KEY (`creado_por`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `tarea_ibfk_3` FOREIGN KEY (`notas`) REFERENCES `notas` (`idNota`),
  ADD CONSTRAINT `tarea_ibfk_4` FOREIGN KEY (`departamento_asignado`) REFERENCES `departamento` (`idDepartamento`),
  ADD CONSTRAINT `tarea_ibfk_5` FOREIGN KEY (`estado`) REFERENCES `status` (`idStatus`),
  ADD CONSTRAINT `tarea_ibfk_6` FOREIGN KEY (`ubicacion`) REFERENCES `ubicacion` (`idUbicacion`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`establecimiento`) REFERENCES `ubicacion` (`idUbicacion`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`pertenece_departamento`) REFERENCES `departamento` (`idDepartamento`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`cargo`) REFERENCES `tipousuario` (`idTipo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
