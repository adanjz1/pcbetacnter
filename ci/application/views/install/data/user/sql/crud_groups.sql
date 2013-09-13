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
  `group_full_controll` tinyint(4) DEFAULT NULL,
  `group_read` tinyint(4) DEFAULT NULL,
  `group_read_write` tinyint(4) DEFAULT NULL,
  `group_read_delete` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `crud_groups`
-- ----------------------------
BEGIN;
INSERT INTO `crud_groups` VALUES ('1', 'Administrators', null, '1', '1', '2', '2', '2'), ('2', 'Supper users', null, '0', '2', '2', '1', '1'), ('3', 'Users', null, '0', '2', '1', '2', '2');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
