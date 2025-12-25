-- MySQL dump 10.13  Distrib 5.7.35, for FreeBSD12.2 (amd64)
--
-- Host: localhost    Database: program
-- ------------------------------------------------------
-- Server version	5.7.35-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(25) NOT NULL,
  `user_type` varchar(25) NOT NULL,
  `pass` varchar(25) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`ID`, `name`, `last_name`, `phone`, `email`, `user_type`, `pass`) VALUES (1,'admin','admin','123456789','admin@admin.gr','Διαχειριστής','admin');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_sem`
--

DROP TABLE IF EXISTS `admin_sem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_sem` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_department` int(10) NOT NULL,
  `ID_sem` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_sem`
--

LOCK TABLES `admin_sem` WRITE;
/*!40000 ALTER TABLE `admin_sem` DISABLE KEYS */;
INSERT INTO `admin_sem` (`ID`, `ID_department`, `ID_sem`) VALUES (1,4,1),(2,3,2),(3,2,2),(4,1,2);
/*!40000 ALTER TABLE `admin_sem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `year` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL,
  `optional` enum('yes','no') NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` (`ID`, `name`, `year`, `code`, `optional`) VALUES (179,'ΑΝΤ. ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΣ Ι','2020','1','no'),(181,'ΔΙΑΚΡΙΤΑ ΜΑΘΗΜΑΤΙΚΑ','2020','2','no'),(183,'ΜΑΘΗΜΑΤΙΚΗ ΑΝΑΛΥΣΗ ΙΙ','2020','3','no'),(184,'ΠΙΘΑΝΟΤΗΤΕΣ & ΣΤΑΤΙΣΤΙΚΗ','2020','4','no'),(185,'ΜΗΧΑΝΙΚΗ','2020','5','no'),(186,'ΗΛΕΚΤΡΙΚΑ ΚΥΚΛΩΜΑΤΑ I','2020','6','no'),(187,'ΗΛΕΚΤΡΟΝΙΚΗ Ι','2020','7','no'),(188,'ΑΓΓΛΙΚΑ ΙΙ','2020','8','no'),(189,'ΔΙΚΤΥΑ ΤΗΛΕΠΙΚΟΙΝΩΝΙΩΝ','2020','9','no'),(190,'ΗΛΕΚΤΡΟΜΑΓΝΗΤΙΣΜΟΣ','2020','10','no'),(191,'ΘΕΩΡΙΑ ΣΗΜΑΤΩΝ & ΣΥΣΤΗΜΑΤΩΝ','2020','11','no'),(192,'ΑΡΙΘΜΗΤΙΚΗ ΑΝΑΛΥΣΗ','2020','12','no'),(193,'ΕΦ. ΜΑΘΗΜΑΤΙΚΑ ΙΙ','2020','13','no'),(194,'ΒΑΣΕΙΣ ΔΕΔΟΜΕΝΩΝ','2020','14','no'),(195,'ΣΑΕ Ι','2020','15','no'),(196,'ΜΙΚΡΟΕΠΕΞΕΡΓΑΣΤΕΣ','2020','16','no'),(197,'ΗΛΕΚΤΡΙΚΕΣ ΜΗΧΑΝΕΣ','2020','17','no'),(198,'ΔΙΚΤΥΑ ΥΠΟΛΟΓΙΣΤΩΝ','2020','18','no'),(199,'ΨΗΦ. ΕΠΕΞ. ΕΙΚΟΝΑΣ','2020','19','yes'),(200,'ΤΕΧΝ., ΚΑΙΝ., ΟΙΚ. ΕΠ.& ΕΠΙΧ.','2020','20','yes'),(201,'ΣΥΣΤ. ΠΑΡΑΛ. & ΚΑΤΑΝ. ΕΠΕΞ.','2020','21','no'),(203,'ΣΥΣΤ. ΓΕΩΓΡ. ΠΛΗΡΟΦΟΡΙΩΝ','2020','23','yes'),(204,'ΑΝΑΛΥΣΗ & ΣΧΕΔΙΑΣΗ ΑΛΓ.','2020','24','no'),(205,'ΑΡΧΕΣ ΟΡΓ., ΔΙΟΙΚ. & ΛΗΨΗΣ ΑΠΟΦ.','2020','25','no'),(206,'ΑΛΛΗΛ. ΑΝΘΡΩΠΟΥ-ΥΠΟΛ.','2020','26','no'),(207,'ΔΙΟΙΚΗΣΗ ΕΡΓΩΝ','2020','27','yes'),(208,'ΑΡΧΕΣ ΟΡΓ., ΔΙΟΙΚ. & ΛΗΨΗΣ ΑΠΟΦ.','2020','25','yes'),(209,'ΑΛΛΗΛ. ΑΝΘΡΩΠΟΥ-ΥΠΟΛ.','2020','26','yes'),(210,'ΒΙΟΪΑΤΡΙΚΗ ΤΕΧΝΟΛΟΓΙΑ','2020','28','yes'),(211,'ΒΙΟΜΗΧΑΝΙΚΗ ΔΙΟΙΚΗΣΗ','2020','29','yes'),(212,'ΕΠΙΧΕΙΡΗΣΙΑΚΗ ΕΡΕΥΝΑ','2020','30','yes'),(213,'ΣΑΕ ΙΙ','2020','31','no'),(214,'ΠΘΨΣ','2020','32','yes'),(215,'ΨΗΦΙΑΚΑ ΗΛΕΚΤΡΟΝΙΚΑ','2020','33','yes'),(216,'ΠΡΟΗΓΜ. ΘΕΜΑΤΑ ΒΑΣΕΩΝ ΔΕΔ','2020','34','yes'),(217,'ΑΣΦΑΛΕΙΑ ΥΠΟΛ. & ΔΙΚΤΥΩΝ','2020','35','no'),(218,'ΟΠΤΙΚΕΣ ΕΠΙΚ. & ΔΙΚΤΥΑ','2020','36','no'),(219,'ΦΩΤΟΝΙΚΗ-ΟΠΤ. ΔΙΑΤΑΞΕΙΣ','2020','37','yes'),(220,'ΔΙΚΤΥΑ ΚΙΝΗΤΩΝ ΕΠΙΚ.','2020','38','no'),(222,'ΟΠΤΙΚΗ','2020','40','yes'),(223,'ΤΕΧΝΟΛΟΓΙΑ ΛΟΓΙΣΜΙΚΟΥ','2020','22','no'),(224,'ΑΣΥΡ. ΔΙΚΤΥΑ ΑΙΣΘΗΤ.','2020','41','yes'),(225,'ΘΕΩΡΙΑ & ΔΙΑΧ. ΤΗΛΕΠ. ΚΙΝΗΣΗΣ','2020','42','yes'),(226,'ΛΕΙΤΟΥΡΓΙΚΑ ΣΥΣΤΗΜΑΤΑ','2020','43','no'),(227,'ΔΙΚΤΥΑ ΥΠΟΛΟΓΙΣΤΩΝ ΙΙ','2020','44','no'),(228,'ΜΑΘ. ΜΟΝΤΕΛ. & ΑΡ. ΑΝΑΛΥΣΗ','2020','45','no'),(229,'ΗΛΕΚΤΡΙΚΑ ΚΥΚΛΩΜΑΤΑ (3ου ΕΞ.)','2020','46','no'),(230,'ΣΥΣΤ. ΠΑΡ. & ΚΑΤΑΝΕΜ. ΕΠΕΞ.','2020','21','no'),(231,'ΣΥΣΤΗΜΑΤΑ ΕΠΙΚΟΙΝΩΝΙΩΝ ΙΙ','2020','47','no'),(232,'ΠΡΟΓΡ. ΔΙΑΔΙΚΤΥΟΥ','2020','48','no'),(233,'ΨΗΦ. ΕΠΕΞ. ΕΙΚΟΝΑΣ','2020','19','no'),(234,'ΕΠΙΚ. ΑΝΘΡΩΠΟΥ-ΥΠΟΛΟΓΙΣΤΗ','2020','49','no'),(235,'ΔΙΟΙΚΗΣΗ ΕΡΓΟΥ','2020','27','yes'),(236,'ΗΛΕΚΤΡΙΚΕΣ ΜΗΧΑΝΕΣ','2020','17','yes'),(237,'ΠΘΨΣ','2020','32','no'),(238,'ΨΗΦ. ΗΛΕΚΤΡΟΝΙΚΑ','2020','33','yes'),(239,'ΗΠΙΕΣ & ΝΕΕΣ ΜΟΡΦΕΣ ΕΝΕΡΓ.','2020','50','yes'),(240,'ΠΡΟΗΓΜ. ΘΕΜΑΤΑ ΒΑΣΕΩΝ ΔΕΔ.','2020','34','no'),(241,'ΠΡΟΗΓΜ. ΘΕΜΑΤΑ ΒΑΣΕΩΝ ΔΕΔ.','2020','34','yes'),(248,'MATHIMA A','2020','sdf','no'),(249,'MATHIMA B','2020','qweqwe','no'),(250,'MATHIMA C','2020','eryer','no'),(251,'sfdsd','sd','634','yes'),(252,'hdfg','2020','gdf','no'),(253,'kat','2020','gfsdg','no'),(254,'MATHIMA A','2020','sdf','yes'),(255,'ΠΡΟΗΓΜ. ΘΕΜΑΤΑ ΒΑΣΕΩΝ ΔΕΔ','2020','34','no'),(258,'λογιστικη 1','2020','151','no'),(260,'hdfgψσψσ','2020','gdf','no'),(261,'ΑΝΑΓΝ. ΠΡΟΤ. & ΜΗΧ. ΜΑΘΗΣΗ','2020','85','yes'),(262,'ΕΝΕΡΓ. ΟΙΚ. & ΑΓΟΡΕΣ ΕΝΕΡΓΕΙΑΣ','2020','86','yes'),(263,'ΥΨΗΛΕΣ ΤΑΣΕΙΣ','2020','87','yes');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_depart`
--

DROP TABLE IF EXISTS `course_depart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_depart` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_course` int(10) NOT NULL,
  `ID_departament` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_course` (`ID_course`),
  KEY `ID_departament` (`ID_departament`),
  CONSTRAINT `course_depart_ibfk_1` FOREIGN KEY (`ID_course`) REFERENCES `course` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_depart_ibfk_2` FOREIGN KEY (`ID_departament`) REFERENCES `departament` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_depart`
--

LOCK TABLES `course_depart` WRITE;
/*!40000 ALTER TABLE `course_depart` DISABLE KEYS */;
INSERT INTO `course_depart` (`ID`, `ID_course`, `ID_departament`) VALUES (123,179,1),(125,181,1),(126,183,1),(127,184,1),(128,185,1),(129,186,1),(130,187,1),(131,188,1),(132,189,1),(133,190,1),(134,191,1),(135,192,1),(136,193,1),(137,194,1),(138,195,1),(139,196,1),(140,197,1),(141,198,1),(142,199,1),(143,200,1),(144,201,1),(145,223,1),(146,203,1),(147,204,1),(148,208,1),(149,209,1),(150,207,1),(151,210,1),(152,211,1),(153,212,1),(154,213,1),(155,237,1),(156,215,1),(157,216,1),(158,217,1),(159,218,1),(160,219,1),(161,220,1),(163,222,1),(164,224,1),(165,225,1),(166,179,2),(167,181,2),(168,183,2),(169,184,2),(170,185,2),(171,186,2),(172,187,2),(173,226,2),(174,227,2),(175,191,2),(176,228,2),(177,193,2),(178,229,2),(179,194,2),(180,230,2),(181,223,2),(182,231,2),(183,204,2),(184,232,2),(185,199,2),(186,217,2),(187,218,2),(188,203,2),(189,219,2),(190,234,2),(191,235,2),(192,220,2),(193,236,2),(194,210,2),(195,211,2),(196,224,2),(197,212,2),(198,214,2),(199,238,2),(200,222,2),(201,239,2),(202,225,2),(203,241,2),(210,248,1),(211,249,1),(212,250,1),(213,251,1),(214,260,1),(215,253,1),(219,261,1),(220,262,1),(221,263,1);
/*!40000 ALTER TABLE `course_depart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_kateuthinsi`
--

DROP TABLE IF EXISTS `course_kateuthinsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_kateuthinsi` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_course` int(10) NOT NULL,
  `ID_kat` int(10) NOT NULL,
  `ID_department` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_course` (`ID_course`),
  KEY `ID_kat` (`ID_kat`),
  KEY `ID_department` (`ID_department`),
  CONSTRAINT `course_kateuthinsi_ibfk_1` FOREIGN KEY (`ID_course`) REFERENCES `course` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_kateuthinsi_ibfk_2` FOREIGN KEY (`ID_department`) REFERENCES `departament` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_kateuthinsi_ibfk_3` FOREIGN KEY (`ID_kat`) REFERENCES `kateuthinsi` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_kateuthinsi`
--

LOCK TABLES `course_kateuthinsi` WRITE;
/*!40000 ALTER TABLE `course_kateuthinsi` DISABLE KEYS */;
INSERT INTO `course_kateuthinsi` (`ID`, `ID_course`, `ID_kat`, `ID_department`) VALUES (1,248,1,1),(2,248,2,1),(3,249,2,1),(4,249,3,1),(5,250,3,1),(12,253,1,1),(13,253,2,1),(16,201,3,1),(17,204,3,1),(18,217,2,1),(19,237,3,1),(20,223,2,1),(21,213,3,1),(22,220,2,1),(24,218,2,1);
/*!40000 ALTER TABLE `course_kateuthinsi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_profesor`
--

DROP TABLE IF EXISTS `course_profesor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_profesor` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_course` int(10) NOT NULL,
  `ID_profesor` int(10) NOT NULL,
  `ID_depart` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_course` (`ID_course`),
  KEY `ID_profesor` (`ID_profesor`),
  KEY `course_profesor_ibfk_3` (`ID_depart`),
  CONSTRAINT `course_profesor_ibfk_1` FOREIGN KEY (`ID_course`) REFERENCES `course` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_profesor_ibfk_2` FOREIGN KEY (`ID_profesor`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_profesor_ibfk_3` FOREIGN KEY (`ID_depart`) REFERENCES `departament` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=301 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_profesor`
--

LOCK TABLES `course_profesor` WRITE;
/*!40000 ALTER TABLE `course_profesor` DISABLE KEYS */;
INSERT INTO `course_profesor` (`ID`, `ID_course`, `ID_profesor`, `ID_depart`) VALUES (188,179,8,1),(190,181,19,1),(193,185,21,1),(194,186,18,1),(195,187,22,1),(196,188,23,1),(197,189,6,1),(199,191,7,1),(200,192,7,1),(202,194,19,1),(203,195,36,1),(204,196,26,1),(205,197,39,1),(206,198,28,1),(207,199,32,1),(208,200,48,1),(210,223,8,1),(211,203,32,1),(212,204,19,1),(213,208,49,1),(214,209,30,1),(215,207,49,1),(216,210,55,1),(217,211,50,1),(218,212,51,1),(219,213,52,1),(220,237,57,1),(221,215,33,1),(222,216,35,1),(223,217,10,1),(224,218,10,1),(225,219,34,1),(226,220,6,1),(228,222,37,1),(229,224,55,1),(230,225,38,1),(231,179,8,2),(232,181,19,2),(235,185,21,2),(236,186,18,2),(237,187,22,2),(239,227,24,2),(240,191,7,2),(241,228,7,2),(243,229,18,2),(244,194,19,2),(246,223,8,2),(247,231,31,2),(248,204,19,2),(249,232,30,2),(250,199,32,2),(251,217,10,2),(252,218,10,2),(253,203,32,2),(254,219,34,2),(255,234,30,2),(256,235,49,2),(257,220,6,2),(258,236,39,2),(259,210,55,2),(260,211,50,2),(261,224,55,2),(262,212,51,2),(263,214,26,2),(264,238,33,2),(265,222,37,2),(266,239,56,2),(267,225,38,2),(268,241,35,2),(274,249,13,1),(279,248,13,1),(283,260,13,1),(284,261,80,1),(285,262,81,1),(286,263,82,1),(287,193,83,2),(288,190,83,1),(289,193,83,1),(290,201,84,1),(295,183,88,1),(296,184,88,1),(297,226,84,2),(298,183,88,2),(299,184,88,2),(300,230,84,2);
/*!40000 ALTER TABLE `course_profesor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `days`
--

DROP TABLE IF EXISTS `days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `days` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `days`
--

LOCK TABLES `days` WRITE;
/*!40000 ALTER TABLE `days` DISABLE KEYS */;
INSERT INTO `days` (`ID`, `name`) VALUES (1,'Δευτέρα'),(2,'Τρίτη'),(3,'Τετάρτη'),(4,'Πέμπτη'),(5,'Παρασκευή');
/*!40000 ALTER TABLE `days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departament`
--

DROP TABLE IF EXISTS `departament`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departament` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `ID_university` int(11) NOT NULL,
  `sso_depart` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_university` (`ID_university`),
  CONSTRAINT `departament_ibfk_1` FOREIGN KEY (`ID_university`) REFERENCES `university` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departament`
--

LOCK TABLES `departament` WRITE;
/*!40000 ALTER TABLE `departament` DISABLE KEYS */;
INSERT INTO `departament` (`ID`, `name`, `ID_university`, `sso_depart`) VALUES (1,'Ηλεκτρολόγων Μηχανικών και Μηχανικών Υπολογιστών',1,1564),(2,'Μηχανικών Πληροφορικής και Τηλεπικοινωνιών',1,205),(3,'Χημικών Μηχανικών',1,544),(4,'sgsggds',1,4353);
/*!40000 ALTER TABLE `departament` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment`
--

LOCK TABLES `equipment` WRITE;
/*!40000 ALTER TABLE `equipment` DISABLE KEYS */;
INSERT INTO `equipment` (`ID`, `name`) VALUES (2,'Ηχεία'),(3,'Εξέδρα'),(4,'Λάπτοπ'),(5,'25 Υπολογιστές'),(6,'Μικρόφωνο'),(7,'Προτζέκτορας'),(8,'egf'),(9,'FPGA Xilinx Pynq XC7100');
/*!40000 ALTER TABLE `equipment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_depart`
--

DROP TABLE IF EXISTS `equipment_depart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment_depart` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_equipment` int(10) NOT NULL,
  `ID_departament` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_equipment` (`ID_equipment`),
  KEY `ID_departament` (`ID_departament`),
  CONSTRAINT `equipment_depart_ibfk_1` FOREIGN KEY (`ID_equipment`) REFERENCES `equipment` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `equipment_depart_ibfk_2` FOREIGN KEY (`ID_departament`) REFERENCES `departament` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_depart`
--

LOCK TABLES `equipment_depart` WRITE;
/*!40000 ALTER TABLE `equipment_depart` DISABLE KEYS */;
INSERT INTO `equipment_depart` (`ID`, `ID_equipment`, `ID_departament`) VALUES (3,2,1),(4,3,1),(5,4,1),(6,5,1),(7,6,1),(8,7,1),(9,9,1);
/*!40000 ALTER TABLE `equipment_depart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_room`
--

DROP TABLE IF EXISTS `equipment_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment_room` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_rooms` int(10) NOT NULL,
  `ID_equipment` int(10) NOT NULL,
  `ID_departament` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_rooms` (`ID_rooms`),
  KEY `ID_equipment` (`ID_equipment`),
  KEY `equipment_room_ibfk_3` (`ID_departament`),
  CONSTRAINT `equipment_room_ibfk_1` FOREIGN KEY (`ID_rooms`) REFERENCES `rooms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `equipment_room_ibfk_2` FOREIGN KEY (`ID_equipment`) REFERENCES `equipment` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `equipment_room_ibfk_3` FOREIGN KEY (`ID_departament`) REFERENCES `departament` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_room`
--

LOCK TABLES `equipment_room` WRITE;
/*!40000 ALTER TABLE `equipment_room` DISABLE KEYS */;
INSERT INTO `equipment_room` (`ID`, `ID_rooms`, `ID_equipment`, `ID_departament`) VALUES (24,8,2,1),(26,8,4,1),(45,11,3,1),(46,11,4,1),(47,11,5,1),(48,9,4,1),(49,9,5,1),(50,3,5,1),(51,3,6,1),(52,3,7,1),(53,4,2,1),(54,4,3,1),(55,4,4,1),(56,5,4,1),(57,5,5,1),(58,5,6,1),(59,12,3,1),(60,12,4,1),(61,12,5,1),(62,13,4,1),(63,13,5,1),(64,14,2,1),(65,14,3,1),(66,15,3,1),(67,15,4,1),(68,16,2,1),(69,16,3,1),(70,17,4,1),(71,17,5,1),(72,17,7,1);
/*!40000 ALTER TABLE `equipment_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_days`
--

DROP TABLE IF EXISTS `exam_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_days` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `ID_departament` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_days`
--

LOCK TABLES `exam_days` WRITE;
/*!40000 ALTER TABLE `exam_days` DISABLE KEYS */;
INSERT INTO `exam_days` (`ID`, `name`, `ID_departament`) VALUES (1,'Tuesday 17-03\n',2),(2,'Wednesday 18-03\n',2),(3,'Thursday 19-03\n',2),(4,'Friday 20-03\n',2),(5,'Saturday 21-03\n',2),(6,'Sunday 22-03\n',2),(7,'Monday 23-03\n',2),(8,'Tuesday 24-03\n',2),(9,'Wednesday 25-03\n',2),(10,'Thursday 26-03\n',2),(11,'Friday 27-03\n',2),(12,'Saturday 28-03\n',2),(13,'Sunday 29-03\n',2),(14,'Monday 30-03\n',2),(15,'Sunday 01-03\n',1),(16,'Monday 02-03\n',1),(17,'Tuesday 03-03\n',1),(18,'Wednesday 04-03\n',1),(19,'Thursday 05-03\n',1),(20,'Friday 06-03\n',1),(21,'Saturday 07-03\n',1),(22,'Sunday 08-03\n',1),(23,'Monday 09-03\n',1);
/*!40000 ALTER TABLE `exam_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_programme`
--

DROP TABLE IF EXISTS `exam_programme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_programme` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_semester_course` int(10) NOT NULL,
  `ID_day` int(10) NOT NULL,
  `ID_hour` int(10) NOT NULL,
  `ID_user` int(10) NOT NULL,
  `ID_schedule` int(10) NOT NULL,
  `ID_departament` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_semester_course` (`ID_semester_course`),
  KEY `ID_day` (`ID_day`),
  KEY `ID_user` (`ID_user`),
  KEY `ID_schedule` (`ID_schedule`),
  CONSTRAINT `exam_programme_ibfk_1` FOREIGN KEY (`ID_semester_course`) REFERENCES `semester_course` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `exam_programme_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `exam_programme_ibfk_3` FOREIGN KEY (`ID_schedule`) REFERENCES `schedules` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `exam_programme_ibfk_4` FOREIGN KEY (`ID_day`) REFERENCES `exam_days` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_programme`
--

LOCK TABLES `exam_programme` WRITE;
/*!40000 ALTER TABLE `exam_programme` DISABLE KEYS */;
INSERT INTO `exam_programme` (`ID`, `ID_semester_course`, `ID_day`, `ID_hour`, `ID_user`, `ID_schedule`, `ID_departament`) VALUES (68,280,2,8,30,1,1),(69,278,3,8,19,1,1),(70,254,4,8,8,1,1),(72,254,5,8,8,1,1),(73,266,2,9,7,1,1),(74,289,3,9,10,1,1),(75,277,4,9,32,1,1),(76,290,4,9,10,1,1),(77,292,6,8,6,1,1),(78,295,6,8,55,1,1),(81,261,5,9,22,1,1),(83,266,6,9,7,1,1),(88,261,3,11,22,1,1),(89,268,4,11,19,1,1),(92,256,3,12,19,1,1),(93,350,3,12,81,1,1),(94,279,5,10,49,1,1),(95,289,5,10,10,1,1),(97,258,4,12,88,1,1),(98,254,2,13,8,1,1),(99,291,5,13,34,1,1),(100,351,2,13,82,1,1),(101,273,2,10,32,1,1),(102,282,10,9,55,1,1),(103,260,3,13,18,1,1),(105,283,6,10,50,1,1),(106,256,9,8,19,1,1),(107,263,9,9,6,1,1),(108,271,12,10,39,1,1),(109,275,6,11,84,1,1),(110,262,1,8,23,1,1);
/*!40000 ALTER TABLE `exam_programme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_programme_rooms`
--

DROP TABLE IF EXISTS `exam_programme_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_programme_rooms` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_day_hour` int(10) DEFAULT NULL,
  `ID_room` int(10) NOT NULL,
  `ID_course` int(10) DEFAULT NULL,
  `active` enum('active','inactive') NOT NULL,
  `ID_departament` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_room` (`ID_room`),
  KEY `ID_course` (`ID_course`),
  CONSTRAINT `exam_programme_rooms_ibfk_1` FOREIGN KEY (`ID_room`) REFERENCES `rooms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `exam_programme_rooms_ibfk_2` FOREIGN KEY (`ID_course`) REFERENCES `course` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_programme_rooms`
--

LOCK TABLES `exam_programme_rooms` WRITE;
/*!40000 ALTER TABLE `exam_programme_rooms` DISABLE KEYS */;
INSERT INTO `exam_programme_rooms` (`ID`, `ID_day_hour`, `ID_room`, `ID_course`, `active`, `ID_departament`) VALUES (86,82,11,209,'active',1),(87,83,3,204,'active',1),(88,84,11,179,'active',1),(90,85,4,179,'active',1),(91,92,5,192,'active',1),(92,93,5,217,'active',1),(93,94,4,203,'active',1),(94,94,3,218,'active',1),(95,86,4,220,'active',1),(96,86,11,224,'active',1),(99,95,5,187,'active',1),(101,96,11,192,'active',1),(106,113,12,187,'active',1),(107,114,5,194,'active',1),(110,123,4,181,'active',1),(111,123,5,262,'active',1),(112,105,5,208,'active',1),(113,105,4,217,'active',1),(115,124,5,184,'active',1),(116,132,5,179,'active',1),(117,135,4,219,'active',1),(118,132,4,263,'active',1),(119,102,4,199,'active',1),(120,910,13,210,'active',1),(121,133,11,186,'active',1),(123,106,11,211,'active',1),(124,89,4,181,'active',1),(125,99,4,189,'active',1),(126,1012,12,197,'active',1),(127,116,5,201,'active',1),(128,81,3,188,'active',1),(129,81,4,188,'active',1),(130,81,11,188,'active',1);
/*!40000 ALTER TABLE `exam_programme_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hours`
--

DROP TABLE IF EXISTS `hours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hours` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `start_hour` int(10) NOT NULL,
  `end_hour` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hours`
--

LOCK TABLES `hours` WRITE;
/*!40000 ALTER TABLE `hours` DISABLE KEYS */;
INSERT INTO `hours` (`ID`, `start_hour`, `end_hour`) VALUES (3,8,21);
/*!40000 ALTER TABLE `hours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kateuthinsi`
--

DROP TABLE IF EXISTS `kateuthinsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kateuthinsi` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `ID_department` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_department` (`ID_department`),
  CONSTRAINT `kateuthinsi_ibfk_1` FOREIGN KEY (`ID_department`) REFERENCES `departament` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kateuthinsi`
--

LOCK TABLES `kateuthinsi` WRITE;
/*!40000 ALTER TABLE `kateuthinsi` DISABLE KEYS */;
INSERT INTO `kateuthinsi` (`ID`, `name`, `ID_department`) VALUES (1,'Κατεύθυνση Eνέργειας',1),(2,'Κατεύθυνση Τηλεπικοινωνιών και Δικτύων',1),(3,'Κατεύθυνση Υπολογιστών και Ηλεκτρονικής',1);
/*!40000 ALTER TABLE `kateuthinsi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `my_course`
--

DROP TABLE IF EXISTS `my_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `my_course` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_user` int(1) NOT NULL,
  `ID_course` int(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_user` (`ID_user`),
  KEY `ID_course` (`ID_course`),
  CONSTRAINT `my_course_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `my_course_ibfk_2` FOREIGN KEY (`ID_course`) REFERENCES `course` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `my_course`
--

LOCK TABLES `my_course` WRITE;
/*!40000 ALTER TABLE `my_course` DISABLE KEYS */;
INSERT INTO `my_course` (`ID`, `ID_user`, `ID_course`) VALUES (50,69,179),(51,69,181),(52,69,183),(53,69,194),(54,12,185),(55,12,187),(56,12,188),(57,12,190),(58,12,191),(59,12,195);
/*!40000 ALTER TABLE `my_course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_user` int(10) NOT NULL,
  `ID_day_hour` int(10) NOT NULL,
  `ID_departament` int(10) NOT NULL,
  `ID_course` int(10) NOT NULL,
  `ID_room` int(10) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `status` int(10) NOT NULL,
  `dt` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password`
--

DROP TABLE IF EXISTS `password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_user` int(10) NOT NULL,
  `pass` varchar(250) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_user` (`ID_user`),
  CONSTRAINT `password_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password`
--

LOCK TABLES `password` WRITE;
/*!40000 ALTER TABLE `password` DISABLE KEYS */;
INSERT INTO `password` (`ID`, `ID_user`, `pass`) VALUES (6,6,'$2y$10$gS04vuxomTwATZYO8zwzcO/fKE7wONDIBWr1oYOlRQduMiW3q1nTe'),(7,7,'1897755008'),(8,8,'1591525942'),(9,9,'1478227113'),(10,10,'2126397606'),(11,12,'$2y$10$oB4HKaucitlI0Qp5rZ/Zt./E43xx6QLZ60ZfEpfTTVo05GR/zSC/2'),(12,13,'$2y$10$4p33gruE0z8RppLZE7gZnecBFLlaeoyLNdzI6NIykeXbyeu81p0C6'),(13,14,'$2y$10$8bEIC.GTgYx9aJQGNSG77uNNt0NnakrZFalIvt8Txbgt.nchhGovm'),(15,18,'1900269308'),(16,19,'$2y$10$YPSLHmGGBFXpfHkI1B3TFOWclNtN9uDLDyY/uu32habN9EubKTu3a'),(17,20,'$2y$10$kr5ECqOm.u5COx9EqW5Nf.tUdfVGt5GmgxJW050LuR0xvIPd5YGdW'),(18,21,'1538003143'),(19,22,'1379190045'),(20,23,'829113815'),(21,24,'37542456'),(23,26,'1348341310'),(24,27,'245042579'),(25,28,'1574952102'),(26,29,'115799829'),(27,30,'2074812418'),(28,31,'1953142470'),(29,32,'607249754'),(30,33,'1764303069'),(31,34,'1753899995'),(32,35,'893927513'),(33,36,'1627643887'),(34,37,'2077861989'),(35,38,'2089597202'),(36,39,'489359759'),(39,48,'$2y$10$wce6JK6WPGJCIgfTlajSYuRgKPC.4NTbx1btXJQB0N5zHBOfg/4MC'),(40,49,'$2y$10$YkQLdKfuqskgnoxwmU.zb.VuhhgWey919E.yWno3JwOyTu7XDUyXK'),(41,50,'$2y$10$STiB9rxUgAwijhvrBrTaJuOA4XDS6lnfATpYlKRVbOeq6E.4q6wTe'),(42,51,'$2y$10$THKKyt9zzXWKGy53wvNrh.a75ULB6hy47.tuaayr8MJ/5xcF7EZYe'),(43,52,'$2y$10$G5mAJEAQ2SFQP4uT1.gh5eaM.hjrXuQ.p/39m9r6xP8Z9sXVDrtrq'),(44,53,'$2y$10$Vl4f8Guv7TPcQrrMn/5QtuCF3vnddObppD4xxqL9.jNL45kgMB6/K'),(46,55,'$2y$10$fRmoHCv1CwvkeQ1rA.9mDO8KLAY0j.WJmw0Ak7Ghzgk6sAc7chOia'),(47,56,'$2y$10$T9I4xfska.qUR1pATM93cOL14w7J4dC/z3ZIDH6rLtlv9mbcHf0cm'),(48,57,'$2y$10$n5HLmDKBkw/tM/qs9D87vOGa5fbwO2QCT8LwSKy6nthtPKcxE5HMK'),(58,69,'$2y$10$LAbpnnVgIaeO66RoK1f0cOuPgTfP.6dvWCQXc7OthYOwN1eaycRoe'),(63,74,'$2y$10$3.kqVAFxjjNV3etuvFy7BOD9NRVtB.H3zy1yTs/MUpBacH6qRtKeG'),(65,76,'$2y$10$rvqa50/n3g9bqIns3./M6ekheyzLMVL7sHigeaBqR4qMKKP5Dsbx.'),(69,80,'$2y$10$.S7bc.Jjdibcru.hfJKPae3xv0J.QKpHFvOoFquIouVM8M0cZPtdq'),(70,81,'$2y$10$DlUNCkhvFrBLttPx7ZQFHe5l7mHjHazh8wS1FkDCEHCs6bgWVv5aG'),(71,82,'$2y$10$2j3rpUF6p4J5BRndCl7TOOkdbm4BkAZq4GRWIJ092YlIdkIVtXWfO'),(72,83,'$2y$10$a6fB.6.kwV100vtVaO2jB.9rBBhQnzyDgA57953KLUTJmYYrJUjsa'),(73,84,'$2y$10$vfS5JLg8JKsKOrphhMLqyeFbQt/KX5PuCkDF1jJvk5Y7FmWj6Qxc.'),(77,88,'$2y$10$3LWrP11N.LIbkM4lVCvYO.qUDQedU4NNpo.0f67y9iYS/Oa7ZuX52'),(78,89,'$2y$10$YHlEfS3iOq6K3dXZUzdTweCUxg1aed8W1O9umcdJRQCUb2XwFmZsS'),(79,90,'$2y$10$Y08aZBSnrQHMIajMZJvvzO/nXfwfT4foeHzsh6C1AWlkrA7QvQzG6'),(80,91,'$2y$10$4hEgNUeQzNnEv4DpFEj2E.WN1Fszx8VDRRIhD1GyMtZCSQ1IdkuZW'),(84,95,'$2y$10$0NvC4pNw6dn5VreZws3OqO2762zYLtEVcLCwz7oI/xr8rBLZBdUwG');
/*!40000 ALTER TABLE `password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programme`
--

DROP TABLE IF EXISTS `programme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programme` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_semester_course` int(10) NOT NULL,
  `ID_day` int(10) NOT NULL,
  `ID_hour` int(10) NOT NULL,
  `ID_user` int(10) NOT NULL,
  `ID_schedule` int(10) NOT NULL,
  `ID_departament` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_semester_course` (`ID_semester_course`),
  KEY `ID_day` (`ID_day`),
  KEY `ID_user` (`ID_user`),
  KEY `ID_schedule` (`ID_schedule`),
  KEY `programme_idfk_5` (`ID_departament`),
  CONSTRAINT `programme_ibfk_1` FOREIGN KEY (`ID_semester_course`) REFERENCES `semester_course` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_ibfk_3` FOREIGN KEY (`ID_schedule`) REFERENCES `schedules` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_ibfk_4` FOREIGN KEY (`ID_day`) REFERENCES `days` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_idfk_5` FOREIGN KEY (`ID_departament`) REFERENCES `departament` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1462 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programme`
--

LOCK TABLES `programme` WRITE;
/*!40000 ALTER TABLE `programme` DISABLE KEYS */;
INSERT INTO `programme` (`ID`, `ID_semester_course`, `ID_day`, `ID_hour`, `ID_user`, `ID_schedule`, `ID_departament`) VALUES (1024,305,1,16,24,1,2),(1025,305,1,17,24,1,2),(1030,313,2,9,31,1,2),(1031,313,2,10,31,1,2),(1032,313,2,11,31,1,2),(1033,313,2,12,31,1,2),(1034,315,3,16,30,1,2),(1035,315,3,17,30,1,2),(1036,315,3,18,30,1,2),(1037,315,3,19,30,1,2),(1039,317,3,10,10,1,2),(1040,317,3,11,10,1,2),(1041,318,3,14,10,1,2),(1042,318,3,15,10,1,2),(1043,324,5,12,39,1,2),(1044,324,5,13,39,1,2),(1045,324,5,14,39,1,2),(1046,332,5,16,56,1,2),(1047,332,5,17,56,1,2),(1048,332,5,18,56,1,2),(1239,254,1,11,8,1,1),(1240,254,1,12,8,1,1),(1241,256,1,13,19,1,1),(1242,256,1,14,19,1,1),(1248,259,2,14,21,1,1),(1249,259,2,15,21,1,1),(1255,259,3,14,21,1,1),(1256,259,3,15,21,1,1),(1257,254,3,16,8,1,1),(1258,254,3,17,8,1,1),(1259,256,4,11,19,1,1),(1260,256,4,12,19,1,1),(1261,260,4,13,18,1,1),(1262,260,4,14,18,1,1),(1263,260,5,11,18,1,1),(1264,260,5,12,18,1,1),(1265,260,5,13,18,1,1),(1267,261,1,9,22,1,1),(1268,261,1,10,22,1,1),(1270,262,2,9,23,1,1),(1271,262,2,10,23,1,1),(1272,261,2,11,22,1,1),(1273,261,2,12,22,1,1),(1274,261,2,13,22,1,1),(1275,263,2,15,6,1,1),(1276,263,2,16,6,1,1),(1277,264,2,17,83,1,1),(1279,261,3,8,22,1,1),(1280,261,3,9,22,1,1),(1281,265,3,10,7,1,1),(1282,265,3,11,7,1,1),(1283,266,3,12,7,1,1),(1284,266,3,13,7,1,1),(1285,263,3,18,6,1,1),(1286,263,3,19,6,1,1),(1287,267,4,9,83,1,1),(1288,267,4,10,83,1,1),(1289,266,4,16,7,1,1),(1290,266,4,17,7,1,1),(1291,265,4,18,7,1,1),(1292,265,4,19,7,1,1),(1293,264,4,12,83,1,1),(1294,264,5,13,83,1,1),(1295,267,5,9,83,1,1),(1296,267,5,10,83,1,1),(1297,268,1,9,19,1,1),(1298,268,1,10,19,1,1),(1299,269,1,17,36,1,1),(1300,269,1,18,36,1,1),(1301,270,2,9,26,1,1),(1302,270,2,10,26,1,1),(1303,268,2,15,19,1,1),(1304,268,2,16,19,1,1),(1305,270,2,17,26,1,1),(1306,270,2,18,26,1,1),(1307,270,2,19,26,1,1),(1308,270,2,20,26,1,1),(1309,271,3,10,39,1,1),(1310,271,3,11,39,1,1),(1312,269,3,15,36,1,1),(1313,269,3,16,36,1,1),(1314,271,4,13,39,1,1),(1315,271,4,14,39,1,1),(1316,271,4,15,39,1,1),(1317,271,5,8,39,1,1),(1318,271,5,9,39,1,1),(1319,271,5,10,39,1,1),(1320,271,5,11,39,1,1),(1321,272,5,12,28,1,1),(1322,272,5,15,28,1,1),(1323,272,5,16,28,1,1),(1324,272,5,17,28,1,1),(1325,272,5,18,28,1,1),(1326,274,1,11,48,1,1),(1327,274,1,12,48,1,1),(1330,286,1,15,57,1,1),(1331,276,1,15,8,1,1),(1332,273,1,15,32,1,1),(1333,274,1,13,48,1,1),(1334,286,1,16,57,1,1),(1335,276,1,16,8,1,1),(1336,273,1,16,32,1,1),(1337,277,1,17,32,1,1),(1338,277,1,18,32,1,1),(1339,277,1,19,32,1,1),(1340,277,1,20,32,1,1),(1341,278,2,13,19,1,1),(1342,278,2,14,19,1,1),(1343,279,2,14,49,1,1),(1344,280,2,15,30,1,1),(1345,279,2,15,49,1,1),(1346,280,2,16,30,1,1),(1347,281,2,16,49,1,1),(1348,280,2,17,30,1,1),(1349,281,2,17,49,1,1),(1350,280,2,18,30,1,1),(1354,282,3,12,55,1,1),(1355,282,3,13,55,1,1),(1356,349,3,13,80,1,1),(1357,276,3,14,8,1,1),(1358,276,3,15,8,1,1),(1359,283,3,17,50,1,1),(1360,284,3,18,51,1,1),(1361,283,3,18,50,1,1),(1362,284,3,19,51,1,1),(1363,283,3,19,50,1,1),(1364,285,4,8,52,1,1),(1365,285,4,9,52,1,1),(1366,285,4,10,52,1,1),(1367,285,4,11,52,1,1),(1368,284,4,11,51,1,1),(1369,285,4,12,52,1,1),(1370,284,4,12,51,1,1),(1371,278,4,13,19,1,1),(1372,287,4,13,33,1,1),(1373,278,4,14,19,1,1),(1374,287,4,14,33,1,1),(1375,287,4,15,33,1,1),(1376,282,4,16,55,1,1),(1377,287,4,16,33,1,1),(1378,286,4,16,57,1,1),(1379,282,4,17,55,1,1),(1380,286,4,17,57,1,1),(1381,286,4,18,57,1,1),(1382,283,4,18,50,1,1),(1383,286,4,19,57,1,1),(1384,283,4,19,50,1,1),(1385,279,5,12,49,1,1),(1386,279,5,13,49,1,1),(1387,285,5,14,52,1,1),(1388,281,5,14,49,1,1),(1389,285,5,15,52,1,1),(1390,281,5,15,49,1,1),(1391,285,5,16,52,1,1),(1392,288,5,17,35,1,1),(1393,288,5,18,35,1,1),(1394,288,5,19,35,1,1),(1395,288,5,20,35,1,1),(1396,289,1,11,10,1,1),(1397,290,1,13,10,1,1),(1398,290,1,14,10,1,1),(1399,291,2,9,34,1,1),(1400,291,2,10,34,1,1),(1401,291,2,11,34,1,1),(1402,291,2,12,34,1,1),(1403,292,2,19,6,1,1),(1404,292,2,20,6,1,1),(1405,292,3,16,6,1,1),(1406,292,3,17,6,1,1),(1407,295,3,18,55,1,1),(1408,295,3,19,55,1,1),(1409,295,4,18,55,1,1),(1410,295,4,19,55,1,1),(1411,294,5,9,37,1,1),(1412,294,5,10,37,1,1),(1413,294,5,11,37,1,1),(1414,294,5,12,37,1,1),(1415,296,5,16,38,1,1),(1416,296,5,17,38,1,1),(1417,296,5,18,38,1,1),(1418,296,5,19,38,1,1),(1420,261,1,8,22,1,1),(1421,275,1,13,84,1,1),(1432,257,2,9,88,1,1),(1434,258,2,11,88,1,1),(1435,258,2,12,88,1,1),(1436,257,2,10,88,1,1),(1437,257,3,9,88,1,1),(1438,257,3,10,88,1,1),(1439,258,3,11,88,1,1),(1440,258,3,12,88,1,1),(1441,261,2,8,22,1,1),(1442,271,3,12,39,1,1),(1443,304,2,17,84,1,2),(1444,304,2,18,84,1,2),(1445,304,2,19,84,1,2),(1446,304,2,20,84,1,2),(1447,264,2,18,83,1,1),(1449,264,5,12,83,1,1),(1461,339,4,20,13,1,1);
/*!40000 ALTER TABLE `programme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programme_history`
--

DROP TABLE IF EXISTS `programme_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programme_history` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_semester_course` int(10) NOT NULL,
  `ID_day` int(10) NOT NULL,
  `ID_hour` int(10) NOT NULL,
  `ID_user` int(10) NOT NULL,
  `ID_schedule` int(10) NOT NULL,
  `ID_departament` int(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_semester_course` (`ID_semester_course`),
  KEY `ID_day` (`ID_day`),
  KEY `ID_user` (`ID_user`),
  KEY `ID_schedule` (`ID_schedule`),
  KEY `programme_history_ibfk_5` (`ID_departament`),
  CONSTRAINT `programme_history_ibfk_1` FOREIGN KEY (`ID_semester_course`) REFERENCES `semester_course` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_history_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_history_ibfk_3` FOREIGN KEY (`ID_schedule`) REFERENCES `schedules` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_history_ibfk_4` FOREIGN KEY (`ID_day`) REFERENCES `days` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_history_ibfk_5` FOREIGN KEY (`ID_departament`) REFERENCES `departament` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1824 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programme_history`
--

LOCK TABLES `programme_history` WRITE;
/*!40000 ALTER TABLE `programme_history` DISABLE KEYS */;
INSERT INTO `programme_history` (`ID`, `ID_semester_course`, `ID_day`, `ID_hour`, `ID_user`, `ID_schedule`, `ID_departament`, `type`) VALUES (1475,254,1,11,8,4,1,'1'),(1476,254,1,12,8,4,1,'1'),(1477,256,1,13,19,4,1,'1'),(1478,256,1,14,19,4,1,'1'),(1479,259,2,14,21,4,1,'1'),(1480,259,2,15,21,4,1,'1'),(1481,259,3,14,21,4,1,'1'),(1482,259,3,15,21,4,1,'1'),(1483,254,3,16,8,4,1,'1'),(1484,254,3,17,8,4,1,'1'),(1485,256,4,11,19,4,1,'1'),(1486,256,4,12,19,4,1,'1'),(1487,260,4,13,18,4,1,'1'),(1488,260,4,14,18,4,1,'1'),(1489,260,5,11,18,4,1,'1'),(1490,260,5,12,18,4,1,'1'),(1491,260,5,13,18,4,1,'1'),(1492,261,1,9,22,4,1,'1'),(1493,261,1,10,22,4,1,'1'),(1494,262,2,9,23,4,1,'1'),(1495,262,2,10,23,4,1,'1'),(1496,261,2,11,22,4,1,'1'),(1497,261,2,12,22,4,1,'1'),(1498,261,2,13,22,4,1,'1'),(1499,263,2,15,6,4,1,'1'),(1500,263,2,16,6,4,1,'1'),(1501,264,2,17,83,4,1,'1'),(1502,261,3,8,22,4,1,'1'),(1503,261,3,9,22,4,1,'1'),(1504,265,3,10,7,4,1,'1'),(1505,265,3,11,7,4,1,'1'),(1506,266,3,12,7,4,1,'1'),(1507,266,3,13,7,4,1,'1'),(1508,263,3,18,6,4,1,'1'),(1509,263,3,19,6,4,1,'1'),(1510,267,4,9,83,4,1,'1'),(1511,267,4,10,83,4,1,'1'),(1512,266,4,16,7,4,1,'1'),(1513,266,4,17,7,4,1,'1'),(1514,265,4,18,7,4,1,'1'),(1515,265,4,19,7,4,1,'1'),(1516,264,4,12,83,4,1,'1'),(1517,264,5,13,83,4,1,'1'),(1518,267,5,9,83,4,1,'1'),(1519,267,5,10,83,4,1,'1'),(1520,268,1,9,19,4,1,'1'),(1521,268,1,10,19,4,1,'1'),(1522,269,1,17,36,4,1,'1'),(1523,269,1,18,36,4,1,'1'),(1524,270,2,9,26,4,1,'1'),(1525,270,2,10,26,4,1,'1'),(1526,268,2,15,19,4,1,'1'),(1527,268,2,16,19,4,1,'1'),(1528,270,2,17,26,4,1,'1'),(1529,270,2,18,26,4,1,'1'),(1530,270,2,19,26,4,1,'1'),(1531,270,2,20,26,4,1,'1'),(1532,271,3,10,39,4,1,'1'),(1533,271,3,11,39,4,1,'1'),(1534,269,3,15,36,4,1,'1'),(1535,269,3,16,36,4,1,'1'),(1536,271,4,13,39,4,1,'1'),(1537,271,4,14,39,4,1,'1'),(1538,271,4,15,39,4,1,'1'),(1539,271,5,8,39,4,1,'1'),(1540,271,5,9,39,4,1,'1'),(1541,271,5,10,39,4,1,'1'),(1542,271,5,11,39,4,1,'1'),(1543,272,5,12,28,4,1,'1'),(1544,272,5,15,28,4,1,'1'),(1545,272,5,16,28,4,1,'1'),(1546,272,5,17,28,4,1,'1'),(1547,272,5,18,28,4,1,'1'),(1548,274,1,11,48,4,1,'1'),(1549,274,1,12,48,4,1,'1'),(1550,286,1,15,57,4,1,'1'),(1551,276,1,15,8,4,1,'1'),(1552,273,1,15,32,4,1,'1'),(1553,274,1,13,48,4,1,'1'),(1554,286,1,16,57,4,1,'1'),(1555,276,1,16,8,4,1,'1'),(1556,273,1,16,32,4,1,'1'),(1557,277,1,17,32,4,1,'1'),(1558,277,1,18,32,4,1,'1'),(1559,277,1,19,32,4,1,'1'),(1560,277,1,20,32,4,1,'1'),(1561,278,2,13,19,4,1,'1'),(1562,278,2,14,19,4,1,'1'),(1563,279,2,14,49,4,1,'1'),(1564,280,2,15,30,4,1,'1'),(1565,279,2,15,49,4,1,'1'),(1566,280,2,16,30,4,1,'1'),(1567,281,2,16,49,4,1,'1'),(1568,280,2,17,30,4,1,'1'),(1569,281,2,17,49,4,1,'1'),(1570,280,2,18,30,4,1,'1'),(1571,282,3,12,55,4,1,'1'),(1572,282,3,13,55,4,1,'1'),(1573,349,3,13,80,4,1,'1'),(1574,276,3,14,8,4,1,'1'),(1575,276,3,15,8,4,1,'1'),(1576,283,3,17,50,4,1,'1'),(1577,284,3,18,51,4,1,'1'),(1578,283,3,18,50,4,1,'1'),(1579,284,3,19,51,4,1,'1'),(1580,283,3,19,50,4,1,'1'),(1581,285,4,8,52,4,1,'1'),(1582,285,4,9,52,4,1,'1'),(1583,285,4,10,52,4,1,'1'),(1584,285,4,11,52,4,1,'1'),(1585,284,4,11,51,4,1,'1'),(1586,285,4,12,52,4,1,'1'),(1587,284,4,12,51,4,1,'1'),(1588,278,4,13,19,4,1,'1'),(1589,287,4,13,33,4,1,'1'),(1590,278,4,14,19,4,1,'1'),(1591,287,4,14,33,4,1,'1'),(1592,287,4,15,33,4,1,'1'),(1593,282,4,16,55,4,1,'1'),(1594,287,4,16,33,4,1,'1'),(1595,286,4,16,57,4,1,'1'),(1596,282,4,17,55,4,1,'1'),(1597,286,4,17,57,4,1,'1'),(1598,286,4,18,57,4,1,'1'),(1599,283,4,18,50,4,1,'1'),(1600,286,4,19,57,4,1,'1'),(1601,283,4,19,50,4,1,'1'),(1602,279,5,12,49,4,1,'1'),(1603,279,5,13,49,4,1,'1'),(1604,285,5,14,52,4,1,'1'),(1605,281,5,14,49,4,1,'1'),(1606,285,5,15,52,4,1,'1'),(1607,281,5,15,49,4,1,'1'),(1608,285,5,16,52,4,1,'1'),(1609,288,5,17,35,4,1,'1'),(1610,288,5,18,35,4,1,'1'),(1611,288,5,19,35,4,1,'1'),(1612,288,5,20,35,4,1,'1'),(1613,289,1,11,10,4,1,'1'),(1614,290,1,13,10,4,1,'1'),(1615,290,1,14,10,4,1,'1'),(1616,291,2,9,34,4,1,'1'),(1617,291,2,10,34,4,1,'1'),(1618,291,2,11,34,4,1,'1'),(1619,291,2,12,34,4,1,'1'),(1620,292,2,19,6,4,1,'1'),(1621,292,2,20,6,4,1,'1'),(1622,292,3,16,6,4,1,'1'),(1623,292,3,17,6,4,1,'1'),(1624,295,3,18,55,4,1,'1'),(1625,295,3,19,55,4,1,'1'),(1626,295,4,18,55,4,1,'1'),(1627,295,4,19,55,4,1,'1'),(1628,294,5,9,37,4,1,'1'),(1629,294,5,10,37,4,1,'1'),(1630,294,5,11,37,4,1,'1'),(1631,294,5,12,37,4,1,'1'),(1632,296,5,16,38,4,1,'1'),(1633,296,5,17,38,4,1,'1'),(1634,296,5,18,38,4,1,'1'),(1635,296,5,19,38,4,1,'1'),(1636,261,1,8,22,4,1,'1'),(1637,275,1,13,84,4,1,'1'),(1638,257,2,9,88,4,1,'1'),(1639,258,2,11,88,4,1,'1'),(1640,258,2,12,88,4,1,'1'),(1641,257,2,10,88,4,1,'1'),(1642,257,3,9,88,4,1,'1'),(1643,257,3,10,88,4,1,'1'),(1644,258,3,11,88,4,1,'1'),(1645,258,3,12,88,4,1,'1'),(1646,261,2,8,22,4,1,'1'),(1647,271,3,12,39,4,1,'1'),(1648,264,2,18,83,4,1,'1'),(1649,254,1,11,8,1,1,'1'),(1650,254,1,12,8,1,1,'1'),(1651,256,1,13,19,1,1,'1'),(1652,256,1,14,19,1,1,'1'),(1653,259,2,14,21,1,1,'1'),(1654,259,2,15,21,1,1,'1'),(1655,259,3,14,21,1,1,'1'),(1656,259,3,15,21,1,1,'1'),(1657,254,3,16,8,1,1,'1'),(1658,254,3,17,8,1,1,'1'),(1659,256,4,11,19,1,1,'1'),(1660,256,4,12,19,1,1,'1'),(1661,260,4,13,18,1,1,'1'),(1662,260,4,14,18,1,1,'1'),(1663,260,5,11,18,1,1,'1'),(1664,260,5,12,18,1,1,'1'),(1665,260,5,13,18,1,1,'1'),(1666,261,1,9,22,1,1,'1'),(1667,261,1,10,22,1,1,'1'),(1668,262,2,9,23,1,1,'1'),(1669,262,2,10,23,1,1,'1'),(1670,261,2,11,22,1,1,'1'),(1671,261,2,12,22,1,1,'1'),(1672,261,2,13,22,1,1,'1'),(1673,263,2,15,6,1,1,'1'),(1674,263,2,16,6,1,1,'1'),(1675,264,2,17,83,1,1,'1'),(1676,261,3,8,22,1,1,'1'),(1677,261,3,9,22,1,1,'1'),(1678,265,3,10,7,1,1,'1'),(1679,265,3,11,7,1,1,'1'),(1680,266,3,12,7,1,1,'1'),(1681,266,3,13,7,1,1,'1'),(1682,263,3,18,6,1,1,'1'),(1683,263,3,19,6,1,1,'1'),(1684,267,4,9,83,1,1,'1'),(1685,267,4,10,83,1,1,'1'),(1686,266,4,16,7,1,1,'1'),(1687,266,4,17,7,1,1,'1'),(1688,265,4,18,7,1,1,'1'),(1689,265,4,19,7,1,1,'1'),(1690,264,4,12,83,1,1,'1'),(1691,264,5,13,83,1,1,'1'),(1692,267,5,9,83,1,1,'1'),(1693,267,5,10,83,1,1,'1'),(1694,268,1,9,19,1,1,'1'),(1695,268,1,10,19,1,1,'1'),(1696,269,1,17,36,1,1,'1'),(1697,269,1,18,36,1,1,'1'),(1698,270,2,9,26,1,1,'1'),(1699,270,2,10,26,1,1,'1'),(1700,268,2,15,19,1,1,'1'),(1701,268,2,16,19,1,1,'1'),(1702,270,2,17,26,1,1,'1'),(1703,270,2,18,26,1,1,'1'),(1704,270,2,19,26,1,1,'1'),(1705,270,2,20,26,1,1,'1'),(1706,271,3,10,39,1,1,'1'),(1707,271,3,11,39,1,1,'1'),(1708,269,3,15,36,1,1,'1'),(1709,269,3,16,36,1,1,'1'),(1710,271,4,13,39,1,1,'1'),(1711,271,4,14,39,1,1,'1'),(1712,271,4,15,39,1,1,'1'),(1713,271,5,8,39,1,1,'1'),(1714,271,5,9,39,1,1,'1'),(1715,271,5,10,39,1,1,'1'),(1716,271,5,11,39,1,1,'1'),(1717,272,5,12,28,1,1,'1'),(1718,272,5,15,28,1,1,'1'),(1719,272,5,16,28,1,1,'1'),(1720,272,5,17,28,1,1,'1'),(1721,272,5,18,28,1,1,'1'),(1722,274,1,11,48,1,1,'1'),(1723,274,1,12,48,1,1,'1'),(1724,286,1,15,57,1,1,'1'),(1725,276,1,15,8,1,1,'1'),(1726,273,1,15,32,1,1,'1'),(1727,274,1,13,48,1,1,'1'),(1728,286,1,16,57,1,1,'1'),(1729,276,1,16,8,1,1,'1'),(1730,273,1,16,32,1,1,'1'),(1731,277,1,17,32,1,1,'1'),(1732,277,1,18,32,1,1,'1'),(1733,277,1,19,32,1,1,'1'),(1734,277,1,20,32,1,1,'1'),(1735,278,2,13,19,1,1,'1'),(1736,278,2,14,19,1,1,'1'),(1737,279,2,14,49,1,1,'1'),(1738,280,2,15,30,1,1,'1'),(1739,279,2,15,49,1,1,'1'),(1740,280,2,16,30,1,1,'1'),(1741,281,2,16,49,1,1,'1'),(1742,280,2,17,30,1,1,'1'),(1743,281,2,17,49,1,1,'1'),(1744,280,2,18,30,1,1,'1'),(1745,282,3,12,55,1,1,'1'),(1746,282,3,13,55,1,1,'1'),(1747,349,3,13,80,1,1,'1'),(1748,276,3,14,8,1,1,'1'),(1749,276,3,15,8,1,1,'1'),(1750,283,3,17,50,1,1,'1'),(1751,284,3,18,51,1,1,'1'),(1752,283,3,18,50,1,1,'1'),(1753,284,3,19,51,1,1,'1'),(1754,283,3,19,50,1,1,'1'),(1755,285,4,8,52,1,1,'1'),(1756,285,4,9,52,1,1,'1'),(1757,285,4,10,52,1,1,'1'),(1758,285,4,11,52,1,1,'1'),(1759,284,4,11,51,1,1,'1'),(1760,285,4,12,52,1,1,'1'),(1761,284,4,12,51,1,1,'1'),(1762,278,4,13,19,1,1,'1'),(1763,287,4,13,33,1,1,'1'),(1764,278,4,14,19,1,1,'1'),(1765,287,4,14,33,1,1,'1'),(1766,287,4,15,33,1,1,'1'),(1767,282,4,16,55,1,1,'1'),(1768,287,4,16,33,1,1,'1'),(1769,286,4,16,57,1,1,'1'),(1770,282,4,17,55,1,1,'1'),(1771,286,4,17,57,1,1,'1'),(1772,286,4,18,57,1,1,'1'),(1773,283,4,18,50,1,1,'1'),(1774,286,4,19,57,1,1,'1'),(1775,283,4,19,50,1,1,'1'),(1776,279,5,12,49,1,1,'1'),(1777,279,5,13,49,1,1,'1'),(1778,285,5,14,52,1,1,'1'),(1779,281,5,14,49,1,1,'1'),(1780,285,5,15,52,1,1,'1'),(1781,281,5,15,49,1,1,'1'),(1782,285,5,16,52,1,1,'1'),(1783,288,5,17,35,1,1,'1'),(1784,288,5,18,35,1,1,'1'),(1785,288,5,19,35,1,1,'1'),(1786,288,5,20,35,1,1,'1'),(1787,289,1,11,10,1,1,'1'),(1788,290,1,13,10,1,1,'1'),(1789,290,1,14,10,1,1,'1'),(1790,291,2,9,34,1,1,'1'),(1791,291,2,10,34,1,1,'1'),(1792,291,2,11,34,1,1,'1'),(1793,291,2,12,34,1,1,'1'),(1794,292,2,19,6,1,1,'1'),(1795,292,2,20,6,1,1,'1'),(1796,292,3,16,6,1,1,'1'),(1797,292,3,17,6,1,1,'1'),(1798,295,3,18,55,1,1,'1'),(1799,295,3,19,55,1,1,'1'),(1800,295,4,18,55,1,1,'1'),(1801,295,4,19,55,1,1,'1'),(1802,294,5,9,37,1,1,'1'),(1803,294,5,10,37,1,1,'1'),(1804,294,5,11,37,1,1,'1'),(1805,294,5,12,37,1,1,'1'),(1806,296,5,16,38,1,1,'1'),(1807,296,5,17,38,1,1,'1'),(1808,296,5,18,38,1,1,'1'),(1809,296,5,19,38,1,1,'1'),(1810,261,1,8,22,1,1,'1'),(1811,275,1,13,84,1,1,'1'),(1812,257,2,9,88,1,1,'1'),(1813,258,2,11,88,1,1,'1'),(1814,258,2,12,88,1,1,'1'),(1815,257,2,10,88,1,1,'1'),(1816,257,3,9,88,1,1,'1'),(1817,257,3,10,88,1,1,'1'),(1818,258,3,11,88,1,1,'1'),(1819,258,3,12,88,1,1,'1'),(1820,261,2,8,22,1,1,'1'),(1821,271,3,12,39,1,1,'1'),(1822,264,2,18,83,1,1,'1'),(1823,264,5,12,83,1,1,'1');
/*!40000 ALTER TABLE `programme_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programme_rooms`
--

DROP TABLE IF EXISTS `programme_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programme_rooms` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_day_hour` int(10) DEFAULT NULL,
  `ID_room` int(10) NOT NULL,
  `ID_course` int(10) DEFAULT NULL,
  `active` enum('active','inactive') NOT NULL,
  `ID_departament` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_room` (`ID_room`),
  KEY `ID_course` (`ID_course`),
  KEY `programme_rooms_idfk_3` (`ID_departament`),
  CONSTRAINT `programme_rooms_ibfk_1` FOREIGN KEY (`ID_room`) REFERENCES `rooms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_rooms_ibfk_2` FOREIGN KEY (`ID_course`) REFERENCES `course` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_rooms_idfk_3` FOREIGN KEY (`ID_departament`) REFERENCES `departament` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1411 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programme_rooms`
--

LOCK TABLES `programme_rooms` WRITE;
/*!40000 ALTER TABLE `programme_rooms` DISABLE KEYS */;
INSERT INTO `programme_rooms` (`ID`, `ID_day_hour`, `ID_room`, `ID_course`, `active`, `ID_departament`) VALUES (939,161,11,227,'active',2),(940,171,11,227,'active',2),(945,92,3,231,'active',2),(946,102,3,231,'active',2),(947,112,13,231,'active',2),(948,122,13,231,'active',2),(949,163,11,232,'active',2),(950,173,11,232,'active',2),(951,183,8,232,'active',2),(952,193,8,232,'active',2),(954,103,8,217,'active',2),(955,113,8,217,'active',2),(956,143,11,218,'active',2),(957,153,11,218,'active',2),(958,125,12,236,'active',2),(959,135,12,236,'active',2),(960,145,12,236,'active',2),(961,165,15,239,'active',2),(962,175,15,239,'active',2),(963,185,15,239,'active',2),(1170,111,5,179,'active',1),(1171,121,5,179,'active',1),(1172,131,5,181,'active',1),(1173,141,5,181,'active',1),(1179,142,5,185,'active',1),(1180,152,5,185,'active',1),(1186,143,5,185,'active',1),(1187,153,5,185,'active',1),(1188,163,3,179,'active',1),(1189,163,8,179,'active',1),(1190,173,3,179,'active',1),(1191,173,8,179,'active',1),(1192,114,5,181,'active',1),(1193,124,5,181,'active',1),(1194,134,12,186,'active',1),(1195,144,12,186,'active',1),(1196,115,5,186,'active',1),(1197,125,5,186,'active',1),(1198,135,5,186,'active',1),(1200,91,5,187,'active',1),(1201,101,5,187,'active',1),(1202,92,11,188,'active',1),(1203,102,11,188,'active',1),(1204,112,12,187,'active',1),(1205,122,12,187,'active',1),(1206,132,12,187,'active',1),(1207,152,11,189,'active',1),(1208,162,11,189,'active',1),(1209,172,3,190,'active',1),(1210,83,12,187,'active',1),(1211,93,12,187,'active',1),(1212,103,3,191,'active',1),(1213,113,3,191,'active',1),(1214,123,3,192,'active',1),(1215,133,3,192,'active',1),(1216,183,3,189,'active',1),(1217,193,3,189,'active',1),(1218,94,5,193,'active',1),(1219,104,5,193,'active',1),(1220,164,5,192,'active',1),(1221,174,5,192,'active',1),(1222,184,5,191,'active',1),(1223,194,5,191,'active',1),(1224,124,4,190,'active',1),(1225,135,4,190,'active',1),(1226,95,5,193,'active',1),(1227,105,5,193,'active',1),(1228,91,3,194,'active',1),(1229,91,8,194,'active',1),(1230,101,3,194,'active',1),(1231,101,8,194,'active',1),(1232,171,3,195,'active',1),(1233,181,3,195,'active',1),(1234,92,4,196,'active',1),(1235,102,4,196,'active',1),(1236,152,3,194,'active',1),(1237,162,3,194,'active',1),(1238,172,12,196,'active',1),(1239,182,12,196,'active',1),(1240,192,12,196,'active',1),(1241,202,12,196,'active',1),(1242,103,12,197,'active',1),(1243,113,12,197,'active',1),(1244,153,4,195,'active',1),(1245,163,5,195,'active',1),(1246,134,5,197,'active',1),(1247,144,5,197,'active',1),(1248,154,5,197,'active',1),(1249,85,12,197,'active',1),(1250,95,12,197,'active',1),(1251,105,12,197,'active',1),(1252,115,12,197,'active',1),(1253,125,3,198,'active',1),(1254,155,8,198,'active',1),(1255,165,8,198,'active',1),(1256,175,8,198,'active',1),(1257,185,8,198,'active',1),(1258,111,15,200,'active',1),(1259,121,15,200,'active',1),(1262,151,3,237,'active',1),(1263,151,5,223,'active',1),(1264,151,8,199,'active',1),(1265,131,15,200,'active',1),(1266,161,3,237,'active',1),(1267,161,5,223,'active',1),(1268,161,8,199,'active',1),(1269,171,8,203,'active',1),(1270,181,8,203,'active',1),(1271,191,8,203,'active',1),(1272,201,8,203,'active',1),(1273,132,3,204,'active',1),(1274,142,3,204,'active',1),(1275,142,15,208,'active',1),(1276,152,4,209,'active',1),(1277,152,15,208,'active',1),(1278,162,4,209,'active',1),(1279,162,15,207,'active',1),(1280,172,8,209,'active',1),(1281,172,15,207,'active',1),(1282,182,8,209,'active',1),(1286,123,4,210,'active',1),(1287,133,4,210,'active',1),(1288,133,17,261,'active',1),(1289,143,3,223,'active',1),(1290,153,3,223,'active',1),(1291,173,15,211,'active',1),(1292,183,11,212,'active',1),(1293,183,15,211,'active',1),(1294,193,11,212,'active',1),(1295,193,15,211,'active',1),(1296,84,12,213,'active',1),(1297,94,12,213,'active',1),(1298,104,3,213,'active',1),(1299,104,12,213,'active',1),(1300,114,3,213,'active',1),(1301,114,12,213,'active',1),(1302,114,8,212,'active',1),(1303,124,12,213,'active',1),(1304,124,8,212,'active',1),(1305,134,3,204,'active',1),(1306,134,11,215,'active',1),(1307,144,3,204,'active',1),(1308,144,11,215,'active',1),(1309,154,14,215,'active',1),(1310,164,4,210,'active',1),(1311,164,12,215,'active',1),(1312,164,14,237,'active',1),(1313,174,4,210,'active',1),(1314,174,12,237,'active',1),(1315,184,12,237,'active',1),(1316,184,15,211,'active',1),(1317,194,12,237,'active',1),(1318,194,15,211,'active',1),(1319,125,15,208,'active',1),(1320,135,15,208,'active',1),(1321,145,4,213,'active',1),(1322,145,15,207,'active',1),(1323,155,4,213,'active',1),(1324,155,15,207,'active',1),(1325,165,4,213,'active',1),(1326,175,4,216,'active',1),(1327,185,4,216,'active',1),(1328,195,8,216,'active',1),(1329,205,8,216,'active',1),(1330,111,11,217,'active',1),(1331,131,4,218,'active',1),(1332,141,4,218,'active',1),(1333,92,8,219,'active',1),(1334,102,8,219,'active',1),(1335,112,11,219,'active',1),(1336,122,11,219,'active',1),(1337,192,4,220,'active',1),(1338,202,4,220,'active',1),(1339,163,4,220,'active',1),(1340,173,4,220,'active',1),(1341,183,4,224,'active',1),(1342,193,4,224,'active',1),(1343,184,4,224,'active',1),(1344,194,4,224,'active',1),(1345,95,11,222,'active',1),(1346,105,11,222,'active',1),(1347,115,11,222,'active',1),(1348,125,11,222,'active',1),(1349,165,3,225,'active',1),(1350,175,3,225,'active',1),(1351,185,3,225,'active',1),(1352,195,3,225,'active',1),(1354,81,5,187,'active',1),(1355,131,3,201,'active',1),(1366,92,5,183,'active',1),(1368,112,5,184,'active',1),(1369,122,5,184,'active',1),(1370,102,5,183,'active',1),(1371,93,5,183,'active',1),(1372,103,5,183,'active',1),(1373,113,5,184,'active',1),(1374,123,5,184,'active',1),(1375,82,12,187,'active',1),(1376,123,12,197,'active',1),(1377,172,9,226,'active',2),(1378,182,9,226,'active',2),(1379,192,9,226,'active',2),(1380,202,9,226,'active',2),(1381,182,3,190,'active',1),(1383,125,4,190,'active',1),(1408,204,3,248,'active',1),(1409,204,4,248,'active',1),(1410,204,11,248,'active',1);
/*!40000 ALTER TABLE `programme_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programme_rooms_history`
--

DROP TABLE IF EXISTS `programme_rooms_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programme_rooms_history` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_day_hour` int(10) NOT NULL,
  `ID_room` int(10) NOT NULL,
  `ID_course` int(10) NOT NULL,
  `ID_schedule` int(10) NOT NULL,
  `ID_departament` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_room` (`ID_room`),
  KEY `ID_course` (`ID_course`),
  KEY `ID_schedule` (`ID_schedule`),
  CONSTRAINT `programme_rooms_history_ibfk_1` FOREIGN KEY (`ID_room`) REFERENCES `rooms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_rooms_history_ibfk_2` FOREIGN KEY (`ID_course`) REFERENCES `course` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `programme_rooms_history_ibfk_3` FOREIGN KEY (`ID_schedule`) REFERENCES `schedules` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=780 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programme_rooms_history`
--

LOCK TABLES `programme_rooms_history` WRITE;
/*!40000 ALTER TABLE `programme_rooms_history` DISABLE KEYS */;
INSERT INTO `programme_rooms_history` (`ID`, `ID_day_hour`, `ID_room`, `ID_course`, `ID_schedule`, `ID_departament`) VALUES (419,111,5,179,4,1),(420,121,5,179,4,1),(421,131,5,181,4,1),(422,141,5,181,4,1),(423,142,5,185,4,1),(424,152,5,185,4,1),(425,143,5,185,4,1),(426,153,5,185,4,1),(427,163,3,179,4,1),(428,163,8,179,4,1),(429,173,3,179,4,1),(430,173,8,179,4,1),(431,114,5,181,4,1),(432,124,5,181,4,1),(433,134,12,186,4,1),(434,144,12,186,4,1),(435,115,5,186,4,1),(436,125,5,186,4,1),(437,135,5,186,4,1),(438,91,5,187,4,1),(439,101,5,187,4,1),(440,92,11,188,4,1),(441,102,11,188,4,1),(442,112,12,187,4,1),(443,122,12,187,4,1),(444,132,12,187,4,1),(445,152,11,189,4,1),(446,162,11,189,4,1),(447,172,3,190,4,1),(448,83,12,187,4,1),(449,93,12,187,4,1),(450,103,3,191,4,1),(451,113,3,191,4,1),(452,123,3,192,4,1),(453,133,3,192,4,1),(454,183,3,189,4,1),(455,193,3,189,4,1),(456,94,5,193,4,1),(457,104,5,193,4,1),(458,164,5,192,4,1),(459,174,5,192,4,1),(460,184,5,191,4,1),(461,194,5,191,4,1),(462,124,4,190,4,1),(463,135,4,190,4,1),(464,95,5,193,4,1),(465,105,5,193,4,1),(466,91,3,194,4,1),(467,91,8,194,4,1),(468,101,3,194,4,1),(469,101,8,194,4,1),(470,171,3,195,4,1),(471,181,3,195,4,1),(472,92,4,196,4,1),(473,102,4,196,4,1),(474,152,3,194,4,1),(475,162,3,194,4,1),(476,172,12,196,4,1),(477,182,12,196,4,1),(478,192,12,196,4,1),(479,202,12,196,4,1),(480,103,12,197,4,1),(481,113,12,197,4,1),(482,153,4,195,4,1),(483,163,5,195,4,1),(484,134,5,197,4,1),(485,144,5,197,4,1),(486,154,5,197,4,1),(487,85,12,197,4,1),(488,95,12,197,4,1),(489,105,12,197,4,1),(490,115,12,197,4,1),(491,125,3,198,4,1),(492,155,8,198,4,1),(493,165,8,198,4,1),(494,175,8,198,4,1),(495,185,8,198,4,1),(496,111,15,200,4,1),(497,121,15,200,4,1),(498,151,3,237,4,1),(499,151,5,223,4,1),(500,151,8,199,4,1),(501,131,15,200,4,1),(502,161,3,237,4,1),(503,161,5,223,4,1),(504,161,8,199,4,1),(505,171,8,203,4,1),(506,181,8,203,4,1),(507,191,8,203,4,1),(508,201,8,203,4,1),(509,132,3,204,4,1),(510,142,3,204,4,1),(511,142,15,208,4,1),(512,152,4,209,4,1),(513,152,15,208,4,1),(514,162,4,209,4,1),(515,162,15,207,4,1),(516,172,8,209,4,1),(517,172,15,207,4,1),(518,182,8,209,4,1),(519,123,4,210,4,1),(520,133,4,210,4,1),(521,133,17,261,4,1),(522,143,3,223,4,1),(523,153,3,223,4,1),(524,173,15,211,4,1),(525,183,11,212,4,1),(526,183,15,211,4,1),(527,193,11,212,4,1),(528,193,15,211,4,1),(529,84,12,213,4,1),(530,94,12,213,4,1),(531,104,3,213,4,1),(532,104,12,213,4,1),(533,114,3,213,4,1),(534,114,12,213,4,1),(535,114,8,212,4,1),(536,124,12,213,4,1),(537,124,8,212,4,1),(538,134,3,204,4,1),(539,134,11,215,4,1),(540,144,3,204,4,1),(541,144,11,215,4,1),(542,154,14,215,4,1),(543,164,4,210,4,1),(544,164,12,215,4,1),(545,164,14,237,4,1),(546,174,4,210,4,1),(547,174,12,237,4,1),(548,184,12,237,4,1),(549,184,15,211,4,1),(550,194,12,237,4,1),(551,194,15,211,4,1),(552,125,15,208,4,1),(553,135,15,208,4,1),(554,145,4,213,4,1),(555,145,15,207,4,1),(556,155,4,213,4,1),(557,155,15,207,4,1),(558,165,4,213,4,1),(559,175,4,216,4,1),(560,185,4,216,4,1),(561,195,8,216,4,1),(562,205,8,216,4,1),(563,111,11,217,4,1),(564,131,4,218,4,1),(565,141,4,218,4,1),(566,92,8,219,4,1),(567,102,8,219,4,1),(568,112,11,219,4,1),(569,122,11,219,4,1),(570,192,4,220,4,1),(571,202,4,220,4,1),(572,163,4,220,4,1),(573,173,4,220,4,1),(574,183,4,224,4,1),(575,193,4,224,4,1),(576,184,4,224,4,1),(577,194,4,224,4,1),(578,95,11,222,4,1),(579,105,11,222,4,1),(580,115,11,222,4,1),(581,125,11,222,4,1),(582,165,3,225,4,1),(583,175,3,225,4,1),(584,185,3,225,4,1),(585,195,3,225,4,1),(586,81,5,187,4,1),(587,131,3,201,4,1),(588,92,5,183,4,1),(589,112,5,184,4,1),(590,122,5,184,4,1),(591,102,5,183,4,1),(592,93,5,183,4,1),(593,103,5,183,4,1),(594,113,5,184,4,1),(595,123,5,184,4,1),(596,82,12,187,4,1),(597,123,12,197,4,1),(598,182,3,190,4,1),(599,111,5,179,1,1),(600,121,5,179,1,1),(601,131,5,181,1,1),(602,141,5,181,1,1),(603,142,5,185,1,1),(604,152,5,185,1,1),(605,143,5,185,1,1),(606,153,5,185,1,1),(607,163,3,179,1,1),(608,163,8,179,1,1),(609,173,3,179,1,1),(610,173,8,179,1,1),(611,114,5,181,1,1),(612,124,5,181,1,1),(613,134,12,186,1,1),(614,144,12,186,1,1),(615,115,5,186,1,1),(616,125,5,186,1,1),(617,135,5,186,1,1),(618,91,5,187,1,1),(619,101,5,187,1,1),(620,92,11,188,1,1),(621,102,11,188,1,1),(622,112,12,187,1,1),(623,122,12,187,1,1),(624,132,12,187,1,1),(625,152,11,189,1,1),(626,162,11,189,1,1),(627,172,3,190,1,1),(628,83,12,187,1,1),(629,93,12,187,1,1),(630,103,3,191,1,1),(631,113,3,191,1,1),(632,123,3,192,1,1),(633,133,3,192,1,1),(634,183,3,189,1,1),(635,193,3,189,1,1),(636,94,5,193,1,1),(637,104,5,193,1,1),(638,164,5,192,1,1),(639,174,5,192,1,1),(640,184,5,191,1,1),(641,194,5,191,1,1),(642,124,4,190,1,1),(643,135,4,190,1,1),(644,95,5,193,1,1),(645,105,5,193,1,1),(646,91,3,194,1,1),(647,91,8,194,1,1),(648,101,3,194,1,1),(649,101,8,194,1,1),(650,171,3,195,1,1),(651,181,3,195,1,1),(652,92,4,196,1,1),(653,102,4,196,1,1),(654,152,3,194,1,1),(655,162,3,194,1,1),(656,172,12,196,1,1),(657,182,12,196,1,1),(658,192,12,196,1,1),(659,202,12,196,1,1),(660,103,12,197,1,1),(661,113,12,197,1,1),(662,153,4,195,1,1),(663,163,5,195,1,1),(664,134,5,197,1,1),(665,144,5,197,1,1),(666,154,5,197,1,1),(667,85,12,197,1,1),(668,95,12,197,1,1),(669,105,12,197,1,1),(670,115,12,197,1,1),(671,125,3,198,1,1),(672,155,8,198,1,1),(673,165,8,198,1,1),(674,175,8,198,1,1),(675,185,8,198,1,1),(676,111,15,200,1,1),(677,121,15,200,1,1),(678,151,3,237,1,1),(679,151,5,223,1,1),(680,151,8,199,1,1),(681,131,15,200,1,1),(682,161,3,237,1,1),(683,161,5,223,1,1),(684,161,8,199,1,1),(685,171,8,203,1,1),(686,181,8,203,1,1),(687,191,8,203,1,1),(688,201,8,203,1,1),(689,132,3,204,1,1),(690,142,3,204,1,1),(691,142,15,208,1,1),(692,152,4,209,1,1),(693,152,15,208,1,1),(694,162,4,209,1,1),(695,162,15,207,1,1),(696,172,8,209,1,1),(697,172,15,207,1,1),(698,182,8,209,1,1),(699,123,4,210,1,1),(700,133,4,210,1,1),(701,133,17,261,1,1),(702,143,3,223,1,1),(703,153,3,223,1,1),(704,173,15,211,1,1),(705,183,11,212,1,1),(706,183,15,211,1,1),(707,193,11,212,1,1),(708,193,15,211,1,1),(709,84,12,213,1,1),(710,94,12,213,1,1),(711,104,3,213,1,1),(712,104,12,213,1,1),(713,114,3,213,1,1),(714,114,12,213,1,1),(715,114,8,212,1,1),(716,124,12,213,1,1),(717,124,8,212,1,1),(718,134,3,204,1,1),(719,134,11,215,1,1),(720,144,3,204,1,1),(721,144,11,215,1,1),(722,154,14,215,1,1),(723,164,4,210,1,1),(724,164,12,215,1,1),(725,164,14,237,1,1),(726,174,4,210,1,1),(727,174,12,237,1,1),(728,184,12,237,1,1),(729,184,15,211,1,1),(730,194,12,237,1,1),(731,194,15,211,1,1),(732,125,15,208,1,1),(733,135,15,208,1,1),(734,145,4,213,1,1),(735,145,15,207,1,1),(736,155,4,213,1,1),(737,155,15,207,1,1),(738,165,4,213,1,1),(739,175,4,216,1,1),(740,185,4,216,1,1),(741,195,8,216,1,1),(742,205,8,216,1,1),(743,111,11,217,1,1),(744,131,4,218,1,1),(745,141,4,218,1,1),(746,92,8,219,1,1),(747,102,8,219,1,1),(748,112,11,219,1,1),(749,122,11,219,1,1),(750,192,4,220,1,1),(751,202,4,220,1,1),(752,163,4,220,1,1),(753,173,4,220,1,1),(754,183,4,224,1,1),(755,193,4,224,1,1),(756,184,4,224,1,1),(757,194,4,224,1,1),(758,95,11,222,1,1),(759,105,11,222,1,1),(760,115,11,222,1,1),(761,125,11,222,1,1),(762,165,3,225,1,1),(763,175,3,225,1,1),(764,185,3,225,1,1),(765,195,3,225,1,1),(766,81,5,187,1,1),(767,131,3,201,1,1),(768,92,5,183,1,1),(769,112,5,184,1,1),(770,122,5,184,1,1),(771,102,5,183,1,1),(772,93,5,183,1,1),(773,103,5,183,1,1),(774,113,5,184,1,1),(775,123,5,184,1,1),(776,82,12,187,1,1),(777,123,12,197,1,1),(778,182,3,190,1,1),(779,125,4,190,1,1);
/*!40000 ALTER TABLE `programme_rooms_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_depart`
--

DROP TABLE IF EXISTS `room_depart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_depart` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_room` int(10) NOT NULL,
  `ID_departament` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_room` (`ID_room`),
  KEY `ID_departament` (`ID_departament`),
  CONSTRAINT `room_depart_ibfk_1` FOREIGN KEY (`ID_room`) REFERENCES `rooms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `room_depart_ibfk_2` FOREIGN KEY (`ID_departament`) REFERENCES `departament` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_depart`
--

LOCK TABLES `room_depart` WRITE;
/*!40000 ALTER TABLE `room_depart` DISABLE KEYS */;
INSERT INTO `room_depart` (`ID`, `ID_room`, `ID_departament`) VALUES (1,8,1),(2,9,1),(3,3,1),(4,4,1),(5,5,1),(13,11,1),(14,12,1),(15,13,1),(16,14,1),(17,15,1),(18,16,1),(19,17,1);
/*!40000 ALTER TABLE `room_depart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` (`ID`, `name`) VALUES (3,'Αιθουσα Α'),(4,'Αιθουσα Β'),(5,'Αμφιθέατρο'),(8,'Υπολ'),(9,'Αρχιτ'),(11,'Αιθουσα Γ'),(12,'ΕΡΓ'),(13,'ΤΗΛΕΠ'),(14,'Ηλεκ'),(15,'ΤΜΜ'),(16,'ΑΡΓΥΡ'),(17,'Εργ.Υπολογιστών Κοίλα');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` (`ID`, `name`) VALUES (1,'2020'),(2,'2019'),(4,'2018'),(5,'2021'),(6,'2022'),(7,'2023'),(8,'2024'),(9,'2025'),(10,'2026'),(11,'2027'),(12,'2028'),(13,'2029'),(14,'2030');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semester`
--

DROP TABLE IF EXISTS `semester`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `semester` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(5) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semester`
--

LOCK TABLES `semester` WRITE;
/*!40000 ALTER TABLE `semester` DISABLE KEYS */;
INSERT INTO `semester` (`ID`, `name`) VALUES (1,'1o'),(2,'2o'),(3,'3o'),(4,'4o'),(5,'5o'),(6,'6o'),(7,'7o'),(8,'8o'),(9,'9o'),(10,'10o');
/*!40000 ALTER TABLE `semester` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semester_course`
--

DROP TABLE IF EXISTS `semester_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `semester_course` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ID_course` int(11) NOT NULL,
  `ID_semester` int(11) NOT NULL,
  `ID_depart` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_course` (`ID_course`),
  KEY `ID_semester` (`ID_semester`),
  KEY `semester_course_ibfk_3` (`ID_depart`),
  CONSTRAINT `semester_course_ibfk_1` FOREIGN KEY (`ID_course`) REFERENCES `course` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `semester_course_ibfk_2` FOREIGN KEY (`ID_semester`) REFERENCES `semester` (`ID`),
  CONSTRAINT `semester_course_ibfk_3` FOREIGN KEY (`ID_depart`) REFERENCES `departament` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=352 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semester_course`
--

LOCK TABLES `semester_course` WRITE;
/*!40000 ALTER TABLE `semester_course` DISABLE KEYS */;
INSERT INTO `semester_course` (`ID`, `ID_course`, `ID_semester`, `ID_depart`) VALUES (254,179,2,1),(256,181,2,1),(257,183,2,1),(258,184,2,1),(259,185,2,1),(260,186,2,1),(261,187,4,1),(262,188,4,1),(263,189,4,1),(264,190,4,1),(265,191,4,1),(266,192,4,1),(267,193,4,1),(268,194,6,1),(269,195,6,1),(270,196,6,1),(271,197,6,1),(272,198,6,1),(273,199,8,1),(274,200,8,1),(275,201,8,1),(276,223,8,1),(277,203,8,1),(278,204,8,1),(279,208,8,1),(280,209,8,1),(281,207,8,1),(282,210,8,1),(283,211,8,1),(284,212,8,1),(285,213,8,1),(286,237,8,1),(287,215,8,1),(288,216,8,1),(289,217,8,1),(290,218,8,1),(291,219,8,1),(292,220,8,1),(294,222,8,1),(295,224,8,1),(296,225,8,1),(297,179,2,2),(298,181,2,2),(299,183,2,2),(300,184,2,2),(301,185,2,2),(302,186,2,2),(303,187,4,2),(304,226,4,2),(305,227,4,2),(306,191,4,2),(307,228,4,2),(308,193,4,2),(309,229,4,2),(310,194,6,2),(311,230,6,2),(312,223,6,2),(313,231,6,2),(314,204,6,2),(315,232,6,2),(316,199,8,2),(317,217,8,2),(318,218,8,2),(319,203,8,2),(320,219,8,2),(321,234,8,2),(322,235,8,2),(323,220,8,2),(324,236,8,2),(325,210,8,2),(326,211,8,2),(327,224,8,2),(328,212,8,2),(329,214,8,2),(330,238,8,2),(331,222,8,2),(332,239,8,2),(333,225,8,2),(334,241,8,2),(339,248,8,1),(340,249,8,1),(341,250,8,1),(342,251,8,1),(343,260,8,1),(344,253,8,1),(349,261,8,1),(350,262,8,1),(351,263,8,1);
/*!40000 ALTER TABLE `semester_course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `university`
--

DROP TABLE IF EXISTS `university`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `university` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `university`
--

LOCK TABLES `university` WRITE;
/*!40000 ALTER TABLE `university` DISABLE KEYS */;
INSERT INTO `university` (`ID`, `name`) VALUES (1,'Πανεπιστήμιο Δυτικής Μακεδονίας');
/*!40000 ALTER TABLE `university` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `phone` int(10) NOT NULL,
  `email` varchar(25) NOT NULL,
  `ID_departament` int(10) NOT NULL,
  `user_type` varchar(25) NOT NULL,
  `sso_id` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_departament` (`ID_departament`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ID_departament`) REFERENCES `departament` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`ID`, `name`, `last_name`, `phone`, `email`, `ID_departament`, `user_type`, `sso_id`) VALUES (6,'Μαλαματή','Λούτα',123456789,'m@a.gr',1,'Καθηγητής',''),(7,'Μάρκος','Τσίπουρας',123456789,'m@t.gr',1,'Καθηγητής',''),(8,'Σταματία','Μπίμπη',123456789,'s@b.gr',1,'Καθηγητής',''),(9,'Κωνσταντίνος','Στεργίου',123456789,'k@s.gr',1,'Καθηγητής',''),(10,'Παναγιώτης','Σαρηγιαννίδης',123456789,'φσαφ@ασφ.γρ',1,'Καθηγητής',''),(12,'student','student',123456789,'student@s.gr',1,'Φοιτητης',''),(13,'Profesor','Profesor',123456789,'prof@p.gr',1,'Καθηγητής',''),(14,'gram','gram',123456789,'gram@g.gr',1,'Γραμματεια',''),(18,'Νικόλαος','Πουλάκης',123456789,'fsd@fsd.gr',1,'Καθηγητής',''),(19,'Νικόλαος','Πλόσκας',123456789,'geo_papakis@hotmail.com',1,'Καθηγητής',''),(20,'gram2','gram1',123456789,'gram1@g.gr',2,'Γραμματεια',''),(21,'Κων/νος','Φιλιππίδης',123456789,'φσδγ@σγδσ.γρ',2,'Καθηγητής',''),(22,'Κωνσταντίνος','Γαύρος',123456789,'ξγηφ@ηφδδ.η',1,'Καθηγητής',''),(23,'Σταυρούλα','Ταβουλτζίδου',123456789,'φσδσ@σγσ.σγσ',1,'Καθηγητής',''),(24,'Βασίλειος','Λαζαρίδης',123456789,'φγσδ@σδφγδφ.η',1,'Καθηγητής',''),(26,'Νικόλαος','Ασημόπουλος',1234567890,'δφ@γφφσ.γρ',1,'Καθηγητής',''),(27,'Δημήτριος','Τσιαμήτρος',123456789,'δγφγηφ@φγδ.γρ',1,'Καθηγητής',''),(28,'Γεώργιος','Φραγκούλης',123456789,'φδγδ@φδγ.γρ',1,'Καθηγητής',''),(29,'ΛΑΖΑΡΙΔΗΣ','ΛΑΖΑΡΙΔΗΣ',123456789,'γδρ@γδφ.γτ',1,'Καθηγητής',''),(30,'ΠΡΩΤΟΨΑΛΤΗΣ','ΠΡΩΤΟΨΑΛΤΗΣ',123456789,'γηδφ@δφγδφ.γεφγ',1,'Καθηγητής',''),(31,'ΜΠΟΥΛΓΕΩΡΓΟΣ','ΜΠΟΥΛΓΕΩΡΓΟΣ',123456789,'ψφηφν@γφδσ.γδφ',1,'Καθηγητής',''),(32,'ΠΕΡΑΚΗΣ','ΠΕΡΑΚΗΣ',123456789,'γξμ@δφγδ.γρ',1,'Καθηγητής',''),(33,'ΑΝΑΣΤΑΣΟΠΟΥΛΟΣ','ΑΝΑΣΤΑΣΟΠΟΥΛΟΣ',123456789,'φγη@σδγφ.γφδ',1,'Καθηγητής',''),(34,'ΠΙΤΙΛΑΚΗΣ','ΠΙΤΙΛΑΚΗΣ',123456789,'φδγφδ@σδφ.γφδ',1,'Καθηγητής',''),(35,'ΔΗΜΟΚΑΣ','ΔΗΜΟΚΑΣ',123456789,'ηγφ@σδφ.τγ',1,'Καθηγητής',''),(36,'ΠΑΡΙΣΗΣ','ΠΑΡΙΣΗΣ',123456789,'γφ@σγ.γσ',1,'Καθηγητής',''),(37,'ΑΜΑΝΑΤΙΑΔΗΣ','ΑΜΑΝΑΤΙΑΔΗΣ',123456789,'δφγ@σφσ.δσ',1,'Καθηγητής',''),(38,'ΒΑΡΔΑΚΑΣ','ΒΑΡΔΑΚΑΣ',123456789,'γ@σδ.σδφ',1,'Καθηγητής',''),(39,'ΤΣΙΑΜΗΤΡΟΣ','ΤΣΙΑΜΗΤΡΟΣ',123456789,'δφ@δσγ.γρ',1,'Καθηγητής',''),(42,'ΕΒΕΛΙΝΑ','ΔΟΚΙΜΑΣΤΙΚΗ',0,'ece00000@uowm.gr',1,'Φοιτητης ','ece00000'),(48,'ΜΠΑΚΟΥΡΟΣ','ΜΠΑΚΟΥΡΟΣ',123456789,'ηδφγ@γ.γργ',1,'Καθηγητής',''),(49,'ΚΩΝΣΤΑΝΤΑΣ','ΚΩΝΣΤΑΝΤΑΣ',123456789,'423@3245.γςερ',1,'Καθηγητής',''),(50,'ΤΑΣΙΑΣ','ΤΑΣΙΑΣ',123456789,'γτφδγ@σγ.σγ',1,'Καθηγητής',''),(51,'ΚΥΡΙΑΚΙΔΗΣ','ΚΥΡΙΑΚΙΔΗΣ',123456789,'γδφγ@ςετσ.ργ',1,'Καθηγητής',''),(52,'ΜΑΣΤΟΡΑΣ','ΜΑΣΤΟΡΑΣ',123456789,'γσδφγ@φσδ.γσ',1,'Καθηγητής',''),(53,'ΑΝΑΣΤΑΣΟΠΟΥΛΟΣ','ΑΝΑΣΤΑΣΟΠΟΥΛΟΣ',123456789,'γδφσ@σδγσ.γρ',1,'Καθηγητής',''),(55,'ΑΓΓΕΛΙΔΗΣ','ΑΓΓΕΛΙΔΗΣ',123456789,'γσγσ@σγσδ.σδφ',1,'Καθηγητής',''),(56,'ΣΚΟΔΡΑΣ','ΣΚΟΔΡΑΣ',123456789,'γδφγ@σδφ.γσδγ',2,'Καθηγητής',''),(57,'ΑΣΗΜΟΠΟΥΛΟΣ','ΑΣΗΜΟΠΟΥΛΟΣ',123456789,'ΞΒΗ@ΓΦΓΗ.ΓΡ',1,'Καθηγητής',''),(69,'ΓΕΩΡΓΙΟΣ ΠΑΝΑΓΙΩΤΗΣ','ΠΑΠΑΚΗΣ',0,'ece00614@uowm.gr',1,'Φοιτητης','ece00614'),(74,'Christos Papakis','Papakis',2104093076,'info@hemexpo.gr',2,'Φοιτητης',''),(76,'ytery','try',123456789,'yrty@gdf.gr',2,'Φοιτητης',''),(80,'Χατζησαββας','Χατζησαββας',123456789,'ηηηηδ@ηηηξξ,γρ',1,'Καθηγητής',''),(81,'ΚΟΝΤΗΣ','ΚΟΝΤΗΣ',123456789,'ΓΓΓΦΓΗ@ΚΚΚΛ.ΓΡ',1,'Καθηγητής',''),(82,'ΔΑΤΣΙΟΣ','ΔΑΤΣΙΟΣ',123456789,'ΦΔΔΓ@ΘΘΘ.ΓΡ',1,'Καθηγητής',''),(83,'ΖΥΓΚΙΡΙΔΗΣ','ΖΥΓΚΙΡΙΔΗΣ',123456789,'ννη@ηκκλι.γρ',2,'Καθηγητής',''),(84,'ΜΗΝΑΣ','ΔΑΣΥΓΕΝΗΣ',0,'mdasygenis@uowm.gr',1,'Καθηγητής','mdasygenis'),(88,'μπισμπας','μπισμπας',123456789,'δσγσδ@σδωσδ.γ',1,'Καθηγητής',''),(89,'fasfδφαδσασδ','asfσδφαασσδ',123457899,'afsafaaδασsf@afaf.gr',2,'Φοιτητης',''),(90,'ΚΑΖΑΗΣ','ΚΑΖΑΗΣ',123456789,'ΚΚΛΗ@ΚΚΓΦ.ΓΡ',1,'Καθηγητής',''),(91,'ΠΑΝΑΓΙΩΤΑ','ΚΑΡΑΓΙΑΝΝΗ',123456789,'ΔΓΦΓΗΗΓ@ΞΓΦΦ.ΓΡ',1,'Φοιτητης',''),(95,'gsfs','fsd',123456789,'smarovoutsa@yahoo.gr',1,'Καθηγητής','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'program'
--

--
-- Dumping routines for database 'program'
--
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-26 19:06:29
