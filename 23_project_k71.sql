CREATE DATABASE  IF NOT EXISTS `23_project_k71` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `23_project_k71`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: 23_project_k71
-- ------------------------------------------------------
-- Server version	8.0.35

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
-- Table structure for table `cauhoi`
--

DROP TABLE IF EXISTS `cauhoi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cauhoi` (
  `QuestionID` int NOT NULL AUTO_INCREMENT,
  `ThamGiaId` int NOT NULL,
  `QuestionType` tinyint NOT NULL,
  `QuestionStatus` tinyint(1) NOT NULL,
  `QuestionName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `QuestionImage` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`QuestionID`),
  KEY `ThamGiaId` (`ThamGiaId`),
  CONSTRAINT `cauhoi_ibfk_1` FOREIGN KEY (`ThamGiaId`) REFERENCES `thamgia` (`ThamGiaId`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cauhoi`
--

LOCK TABLES `cauhoi` WRITE;
/*!40000 ALTER TABLE `cauhoi` DISABLE KEYS */;
INSERT INTO `cauhoi` VALUES (2,1,1,1,'Chọn đáp án đúng?','Screenshot 2023-05-30 13252620231207121004.png'),(4,3,1,1,'Đánh giá độ phức tạp của thuật toán có thời gian chạy T(n, n) sau:','Screenshot 2023-12-07 18130120231207121457.png'),(9,1,1,1,'Chọn đáp án đúng','Screenshot 2023-11-18 17511520231208064557.png'),(12,1,2,1,'Chọn đáp án đúng','Screenshot 2023-12-08 16102420231208102148.png'),(21,1,2,1,'1+1 = ?',NULL),(23,3,3,1,'Các sự lựa chọn đúng?','Screenshot 2023-12-08 17505420231209152023.png'),(24,1,4,1,'Sắp xếp lại đáp án sau:\nA. 1 2 3\nB. 4 5 6\nC. 7 8 9\nD. 10 9 8',NULL),(27,1,5,1,'Nối các câu hoi',NULL),(34,1,6,1,'Cau noi noi',NULL),(44,20,1,0,'Kết quả của chương trình sau là gì?','Screenshot 2023-12-20 08313220231220023215.png'),(45,20,2,0,'Trình dịch php thuộc:',NULL),(46,19,3,0,'Chọn các cách comment trong php?',NULL),(47,19,4,0,'Sắp xếp lại cấu trúc hàm tính tổng chữ số của một số sau đây?',NULL),(48,19,5,0,'Chọn các mô tả đúng cho các hàm sau đây?',NULL),(49,18,6,1,'Chọn các hàm tương ứng cho các kiểu dữ  liệu sau đây?',NULL);
/*!40000 ALTER TABLE `cauhoi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dapan`
--

DROP TABLE IF EXISTS `dapan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dapan` (
  `AnswerId` int NOT NULL AUTO_INCREMENT,
  `QuestionID` int DEFAULT NULL,
  `AnswerContent` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `CorrectAnswer` tinyint(1) DEFAULT NULL,
  `stt` tinyint DEFAULT NULL,
  `ThuTuCot` tinyint DEFAULT NULL,
  PRIMARY KEY (`AnswerId`),
  KEY `QuestionID` (`QuestionID`),
  CONSTRAINT `dapan_ibfk_1` FOREIGN KEY (`QuestionID`) REFERENCES `cauhoi` (`QuestionID`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dapan`
--

LOCK TABLES `dapan` WRITE;
/*!40000 ALTER TABLE `dapan` DISABLE KEYS */;
INSERT INTO `dapan` VALUES (2,2,'1',1,NULL,NULL),(3,4,'n',1,NULL,NULL),(8,9,'6',1,NULL,NULL),(13,12,'A',1,NULL,NULL),(14,12,'B',0,NULL,NULL),(15,12,'C',0,NULL,NULL),(16,12,'D',0,NULL,NULL),(46,21,'4',0,NULL,NULL),(47,21,'5',0,NULL,NULL),(48,21,'2',1,NULL,NULL),(49,21,'1',0,NULL,NULL),(54,23,'A',0,NULL,NULL),(55,23,'B',1,NULL,NULL),(56,23,'C',0,NULL,NULL),(57,23,'D',1,NULL,NULL),(58,24,'A',1,1,NULL),(59,24,'C',1,2,NULL),(60,24,'B',1,3,NULL),(61,24,'D',1,4,NULL),(62,27,'A',1,1,1),(63,27,'D',1,1,2),(64,27,'B',1,2,1),(65,27,'E',1,2,2),(66,27,'C',1,3,1),(67,27,'F',1,3,2),(79,34,'2',1,0,1),(80,34,'6',1,1,1),(81,34,'7',1,2,1),(82,34,'4',1,0,2),(83,34,'8',1,1,2),(117,44,'do phuong',1,NULL,NULL),(118,45,'PHP Translator',0,NULL,NULL),(119,45,'PHP Interpreter',1,NULL,NULL),(120,45,'PHP Communicator',0,NULL,NULL),(121,45,'Không có đáp án đúng',0,NULL,NULL),(122,46,'// This is a single-line comment',1,NULL,NULL),(123,46,'# This is also a single-line comment',1,NULL,NULL),(124,46,'/* This is a multi-line comment */',1,NULL,NULL),(125,47,'function tongChuSo($n){',1,1,NULL),(126,47,'if($n < 10){',1,2,NULL),(127,47,'return $n;',1,3,NULL),(128,47,'}',1,4,NULL),(129,47,'else{',1,5,NULL),(130,47,'return tongChuSo((int)($n / 10)) + $n % 10;',1,6,NULL),(131,47,'}',1,7,NULL),(132,47,'}',1,8,NULL),(133,48,'str_word_count()',1,1,1),(134,48,'Đếm từ trong một chuỗi',1,1,2),(135,48,'(int)',1,2,1),(136,48,'Ép sang kiểu số nguyên',1,2,2),(137,48,'is_int()',1,3,1),(138,48,'Kiểm tra xem có phải là số nguyên hay không',1,3,2),(139,48,'var_dump()',1,4,1),(140,48,'Trả về kiểu dữ liệu của bất kỳ đối tượng nào',1,4,2),(141,48,'strtoupper()',1,5,1),(142,48,'Trả và chuỗi mới ở dạng chữ hoa',1,5,2),(143,49,'Strings',1,0,1),(144,49,'strtolower()',1,1,1),(145,49,'strtoupper()',1,2,1),(146,49,'substr()',1,3,1),(147,49,'explode()',1,4,1),(148,49,'Numbers',1,0,2),(149,49,'is_integer()',1,1,2),(150,49,'is_float()',1,2,2),(151,49,'is_numeric()',1,3,2);
/*!40000 ALTER TABLE `dapan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `khoahoc`
--

DROP TABLE IF EXISTS `khoahoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `khoahoc` (
  `CourseId` int NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `CourseDescription` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `CourseImage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`CourseId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `khoahoc`
--

LOCK TABLES `khoahoc` WRITE;
/*!40000 ALTER TABLE `khoahoc` DISABLE KEYS */;
INSERT INTO `khoahoc` VALUES (1,'Phân tích và thiết kế thuật toán',NULL,'khoahoc1.jpg'),(12,'Công nghệ web','','khoahoc20231220022518.jpg');
/*!40000 ALTER TABLE `khoahoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taikhoan`
--

DROP TABLE IF EXISTS `taikhoan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taikhoan` (
  `UserId` int NOT NULL AUTO_INCREMENT,
  `UserName` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `UserPass` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `UserRole` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taikhoan`
--

LOCK TABLES `taikhoan` WRITE;
/*!40000 ALTER TABLE `taikhoan` DISABLE KEYS */;
INSERT INTO `taikhoan` VALUES (1,'admin','c4ca4238a0b923820dcc509a6f75849b',1),(2,'tk1','c4ca4238a0b923820dcc509a6f75849b',0),(4,'tk2','c4ca4238a0b923820dcc509a6f75849b',0),(5,'admin3','c4ca4238a0b923820dcc509a6f75849b',0),(6,'tk3','c4ca4238a0b923820dcc509a6f75849b',0);
/*!40000 ALTER TABLE `taikhoan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thamgia`
--

DROP TABLE IF EXISTS `thamgia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thamgia` (
  `ThamGiaId` int NOT NULL AUTO_INCREMENT,
  `UserId` int NOT NULL,
  `CourseId` int NOT NULL,
  PRIMARY KEY (`ThamGiaId`),
  KEY `UserId` (`UserId`),
  KEY `CourseId` (`CourseId`),
  CONSTRAINT `thamgia_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `taikhoan` (`UserId`),
  CONSTRAINT `thamgia_ibfk_2` FOREIGN KEY (`CourseId`) REFERENCES `khoahoc` (`CourseId`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thamgia`
--

LOCK TABLES `thamgia` WRITE;
/*!40000 ALTER TABLE `thamgia` DISABLE KEYS */;
INSERT INTO `thamgia` VALUES (1,1,1),(3,2,1),(5,4,1),(18,1,12),(19,2,12),(20,4,12);
/*!40000 ALTER TABLE `thamgia` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-20  9:56:18
