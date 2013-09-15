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

 Date: 04/18/2013 14:34:51 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `crud_user_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `crud_user_permissions`;
CREATE TABLE `crud_user_permissions` (
  `user_id` bigint(20) NOT NULL,
  `com_id` bigint(20) NOT NULL,
  `permission_type` tinyint(4) NOT NULL,
  PRIMARY KEY (`user_id`,`com_id`,`permission_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `crud_user_permissions`
-- ----------------------------
BEGIN;
INSERT INTO `crud_user_permissions` VALUES ('4', '3', '1'), ('4', '3', '2'), ('4', '3', '3'), ('4', '3', '4');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
