-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: sisbanco1
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ahorros`
--

DROP TABLE IF EXISTS `ahorros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahorros` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint(20) unsigned NOT NULL,
  `monto_ahorro` decimal(10,2) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta','Cheque') NOT NULL,
  `referencia_pago` varchar(255) NOT NULL,
  `estado` enum('Pendiente','Pagado') NOT NULL,
  `fecha_pago` date DEFAULT NULL,
  `detalle_pago` varchar(255) DEFAULT NULL,
  `pago_id` varchar(255) DEFAULT NULL,
  `multa` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ahorros_cliente_id_foreign` (`cliente_id`),
  CONSTRAINT `ahorros_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ahorros`
--

LOCK TABLES `ahorros` WRITE;
/*!40000 ALTER TABLE `ahorros` DISABLE KEYS */;
INSERT INTO `ahorros` VALUES (1,1,100.00,'2025-02-10','Efectivo','Pago del ahorro mes febrero 2025','Pendiente',NULL,NULL,NULL,NULL,'2025-04-14 23:26:09','2025-04-14 23:26:09'),(2,1,100.00,'2025-03-10','Efectivo','Pago del ahorro mes marzo 2025','Pendiente',NULL,NULL,NULL,NULL,'2025-04-14 23:26:09','2025-04-14 23:26:09'),(3,1,100.00,'2025-04-10','Efectivo','Pago del ahorro mes abril 2025','Pendiente',NULL,NULL,NULL,NULL,'2025-04-14 23:26:09','2025-04-14 23:26:09'),(4,1,100.00,'2025-05-10','Efectivo','Pago del ahorro mes mayo 2025','Pendiente',NULL,NULL,NULL,NULL,'2025-04-14 23:26:09','2025-04-14 23:26:09'),(5,1,100.00,'2025-06-10','Efectivo','Pago del ahorro mes junio 2025','Pendiente',NULL,NULL,NULL,NULL,'2025-04-14 23:26:09','2025-04-14 23:26:09'),(6,1,100.00,'2025-07-10','Efectivo','Pago del ahorro mes julio 2025','Pendiente',NULL,NULL,NULL,NULL,'2025-04-14 23:26:09','2025-04-14 23:26:09'),(7,1,100.00,'2025-08-10','Efectivo','Pago del ahorro mes agosto 2025','Pendiente',NULL,NULL,NULL,NULL,'2025-04-14 23:26:09','2025-04-14 23:26:09'),(8,1,100.00,'2025-09-10','Efectivo','Pago del ahorro mes septiembre 2025','Pendiente',NULL,NULL,NULL,NULL,'2025-04-14 23:26:09','2025-04-14 23:26:09'),(9,1,100.00,'2025-10-10','Efectivo','Pago del ahorro mes octubre 2025','Pendiente',NULL,NULL,NULL,NULL,'2025-04-14 23:26:09','2025-04-14 23:26:09'),(10,1,100.00,'2025-11-10','Efectivo','Pago del ahorro mes noviembre 2025','Pendiente',NULL,NULL,NULL,NULL,'2025-04-14 23:26:09','2025-04-14 23:26:09'),(11,1,100.00,'2025-12-10','Efectivo','Pago del ahorro mes diciembre 2025','Pendiente',NULL,NULL,NULL,NULL,'2025-04-14 23:26:09','2025-04-14 23:26:09');
/*!40000 ALTER TABLE `ahorros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nro_documento` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `ref_celular` varchar(255) NOT NULL,
  `acciones` int(11) NOT NULL,
  `fecha_afiliacion` date NOT NULL,
  `saldo_ahorro` decimal(10,2) NOT NULL,
  `saldo_ahorro1` decimal(10,2) NOT NULL,
  `estado` enum('Activo','Deshabilitado') NOT NULL DEFAULT 'Activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clientes_nro_documento_unique` (`nro_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'1719384732','Generico','Usuario','2025-04-01','masculino','generico1@gmail.com','0993422324','2348934384',4,'2025-02-01',1000.00,1000.00,'Activo','2025-04-14 23:26:09','2025-04-14 23:28:52');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuraciones`
--

DROP TABLE IF EXISTS `configuraciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuraciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `web` varchar(255) DEFAULT NULL,
  `moneda` varchar(255) NOT NULL,
  `logo` text NOT NULL,
  `base_prestamo` decimal(10,2) NOT NULL,
  `valor_accion` decimal(10,2) NOT NULL,
  `valor_retencion` decimal(10,2) DEFAULT NULL,
  `valor_mora` decimal(10,2) DEFAULT NULL,
  `valor_seguro` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciones`
--

LOCK TABLES `configuraciones` WRITE;
/*!40000 ALTER TABLE `configuraciones` DISABLE KEYS */;
INSERT INTO `configuraciones` VALUES (1,'COO PROFUTURO','Prestamos con interes bajo','guamani','0993593185','noloststorres@gmail.com','ninguna.com','usd','logos/QSEKZloYDLurWY5QcwfV8gVRxvKIkNJzohnmi4x1.png',2.00,25.00,1.00,0.00,NULL,'2025-04-14 23:25:02','2025-04-14 23:25:02');
/*!40000 ALTER TABLE `configuraciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuotas`
--

DROP TABLE IF EXISTS `cuotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuotas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prestamo_id` bigint(20) unsigned NOT NULL,
  `monto_cuota` decimal(10,2) NOT NULL,
  `interes` decimal(10,2) NOT NULL,
  `capital` decimal(10,2) NOT NULL,
  `saldo_pendiente` decimal(10,2) NOT NULL,
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta','Cheque') NOT NULL,
  `referencia_pago` varchar(255) NOT NULL,
  `estado` enum('Pendiente','Pagado') NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `fecha_pago` date DEFAULT NULL,
  `detalle_pago` varchar(255) DEFAULT NULL,
  `pago_id` varchar(255) DEFAULT NULL,
  `multa` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cuotas_prestamo_id_foreign` (`prestamo_id`),
  CONSTRAINT `cuotas_prestamo_id_foreign` FOREIGN KEY (`prestamo_id`) REFERENCES `prestamos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuotas`
--

LOCK TABLES `cuotas` WRITE;
/*!40000 ALTER TABLE `cuotas` DISABLE KEYS */;
/*!40000 ALTER TABLE `cuotas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2014_10_12_100000_create_password_resets_table',1),(4,'2015_03_09_122602_create_configuraciones_table',1),(5,'2019_08_19_000000_create_failed_jobs_table',1),(6,'2019_12_14_000001_create_personal_access_tokens_table',1),(7,'2025_03_10_155302_create_permission_tables',1),(8,'2025_03_11_074215_create_clientes_table',1),(9,'2025_03_11_074215_create_pagos_table',1),(10,'2025_03_11_222929_create_prestamos_table',1),(11,'2025_03_11_224017_create_cuotas_table',1),(12,'2025_03_12_224959_create_ahorros_table',1),(13,'2025_03_16_233107_create_transacciones_table',1),(14,'2025_03_17_181957_create_retiros_table',1),(15,'2025_04_10_145125_create_retenciones_table',1),(16,'2025_04_14_152045_update_tipo_transaccion1_enum_in_transacciones',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint(20) unsigned NOT NULL,
  `total_pago` decimal(10,2) NOT NULL,
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta','Cheque','Movimiento interno') NOT NULL,
  `fecha_pago` date DEFAULT NULL,
  `detalle_pago` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pagos_cliente_id_foreign` (`cliente_id`),
  CONSTRAINT `pagos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'admin.configuracion.index','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(2,'admin.configuracion.create','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(3,'admin.configuracion.store','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(4,'admin.configuracion.show','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(5,'admin.configuracion.edit','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(6,'admin.configuracion.update','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(7,'admin.configuracion.destroy','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(8,'admin.roles.index','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(9,'admin.roles.create','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(10,'admin.roles.store','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(11,'admin.roles.show','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(12,'admin.roles.asignar_roles','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(13,'admin.roles.update_asignar','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(14,'admin.roles.edit','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(15,'admin.roles.update','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(16,'admin.roles.destroy','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(17,'admin.users.index','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(18,'admin.users.create','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(19,'admin.users.store','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(20,'admin.users.show','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(21,'admin.users.edit','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(22,'admin.users.update','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(23,'admin.users.destroy','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(24,'admin.clientes.index','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(25,'admin.clientes.create','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(26,'admin.clientes.store','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(27,'admin.clientes.show','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(28,'admin.clientes.edit','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(29,'admin.clientes.update','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(30,'admin.clientes.destroy','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(31,'admin.clientes.deshabilitar','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(32,'admin.prestamos.index','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(33,'admin.prestamos.create','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(34,'admin.prestamos.cliente.obtenerCliente','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(35,'admin.prestamos.store','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(36,'admin.prestamos.show','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(37,'admin.prestamos.contratos','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(38,'admin.cuotas.index','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(39,'admin.cuotas.create','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(40,'admin.cuotas.cliente.obtenerCliente','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(41,'admin.cuotas.pagos-pendientes','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(42,'admin.cuotas.ahorros-pendientes','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(43,'admin.cuotas.store','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(44,'admin.cuotas.show','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(45,'admin.cuotas.recibos','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(46,'admin.cuotas.interes','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(47,'admin.cuotas.pagarinteres','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(48,'admin.cuotas.store1','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(49,'admin.retiros.index','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(50,'admin.retiros.create','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(51,'admin.retiros.cliente.obtenerCliente','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(52,'admin.retiros.store','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(53,'admin.retiros.show','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(54,'admin.retiros.recibos','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(55,'admin.backups.index','web','2025-04-14 23:14:24','2025-04-14 23:14:24'),(56,'admin.backups.create','web','2025-04-14 23:14:24','2025-04-14 23:14:24');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamos`
--

DROP TABLE IF EXISTS `prestamos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestamos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint(20) unsigned NOT NULL,
  `monto_prestado` decimal(10,2) NOT NULL,
  `metodo_prestamo` enum('Institucional','Personalizado','Francés','Alemán') NOT NULL,
  `tasa_interes_anual` decimal(5,2) DEFAULT NULL,
  `modalidad` enum('Diario','Semanal','Quincenal','Mensual','Anual') NOT NULL,
  `nro_cuotas` int(11) NOT NULL,
  `monto_total` decimal(12,2) NOT NULL,
  `monto_total1` decimal(12,2) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `estado` enum('Activo','Cancelado') NOT NULL DEFAULT 'Activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prestamos_cliente_id_foreign` (`cliente_id`),
  CONSTRAINT `prestamos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamos`
--

LOCK TABLES `prestamos` WRITE;
/*!40000 ALTER TABLE `prestamos` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestamos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retenciones`
--

DROP TABLE IF EXISTS `retenciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `retenciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prestamo_id` int(11) DEFAULT NULL,
  `valor_retenido` decimal(10,2) NOT NULL,
  `detalle` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retenciones`
--

LOCK TABLES `retenciones` WRITE;
/*!40000 ALTER TABLE `retenciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `retenciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retiros`
--

DROP TABLE IF EXISTS `retiros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `retiros` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint(20) unsigned NOT NULL,
  `total_retiro` decimal(10,2) NOT NULL,
  `metodo_retiro` enum('Efectivo','Transferencia','Tarjeta','Cheque') NOT NULL,
  `fecha_retiro` date DEFAULT NULL,
  `detalle_retiro` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `retiros_cliente_id_foreign` (`cliente_id`),
  CONSTRAINT `retiros_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retiros`
--

LOCK TABLES `retiros` WRITE;
/*!40000 ALTER TABLE `retiros` DISABLE KEYS */;
/*!40000 ALTER TABLE `retiros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'ADMINISTRADOR','web','2025-04-14 23:14:24','2025-04-14 23:14:24');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transacciones`
--

DROP TABLE IF EXISTS `transacciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transacciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pago_id` int(11) DEFAULT NULL,
  `retiro_id` int(11) DEFAULT NULL,
  `tipo_transaccion` enum('ingreso','egreso','movimiento interno') NOT NULL DEFAULT 'ingreso',
  `tipo_transaccion1` enum('ahorro inicial','pago ahorro','pago ahorro_parcial','pago prestamo','pago cuota_parcial','multa','precancelacion','retiro interes','retiro ahorro','prestamo','acumular','reverso_prestamo','reverso_pago') DEFAULT NULL,
  `detalle` varchar(255) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transacciones`
--

LOCK TABLES `transacciones` WRITE;
/*!40000 ALTER TABLE `transacciones` DISABLE KEYS */;
INSERT INTO `transacciones` VALUES (1,NULL,NULL,'ingreso','ahorro inicial','Ahorro inicial del Cliente: Manolo',1000.00,1000.00,'2025-04-14','2025-04-14 23:26:09','2025-04-14 23:26:09');
/*!40000 ALTER TABLE `transacciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin123','admin@admin.com',NULL,'$2y$12$uMocjFbor1tY6Mx.dqGbfuCk.CIFxxD/8FMkAP3EdIDKCmnwCM/ZC',NULL,'2025-04-14 23:14:25','2025-04-14 23:31:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-14 18:31:19
