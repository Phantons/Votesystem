SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `realms`
-- ----------------------------
DROP TABLE IF EXISTS `realms`;
CREATE TABLE `realms` (
  `id` int(5) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `chardb` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ----------------------------
-- Table structure for `rewards`
-- ----------------------------
DROP TABLE IF EXISTS `rewards`;
CREATE TABLE `rewards` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `itemid` int(8) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `cost` int(4) DEFAULT NULL,
  `color` int(1) DEFAULT NULL,
  `realm` int(5) NOT NULL,
  `headline` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `shoplog`
-- ----------------------------
DROP TABLE IF EXISTS `shoplog`;
CREATE TABLE `shoplog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(30) DEFAULT NULL,
  `character` varchar(30) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `itemid` int(10) DEFAULT NULL,
  `date` varchar(30) DEFAULT NULL,
  `time` varchar(30) DEFAULT NULL,
  `realm` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of shoplog
-- ----------------------------
DROP TABLE IF EXISTS `topsites`;
CREATE TABLE `topsites` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


-- ----------------------------
-- Table structure for `votelog`
-- ----------------------------
DROP TABLE IF EXISTS `votelog`;
CREATE TABLE `votelog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(40) NOT NULL,
  `site` int(2) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `date` varchar(30) NOT NULL,
  `time` varchar(30) NOT NULL,
  `next` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

