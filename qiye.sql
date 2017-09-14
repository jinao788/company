/*
Navicat MySQL Data Transfer

Source Server         : wamp64
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : qiye

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-09-13 19:52:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` char(32) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `login_count` int(4) DEFAULT NULL,
  `lastlogin_time` int(11) DEFAULT NULL,
  `lastlogout_time` int(11) DEFAULT NULL,
  `is_update` tinyint(4) DEFAULT '1',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1', '68', '1505225689', '1505225673', '1', '1505206030');
INSERT INTO `admin` VALUES ('2', 'admin888', 'e10adc3949ba59abbe56e057f20f883e', '1', null, null, null, '1', null);

-- ----------------------------
-- Table structure for banner
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES ('9', '20170908\\bcc7f711a2dddb7d4594e5a426ce82f0.png', '是', '是');
INSERT INTO `banner` VALUES ('4', '20170906\\9f41d669cfbc1592b911d6e79213ec1d.png', '2222', '2233');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(255) NOT NULL,
  `cate_order` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('64', '中国', '0', '0', null);
INSERT INTO `category` VALUES ('65', '韩国11', '55', '0', null);
INSERT INTO `category` VALUES ('83', '河南', '0', '64', null);
INSERT INTO `category` VALUES ('89', '郑州', '0', '83', '1505215831');
INSERT INTO `category` VALUES ('90', '管城', '0', '89', '1505215831');

-- ----------------------------
-- Table structure for system
-- ----------------------------
DROP TABLE IF EXISTS `system`;
CREATE TABLE `system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `is_close` tinyint(2) DEFAULT NULL COMMENT '//1是开启0是关闭',
  `is_update` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system
-- ----------------------------
INSERT INTO `system` VALUES ('1', 'php', 'php7,tp5,h5,css3', '企业站', '0', '1');
