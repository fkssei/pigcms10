<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title><?php echo $nowImage['title'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/mp_news.css"/>
	</head>
	<body id="activity-detail" class=" ">
		<div class="rich_media container">
			<div class="header" style="display: none;"></div>
			<div class="rich_media_inner content" style="min-height: 831px;">
				<h2 class="rich_media_title" id="activity-name"><?php echo $nowImage['title'];?></h2>
				<div class="rich_media_meta_list">
					<em id="post-date" class="rich_media_meta text"><?php echo date('Y-m-d');?></em> 
					<em class="rich_media_meta text"></em> 
					<a class="rich_media_meta link nickname js-no-follow js-open-follow" href="javascript:;" id="post-user"><?php echo $weixin['nick_name'];?></a>
				</div>
				<div id="page-content" class="content">
					<div id="img-content">
						<?php if ($nowImage['cover_pic'] && $nowImage['is_show']) {?>
						<div class="rich_media_thumb" id="media">
							<img onerror="this.parentNode.removeChild(this)" src="<?php echo $nowImage['cover_pic'];?>">
						</div>
						<?php }?>
						<div class="rich_media_content" id="js_content"><?php echo $nowImage['content'];?></div>
						<?php if ($nowImage['url']) {?>
						<div class="rich_media_tool" id="js_toobar">
							<a class="media_tool_meta meta_primary" href="<?php echo $nowImage['url']?>">阅读原文</a>
						</div>
						<?php }?>
					</div>
				</div>
				<?php if (isset($weixin['qrcode_url']) && $weixin['qrcode_url']) {?>
				<div id="js_pc_qr_code" class="qr_code_pc_outer">
					<div class="qr_code_pc_inner">
						<div class="qr_code_pc">
							<div class="qr_code_pc_img">
								<img width="158" height="158" src="<?php echo ($weixin['alias'] ? 'http://open.weixin.qq.com/qr/code/?username='.$weixin['alias'] : $weixin['qrcode_url']);?>">
							</div>
							<p>
								微信扫一扫<br>获得更多内容
							</p>
						</div>
					</div>
				</div>
				<?php }?>
			</div>
		</div>
		<?php include display('footer');?>
		<?php echo $shareData;?>
	</body>
</html>