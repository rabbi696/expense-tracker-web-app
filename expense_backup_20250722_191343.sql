-- MySQL dump 10.13  Distrib 8.0.40, for macos14 (arm64)
--
-- Host: 127.0.0.1    Database: expense
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bills` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `frequency` enum('daily','weekly','monthly','quarterly','yearly') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bills_user_id_foreign` (`user_id`),
  CONSTRAINT `bills_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
INSERT INTO `bills` VALUES (1,4,'APA',3500.00,'2025-07-06','monthly',1,'2025-07-08 11:59:15','2025-07-08 11:59:28'),(2,4,'Service Charge',3000.00,'2025-07-06','monthly',1,'2025-07-08 11:59:43','2025-07-08 11:59:56'),(3,4,'House Rent',8000.00,'2025-07-08','monthly',1,'2025-07-08 12:03:36','2025-07-10 00:37:39');
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Rice',NULL,'2025-07-08 11:46:51','2025-07-08 11:46:51'),(2,'Chicken',NULL,'2025-07-08 11:47:01','2025-07-08 11:47:01'),(3,'Beef',NULL,'2025-07-08 11:47:04','2025-07-08 11:47:04'),(4,'Soyabean Oil',NULL,'2025-07-08 11:47:10','2025-07-08 11:47:10'),(5,'Grocery',NULL,'2025-07-08 11:47:18','2025-07-08 11:47:18'),(6,'Gas',NULL,'2025-07-08 11:47:32','2025-07-08 11:47:32'),(7,'Others',NULL,'2025-07-08 11:47:40','2025-07-08 11:47:40'),(8,'Fish',NULL,'2025-07-08 11:47:45','2025-07-08 11:47:45'),(9,'Bills',NULL,'2025-07-08 11:59:28','2025-07-08 11:59:28');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `receipt_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_from` enum('Supershop','eCommerce','Bazar') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned_to_user_id` bigint unsigned DEFAULT NULL,
  `expense_date` date NOT NULL,
  `is_group_expense` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` bigint unsigned DEFAULT NULL,
  `bill_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_user_id_foreign` (`user_id`),
  KEY `expenses_assigned_to_user_id_foreign` (`assigned_to_user_id`),
  KEY `expenses_category_id_foreign` (`category_id`),
  KEY `expenses_bill_id_foreign` (`bill_id`),
  CONSTRAINT `expenses_assigned_to_user_id_foreign` FOREIGN KEY (`assigned_to_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `expenses_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE SET NULL,
  CONSTRAINT `expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (1,4,189.00,NULL,NULL,'Supershop','2025-07-08 11:49:47','2025-07-08 11:49:47',4,'2025-07-02',0,4,NULL),(2,4,612.00,NULL,NULL,'Supershop','2025-07-08 11:50:12','2025-07-08 11:50:12',4,'2025-07-02',0,5,NULL),(3,4,492.00,NULL,NULL,'Supershop','2025-07-08 11:50:33','2025-07-08 11:50:33',4,'2025-07-03',0,1,NULL),(4,4,683.00,'Garbage Poli, Tiles Cleaner, Tape, Handwash, Wall Hanger',NULL,'eCommerce','2025-07-08 11:58:34','2025-07-08 11:58:34',4,'2025-07-04',0,7,NULL),(5,4,3500.00,'Bill payment: APA',NULL,NULL,'2025-07-08 11:59:28','2025-07-08 11:59:28',4,'2025-07-08',0,9,1),(6,4,3000.00,'Bill payment: Service Charge',NULL,NULL,'2025-07-08 11:59:56','2025-07-08 11:59:56',4,'2025-07-08',0,9,2),(7,4,189.00,NULL,NULL,'Supershop','2025-07-08 15:13:52','2025-07-08 15:13:52',4,'2025-07-08',0,4,NULL),(8,4,366.00,NULL,NULL,'Supershop','2025-07-08 15:15:46','2025-07-08 15:15:46',4,'2025-07-08',0,5,NULL),(9,4,8000.00,NULL,NULL,NULL,'2025-07-10 00:37:39','2025-07-10 00:52:15',4,'2025-07-09',0,9,3),(10,4,415.00,NULL,NULL,'Supershop','2025-07-10 00:51:56','2025-07-10 00:51:56',4,'2025-07-09',0,8,NULL),(11,4,245.00,'Toilet Cleaner, Notepad, Vim',NULL,'Supershop','2025-07-10 00:53:40','2025-07-10 00:53:40',4,'2025-07-09',0,7,NULL),(12,4,425.00,NULL,NULL,'Supershop','2025-07-17 10:50:29','2025-07-17 10:50:29',4,'2025-07-13',0,1,NULL),(13,4,227.00,NULL,NULL,'Supershop','2025-07-17 10:50:55','2025-07-17 10:50:55',4,'2025-07-13',0,7,NULL),(14,4,767.00,NULL,NULL,'Supershop','2025-07-17 10:52:29','2025-07-17 10:52:29',4,'2025-07-16',0,8,NULL),(15,4,156.00,NULL,NULL,'Supershop','2025-07-17 10:53:19','2025-07-17 10:53:19',4,'2025-07-16',0,5,NULL),(16,4,166.00,'Mango',NULL,'Supershop','2025-07-17 10:53:47','2025-07-17 10:53:47',4,'2025-07-16',0,7,NULL),(17,4,189.00,NULL,NULL,'Supershop','2025-07-20 09:32:49','2025-07-20 09:32:49',4,'2025-07-18',0,4,NULL),(18,4,235.00,'Turmeric+Bazar',NULL,'Supershop','2025-07-20 09:34:38','2025-07-20 09:34:38',4,'2025-07-18',0,5,NULL),(19,4,1530.00,NULL,NULL,'Bazar','2025-07-20 09:35:55','2025-07-20 09:35:55',4,'2025-07-19',0,6,NULL),(20,4,245.00,NULL,NULL,'Supershop','2025-07-22 03:22:40','2025-07-22 03:22:40',4,'2025-07-21',0,5,NULL);
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
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
-- Table structure for table `incomes`
--

DROP TABLE IF EXISTS `incomes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incomes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned_to_user_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `incomes_user_id_foreign` (`user_id`),
  KEY `incomes_assigned_to_user_id_foreign` (`assigned_to_user_id`),
  CONSTRAINT `incomes_assigned_to_user_id_foreign` FOREIGN KEY (`assigned_to_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `incomes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incomes`
--

LOCK TABLES `incomes` WRITE;
/*!40000 ALTER TABLE `incomes` DISABLE KEYS */;
INSERT INTO `incomes` VALUES (1,4,1000.00,'2025-07-02',NULL,'2025-07-08 12:00:53','2025-07-08 12:00:53',4),(2,4,1000.00,'2025-07-03',NULL,'2025-07-08 12:01:02','2025-07-08 12:01:37',4),(3,4,2000.00,'2025-07-04',NULL,'2025-07-08 12:01:11','2025-07-08 12:01:42',4),(4,4,1500.00,'2025-07-05',NULL,'2025-07-08 12:01:23','2025-07-08 12:01:54',4),(5,4,3000.00,'2025-07-06',NULL,'2025-07-08 12:02:20','2025-07-08 12:02:20',4),(6,4,531.00,'2025-07-08',NULL,'2025-07-08 15:17:19','2025-07-08 15:17:19',4),(7,4,8000.00,'2025-07-09','House rent','2025-07-10 00:55:30','2025-07-10 00:55:30',4),(8,4,660.00,'2025-07-09','Grocery','2025-07-10 00:56:11','2025-07-10 00:56:11',4),(10,4,652.00,'2025-07-13',NULL,'2025-07-17 10:54:41','2025-07-17 10:54:41',4),(11,4,189.00,'2025-07-16',NULL,'2025-07-17 10:55:09','2025-07-17 10:55:09',4),(12,4,424.00,'2025-07-18',NULL,'2025-07-20 09:35:10','2025-07-20 09:35:10',4),(13,4,1530.00,'2025-07-19','Gas','2025-07-20 09:36:12','2025-07-20 09:36:12',4),(14,4,245.00,'2025-07-21',NULL,'2025-07-22 03:22:52','2025-07-22 03:22:52',4),(15,4,900.00,'2025-07-12','adjust','2025-07-22 04:49:37','2025-07-22 04:49:37',4),(16,5,6432.00,'2025-07-10','Bank Transfer','2025-07-22 05:20:34','2025-07-22 05:20:34',5);
/*!40000 ALTER TABLE `incomes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('pending','paid','overdue') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  KEY `invoices_user_id_foreign` (`user_id`),
  CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_07_04_210033_add_role_to_users_table',1),(5,'2025_07_04_210119_create_categories_table',1),(6,'2025_07_04_210120_create_expenses_table',1),(7,'2025_07_04_212416_add_assigned_to_user_id_to_expenses_table',1),(8,'2025_07_04_212712_add_monthly_allocation_to_users_table',1),(9,'2025_07_04_213041_create_debts_table',1),(10,'2025_07_04_213113_add_is_group_expense_to_expenses_table',1),(11,'2025_07_04_213414_create_bills_table',1),(12,'2025_07_04_213635_add_notes_to_expenses_table',1),(13,'2025_07_04_213823_create_incomes_table',1),(14,'2025_07_04_214118_add_is_tax_deductible_to_categories_table',1),(15,'2025_07_04_215233_create_invoices_table',1),(16,'2025_07_04_221859_remove_is_tax_deductible_from_categories_table',1),(17,'2025_07_04_222824_add_expense_date_to_expenses_table',1),(18,'2025_07_04_223017_make_expense_date_non_nullable_in_expenses_table',1),(19,'2025_07_04_224803_add_assigned_to_user_id_to_incomes_table',1),(20,'2025_07_04_225433_add_notes_to_incomes_table',1),(21,'2025_07_04_225517_remove_source_from_incomes_table',1),(22,'2025_07_04_230101_remove_payment_method_from_expenses_table',1),(23,'2025_07_04_231108_add_purchase_from_to_expenses_table',1),(24,'2025_07_04_231904_remove_notes_from_expenses_table',1),(25,'2025_07_04_232711_remove_is_group_expense_from_expenses_table',1),(26,'2025_07_04_235202_create_expense_category_table',1),(27,'2025_07_04_235313_remove_category_id_from_expenses_table',1),(28,'2025_07_05_023501_add_is_group_expense_to_expenses_table',1),(29,'2025_07_05_163646_add_category_id_to_expenses_table',1),(30,'2025_07_05_163725_drop_expense_category_table',1),(31,'2025_07_05_183839_add_bill_id_to_expenses_table',1),(32,'2025_07_22_112533_drop_debts_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('E57KjipUycIdCiuNawxgfTkABdDbUKvDop9W7Dty',4,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUXJHN1hCbnBBSG1UZGszckVIREpkVFF1dEVZT2d2akRER3lSQ21qMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9leHBlbnNlLXRyYWNrZXItYXBwLnRlc3QvcmVwb3J0cy91c2VyLzQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1MzE4OTAxODt9fQ==',1753189047);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `monthly_allocation` decimal(10,2) NOT NULL DEFAULT '0.00',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Admin','admin@solveez.com','admin',0.00,NULL,'$2y$12$KYr77EOhdx5a1uCMz9Trn./gmUS6NULDAJQZ.w0hg5eY.T770fMm6',NULL,'2025-07-08 02:00:22','2025-07-08 02:35:48'),(4,'Rabbi','rabbi@solveez.com','user',0.00,NULL,'$2y$12$fwXVaO2Yaa2xQbD6hTXZ.es9.xvOAd87lMcIC.qHRuI98sB3gLi4G','n6LebHOVT25tUZLpiNAEBKxnEiMJiaDngwkwoYd6sEf7knz9kw0yI9A75kiD','2025-07-08 11:48:38','2025-07-08 11:48:38'),(5,'Faisal','faisal@solveez.com','user',0.00,NULL,'$2y$12$GNebYXDcja74WBTRmV7n0OAZ2X.qmp/V5mmPJuy9Af8HZLpe9c27O','aLWNuG4hQceOiw5ZK3LWJoO7B9zSs29C2r40wl1HrVset3XxtF47fQNwiGDB','2025-07-08 11:48:58','2025-07-08 11:48:58');
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

-- Dump completed on 2025-07-22 19:13:43
