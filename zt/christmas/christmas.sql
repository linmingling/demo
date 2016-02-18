/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : zhuanti

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2015-12-22 22:05:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `christmas`
-- ----------------------------
DROP TABLE IF EXISTS `christmas`;
CREATE TABLE `christmas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL COMMENT '姓名',
  `openid` varchar(50) NOT NULL COMMENT '用户openid',
  `nickname` varchar(30) NOT NULL COMMENT '微信名',
  `phone` varchar(11) DEFAULT NULL COMMENT '电话',
  `prize` tinyint(2) NOT NULL COMMENT '奖品编号',
  `quantity` int(10) DEFAULT NULL COMMENT '数量',
  `add_time` datetime DEFAULT NULL COMMENT '时间',
  `is_prize` int(11) NOT NULL DEFAULT '1',
  `share` int(11) DEFAULT '0' COMMENT '是否分享',
  `num` tinyint(11) NOT NULL COMMENT '总刮奖次数',
  `disting` tinyint(1) DEFAULT NULL COMMENT '次数',
  `per` tinyint(1) DEFAULT NULL COMMENT '期数',
  `last_time` datetime NOT NULL COMMENT '最近一次刮奖时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of christmas
-- ----------------------------
INSERT INTO `christmas` VALUES ('2', null, '76576', 'dsghgdad', null, '0', null, '2015-12-22 20:47:53', '1', '0', '0', '1', '1', '0000-00-00 00:00:00');
