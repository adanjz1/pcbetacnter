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

 Date: 04/17/2013 14:51:14 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `crud_components`
-- ----------------------------
DROP TABLE IF EXISTS `crud_components`;
CREATE TABLE `crud_components` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(20) DEFAULT NULL,
  `component_name` varchar(255) DEFAULT NULL,
  `component_table` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `crud_components`
-- ----------------------------
BEGIN;
INSERT INTO `crud_components` VALUES ('1', '3', 'Categories', 'categories'), ('2', '3', 'Articles', 'articles'), ('3', '0', 'Countries', 'countries');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
