/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : workflow

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2015-12-06 20:43:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `auth_access`
-- ----------------------------
DROP TABLE IF EXISTS `auth_access`;
CREATE TABLE `auth_access` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(255) DEFAULT NULL COMMENT '权限，模块，控制器，操作',
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_access
-- ----------------------------

-- ----------------------------
-- Table structure for `auth_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `auth_permissions`;
CREATE TABLE `auth_permissions` (
  `perm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perm_name` varchar(50) NOT NULL,
  `access_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  PRIMARY KEY (`perm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_permissions
-- ----------------------------
INSERT INTO `auth_permissions` VALUES ('1', '{\"m\":\"user\",\"s\":\"add\"}', null, null, null);
INSERT INTO `auth_permissions` VALUES ('2', '{\"m\":\"user\",\"s\":\"edit\"}', null, null, null);
INSERT INTO `auth_permissions` VALUES ('3', '{\"m\":\"user\",\"s\":\"del\"}', null, null, null);
INSERT INTO `auth_permissions` VALUES ('4', '{\"m\":\"user\",\"s\":\"list\"}', null, null, null);

-- ----------------------------
-- Table structure for `auth_roles`
-- ----------------------------
DROP TABLE IF EXISTS `auth_roles`;
CREATE TABLE `auth_roles` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_roles
-- ----------------------------
INSERT INTO `auth_roles` VALUES ('1', '管理员');
INSERT INTO `auth_roles` VALUES ('2', '设计部管理');
INSERT INTO `auth_roles` VALUES ('3', '技术部管理员');
INSERT INTO `auth_roles` VALUES ('4', '设计部普通成员');
INSERT INTO `auth_roles` VALUES ('5', '技术部普通成员');

-- ----------------------------
-- Table structure for `auth_role_perm`
-- ----------------------------
DROP TABLE IF EXISTS `auth_role_perm`;
CREATE TABLE `auth_role_perm` (
  `role_id` int(10) unsigned NOT NULL,
  `perm_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_role_perm
-- ----------------------------
INSERT INTO `auth_role_perm` VALUES ('1', '1');
INSERT INTO `auth_role_perm` VALUES ('1', '2');
INSERT INTO `auth_role_perm` VALUES ('1', '3');
INSERT INTO `auth_role_perm` VALUES ('2', '1');

-- ----------------------------
-- Table structure for `auth_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `auth_user_role`;
CREATE TABLE `auth_user_role` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_user_role
-- ----------------------------
INSERT INTO `auth_user_role` VALUES ('1', '1');
INSERT INTO `auth_user_role` VALUES ('4', '5');
INSERT INTO `auth_user_role` VALUES ('2', '2');
INSERT INTO `auth_user_role` VALUES ('3', '4');

-- ----------------------------
-- Table structure for `tc_organization`
-- ----------------------------
DROP TABLE IF EXISTS `tc_organization`;
CREATE TABLE `tc_organization` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(255) DEFAULT NULL COMMENT '组织名称',
  `parent_id` int(11) unsigned DEFAULT '0' COMMENT '上级ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='机构表';

-- ----------------------------
-- Records of tc_organization
-- ----------------------------
INSERT INTO `tc_organization` VALUES ('1', '设计部', '0');
INSERT INTO `tc_organization` VALUES ('2', '技术部', '0');

-- ----------------------------
-- Table structure for `tc_task`
-- ----------------------------
DROP TABLE IF EXISTS `tc_task`;
CREATE TABLE `tc_task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `task_name` varchar(255) NOT NULL COMMENT '任务名称',
  `description` varchar(255) DEFAULT NULL COMMENT '任务详情',
  `target` text COMMENT '目标计划',
  `created_id` int(11) unsigned DEFAULT '0' COMMENT '创建者ID',
  `creat_time` bigint(14) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `start_time` bigint(14) NOT NULL DEFAULT '0' COMMENT '设置开始时间',
  `end_time` bigint(14) NOT NULL DEFAULT '0' COMMENT '设置结束时间',
  `modification_date` bigint(15) DEFAULT NULL COMMENT '最后修改时间',
  `statu` tinyint(1) DEFAULT '0' COMMENT '任务状态：结束，未结束，其他....',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='任务表';

-- ----------------------------
-- Records of tc_task
-- ----------------------------
INSERT INTO `tc_task` VALUES ('1', '任务1', '任务1说明222', '完成任务12222', '0', '1448902800', '1449417600', '1449935999', '1449331193', '1');
INSERT INTO `tc_task` VALUES ('2', '任务1', '完成这个项目', '独立完成整个项目', '0', '1449327841', '1449244800', '1450195200', null, null);
INSERT INTO `tc_task` VALUES ('3', '任务2', '完成这个项目2', '独立完成整个项目2', '0', '1449327940', '1449763200', '1449849599', null, null);
INSERT INTO `tc_task` VALUES ('4', '任务2', '完成这个项目2', '独立完成整个项目2', '0', '1449328075', '1449763200', '1449849599', null, null);

-- ----------------------------
-- Table structure for `tc_task_execute`
-- ----------------------------
DROP TABLE IF EXISTS `tc_task_execute`;
CREATE TABLE `tc_task_execute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `task_id` int(11) NOT NULL COMMENT '任务ID',
  `exec_id` int(11) DEFAULT '0' COMMENT '执行者ID',
  `task_statu` tinyint(1) DEFAULT '1' COMMENT '任务执行状态',
  `progress` varchar(255) DEFAULT NULL COMMENT '执行进度',
  `note` text COMMENT '注释',
  `created_id` int(11) unsigned DEFAULT '0' COMMENT '创建者ID或分发者ID',
  `add_time` bigint(14) DEFAULT '0' COMMENT '添加时间',
  `start_time` bigint(14) DEFAULT '0' COMMENT '开始时间',
  `end_time` bigint(14) DEFAULT '0' COMMENT '结束时间',
  `bush_statu` tinyint(1) DEFAULT NULL COMMENT '忙碌状态',
  `assign_target` varchar(255) DEFAULT NULL COMMENT '指派目标，指派人给任务时写的东西',
  `level` tinyint(1) DEFAULT '1' COMMENT '任务级别',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='任务执行者映射表';

-- ----------------------------
-- Records of tc_task_execute
-- ----------------------------
INSERT INTO `tc_task_execute` VALUES ('1', '1', '1', '1', '建表阶段', '正在建表，其他未完成', '1', '1449027360', '1449111600', '1449370800', '1', null, null);
INSERT INTO `tc_task_execute` VALUES ('2', '1', '3', '1', '出ps效果图', '设计中', '1', '1449027360', '1449111600', '1449370800', '2', null, null);
INSERT INTO `tc_task_execute` VALUES ('3', '1', '4', '2', '建模', '已出模型图', '1', '1449027360', '1449111600', '1449370800', '4', null, null);
INSERT INTO `tc_task_execute` VALUES ('4', '1', '2', '1', '静态页面设计', '设计中', '0', '1449027360', '1449111600', '1449370800', '3', null, null);
INSERT INTO `tc_task_execute` VALUES ('5', '2', '2', '1', null, null, '0', '1449375694', '1448812800', '1448985599', null, '上的发生大幅', '2');
INSERT INTO `tc_task_execute` VALUES ('6', '2', '4', '1', null, null, '0', '1449375694', '1448812800', '1448985599', null, '上的发生大幅', '2');
INSERT INTO `tc_task_execute` VALUES ('7', '2', '7', '1', null, null, '0', '1449375694', '1448812800', '1448985599', null, '上的发生大幅', '2');
INSERT INTO `tc_task_execute` VALUES ('8', '2', '5', '1', null, null, '0', '1449375694', '1448812800', '1448985599', null, '上的发生大幅', '2');
INSERT INTO `tc_task_execute` VALUES ('9', '2', '3', '1', null, null, '0', '1449375694', '1448812800', '1448985599', null, '上的发生大幅', '2');
INSERT INTO `tc_task_execute` VALUES ('10', '4', '1', '1', null, null, '0', '1449375826', '1449590400', '1449331199', null, 'BBBBB', '3');

-- ----------------------------
-- Table structure for `tc_task_process`
-- ----------------------------
DROP TABLE IF EXISTS `tc_task_process`;
CREATE TABLE `tc_task_process` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL COMMENT '工作内容',
  `add_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT '0' COMMENT '执行者id',
  `created_id` int(11) DEFAULT '0' COMMENT '创建者',
  `task_id` int(11) DEFAULT '0' COMMENT '任务ID',
  `exec_statu` tinyint(1) DEFAULT '0' COMMENT '执行状态',
  `exec_flag` varchar(255) DEFAULT NULL COMMENT '执行状态说明：文字说明',
  `task_exec_id` int(11) DEFAULT '0' COMMENT '任务执行表ID',
  `exec_id` int(11) DEFAULT '0' COMMENT '执行者ID 冗余字段',
  `progress` varchar(255) DEFAULT NULL COMMENT '执行进度 冗余字段',
  `start_time` bigint(14) DEFAULT NULL COMMENT '开始时间',
  `end_time` bigint(14) DEFAULT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tc_task_process
-- ----------------------------

-- ----------------------------
-- Table structure for `tc_task_statu`
-- ----------------------------
DROP TABLE IF EXISTS `tc_task_statu`;
CREATE TABLE `tc_task_statu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '任务完成状态名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tc_task_statu
-- ----------------------------
INSERT INTO `tc_task_statu` VALUES ('1', '已发布');
INSERT INTO `tc_task_statu` VALUES ('2', '执行中');
INSERT INTO `tc_task_statu` VALUES ('3', '已完成');
INSERT INTO `tc_task_statu` VALUES ('4', '废弃');
INSERT INTO `tc_task_statu` VALUES ('5', '变动');

-- ----------------------------
-- Table structure for `tc_user`
-- ----------------------------
DROP TABLE IF EXISTS `tc_user`;
CREATE TABLE `tc_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(255) DEFAULT NULL COMMENT '用户名称',
  `phone` varchar(11) DEFAULT '1' COMMENT '手机号码',
  `email` varchar(255) DEFAULT '0' COMMENT '用户邮箱',
  `bush_statu` varchar(255) DEFAULT '空闲' COMMENT '忙碌状态',
  `org_id` int(11) unsigned DEFAULT '0' COMMENT '组织ID',
  `user_type` tinyint(1) DEFAULT NULL COMMENT '用户类型',
  `role_id` int(11) DEFAULT NULL COMMENT '用户权限 ID',
  `user_id` int(11) DEFAULT NULL COMMENT '对应用户表id',
  `add_time` bigint(15) DEFAULT NULL COMMENT '添加时间戳',
  `modify_time` bigint(15) DEFAULT NULL COMMENT '修改时间戳',
  `statu` tinyint(1) DEFAULT '1' COMMENT '用户状态:1:正常:0 禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用户基础表';

-- ----------------------------
-- Records of tc_user
-- ----------------------------
INSERT INTO `tc_user` VALUES ('1', '张1', '15626234518', '1823566@qq.com', '空闲', '2', '1', null, null, '1449111600', '1449222550', '1');
INSERT INTO `tc_user` VALUES ('2', '刘', '11011011010', 'a@qq.com', '空闲', '1', '1', null, null, '1449111600', '1449111600', '1');
INSERT INTO `tc_user` VALUES ('3', '王', '15151351', 'b@qq.com', '空闲', '1', '2', null, null, '1449111600', '1449111600', '1');
INSERT INTO `tc_user` VALUES ('4', '电放费', '324234224', 'c@qq.com', '空闲', '2', '2', null, null, '1449111600', '1449111600', '1');
INSERT INTO `tc_user` VALUES ('5', 'dsfads', 'fsdfsd', 'fasdfdfdf', '空闲', '1', '2', null, null, '1449111600', '1449111600', '1');
INSERT INTO `tc_user` VALUES ('6', 'fghd', 'sdfgghgh', 'ghghgh', '空闲', '2', '2', null, null, '1449111600', '1449111600', '1');
INSERT INTO `tc_user` VALUES ('7', '测试1', '15626234518', '181651561@qq.com', '空闲', '1', '2', null, null, '1449111600', '1449111600', '1');
INSERT INTO `tc_user` VALUES ('8', '张1', '15626234518', '1823566@qq.com', '空闲', '1', null, null, null, '1449222354', null, '1');
INSERT INTO `tc_user` VALUES ('9', '45345345', '', '', '空闲', '0', null, null, null, '1449324390', null, '1');

-- ----------------------------
-- Table structure for `tc_user_admin`
-- ----------------------------
DROP TABLE IF EXISTS `tc_user_admin`;
CREATE TABLE `tc_user_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `username` varchar(255) DEFAULT NULL COMMENT '账号',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `state` tinyint(1) unsigned DEFAULT '1' COMMENT '管理员状态:1:生效，0失效',
  `lost_count` int(3) DEFAULT '0' COMMENT '一天内登录失败次数',
  `user_id` int(11) DEFAULT NULL COMMENT '对应用户表中的用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台表';

-- ----------------------------
-- Records of tc_user_admin
-- ----------------------------
INSERT INTO `tc_user_admin` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '1', '0', '1');
