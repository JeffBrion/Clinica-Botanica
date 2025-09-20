-- MySQL dump 10.13  Distrib 9.3.0, for macos15.2 (arm64)
--
-- Host: localhost    Database: Db_Clinica
-- ------------------------------------------------------
-- Server version	9.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_created_by_foreign` (`created_by`),
  KEY `categories_updated_by_foreign` (`updated_by`),
  CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Sistema Digestivo','Productos para el sistema digestivo y hepático',NULL,1,1,NULL,NULL),(2,'Sistema Reproductivo','Productos para el sistema reproductivo y hormonal',NULL,1,1,NULL,NULL),(3,'Sistema Nervioso','Productos para el sistema nervioso y relajantes',NULL,1,1,NULL,NULL),(4,'Sistema Respiratorio','Productos para el sistema respiratorio e inmunológico',NULL,1,1,NULL,NULL),(5,'Sistema Circulatorio','Productos para el sistema circulatorio y articular',NULL,1,1,NULL,NULL),(6,'Tés Específicos','Productos con ingredientes específicos y sabores',NULL,1,1,NULL,NULL),(7,'Aceites y productos naturales','Categoría para aceites y productos naturales como geles',NULL,1,1,NULL,NULL),(8,'Sistema Inmunológico','Productos relacionados con el fortalecimiento del sistema inmunológico',NULL,1,1,NULL,NULL),(9,'Articulaciones y Muscular','Productos para la salud articular y muscular',NULL,1,1,NULL,NULL),(10,'Suplementos e Inyecciones','Vitaminas, inyecciones y suplementos diversos',NULL,1,1,NULL,NULL),(11,'Cuidados personales y cosméticos','Productos para el cuidado personal como champús y aceites',NULL,1,1,NULL,NULL),(12,'Sistema inmune y antibióticos naturales','Productos para fortalecer el sistema inmune y antibióticos naturales',NULL,1,1,NULL,NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `inventories`
--

DROP TABLE IF EXISTS `inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_product_id` bigint unsigned NOT NULL,
  `requested_date` date NOT NULL,
  `quantity` int NOT NULL,
  `expiration_date` date NOT NULL,
  `observation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'No hay observaciones',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Agregado',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventories_supplier_product_id_foreign` (`supplier_product_id`),
  KEY `inventories_created_by_foreign` (`created_by`),
  KEY `inventories_updated_by_foreign` (`updated_by`),
  CONSTRAINT `inventories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `inventories_supplier_product_id_foreign` FOREIGN KEY (`supplier_product_id`) REFERENCES `supplier_products` (`id`),
  CONSTRAINT `inventories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventories`
--

LOCK TABLES `inventories` WRITE;
/*!40000 ALTER TABLE `inventories` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `items_code_unique` (`code`),
  KEY `items_category_id_foreign` (`category_id`),
  KEY `items_created_by_foreign` (`created_by`),
  KEY `items_updated_by_foreign` (`updated_by`),
  CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `items_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'Hepatico',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(2,'Manzanilla',NULL,NULL,6,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(3,'Menopausico',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(4,'Menstrual',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(5,'Respiratori',NULL,NULL,4,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(6,'Chancapiedra',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(7,'Jengibre canela',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(8,'Digestivo',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(9,'Artritis',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(10,'Adelgasante',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(11,'Pasiflora',NULL,NULL,3,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(12,'Prostata',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(13,'Renal',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(14,'Tilo',NULL,NULL,3,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(15,'Valeriana',NULL,NULL,3,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(16,'Boldo',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(17,'Cola de caballo',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(18,'Melisa',NULL,NULL,3,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(19,'Cardiovascular',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(20,'Antigripal',NULL,NULL,4,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(21,'Canela',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(22,'Verde',NULL,NULL,6,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(23,'Artritfin',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(24,'Antireumatico',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(25,'Circulacion',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(26,'Pies casados',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(27,'Acido urico',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(28,'Ajo/Apio y perejil',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(29,'Arcilla digestiva',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(30,'Artritis for',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(31,'Boldo',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(32,'Canela',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(33,'Caraña',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(34,'Cartiago de tiburn',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(35,'Cascabel',NULL,NULL,4,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(36,'Cascara sagrada',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(37,'Castaña de india',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(38,'Cla de caballo',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(39,'Colesterol',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(40,'Curcuma',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(41,'Desintoxi colon',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(42,'Diente de leon',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(43,'Equinacea',NULL,NULL,8,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(44,'Fenogreco',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(45,'Flor de tilo',NULL,NULL,3,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(46,'Gastritis',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(47,'Gingo biloba',NULL,NULL,3,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(48,'Helico bacter',NULL,NULL,8,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(49,'Hemorroy for',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(50,'Limpia colon',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(51,'Muerdago',NULL,NULL,8,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(52,'Ovarios',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(53,'Prostata',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(54,'Rompe piedra',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(55,'Sana colon',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(56,'Sana higado',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(57,'Trigliseridos',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(58,'Uña de gato',NULL,NULL,8,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(59,'Fibra adelazante',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(60,'Fibra limpieza de colon',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(61,'Batidos',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(62,'Linaza chia jamaica',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(63,'Trialsamo',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(64,'Ge de arnica',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(65,'Gel de mango',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(66,'Gel 7 plantas',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(67,'Varigel',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(68,'Artriel',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(69,'Antianemico',NULL,NULL,10,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(70,'Arcilla liquida',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(71,'Ama vid',NULL,NULL,10,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(72,'Pulmobron adulto',NULL,NULL,4,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(73,'Pulmobron niño',NULL,NULL,4,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(74,'Aceite de coco',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(75,'Aceite de almendras',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(76,'Aceite de rosas',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(77,'Aceite de aguacate',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(78,'Aceite de manzanilla',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(79,'AK. ART',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(80,'AK pulmon',NULL,NULL,4,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(81,'AK.preson',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(82,'AK colest.',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(83,'AK mujer',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(84,'AK diabetes',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(85,'SEX.dafil',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(86,'glucosamina',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(87,'colageno',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(88,'rabano yod',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(89,'kitatos',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(90,'limp.sangre',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(91,'ampolla bb',NULL,NULL,10,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(92,'foskrol gin',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(93,'seng',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(94,'mujer feliz',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(95,'gingo biloba',NULL,NULL,3,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(96,'mas ginseg',NULL,NULL,10,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(97,'cero stres',NULL,NULL,3,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(98,'en inyeccion',NULL,NULL,10,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(99,'compleben',NULL,NULL,10,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(100,'higado crudo',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(101,'inyeccion',NULL,NULL,10,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(102,'hepaceguel',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(103,'doloneurobion',NULL,NULL,10,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(104,'aceite argan',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(105,'aceite romero',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(106,'aceite oregano',NULL,NULL,7,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(107,'Acido urico',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(108,'Tiroidal',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(109,'Sex men',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(110,'Sabila lino sen',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(111,'Curcuma compuesta',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(112,'menopausia',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(113,'vesicula biliar',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(114,'energi full',NULL,NULL,10,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(115,'Renal power',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(116,'Normo precion',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(117,'gastro fin',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(118,'Colesterol y trigliseridos',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(119,'desparasitate',NULL,NULL,8,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(120,'ajo puro',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(121,'Sinusitis, gripe y tos',NULL,NULL,4,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(122,'ovaricomplex',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(123,'cola de caballo',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(124,'limpia colon e higado',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(125,'set de champu argan',NULL,NULL,11,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(126,'set de champu romero y aloe vera',NULL,NULL,11,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(127,'champu romero',NULL,NULL,11,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(128,'Boldo',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(129,'Chanca piedra',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(130,'Blodex',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(131,'Levadura de cerveza',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(132,'Cardo mariano',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(133,'Oxilam',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(134,'Esliwfat',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(135,'Colwax',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(136,'Eutirox',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(137,'Pilobacter',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(138,'Peptium',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(139,'Cramberri',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(140,'Cardioben',NULL,NULL,5,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(141,'Antibiotic',NULL,NULL,12,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(142,'Tiroccel',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(143,'Hepabil',NULL,NULL,8,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(144,'Urixan',NULL,NULL,8,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(145,'Reumanax',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(146,'Ciatic',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(147,'Strofen',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(148,'Uroprostat',NULL,NULL,2,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(149,'Power maca',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(150,'Ginseng pastilla',NULL,NULL,9,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(151,'Bronquial adulto',NULL,NULL,4,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(152,'Vitamina gr',NULL,NULL,10,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(153,'Bronquial kit',NULL,NULL,4,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07'),(154,'Liverplus',NULL,NULL,1,NULL,1,1,'2025-09-17 21:57:07','2025-09-17 21:57:07');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_09_12_084204_create_personal_access_tokens_table',1),(5,'2025_04_15_204533_create_items_table',1),(6,'2025_04_16_223844_create_suppliers_table',1),(7,'2025_04_18_222254_create_inventories_table',1),(8,'2025_05_13_213540_create_sales_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internal_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_route_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modules_created_by_foreign` (`created_by`),
  KEY `modules_updated_by_foreign` (`updated_by`),
  CONSTRAINT `modules_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `modules_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'Usuarios','users','users.index','bx bx-group nav_icon',NULL,NULL,'2025-09-17 21:11:48','2025-09-17 21:11:48'),(2,'Productos','items','items.index','bx bx-box nav_icon',NULL,NULL,'2025-09-17 21:11:48','2025-09-17 21:11:48'),(3,'Proveedores','suppliers','suppliers.index','bx bx-store nav_icon',NULL,NULL,'2025-09-17 21:11:48','2025-09-17 21:11:48'),(4,'Inventarios','inventories','inventories.index','bx bx-archive nav_icon',NULL,NULL,'2025-09-17 21:11:48','2025-09-17 21:11:48'),(5,'Ventas','sales','sales.index','bx bx-cart nav_icon',NULL,NULL,'2025-09-17 21:11:48','2025-09-17 21:11:48'),(6,'Reportes','reports','reports.index','bx bx-bar-chart-alt nav_icon',NULL,NULL,'2025-09-17 21:11:48','2025-09-17 21:11:48');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
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
-- Table structure for table `sales`
--


/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;


--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
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
INSERT INTO `sessions` VALUES ('ttoXuXbuUUbwLittTKcFbV0JbvpPnRIDJkkkQ2Sk',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoickVhdUxSRFZuZ2dWMHp5bm02V2hjN1p0VHloUnZpdVBNaDVvTGdYNiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3NhbGVzL2luZGV4Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnZlbnRvcmllcy9oaXN0b3J5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjg6InNhbGVEYXRhIjthOjI6e3M6ODoic3VwcGxpZXIiO3M6MTE6IlByb3ZlZWRvciAxIjtzOjU6Iml0ZW1zIjthOjI6e2k6MDthOjQ6e3M6NDoibmFtZSI7czoxMToiQWNpZG8gdXJpY28iO3M6ODoic3VwcGxpZXIiO3M6MjE6IkxhYm9yYXRvcmlvIFBST01FRElDUCI7czo4OiJxdWFudGl0eSI7czoxOiIxIjtzOjU6InByaWNlIjtzOjY6IjE0MC4wMCI7fWk6MTthOjQ6e3M6NDoibmFtZSI7czo2OiJDYW5lbGEiO3M6ODoic3VwcGxpZXIiO3M6MTk6IkxhYm9yYXRvcmlvIE1BTkFHVUEiO3M6ODoicXVhbnRpdHkiO3M6MjoiMjMiO3M6NToicHJpY2UiO3M6NjoiMTgwLjAwIjt9fX19',1758213371);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_products`
--

DROP TABLE IF EXISTS `supplier_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `buy_price` decimal(10,2) DEFAULT NULL,
  `sell_price` decimal(10,2) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_products_supplier_id_foreign` (`supplier_id`),
  KEY `supplier_products_item_id_foreign` (`item_id`),
  KEY `supplier_products_created_by_foreign` (`created_by`),
  KEY `supplier_products_updated_by_foreign` (`updated_by`),
  CONSTRAINT `supplier_products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `supplier_products_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `supplier_products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  CONSTRAINT `supplier_products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_products`
--

LOCK TABLES `supplier_products` WRITE;
/*!40000 ALTER TABLE `supplier_products` DISABLE KEYS */;
INSERT INTO `supplier_products` VALUES (1,1,1,75.00,160.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(2,1,2,64.00,140.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(3,1,3,70.00,150.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(4,1,4,70.00,150.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(5,1,5,66.00,150.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(6,1,6,70.00,150.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(7,1,7,79.00,170.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(8,1,8,74.00,160.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(9,1,9,75.00,160.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(10,1,10,74.00,160.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(11,1,11,68.00,150.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(12,1,12,75.00,160.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(13,1,13,75.00,160.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(14,1,14,65.00,140.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(15,1,15,70.00,150.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(16,1,16,69.00,150.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(17,1,17,65.00,140.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(18,1,18,65.00,140.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(19,1,19,75.00,160.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(20,1,20,65.00,140.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(21,1,21,88.00,190.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(22,1,22,85.00,180.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(23,1,23,90.00,190.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(24,1,24,90.00,190.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(25,1,25,90.00,190.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(26,1,26,90.00,190.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(27,2,27,60.00,140.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(28,2,28,65.00,140.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(29,2,29,50.00,155.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(30,2,30,65.00,140.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(31,2,31,55.00,120.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(32,3,32,90.00,180.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(33,3,33,90.00,180.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(34,3,34,90.00,180.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(35,3,35,90.00,180.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(36,3,36,90.00,180.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(37,3,37,90.00,180.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(38,4,38,70.00,150.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(39,4,39,68.00,150.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(40,4,40,90.00,190.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(41,4,41,80.00,170.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(42,4,42,85.00,180.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(43,5,43,109.00,220.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(44,5,44,167.00,340.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(45,5,45,167.00,380.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(46,5,46,212.00,430.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(47,5,47,155.00,310.00,NULL,NULL,NULL,'2025-09-17 22:11:13','2025-09-17 22:11:13'),(48,5,154,230.00,460.00,NULL,1,NULL,'2025-09-18 14:17:18','2025-09-18 14:17:18'),(49,5,6,167.00,340.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(50,5,16,109.00,220.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(51,5,31,109.00,220.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(52,5,128,109.00,220.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(53,5,130,167.00,380.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(54,5,131,212.00,430.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(55,5,132,155.00,310.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(56,5,133,116.00,240.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(57,5,134,184.00,370.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(58,5,135,184.00,370.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(59,5,136,187.00,380.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(60,5,137,198.00,410.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(61,5,138,187.00,380.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(62,5,139,225.00,460.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(63,5,140,184.00,370.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(64,5,141,198.00,410.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(65,5,142,192.00,410.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(66,5,143,184.00,370.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(67,5,144,187.00,370.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(68,5,145,184.00,370.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(69,5,146,198.00,400.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(70,5,147,172.00,350.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(71,5,148,184.00,370.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(72,5,149,184.00,370.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(73,5,150,271.00,550.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(74,5,151,230.00,460.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(75,5,152,271.00,460.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(76,5,153,235.00,470.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56'),(77,5,154,230.00,460.00,NULL,NULL,NULL,'2025-09-18 14:24:56','2025-09-18 14:24:56');
/*!40000 ALTER TABLE `supplier_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `promoter_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `suppliers_created_by_foreign` (`created_by`),
  KEY `suppliers_updated_by_foreign` (`updated_by`),
  CONSTRAINT `suppliers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `suppliers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Nicaté',NULL,'Laboratorio Nicaté',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-17 22:04:33','2025-09-17 22:04:33'),(2,'Laboratorio PROMEDICP',NULL,'Laboratorio PROMEDICP',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2025-09-17 22:04:33','2025-09-17 22:05:42'),(3,'Laboratorio MANAGUA',NULL,'Laboratorio MANAGUA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2025-09-17 22:04:33','2025-09-17 22:05:29'),(4,'Laboratorio RAMOS',NULL,'Laboratorio RAMOS',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2025-09-17 22:04:33','2025-09-17 22:05:14'),(5,'NATGREENSA',NULL,'Laboratorio NATGREENSA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-09-17 22:04:33','2025-09-17 22:04:33');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Usuario',
  `inss` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `worker_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `contract_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_created_by_foreign` (`created_by`),
  KEY `users_updated_by_foreign` (`updated_by`),
  CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `users_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','ilueilwitz@example.net','2025-09-17 21:11:48','$2y$12$F4Z08L0RO.yR4Y7J2IYCJuAnCzOKBRnwlmLyiARUaKbUh8DsOsCbq','Administrador',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Qun9qof3FR',NULL,NULL,'2025-09-17 21:11:48','2025-09-17 21:11:48');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_modules`
--

DROP TABLE IF EXISTS `users_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_modules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_modules_user_id_foreign` (`user_id`),
  KEY `users_modules_module_id_foreign` (`module_id`),
  KEY `users_modules_created_by_foreign` (`created_by`),
  KEY `users_modules_updated_by_foreign` (`updated_by`),
  CONSTRAINT `users_modules_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `users_modules_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_modules_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `users_modules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_modules`
--

LOCK TABLES `users_modules` WRITE;
/*!40000 ALTER TABLE `users_modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_modules` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-18 11:01:04
