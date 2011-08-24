/*
SQLyog Community v8.7 
MySQL - 5.1.49-1ubuntu8.1 : Database - evaluaciones
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`evaluaciones` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `evaluaciones`;

/*Table structure for table `administrador` */

DROP TABLE IF EXISTS `administrador`;

CREATE TABLE `administrador` (
  `IdAdministrador` int(11) NOT NULL AUTO_INCREMENT,
  `Login` varchar(100) DEFAULT NULL,
  `Clave` longtext,
  PRIMARY KEY (`IdAdministrador`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `administrador` */

insert  into `administrador`(`IdAdministrador`,`Login`,`Clave`) values (1,'andres','test');

/*Table structure for table `archivos_videos` */

DROP TABLE IF EXISTS `archivos_videos`;

CREATE TABLE `archivos_videos` (
  `IdArchivo` int(11) NOT NULL AUTO_INCREMENT,
  `IdVideo` int(11) DEFAULT NULL,
  `NombreArchivo` varchar(255) DEFAULT NULL,
  UNIQUE KEY `IdArchivo` (`IdArchivo`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `archivos_videos` */

insert  into `archivos_videos`(`IdArchivo`,`IdVideo`,`NombreArchivo`) values (16,15,'Lopital.doc');

/*Table structure for table `categorias` */

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `IdCategorias` int(11) NOT NULL AUTO_INCREMENT,
  `categorias` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`IdCategorias`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `categorias` */

insert  into `categorias`(`IdCategorias`,`categorias`) values (4,'categoria1'),(5,'categoria2');

/*Table structure for table `departamentos` */

DROP TABLE IF EXISTS `departamentos`;

CREATE TABLE `departamentos` (
  `IdDepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `NomDepartamento` varchar(255) NOT NULL,
  PRIMARY KEY (`IdDepartamento`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `departamentos` */

insert  into `departamentos`(`IdDepartamento`,`NomDepartamento`) values (1,'Ventas'),(3,'Contabilidad'),(15,'Dep2'),(14,'Dep1');

/*Table structure for table `departamentos_usuarios` */

DROP TABLE IF EXISTS `departamentos_usuarios`;

CREATE TABLE `departamentos_usuarios` (
  `IdUsuario` int(11) NOT NULL,
  `IdDepartamento` int(11) NOT NULL,
  PRIMARY KEY (`IdUsuario`,`IdDepartamento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `departamentos_usuarios` */

insert  into `departamentos_usuarios`(`IdUsuario`,`IdDepartamento`) values (3,1),(3,3),(7,3),(7,14),(12,1),(12,3),(13,1),(13,3),(14,1),(14,3),(15,1),(15,3),(16,1),(16,3),(17,1),(18,1),(18,3),(19,1),(27,1),(27,3),(28,3),(29,3),(30,3),(31,3),(32,1),(32,3),(33,1),(33,3);

/*Table structure for table `grupos` */

DROP TABLE IF EXISTS `grupos`;

CREATE TABLE `grupos` (
  `IdGrupos` int(11) NOT NULL AUTO_INCREMENT,
  `grupos` varchar(250) DEFAULT NULL,
  `IdCategorias` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdGrupos`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `grupos` */

insert  into `grupos`(`IdGrupos`,`grupos`,`IdCategorias`) values (1,'Basico',1),(2,'Intermedio',1),(3,'Avanzado',1),(6,'grupo1',4),(7,'grupo2',5);

/*Table structure for table `livechat` */

DROP TABLE IF EXISTS `livechat`;

CREATE TABLE `livechat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `comentario` varchar(500) NOT NULL,
  `leido` varchar(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `livechat` */

insert  into `livechat`(`id`,`Nombre`,`mail`,`comentario`,`leido`,`fecha`) values (1,'victor','v@.com','bla bla bla bla','0','2011-03-12 00:45:50'),(2,'vicic','v@.com','asdfadf','0','2011-03-12 00:45:50'),(3,'vic','v@.com','otra','0','2011-03-12 00:45:50'),(4,'vic de nuevo','vzdcq@.com','otra vez esta pregunta istrionica de contenidos alarmantes sicnronizantes con dominio publico de inercaia','0','2011-03-12 00:45:50'),(5,'victor de nievo','v@.com','estÃ¡ habiliÃ¡do las t\'ildes Ã³n?','0','2011-03-12 00:45:50'),(6,'victor de nuevi','v@.com','estás si ón á é','0','2011-03-12 00:45:50');

/*Table structure for table `modo` */

DROP TABLE IF EXISTS `modo`;

CREATE TABLE `modo` (
  `IdModo` int(11) NOT NULL AUTO_INCREMENT,
  `DetalleModo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdModo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `modo` */

/*Table structure for table `modulos` */

DROP TABLE IF EXISTS `modulos`;

CREATE TABLE `modulos` (
  `IdModulo` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` longtext,
  `Calificacion` int(11) DEFAULT '0',
  `Idvideo` int(11) DEFAULT NULL,
  `CalificacionMinima` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`IdModulo`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `modulos` */

insert  into `modulos`(`IdModulo`,`Titulo`,`Calificacion`,`Idvideo`,`CalificacionMinima`,`estado`) values (1,'titilo',5,5,3,1),(2,'titulo',5,8,3,1),(3,'test',5,6,1,1),(5,'Word1',10,13,8,1),(6,'Word1',10,14,8,1),(9,'Titulo1',10,15,8,1),(8,'Titulo1',10,12,8,1);

/*Table structure for table `permisos_departamentos` */

DROP TABLE IF EXISTS `permisos_departamentos`;

CREATE TABLE `permisos_departamentos` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `IdDepartamento` int(11) DEFAULT NULL,
  `IdCategorias` int(11) DEFAULT NULL,
  `IdGrupos` int(11) DEFAULT NULL,
  `IdSubGrupo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpermiso`),
  UNIQUE KEY `idpermiso` (`idpermiso`)
) ENGINE=MyISAM AUTO_INCREMENT=382 DEFAULT CHARSET=utf8;

/*Data for the table `permisos_departamentos` */

insert  into `permisos_departamentos`(`idpermiso`,`IdDepartamento`,`IdCategorias`,`IdGrupos`,`IdSubGrupo`) values (381,15,NULL,NULL,8),(380,15,NULL,7,NULL),(379,15,5,NULL,NULL),(378,15,NULL,NULL,6),(377,15,NULL,6,NULL),(376,15,4,NULL,NULL),(375,3,NULL,NULL,8),(374,3,NULL,7,NULL),(360,14,NULL,NULL,6),(359,14,NULL,6,NULL),(358,14,4,NULL,NULL),(373,3,5,NULL,NULL);

/*Table structure for table `permisos_usuarios` */

DROP TABLE IF EXISTS `permisos_usuarios`;

CREATE TABLE `permisos_usuarios` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) DEFAULT NULL,
  `IdCategorias` int(11) DEFAULT NULL,
  `IdGrupos` int(11) DEFAULT NULL,
  `IdSubGrupo` int(11) DEFAULT NULL,
  `IdDepartamento` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpermiso`),
  UNIQUE KEY `idpermiso` (`idpermiso`)
) ENGINE=MyISAM AUTO_INCREMENT=1199 DEFAULT CHARSET=utf8;

/*Data for the table `permisos_usuarios` */

insert  into `permisos_usuarios`(`idpermiso`,`IdUsuario`,`IdCategorias`,`IdGrupos`,`IdSubGrupo`,`IdDepartamento`) values (1018,7,4,NULL,NULL,14),(1017,7,NULL,6,NULL,14),(1016,7,NULL,NULL,6,14),(1156,3,5,NULL,NULL,3),(1155,3,NULL,7,NULL,3),(1154,3,NULL,NULL,8,3),(1159,7,5,NULL,NULL,3),(1158,7,NULL,7,NULL,3),(1157,7,NULL,NULL,8,3),(1162,12,5,NULL,NULL,3),(1161,12,NULL,7,NULL,3),(1160,12,NULL,NULL,8,3),(1165,13,5,NULL,NULL,3),(1164,13,NULL,7,NULL,3),(1163,13,NULL,NULL,8,3),(1168,14,5,NULL,NULL,3),(1167,14,NULL,7,NULL,3),(1166,14,NULL,NULL,8,3),(1171,15,5,NULL,NULL,3),(1170,15,NULL,7,NULL,3),(1169,15,NULL,NULL,8,3),(1174,16,5,NULL,NULL,3),(1173,16,NULL,7,NULL,3),(1172,16,NULL,NULL,8,3),(1177,18,5,NULL,NULL,3),(1176,18,NULL,7,NULL,3),(1175,18,NULL,NULL,8,3),(1180,27,5,NULL,NULL,3),(1179,27,NULL,7,NULL,3),(1178,27,NULL,NULL,8,3),(1183,28,5,NULL,NULL,3),(1182,28,NULL,7,NULL,3),(1181,28,NULL,NULL,8,3),(1186,29,5,NULL,NULL,3),(1185,29,NULL,7,NULL,3),(1184,29,NULL,NULL,8,3),(1189,30,5,NULL,NULL,3),(1188,30,NULL,7,NULL,3),(1187,30,NULL,NULL,8,3),(1192,31,5,NULL,NULL,3),(1191,31,NULL,7,NULL,3),(1190,31,NULL,NULL,8,3),(1195,32,5,NULL,NULL,3),(1194,32,NULL,7,NULL,3),(1193,32,NULL,NULL,8,3),(1198,33,5,NULL,NULL,3),(1197,33,NULL,7,NULL,3),(1196,33,NULL,NULL,8,3);

/*Table structure for table `preguntas` */

DROP TABLE IF EXISTS `preguntas`;

CREATE TABLE `preguntas` (
  `IdPregunta` int(11) NOT NULL AUTO_INCREMENT,
  `IdModulo` int(11) DEFAULT '0',
  `DetallePregunta` longtext,
  PRIMARY KEY (`IdPregunta`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `preguntas` */

insert  into `preguntas`(`IdPregunta`,`IdModulo`,`DetallePregunta`) values (1,1,'pregunta 1'),(2,1,'pregunta 1'),(3,2,'pregunta 1'),(4,2,'pregunta 2'),(5,3,'es ok'),(6,3,'es ok2'),(7,3,'ok3'),(8,5,'Pregunta 1'),(9,6,'pregunta 1');

/*Table structure for table `respuesta` */

DROP TABLE IF EXISTS `respuesta`;

CREATE TABLE `respuesta` (
  `IdRespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `IdPregunta` int(11) DEFAULT '0',
  `DetalleRespuesta` longtext,
  `Correcta` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`IdRespuesta`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `respuesta` */

insert  into `respuesta`(`IdRespuesta`,`IdPregunta`,`DetalleRespuesta`,`Correcta`) values (1,1,'fdgfgssss',1),(2,1,'dffgfgdgfg',0),(3,1,'fgfgf d  fg ',0),(4,3,'respuesta si es',1),(5,3,'respuesta no es',0),(6,4,'respuesta 1 pregunta 2',1),(7,4,'respuesta 2 pregunta 2 esta no',0),(8,5,'ok',1),(9,6,'ok',1),(10,7,'ok3',1),(11,8,'respuesta 1',1),(12,9,'respuesta 1',1);

/*Table structure for table `resultadoexamen` */

DROP TABLE IF EXISTS `resultadoexamen`;

CREATE TABLE `resultadoexamen` (
  `IdResultado` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) DEFAULT '0',
  `IdModulo` int(11) DEFAULT '0',
  `NotaObtenida` float DEFAULT NULL,
  `Fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `NotaBase` float DEFAULT NULL,
  `NotaMinima` float DEFAULT NULL,
  PRIMARY KEY (`IdResultado`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Data for the table `resultadoexamen` */

insert  into `resultadoexamen`(`IdResultado`,`IdUsuario`,`IdModulo`,`NotaObtenida`,`Fecha`,`NotaBase`,`NotaMinima`) values (1,1,2,5,'2010-07-09 01:30:00',5,3),(2,1,2,2.5,'2010-07-09 01:30:00',5,3),(3,1,2,5,'2010-07-09 01:30:00',5,3),(4,1,2,0,'2010-07-09 01:30:00',5,3),(5,1,1,2.5,'2010-07-09 01:30:00',5,3),(6,1,1,2.5,'2010-08-09 12:28:47',5,3),(7,1,1,0,'2010-08-09 12:28:52',5,3),(8,1,1,0,'2010-08-09 12:30:35',5,3),(9,1,1,0,'2010-08-09 12:35:21',5,3),(10,1,3,5,'2010-08-09 12:39:57',5,1),(11,1,3,0,'2010-08-09 12:40:03',5,1),(12,1,1,0,'2010-08-09 12:44:07',5,3),(13,1,3,5,'2010-08-09 12:47:12',5,1),(14,1,3,5,'2010-08-09 12:47:38',5,1),(15,1,3,5,'2010-08-09 12:48:03',5,1),(16,1,2,5,'2010-08-16 13:36:01',5,3),(17,1,2,5,'2010-08-16 13:36:22',5,3),(18,1,2,0,'2010-08-16 13:36:29',5,3),(19,1,3,5,'2010-08-16 13:37:16',5,1),(20,1,2,5,'2010-08-16 13:44:01',5,3),(21,1,2,0,'2010-08-16 13:44:05',5,3),(22,1,2,5,'2010-08-16 13:48:32',5,3),(23,7,4,0,'2010-08-27 21:29:50',10,8),(24,3,5,10,'2010-08-28 17:34:59',10,8),(25,7,7,0,'2010-08-31 21:42:13',10,8),(26,7,7,10,'2010-09-23 08:32:16',10,8),(27,7,7,0,'2010-09-23 09:04:24',10,8);

/*Table structure for table `subgrupos` */

DROP TABLE IF EXISTS `subgrupos`;

CREATE TABLE `subgrupos` (
  `IdSubGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSubGrupo` longtext,
  `estado` tinyint(1) DEFAULT '1',
  `IdGrupos` int(5) DEFAULT NULL,
  PRIMARY KEY (`IdSubGrupo`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `subgrupos` */

insert  into `subgrupos`(`IdSubGrupo`,`NombreSubGrupo`,`estado`,`IdGrupos`) values (1,'basico 1',1,1),(2,'basico 2',1,1),(6,'subcategoria1',1,6),(8,'subgrupo2',1,7);

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(100) DEFAULT NULL,
  `Password` longtext,
  `NombreCompleto` varchar(255) DEFAULT NULL,
  `Cedula` varchar(20) DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `FechaCreacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Data for the table `usuarios` */

insert  into `usuarios`(`IdUsuario`,`Usuario`,`Password`,`NombreCompleto`,`Cedula`,`Correo`,`FechaCreacion`) values (3,'tats','test','Tatiana Bernon',NULL,NULL,'2011-02-09 20:11:20'),(7,'andres','test','Andres G.','1234567','my@email.net','2011-02-09 20:11:20'),(12,'maritza','test','Maritza Bernon',NULL,NULL,'2011-02-09 20:11:20'),(13,'johann','test','Johann Bernon',NULL,NULL,'2011-02-09 20:11:20'),(14,'roxy','test','Roxy Bernon',NULL,NULL,'2011-02-09 20:11:20'),(15,'rizu','rest','Rizu Bernon',NULL,NULL,'2011-02-09 20:11:20'),(16,'jocelyn','test','Jocelyn Bernon',NULL,NULL,'2011-02-09 20:11:20'),(27,'homero','test','Homero Simpson',NULL,NULL,'2011-02-09 20:11:20'),(33,'cont2','cont2','Contabilidad_2',NULL,NULL,'2011-02-07 22:25:57'),(32,'cont1','cont1','Contabilidad_1',NULL,NULL,'0000-00-00 00:00:00');

/*Table structure for table `videos` */

DROP TABLE IF EXISTS `videos`;

CREATE TABLE `videos` (
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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `videos` */

insert  into `videos`(`Idvideo`,`UrlVideo`,`estado`,`IdSubGrupo`,`IdGrupos`,`fecha`,`visita`,`nombre`,`duracion`,`descripcion`,`presentador`,`urlpic`,`orden`) values (12,'www.video.com',0,6,NULL,'0000-00-00',0,'Video 2','','','','speaker_15.png',1),(11,'www.video.com',1,NULL,6,'0000-00-00',0,'Video 1',NULL,NULL,NULL,'speaker_15.png',2),(16,'www.video.com',1,6,NULL,'0000-00-00',0,'Video 1',NULL,'Blah','Blah Blah','speaker_15.png',1),(18,'www.video.com',1,NULL,6,'0000-00-00',0,'Video 3','10 Minutos','Video 3','Marge Simpson - Gerente de Ventas',NULL,3),(21,'www.video.com',1,NULL,7,'0000-00-00',0,'abba','2 dias','Descripcion del video','Homero Simpson - Gerente de Proyectos',NULL,1);

/*Table structure for table `videosvistos` */

DROP TABLE IF EXISTS `videosvistos`;

CREATE TABLE `videosvistos` (
  `idvistovideo` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) DEFAULT NULL,
  `Idvideo` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idvistovideo`),
  UNIQUE KEY `idvistovideo` (`idvistovideo`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

/*Data for the table `videosvistos` */

insert  into `videosvistos`(`idvistovideo`,`IdUsuario`,`Idvideo`,`fecha`) values (61,7,12,'2011-02-10 23:28:35'),(62,33,21,'2011-02-10 23:38:22'),(63,7,11,'2011-02-13 23:02:59'),(64,7,11,'2011-02-13 23:03:01'),(65,7,16,'2011-03-12 20:09:51');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
