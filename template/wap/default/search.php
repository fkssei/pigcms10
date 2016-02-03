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
		<title>商品搜索</title>
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
					<div class="custom-search">
						<form action="./search.php" method="get">
							<input type="hidden" name="store_id" value="<?php echo $now_store['store_id'];?>"/>
							<input type="search" class="custom-search-input" placeholder="商品搜索：请输入商品关键字" name="q" value="<?php echo $key;?>"/>
							<button type="submit" class="custom-search-button">搜索</button>
						</form>
					</div>
					
						<ul class="js-goods-list sc-goods-list clearfix list size-3">
							<?php
								if(!empty($goodList)){
									$i = 1;
									foreach($goodList['product_list'] as $key=>$value){ 
							?>
										<li class="goods-card goods-list <?php if($i%3 == 1){echo 'big-pic';}else{echo 'small-pic';}?> <?php if($nowGroup['list_style_type'] == 2){echo 'normal';}else{echo 'card';}?>">
											<a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $value['product_id'];?>" class="js-goods link clearfix" target="_blank" title="<?php echo $value['name'];?>">
												<div class="photo-block">
													<img class="goods-photo js-goods-lazy" src="<?php echo $value['image'];?>" style="display:block;">
												</div>
												<div class="info">
													<p class="goods-title"><?php echo $value['name'];?></p>
													<p class="goods-price">        
														<em>￥<?php echo $value['price'];?></em>
													</p>
													<div class="goods-buy btn1"></div>  
													<div class="js-goods-buy buy-response" data-id="<?php echo $value['product_id'];?>"></div>
												</div>
											</a>
										</li>
							<?php 
										$i++;
									}
								}else{
							?>
									<li class="text-center">商品不存在。<a href="<?php echo $now_store['url'];?>" class="more-link">去店铺主页看看？</a></li>
							<?php	
								}
							?>
						</ul>
						<?php if($goodList['pagebar']){ ?>
							<div class="custom-paginations-container">
								<div class="custom-paginations clearfix"><?php echo $goodList['pagebar'];?></div>
							</div>
						<?php } ?>
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
					</div>
				<?php } ?>
				<?php if(!empty($storeNav)){ echo $storeNav;}?>
			</div>
			<?php include display('footer');?>
			<?php echo $shareData;?>
		</div>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'search', '商品搜索', $now_store['store_id']); ?>