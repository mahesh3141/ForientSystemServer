/*
SQLyog Community v12.4.3 (64 bit)
MySQL - 5.7.21-0ubuntu0.16.04.1 : Database - corephpadmin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`corephpadmin` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `corephpadmin`;

/*Table structure for table `admin_accounts` */

DROP TABLE IF EXISTS `admin_accounts`;

CREATE TABLE `admin_accounts` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `admin_type` varchar(10) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `admin_accounts` */

insert  into `admin_accounts`(`id`,`user_name`,`passwd`,`admin_type`,`fname`,`lname`) values 
(1,'chetan','3b8ebe34e784a3593693a37baaacb016','super','Chetan','Patil'),
(4,'anand','8bda8e915e629a9fd1bbca44f8099c81','admin','Anand','Shah'),
(6,'superadmin','17c4520f6cfd1ab53d8745e84681eb49','super','Nitin','Pandaye'),
(7,'admin','0192023a7bbd73250516f069df18b500','super','Mahesh','Nawale'),
(8,'sandesh','dee3ae5926b1768ea18228ee54281df3','super','Sandesh','Joshi');

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(25) NOT NULL,
  `l_name` varchar(25) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(15) NOT NULL,
  `state` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

/*Data for the table `customers` */

insert  into `customers`(`id`,`f_name`,`l_name`,`gender`,`address`,`city`,`state`,`phone`,`email`,`date_of_birth`,`created_at`,`updated_at`) values 
(12,'Chetan','Shenai','male','Priyadarshini','mumbai','Maharashtra','34343432','chetanshenai9@gmail.com','1995-06-05',NULL,NULL),
(18,'bhushan','Chhadva','male','Padmavati','mumbai','Maharashtra','34343432','bhusahan2@gmail.com','1991-06-18',NULL,NULL),
(19,'Jayant','atre','male','Priyadarshini A102, adwa2','wad','Maharashtra','34343432','bhusahan2@gmail.com','1998-05-18',NULL,NULL),
(21,'bhushan','sutar','male','Priyadarshini A102, adwa2','mumbai','Maharashtra','34343432','bhusahan2@gmail.com','2016-11-24',NULL,NULL),
(23,'Paolo',' Accorti','male','Priyadarshini A102, adwa2','mumbai','Maharashtra','34343432','bhusahan2@gmail.com','1992-02-04',NULL,NULL),
(24,'Roland',' Mendel','male','Priyadarshini A102, adwa2','mumbai','Maharashtra','34343432','bhusahan2@gmail.com','2016-11-30',NULL,NULL),
(25,'John','doe','male','City, view','','Maharashtra','8875207658','john@abc.com','2017-01-27',NULL,NULL),
(26,'Maria','Anders','female','New york city','','Maharashtra','8856705387','chetanshenai9@gmail.com','2017-01-28',NULL,NULL),
(27,'Ana',' Trujillo','female','Street view','','Maharashtra','9975658478','chetanshenai9@gmail.com','1992-07-16',NULL,NULL),
(28,'Thomas','Hardy','male','120 Hanover Sq','','Maharashtra','885115323','abc@abc.com','1985-06-24',NULL,NULL),
(29,'Christina','Berglund','female','Berguvsvägen 8','','Maharashtra','9985125366','chetanshenai9@gmail.com','1997-02-12',NULL,NULL),
(30,'Ann','Devon','male','35 King George','','Maharashtra','8865356988','abc@abc.com','1988-02-09',NULL,NULL),
(31,'Helen','Bennett','female','Garden House Crowther Way','','Maharashtra','75207654','chetanshenai9@gmail.com','1983-06-15',NULL,NULL),
(32,'Annette','Roulet','female','1 rue Alsace-Lorraine','',' ','3410005687','abc@abc.com','1992-01-13',NULL,NULL),
(33,'Yoshi','Tannamuri','male','1900 Oak St.','','Maharashtra','8855647899','chetanshenai9@gmail.com','1994-07-28',NULL,NULL),
(34,'Carlos','González','male','Barquisimeto','','Maharashtra','9966447554','abc@abc.com','1997-06-24',NULL,NULL),
(35,'Fran',' Wilson','male','Priyadarshini ','','Maharashtra','5844775565','fran@abc.com','1997-01-27',NULL,NULL),
(36,'Jean',' Fresnière','female','43 rue St. Laurent','','Maharashtra','9975586123','chetanshenai9@gmail.com','2002-01-28',NULL,NULL),
(37,'Jose','Pavarotti','male','187 Suffolk Ln.','','Maharashtra','875213654',' Pavarotti@gmail.com','1997-02-04',NULL,NULL),
(38,'Palle','Ibsen','female','Smagsløget 45','','Maharashtra','9975245588','Palle@gmail.com','1991-06-17',NULL,'2018-01-14 17:11:42'),
(39,'Paula','Parente','male','Rua do Mercado, 12','','Maharashtra','659984878','abc@gmail.com','1996-02-06',NULL,NULL),
(40,'Matti',' Karttunen','female','Keskuskatu 45','','Maharashtra','845555125','abc@abc.com','1984-06-19',NULL,NULL);

/*Table structure for table `tasklist` */

DROP TABLE IF EXISTS `tasklist`;

CREATE TABLE `tasklist` (
  `id` int(99) NOT NULL AUTO_INCREMENT,
  `cid` int(99) DEFAULT NULL,
  `eid` int(99) DEFAULT NULL,
  `taskId` varchar(50) NOT NULL,
  `taskInfo` varchar(250) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `status` enum('open','resolved','closed') NOT NULL DEFAULT 'open',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tasklist` */

insert  into `tasklist`(`id`,`cid`,`eid`,`taskId`,`taskInfo`,`createdAt`,`status`) values 
(1,33,7,'TSK-owwn','fgdfgdgdgdg','2018-03-01 17:05:23','open'),
(2,33,6,'TSK-o0s5','pc not working','2018-03-01 17:07:00','open'),
(3,26,7,'TSK-BxnK','fuck here and get payment','2018-03-01 17:46:59','open');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
