/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100408
 Source Host           : localhost:3306
 Source Schema         : db_loket

 Target Server Type    : MariaDB
 Target Server Version : 100408
 File Encoding         : 65001

 Date: 08/10/2019 13:22:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for m_antrian_apotek
-- ----------------------------
DROP TABLE IF EXISTS `m_antrian_apotek`;
CREATE TABLE `m_antrian_apotek`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `waktu_mulai` time(0) NULL DEFAULT NULL,
  `waktu_dilayani` time(0) NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  `poli_id` int(11) NULL DEFAULT NULL,
  `nama` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `alamat` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `from` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_antrian_apotek
-- ----------------------------
INSERT INTO `m_antrian_apotek` VALUES (1, 1, '2019-10-05', '19:07:17', NULL, 1, 4, 'Putra Budiman', 'Grinting', NULL);
INSERT INTO `m_antrian_apotek` VALUES (2, 2, '2019-10-05', '19:33:52', NULL, 1, 4, 'Markus Horizon', 'Grinting', NULL);
INSERT INTO `m_antrian_apotek` VALUES (3, 3, '2019-10-06', '15:54:47', '16:43:46', 5, 1, 'Sumiati', 'GEBANG', NULL);
INSERT INTO `m_antrian_apotek` VALUES (4, 4, '2019-10-07', '12:08:23', NULL, 1, 2, 'Markus Horizon', 'Grinting', NULL);
INSERT INTO `m_antrian_apotek` VALUES (5, 6, '2019-10-07', '12:33:06', NULL, 1, 2, 'Sumiati', 'Grinting', NULL);

-- ----------------------------
-- Table structure for m_antrian_laborat
-- ----------------------------
DROP TABLE IF EXISTS `m_antrian_laborat`;
CREATE TABLE `m_antrian_laborat`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `waktu_mulai` time(0) NULL DEFAULT NULL,
  `waktu_dilayani` time(0) NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  `poli_id` int(11) NULL DEFAULT NULL,
  `nama` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `alamat` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_antrian_laborat
-- ----------------------------
INSERT INTO `m_antrian_laborat` VALUES (1, 1, '2019-10-05', '19:07:17', NULL, 1, 4, 'Putra Budiman', 'Grinting');

-- ----------------------------
-- Table structure for m_antrian_loket
-- ----------------------------
DROP TABLE IF EXISTS `m_antrian_loket`;
CREATE TABLE `m_antrian_loket`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `waktu_mulai` time(0) NULL DEFAULT NULL,
  `waktu_dilayani` time(0) NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  `poli_id` int(11) NULL DEFAULT NULL,
  `loket_id` int(11) NULL DEFAULT NULL,
  `call_attempt` int(11) NULL DEFAULT NULL,
  `jp_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_antrian_loket
-- ----------------------------
INSERT INTO `m_antrian_loket` VALUES (1, 'A001', '2019-10-05', '16:43:22', NULL, 3, NULL, 1, NULL, 1);
INSERT INTO `m_antrian_loket` VALUES (2, 'A002', '2019-10-05', '17:04:26', '17:38:23', 5, 4, 1, NULL, 1);
INSERT INTO `m_antrian_loket` VALUES (3, 'C001', '2019-10-05', '19:24:55', '19:25:14', 5, 4, 1, NULL, 3);
INSERT INTO `m_antrian_loket` VALUES (4, 'A001', '2019-10-06', '15:48:22', '15:51:18', 5, 1, 1, NULL, 1);
INSERT INTO `m_antrian_loket` VALUES (5, 'A002', '2019-10-06', '15:48:39', NULL, 1, NULL, 1, NULL, 1);
INSERT INTO `m_antrian_loket` VALUES (6, 'B001', '2019-10-06', '15:48:56', NULL, 1, NULL, 1, NULL, 2);
INSERT INTO `m_antrian_loket` VALUES (7, 'B002', '2019-10-06', '15:49:06', NULL, 1, NULL, 1, NULL, 2);
INSERT INTO `m_antrian_loket` VALUES (8, 'C001', '2019-10-06', '15:49:15', NULL, 1, NULL, 1, NULL, 3);
INSERT INTO `m_antrian_loket` VALUES (9, 'A001', '2019-10-07', '11:50:22', '12:07:34', 5, 2, 1, NULL, 1);
INSERT INTO `m_antrian_loket` VALUES (10, 'A002', '2019-10-07', '12:01:30', '12:08:48', 5, 3, 1, NULL, 1);
INSERT INTO `m_antrian_loket` VALUES (11, 'A003', '2019-10-07', '12:23:11', '12:30:31', 5, 2, 1, NULL, 1);
INSERT INTO `m_antrian_loket` VALUES (12, 'A004', '2019-10-07', '12:29:55', '12:31:41', 5, 2, 1, NULL, 1);
INSERT INTO `m_antrian_loket` VALUES (13, 'B001', '2019-10-07', '12:34:56', NULL, 1, NULL, 1, NULL, 2);
INSERT INTO `m_antrian_loket` VALUES (14, 'C001', '2019-10-07', '12:35:06', NULL, 1, NULL, 1, NULL, 3);

-- ----------------------------
-- Table structure for m_antrian_poli
-- ----------------------------
DROP TABLE IF EXISTS `m_antrian_poli`;
CREATE TABLE `m_antrian_poli`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `al_id` int(11) NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `waktu_mulai` time(0) NULL DEFAULT NULL,
  `waktu_dilayani` time(0) NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  `nama` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `alamat` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `poli_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_antrian_poli
-- ----------------------------
INSERT INTO `m_antrian_poli` VALUES (1, 2, '2019-10-05', '17:38:23', '19:07:17', 5, 'Putra Budiman', 'Grinting', 4);
INSERT INTO `m_antrian_poli` VALUES (2, 3, '2019-10-05', '19:25:14', '19:33:52', 5, 'Markus Horizon', 'Grinting', 4);
INSERT INTO `m_antrian_poli` VALUES (3, 4, '2019-10-06', '15:51:18', '15:54:47', 5, 'Sumiati', 'GEBANG', 1);
INSERT INTO `m_antrian_poli` VALUES (4, 9, '2019-10-07', '12:07:34', '12:08:23', 5, 'Markus Horizon', 'Grinting', 2);
INSERT INTO `m_antrian_poli` VALUES (5, 10, '2019-10-07', '12:08:48', NULL, 1, 'Putra Budiman', 'Grinting', 3);
INSERT INTO `m_antrian_poli` VALUES (6, 11, '2019-10-07', '12:30:31', '12:33:06', 5, 'Sumiati', 'Grinting', 2);
INSERT INTO `m_antrian_poli` VALUES (7, 12, '2019-10-07', '12:31:41', NULL, 1, 'Markus Horizon', 'Grinting', 2);

-- ----------------------------
-- Table structure for m_display_antrian_loket
-- ----------------------------
DROP TABLE IF EXISTS `m_display_antrian_loket`;
CREATE TABLE `m_display_antrian_loket`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curr_no` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `a_cx` int(11) NULL DEFAULT NULL,
  `b_cx` int(11) NULL DEFAULT NULL,
  `c_cx` int(11) NULL DEFAULT NULL,
  `date` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_display_antrian_loket
-- ----------------------------
INSERT INTO `m_display_antrian_loket` VALUES (1, 'n/a', 0, 0, 0, '2019-10-08 13:20:49');

-- ----------------------------
-- Table structure for m_jenis_pendaftaran
-- ----------------------------
DROP TABLE IF EXISTS `m_jenis_pendaftaran`;
CREATE TABLE `m_jenis_pendaftaran`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `kode` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `slug` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_jenis_pendaftaran
-- ----------------------------
INSERT INTO `m_jenis_pendaftaran` VALUES (1, 'Peserta BPJS', 'A', 'bpjs');
INSERT INTO `m_jenis_pendaftaran` VALUES (2, 'Peserta Umum', 'B', 'umum');
INSERT INTO `m_jenis_pendaftaran` VALUES (3, 'Lansia/Anak', 'C', 'lansia-anak');

-- ----------------------------
-- Table structure for m_loket
-- ----------------------------
DROP TABLE IF EXISTS `m_loket`;
CREATE TABLE `m_loket`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `keterangan` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tgl_dibuat` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_loket
-- ----------------------------
INSERT INTO `m_loket` VALUES (1, 'Loket 1', 'Loket 1', '2019-09-11');
INSERT INTO `m_loket` VALUES (2, 'Loket 2', 'Loket 2', '2019-09-11');

-- ----------------------------
-- Table structure for m_nomor_pendaftaran
-- ----------------------------
DROP TABLE IF EXISTS `m_nomor_pendaftaran`;
CREATE TABLE `m_nomor_pendaftaran`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NULL DEFAULT NULL,
  `nomor` int(11) NULL DEFAULT NULL,
  `tanggal` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for m_poli
-- ----------------------------
DROP TABLE IF EXISTS `m_poli`;
CREATE TABLE `m_poli`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `laborat` int(11) NULL DEFAULT NULL,
  `tgl_dibuat` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_poli
-- ----------------------------
INSERT INTO `m_poli` VALUES (1, 'Poli Umum', 1, '2019-09-06');
INSERT INTO `m_poli` VALUES (2, 'Poli Gigi', 0, '2019-09-06');
INSERT INTO `m_poli` VALUES (4, 'Poli KIA', 1, '2019-10-05');
INSERT INTO `m_poli` VALUES (5, 'Poli Imunisasi', 0, '2019-10-08');
INSERT INTO `m_poli` VALUES (6, 'Poli MTBPS', 1, '2019-10-08');

-- ----------------------------
-- Table structure for m_setting
-- ----------------------------
DROP TABLE IF EXISTS `m_setting`;
CREATE TABLE `m_setting`  (
  `key` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `value` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `keterangan` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `validation` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_setting
-- ----------------------------
INSERT INTO `m_setting` VALUES ('app_name', 'Sistem Informasi Antrian Puskes', 'Nama Aplikasi', 'Nama Aplikasi', '-', NULL);
INSERT INTO `m_setting` VALUES ('nama_instansi', 'PUSKESMAS GRINTING', 'Nama Instansi', 'Nama Instansi', '/antrian/tiket', NULL);
INSERT INTO `m_setting` VALUES ('waktu_stop_tiket', '15:00:00', 'Waktu Stop Layanan Tiket', 'Jangan layani tiket pada jam {waktu_stop_tiket}', '/tiket', '^(?:2[0-3]|[01]?[0-9]):[0-5][0-9]:[0-5][0-9]$');
INSERT INTO `m_setting` VALUES ('running_text', 'Selamat datang di {nama_instansi}', 'Running Text', 'Text Berjalan <marquee>{running_text}<marquee>', '/antrian/tiket', NULL);
INSERT INTO `m_setting` VALUES ('tts_speak_command', '{BALCON} -n \"Vocalizer Damayanti - Indonesian For KobaSpeech 2\" -s -8 -o raw -t {text} | {LAME} --preset voice -q 9 --vbr-new - {filepath}', 'TTS Speak Command', 'Perintah keluaran suara offline', '/tts/speak/:string', NULL);
INSERT INTO `m_setting` VALUES ('tiket_digit_format', '%03d', 'Tiket Digit Format', 'Penomoran tiket, misal %04d : 0001', '/tiket', NULL);
INSERT INTO `m_setting` VALUES ('default_loket_id', '1', 'Default Loket', 'Jika Setting Loket tidak ditentukan untuk jenis pendaftaran tertentu maka gunakan ID loket ini', NULL, NULL);
INSERT INTO `m_setting` VALUES ('enable_stop_tiket', '0', 'Enable Stop Tiket', 'Jika Enable maka pelayanan tiket stop aktif', NULL, NULL);

-- ----------------------------
-- Table structure for m_setting_loket
-- ----------------------------
DROP TABLE IF EXISTS `m_setting_loket`;
CREATE TABLE `m_setting_loket`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jp_id` int(11) NULL DEFAULT NULL,
  `loket_id` int(11) NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for m_status_antrian
-- ----------------------------
DROP TABLE IF EXISTS `m_status_antrian`;
CREATE TABLE `m_status_antrian`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `text` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_status_antrian
-- ----------------------------
INSERT INTO `m_status_antrian` VALUES (1, 'queue', 'Dalam Antrian');
INSERT INTO `m_status_antrian` VALUES (2, 'on_proses', 'Sedang Dilayani');
INSERT INTO `m_status_antrian` VALUES (3, 'skip', 'Lewat');
INSERT INTO `m_status_antrian` VALUES (4, 'cancel', 'Batal');
INSERT INTO `m_status_antrian` VALUES (5, 'finish', 'Selesai');

-- ----------------------------
-- Table structure for m_user
-- ----------------------------
DROP TABLE IF EXISTS `m_user`;
CREATE TABLE `m_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(225) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nama` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `group_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
