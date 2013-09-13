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

 Date: 04/18/2013 11:32:40 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `crud_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `crud_permissions`;
CREATE TABLE `crud_permissions` (
  `group_id` bigint(20) NOT NULL,
  `com_id` bigint(20) NOT NULL,
  `permission_type` tinyint(4) NOT NULL,
  PRIMARY KEY (`group_id`,`com_id`,`permission_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `crud_permissions`
-- ----------------------------
BEGIN;
INSERT INTO `crud_permissions` VALUES ('1', '1', '1'), ('1', '1', '2'), ('1', '1', '3'), ('1', '1', '4'), ('1', '2', '1'), ('1', '2', '2'), ('1', '2', '3'), ('1', '2', '4'), ('1', '3', '1'), ('1', '3', '2'), ('1', '3', '3'), ('1', '3', '4'), ('2', '1', '1'), ('2', '1', '2'), ('2', '1', '3'), ('2', '1', '4'), ('2', '1', '5'), ('2', '2', '1'), ('2', '2', '2'), ('2', '2', '3'), ('2', '2', '4'), ('2', '2', '5'), ('2', '3', '1'), ('2', '3', '2'), ('2', '3', '3'), ('2', '3', '4'), ('2', '3', '5'), ('3', '1', '4'), ('3', '1', '5'), ('3', '2', '4'), ('3', '2', '5');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
