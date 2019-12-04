-- MariaDB dump 10.17  Distrib 10.4.8-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db_loket
-- ------------------------------------------------------
-- Server version	10.4.8-MariaDB

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
-- Table structure for table `m_antrian_apotek`
--

DROP TABLE IF EXISTS `m_antrian_apotek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_antrian_apotek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_dilayani` time DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `poli_id` int(11) DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `from` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_antrian_apotek`
--

LOCK TABLES `m_antrian_apotek` WRITE;
/*!40000 ALTER TABLE `m_antrian_apotek` DISABLE KEYS */;
INSERT INTO `m_antrian_apotek` VALUES (1,1,'2019-10-05','19:07:17',NULL,1,4,'Putra Budiman','Grinting',NULL),(2,2,'2019-10-05','19:33:52',NULL,1,4,'Markus Horizon','Grinting',NULL),(3,3,'2019-10-06','15:54:47','16:43:46',5,1,'Sumiati','GEBANG',NULL),(4,4,'2019-10-07','12:08:23',NULL,1,2,'Markus Horizon','Grinting',NULL),(5,6,'2019-10-07','12:33:06',NULL,1,2,'Sumiati','Grinting',NULL);
/*!40000 ALTER TABLE `m_antrian_apotek` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_antrian_laborat`
--

DROP TABLE IF EXISTS `m_antrian_laborat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_antrian_laborat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_dilayani` time DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `poli_id` int(11) DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_antrian_laborat`
--

LOCK TABLES `m_antrian_laborat` WRITE;
/*!40000 ALTER TABLE `m_antrian_laborat` DISABLE KEYS */;
INSERT INTO `m_antrian_laborat` VALUES (1,1,'2019-10-05','19:07:17',NULL,1,4,'Putra Budiman','Grinting');
/*!40000 ALTER TABLE `m_antrian_laborat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_antrian_loket`
--

DROP TABLE IF EXISTS `m_antrian_loket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_antrian_loket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor` varchar(10) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_dilayani` time DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `poli_id` int(11) DEFAULT NULL,
  `loket_id` int(11) DEFAULT NULL,
  `call_attempt` int(11) DEFAULT NULL,
  `jp_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_antrian_loket`
--

LOCK TABLES `m_antrian_loket` WRITE;
/*!40000 ALTER TABLE `m_antrian_loket` DISABLE KEYS */;
INSERT INTO `m_antrian_loket` VALUES (1,'A001','2019-10-05','16:43:22',NULL,3,NULL,1,NULL,1),(2,'A002','2019-10-05','17:04:26','17:38:23',5,4,1,NULL,1),(3,'C001','2019-10-05','19:24:55','19:25:14',5,4,1,NULL,3),(4,'A001','2019-10-06','15:48:22','15:51:18',5,1,1,NULL,1),(5,'A002','2019-10-06','15:48:39',NULL,1,NULL,1,NULL,1),(6,'B001','2019-10-06','15:48:56',NULL,1,NULL,1,NULL,2),(7,'B002','2019-10-06','15:49:06',NULL,1,NULL,1,NULL,2),(8,'C001','2019-10-06','15:49:15',NULL,1,NULL,1,NULL,3),(9,'A001','2019-10-07','11:50:22','12:07:34',5,2,1,NULL,1),(10,'A002','2019-10-07','12:01:30','12:08:48',5,3,1,NULL,1),(11,'A003','2019-10-07','12:23:11','12:30:31',5,2,1,NULL,1),(12,'A004','2019-10-07','12:29:55','12:31:41',5,2,1,NULL,1),(13,'B001','2019-10-07','12:34:56',NULL,1,NULL,1,NULL,2),(14,'C001','2019-10-07','12:35:06',NULL,1,NULL,1,NULL,3),(25,'A001','2019-11-29','08:44:29',NULL,1,NULL,1,NULL,1),(26,'B001','2019-11-29','08:44:39',NULL,1,NULL,1,NULL,2),(27,'C001','2019-11-29','08:46:18',NULL,1,NULL,1,NULL,3),(28,'A001','2019-12-05','00:15:05',NULL,1,NULL,1,NULL,1),(29,'A002','2019-12-05','00:58:22',NULL,1,NULL,1,NULL,1),(30,'B001','2019-12-05','00:58:24',NULL,1,NULL,1,NULL,2),(31,'C001','2019-12-05','00:58:28',NULL,1,NULL,1,NULL,3),(32,'B002','2019-12-05','00:58:30',NULL,1,NULL,1,NULL,2),(33,'C002','2019-12-05','00:58:32',NULL,1,NULL,1,NULL,3),(34,'B003','2019-12-05','00:58:34',NULL,1,NULL,1,NULL,2),(35,'A003','2019-12-05','00:58:36',NULL,1,NULL,1,NULL,1);
/*!40000 ALTER TABLE `m_antrian_loket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_antrian_poli`
--

DROP TABLE IF EXISTS `m_antrian_poli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_antrian_poli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `al_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_dilayani` time DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `poli_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_antrian_poli`
--

LOCK TABLES `m_antrian_poli` WRITE;
/*!40000 ALTER TABLE `m_antrian_poli` DISABLE KEYS */;
INSERT INTO `m_antrian_poli` VALUES (1,2,'2019-10-05','17:38:23','19:07:17',5,'Putra Budiman','Grinting',4),(2,3,'2019-10-05','19:25:14','19:33:52',5,'Markus Horizon','Grinting',4),(3,4,'2019-10-06','15:51:18','15:54:47',5,'Sumiati','GEBANG',1),(4,9,'2019-10-07','12:07:34','12:08:23',5,'Markus Horizon','Grinting',2),(5,10,'2019-10-07','12:08:48',NULL,1,'Putra Budiman','Grinting',3),(6,11,'2019-10-07','12:30:31','12:33:06',5,'Sumiati','Grinting',2),(7,12,'2019-10-07','12:31:41',NULL,1,'Markus Horizon','Grinting',2);
/*!40000 ALTER TABLE `m_antrian_poli` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_display_antrian_loket`
--

DROP TABLE IF EXISTS `m_display_antrian_loket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_display_antrian_loket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curr_no` varchar(10) DEFAULT NULL,
  `a_cx` int(11) DEFAULT NULL,
  `b_cx` int(11) DEFAULT NULL,
  `c_cx` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_display_antrian_loket`
--

LOCK TABLES `m_display_antrian_loket` WRITE;
/*!40000 ALTER TABLE `m_display_antrian_loket` DISABLE KEYS */;
INSERT INTO `m_display_antrian_loket` VALUES (1,'n/a',0,0,0,'2019-10-08 13:20:49'),(2,NULL,0,0,0,'2019-11-29 09:00:53'),(3,'n/a',0,0,0,'2019-12-04 06:14:28'),(4,NULL,0,0,0,'2019-12-05 01:29:57');
/*!40000 ALTER TABLE `m_display_antrian_loket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_jenis_pendaftaran`
--

DROP TABLE IF EXISTS `m_jenis_pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_jenis_pendaftaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(25) DEFAULT NULL,
  `kode` varchar(25) DEFAULT NULL,
  `slug` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_jenis_pendaftaran`
--

LOCK TABLES `m_jenis_pendaftaran` WRITE;
/*!40000 ALTER TABLE `m_jenis_pendaftaran` DISABLE KEYS */;
INSERT INTO `m_jenis_pendaftaran` VALUES (1,'Peserta BPJS','A','bpjs'),(2,'Peserta Umum','B','umum'),(3,'Lansia/Anak','C','lansia-anak');
/*!40000 ALTER TABLE `m_jenis_pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_loket`
--

DROP TABLE IF EXISTS `m_loket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_loket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(25) DEFAULT NULL,
  `keterangan` varchar(25) DEFAULT NULL,
  `tgl_dibuat` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_loket`
--

LOCK TABLES `m_loket` WRITE;
/*!40000 ALTER TABLE `m_loket` DISABLE KEYS */;
INSERT INTO `m_loket` VALUES (1,'Loket 1','Loket 1','2019-09-11'),(2,'Loket 2','Loket 2','2019-09-11');
/*!40000 ALTER TABLE `m_loket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_nomor_pendaftaran`
--

DROP TABLE IF EXISTS `m_nomor_pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_nomor_pendaftaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `nomor` int(11) DEFAULT NULL,
  `tanggal` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_nomor_pendaftaran`
--

LOCK TABLES `m_nomor_pendaftaran` WRITE;
/*!40000 ALTER TABLE `m_nomor_pendaftaran` DISABLE KEYS */;
INSERT INTO `m_nomor_pendaftaran` VALUES (1,1,2,'2019-11-29'),(2,2,2,'2019-11-29'),(3,3,2,'2019-11-29'),(4,1,4,'2019-12-05'),(5,2,4,'2019-12-05'),(6,3,3,'2019-12-05');
/*!40000 ALTER TABLE `m_nomor_pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_poli`
--

DROP TABLE IF EXISTS `m_poli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_poli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(25) DEFAULT NULL,
  `laborat` int(11) DEFAULT NULL,
  `tgl_dibuat` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_poli`
--

LOCK TABLES `m_poli` WRITE;
/*!40000 ALTER TABLE `m_poli` DISABLE KEYS */;
INSERT INTO `m_poli` VALUES (1,'Poli Umum',1,'2019-09-06'),(2,'Poli Gigi',0,'2019-09-06'),(4,'Poli KIA',1,'2019-10-05'),(5,'Poli Imunisasi',0,'2019-10-08'),(6,'Poli MTBS',1,'2019-10-08');
/*!40000 ALTER TABLE `m_poli` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_setting`
--

DROP TABLE IF EXISTS `m_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_setting` (
  `key` varchar(25) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `validation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_setting`
--

LOCK TABLES `m_setting` WRITE;
/*!40000 ALTER TABLE `m_setting` DISABLE KEYS */;
INSERT INTO `m_setting` VALUES ('app_name','Sistem Informasi Antrian Puskes','Nama Aplikasi','Nama Aplikasi','-',NULL),('nama_instansi','PUSKESMAS GRINTING','Nama Instansi','Nama Instansi','/antrian/tiket',NULL),('waktu_stop_tiket','15:00:00','Waktu Stop Layanan Tiket','Jangan layani tiket pada jam {waktu_stop_tiket}','/tiket','^(?:2[0-3]|[01]?[0-9]):[0-5][0-9]:[0-5][0-9]$'),('running_text','Selamat datang di {nama_instansi}','Running Text','Text Berjalan <marquee>{running_text}<marquee>','/antrian/tiket',NULL),('tts_speak_command','{BALCON} -n \"Vocalizer Damayanti - Indonesian For KobaSpeech 2\" -s -8 -o raw -t {text} | {LAME} --preset voice -q 9 --vbr-new - {filepath}','TTS Speak Command','Perintah keluaran suara offline','/tts/speak/:string',NULL),('tiket_digit_format','%03d','Tiket Digit Format','Penomoran tiket, misal %04d : 0001','/tiket',NULL),('default_loket_id','1','Default Loket','Jika Setting Loket tidak ditentukan untuk jenis pendaftaran tertentu maka gunakan ID loket ini',NULL,NULL),('enable_stop_tiket','0','Enable Stop Tiket','Jika Enable maka pelayanan tiket stop aktif',NULL,NULL);
/*!40000 ALTER TABLE `m_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_setting_loket`
--

DROP TABLE IF EXISTS `m_setting_loket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_setting_loket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jp_id` int(11) DEFAULT NULL,
  `loket_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_setting_loket`
--

LOCK TABLES `m_setting_loket` WRITE;
/*!40000 ALTER TABLE `m_setting_loket` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_setting_loket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_status_antrian`
--

DROP TABLE IF EXISTS `m_status_antrian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_status_antrian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(200) DEFAULT NULL,
  `text` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_status_antrian`
--

LOCK TABLES `m_status_antrian` WRITE;
/*!40000 ALTER TABLE `m_status_antrian` DISABLE KEYS */;
INSERT INTO `m_status_antrian` VALUES (1,'queue','Dalam Antrian'),(2,'on_proses','Sedang Dilayani'),(3,'skip','Lewat'),(4,'cancel','Batal'),(5,'finish','Selesai');
/*!40000 ALTER TABLE `m_status_antrian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_user`
--

DROP TABLE IF EXISTS `m_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_user`
--

LOCK TABLES `m_user` WRITE;
/*!40000 ALTER TABLE `m_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-05  2:43:14
