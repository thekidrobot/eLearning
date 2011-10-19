# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.12
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-10-19 18:35:38
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping structure for table evaluaciones.administrador
DROP TABLE IF EXISTS `administrador`;
CREATE TABLE IF NOT EXISTS `administrador` (
  `IdAdministrador` int(11) NOT NULL AUTO_INCREMENT,
  `Login` varchar(100) DEFAULT NULL,
  `Clave` longtext,
  PRIMARY KEY (`IdAdministrador`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.administrador: 1 rows
DELETE FROM `administrador`;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` (`IdAdministrador`, `Login`, `Clave`) VALUES
	(1, 'andres', '16d7a4fca7442dda3ad93c9a726597e4');
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;


# Dumping structure for table evaluaciones.archivos_videos
DROP TABLE IF EXISTS `archivos_videos`;
CREATE TABLE IF NOT EXISTS `archivos_videos` (
  `IdArchivo` int(11) NOT NULL AUTO_INCREMENT,
  `IdVideo` int(11) DEFAULT NULL,
  `NombreArchivo` varchar(255) DEFAULT NULL,
  UNIQUE KEY `IdArchivo` (`IdArchivo`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.archivos_videos: 1 rows
DELETE FROM `archivos_videos`;
/*!40000 ALTER TABLE `archivos_videos` DISABLE KEYS */;
INSERT INTO `archivos_videos` (`IdArchivo`, `IdVideo`, `NombreArchivo`) VALUES
	(16, 15, 'Lopital.doc');
/*!40000 ALTER TABLE `archivos_videos` ENABLE KEYS */;


# Dumping structure for table evaluaciones.categorias
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `IdCategorias` int(11) NOT NULL AUTO_INCREMENT,
  `categorias` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`IdCategorias`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.categorias: 1 rows
DELETE FROM `categorias`;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` (`IdCategorias`, `categorias`) VALUES
	(10, 'Categoria 1');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;


# Dumping structure for table evaluaciones.departamentos
DROP TABLE IF EXISTS `departamentos`;
CREATE TABLE IF NOT EXISTS `departamentos` (
  `IdDepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `NomDepartamento` varchar(255) NOT NULL,
  PRIMARY KEY (`IdDepartamento`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.departamentos: 1 rows
DELETE FROM `departamentos`;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` (`IdDepartamento`, `NomDepartamento`) VALUES
	(16, 'Grupo 1');
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;


# Dumping structure for table evaluaciones.departamentos_usuarios
DROP TABLE IF EXISTS `departamentos_usuarios`;
CREATE TABLE IF NOT EXISTS `departamentos_usuarios` (
  `IdUsuario` int(11) NOT NULL,
  `IdDepartamento` int(11) NOT NULL,
  PRIMARY KEY (`IdUsuario`,`IdDepartamento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.departamentos_usuarios: 2 rows
DELETE FROM `departamentos_usuarios`;
/*!40000 ALTER TABLE `departamentos_usuarios` DISABLE KEYS */;
INSERT INTO `departamentos_usuarios` (`IdUsuario`, `IdDepartamento`) VALUES
	(38, 16),
	(39, 16);
/*!40000 ALTER TABLE `departamentos_usuarios` ENABLE KEYS */;


# Dumping structure for table evaluaciones.grupos
DROP TABLE IF EXISTS `grupos`;
CREATE TABLE IF NOT EXISTS `grupos` (
  `IdGrupos` int(11) NOT NULL AUTO_INCREMENT,
  `grupos` varchar(250) DEFAULT NULL,
  `IdCategorias` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdGrupos`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.grupos: 4 rows
DELETE FROM `grupos`;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` (`IdGrupos`, `grupos`, `IdCategorias`) VALUES
	(1, 'Basico', 1),
	(2, 'Intermedio', 1),
	(3, 'Avanzado', 1),
	(8, 'Grupo1', 10);
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;


# Dumping structure for table evaluaciones.livechat
DROP TABLE IF EXISTS `livechat`;
CREATE TABLE IF NOT EXISTS `livechat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `comentario` varchar(500) NOT NULL,
  `leido` varchar(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.livechat: 6 rows
DELETE FROM `livechat`;
/*!40000 ALTER TABLE `livechat` DISABLE KEYS */;
INSERT INTO `livechat` (`id`, `Nombre`, `mail`, `comentario`, `leido`, `fecha`) VALUES
	(1, 'victor', 'v@.com', 'bla bla bla bla', '0', '2011-03-12 00:45:50'),
	(2, 'vicic', 'v@.com', 'asdfadf', '0', '2011-03-12 00:45:50'),
	(3, 'vic', 'v@.com', 'otra', '0', '2011-03-12 00:45:50'),
	(4, 'vic de nuevo', 'vzdcq@.com', 'otra vez esta pregunta istrionica de contenidos alarmantes sicnronizantes con dominio publico de inercaia', '0', '2011-03-12 00:45:50'),
	(5, 'victor de nievo', 'v@.com', 'estÃ¡ habiliÃ¡do las t\'ildes Ã³n?', '0', '2011-03-12 00:45:50'),
	(6, 'victor de nuevi', 'v@.com', 'estás si ón á é', '0', '2011-03-12 00:45:50');
/*!40000 ALTER TABLE `livechat` ENABLE KEYS */;


# Dumping structure for table evaluaciones.modo
DROP TABLE IF EXISTS `modo`;
CREATE TABLE IF NOT EXISTS `modo` (
  `IdModo` int(11) NOT NULL AUTO_INCREMENT,
  `DetalleModo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdModo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.modo: 0 rows
DELETE FROM `modo`;
/*!40000 ALTER TABLE `modo` DISABLE KEYS */;
/*!40000 ALTER TABLE `modo` ENABLE KEYS */;


# Dumping structure for table evaluaciones.modulos
DROP TABLE IF EXISTS `modulos`;
CREATE TABLE IF NOT EXISTS `modulos` (
  `IdModulo` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` longtext,
  `Calificacion` int(11) DEFAULT '0',
  `Idvideo` int(11) DEFAULT NULL,
  `CalificacionMinima` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`IdModulo`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.modulos: 8 rows
DELETE FROM `modulos`;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` (`IdModulo`, `Titulo`, `Calificacion`, `Idvideo`, `CalificacionMinima`, `estado`) VALUES
	(1, 'titilo', 5, 5, 3, 1),
	(2, 'titulo', 5, 8, 3, 1),
	(3, 'test', 5, 6, 1, 1),
	(5, 'Word1', 10, 13, 8, 1),
	(6, 'Word1', 10, 14, 8, 1),
	(9, 'Titulo1', 10, 15, 8, 1),
	(8, 'Titulo1', 10, 12, 8, 1),
	(10, 'Cuestionario_Grupo1', 10, 22, 8, 1);
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;


# Dumping structure for table evaluaciones.permisos_departamentos
DROP TABLE IF EXISTS `permisos_departamentos`;
CREATE TABLE IF NOT EXISTS `permisos_departamentos` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `IdDepartamento` int(11) DEFAULT NULL,
  `IdCategorias` int(11) DEFAULT NULL,
  `IdGrupos` int(11) DEFAULT NULL,
  `IdSubGrupo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpermiso`),
  UNIQUE KEY `idpermiso` (`idpermiso`)
) ENGINE=MyISAM AUTO_INCREMENT=384 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.permisos_departamentos: 14 rows
DELETE FROM `permisos_departamentos`;
/*!40000 ALTER TABLE `permisos_departamentos` DISABLE KEYS */;
INSERT INTO `permisos_departamentos` (`idpermiso`, `IdDepartamento`, `IdCategorias`, `IdGrupos`, `IdSubGrupo`) VALUES
	(381, 15, NULL, NULL, 8),
	(380, 15, NULL, 7, NULL),
	(379, 15, 5, NULL, NULL),
	(378, 15, NULL, NULL, 6),
	(377, 15, NULL, 6, NULL),
	(376, 15, 4, NULL, NULL),
	(375, 3, NULL, NULL, 8),
	(374, 3, NULL, 7, NULL),
	(360, 14, NULL, NULL, 6),
	(359, 14, NULL, 6, NULL),
	(358, 14, 4, NULL, NULL),
	(373, 3, 5, NULL, NULL),
	(382, 16, 10, NULL, NULL),
	(383, 16, NULL, 8, NULL);
/*!40000 ALTER TABLE `permisos_departamentos` ENABLE KEYS */;


# Dumping structure for table evaluaciones.permisos_usuarios
DROP TABLE IF EXISTS `permisos_usuarios`;
CREATE TABLE IF NOT EXISTS `permisos_usuarios` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) DEFAULT NULL,
  `IdCategorias` int(11) DEFAULT NULL,
  `IdGrupos` int(11) DEFAULT NULL,
  `IdSubGrupo` int(11) DEFAULT NULL,
  `IdDepartamento` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpermiso`),
  UNIQUE KEY `idpermiso` (`idpermiso`)
) ENGINE=MyISAM AUTO_INCREMENT=1209 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.permisos_usuarios: 4 rows
DELETE FROM `permisos_usuarios`;
/*!40000 ALTER TABLE `permisos_usuarios` DISABLE KEYS */;
INSERT INTO `permisos_usuarios` (`idpermiso`, `IdUsuario`, `IdCategorias`, `IdGrupos`, `IdSubGrupo`, `IdDepartamento`) VALUES
	(1208, 39, NULL, 8, NULL, 16),
	(1207, 39, 10, NULL, NULL, 16),
	(1206, 38, NULL, 8, NULL, 16),
	(1205, 38, 10, NULL, NULL, 16);
/*!40000 ALTER TABLE `permisos_usuarios` ENABLE KEYS */;


# Dumping structure for table evaluaciones.preguntas
DROP TABLE IF EXISTS `preguntas`;
CREATE TABLE IF NOT EXISTS `preguntas` (
  `IdPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `IdModulo` int(11) DEFAULT '0',
  `DetallePregunta` longtext,
  PRIMARY KEY (`IdPregunta`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.preguntas: 9 rows
DELETE FROM `preguntas`;
/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */;
INSERT INTO `preguntas` (`IdPregunta`, `IdModulo`, `DetallePregunta`) VALUES
	(1, 1, 'pregunta 1'),
	(2, 1, 'pregunta 1'),
	(3, 2, 'pregunta 1'),
	(4, 2, 'pregunta 2'),
	(5, 3, 'es ok'),
	(6, 3, 'es ok2'),
	(7, 3, 'ok3'),
	(8, 5, 'Pregunta 1'),
	(9, 6, 'pregunta 1');
/*!40000 ALTER TABLE `preguntas` ENABLE KEYS */;


# Dumping structure for table evaluaciones.respuesta
DROP TABLE IF EXISTS `respuesta`;
CREATE TABLE IF NOT EXISTS `respuesta` (
  `IdRespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `IdPregunta` int(11) DEFAULT '0',
  `DetalleRespuesta` longtext,
  `Correcta` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`IdRespuesta`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.respuesta: 12 rows
DELETE FROM `respuesta`;
/*!40000 ALTER TABLE `respuesta` DISABLE KEYS */;
INSERT INTO `respuesta` (`IdRespuesta`, `IdPregunta`, `DetalleRespuesta`, `Correcta`) VALUES
	(1, 1, 'fdgfgssss', 1),
	(2, 1, 'dffgfgdgfg', 0),
	(3, 1, 'fgfgf d  fg ', 0),
	(4, 3, 'respuesta si es', 1),
	(5, 3, 'respuesta no es', 0),
	(6, 4, 'respuesta 1 pregunta 2', 1),
	(7, 4, 'respuesta 2 pregunta 2 esta no', 0),
	(8, 5, 'ok', 1),
	(9, 6, 'ok', 1),
	(10, 7, 'ok3', 1),
	(11, 8, 'respuesta 1', 1),
	(12, 9, 'respuesta 1', 1);
/*!40000 ALTER TABLE `respuesta` ENABLE KEYS */;


# Dumping structure for table evaluaciones.resultadoexamen
DROP TABLE IF EXISTS `resultadoexamen`;
CREATE TABLE IF NOT EXISTS `resultadoexamen` (
  `IdResultado` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) DEFAULT '0',
  `IdModulo` int(11) DEFAULT '0',
  `NotaObtenida` float DEFAULT NULL,
  `Fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `NotaBase` float DEFAULT NULL,
  `NotaMinima` float DEFAULT NULL,
  PRIMARY KEY (`IdResultado`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.resultadoexamen: 27 rows
DELETE FROM `resultadoexamen`;
/*!40000 ALTER TABLE `resultadoexamen` DISABLE KEYS */;
INSERT INTO `resultadoexamen` (`IdResultado`, `IdUsuario`, `IdModulo`, `NotaObtenida`, `Fecha`, `NotaBase`, `NotaMinima`) VALUES
	(1, 1, 2, 5, '2010-07-09 01:30:00', 5, 3),
	(2, 1, 2, 2.5, '2010-07-09 01:30:00', 5, 3),
	(3, 1, 2, 5, '2010-07-09 01:30:00', 5, 3),
	(4, 1, 2, 0, '2010-07-09 01:30:00', 5, 3),
	(5, 1, 1, 2.5, '2010-07-09 01:30:00', 5, 3),
	(6, 1, 1, 2.5, '2010-08-09 12:28:47', 5, 3),
	(7, 1, 1, 0, '2010-08-09 12:28:52', 5, 3),
	(8, 1, 1, 0, '2010-08-09 12:30:35', 5, 3),
	(9, 1, 1, 0, '2010-08-09 12:35:21', 5, 3),
	(10, 1, 3, 5, '2010-08-09 12:39:57', 5, 1),
	(11, 1, 3, 0, '2010-08-09 12:40:03', 5, 1),
	(12, 1, 1, 0, '2010-08-09 12:44:07', 5, 3),
	(13, 1, 3, 5, '2010-08-09 12:47:12', 5, 1),
	(14, 1, 3, 5, '2010-08-09 12:47:38', 5, 1),
	(15, 1, 3, 5, '2010-08-09 12:48:03', 5, 1),
	(16, 1, 2, 5, '2010-08-16 13:36:01', 5, 3),
	(17, 1, 2, 5, '2010-08-16 13:36:22', 5, 3),
	(18, 1, 2, 0, '2010-08-16 13:36:29', 5, 3),
	(19, 1, 3, 5, '2010-08-16 13:37:16', 5, 1),
	(20, 1, 2, 5, '2010-08-16 13:44:01', 5, 3),
	(21, 1, 2, 0, '2010-08-16 13:44:05', 5, 3),
	(22, 1, 2, 5, '2010-08-16 13:48:32', 5, 3),
	(23, 7, 4, 0, '2010-08-27 21:29:50', 10, 8),
	(24, 3, 5, 10, '2010-08-28 17:34:59', 10, 8),
	(25, 7, 7, 0, '2010-08-31 21:42:13', 10, 8),
	(26, 7, 7, 10, '2010-09-23 08:32:16', 10, 8),
	(27, 7, 7, 0, '2010-09-23 09:04:24', 10, 8);
/*!40000 ALTER TABLE `resultadoexamen` ENABLE KEYS */;


# Dumping structure for table evaluaciones.subgrupos
DROP TABLE IF EXISTS `subgrupos`;
CREATE TABLE IF NOT EXISTS `subgrupos` (
  `IdSubGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSubGrupo` longtext,
  `estado` tinyint(1) DEFAULT '1',
  `IdGrupos` int(5) DEFAULT NULL,
  PRIMARY KEY (`IdSubGrupo`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.subgrupos: 2 rows
DELETE FROM `subgrupos`;
/*!40000 ALTER TABLE `subgrupos` DISABLE KEYS */;
INSERT INTO `subgrupos` (`IdSubGrupo`, `NombreSubGrupo`, `estado`, `IdGrupos`) VALUES
	(1, 'basico 1', 1, 1),
	(2, 'basico 2', 1, 1);
/*!40000 ALTER TABLE `subgrupos` ENABLE KEYS */;


# Dumping structure for table evaluaciones.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(100) DEFAULT NULL,
  `Password` longtext,
  `NombreCompleto` varchar(255) DEFAULT NULL,
  `Empresa` varchar(20) DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `FechaCreacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.usuarios: 1 rows
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`IdUsuario`, `Usuario`, `Password`, `NombreCompleto`, `Empresa`, `Correo`, `FechaCreacion`) VALUES
	(7, 'andgonzalez81@yahoo.com', '16d7a4fca7442dda3ad93c9a726597e4', 'Gonzo Vargas', 'Technology11', 'andgonzalez81@yahoo.com', '2011-08-30 15:28:58');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;


# Dumping structure for table evaluaciones.videos
DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `Idvideo` int(11) NOT NULL AUTO_INCREMENT,
  `UrlVideo` longtext,
  `estado` tinyint(1) DEFAULT '1',
  `IdSubGrupo` int(5) DEFAULT NULL,
  `IdGrupos` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `visita` int(11) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `duracion` varchar(50) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `presentador` varchar(255) DEFAULT NULL,
  `urlpic` varchar(255) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  PRIMARY KEY (`Idvideo`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.videos: 1 rows
DELETE FROM `videos`;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` (`Idvideo`, `UrlVideo`, `estado`, `IdSubGrupo`, `IdGrupos`, `fecha`, `visita`, `nombre`, `duracion`, `descripcion`, `presentador`, `urlpic`, `orden`) VALUES
	(22, 'www.google.com', 1, NULL, 8, '0000-00-00', 0, 'VideoGrupo1', '10min', 'VideoGrupo1', 'Yo no se', NULL, 1);
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;


# Dumping structure for table evaluaciones.videosvistos
DROP TABLE IF EXISTS `videosvistos`;
CREATE TABLE IF NOT EXISTS `videosvistos` (
  `idvistovideo` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) DEFAULT NULL,
  `Idvideo` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idvistovideo`),
  UNIQUE KEY `idvistovideo` (`idvistovideo`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

# Dumping data for table evaluaciones.videosvistos: 1 rows
DELETE FROM `videosvistos`;
/*!40000 ALTER TABLE `videosvistos` DISABLE KEYS */;
INSERT INTO `videosvistos` (`idvistovideo`, `IdUsuario`, `Idvideo`, `fecha`) VALUES
	(68, 7, 22, '2011-09-02 15:27:45');
/*!40000 ALTER TABLE `videosvistos` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
