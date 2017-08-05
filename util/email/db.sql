/*
SQLyog Community Edition- MySQL GUI v8.05 
MySQL - 5.1.45-community : Database - db_sstplus
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_sstplus` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_sstplus`;

/*Table structure for table `gen_centro_poblado` */

DROP TABLE IF EXISTS `gen_centro_poblado`;

CREATE TABLE `gen_centro_poblado` (
  `id_centro_poblado` int(11) NOT NULL AUTO_INCREMENT,
  `id_municipio` int(11) NOT NULL,
  `codigo_centro_poblado` tinyint(6) NOT NULL,
  `centro_poblado` varchar(49) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_centro_poblado`),
  KEY `fk_gen_centro_poblado_municipio_idx` (`id_municipio`),
  CONSTRAINT `fk_gen_centro_poblado_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `gen_municipio` (`id_municipio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `gen_centro_poblado` */

/*Table structure for table `gen_contactos` */

DROP TABLE IF EXISTS `gen_contactos`;

CREATE TABLE `gen_contactos` (
  `id_contacto` int(11) NOT NULL AUTO_INCREMENT,
  `empresa` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre_apellido` varchar(130) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cargo` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `mensaje` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` char(1) DEFAULT 'R',
  `fecha_resp` date DEFAULT NULL,
  `respuesa` text,
  `calificacion` int(11) DEFAULT NULL,
  `usuario_resp` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `gen_contactos` */

insert  into `gen_contactos`(`id_contacto`,`empresa`,`nombre_apellido`,`cargo`,`email`,`telefono`,`ciudad`,`mensaje`,`estado`,`fecha_resp`,`respuesa`,`calificacion`,`usuario_resp`,`fecha_sistema`) values (1,'AAA','AAA','AAA','AA','1234567899','NNN','ASDD','R',NULL,NULL,NULL,'SISTEMA','2017-07-13 16:05:48'),(2,'AAA','AAA','AAA','AA','1234567899','NNN','ASDD','R',NULL,NULL,NULL,'SISTEMA','2017-07-13 16:05:53'),(3,'COCACOLA','ANDRE FELIPE PERDOMO','VENDEDOR','ANFEPE91@GMAIL.COM','3124115393','BOGOTA','QUIERO SABER ALGO','R',NULL,NULL,NULL,'SISTEMA','2017-07-13 16:05:57'),(5,'OPASOFT','ORLANDO PUENTE','PROGRAMADOR','orlando.puentes53@gmail.com','8733356','NEIVA','QUIERO QUE ME AYUDEN','C','2017-07-13','aaaaaaaaaa aaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaa',5,'SISTEMA','2017-07-13 18:43:18'),(7,'PRUEBA','JUAN PRUEBA','PROGRAMADOR','jlperdomo26@misena.edu.co','3124115392','NEIVA','HOLA MUNDO','R',NULL,NULL,NULL,NULL,'2017-07-12 17:07:08'),(8,'BANCO','JOSE LUIS','GERENTE','lucho912010@gmil.com','1234567899','NEIVA','JOSE LUCHO 123','C','2017-07-13','Hola lucho',5,'SISTEMA','2017-07-13 16:50:06'),(9,'PIRADEME','JOSE LUIS PERDOMO','GERENTE','lucho912010@gmail.com','3124115398','BOGOTA','QUIERO SABER SI SIRVE O NO','C','2017-07-13','Prueba adjunto',5,'SISTEMA','2017-07-13 17:03:10');

/*Table structure for table `gen_definiciones` */

DROP TABLE IF EXISTS `gen_definiciones`;

CREATE TABLE `gen_definiciones` (
  `id_definicion` int(11) NOT NULL AUTO_INCREMENT,
  `definicion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_definicion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `gen_definiciones` */

insert  into `gen_definiciones`(`id_definicion`,`definicion`,`usuario`,`fecha_sistema`) values (1,'TIPOS DOCUMENTO IDENTIDAD','SISTEMAS','2017-07-05 15:48:41'),(2,'GENERO','SISTEMAS','2017-07-05 15:55:05');

/*Table structure for table `gen_departamento` */

DROP TABLE IF EXISTS `gen_departamento`;

CREATE TABLE `gen_departamento` (
  `id_departamento` int(11) NOT NULL AUTO_INCREMENT,
  `id_pais` int(11) NOT NULL,
  `codigo_departamento` tinyint(2) NOT NULL,
  `departamento` varchar(56) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_departamento`),
  KEY `fk_gen_departamento_pais_idx` (`id_pais`),
  CONSTRAINT `fk_gen_departamento_pais` FOREIGN KEY (`id_pais`) REFERENCES `gen_pais` (`id_pais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `gen_departamento` */

/*Table structure for table `gen_detalle_definicion` */

DROP TABLE IF EXISTS `gen_detalle_definicion`;

CREATE TABLE `gen_detalle_definicion` (
  `id_detalle_definicion` int(11) NOT NULL AUTO_INCREMENT,
  `id_definicion` int(11) NOT NULL,
  `codigo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `orden` int(5) DEFAULT NULL,
  `detalle_definicion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_detalle_definicion`),
  KEY `fk_gen_detalle_definicion_definicion_idx` (`id_definicion`),
  CONSTRAINT `fk_gen_detalle_definicion_definicion` FOREIGN KEY (`id_definicion`) REFERENCES `gen_definiciones` (`id_definicion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `gen_detalle_definicion` */

insert  into `gen_detalle_definicion`(`id_detalle_definicion`,`id_definicion`,`codigo`,`orden`,`detalle_definicion`,`usuario`,`fecha_sistema`) values (1,1,'CC',1,'CEDULA DE CIUDADANIA','SISTEMAS','2017-07-05 15:49:55'),(2,1,'TI',2,'TARJETA DE IDENTIDAD','SISTEMAS','2017-07-05 15:51:41'),(3,1,'CE',3,'CEDULA DE EXTRANJERIA','SISTEMAS','2017-07-05 15:52:49'),(4,1,'NIT',4,'NIT','SISTEMAS','2017-07-05 15:53:09'),(5,2,'M',1,'MASCULINO','SISTEMAS','2017-07-05 15:55:30'),(6,2,'F',2,'FEMENINO','SISTEMAS','2017-07-05 15:55:50');

/*Table structure for table `gen_empresas` */

DROP TABLE IF EXISTS `gen_empresas`;

CREATE TABLE `gen_empresas` (
  `id_empresa` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `empresa` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `gen_empresas` */

insert  into `gen_empresas`(`id_empresa`,`empresa`) values (1,'NUEVASTIC');

/*Table structure for table `gen_menu` */

DROP TABLE IF EXISTS `gen_menu`;

CREATE TABLE `gen_menu` (
  `id_menu` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orden` tinyint(4) DEFAULT NULL,
  `menu` varchar(50) DEFAULT NULL,
  `ubicacion` varchar(20) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT '1',
  `usuario` varchar(50) DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `gen_menu` */

insert  into `gen_menu`(`id_menu`,`orden`,`menu`,`ubicacion`,`estado`,`usuario`,`fecha_sistema`) values (1,1,'ORGANIZACION','iz_arriba',1,'1','2017-07-13 15:39:22'),(2,2,'DIAGNOSTICO','iz_arriba',1,'1','2017-07-13 15:39:23'),(3,3,'POLÍTICA','iz_arriba',1,'1','2017-07-13 15:39:24'),(4,4,'OBJETIVOS','iz_arriba',1,'1','2017-07-13 15:39:24'),(5,5,'INDICADORES','iz_arriba',1,'1','2017-07-13 15:39:24'),(6,6,'PLAN DE TRABAJO','iz_arriba',1,'1','2017-07-13 15:39:25'),(7,7,'DOCUMENTACIÓN','iz_arriba',1,'1','2017-07-13 15:39:25'),(8,8,'MATRIZ DE REQUISITOS LEGALES','iz_arriba',1,'1','2017-07-13 15:39:25'),(9,1,'GESTIÓN DE SALUD','de_arriba',1,'1','2017-07-13 15:39:25'),(10,2,'GESTIÓN DE RIESGO','de_arriba',1,'1','2017-07-13 15:39:26'),(11,3,'EMERGENCIAS','de_arriba',1,'1','2017-07-13 15:39:26'),(12,4,'CONTRATRACIÓN','de_arriba',1,'1','2017-07-13 15:39:26'),(13,1,'REPORTAR ACPM','iz_abajo',1,'1','2017-07-13 15:39:26'),(14,2,'SEGUIMINTO DE HALLAZGOS','iz_abajo',1,'1','2017-07-13 15:39:27'),(15,1,'AUDITORIAS','de_abajo',1,'1','2017-07-13 15:39:27'),(16,2,'REVISIÓN GERENCIAL','de_abajo',1,'1','2017-07-13 15:39:29'),(17,1,'INICIO','superior',1,'1','2017-07-13 15:44:09'),(18,2,'FAVORITOS','superior',1,'1','2017-07-13 15:44:10'),(19,3,'ACTAS','superior',1,'1','2017-07-13 15:44:11'),(20,4,'PROCESOS','superior',1,'1','2017-07-13 15:44:11'),(21,5,'TAREAS','superior',1,'1','2017-07-13 15:44:11'),(22,6,'CONFIGURACION','superior',1,'1','2017-07-13 15:44:12'),(23,7,'NOTIFICACION','superior',1,'1','2017-07-13 15:44:12'),(24,8,'USUARIOS','superior',1,'1','2017-07-13 15:44:13'),(25,9,'SUPER ADMINISTRADOR','superior',1,'1','2017-07-13 15:44:13');

/*Table structure for table `gen_municipio` */

DROP TABLE IF EXISTS `gen_municipio`;

CREATE TABLE `gen_municipio` (
  `id_municipio` int(11) NOT NULL AUTO_INCREMENT,
  `id_departamento` int(11) NOT NULL,
  `codigo_municipio` tinyint(4) NOT NULL,
  `municipio` varchar(27) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_municipio`),
  KEY `fk_gen_municipio_departamento_idx` (`id_departamento`),
  CONSTRAINT `fk_gen_municipio_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `gen_departamento` (`id_departamento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `gen_municipio` */

/*Table structure for table `gen_pais` */

DROP TABLE IF EXISTS `gen_pais`;

CREATE TABLE `gen_pais` (
  `id_pais` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_pais` tinyint(2) NOT NULL,
  `pais` varchar(31) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pais`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `gen_pais` */

/*Table structure for table `gen_personas` */

DROP TABLE IF EXISTS `gen_personas`;

CREATE TABLE `gen_personas` (
  `id_persona` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_documento` int(11) NOT NULL,
  `numero_documento` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_expedicion_documento` date DEFAULT NULL,
  `primer_nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `segundo_nombre` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `primer_apellido` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `segundo_apellido` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_genero` int(11) NOT NULL,
  `id_pais_nacimiento` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_departamento_nacimiento` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_municipio_nacimiento` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `id_departamento_residencia` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_municipio_residencia` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `telefono_1` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `telefono_2` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `id_escolaridad` int(11) DEFAULT NULL,
  `id_profesion` int(11) DEFAULT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_persona`),
  KEY `index_escolaridad` (`id_escolaridad`),
  KEY `index_profesion` (`id_profesion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `gen_personas` */

insert  into `gen_personas`(`id_persona`,`id_tipo_documento`,`numero_documento`,`fecha_expedicion_documento`,`primer_nombre`,`segundo_nombre`,`primer_apellido`,`segundo_apellido`,`id_genero`,`id_pais_nacimiento`,`id_departamento_nacimiento`,`id_municipio_nacimiento`,`fecha_nacimiento`,`id_departamento_residencia`,`id_municipio_residencia`,`direccion`,`telefono_1`,`telefono_2`,`email`,`id_escolaridad`,`id_profesion`,`usuario`,`fecha_sistema`) values (1,1,'12105298',NULL,'ORLANDO',NULL,'PUENTES','ANDRADE',5,NULL,NULL,NULL,'0000-00-00',NULL,NULL,'CALLE 53 26-40','3182821634',NULL,'orlando.puentes53@gmail.com',NULL,NULL,'SISTEMAS','2017-07-05 15:57:59');

/*Table structure for table `gen_submenu` */

DROP TABLE IF EXISTS `gen_submenu`;

CREATE TABLE `gen_submenu` (
  `id_submenu` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) unsigned DEFAULT NULL,
  `nivel` tinyint(4) DEFAULT NULL,
  `orden` tinyint(4) DEFAULT NULL,
  `submenu` varchar(50) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT '1',
  `usuario` varchar(50) DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_submenu`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `gen_submenu` */

insert  into `gen_submenu`(`id_submenu`,`id_menu`,`nivel`,`orden`,`submenu`,`estado`,`usuario`,`fecha_sistema`) values (1,24,1,1,'Perfil',1,'1','2017-07-13 15:50:41'),(2,24,1,2,'Cambiar Contraseña',1,'1','2017-07-13 15:51:48'),(3,24,1,3,'Cerrrar Sessión',1,'1','2017-07-13 15:52:18'),(4,25,1,1,'Crear Usuario',1,'1','2017-07-13 15:53:22'),(5,25,1,2,'Cambiar Contraseña',1,'1','2017-07-13 15:53:45'),(6,25,1,3,'Cambiar Estado',1,'1','2017-07-13 15:54:30'),(7,NULL,NULL,NULL,'Mensajes de Contacto',1,'1','2017-07-13 15:55:06');

/*Table structure for table `seg_perfil` */

DROP TABLE IF EXISTS `seg_perfil`;

CREATE TABLE `seg_perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `perfil` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `seg_perfil` */

insert  into `seg_perfil`(`id_perfil`,`perfil`,`usuario`,`fecha_sistema`) values (1,'*','SISTEMAS','2017-07-05 15:45:23');

/*Table structure for table `seg_recursos` */

DROP TABLE IF EXISTS `seg_recursos`;

CREATE TABLE `seg_recursos` (
  `id_recurso` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_recurso` int(11) NOT NULL,
  `recurso` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_recurso`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `seg_recursos` */

insert  into `seg_recursos`(`id_recurso`,`id_tipo_recurso`,`recurso`,`url`,`usuario`,`fecha_sistema`) values (1,0,'*','*','SISTEMAS','2017-07-13 15:58:36');

/*Table structure for table `seg_rol_perfil` */

DROP TABLE IF EXISTS `seg_rol_perfil`;

CREATE TABLE `seg_rol_perfil` (
  `id_rol_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rol_perfil`),
  KEY `fk_seg_rol_perfil_rol_idx` (`id_rol`),
  KEY `fk_seg_rol_perfil_perfil_idx` (`id_perfil`),
  CONSTRAINT `fk_seg_rol_perfil_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `seg_perfil` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_seg_rol_perfil_rol` FOREIGN KEY (`id_rol`) REFERENCES `seg_roles` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `seg_rol_perfil` */

insert  into `seg_rol_perfil`(`id_rol_perfil`,`id_rol`,`id_perfil`,`usuario`,`fecha_sistema`) values (1,1,1,'SISTEMAS','2017-07-05 15:45:54');

/*Table structure for table `seg_rol_recurso` */

DROP TABLE IF EXISTS `seg_rol_recurso`;

CREATE TABLE `seg_rol_recurso` (
  `id_rol_recurso` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rol_recurso`),
  KEY `fk_seg_rol_recurso_recurso_idx` (`id_recurso`),
  KEY `fk_rol_recurso_rol_idx` (`id_rol`),
  CONSTRAINT `fk_seg_rol_recurso_recurso` FOREIGN KEY (`id_recurso`) REFERENCES `seg_recursos` (`id_recurso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_seg_rol_recurso_rol` FOREIGN KEY (`id_rol`) REFERENCES `seg_roles` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `seg_rol_recurso` */

insert  into `seg_rol_recurso`(`id_rol_recurso`,`id_rol`,`id_recurso`,`usuario`,`fecha_sistema`) values (2,1,1,'SISTEMAS','2017-07-05 15:47:31');

/*Table structure for table `seg_roles` */

DROP TABLE IF EXISTS `seg_roles`;

CREATE TABLE `seg_roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `seg_roles` */

insert  into `seg_roles`(`id_rol`,`rol`,`usuario`,`fecha_sistema`) values (1,'PROPIETARIO','SISTEMAS','2017-07-05 15:44:39');

/*Table structure for table `seg_usuarios` */

DROP TABLE IF EXISTS `seg_usuarios`;

CREATE TABLE `seg_usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_persona` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `cambio_contrasena` tinyint(1) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `usuario_sistema` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_sistema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_seg_usuario_rol_idx` (`id_rol`),
  KEY `fk_seg_usuario_empresa_idx` (`id_empresa`),
  KEY `fk_seg_usuario_persona_idx` (`id_persona`),
  CONSTRAINT `fk_seg_usuario_persona` FOREIGN KEY (`id_persona`) REFERENCES `gen_personas` (`id_persona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_seg_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `seg_roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `seg_usuarios` */

insert  into `seg_usuarios`(`id_usuario`,`id_persona`,`id_rol`,`id_empresa`,`usuario`,`contrasena`,`cambio_contrasena`,`fecha_inicio`,`fecha_fin`,`estado`,`usuario_sistema`,`fecha_sistema`) values (1,1,1,1,'OPA','e10adc3949ba59abbe56e057f20f883e',1,'2017-06-01','2017-12-31','A','SISTEMAS','2017-07-13 14:29:57');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
