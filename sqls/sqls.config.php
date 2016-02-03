<?php
header("Content-type: text/html; charset=utf-8");
return array(
/*sqls*/
//2015-08-15 14:51:58
array('time'=>mktimes(1970,1,1,10,01),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}business_hour` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',  `business_time` varchar(100) DEFAULT '' COMMENT '营业时间',  `is_open` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-08-15 14:33:58
array('time'=>mktimes(1970,1,1,10,08),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}business_hour` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',  `business_time` varchar(100) DEFAULT '' COMMENT '营业时间',  `is_open` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-08-13 15:27:17
array('time'=>mktimes(1970,1,1,10,07),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD template_id int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模板ID'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,06),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD template_cat_id int(11) NOT NULL DEFAULT '0' COMMENT '店铺模板ID'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,05),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}wei_page_category` ADD page_id int(10) unsigned NOT NULL DEFAULT '0'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,04),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user` ADD admin_id int(10) unsigned NOT NULL DEFAULT '0' COMMENT '后台ID'",'des'=>'...'),

//2015-08-12 13:27:55
array('time'=>mktimes(1970,1,1,10,00),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES(100, 'synthesize_store', '', '1', '', '综合商城预览', '0', '', 1, 0, 0)",'des'=>'...'),

//2015-08-12 10:50:20
array('time'=>mktimes(1970,1,1,9,59),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (99, 'ischeck_store', 'type=select&value=1:开店需要审核|0:开店无需审核', '0', '开店是否要审核', '开启后，会员开店需要后台审核通过后，店铺才能正常使用', '0', '', '1', '0', '1')",'des'=>'...'),
//2015-08-11 17:26:51
array('time'=>mktimes(1970,1,1,9,58),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) values('60','12','店铺评价管理','Store','comment','0','1','1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,57),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) values('59','3','商品评价管理','Product','comment','0','1','1')",'des'=>'...'),

//2015-08-10 10:07:58
array('time'=>mktimes(1970,1,1,9,56),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}tempmsg` (  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,  `tempkey` char(50) NOT NULL,  `name` char(100) NOT NULL,  `content` varchar(1000) NOT NULL,  `industry` char(50) NOT NULL,  `topcolor` char(10) NOT NULL DEFAULT '#029700',  `textcolor` char(10) NOT NULL DEFAULT '#000000',  `token` char(40) NOT NULL,  `tempid` char(100) DEFAULT NULL,  `status` tinyint(4) NOT NULL DEFAULT '0',  PRIMARY KEY (`id`),  KEY `tempkey` (`tempkey`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),

//2015-08-08 16:39:36
array('time'=>mktimes(1970,1,1,9,55),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_sku` ADD COLUMN `drp_level_1_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品价格' AFTER `max_fx_price`,ADD COLUMN `drp_level_2_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品价格' AFTER `drp_level_1_price`,ADD COLUMN `drp_level_3_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品价格' AFTER `drp_level_2_price`,ADD COLUMN `drp_level_1_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品成本价格' AFTER `drp_level_3_price`,ADD COLUMN `drp_level_2_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品成本价格' AFTER `drp_level_1_cost_price`,ADD COLUMN `drp_level_3_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品成本价格' AFTER `drp_level_2_cost_price`",'des'=>'...'),

//2015-08-07 13:16:25
array('time'=>mktimes(1970,1,1,9,51),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `open_friend` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '是否开启送朋友，1：是，0：否' AFTER  `open_logistics`",'des'=>'...'),

//2015-08-06 13:43:58
array('time'=>mktimes(1970,1,1,9,50),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) values(58, '3','被分销的源商品列表','Product','fxlist','0','1','1')",'des'=>'...'),

//2015-08-06 13:09:26
array('time'=>mktimes(1970,1,1,9,49),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product` ADD COLUMN `is_hot` TINYINT(1) DEFAULT 0 NOT NULL COMMENT '是否热门 0否 1是' AFTER `drp_level_3_cost_price`",'des'=>'...'),

//2015-08-06 10:19:42
array('time'=>mktimes(1970,1,1,9,48),'type'=>'sql','sql'=>"UPDATE `{tableprefix}config` SET `type` = 'type=text&size=3&validate=required:true,number:true,maxlength:2' WHERE `{tableprefix}config`.`name` = 'sales_ratio'",'des'=>'...'),

//2015-08-05 17:52:15
array('time'=>mktimes(1970,1,1,9,47),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` ADD COLUMN `sales_ratio` DECIMAL(10,2) NOT NULL COMMENT '商家销售分成比例,按照所填百分比进行扣除' AFTER `storeOpenid`",'des'=>'...'),

//2015-08-05 17:04:29
array('time'=>mktimes(1970,1,1,9,46),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('sales_ratio','type=text&size=3&validate=required:true,number:true,maxlength:3','2','商家销售分成比例','例：填入：2，则相应扣除2%，最高位100%，按照所填百分比进行扣除','0','','1','0','1')",'des'=>'...'),

//2015-08-01 15:41:32
array('time'=>mktimes(1970,1,1,9,45),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_image`ADD COLUMN `sort`  tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序' AFTER `image`,ADD INDEX (`sort`) USING BTREE",'des'=>'...'),

//2015-07-30 9:06:04
array('time'=>mktimes(1970,1,1,9,44),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `drp_limit_condition`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 或（2个条件满足一个即可分销） 1 和（2个条件都满足即可分销）' AFTER `drp_limit_share`",'des'=>'...'),

//2015-07-30 9:05:45
array('time'=>mktimes(1970,1,1,9,43),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `open_drp_guidance`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '店铺分销引导' AFTER `token`,ADD COLUMN `open_drp_limit`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销限制' AFTER `open_drp_guidance`,ADD COLUMN `drp_limit_buy`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '消费多少金额可分销' AFTER `open_drp_limit`,ADD COLUMN `drp_limit_share`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分享多少次可分销' AFTER `drp_limit_buy`,ADD INDEX `token` (`token`) USING BTREE",'des'=>'...'),



//2015-08-03 19:01:19
array('time'=>mktimes(1970,1,1,9,42),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}adver_category` VALUES (13, 'pc-首页活动广告', 'pc_index_activity')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,41),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}adver_category` VALUES (12, 'pc-活动页附近活动（4）', 'pc_activity_nearby')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,40),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}adver_category` VALUES (11, 'pc-活动页热门活动（4）', 'pc_activity_hot')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,39),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}adver_category` VALUES (10, 'pc-活动页今日推荐（1）', 'pc_activity_rec')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,38),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}adver_category` VALUES ( 9, 'pc-活动页头部幻灯片（6）', 'pc_activity_slider')",'des'=>'...'),


//2015-08-03 11:29:48
array('time'=>mktimes(1970,1,1,9,37),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('pc_shopercenter_logo','type=image&validate=required:true,url:true','','商家中心LOGO图','请填写带LOGO的网址，包含（http://域名）','0','','1','0','1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,36),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('pc_usercenter_logo','type=image&validate=required:true,url:true','','PC-个人用户中心LOGO图','请填写带LOGO的网址，包含（http://域名）','0','','1','0','1')",'des'=>'...'),

//2015-08-01 15:48:33
array('time'=>mktimes(1970,1,1,9,34),'type'=>'sql','sql'=>"INSERT INTO  `{tableprefix}config` (`name` ,`type` ,`value` ,`info` ,`desc` ,`tab_id`, `tab_name` ,`gid` ,`sort` ,`status`) VALUES ('is_have_activity',  'type=radio&value=1:有|0:没有',  '1',  '活动',  '首页是否需要展示营销活动',  '0',  '0',  '1',  '0',  '0')",'des'=>'...'),

//2015-08-01 15:14:44
array('time'=>mktimes(1970,1,1,9,33),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}order_check_log` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `order_id` int(10) DEFAULT NULL COMMENT '订单id',  `order_no` varchar(100) DEFAULT NULL COMMENT '订单号',  `store_id` int(11) DEFAULT NULL COMMENT '被操作的商铺id',  `description` varchar(255) DEFAULT NULL COMMENT '描述',  `admin_uid` int(11) DEFAULT NULL COMMENT '操作人uid',  `ip` bigint(20) DEFAULT NULL COMMENT '操作人ip',  `timestamp` int(11) DEFAULT NULL COMMENT '记录的时间',  PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,32),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` ADD `is_check` TINYINT( 1 ) NOT NULL DEFAULT '1' COMMENT '是否对账，1：未对账，2：已对账' AFTER `storeOpenid`",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,31),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES(55, 12, '店铺对账日志', 'Order', 'checklog', 0, 1, 1)",'des'=>'...'),

//2015-08-01 15:10:52
array('time'=>mktimes(1970,1,1,9,30),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}activity_recommend` ADD  `is_rec` TINYINT( 1 ) NOT NULL ,ADD  `ucount` INT NOT NULL",'des'=>'...'),

//2015-07-31 16:36:09
array('time'=>mktimes(1970,1,1,9,29),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}activity_recommend` ADD COLUMN `time`  int NULL",'des'=>'...'),

array('time'=>mktimes(1970,1,1,9,28),'type'=>'sql','sql'=>"CREATE TABLE If Not Exists `{tableprefix}activity_recommend` (`id`  int NOT NULL AUTO_INCREMENT ,`modelId`  int NULL ,`title`  varchar(500) NULL ,`info`  varchar(2000) NULL ,`image`  varchar(200) NULL ,`token`  char(50) NULL ,`model`  char(20) NULL ,PRIMARY KEY (`id`),INDEX (`modelId`, `token`, `model`) USING BTREE )ENGINE=MyISAMDEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ciCOMMENT='推荐活动'CHECKSUM=0DELAY_KEY_WRITE=0",'des'=>'...'),

//2015-07-29 9:49:14
array('time'=>mktimes(1970,1,1,9,27),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`) VALUES (54,'12', '营销活动展示', 'Store', 'activityRecommend')",'des'=>'...'),

//2015-07-29 9:42:23
array('time'=>mktimes(1970,1,1,9,26),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`) VALUES (53, '12', '营销活动管理', 'Store', 'activityManage')",'des'=>'...'),

//2015-07-30 11:04:57
array('time'=>mktimes(1970,1,1,9,27),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `open_logistics` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '是否开启物流配送，1：开启，0：关闭' AFTER  `offline_payment`",'des'=>'...'),

//2015-07-29 17:07:33
array('time'=>mktimes(1970,1,1,9,26),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `buyer_selffetch_name` VARCHAR( 50 ) NOT NULL COMMENT  '“上门自提”自定义名称' AFTER  `buyer_selffetch`",'des'=>'...'),

//2015-07-28 17:57:53
array('time'=>mktimes(1970,1,1,9,25),'type'=>'sql','sql'=>"INSERT INTO  `{tableprefix}config` (`name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('syn_domain', 'type=text', '', '营销活动地址', '部分功能需要调用平台内容，需要用到该网址', '0', '', '8', '-2', '1'), ('encryption', 'type=text', '', '营销活动key', '与平台对接时需要用到', '0', '', '8', '-1', '1')",'des'=>'...'),

//2015-07-27 16:51:55
array('time'=>mktimes(1970,1,1,9,24),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `pigcmsToken` CHAR( 100 ) NULL",'des'=>'...'),


//2015-07-20 17:08:46
array('time'=>mktimes(1970,1,1,9,23),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}location_qrcode` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `ticket` varchar(500) NOT NULL,  `status` tinyint(1) NOT NULL,  `add_time` int(11) NOT NULL,  `openid` char(40) NOT NULL,  `lat` char(10) NOT NULL,  `lng` char(10) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=400000000 DEFAULT CHARSET=utf8 COMMENT='使用微信登录生成的临时二维码'",'des'=>'...'),

//2015-07-18 15:15:38
array('time'=>mktimes(1970,1,1,9,22),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`) VALUES (51, '12', '品牌管理', 'Store', 'brand')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,21),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`) VALUES (50, '12', '品牌类别管理', 'Store', 'brandType')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,20),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `open_drp_approve` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启分销商审核' AFTER `wxpay`,ADD COLUMN `drp_approve` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分销商审核状态' AFTER `open_drp_approve`,ADD COLUMN `drp_profit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销利润' AFTER `drp_approve`,ADD COLUMN `drp_profit_withdrawal` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销利润提现' AFTER `drp_profit`",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,19),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('weidian_key', 'type=salt', 'pigcms', '微店KEY', '对接微店使用的KEY，请妥善保管', '0', '', '1', '0', '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,18),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product` ADD COLUMN `drp_profit` decimal(11,0) unsigned NOT NULL DEFAULT '0' COMMENT '商品分销利润总额' AFTER `attention_num`,ADD COLUMN `drp_seller_qty` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商数量(被分销次数)' AFTER `drp_profit`,ADD COLUMN `drp_sale_qty` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商品销量' AFTER `drp_seller_qty`,ADD COLUMN `unified_price_setting` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '供货商统一定价' AFTER `drp_sale_qty`,ADD COLUMN `drp_level_1_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品价格' AFTER `unified_price_setting`,ADD COLUMN `drp_level_2_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品价格' AFTER `drp_level_1_price`,ADD COLUMN `drp_level_3_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品价格' AFTER `drp_level_2_price`,ADD COLUMN `drp_level_1_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品成本价格' AFTER `drp_level_3_price`,ADD COLUMN `drp_level_2_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品成本价格' AFTER `drp_level_1_cost_price`,ADD COLUMN `drp_level_3_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品成本价格' AFTER `drp_level_2_cost_price`",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,17),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}product` ADD  `attention_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注数'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,16),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `attention_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注数'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,15),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}user_attention` (  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',  `data_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当type=1，这里值为商品id，type=2，此值为店铺id',  `data_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型  1，商品 2，店铺',  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-07-18 14:04:36
array('time'=>mktimes(1970,1,1,9,12),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}ng_word` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `ng_word` varchar(100) NOT NULL,  `replace_word` varchar(100) NOT NULL,  PRIMARY KEY (`id`),  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `ng_word` (`ng_word`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='敏感词表'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,11),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}system_tag` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `tid` int(11) NOT NULL DEFAULT '0' COMMENT 'system_property_type表type_id，主要是为了方便查找',  `name` varchar(100) NOT NULL COMMENT '标签名',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1为开启，0：关闭',  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `tid` (`tid`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统标签表'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,10),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}comment_tag` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '评论表ID',  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '系统标签表ID',  `relation_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联评论ID，例：产品ID，店铺ID等',  `type` enum('PRODUCT','STORE') NOT NULL DEFAULT 'PRODUCT' COMMENT '评论的类型，PRODUCT:对产品评论，STORE:对店铺评论',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `cid` (`cid`) USING BTREE,  KEY `tag_id` (`tag_id`,`relation_id`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,09),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}comment_reply` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复时间',  `cid` int(11) unsigned NOT NULL COMMENT '评论表ID',  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',  `content` text COMMENT '回复内容',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `cid` (`cid`) USING BTREE,  KEY `uid` (`uid`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论回复表'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,08),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}comment_attachment` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '评论表ID',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为图片，1为语音，2为视频',  `file` varchar(100) DEFAULT NULL COMMENT '文件地址',  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小，byte字节数',  `width` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '图片宽度',  `height` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '图片高度',  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `cid` (`cid`) USING BTREE,  KEY `uid` (`uid`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='评论附件表'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,07),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}comment` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单表ID,对产品评论时，要加订单ID，其它为0',  `relation_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联评论ID，例：产品ID，店铺ID等',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',  `score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '满意度，1-5，数值越大，满意度越高',  `logistics_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '物流满意度，1-5，数值越大，满意度越高',  `description_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '描述相符，1-5，数值越大，满意度越高',  `speed_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '发货速度，1-5，数值越大，满意度越高',  `service_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '服务态度，1-5，数值越大，满意度越高',  `type` enum('PRODUCT','STORE') NOT NULL DEFAULT 'PRODUCT' COMMENT '评论的类型，PRODUCT:对产品评论，STORE:对店铺评论',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',  `has_image` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有图片，1为有，0为没有',  `content` text NOT NULL COMMENT '评论内容',  `reply_number` int(11) NOT NULL DEFAULT '0' COMMENT '回复数',  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `relation_id` (`relation_id`) USING BTREE,  KEY `order_id` (`order_id`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='评论表'",'des'=>'...'),

//2015-07-17 11:08:34
array('time'=>mktimes(1970,1,1,9,06),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order_product` ADD  `pro_weight` FLOAT( 10, 2 ) NOT NULL COMMENT  '每一个产品的重量，单位：克' AFTER  `pro_price`",'des'=>'...'),

//2015-07-17 10:32:36
array('time'=>mktimes(1970,1,1,9,05),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}product` ADD  `weight` FLOAT( 10, 2 ) NOT NULL COMMENT  '产品重量，单位：克' AFTER  `original_price`",'des'=>'...'),

//2015-07-14 14:18:01
array('time'=>mktimes(1970,1,1,9,04),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_brand` (  `brand_id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(250) NOT NULL COMMENT '商铺品牌名',  `pic` varchar(200) NOT NULL COMMENT '品牌图片',  `order_by` int(100) NOT NULL DEFAULT '0' COMMENT '排序，越小越前面',  `store_id` int(11) NOT NULL COMMENT '商铺id',  `type_id` int(11) NOT NULL COMMENT '所属品牌类别id',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用（1：启用；  0：禁用）',  PRIMARY KEY (`brand_id`)) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='商铺品牌表'",'des'=>'...'),

//2015-07-14 14:17:37
array('time'=>mktimes(1970,1,1,9,03),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_brand_type` (  `type_id` int(11) NOT NULL AUTO_INCREMENT,  `type_name` varchar(100) NOT NULL COMMENT '商铺品牌类别名',  `order_by` int(10) NOT NULL COMMENT '排序',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '品牌状态（1：开启，0：禁用）',  PRIMARY KEY (`type_id`)) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='商铺品牌类别表'",'des'=>'...'),

//2015-07-13 16:22:32
array('time'=>mktimes(1970,1,1,9,02),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_category` CHANGE `cat_pic` `cat_pic` VARCHAR(50) CHARSET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'wap端栏目图片', ADD COLUMN `cat_pc_pic` VARCHAR(50) NOT NULL COMMENT 'pc端栏目图片' AFTER `cat_pic`",'des'=>'...'),

//2015-07-06 10:18:49
array('time'=>mktimes(1970,1,1,9,01),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_property_value` ADD `image` VARCHAR(255) NOT NULL COMMENT '属性对应图片'",'des'=>'...'),

//2015-07-04 14:15:05
array('time'=>mktimes(1970,1,1,9,00),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES (46, 2, '商城评论标签', 'Tag', 'index', 0, 1, 1),(49, 2, '敏感词', 'Ng_word', 'index', 0, 1, 1)",'des'=>'...'),

//2015-07-03 17:16:51
array('time'=>mktimes(1970,1,1,8,59),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_category` ADD `tag_str` VARCHAR(1024) NOT NULL COMMENT '标签列表，每个tag_id之间用逗号分割' AFTER `filter_attr`",'des'=>'...'),

//2015-07-03 9:54:24
array('time'=>mktimes(1970,1,1,8,58),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product` ADD `is_comment` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否已评论，1：是，0：否'",'des'=>'...'),

//2015-07-02 14:37:49
array('time'=>mktimes(1970,1,1,8,57),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}present_product` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `pid` int(11) NOT NULL COMMENT '赠品表ID',  `product_id` int(11) NOT NULL COMMENT '产品表ID',  PRIMARY KEY (`id`),  KEY `pid` (`pid`,`product_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='赠品产品列表'",'des'=>'...'),

//2015-07-02 14:36:03
array('time'=>mktimes(1970,1,1,8,56),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}present` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) NOT NULL COMMENT '添加时间',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',  `name` varchar(255) NOT NULL COMMENT '赠品名称',  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '赠品开始时间',  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '赠品结束时间',  `expire_date` int(11) NOT NULL DEFAULT '0' COMMENT '领取有效期，此只对虚拟产品,保留字段',  `expire_number` int(11) NOT NULL DEFAULT '0' COMMENT '领取限制，此只对虚拟产品，保留字段',  `number` int(11) NOT NULL DEFAULT '0' COMMENT '领取次数',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效，1：有效，0：无效，',  PRIMARY KEY (`id`),  KEY `store_id` (`store_id`,`start_time`,`end_time`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='赠品表'",'des'=>'...'),

//2015-07-02 14:34:32
array('time'=>mktimes(1970,1,1,8,55),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}reward_product` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `rid` int(11) NOT NULL COMMENT '满减/送表ID',  `product_id` int(11) NOT NULL COMMENT '产品表ID',  PRIMARY KEY (`id`),  KEY `rid` (`rid`,`product_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='满减/送产品列表'",'des'=>'...'),

//2015-07-02 14:33:54
array('time'=>mktimes(1970,1,1,8,54),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}reward_condition` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `rid` int(11) NOT NULL COMMENT '满减/送表ID',  `money` int(11) NOT NULL COMMENT '钱数限制',  `cash` int(11) NOT NULL DEFAULT '0' COMMENT '减现金，0：表示没有此选项',  `postage` int(11) NOT NULL DEFAULT '0' COMMENT '免邮费，0：表示没有此选项',  `score` int(11) NOT NULL DEFAULT '0' COMMENT '送积分，0：表示没有此选项',  `coupon` int(11) NOT NULL DEFAULT '0' COMMENT '送优惠，0：表示没有此选项',  `present` int(11) NOT NULL DEFAULT '0' COMMENT '送赠品，0：表示没有此选项',  PRIMARY KEY (`id`),  KEY `rid` (`rid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='优惠条件表'",'des'=>'...'),

//2015-07-02 14:33:20
array('time'=>mktimes(1970,1,1,8,53),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}reward` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) NOT NULL COMMENT '添加时间',  `uid` int(11) NOT NULL COMMENT '会员ID',  `store_id` int(11) NOT NULL COMMENT '店铺ID',  `name` varchar(255) NOT NULL COMMENT '活动名称',  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '优惠方式，1：普通优惠，2：多级优惠，每级优惠不累积',  `is_all` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否所有商品都参与活动，1：全部商品，2：部分商品',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效，1：有效，0：无效，',  PRIMARY KEY (`id`),  KEY `uid` (`uid`,`store_id`,`start_time`,`end_time`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='满减/送表'",'des'=>'...'),

//2015-07-02 14:31:48
array('time'=>mktimes(1970,1,1,8,52),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}order_coupon` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `order_id` int(11) NOT NULL DEFAULT '0',  `uid` int(11) NOT NULL DEFAULT '0',  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券ID',  `name` varchar(255) NOT NULL COMMENT '优惠券名称',  `user_coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT 'user_coupon表id',  `money` float(8,2) NOT NULL COMMENT '优惠券金额',  PRIMARY KEY (`id`),  KEY `uid` (`uid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-07-02 14:30:07
array('time'=>mktimes(1970,1,1,8,51),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}order_reward` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `order_id` int(11) NOT NULL COMMENT '订单表ID',  `uid` int(11) NOT NULL COMMENT '会员ID',  `rid` int(11) NOT NULL COMMENT '满减/送ID',  `name` varchar(255) NOT NULL COMMENT '活动名称',  `content` text NOT NULL COMMENT '描述序列化数组',  PRIMARY KEY (`id`),  KEY `order_id` (`order_id`,`uid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单优惠表'",'des'=>'...'),

//2015-07-02 14:25:22
array('time'=>mktimes(1970,1,1,8,50),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}coupon` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) NOT NULL,  `store_id` int(11) NOT NULL COMMENT '商铺id',  `name` varchar(255) NOT NULL COMMENT '优惠券名称',  `face_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券面值(起始)',  `limit_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用优惠券的订单金额下限（为0：为不限定）',  `most_have` int(11) NOT NULL COMMENT '单人最多拥有优惠券数量（0：不限制）',  `total_amount` int(11) NOT NULL COMMENT '发放总量',  `start_time` int(11) NOT NULL COMMENT '生效时间',  `end_time` int(11) NOT NULL COMMENT '过期时间',  `is_expire_notice` tinyint(1) NOT NULL COMMENT '到期提醒（0：不提醒；1：提醒）',  `is_share` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许分享链接（0：不允许；1：允许）',  `is_all_product` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否全店通用（0：全店通用；1：指定商品使用）',  `is_original_price` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:非原价购买可使用；1：原价购买商品时可',  `timestamp` int(11) NOT NULL COMMENT '添加优惠券的时间',  `description` text NOT NULL COMMENT '使用说明',  `used_number` int(11) NOT NULL DEFAULT '0' COMMENT '已使用数量',  `number` int(11) NOT NULL DEFAULT '0' COMMENT '已领取数量',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否失效（0：失效；1：未失效）',  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '券类型（1：优惠券； 2:赠送券）',  UNIQUE KEY `id` (`id`),  KEY `uid` (`uid`,`store_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='优惠券' AUTO_INCREMENT=21",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,49),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}user_coupon` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) NOT NULL COMMENT '用户id',  `store_id` int(11) NOT NULL COMMENT '商铺id',  `coupon_id` int(11) NOT NULL COMMENT '优惠券ID',  `card_no` char(32) NOT NULL COMMENT '卡号',  `cname` varchar(255) NOT NULL COMMENT '优惠券名称',  `face_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券面值(起始)',  `limit_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用优惠券的订单金额下限（为0：为不限定）',  `start_time` int(11) NOT NULL COMMENT '生效时间',  `end_time` int(11) NOT NULL COMMENT '过期时间',  `is_expire_notice` tinyint(1) NOT NULL COMMENT '到期提醒（0：不提醒；1：提醒）',  `is_share` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许分享链接（0：不允许；1：允许）',  `is_all_product` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否全店通用（0：全店通用；1：指定商品使用）',  `is_original_price` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:非原价购买可使用；1：原价购买商品时可',  `description` text NOT NULL COMMENT '使用说明',  `is_use` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用',  `is_valid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:不可以使用，1：可以使用',  `use_time` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券使用时间',  `timestamp` int(11) NOT NULL COMMENT '领取优惠券的时间',  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '券类型（1：优惠券，2：赠送券）',  `give_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '赠送的订单id',  `use_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用的订单id',  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除(0:未删除，1：已删除)',  PRIMARY KEY (`id`),  UNIQUE KEY `card_no` (`card_no`),  KEY `coupon_id` (`coupon_id`),  KEY `uid` (`uid`),  KEY `type` (`type`),  KEY `store_id` (`store_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户领取的优惠券信息' AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,48),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}coupon_to_product` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `coupon_id` int(11) NOT NULL COMMENT '优惠券id',  `product_id` int(11) NOT NULL COMMENT '产品id',  PRIMARY KEY (`id`),  UNIQUE KEY `id` (`id`),  UNIQUE KEY `id_2` (`id`),  KEY `coupon_id` (`coupon_id`,`product_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='优惠券产品对应表' AUTO_INCREMENT=1",'des'=>'...'),

//2015-07-01 10:18:38
array('time'=>mktimes(1970,1,1,8,47),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}attachment` ADD `ip` BIGINT(20) NOT NULL DEFAULT '0' COMMENT '用户IP地址' , ADD `agent` VARCHAR(1024) NOT NULL COMMENT '用户浏览器信息'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,46),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}attachment_user` ADD `ip` BIGINT(20) NOT NULL DEFAULT '0' COMMENT '用户IP地址' , ADD `agent` VARCHAR(1024) NOT NULL COMMENT '用户浏览器信息'",'des'=>'...'),

//2015-06-26 15:48:31
array('time'=>mktimes(1970,1,1,8,45),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}service` (  `service_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',  `nickname` char(50) NOT NULL COMMENT '客服昵称',  `truename` char(50) NOT NULL COMMENT '真实姓名',  `avatar` char(150) NOT NULL COMMENT '客服头像',  `intro` text NOT NULL COMMENT '客服简介',  `tel` char(20) NOT NULL COMMENT '电话',  `qq` char(11) NOT NULL COMMENT 'qq',  `email` char(45) NOT NULL COMMENT '联系邮箱',  `openid` char(60) NOT NULL COMMENT '绑定openid',  `add_time` char(15) NOT NULL COMMENT '添加时间',  `status` tinyint(4) NOT NULL COMMENT '客服状态',  `store_id` int(11) NOT NULL COMMENT '所属店铺',  PRIMARY KEY (`service_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺客服列表' AUTO_INCREMENT=1",'des'=>'...'),

//2015-06-26 11:20:39
array('time'=>mktimes(1970,1,1,8,44),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product` ADD `is_present` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否为赠品，1：是，0：否'",'des'=>'...'),

//2015-08-07 15:51:28
array('time'=>mktimes(1970,1,1,9,43),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` ( `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('ischeck_to_show_by_comment','type=select&value=1:不需要审核评论才显示|0:需审核即可显示评论','1','评论是否需要审核显示','开启后，需商家或管理员审核方可显示，反之：不需审核即可显示','0','','1','0','1')",'des'=>'...'),

//2015-08-12 10:10:28
array('time'=>mktimes(1970,1,1,9,42),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('is_allow_comment_control','type=select&value=1:允许商户管理评论|2:不允许商户管理评论','1','是否允许商户管理评论','开启后，商户可对评论进行增、删、查操作','0','','1','0','1')",'des'=>'...'),

//2015-06-18 10:16:25
array('time'=>mktimes(1970,1,1,8,41),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}system_property_value` (`vid` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品栏目属性值id', `pid` int(10) NOT NULL DEFAULT '0' COMMENT '商品栏目属性名id',`value` varchar(50) NOT NULL DEFAULT '' COMMENT '商品栏目属性值', PRIMARY KEY (`vid`), KEY `pid` (`pid`) USING BTREE, KEY `pid_2` (`pid`,`value`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品栏目属性值' AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,40),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}system_property_type` (`type_id` smallint(5) NOT NULL AUTO_INCREMENT,`type_name` varchar(80) NOT NULL COMMENT '属性类别名',`type_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1为开启，0为关闭',PRIMARY KEY (`type_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品属性的类别表' AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,39),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}system_product_to_property_value` ( `id` int(11) NOT NULL AUTO_INCREMENT,`product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',`pid` int(10) NOT NULL DEFAULT '0' COMMENT '系统筛选表id',`vid` int(10) NOT NULL DEFAULT '0' COMMENT '系统筛选属性值id',PRIMARY KEY (`id`), KEY `product_id` (`product_id`) USING BTREE,KEY `vid` (`vid`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品关联筛选属性值表' AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,38),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}system_product_property` (`pid` int(10) NOT NULL AUTO_INCREMENT, `name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名',`sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序字段',`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1：启用，0：关闭',`property_type_id` smallint(5) NOT NULL COMMENT '产品属性所属类别id', PRIMARY KEY (`pid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品栏目属性名表' AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,36),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_category` ADD `filter_attr` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '拥有的属性id 用,号分割' AFTER `cat_level`",'des'=>'...'),

//2015-06-15 17:48:03
array('time'=>mktimes(1970,1,1,8,34),'type'=>'sql','sql'=>"UPDATE `{tableprefix}system_menu` SET `fid` = '2' WHERE `{tableprefix}system_menu`.`id` = 41",'des'=>'...'),

//2015-06-15 17:45:29
array('time'=>mktimes(1970,1,1,8,33),'type'=>'sql','sql'=>"UPDATE `{tableprefix}system_menu` SET `name` = '商品栏目属性类别管理', `module` = 'Sys_product_property' WHERE `{tableprefix}system_menu`.`id` = 41",'des'=>'...'),

//2015-06-15 17:42:59
array('time'=>mktimes(1970,1,1,8,32),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES(44, 2, '商品栏目属性列表', 'Sys_product_property', 'property', 0, 1, 1),(45, 2, '商品栏目属性值列表', 'Sys_product_property', 'propertyValue', 0, 1, 1)",'des'=>'...'),


//2015-06-13 16:14:39
array('time'=>mktimes(1970,1,1,8,23),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}search_tmp` (  `md5` varchar(32) NOT NULL COMMENT 'md5系统分类表id字条串，例md5(''1,2,3'')',  `product_id_str` text COMMENT '满足条件的产品id字符串，每个产品id以逗号分割',  `expire_time` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',  UNIQUE KEY `md5` (`md5`) USING BTREE,  KEY `expire_time` (`expire_time`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统分类筛选产品临时表'",'des'=>'...'),


//2015-06-08 17:05:00
array('time'=>mktimes(1970,1,1,8,19),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('attachment_upload_unlink', 'type=select&value=0:不删除本地附件|1:删除本地附件', '0', '是否删除本地附件', '当附件存放在远程时，如果本地服务器空间充足，不建议删除本地附件', 'base', '基础配置', '14', '0', '1')",'des'=>'...'),

//2015-06-06 16:59:46
array('time'=>mktimes(1970,1,1,8,18),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('notify_appkey', '', '', '', '通知的KEY', '0', '', 0, 0, 0)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,17),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('notify_appid', '', '', '', '通知的appid', '0', '', 0, 0, 0)",'des'=>'...'),

//2015-06-06 15:28:21
array('time'=>mktimes(1970,1,1,8,16),'type'=>'sql','sql'=>"INSERT INTO  `{tableprefix}config` (`name` ,`type` ,`value` ,`info` ,`desc` ,`tab_id` ,`tab_name` ,`gid` ,`sort` ,`status`)VALUES ('service_key',  'type=text&validate=required:false',  '',  '服务key',  '请填写购买产品时的服务key',  '0',  '',  '1',  '0',  '1')",'des'=>'...'),

//2015-06-06 15:20:41
array('time'=>mktimes(1970,1,1,8,15),'type'=>'sql','sql'=>"INSERT INTO  `{tableprefix}config` (`name` ,`type` ,`value` ,`info` ,`desc` ,`tab_id` ,`tab_name` ,`gid` ,`sort` ,`status`)VALUES ('is_diy_template',  'type=radio&value=1:开启|0:关闭',  '0',  '是否使用自定模板',  '是否使用自定模板',  '0',  '',  '11',  '3',  '1')",'des'=>'...'),

//2015-06-02 18:09:59
array('time'=>mktimes(1970,1,1,8,14),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('web_index_cache', 'type=text&size=20&validate=required:true,number:true,maxlength:5', '0', 'PC端首页缓存时间', 'PC端首页缓存时间，0为不缓存', '0', '', 1, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,13),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('attachment_up_domainname', 'type=text&size=50', 'chenyun.b0.upaiyun.com', '云存储域名', '云存储域名 不包含http://', 'upyun', '又拍云', 14, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,12),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('attachment_up_password', 'type=text&size=50', 'lomos516626', '操作员密码', '操作员密码', 'upyun', '又拍云', 14, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,11),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('attachment_up_username', 'type=text&size=50', 'chenyun', '操作员用户名', '操作员用户名', 'upyun', '又拍云', 14, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,10),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('attachment_up_form_api_secret', 'type=text&size=50', 'rY7h9T/vwffDcQN4tLtJWtn9If4=', 'FORM_API_SECRET', 'FORM_API_SECRET', 'upyun', '又拍云', 14, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,09),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('attachment_up_bucket', 'type=text&size=50', 'chenyun', 'BUCKET', 'BUCKET', 'upyun', '又拍云', 14, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,08),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('attachment_upload_type', 'type=select&value=0:保存到本服务器|1:保存到又拍云', '1', '附件保存方式', '附件保存方式', 'base', '基础配置', 14, 0, 1)",'des'=>'...'),

//2015-08-12 10:20:01
array('time'=>mktimes(1970,1,1,8,07),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}config` ADD UNIQUE (`name`)",'des'=>'...'),
//2015-08-07 13:17:27
array('time'=>mktimes(1970,1,1,8,06),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}config` ADD `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,05),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}config` DROP PRIMARY KEY",'des'=>'...'),


//2015-06-02 10:27:47
array('time'=>mktimes(1970,1,1,8,04),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}attachment_user` (  `pigcms_id` int(11) NOT NULL auto_increment COMMENT '自增ID',  `uid` int(11) NOT NULL COMMENT 'UID',  `name` varchar(50) NOT NULL COMMENT '名称',  `from` tinyint(1) NOT NULL default '0' COMMENT '0为上传，1为导入，2为收藏',  `type` tinyint(1) NOT NULL default '0' COMMENT '0为图片，1为语音，2为视频',  `file` varchar(100) NOT NULL COMMENT '文件地址',  `size` bigint(20) NOT NULL COMMENT '尺寸，byte字节',  `width` int(11) NOT NULL COMMENT '图片宽度',  `height` int(11) NOT NULL COMMENT '图片高度',  `add_time` int(11) NOT NULL COMMENT '添加时间',  `status` tinyint(4) NOT NULL default '1' COMMENT '状态',  PRIMARY KEY  (`pigcms_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员附件表'",'des'=>'...'),

//2015-05-26 10:27:21
array('time'=>mktimes(1970,1,1,8,03),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` CHANGE  `collect`  `collect` INT( 11 ) UNSIGNED NOT NULL COMMENT  '店铺收藏数'",'des'=>'...'),

//2015-05-26 10:26:37
array('time'=>mktimes(1970,1,1,8,02),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}product` CHANGE  `collect`  `collect` INT( 11 ) UNSIGNED NOT NULL COMMENT  '收藏数'",'des'=>'...'),

//2015-05-25 13:39:21
array('time'=>mktimes(1970,1,1,8,01),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}user_collect` (  `collect_id` int(11) unsigned NOT NULL auto_increment,  `user_id` mediumint(8) unsigned NOT NULL default '0',  `dataid` int(11) unsigned NOT NULL default '0' COMMENT '当type=1，这里值为商品id，type=2，此值为店铺id',  `add_time` int(11) unsigned NOT NULL default '0',  `type` tinyint(1) NOT NULL COMMENT '1:为商品；2:为店铺',  `is_attention` tinyint(1) NOT NULL default '0' COMMENT '是否被关注(0:不关注，1：关注)',  PRIMARY KEY  (`collect_id`),  KEY `user_id` (`user_id`),  KEY `goods_id` (`dataid`),  KEY `is_attention` (`is_attention`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户收藏店铺or商品' AUTO_INCREMENT=1",'des'=>'...'),


);
?>