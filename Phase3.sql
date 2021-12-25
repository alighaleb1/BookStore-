-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bookstore
-- ------------------------------------------------------
-- Server version	5.7.35

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
-- Table structure for table `AUTHOR`
--

DROP TABLE IF EXISTS `AUTHOR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `AUTHOR` (
  `AuthorID` int(5) NOT NULL,
  `firstname` varchar(40) DEFAULT NULL,
  `lastname` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`AuthorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AUTHOR`
--

LOCK TABLES `AUTHOR` WRITE;
/*!40000 ALTER TABLE `AUTHOR` DISABLE KEYS */;
INSERT INTO `AUTHOR` VALUES (1,'John','Steinbeck'),(2,'Lee','Harper'),(3,'J.R.R','Tolkien'),(4,'Stephen','King'),(5,'J.K','Rowling');
/*!40000 ALTER TABLE `AUTHOR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BOOKS`
--

DROP TABLE IF EXISTS `BOOKS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `BOOKS` (
  `ISBN` varchar(30) NOT NULL,
  `title` varchar(300) NOT NULL,
  `publisher` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `AuthorID` int(5) DEFAULT NULL,
  PRIMARY KEY (`ISBN`),
  KEY `AuthorID` (`AuthorID`),
  CONSTRAINT `BOOKS_ibfk_1` FOREIGN KEY (`AuthorID`) REFERENCES `AUTHOR` (`AuthorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BOOKS`
--

LOCK TABLES `BOOKS` WRITE;
/*!40000 ALTER TABLE `BOOKS` DISABLE KEYS */;
INSERT INTO `BOOKS` VALUES ('9780140177374','Harry Potter and the Chamber of Secrets','Bloomsburg Publishing','Fantasy',11.99,5),('9780140177398','Of Mice and Men','Penguin Publishing Group','Fiction',10.99,1),('9780142000663','Misery','Viking Press','Horror',14.99,4),('9780452284234','The Fellowship of the Ring','Allen and Unwin','Adventure',19.99,3),('9780679732242','To Kill a Mockingbird','J,P Lippincott & Co','Fiction',8.99,2);
/*!40000 ALTER TABLE `BOOKS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CUSTOMER`
--

DROP TABLE IF EXISTS `CUSTOMER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `CUSTOMER` (
  `username` varchar(20) NOT NULL,
  `pin` varchar(4) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `address` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `credit_card_no` varchar(16) NOT NULL,
  `credit_card_type` varchar(15) NOT NULL,
  `expiration_date` varchar(4) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CUSTOMER`
--

LOCK TABLES `CUSTOMER` WRITE;
/*!40000 ALTER TABLE `CUSTOMER` DISABLE KEYS */;
INSERT INTO `CUSTOMER` VALUES ('132tonyvic','7788','Tony','Vicci','992 Carson Ave','Brighton','Michigan','48116','4444888877770110','DISCOVER','1026'),('aghaleb1','1052','Ali','Ghaleb','1234 Maple St','Dearborn','Michigan','48168','3333444499992222','MASTER','1225'),('ericacart','1052','Erica','Carter','934 Jackson St','Dallas','Texas','09182','2222444488882222','MASTER','0925'),('HenkelJohn55','9191','John','Henkel','343 South Pine St','Howell','Michigan','48899','1111222233334444','MASTER','0824'),('lizout12','8523','Elizabeth','Warwick','8430 Ryder Blvd','Sacramento','California','97128','7777333366660000','DISCOVER','1123'),('mich23','9090','Michael','May','2345 Maple St','Dearborn','Michigan','48168','5555888844443333','VISA','0824');
/*!40000 ALTER TABLE `CUSTOMER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ORDERS`
--

DROP TABLE IF EXISTS `ORDERS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ORDERS` (
  `order_number` varchar(100) NOT NULL,
  `order_date` varchar(10) DEFAULT NULL,
  `order_time` varchar(8) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `ISBN` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`order_number`),
  KEY `ISBN` (`ISBN`),
  KEY `username` (`username`),
  CONSTRAINT `ORDERS_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `BOOKS` (`ISBN`),
  CONSTRAINT `ORDERS_ibfk_2` FOREIGN KEY (`username`) REFERENCES `CUSTOMER` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ORDERS`
--

LOCK TABLES `ORDERS` WRITE;
/*!40000 ALTER TABLE `ORDERS` DISABLE KEYS */;
INSERT INTO `ORDERS` VALUES ('089984320','2021-10-31','08-24-05','mich23','9780140177398'),('111584320','2020-11-03','08-24-05','aghaleb1','9780679732242'),('249984320','2019-07-19','08-24-05','ericacart','9780452284234'),('442484320','2020-03-21','08-24-05','132tonyvic','9780140177374'),('779984320','2021-11-10','08-24-05','lizout12','9780142000663');
/*!40000 ALTER TABLE `ORDERS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `REVIEWS`
--

DROP TABLE IF EXISTS `REVIEWS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `REVIEWS` (
  `ISBN` varchar(30) NOT NULL,
  `review` varchar(3000) DEFAULT NULL,
  PRIMARY KEY (`ISBN`),
  CONSTRAINT `REVIEWS_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `BOOKS` (`ISBN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `REVIEWS`
--

LOCK TABLES `REVIEWS` WRITE;
/*!40000 ALTER TABLE `REVIEWS` DISABLE KEYS */;
INSERT INTO `REVIEWS` VALUES ('9780140177374','Dont waste your time'),('9780140177398','Great Book!'),('9780142000663','Awful'),('9780452284234','Not that interesting'),('9780679732242','What an ending!');
/*!40000 ALTER TABLE `REVIEWS` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-12 15:51:30
