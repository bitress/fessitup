-- MariaDB dump 10.17  Distrib 10.4.11-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: fessitup
-- ------------------------------------------------------
-- Server version	10.4.11-MariaDB

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (0,'Uncategorised'),(1,'Lovelife'),(2,'School'),(3,'Family'),(4,'Friends and Peers'),(5,'LGBT'),(6,'General');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `confessions`
--

DROP TABLE IF EXISTS `confessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `confessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(20) NOT NULL,
  `title` text NOT NULL,
  `category` int(11) NOT NULL,
  `message` text NOT NULL,
  `smile` int(11) NOT NULL DEFAULT 0,
  `user` varchar(20) NOT NULL,
  `type` enum('user','visitor') NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `confessions`
--

LOCK TABLES `confessions` WRITE;
/*!40000 ALTER TABLE `confessions` DISABLE KEYS */;
INSERT INTO `confessions` VALUES (1,'7f684518e','nfEsA/TWT52ld3JRYjy9AdaMmYqQf5N/I1Tl/ibSxGdhd9nFUYJxpFeauLyAZ9z7NlpBTzcyejJMTjRaQzNIY09RNDg0Zz09',6,'wF+t3rjq5Hm9MApD68w8TmgaZIwEO5BsCVkfiXuGUBhca2TVkyliECFa7t6Fi0TUZm4vdUNMRjlacXVWV05pd3FXZlRaQS93c1ZGUHREZWIybzRjZWh1aFJSMk10TUhXUjFDWUh3VUQvZ09qYW84bitDY25FcENQZWtYaUtuQzY5aHVGT3VTdHI2c1JFcmN5b3k1MHBVK0RlYjQxREN0UzgzZXJ2bHFuZWtQM1RVeC9Qdm1PWlk5cHN1ZjE5cWxWS2srVVN4Y01DTTVLVVB1SS9aUVBMS0dOTnNCdGx5bkI2em5LRUpWL0t1SnpZTm40SkxRSmhaQWFickhza0R0ay9RaFN0WXJjdkpCc1NndzFXSHhZMXJ2R2NSNVNOUjRrOWZIUFFOQUVIUmQ5dWdCN01SQ3Z5QUV6UUdpMk1FcSt2TVlsU2tvOWJobGFDdG1RZzBwR2NmZG9walIvWldLUFhJT2txUHg1SEUveWxjNis=',1,'1','user','2021-04-08 21:42:58'),(2,'1e50906','HRWEhRSRPCnUZAENPlosKlgwW8LS37thPIMqjBALLNuGUParbKStpDN5eQc4OB8iSVMydk9oUTNYY1ZCWDRhRHorL0JjZz09',5,'1N16o1aJFA7X5I0N1WXgTnAJjToZdc2iFY3lL5+TDRUujnsqEmFE14Zazp/G1/yMTDRFTUtoTGRaZEVkQnpwWnhoeEZ5QT09',0,'1','user','2021-04-11 13:04:24'),(3,'b3232840ce13','epFK89w82sk3vkwxHH6m8FRoidi9sK3dMiCDTcrY349OrhTBnUbzXo7++3obOXcWNnUvMkNRTEtQOHR3OGEzbGM0bkhuZz09',5,'Om7zLSszPVipzZ1fFCouDhI2y8hYxqp05tT7UGJkJXGqQZvZV9NCGQvS5eiPpUkINytmbFF0cStSNzE1Z2ZNMFJhOWV4UT09',0,'1','user','2021-04-11 13:04:36'),(4,'262400a4921d6b34','1pYyOa3tD4jMUDezzFswOmrPQGp5X1ZRrRtucsdUBqBbbL2lX6QlPrABbxMFHFCMNExGK1RCcDZEdnd0c2JLUWkyTFBVQT09',6,'9KBFgF8pINdf+jdmMMYRq60VsgWNNgttj8YmVRAQu5qaALAzu6x2ZfC2xzp9rkYXQXJzSWl4d09JWjhsZ3ZzQmxVY2pBZz09',1,'1','user','2021-04-13 21:35:20'),(5,'1094a1e1eb7fcb','m+jQoBqHV9HvuS70B1vUyKWQ9BYAQ9/paEmKAButAyeGf7FSmV3vbq6IQXtaveSOaGtta2VYZlRBVXhpVU11VGNZTXZRUT09',0,'/PJCWBLA8qEZ+Vn9jTuvrf8vAluAVRQXIosE5Oiar9eWR3Dq9skhG/9g5sBOiYu9WlNUc2tjN1NoRkhRUUJObUZ2ZVN4QT09',3,'1','user','2021-04-14 12:14:51'),(6,'d5f12da7177','1jMtyL5PRIUMQq7gSKI6iXlXu8oN3QCZaKIt8Wi8U+/Da2kUpTb62V+b6i26N/o/RVlkdnpJWUl0c2ZaMnVnSmdJRllQZz09',5,'BBzdVgGP5QLkxiIEB8OYt56si/FkcMqe5J/0nSwgxvHEZC0wtxM2zd0MiKrW2tlMNzZYd0Fsc2dOcDF2MUd6S3ZUUGt1UT09',4,'::1','visitor','2021-04-15 21:03:49'),(7,'b2110e8340b','yaNYP6JdAhzwEPEpX00KKHDZmt+rk9/k9z8JMBaY6Jp7QX+dnW3e5uG0sdM+akhbY3hIRGh6YklscWhiZnhMbzR4b0hyUmVYMWNyVmxETit4ekFvMG4zQ09kdz0=',0,'RZA/yE95NJ0VW1F3FXrIqCDJel/YUj5K7ioRx4KfjNWwomZSHNsnnpoLDGNvK002Q09QT2ZtakRRdklSODF6bG5VbUtWTnloRC8vZXJDc0M5cGpTai9mQnRDdz0=',2,'1','user','2021-04-15 21:10:53'),(8,'d9a203d2e5f21b136','xfoO/uPV1r3cGbuRmdLGDuRbZNCckVBCTOXKHCskC3K1oi0AS8/Hw8doMwFp2zkuK2UzcnU3WExLVVNpVldxYktKbmI1UT09',6,'c8qky+OjXQoyUG7//vuVtzVWLK7mx3rX7Ec75+LbHDEJ2ZvP/KUGT8veSOIuuTI0U1U2dStYQkJycy90SzlMdDJkcEJzZz09',1,'1','user','2021-04-19 21:27:57');
/*!40000 ALTER TABLE `confessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `login_attempts_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(20) NOT NULL,
  `attempt` int(11) DEFAULT 1,
  `date` date NOT NULL,
  PRIMARY KEY (`login_attempts_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
INSERT INTO `login_attempts` VALUES (1,'::1',1,'2021-04-05');
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (1,1,'upvote',3,'Someone smiled on your confession!','1','2021-03-31 10:26:01'),(2,1,'upvote',2,'Someone smiled on your confession!','1','2021-03-31 10:26:03'),(3,1,'upvote',1,'Someone smiled on your confession!','1','2021-03-31 10:26:04'),(4,0,'upvote',5,'Someone smiled on your confession!','0','2021-04-05 10:04:48'),(5,1,'upvote',4,'Someone smiled on your confession!','1','2021-04-13 09:35:42'),(6,0,'upvote',6,'Someone smiled on your confession!','0','2021-04-15 09:03:51'),(7,1,'smile',7,'Someone smiled on your confession!','1','2021-04-15 09:11:54'),(8,1,'smile',8,'Someone smiled on your confession!','1','2021-04-19 09:28:15');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_settings`
--

DROP TABLE IF EXISTS `notification_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_settings` (
  `notification_settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `smile_on_post` enum('0','1') NOT NULL DEFAULT '1',
  `comments_on_post` enum('0','1') NOT NULL DEFAULT '1',
  `replies_on_comments` enum('0','1') NOT NULL DEFAULT '1',
  `new_followers` enum('0','1') NOT NULL DEFAULT '1',
  `chat_messages` enum('0','1') NOT NULL DEFAULT '1',
  `chat_requests` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`notification_settings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_settings`
--

LOCK TABLES `notification_settings` WRITE;
/*!40000 ALTER TABLE `notification_settings` DISABLE KEYS */;
INSERT INTO `notification_settings` VALUES (1,1,'1','1','1','1','1','1'),(2,2,'1','1','1','1','1','1');
/*!40000 ALTER TABLE `notification_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `smile`
--

DROP TABLE IF EXISTS `smile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `smile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `confession_id` int(10) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `smile`
--

LOCK TABLES `smile` WRITE;
/*!40000 ALTER TABLE `smile` DISABLE KEYS */;
INSERT INTO `smile` VALUES (36,6,'::1','smile','::1'),(37,5,'::1','smile','::1'),(40,7,'::1','smile','::1'),(41,7,'1','smile','::1'),(42,5,'1','smile','::1'),(43,8,'::1','smile','::1');
/*!40000 ALTER TABLE `smile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_comments`
--

DROP TABLE IF EXISTS `user_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comment` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `confession_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_comments`
--

LOCK TABLES `user_comments` WRITE;
/*!40000 ALTER TABLE `user_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `is_premium` enum('0','1') NOT NULL DEFAULT '0',
  `token` varchar(120) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'CyanneInnit','cyannejustinvega@protonmail.com','$2y$10$Q.21VgpGDE9wbmNwDhiAfuDk8XUNo4wtWfEOOCmqTidorteTW6/6W','1','b8b959321178e0e4f9e557d208a86cbf','2020-04-10 15:05:52'),(2,'ItsCyanne','cyannejustinl.vega12@gmail.com','$2y$10$1wNCP2hTGrLZnep85XefNupCsXvNiLKcBd58Iy7q.rfKJOcuEhEym','0','1a7c529e2476f066af5b0c15614f0ef0','2021-04-12 14:24:59');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_details`
--

DROP TABLE IF EXISTS `users_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_details` (
  `users_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `profile_image` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `gender` varchar(10) NOT NULL,
  `birthdate` date NOT NULL,
  `bio` varchar(121) NOT NULL DEFAULT 'I am not lazy, to put bio.',
  PRIMARY KEY (`users_details_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_details`
--

LOCK TABLES `users_details` WRITE;
/*!40000 ALTER TABLE `users_details` DISABLE KEYS */;
INSERT INTO `users_details` VALUES (1,1,'Cyanne Justin','Vega','7385a1094b5d478.png','','2002-12-01','I am inevitable.'),(2,2,'Cyanne Justin','Vega','default.jpg','','2003-03-10','I am not lazy, to put bio.');
/*!40000 ALTER TABLE `users_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_level`
--

DROP TABLE IF EXISTS `users_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_level` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_level` varchar(50) NOT NULL,
  `user_xp` varchar(50) NOT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_level`
--

LOCK TABLES `users_level` WRITE;
/*!40000 ALTER TABLE `users_level` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_settings`
--

DROP TABLE IF EXISTS `users_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_settings` (
  `user_setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `confession_public` enum('0','1') NOT NULL DEFAULT '1',
  `searchable_confession` enum('0','1') NOT NULL DEFAULT '1',
  `confession_commentable` enum('0','1') NOT NULL DEFAULT '1',
  `visitable_profile` enum('0','1') NOT NULL DEFAULT '0',
  `searchable_profile` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_settings`
--

LOCK TABLES `users_settings` WRITE;
/*!40000 ALTER TABLE `users_settings` DISABLE KEYS */;
INSERT INTO `users_settings` VALUES (1,1,'1','1','1','1','0'),(2,2,'1','1','1','0','0');
/*!40000 ALTER TABLE `users_settings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-22 21:05:01
