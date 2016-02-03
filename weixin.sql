-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1:3306
-- 生成日期: 2015 年 10 月 12 日 13:35
-- 服务器版本: 5.1.28
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `weixin`
--

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_access_token_expires`
--

CREATE TABLE IF NOT EXISTS `pigcms_access_token_expires` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_token` varchar(700) NOT NULL,
  `expires_in` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `pigcms_access_token_expires`
--

INSERT INTO `pigcms_access_token_expires` (`id`, `access_token`, `expires_in`) VALUES
(1, '4YpN6XV0O1nZfDuEsEqumdl_6cj0AP_z3e1DJDqqY_5P2fa-q5Aar_baevS_dxwbGSjhCaiwZ64Q0zqaWHZw9Q9o7eEjwiC0j1m6NRAX4ig', 1440042387);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_admin`
--

CREATE TABLE IF NOT EXISTS `pigcms_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` char(20) NOT NULL,
  `pwd` char(32) NOT NULL,
  `realname` char(20) NOT NULL,
  `phone` char(20) NOT NULL,
  `email` char(20) NOT NULL,
  `qq` char(20) NOT NULL,
  `last_ip` bigint(20) NOT NULL,
  `last_time` int(11) NOT NULL,
  `login_count` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `pigcms_admin`
--

INSERT INTO `pigcms_admin` (`id`, `account`, `pwd`, `realname`, `phone`, `email`, `qq`, `last_ip`, `last_time`, `login_count`, `status`) VALUES
(1, 'admin', '40e84b91b26c5e06bb1cb5cb44ff4ec2', '', '', '', '', 2130706433, 1444652750, 87, 1);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_adver`
--

CREATE TABLE IF NOT EXISTS `pigcms_adver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `pic` varchar(50) NOT NULL,
  `bg_color` varchar(30) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`,`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- 导出表中的数据 `pigcms_adver`
--

INSERT INTO `pigcms_adver` (`id`, `name`, `url`, `pic`, `bg_color`, `cat_id`, `status`, `last_time`) VALUES
(1, '首页幻灯片1', 'http://localhost/pigcms10', 'adver/2015/08/55d961e004414.png', '#D32830', 1, 1, 1440492982),
(2, '广告1', 'http://localhost/pigcms10', 'adver/2015/06/5570fd45bcffc.png', '', 3, 1, 1440492910),
(3, '广告2', 'http://localhost/pigcms10', 'adver/2015/06/5570fcddac14a.jpg', '', 3, 1, 1440492916),
(6, '首页幻灯片2', 'http://localhost/pigcms10', 'adver/2015/08/55d9619a8223d.png', '#FE3875', 1, 1, 1440492977),
(7, '首页幻灯片3', 'http://localhost/pigcms10', 'adver/2015/08/55d9618d99073.png', '#6F41E1', 1, 1, 1440492970),
(8, '广告1', 'http://localhost/pigcms10', 'adver/2015/09/5607efc96acfc.jpg', '', 4, 1, 1443360713),
(9, '广告1', 'http://localhost/pigcms10', 'adver/2015/08/55d96663639f5.gif', '', 5, 1, 1440492882),
(10, '首页楼层广告内容-1', 'http://localhost/pigcms10', 'adver/2015/05/555ef241c80be.png', '', 6, 1, 1440492841),
(11, 'pc-首页楼层广告位-2', 'http://localhost/pigcms10', 'adver/2015/05/555ef2973d975.png', '', 6, 1, 1440492846),
(12, '今日推荐-广告1', 'http://localhost/pigcms10', 'adver/2015/05/555efe7caa45b.jpg', '', 7, 1, 1440492810),
(13, '首页幻灯片右侧广告-1', 'http://localhost/pigcms10', 'adver/2015/05/555f043ce121f.png', '', 8, 1, 1440492791),
(14, '首页幻灯片右侧广告-2', 'http://localhost/pigcms10', 'adver/2015/05/555f04512b6c3.png', '', 8, 1, 1440492798),
(15, '首页幻灯片4', 'http://localhost/pigcms10', 'adver/2015/08/55d961615bfe3.png', '#110E1F', 1, 1, 1440492965),
(16, '今日推荐-广告2', 'http://localhost/pigcms10', 'adver/2015/05/5563de912e533.jpg', '', 7, 1, 1440492817),
(17, '今日推荐-广告3', 'http://localhost/pigcms10', 'adver/2015/05/5563dee021d8f.jpg', '', 7, 1, 1440492822),
(18, '今日推荐-广告4', 'http://localhost/pigcms10', 'adver/2015/05/5563df3586e25.jpg', '', 7, 1, 1440492829),
(19, 'pc-首页楼层广告位-3', 'http://localhost/pigcms10', 'adver/2015/05/5563e04087e2d.png', '', 6, 1, 1440492851),
(20, 'pc-首页楼层广告位-4', 'http://localhost/pigcms10', 'adver/2015/05/5563e0abbfb71.png', '', 6, 1, 1440492863),
(22, 'pc-首页楼层广告位-6', 'http://localhost/pigcms10', 'adver/2015/05/5563e22f1cd5d.jpg', '', 6, 1, 1440492868),
(5, '你猜', 'http://localhost/pigcms10', 'adver/2015/07/55ae00bfd9329.jpg', '', 2, 1, 1440492933),
(25, '时尚女装', 'http://localhost/pigcms10', 'adver/2015/06/5571010f38388.jpg', '', 2, 1, 1440492928),
(4, '制服大牌', 'http://localhost/pigcms10', 'adver/2015/06/55710117a44e9.jpg', '', 2, 1, 1440492939),
(32, '我要送礼', 'http://localhost/pigcms10', 'adver/2015/08/55bc7ae7ce478.png', '', 13, 1, 1440492719),
(33, '降价拍', 'http://localhost/pigcms10', 'adver/2015/08/55bc7b05f170a.png', '', 13, 1, 1440492730),
(34, '一元夺宝', 'http://localhost/pigcms10', 'adver/2015/08/55bc7b205d36a.png', '', 13, 1, 1440492738),
(35, '众筹', 'http://localhost/pigcms10', 'adver/2015/08/55d96345e181e.png', '', 13, 1, 1440492745),
(36, '限时秒杀', 'http://localhost/pigcms10', 'adver/2015/08/55d9632072e19.png', '', 13, 1, 1440492751),
(37, '超级砍价', 'http://localhost/pigcms10', 'adver/2015/08/55d962e8508c8.png', '', 13, 1, 1440492758),
(38, '互动娱乐电商', 'http://localhost/pigcms10', 'adver/2015/08/55d9690322c5c.png', '', 1, 1, 1440492960),
(39, '最好广告', 'http://localhost/pigcms10', 'adver/2015/08/55d9696691661.png', '', 1, 1, 1440492954);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_adver_category`
--

CREATE TABLE IF NOT EXISTS `pigcms_adver_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` char(20) NOT NULL,
  `cat_key` char(20) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 导出表中的数据 `pigcms_adver_category`
--

INSERT INTO `pigcms_adver_category` (`cat_id`, `cat_name`, `cat_key`) VALUES
(1, 'pc-首页幻灯片', 'pc_index_slide'),
(2, 'wap-首页头部幻灯片(6)', 'wap_index_slide_top'),
(3, 'wap-首页热门品牌下方广告（2）', 'wap_index_brand'),
(4, 'pc-登陆页广告位', 'pc_login_pic'),
(5, 'pc-公用头部右侧广告位（1）', 'pc_index_top_right'),
(6, 'pc-首页楼层广告位（6）', 'pc_floor_inslide'),
(7, 'pc-首页今日推荐', 'pc_today'),
(8, '幻灯片-右侧广告', 'pc_index_slide_right'),
(9, 'pc-活动页头部幻灯片（6）', 'pc_activity_slider'),
(10, 'pc-活动页今日推荐（1）', 'pc_activity_rec'),
(11, 'pc-活动页热门活动（4）', 'pc_activity_hot'),
(12, 'pc-活动页附近活动（4）', 'pc_activity_nearby'),
(13, 'pc-首页活动广告', 'pc_index_activity');

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_attachment`
--

CREATE TABLE IF NOT EXISTS `pigcms_attachment` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `from` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为上传，1为导入，2为收藏',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为图片，1为语音，2为视频',
  `file` varchar(100) NOT NULL COMMENT '文件地址',
  `size` bigint(20) NOT NULL COMMENT '尺寸，byte字节',
  `width` int(11) NOT NULL COMMENT '图片宽度',
  `height` int(11) NOT NULL COMMENT '图片高度',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户IP地址',
  `agent` varchar(1024) NOT NULL COMMENT '用户浏览器信息',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='附件表' AUTO_INCREMENT=307 ;

--
-- 导出表中的数据 `pigcms_attachment`
--

INSERT INTO `pigcms_attachment` (`pigcms_id`, `store_id`, `name`, `from`, `type`, `file`, `size`, `width`, `height`, `add_time`, `status`, `ip`, `agent`) VALUES
(298, 27, '002.png', 0, 0, 'images/000/000/027/201508/55d4819fb0587.png', 155921, 399, 709, 1439990174, 1, 720577822, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36'),
(299, 29, 'sssd.JPG', 0, 0, 'images/000/000/029/201508/55d483b4030ad.JPG', 105357, 747, 422, 1439990706, 1, 454626635, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 UBrowser/5.3.3996.0 Safari/537.36'),
(300, 0, '5558576ae8553.gif', 0, 0, 'images/000/000/000/201508/55dabbd9ca2dd.gif', 8872, 580, 300, 1440398297, 1, 2130706433, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
(301, 35, '5563f2d6d26bf.gif', 0, 0, 'images/000/000/035/201508/55dabc0f29f63.gif', 8889, 580, 300, 1440398351, 1, 2130706433, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
(302, 35, '5558576ae8553.gif', 0, 0, 'images/000/000/035/201508/55dabccd29f63.gif', 8872, 580, 300, 1440398541, 1, 2130706433, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
(303, 35, 'wx.gif', 0, 0, 'images/000/000/035/201508/55dabcfd44aa2.gif', 2472, 276, 279, 1440398589, 1, 2130706433, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
(304, 35, 'wx.gif', 0, 0, 'images/000/000/035/201508/55dabd559c671.gif', 2472, 276, 279, 1440398677, 1, 2130706433, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
(305, 35, 'wx.gif', 0, 0, 'images/000/000/035/200108/3b85fb2da037a.gif', 2472, 276, 279, 998636333, 1, 2130706433, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
(306, 37, '3-141004093045.jpg', 0, 0, 'images/000/000/037/201509/560976652ccbb.jpg', 140489, 1600, 900, 1443460709, 1, 2130706433, 'Mozilla/5.0 (Windows NT 5.2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_attachment_user`
--

CREATE TABLE IF NOT EXISTS `pigcms_attachment_user` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` int(11) NOT NULL COMMENT 'UID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `from` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为上传，1为导入，2为收藏',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为图片，1为语音，2为视频',
  `file` varchar(100) NOT NULL COMMENT '文件地址',
  `size` bigint(20) NOT NULL COMMENT '尺寸，byte字节',
  `width` int(11) NOT NULL COMMENT '图片宽度',
  `height` int(11) NOT NULL COMMENT '图片高度',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户IP地址',
  `agent` varchar(1024) NOT NULL COMMENT '用户浏览器信息',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='会员附件表' AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `pigcms_attachment_user`
--

INSERT INTO `pigcms_attachment_user` (`pigcms_id`, `uid`, `name`, `from`, `type`, `file`, `size`, `width`, `height`, `add_time`, `status`, `ip`, `agent`) VALUES
(1, 74, '5558576ae8553.gif', 0, 0, 'images/000/000/074/201508/55daba281312d.gif', 8872, 580, 300, 1440397862, 1, 2130706433, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
(2, 76, 'wx.gif', 0, 0, 'images/000/000/076/201508/55dac3d807a12.gif', 2472, 276, 279, 1440400343, 1, 2130706433, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_bank`
--

CREATE TABLE IF NOT EXISTS `pigcms_bank` (
  `bank_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0启用 1禁用',
  PRIMARY KEY (`bank_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='银行' AUTO_INCREMENT=6 ;

--
-- 导出表中的数据 `pigcms_bank`
--

INSERT INTO `pigcms_bank` (`bank_id`, `name`, `status`) VALUES
(1, '中国工商银行', 1),
(2, '中国农业银行', 1),
(3, '中国银行', 1),
(4, '中国建设银行', 1),
(5, '交通银行', 1);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_business_hour`
--

CREATE TABLE IF NOT EXISTS `pigcms_business_hour` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `business_time` varchar(100) DEFAULT '' COMMENT '营业时间',
  `is_open` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_business_hour`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_comment`
--

CREATE TABLE IF NOT EXISTS `pigcms_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单表ID,对产品评论时，要加订单ID，其它为0',
  `relation_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联评论ID，例：产品ID，店铺ID等',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '满意度，1-5，数值越大，满意度越高',
  `logistics_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '物流满意度，1-5，数值越大，满意度越高',
  `description_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '描述相符，1-5，数值越大，满意度越高',
  `speed_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '发货速度，1-5，数值越大，满意度越高',
  `service_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '服务态度，1-5，数值越大，满意度越高',
  `type` enum('PRODUCT','STORE') NOT NULL DEFAULT 'PRODUCT' COMMENT '评论的类型，PRODUCT:对产品评论，STORE:对店铺评论',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',
  `has_image` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有图片，1为有，0为没有',
  `content` text NOT NULL COMMENT '评论内容',
  `reply_number` int(11) NOT NULL DEFAULT '0' COMMENT '回复数',
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',
  UNIQUE KEY `id` (`id`),
  KEY `relation_id` (`relation_id`) USING BTREE,
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_comment`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_comment_tag`
--

CREATE TABLE IF NOT EXISTS `pigcms_comment_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '评论表ID',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '系统标签表ID',
  `relation_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联评论ID，例：产品ID，店铺ID等',
  `type` enum('PRODUCT','STORE') NOT NULL DEFAULT 'PRODUCT' COMMENT '评论的类型，PRODUCT:对产品评论，STORE:对店铺评论',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',
  UNIQUE KEY `id` (`id`),
  KEY `cid` (`cid`) USING BTREE,
  KEY `tag_id` (`tag_id`,`relation_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_comment_tag`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_company`
--

CREATE TABLE IF NOT EXISTS `pigcms_company` (
  `company_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '公司id',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名',
  `province` varchar(30) NOT NULL DEFAULT '' COMMENT '省',
  `city` varchar(30) NOT NULL DEFAULT '' COMMENT '市',
  `area` varchar(30) NOT NULL DEFAULT '' COMMENT '区',
  `address` varchar(500) NOT NULL DEFAULT '' COMMENT '地址',
  PRIMARY KEY (`company_id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- 导出表中的数据 `pigcms_company`
--

INSERT INTO `pigcms_company` (`company_id`, `uid`, `name`, `province`, `city`, `area`, `address`) VALUES
(19, 60, 'sasas', '110000', '110200', '110228', 'sasa'),
(20, 63, 'sdv fdsv', '130000', '130200', '130203', 'asdv'),
(21, 64, '微店', '360000', '360600', '360602', '人民路1号'),
(22, 65, '1231', '120000', '120100', '120102', '123123'),
(23, 71, '按时发到手', '120000', '120100', '120102', '阿斯顿发的沙发地方'),
(24, 69, '微伊电子商务有限公司', '220000', '220300', '220303', '二商店西行99米'),
(25, 62, '阿萨飒飒', '130000', '130300', '130302', '阿萨飒飒'),
(26, 72, '测试', '510000', '510700', '510726', '勇敢'),
(27, 75, '狗扑源码测试店铺', '130000', '130400', '130403', '狗扑源码测试店铺'),
(28, 76, '测试测试测是', '330000', '330300', '330304', '测试测试测是'),
(29, 79, '狗扑源码', '110000', '110100', '110101', '狗扑源码');

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_config`
--

CREATE TABLE IF NOT EXISTS `pigcms_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(150) NOT NULL COMMENT '多个默认值用|分隔',
  `value` text NOT NULL,
  `info` varchar(20) NOT NULL,
  `desc` varchar(250) NOT NULL,
  `tab_id` varchar(20) NOT NULL DEFAULT '0' COMMENT '小分组ID',
  `tab_name` varchar(20) NOT NULL COMMENT '小分组名称',
  `gid` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `gid` (`gid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='配置表' AUTO_INCREMENT=101 ;

--
-- 导出表中的数据 `pigcms_config`
--

INSERT INTO `pigcms_config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES
(1, 'site_name', 'type=text&validate=required:true', '吾爱源码社区微店系统', '网站名称', '网站的名称', '0', '', 1, 0, 1),
(2, 'site_url', 'type=text&validate=required:true,url:true', 'http://d.52codes.net', '网站网址', '请填写网站的网址，包含（http://域名）', '0', '', 1, 0, 1),
(3, 'site_logo', 'type=image&validate=required:true,url:true', 'http://d.52codes.net/static/image/common/logo.png', '网站LOGO', '请填写LOGO的网址，包含（http://域名）', '0', '', 1, 0, 1),
(4, 'site_qq', 'type=text&validate=qq:true', '75943938', '联系QQ', '前台涉及到需要显示QQ的地方，将显示此值！', '0', '', 1, 0, 1),
(5, 'site_email', 'type=text&validate=email:true', '75943938@qq.com', '联系邮箱', '前台涉及到需要显示邮箱的地方，将显示此值！', '0', '', 1, 0, 1),
(6, 'site_icp', 'type=text', '', 'ICP备案号', '可不填写。放置于大陆的服务器，需要网站备案。', '0', '', 1, 0, 1),
(7, 'seo_title', 'type=text&size=80&validate=required:true', '吾爱源码社区微店系统_提供小猪独立微店商源码及小猪O2O V1.3破解版源码', 'SEO标题', '一般不超过80个字符！', '0', '', 1, 0, 1),
(8, 'seo_keywords', 'type=text&size=80', '吾爱源码社区微店系统_提供小猪独立微店商源码及小猪O2O V1.3破解版源码', 'SEO关键词', '一般不超过100个字符！', '0', '', 1, 0, 1),
(9, 'seo_description', 'type=textarea&rows=4&cols=93', '吾爱源码社区微店系统_提供小猪独立微店商源码及小猪O2O V1.3破解版源码', 'SEO描述', '一般不超过200个字符！', '0', '', 1, 0, 1),
(10, 'site_footer', 'type=textarea&rows=6&cols=93', 'Copyright 2015 (c)吾爱源码微店系统版权所有', '网站底部信息', '可填写统计、客服等HTML代码，代码前台隐藏不可见！！', '0', '', 1, 0, 1),
(11, 'register_check_phone', 'type=radio&value=1:验证|0:不验证', '0', '验证手机', '注册时是否发送短信验证手机号码！请确保短信配置成功。', '0', '', 1, 0, 0),
(12, 'register_phone_again_time', 'type=text&size=10&validate=required:true', '60', '注册短信间隔时间', '注册再次发送短信的间隔时间', '0', '', 0, 0, 0),
(13, 'theme_user_group', '', 'default', '', '', '0', '', 0, 0, 0),
(14, 'trade_pay_cancel_time', 'type=text&size=10&validate=required:true', '30', '默认自动取消订单时间', '默认自动取消订单时间，填0表示关闭该功能', '0', '', 0, 0, 0),
(15, 'trade_pay_alert_time', 'type=text&size=10&validate=required:true', '20', '默认自动催付订单时间', '默认自动催付订单时间，填0表示关闭该功能', '0', '', 0, 0, 0),
(16, 'trade_sucess_notice', 'type=radio&value=1:通知|0:不通知', '1', '支付成功是否通知用户', '支付成功是否通知用户', '0', '', 0, 0, 0),
(17, 'trade_send_notice', 'type=radio&value=1:通知|0:不通知', '1', '发货是否通知用户', '发货是否通知用户', '0', '', 0, 0, 0),
(18, 'trade_complain_notice', 'type=radio&value=1:通知|0:不通知', '1', '维权通知是否通知用户', '维权通知是否通知用户', '0', '', 0, 0, 0),
(19, 'ucenter_page_title', 'type=text&size=80&validate=required:true,maxlength:50', '会员主页', '默认页面名称', '如果店铺没有填写页面名称，默认值', '0', '会员主页', 0, 0, 0),
(20, 'ucenter_bg_pic', 'type=text&size=80&validate=required:true', 'default_ucenter.jpg', '默认背景图', '如果店铺没有上传背景图，默认值', '0', '会员主页', 0, 0, 0),
(21, 'ucenter_show_level', 'type=radio&value=1:显示|0:不显示', '1', '默认是否显示等级', '店铺在没有修改之前，默认是否显示等级', '0', '会员主页', 0, 0, 0),
(22, 'ucenter_show_point', 'type=radio&value=1:显示|0:不显示', '1', '默认是否显示积分', '店铺在没有修改之前，默认是否显示积分', '0', '会员主页', 0, 0, 0),
(23, 'wap_site_url', 'type=text&size=80&validate=required:true', 'http://ftp192029.host507.zhujiwu.cn/wap', '手机版网站网址', '手机版网站网址，可使用二级域名', '0', '', 1, 0, 1),
(24, 'theme_wap_group', 'type=select&value=default:默认|theme1:其他', 'default', '平台商城模板', '选择非“默认模板”选项后“平台商城首页内容”设置将无法生效', '0', '', 11, 0, 0),
(25, 'wx_token', 'type=text', '', '公众号消息校验Token', '公众号消息校验Token', '0', '', 13, 0, 1),
(26, 'wx_appsecret', 'type=text', '', '网页授权AppSecret', '网页授权AppSecret', '0', '', 13, 0, 1),
(27, 'wx_appid', 'type=text', '', '网页授权AppID', '网页授权AppID', '0', '', 13, 0, 1),
(28, 'wx_componentverifyticket', 'type=text', 'ticket@@@1pcH5efAO-gjfuZc9ShPFxSIevu3X1bP2dXIz4-7X3BscyRtTVwFg291Oex65T3cHmXFNGejd8-xuhFuR3ltwA', '', '', '0', '', 0, 0, 1),
(29, 'orderid_prefix', 'type=text&size=20', 'PIG', '订单号前缀', '用户看到的订单号 = 订单号前缀+订单号', '0', '', 1, 0, 1),
(30, 'pay_alipay_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'alipay', '支付宝', 7, 0, 1),
(31, 'pay_alipay_name', 'type=text&size=80', '', '帐号', '', 'alipay', '支付宝', 7, 0, 1),
(32, 'pay_alipay_pid', 'type=text&size=80', '', 'PID', '', 'alipay', '支付宝', 7, 0, 1),
(33, 'pay_alipay_key', 'type=text&size=80', '', 'KEY', '', 'alipay', '支付宝', 7, 0, 1),
(34, 'pay_tenpay_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'tenpay', '财付通', 7, 0, 1),
(35, 'pay_tenpay_partnerid', 'type=text&size=80', '', '商户号', '', 'tenpay', '财付通', 7, 0, 1),
(36, 'pay_tenpay_partnerkey', 'type=text&size=80', '', '密钥', '', 'tenpay', '财付通', 7, 0, 1),
(37, 'pay_yeepay_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'yeepay', '银行卡支付（易宝）', 7, 0, 1),
(38, 'pay_yeepay_merchantaccount', 'type=text&size=80', 'YB01000000144', '商户编号', '', 'yeepay', '银行卡支付（易宝）', 7, 0, 1),
(39, 'pay_yeepay_merchantprivatekey', 'type=text&size=80', 'MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBAPGE6DHyrUUAgqep/oGqMIsrJddJNFI1J/BL01zoTZ9+YiluJ7I3uYHtepApj+Jyc4Hfi+08CMSZBTHi5zWHlHQCl0WbdEkSxaiRX9t4aMS13WLYShKBjAZJdoLfYTGlyaw+tm7WG/MR+VWakkPX0pxfG+duZAQeIDoBLVfL++ihAgMBAAECgYAw2urBV862+5BybA/AmPWy4SqJbxR3YKtQj3YVACTbk4w1x0OeaGlNIAW/7bheXTqCVf8PISrA4hdL7RNKH7/mhxoX3sDuCO5nsI4Dj5xF24CymFaSRmvbiKU0Ylso2xAWDZqEs4Le/eDZKSy4LfXA17mxHpMBkzQffDMtiAGBpQJBAPn3mcAwZwzS4wjXldJ+Zoa5pwu1ZRH9fGNYkvhMTp9I9cf3wqJUN+fVPC6TIgLWyDf88XgFfjilNKNz0c/aGGcCQQD3WRxwots1lDcUhS4dpOYYnN3moKNgB07Hkpxkm+bw7xvjjHqI8q/4Jiou16eQURG+hlBZlZz37Y7P+PHF2XG3AkAyng/1WhfUAfRVewpsuIncaEXKWi4gSXthxrLkMteM68JRfvtb0cAMYyKvr72oY4Phyoe/LSWVJOcW3kIzW8+rAkBWekhQNRARBnXPbdS2to1f85A9btJP454udlrJbhxrBh4pC1dYBAlz59v9rpY+Ban/g7QZ7g4IPH0exzm4Y5K3AkBjEVxIKzb2sPDe34Aa6Qd/p6YpG9G6ND0afY+m5phBhH+rNkfYFkr98cBqjDm6NFhT7+CmRrF903gDQZmxCspY', '商户私钥', '', 'yeepay', '银行卡支付（易宝）', 7, 0, 1),
(40, 'pay_yeepay_merchantpublickey', 'type=text&size=80', 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDxhOgx8q1FAIKnqf6BqjCLKyXXSTRSNSfwS9Nc6E2ffmIpbieyN7mB7XqQKY/icnOB34vtPAjEmQUx4uc1h5R0ApdFm3RJEsWokV/beGjEtd1i2EoSgYwGSXaC32ExpcmsPrZu1hvzEflVmpJD19KcXxvnbmQEHiA6AS1Xy/vooQIDAQAB', '商户公钥', '', 'yeepay', '银行卡支付（易宝）', 7, 0, 1),
(41, 'pay_yeepay_yeepaypublickey', 'type=text&size=80', 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCxnYJL7fH7DVsS920LOqCu8ZzebCc78MMGImzW8MaP/cmBGd57Cw7aRTmdJxFD6jj6lrSfprXIcT7ZXoGL5EYxWUTQGRsl4HZsr1AlaOKxT5UnsuEhA/K1dN1eA4lBpNCRHf9+XDlmqVBUguhNzy6nfNjb2aGE+hkxPP99I1iMlQIDAQAB', '易宝公钥', '', 'yeepay', '银行卡支付（易宝）', 7, 0, 1),
(42, 'pay_yeepay_productcatalog', 'type=text&size=80', '1', '商品类别码', '', 'yeepay', '银行卡支付（易宝）', 7, 0, 1),
(43, 'pay_allinpay_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'allinpay', '银行卡支付（通联）', 7, 0, 1),
(44, 'pay_allinpay_merchantid', 'type=text&size=80', '100020091218001', '商户号', '', 'allinpay', '银行卡支付（通联）', 7, 0, 1),
(45, 'pay_allinpay_merchantkey', 'type=text&size=80', '1234567890', 'MD5 KEY', '', 'allinpay', '银行卡支付（通联）', 7, 0, 1),
(46, 'pay_weixin_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'weixin', '微信支付', 7, 0, 1),
(47, 'pay_weixin_appid', 'type=text&size=80', '', 'Appid', '微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看。', 'weixin', '微信支付', 7, 0, 1),
(48, 'pay_weixin_mchid', 'type=text&size=80', '', 'Mchid', '受理商ID，身份标识', 'weixin', '微信支付', 7, 0, 1),
(49, 'pay_weixin_key', 'type=text&size=80', '', 'Key', '商户支付密钥Key。审核通过后，在微信发送的邮件中查看。', 'weixin', '微信支付', 7, 0, 1),
(50, 'wx_encodingaeskey', 'type=text', '', '公众号消息加解密Key', '公众号消息加解密Key', '0', '', 13, 0, 1),
(51, 'wechat_appid', 'type=text&validate=required:true', 'aaaaa', 'AppID', 'AppID', '0', '', 8, 0, 1),
(52, 'wechat_appsecret', 'type=text&validate=required:true', 'aaaaa', 'AppSecret', 'AppSecret', '0', '', 8, 0, 1),
(53, 'bbs_url', 'type=text&validate=required:true', 'http://bbs.52codes.net', '交流论坛网址', '商家用于交流的论坛网址，需自行搭建', '0', '', 1, 0, 1),
(54, 'user_store_num_limit', 'type=text&size=20', '0', '开店数限制', '用户最大开店数限制', '0', '每个用户最多可开店数限制，0为不限', 1, 0, 1),
(55, 'sync_login_key', '', 'KKgybUkzUqrBGwCTgnAhKmqJmrzfZajJUnZenBZEVQN', '', '', '0', '', 0, 0, 0),
(56, 'is_check_mobile', '', '0', '手机号验证', '手机号验证', '0', '', 0, 0, 0),
(57, 'readme_title', 'type=text', '吾爱源码社区_提供小猪独立微店商源码及小猪O2O V1.3破解版源码', '开店协议标题', '开店协议标题', '0', '', 1, 0, 1),
(58, 'readme_content', 'type=textarea&rows=20&cols=93', '在向消费者销售及向供应商采购的过程中，分销商需遵守：\r\n\r\n1 分销商必须严格履行对消费者的承诺，分销商不得以其与供应商之间的约定对抗其对消费者的承诺,如果分销商与供应商之间的约定不清或不能覆盖分销商对消费者的销售承诺，风险由分销商自行承担；分销商与买家出现任何纠纷，均应当依据淘宝相关规则进行处理；\r\n\r\n2 分销商承诺其最终销售给消费者的分销商品零售价格符合与供应商的约定；\r\n\r\n3 在消费者（买家）付款后，分销商应当及时向供应商支付采购单货款，否则7天后系统将关闭采购单交易，分销商应当自行承担因此而发生的交易风险；\r\n\r\n4 分销商应当在系统中及时同步供应商的实际产品库存，无论任何原因导致买家拍下后无货而产生的纠纷，均应由分销商自行承担风险与责任；\r\n\r\n5 分销商承诺分销商品所产生的销售订单均由分销平台相应的的供应商供货，以保证分销商品品质；\r\n\r\n6 分销商有义务确认消费者（买家）收货地址的有效性；\r\n\r\n7 分销商有义务在买家收到货物后，及时确认货款给供应商。如果在供应商发出货物30天后，分销商仍未确认收货，则系统会自动确认收货并将采购单对应的货款支付给供应商。', '开店协议内容', '用户开店前必须先阅读并同意该协议', '0', '', 1, 0, 1),
(59, 'max_store_drp_level', 'type=text&size=10', '8', '排他分销最大级别', '允许排他分销最多级别', '0', '', 12, 0, 1),
(60, 'open_store_drp', 'type=radio&value=1:开启|0:关闭', '1', '排他分销', '', '0', '', 12, 0, 1),
(61, 'open_platform_drp', 'type=radio&value=1:开启|0:关闭', '1', '全网分销', '', '0', '', 12, 0, 1),
(62, 'platform_mall_index_page', 'type=page&validate=required:true,number:true', '3', '平台商城首页内容', '选择一篇微页面作为平台商城首页的内容', '0', '', 11, 1, 1),
(63, 'platform_mall_open', 'type=radio&value=1:开启|0:关闭', '1', '是否开启平台商城', '如果不开启平台商城，则首页将显示为宣传介绍页面！否则显示平台商城', '0', '', 11, 2, 1),
(64, 'theme_index_group', '', 'default', '', '', '0', '', 0, 0, 0),
(65, 'wechat_qrcode', 'type=image&validate=required:true,url:true', 'http://d.52codes.net/upload/images/system/55aa280d658c1.jpg', '公众号二维码', '您的公众号二维码', '0', '', 8, 0, 1),
(66, 'wechat_name', 'type=text&validate=required:true', 'aaa', '公众号名称', '公众号的名称', '0', '', 8, 0, 1),
(67, 'wechat_sourceid', 'type=text&validate=required:true', 'aaaa', '公众号原始id', '公众号原始id', '0', '', 8, 0, 1),
(68, 'wechat_id', 'type=text&validate=required:true', '75943938@qq.com', '微信号', '微信号', '0', '', 8, 0, 1),
(69, 'wechat_token', 'type=text&validate=required:true', '015238d04c59ebae287145170449f0ec', '微信验证TOKEN', '微信验证TOKEN', '0', '', 8, 0, 0),
(70, 'wechat_encodingaeskey', 'type=text', 'aaaaaaa', 'EncodingAESKey', '公众号消息加解密Key,在使用安全模式情况下要填写该值，请先在管理中心修改，然后填写该值，仅限服务号和认证订阅号', '0', '', 8, 0, 1),
(71, 'wechat_encode', 'type=select&value=0:明文模式|1:兼容模式|2:安全模式', '0', '消息加解密方式', '如需使用安全模式请在管理中心修改，仅限服务号和认证订阅号', '0', '', 8, 0, 1),
(72, 'web_login_show', 'type=select&value=0:两种方式|1:仅允许帐号密码登录|2:仅允许微信扫码登录', '0', '用户登录电脑网站的方式', '用户登录电脑网站的方式', '0', '', 2, 0, 1),
(73, 'store_pay_weixin_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'store_weixin', '商家微信支付', 7, 0, 1),
(74, 'im_appid', '', '1530', '', '', '0', '', 0, 0, 1),
(75, 'im_appkey', '', '4611eeb8728fa0f82c95def32da99bf0', '', '', '0', '', 0, 0, 1),
(76, 'attachment_upload_type', 'type=select&value=0:保存到本服务器|1:保存到又拍云', '0', '附件保存方式', '附件保存方式', 'base', '基础配置', 14, 0, 1),
(77, 'attachment_up_bucket', 'type=text&size=50', '', 'BUCKET', 'BUCKET', 'upyun', '又拍云', 14, 0, 1),
(78, 'attachment_up_form_api_secret', 'type=text&size=50', '', 'FORM_API_SECRET', 'FORM_API_SECRET', 'upyun', '又拍云', 14, 0, 1),
(79, 'attachment_up_username', 'type=text&size=50', '', '操作员用户名', '操作员用户名', 'upyun', '又拍云', 14, 0, 1),
(80, 'attachment_up_password', 'type=text&size=50', '', '操作员密码', '操作员密码', 'upyun', '又拍云', 14, 0, 1),
(81, 'attachment_up_domainname', 'type=text&size=50', '', '云存储域名', '云存储域名 不包含http://', 'upyun', '又拍云', 14, 0, 1),
(82, 'web_index_cache', 'type=text&size=20&validate=required:true,number:true,maxlength:5', '10', 'PC端首页缓存时间', 'PC端首页缓存时间，0为不缓存（小时为单位）', '0', '', 1, 0, 1),
(83, 'notify_appid', '', 'aabbccddeeffgghhiijjkkllmmnn', '', '通知的appid', '0', '', 0, 0, 0),
(84, 'notify_appkey', '', 'aabbccddeeffgghhiijjkkll', '', '通知的KEY', '0', '', 0, 0, 0),
(85, 'is_diy_template', 'type=radio&value=1:开启|0:关闭', '1', '是否使用自定模板', '开启后平台商城首页将不使用微杂志。自定义模板目录/template/wap/default/theme', '0', '', 11, 3, 1),
(86, 'service_key', 'type=text&validate=required:false', '', '服务key', '请填写购买产品时的服务key', '0', '', 1, 0, 1),
(87, 'attachment_upload_unlink', 'type=select&value=0:不删除本地附件|1:删除本地附件', '0', '是否删除本地附件', '当附件存放在远程时，如果本地服务器空间充足，不建议删除本地附件', 'base', '基础配置', 14, 0, 1),
(88, 'weidian_key', 'type=salt', 'pigcms', '微店KEY', '对接微店使用的KEY，请妥善保管', '0', '', 1, 0, 1),
(89, 'syn_domain', 'type=text', '', '营销活动地址', '部分功能需要调用平台内容，需要用到该网址', '0', '', 8, -2, 1),
(90, 'encryption', 'type=text', '', '营销活动key', '与平台对接时需要用到', '0', '', 8, -1, 1),
(91, 'is_have_activity', 'type=radio&value=1:有|0:没有', '1', '活动', '首页是否需要展示营销活动', '0', '0', 1, 0, 1),
(92, 'pc_usercenter_logo', 'type=image&validate=required:true,url:true', 'http://bbs.52codes.net/static/image/common/logo.png', 'PC-个人用户中心LOGO图', '请填写带LOGO的网址，包含（http://域名）', '0', '', 1, 0, 1),
(93, 'pc_shopercenter_logo', 'type=image&validate=required:true,url:true', 'http://bbs.52codes.net/static/image/common/logo.png', '商家中心LOGO图', '请填写带LOGO的网址，包含（http://域名）', '0', '', 1, 0, 1),
(94, 'is_allow_comment_control', 'type=select&value=1:允许商户管理评论|2:不允许商户管理评论', '1', '是否允许商户管理评论', '开启后，商户可对评论进行增、删、查操作', '0', '', 1, 0, 1),
(95, 'ischeck_to_show_by_comment', 'type=select&value=1:不需要审核评论才显示|0:需审核即可显示评论', '1', '评论是否需要审核显示', '开启后，需商家或管理员审核方可显示，反之：不需审核即可显示', '0', '', 1, 0, 1),
(96, 'sales_ratio', 'type=text&size=3&validate=required:true,number:true,maxlength:2', '2', '商家销售分成比例', '例：填入：2，则相应扣除2%，最高位100%，按照所填百分比进行扣除', '0', '', 1, 0, 1),
(99, 'ischeck_store', 'type=select&value=1:开店需要审核|0:开店无需审核', '0', '开店是否要审核', '开启后，会员开店需要后台审核通过后，店铺才能正常使用', '0', '', 1, 0, 1),
(100, 'synthesize_store', '', '1', '', '综合商城预览', '0', '', 1, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_config_group`
--

CREATE TABLE IF NOT EXISTS `pigcms_config_group` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `gname` char(20) NOT NULL,
  `gsort` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='配置分组' AUTO_INCREMENT=15 ;

--
-- 导出表中的数据 `pigcms_config_group`
--

INSERT INTO `pigcms_config_group` (`gid`, `gname`, `gsort`, `status`) VALUES
(1, '基础配置', 10, 1),
(7, '支付配置', 4, 1),
(11, '微信版商城配置', 0, 1),
(12, '分销配置', 0, 1),
(8, '平台公众号配置', 3, 1),
(13, '店铺绑定公众号配置', 0, 1),
(2, '会员配置', 9, 1),
(14, '附件配置', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_coupon`
--

CREATE TABLE IF NOT EXISTS `pigcms_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `store_id` int(11) NOT NULL COMMENT '商铺id',
  `name` varchar(255) NOT NULL COMMENT '优惠券名称',
  `face_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券面值(起始)',
  `limit_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用优惠券的订单金额下限（为0：为不限定）',
  `most_have` int(11) NOT NULL COMMENT '单人最多拥有优惠券数量（0：不限制）',
  `total_amount` int(11) NOT NULL COMMENT '发放总量',
  `start_time` int(11) NOT NULL COMMENT '生效时间',
  `end_time` int(11) NOT NULL COMMENT '过期时间',
  `is_expire_notice` tinyint(1) NOT NULL COMMENT '到期提醒（0：不提醒；1：提醒）',
  `is_share` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许分享链接（0：不允许；1：允许）',
  `is_all_product` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否全店通用（0：全店通用；1：指定商品使用）',
  `is_original_price` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:非原价购买可使用；1：原价购买商品时可',
  `timestamp` int(11) NOT NULL COMMENT '添加优惠券的时间',
  `description` text NOT NULL COMMENT '使用说明',
  `used_number` int(11) NOT NULL DEFAULT '0' COMMENT '已使用数量',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '已领取数量',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否失效（0：失效；1：未失效）',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '券类型（1：优惠券； 2:赠送券）',
  UNIQUE KEY `id` (`id`),
  KEY `uid` (`uid`,`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='优惠券' AUTO_INCREMENT=21 ;

--
-- 导出表中的数据 `pigcms_coupon`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_coupon_to_product`
--

CREATE TABLE IF NOT EXISTS `pigcms_coupon_to_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL COMMENT '优惠券id',
  `product_id` int(11) NOT NULL COMMENT '产品id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `coupon_id` (`coupon_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='优惠券产品对应表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_coupon_to_product`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_custom_field`
--

CREATE TABLE IF NOT EXISTS `pigcms_custom_field` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `module_name` varchar(20) NOT NULL,
  `module_id` int(11) NOT NULL,
  `field_type` varchar(20) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`field_id`),
  KEY `store_id_2` (`store_id`,`module_name`,`module_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='自定义字段' AUTO_INCREMENT=651 ;

--
-- 导出表中的数据 `pigcms_custom_field`
--

INSERT INTO `pigcms_custom_field` (`field_id`, `store_id`, `module_name`, `module_id`, `field_type`, `content`) VALUES
(315, 3, 'page', 3, 'rich_text', 'a:1:{s:7:"content";s:2948:"&lt;table data-sort=&quot;sortDisabled&quot;&gt;&lt;tbody&gt;&lt;tr class=&quot;firstRow&quot;&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; rowspan=&quot;4&quot; colspan=&quot;1&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb289f66dff.jpg&quot; width=&quot;126&quot; height=&quot;548&quot; style=&quot;width: 126px; height: 548px;&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28b2ec63a.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28be26066.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28c6a3e8f.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28d3a7b98.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28db39193.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28e4f0343.png&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28eb90d62.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28f453cd2.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;";}'),
(3, 4, 'page', 4, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-20 17:05";}'),
(4, 4, 'page', 4, 'rich_text', 'a:1:{s:7:"content";s:2116:"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>";}'),
(5, 5, 'page', 5, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-20 17:05";}'),
(6, 5, 'page', 5, 'rich_text', 'a:1:{s:7:"content";s:2116:"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>";}'),
(7, 6, 'page', 6, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-20 17:58";}'),
(8, 6, 'page', 6, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(9, 6, 'good_cat', 1, 'image_ad', 'a:1:{s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:0:"";}}}'),
(10, 7, 'page', 7, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-23 09:53";}'),
(11, 7, 'page', 7, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(12, 8, 'page', 8, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-23 09:56";}'),
(13, 8, 'page', 8, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(14, 9, 'page', 9, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-25 09:09";}'),
(15, 9, 'page', 9, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(16, 10, 'page', 10, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-25 11:00";}'),
(17, 10, 'page', 10, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(18, 11, 'page', 11, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-28 11:23";}'),
(19, 11, 'page', 11, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(20, 12, 'page', 12, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-29 11:49";}'),
(21, 12, 'page', 12, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(22, 6, 'good_cat', 4, 'goods', 'a:4:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";}'),
(35, 0, 'page', 13, 'store', 'a:0:{}'),
(36, 0, 'page', 13, 'image_ad', 'a:3:{s:10:"max_height";s:3:"320";s:9:"max_width";s:3:"640";s:8:"nav_list";a:4:{i:10;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b99554e8de8.jpg";}i:11;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b9955f2dce2.jpg";}i:12;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b995cf20c96.jpg";}i:13;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b995eec45f9.jpg";}}}'),
(25, 13, 'page', 14, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-30 12:26";}'),
(26, 13, 'page', 14, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(37, 0, 'page', 13, 'image_nav', 'a:4:{i:10;a:5:{s:5:"title";s:6:"酒店";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b9d80a0bc84.jpg";}i:11;a:5:{s:5:"title";s:6:"美食";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b9dbb6bd499.jpg";}i:12;a:5:{s:5:"title";s:6:"打车";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b9dbc6cc520.jpg";}i:13;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:0:"";}}'),
(38, 0, 'page', 13, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:10:"show_title";s:1:"1";s:5:"price";s:1:"1";}'),
(307, 14, 'page', 28, 'component', 'a:3:{s:4:"name";s:7:"模板1";s:2:"id";s:1:"3";s:3:"url";s:45:"http://d.mz868.net/wap/component.php?id=3";}'),
(303, 21, 'page', 29, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-13 15:25";}'),
(304, 21, 'page', 29, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(41, 15, 'page', 16, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-30 17:13";}'),
(42, 15, 'page', 16, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(318, 23, 'page', 31, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-17 22:52";}'),
(109, 3, 'page', 17, 'goods', 'a:5:{s:4:"size";s:1:"3";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"14";s:5:"title";s:87:"BAKONG 2015夏季新款凉鞋女平底沙滩鞋女鞋波西米亚凉鞋820 836黑色 38";s:5:"price";s:5:"79.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=14";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad1878d059.jpg";}i:1;a:5:{s:2:"id";s:2:"13";s:5:"title";s:75:"彰婷 2015夏季新款胖MM短袖大码修身连衣裙T0958 图片色. 3XL";s:5:"price";s:6:"189.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=13";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad08c7dc35.jpg";}i:2;a:5:{s:2:"id";s:2:"12";s:5:"title";s:137:"紫缇宣 欧美大码女装夏装新款印花显瘦两件套装加肥胖mm短袖T恤雪纺衫上衣+短裤子 1540# 3XL 150-160斤左右";s:5:"price";s:6:"178.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=12";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bacf9b630f6.jpg";}}}'),
(106, 3, 'page', 17, 'store', 'a:0:{}'),
(107, 3, 'page', 17, 'image_ad', 'a:3:{s:10:"max_height";s:3:"320";s:9:"max_width";s:3:"640";s:8:"nav_list";a:4:{i:10;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad24731781.jpg";}i:11;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad253f0343.jpg";}i:12;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad25b94a6b.jpg";}i:13;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad263ab8a1.jpg";}}}'),
(108, 3, 'page', 17, 'text_nav', 'a:3:{i:10;a:4:{s:5:"title";s:6:"女装";s:4:"name";s:6:"女装";s:6:"prefix";s:9:"微页面";s:3:"url";s:41:"http://d.mz868.net/wap/page.php?id=18";}i:11;a:4:{s:5:"title";s:6:"女鞋";s:4:"name";s:6:"女鞋";s:6:"prefix";s:9:"微页面";s:3:"url";s:41:"http://d.mz868.net/wap/page.php?id=19";}i:12;a:4:{s:5:"title";s:6:"女包";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(85, 3, 'page', 18, 'store', 'a:0:{}'),
(86, 3, 'page', 18, 'image_ad', 'a:3:{s:10:"max_height";s:3:"320";s:9:"max_width";s:3:"640";s:8:"nav_list";a:3:{i:10;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badd944ffc9.jpg";}i:11;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badda29c47d.jpg";}i:12;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badda94c2c0.jpg";}}}'),
(87, 3, 'page', 18, 'goods', 'a:5:{s:4:"size";s:1:"3";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:4:{i:0;a:5:{s:2:"id";s:2:"16";s:5:"title";s:112:"猫小仙儿2015连衣裙夏装韩版女装小清新两件套印花雪纺半裙加雪纺上衣 米粉底绿花 L";s:5:"price";s:6:"158.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=16";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bada4e7dc35.jpg";}i:1;a:5:{s:2:"id";s:2:"15";s:5:"title";s:96:"虞倩YQ 2015新品秋装女装连衣裙 蕾丝边外套修身显瘦两件套装Y066 梅红色 M";s:5:"price";s:6:"168.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=15";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad9796e811.jpg";}i:2;a:5:{s:2:"id";s:2:"13";s:5:"title";s:75:"彰婷 2015夏季新款胖MM短袖大码修身连衣裙T0958 图片色. 3XL";s:5:"price";s:6:"189.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=13";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad08c7dc35.jpg";}i:3;a:5:{s:2:"id";s:2:"12";s:5:"title";s:137:"紫缇宣 欧美大码女装夏装新款印花显瘦两件套装加肥胖mm短袖T恤雪纺衫上衣+短裤子 1540# 3XL 150-160斤左右";s:5:"price";s:6:"178.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=12";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bacf9b630f6.jpg";}}}'),
(88, 3, 'page', 19, 'store', 'a:0:{}'),
(89, 3, 'page', 19, 'image_ad', 'a:3:{s:10:"max_height";s:3:"320";s:9:"max_width";s:3:"640";s:8:"nav_list";a:3:{i:10;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badddf2235d.jpg";}i:11;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55baddeb98774.jpg";}i:12;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55baddfba3e8f.jpg";}}}'),
(90, 3, 'page', 19, 'search', 'a:0:{}'),
(91, 3, 'page', 19, 'goods', 'a:5:{s:4:"size";s:1:"3";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:4:{i:0;a:5:{s:2:"id";s:2:"19";s:5:"title";s:106:"莱尔斯丹 2015春季新款优雅圆头纯色漆皮单鞋高跟金属扣女鞋OUSE 6M82901 黑色 BKP 38";s:5:"price";s:6:"479.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=19";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badcced1afb.jpg";}i:1;a:5:{s:2:"id";s:2:"18";s:5:"title";s:126:"邦木 2015春夏新款单鞋女鞋网面透气女帆布鞋韩版透气厚底运动摇摇鞋松糕时尚女休闲鞋 月色 38";s:5:"price";s:6:"198.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=18";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badc13e8931.jpg";}i:2;a:5:{s:2:"id";s:2:"17";s:5:"title";s:96:"红蜻蜓 2015春季新款时尚舒适可爱蝴蝶结女鞋女单鞋 WCB57311/12/13/15 黑色 36";s:5:"price";s:6:"249.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=17";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badb5531781.jpg";}i:3;a:5:{s:2:"id";s:2:"14";s:5:"title";s:87:"BAKONG 2015夏季新款凉鞋女平底沙滩鞋女鞋波西米亚凉鞋820 836黑色 38";s:5:"price";s:5:"79.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=14";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad1878d059.jpg";}}}'),
(97, 3, 'page', 20, 'store', 'a:0:{}'),
(98, 3, 'page', 20, 'image_ad', 'a:3:{s:10:"max_height";s:3:"320";s:9:"max_width";s:3:"640";s:8:"nav_list";a:3:{i:10;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bae41cbe9ce.jpg";}i:11;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bae42a4c2c0.jpg";}i:12;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bae4344c2c0.jpg";}}}'),
(99, 3, 'page', 20, 'goods', 'a:5:{s:4:"size";s:1:"3";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:2:{i:0;a:5:{s:2:"id";s:2:"22";s:5:"title";s:94:"海澜之家 2015夏季新品 男装条纹拼接短袖T恤HNTBJ2A009A 浅灰镶拼(11) 175/92Y";s:5:"price";s:5:"99.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=22";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bae33329d6f.jpg";}i:1;a:5:{s:2:"id";s:2:"21";s:5:"title";s:93:"依泽麦布2015夏款短袖T恤男 潮男修身印花运动套装 男装短袖T恤 白色 XL";s:5:"price";s:6:"158.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=21";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bae24de4c28.jpg";}}}'),
(100, 16, 'page', 21, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-07-31 12:28";}'),
(101, 16, 'page', 21, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(316, 3, 'page', 3, 'rich_text', 'a:1:{s:7:"content";s:122:"&lt;p&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2af00b527.jpg&quot;&gt;&lt;/p&gt;";}'),
(317, 3, 'page', 3, 'rich_text', 'a:1:{s:7:"content";s:2535:"&lt;table data-sort=&quot;sortDisabled&quot;&gt;&lt;tbody&gt;&lt;tr class=&quot;firstRow&quot;&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; rowspan=&quot;3&quot; colspan=&quot;1&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b0c5b6e4.jpg&quot; width=&quot;126&quot; height=&quot;408&quot; style=&quot;width: 126px; height: 408px;&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b27e8931.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b2f1e654.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b3585647.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b3c2da78.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b43b6fbc.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://d.mz868.net/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b4a40ba5.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;";}'),
(314, 3, 'page', 3, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"12";s:5:"title";s:137:"紫缇宣 欧美大码女装夏装新款印花显瘦两件套装加肥胖mm短袖T恤雪纺衫上衣+短裤子 1540# 3XL 150-160斤左右";s:5:"price";s:6:"178.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=12";s:5:"image";s:43:"images/000/000/003/201507/55bacf9b630f6.jpg";}i:1;a:5:{s:2:"id";s:2:"14";s:5:"title";s:87:"BAKONG 2015夏季新款凉鞋女平底沙滩鞋女鞋波西米亚凉鞋820 836黑色 38";s:5:"price";s:5:"79.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=14";s:5:"image";s:43:"images/000/000/003/201507/55bad1878d059.jpg";}i:2;a:5:{s:2:"id";s:2:"13";s:5:"title";s:75:"彰婷 2015夏季新款胖MM短袖大码修身连衣裙T0958 图片色. 3XL";s:5:"price";s:6:"189.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=13";s:5:"image";s:43:"images/000/000/003/201507/55bad08c7dc35.jpg";}}}'),
(310, 3, 'page', 3, 'image_ad', 'a:3:{s:10:"max_height";s:3:"320";s:9:"max_width";s:3:"640";s:8:"nav_list";a:4:{i:10;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad2ae5f3ed.jpg";}i:11;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad2b453cd2.jpg";}i:12;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad2bba3e8f.jpg";}i:13;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad2c240ba5.jpg";}}}'),
(311, 3, 'page', 3, 'search', 'a:0:{}'),
(312, 3, 'page', 3, 'image_nav', 'a:4:{i:10;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:0:"";}i:11;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:0:"";}i:12;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:0:"";}i:13;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:0:"";}}'),
(313, 3, 'page', 3, 'image_nav', 'a:4:{i:10;a:5:{s:5:"title";s:6:"女人";s:4:"name";s:6:"女人";s:6:"prefix";s:9:"微页面";s:3:"url";s:41:"http://d.mz868.net/wap/page.php?id=17";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad50fca0e9.png";}i:11;a:5:{s:5:"title";s:6:"男人";s:4:"name";s:6:"男人";s:6:"prefix";s:9:"微页面";s:3:"url";s:41:"http://d.mz868.net/wap/page.php?id=20";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad515c26d7.png";}i:12;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:0:"";}i:13;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:0:"";}}'),
(202, 17, 'page', 22, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-05 21:21";}');
INSERT INTO `pigcms_custom_field` (`field_id`, `store_id`, `module_name`, `module_id`, `field_type`, `content`) VALUES
(203, 17, 'page', 22, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(204, 18, 'page', 23, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-05 21:23";}'),
(205, 18, 'page', 23, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(241, 19, 'page_cat', 2, 'rich_text', 'a:1:{s:7:"content";s:1860:"&lt;h2&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(146, 208, 80);&quot;&gt;会费缴纳标准：&lt;/span&gt;&lt;/h2&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(0, 176, 240);&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 宋体; font-size: 20px; text-decoration: none;&quot;&gt;商会会费按年缴纳&lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;会长（法人代表）：100000元/年；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;副会长：50000元/年；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;秘书长、监事长：50000元/年&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;副秘书长：30000元/年；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;理事：10000元/年；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;会员：3000元/年；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;新加入商会的会员均应在办理入会手续时按要求交纳会费。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;会员向商会缴纳会费后，财务人员应开具加盖公章的会费收取收据，会费列入财务监管，会费缴纳不在退费。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;";}'),
(244, 19, 'ucenter', 19, 'white', 'a:1:{s:6:"height";s:2:"30";}'),
(245, 19, 'ucenter', 19, 'store', 'a:0:{}'),
(208, 19, 'good_cat', 8, 'line', 'a:0:{}'),
(209, 19, 'good_cat', 8, 'store', 'a:0:{}'),
(210, 19, 'good_cat', 8, 'text_nav', 'a:0:{}'),
(211, 19, 'page', 25, 'title', 'a:2:{s:5:"title";s:24:"许昌商会会费缴纳";s:9:"sub_title";s:15:"以年为单位";}'),
(212, 19, 'page', 25, 'notice', 'a:1:{s:7:"content";s:75:"新加入商会的会员均应在办理入会手续时按要求交纳会费";}'),
(213, 19, 'page', 25, 'search', 'a:0:{}'),
(214, 19, 'page', 25, 'goods', 'a:7:{s:4:"size";s:1:"1";s:9:"size_type";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:10:"show_title";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:2:{i:0;a:5:{s:2:"id";s:2:"26";s:5:"title";s:9:"副会长";s:5:"price";s:7:"5000.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=26";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c311f119a65.jpg";}i:1;a:5:{s:2:"id";s:2:"25";s:5:"title";s:24:"会长（法人代表）";s:5:"price";s:8:"10000.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=25";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c30c4c622cb.jpg";}}}'),
(215, 19, 'page', 25, 'line', 'a:0:{}'),
(216, 19, 'page', 25, 'store', 'a:0:{}'),
(253, 19, 'page', 26, 'notice', 'a:1:{s:7:"content";s:222:"新加入商会的会员均应在办理入会手续时按要求交纳会费；会员向商会缴纳会费后，财务人员应开具加盖公章的会费收取收据，会费列入财务监管，会费缴纳不在退费。";}'),
(256, 19, 'page', 26, 'line', 'a:0:{}'),
(254, 19, 'page', 26, 'search', 'a:0:{}'),
(255, 19, 'page', 26, 'goods', 'a:7:{s:4:"size";s:1:"1";s:9:"size_type";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:10:"show_title";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:6:{i:0;a:5:{s:2:"id";s:2:"25";s:5:"title";s:24:"会长（法人代表）";s:5:"price";s:8:"10000.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=25";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c30c4c622cb.jpg";}i:1;a:5:{s:2:"id";s:2:"26";s:5:"title";s:9:"副会长";s:5:"price";s:7:"5000.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=26";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c311f119a65.jpg";}i:2;a:5:{s:2:"id";s:2:"27";s:5:"title";s:21:"秘书长、监事长";s:5:"price";s:8:"50000.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=27";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c316882b3e5.jpg";}i:3;a:5:{s:2:"id";s:2:"28";s:5:"title";s:12:"副秘书长";s:5:"price";s:8:"30000.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=28";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c3173428e03.jpg";}i:4;a:5:{s:2:"id";s:2:"29";s:5:"title";s:6:"理事";s:5:"price";s:8:"10000.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=29";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c31871c3361.jpg";}i:5;a:5:{s:2:"id";s:2:"30";s:5:"title";s:6:"会员";s:5:"price";s:7:"3000.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=30";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c3194aec38e.jpg";}}}'),
(252, 19, 'page', 26, 'title', 'a:2:{s:5:"title";s:24:"许昌商会会费缴纳";s:9:"sub_title";s:24:"商会会费按年缴纳";}'),
(257, 19, 'page', 26, 'store', 'a:0:{}'),
(258, 20, 'page', 27, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-10 14:35";}'),
(259, 20, 'page', 27, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(306, 14, 'page', 28, 'image_nav', 'a:4:{i:10;a:5:{s:5:"title";s:6:"纯棉";s:4:"name";s:6:"纯棉";s:6:"prefix";s:12:"商品分组";s:3:"url";s:43:"http://d.mz868.net/wap/goodcat.php?id=9";s:5:"image";s:0:"";}i:11;a:5:{s:5:"title";s:9:"生态棉";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:0:"";}i:12;a:5:{s:5:"title";s:9:"钻石绒";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:0:"";}i:13;a:5:{s:5:"title";s:6:"天丝";s:4:"name";s:15:"天丝四件套";s:6:"prefix";s:6:"商品";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=32";s:5:"image";s:0:"";}}'),
(305, 14, 'page', 28, 'search', 'a:0:{}'),
(266, 14, 'common_ad', 14, 'image_ad', 'a:3:{s:10:"max_height";s:4:"1308";s:9:"max_width";s:4:"1600";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/014/201508/55cc3765c469a.jpg";}}}'),
(267, 14, 'common_ad', 14, 'component', 'a:3:{s:4:"name";s:7:"模板1";s:2:"id";s:1:"3";s:3:"url";s:45:"http://d.mz868.net/wap/component.php?id=3";}'),
(298, 14, 'custom_page', 3, 'image_ad', 'a:3:{s:10:"max_height";s:4:"1308";s:9:"max_width";s:4:"1600";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:0:"";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:75:"http://weidian01.b0.upaiyun.com/images/000/000/014/201508/55cc3c7fa2e40.jpg";}}}'),
(308, 22, 'page', 30, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-16 12:36";}'),
(309, 22, 'page', 30, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(319, 23, 'page', 31, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(320, 24, 'page', 32, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-17 23:45";}'),
(321, 24, 'page', 32, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>";}'),
(322, 0, 'page', 33, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(323, 0, 'page', 33, 'search', 'a:0:{}'),
(324, 0, 'page', 33, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"41";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=43";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"42";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=42";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"43";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=41";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(325, 0, 'page', 34, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(326, 0, 'page', 34, 'search', 'a:0:{}'),
(327, 0, 'page', 34, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"13";s:5:"title";s:12:"餐饮外卖";}}}'),
(328, 0, 'page', 35, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(329, 0, 'page', 35, 'search', 'a:0:{}'),
(330, 0, 'page', 35, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(331, 0, 'page', 35, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"41";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=41";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"42";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=43";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"43";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=43";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(332, 0, 'page', 36, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(333, 0, 'page', 36, 'search', 'a:0:{}'),
(334, 0, 'page', 36, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"41";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=41";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"42";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=41";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"43";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=41";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(335, 0, 'page', 37, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(336, 0, 'page', 37, 'search', 'a:0:{}'),
(337, 0, 'page', 37, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(338, 0, 'page', 37, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"41";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=42";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"42";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=41";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"43";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=41";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(339, 0, 'page', 38, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(340, 0, 'page', 38, 'search', 'a:0:{}'),
(341, 0, 'page', 38, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(342, 0, 'page', 38, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"41";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=42";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"42";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=43";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"43";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=42";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(343, 0, 'page', 39, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(344, 0, 'page', 39, 'search', 'a:0:{}'),
(345, 0, 'page', 39, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"44";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=44";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"45";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=44";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"46";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=46";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(346, 0, 'page', 40, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(347, 0, 'page', 40, 'search', 'a:0:{}'),
(348, 0, 'page', 40, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"14";s:5:"title";s:12:"餐饮外卖";}}}'),
(349, 0, 'page', 41, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(350, 0, 'page', 41, 'search', 'a:0:{}'),
(351, 0, 'page', 41, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(352, 0, 'page', 41, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"44";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=44";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"45";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=44";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"46";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=46";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(353, 0, 'page', 42, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(354, 0, 'page', 42, 'search', 'a:0:{}'),
(355, 0, 'page', 42, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"44";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=44";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"45";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=44";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"46";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=45";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(356, 0, 'page', 43, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(357, 0, 'page', 43, 'search', 'a:0:{}'),
(358, 0, 'page', 43, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(359, 0, 'page', 43, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"44";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=46";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"45";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=46";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"46";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=45";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(360, 0, 'page', 44, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(361, 0, 'page', 44, 'search', 'a:0:{}'),
(362, 0, 'page', 44, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(363, 0, 'page', 44, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"44";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=44";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"45";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=45";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"46";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=45";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(364, 0, 'page', 45, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(365, 0, 'page', 45, 'search', 'a:0:{}'),
(366, 0, 'page', 45, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"47";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=47";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"48";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=49";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"49";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=47";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(367, 0, 'page', 46, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(368, 0, 'page', 46, 'search', 'a:0:{}'),
(369, 0, 'page', 46, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"15";s:5:"title";s:12:"餐饮外卖";}}}'),
(370, 0, 'page', 47, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(371, 0, 'page', 47, 'search', 'a:0:{}'),
(372, 0, 'page', 47, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(373, 0, 'page', 47, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"47";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=49";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"48";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=47";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"49";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=49";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(374, 0, 'page', 48, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(375, 0, 'page', 48, 'search', 'a:0:{}'),
(376, 0, 'page', 48, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"47";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=48";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"48";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=49";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"49";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=48";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(377, 0, 'page', 49, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(378, 0, 'page', 49, 'search', 'a:0:{}'),
(379, 0, 'page', 49, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(380, 0, 'page', 49, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"47";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=49";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"48";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=47";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"49";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=47";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(381, 0, 'page', 50, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(382, 0, 'page', 50, 'search', 'a:0:{}'),
(383, 0, 'page', 50, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(384, 0, 'page', 50, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"47";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=48";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"48";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=49";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"49";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=49";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(385, 0, 'page', 51, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(386, 0, 'page', 51, 'search', 'a:0:{}'),
(387, 0, 'page', 51, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"50";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=51";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"51";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=50";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"52";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=52";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(388, 0, 'page', 52, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(389, 0, 'page', 52, 'search', 'a:0:{}'),
(390, 0, 'page', 52, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"16";s:5:"title";s:12:"餐饮外卖";}}}'),
(391, 0, 'page', 53, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(392, 0, 'page', 53, 'search', 'a:0:{}'),
(393, 0, 'page', 53, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(394, 0, 'page', 53, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"50";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=51";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"51";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=50";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"52";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=50";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(395, 0, 'page', 54, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(396, 0, 'page', 54, 'search', 'a:0:{}'),
(397, 0, 'page', 54, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"50";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=52";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"51";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=52";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"52";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=50";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(398, 0, 'page', 55, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(399, 0, 'page', 55, 'search', 'a:0:{}'),
(400, 0, 'page', 55, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(401, 0, 'page', 55, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"50";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=50";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"51";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=50";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"52";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=51";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(402, 0, 'page', 56, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(403, 0, 'page', 56, 'search', 'a:0:{}'),
(404, 0, 'page', 56, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(405, 0, 'page', 56, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"50";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=51";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"51";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=51";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"52";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=52";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(406, 0, 'page', 57, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(407, 0, 'page', 57, 'search', 'a:0:{}'),
(408, 0, 'page', 57, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"53";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=53";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"54";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=54";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"55";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=55";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(409, 0, 'page', 58, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(410, 0, 'page', 58, 'search', 'a:0:{}'),
(411, 0, 'page', 58, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"17";s:5:"title";s:12:"餐饮外卖";}}}'),
(412, 0, 'page', 59, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(413, 0, 'page', 59, 'search', 'a:0:{}'),
(414, 0, 'page', 59, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(415, 0, 'page', 59, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"53";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=53";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"54";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=54";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"55";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=54";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(416, 0, 'page', 60, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(417, 0, 'page', 60, 'search', 'a:0:{}'),
(418, 0, 'page', 60, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"53";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=55";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"54";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=55";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"55";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=54";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(419, 0, 'page', 61, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(420, 0, 'page', 61, 'search', 'a:0:{}'),
(421, 0, 'page', 61, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(422, 0, 'page', 61, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"53";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=53";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"54";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=54";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"55";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=53";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(423, 0, 'page', 62, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(424, 0, 'page', 62, 'search', 'a:0:{}'),
(425, 0, 'page', 62, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(426, 0, 'page', 62, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"53";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=53";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"54";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=55";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"55";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:39:"http://d.mz868.net/wap/good.php?id=54";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(427, 26, 'page', 63, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-18 22:50";}');
INSERT INTO `pigcms_custom_field` (`field_id`, `store_id`, `module_name`, `module_id`, `field_type`, `content`) VALUES
(428, 26, 'page', 63, 'rich_text', 'a:1:{s:7:"content";s:2095:"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>";}'),
(441, 29, 'page', 66, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-19 21:23";}'),
(435, 27, 'page', 64, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:1:{i:0;a:5:{s:2:"id";s:2:"58";s:5:"title";s:12:"远亮神器";s:5:"price";s:4:"1.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=58";s:5:"image";s:43:"images/000/000/027/201508/55d4819fb0587.png";}}}'),
(444, 30, 'page', 67, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-19 21:26";}'),
(431, 28, 'page', 65, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-19 21:10";}'),
(432, 28, 'page', 65, 'rich_text', 'a:1:{s:7:"content";s:2095:"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>";}'),
(433, 27, 'good', 58, 'goods', 'a:4:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";}'),
(442, 29, 'page', 66, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:1:{i:0;a:5:{s:2:"id";s:2:"59";s:5:"title";s:6:"测试";s:5:"price";d:1;s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=59";s:5:"image";s:43:"images/000/000/029/201508/55d483b4030ad.JPG";}}}'),
(443, 29, 'page', 66, 'rich_text', 'a:1:{s:7:"content";s:2811:"&lt;p&gt;感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。&lt;/p&gt;&lt;p&gt;在微杂志里，您可以多个功能模块，例如“&lt;strong&gt;富文本&lt;/strong&gt;”模块。在“富文本”里，对文字进行&lt;strong&gt;加粗&lt;/strong&gt;、&lt;em&gt;斜体&lt;/em&gt;、&lt;span style=&quot;text-decoration:underline;&quot;&gt;下划线&lt;/span&gt;、&lt;span style=&quot;text-decoration:line-through;&quot;&gt;删除线&lt;/span&gt;、&lt;span style=&quot;color:rgb(0,176,240);&quot;&gt;文字颜色&lt;/span&gt;、&lt;span style=&quot;color:rgb(255,255,255);background-color:rgb(247,150,70);&quot;&gt;背景色&lt;/span&gt;、以及&lt;span style=&quot;font-size:22px;&quot;&gt;字号大小&lt;/span&gt;等简单排版操作。&lt;/p&gt;&lt;p&gt;也可以在这里，通过编辑器使用表格功能&lt;/p&gt;&lt;table&gt;&lt;tbody&gt;&lt;tr class=&quot;firstRow&quot;&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;中奖客户&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;发放奖品&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;备注&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;猪猪&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;内测码&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;&lt;span style=&quot;color:rgb(255,0,0);&quot;&gt;已经发放&lt;/span&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;大麦&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;积分&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;&lt;span style=&quot;color:rgb(0,176,240);&quot;&gt;领取地址&lt;/span&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;p&gt;还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。&lt;br&gt;&lt;/p&gt;&lt;p&gt;另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。&lt;/p&gt;&lt;p&gt;再次感谢您选择JY微店系统！&lt;/p&gt;";}'),
(445, 30, 'page', 67, 'rich_text', 'a:1:{s:7:"content";s:2095:"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>";}'),
(446, 0, 'page', 68, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(447, 0, 'page', 68, 'search', 'a:0:{}'),
(448, 0, 'page', 68, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"60";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=62";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"61";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=60";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"62";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=60";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(449, 0, 'page', 69, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(450, 0, 'page', 69, 'search', 'a:0:{}'),
(451, 0, 'page', 69, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"22";s:5:"title";s:12:"餐饮外卖";}}}'),
(452, 0, 'page', 70, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(453, 0, 'page', 70, 'search', 'a:0:{}'),
(454, 0, 'page', 70, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(455, 0, 'page', 70, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"60";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=61";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"61";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=60";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"62";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=61";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(456, 0, 'page', 71, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(457, 0, 'page', 71, 'search', 'a:0:{}'),
(458, 0, 'page', 71, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"60";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=62";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"61";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=62";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"62";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=62";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(459, 0, 'page', 72, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(460, 0, 'page', 72, 'search', 'a:0:{}'),
(461, 0, 'page', 72, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(462, 0, 'page', 72, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"60";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=60";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"61";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=60";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"62";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=61";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(463, 0, 'page', 73, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(464, 0, 'page', 73, 'search', 'a:0:{}'),
(465, 0, 'page', 73, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(466, 0, 'page', 73, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"60";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=62";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"61";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=62";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"62";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:45:"http://d.mz868.net/wap/good.php?id=62";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(467, 31, 'page', 74, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-19 22:12";}'),
(468, 31, 'page', 74, 'rich_text', 'a:1:{s:7:"content";s:2095:"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>";}'),
(469, 32, 'page', 75, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-19 22:18";}'),
(470, 32, 'page', 75, 'rich_text', 'a:1:{s:7:"content";s:2095:"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>";}'),
(471, 0, 'page', 76, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(472, 0, 'page', 76, 'search', 'a:0:{}'),
(473, 0, 'page', 76, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"63";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=63";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"64";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=64";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"65";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=63";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(474, 0, 'page', 77, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(475, 0, 'page', 77, 'search', 'a:0:{}'),
(476, 0, 'page', 77, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"23";s:5:"title";s:12:"餐饮外卖";}}}'),
(477, 0, 'page', 78, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(478, 0, 'page', 78, 'search', 'a:0:{}'),
(479, 0, 'page', 78, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(480, 0, 'page', 78, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"63";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=63";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"64";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=64";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"65";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=63";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(481, 0, 'page', 79, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(482, 0, 'page', 79, 'search', 'a:0:{}'),
(483, 0, 'page', 79, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"63";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=64";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"64";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=63";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"65";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=64";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(484, 0, 'page', 80, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(485, 0, 'page', 80, 'search', 'a:0:{}'),
(486, 0, 'page', 80, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(487, 0, 'page', 80, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"63";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=63";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"64";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=63";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"65";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=64";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(488, 0, 'page', 81, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(489, 0, 'page', 81, 'search', 'a:0:{}'),
(490, 0, 'page', 81, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(491, 0, 'page', 81, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"63";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=65";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"64";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=63";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"65";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:41:"http://d.mz868.net/wap/good.php?id=65";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(492, 33, 'page', 82, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-20 09:48";}'),
(493, 33, 'page', 82, 'rich_text', 'a:1:{s:7:"content";s:2095:"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>";}'),
(494, 0, 'page', 83, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(495, 0, 'page', 83, 'search', 'a:0:{}'),
(496, 0, 'page', 83, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"66";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=68";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"67";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=67";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"68";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=66";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(497, 0, 'page', 84, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(498, 0, 'page', 84, 'search', 'a:0:{}'),
(499, 0, 'page', 84, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"24";s:5:"title";s:12:"餐饮外卖";}}}'),
(500, 0, 'page', 85, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(501, 0, 'page', 85, 'search', 'a:0:{}'),
(502, 0, 'page', 85, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(503, 0, 'page', 85, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"66";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=67";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"67";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=68";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"68";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=66";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(504, 0, 'page', 86, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(505, 0, 'page', 86, 'search', 'a:0:{}'),
(506, 0, 'page', 86, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"66";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=68";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"67";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=68";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"68";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=68";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(507, 0, 'page', 87, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(508, 0, 'page', 87, 'search', 'a:0:{}'),
(509, 0, 'page', 87, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(510, 0, 'page', 87, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"66";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=66";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"67";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=66";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"68";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=68";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(511, 0, 'page', 88, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(512, 0, 'page', 88, 'search', 'a:0:{}'),
(513, 0, 'page', 88, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(514, 0, 'page', 88, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"66";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=66";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"67";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=66";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"68";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=68";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(515, 0, 'page', 89, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(516, 0, 'page', 89, 'search', 'a:0:{}'),
(517, 0, 'page', 89, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"69";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=70";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"70";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=71";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"71";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=69";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(518, 0, 'page', 90, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(519, 0, 'page', 90, 'search', 'a:0:{}'),
(520, 0, 'page', 90, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"25";s:5:"title";s:12:"餐饮外卖";}}}'),
(521, 0, 'page', 91, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(522, 0, 'page', 91, 'search', 'a:0:{}'),
(523, 0, 'page', 91, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(524, 0, 'page', 91, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"69";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=71";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"70";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=70";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"71";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=70";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(525, 0, 'page', 92, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(526, 0, 'page', 92, 'search', 'a:0:{}'),
(527, 0, 'page', 92, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"69";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=70";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"70";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=70";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"71";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=69";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(528, 0, 'page', 93, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(529, 0, 'page', 93, 'search', 'a:0:{}'),
(530, 0, 'page', 93, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(531, 0, 'page', 93, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"69";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=70";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"70";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=71";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"71";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=70";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(532, 0, 'page', 94, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(533, 0, 'page', 94, 'search', 'a:0:{}'),
(534, 0, 'page', 94, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(535, 0, 'page', 94, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"69";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=69";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"70";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=69";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"71";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=71";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(536, 0, 'page', 95, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(537, 0, 'page', 95, 'search', 'a:0:{}'),
(538, 0, 'page', 95, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"72";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=73";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"73";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=74";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"74";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=74";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(539, 0, 'page', 96, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(540, 0, 'page', 96, 'search', 'a:0:{}'),
(541, 0, 'page', 96, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"26";s:5:"title";s:12:"餐饮外卖";}}}'),
(542, 0, 'page', 97, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(543, 0, 'page', 97, 'search', 'a:0:{}'),
(544, 0, 'page', 97, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(545, 0, 'page', 97, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"72";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=72";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"73";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=73";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"74";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=74";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(546, 0, 'page', 98, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(547, 0, 'page', 98, 'search', 'a:0:{}'),
(548, 0, 'page', 98, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"72";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=72";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"73";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=73";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"74";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=73";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(549, 0, 'page', 99, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(550, 0, 'page', 99, 'search', 'a:0:{}'),
(551, 0, 'page', 99, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(552, 0, 'page', 99, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"72";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=73";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"73";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=72";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"74";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=74";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(553, 0, 'page', 100, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(554, 0, 'page', 100, 'search', 'a:0:{}'),
(555, 0, 'page', 100, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(556, 0, 'page', 100, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"72";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=72";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"73";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=72";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"74";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:37:"http://d.mz868.net/wap/good.php?id=74";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(557, 34, 'page', 101, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-23 19:09";}'),
(558, 34, 'page', 101, 'rich_text', 'a:1:{s:7:"content";s:2107:"<p>感谢您使用绵州微店系统，在绵州微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择绵州微店系统！</p>";}'),
(559, 0, 'page', 102, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(560, 0, 'page', 102, 'search', 'a:0:{}'),
(561, 0, 'page', 102, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"75";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=76";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"76";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=76";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"77";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=77";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(562, 0, 'page', 103, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(563, 0, 'page', 103, 'search', 'a:0:{}'),
(564, 0, 'page', 103, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"27";s:5:"title";s:12:"餐饮外卖";}}}'),
(565, 0, 'page', 104, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(566, 0, 'page', 104, 'search', 'a:0:{}'),
(567, 0, 'page', 104, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(568, 0, 'page', 104, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"75";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=77";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"76";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=76";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"77";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=76";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(569, 0, 'page', 105, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}');
INSERT INTO `pigcms_custom_field` (`field_id`, `store_id`, `module_name`, `module_id`, `field_type`, `content`) VALUES
(570, 0, 'page', 105, 'search', 'a:0:{}'),
(571, 0, 'page', 105, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"75";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=75";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"76";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=77";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"77";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=75";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(572, 0, 'page', 106, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(573, 0, 'page', 106, 'search', 'a:0:{}'),
(574, 0, 'page', 106, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(575, 0, 'page', 106, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"75";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=75";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"76";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=75";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"77";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=76";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(576, 0, 'page', 107, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(577, 0, 'page', 107, 'search', 'a:0:{}'),
(578, 0, 'page', 107, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(579, 0, 'page', 107, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"75";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=76";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"76";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=75";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"77";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:40:"http://test.gope.cn/wap/good.php?id=77";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(580, 35, 'page', 108, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-24 14:36";}'),
(581, 35, 'page', 108, 'rich_text', 'a:1:{s:7:"content";s:2149:"<p>感谢您使用狗扑源码论坛_gope.cn，在狗扑源码论坛_gope.cn里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择狗扑源码论坛_gope.cn！</p>";}'),
(582, 35, 'good_cat', 28, 'goods', 'a:4:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";}'),
(583, 35, 'page', 109, 'goods', 'a:4:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";}'),
(584, 36, 'page', 110, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-08-24 15:13";}'),
(585, 36, 'page', 110, 'rich_text', 'a:1:{s:7:"content";s:2149:"<p>感谢您使用狗扑源码论坛_gope.cn，在狗扑源码论坛_gope.cn里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择狗扑源码论坛_gope.cn！</p>";}'),
(586, 0, 'page', 111, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(587, 0, 'page', 111, 'search', 'a:0:{}'),
(588, 0, 'page', 111, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"79";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=80";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"80";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=81";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"81";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=80";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(589, 0, 'page', 112, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(590, 0, 'page', 112, 'search', 'a:0:{}'),
(591, 0, 'page', 112, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"29";s:5:"title";s:12:"餐饮外卖";}}}'),
(592, 0, 'page', 113, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(593, 0, 'page', 113, 'search', 'a:0:{}'),
(594, 0, 'page', 113, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(595, 0, 'page', 113, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"79";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=79";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"80";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=81";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"81";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=80";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(596, 0, 'page', 114, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(597, 0, 'page', 114, 'search', 'a:0:{}'),
(598, 0, 'page', 114, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"79";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=81";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"80";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=81";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"81";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=79";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(599, 0, 'page', 115, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(600, 0, 'page', 115, 'search', 'a:0:{}'),
(601, 0, 'page', 115, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(602, 0, 'page', 115, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"79";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=80";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"80";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=79";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"81";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=81";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(603, 0, 'page', 116, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(604, 0, 'page', 116, 'search', 'a:0:{}'),
(605, 0, 'page', 116, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(606, 0, 'page', 116, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"79";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=79";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"80";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=81";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"81";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=81";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(607, 0, 'page', 117, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(608, 0, 'page', 117, 'search', 'a:0:{}'),
(609, 0, 'page', 117, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"82";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=83";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"83";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=83";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"84";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=84";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(610, 0, 'page', 118, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(611, 0, 'page', 118, 'search', 'a:0:{}'),
(612, 0, 'page', 118, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"30";s:5:"title";s:12:"餐饮外卖";}}}'),
(613, 0, 'page', 119, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(614, 0, 'page', 119, 'search', 'a:0:{}'),
(615, 0, 'page', 119, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(616, 0, 'page', 119, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"82";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=83";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"83";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=83";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"84";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=84";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(617, 0, 'page', 120, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(618, 0, 'page', 120, 'search', 'a:0:{}'),
(619, 0, 'page', 120, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"82";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=84";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"83";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=83";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"84";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=84";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(620, 0, 'page', 121, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(621, 0, 'page', 121, 'search', 'a:0:{}'),
(622, 0, 'page', 121, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(623, 0, 'page', 121, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"82";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=83";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"83";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=82";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"84";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=83";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(624, 0, 'page', 122, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(625, 0, 'page', 122, 'search', 'a:0:{}'),
(626, 0, 'page', 122, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(627, 0, 'page', 122, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"82";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=82";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"83";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=84";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"84";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:42:"http://gope.cn/wap/good.php?id=82";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(628, 37, 'page', 123, 'title', 'a:2:{s:5:"title";s:21:"初次认识微杂志";s:9:"sub_title";s:16:"2015-09-29 01:16";}'),
(629, 37, 'page', 123, 'rich_text', 'a:1:{s:7:"content";s:2125:"<p>感谢您使用狗扑源码微店系统，在狗扑源码微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择狗扑源码微店系统！</p>";}'),
(630, 0, 'page', 124, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"通用模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg6.png";}}}'),
(631, 0, 'page', 124, 'search', 'a:0:{}'),
(632, 0, 'page', 124, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"86";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=86";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"87";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=87";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"88";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=86";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(633, 0, 'page', 125, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"200";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:12:"餐饮外卖";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg5.png";}}}'),
(634, 0, 'page', 125, 'search', 'a:0:{}'),
(635, 0, 'page', 125, 'goods_group1', 'a:1:{s:12:"goods_group1";a:1:{i:0;a:2:{s:2:"id";s:2:"32";s:5:"title";s:12:"餐饮外卖";}}}'),
(636, 0, 'page', 126, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"食品电商";}'),
(637, 0, 'page', 126, 'search', 'a:0:{}'),
(638, 0, 'page', 126, 'notice', 'a:1:{s:7:"content";s:108:"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板";}'),
(639, 0, 'page', 126, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"86";s:5:"title";s:7:"零食3";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=88";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"87";s:5:"title";s:7:"零食2";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=86";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"88";s:5:"title";s:7:"零食1";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=86";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(640, 0, 'page', 127, 'tpl_shop', 'a:3:{s:16:"shop_head_bg_img";s:27:"/upload/images/head_bg1.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"美妆电商";}'),
(641, 0, 'page', 127, 'search', 'a:0:{}'),
(642, 0, 'page', 127, 'goods', 'a:5:{s:4:"size";s:1:"1";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"86";s:5:"title";s:10:"化妆品3";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=86";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"87";s:5:"title";s:10:"化妆品2";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=87";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"88";s:5:"title";s:10:"化妆品1";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=86";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(643, 0, 'page', 128, 'tpl_shop1', 'a:3:{s:16:"shop_head_bg_img";s:29:"/upload/images/tpl_wxd_bg.png";s:18:"shop_head_logo_img";s:31:"/upload/images/default_shop.png";s:5:"title";s:12:"线下门店";}'),
(644, 0, 'page', 128, 'search', 'a:0:{}'),
(645, 0, 'page', 128, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(646, 0, 'page', 128, 'goods', 'a:4:{s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"86";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=87";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"87";s:5:"title";s:13:"餐饮外卖2";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=86";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"88";s:5:"title";s:13:"餐饮外卖1";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=88";s:5:"image";s:14:"images/eg3.jpg";}}}'),
(647, 0, 'page', 129, 'image_ad', 'a:4:{s:10:"image_type";s:1:"1";s:10:"max_height";s:3:"300";s:9:"max_width";s:3:"640";s:8:"nav_list";a:1:{i:10;a:5:{s:5:"title";s:18:"鲜花速递模板";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";s:5:"image";s:14:"images/eg4.png";}}}'),
(648, 0, 'page', 129, 'search', 'a:0:{}'),
(649, 0, 'page', 129, 'text_nav', 'a:1:{i:10;a:4:{s:5:"title";s:12:"最新商品";s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:3:"url";s:0:"";}}'),
(650, 0, 'page', 129, 'goods', 'a:5:{s:4:"size";s:1:"2";s:7:"buy_btn";s:1:"1";s:12:"buy_btn_type";s:1:"1";s:5:"price";s:1:"1";s:5:"goods";a:3:{i:0;a:5:{s:2:"id";s:2:"86";s:5:"title";s:13:"鲜花速递3";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=87";s:5:"image";s:14:"images/eg1.jpg";}i:1;a:5:{s:2:"id";s:2:"87";s:5:"title";s:13:"鲜花速递2";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=86";s:5:"image";s:14:"images/eg2.jpg";}i:2;a:5:{s:2:"id";s:2:"88";s:5:"title";s:13:"鲜花速递1";s:5:"price";s:5:"10.00";s:3:"url";s:54:"http://ftp192029.host507.zhujiwu.cn/wap/good.php?id=88";s:5:"image";s:14:"images/eg3.jpg";}}}');

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_custom_page`
--

CREATE TABLE IF NOT EXISTS `pigcms_custom_page` (
  `page_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自定义页面id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '自定页面模块名',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='自定义页面模块' AUTO_INCREMENT=4 ;

--
-- 导出表中的数据 `pigcms_custom_page`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_diymenu_class`
--

CREATE TABLE IF NOT EXISTS `pigcms_diymenu_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `pid` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `is_show` tinyint(1) NOT NULL,
  `sort` tinyint(3) NOT NULL,
  `url` varchar(300) NOT NULL DEFAULT '',
  `wxsys` char(40) NOT NULL,
  `content` varchar(500) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT 'type [0:文本，1：图文，2：音乐，3：商品，4：商品分类，5：微页面，6：微页面分类，7：店铺主页，8：会员主页]',
  `fromid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `pigcms_diymenu_class`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_express`
--

CREATE TABLE IF NOT EXISTS `pigcms_express` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(200) NOT NULL,
  `sort` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='快递公司表' AUTO_INCREMENT=18 ;

--
-- 导出表中的数据 `pigcms_express`
--

INSERT INTO `pigcms_express` (`pigcms_id`, `code`, `name`, `url`, `sort`, `add_time`, `status`) VALUES
(1, 'ems', 'ems快递', 'http://www.ems.com.cn/', 0, 1419225737, 1),
(2, 'shentong', '申通快递', 'http://www.sto.cn/', 0, 1419220300, 1),
(3, 'yuantong', '圆通速递', 'http://www.yto.net.cn/', 0, 1419220397, 1),
(4, 'shunfeng', '顺丰速运', 'http://www.sf-express.com/', 0, 1419220418, 1),
(5, 'tiantian', '天天快递', 'http://www.ttkd.cn/', 0, 1419220435, 1),
(6, 'yunda', '韵达快递', 'http://www.yundaex.com/', 0, 1419220474, 1),
(7, 'zhongtong', '中通速递', 'http://www.zto.cn/', 0, 1419220493, 1),
(8, 'longbanwuliu', '龙邦物流', 'http://www.lbex.com.cn/', 0, 1419220511, 1),
(9, 'zhaijisong', '宅急送', 'http://www.zjs.com.cn/', 0, 1419220528, 1),
(10, 'quanyikuaidi', '全一快递', 'http://www.apex100.com/', 0, 1419220551, 1),
(11, 'huitongkuaidi', '汇通速递', 'http://www.htky365.com/', 0, 1419220569, 1),
(12, 'minghangkuaidi', '民航快递', 'http://www.cae.com.cn/', 0, 1419220586, 1),
(13, 'yafengsudi', '亚风速递', 'http://www.airfex.cn/', 0, 1419220605, 1),
(14, 'kuaijiesudi', '快捷速递', 'http://www.fastexpress.com.cn/', 0, 1419220623, 1),
(15, 'tiandihuayu', '天地华宇', 'http://www.hoau.net/', 0, 1419220676, 1),
(16, 'zhongtiekuaiyun', '中铁快运', 'http://www.cre.cn/', 0, 1427265253, 1),
(17, 'deppon', '德邦物流', 'http://www.deppon.com/', 0, 1427265464, 1);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_financial_record`
--

CREATE TABLE IF NOT EXISTS `pigcms_financial_record` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_no` varchar(100) NOT NULL DEFAULT '' COMMENT '订单号',
  `income` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '收入 负值为支出',
  `type` tinyint(1) NOT NULL COMMENT '类型 1订单入账 2提现 3退款 4系统退款 5分销',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `payment_method` varchar(30) NOT NULL DEFAULT '' COMMENT '支付方式',
  `trade_no` varchar(100) NOT NULL DEFAULT '' COMMENT '交易号',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1进行中 2退款 3成功 4失败',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户订单id,统一分销订单',
  `profit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销利润',
  `storeOwnPay` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pigcms_id`),
  KEY `order_id` (`order_id`) USING BTREE,
  KEY `order_no` (`order_no`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='财务记录' AUTO_INCREMENT=4 ;

--
-- 导出表中的数据 `pigcms_financial_record`
--

INSERT INTO `pigcms_financial_record` (`pigcms_id`, `store_id`, `order_id`, `order_no`, `income`, `type`, `balance`, `payment_method`, `trade_no`, `add_time`, `status`, `user_order_id`, `profit`, `storeOwnPay`) VALUES
(1, 29, 18, '20150819214708563365', 2.00, 1, 0.00, 'weixin', '20150819214714168436', 1439992050, 3, 18, 0.00, 0),
(2, 29, 17, '20150819214612378206', 2.00, 1, 2.00, 'CardPay', '20150819215626652154', 1439992607, 3, 17, 0.00, 0),
(3, 29, 20, '20150819221053307724', 2.00, 1, 4.00, 'weixin', '20150819221315519011', 1439993625, 1, 20, 0.00, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_first`
--

CREATE TABLE IF NOT EXISTS `pigcms_first` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `content` varchar(500) NOT NULL COMMENT '回复内容',
  `fromid` tinyint(1) unsigned NOT NULL COMMENT '网站功能回复（1：网站首页，2:团购，3：订餐）',
  `title` varchar(50) NOT NULL COMMENT '图文回复标题',
  `info` varchar(200) NOT NULL COMMENT '图文回复内容',
  `pic` varchar(200) NOT NULL COMMENT '图文回复图片',
  `url` varchar(200) NOT NULL COMMENT '图文回复外站链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_first`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_flink`
--

CREATE TABLE IF NOT EXISTS `pigcms_flink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `info` varchar(100) NOT NULL,
  `url` varchar(150) NOT NULL,
  `add_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `pigcms_flink`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_fx_order`
--

CREATE TABLE IF NOT EXISTS `pigcms_fx_order` (
  `fx_order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fx_order_no` varchar(100) NOT NULL DEFAULT '' COMMENT '订单号',
  `fx_trade_no` varchar(100) NOT NULL DEFAULT '' COMMENT '交易单号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '买家id',
  `session_id` varchar(32) NOT NULL,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '主订单id',
  `order_no` varchar(100) NOT NULL DEFAULT '' COMMENT '主订单号',
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商id',
  `postage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总价',
  `cost_sub_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品成本总价',
  `quantity` int(5) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `cost_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本总额',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '订单状态',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  `paid_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '付款时间',
  `supplier_sent_time` int(11) NOT NULL DEFAULT '0' COMMENT '供货商发货时间',
  `complate_time` int(11) NOT NULL DEFAULT '0' COMMENT '交易完成时间',
  `delivery_user` varchar(100) NOT NULL DEFAULT '' COMMENT '收货人',
  `delivery_tel` varchar(30) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `delivery_address` varchar(200) NOT NULL DEFAULT '' COMMENT '收货地址',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户订单id,统一分销订单',
  `suppliers` varchar(500) NOT NULL DEFAULT '' COMMENT '供货商',
  `fx_postage` varchar(500) NOT NULL DEFAULT '' COMMENT '分销运费',
  PRIMARY KEY (`fx_order_id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `order_no` (`order_no`) USING BTREE,
  KEY `supplier_id` (`supplier_id`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分销订单' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_fx_order`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_fx_order_product`
--

CREATE TABLE IF NOT EXISTS `pigcms_fx_order_product` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fx_order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分销订单id',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '单价',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `quantity` int(5) NOT NULL DEFAULT '0' COMMENT '数量',
  `sku_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '库存id',
  `sku_data` text NOT NULL COMMENT '库存信息',
  `comment` text NOT NULL COMMENT '买家留言',
  `source_product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '源商品id',
  PRIMARY KEY (`pigcms_id`),
  KEY `fx_order_id` (`fx_order_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `sku_id` (`sku_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分销订单商品' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_fx_order_product`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_image_text`
--

CREATE TABLE IF NOT EXISTS `pigcms_image_text` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `title` varchar(64) NOT NULL COMMENT '标题',
  `author` varchar(10) NOT NULL COMMENT '作者',
  `cover_pic` varchar(200) NOT NULL COMMENT '封面图',
  `digest` varchar(300) NOT NULL COMMENT '介绍',
  `content` text NOT NULL COMMENT '内容',
  `url` varchar(200) NOT NULL COMMENT '外链',
  `dateline` int(10) unsigned NOT NULL COMMENT '创建时间',
  `is_show` tinyint(1) unsigned NOT NULL COMMENT '封面图是否显示正文（0:不显示，1：显示）',
  `url_title` varchar(300) NOT NULL COMMENT '外链名称',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图文表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_image_text`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_keyword`
--

CREATE TABLE IF NOT EXISTS `pigcms_keyword` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `content` varchar(200) NOT NULL,
  `from_id` int(11) NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_keyword`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_location_qrcode`
--

CREATE TABLE IF NOT EXISTS `pigcms_location_qrcode` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `add_time` int(11) NOT NULL,
  `openid` char(40) NOT NULL,
  `lat` char(10) NOT NULL,
  `lng` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='使用微信登录生成的临时二维码' AUTO_INCREMENT=400001832 ;

--
-- 导出表中的数据 `pigcms_location_qrcode`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_login_qrcode`
--

CREATE TABLE IF NOT EXISTS `pigcms_login_qrcode` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket` varchar(500) NOT NULL,
  `uid` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='使用微信登录生成的临时二维码' AUTO_INCREMENT=100000030 ;

--
-- 导出表中的数据 `pigcms_login_qrcode`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_my_supplier`
--

CREATE TABLE IF NOT EXISTS `pigcms_my_supplier` (
  `seller_store_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商店铺id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商id',
  `supplier_store_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商店铺id',
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商id',
  KEY `seller_store_id` (`seller_store_id`) USING BTREE,
  KEY `supplier_store_id` (`supplier_store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='我的供货商';

--
-- 导出表中的数据 `pigcms_my_supplier`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_ng_word`
--

CREATE TABLE IF NOT EXISTS `pigcms_ng_word` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ng_word` varchar(100) NOT NULL,
  `replace_word` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `ng_word` (`ng_word`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='敏感词表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_ng_word`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_order`
--

CREATE TABLE IF NOT EXISTS `pigcms_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `order_no` varchar(100) NOT NULL COMMENT '订单号',
  `trade_no` varchar(100) NOT NULL COMMENT '交易号',
  `pay_type` varchar(10) NOT NULL COMMENT '支付方式',
  `third_id` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '买家id',
  `session_id` varchar(32) NOT NULL,
  `postage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '邮费',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品金额（不含邮费）',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额（含邮费）',
  `pro_count` int(11) NOT NULL COMMENT '商品的个数',
  `pro_num` int(10) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `address` text NOT NULL COMMENT '收货地址',
  `address_user` varchar(30) NOT NULL DEFAULT '' COMMENT '收货人',
  `address_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `payment_method` varchar(50) NOT NULL DEFAULT '' COMMENT '支付方式',
  `shipping_method` varchar(50) NOT NULL DEFAULT '' COMMENT '物流方式 express快递发货 selffetch上门自提',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型 0普通 1代付 2送礼 3分销',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单状态 0临时订单 1未支付 2未发货 3已发货 4已完成 5已取消 6退款中 ',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '订单时间',
  `paid_time` int(11) NOT NULL DEFAULT '0' COMMENT '付款时间',
  `sent_time` int(11) NOT NULL DEFAULT '0' COMMENT '发货时间',
  `cancel_time` int(11) NOT NULL DEFAULT '0' COMMENT '取消时间',
  `complate_time` int(11) NOT NULL,
  `refund_time` int(11) NOT NULL COMMENT '退款时间',
  `comment` varchar(500) NOT NULL DEFAULT '' COMMENT '买家留言',
  `bak` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',
  `star` tinyint(1) NOT NULL DEFAULT '0' COMMENT '加星订单 1|2|3|4|5 默认0',
  `pay_money` decimal(10,2) NOT NULL COMMENT '实际付款金额',
  `cancel_method` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单取消方式 0过期自动取消 1卖家手动取消 2买家手动取消',
  `float_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单浮动金额',
  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包含分销商品 0 否 1是',
  `fx_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销订单id',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户订单id,统一分销订单',
  `suppliers` varchar(500) NOT NULL DEFAULT '' COMMENT '商品供货商',
  `packaging` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '打包中',
  `fx_postage` varchar(500) NOT NULL DEFAULT '' COMMENT '分销运费详细 supplier_id=>postage',
  `useStorePay` tinyint(1) NOT NULL DEFAULT '0',
  `storeOpenid` varchar(100) NOT NULL,
  `sales_ratio` decimal(10,2) NOT NULL COMMENT '商家销售分成比例,按照所填百分比进行扣除',
  `is_check` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否对账，1：未对账，2：已对账',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_no` (`order_no`),
  UNIQUE KEY `trade_no` (`trade_no`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `store_id_2` (`store_id`,`status`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单' AUTO_INCREMENT=23 ;

--
-- 导出表中的数据 `pigcms_order`
--

INSERT INTO `pigcms_order` (`order_id`, `store_id`, `order_no`, `trade_no`, `pay_type`, `third_id`, `uid`, `session_id`, `postage`, `sub_total`, `total`, `pro_count`, `pro_num`, `address`, `address_user`, `address_tel`, `payment_method`, `shipping_method`, `type`, `status`, `add_time`, `paid_time`, `sent_time`, `cancel_time`, `complate_time`, `refund_time`, `comment`, `bak`, `star`, `pay_money`, `cancel_method`, `float_amount`, `is_fx`, `fx_order_id`, `user_order_id`, `suppliers`, `packaging`, `fx_postage`, `useStorePay`, `storeOpenid`, `sales_ratio`, `is_check`) VALUES
(14, 29, '20150819212853893590', '20150819212853893590', '', '', 66, '', 0.00, 1.00, 0.00, 1, 1, '', '', '', '', '', 0, 0, 1439990933, 0, 0, 0, 0, 0, '', '', 0, 0.00, 0, 0.00, 0, 0, 0, '29', 0, '', 0, '', 0.00, 1),
(15, 29, '20150819214001576448', '20150819214001576448', '', '', 67, '', 0.00, 1.00, 0.00, 1, 1, '', '', '', '', '', 0, 0, 1439991601, 0, 0, 0, 0, 0, '', '', 0, 0.00, 0, 0.00, 0, 0, 0, '29', 0, '', 0, '', 0.00, 1),
(16, 29, '20150819214246393168', '20150819214313673055', '', '', 67, '', 1.00, 1.00, 2.00, 1, 1, 'a:4:{s:7:"address";s:6:"还差";s:8:"province";s:9:"天津市";s:4:"city";s:0:"";s:4:"area";s:9:"河西区";}', '彭', '13800138000', '', 'express', 0, 1, 1439991766, 0, 0, 0, 0, 0, '', '', 0, 0.00, 0, 0.00, 0, 0, 0, '29', 0, 'a:1:{i:29;d:1;}', 0, '', 0.00, 1),
(17, 29, '20150819214612378206', '20150819215626652154', '', '', 66, '', 1.00, 1.00, 2.00, 1, 1, 'a:4:{s:7:"address";s:12:"人民广场";s:8:"province";s:9:"河北省";s:4:"city";s:12:"秦皇岛市";s:4:"area";s:12:"山海关区";}', '王', '13356985633', 'CardPay', 'express', 0, 4, 1439991972, 1439992607, 1439992707, 0, 1439992714, 0, '', '', 0, 2.00, 0, 0.00, 0, 0, 0, '29', 0, 'a:1:{i:29;d:1;}', 0, '', 0.00, 1),
(18, 29, '20150819214708563365', '20150819214714168436', '', '1003400169201508190659257489', 67, '', 1.00, 1.00, 2.00, 1, 1, 'a:4:{s:7:"address";s:6:"还差";s:8:"province";s:9:"天津市";s:4:"city";s:0:"";s:4:"area";s:9:"河西区";}', '彭', '13800138000', 'weixin', 'express', 0, 4, 1439992028, 1439992050, 1439992227, 0, 1439992235, 0, '', '', 0, 2.00, 0, 0.00, 0, 0, 0, '29', 0, 'a:1:{i:29;d:1;}', 0, '', 0.00, 1),
(19, 29, '20150819220928249483', '20150819220928249483', '', '', 66, '', 1.00, 1.00, 2.00, 1, 1, '', '', '', '', '', 0, 0, 1439993368, 0, 0, 0, 0, 0, '', '', 0, 0.00, 0, 0.00, 0, 0, 0, '29', 0, 'a:1:{i:29;d:1;}', 0, '', 0.00, 1),
(20, 29, '20150819221053307724', '20150819221315519011', '', '1008040169201508190659433874', 68, '', 1.00, 1.00, 2.00, 1, 1, 'a:4:{s:7:"address";s:6:"明明";s:8:"province";s:9:"山西省";s:4:"city";s:9:"长治市";s:4:"area";s:9:"长治县";}', '马旺', '18812256563', 'weixin', 'express', 0, 2, 1439993453, 1439993625, 0, 0, 0, 0, '', '', 0, 2.00, 0, 0.00, 0, 0, 0, '29', 0, 'a:1:{i:29;d:1;}', 0, '', 0.00, 1),
(21, 29, '20150819221244776120', '20150819221244776120', '', '', 67, '', 1.00, 1.00, 2.00, 1, 1, '', '', '', '', '', 0, 0, 1439993564, 0, 0, 0, 0, 0, '', '', 0, 0.00, 0, 0.00, 0, 0, 0, '29', 0, 'a:1:{i:29;d:1;}', 0, '', 0.00, 1),
(22, 29, '20150819221258722713', '20150819221258722713', '', '', 67, '', 1.00, 1.00, 2.00, 1, 1, '', '', '', '', '', 0, 0, 1439993578, 0, 0, 0, 0, 0, '', '', 0, 0.00, 0, 0.00, 0, 0, 0, '29', 0, 'a:1:{i:29;d:1;}', 0, '', 0.00, 1);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_order_check_log`
--

CREATE TABLE IF NOT EXISTS `pigcms_order_check_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT NULL COMMENT '订单id',
  `order_no` varchar(100) DEFAULT NULL COMMENT '订单号',
  `store_id` int(11) DEFAULT NULL COMMENT '被操作的商铺id',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `admin_uid` int(11) DEFAULT NULL COMMENT '操作人uid',
  `ip` bigint(20) DEFAULT NULL COMMENT '操作人ip',
  `timestamp` int(11) DEFAULT NULL COMMENT '记录的时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_order_check_log`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_order_coupon`
--

CREATE TABLE IF NOT EXISTS `pigcms_order_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券ID',
  `name` varchar(255) NOT NULL COMMENT '优惠券名称',
  `user_coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT 'user_coupon表id',
  `money` float(8,2) NOT NULL COMMENT '优惠券金额',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_order_coupon`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_order_package`
--

CREATE TABLE IF NOT EXISTS `pigcms_order_package` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `express_code` varchar(50) NOT NULL,
  `express_company` varchar(50) NOT NULL DEFAULT '' COMMENT '快递公司',
  `express_no` varchar(50) NOT NULL DEFAULT '' COMMENT '快递单号',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0未发货 1已发货 2已到店 3已签收',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `sign_name` varchar(30) NOT NULL DEFAULT '' COMMENT '签收人',
  `sign_time` int(11) NOT NULL DEFAULT '0' COMMENT '签收时间',
  `products` varchar(500) NOT NULL DEFAULT '' COMMENT '商品集合',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户订单id',
  PRIMARY KEY (`package_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单包裹' AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `pigcms_order_package`
--

INSERT INTO `pigcms_order_package` (`package_id`, `store_id`, `order_id`, `express_code`, `express_company`, `express_no`, `status`, `add_time`, `sign_name`, `sign_time`, `products`, `user_order_id`) VALUES
(1, 29, 18, '', '', '', 1, 0, '', 0, '59', 18),
(2, 29, 17, '', '', '', 1, 0, '', 0, '59', 17);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_order_product`
--

CREATE TABLE IF NOT EXISTS `pigcms_order_product` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单商品id',
  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单id',
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `sku_id` int(10) NOT NULL DEFAULT '0' COMMENT '库存id',
  `sku_data` text NOT NULL COMMENT '库存信息',
  `pro_num` int(10) NOT NULL DEFAULT '0' COMMENT '数量',
  `pro_price` decimal(10,2) NOT NULL,
  `pro_weight` float(10,2) NOT NULL COMMENT '每一个产品的重量，单位：克',
  `comment` text NOT NULL COMMENT '买家留言',
  `is_packaged` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已打包 0未打包 1已打包',
  `in_package_status` tinyint(1) NOT NULL COMMENT '在包裹里的状态 0未发货 1已发货 2已到店 3已签收',
  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销商品 0否 1是',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商id',
  `original_product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '源商品id',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户订单id',
  `is_present` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为赠品，1：是，0：否',
  `is_comment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已评论，1：是，0：否',
  PRIMARY KEY (`pigcms_id`),
  KEY `order_id` (`order_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `sku_id` (`sku_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单商品' AUTO_INCREMENT=23 ;

--
-- 导出表中的数据 `pigcms_order_product`
--

INSERT INTO `pigcms_order_product` (`pigcms_id`, `order_id`, `product_id`, `sku_id`, `sku_data`, `pro_num`, `pro_price`, `pro_weight`, `comment`, `is_packaged`, `in_package_status`, `is_fx`, `supplier_id`, `original_product_id`, `user_order_id`, `is_present`, `is_comment`) VALUES
(14, 14, 59, 0, '', 1, 1.00, 0.00, '', 0, 0, 0, 29, 59, 14, 0, 0),
(15, 15, 59, 0, '', 1, 1.00, 0.00, '', 0, 0, 0, 29, 59, 15, 0, 0),
(16, 16, 59, 0, '', 1, 1.00, 0.00, '', 0, 0, 0, 29, 59, 16, 0, 0),
(17, 17, 59, 0, '', 1, 1.00, 0.00, '', 1, 1, 0, 29, 59, 17, 0, 0),
(18, 18, 59, 0, '', 1, 1.00, 0.00, '', 1, 1, 0, 29, 59, 18, 0, 0),
(19, 19, 59, 0, '', 1, 1.00, 0.00, '', 0, 0, 0, 29, 59, 19, 0, 0),
(20, 20, 59, 0, '', 1, 1.00, 0.00, '', 0, 0, 0, 29, 59, 20, 0, 0),
(21, 21, 59, 0, '', 1, 1.00, 0.00, '', 0, 0, 0, 29, 59, 21, 0, 0),
(22, 22, 59, 0, '', 1, 1.00, 0.00, '', 0, 0, 0, 29, 59, 22, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_order_reward`
--

CREATE TABLE IF NOT EXISTS `pigcms_order_reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单表ID',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `rid` int(11) NOT NULL COMMENT '满减/送ID',
  `name` varchar(255) NOT NULL COMMENT '活动名称',
  `content` text NOT NULL COMMENT '描述序列化数组',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单优惠表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_order_reward`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_order_trade`
--

CREATE TABLE IF NOT EXISTS `pigcms_order_trade` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `third_data` text NOT NULL,
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='交易支付返回消息详细数据' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_order_trade`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_platform`
--

CREATE TABLE IF NOT EXISTS `pigcms_platform` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `info` varchar(500) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `key` varchar(50) NOT NULL COMMENT '关键词',
  `url` varchar(200) NOT NULL COMMENT '外链url',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='首页回复配置' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_platform`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_postage_template`
--

CREATE TABLE IF NOT EXISTS `pigcms_postage_template` (
  `tpl_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '邮费模板id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `tpl_name` varchar(100) NOT NULL DEFAULT '' COMMENT '模板名称',
  `tpl_area` varchar(10000) NOT NULL COMMENT '模板配送区域',
  `last_time` int(11) NOT NULL,
  `copy_id` int(11) NOT NULL,
  PRIMARY KEY (`tpl_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='邮费模板' AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `pigcms_postage_template`
--

INSERT INTO `pigcms_postage_template` (`tpl_id`, `store_id`, `tpl_name`, `tpl_area`, `last_time`, `copy_id`) VALUES
(1, 29, '包邮', '110000&120000&130000&230000&340000&350000&360000&370000&410000&420000&510000&620000&630000&640000&650000,0,0.00,0,0.00', 1439991069, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_present`
--

CREATE TABLE IF NOT EXISTS `pigcms_present` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) NOT NULL COMMENT '添加时间',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `name` varchar(255) NOT NULL COMMENT '赠品名称',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '赠品开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '赠品结束时间',
  `expire_date` int(11) NOT NULL DEFAULT '0' COMMENT '领取有效期，此只对虚拟产品,保留字段',
  `expire_number` int(11) NOT NULL DEFAULT '0' COMMENT '领取限制，此只对虚拟产品，保留字段',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '领取次数',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效，1：有效，0：无效，',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`,`start_time`,`end_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赠品表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_present`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_present_product`
--

CREATE TABLE IF NOT EXISTS `pigcms_present_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '赠品表ID',
  `product_id` int(11) NOT NULL COMMENT '产品表ID',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赠品产品列表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_present_product`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product`
--

CREATE TABLE IF NOT EXISTS `pigcms_product` (
  `product_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `category_fid` int(11) NOT NULL,
  `category_id` int(10) NOT NULL DEFAULT '0' COMMENT '分类id',
  `group_id` int(10) NOT NULL DEFAULT '0' COMMENT '分组id',
  `name` varchar(300) NOT NULL DEFAULT '' COMMENT '商品名称',
  `sale_way` char(1) NOT NULL DEFAULT '0' COMMENT '出售方式 0一口价 1拍卖',
  `buy_way` char(1) NOT NULL DEFAULT '1' COMMENT '购买方式 1店内购买 0店外购买',
  `type` char(1) NOT NULL DEFAULT '0' COMMENT '商品类型 0实物 1虚拟',
  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `original_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `weight` float(10,2) NOT NULL COMMENT '产品重量，单位：克',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '商品编码',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '商品主图',
  `image_size` varchar(200) NOT NULL,
  `postage_type` char(1) NOT NULL DEFAULT '0' COMMENT '邮费类型 0统计邮费 1邮费模板 ',
  `postage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '邮费',
  `postage_template_id` int(10) NOT NULL DEFAULT '0' COMMENT '邮费模板',
  `buyer_quota` int(5) NOT NULL DEFAULT '0' COMMENT '买家限购',
  `allow_discount` char(1) NOT NULL DEFAULT '1' COMMENT '参加会员折扣',
  `invoice` char(1) NOT NULL DEFAULT '0' COMMENT '发票 0无 1有',
  `warranty` char(1) NOT NULL DEFAULT '0' COMMENT '保修 0无 1有',
  `sold_time` int(11) NOT NULL DEFAULT '0' COMMENT '开售时间 0立即开售',
  `sales` int(10) NOT NULL DEFAULT '0' COMMENT '商品销量',
  `show_sku` char(1) NOT NULL DEFAULT '1' COMMENT '显示库存 0 不显示 1显示',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 0仓库中 1上架 2 删除',
  `date_added` varchar(20) NOT NULL DEFAULT '0' COMMENT '添加日期',
  `soldout` char(1) NOT NULL DEFAULT '0' COMMENT '售完 0未售完 1已售完',
  `pv` int(10) NOT NULL DEFAULT '0' COMMENT '商品浏览量',
  `uv` int(10) NOT NULL DEFAULT '0' COMMENT '商品浏览人数',
  `buy_url` varchar(200) NOT NULL DEFAULT '' COMMENT '外部购买地址',
  `intro` varchar(300) NOT NULL DEFAULT '' COMMENT '商品简介',
  `info` text NOT NULL COMMENT '商品描述',
  `has_custom` tinyint(4) NOT NULL COMMENT '有没有自定义文本',
  `has_category` tinyint(4) NOT NULL COMMENT '有没有商品分组',
  `properties` text NOT NULL COMMENT '商品属性',
  `has_property` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有商品属性 0否 1是',
  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销商品',
  `fx_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分销类型 0全网分销 1排他分销',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价格',
  `min_fx_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销最低价格',
  `max_fx_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销最高价格',
  `is_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商家推荐',
  `source_product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销来源商品id',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商店铺id',
  `delivery_address_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址 0为买家地址，大于0为分销商地址',
  `last_edit_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  `original_product_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销原始id,同一商品各分销商相同',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_fx_setting` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已设置分销信息',
  `collect` int(11) unsigned NOT NULL COMMENT '收藏数',
  `attention_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注数',
  `drp_profit` decimal(11,0) unsigned NOT NULL DEFAULT '0' COMMENT '商品分销利润总额',
  `drp_seller_qty` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商数量(被分销次数)',
  `drp_sale_qty` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商品销量',
  `unified_price_setting` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '供货商统一定价',
  `drp_level_1_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品价格',
  `drp_level_2_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品价格',
  `drp_level_3_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品价格',
  `drp_level_1_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品成本价格',
  `drp_level_2_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品成本价格',
  `drp_level_3_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品成本价格',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否热门 0否 1是',
  PRIMARY KEY (`product_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE,
  KEY `postage_template_id` (`postage_template_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品' AUTO_INCREMENT=89 ;

--
-- 导出表中的数据 `pigcms_product`
--

INSERT INTO `pigcms_product` (`product_id`, `uid`, `store_id`, `category_fid`, `category_id`, `group_id`, `name`, `sale_way`, `buy_way`, `type`, `quantity`, `price`, `original_price`, `weight`, `code`, `image`, `image_size`, `postage_type`, `postage`, `postage_template_id`, `buyer_quota`, `allow_discount`, `invoice`, `warranty`, `sold_time`, `sales`, `show_sku`, `status`, `date_added`, `soldout`, `pv`, `uv`, `buy_url`, `intro`, `info`, `has_custom`, `has_category`, `properties`, `has_property`, `is_fx`, `fx_type`, `cost_price`, `min_fx_price`, `max_fx_price`, `is_recommend`, `source_product_id`, `supplier_id`, `delivery_address_id`, `last_edit_time`, `original_product_id`, `sort`, `is_fx_setting`, `collect`, `attention_num`, `drp_profit`, `drp_seller_qty`, `drp_sale_qty`, `unified_price_setting`, `drp_level_1_price`, `drp_level_2_price`, `drp_level_3_price`, `drp_level_1_cost_price`, `drp_level_2_cost_price`, `drp_level_3_cost_price`, `is_hot`) VALUES
(53, 60, 0, 3, 17, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(54, 60, 0, 3, 17, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(55, 60, 0, 3, 17, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(56, 60, 0, 3, 18, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(57, 60, 0, 3, 19, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(42, 60, 0, 3, 13, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(43, 60, 0, 3, 13, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(44, 60, 0, 3, 14, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(45, 60, 0, 3, 14, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(46, 60, 0, 3, 14, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', 'a:0:{}', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(47, 60, 0, 3, 15, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(48, 60, 0, 3, 15, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(49, 60, 0, 3, 15, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(50, 60, 0, 3, 16, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(51, 60, 0, 3, 16, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(52, 60, 0, 3, 16, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(41, 60, 0, 3, 13, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(58, 63, 27, 64, 72, 0, '远亮神器', '0', '1', '0', 99, 1.00, 99.00, 0.00, '9453', 'images/000/000/027/201508/55d4819fb0587.png', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439990209', '0', 0, 0, '', '', '', 1, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(59, 64, 29, 11, 62, 0, '测试', '0', '1', '0', 97, 1.00, 0.00, 0.00, '', 'images/000/000/029/201508/55d483b4030ad.JPG', 'a:2:{s:5:"width";s:3:"747";s:6:"height";s:3:"422";}', '0', 1.00, 0, 0, '0', '0', '0', 0, 3, '1', '1', '1439990723', '0', 30, 0, '', '', '<p><img src="http://d.mz868.net/upload/images/000/000/029/201508/55d483b4030ad.JPG"/><img src="http://d.mz868.net/upload/images/000/000/029/201508/55d483b4030ad.JPG"/><img src="http://d.mz868.net/upload/images/000/000/029/201508/55d483b4030ad.JPG"/></p>', 0, 1, '', 0, 1, 0, 1.00, 3.00, 10.00, 1, 0, 0, 0, 1439993337, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(60, 69, 0, 3, 22, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(61, 69, 0, 3, 22, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(62, 69, 0, 3, 22, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(63, 62, 0, 3, 23, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(64, 62, 0, 3, 23, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(65, 62, 0, 3, 23, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(66, 61, 0, 3, 24, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(67, 61, 0, 3, 24, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(68, 61, 0, 3, 24, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(69, 72, 0, 3, 25, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(70, 72, 0, 3, 25, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(71, 72, 0, 3, 25, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(72, 72, 0, 3, 26, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(73, 72, 0, 3, 26, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(74, 72, 0, 3, 26, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(75, 75, 0, 3, 27, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(76, 75, 0, 3, 27, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(77, 75, 0, 3, 27, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(78, 75, 35, 39, 42, 0, '111', '0', '1', '0', 1, 2.00, 0.00, 0.00, '11', 'images/000/000/035/200108/3b85fb2da037a.gif', '', '0', 1.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '998636341', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(79, 79, 0, 3, 29, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(80, 79, 0, 3, 29, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(81, 79, 0, 3, 29, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(82, 79, 0, 3, 30, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(83, 79, 0, 3, 30, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(84, 79, 0, 3, 30, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(85, 79, 37, 1, 2, 0, '狗扑源码', '0', '1', '0', 1111, 11111.00, 0.00, 0.00, '', 'images/000/000/037/201509/560976652ccbb.jpg', 'a:2:{s:5:"width";s:4:"1600";s:6:"height";s:3:"900";}', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1443460718', '0', 2, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(86, 0, 0, 3, 32, 0, '餐饮外卖1', '0', '1', '0', 100, 10.00, 0.00, 0.00, '', 'images/eg1.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003015', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(87, 0, 0, 3, 32, 0, '餐饮外卖2', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg2.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003109', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
(88, 0, 0, 3, 32, 0, '餐饮外卖3', '0', '1', '0', 10, 10.00, 0.00, 0.00, '', 'images/eg3.jpg', '', '0', 0.00, 0, 0, '0', '0', '0', 0, 0, '1', '1', '1439003188', '0', 0, 0, '', '', '', 0, 1, '', 0, 0, 0, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product_category`
--

CREATE TABLE IF NOT EXISTS `pigcms_product_category` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `cat_desc` varchar(1000) NOT NULL COMMENT '描述',
  `cat_fid` int(10) NOT NULL DEFAULT '0' COMMENT '父类id',
  `cat_pic` varchar(50) NOT NULL COMMENT 'wap端栏目图片',
  `cat_pc_pic` varchar(50) NOT NULL COMMENT 'pc端栏目图片',
  `cat_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `cat_sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序，值越大优前',
  `cat_path` varchar(1000) NOT NULL,
  `cat_level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `filter_attr` varchar(255) NOT NULL COMMENT '拥有的属性id 用,号分割',
  `tag_str` varchar(1024) NOT NULL COMMENT '标签列表，每个tag_id之间用逗号分割',
  `cat_parent_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '父类状态',
  PRIMARY KEY (`cat_id`),
  KEY `parent_category_id` (`cat_fid`) USING BTREE,
  KEY `cat_sort` (`cat_sort`) USING BTREE,
  KEY `cat_name` (`cat_name`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品分类' AUTO_INCREMENT=101 ;

--
-- 导出表中的数据 `pigcms_product_category`
--

INSERT INTO `pigcms_product_category` (`cat_id`, `cat_name`, `cat_desc`, `cat_fid`, `cat_pic`, `cat_pc_pic`, `cat_status`, `cat_sort`, `cat_path`, `cat_level`, `filter_attr`, `tag_str`, `cat_parent_status`) VALUES
(1, '女人', '', 0, '', '', 1, 0, '0,01', 1, '', '', 1),
(2, '女装', '', 1, 'category/2015/04/55273743e28a7.jpg', '', 1, 0, '0,01,02', 2, '', '', 1),
(3, '女鞋', '', 1, 'category/2015/04/5527380cdee55.jpg', '', 1, 0, '0,01,03', 2, '', '', 1),
(4, '女包', '', 1, 'category/2015/04/5527383f1d1f5.jpg', '', 1, 0, '0,01,04', 2, '', '', 1),
(5, '男人', '', 0, '', '', 1, 0, '0,05', 1, '', '', 1),
(6, '男装', '', 5, 'category/2015/04/552738de81f42.jpg', '', 1, 0, '0,05,06', 2, '', '', 1),
(7, '男鞋', '', 5, 'category/2015/04/5527389296c4c.jpg', '', 1, 0, '0,05,07', 2, '', '', 1),
(8, '男包', '', 5, 'category/2015/04/552738b59a84a.jpg', '', 1, 0, '0,05,08', 2, '', '', 1),
(9, '女士内衣', '', 1, 'category/2015/04/552739159e37e.jpg', '', 1, 0, '0,01,09', 2, '', '', 1),
(10, '男士内衣', '', 5, 'category/2015/04/5527393c02fa7.jpg', '', 1, 0, '0,05,10', 2, '', '', 1),
(11, '食品酒水', '', 0, '', '', 1, 0, '0,11', 1, '', '', 1),
(12, '茶叶', '', 11, 'category/2015/04/552739cd6bbce.jpg', '', 1, 0, '0,11,12', 2, '', '', 1),
(13, '坚果炒货', '', 11, 'category/2015/04/552739ecaa0ad.jpg', '', 1, 0, '0,11,13', 2, '', '', 1),
(14, '零食', '', 11, 'category/2015/04/55273a09cb340.jpg', '', 1, 0, '0,11,14', 2, '', '', 1),
(15, '特产', '', 11, 'category/2015/04/55273b8f95804.png', '', 1, 0, '0,11,15', 2, '', '', 1),
(16, '家居服', '', 1, 'category/2015/04/55273be0a0771.jpg', '', 1, 0, '0,01,16', 2, '', '', 1),
(17, '服饰配件', '', 1, 'category/2015/04/55273c530d6a6.jpg', '', 1, 0, '0,01,17', 2, '', '', 1),
(18, '围巾手套', '', 1, 'category/2015/04/55273ce948db8.jpg', '', 1, 0, '0,01,18', 2, '', '', 1),
(19, '棉袜丝袜', '', 1, 'category/2015/04/55273d24949ae.jpg', '', 1, 0, '0,01,19', 2, '', '', 1),
(20, '个护美妆', '', 0, '', '', 1, 0, '0,20', 1, '', '', 1),
(21, '清洁', '', 20, 'category/2015/04/55273e9e9e563.png', '', 1, 0, '0,20,21', 2, '', '', 1),
(22, '护肤', '', 20, 'category/2015/04/55273eb645e0b.png', '', 1, 0, '0,20,22', 2, '', '', 1),
(23, '面膜', '', 20, 'category/2015/04/55273ee20197e.jpg', '', 1, 0, '0,20,23', 2, '', '', 1),
(24, '眼霜', '', 20, 'category/2015/04/55273f0606ebe.jpg', '', 1, 0, '0,20,24', 2, '', '', 1),
(25, '精华', '', 20, 'category/2015/04/55273f2f28827.jpg', '', 1, 0, '0,20,25', 2, '', '', 1),
(26, '防晒', '', 20, 'category/2015/04/55273f52c60f0.jpg', '', 1, 0, '0,20,26', 2, '', '', 1),
(27, '香水彩妆', '', 20, 'category/2015/04/55273f8ddc835.jpg', '', 1, 0, '0,20,27', 2, '', '', 1),
(28, '个人护理', '', 20, 'category/2015/04/55273fac76513.jpg', '', 1, 0, '0,20,28', 2, '', '', 1),
(29, '沐浴洗护', '', 20, 'category/2015/04/55273fe4c6469.jpg', '', 1, 0, '0,20,29', 2, '', '', 1),
(30, '母婴玩具', '', 0, '', '', 1, 0, '0,30', 1, '', '', 1),
(31, '孕妈食品', '', 30, 'category/2015/04/552740b099e46.jpg', '', 1, 0, '0,30,31', 2, '', '', 1),
(32, '妈妈护肤', '', 30, 'category/2015/04/552740dfca8dc.jpg', '', 1, 0, '0,30,32', 2, '', '', 1),
(33, '孕妇装', '', 30, 'category/2015/04/5527410749daa.jpg', '', 1, 0, '0,30,33', 2, '', '', 1),
(34, '宝宝用品', '', 30, 'category/2015/04/5527419a167ba.jpg', '', 1, 0, '0,30,34', 2, '', '', 1),
(35, '童装童鞋', '', 30, 'category/2015/04/552741cb6979e.jpg', '', 1, 0, '0,30,35', 2, '', '', 1),
(36, '童车童床', '', 30, 'category/2015/04/5527420d5643d.png', '', 1, 0, '0,30,36', 2, '', '', 1),
(37, '玩具乐器', '', 30, 'category/2015/04/5527423eb17bd.jpg', '', 1, 0, '0,30,37', 2, '', '', 1),
(38, '寝具服饰', '', 30, 'category/2015/04/55274283af0a4.jpg', '', 1, 0, '0,30,38', 2, '', '', 1),
(39, '家居百货', '', 0, '', '', 1, 0, '0,39', 1, '', '', 1),
(40, '家纺', '', 39, 'category/2015/04/552745a79931e.png', '', 1, 0, '0,39,40', 2, '', '', 1),
(41, '厨具', '', 39, 'category/2015/04/552745e700431.png', '', 1, 0, '0,39,41', 2, '', '', 1),
(42, '家用', '', 39, 'category/2015/04/55274acb138c9.jpg', '', 1, 0, '0,39,42', 2, '', '', 1),
(43, '收纳', '', 39, 'category/2015/04/5527462826195.jpg', '', 1, 0, '0,39,43', 2, '', '', 1),
(44, '家具', '', 39, 'category/2015/04/5527464a87c77.jpg', '', 1, 0, '0,39,44', 2, '', '', 1),
(45, '建材', '', 39, 'category/2015/04/5527466f6a0d6.jpg', '', 1, 0, '0,39,45', 2, '', '', 1),
(46, '纸品', '', 39, 'category/2015/04/552746ac0f269.jpg', '', 1, 0, '0,39,46', 2, '', '', 1),
(47, '女性护理', '', 1, 'category/2015/04/55274720db396.jpg', '', 1, 0, '0,01,47', 2, '', '', 1),
(49, '运动户外', '', 0, '', '', 1, 0, '0,49', 1, '', '', 1),
(50, '运动鞋包', '', 49, 'category/2015/04/552747be89089.jpg', '', 1, 0, '0,49,50', 2, '', '', 1),
(51, '运动服饰', '', 49, 'category/2015/04/552747d81ea2b.jpg', '', 1, 0, '0,49,51', 2, '', '', 1),
(52, '户外鞋服', '', 49, 'category/2015/04/552747ff766bf.jpg', '', 1, 0, '0,49,52', 2, '', '', 1),
(53, '户外装备', '', 49, 'category/2015/04/552748237f5d5.jpg', '', 1, 0, '0,49,53', 2, '', '', 1),
(54, '垂钓游泳', '', 49, 'category/2015/04/55274847891a5.jpg', '', 1, 0, '0,49,54', 2, '', '', 1),
(55, '体育健身', '', 49, 'category/2015/04/5527486189e62.jpg', '', 1, 0, '0,49,55', 2, '', '', 1),
(56, '骑行运动', '', 49, 'category/2015/04/5527487e2dac0.jpg', '', 1, 0, '0,49,56', 2, '', '', 1),
(57, '酒水', '', 11, 'category/2015/04/55274936e745d.png', '', 1, 0, '0,11,57', 2, '', '', 1),
(58, '水果', '', 11, 'category/2015/04/5527495bde3c1.png', '', 1, 0, '0,11,58', 2, '', '', 1),
(59, '生鲜', '', 11, 'category/2015/04/5527497f0b9d4.jpg', '', 1, 0, '0,11,59', 2, '', '', 1),
(60, '粮油', '', 11, 'category/2015/04/552749acec1d1.jpg', '', 1, 0, '0,11,60', 2, '', '', 1),
(61, '干货', '', 11, 'category/2015/04/552749dd835c5.jpg', '', 1, 0, '0,11,61', 2, '', '', 1),
(62, '饮料', '', 11, 'category/2015/04/55274a1d54e02.jpg', '', 1, 0, '0,11,62', 2, '', '', 1),
(63, '计生', '', 39, 'category/2015/04/55274b2f541fd.jpg', '', 1, 0, '0,39,63', 2, '', '', 1),
(64, '电脑数码', '', 0, '', '', 1, 0, '0,64', 1, '', '', 1),
(65, '手机', '', 64, 'category/2015/04/55275d3ebc545.jpg', '', 1, 0, '0,64,65', 2, '', '', 1),
(66, '手机配件', '', 64, 'category/2015/04/55275d663f0ae.png', '', 1, 0, '0,64,66', 2, '', '', 1),
(67, '电脑', '', 64, 'category/2015/04/55275da6169b7.jpg', '', 1, 0, '0,64,67', 2, '', '', 1),
(68, '平板', '', 64, 'category/2015/04/55275dbc4824a.jpg', '', 1, 0, '0,64,68', 2, '', '', 1),
(69, '电脑配件', '', 64, 'category/2015/04/55275df02c582.jpg', '', 1, 0, '0,64,69', 2, '', '', 1),
(70, '摄影', '', 64, 'category/2015/04/55275e0fbba9f.jpg', '', 1, 0, '0,64,70', 2, '', '', 1),
(71, '影音', '', 64, 'category/2015/04/55275e2f89c97.jpg', '', 1, 0, '0,64,71', 2, '', '', 1),
(72, '网络', '', 64, 'category/2015/04/55275e4eedc8a.jpg', '', 1, 0, '0,64,72', 2, '', '', 1),
(73, '办公', '', 64, 'category/2015/04/55275ea744bfc.jpg', '', 1, 0, '0,64,73', 2, '', '', 1),
(74, '电器', '', 39, 'category/2015/04/55275eed3b47c.png', '', 1, 0, '0,39,74', 2, '', '', 1),
(75, '手表饰品', '', 0, '', '', 1, 0, '0,75', 1, '', '', 1),
(76, '钟表', '', 75, 'category/2015/04/55275f39eb17e.jpg', '', 1, 0, '0,75,76', 2, '', '', 1),
(77, '饰品', '', 75, 'category/2015/04/55275f618cdd6.jpg', '', 1, 0, '0,75,77', 2, '', '', 1),
(78, '天然珠宝', '', 75, 'category/2015/04/55275fa4e1713.jpg', '', 1, 0, '0,75,78', 2, '', '', 1),
(79, '汽车用品', '', 0, '', '', 1, 0, '0,79', 1, '', '', 1),
(80, '汽车装饰', '', 79, 'category/2015/04/552760961dfa9.jpg', '', 1, 0, '0,79,80', 2, '', '', 1),
(81, '车载电器', '', 79, 'category/2015/04/552760140ba45.png', '', 1, 0, '0,79,81', 2, '', '', 1),
(82, '美容清洗', '', 79, 'category/2015/04/5527603514e1b.jpg', '', 1, 0, '0,79,82', 2, '', '', 1),
(83, '维修保养', '', 79, 'category/2015/04/55276054c30f7.png', '', 1, 0, '0,79,83', 2, '', '', 1),
(84, '安全自驾', '', 79, 'category/2015/04/5527607a693b0.png', '', 1, 0, '0,79,84', 2, '', '', 1),
(96, '旅行票务', '', 0, '', '', 1, 0, '0,96', 1, '', '', 1),
(97, '图书音像', '', 0, 'category/2015/08/55dab86000000.png', 'category/2015/08/', 1, 0, '0,97', 1, '', '', 1),
(90, '企业测试', '', 1, '', '', 1, 0, '0,01,90', 2, '', '', 1),
(95, '金融理财', '', 0, '', '', 1, 0, '0,95', 1, '', '', 1),
(94, '汽车配件', '', 0, '', '', 1, 0, '0,94', 1, '', '', 1),
(98, '厨卫用具', '', 0, '', '', 1, 0, '0,98', 1, '', '', 1),
(99, '厨卫用具', '', 0, '', '', 1, 0, '0,99', 1, '', '', 1),
(100, '狗扑源码', '', 0, '', '', 1, 0, '0,100', 1, '', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product_custom_field`
--

CREATE TABLE IF NOT EXISTS `pigcms_product_custom_field` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `field_name` varchar(30) NOT NULL DEFAULT '' COMMENT '自定义字段名称',
  `field_type` varchar(30) NOT NULL DEFAULT '' COMMENT '自定义字段类型',
  `multi_rows` tinyint(1) NOT NULL DEFAULT '0' COMMENT '多行 0 否 1 是',
  `required` tinyint(1) NOT NULL DEFAULT '0' COMMENT '必填 0 否 1是',
  PRIMARY KEY (`pigcms_id`),
  KEY `product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品自定义字段' AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `pigcms_product_custom_field`
--

INSERT INTO `pigcms_product_custom_field` (`pigcms_id`, `product_id`, `field_name`, `field_type`, `multi_rows`, `required`) VALUES
(1, 12, '留言', 'text', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product_group`
--

CREATE TABLE IF NOT EXISTS `pigcms_product_group` (
  `group_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品分组id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `group_name` varchar(50) NOT NULL COMMENT '分组名称',
  `is_show_name` char(1) NOT NULL DEFAULT '0' COMMENT '显示商品分组名称',
  `first_sort` varchar(30) NOT NULL DEFAULT '' COMMENT '商品排序',
  `second_sort` varchar(30) NOT NULL DEFAULT '' COMMENT '商品排序',
  `list_style_size` char(1) NOT NULL DEFAULT '0' COMMENT '列表大小 0大图 1小图 2一大两小 3详细列表',
  `list_style_type` char(1) NOT NULL DEFAULT '0' COMMENT '列表样式 0卡片样式 1瀑布流 2极简样式',
  `is_show_price` char(1) NOT NULL DEFAULT '1' COMMENT '显示价格',
  `is_show_product_name` char(1) NOT NULL DEFAULT '0' COMMENT '显示商品名 0不显示 1显示',
  `is_show_buy_button` char(1) NOT NULL DEFAULT '1' COMMENT '显示购买按钮',
  `buy_button_style` char(1) NOT NULL DEFAULT '1' COMMENT '购买按钮样式 1样式1 2样式2 3样式3 4 样式4',
  `group_label` varchar(300) NOT NULL DEFAULT '' COMMENT '商品标签简介',
  `product_count` int(10) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `has_custom` tinyint(1) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`group_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品分组' AUTO_INCREMENT=33 ;

--
-- 导出表中的数据 `pigcms_product_group`
--

INSERT INTO `pigcms_product_group` (`group_id`, `store_id`, `group_name`, `is_show_name`, `first_sort`, `second_sort`, `list_style_size`, `list_style_type`, `is_show_price`, `is_show_product_name`, `is_show_buy_button`, `buy_button_style`, `group_label`, `product_count`, `has_custom`, `add_time`) VALUES
(18, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(19, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(17, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(16, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(15, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(14, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(13, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(20, 27, '神器', '1', '0', '0', '2', '0', '1', '0', '1', '4', '', 1, 0, 1439990039),
(21, 29, '瞎填', '1', '0', '0', '2', '0', '1', '0', '1', '1', '', 1, 0, 1439990678),
(22, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(23, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(24, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(25, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(26, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(27, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(28, 35, '狗扑源码', '1', '0', '0', '2', '0', '1', '0', '1', '1', '<p>df狗扑源码论坛_gope.cn</p>', 1, 1, 1440398449),
(29, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(30, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225),
(31, 37, '狗扑源码', '1', '0', '0', '2', '0', '1', '0', '1', '1', '<p>狗扑源码</p>', 1, 0, 1443460666),
(32, 567, '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', 3, 0, 1439003225);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product_image`
--

CREATE TABLE IF NOT EXISTS `pigcms_product_image` (
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '商品图片',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `sort` (`sort`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品图片';

--
-- 导出表中的数据 `pigcms_product_image`
--

INSERT INTO `pigcms_product_image` (`product_id`, `image`, `sort`) VALUES
(58, 'images/000/000/027/201508/55d4819fb0587.png', 1),
(59, 'images/000/000/029/201508/55d483b4030ad.JPG', 1),
(78, 'images/000/000/035/200108/3b85fb2da037a.gif', 1),
(85, 'images/000/000/037/201509/560976652ccbb.jpg', 1);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product_property`
--

CREATE TABLE IF NOT EXISTS `pigcms_product_property` (
  `pid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品属性名' AUTO_INCREMENT=112 ;

--
-- 导出表中的数据 `pigcms_product_property`
--

INSERT INTO `pigcms_product_property` (`pid`, `name`) VALUES
(1, '尺寸'),
(2, '金重'),
(3, '机芯'),
(4, '适用'),
(5, '净含量'),
(6, '包装'),
(7, '款式'),
(8, '口味'),
(9, '产地'),
(10, '种类'),
(11, '内存'),
(12, '套餐'),
(13, '出行日期'),
(14, '出行人群'),
(15, '入住时段'),
(16, '房型'),
(17, '介质'),
(18, '开本'),
(19, '版本'),
(20, '类型（例如实体票,电子票）'),
(22, '有效期'),
(23, '乘客类型'),
(24, '伞面尺寸'),
(25, '儿童/青少年床尺寸'),
(26, '内裤尺码'),
(27, '出发日期'),
(28, '剩余保质期'),
(29, '佛珠尺寸'),
(30, '克重'),
(31, '型号'),
(32, '大小'),
(33, '大小描述'),
(34, '功率'),
(35, '吉祥图案'),
(36, '圆床尺寸'),
(37, '奶嘴规格'),
(38, '娃娃尺寸'),
(39, '安全套规格'),
(40, '宠物适用尺码'),
(41, '布尿裤尺码'),
(42, '帽围'),
(43, '床品尺寸'),
(44, '戒圈'),
(45, '户外帽尺码'),
(46, '户外手套尺码'),
(47, '手镯内径'),
(48, '方形地毯规格'),
(49, '毛色'),
(50, '洗车机容量'),
(51, '珍珠直径'),
(52, '珍珠颜色'),
(53, '瓷砖尺寸（平方毫米）'),
(54, '线号'),
(55, '床垫厚度'),
(56, '床垫规格'),
(57, '床尺寸'),
(58, '座垫套件数量'),
(59, '建议身高（尺码）'),
(60, '画布尺寸'),
(61, '画框尺寸'),
(62, '皮带长度'),
(63, '窗帘尺寸（宽X高)'),
(64, '笔芯颜色'),
(65, '粉粉份量'),
(66, '纸张规格'),
(67, '线材长度'),
(68, '线长'),
(69, '组合'),
(70, '绣布CT数'),
(71, '胸围尺码'),
(72, '胸垫尺码'),
(73, '自定义项'),
(74, '色温'),
(75, '花束直径'),
(76, '花盆规格'),
(77, '蛋糕尺寸'),
(78, '袜子尺码'),
(79, '规格尺寸'),
(80, '规格（粒/袋/ml/g）'),
(81, '贵金属成色'),
(82, '车用香水香味'),
(83, '适用年龄'),
(84, '适用床尺寸'),
(85, '适用户外项目'),
(86, '适用范围'),
(87, '适用规格'),
(88, '遮阳挡件数'),
(89, '邮轮房型'),
(90, '钓钩尺寸'),
(91, '钻石净度'),
(92, '钻石重量'),
(93, '钻石颜色'),
(94, '链子长度'),
(95, '锅具尺寸'),
(96, '锅身直径尺寸'),
(97, '镜子尺寸'),
(98, '镜片适合度数'),
(99, '镶嵌材质'),
(100, '长度'),
(101, '防潮垫大小'),
(102, '雨刷尺寸'),
(103, '鞋码'),
(104, '鞋码（内长）'),
(105, '香味'),
(106, '颜色'),
(107, '尺码'),
(108, '上市时间'),
(109, '容量'),
(110, '系列'),
(111, '规格');

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product_property_value`
--

CREATE TABLE IF NOT EXISTS `pigcms_product_property_value` (
  `vid` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品属性值id',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '商品属性名id',
  `value` varchar(50) NOT NULL DEFAULT '' COMMENT '商品属性值',
  `image` varchar(255) NOT NULL COMMENT '属性对应图片',
  PRIMARY KEY (`vid`),
  KEY `pid` (`pid`) USING BTREE,
  KEY `pid_2` (`pid`,`value`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品属性值' AUTO_INCREMENT=1401 ;

--
-- 导出表中的数据 `pigcms_product_property_value`
--

INSERT INTO `pigcms_product_property_value` (`vid`, `pid`, `value`, `image`) VALUES
(1, 106, '紫色', ''),
(2, 106, '绿色', ''),
(3, 106, '红色', ''),
(4, 106, '黑色', ''),
(5, 107, 'S', ''),
(6, 107, 'M', ''),
(7, 107, 'L', ''),
(8, 107, 'XL', ''),
(9, 107, 'XXL', ''),
(10, 106, '黑红花', ''),
(11, 106, '蓝色花', ''),
(12, 106, '红色花', ''),
(13, 106, '红', ''),
(14, 106, '黑', ''),
(15, 106, '蓝', ''),
(16, 107, 'X', ''),
(17, 106, '灰', ''),
(18, 106, '白', ''),
(19, 1, 'X', ''),
(20, 1, 'L', ''),
(21, 1, 'XL', ''),
(22, 106, '绿', ''),
(23, 1, '1尺', ''),
(24, 1, '大', ''),
(25, 1, '4.7寸', ''),
(26, 3, '64 位架构的 A8 芯片 M8 运动协处理器', ''),
(27, 109, '16G', ''),
(28, 19, '8.1.1', ''),
(29, 11, '8G', ''),
(30, 11, '16G', ''),
(31, 11, '32G', ''),
(32, 106, '银色', ''),
(33, 106, '土豪金', ''),
(34, 106, '1', ''),
(35, 106, '更换', ''),
(36, 106, '好看', ''),
(37, 106, 'vg', ''),
(38, 1, 'm', ''),
(39, 1, 'xxl', ''),
(40, 1, 'xxxl', ''),
(41, 1, 'xxxxxl', ''),
(42, 1, '158', ''),
(43, 1, '160', ''),
(44, 1, '162', ''),
(45, 1, '164', ''),
(46, 1, '166', ''),
(47, 11, '16', ''),
(48, 11, '68', ''),
(49, 11, '120G', ''),
(50, 3, '123456', ''),
(51, 106, '雪晶白', ''),
(52, 106, '星砖黑', ''),
(53, 106, '铂光金', ''),
(54, 19, 'GALAXY S6 Edge SM-G9250', ''),
(55, 12, '官方标配', ''),
(56, 19, '中国大陆', ''),
(57, 106, '深度灰色', ''),
(58, 106, '金色', ''),
(59, 11, '64G', ''),
(60, 11, '128G', ''),
(61, 106, '深灰色', ''),
(62, 106, '深空灰', ''),
(63, 19, '公开版16G', ''),
(64, 19, '公开版（16G）', ''),
(65, 19, '公开版（64G）', ''),
(66, 19, '公开版（128G）', ''),
(67, 19, '移动4G版（16G）', ''),
(68, 19, '移动4G版（64G）', ''),
(69, 106, '香槟金', ''),
(70, 106, '极光白', ''),
(71, 19, 'X5MAx+ 双卡双模', ''),
(72, 19, 'X5MAx+6 双卡多模', ''),
(73, 19, 'X5MAx+ 双卡多模', ''),
(74, 11, '16GB', ''),
(75, 19, 'X5S L 双卡多模', ''),
(76, 19, 'X5V 双卡多模', ''),
(77, 5, '50g', ''),
(78, 2, '15', ''),
(79, 2, '16', ''),
(80, 2, '18', ''),
(81, 3, '19', ''),
(82, 3, '1', ''),
(83, 3, '74555', ''),
(84, 3, '3232', ''),
(85, 3, '3', ''),
(86, 1, '155cm', ''),
(87, 62, '98', ''),
(88, 4, '26', ''),
(89, 5, '150', ''),
(90, 27, '2015年5月9日', ''),
(91, 1, 'f', ''),
(92, 1, 'd', ''),
(93, 1, 'e', ''),
(94, 1, 'g', ''),
(95, 1, 'h', ''),
(96, 20, 'd', ''),
(97, 20, '1', ''),
(98, 1, '1', ''),
(99, 1, '12', ''),
(100, 1, 'fd', ''),
(101, 1, '2', ''),
(102, 1, '3', ''),
(103, 1, '4', ''),
(104, 107, 'MM', ''),
(105, 5, '100', ''),
(106, 9, '内蒙', ''),
(107, 22, '9个月', ''),
(108, 11, '3', ''),
(109, 11, '3G', ''),
(110, 9, '深圳', ''),
(111, 73, '品牌', ''),
(112, 73, '保质期', ''),
(113, 20, '四件套', ''),
(114, 1, '1.5m（5英尺）床', ''),
(115, 7, '折叠席', ''),
(116, 10, '凉席套件', ''),
(117, 86, '组合沙发', ''),
(118, 111, '直径：30CM', ''),
(119, 31, 'PC30S3', ''),
(120, 17, '合金', ''),
(121, 99, '304不锈钢', ''),
(122, 7, '现代简约', ''),
(123, 10, '台式电脑桌', ''),
(124, 4, '客厅', ''),
(125, 7, '时尚简约', ''),
(126, 10, '装饰台灯', ''),
(127, 10, '抽纸，手帕纸', ''),
(128, 80, '200抽，组合装', ''),
(129, 1, '58-60英寸', ''),
(130, 10, 'LED电视（主流）', ''),
(131, 4, '客厅电视', ''),
(132, 7, '简约纯色，条纹格子，几何图形', ''),
(133, 10, '枕套', ''),
(134, 73, '面料：全棉', ''),
(135, 79, '48*74cm', ''),
(136, 1, '48*74cm', ''),
(137, 10, '长方形枕头', ''),
(138, 55, '10cm', ''),
(139, 57, '1.5mx2.0m', ''),
(140, 4, '门厅', ''),
(141, 1, '大小', ''),
(142, 0, '', ''),
(143, 6, '单件装', ''),
(144, 83, '0-8岁', ''),
(145, 80, '120g', ''),
(146, 80, '50g', ''),
(147, 79, '50X50cm', ''),
(148, 7, '宽松型', ''),
(149, 80, '30ml', ''),
(150, 106, '玫红色', ''),
(151, 106, '黄色', ''),
(152, 106, '深蓝色', ''),
(153, 106, '白色', ''),
(154, 80, '60g', ''),
(155, 106, '卡其色', ''),
(156, 106, '粉色', ''),
(157, 106, '浅灰色', ''),
(158, 80, '44ml', ''),
(159, 80, '10片', ''),
(160, 80, '80g', ''),
(161, 106, '藏青', ''),
(162, 106, '裸色', ''),
(163, 80, '100g', ''),
(164, 106, '粉红色', ''),
(165, 1, '18cm*15.8cm', ''),
(166, 107, 'XXXL', ''),
(167, 106, '紫金红/土豪金', ''),
(168, 106, '咖色格子', ''),
(169, 106, '藏蓝格子', ''),
(170, 80, '5袋', ''),
(171, 80, '700ml', ''),
(172, 106, '宝蓝色', ''),
(173, 109, '501-600ml', ''),
(174, 80, '500ml', ''),
(175, 9, '中国大陆', ''),
(176, 80, '1800-2000ml', ''),
(177, 80, '250ml', ''),
(178, 106, '桔色', ''),
(179, 80, '180g', ''),
(180, 17, 'SD/SDHC卡', ''),
(181, 9, '台湾', ''),
(182, 106, '蓝色', ''),
(183, 86, '家用', ''),
(184, 107, '35', ''),
(185, 107, '36', ''),
(186, 107, '37', ''),
(187, 107, '38', ''),
(188, 107, '39', ''),
(189, 109, '600ml以上', ''),
(190, 107, '34', ''),
(191, 107, '40', ''),
(192, 107, '41', ''),
(193, 106, '驼色', ''),
(194, 80, '30粒', ''),
(195, 109, '30L—39L', ''),
(196, 106, '粉红', ''),
(197, 106, '粉红白', ''),
(198, 106, '灰蓝', ''),
(199, 106, '灰兰', ''),
(200, 73, '功率：1000W~1399W', ''),
(201, 80, '5件套', ''),
(202, 107, '33', ''),
(203, 111, '120*100*190cm', ''),
(204, 109, '2人', ''),
(205, 34, '1500W', ''),
(206, 106, '绿色花', ''),
(207, 106, '条纹白', ''),
(208, 106, '米白', ''),
(209, 1, '是', ''),
(210, 106, '深红色', ''),
(211, 106, '深蓝', ''),
(212, 106, '深棕', ''),
(213, 106, '橙色', ''),
(214, 106, '粉', ''),
(215, 106, '虎斑', ''),
(216, 106, '嫩黄', ''),
(217, 106, '酒红', ''),
(218, 106, '灰色', ''),
(219, 80, '800g', ''),
(220, 106, '华丽晚礼', ''),
(221, 106, '清凉海滩', ''),
(222, 110, '四件套', ''),
(223, 110, '六件套', ''),
(224, 110, '七件套', ''),
(225, 110, '八件套', ''),
(226, 20, '迷你型', ''),
(227, 20, '常规型', ''),
(228, 1, '12寸绿色', ''),
(229, 1, '12寸蓝色', ''),
(230, 1, '14寸绿色', ''),
(231, 1, '14寸蓝色', ''),
(232, 1, '12寸红色', ''),
(233, 7, '手套', ''),
(234, 106, '蜂蜜色', ''),
(235, 106, '桃木色', ''),
(236, 11, '运行内存:2GB RAM', ''),
(237, 11, '机身内存:16GB ROM', ''),
(238, 108, '2014年11月', ''),
(239, 106, '橘色', ''),
(240, 107, '70A/32A', ''),
(241, 107, '70B/32B', ''),
(242, 11, '机身内存:16GB ROM 运行内存:2GB RAM', ''),
(243, 107, '75B/34B', ''),
(244, 107, '75C/34C', ''),
(245, 106, '香槟色', ''),
(246, 1, '110', ''),
(247, 1, '120', ''),
(248, 1, '130', ''),
(249, 1, '140', ''),
(250, 106, '天蓝色', ''),
(251, 106, '藏青色', ''),
(252, 107, 'A', ''),
(253, 107, 'B', ''),
(254, 107, 'C', ''),
(255, 107, 'D', ''),
(256, 7, '厚款', ''),
(257, 7, '薄款', ''),
(258, 107, '110', ''),
(259, 107, '120', ''),
(260, 107, '130', ''),
(261, 107, '140', ''),
(262, 107, '150', ''),
(263, 107, '32B/70B', ''),
(264, 107, '34B/75B', ''),
(265, 106, '枣红', ''),
(266, 107, '36B/80B', ''),
(267, 107, '38B/85B', ''),
(268, 106, '冰湖蓝', ''),
(269, 106, '黑曜石', ''),
(270, 1, '40*24*32MM', ''),
(271, 106, '黑色,白色,活力黑黄,黑绿色,魅力黑蓝,浪漫玫红', ''),
(272, 31, 'QY7', ''),
(273, 106, '湖蓝色', ''),
(274, 107, '120CM', ''),
(275, 107, '130CM', ''),
(276, 107, '140CM', ''),
(277, 107, '150CM', ''),
(278, 106, '灰色条纹', ''),
(279, 106, '四叶草软底', ''),
(280, 1, '21.5英寸采用 IPS 技术的LED 背光显示屏', ''),
(281, 106, '玫红', ''),
(282, 107, '160/85（S)', ''),
(283, 107, '170/95(L)', ''),
(284, 106, '肤色', ''),
(285, 1, '21英寸,速度1.4GHz', ''),
(286, 1, '21英寸,速度2.9GHz', ''),
(287, 1, '27英寸,速度3.2GHz', ''),
(288, 1, '27英寸,速度3.4GHz', ''),
(289, 1, '27英寸,速度1600MHz DDR3', ''),
(290, 106, '紫罗兰', ''),
(291, 106, '米色', ''),
(292, 80, '40g', ''),
(293, 31, 'MF432CH/A', ''),
(294, 31, 'MD531CH/A', ''),
(295, 106, '深空灰色/白色', ''),
(296, 106, '深空灰色', ''),
(297, 80, '192ml', ''),
(298, 106, '棕色', ''),
(299, 106, '浅棕色', ''),
(300, 80, '200ml', ''),
(301, 106, '米白色', ''),
(302, 106, '酒红色', ''),
(303, 106, '肉粉色', ''),
(304, 106, '玫瑰红色', ''),
(305, 31, '中号', ''),
(306, 7, '害羞女孩', ''),
(307, 7, '与狼共舞', ''),
(308, 31, '超大号标配', ''),
(309, 31, '中号基本套餐', ''),
(310, 31, '超大号基本套餐', ''),
(311, 106, '果粉', ''),
(312, 106, '经典蓝', ''),
(313, 106, '蓝白色', ''),
(314, 107, '28', ''),
(315, 107, '29', ''),
(316, 107, '30', ''),
(317, 107, '31', ''),
(318, 107, '32', ''),
(319, 80, '400ml', ''),
(320, 106, '军绿', ''),
(321, 106, '桔红', ''),
(322, 106, '卡其', ''),
(323, 107, '42', ''),
(324, 107, '43', ''),
(325, 107, '45', ''),
(326, 10, '多平台散热器', ''),
(327, 10, '水冷', ''),
(328, 6, '4瓶装', ''),
(329, 9, '马来西亚', ''),
(330, 11, '无内存版', ''),
(331, 11, '内置16G内存版', ''),
(332, 106, '黑色/白色', ''),
(333, 106, '杏色', ''),
(334, 80, '1.5g*26袋', ''),
(335, 106, '浅绿', ''),
(336, 106, '咖啡', ''),
(337, 107, '44', ''),
(338, 34, '<=5W', ''),
(339, 80, '260.0g', ''),
(340, 111, '170*56*32mm', ''),
(341, 106, '魅力黑', ''),
(342, 80, '64g', ''),
(343, 106, '黑红', ''),
(344, 86, '通用', ''),
(345, 106, '月光银', ''),
(346, 106, '酷炭黑', ''),
(347, 80, '45g*2袋', ''),
(348, 106, '灰黄', ''),
(349, 9, '印尼', ''),
(350, 106, '军绿色', ''),
(351, 80, '336g', ''),
(352, 31, 'S-35', ''),
(353, 31, 'S-36', ''),
(354, 31, 'S-52', ''),
(355, 106, '黑湖水蓝', ''),
(356, 106, '黑荧光绿', ''),
(357, 106, '全黑', ''),
(358, 106, '宝蓝白', ''),
(359, 80, '160g', ''),
(360, 106, '宝石蓝', ''),
(361, 106, '绚丽蓝', ''),
(362, 106, '绚丽紫', ''),
(363, 106, '天空蓝', ''),
(364, 106, '宝石蓝,天空蓝,绚丽紫', ''),
(365, 19, '经典版', ''),
(366, 19, '无限版', ''),
(367, 106, '麦黄色', ''),
(368, 106, '红棕色', ''),
(369, 106, '棕疯马色', ''),
(370, 106, '紫', ''),
(371, 1, '7英寸', ''),
(372, 19, '至尊版灰', ''),
(373, 19, '至尊版黄', ''),
(374, 11, '公开版16G', ''),
(375, 11, '公开版64G ROM', ''),
(376, 11, '公开版12G ROM', ''),
(377, 11, '公开版128G ROM', ''),
(378, 106, '中国红', ''),
(379, 106, '精灵蓝', ''),
(380, 106, '黄', ''),
(381, 106, '咖色', ''),
(382, 106, '粉色,白色,黄色', ''),
(383, 106, '深海蓝', ''),
(384, 106, '智能红', ''),
(385, 106, '经典银', ''),
(386, 7, '超级光驱,黑色', ''),
(387, 7, '刀锋超薄刻录机', ''),
(388, 106, '黑配灰', ''),
(389, 106, '黑配蓝', ''),
(390, 86, '家庭路由', ''),
(391, 19, '优酷盒子', ''),
(392, 19, '手柄套装版', ''),
(393, 20, '黑白激光', ''),
(394, 86, '打印 扫描 复印 传真', ''),
(395, 106, '咖啡色', ''),
(396, 7, '轻便型手动装订机', ''),
(397, 7, '大台板畅销型装订机', ''),
(398, 106, '古铜金砂', ''),
(399, 7, '爆款激光定位装订机', ''),
(400, 106, '西瓜红', ''),
(401, 106, '牛仔蓝', ''),
(402, 106, '天然绿', ''),
(403, 106, '浅咖色', ''),
(404, 1, '32cun', ''),
(405, 1, '42寸', ''),
(406, 7, '蓝光', ''),
(407, 7, '网络', ''),
(408, 7, '智能', ''),
(409, 80, '240ML', ''),
(410, 12, '年', ''),
(411, 10, '冰冻', ''),
(412, 80, '20g', ''),
(413, 80, '113g', ''),
(414, 106, '灰蓝色', ''),
(415, 106, '橘红色', ''),
(416, 106, '深灰色-女', ''),
(417, 106, '伊甸粉色-女', ''),
(418, 106, '黑色-男', ''),
(419, 106, '铁蓝灰色-男', ''),
(420, 106, '黑绿', ''),
(421, 106, '母绿', ''),
(422, 106, '蓝黑', ''),
(423, 106, '50SD9', ''),
(424, 106, '50FD9', ''),
(425, 106, '50FC99', ''),
(426, 106, '50FC821', ''),
(427, 106, '深棕色', ''),
(428, 106, '荧光绿', ''),
(429, 1, '31.5*17.5*13.5cm', ''),
(430, 106, '象牙白', ''),
(431, 86, '浴室', ''),
(432, 86, '办公室', ''),
(433, 86, '客厅', ''),
(434, 86, '浴室，办公室，客厅', ''),
(435, 107, '165', ''),
(436, 107, '170', ''),
(437, 107, '175', ''),
(438, 107, '180', ''),
(439, 107, '185', ''),
(440, 1, '49.5*24*80cm', ''),
(441, 1, '49.5', ''),
(442, 1, '49.5*24*80', ''),
(443, 106, '青绿色+', ''),
(444, 106, '青绿色+白色', ''),
(445, 106, '浆果红', ''),
(446, 106, '基础黑', ''),
(447, 111, '2个大号+2个中号（赠双管抽气泵）', ''),
(448, 106, '透明色', ''),
(449, 107, '女款L', ''),
(450, 107, '女款M', ''),
(451, 107, '女款XL', ''),
(452, 107, '女款XXL', ''),
(453, 107, '男款M', ''),
(454, 107, '男款L', ''),
(455, 107, '男款XL', ''),
(456, 107, '男款XXL', ''),
(457, 106, '花灰色', ''),
(458, 107, '2XL', ''),
(459, 107, '3XL', ''),
(460, 1, '45*15*42', ''),
(461, 1, '45*15*42cm', ''),
(462, 106, '大红色', ''),
(463, 1, '26*13*12cm', ''),
(464, 1, '40*34*46cm', ''),
(465, 106, '宝蓝', ''),
(466, 106, '花灰', ''),
(467, 73, '层数：3层', ''),
(468, 73, '层数：4层', ''),
(469, 106, '草绿色', ''),
(470, 106, '米蓝色', ''),
(471, 107, '男OSFM', ''),
(472, 107, '女OSFM', ''),
(473, 107, '31L', ''),
(474, 107, '45L', ''),
(475, 107, '58L', ''),
(476, 106, '浅蓝色', ''),
(477, 1, '单人吊床', ''),
(478, 1, '双人吊床', ''),
(479, 106, '黑蓝', ''),
(480, 107, '1.6米衣柜+转角架', ''),
(481, 107, '1.8米衣柜+转角架', ''),
(482, 31, '高倍型', ''),
(483, 31, '稳定型', ''),
(484, 107, '1.5*1.9米床+床垫+1柜', ''),
(485, 107, '1.5*2.0米床+床垫+1柜', ''),
(486, 107, '1.8*2.0米床+床垫+1柜', ''),
(487, 7, '学习桌', ''),
(488, 7, '学习桌+椅子', ''),
(489, 106, '蓝色，红色', ''),
(490, 100, '3.6米', ''),
(491, 100, '4.5米', ''),
(492, 100, '5.4米', ''),
(493, 55, '280mm左右', ''),
(494, 12, '套餐一', ''),
(495, 12, '套餐二', ''),
(496, 7, '舒适版', ''),
(497, 7, '豪华版', ''),
(498, 107, '1500*2000mm', ''),
(499, 107, '2000*2200mm', ''),
(500, 12, '基础套餐', ''),
(501, 12, '饵灯套餐', ''),
(502, 12, '大支架套餐', ''),
(503, 106, '浅绿色', ''),
(504, 106, '枚红色', ''),
(505, 1, 'S', ''),
(506, 106, '白色，古铜色，黑色', ''),
(507, 106, '湖水蓝', ''),
(508, 1, '90*90cm', ''),
(509, 1, '110*110cm', ''),
(510, 1, '120*60cm', ''),
(511, 1, '136*80*73cm', ''),
(512, 7, '直拍2只', ''),
(513, 7, '横拍2只', ''),
(514, 7, 'T字型4人位', ''),
(515, 7, '人字型4人位', ''),
(516, 7, '十字型4人位', ''),
(517, 106, '粉色，枫叶，蝴蝶花', ''),
(518, 106, '蝴蝶花', ''),
(519, 106, '粉色，枫叶', ''),
(520, 7, 'slingshot', ''),
(521, 7, 'covert', ''),
(522, 106, '青花瓷，旗袍红', ''),
(523, 10, '带减震', ''),
(524, 9, '德国', ''),
(525, 10, '彩屏带减震', ''),
(526, 106, '浅蓝', ''),
(527, 111, '实心100cm', ''),
(528, 7, '8头彩光遥控', ''),
(529, 111, '实心120cm', ''),
(530, 7, '3头彩光遥控', ''),
(531, 107, '118*121mm', ''),
(532, 106, '白蓝', ''),
(533, 109, '5L', ''),
(534, 109, '15L', ''),
(535, 79, '长910mm*宽127mm*厚度15mm', ''),
(536, 107, 'XS', ''),
(537, 106, '白蓝色', ''),
(538, 106, '黑红色', ''),
(539, 106, '黑黄色', ''),
(540, 106, '土豪色', ''),
(541, 86, '日常生活用品', ''),
(542, 9, '中国广东', ''),
(543, 10, '冰爽醒肤10片独立装', ''),
(544, 10, '去油去汗10片独立装', ''),
(545, 106, '粉蓝', ''),
(546, 106, '富贵紫', ''),
(547, 106, '轿车蓝', ''),
(548, 111, '200抽', ''),
(549, 106, '亮黄', ''),
(550, 106, '亮蓝', ''),
(551, 86, '产妇专用卫生纸', ''),
(552, 111, '30cm*60cm', ''),
(553, 106, '空灵-女', ''),
(554, 106, '空灵-男', ''),
(555, 106, '无迹-女', ''),
(556, 106, '无迹-男', ''),
(557, 106, '极光-女', ''),
(558, 106, '极光-男', ''),
(559, 111, '160克以上', ''),
(560, 105, '无味', ''),
(561, 1, '20cm*11cm', ''),
(562, 111, '6包纸巾', ''),
(563, 107, '白', ''),
(564, 107, '红', ''),
(565, 111, '72只', ''),
(566, 39, '72只', ''),
(567, 32, '175', ''),
(568, 9, '上海', ''),
(569, 5, '3公斤', ''),
(570, 73, '三围：90*60*88', ''),
(571, 86, '时尚前卫，追求生活情趣的女性', ''),
(572, 80, '10ml', ''),
(573, 2, '36', ''),
(574, 2, '345', ''),
(575, 5, '365', ''),
(576, 5, '32', ''),
(577, 8, '草莓', ''),
(578, 8, '蓝莓', ''),
(579, 8, '香蕉', ''),
(580, 6, '塑封', ''),
(581, 6, '袋装', ''),
(582, 107, 'SML', ''),
(583, 25, '2迷', ''),
(584, 25, '1.2迷', ''),
(585, 109, '500', ''),
(586, 103, '42', ''),
(587, 108, '2015', ''),
(588, 8, 'tian', ''),
(589, 80, '150g*3袋', ''),
(590, 8, '经典原味', ''),
(591, 8, '伯爵', ''),
(592, 8, '经典炭烧', ''),
(593, 8, '经典港式', ''),
(594, 8, '经典玫瑰', ''),
(595, 1, '均码', ''),
(596, 1, '35', ''),
(597, 1, '36', ''),
(598, 1, '37', ''),
(599, 1, '38', ''),
(600, 1, '39', ''),
(601, 5, '25', ''),
(602, 5, '50', ''),
(603, 5, '10', ''),
(604, 9, '涪陵龙潭镇', ''),
(605, 2, '111', ''),
(606, 2, '1111', ''),
(607, 5, '300', ''),
(608, 5, '500', ''),
(609, 5, '600', ''),
(610, 5, '1000', ''),
(611, 6, '瓶装', ''),
(612, 6, '塑料瓶', ''),
(613, 6, '玻璃瓶', ''),
(614, 1, '大号：100*70cm', ''),
(615, 1, '中号：80*60cm', ''),
(616, 1, '小号：70*50cm', ''),
(617, 8, '高钙', ''),
(618, 8, '原味', ''),
(619, 31, '200', ''),
(620, 31, '300', ''),
(621, 30, '300', ''),
(622, 30, '400', ''),
(623, 4, '台', ''),
(624, 27, '1988', ''),
(625, 27, '1989', ''),
(626, 8, '核桃', ''),
(627, 8, '花生', ''),
(628, 2, 'aa', ''),
(629, 2, 'bb', ''),
(630, 3, 'cc', ''),
(631, 3, 'dd', ''),
(632, 3, 'ee', ''),
(633, 3, 'gg', ''),
(634, 3, 'hh', ''),
(635, 3, 'hjj', ''),
(636, 4, '111', ''),
(637, 4, '112', ''),
(638, 4, '23', ''),
(639, 2, '11', ''),
(640, 2, '44', ''),
(641, 4, '55', ''),
(642, 4, '33', ''),
(643, 1, '66', ''),
(644, 4, '66', ''),
(645, 4, '77', ''),
(646, 1, '44', ''),
(647, 1, 'cc', ''),
(648, 1, 'dd', ''),
(649, 1, '123', ''),
(650, 1, '2寸', ''),
(651, 19, '1', ''),
(652, 19, '2', ''),
(653, 19, '4', ''),
(654, 31, 'x', ''),
(655, 31, 'm', ''),
(656, 31, 'xl', ''),
(657, 31, 'xll', ''),
(658, 31, 'xlll', ''),
(659, 4, '456', ''),
(660, 106, '女童（荧光绿）', ''),
(661, 106, '女童（玫红）', ''),
(662, 106, '男童（宝蓝）', ''),
(663, 106, '男童（森林绿）', ''),
(664, 1, '344', ''),
(665, 1, '222', ''),
(666, 1, '56', ''),
(667, 1, '77', ''),
(668, 1, '88', ''),
(669, 1, '22', ''),
(670, 2, '4', ''),
(671, 2, '5', ''),
(672, 2, '6', ''),
(673, 2, '7', ''),
(674, 2, '8', ''),
(675, 2, '9', ''),
(676, 2, '0', ''),
(677, 2, '-', ''),
(678, 2, '=', ''),
(679, 111, '111', ''),
(680, 3, '467', ''),
(681, 1, '4563', ''),
(682, 1, '4.7', ''),
(683, 1, '11', ''),
(684, 1, 'XLL', ''),
(685, 1, 'XLLL', ''),
(686, 1, 'XLLLL', ''),
(687, 4, '222', ''),
(688, 3, '1111', ''),
(689, 3, '2222', ''),
(690, 2, '80.0kg', ''),
(691, 2, '橙色', ''),
(692, 2, '浅紫色', ''),
(693, 1, '57-17-8mm', ''),
(694, 9, '缅甸', ''),
(695, 1, '56-15-7mm', ''),
(696, 1, '内径：56-66mm 宽：16-22mm 厚：6mm', ''),
(697, 106, '乌鸡黑色', ''),
(698, 1, '高：25~41mm 宽：13~23mm 厚：1~3mm', ''),
(699, 1, '高 　　45mm 　　宽 　　31mm 　　厚 　　8mm', ''),
(700, 1, '8989', ''),
(701, 1, '132', ''),
(702, 1, 'M号', ''),
(703, 1, 'L号', ''),
(704, 1, 'XM号', ''),
(705, 7, '最新款', ''),
(706, 1, '34', ''),
(707, 1, '40', ''),
(708, 13, '12月1日', ''),
(709, 13, '12月19日', ''),
(710, 13, '12月30日', ''),
(711, 10, '男款', ''),
(712, 10, '女款', ''),
(713, 10, '儿童款', ''),
(714, 1, '45', ''),
(715, 1, '666', ''),
(716, 2, '4144', ''),
(717, 2, '4545', ''),
(718, 1, '32', ''),
(719, 2, '34', ''),
(720, 3, '22', ''),
(721, 3, '21', ''),
(722, 4, '12', ''),
(723, 4, '22', ''),
(724, 5, '2400', ''),
(725, 5, '3960', ''),
(726, 5, '330', ''),
(727, 5, '165', ''),
(728, 106, '亚光灰', ''),
(729, 106, '银白', ''),
(730, 83, '18-23', ''),
(731, 1, '59-12-6mm', ''),
(732, 5, '500g', ''),
(733, 1, '41', ''),
(734, 1, '42', ''),
(735, 1, '4.8', ''),
(736, 80, 'ml', ''),
(737, 80, 'l', ''),
(738, 106, '220', ''),
(739, 106, '140', ''),
(740, 106, '230', ''),
(741, 106, '720', ''),
(742, 106, '150', ''),
(743, 106, '420', ''),
(744, 106, '210', ''),
(745, 106, '610', ''),
(746, 111, '5A', ''),
(747, 111, '7A', ''),
(748, 111, '9A', ''),
(749, 19, 'PHP格式', ''),
(750, 1, '1400', ''),
(751, 1, '长 1400', ''),
(752, 1, '高 2100', ''),
(753, 106, '枫木色', ''),
(754, 5, '1100', ''),
(755, 1, 'XX', ''),
(756, 1, 'XM', ''),
(757, 19, '基础版', ''),
(758, 19, '增值版', ''),
(759, 19, '至尊版', ''),
(760, 19, '次年续费', ''),
(761, 1, '1.2米', ''),
(762, 1, '1.5米', ''),
(763, 1, '1.8米', ''),
(764, 111, '套', ''),
(765, 111, '1套', ''),
(766, 111, '标准版', ''),
(767, 111, '升级版', ''),
(768, 111, '行业版', ''),
(769, 103, '35', ''),
(770, 103, '36', ''),
(771, 103, '37', ''),
(772, 103, '38', ''),
(773, 103, '39', ''),
(774, 103, '40', ''),
(775, 106, 'heise', ''),
(776, 80, '60粒', ''),
(777, 80, '100粒', ''),
(778, 80, '120粒', ''),
(779, 80, '200粒', ''),
(780, 111, '908g', ''),
(781, 80, '20粒', ''),
(782, 1, '1.8实', ''),
(783, 1, '1.8米]', ''),
(784, 1, '2米', ''),
(785, 1, '2.0米', ''),
(786, 19, '标准版', ''),
(787, 19, '升级版', ''),
(788, 19, '行业版', ''),
(789, 106, '褐色', ''),
(790, 1, '16G', ''),
(791, 111, '900克', ''),
(792, 2, '斯蒂芬 防撒旦', ''),
(793, 32, '大', ''),
(794, 32, '中', ''),
(795, 32, '小', ''),
(796, 1, '5', ''),
(797, 4, '北京地区', ''),
(798, 4, '保定地区', ''),
(799, 4, '北京地区服务', ''),
(800, 4, '秦皇岛地区服务', ''),
(801, 4, '保定地区服务', ''),
(802, 4, '唐山地区服务', ''),
(803, 13, '一月1号', ''),
(804, 13, '一月2号', ''),
(805, 13, '一月3号', ''),
(806, 13, '一月4号', ''),
(807, 13, '一月5号', ''),
(808, 13, '一月6号', ''),
(809, 13, '一月7号', ''),
(810, 13, '一月八号', ''),
(811, 31, 'XXL', ''),
(812, 27, '二月一号', ''),
(813, 27, '二月二号', ''),
(814, 27, '二月三号', ''),
(815, 27, '二月四号', ''),
(816, 27, '一月一日', ''),
(817, 27, '一月二日', ''),
(818, 27, '一月三日', ''),
(819, 27, '一月四日', ''),
(820, 27, '一月五日', ''),
(821, 27, '一月六日', ''),
(822, 27, '一月七日', ''),
(823, 13, '2015', ''),
(824, 10, '卡片', ''),
(825, 111, '心相随', ''),
(826, 111, '阳光心情-青驼', ''),
(827, 7, '电脑式', ''),
(828, 31, '禾诗 HS-08F', ''),
(829, 1, '1.2炚', ''),
(830, 106, '时尚花都-大红', ''),
(831, 106, '素雅流年--紫', ''),
(832, 106, '千娇百媚', ''),
(833, 106, '塞利维亚', ''),
(834, 106, '心相随', ''),
(835, 106, '幸福爱意-豆沙', ''),
(836, 106, '伊莎贝尔--紫色', ''),
(837, 106, '伊人香气-紫罗兰', ''),
(838, 106, '凡尔赛', ''),
(839, 106, '皇家风范-驼色', ''),
(840, 106, '凯瑟大厅--红玉', ''),
(841, 106, '花语柔情--紫罗兰', ''),
(842, 106, '其它花色请备注', ''),
(843, 106, '酷儿', ''),
(844, 106, '飞舞时光', ''),
(845, 106, '东方剑桥', ''),
(846, 106, '浪漫花丛', ''),
(847, 106, '安妮宝贝', ''),
(848, 106, '碧海柔情', ''),
(849, 106, '淡雅格调', ''),
(850, 106, '花开四季', ''),
(851, 106, '可爱女孩', ''),
(852, 1, '1.85米', ''),
(853, 106, '百丽佳人', ''),
(854, 106, '花蝶凤兰-桔', ''),
(855, 106, '流光百媚', ''),
(856, 106, '思香', ''),
(857, 106, '甜美意境', ''),
(858, 1, '1.5哦也', ''),
(859, 1, '1.', ''),
(860, 106, '暖暖浅春-粉', ''),
(861, 106, '月舞飞扬', ''),
(862, 106, '花团锦绣', ''),
(863, 106, '花源-蓝', ''),
(864, 106, '唯美若诗', ''),
(865, 106, '沁馨花语', ''),
(866, 106, '东方情致', ''),
(867, 106, '缤纷花溢', ''),
(868, 106, '水色蝶舞', ''),
(869, 106, '筱梦提香', ''),
(870, 106, '雅熙花园', ''),
(871, 110, '编号', ''),
(872, 110, 'waixing', ''),
(873, 110, '外形', ''),
(874, 5, '190', ''),
(875, 5, '490', ''),
(876, 1, '厘米', ''),
(877, 30, '克', ''),
(878, 1, '5.9*4.2*1.2cm', ''),
(879, 30, '5克', ''),
(880, 2, 'd', ''),
(881, 2, 'dd', ''),
(882, 5, '220g', ''),
(883, 3, '自动机械', ''),
(884, 32, '30', ''),
(885, 32, '40', ''),
(886, 32, '50', ''),
(887, 5, '900g', ''),
(888, 22, '1年', ''),
(889, 27, '6月1日', ''),
(890, 9, '卡斯蒂利亚', ''),
(891, 8, '带樱桃香味', ''),
(892, 5, '750ml*1*12', ''),
(893, 111, '750ml*1*12', ''),
(894, 1, '64', ''),
(895, 1, '70', ''),
(896, 1, '76', ''),
(897, 1, '82', ''),
(898, 1, '90', ''),
(899, 13, '6月1日', ''),
(900, 13, '6月日', ''),
(901, 13, '6月3日', ''),
(902, 30, '斤', ''),
(903, 14, '成人', ''),
(904, 14, '儿童', ''),
(905, 1, '风格', ''),
(906, 111, '浓郁的红色水果的芳香气息', ''),
(907, 2, '10', ''),
(908, 2, '20', ''),
(909, 2, '30', ''),
(910, 8, '浓郁的红色水果的芳香气息', ''),
(911, 9, '里奥哈', ''),
(912, 106, '淡蓝色', ''),
(913, 31, '双人', ''),
(914, 31, '单人', ''),
(915, 1, '7寸', ''),
(916, 106, '淡黄色', ''),
(917, 107, '尺码', ''),
(918, 107, 'F', ''),
(919, 106, '米', ''),
(920, 106, '玉色', ''),
(921, 5, '包', ''),
(922, 6, '罐装', ''),
(923, 1, '43', ''),
(924, 1, '1.5米*200', ''),
(925, 106, '米黄', ''),
(926, 26, '36', ''),
(927, 26, '37', ''),
(928, 26, '38', ''),
(929, 26, '39', ''),
(930, 31, 'GT630', ''),
(931, 1, '10寸', ''),
(932, 31, 'GT610', ''),
(933, 1, '12寸', ''),
(934, 31, 'GT600', ''),
(935, 31, 'GT590', ''),
(936, 31, 'GT580', ''),
(937, 1, '1.2哦也', ''),
(938, 1, '1.5主', ''),
(939, 106, '锦上添花', ''),
(940, 106, '纯真时代', ''),
(941, 106, '粉色兔', ''),
(942, 106, '其它颜色请备注', ''),
(943, 1, '10.14寸', ''),
(944, 1, '上14寸，下16寸', ''),
(945, 1, '上10寸.下14寸', ''),
(946, 1, '上12寸.下16寸', ''),
(947, 1, '上8寸.中12寸.下16寸', ''),
(948, 31, 'GC-21XSQ', ''),
(949, 1, '2000*200', ''),
(950, 1, '14寸', ''),
(951, 1, '8寸', ''),
(952, 12, '国行100D单机标配特价', ''),
(953, 12, '港版100D单机标配', ''),
(954, 1, '6寸', ''),
(955, 26, '均码', ''),
(956, 7, '三角裤', ''),
(957, 106, '大红', ''),
(958, 106, '碧绿', ''),
(959, 107, '均码', ''),
(960, 5, '500ml', ''),
(961, 5, '1000ml', ''),
(962, 9, '厦门', ''),
(963, 111, '30#', ''),
(964, 111, '32#', ''),
(965, 111, '28#', ''),
(966, 26, 'S', ''),
(967, 26, 'M', ''),
(968, 26, 'L', ''),
(969, 5, '60g', ''),
(970, 6, '金装奶粉', ''),
(971, 7, '条纹', ''),
(972, 7, '花色', ''),
(973, 7, '网状', ''),
(974, 7, 'V领', ''),
(975, 1, '175', ''),
(976, 1, '180', ''),
(977, 1, '185', ''),
(978, 7, '格子', ''),
(979, 106, '黄褐色', ''),
(980, 10, 'HEV版', ''),
(981, 10, '藏版', ''),
(982, 107, '38码', ''),
(983, 107, '39码', ''),
(984, 107, '40码', ''),
(985, 107, '41码', ''),
(986, 107, '42码', ''),
(987, 107, '43码', ''),
(988, 111, '34#', ''),
(989, 111, '363', ''),
(990, 111, '36#', ''),
(991, 1, 'xs', ''),
(992, 7, '商务', ''),
(993, 7, '休闲', ''),
(994, 109, '750ml', ''),
(995, 110, '曼男爵', ''),
(996, 110, '勒胜庄', ''),
(997, 110, '维而蒂  月亮河  圣峰岩  圣人里鹏  乐奔  大主教  玫思  泽思  若思  百酿吉诺  维若', ''),
(998, 110, '维而蒂', ''),
(999, 110, '月亮河', ''),
(1000, 110, '奔富', ''),
(1001, 20, '干红', ''),
(1002, 20, '甜白', ''),
(1003, 110, '套装', ''),
(1004, 111, 'qweq', ''),
(1005, 111, 'weqcs', ''),
(1006, 22, '1月', ''),
(1007, 10, '微官网', ''),
(1008, 10, '微商城', ''),
(1009, 10, '三级分销商', ''),
(1010, 22, '1次', ''),
(1011, 5, '一斤', ''),
(1012, 5, '两斤', ''),
(1013, 5, '半斤', ''),
(1014, 30, '半斤', ''),
(1015, 30, '250g', ''),
(1016, 111, 'M', ''),
(1017, 111, 'L', ''),
(1018, 111, 'XL', ''),
(1019, 111, 'XXL', ''),
(1020, 3, 'acer', ''),
(1021, 7, 'hese', ''),
(1022, 22, '最低十五年', ''),
(1023, 4, '使用幼儿园到高中的全部学生', ''),
(1024, 79, '28', ''),
(1025, 79, '29', ''),
(1026, 79, '30', ''),
(1027, 79, '31', ''),
(1028, 79, '32', ''),
(1029, 79, '33', ''),
(1030, 31, '39', ''),
(1031, 31, '40', ''),
(1032, 31, '41', ''),
(1033, 31, '42', ''),
(1034, 31, '43', ''),
(1035, 79, 'M', ''),
(1036, 79, 'L', ''),
(1037, 79, 'XL', ''),
(1038, 8, '不辣', ''),
(1039, 8, '微辣', ''),
(1040, 8, '超辣', ''),
(1041, 5, '400克', ''),
(1042, 111, '750', ''),
(1043, 111, '500', ''),
(1044, 30, '100', ''),
(1045, 30, '50', ''),
(1046, 30, '200', ''),
(1047, 1, '下16寸，中12寸，上8寸', ''),
(1048, 1, '下14寸，上10寸', ''),
(1049, 1, '170', ''),
(1050, 30, '125g', ''),
(1051, 1, '六层（6寸+8寸+10寸+12寸+14寸+16寸）', ''),
(1052, 107, '36 37 38 39', ''),
(1053, 1, '八层（6寸+8寸+10寸+12寸+14寸+16寸+18寸+20寸）', ''),
(1054, 1, '小三层（8寸+10寸+12寸）', ''),
(1055, 1, '大三层（10寸+12寸+14寸）', ''),
(1056, 1, '7cun', ''),
(1057, 1, '三层（8寸+10寸+14寸）', ''),
(1058, 1, '21寸', ''),
(1059, 1, '22寸', ''),
(1060, 1, '23寸', ''),
(1061, 1, '24寸', ''),
(1062, 2, '2kg', ''),
(1063, 2, '2.2kg', ''),
(1064, 106, '银', ''),
(1065, 2, '2.4kg', ''),
(1066, 2, '2.6kg', ''),
(1067, 106, '金', ''),
(1068, 1, '5.5寸', ''),
(1069, 7, 'iphone6', ''),
(1070, 7, 'iphone plus', ''),
(1071, 1, '三层（8寸+12寸+14寸）', ''),
(1072, 1, '16寸', ''),
(1073, 1, '15cm', ''),
(1074, 1, '20cm', ''),
(1075, 5, '2kg', ''),
(1076, 5, '1.5kg', ''),
(1077, 5, '242g*2', ''),
(1078, 5, '202g', ''),
(1079, 5, '202g*2', ''),
(1080, 5, '1.68kg', ''),
(1081, 5, '650g', ''),
(1082, 5, '600g', ''),
(1083, 1, '165', ''),
(1084, 1, '25寸', ''),
(1085, 11, '4G', ''),
(1086, 1, '5寸', ''),
(1087, 57, '提供早餐', ''),
(1088, 57, '提供免费宽带服务', ''),
(1089, 57, '热水洗浴', ''),
(1090, 57, '所有房型均有窗', ''),
(1091, 57, '单间A：1张床（1.5mx2m）', ''),
(1092, 57, '标间B：2张床（1.2mx2m）', ''),
(1093, 1, '10*10', ''),
(1094, 4, '微信支付 支付宝 拉卡拉', ''),
(1095, 103, '3536373839', ''),
(1096, 1, '10*20', ''),
(1097, 5, '1kg', ''),
(1098, 106, '橄榄绿', ''),
(1099, 1, '180mm', ''),
(1100, 1, '240mm', ''),
(1101, 1, '480mm', ''),
(1102, 1, '迷你', ''),
(1103, 1, '中长款', ''),
(1104, 1, '长款', ''),
(1105, 106, '典雅红', ''),
(1106, 106, '经典黑', ''),
(1107, 4, '小票', ''),
(1108, 1, '15*30', ''),
(1109, 4, '刷粉神器', ''),
(1110, 3, '真八核', ''),
(1111, 4, '吸粉神器', ''),
(1112, 4, '覆盖100㎡', ''),
(1113, 4, '覆盖200㎡', ''),
(1114, 4, '覆盖300㎡', ''),
(1115, 1, '24', ''),
(1116, 1, '25', ''),
(1117, 1, '26', ''),
(1118, 10, '牛皮', ''),
(1119, 10, '呢子', ''),
(1120, 8, '斯蒂芬', ''),
(1121, 8, '多的', ''),
(1122, 34, '100㎡', ''),
(1123, 34, '200㎡', ''),
(1124, 34, '300㎡', ''),
(1125, 31, '100㎡', ''),
(1126, 31, '200㎡', ''),
(1127, 31, '300㎡', ''),
(1128, 34, '500㎡', ''),
(1129, 1, '小型', ''),
(1130, 1, '中型', ''),
(1131, 6, '盒装', ''),
(1132, 5, '120克', ''),
(1133, 5, '200克', ''),
(1134, 1, 'kk', ''),
(1135, 1, 'daxia', ''),
(1136, 1, 'dadfa', ''),
(1137, 1, 'dasfads', ''),
(1138, 1, 'adsfads', ''),
(1139, 1, 'asdfads', ''),
(1140, 1, 'adsfdasfa', ''),
(1141, 1, 'asdfadsf', ''),
(1142, 1, 'fasdfadsf', ''),
(1143, 1, 'asdfasd', ''),
(1144, 1, 'safasdfadsf', ''),
(1145, 6, '压缩', ''),
(1146, 8, '醇香', ''),
(1147, 6, '压缩盒装', ''),
(1148, 73, '全脂乳粉、白砂糖、发酵乳、低聚麦芽糖、葡萄糖粉、植脂末、柠檬酸、食用香精', ''),
(1149, 8, '香辣', ''),
(1150, 1, 'sadf;kjsadfl', ''),
(1151, 1, 'asdfdasf', ''),
(1152, 1, 'adsfadsf', ''),
(1153, 1, 'sadfadsf', ''),
(1154, 1, 'asdfadsfasdfa', ''),
(1155, 1, 'adsfadsfadsfas', ''),
(1156, 1, 'dasfadsfads', ''),
(1157, 1, 'asdfasdfasdf', ''),
(1158, 1, 'adsfasdfasf', ''),
(1159, 1, 'adsfasfadsf', ''),
(1160, 1, 'adsfasfasfasfasfas', ''),
(1161, 1, '撒打发似的', ''),
(1162, 1, '阿斯蒂芬', ''),
(1163, 1, '多对多', ''),
(1164, 5, '225ml', ''),
(1165, 5, '100ml', ''),
(1166, 5, '300ml', ''),
(1167, 1, 'aa', ''),
(1168, 4, '1111', ''),
(1169, 4, '1111111111111111111', ''),
(1170, 2, '5555', ''),
(1171, 2, '5555555', ''),
(1172, 100, '1.5', ''),
(1173, 100, '0.8', ''),
(1174, 111, '本', ''),
(1175, 1, 'sfsdf', ''),
(1176, 5, '25g', ''),
(1177, 32, '一盒', ''),
(1178, 6, '盒', ''),
(1179, 6, '片', ''),
(1180, 7, '75A', ''),
(1181, 7, '70A', ''),
(1182, 7, '80A', ''),
(1183, 6, '大红', ''),
(1184, 6, '橙色', ''),
(1185, 6, '润绿', ''),
(1186, 6, '黑色', ''),
(1187, 106, '粉丝', ''),
(1188, 1, '20', ''),
(1189, 1, '21', ''),
(1190, 1, '23', ''),
(1191, 1, '27', ''),
(1192, 1, '28', ''),
(1193, 1, '29', ''),
(1194, 1, '30', ''),
(1195, 1, '31', ''),
(1196, 1, '33', ''),
(1197, 106, '黑色、黄色、黑黄、藏青、玫红、深红、浅红、蓝色、粉肉、浅粉紫、红蓝、桔色、紫玫红', ''),
(1198, 106, '黑黄', ''),
(1199, 106, '深红', ''),
(1200, 106, '浅红', ''),
(1201, 106, '粉肉', ''),
(1202, 106, '浅粉紫', ''),
(1203, 106, '红蓝', ''),
(1204, 106, '紫玫红', ''),
(1205, 4, '电子称', ''),
(1206, 111, '900', ''),
(1207, 111, '1500', ''),
(1208, 2, '1', ''),
(1209, 104, '35', ''),
(1210, 104, '36', ''),
(1211, 104, '37', ''),
(1212, 104, '38', ''),
(1213, 104, '39', ''),
(1214, 104, '40', ''),
(1215, 107, '155/80A/S', ''),
(1216, 107, '160/84A/M', ''),
(1217, 1, '28 29 32 31 32 33 34 35 36 37', ''),
(1218, 1, '24L 48L 58L 68L 88L', ''),
(1219, 1, '】', ''),
(1220, 106, '梦幻蓝 薄荷绿 烟花粉', ''),
(1221, 86, '内衣 大衣/西服 毛衣 包包', ''),
(1222, 106, '白绿', ''),
(1223, 106, '本白', ''),
(1224, 109, '15ml', ''),
(1225, 109, '12mg', ''),
(1226, 109, '60ml', ''),
(1227, 109, '30ml', ''),
(1228, 109, '700', ''),
(1229, 109, '900', ''),
(1230, 1, '46', ''),
(1231, 5, '100、', ''),
(1232, 6, '11', ''),
(1233, 1, '我的', ''),
(1234, 1, '好', ''),
(1235, 3, '不', ''),
(1236, 1, 'eee', ''),
(1237, 1, '二二二', ''),
(1238, 3, '让人', ''),
(1239, 3, '日日日', ''),
(1240, 3, 'eer', ''),
(1241, 2, '121', ''),
(1242, 2, '235', ''),
(1243, 3, 'aass', ''),
(1244, 3, 'c', ''),
(1245, 4, '水电费', ''),
(1246, 73, '运费', ''),
(1247, 5, '500克', ''),
(1248, 107, '39，40，41', ''),
(1249, 106, '灰色，黑色', ''),
(1250, 108, '2015年夏季', ''),
(1251, 73, '印花', ''),
(1252, 73, '韩版', ''),
(1253, 73, '纯棉', ''),
(1254, 73, '修身', ''),
(1255, 107, '均码、修身', ''),
(1256, 17, '纯棉', ''),
(1257, 108, '20105年夏季', ''),
(1258, 79, '110cm', ''),
(1259, 79, '120cm 130cm 140cm 150cm 160cm', ''),
(1260, 79, '120cm', ''),
(1261, 79, '130cm', ''),
(1262, 79, '140cm', ''),
(1263, 79, '150cm', ''),
(1264, 79, '160cm', ''),
(1265, 1, 'xk', ''),
(1266, 1, '75A', ''),
(1267, 1, '75B', ''),
(1268, 1, '80A', ''),
(1269, 1, '80B', ''),
(1270, 1, '37、38', ''),
(1271, 106, '浅绿色、淡黄色', ''),
(1272, 1, '110cm', ''),
(1273, 1, '120cm', ''),
(1274, 1, '130cm', ''),
(1275, 1, '140cm', ''),
(1276, 1, '150cm', ''),
(1277, 1, '160cm', ''),
(1278, 1, ';', ''),
(1279, 1, '2XL', ''),
(1280, 106, '浅黄色', ''),
(1281, 106, '藏蓝色', ''),
(1282, 106, '甜心粉', ''),
(1283, 17, '平纹棉', ''),
(1284, 31, '10W40', ''),
(1285, 31, '10W30', ''),
(1286, 106, '天蓝', ''),
(1287, 5, '10克', ''),
(1288, 5, '20克', ''),
(1289, 5, '30克', ''),
(1290, 1, 'C', ''),
(1291, 106, 'bai', ''),
(1292, 7, '吊带', ''),
(1293, 83, '25-29周岁', ''),
(1294, 7, '连衣裙', ''),
(1295, 109, '750', ''),
(1296, 109, '75', ''),
(1297, 109, '50', ''),
(1298, 1, 'dsada', ''),
(1299, 1, '2M*2.3M', ''),
(1300, 1, '1.8M*2M', ''),
(1301, 6, '无包装', ''),
(1302, 6, '有包装', ''),
(1303, 4, '男士', ''),
(1304, 4, '女士', ''),
(1305, 1, '长', ''),
(1306, 1, '宽', ''),
(1307, 1, '边距', ''),
(1308, 31, 'mx3', ''),
(1309, 31, 'mx4', ''),
(1310, 31, 'note', ''),
(1311, 31, 'm2', ''),
(1312, 31, 'm3', ''),
(1313, 31, 'm4', ''),
(1314, 1, '水电费', ''),
(1315, 1, '165M 170L 175XL 180XXL', ''),
(1316, 109, '1.8L', ''),
(1317, 109, '2.5', ''),
(1318, 106, '其它', ''),
(1319, 4, '移动', ''),
(1320, 4, '点心', ''),
(1321, 4, '电信', ''),
(1322, 4, '联通', ''),
(1323, 4, '三网合一', ''),
(1324, 1, '165L', ''),
(1325, 1, '170L', ''),
(1326, 1, '175XL', ''),
(1327, 1, '180XXL', ''),
(1328, 1, 'sdfdsf', ''),
(1329, 86, '美白', ''),
(1330, 86, '祛斑', ''),
(1331, 1, '啥地方大厦法第三方', ''),
(1332, 86, '保湿', ''),
(1333, 3, '萨达、', ''),
(1334, 109, '100ml', ''),
(1335, 4, '手机音频接口', ''),
(1336, 4, '手机APP', ''),
(1337, 4, '手机音频接口、手机APP', ''),
(1338, 1, '6', ''),
(1339, 1, '8', ''),
(1340, 1, '10', ''),
(1341, 1, '14', ''),
(1342, 111, '箱', ''),
(1343, 93, '箱', ''),
(1344, 87, '箱', ''),
(1345, 106, '灰色809', ''),
(1346, 106, '军绿808', ''),
(1347, 106, '浅绿606', ''),
(1348, 6, '袋', ''),
(1349, 106, '军绿807', ''),
(1350, 6, '箱', ''),
(1351, 2, '2222', ''),
(1352, 2, 'qqqqq', ''),
(1353, 2, 'aaa', ''),
(1354, 2, 'dda', ''),
(1355, 2, 'ass', ''),
(1356, 2, 'EEE', ''),
(1357, 2, 'RR', ''),
(1358, 2, 'RRR', ''),
(1359, 2, 'EE', ''),
(1360, 2, 'TTT', ''),
(1361, 2, 'GFGG', ''),
(1362, 2, 'EESSS', ''),
(1363, 3, 'KJJJ', ''),
(1364, 3, 'JJJ', ''),
(1365, 30, '300g', ''),
(1366, 30, '500g', ''),
(1367, 2, '是的范德萨', ''),
(1368, 2, 'sdfds', ''),
(1369, 4, '点点滴滴', ''),
(1370, 4, '大多数是谁', ''),
(1371, 2, '100g', ''),
(1372, 2, '200g', ''),
(1373, 2, '12g', ''),
(1374, 2, '15g', ''),
(1375, 2, '18g', ''),
(1376, 2, '25g', ''),
(1377, 2, '问我', ''),
(1378, 2, '呜呜呜呜', ''),
(1379, 4, '啥地方', ''),
(1380, 4, '啥地方第三方', ''),
(1381, 6, 'iii', ''),
(1382, 6, '水电费', ''),
(1383, 7, '白色', ''),
(1384, 7, '蓝色', ''),
(1385, 7, '灰色', ''),
(1386, 1, '７.１', ''),
(1387, 111, '米粉底绿花', ''),
(1388, 111, '冰淇淋图案', ''),
(1389, 106, '灰绿', ''),
(1390, 106, '月色', ''),
(1391, 106, '玫瑰色', ''),
(1392, 1, '190', ''),
(1393, 1, '180cm', ''),
(1394, 1, '200cm', ''),
(1395, 1, '230cm', ''),
(1396, 1, '被套(200cm*230cm)  床罩（250cm*270cm） 小枕套（50cm*70cm）  大', ''),
(1397, 1, '被套(200cm*230cm) 床罩（250cm*270cm） 小枕套（50cm*70cm） 大枕套', ''),
(1398, 1, '被套(200cm*230cm)    床罩（250cm*270cm）   小枕套（45cm*75cm', ''),
(1399, 1, '被套(200cm*230cm) 床罩（250cm*270cm） 小枕套（45cm*75cm） 大枕套', ''),
(1400, 1, '被套（200cm*230cm）  床罩（250cm*270cm）  小枕套（45cm*75cm）  ', '');

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product_qrcode_activity`
--

CREATE TABLE IF NOT EXISTS `pigcms_product_qrcode_activity` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `buy_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '购买方式 0扫码直接购买',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优惠方式 0扫码折扣 1扫码可减优惠',
  `discount` float NOT NULL DEFAULT '0' COMMENT '折扣',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品扫码活动' AUTO_INCREMENT=8 ;

--
-- 导出表中的数据 `pigcms_product_qrcode_activity`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product_sku`
--

CREATE TABLE IF NOT EXISTS `pigcms_product_sku` (
  `sku_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '库存id',
  `product_id` int(10) NOT NULL,
  `properties` varchar(500) NOT NULL DEFAULT '' COMMENT '商品属性组合 pid1:vid1;pid2:vid2;pid3:vid3',
  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '库存',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '库存编码',
  `sales` int(10) NOT NULL DEFAULT '0' COMMENT '销量',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价格',
  `min_fx_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销最低价格',
  `max_fx_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销最高价格',
  `drp_level_1_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品价格',
  `drp_level_2_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品价格',
  `drp_level_3_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品价格',
  `drp_level_1_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品成本价格',
  `drp_level_2_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品成本价格',
  `drp_level_3_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品成本价格',
  PRIMARY KEY (`sku_id`),
  KEY `code` (`code`) USING BTREE,
  KEY `product_id` (`product_id`,`quantity`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品库存' AUTO_INCREMENT=139 ;

--
-- 导出表中的数据 `pigcms_product_sku`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product_to_group`
--

CREATE TABLE IF NOT EXISTS `pigcms_product_to_group` (
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '分组id',
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品分组关联';

--
-- 导出表中的数据 `pigcms_product_to_group`
--

INSERT INTO `pigcms_product_to_group` (`product_id`, `group_id`) VALUES
(55, 17),
(54, 17),
(53, 17),
(52, 16),
(51, 16),
(50, 16),
(49, 15),
(48, 15),
(47, 15),
(46, 14),
(45, 14),
(44, 14),
(43, 13),
(42, 13),
(41, 13),
(58, 20),
(59, 21),
(60, 22),
(61, 22),
(62, 22),
(63, 23),
(64, 23),
(65, 23),
(66, 24),
(67, 24),
(68, 24),
(69, 25),
(70, 25),
(71, 25),
(72, 26),
(73, 26),
(74, 26),
(75, 27),
(76, 27),
(77, 27),
(78, 28),
(79, 29),
(80, 29),
(81, 29),
(82, 30),
(83, 30),
(84, 30),
(85, 31),
(86, 32),
(87, 32),
(88, 32);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product_to_property`
--

CREATE TABLE IF NOT EXISTS `pigcms_product_to_property` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '商品属性id',
  `order_by` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`pigcms_id`),
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品关联属性id' AUTO_INCREMENT=30 ;

--
-- 导出表中的数据 `pigcms_product_to_property`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_product_to_property_value`
--

CREATE TABLE IF NOT EXISTS `pigcms_product_to_property_value` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '商品属性id',
  `vid` int(10) NOT NULL DEFAULT '0' COMMENT '商品属性值id',
  `order_by` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`pigcms_id`),
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE,
  KEY `vid` (`vid`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品关联属性值' AUTO_INCREMENT=89 ;

--
-- 导出表中的数据 `pigcms_product_to_property_value`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_recognition`
--

CREATE TABLE IF NOT EXISTS `pigcms_recognition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `third_type` varchar(30) NOT NULL,
  `third_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `ticket` varchar(200) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_recognition`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_reply_relation`
--

CREATE TABLE IF NOT EXISTS `pigcms_reply_relation` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT '[0:文本，1：图文，2：音乐，3：商品，4：商品分类，5：微页面，6：微页面分类，7：店铺主页，8：会员主页]',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_reply_relation`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_reply_tail`
--

CREATE TABLE IF NOT EXISTS `pigcms_reply_tail` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `is_open` tinyint(1) NOT NULL COMMENT '是否开启（0：关，1：开）',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_reply_tail`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_reward`
--

CREATE TABLE IF NOT EXISTS `pigcms_reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) NOT NULL COMMENT '添加时间',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  `name` varchar(255) NOT NULL COMMENT '活动名称',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '优惠方式，1：普通优惠，2：多级优惠，每级优惠不累积',
  `is_all` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否所有商品都参与活动，1：全部商品，2：部分商品',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效，1：有效，0：无效，',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`store_id`,`start_time`,`end_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='满减/送表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_reward`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_reward_condition`
--

CREATE TABLE IF NOT EXISTS `pigcms_reward_condition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL COMMENT '满减/送表ID',
  `money` int(11) NOT NULL COMMENT '钱数限制',
  `cash` int(11) NOT NULL DEFAULT '0' COMMENT '减现金，0：表示没有此选项',
  `postage` int(11) NOT NULL DEFAULT '0' COMMENT '免邮费，0：表示没有此选项',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '送积分，0：表示没有此选项',
  `coupon` int(11) NOT NULL DEFAULT '0' COMMENT '送优惠，0：表示没有此选项',
  `present` int(11) NOT NULL DEFAULT '0' COMMENT '送赠品，0：表示没有此选项',
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='优惠条件表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_reward_condition`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_reward_product`
--

CREATE TABLE IF NOT EXISTS `pigcms_reward_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL COMMENT '满减/送表ID',
  `product_id` int(11) NOT NULL COMMENT '产品表ID',
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='满减/送产品列表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_reward_product`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_rule`
--

CREATE TABLE IF NOT EXISTS `pigcms_rule` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT '规则类型（0：手动添加的，1：系统默认的）',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='规则表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_rule`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_sale_category`
--

CREATE TABLE IF NOT EXISTS `pigcms_sale_category` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '类目id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '类目名称',
  `desc` varchar(1000) NOT NULL DEFAULT '' COMMENT '描述',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '父类id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `order_by` int(10) NOT NULL DEFAULT '0' COMMENT '排序，值小优越',
  `path` varchar(1000) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `parent_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '父类状态',
  `stores` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺数量',
  `cat_pic` varchar(120) NOT NULL COMMENT '图片',
  PRIMARY KEY (`cat_id`),
  KEY `parent_category_id` (`parent_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺主营类目' AUTO_INCREMENT=21 ;

--
-- 导出表中的数据 `pigcms_sale_category`
--

INSERT INTO `pigcms_sale_category` (`cat_id`, `name`, `desc`, `parent_id`, `status`, `order_by`, `path`, `level`, `parent_status`, `stores`, `cat_pic`) VALUES
(1, '女装', '精美女装 新款上市', 0, 1, 0, '0,01', 1, 1, 703, 'category/2015/08/55d976353d79b.png'),
(2, '男装', '帅气男装 新款上市', 0, 1, 0, '0,02', 1, 1, 179, ''),
(3, '食品酒水', '绿水食品 放心酒水', 0, 1, 0, '0,03', 1, 1, 467, ''),
(4, '个护美妆', '美丽从现在开始', 0, 1, 0, '0,04', 1, 1, 175, ''),
(5, '母婴玩具', '安全母婴 健康成长', 0, 1, 0, '0,05', 1, 1, 105, ''),
(6, '家居百货', '家居超市 齐全百货', 0, 1, 0, '0,06', 1, 1, 218, ''),
(7, '运动户外', '运动锻炼 户外旅行', 0, 1, 0, '0,07', 1, 1, 93, ''),
(8, '电脑数码', '全类3C 保证正品', 0, 1, 0, '0,08', 1, 1, 340, ''),
(9, '手表饰品', '打扮不一样的自己', 0, 1, 0, '0,09', 1, 1, 49, ''),
(10, '汽车用品', '汽车用品超市', 0, 1, 0, '0,10', 1, 1, 92, ''),
(13, '汽车装饰', '', 10, 1, 0, '0,10,13', 2, 1, 54, ''),
(14, '车载电器', '', 10, 1, 0, '0,10,14', 2, 1, 5, ''),
(15, '美容清洗', '', 10, 1, 0, '0,10,15', 2, 1, 3, ''),
(16, '维修保养', '', 10, 1, 0, '0,10,16', 2, 1, 8, ''),
(17, '安全自驾', '', 10, 1, 0, '0,10,17', 2, 1, 2, ''),
(18, '全品类', '', 10, 1, 0, '0,10,18', 2, 1, 20, ''),
(19, '其他', '其他分类', 0, 1, 0, '0,19', 1, 1, 377, ''),
(20, '虚拟卡券', '', 19, 1, 0, '0,19,20', 2, 1, 377, '');

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_search_hot`
--

CREATE TABLE IF NOT EXISTS `pigcms_search_hot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `url` varchar(500) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `sort` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='热门搜索' AUTO_INCREMENT=8 ;

--
-- 导出表中的数据 `pigcms_search_hot`
--

INSERT INTO `pigcms_search_hot` (`id`, `name`, `url`, `type`, `sort`, `add_time`) VALUES
(1, '休闲零食', 'http://d.mz868.net/category/35', 1, 0, 1432971333),
(2, '婚庆摄影', 'http://d.mz868.net/category/14', 1, 0, 1432971431),
(3, '茶饮冲调', 'http://d.mz868.net/category/36', 0, 0, 1432971589),
(4, '数码家电', 'http://d.mz868.net/category/7', 1, 0, 1432975713),
(5, '美妆', 'http://d.mz868.net/category/4', 0, 0, 1432971701),
(6, '男装', 'http://d.mz868.net/category/37', 0, 0, 1432971775),
(7, '男鞋', 'http://d.mz868.net/category/33', 0, 0, 1432971892);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_search_tmp`
--

CREATE TABLE IF NOT EXISTS `pigcms_search_tmp` (
  `md5` varchar(32) NOT NULL COMMENT 'md5系统分类表id字条串，例md5(''1,2,3'')',
  `product_id_str` text COMMENT '满足条件的产品id字符串，每个产品id以逗号分割',
  `expire_time` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  UNIQUE KEY `md5` (`md5`),
  KEY `expire_time` (`expire_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统分类筛选产品临时表';

--
-- 导出表中的数据 `pigcms_search_tmp`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_seller_fx_product`
--

CREATE TABLE IF NOT EXISTS `pigcms_seller_fx_product` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商店铺id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商店铺id',
  `source_product_id` int(11) NOT NULL DEFAULT '0' COMMENT '源商品id',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  PRIMARY KEY (`pigcms_id`),
  KEY `supplier_id` (`supplier_id`) USING BTREE,
  KEY `seller_id` (`seller_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分销商分销商品' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_seller_fx_product`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_service`
--

CREATE TABLE IF NOT EXISTS `pigcms_service` (
  `service_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `nickname` char(50) NOT NULL COMMENT '客服昵称',
  `truename` char(50) NOT NULL COMMENT '真实姓名',
  `avatar` char(150) NOT NULL COMMENT '客服头像',
  `intro` text NOT NULL COMMENT '客服简介',
  `tel` char(20) NOT NULL COMMENT '电话',
  `qq` char(11) NOT NULL COMMENT 'qq',
  `email` char(45) NOT NULL COMMENT '联系邮箱',
  `openid` char(60) NOT NULL COMMENT '绑定openid',
  `add_time` char(15) NOT NULL COMMENT '添加时间',
  `status` tinyint(4) NOT NULL COMMENT '客服状态',
  `store_id` int(11) NOT NULL COMMENT '所属店铺',
  PRIMARY KEY (`service_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺客服列表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_service`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_slider`
--

CREATE TABLE IF NOT EXISTS `pigcms_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `pic` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL,
  `last_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='导航表' AUTO_INCREMENT=15 ;

--
-- 导出表中的数据 `pigcms_slider`
--

INSERT INTO `pigcms_slider` (`id`, `cat_id`, `name`, `url`, `pic`, `sort`, `last_time`, `status`) VALUES
(1, 2, '餐具', 'http://gope.cn/wap/category.php?keyword=%E9%9B%B6%E9%A3%9F&id=14', 'slider/2015/06/5570f82e5d4ea.png', 0, 1433727140, 1),
(2, 2, '居家', 'http://gope.cn/wap/category.php?keyword=%E5%AE%B6%E7%BA%BA&id=40', 'slider/2015/06/5570f85fc0844.png', 0, 1433727124, 1),
(3, 2, '娱乐', 'http://gope.cn/wap/category.php?keyword=%E9%AA%91%E8%A1%8C%E8%BF%90%E5%8A%A8&id=56', 'slider/2015/06/5570f87bb0b60.png', 0, 1433727106, 1),
(4, 2, '户外', 'http://gope.cn/wap/category.php?keyword=%E8%BF%90%E5%8A%A8%E9%9E%8B%E5%8C%85&id=50', 'slider/2015/06/5570f8b047c7f.png', 0, 1433727067, 1),
(5, 1, '运动鞋包', 'http://gope.cn/category/50', '', 1, 1433395845, 1),
(6, 1, '食品酒水', 'http://gope.cn/category/11', '', 2, 1433572631, 1),
(7, 1, '热卖男鞋', 'http://gope.cn/category/6', '', 3, 1433395792, 1),
(8, 1, '宝宝用品', 'http://gope.cn/category/34', '', 0, 1433495147, 1),
(9, 1, '沐浴洗护', 'http://gope.cn/category/29', '', 0, 1433495177, 1),
(10, 1, '居家百货', 'http://gope.cn/category/39', '', 0, 1433495207, 1),
(11, 1, '电脑数码', 'http://gope.cn/category/64', '', 0, 1433495234, 1),
(12, 1, '手表饰品', 'http://gope.cn/category/75', '', 0, 1433495279, 1),
(13, 1, '汽车用品', 'http://gope.cn/category/79', '', 0, 1433495663, 1),
(14, 1, '服装配件', 'http://gope.cn/category/17', '', 0, 1433495697, 1);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_slider_category`
--

CREATE TABLE IF NOT EXISTS `pigcms_slider_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` char(20) NOT NULL,
  `cat_key` char(20) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='导航归类表' AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `pigcms_slider_category`
--

INSERT INTO `pigcms_slider_category` (`cat_id`, `cat_name`, `cat_key`) VALUES
(1, 'PC端导航', 'pc_nav'),
(2, '手机端-首页导航（4个）', 'wap_index_nav');

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_source_material`
--

CREATE TABLE IF NOT EXISTS `pigcms_source_material` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `it_ids` varchar(50) NOT NULL COMMENT '图文表id集合',
  `store_id` int(10) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT '图文类型（0：单图文，1：多图文）',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_source_material`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_store`
--

CREATE TABLE IF NOT EXISTS `pigcms_store` (
  `store_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '店铺id',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '会员id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `edit_name_count` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '店铺名修改次数',
  `logo` varchar(200) NOT NULL DEFAULT '' COMMENT '店铺logo',
  `sale_category_fid` int(11) NOT NULL,
  `sale_category_id` int(10) NOT NULL DEFAULT '0' COMMENT '主营类目',
  `linkman` varchar(30) NOT NULL DEFAULT '' COMMENT '联系人',
  `tel` varchar(20) NOT NULL DEFAULT '' COMMENT '电话',
  `intro` varchar(1000) NOT NULL DEFAULT '' COMMENT '店铺简介',
  `approve` char(1) NOT NULL DEFAULT '0' COMMENT '认证 0未认证 1已证',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 0禁用 1启用',
  `date_added` varchar(20) NOT NULL DEFAULT '' COMMENT '店铺入驻时间',
  `service_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '客服电话',
  `service_qq` varchar(15) NOT NULL DEFAULT '' COMMENT '客服qq',
  `service_weixin` varchar(60) NOT NULL DEFAULT '' COMMENT '客服微信',
  `bind_weixin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '绑定微信 0未绑定 1已绑定',
  `weixin_name` varchar(60) NOT NULL DEFAULT '' COMMENT '公众号名称',
  `weixin_original_id` varchar(20) NOT NULL DEFAULT '' COMMENT '微信原始ID',
  `weixin_id` varchar(20) NOT NULL DEFAULT '' COMMENT '微信ID',
  `qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'qq',
  `open_weixin` char(1) NOT NULL DEFAULT '0' COMMENT '绑定微信',
  `buyer_selffetch` char(1) NOT NULL DEFAULT '0' COMMENT '买家上门自提',
  `pay_agent` char(1) NOT NULL DEFAULT '0' COMMENT '代付',
  `open_nav` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启店铺导航',
  `nav_style_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT '店铺导航样式',
  `use_nav_pages` varchar(20) NOT NULL DEFAULT '1' COMMENT '使用导航菜单的页面 1店铺主页 2会员主页 3微页面及分类 4商品分组 5商品搜索',
  `open_ad` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启广告',
  `has_ad` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有店铺广告',
  `ad_position` tinyint(1) NOT NULL DEFAULT '0' COMMENT '广告位置 0页面头部 1页面底部',
  `use_ad_pages` varchar(20) NOT NULL DEFAULT '' COMMENT '使用广告的页面 1微页面 2微页面分类 3商品 4商品分组 5店铺主页 6会员主页',
  `date_edited` varchar(20) NOT NULL DEFAULT '' COMMENT '更新时间',
  `income` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺收入',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '未提现余额',
  `unbalance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '不可用余额',
  `withdrawal_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已提现金额',
  `withdrawal_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '提现方式 0对私 1对公',
  `bank_id` int(5) NOT NULL DEFAULT '0' COMMENT '开户银行',
  `bank_card` varchar(30) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `bank_card_user` varchar(30) NOT NULL DEFAULT '' COMMENT '开卡人姓名',
  `opening_bank` varchar(30) NOT NULL DEFAULT '' COMMENT '开户行',
  `last_edit_time` varchar(20) NOT NULL DEFAULT '' COMMENT '最后修改时间',
  `physical_count` smallint(6) NOT NULL,
  `drp_supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销店铺供货商id',
  `drp_level` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销级别',
  `collect` int(11) unsigned NOT NULL COMMENT '店铺收藏数',
  `wxpay` tinyint(1) NOT NULL DEFAULT '0',
  `open_drp_approve` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启分销商审核',
  `drp_approve` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分销商审核状态',
  `drp_profit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销利润',
  `drp_profit_withdrawal` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销利润提现',
  `attention_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注数',
  `pigcmsToken` char(100) DEFAULT NULL,
  `template_cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺模板ID',
  `template_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模板ID',
  `source_site_url` varchar(255) DEFAULT NULL COMMENT '来源URL',
  `payment_url` varchar(255) DEFAULT NULL COMMENT '支付地址',
  `notify_url` varchar(255) DEFAULT NULL COMMENT '支付结果通知地址',
  `oauth_url` varchar(255) DEFAULT NULL COMMENT '验证地址',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `open_logistics` tinyint(1) NOT NULL DEFAULT '0',
  `offline_payment` tinyint(1) DEFAULT '0',
  `open_friend` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`store_id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺' AUTO_INCREMENT=38 ;

--
-- 导出表中的数据 `pigcms_store`
--

INSERT INTO `pigcms_store` (`store_id`, `uid`, `name`, `edit_name_count`, `logo`, `sale_category_fid`, `sale_category_id`, `linkman`, `tel`, `intro`, `approve`, `status`, `date_added`, `service_tel`, `service_qq`, `service_weixin`, `bind_weixin`, `weixin_name`, `weixin_original_id`, `weixin_id`, `qq`, `open_weixin`, `buyer_selffetch`, `pay_agent`, `open_nav`, `nav_style_id`, `use_nav_pages`, `open_ad`, `has_ad`, `ad_position`, `use_ad_pages`, `date_edited`, `income`, `balance`, `unbalance`, `withdrawal_amount`, `withdrawal_type`, `bank_id`, `bank_card`, `bank_card_user`, `opening_bank`, `last_edit_time`, `physical_count`, `drp_supplier_id`, `drp_level`, `collect`, `wxpay`, `open_drp_approve`, `drp_approve`, `drp_profit`, `drp_profit_withdrawal`, `attention_num`, `pigcmsToken`, `template_cat_id`, `template_id`, `source_site_url`, `payment_url`, `notify_url`, `oauth_url`, `token`, `open_logistics`, `offline_payment`, `open_friend`) VALUES
(26, 60, 'sasas', 0, '', 1, 0, 'sasa', '13800138000', '', '1', '1', '1439909415', '', '', '', 1, '', '', '', '123456', '0', '0', '0', 0, 1, '1', 0, 0, 0, '', '', 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 1, 0.00, 0.00, 0, NULL, 0, 0, 'http://www.pigcms0818.com', 'http://www.pigcms0818.com/index.php?g=Wap&m=Micrstore&a=pay', 'http://www.pigcms0818.com/index.php?g=Wap&m=Micrstore&a=notify', 'http://www.pigcms0818.com/index.php?g=Wap&m=Micrstore&a=login', 'ibzrbc1439906871', 1, 0, 0),
(27, 63, 'sadf v', 0, '', 1, 0, '马旺', '18812256563', '', '1', '1', '1439989817', '', '', '', 0, '', '', '', '1275872387', '0', '0', '0', 0, 1, '1', 0, 0, 0, '', '', 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 1, 0.00, 0.00, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, 0, 0),
(28, 63, 'asdg', 0, '', 1, 0, '马旺', '18888888888', '', '1', '1', '1439989855', '', '', '', 0, '', '', '', '1437528922', '0', '0', '0', 0, 1, '1', 0, 0, 0, '', '', 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 1, 0.00, 0.00, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, 0, 0),
(29, 64, '微店', 0, '', 1, 0, '微店', '15639542033', '', '1', '1', '1439990590', '13357878632', '4245674646', '', 1, '', '', '', '946356093', '0', '0', '0', 0, 1, '1', 0, 0, 0, '', '', 6.00, 4.00, 2.00, 0.00, 0, 0, '', '', '', '1439993626', 0, 0, 0, 0, 0, 1, 1, 0.00, 0.00, 0, NULL, 0, 0, 'http://weixin.imakebe.com', 'http://weixin.imakebe.com/index.php?g=Wap&m=Micrstore&a=pay', 'http://weixin.imakebe.com/index.php?g=Wap&m=Micrstore&a=notify', 'http://weixin.imakebe.com/index.php?g=Wap&m=Micrstore&a=login', 'jaeiyr1439990045', 1, 0, 0),
(30, 65, '123123', 0, '', 3, 0, '1231231', '13212341234', '', '1', '1', '1439990799', '', '', '', 1, '', '', '', '121312312', '0', '0', '0', 0, 1, '1', 0, 0, 0, '', '', 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 1, 0.00, 0.00, 0, NULL, 0, 0, 'http://weixin.imakebe.com', 'http://weixin.imakebe.com/index.php?g=Wap&m=Micrstore&a=pay', 'http://weixin.imakebe.com/index.php?g=Wap&m=Micrstore&a=notify', 'http://weixin.imakebe.com/index.php?g=Wap&m=Micrstore&a=login', 'qgvdkw1439949139', 1, 0, 0),
(31, 71, '昂首待发', 0, '', 1, 0, '阿迪发的是否', '15888888888', '', '1', '1', '1439993572', '', '', '', 0, '', '', '', '2159849', '0', '0', '0', 0, 1, '1', 0, 0, 0, '', '', 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 1, 0.00, 0.00, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, 0, 0),
(32, 69, '微伊科技', 0, '', 19, 20, '海', '13278077774', '', '1', '1', '1439993894', '', '', '', 0, '', '', '', '182040592', '0', '0', '0', 0, 1, '1', 0, 0, 0, '', '', 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 1, 0.00, 0.00, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, 0, 0),
(33, 62, '飒飒', 0, '', 1, 0, '阿萨飒飒', '13800138000', '', '1', '1', '1440035329', '323', '2312', '123', 1, '', '', '', '1380013800', '0', '1', '0', 0, 1, '1', 0, 0, 0, '', '', 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 1, 0.00, 0.00, 0, NULL, 0, 0, 'http://www.weixin.com', 'http://www.weixin.com/index.php?g=Wap&m=Micrstore&a=pay', 'http://www.weixin.com/index.php?g=Wap&m=Micrstore&a=notify', 'http://www.weixin.com/index.php?g=Wap&m=Micrstore&a=login', 'iztlsr1439949156', 1, 0, 0),
(34, 72, '测试', 0, '', 1, 0, '测试', '13000000000', '', '1', '1', '1440328182', '13000000000', '100001', '', 1, '', '', '', '100001', '0', '0', '0', 0, 1, '1', 0, 0, 0, '', '', 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 1, 0.00, 0.00, 0, NULL, 0, 0, 'http://www.mz868.net', 'http://www.mz868.net/wap.php?c=Pay&a=check&type=weidian', 'http://www.mz868.net/wap.php?c=Weidian&a=api_msg', 'http://www.mz868.net/wap.php?c=Weidian&a=redirect', '68', 0, 0, 0),
(35, 75, '柒柒测试', 0, '', 2, 0, '狗扑源码论坛_Gope.Cn', '15656565656', '', '1', '1', '1440398189', '', '', '', 0, '', '', '', '5646464654', '0', '0', '0', 0, 1, '1', 0, 0, 0, '', '', 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 1, 0.00, 0.00, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(36, 76, '测试测试测是', 0, '', 1, 0, '测试测试测是', '15656525689', '', '1', '1', '1440400385', '', '', '', 0, '', '', '', '5646546546', '0', '0', '0', 0, 1, '1', 0, 0, 0, '', '', 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 1, 0.00, 0.00, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, 0, 0),
(37, 79, '狗扑源码', 0, '', 1, 0, '狗扑源码', '15588000000', '', '0', '1', '1443460616', '', '', '', 0, '', '', '', '123456', '0', '0', '0', 0, 1, '1', 0, 0, 0, '', '', 0.00, 0.00, 0.00, 0.00, 0, 0, '', '', '', '', 0, 0, 0, 0, 0, 0, 1, 0.00, 0.00, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_store_analytics`
--

CREATE TABLE IF NOT EXISTS `pigcms_store_analytics` (
  `pigcms_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `module` varchar(30) NOT NULL DEFAULT '' COMMENT '模块名',
  `title` varchar(300) NOT NULL DEFAULT '' COMMENT '页面标题',
  `page_id` int(10) NOT NULL DEFAULT '0' COMMENT '页面id',
  `visited_time` int(11) NOT NULL DEFAULT '0' COMMENT '访问时间',
  `visited_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '访问ip',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`,`visited_time`,`visited_ip`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺访问统计' AUTO_INCREMENT=627 ;

--
-- 导出表中的数据 `pigcms_store_analytics`
--

INSERT INTO `pigcms_store_analytics` (`pigcms_id`, `store_id`, `module`, `title`, `page_id`, `visited_time`, `visited_ip`) VALUES
(527, 27, 'home', '这是您的第一篇微杂志', 27, 1439989967, 720577822),
(528, 27, 'home', '远亮商城', 27, 1439990411, 720577822),
(529, 29, 'home', '这是您的第一篇微杂志', 29, 1439990926, 236004754),
(530, 29, 'pay', '订单支付', 14, 1439990935, 236004754),
(531, 29, 'home', '这是您的第一篇微杂志', 29, 1439990955, 236004754),
(532, 29, 'goods', '测试', 59, 1439990990, 3074176005),
(533, 27, 'home', '远亮商城', 27, 1439991040, 3029977423),
(534, 29, 'home', '这是您的第一篇微杂志', 29, 1439991138, 2006160067),
(535, 29, 'home', '这是您的第一篇微杂志', 29, 1439991223, 236004754),
(536, 29, 'goods', '测试', 59, 1439991226, 236004754),
(537, 29, 'home', '这是您的第一篇微杂志', 29, 1439991526, 1709318623),
(538, 29, 'home', '这是您的第一篇微杂志', 29, 1439991575, 236004754),
(539, 29, 'home', '这是您的第一篇微杂志', 29, 1439991582, 236004753),
(540, 29, 'ucenter', '会员主页', 29, 1439991586, 236004753),
(541, 29, 'ucenter', '会员主页', 29, 1439991591, 236004753),
(542, 29, 'home', '这是您的第一篇微杂志', 29, 1439991595, 236004753),
(543, 29, 'pay', '订单支付', 15, 1439991604, 236004753),
(544, 29, 'home', '这是您的第一篇微杂志', 29, 1439991604, 454626635),
(545, 29, 'home', '这是您的第一篇微杂志', 29, 1439991724, 236004754),
(546, 29, 'goods', '测试', 59, 1439991728, 236004754),
(547, 29, 'home', '这是您的第一篇微杂志', 29, 1439991761, 236004754),
(548, 29, 'pay', '订单支付', 16, 1439991769, 236004754),
(549, 29, 'home', '这是您的第一篇微杂志', 29, 1439991963, 3074176005),
(550, 29, 'goods', '测试', 59, 1439991968, 3074176005),
(551, 29, 'pay', '订单支付', 17, 1439991974, 3074176005),
(552, 29, 'home', '这是您的第一篇微杂志', 29, 1439992015, 236004753),
(553, 29, 'goods', '测试', 59, 1439992019, 236004754),
(554, 29, 'pay', '订单支付', 18, 1439992030, 236004754),
(555, 29, 'home', '这是您的第一篇微杂志', 29, 1439992282, 236004753),
(556, 29, 'goods', '测试', 59, 1439992285, 236004754),
(557, 29, 'home', '这是您的第一篇微杂志', 29, 1439992306, 236004754),
(558, 29, 'home', '这是您的第一篇微杂志', 29, 1439992369, 236004753),
(559, 29, 'ucenter', '会员主页', 29, 1439992375, 236004753),
(560, 29, 'home', '这是您的第一篇微杂志', 29, 1439992383, 236004753),
(561, 29, 'ucenter', '会员主页', 29, 1439992394, 236004753),
(562, 29, 'ucenter', '会员主页', 29, 1439992399, 236004754),
(563, 29, 'ucenter', '会员主页', 29, 1439992407, 236004754),
(564, 29, 'ucenter', '会员主页', 29, 1439992412, 236004753),
(565, 29, 'ucenter', '会员主页', 29, 1439992422, 236004753),
(566, 29, 'home', '这是您的第一篇微杂志', 29, 1439992444, 3074176005),
(567, 29, 'goods', '测试', 59, 1439992564, 3074176005),
(568, 29, 'ucenter', '会员主页', 29, 1439992574, 236004754),
(569, 29, 'ucenter', '会员主页', 29, 1439992576, 236004754),
(570, 29, 'pay', '订单支付', 17, 1439992583, 3074176005),
(571, 27, 'home', '远亮商城', 27, 1439992614, 720577822),
(572, 27, 'home', '远亮商城', 27, 1439992688, 720577822),
(573, 28, 'home', '这是您的第一篇微杂志', 28, 1439992693, 720577822),
(574, 28, 'home', '这是您的第一篇微杂志', 28, 1439992707, 720577822),
(575, 29, 'home', '这是您的第一篇微杂志', 29, 1439992725, 3074176005),
(576, 29, 'goods', '测试', 59, 1439992729, 236004754),
(577, 29, 'ucenter', '会员主页', 29, 1439992737, 3074176005),
(578, 29, 'ucenter', '会员主页', 29, 1439992770, 3074176005),
(579, 29, 'home', '这是您的第一篇微杂志', 29, 1439992860, 3074176005),
(580, 29, 'goods', '测试', 59, 1439992866, 3074176005),
(581, 29, 'home', '这是您的第一篇微杂志', 29, 1439992927, 236004754),
(582, 29, 'goods', '测试', 59, 1439992931, 236004754),
(583, 29, 'home', '这是您的第一篇微杂志', 29, 1439992939, 236004754),
(584, 29, 'goods', '测试', 59, 1439992943, 236004754),
(585, 29, 'goods', '测试', 59, 1439993274, 3074176005),
(586, 29, 'ucenter', '会员主页', 29, 1439993286, 3074176005),
(587, 29, 'home', '这是您的第一篇微杂志', 29, 1439993361, 3074176005),
(588, 29, 'home', '这是您的第一篇微杂志', 29, 1439993362, 3029977556),
(589, 29, 'goods', '测试', 59, 1439993364, 3074176005),
(590, 29, 'pay', '订单支付', 19, 1439993370, 3074176005),
(591, 29, 'goods', '测试', 59, 1439993379, 236004754),
(592, 29, 'goods', '测试', 59, 1439993389, 3074176005),
(593, 29, 'home', '这是您的第一篇微杂志', 29, 1439993445, 3062675541),
(594, 29, 'goods', '测试', 59, 1439993455, 3074176005),
(595, 29, 'pay', '订单支付', 20, 1439993455, 3062675541),
(596, 29, 'home', '这是您的第一篇微杂志', 29, 1439993457, 720577822),
(597, 29, 'home', '这是您的第一篇微杂志', 29, 1439993463, 236004753),
(598, 29, 'goods', '测试', 59, 1439993467, 236004754),
(599, 29, 'goods', '测试', 59, 1439993468, 3074176005),
(600, 29, 'home', '这是您的第一篇微杂志', 29, 1439993482, 720577822),
(601, 29, 'home', '这是您的第一篇微杂志', 29, 1439993518, 236004753),
(602, 29, 'goods', '测试', 59, 1439993523, 236004753),
(603, 29, 'home', '这是您的第一篇微杂志', 29, 1439993531, 236004753),
(604, 29, 'goods', '测试', 59, 1439993534, 236004753),
(605, 29, 'goods', '测试', 59, 1439993542, 1920253163),
(606, 29, 'home', '这是您的第一篇微杂志', 29, 1439993552, 236004753),
(607, 29, 'goods', '测试', 59, 1439993554, 236004753),
(608, 29, 'home', '这是您的第一篇微杂志', 29, 1439993565, 720577822),
(609, 29, 'pay', '订单支付', 21, 1439993566, 236004754),
(610, 29, 'pay', '订单支付', 22, 1439993580, 236004753),
(611, 29, 'home', '这是您的第一篇微杂志', 29, 1439993619, 3074176005),
(612, 29, 'goods', '测试', 59, 1439993623, 3074176005),
(613, 29, 'home', '这是您的第一篇微杂志', 29, 1439993634, 3062675541),
(614, 29, 'home', '这是您的第一篇微杂志', 29, 1439993679, 236004753),
(615, 29, 'home', '这是您的第一篇微杂志', 29, 1439993680, 3074176005),
(616, 29, 'goods', '测试', 59, 1439993682, 236004753),
(617, 29, 'home', '这是您的第一篇微杂志', 29, 1439993689, 3074176005),
(618, 29, 'ucenter', '会员主页', 29, 1439993693, 3074176005),
(619, 29, 'home', '这是您的第一篇微杂志', 29, 1439993702, 3074176005),
(620, 31, 'home', '这是您的第一篇微杂志', 31, 1439993841, 3029978659),
(621, 29, 'home', '这是您的第一篇微杂志', 29, 1439993913, 1709318625),
(622, 29, 'goods', '测试', 59, 1439994911, 3074176005),
(623, 29, 'goods', '测试', 59, 1439994916, 3074176005),
(624, 37, 'goods', '狗扑源码', 85, 1443460723, 2130706433),
(625, 37, 'goods', '狗扑源码', 85, 1443460734, 2130706433),
(626, 0, 'ucenter', '会员主页', 0, 1443790379, 2130706433);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_store_brand`
--

CREATE TABLE IF NOT EXISTS `pigcms_store_brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL COMMENT '商铺品牌名',
  `pic` varchar(200) NOT NULL COMMENT '品牌图片',
  `order_by` int(100) NOT NULL DEFAULT '0' COMMENT '排序，越小越前面',
  `store_id` int(11) NOT NULL COMMENT '商铺id',
  `type_id` int(11) NOT NULL COMMENT '所属品牌类别id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用（1：启用；  0：禁用）',
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商铺品牌表' AUTO_INCREMENT=14 ;

--
-- 导出表中的数据 `pigcms_store_brand`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_store_brand_type`
--

CREATE TABLE IF NOT EXISTS `pigcms_store_brand_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL COMMENT '商铺品牌类别名',
  `order_by` int(10) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '品牌状态（1：开启，0：禁用）',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商铺品牌类别表' AUTO_INCREMENT=10 ;

--
-- 导出表中的数据 `pigcms_store_brand_type`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_store_contact`
--

CREATE TABLE IF NOT EXISTS `pigcms_store_contact` (
  `store_id` int(11) NOT NULL,
  `phone1` varchar(6) NOT NULL,
  `phone2` varchar(15) NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `county` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `long` decimal(10,6) NOT NULL,
  `lat` decimal(10,6) NOT NULL,
  `last_time` int(11) NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `pigcms_store_contact`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_store_nav`
--

CREATE TABLE IF NOT EXISTS `pigcms_store_nav` (
  `store_nav_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '店铺导航id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `style` tinyint(1) NOT NULL DEFAULT '1' COMMENT '导航样式',
  `bgcolor` char(7) NOT NULL DEFAULT '' COMMENT '背景颜色',
  `data` text NOT NULL COMMENT '店铺导航数据',
  `date_added` varchar(20) NOT NULL,
  PRIMARY KEY (`store_nav_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `store_nav_template_id` (`style`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺导航' AUTO_INCREMENT=6 ;

--
-- 导出表中的数据 `pigcms_store_nav`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_store_pay_agent`
--

CREATE TABLE IF NOT EXISTS `pigcms_store_pay_agent` (
  `agent_id` int(10) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '昵称',
  `type` char(1) NOT NULL DEFAULT '0' COMMENT '类型 0 发起人 1 代付人',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '内容',
  PRIMARY KEY (`agent_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='找人代付' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_store_pay_agent`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_store_physical`
--

CREATE TABLE IF NOT EXISTS `pigcms_store_physical` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `phone1` varchar(6) NOT NULL,
  `phone2` varchar(15) NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `county` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `long` decimal(10,6) NOT NULL,
  `lat` decimal(10,6) NOT NULL,
  `last_time` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `images` varchar(500) NOT NULL,
  `business_hours` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `pigcms_store_physical`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_store_supplier`
--

CREATE TABLE IF NOT EXISTS `pigcms_store_supplier` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商店铺id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商店铺id',
  `supply_chain` varchar(500) NOT NULL DEFAULT '' COMMENT '供货链',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '级别',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分销类型，0 全网分销 1排他分销',
  PRIMARY KEY (`pigcms_id`),
  KEY `supplier_id` (`supplier_id`) USING BTREE,
  KEY `seller_id` (`seller_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='供货商' AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `pigcms_store_supplier`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_store_user_data`
--

CREATE TABLE IF NOT EXISTS `pigcms_store_user_data` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `point_count` int(11) NOT NULL,
  `order_unpay` mediumint(9) NOT NULL,
  `order_unsend` mediumint(9) NOT NULL,
  `order_send` mediumint(9) NOT NULL,
  `order_complete` mediumint(9) NOT NULL,
  `last_time` int(11) NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`,`uid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺用户数据表' AUTO_INCREMENT=16 ;

--
-- 导出表中的数据 `pigcms_store_user_data`
--

INSERT INTO `pigcms_store_user_data` (`pigcms_id`, `store_id`, `uid`, `point`, `point_count`, `order_unpay`, `order_unsend`, `order_send`, `order_complete`, `last_time`) VALUES
(13, 29, 66, 0, 0, 0, 0, 0, 1, 1439993691),
(14, 29, 67, 0, 0, 3, 0, 0, 1, 1439993578),
(15, 29, 68, 0, 0, 0, 1, 0, 0, 1439993625);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_store_withdrawal`
--

CREATE TABLE IF NOT EXISTS `pigcms_store_withdrawal` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(100) NOT NULL DEFAULT '' COMMENT '交易号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `bank_id` int(11) NOT NULL DEFAULT '0' COMMENT '银行id',
  `opening_bank` varchar(30) NOT NULL DEFAULT '' COMMENT '开户行',
  `bank_card` varchar(30) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `bank_card_user` varchar(30) NOT NULL DEFAULT '' COMMENT '开卡人姓名',
  `withdrawal_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '提现方式 0对私 1对公',
  `add_time` varchar(20) NOT NULL DEFAULT '' COMMENT '申请时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1申请中 2银行处理中 3提现成功 4提现失败',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `complate_time` varchar(20) NOT NULL DEFAULT '' COMMENT '完成时间',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `bank_id` (`bank_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='提现' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_store_withdrawal`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_system_info`
--

CREATE TABLE IF NOT EXISTS `pigcms_system_info` (
  `lastsqlupdate` int(10) NOT NULL,
  `version` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `pigcms_system_info`
--

INSERT INTO `pigcms_system_info` (`lastsqlupdate`, `version`) VALUES
(7620, '');

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_system_menu`
--

CREATE TABLE IF NOT EXISTS `pigcms_system_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `name` char(20) NOT NULL,
  `module` char(20) NOT NULL,
  `action` char(20) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统后台菜单表' AUTO_INCREMENT=61 ;

--
-- 导出表中的数据 `pigcms_system_menu`
--

INSERT INTO `pigcms_system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES
(1, 0, '后台首页', '', '', 10, 1, 1),
(2, 0, '系统设置', '', '', 9, 1, 1),
(3, 0, '商品管理', '', '', 7, 1, 1),
(4, 0, '订单管理', '', '', 6, 1, 1),
(5, 0, '用户管理', '', '', 5, 1, 1),
(6, 1, '后台首页', 'index', 'main', 0, 1, 1),
(7, 1, '修改密码', 'index', 'pass', 0, 1, 1),
(8, 1, '个人资料', 'index', 'profile', 0, 1, 1),
(9, 1, '更新缓存', 'index', 'cache', 0, 0, 1),
(10, 2, '站点配置', 'config', 'index', 0, 1, 1),
(11, 2, '友情链接', 'flink', 'index', 0, 1, 1),
(12, 0, '店铺管理', '', '', 4, 1, 1),
(13, 12, '店铺列表', 'Store', 'index', 0, 1, 1),
(14, 2, '城市区域', 'area', 'index', 0, 0, 0),
(15, 3, '商品列表', 'Product', 'index', 0, 1, 1),
(16, 3, '商品分类', 'Product', 'category', 0, 1, 1),
(17, 2, '广告管理', 'Adver', 'index', 0, 1, 1),
(19, 2, '导航管理', 'Slider', 'index', 0, 1, 1),
(20, 2, '热门搜索词', 'Search_hot', 'index', 0, 1, 1),
(21, 24, '自定义菜单', 'diymenu', 'index', 0, 1, 1),
(22, 2, '快递公司', 'Express', 'index', 0, 1, 1),
(23, 12, '收支明细', 'Store', 'inoutdetail', 0, 1, 1),
(24, 0, '微信设置', '', '', 8, 1, 1),
(25, 24, '首页回复配置', 'home', 'index', 0, 1, 1),
(28, 4, '所有订单', 'Order', 'index', 0, 1, 1),
(29, 5, '用户列表', 'user', 'index', 0, 1, 1),
(30, 24, '首次关注回复', 'home', 'first', 0, 1, 1),
(31, 24, '关键词回复', 'home', 'other', 0, 1, 1),
(32, 2, '平台会员卡', 'Card', 'index', 0, 0, 0),
(33, 24, '模板消息', 'templateMsg', 'index', 0, 1, 1),
(34, 4, '到店自提订单', 'Order', 'selffetch', 0, 1, 1),
(35, 4, '货到付款订单', 'Order', 'codpay', 0, 1, 1),
(36, 4, '代付的订单', 'Order', 'payagent', 0, 1, 1),
(37, 12, '主营类目', 'Store', 'category', 0, 1, 1),
(38, 12, '提现记录', 'Store', 'withdraw', 0, 1, 1),
(40, 3, '商品分组', 'Product', 'group', 0, 1, 1),
(44, 2, '商品栏目属性列表', 'Sys_product_property', 'property', 0, 1, 1),
(45, 2, '商品栏目属性值列表', 'Sys_product_property', 'propertyValue', 0, 1, 1),
(46, 2, '商城评论标签', 'Tag', 'index', 0, 1, 1),
(49, 2, '敏感词', 'Ng_word', 'index', 0, 1, 1),
(50, 12, '品牌类别管理', 'Store', 'brandType', 0, 1, 1),
(51, 12, '品牌管理', 'Store', 'brand', 0, 1, 1),
(53, 12, '营销活动管理', 'Store', 'activityManage', 0, 1, 1),
(54, 12, '营销活动展示', 'Store', 'activityRecommend', 0, 1, 1),
(55, 12, '店铺对账日志', 'Order', 'checklog', 0, 1, 1),
(58, 3, '被分销的源商品列表', 'Product', 'fxlist', 0, 1, 1),
(59, 3, '商品评价管理', 'Product', 'comment', 0, 1, 1),
(60, 12, '店铺评价管理', 'Store', 'comment', 0, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_system_product_property`
--

CREATE TABLE IF NOT EXISTS `pigcms_system_product_property` (
  `pid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序字段',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1：启用，0：关闭',
  `property_type_id` smallint(5) NOT NULL COMMENT '产品属性所属类别id',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品栏目属性名表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_system_product_property`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_system_product_to_property_value`
--

CREATE TABLE IF NOT EXISTS `pigcms_system_product_to_property_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '系统筛选表id',
  `vid` int(10) NOT NULL DEFAULT '0' COMMENT '系统筛选属性值id',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `vid` (`vid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品关联筛选属性值表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_system_product_to_property_value`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_system_property_type`
--

CREATE TABLE IF NOT EXISTS `pigcms_system_property_type` (
  `type_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(80) NOT NULL COMMENT '属性类别名',
  `type_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1为开启，0为关闭',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品属性的类别表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_system_property_type`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_system_property_value`
--

CREATE TABLE IF NOT EXISTS `pigcms_system_property_value` (
  `vid` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品栏目属性值id',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '商品栏目属性名id',
  `value` varchar(50) NOT NULL DEFAULT '' COMMENT '商品栏目属性值',
  PRIMARY KEY (`vid`),
  KEY `pid` (`pid`) USING BTREE,
  KEY `pid_2` (`pid`,`value`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品栏目属性值' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_system_property_value`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_system_tag`
--

CREATE TABLE IF NOT EXISTS `pigcms_system_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT 'system_property_type表type_id，主要是为了方便查找',
  `name` varchar(100) NOT NULL COMMENT '标签名',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1为开启，0：关闭',
  UNIQUE KEY `id` (`id`),
  KEY `tid` (`tid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统标签表' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_system_tag`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_tempmsg`
--

CREATE TABLE IF NOT EXISTS `pigcms_tempmsg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tempkey` char(50) NOT NULL,
  `name` char(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `industry` char(50) NOT NULL,
  `topcolor` char(10) NOT NULL DEFAULT '#029700',
  `textcolor` char(10) NOT NULL DEFAULT '#000000',
  `token` char(40) NOT NULL,
  `tempid` char(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tempkey` (`tempkey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_tempmsg`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_text`
--

CREATE TABLE IF NOT EXISTS `pigcms_text` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `content` varchar(200) NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_text`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_trade_selffetch`
--

CREATE TABLE IF NOT EXISTS `pigcms_trade_selffetch` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `province` mediumint(9) NOT NULL,
  `city` mediumint(9) NOT NULL,
  `county` mediumint(9) NOT NULL,
  `address` varchar(150) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `last_time` int(11) NOT NULL,
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='买家上门自提' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_trade_selffetch`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_trade_setting`
--

CREATE TABLE IF NOT EXISTS `pigcms_trade_setting` (
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  `pay_cancel_time` smallint(6) NOT NULL COMMENT '自动取消订单时间',
  `pay_alert_time` smallint(6) NOT NULL COMMENT '自动催付订单时间',
  `sucess_notice` tinyint(1) NOT NULL COMMENT '支付成功是否通知',
  `send_notice` tinyint(1) NOT NULL COMMENT '发货是否通知',
  `complain_notice` tinyint(1) NOT NULL COMMENT '维权是否通知',
  `last_time` int(11) NOT NULL,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='交易物流通知';

--
-- 导出表中的数据 `pigcms_trade_setting`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_ucenter`
--

CREATE TABLE IF NOT EXISTS `pigcms_ucenter` (
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `page_title` varchar(100) NOT NULL COMMENT '页面名称',
  `bg_pic` varchar(200) NOT NULL COMMENT '背景图片',
  `show_level` char(1) NOT NULL DEFAULT '1' COMMENT '显示会员等级 0不显示 1显示',
  `show_point` char(1) NOT NULL DEFAULT '1' COMMENT '显示用户积分 0不显示 1显示',
  `has_custom` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有自定义字段',
  `last_time` int(11) NOT NULL COMMENT '最后编辑时间',
  UNIQUE KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户中心';

--
-- 导出表中的数据 `pigcms_ucenter`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_user`
--

CREATE TABLE IF NOT EXISTS `pigcms_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `phone` varchar(20) NOT NULL COMMENT '手机号',
  `openid` varchar(50) NOT NULL COMMENT '微信唯一标识',
  `reg_time` int(10) unsigned NOT NULL,
  `reg_ip` bigint(20) unsigned NOT NULL,
  `last_time` int(10) unsigned NOT NULL,
  `last_ip` bigint(20) unsigned NOT NULL,
  `check_phone` tinyint(1) NOT NULL DEFAULT '0',
  `login_count` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `intro` varchar(500) NOT NULL DEFAULT '' COMMENT '个人签名',
  `avatar` varchar(200) NOT NULL DEFAULT '' COMMENT '头像',
  `is_weixin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是微信用户 0否 1是',
  `stores` smallint(6) NOT NULL DEFAULT '0' COMMENT '店铺数量',
  `token` varchar(100) NOT NULL DEFAULT '' COMMENT '微信token',
  `session_id` varchar(50) NOT NULL DEFAULT '' COMMENT 'session id',
  `server_key` varchar(50) NOT NULL DEFAULT '',
  `source_site_url` varchar(200) NOT NULL DEFAULT '' COMMENT '来源网站',
  `payment_url` varchar(200) NOT NULL DEFAULT '' COMMENT '站外支付地址',
  `notify_url` varchar(200) NOT NULL DEFAULT '' COMMENT '通知地址',
  `oauth_url` varchar(200) NOT NULL DEFAULT '' COMMENT '对接网站用户认证地址',
  `is_seller` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是卖家',
  `third_id` varchar(50) NOT NULL DEFAULT '' COMMENT '第三方id',
  `drp_store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户所属店铺',
  `app_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对接应用id',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '后台ID',
  PRIMARY KEY (`uid`),
  KEY `phone` (`phone`) USING BTREE,
  KEY `nickname` (`nickname`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

--
-- 导出表中的数据 `pigcms_user`
--

INSERT INTO `pigcms_user` (`uid`, `nickname`, `password`, `phone`, `openid`, `reg_time`, `reg_ip`, `last_time`, `last_ip`, `check_phone`, `login_count`, `status`, `intro`, `avatar`, `is_weixin`, `stores`, `token`, `session_id`, `server_key`, `source_site_url`, `payment_url`, `notify_url`, `oauth_url`, `is_seller`, `third_id`, `drp_store_id`, `app_id`, `admin_id`) VALUES
(82, 'admin', 'dcf867ea8921bdf2da27a754597e83d8', '', '', 1444656725, 2130706433, 1444656725, 2130706433, 0, 0, 1, '', '', 0, 0, '', '', '', '', '', '', '', 0, '', 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_user_address`
--

CREATE TABLE IF NOT EXISTS `pigcms_user_address` (
  `address_id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `session_id` varchar(32) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人',
  `tel` varchar(20) NOT NULL COMMENT '联系电话',
  `province` mediumint(9) NOT NULL COMMENT '省code',
  `city` mediumint(9) NOT NULL COMMENT '市code',
  `area` mediumint(9) NOT NULL COMMENT '区code',
  `address` varchar(300) NOT NULL DEFAULT '' COMMENT '详细地址',
  `zipcode` varchar(10) NOT NULL COMMENT '邮编',
  `default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认收货地址',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='收货地址' AUTO_INCREMENT=9 ;

--
-- 导出表中的数据 `pigcms_user_address`
--

INSERT INTO `pigcms_user_address` (`address_id`, `uid`, `session_id`, `name`, `tel`, `province`, `city`, `area`, `address`, `zipcode`, `default`, `add_time`) VALUES
(6, 67, '', '彭', '13800138000', 120000, 120100, 120103, '还差', '518865', 0, 1439991789),
(7, 66, '', '王', '13356985633', 130000, 130300, 130303, '人民广场', '0', 0, 1439992001),
(8, 68, '', '马旺', '18812256563', 140000, 140400, 140421, '明明', '646466', 0, 1439993591);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_user_attention`
--

CREATE TABLE IF NOT EXISTS `pigcms_user_attention` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `data_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当type=1，这里值为商品id，type=2，此值为店铺id',
  `data_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型  1，商品 2，店铺',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- 导出表中的数据 `pigcms_user_attention`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_user_cart`
--

CREATE TABLE IF NOT EXISTS `pigcms_user_cart` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sku_id` int(11) NOT NULL,
  `sku_data` text NOT NULL COMMENT '库存信息',
  `pro_num` int(11) NOT NULL,
  `pro_price` decimal(10,2) NOT NULL,
  `add_time` int(11) NOT NULL,
  `comment` text NOT NULL,
  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为分销商品',
  PRIMARY KEY (`pigcms_id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `session_id` (`session_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户的购物车' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_user_cart`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_user_collect`
--

CREATE TABLE IF NOT EXISTS `pigcms_user_collect` (
  `collect_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dataid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '当type=1，这里值为商品id，type=2，此值为店铺id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL COMMENT '1:为商品；2:为店铺',
  `is_attention` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否被关注(0:不关注，1：关注)',
  PRIMARY KEY (`collect_id`),
  KEY `user_id` (`user_id`),
  KEY `goods_id` (`dataid`),
  KEY `is_attention` (`is_attention`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户收藏店铺or商品' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_user_collect`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_user_coupon`
--

CREATE TABLE IF NOT EXISTS `pigcms_user_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `store_id` int(11) NOT NULL COMMENT '商铺id',
  `coupon_id` int(11) NOT NULL COMMENT '优惠券ID',
  `card_no` char(32) NOT NULL COMMENT '卡号',
  `cname` varchar(255) NOT NULL COMMENT '优惠券名称',
  `face_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券面值(起始)',
  `limit_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用优惠券的订单金额下限（为0：为不限定）',
  `start_time` int(11) NOT NULL COMMENT '生效时间',
  `end_time` int(11) NOT NULL COMMENT '过期时间',
  `is_expire_notice` tinyint(1) NOT NULL COMMENT '到期提醒（0：不提醒；1：提醒）',
  `is_share` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许分享链接（0：不允许；1：允许）',
  `is_all_product` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否全店通用（0：全店通用；1：指定商品使用）',
  `is_original_price` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:非原价购买可使用；1：原价购买商品时可',
  `description` text NOT NULL COMMENT '使用说明',
  `is_use` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用',
  `is_valid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:不可以使用，1：可以使用',
  `use_time` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券使用时间',
  `timestamp` int(11) NOT NULL COMMENT '领取优惠券的时间',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '券类型（1：优惠券，2：赠送券）',
  `give_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '赠送的订单id',
  `use_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用的订单id',
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除(0:未删除，1：已删除)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_no` (`card_no`),
  KEY `coupon_id` (`coupon_id`),
  KEY `uid` (`uid`),
  KEY `type` (`type`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户领取的优惠券信息' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_user_coupon`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_weixin_bind`
--

CREATE TABLE IF NOT EXISTS `pigcms_weixin_bind` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `authorizer_appid` varchar(100) NOT NULL COMMENT '授权方appid',
  `authorizer_refresh_token` varchar(500) NOT NULL COMMENT '刷新令牌',
  `func_info` varchar(50) NOT NULL COMMENT '公众号授权给开发者的权限集列表',
  `head_img` varchar(300) NOT NULL COMMENT '授权方头像',
  `service_type_info` tinyint(1) NOT NULL COMMENT '授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号',
  `verify_type_info` tinyint(1) NOT NULL COMMENT '授权方认证类型，-1代表未认证，0代表微信认证，1代表新浪微博认证，2代表腾讯微博认证，3代表已资质认证通过但还未通过名称认证，4代表已资质认证通过、还未通过名称认证，但通过了新浪微博认证，5代表已资质认证通过、还未通过名称认证，但通过了腾讯微博认证',
  `user_name` varchar(70) NOT NULL COMMENT '授权方公众号的原始ID',
  `nick_name` varchar(30) NOT NULL COMMENT '授权方昵称',
  `alias` varchar(30) NOT NULL COMMENT '授权方公众号所设置的微信号，可能为空',
  `qrcode_url` varchar(300) NOT NULL COMMENT '二维码图片的URL',
  `wxpay_mchid` varchar(50) NOT NULL,
  `wxpay_key` varchar(50) NOT NULL,
  `wxpay_test` tinyint(1) NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `user_name` (`user_name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='绑定微信信息' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `pigcms_weixin_bind`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_wei_page`
--

CREATE TABLE IF NOT EXISTS `pigcms_wei_page` (
  `page_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '页面id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `page_name` varchar(50) NOT NULL COMMENT '页面标题',
  `page_desc` varchar(1000) NOT NULL COMMENT '页面描述',
  `bgcolor` varchar(10) NOT NULL COMMENT '背景颜色',
  `is_home` tinyint(1) NOT NULL DEFAULT '0' COMMENT '主页 0否 1是',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建日期',
  `product_count` int(10) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `hits` int(10) NOT NULL DEFAULT '0' COMMENT '页面浏览量',
  `page_sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `has_category` tinyint(1) NOT NULL,
  `has_custom` tinyint(1) NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微页面' AUTO_INCREMENT=130 ;

--
-- 导出表中的数据 `pigcms_wei_page`
--

INSERT INTO `pigcms_wei_page` (`page_id`, `store_id`, `page_name`, `page_desc`, `bgcolor`, `is_home`, `add_time`, `product_count`, `hits`, `page_sort`, `has_category`, `has_custom`) VALUES
(48, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(47, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(46, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(45, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(44, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(43, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(42, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(41, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(40, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(39, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(38, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(37, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(36, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(35, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(34, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(33, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(49, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(50, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(51, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(52, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(53, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(54, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(55, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(56, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(57, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(58, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(59, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(60, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(61, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(62, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(63, 26, '这是您的第一篇微杂志', '', '', 1, 1439909414, 0, 0, 0, 0, 1),
(64, 27, '远亮商城', '', '', 1, 1439990314, 0, 0, 0, 0, 1),
(65, 28, '这是您的第一篇微杂志', '', '', 1, 1439989853, 0, 0, 0, 0, 1),
(66, 29, '这是您的第一篇微杂志', '', '', 1, 1439990751, 0, 0, 0, 0, 1),
(67, 30, '这是您的第一篇微杂志', '', '', 1, 1439990798, 0, 0, 0, 0, 1),
(68, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(69, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(70, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(71, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(72, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(73, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(74, 31, '这是您的第一篇微杂志', '', '', 1, 1439993571, 0, 0, 0, 0, 1),
(75, 32, '这是您的第一篇微杂志', '', '', 1, 1439993893, 0, 0, 0, 0, 1),
(76, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(77, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(78, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(79, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(80, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(81, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(82, 33, '这是您的第一篇微杂志', '', '', 1, 1440035329, 0, 0, 0, 0, 1),
(83, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(84, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(85, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(86, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(87, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(88, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(89, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(90, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(91, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(92, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(93, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(94, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(95, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(96, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(97, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(98, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(99, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(100, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(101, 34, '这是您的第一篇微杂志', '', '', 1, 1440328182, 0, 0, 0, 0, 1),
(102, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(103, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(104, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(105, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(106, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(107, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(108, 35, '这是您的第一篇微杂志', '', '', 1, 1440398189, 0, 0, 0, 0, 1),
(109, 35, '狗扑源码论坛_gope.cn', '狗扑源码论坛_gope.cn', '', 0, 1440398495, 0, 0, 0, 0, 1),
(110, 36, '这是您的第一篇微杂志', '', '', 1, 1440400385, 0, 0, 0, 0, 1),
(111, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(112, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(113, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(114, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(115, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(116, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(117, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(118, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(119, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(120, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(121, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(122, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1),
(123, 37, '这是您的第一篇微杂志', '', '', 1, 1443460616, 0, 0, 0, 0, 1),
(124, 0, '通用模板', '通用模板', '', 0, 1438999689, 0, 0, 0, 1, 1),
(125, 0, '餐饮外卖模板', '餐饮外卖模板', '', 0, 1438999668, 0, 0, 0, 1, 1),
(126, 0, '食品电商模板', '食品电商模板', '', 0, 1438999652, 0, 0, 0, 1, 1),
(127, 0, '美妆电商模板', '美妆电商模板', '', 0, 1438999625, 0, 0, 0, 1, 1),
(128, 0, '线下门店模板', '线下门店模板', '', 0, 1438999588, 0, 0, 0, 1, 1),
(129, 0, '鲜花速递模板', '鲜花速递模板', '', 1, 1438999567, 0, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `pigcms_wei_page_category`
--

CREATE TABLE IF NOT EXISTS `pigcms_wei_page_category` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '微页面分类id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名',
  `first_sort` varchar(20) NOT NULL DEFAULT '' COMMENT '排序 pv DESC order_by DESC',
  `second_sort` varchar(20) NOT NULL DEFAULT '' COMMENT '排序 date_added DESC date_added DESC pv DESC',
  `show_style` char(1) NOT NULL DEFAULT '0' COMMENT '显示样式 0仅显示杂志列表 1用期刊方式展示',
  `cat_desc` text NOT NULL COMMENT '简介',
  `page_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '微页面数',
  `has_custom` tinyint(1) NOT NULL,
  `add_time` int(11) NOT NULL COMMENT '创建日期',
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微页面分类' AUTO_INCREMENT=4 ;

--
-- 导出表中的数据 `pigcms_wei_page_category`
--


-- --------------------------------------------------------

--
-- 表的结构 `pigcms_wei_page_to_category`
--

CREATE TABLE IF NOT EXISTS `pigcms_wei_page_to_category` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL DEFAULT '0' COMMENT '微页面id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '微页面分类id',
  PRIMARY KEY (`pigcms_id`),
  KEY `wei_page_id` (`page_id`) USING BTREE,
  KEY `wei_page_category_id` (`cat_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微页面关联分类' AUTO_INCREMENT=8 ;

--
-- 导出表中的数据 `pigcms_wei_page_to_category`
--

