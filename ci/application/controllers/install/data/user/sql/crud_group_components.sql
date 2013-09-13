/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50144
 Source Host           : localhost
 Source Database       : phpadminpro_v1.0

 Target Server Type    : MySQL
 Target Server Version : 50144
 File Encoding         : utf-8

 Date: 04/18/2013 12:45:20 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `crud_group_components`
-- ----------------------------
DROP TABLE IF EXISTS `crud_group_components`;
CREATE TABLE `crud_group_components` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `crud_group_components`
-- ----------------------------
BEGIN;
INSERT INTO `crud_group_components` VALUES ('3', 'Article Manager', '<p>Article Manager</p>\r\n');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
