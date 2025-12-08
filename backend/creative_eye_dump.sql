/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: creative_eye
-- ------------------------------------------------------
-- Server version	10.6.22-MariaDB-0ubuntu0.22.04.1

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `categoria_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'fotografia'),(2,'video'),(3,'objetivos'),(4,'accesorios');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2025_10_13_102340_create_roles_table',1),(2,'2025_10_13_102341_create_categorias_table',1),(3,'2025_10_13_102342_create_usuarios_table',1),(4,'2025_10_13_102343_create_productos_table',1),(5,'2025_10_13_102344_create_pedidos_table',1),(6,'2025_10_13_102345_create_pedidos_productos_table',1),(7,'2025_10_30_164513_create_personal_access_tokens_table',1),(8,'2025_11_12_210900_add_remember_token_to_usuarios_table',1),(9,'2025_12_08_115206_create_sessions_table',2),(10,'2025_12_08_115219_create_cache_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `pedido_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `fecha_pedido` date NOT NULL,
  `total_pedido` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pedido_id`),
  KEY `pedidos_usuario_id_foreign` (`usuario_id`),
  CONSTRAINT `pedidos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,3,'2025-12-08',358.90,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(2,4,'2025-12-05',798.00,'2025-12-08 12:07:30','2025-12-08 12:07:30');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos_productos`
--

DROP TABLE IF EXISTS `pedidos_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos_productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint(20) unsigned NOT NULL,
  `producto_id` bigint(20) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `precio_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedidos_productos_pedido_id_foreign` (`pedido_id`),
  KEY `pedidos_productos_producto_id_foreign` (`producto_id`),
  CONSTRAINT `pedidos_productos_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`pedido_id`) ON DELETE CASCADE,
  CONSTRAINT `pedidos_productos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos_productos`
--

LOCK TABLES `pedidos_productos` WRITE;
/*!40000 ALTER TABLE `pedidos_productos` DISABLE KEYS */;
INSERT INTO `pedidos_productos` VALUES (1,1,6,1,229.00,229.00,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(2,1,10,1,129.90,129.90,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(3,2,12,1,549.00,549.00,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(4,2,11,1,249.00,249.00,'2025-12-08 12:07:30','2025-12-08 12:07:30');
/*!40000 ALTER TABLE `pedidos_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
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
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `producto_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`producto_id`),
  UNIQUE KEY `productos_codigo_unique` (`codigo`),
  KEY `productos_categoria_id_foreign` (`categoria_id`),
  CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`categoria_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Canon EOS R6 Mark II (cuerpo)',5,2599.00,'CAM-CAN-R6M2-BODY','https://i.ibb.co/7JgXFbsP/Canon-EOS-R6-Mark-II-cuerpo.png','Cámara full-frame con excelente rendimiento en ráfaga y AF para fotografía deportiva y de eventos. Estabilización en el cuerpo (IBIS) y buen rendimiento en ISO alto.',1,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(2,'Fujifilm X-T5 (cuerpo)',8,1899.00,'CAM-FUJ-XT5-BODY','https://i.ibb.co/JwNwH63C/Fujifilm-X-T5.png','Cámara APS-C de 40MP con excelente color y sistema de simulación de película. Ideal para retrato y fotografía de estudio.',1,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(3,'Sony Alpha A7 IV (cuerpo)',4,2799.00,'CAM-SON-A7IV-BODY','https://i.ibb.co/84MLSxw4/Sony-Alpha-A7-IV.png','Híbrida full-frame 33MP con un balance entre foto y vídeo; AF avanzado y soporte amplio de lentes FE.',1,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(4,'Blackmagic Pocket Cinema Camera 6K G2',3,1995.00,'VID-BMD-P6KG2','https://i.ibb.co/V07MCG4d/Blackmagic-Pocket-Cinema-Camera-6-K-G2.png','Cámara de cine 6K con sensor Super 35, grabación en Blackmagic RAW y ProRes; pensada para producción de vídeo profesional y documentales.',2,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(5,'Panasonic Lumix S5 II (cuerpo)',4,1999.00,'VID-PAN-S5II','https://i.ibb.co/jkqgQgPH/Lumix-S5-II.png','Cámara mirrorless full-frame orientada a vídeo: estabilización, perfiles log y buena gestión térmica para tomas largas.',2,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(6,'Canon RF 50mm f/1.8 STM',15,229.00,'LEN-CAN-RF50F18','https://i.ibb.co/LhrscwkK/Canon-RF-50mm-f-1-8-STM.png','Pequeño y ligero \"nifty fifty\" para montura RF. Buen rendimiento en retrato y baja luz, relación calidad-precio excelente.',3,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(7,'Sony FE 24-70mm f/2.8 GM II',3,2399.00,'LEN-SON-2470GM2','https://i.ibb.co/7dzkwR90/Sony-FE-24-70mm-f2-8-GMII.png','Zoom estándar profesional con excelente nitidez y sellado climático; ideal para bodas, eventos y producción comercial.',3,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(8,'Sigma 18-35mm f/1.8 DC HSM Art (Canon EF)',6,799.00,'LEN-SIG-1835ART-EF','https://i.ibb.co/8Dw1LTkW/sigma-18-35mm-f18-dc-hsm-art.png','Objetivo luminoso para APS-C; muy valorado en vídeo por su apertura constante y calidad óptica.',3,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(9,'Trípode Manfrotto Befree Advanced',10,199.00,'ACC-MAN-BEFREE-ADV','https://i.ibb.co/HDtCqKkd/Tr-pode-Manfrotto-Befree-Advanced.png','Trípode compacto y resistente, pensado para viajar. Compatible con cámaras mirrorless y DSLR ligeras.',4,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(10,'Tarjeta SDXC 128GB UHS-II V90',25,129.90,'ACC-SDXC-128-V90','https://i.ibb.co/939hnxNb/tarjeta-SDXC-128-GB-UHS-II-V90.png','Tarjeta de alta velocidad para grabaciones 4K/6K y ráfagas prolongadas; indicada para cámaras profesionales.',4,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(11,'Rode VideoMic NTG',7,249.00,'ACC-ROD-VIDNTG','https://i.ibb.co/DfcGWgYb/Rode-Video-Mic-NTG.png','Micrófono shotgun híbrido con salida TRS y USB; ideal para creadores de contenido y vídeos en exteriores.',4,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(12,'DJI RS 4 (gimbal)',2,549.00,'ACC-DJI-RS4','https://i.ibb.co/p6BGNnPb/DJI-RS-4-gimbal.png','Estabilizador 3 ejes para cámaras mirrorless y DSLR ligeras; buen soporte de carga y modos de seguimiento.',4,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(13,'Monopié Cayer',15,120.00,'ACC-CAY-MP22','https://i.ibb.co/ynVYxcCZ/Monopi-Cayer.png','Monopié profesional de aleación de aluminio con cierre rápido y base plegable. Ideal para fotografía deportiva y de naturaleza. Soporta hasta 10 kg y cuenta con empuñadura antideslizante.',4,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(14,'Sony FE 70-200mm f/2.8 GM OSS II',8,2599.00,'LEN-SON-GMII','https://i.ibb.co/dJ4K5QXs/Sony-70-200-2-8-GMII.png','Teleobjetivo zoom de la serie G Master con apertura constante f/2.8. Enfoque automático rápido y silencioso, elementos XA para máxima nitidez, y recubrimiento Nano AR II que reduce reflejos y destellos. Ideal para deportes, retratos y naturaleza.',3,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(15,'Sony FX3 Cinema Line',3,4599.00,'CAM-SON-FX3-BODY','https://i.ibb.co/TD516Q2Q/Sony-FX3.png','Cámara de cine compacta con sensor full-frame Exmor R de 10.2 MP, grabación 4K hasta 120p, ISO extendido hasta 409.600, montura E y diseño con ventilador activo. Pensada para producciones cinematográficas y creadores de contenido profesionales.',2,'2025-12-08 12:07:30','2025-12-08 12:07:30'),(16,'prueba inmacu',1,0.05,'dfsdf','/storage/product-photos/lvSshaCHb4GiN670TyV8m5zO5cf5fFaJS77QJIee.png','lada concecpcion',1,'2025-12-08 12:19:26','2025-12-08 12:19:26');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `rol_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrador'),(2,'almacen'),(3,'cliente');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `usuario_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `nombre_usuario` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rol_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuarios_nombre_usuario_unique` (`nombre_usuario`),
  KEY `usuarios_rol_id_foreign` (`rol_id`),
  CONSTRAINT `usuarios_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`rol_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Administrador','admin@creative.es','uVlwTkd4jJp1RAvUkl2KBYrGAAZbEYFu5X4zmXGq.jpg','$2y$12$90Re.wbndXuoOLuYbSTgL.gyi/t0fyrZKC.jruRAazDEWZ6zUBsKe',1,'2025-12-08 12:07:30','2025-12-08 12:07:30',NULL),(2,'Responsable Almacén','almacen@creative.es','h02KJMnibFnQnvMlVPxIW332W5EcTGOsNa4qEmBq.jpg','$2y$12$90Re.wbndXuoOLuYbSTgL.gyi/t0fyrZKC.jruRAazDEWZ6zUBsKe',2,'2025-12-08 12:07:30','2025-12-08 12:18:22',NULL),(3,'José Fernández','jose@creative.es','265b2RLNmizvMsNbVPGhg2oJKQ7T7WvhhhUdO8Ib.jpg','$2y$12$90Re.wbndXuoOLuYbSTgL.gyi/t0fyrZKC.jruRAazDEWZ6zUBsKe',3,'2025-12-08 12:07:30','2025-12-08 12:07:30',NULL),(4,'Laura Gómez','laura@creative.es','df9Nj2KJDPie4X5JWHbQJaDDNS30r1UhKAOd5VqO.jpg','$2y$12$90Re.wbndXuoOLuYbSTgL.gyi/t0fyrZKC.jruRAazDEWZ6zUBsKe',3,'2025-12-08 12:07:30','2025-12-08 12:07:30',NULL),(5,'Juan Palomo','juan@administrador.com','hH6Ugb2pDiaXVPSkgrZioBsYjMjSaHZHuFOZU3dX.jpg','$2y$12$90Re.wbndXuoOLuYbSTgL.gyi/t0fyrZKC.jruRAazDEWZ6zUBsKe',1,'2025-12-08 12:07:30','2025-12-08 12:07:30',NULL),(6,'José Gomez','jose@almacen.com','jSdOijHti6PMFthJ7WtAaNxV9eM9ki0EdbR2On0B.jpg','$2y$12$90Re.wbndXuoOLuYbSTgL.gyi/t0fyrZKC.jruRAazDEWZ6zUBsKe',2,'2025-12-08 12:07:30','2025-12-08 12:07:30',NULL),(7,'Pedro Navaja','pedro@cliente.com','avJuCsYTBYIeIlcUWObDS4wIQ3SNE2S5hyw2kdMu.jpg','$2y$12$90Re.wbndXuoOLuYbSTgL.gyi/t0fyrZKC.jruRAazDEWZ6zUBsKe',3,'2025-12-08 12:07:30','2025-12-08 12:07:30',NULL),(8,'Carlos Gomez','carlitos@cliente.com','XUnc1JUVH7FKhIELZ3FuwqeOLH8JgxiKv1o9JNvW.jpg','$2y$12$90Re.wbndXuoOLuYbSTgL.gyi/t0fyrZKC.jruRAazDEWZ6zUBsKe',3,'2025-12-08 12:07:30','2025-12-08 12:07:30',NULL),(9,'Letizia Mallorca','leti@cliente.com','2IrEgZI6HD5cZpF1O6b6yxsfGNL4qXVFvFVN8EnA.jpg','$2y$12$90Re.wbndXuoOLuYbSTgL.gyi/t0fyrZKC.jruRAazDEWZ6zUBsKe',3,'2025-12-08 12:07:30','2025-12-08 12:07:30',NULL),(10,'Carolina Papaleo','carol@cliente.com','HlV4YAYk9XFW9URF4gUMCm0aiEpVVyOwuycCuZVj.jpg','$2y$12$90Re.wbndXuoOLuYbSTgL.gyi/t0fyrZKC.jruRAazDEWZ6zUBsKe',3,'2025-12-08 12:07:30','2025-12-08 12:07:30',NULL),(11,'Eva Gonzalez','eva@cliente.com','uOJklB7nkOSjBSgTOtZkWB3F24yaqU3zZkniew7I.jpg','$2y$12$90Re.wbndXuoOLuYbSTgL.gyi/t0fyrZKC.jruRAazDEWZ6zUBsKe',3,'2025-12-08 12:07:30','2025-12-08 12:07:30',NULL),(12,'david','david@cliente.es','almacenista.jpg','$2y$12$4Uxj.ec1x9ECLZXgUBQqwuypZRGfITWvGFcDSW8iTPLv4youEoMVW',3,'2025-12-08 12:20:42','2025-12-08 12:20:42',NULL),(13,'flash gordon','flash@creative.es','0684456b-aa2b-4631-86f7-93ceaf33303c.jpg','$2y$12$3RuBLnwjnd5dftAaySs8NuzYHq0bU0TevZa5oz4a6qPWnk2imiQg6',3,'2025-12-08 12:28:48','2025-12-08 12:28:48',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-08 12:46:00
