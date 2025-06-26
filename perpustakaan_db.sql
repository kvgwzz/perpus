/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - perpustakaan_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`perpustakaan_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `perpustakaan_db`;

/*Table structure for table `book` */

DROP TABLE IF EXISTS `book`;

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_title` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `author` varchar(50) NOT NULL,
  `book_copies` int(11) NOT NULL,
  `publisher_name` varchar(100) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `copyright_year` int(11) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '1',
  PRIMARY KEY (`book_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `book` */

insert  into `book`(`book_id`,`book_title`,`category`,`author`,`book_copies`,`publisher_name`,`isbn`,`copyright_year`,`status`) values 
(1,'Database dan ERD','Teknologi','Fajar Agung',4,'Unpam Press','1232123432123',2021,'1'),
(2,'Matematika Diskrit','Pendidikan','Saptono',2,'Erlangga','1234243463455',2021,'0'),
(3,'Database Relational','Teknologi','Fajar Agung',4,'Unpam Press','1232123432123',2022,'1'),
(4,'Logika Matematika','Pendidikan','Saptono',2,'Erlangga','1234243463455',2021,'1'),
(5,'Database Fundamental','Teknologi','Fajar Agung',4,'Unpam Press','1232123456454',2024,'1'),
(6,'Database Intermediate','Teknologi','Fajar Agung',4,'Unpam Press','1232178978895',2021,'1'),
(7,'Database','Teknologi','Fajar Agung',4,'Unpam Press','1232123424244',2000,'0'),
(8,'Pengantar teknologi','Pendidikan','Saptono',2,'Erlangga','1234243789634',2011,'1'),
(9,'Data Mining','Teknologi','Fajar Agung',4,'Unpam Press','1232123434533',2011,'0');

/*Table structure for table `borrow` */

DROP TABLE IF EXISTS `borrow`;

CREATE TABLE `borrow` (
  `borrow_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `date_borrow` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  PRIMARY KEY (`borrow_id`) USING BTREE,
  KEY `fk123` (`member_id`) USING BTREE,
  CONSTRAINT `fk123` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `borrow` */

insert  into `borrow`(`borrow_id`,`member_id`,`date_borrow`,`due_date`,`status`) values 
(1,4,'2025-06-20','2025-06-27',1),
(2,5,'2025-06-20','2025-06-27',1),
(3,6,'2025-06-20','2025-06-27',1),
(4,6,'2025-06-20','2025-06-27',1),
(5,4,'2025-06-20','2025-06-27',0),
(6,7,'2025-06-26','2025-06-26',1);

/*Table structure for table `borrowdetails` */

DROP TABLE IF EXISTS `borrowdetails`;

CREATE TABLE `borrowdetails` (
  `borrow_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `borrow_id` int(11) NOT NULL,
  `borrow_status` int(11) DEFAULT 1,
  `date_return` date DEFAULT NULL,
  PRIMARY KEY (`borrow_details_id`) USING BTREE,
  KEY `book_id` (`book_id`) USING BTREE,
  KEY `borrow_id` (`borrow_id`) USING BTREE,
  CONSTRAINT `borrowdetails_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`),
  CONSTRAINT `borrowdetails_ibfk_2` FOREIGN KEY (`borrow_id`) REFERENCES `borrow` (`borrow_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `borrowdetails` */

insert  into `borrowdetails`(`borrow_details_id`,`book_id`,`borrow_id`,`borrow_status`,`date_return`) values 
(1,5,1,1,'2025-06-20'),
(2,6,1,1,'2025-06-20'),
(3,3,1,1,'2025-06-20'),
(4,7,2,1,'2025-06-20'),
(5,5,2,1,'2025-06-20'),
(6,3,2,1,'2025-06-20'),
(7,4,2,1,'2025-06-20'),
(8,8,2,1,'2025-06-20'),
(9,5,3,1,'2025-06-20'),
(10,6,3,1,'2025-06-20'),
(11,2,3,1,'2025-06-20'),
(12,1,4,1,'2025-06-20'),
(13,3,4,1,'2025-06-20'),
(14,9,5,0,NULL),
(15,7,5,0,NULL),
(16,2,6,1,NULL);

/*Table structure for table `member` */

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`member_id`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `member` */

insert  into `member`(`member_id`,`firstname`,`lastname`,`username`,`email`,`password`,`gender`,`address`,`contact`,`type`,`status`) values 
(4,'Fajar','A',NULL,'fajar@gmail.com',NULL,'L','depok','09821392','Guru',1),
(5,'Sarah','Azhari',NULL,'sarah@gmail.co',NULL,'P','depok','09821392','Siswa',1),
(6,'Valentino','Ronald',NULL,'Ronald@gmail.com',NULL,'L','Depok','09821392','Siswa',1),
(7,'tester','akun','tester','tester1@mail.com','$2y$10$mHHviyyui1X7Ti4pwOe8XOj3RMwMKjwad8WShEBJyRtxMWcO0t1Lq','L','jakarta','0800','siswa',1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`username`,`password`,`firstname`,`lastname`) values 
(1,'admin','$2y$10$LF.OSu192DukatY/Fm755ek2YZaoOiTn/b9E5iODMG4OAx5ZRSGoy','super','admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
