-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-12-2021 a las 19:51:40
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `connective`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id_comentario` int(11) NOT NULL,
  `id_tema` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `correo_institucional` varchar(100) DEFAULT NULL,
  `fecha_publicacion_comentario` text NOT NULL,
  `usuario_comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario_destacado`
--

CREATE TABLE `comentario_destacado` (
  `id_comentario` int(11) NOT NULL,
  `usuario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `nombre` text DEFAULT NULL,
  `apellido_p` text DEFAULT NULL,
  `apellido_m` text DEFAULT NULL,
  `carrera` text DEFAULT NULL,
  `usuario` varchar(30) NOT NULL DEFAULT '',
  `matricula` varchar(11) NOT NULL,
  `correo_institucional` varchar(100) NOT NULL,
  `contraseña` varchar(16) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `plantel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `karma`
--

CREATE TABLE `karma` (
  `id_tema` int(11) NOT NULL,
  `correo_institucional` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id_respuesta` bigint(20) NOT NULL,
  `id_comentario` int(11) NOT NULL,
  `usuario_respuesta` text NOT NULL,
  `respuesta` text NOT NULL,
  `fecha_publicacion_respuesta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE `tema` (
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `simpatizantes` int(11) DEFAULT NULL,
  `id_tema` int(11) NOT NULL,
  `correo_institucional` varchar(100) NOT NULL,
  `solucion` tinyint(1) DEFAULT NULL,
  `fecha_publicacion` text NOT NULL,
  `etiqueta` text NOT NULL,
  `color` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario` varchar(30) NOT NULL,
  `contraseña` text DEFAULT NULL,
  `salt` text DEFAULT NULL,
  `creacion` datetime DEFAULT NULL,
  `hora_entrada` datetime DEFAULT NULL,
  `hora_salida` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `ubicar_comentarios` (`id_tema`,`correo_institucional`),
  ADD KEY `correoInstitucionalComentario` (`correo_institucional`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`usuario`,`matricula`,`correo_institucional`),
  ADD UNIQUE KEY `matricula` (`matricula`,`correo_institucional`),
  ADD KEY `correo_institucional` (`correo_institucional`);

--
-- Indices de la tabla `karma`
--
ALTER TABLE `karma`
  ADD PRIMARY KEY (`id_tema`,`correo_institucional`),
  ADD KEY `karmas` (`id_tema`),
  ADD KEY `correoInstitucional` (`correo_institucional`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id_respuesta`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id_tema`,`correo_institucional`),
  ADD KEY `ubicacion_temas` (`correo_institucional`,`id_tema`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id_respuesta` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `correoInstitucionalComentario` FOREIGN KEY (`correo_institucional`) REFERENCES `estudiante` (`correo_institucional`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTemaComentario` FOREIGN KEY (`id_tema`) REFERENCES `tema` (`id_tema`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `karma`
--
ALTER TABLE `karma`
  ADD CONSTRAINT `correoInstitucional` FOREIGN KEY (`correo_institucional`) REFERENCES `estudiante` (`correo_institucional`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTema` FOREIGN KEY (`id_tema`) REFERENCES `tema` (`id_tema`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tema`
--
ALTER TABLE `tema`
  ADD CONSTRAINT `correoInstitucionalTema` FOREIGN KEY (`correo_institucional`) REFERENCES `estudiante` (`correo_institucional`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario` FOREIGN KEY (`usuario`) REFERENCES `estudiante` (`usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
