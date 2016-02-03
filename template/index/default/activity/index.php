<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title><?php echo $config['site_name'];?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css">
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo TPL_URL;?>js/myindex.js"></script>
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script src="<?php echo TPL_URL;?>js/index2.js"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="js/DD_belatedPNG_0.0.8a.js" mce_src="js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css"> 
body{ behavior:url("csshover.htc");}
</style>
<![endif]-->
<style>
	.activi_header .activi_header_content .activi_header_bottom{
		position: relative;
	}
	.recommend .content_list_erweima{
		width: 100%;
		height: 100%;
		position: absolute;
		top: 0;
		left: 0;
		background: rgba(0,0,0,0.7);
		display: none;
		filter: alpha(opacity=50);
		filter: progid:DXImageTransform.Microsoft.gradient(startcolorstr=#7F000000, endcolorstr=#7F000000);
		overflow: hidden;
	}
	.recommend:hover .content_list_erweima{
		display: block;
	}
</style>
</head>

<body>
<?php include display( 'public:header');?>

<div class="activi_header">
	<div class="activi_header_content">
		<div class="activi_header_content_left">
			<div class="content__cell content__cell--slider">
				<div class="component-index-slider">
					<div class="index-slider ui-slider log-mod-viewed">
						<div class="pre-next"> 
							<a style="opacity: 0.6; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-previous sp-slide--previous"></a> 
							<a style="opacity: 0.6; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-next sp-slide--next"></a> 
						</div>

						<ul class="content">
							<?php foreach ($slider as $key => $value) {?>
							<li class="cf" style="opacity: 1; display: <?php if($key==0){echo 'block';}else{echo 'none';}?>;"> 
							   <img src="<?php echo $value['pic'];?>">
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="activi_header_content_right">
			<div class="activi_header_top">
				<div class="activi_header_title"><span></span>今日推荐</div>
				<p><?php echo $recommend['name'];?></p>
				<p class="activi_header_title_p_r"><span><?php echo $recommend['count'];?></span>人参与</p>
				<div class="jiantou"></div>
			</div>
			<div class="content_list_img activi_header_bottom">
				<a href="javascript:;" class="recommend">
				<img src="<?php echo $recommend['image'];?>">
				<div class="content_list_erweima">
					<div class="content_list_erweima_img"><img height="159" src="./source/qrcode.php?type=activity&id=no&url=<?php echo $recommend['appurl'];?>"></div>
				</div>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="content activity">
	<div class="content_commodity content_activity hot_activity"  >
		<div class="content_commodity_title">
			<div class="content_commodity_title_left"><a href="###">热门活动</a></div>
			<div class="content_commodity_title_content">
				<ul>
					<li class="content_curn"><a href="javascript:void(0);">一元夺宝</a></li>
					<li><a href="javascript:void(0);">众筹</a></li>
					<li><a href="javascript:void(0);">降价拍</a></li>
					<li><a href="javascript:void(0);">限时秒杀</a></li>
					<li><a href="javascript:void(0);">超级砍价</a></li>
				</ul>
			</div>
			<div class="content_commodity_title_right"><a href="###">更多&gt;&gt;</a></div>
		</div>
		<div class="content_list_activity cur">
			<ul class="content_list_ul">
				<?php  foreach ($hot_duobao as $key => $value) { ?>
				<li> 
					<a href="javascript:void(0);">
					<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'一元夺宝','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
						<img height="159" src="<?php echo $value['image'];?>">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
							<div class="content_shop_name"><?php echo $value['name'];?></div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name"><?php echo $value['name'];?></div>
						<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
					</div>
					</a> 
				</li>
				<?php if($key == 0){?>
					<li class="activity_list">
						<div class="content__cell content__cell--slider">
							<div class="component-index-slider1">
								<div class="index-slider ui-slider log-mod-viewed">
									<div class="pre-next"> 
										<a style="opacity: 0.6; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-previous sp-slide--previous"></a> 
										<a style="opacity: 0.6; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-next sp-slide--next"></a> 
									</div>
									<ul class="content">
										<?php foreach ($hot as $key => $value) {?>
										<li class="cf" style="opacity: 1; display: <?php if($key==0){echo 'block';}else{echo 'none';}?>;"> 
										   <img src="<?php echo $value['pic'];?>">
										</li>
										<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					</li>
				<?php }?>
				<?php }?>
			</ul>
		</div>
		<div class="content_list_activity">
			<ul class="content_list_ul">
				<?php  foreach ($hot_zhongchou as $key => $value) { ?>
				<li> 
					<a href="javascript:void(0);">
					<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'众筹','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
						<img height="159" src="<?php echo $value['image'];?>">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
							<div class="content_shop_name"><?php echo $value['name'];?></div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name"><?php echo $value['name'];?></div>
						<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
					</div>
					</a> 
				</li>
				<?php }?>
			</ul>
		</div>
		<div class="content_list_activity">
			<ul class="content_list_ul">
				<?php  foreach ($hot_jiangjia as $key => $value) { ?>
				<li> 
					<a href="javascript:void(0);">
					<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'降价拍','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
						<img height="159" src="<?php echo $value['image'];?>">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
							<div class="content_shop_name"><?php echo $value['name'];?></div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name"><?php echo $value['name'];?></div>
						<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
					</div>
					</a> 
				</li>
				<?php }?>
			</ul>
		</div>
		<div class="content_list_activity">
			<ul class="content_list_ul">
				<?php  foreach ($hot_miaosha as $key => $value) { ?>
				<li> 
					<a href="javascript:void(0);">
					<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'限时秒杀','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
						<img height="159" src="<?php echo $value['image'];?>">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
							<div class="content_shop_name"><?php echo $value['name'];?></div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name"><?php echo $value['name'];?></div>
						<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
					</div>
					</a> 
				</li>
				<?php }?>
			</ul>
		</div>
		<div class="content_list_activity">
			<ul class="content_list_ul">
				<?php  foreach ($hot_kanjia as $key => $value) { ?>
				<li> 
					<a href="javascript:void(0);">
					<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'超级砍价','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
						<img height="159" src="<?php echo $value['image'];?>">
						<div class="content_list_erweima">
							<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
							<div class="content_shop_name"><?php echo $value['name'];?></div>
						</div>
					</div>
					<div class="content_list_txt">
						<div class="content_shop_name"><?php echo $value['name'];?></div>
						<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
					</div>
					</a> 
				</li>
				<?php }?>
			</ul>
		</div>
	</div>
	<div class="content_commodity content_activity nearby_activity"  >
		<div class="content_commodity_title">
			<div class="content_commodity_title_left"><a href="###"> 附近活动</a></div>
			<div class="content_commodity_title_content">
				<ul>
					<li class="content_curn"><a href="javascript:void(0);">一元夺宝</a></li>
					<li><a href="javascript:void(0);">众筹</a></li>
					<li><a href="javascript:void(0);">降价拍</a></li>
					<li><a href="javascript:void(0);">限时秒杀</a></li>
					<li><a href="javascript:void(0);">超级砍价</a></li>
				</ul>
			</div>
			<div class="content_commodity_title_right"><a href="###">更多&gt;&gt;</a></div>
		</div>
		<div class="content_list_activity cur">
			<ul class="content_list_ul">
				<?php 
				if (is_array($duobao)) {
					foreach ($duobao as $key => $value) {
				?>
						<li> 
							<a href="javascript:void(0);">
							<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'一元夺宝','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
								<img height="159" src="<?php echo $value['image'];?>">
								<div class="content_list_erweima">
									<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
									<div class="content_shop_name"><?php echo $value['name'];?></div>
								</div>
							</div>
							<div class="content_list_txt">
								<div class="content_shop_name"><?php echo $value['name'];?></div>
								<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
							</div>
							</a> 
						</li>
						<?php
						if($key == 0){
						?>
							<li class="activity_list">
								<div class="content__cell content__cell--slider">
									<div class="component-index-slider2">
										<div class="index-slider ui-slider log-mod-viewed">
											<div class="pre-next"> <a style="opacity: 0.6; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-previous sp-slide--previous"></a> <a style="opacity: 0.6; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-next sp-slide--next"></a> </div>
											<ul class="content">
												<?php foreach ($nearby as $key => $value) {?>
												<li class="cf" style="opacity: 1; display: <?php if($key==0){echo 'block';}else{echo 'none';}?>;"> 
												   <img src="<?php echo $value['pic'];?>">
												</li>
												<?php } ?>
											</ul>
										</div>
									</div>
								</div>
							</li>
				<?php
						}
					}
				}
				?>
			</ul>
		</div>
		<div class="content_list_activity">
			<ul class="content_list_ul">
				<?php
				if (is_array($zhongchou)) {
					foreach ($zhongchou as $key => $value) {
				?>
						<li> 
							<a href="javascript:void(0);">
							<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'众筹','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
								<img height="159" src="<?php echo $value['image'];?>">
								<div class="content_list_erweima">
									<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
									<div class="content_shop_name"><?php echo $value['name'];?></div>
								</div>
							</div>
							<div class="content_list_txt">
								<div class="content_shop_name"><?php echo $value['name'];?></div>
								<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
							</div>
							</a> 
						</li>
				<?php
					}
				}
				?>
			</ul>
		</div>
		<div class="content_list_activity">
			<ul class="content_list_ul">
				<?php
				if (is_array($jiangjia)) {
					foreach ($jiangjia as $key => $value) {
				?>
						<li> 
							<a href="javascript:void(0);">
							<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'降价拍','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
								<img height="159" src="<?php echo $value['image'];?>">
								<div class="content_list_erweima">
									<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
									<div class="content_shop_name"><?php echo $value['name'];?></div>
								</div>
							</div>
							<div class="content_list_txt">
								<div class="content_shop_name"><?php echo $value['name'];?></div>
								<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
							</div>
							</a> 
						</li>
				<?php
					}
				}
				?>
			</ul>
		</div>
		<div class="content_list_activity">
			<ul class="content_list_ul">
				<?php
				if (is_array($miaosha)) {
					foreach ($miaosha as $key => $value) {
				?>
						<li> 
							<a href="javascript:void(0);">
							<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'限时秒杀','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
								<img height="159" src="<?php echo $value['image'];?>">
								<div class="content_list_erweima">
									<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
									<div class="content_shop_name"><?php echo $value['name'];?></div>
								</div>
							</div>
							<div class="content_list_txt">
								<div class="content_shop_name"><?php echo $value['name'];?></div>
								<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
							</div>
							</a> 
						</li>
				<?php
					}
				}
				?>
			</ul>
		</div>
		<div class="content_list_activity">
			<ul class="content_list_ul">
				<?php
				if (is_array($kanjia)) {
					foreach ($kanjia as $key => $value) {
				?>
						<li> 
							<a href="javascript:void(0);">
							<div class="content_list_img huodong" data-json="{'name':'<?php echo $value[name]?>','type':'huodong','typename':'超级砍价','wx_image':'./source/qrcode.php?type=activity&id=no&url=<?php echo $value[appurl];?>','cyrs':'<?php echo $value['count']?>','intro':'<?php echo $value['intro']?>'}">
								<img height="159" src="<?php echo $value['image'];?>">
								<div class="content_list_erweima">
									<div class="content_list_erweima_img"><img height="159"  src="./source/qrcode.php?type=activity&id=no&url=<?php echo $value['appurl'];?>"></div>
									<div class="content_shop_name"><?php echo $value['name'];?></div>
								</div>
							</div>
							<div class="content_list_txt">
								<div class="content_shop_name"><?php echo $value['name'];?></div>
								<div class="content_shop_jion"><span><?php echo $value['count'];?></span>人已参与</div>
							</div>
							</a> 
						</li>
				<?php
					}
				}
				?>
			</ul>
		</div>
	</div>

</div>

<?php include display( 'public:footer');?>
</body>
</html>