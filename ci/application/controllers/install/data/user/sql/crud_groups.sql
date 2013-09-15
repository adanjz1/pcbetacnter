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

 Date: 04/17/2013 14:51:07 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `crud_groups`
-- ----------------------------
DROP TABLE IF EXISTS `crud_groups`;
CREATE TABLE `crud_groups` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) DEFAULT NULL,
  `group_description` text,
  `group_manage_flag` tinyint(4) DEFAULT NULL,
  `group_setting_management` tinyint(4) DEFAULT NULL,
  `group_global_access` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `crud_groups`
-- ----------------------------
BEGIN;
INSERT INTO `crud_groups` VALUES ('1', 'Administrators', null, '3', '1', '1'), ('2', 'Manager', '', '0', '1', '0'), ('3', 'Users', null, '0', '0', '0');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
