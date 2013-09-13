/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50144
 Source Host           : localhost
 Source Database       : scrud_v2.0

 Target Server Type    : MySQL
 Target Server Version : 50144
 File Encoding         : utf-8

 Date: 04/17/2013 14:51:22 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `categories`
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `category_description` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `categories`
-- ----------------------------
BEGIN;
INSERT INTO `categories` VALUES ('1', 'General', 'Description here<br>', null, null, null, null), ('2', 'News', 'Description here<br>', null, null, null, null), ('3', 'Business', 'Description here<br>', null, null, null, null), ('4', 'Sport', 'Description here<br><br>', null, null, null, null), ('5', 'Entertainment', 'Description here<br>', null, null, null, null), ('6', 'Technology', 'Description here<br>', null, null, null, null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
