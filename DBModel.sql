CREATE DATABASE  IF NOT EXISTS `ppmx_v2` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ppmx_v2`;
-- MySQL dump 10.13  Distrib 8.0.19, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: ppmx_v2
-- ------------------------------------------------------
-- Server version	8.0.19-0ubuntu0.19.10.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reporteFallasAplicacion`
--

DROP TABLE IF EXISTS `reporteFallasAplicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reporteFallasAplicacion` (
  `idReporteFallas` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `area` int DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idReporteFallas`),
  UNIQUE KEY `idReporteFallas_UNIQUE` (`idReporteFallas`),
  KEY `fk_reporteFallasAplicacion_1_idx` (`area`),
  KEY `fk_reporteFallasAplicacion_2_idx` (`status`),
  CONSTRAINT `fk_reporteFallasAplicacion_1` FOREIGN KEY (`area`) REFERENCES `tb_etapa` (`idEtapa`),
  CONSTRAINT `fk_reporteFallasAplicacion_2` FOREIGN KEY (`status`) REFERENCES `tb_status` (`idStatus`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_acciones`
--

DROP TABLE IF EXISTS `tb_acciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_acciones` (
  `idAcciones` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int DEFAULT NULL,
  `idPieza` int DEFAULT NULL,
  `idEtapa` int DEFAULT NULL,
  `idRevision` int DEFAULT NULL,
  `idObservacion` int DEFAULT NULL,
  `idFalla` int DEFAULT NULL,
  `comentario` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `revision` int DEFAULT NULL,
  `estampa` varchar(45) DEFAULT NULL,
  `armador` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idAcciones`),
  KEY `fk_tb_acciones_1_idx` (`idUsuario`),
  KEY `fk_tb_acciones_2_idx` (`idEtapa`),
  KEY `fk_tb_acciones_3_idx` (`idRevision`),
  KEY `fk_tb_acciones_4_idx` (`idPieza`),
  CONSTRAINT `fk_tb_acciones_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuarios`),
  CONSTRAINT `fk_tb_acciones_2` FOREIGN KEY (`idEtapa`) REFERENCES `tb_etapa` (`idEtapa`),
  CONSTRAINT `fk_tb_acciones_3` FOREIGN KEY (`idRevision`) REFERENCES `tb_revision` (`idRevision`),
  CONSTRAINT `fk_tb_acciones_4` FOREIGN KEY (`idPieza`) REFERENCES `tb_pieza` (`idPieza`)
) ENGINE=InnoDB AUTO_INCREMENT=422 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_armadores`
--

DROP TABLE IF EXISTS `tb_armadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_armadores` (
  `idArmador` int NOT NULL AUTO_INCREMENT,
  `nombre` text,
  PRIMARY KEY (`idArmador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_etapa`
--

DROP TABLE IF EXISTS `tb_etapa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_etapa` (
  `idEtapa` int NOT NULL AUTO_INCREMENT,
  `descripcionEtapa` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idEtapa`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_fallas`
--

DROP TABLE IF EXISTS `tb_fallas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_fallas` (
  `idFallas` int NOT NULL AUTO_INCREMENT,
  `idObservacion` int DEFAULT NULL,
  `idTipoFalla` int DEFAULT NULL,
  `ComentarioFalla` varchar(100) DEFAULT NULL,
  `supervisorqi` int DEFAULT NULL,
  `indicacion` varchar(45) DEFAULT NULL,
  `observaciones` varchar(100) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `soldaduraProceso` varchar(45) DEFAULT NULL,
  `fechaFalla` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idFallas`),
  KEY `1_idx` (`idObservacion`),
  KEY `2_idx` (`idTipoFalla`),
  KEY `3_idx` (`status`),
  KEY `fallas4_idx` (`supervisorqi`),
  CONSTRAINT `fallas1` FOREIGN KEY (`idObservacion`) REFERENCES `tb_observaciones` (`idObservaciones`),
  CONSTRAINT `fallas2` FOREIGN KEY (`idTipoFalla`) REFERENCES `tb_tipofalla` (`idTipoFalla`),
  CONSTRAINT `fallas3` FOREIGN KEY (`status`) REFERENCES `tb_status` (`idStatus`),
  CONSTRAINT `fallas4` FOREIGN KEY (`supervisorqi`) REFERENCES `tb_supervisorqi` (`idSupervisor`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
ALTER DATABASE `ppmx_v2` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,NO_AUTO_VALUE_ON_ZERO,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `actualiza_observaciones` AFTER UPDATE ON `tb_fallas` FOR EACH ROW BEGIN
    DECLARE idOB integer;
    set @idOB := new.idObservacion;
    
    UPDATE tb_observaciones as ob set ob.updated_at = CURRENT_TIMESTAMP() where ob.idObservaciones = @idOB;
IF
(select SUM(if(fa.status = 1,0,1)) as suma from tb_fallas as fa inner join tb_observaciones as ob on fa.idObservacion
 = ob.idObservaciones inner join tb_piezaob as pob on pob.idPiezaOB = ob.idPiezaOb inner join tb_revision as rv on
 rv.idRevision = pob.idRevision where fa.idObservacion = @idOB) = 0
THEN
	UPDATE tb_observaciones as ob set ob.status = 1 where ob.idObservaciones = @idOB;
END IF;
	END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `ppmx_v2` CHARACTER SET utf8 COLLATE utf8_general_ci ;

--
-- Table structure for table `tb_inspector`
--

DROP TABLE IF EXISTS `tb_inspector`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_inspector` (
  `idInspector` int NOT NULL AUTO_INCREMENT,
  `nombreInspector` varchar(45) DEFAULT NULL,
  `apellidoMInspector` varchar(45) DEFAULT NULL,
  `apellidoPInspector` varchar(45) DEFAULT NULL,
  `fechaInspector` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `iduser` int DEFAULT NULL,
  PRIMARY KEY (`idInspector`),
  KEY `isuser_idx` (`iduser`),
  CONSTRAINT `isuser` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_lotePintura`
--

DROP TABLE IF EXISTS `tb_lotePintura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_lotePintura` (
  `idLotePintura` int NOT NULL AUTO_INCREMENT,
  `idSupervisorPintura` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `codigoLote` varchar(45) DEFAULT NULL,
  `status` int DEFAULT '4',
  PRIMARY KEY (`idLotePintura`),
  KEY `fk_tb_lotePintura_1_idx` (`status`),
  CONSTRAINT `fk_tb_lotePintura_1` FOREIGN KEY (`status`) REFERENCES `tb_status` (`idStatus`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_nr`
--

DROP TABLE IF EXISTS `tb_nr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_nr` (
  `idNr` int NOT NULL AUTO_INCREMENT,
  `idPieza` int DEFAULT NULL,
  `idInspector` int DEFAULT NULL,
  `idRevision` int DEFAULT NULL,
  `idEtapa` int DEFAULT NULL,
  `comentario` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idNr`),
  KEY `fk_tb_nr_1_idx` (`idPieza`),
  KEY `fk_tb_nr_2_idx` (`idInspector`),
  KEY `fk_tb_nr_3_idx` (`idRevision`),
  KEY `fk_tb_nr_4_idx` (`idEtapa`),
  CONSTRAINT `fk_tb_nr_1` FOREIGN KEY (`idPieza`) REFERENCES `tb_pieza` (`idPieza`),
  CONSTRAINT `fk_tb_nr_2` FOREIGN KEY (`idInspector`) REFERENCES `usuarios` (`idUsuarios`),
  CONSTRAINT `fk_tb_nr_3` FOREIGN KEY (`idRevision`) REFERENCES `tb_revision` (`idRevision`),
  CONSTRAINT `fk_tb_nr_4` FOREIGN KEY (`idEtapa`) REFERENCES `tb_etapa` (`idEtapa`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_observaciones`
--

DROP TABLE IF EXISTS `tb_observaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_observaciones` (
  `idObservaciones` int NOT NULL AUTO_INCREMENT,
  `idPiezaOb` int DEFAULT NULL,
  `supervisor` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status` int DEFAULT NULL,
  `contadorRevision` int DEFAULT '1',
  `fecharevision` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT NULL,
  `idLotePintura` int DEFAULT NULL,
  `idPiezaPintura` int DEFAULT NULL,
  `supervisorLibera` int DEFAULT NULL,
  `areaCargada` int DEFAULT NULL,
  PRIMARY KEY (`idObservaciones`),
  KEY `2_idx` (`status`),
  KEY `obsevaciones3_idx` (`idPiezaOb`),
  KEY `fk_tb_observaciones_2_idx` (`idLotePintura`),
  KEY `fk_tb_observaciones_1_idx` (`idPiezaPintura`),
  KEY `fk_tb_observaciones_3_idx` (`supervisorLibera`),
  KEY `fk_tb_observaciones_4_idx` (`areaCargada`),
  CONSTRAINT `fk_tb_observaciones_1` FOREIGN KEY (`idPiezaPintura`) REFERENCES `tb_piezaPintura` (`idPiezaPintura`),
  CONSTRAINT `fk_tb_observaciones_2` FOREIGN KEY (`idLotePintura`) REFERENCES `tb_lotePintura` (`idLotePintura`),
  CONSTRAINT `fk_tb_observaciones_3` FOREIGN KEY (`supervisorLibera`) REFERENCES `usuarios` (`idUsuarios`),
  CONSTRAINT `fk_tb_observaciones_4` FOREIGN KEY (`areaCargada`) REFERENCES `tb_etapa` (`idEtapa`),
  CONSTRAINT `observaciones1` FOREIGN KEY (`status`) REFERENCES `tb_status` (`idStatus`),
  CONSTRAINT `obsevaciones3` FOREIGN KEY (`idPiezaOb`) REFERENCES `tb_piezaob` (`idPiezaOB`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `actualiza_revision` AFTER UPDATE ON `tb_observaciones` FOR EACH ROW BEGIN
    DECLARE idOB integer;
    set @idOB := new.idObservaciones;
IF
(select SUM(if(ob.status = 1,0,1)) as suma from tb_observaciones as ob inner join tb_piezaob as pob on pob.idPiezaOB = ob.idPiezaOb inner join tb_revision as rv on
 rv.idRevision = pob.idRevision where ob.idObservaciones = @idOB and rv.idEtapa=4) = 0 and new.status = 1 and old.status = 2
THEN
	UPDATE tb_revision as rv inner join tb_piezaob as pob on pob.idRevision = rv.idRevision inner join tb_observaciones as ob on ob.idPiezaOb = pob.idPiezaOb  set rv.CantidadAprobadas = (rv.CantidadAprobadas + 1) where ob.idObservaciones = @idOB;
END IF;
	END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tb_pieza`
--

DROP TABLE IF EXISTS `tb_pieza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_pieza` (
  `idPieza` int NOT NULL AUTO_INCREMENT,
  `nombreProyecto` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cod_elemento` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `idStatus` int DEFAULT NULL,
  `cantidadPieza` int DEFAULT NULL,
  `consecutivo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaPieza` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `proyecto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombrePieza` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idUltimaAprobacion` int DEFAULT NULL,
  `updated_at` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idPieza`),
  KEY `fk_tb_pieza_1_idx` (`idUltimaAprobacion`),
  CONSTRAINT `fk_tb_pieza_1` FOREIGN KEY (`idUltimaAprobacion`) REFERENCES `tb_etapa` (`idEtapa`)
) ENGINE=InnoDB AUTO_INCREMENT=45837 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_piezaPintura`
--

DROP TABLE IF EXISTS `tb_piezaPintura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_piezaPintura` (
  `idPiezaPintura` int NOT NULL AUTO_INCREMENT,
  `idPieza` int DEFAULT NULL,
  `consecutivo` int DEFAULT NULL,
  `idStatus` int DEFAULT NULL,
  `idUltimaAprobacion` int DEFAULT NULL,
  `idLotePintura` int DEFAULT NULL,
  `pinturaPrep` datetime DEFAULT NULL,
  `pinturaC1` datetime DEFAULT NULL,
  `pinturaC2` datetime DEFAULT NULL,
  `pinturaC3` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `idConjunto` int DEFAULT NULL,
  `inspectorC1` int DEFAULT NULL,
  `inspectorC2` int DEFAULT NULL,
  `inspectorC3` int DEFAULT NULL,
  `inspectorPrep` int DEFAULT NULL,
  `muestra` tinyint DEFAULT NULL,
  `tieneOB` tinyint DEFAULT NULL,
  PRIMARY KEY (`idPiezaPintura`),
  KEY `fk_tb_piezaHabilidado_1_idx` (`idPieza`),
  KEY `fk_tb_piezaHabilidado_2_idx` (`idStatus`),
  KEY `fk_tb_piezaHabilidado_3_idx` (`idUltimaAprobacion`),
  KEY `fk_tb_piezaHabilidado_4_idx` (`idLotePintura`),
  KEY `fk_tb_piezaHabilidado_5_idx` (`pinturaPrep`),
  KEY `fk_tb_piezaHabilidado_6_idx` (`pinturaC1`),
  KEY `fk_tb_piezaHabilidado_7_idx` (`pinturaC2`),
  KEY `fk_tb_piezaHabilidado_8_idx` (`pinturaC3`),
  KEY `fk_tb_piezaPintura_1_idx` (`inspectorC1`),
  KEY `fk_tb_piezaPintura_2_idx` (`inspectorC2`),
  KEY `fk_tb_piezaPintura_3_idx` (`inspectorC3`),
  KEY `fk_tb_piezaPintura_4_idx` (`inspectorPrep`),
  CONSTRAINT `fk_tb_piezaHabilidado_1` FOREIGN KEY (`idPieza`) REFERENCES `tb_pieza` (`idPieza`),
  CONSTRAINT `fk_tb_piezaHabilidado_2` FOREIGN KEY (`idStatus`) REFERENCES `tb_status` (`idStatus`),
  CONSTRAINT `fk_tb_piezaHabilidado_3` FOREIGN KEY (`idUltimaAprobacion`) REFERENCES `tb_etapa` (`idEtapa`),
  CONSTRAINT `fk_tb_piezaHabilidado_4` FOREIGN KEY (`idLotePintura`) REFERENCES `tb_lotePintura` (`idLotePintura`),
  CONSTRAINT `fk_tb_piezaPintura_1` FOREIGN KEY (`inspectorC1`) REFERENCES `usuarios` (`idUsuarios`),
  CONSTRAINT `fk_tb_piezaPintura_2` FOREIGN KEY (`inspectorC2`) REFERENCES `usuarios` (`idUsuarios`),
  CONSTRAINT `fk_tb_piezaPintura_3` FOREIGN KEY (`inspectorC3`) REFERENCES `usuarios` (`idUsuarios`),
  CONSTRAINT `fk_tb_piezaPintura_4` FOREIGN KEY (`inspectorPrep`) REFERENCES `usuarios` (`idUsuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_piezaob`
--

DROP TABLE IF EXISTS `tb_piezaob`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_piezaob` (
  `idPiezaOB` int NOT NULL AUTO_INCREMENT,
  `idRevision` int DEFAULT NULL,
  `consPieza` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`idPiezaOB`),
  KEY `1_idx` (`idRevision`),
  CONSTRAINT `piezaOB1` FOREIGN KEY (`idRevision`) REFERENCES `tb_revision` (`idRevision`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_revision`
--

DROP TABLE IF EXISTS `tb_revision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_revision` (
  `idRevision` int NOT NULL AUTO_INCREMENT,
  `idPieza` int DEFAULT NULL,
  `idUsuario` int DEFAULT NULL,
  `idEtapa` int DEFAULT NULL,
  `comentario` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CantidadAprobadas` int DEFAULT NULL,
  `tieneOB` tinyint DEFAULT '0',
  `fechaRevision` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `parcial` varchar(45) COLLATE utf8_spanish_ci DEFAULT 'false',
  `updated_at` datetime DEFAULT NULL,
  `idLotePintura` int DEFAULT NULL,
  `revisionPlano` int DEFAULT NULL,
  `procesoSoldadura` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idRevision`),
  KEY `1_idx` (`idPieza`),
  KEY `2_idx` (`idUsuario`),
  KEY `3_idx` (`idEtapa`),
  KEY `fk_tb_revision_1_idx` (`idLotePintura`),
  CONSTRAINT `1` FOREIGN KEY (`idPieza`) REFERENCES `tb_pieza` (`idPieza`),
  CONSTRAINT `2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuarios`),
  CONSTRAINT `3` FOREIGN KEY (`idEtapa`) REFERENCES `tb_etapa` (`idEtapa`),
  CONSTRAINT `fk_tb_revision_1` FOREIGN KEY (`idLotePintura`) REFERENCES `tb_lotePintura` (`idLotePintura`)
) ENGINE=InnoDB AUTO_INCREMENT=825 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_revisionTrabajador`
--

DROP TABLE IF EXISTS `tb_revisionTrabajador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_revisionTrabajador` (
  `idRevisionArmador` int NOT NULL AUTO_INCREMENT,
  `idRevision` int DEFAULT NULL,
  `idArmador` int DEFAULT NULL,
  `idSoldador` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idRevisionArmador`),
  KEY `fk_tb_revisionArmador_1_idx` (`idRevision`),
  KEY `fk_tb_revisionTrabajador_1_idx` (`idArmador`),
  KEY `fk_tb_revisionTrabajador_2_idx` (`idSoldador`),
  CONSTRAINT `fk_tb_revisionArmador_1` FOREIGN KEY (`idRevision`) REFERENCES `tb_revision` (`idRevision`),
  CONSTRAINT `fk_tb_revisionTrabajador_1` FOREIGN KEY (`idArmador`) REFERENCES `tb_armadores` (`idArmador`),
  CONSTRAINT `fk_tb_revisionTrabajador_2` FOREIGN KEY (`idSoldador`) REFERENCES `tb_soldadores` (`idSoldador`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_soldadores`
--

DROP TABLE IF EXISTS `tb_soldadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_soldadores` (
  `idSoldador` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `estampa` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idSoldador`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_status`
--

DROP TABLE IF EXISTS `tb_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_status` (
  `idStatus` int NOT NULL AUTO_INCREMENT,
  `descripcionStatus` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`idStatus`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_supervisorqi`
--

DROP TABLE IF EXISTS `tb_supervisorqi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_supervisorqi` (
  `idSupervisor` int NOT NULL AUTO_INCREMENT,
  `nombreSupervisor` varchar(45) DEFAULT NULL,
  `apellidoPsupervisor` varchar(45) DEFAULT NULL,
  `apellidoMsupervisor` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idSupervisor`),
  UNIQUE KEY `idSupervisor_UNIQUE` (`idSupervisor`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_tipofalla`
--

DROP TABLE IF EXISTS `tb_tipofalla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_tipofalla` (
  `idTipoFalla` int NOT NULL AUTO_INCREMENT,
  `descripcionTipoFalla` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`idTipoFalla`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_usuarioRevision`
--

DROP TABLE IF EXISTS `tb_usuarioRevision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_usuarioRevision` (
  `idUsuarioRevision` int NOT NULL AUTO_INCREMENT,
  `idRevision` int NOT NULL,
  `idUsuario` int NOT NULL,
  `Comentario` varchar(255) DEFAULT NULL,
  `numeroRevision` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idUsuarioRevision`),
  KEY `fk_tb_usuarioRevision_1_idx` (`idRevision`),
  KEY `fk_tb_usuarioRevision_2_idx` (`idUsuario`),
  CONSTRAINT `fk_tb_usuarioRevision_1` FOREIGN KEY (`idRevision`) REFERENCES `tb_revision` (`idRevision`),
  CONSTRAINT `fk_tb_usuarioRevision_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `nip_UNIQUE` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
ALTER DATABASE `ppmx_v2` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,NO_AUTO_VALUE_ON_ZERO,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `creaSupervisor` AFTER INSERT ON `users` FOR EACH ROW begin
	declare nombre varchar(50);
    declare id int;
	set nombre = new.name;
    set id = new.id;
    
	insert into tb_inspector(nombreInspector, iduser) values (nombre, id);
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `ppmx_v2` CHARACTER SET utf8 COLLATE utf8_general_ci ;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idUsuarios` int NOT NULL AUTO_INCREMENT,
  `nombreUsuario` varchar(200) DEFAULT NULL,
  `apellidoPaterno` varchar(200) DEFAULT NULL,
  `apellidoMaterno` varchar(200) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `nip` varchar(200) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permisos` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idUsuarios`),
  UNIQUE KEY `usuarios_UNIQUE` (`idUsuarios`),
  UNIQUE KEY `nip_UNIQUE` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'ppmx_v2'
--

--
-- Dumping routines for database 'ppmx_v2'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-18 14:17:18
