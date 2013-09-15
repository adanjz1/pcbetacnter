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

 Date: 04/18/2013 14:34:56 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `crud_users`
-- ----------------------------
DROP TABLE IF EXISTS `crud_users`;
CREATE TABLE `crud_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(20) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_first_name` varchar(255) DEFAULT NULL,
  `user_las_name` varchar(255) DEFAULT NULL,
  `user_info` text,
  `user_code` varchar(255) DEFAULT NULL,
  `user_status` tinyint(4) DEFAULT '0',
  `user_manage_flag` tinyint(4) DEFAULT NULL,
  `user_setting_management` tinyint(4) DEFAULT NULL,
  `user_global_access` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `crud_users`
-- ----------------------------
BEGIN;
INSERT INTO `crud_users` VALUES ('1', '1', 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'admin@demo.com', 'Demo', 'Admin ', '', null, '1', '0', '0', '0'), ('2', '2', 'manager', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'manager@demo.com', 'Demo', 'Manager', '', null, '1', '0', '0', '0'), ('3', '3', 'user', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'user@demo.com', 'Demo', 'User', '', null, '1', null, null, null), ('4', '0', 'user2', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'user2@demo.com', 'Demo', 'User 2', '', null, '1', '0', '0', '0');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
