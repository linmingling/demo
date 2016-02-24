/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : workflow

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-11-30 18:24:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tc_organization
-- ----------------------------
DROP TABLE IF EXISTS `tc_organization`;
CREATE TABLE `tc_organization` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(255) DEFAULT NULL COMMENT '组织名称',
  `parent_id` int(11) unsigned DEFAULT '0' COMMENT '上级ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='机构表';

-- ----------------------------
-- Records of tc_organization
-- ----------------------------

-- ----------------------------
-- Table structure for tc_task
-- ----------------------------
DROP TABLE IF EXISTS `tc_task`;
CREATE TABLE `tc_task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `task_name` varchar(255) NOT NULL COMMENT '任务名称',
  `description` varchar(255) DEFAULT NULL COMMENT '任务详情',
  `target` text COMMENT '目标计划',
  `created_id` int(11) unsigned DEFAULT '0' COMMENT '创建者ID',
  `creat_time` int(11) NOT NULL COMMENT '创建时间',
  `start_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '设置开始时间',
  `end_time` int(11) NOT NULL COMMENT '设置结束时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务表';

-- ----------------------------
-- Records of tc_task
-- ----------------------------

-- ----------------------------
-- Table structure for tc_task_execute
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务执行者映射表';

-- ----------------------------
-- Records of tc_task_execute
-- ----------------------------

-- ----------------------------
-- Table structure for tc_user
-- ----------------------------
DROP TABLE IF EXISTS `tc_user`;
CREATE TABLE `tc_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(255) DEFAULT NULL COMMENT '用户名称',
  `phone` varchar(11) DEFAULT '1' COMMENT '手机号码',
  `email` varchar(255) DEFAULT '0' COMMENT '用户邮箱',
  `bush_statu` varchar(255) DEFAULT '空闲' COMMENT '忙碌状态',
  `org_id` int(11) unsigned DEFAULT '0' COMMENT '组织ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户基础表';

-- ----------------------------
-- Records of tc_user
-- ----------------------------

-- ----------------------------
-- Table structure for tc_user_admin
-- ----------------------------
DROP TABLE IF EXISTS `tc_user_admin`;
CREATE TABLE `tc_user_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `username` varchar(255) DEFAULT NULL COMMENT '账号',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `state` tinyint(1) unsigned DEFAULT '1' COMMENT '管理员状态:1:生效，0失效',
  `lost_count` int(3) DEFAULT '0' COMMENT '一天内登录失败次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台表';

-- ----------------------------
-- Records of tc_user_admin
-- ----------------------------
