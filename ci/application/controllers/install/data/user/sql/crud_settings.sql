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

 Date: 05/02/2013 10:58:36 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `crud_settings`
-- ----------------------------
DROP TABLE IF EXISTS `crud_settings`;
CREATE TABLE `crud_settings` (
  `setting_key` varchar(255) NOT NULL DEFAULT '',
  `setting_value` longtext,
  PRIMARY KEY (`setting_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `crud_settings`
-- ----------------------------
BEGIN;
INSERT INTO `crud_settings` VALUES ('dfe2db74975e0aa9f6fdd4d61dedcb7328502456', 'a:17:{s:11:\"setting_key\";s:40:\"dfe2db74975e0aa9f6fdd4d61dedcb7328502456\";s:13:\"email_address\";s:14:\"admin@demo.com\";s:13:\"default_group\";s:1:\"3\";s:20:\"disable_registration\";s:1:\"0\";s:22:\"disable_reset_password\";s:1:\"0\";s:24:\"require_email_activation\";s:1:\"1\";s:16:\"default_language\";s:5:\"en_US\";s:16:\"enable_recaptcha\";s:1:\"1\";s:20:\"recaptcha_public_key\";s:40:\"6Le4CtUSAAAAAC-Cnbu_d6eshhyDyY_H1OB2cI11\";s:21:\"recaptcha_private_key\";s:40:\"6Le4CtUSAAAAAJOySWsjT1NAKtfdqJyCKomyzoKx\";s:11:\"enable_smtp\";s:1:\"0\";s:9:\"smtp_host\";s:0:\"\";s:9:\"smtp_port\";s:0:\"\";s:9:\"smtp_auth\";s:0:\"\";s:16:\"enable_smtp_auth\";s:1:\"0\";s:12:\"smtp_account\";s:0:\"\";s:13:\"smtp_password\";s:0:\"\";}'), ('f0347ce3a03a3ba71f596438a2b80dd21c9af71b', 'a:5:{s:11:\"setting_key\";s:40:\"f0347ce3a03a3ba71f596438a2b80dd21c9af71b\";s:17:\"send_link_subject\";s:32:\"[PHP Admin Pro] Activate Account\";s:14:\"send_link_body\";s:157:\"Welcome {user_name},\r\n\r\nYou must activate your account via this message to log in.\r\n\r\nClick the following link to do so: {activation_link}\r\n\r\nThanks.								\";s:17:\"activated_subject\";s:48:\"[PHP Admin Pro] You have activated your account!\";s:14:\"activated_body\";s:187:\"Hi there {user_name} !\r\n\r\nYour account at {site_address} has been successfully activated :).\r\n\r\nFor your reference, your user email is  {user_email}.\r\n\r\nSee you soon!																					\";}'), ('868a882a74b3f7f4cc49d8914e144ef07b3ea9d5', 'a:5:{s:11:\"setting_key\";s:40:\"868a882a74b3f7f4cc49d8914e144ef07b3ea9d5\";s:15:\"request_subject\";s:35:\"[PHP Admin Pro] Lost your password?\";s:12:\"request_body\";s:167:\"Hi {user_name},\r\n\r\nYour user email is {user_email}.\r\n\r\nTo reset your password at AuthAcl, please click the following password reset link: {reset_link}\r\n\r\nSee you soon!\";s:15:\"success_subject\";s:45:\"[PHP Admin Pro] Your password has been reset.\";s:12:\"success_body\";s:194:\"Welcome back {user_name},\r\n\r\nI\'m just letting you know your password at {site_address} has been successfully changed.\r\n\r\nHopefully you were the one that requested this password reset !\r\n\r\nCheers\";}');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
