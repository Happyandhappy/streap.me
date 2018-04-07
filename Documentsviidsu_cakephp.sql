/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.13-MariaDB : Database - viidsu_cakephp
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`viidsu_cakephp` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `viidsu_cakephp`;

/*Table structure for table `actions` */

DROP TABLE IF EXISTS `actions`;

CREATE TABLE `actions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `link_id` int(10) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `platform` varchar(32) DEFAULT NULL,
  `type` varchar(32) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `click_count` int(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `links` */

DROP TABLE IF EXISTS `links`;

CREATE TABLE `links` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `slug` varchar(5) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `heading` varchar(32) DEFAULT NULL,
  `button_label` varchar(32) DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `completion_count` int(10) DEFAULT NULL,
  `view_count` int(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `statistics` */

DROP TABLE IF EXISTS `statistics`;

CREATE TABLE `statistics` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `foreign_table` varchar(64) DEFAULT NULL,
  `foreign_id` int(10) DEFAULT NULL,
  `operation` varchar(64) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `referrer` varchar(1024) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `user_totals` */

DROP TABLE IF EXISTS `user_totals`;

CREATE TABLE `user_totals` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `impression_count` int(10) DEFAULT NULL,
  `use_count` int(10) DEFAULT NULL,
  `completion_count` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(32) DEFAULT NULL,
  `recovery_code` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
