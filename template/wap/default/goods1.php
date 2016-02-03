<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){echo ' responsive-320';}elseif($_GET['ps']>=540){echo ' responsive-540';} if($_GET['ps']>540){echo ' responsive-800';} ?>" lang="zh-CN">
<head>
	<meta charset="utf-8" />
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" 	content="<?php echo $config['seo_description'];?>" />
	<meta name="HandheldFriendly" content="true" />
	<meta name="MobileOptimized" content="320" />
	<meta name="format-detection" content="telephone=no" />
	<meta http-equiv="cleartype" content="on" />
	<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
	<title><?php echo $nowProduct['name'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css" />
	<?php if($is_mobile){ ?>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css" />
		<script>var is_mobile = true;</script>
	<?php }else{ ?>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css" />
		<script>var is_mobile = false;</script>
	<?php } ?>
	<script>
	var is_logistics = <?php echo $now_store['open_logistics'] ? 'true' : 'false' ?>;
	var is_selffetch = <?php echo $now_store['buyer_selffetch'] ? 'true' : 'false' ?>;
	</script>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/goods.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/drp_notice.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/coupon.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL?>css/comment.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/font/icon.css" />
	<script> var storeId=<?php echo $now_store['store_id'];?>,product_id=<?php echo $nowProduct['product_id'];?>,showBuy=!!<?php echo intval($_GET['buy'])?>,hasActivity=!!<?php echo intval($nowActivity);?>,activityId=<?php echo intval($nowActivity['pigcms_id']);?>,activityType=<?php echo intval($nowActivity['type']);?>,activityDiscount=<?php echo floatval($nowActivity['discount']);?>,activityPrice=<?php echo floatval($nowActivity['price']);?>;</script>
	<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
	<script src="<?php echo $config['site_url'];?>/static/js/jquery.waterfall.js"></script>
	<script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
	<script src="<?php echo TPL_URL;?>js/base.js"></script>
	<script src="<?php echo TPL_URL;?>js/sku.js"></script>
	<script src="<?php echo TPL_URL;?>js/good.js"></script>
	<script src="<?php echo TPL_URL;?>js/drp_notice.js"></script>
</head>

<body <?php if($is_mobile){ ?> class="body-fixed-bottom" <?php } ?>>
		<?php if ($allow_drp) { ?>
			<div id="drp-notice">
				<ul>
					<li class="msg-li" style="width: 60%">分销此商品您最多可获得：<br />￥<span
						style="color: #4EC83B"><?php echo $max_fx_price; ?></span>佣金
					</li>
					<li class="btn-li"><a href="<?php echo $drp_register_url; ?>"
						class="button green">我要分销</a></li>
					<li class="last-li"><b class="close"></b></li>
				</ul>
			</div>
		<?php } ?>
		<div class="container">
		<div class="header">
				<?php if(!$is_mobile && $_SESSION['user'] && $nowProduct['uid'] == $_SESSION['user']['uid']){ ?>
				<div class="headerbar">
				<div class="headerbar-wrap clearfix">
					<div class="headerbar-preview">
						<span>预览：</span>
						<ul>
							<li><a href="<?php echo $now_url;?>&ps=320"
								class="js-no-follow<?php if(empty($_GET['ps']) || $_GET['ps'] == '320') echo ' active';?>">iPhone版</a>
							</li>
							<li><a href="<?php echo $now_url;?>&ps=540"
								class="js-no-follow<?php if($_GET['ps'] == '540') echo ' active';?>">三星Note3版</a>
							</li>
							<li><a href="<?php echo $now_url;?>&ps=800"
								class="js-no-follow<?php if($_GET['ps'] == '800') echo ' active';?>">PC版</a>
							</li>
						</ul>
					</div>
					<div class="headerbar-reedit">
						<a
							href="<?php dourl('user:goods:edit',array('id'=>$nowProduct['product_id']),true);?>"
							class="js-no-follow">重新编辑</a>
					</div>
				</div>
			</div>
				<?php } ?>
				<!-- ▼顶部通栏 -->

			<div class="js-mp-info share-mp-info">
				<a class="page-mp-info" href="<?php echo $now_store['url'];?>"> <img
					class="mp-image" width="24" height="24"
					src="<?php echo $now_store['logo'];?>"
					alt="<?php echo $now_store['name'];?>" /> <i class="mp-nickname"><?php echo $now_store['name'];?></i>
				</a>

				<div class="links">
					<a class="mp-homepage"
						href="<?php echo $now_store['ucenter_url'];?>">我的记录</a>
				</div>

			</div>





			<!-- ▲顶部通栏 -->
		</div>
		<div class="content">
			<div class="content-body">
					<?php if($pageHasAd && $pageAdPosition == 0 && $pageAdFieldCon){ echo $pageAdFieldCon;}?>
					<div
					class="js-image-swiper custom-image-swiper custom-goods-swiper"
					data-max-height="<?php echo $nowProduct['image_size']['height'];?>"
					data-max-width="<?php echo $nowProduct['image_size']['width'];?>">
					<div class="swiper-container" style="height: 280px;">
						<div class="swiper-wrapper">
								<?php foreach($nowProduct['images'] as $value){ ?>
									<div class="swiper-slide" style="height: 280px;">
								<a class="js-no-follow" href="javascript:;"
									style="height: 280px;"> <img
									src="<?php echo $value['image'];?>" />
								</a>
							</div>
								<?php } ?>
							</div>
					</div>
					<div class="swiper-pagination">
						<?php if($nowProduct['images_num'] > 1){ ?>
							<?php for($i=0;$i<$nowProduct['images_num'];$i++){ ?><span
							class="swiper-pagination-switch <?php if($i==0){ ?>swiper-active-switch<?php } ?>"></span><?php } ?>
						<?php } ?>
						</div>
				</div>
				<div class="goods-header">
						<?php if (!$allow_drp) { ?>
						<h2 class="title"><?php echo $nowProduct['name'];?></h2>
						<?php } else { ?>
						<div class="item">
						<div class="row dotted">
							<div class="col-8">
								<p class="title f16 black"><?php echo $nowProduct['name']; ?></p>
							</div>
							<div class="col-4 t_right"
								style="padding: 0 0 0 10px; box-sizing: border-box; border-left: 1px solid #ddd;">
								<a class="btn-radius btn-default btn-outlet"
									href="<?php echo $drp_register_url; ?>"><i class="iconfont"></i><span>我要分销</span></a>
							</div>
						</div>
					</div>
					<div style="clear: both"></div>
						<?php } ?>
						<?php
						if ($reward) {
							?>
							<div class="reward"
						style="padding: 0px; text-align: left; margin-left: 10px; font-size: 12px; line-height: 14px;">
						<span
							style="padding: 0px 5px; background: #fe5842; color: white; border-radius: 3px;">满减</span><?php echo $reward?>
							</div>
						<?php
						}
						?>
						<div class="goods-price">
							<?php if($nowActivity){?>
								<div class="current-price">
							<span>￥&nbsp;</span> <i class="js-goods-price price">
									<?php
								if ($nowActivity ['type'] == 1) {
									echo ($maxPrice != 0 && $minPrice != $maxPrice) ? round ( $minPrice - $nowActivity ['price'], 2 ) . '-' . round ( $maxPrice ['price'] - $nowActivity ['price'], 2 ) : round ( $minPrice - $nowActivity ['price'], 2 );
								} else {
									echo ($maxPrice != 0 && $minPrice != $maxPrice) ? round ( $minPrice * $nowActivity ['discount'] / 10, 2 ) . '-' . round ( $maxPrice * $nowActivity ['discount'] / 10, 2 ) : round ( $minPrice * $nowActivity ['discount'] / 10, 2 );
								}
								?>
									</i> <span class="price-tag">扫码折扣价</span>
						</div>
						<div class="original-price">价格:￥<?php echo ($maxPrice!=0 && $minPrice!=$maxPrice) ? $minPrice.' - '.$maxPrice : $minPrice;?></div>
							<?php }else{ ?>
							<div class="current-price">
							<span>￥&nbsp;</span><i class="js-goods-price price"><?php echo ($maxPrice!=0 && $minPrice!=$maxPrice) ? $minPrice.'-'.$maxPrice : $minPrice;?></i>
						</div>
							<?php if($nowProduct['original_price'] != 0.00){ ?>
										<div class="original-price">原价:￥<?php echo $nowProduct['original_price'];?></div>
							<?php
								}
							}
							?>
							<?php if (!empty($nowProduct['buyer_quota'])) { ?>
							<span class="price-tag buyer-quota"
							data-buy-quantity="<?php echo $buy_quantity; ?>">限购<?php echo $nowProduct['buyer_quota'];?>件</span>
							<?php } ?>
						</div>
				</div>
				<hr class="with-margin" />
					<?php if (!empty($nowProduct['buy_way'])) { ?>
					<div class="sku-detail adv-opts" style="border-top: none;">
					<div class="sku-detail-inner adv-opts-inner">
							<?php if($newPropertyList){ foreach($newPropertyList as $value){ ?>
								<?php if (!empty($value['values'])) { ?>
								<dl>
							<dt><?php echo $value['name'];?>：</dt>
							<dd><?php $i=1;$count=count($value['values']);foreach($value['values'] as $v){ echo $v['value'];if($i!=$count){echo '、';}$i++;} ?></dd>
						</dl>
								<?php } ?>
							<?php } } ?>
							<?php if($nowProduct['show_sku']){ ?>
								<dl>
							<dt>剩余：</dt>
							<dd><?php echo $nowProduct['quantity'];?></dd>
						</dl>
							<?php } ?>
							<dl>
							<dt>运费：</dt>
							<dd>¥ <?php echo $nowProduct['postage_tpl'] ? $nowProduct['postage_tpl']['min'].'~'.$nowProduct['postage_tpl']['max'] : $nowProduct['postage']?></dd>
						</dl>
					</div>
					<div class="qrcode-buy">
						<a href="javascript:;"
							class="js-qrcode-buy btn btn-block btn-orange-dark butn-qrcode">立即购买</a>
					</div>
				</div>
					<?php } ?>
					<div class="js-components-container components-container">
					<div class="custom-store">
						<a class="custom-store-link clearfix"
							href="./home.php?id=<?php echo $now_store['store_id'];?>">
							<div class="custom-store-img"></div>
							<div class="custom-store-name"><?php echo $now_store['name'];?></div>
							<span class="custom-store-enter">进入店铺</span>
						</a>
						<div class="call_store">
							联系卖家：
							<div class="inlineBlock storeContact"
								login-status="<?php if(empty($_SESSION['wap_user'])){echo 0;}else{echo 1;}?>"
								open-url="<?php echo $imUrl;?>"
								data-tel="<?php echo $now_store['tel'] ?>"></div>
						</div>
					</div>
					<div
						class="custom-recommend-goods js-custom-recommend-goods hide clearfix">
						<div class="custom-recommend-goods-title">
							<a class="js-custom-recommend-goods-link" href="">推荐商品</a>
						</div>
						<ul
							class="custom-recommend-goods-list js-custom-recommend-goods-list clearfix"></ul>
					</div>
						
						<?php if($homeCustomField){foreach($homeCustomField as $value){echo $value['html'];} }?>
					</div>
				<!--------------->

				<style><!--

-->
</style>


				

<div data-product-id="<?php echo $nowProduct['product_id'];?>" class="section_body info_detail">
				<div>
					<div id="div_nav_fixed">
						<div class="div_nav" id="div_nav">
							<ul class="box"><!-- 
								<li>
									<a  class="xuanxiangka" href="javascript:;">商品属性</a>
								</li>-->
								<li style="border-right: 1px solid #ced3d7;">
									<a  href="javascript:;"  class="on xuanxiangka">图文详情</a>
								</li>
								<li>
									<a class="xuanxiangka" href="#pl_goods">评价</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="div_sections" id="div_sections">
					<!--  
						<section class="section_specification section_section">
							<dl>

								<div>
									
									<dd>
										<label>品牌</label><label>金字</label></dd>
									
									<dd>
										<label>包装方式</label><label>普通包装</label></dd>
									
									<dd>
										<label>特产</label><label>金华香肠</label></dd>
									
									<dd>
										<label>食品产地</label><label>国产</label></dd>
									
								</div>
							</dl>
						</section>
-->
						<section class="section_section section_detail on">
							<section id="info_detail_2_section">
								<div>						   
									<?php if($nowProduct['info']){ ?>
										<div class="custom-richtext"><?php echo $nowProduct['info'];?></div>
									<?php } ?>						  
								</div>
							</section>
						</section>
						<section class="section_comments section_section">
							<div>
								<!-- 
									<ul class="nav_comments box" id="nav_comments">
										<li onclick="changeCommentTable(this, event, 0);" class="on">
											<label>好评(31)</label>
										</li>
										<li onclick="changeCommentTable(this, event, 1);">
											<label>中评(0)</label>
										</li>
										<li onclick="changeCommentTable(this, event, 2);">
											<label>差评(0)</label>
										</li>
									</ul>
								-->
								<div class="tabber tabber_menu  tabber-ios clearfix">
									<a href="#pl_goods" class="active" style="border-right: 1px solid #fe5842">好评</a>
									<a href="#pl_nomal"  style="border-right: 1px solid #fe5842">中评</a>
									<a href="#pl_bad" style="width: 34%;">差评</a>
								</div>
								
							</div>
							<div id="list_comments">
								
								<ul class="list_comments" id="list_comments_0" ></ul>
								<ul class="list_comments" id="list_comments_1"></ul>
								<ul class="list_comments" id="list_comments_2" ></ul>
								<div class="wx_loading2" ><i class="wx_loading_icon"></i></div>
								<div class="empty-list" style="margin-top:40px;display: none">
									<div>
										<span class="font-size-16 c-black">神马，还没有评价？</span>
									</div>
									<div>
										<span class="font-size-12">怎么能忍？</span>
									</div>
								
								</div>
								<div class="s_empty" id="noMoreTips">已无更多评价！</div>
							</div>
						</section>
						
						
					</div>
				</div>
			</div>
			

			<!-------------->
			<div class="js-bottom-opts js-footer-auto-ele bottom-fix">
						<?php if($nowProduct['quantity'] == 0){ ?>
							<div class="btn-1-1">
					<button disabled="disabled" class="btn">商品已售罄</button>
				</div>
						<?php } else if ($buyer_quota) { ?>
							<div class="btn-1-1">
					<button disabled="disabled" class="btn">限购，您已购买<?php echo $buy_quantity; ?>件</button>
				</div>
						<?php } else if (empty($nowProduct['buy_way'])) { ?>
							<div class="btn-2-1">
					<a
						href="./outside_good.php?id=<?php echo $nowProduct['product_id']; ?>"
						class="js-buy-it btn btn-orange-dark">去购买</a>
				</div>
						<?php } else if($nowProduct['status'] == 1){ ?>
							<div class="btn-2-1">
					<a href="javascript:;" class="js-buy-it btn btn-orange-dark">立即购买</a>
				</div>
				<div class="btn-2-1">
					<a href="javascript:;" class="js-add-cart btn btn-white">加入购物车</a>
				</div>
						<?php } else{ ?>
							<div class="btn-1-1">
					<button disabled="disabled" class="btn">该商品已下架</button>
				</div>
						<?php } ?>
					</div>
				<?php if($pageHasAd && $pageAdPosition == 1 && $pageAdFieldCon){ echo $pageAdFieldCon;}?>
				</div>
				<?php if(!$is_mobile){ ?>
					<div class="content-sidebar">
						<a href="<?php echo $now_store['url'];?>" class="link">
							<div class="sidebar-section shop-card">
								<div class="table-cell">
									<img src="<?php echo $now_store['logo'];?>" width="60" height="60"
										class="shop-img" alt="<?php echo $now_store['name'];?>" />
								</div>
								<div class="table-cell">
									<p class="shop-name"><?php echo $now_store['name'];?></p>
								</div>
							</div>
						</a>
						<div class="sidebar-section qrcode-info">
							<div class="section-detail">
								<p class="text-center shop-detail">
									<strong>手机扫码访问</strong>
								</p>
								<p class="text-center weixin-title">微信“扫一扫”分享到朋友圈1</p>
								<p class="text-center qr-code">
									<img width="158" height="158"
										src="<?php echo $config['site_url'];?>/source/qrcode.php?type=good&id=<?php echo $nowProduct['product_id'];?>">
								</p>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if(!empty($storeNav)){ echo $storeNav;}?>
			</div>
			<?php include display('footer');?>
		</div>
		<?php if(!$is_mobile){ ?>
			<div class="popover popover-goods js-popover-goods">
		<div class="popover-inner">
			<h4 class="title clearfix">
				<span class="icon-weixin pull-left"></span>手机启动微信<br>扫一扫购买
			</h4>
			<div class="js-async ui-goods-qrcode">
				<img
					src="<?php echo $config['site_url'];?>/source/qrcode.php?type=good&id=<?php echo $nowProduct['product_id'];?>"
					alt="二维码" class="qrcode-img" />
			</div>
		</div>
	</div>
	<script>
				$(function(){
					$('.js-qrcode-buy').hover(function(){
						$('.js-popover-goods').css({'left':$(this).offset().left+$(this).width()+50+'px','top':$(this).offset().top-100+'px'}).show();
					},function(){
						$('.js-popover-goods').hide();
					});
				});
			</script>
		<?php } ?>
		<?php echo $shareData;?>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'goods', $nowProduct['name'], $_GET['id']); ?>