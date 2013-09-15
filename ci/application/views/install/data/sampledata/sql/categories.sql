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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `categories`
-- ----------------------------
BEGIN;
INSERT INTO `categories` VALUES ('1', 'General', 'Description here<br>'), ('2', 'News', 'Description here<br>'), ('3', 'Business', 'Description here<br>'), ('4', 'Sport', 'Description here<br><br>'), ('5', 'Entertainment', 'Description here<br>'), ('6', 'Technology', 'Description here<br>');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
