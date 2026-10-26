-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_sanitasi
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `babs`
--

DROP TABLE IF EXISTS `babs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `babs` (
  `id_babs` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_rt` bigint(20) unsigned NOT NULL,
  `pembuangan` int(11) NOT NULL,
  `simpan_keterangan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_babs`),
  KEY `babs_id_rt_foreign` (`id_rt`),
  CONSTRAINT `babs_id_rt_foreign` FOREIGN KEY (`id_rt`) REFERENCES `rumah_tanggas` (`id_rt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `babs`
--

LOCK TABLES `babs` WRITE;
/*!40000 ALTER TABLE `babs` DISABLE KEYS */;
/*!40000 ALTER TABLE `babs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
-- Table structure for table `jalans`
--

DROP TABLE IF EXISTS `jalans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jalans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kelurahan` varchar(255) NOT NULL,
  `nama_jalan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jalans`
--

LOCK TABLES `jalans` WRITE;
/*!40000 ALTER TABLE `jalans` DISABLE KEYS */;
/*!40000 ALTER TABLE `jalans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `komunal`
--

DROP TABLE IF EXISTS `komunal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `komunal` (
  `id_komunal` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `kelurahan` varchar(100) NOT NULL,
  `rw` varchar(10) NOT NULL,
  `rt` varchar(10) NOT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `nama_fasilitas` varchar(100) NOT NULL,
  `nama_sistem` varchar(100) DEFAULT NULL,
  `bilik_mandi` int(11) DEFAULT 0,
  `jml_wc` int(11) DEFAULT 0,
  `jarak_air` varchar(50) DEFAULT NULL,
  `kondisi_fisik` varchar(100) DEFAULT NULL,
  `kondisi_air` varchar(100) DEFAULT NULL,
  `status_kelayakan` varchar(50) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  PRIMARY KEY (`id_komunal`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `komunal_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `komunal`
--

LOCK TABLES `komunal` WRITE;
/*!40000 ALTER TABLE `komunal` DISABLE KEYS */;
INSERT INTO `komunal` VALUES (2,1,'Mojoroto','RW 01','RT 01','64112','MCK Komunal Barokah','Sistem IPAL Komunal',4,2,'Lebih dari 15 Meter (Sangat Layak)','Aman','Lancar','Layak',-7.8165027999781,112.00368404388,'2026-07-02 01:24:45','2026-07-02 01:24:45','Jl. Mojoroto Gang 4, RT 01 / RW 01, Kode Pos: 64112'),(3,1,'Lirboyo','RW 01','RT 27','64117','MCK Umum Anggrek','MCK Umum Bersama',3,4,'Lebih dari 15 Meter (Sangat Layak)','Aman','Lancar','Layak',-7.8169067075331,112.00298309326,'2026-07-02 08:59:42','2026-07-02 08:59:42','Pilih Jalan, RT 27 / RW 01, Kode Pos: 64117'),(4,1,'Lirboyo','RW 09','RT 07','64117','Fasilitas Komunal Desa Lirboyo','MCK Umum Bersama',4,3,'Kurang dari 10 Meter (Risiko Tinggi)','Aman','Lancar','Layak',-7.8153902806567,111.99460744858,'2026-07-03 05:50:15','2026-07-03 05:50:15','Kawasan Pondok Lirboyo, RT 07 / RW 09, Kode Pos: 64117'),(5,1,'Pojok','RW 06','RT 07','64115','Sanitasi Pojok','Sistem IPAL Komunal',3,2,'Lebih dari 15 Meter (Sangat Layak)','Aman','Lancar','Layak',-7.8021536,111.9800079,'2026-07-13 04:19:42','2026-07-13 04:19:42','Jl. Selomangleng, RT 07 / RW 06, Kode Pos: 64115');
/*!40000 ALTER TABLE `komunal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan`
--

DROP TABLE IF EXISTS `laporan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_komunal` int(11) NOT NULL,
  `alamat_mck` text NOT NULL,
  `deskrip_masalah` text NOT NULL,
  `status_kelayakan` varchar(50) NOT NULL,
  `kondisi_buangan` varchar(100) DEFAULT NULL,
  `kebersihan` varchar(100) DEFAULT NULL,
  `status_perbaikan` varchar(100) NOT NULL DEFAULT 'Pending',
  `foto_bukti` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_laporan`),
  KEY `id_user` (`id_user`),
  KEY `id_komunal` (`id_komunal`),
  CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`id_komunal`) REFERENCES `komunal` (`id_komunal`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan`
--

LOCK TABLES `laporan` WRITE;
/*!40000 ALTER TABLE `laporan` DISABLE KEYS */;
INSERT INTO `laporan` VALUES (1,1,2,'MCK Komunal Barokah','tidak ada masalah','Layak','Baik / Tertutup','Bersih Terawat','belum','1782981513_laporan_foto_bukti_mck_1782981492840.jpg','2026-07-02 01:38:33','2026-07-08 06:48:27'),(2,1,4,'Fasilitas Komunal Desa Lirboyo','Hasjhahahav','Layak','Baik / Tertutup','Bersih Terawat','proses','1783059553_laporan_foto_bukti_mck_1783059526757.jpg','2026-07-03 06:19:13','2026-07-08 06:48:39'),(3,1,3,'MCK Umum Anggrek','Bajnahavhb','Layak','Baik / Tertutup','Bersih Terawat','Tidak / Ringan','1783059609_laporan_foto_bukti_mck_1783059587985.jpg','2026-07-03 06:20:09','2026-07-03 06:20:09');
/*!40000 ALTER TABLE `laporan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2026_06_01_000001_add_username_to_users_table',1),(6,'2026_06_01_113505_create_rumah_tanggas_table',1),(7,'2026_06_01_113506_create_babs_table',1),(8,'2026_07_09_094758_create_jalans_table',2),(9,'2026_07_09_213708_add_kelurahan_to_user_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
-- Table structure for table `rumah_tangga`
--

DROP TABLE IF EXISTS `rumah_tangga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rumah_tangga` (
  `id_rt` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `kelurahan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_kk` varchar(30) NOT NULL,
  `kepala_keluarga` varchar(150) NOT NULL,
  `jml_penghuni` int(11) DEFAULT 1,
  `kepemilikan_jamban` varchar(100) NOT NULL,
  `jenis_jamban` varchar(100) NOT NULL,
  `status_kelayakan` varchar(50) NOT NULL,
  `pembuangan` varchar(100) DEFAULT NULL,
  `riwayat_sedot` varchar(100) DEFAULT NULL,
  `greywater` varchar(100) DEFAULT NULL,
  `jarak_air` varchar(50) DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `foto_dokumen` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rt`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `rumah_tangga_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rumah_tangga`
--

LOCK TABLES `rumah_tangga` WRITE;
/*!40000 ALTER TABLE `rumah_tangga` DISABLE KEYS */;
INSERT INTO `rumah_tangga` VALUES (1,1,'Mojoroto','Jl. Penanggungan, RT 03 / RW 02, Kode Pos: 64112','3506012345670001','Bapak Supriyadi',3,'sendiri','leher angsa','Layak','tangki septic','Belum Pernah Disedot','Saluran Tertutup','≥ 10 Meter (Aman)',112.00267553,-7.81616267,'1782978742_dokumen_FOTO_RT_1782978483283.jpg6891164304751676377.jpg','2026-07-02 00:52:22','2026-07-02 00:52:22'),(2,1,'Pojok','Jl. Tembus, RT 24 / RW 05, Kode Pos: 64115','1234568736920001','Bapak Samuji',3,'sendiri','leher angsa','Layak','tangki septic','Pernah disedot (1 Kali), Waktu Terakhir: Kurang dari 3 tahun lalu','Saluran Tertutup','≥ 10 Meter (Aman)',111.98710286,-7.81643372,'1782982599_dokumen_SRV_6905121723953359990.jpg','2026-07-02 08:56:39','2026-07-02 08:56:39'),(3,1,'Pojok','Perum Wilis Indah, RT 01 / RW 01, Kode Pos: 64115','3162998589710001','Bapak Suwardi',3,'sendiri','leher angsa','Layak','tangki septic','Belum Pernah Disedot','Saluran Tertutup','≥ 10 Meter (Aman)',111.98250532,-7.81636108,'1783055869_dokumen_SRV_4388978043231780542.jpg','2026-07-03 05:17:51','2026-07-03 05:17:51'),(4,1,'Pojok','Perum Wilis Indah, RT 01 / RW 01, Kode Pos: 64115','3162998589710001','Bapak Suwardi',3,'sendiri','leher angsa','Layak','tangki septic','Belum Pernah Disedot','Saluran Tertutup','≥ 10 Meter (Aman)',111.98250532,-7.81636108,'1783055874_dokumen_SRV_4388978043231780542.jpg','2026-07-03 05:17:54','2026-07-03 05:17:54'),(5,1,'Lirboyo','Gang 2, RT 08 / RW 06, Kode Pos: 64117','6618369485800003','Bapak Sutanto',3,'sendiri','leher angsa','Layak','tangki septic','Belum Pernah Disedot','Saluran Tertutup','≥ 10 Meter (Aman)',111.99492216,-7.81886955,'1783055973_dokumen_SRV_647431268323520418.jpg','2026-07-03 05:19:33','2026-07-03 05:19:33'),(6,1,'Lirboyo','Kawasan Pondok Lirboyo, RT 01 / RW 01, Kode Pos: 64117','649494','Bapak Toha',1,'menumpang','plengsengan','Tidak Layak','lubang tanah','Belum Pernah Disedot','Masuk ke Sumur Resapan','< 10 Meter (Tidak Aman)',111.99477911,-7.81613432,'1783056295_dokumen_SRV_2788980794988592267.jpg','2026-07-03 05:24:55','2026-07-03 05:24:55'),(7,1,'Pojok','Pilih Jalan, RT 05 / RW 01, Kode Pos: 64115','6666222211118888','Mastri',3,'sendiri','leher angsa','Layak','tangki septic','Pernah disedot (1 Kali), Waktu Terakhir: Kurang dari 3 tahun lalu','Saluran Tertutup','≥ 10 Meter (Aman)',111.9773978,-7.8208537,'1783569579_dokumen_SRV_1681057660026252147.jpg','2026-07-09 03:59:45','2026-07-09 03:59:45'),(8,1,'Pojok','Pilih Jalan, RT 05 / RW 01, Kode Pos: 64115','6666222211118888','Mastri',3,'sendiri','leher angsa','Layak','tangki septic','Pernah disedot (1 Kali), Waktu Terakhir: Kurang dari 3 tahun lalu','Saluran Tertutup','≥ 10 Meter (Aman)',111.9773978,-7.8208537,'1783569585_dokumen_SRV_1681057660026252147.jpg','2026-07-09 03:59:45','2026-07-09 03:59:45'),(10,1,'Pojok','Jalan Lingkar Maskumambang, RT 02 / RW 04, Kode Pos: 64115','3333222244448888','Mariadi',3,'sendiri','leher angsa','Layak','tangki septic','Pernah disedot (1 Kali), Waktu Terakhir: Kurang dari 3 tahun lalu','Saluran Tertutup','≥ 10 Meter (Aman)',111.9798571,-7.8020916,'1783922262_dokumen_SRV_1515713679925389004.jpg','2026-07-13 05:57:43','2026-07-13 05:57:43'),(11,1,'Pojok','Jl. Lingkar Maskumambang, RT 01 / RW 01, Kode Pos: 64115','3333666655558888','Mariadi',3,'sendiri','leher angsa','Layak','tangki septic','Pernah disedot (1 Kali), Waktu Terakhir: 3 tahun yang lalu','Saluran Tertutup','≥ 10 Meter (Aman)',112.01,-7.816,'1783922532_dokumen_SRV_4476421034670638118.jpg','2026-07-13 06:02:12','2026-07-13 06:02:12'),(12,1,'Pojok','Jalan Lingkar Maskumambang, RT 01 / RW 01, Kode Pos: 64115','4362158236910007','Suryanto',5,'sendiri','leher angsa','Layak','tangki septic','Pernah disedot (1 Kali), Waktu Terakhir: Kurang dari 3 tahun lalu','Saluran Tertutup','≥ 10 Meter (Aman)',111.9798844,-7.8020802,'1783923593_6a548389287d0_dokumen_SRV_7094958575631197933.jpg,1783923593_6a5483892f02b_dokumen_SRV_4423231391508290165.jpg','2026-07-13 06:19:53','2026-07-13 06:19:53'),(13,1,'Pojok','Jl. Lingkar Maskumambang, RT 05 / RW 06, Kode Pos: 64115','3695258014720001','Darsa',3,'sendiri','plengsengan','Tidak Layak','tangki septic','Belum Pernah Disedot','Saluran Terbuka','< 10 Meter (Tidak Aman)',111.9798844,-7.8020802,'1783924211_6a5485f320f71_dokumen_SRV_541371737296905007.jpg,1783924211_6a5485f3267d5_dokumen_SRV_6335520754236679126.jpg,1783924211_6a5485f326f0b_dokumen_SRV_6241338912686558321.jpg','2026-07-13 06:30:11','2026-07-13 06:30:11'),(14,1,'Pojok','Jalan Lingkar Maskumambang, RT 06 / RW 09, Kode Pos: 64115','6999258136927836','Marto',1,'sendiri','leher angsa','Layak','tangki septic','Pernah disedot (1 Kali), Waktu Terakhir: Kurang dari 3 tahun lalu','Saluran Tertutup','≥ 10 Meter (Aman)',111.9799517,-7.8021481,'1783925784_6a548c189fc7a_dokumen_SRV_3365615638000160778.jpg,1783925784_6a548c18a3b33_dokumen_SRV_6043037709185018167.jpg','2026-07-13 06:56:24','2026-07-13 06:56:24'),(15,1,'Pojok','Jalan Lingkar Maskumambang, RT 06 / RW 04, Kode Pos: 64115','3692145685430003','Suprapto',3,'sendiri','leher angsa','Layak','tangki septic','Pernah disedot (4 Kali), Waktu Terakhir: 4 tahun yang lalu','Saluran Tertutup','≥ 10 Meter (Aman)',111.9798935,-7.8020871,'1783926666_6a548f8a98091_dokumen_SRV_3770293831339958535.jpg,1783926666_6a548f8a9f1fe_dokumen_SRV_2159139563449623048.jpg','2026-07-13 07:11:06','2026-07-13 07:11:06');
/*!40000 ALTER TABLE `rumah_tangga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rumah_tanggas`
--

DROP TABLE IF EXISTS `rumah_tanggas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rumah_tanggas` (
  `id_rt` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id` bigint(20) unsigned NOT NULL,
  `kelurahan` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `no_kk` varchar(255) NOT NULL,
  `kepala_keluarga` varchar(255) NOT NULL,
  `jml_penghuni` int(11) NOT NULL,
  `kepemilikan_jamban` enum('sendiri','bersama','menumpang') NOT NULL,
  `jenis_jamban` varchar(255) NOT NULL,
  `status_kelayakan` varchar(255) NOT NULL,
  `pembuangan` varchar(255) NOT NULL,
  `jarak_air` int(11) NOT NULL,
  `longitude` decimal(10,8) DEFAULT NULL,
  `latitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rt`),
  KEY `rumah_tanggas_id_foreign` (`id`),
  CONSTRAINT `rumah_tanggas_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rumah_tanggas`
--

LOCK TABLES `rumah_tanggas` WRITE;
/*!40000 ALTER TABLE `rumah_tanggas` DISABLE KEYS */;
/*!40000 ALTER TABLE `rumah_tanggas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spal`
--

DROP TABLE IF EXISTS `spal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spal` (
  `id_babs` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `no_kk` varchar(30) NOT NULL,
  `nama_kepala` varchar(150) NOT NULL,
  `kelurahan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `status_spal` varchar(100) NOT NULL,
  `kondisi_bak` varchar(100) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `foto_dokumen` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_babs`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `spal_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spal`
--

LOCK TABLES `spal` WRITE;
/*!40000 ALTER TABLE `spal` DISABLE KEYS */;
INSERT INTO `spal` VALUES (1,1,'3506012345670002','Ibu Siti Aminah','Mojoroto','Jl. Veteran, RT 06 / RW 06','Tersambung ke IPAL Komunal Kota','Berfungsi Baik',-7.8134911962385,111.99643135071,'content://com.google.android.apps.photos.contentprovider/1/1/content%3A%2F%2Fmedia%2Fexternal%2Fimages%2Fmedia%2F1000329153/ORIGINAL/NONE/image%2Fjpeg/1430791035','2026-07-02 01:28:04','2026-07-02 01:28:04'),(2,1,'6321082594150002','Bapak Matsuni','Dermo','Jl. Sersan Bahrun, RT 31 / RW 05','Sistem Pembuangan Mandiri / Rumah Sendiri','Berfungsi Baik',-7.8121731698854,111.9952082634,'content://com.google.android.apps.photos.contentprovider/-1/1/content%3A%2F%2Fmedia%2Fexternal%2Fimages%2Fmedia%2F1000300613/ORIGINAL/NONE/image%2Fjpeg/170337413','2026-07-02 09:01:15','2026-07-02 09:01:15'),(3,1,'6543952168130004','Bapak Wahidin','Bandar Lor','Jl. Bandar Lor, RT 06 / RW 08','Tersambung ke IPAL Komunal Kota','Berfungsi Baik',-7.8122369454499,112.00248241425,'content://com.google.android.apps.photos.contentprovider/-1/1/content%3A%2F%2Fmedia%2Fexternal%2Fimages%2Fmedia%2F1000338583/ORIGINAL/NONE/image%2Fjpeg/602932913','2026-07-03 05:57:07','2026-07-03 05:57:07'),(4,1,'6954321891680001','Bapak Syarianto','Mojoroto','Jl. Jaksa Agung Suprapto, RT 08 / RW 09','Tersambung ke IPAL Komunal Kota','Berfungsi Baik',-7.8133849039449,112.00110912323,'1783059336_spal_SPAL_GAL_1987405131132844705.jpg','2026-07-03 06:15:41','2026-07-03 06:15:41'),(5,1,'6954321891680001','Bapak Syarianto','Mojoroto','Jl. Jaksa Agung Suprapto, RT 08 / RW 09','Tersambung ke IPAL Komunal Kota','Berfungsi Baik',-7.8133849039449,112.00110912323,'1783059342_spal_SPAL_GAL_1987405131132844705.jpg','2026-07-03 06:15:43','2026-07-03 06:15:43'),(6,1,'6954321891680001','Bapak Syarianto','Mojoroto','Jl. Jaksa Agung Suprapto, RT 08 / RW 09','Tersambung ke IPAL Komunal Kota','Berfungsi Baik',-7.8133849039449,112.00110912323,'1783059344_spal_SPAL_GAL_1987405131132844705.jpg','2026-07-03 06:15:44','2026-07-03 06:15:44');
/*!40000 ALTER TABLE `spal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  `kelurahan` varchar(255) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Petugas Lapangan','Pojok','petugas1','$2y$12$9ma.1UkbKS4mkN9NTYZqMe4ssfCuF0Oc2q065DDf6X/8VPSqhPj0O'),(2,'Admin',NULL,'admin_sanitasi','$2y$12$CyE6SOEDXHlfzYAxYYlVCenVyqVQjYQHKLxzdV9KuQYxkV/WzaFAC'),(4,'Petugas','Sukorame','Petugas sukorame','$2y$12$Wmd.RPKxRTVoqrgm9MCRBegFoHDWQbQwS9s1b1NiYpx4.5QWSlx5i');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Petugas') NOT NULL DEFAULT 'Petugas',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2026-07-23 15:16:38
