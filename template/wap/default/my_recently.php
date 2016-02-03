<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>最近浏览</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/history.css"/>
	</head>
	<body>
		<div class="wx_wrap">
			<div class="recent_tit">
				最多保存<span class="num">20</span>条浏览记录 <a class="btn_clear" href="./my_recently.php?action=clear" id="clearBtn">清除</a>
			</div>
			<?php if(is_array($good_history_arr)){ ?>
				<ul class="mod_list recent" id="recentList">
					<?php foreach($good_history_arr as &$value){ ?>
							<li class="hproduct">
								<a href="<?php echo $value['url'];?>">
									<div class="list_inner">
										<div class="photo"><img src="<?php echo $value['image'];?>"/></div>
										<div class="info">
											<p class="title"><?php echo $value['name'];?></p>
											<p class="price">¥<?php echo $value['price'];?></p>
										</div>
										<div class="time"><?php echo $value['time_txt'];?></div>
									</div>
								</a>
							</li>
					<?php } ?>
				</ul>
			<?php }else{ ?>
				<div class="recent_tip" id="tips">最近一周内没有浏览记录</div>
			<?php } ?>
		</div>
		<?php echo $shareData;?>
	</body>
</html>