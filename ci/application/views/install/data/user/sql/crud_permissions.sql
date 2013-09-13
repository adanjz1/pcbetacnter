SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `crud_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `crud_permissions`;
CREATE TABLE `crud_permissions` (
  `group_id` bigint(20) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `permission_type` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`group_id`,`table_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `crud_permissions`
-- ----------------------------
BEGIN;
INSERT INTO `crud_permissions` VALUES ('1', 'articles', '3'), ('1', 'categories', '3'), ('2', 'articles', '2'), ('2', 'categories', '2'), ('3', 'articles', '1'), ('3', 'categories', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
