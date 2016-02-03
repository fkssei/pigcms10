<?php if(empty($noFooterLinks) && empty($noFooterCopy)){ ?>
	<div class="js-footer">          
		<div class="footer">
			<div class="copyright">
				<?php if(empty($noFooterLinks)){ ?>
					<div class="ft-links">
						<a href="<?php echo $now_store['url'];?>">店铺主页</a>
						<a href="<?php echo $now_store['ucenter_url'];?>">会员中心</a>
						<?php if($now_store['physical_count']){ ?><a href="<?php echo $now_store['physical_url'];?>">线下门店</a><?php } ?>
					</div>
				<?php } ?>
				<?php if(0 && empty($noFooterCopy)){ ?>
					<div class="ft-copyright">
						<a href="<?php echo $config['wap_site_url'];?>" target="_blank">由&nbsp;<span class="company">吾爱源码</span>&nbsp;提供技术支持</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
<?php
	if(!empty($_GET['platform']) || !empty($_SESSION['platform'])){
		$_SESSION['platform'] = 1;
?>
		<div class="wx_aside" id="quckArea">
			<a href="javascript:void(0);" id="quckIco2" class="btn_more">更多</a>
			<div class="wx_aside_item" id="quckMenu">
				<a href="./index.php" class="item_index">首页</a>
				<a href="./category.php" class="item_fav">商品分类</a>
				<a href="./weidian.php" class="item_cart">微店列表</a>
				<a href="./my.php" class="item_uc">个人中心</a>
			</div>
		</div>
<?php } ?>