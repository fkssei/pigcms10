<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){echo ' responsive-320';}elseif($_GET['ps']>=540){echo ' responsive-540';} if($_GET['ps']>540){echo ' responsive-800';} ?>" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title><?php echo $nowGroup['group_name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<?php if($is_mobile){ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
			<script>var is_mobile = true;</script>
		<?php }else{ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
			<script>var is_mobile = false;</script>
		<?php } ?>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.waterfall.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
		<script>var storeId = <?php echo $now_store['store_id']?>;</script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/sku.js"></script>
		<script src="<?php echo TPL_URL;?>js/goodcat.js"></script>
	</head>
	<body <?php if(!empty($storeNav)){ ?>style="padding-bottom:45px;"<?php } ?>>
		<div class="container">
			<div class="header">
				<?php if(!$is_mobile && $_SESSION['user']){ ?>
				<div class="headerbar">
					<div class="headerbar-wrap clearfix">
						<div class="headerbar-preview">
							<span>预览：</span>
							<ul>
								<li>
								   <a href="<?php echo $now_url;?>&ps=320" class="js-no-follow<?php if(empty($_GET['ps']) || $_GET['ps'] == '320') echo ' active';?>">iPhone版</a>
								</li>
								<li>
								   <a href="<?php echo $now_url;?>&ps=540" class="js-no-follow<?php if($_GET['ps'] == '540') echo ' active';?>">三星Note3版</a>
								</li>
								<li>
								   <a href="<?php echo $now_url;?>&ps=800" class="js-no-follow<?php if($_GET['ps'] == '800') echo ' active';?>">PC版</a>
								</li>
							</ul>
						</div>
						<div class="headerbar-reedit">
							<a href="<?php dourl('user:goods:category',array(),true);?>#edit/<?php echo $nowGroup['group_id']?>" class="js-no-follow">重新编辑</a>
						</div>
					</div>
				</div>
				<?php } ?>
				<!-- ▼顶部通栏 -->
				<div class="js-mp-info share-mp-info">
					<a class="page-mp-info" href="<?php echo $now_store['url'];?>">
						<img class="mp-image" width="24" height="24" src="<?php echo $now_store['logo'];?>" alt="<?php echo $now_store['name'];?>"/>
						<i class="mp-nickname"><?php echo $now_store['name'];?></i>
					</a>
					<div class="links">
						<a class="mp-homepage" href="<?php echo $now_store['ucenter_url'];?>">我的记录</a>
					</div>
				</div>
				<!-- ▲顶部通栏 -->
			</div>
			<div class="content">
				<div class="content-body">
					<?php if($pageHasAd && $pageAdPosition == 0 && $pageAdFieldCon){ echo $pageAdFieldCon;}?>
					<?php if($nowGroup['is_show_name']){ ?>
						<div class="custom-title">
							<h2 class="title"><?php echo $nowGroup['group_name']; ?></h2>
						</div>
					<?php } ?>
					<?php if($nowGroup['group_label']){ ?>
						<div class="custom-richtext"><?php echo $nowGroup['group_label'];?></div>
					<?php } ?>
					<!-- 商品列表 -->
					<?php
						if(!empty($goodList)){
							if($nowGroup['list_style_size'] == 0){
					?>
								<ul class="js-goods-list sc-goods-list pic clearfix size-0">
									<?php
										$i = 1;
										foreach($goodList as $key=>$value){ 
									?>
											<li class="goods-card goods-list big-pic <?php if($nowGroup['list_style_type'] == 2){echo 'normal';}else{echo 'card';}?>">
												<a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $value['product_id'];?>" class="js-goods link clearfix" target="_blank" title="<?php echo $value['name'];?>">
													<div class="photo-block">
														<img class="goods-photo js-goods-lazy" src="<?php echo $value['image'];?>" style="display:inline;">
													</div>
													<div class="info clearfix <?php if($nowGroup['is_show_product_name'] == 1){echo 'info-title';}else{echo 'info-no-title';}?> <?php if($nowGroup['is_show_price'] == 1){echo 'info-price';}else{echo 'info-no-price';}?> btn<?php echo $nowGroup['buy_button_style'];?> <?php if($nowGroup['is_show_product_name'] == 0 || $nowGroup['is_show_price'] == 0){echo 'hide';}?>">
														<p class="goods-title"><?php echo $value['name'];?></p>
														<p class="goods-sub-title c-black hide"></p>
														<?php if($nowGroup['is_show_price']){ ?>
															<p class="goods-price">        
																<em>￥<?php echo $value['price'];?></em>
															</p>
														<?php } ?>
														<p class="goods-price-taobao hide"></p>   
													</div>
													<?php if($nowGroup['is_show_buy_button'] && $nowGroup['list_style_type']==0){ ?>
														<div class="goods-buy btn<?php echo $nowGroup['buy_button_style'];?> info-no-title"></div>  
														<div class="js-goods-buy buy-response" data-id="<?php echo $value['product_id'];?>"></div>
													<?php } ?>
												</a>
											</li>
									<?php 
											$i++;
										}
									?>
								</ul>
					<?php 
							}else if($nowGroup['list_style_size'] == 1){
								if($nowGroup['list_style_type'] != 1){
					?>
									<ul class="js-goods-list sc-goods-list pic clearfix size-1">
										<?php
											$i = 1;
											foreach($goodList as $key=>$value){
										?>
												<li class="goods-card goods-list small-pic <?php if($nowGroup['list_style_type'] == 2){echo 'normal';}else{echo 'card';}?>">
													<a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $value['product_id'];?>" class="js-goods link clearfix" target="_blank" title="<?php echo $value['name'];?>">
														<div class="photo-block">
															<img class="goods-photo js-goods-lazy" src="<?php echo $value['image'];?>" style="display:inline;"/>
														</div>
														<div class="info clearfix <?php if($nowGroup['is_show_product_name'] == 1){echo 'info-title';}else{echo 'info-no-title';}?> <?php if($nowGroup['is_show_price'] == 1){echo 'info-price';}else{echo 'info-no-price';}?> btn<?php echo $nowGroup['buy_button_style'];?> <?php if($nowGroup['is_show_product_name'] == 0 && $nowGroup['is_show_price'] == 0){echo 'hide';}?>">
															<p class="goods-title"><?php echo $value['name'];?></p>
															<p class="goods-sub-title c-black hide"></p>
															<?php if($nowGroup['is_show_price']){ ?>
																<p class="goods-price">        
																	<em>￥<?php echo $value['price'];?></em>
																</p>
															<?php } ?>
															<p class="goods-price-taobao hide"></p>   
														</div>
														<?php if($nowGroup['is_show_buy_button'] && $nowGroup['list_style_type']==0){ ?>
															<div class="goods-buy btn<?php echo $nowGroup['buy_button_style'];?>"></div>  
															<div class="js-goods-buy buy-response" data-id="<?php echo $value['product_id'];?>"></div>
														<?php } ?>
													</a>
												</li>
										<?php 
												$i++;
											}
										?>
									</ul>
						<?php 	}else{ ?>
									<ul class="js-goods-list sc-goods-list pic clearfix size-1 waterfall">
										<?php
											$i = 1;
											foreach($goodList as $key=>$value){
										?>
												<li class="goods-card goods-list small-pic waterfall" style="width:155px;">
													<a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $value['product_id'];?>" class="js-goods link clearfix" target="_blank" title="<?php echo $value['name'];?>">
														<div class="photo-block">
															<img class="goods-photo js-goods-lazy" src="<?php echo $value['image'];?>" style="display:inline;">
														</div>
														<div class="info clearfix <?php if($nowGroup['is_show_product_name'] == 1){echo 'info-title';}else{echo 'info-no-title';}?> <?php if($nowGroup['is_show_price'] == 1){echo 'info-price';}else{echo 'info-no-price';}?> btn<?php echo $nowGroup['buy_button_style'];?> <?php if($nowGroup['is_show_product_name'] == 0 || $nowGroup['is_show_price'] == 0){echo 'hide';}?>">
															<p class="goods-title"><?php echo $value['name'];?></p>
															<p class="goods-sub-title c-black hide"></p>
															<?php if($nowGroup['is_show_price']){ ?>
																<p class="goods-price">        
																	<em>￥<?php echo $value['price'];?></em>
																</p>
															<?php } ?>
															<p class="goods-price-taobao hide"></p>   
														</div>
														<?php if($nowGroup['is_show_buy_button']){ ?>
															<div class="goods-buy btn<?php echo $nowGroup['buy_button_style'];?>"></div>  
															<div class="js-goods-buy buy-response" data-id="<?php echo $value['product_id'];?>"></div>
														<?php } ?>
													</a>
												</li>
										<?php 
												$i++;
											}
										?>
									</ul>
					<?php
								}
							}else if($nowGroup['list_style_size'] == 2){
					?>
								<ul class="js-goods-list sc-goods-list pic clearfix size-2">
									<?php
										$i = 1;
										foreach($goodList as $key=>$value){ 
									?>
											<li class="goods-card goods-list <?php if($i%3 == 1){echo 'big-pic';}else{echo 'small-pic';}?> <?php if($nowGroup['list_style_type'] == 2){echo 'normal';}else{echo 'card';}?>">
												<a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $value['product_id'];?>" class="js-goods link clearfix" target="_blank" title="<?php echo $value['name'];?>">
													<div class="photo-block">
														<img class="goods-photo js-goods-lazy" src="<?php echo $value['image'];?>" style="display:inline;">
													</div>
													<div class="info clearfix <?php if($nowGroup['is_show_product_name'] == 1){echo 'info-title';}else{echo 'info-no-title';}?> <?php if($nowGroup['is_show_price'] == 1){echo 'info-price';}else{echo 'info-no-price';}?> btn<?php echo $nowGroup['buy_button_style'];?> <?php if($nowGroup['is_show_product_name'] == 0 || $nowGroup['is_show_price'] == 0){echo 'hide';}?>">
														<p class="goods-title"><?php echo $value['name'];?></p>
														<p class="goods-sub-title c-black hide"></p>
														<?php if($nowGroup['is_show_price']){ ?>
															<p class="goods-price">        
																<em>￥<?php echo $value['price'];?></em>
															</p>
														<?php } ?>
														<p class="goods-price-taobao hide"></p>   
													</div>
													<?php if($nowGroup['is_show_buy_button'] && $nowGroup['list_style_type']==0){ ?>
														<div class="goods-buy btn<?php echo $nowGroup['buy_button_style'];?> info-no-title"></div>  
														<div class="js-goods-buy buy-response" data-id="<?php echo $value['product_id'];?>"></div>
													<?php } ?>
												</a>
											</li>
									<?php 
											$i++;
										}
									?>
								</ul>
					<?php 
							}else if($nowGroup['list_style_size'] == 3){
					?>
								<ul class="js-goods-list sc-goods-list clearfix list size-3">
									<?php
										$i = 1;
										foreach($goodList as $key=>$value){ 
									?>
											<li class="goods-card goods-list <?php if($i%3 == 1){echo 'big-pic';}else{echo 'small-pic';}?> <?php if($nowGroup['list_style_type'] == 2){echo 'normal';}else{echo 'card';}?>">
												<a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $value['product_id'];?>" class="js-goods link clearfix" target="_blank" title="<?php echo $value['name'];?>">
													<div class="photo-block">
														<img class="goods-photo js-goods-lazy" src="<?php echo $value['image'];?>" style="display:block;">
													</div>
													<div class="info">
														<p class="goods-title"><?php echo $value['name'];?></p>
														<?php if($nowGroup['is_show_price']){ ?>
															<p class="goods-price">        
																<em>￥<?php echo $value['price'];?></em>
															</p>
														<?php } ?>
														<?php if($nowGroup['is_show_buy_button']){ ?>
															<div class="goods-buy btn<?php echo $nowGroup['buy_button_style'];?> info-no-title"></div>  
															<div class="js-goods-buy buy-response" data-id="<?php echo $value['product_id'];?>"></div>
														<?php } ?>
													</div>
												</a>
											</li>
									<?php 
											$i++;
										}
									?>
								</ul>
					<?php 
							}
						}
					?>
					<?php
						if($homeCustomField){
							foreach($homeCustomField as $value){
								echo $value['html'];
							}
						} 
					?>
					<?php if($pageHasAd && $pageAdPosition == 1 && $pageAdFieldCon){ echo $pageAdFieldCon;}?>
				</div>
				<?php if(!$is_mobile){ ?>
					<div class="content-sidebar">
						<a href="<?php echo $now_store['url'];?>" class="link">
							<div class="sidebar-section shop-card">
								<div class="table-cell">
									<img src="<?php echo $now_store['logo'];?>" width="60" height="60" class="shop-img" alt="<?php echo $now_store['name'];?>"/>
								</div>
								<div class="table-cell">
									<p class="shop-name"><?php echo $now_store['name'];?></p>
								</div>
							</div>
						</a>
						<div class="sidebar-section qrcode-info">
							<div class="section-detail">
								<p class="text-center shop-detail"><strong>手机扫码访问</strong></p>
								<p class="text-center weixin-title">微信“扫一扫”分享到朋友圈</p>
								<p class="text-center qr-code">
									<img width="158" height="158" src="<?php echo $config['site_url'];?>/source/qrcode.php?type=good_cat&id=<?php echo $nowGroup['group_id'];?>">
								</p>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if(!empty($storeNav)){ echo $storeNav;}?>
			</div>
			<?php include display('footer');?>
		</div>
		<?php echo $shareData;?>
	</body>
</html>
<?php Analytics($_GET['id'], 'goods_group', $nowGroup['group_name'], $_GET['id']); ?>