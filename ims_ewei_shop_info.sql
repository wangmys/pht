/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : s100

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-04-02 18:26:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ims_ewei_shop_info_adv
-- ----------------------------
DROP TABLE IF EXISTS `ims_ewei_shop_info_adv`;
CREATE TABLE `ims_ewei_shop_info_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_enabled` (`enabled`),
  KEY `idx_displayorder` (`displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_ewei_shop_info_adv
-- ----------------------------
INSERT INTO `ims_ewei_shop_info_adv` VALUES ('1', '4', '无敌是多么多么寂寞', './index.php?i=4&c=entry&m=ewei_shopv2&do=mobile&r=music.index', 'http://img2.y01.cn/images/4/2019/01/TsMZ3v55Z38m1pmcmN6anA6da66N6z.jpg', '505', '1');
INSERT INTO `ims_ewei_shop_info_adv` VALUES ('2', '4', '与你相遇的春天要来了,没有你的春天也要来了', './index.php?i=4&c=entry&m=ewei_shopv2&do=mobile&r=music.index', 'http://img2.y01.cn/images/4/2019/01/qgur1CFr02uk7Kc7ccMEA37K2e2uia.jpg', '6', '1');
INSERT INTO `ims_ewei_shop_info_adv` VALUES ('6', '4', '修护冰晶素材图片', '', 'http://img1.y01.cn/3350941c0a3c5491e8eeff0d0833e010.jpg', '0', '1');

-- ----------------------------
-- Table structure for ims_ewei_shop_info_custom
-- ----------------------------
DROP TABLE IF EXISTS `ims_ewei_shop_info_custom`;
CREATE TABLE `ims_ewei_shop_info_custom` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `key` varchar(20) NOT NULL COMMENT '键',
  `val` varchar(255) NOT NULL COMMENT '值',
  `type` varchar(20) NOT NULL COMMENT '类型',
  `text` varchar(255) NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_ewei_shop_info_custom
-- ----------------------------
INSERT INTO `ims_ewei_shop_info_custom` VALUES ('1', 'user', '555', 'text', '<input type=\'text\' name=\'user\' id=\'user\' value=\"555\">');

-- ----------------------------
-- Table structure for ims_ewei_shop_info_introduce
-- ----------------------------
DROP TABLE IF EXISTS `ims_ewei_shop_info_introduce`;
CREATE TABLE `ims_ewei_shop_info_introduce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_enabled` (`enabled`),
  KEY `idx_displayorder` (`displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_ewei_shop_info_introduce
-- ----------------------------
INSERT INTO `ims_ewei_shop_info_introduce` VALUES ('2', '4', '蕾西拉蒙', './index.php?i=4&c=entry&m=ewei_shopv2&do=mobile&r=train.index', 'http://img2.y01.cn/images/4/2019/04/htH6dh66xttXTLprptp6XmhtTXX8tL.png', '88', '1');
INSERT INTO `ims_ewei_shop_info_introduce` VALUES ('12', '4', '冬之回忆', './index.php?i=4&c=entry&m=ewei_shopv2&do=mobile&r=train.index', 'http://img2.y01.cn/images/4/2019/04/htH6dh66xttXTLprptp6XmhtTXX8tL.png', '44', '1');
INSERT INTO `ims_ewei_shop_info_introduce` VALUES ('13', '4', '音乐光碟', './index.php?i=4&c=entry&m=ewei_shopv2&do=mobile&r=train.index', 'http://img2.y01.cn/images/4/2019/04/htH6dh66xttXTLprptp6XmhtTXX8tL.png', '66', '1');

-- ----------------------------
-- Table structure for ims_ewei_shop_info_product
-- ----------------------------
DROP TABLE IF EXISTS `ims_ewei_shop_info_product`;
CREATE TABLE `ims_ewei_shop_info_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_enabled` (`enabled`),
  KEY `idx_displayorder` (`displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_ewei_shop_info_product
-- ----------------------------
INSERT INTO `ims_ewei_shop_info_product` VALUES ('1', '4', '我为歌狂', './index.php?i=4&c=entry&m=ewei_shopv2&do=mobile&r=train.index', 'http://img2.y01.cn/images/4/2019/04/htH6dh66xttXTLprptp6XmhtTXX8tL.png', '5', '1');
INSERT INTO `ims_ewei_shop_info_product` VALUES ('10', '4', 'title', '', 'http://img2.y01.cn/images/4/2019/04/htH6dh66xttXTLprptp6XmhtTXX8tL.png', '55', '1');
INSERT INTO `ims_ewei_shop_info_product` VALUES ('12', '4', '冬之回忆', './index.php?i=4&c=entry&m=ewei_shopv2&do=mobile&r=train.index', 'http://img2.y01.cn/images/4/2019/04/htH6dh66xttXTLprptp6XmhtTXX8tL.png', '10', '1');
INSERT INTO `ims_ewei_shop_info_product` VALUES ('13', '4', '音乐光碟', './index.php?i=4&c=entry&m=ewei_shopv2&do=mobile&r=train.index', 'http://img2.y01.cn/images/4/2019/04/htH6dh66xttXTLprptp6XmhtTXX8tL.png', '3', '0');

-- ----------------------------
-- Table structure for ims_ewei_shop_info_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_ewei_shop_info_user`;
CREATE TABLE `ims_ewei_shop_info_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `openid` varchar(50) NOT NULL COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '姓名',
  `sex` int(2) unsigned NOT NULL COMMENT '0 女 1 男  3 保密',
  `birthtime` int(11) unsigned DEFAULT '0' COMMENT '出生日期',
  `age` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `addr` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `goodname` varchar(255) DEFAULT '' COMMENT '购买的商品',
  `buytime` int(11) unsigned DEFAULT '0' COMMENT '购买时间',
  `buystore` varchar(50) NOT NULL DEFAULT '' COMMENT '购买门店',
  `sales` varchar(50) NOT NULL DEFAULT '' COMMENT '销售人员',
  `medical` text NOT NULL COMMENT '病史',
  `province` varchar(50) NOT NULL DEFAULT '' COMMENT '地区  省',
  `city` varchar(50) NOT NULL DEFAULT '' COMMENT '地区 市',
  `area` varchar(50) NOT NULL DEFAULT '' COMMENT '区 地域',
  `custom` text NOT NULL COMMENT '自定义信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_ewei_shop_info_user
-- ----------------------------
INSERT INTO `ims_ewei_shop_info_user` VALUES ('6', 'oPiMiw0OpF15LHc_RbdezyYdSBy4', '王梦园', '1', '1396281600', '18', '121313', '17775611493', '2123', '1554048000', '233', '6566', '115', '北京市', '北京市', '东城区', '');
INSERT INTO `ims_ewei_shop_info_user` VALUES ('11', 'oPiMiwyE_KbKDI-9OJ8NS9UR3xtM', '刘龙', '2', '946656000', '18', 'D016', '17775611493', '脑白金', '1554134400', '沈志典', '刘一凡', '无', '安徽省', '合肥市', '瑶海区', '');

-- ----------------------------
-- Table structure for ims_ewei_shop_info_video
-- ----------------------------
DROP TABLE IF EXISTS `ims_ewei_shop_info_video`;
CREATE TABLE `ims_ewei_shop_info_video` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `video_name` varchar(200) NOT NULL DEFAULT '' COMMENT '视频名称',
  `upload_time` int(11) NOT NULL DEFAULT '0' COMMENT '上传时间',
  `enabled` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示 0 隐藏 1显示',
  `video_url` varchar(255) NOT NULL DEFAULT '' COMMENT '视频地址',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '视频排序',
  `thumb` varchar(255) NOT NULL COMMENT '视频封面',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_enabled` (`enabled`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_ewei_shop_info_video
-- ----------------------------
INSERT INTO `ims_ewei_shop_info_video` VALUES ('1', '4', '献给爱丽丝', '1554175463', '1', 'videos/238/2019/01/te5Se5VdoHaW3VSstT0S7wHSS0s30S.mp4', '6', 'images/4/2019/04/htH6dh66xttXTLprptp6XmhtTXX8tL.png');
INSERT INTO `ims_ewei_shop_info_video` VALUES ('4', '4', '光年之外', '1554175448', '1', 'videos/4/2019/01/DdWd1xj9C2ZxDxcCC2JxdcCC94XL6W.mp4', '5', 'images/4/2019/04/htH6dh66xttXTLprptp6XmhtTXX8tL.png');
