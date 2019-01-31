/*
Navicat MySQL Data Transfer

Source Server         : mine
Source Server Version : 50711
Source Host           : localhost:3306
Source Database       : posts_api

Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2019-01-31 12:01:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for access
-- ----------------------------
DROP TABLE IF EXISTS `access`;
CREATE TABLE `access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(256) NOT NULL,
  `password` varchar(2048) NOT NULL,
  `token` varchar(2048) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of access
-- ----------------------------
INSERT INTO `access` VALUES ('3', 'esteres', '$2y$10$J3G672zhNxoDAHZaWGTJYOnLMezsfBPltf2ag6FmzimRYo2wRSpKO', '');
INSERT INTO `access` VALUES ('4', 'erestrepo', '$2y$10$mamJRbmPHuAcs7JvcsiBjuEyrJiOtf/HGiECjuzCz7LiSioxzCWeu', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsImF1ZCI6Imh0dHA6XC9cL2V4YW1wbGUuY29tIiwiaWF0IjoxMzU2OTk5NTI0LCJuYmYiOjEzNTcwMDAwMDAsImRhdGEiOnsiaWQiOiI0IiwidXNlcm5hbWUiOiJlcmVzdHJlcG8iLCJwYXNzd29yZCI6IiQyeSQxMCRtYW1KUmJtUEh1QWNzN0p2Y3NpQmp1RXlySmlPdGZcL0hHaUVDanV6Q3o3TGlTaW94ekNXZXUifX0.kS3IKxNUoCwAn0uUzt1s9h2XWj82yl1W_KNVlgb77ek');

-- ----------------------------
-- Table structure for author
-- ----------------------------
DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `date_created` int(11) NOT NULL,
  `date_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of author
-- ----------------------------
INSERT INTO `author` VALUES ('1', 'Esteban', 'Restrepo', '1548920474', null);

-- ----------------------------
-- Table structure for post
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `author` varchar(256) NOT NULL,
  `content` text NOT NULL,
  `date_created` int(11) NOT NULL,
  `date_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of post
-- ----------------------------
INSERT INTO `post` VALUES ('1', 'Test', 'Test', 'Test', '1548952346', null);
