DROP TABLE IF EXISTS `jlf_weixin_info`;
CREATE TABLE `jlf_weixin_info` (
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
  `surplus_num` int(5) NOT NULL COMMENT '剩余刮奖次数',
  `num` tinyint(11) NOT NULL COMMENT '总刮奖次数',
  `last_time` datetime NOT NULL COMMENT '最近一次刮奖时间'
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8;
