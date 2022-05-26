-- MariaDB dump 10.19  Distrib 10.7.3-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: database_dev
-- ------------------------------------------------------
-- Server version	10.7.3-MariaDB-1:10.7.3+maria~focal

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
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` char(39) NOT NULL,
  `text` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_fi_72d1d6` (`postId`),
  KEY `comment_fi_f4311f` (`userId`),
  CONSTRAINT `comment_fk_72d1d6` FOREIGN KEY (`postId`) REFERENCES `post` (`id`),
  CONSTRAINT `comment_fk_f4311f` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES
(1,'5226bfb5-9363-4800-b442-ef0f7a102576','hi im a comment','2022-05-26 17:50:48',2,3);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` char(39) NOT NULL,
  `title` varchar(140) NOT NULL,
  `text` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `threadId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_fi_f4311f` (`userId`),
  KEY `post_fi_74b402` (`threadId`),
  CONSTRAINT `post_fk_74b402` FOREIGN KEY (`threadId`) REFERENCES `thread` (`id`),
  CONSTRAINT `post_fk_f4311f` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES
(1,'9b4e264c-e379-4f5b-90d6-bd61a47127a5','i like music','1','2022-05-24 16:11:28',1,1),
(2,'644a27a2-1694-4ae8-bd48-e00662c1a69f','1','1','2022-05-26 17:42:55',7,3),
(3,'cf63aa6f-8ac4-4adf-b3da-153e00f9a771','1','1','2022-05-26 17:43:31',7,3);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propel_migration`
--

DROP TABLE IF EXISTS `propel_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propel_migration` (
  `version` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propel_migration`
--

LOCK TABLES `propel_migration` WRITE;
/*!40000 ALTER TABLE `propel_migration` DISABLE KEYS */;
INSERT INTO `propel_migration` VALUES
(1651083789);
/*!40000 ALTER TABLE `propel_migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thread`
--

DROP TABLE IF EXISTS `thread`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` char(39) NOT NULL,
  `name` varchar(140) NOT NULL,
  `createdAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thread`
--

LOCK TABLES `thread` WRITE;
/*!40000 ALTER TABLE `thread` DISABLE KEYS */;
INSERT INTO `thread` VALUES
(1,'9acb5774-2f48-4b2d-95d1-3271f1feb473','music','2022-05-24 16:04:20'),
(2,'194eb804-3c6b-4ff9-924b-5671fccf7c5b','art','2022-05-24 16:04:36'),
(3,'514ca57e-0475-4f36-99cb-5f42401c14ab','maths','2022-05-24 16:04:46'),
(4,'466d6ead-00e6-41aa-af0b-7c4435c84d1f','buildings','2022-05-24 16:05:03'),
(5,'305a54a8-c557-4740-b501-e5779bd5ae0d','test','2022-05-24 16:09:48'),
(6,'0a90c508-d0c7-42d5-8610-5263ac5b23c7','test1','2022-05-26 17:36:31'),
(7,'ed78b38d-b4d0-4719-95b7-4551b48b0fb2','tes1','2022-05-26 17:41:57');
/*!40000 ALTER TABLE `thread` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` char(39) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES
(1,'74dadf7f-3ec8-48bb-9bdf-044bb3ca5171','alex','$argon2i$v=19$m=65536,t=4,p=1$dHpPWnBwSjJNVndtUGI2ZA$7Peeg6vlchVXprJOvtn95LzAgc7bEe56EgaAqHSJr18'),
(2,'b387ab53-5079-4ac9-83ac-34d63a8288a1','user7','$argon2i$v=19$m=65536,t=4,p=1$WjliYUsxT0p4WGdzLjM4Zw$BxYi4p0Vt/IStBw8Q38w9KXQERubP1pQp24orO+KOww'),
(3,'ac1dbdf6-b38f-47c0-bb1a-534e9a6dc894','user8','$argon2i$v=19$m=65536,t=4,p=1$RmVpalJQRWVCcFVyTnN0dQ$jJKwxQibh9db95dGeDEI/D1P6Ej+FmG4wXXw17gyGeE');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vote` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vote_fi_72d1d6` (`postId`),
  KEY `vote_fi_f4311f` (`userId`),
  CONSTRAINT `vote_fk_72d1d6` FOREIGN KEY (`postId`) REFERENCES `post` (`id`),
  CONSTRAINT `vote_fk_f4311f` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote`
--

LOCK TABLES `vote` WRITE;
/*!40000 ALTER TABLE `vote` DISABLE KEYS */;
INSERT INTO `vote` VALUES
(1,1,1,1),
(2,-1,3,3),
(3,-1,2,3);
/*!40000 ALTER TABLE `vote` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-26 18:05:57
