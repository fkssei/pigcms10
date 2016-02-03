<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<title><?php echo htmlspecialchars($product['name']) ?>-<?php echo $config['seo_title'] ?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link rel="icon"  href="favicon.ico" type="image/x-icon" />
<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/fancybox.css" type="text/css" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css" />
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/common.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/goods.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.fly.min.js"></script>
<script src="<?php echo TPL_URL;?>js/bootstrap.min.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.fancybox-1.3.1.pack.js"></script>

<script type="text/javascript" src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/index.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/index2.js"></script>

<script type="text/javascript" src="<?php echo TPL_URL;?>js/distance.js"></script>

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
.shopping .shopping_left .shopping_menu .shopping_menu_right .selected{border:1px solid #F63b3b; color:#f63b3b;}
.item_property_detail .normal {cursor:pointer;}
.shopping .shopping_left .shopping_menu .shopping_menu_right .notallowed {cursor:not-allowed; background:#FFF; color:#e5e5e5; border:1px #e5e5e5 dashed;}
.shopping .shopping_left .shopping_menu .shopping_menu_right .notallowed img {opacity:0.3}
</style>
<script>
var has_property = "<?php echo $product['has_property'] ?>";
var product_sku = <?php echo json_encode($product_sku_list) ?>;
var is_sku = "<?php echo $product['show_sku'] ?>";
var comment_url = "<?php echo url('comment:index') ?>";
var comment_add = "<?php echo url('comment:add') ?>";
var is_login = <?php echo $_SESSION['user'] ? 'true' : 'false' ?>;
var is_logistics = <?php echo $store['open_logistics'] ? 'true' : 'false' ?>;
var is_selffetch = <?php echo $store['buyer_selffetch'] ? 'true' : 'false' ?>;
</script>
</head>

<body >
<?php 
if ($is_preview) {
	include display( 'public:preview_header');
}
?>
<?php include display( 'public:header');?>
<div class="shopping content">
	<div class="shopping_left">
		<div class="shopping_menu">
			<div class="shopping_menu_left">
				<div class="mod18">
					<div id="picBox" class="picBox">
						<ul class="cf">
							<li> <a href="###"><img src="<?php echo $product['image'] ?>" alt="<?php echo htmlspecialchars($product['name']) ?>" /></a> </li>
							<?php 
							foreach ($product_image_list as $product_image) {
							?>
								<li><a href="###"><img src="<?php echo $product_image['image'] ?>" alt="<?php echo htmlspecialchars($product['name']) ?>" /></a> </li>
							<?php 
							}
							?>
						</ul>
					</div>
					<div class="shop_prev"><span id="prev" class="btn prev"></span></div>
					<div class="shop_next"> <span id="next" class="btn next"></span></div>
					<span id="prevTop" class="btn prev"></span> <span id="nextTop" class="btn next"></span>
					<div id="listBox" class="listBox">
						<ul class="cf">
							<li class="on"><i class="arr2"></i><img src="<?php echo $product['image'] ?>" /></li>
							<?php 
							foreach ($product_image_list as $product_image) {
							?>
								<li><i class="arr2"></i><img src="<?php echo $product_image['image'] ?>" alt="<?php echo htmlspecialchars($product['name']) ?>" /></li>
							<?php 
							}
							?>
						</ul>
					</div>
				</div>
			</div>
			<div class="shopping_menu_right">
				<ul>
					<li class="shoping_name"><?php echo htmlspecialchars($product['name']) ?></li>
					<li class="shopping_price">￥<span class="j_realPrice"><?php echo $product['price'] ?></span></li>
					<li class="shop_info">
						<span class="js-express">请设置您的位置</span><em>|</em><span class="js-distance" data-long="<?php echo $store_contact['long'] ?>" data-lat="<?php echo $store_contact['lat'] ?>"><i></i>0km</span><em>|</em><span><span><?php echo $product['drp_seller_qty'] ?></span>个分销商</span>
						<?php 
						if ($store['drp_level'] < 3 || $product['supplier_id'] == 0) {
						?>
							<span data-json="{'name':'<?php echo $product[name]?>','type':'product','wx_image':'<?php echo $product[wx_image]?>','pszlr':'<?php echo $product[drp_profit];?>','fxsl':'<?php echo $product[drp_seller_qty]?>','fxlr':'<?php echo ($product[min_fx_price]-$product[cost_price]).'~'.($product[max_fx_price]-$product[cost_price])?>'}" class="shopping_sale wyfx cursor">我要分销</span>
						<?php 
						}
						?>
					</li>
					<?php 
					if (isset($property_list) && !empty($property_list)) {
						foreach ($property_list as $key => $property) {
					?>
							<li class="item_property_detail" data-index="<?php echo $key ?>">
								<div class="shopping_txt js_property_name" data-msg="<?php echo $property['name'] ?>"><?php echo $property['name'] ?>:</div>
								<?php
								foreach ($property['values'] as $tmp) {
									if ($tmp['image']) {
								?>
										<div class="shopping_li_img js_selected_property normal" id="sku_<?php echo $property['pid'] . '_' . $tmp['vid'] ?>" data-pid="<?php echo $property['pid'] ?>" data-vid="<?php echo $tmp['vid'] ?>" data-sku="<?php echo $property['pid'] . ':' . $tmp['vid'] ?>"><img src="<?php echo $tmp['image'] ?>" /></div>
								<?php 
									} else {
								?>
										<div class="shopping_li_size js_selected_property normal" id="sku_<?php echo $property['pid'] . '_' . $tmp['vid'] ?>" data-pid="<?php echo $property['pid'] ?>" data-vid="<?php echo $tmp['vid'] ?>" data-sku="<?php echo $property['pid'] . ':' . $tmp['vid'] ?>"><?php echo $tmp['value'] ?></div>
								<?php 
									}
								}
								?>
							</li>
					<?php 
						}
					}
					?>
					<li>
						<div class="shopping_txt">数量:</div>
						<form onsubmit="return false">
							<div class="namub">
								<input class="stock-change-amout" value="1" id="quantity" readonly="readonly" />
								<div class="namub_right">
									<div class="namub_top stock-change-increase"></div>
									<div class="namub_bottom stock-change-reduce"></div>
								</div>
								<div style="float:left; width:200px; color:#F00; display:none;" class="dt-showtxt">正在提交中，请稍等</div>
							</div>
							<?php 
								if ($product['show_sku'] || $product['buyer_quota']) {
								?>
									<div style="float:left; width:200px;">
										<?php 
										if ($product['show_sku']) {
										?>
											&nbsp;&nbsp;库存：<span id="sAmout"><?php echo $product['quantity'] ?></span>件
										<?php 
										}
										if ($product['buyer_quota']) {
										?>
											&nbsp;&nbsp;每位会员限购<span class="js_buyer_quota"><?php echo $product['buyer_quota'] ?></span>件
										<?php
										}
										?>
									</div>
								<?php 
								}
								?>
						</form>
					</li>
					<li>
						<form onsubmit="return false;">
							<input type="hidden" name="sku_id" id="sku_id" value="" />
							<input type="hidden" name="product_id" id="product_id" value="<?php echo $product['product_id'] ?>" />
							<button class="shopping_shopping dt-go" style="cursor: pointer;">立即购买</button>
							<button class="shopping_shear dt-cart" style="cursor:pointer;">加入购物车</button>
						</form>
					</li>
				</ul>
			</div>
		</div>
		<div class="shopping_content">
			<div class="shopping_content_title">
				<div class="shopping_dingwei">
					<div class="shopping_tabd">
						<dl>
							<dd class="title_curn"><a href="#product_dec">商品介绍</a></dd>
							<dd><a href="#product_comment">商品评价</a></dd>
							<dt>
								<form onsubmit="return false;">
									<button class="dt-go">立即购买</button>
								</form>
								<div class="shopping_shaoma"><span  class="shaoma_img"></span><span class="shaoma_jian"></span>
									<div class="shopping_shaoma_erweima">
										<P>手机扫一扫&nbsp;&nbsp;轻松下单</P>
										<img src="<?php echo '/source/qrcode.php?type=good&id=' . $product['product_id'] ?>" /></div>
								</div>
							</dt>
						</dl>
					</div>
				</div>
			</div>
			<div class="shopping_dec"><a name="product_dec"></a>
				<div class="shopping_dec_title"> <span></span> 商品介绍 </div>
				<div class="shopping_dec_content">
					<?php echo $product['info'] ?>
				</div>
			</div>
			<div class="shopping_comment"><a name="product_comment"></a><a name="product_comment_image"></a>
				<div class="shopping_dec_title"> <span></span> 商品评价 </div>
				<div class="shopping_conmment_content">
					<div class="shopping_conmment_top">
						<div class="shopping_conmment_top_left">
							<p ><span><?php echo $comment_type_count['satisfaction_pre'] ?></span></p>
							<p>满意度</p>
						</div>
						<div class="shopping_conmment_top_content">
							<dl>
								<?php 
								foreach ($product_category_tag_list as $key => $tmp) {
								?>
									<dd><?php echo $tmp ?> (<?php echo $comment_tag_count_list[$key] + 0 ?>)</dd>
								<?php 
								}
								?>
							</dl>
						</div>
						<div class="shopping_conmment_top_right">
							<div class="shopping_publish"><a href="#fabiao"> <span></span> 发表评论 </a></div>
						</div>
					</div>
					<div class="shopping_conmment_bottom"> 
						
						<!-- 代码部分begin -->
						<div class="zzsc">
							<div class="tab">
								<div class="tab_title">
									<a href="javascript:;" class="on" data-tab="ALL">全部评价(<span><?php echo $comment_type_count['total'] ?></span>)</a>
									<a href="javascript:;" data-tab="HAO">满意(<span><?php echo $comment_type_count['t3'] + 0 ?></span>)</a>
									<a href="javascript:;" data-tab="ZHONG">一般(<span><?php echo $comment_type_count['t2'] + 0 ?></span>)</a>
									<a href="javascript:;" data-tab="CHA">不满意(<span><?php echo $comment_type_count['t1'] + 0 ?></span>)</a>
								</div>
								<div class="tab_form">
									<div class="form_sec">
										<form action="" method="get">
											<input type="checkbox"  class="ui-checkbox" id="has_image" >
											<span>有照片</span>
										</form>
									</div>
								</div>
							</div>
							<div class="content_tab">
								<ul>
									<li style="display:block;"><div style="height:24px; line-height:24px; padding-top:20px;" class="js_default">加载中</div></li>
									<li><div style="height:24px; line-height:24px; padding-top:20px;" class="js_default">加载中</div></li>
									<li><div style="height:24px; line-height:24px; padding-top:20px;" class="js_default">加载中</div></li>
									<li><div style="height:24px; line-height:24px; padding-top:20px;" class="js_default">加载中</div></li>
								</ul>
							</div>
							<div class="shop_pingjia"> <a  name="fabiao"></a>
								<div class="shop_pinjiga_title">发表评价</div>
									<div class="shop_pinjgia_form">
										<div class="shop_pingjia_form_list  appraise_li-list_top js-score">
											<div class="shop_pingjia_form_list_zong">总体评价:</div>
											<ul>
												<li class="red">
													<div class="appraise_li-list_top_icon manyi">
														<input type="radio" class="ui-checkbox" name="manyi" id="refund-reason00" value="5" checked="checked" />
														<label for="refund-reason00" ><span>满意</span></label>
													</div>
												</li>
												<li class="yellow">
													<div class="appraise_li-list_top_icon yiban">
														<input type="radio" class="ui-checkbox" name="manyi" id="refund-reason001" value="3" />
														<label for="refund-reason001" ><span>一般</span></label>
													</div>
												</li>
												<li class="gray">
													<div class="appraise_li-list_top_icon bumanyi">
														<input type="radio"  class="ui-checkbox" name="manyi" id="refund-reason002" value="1" />
														<label for="refund-reason002" ><span>不满意</span></label>
													</div>
												</li>
												<div style="clear:both"></div>
											</ul>
										</div>
										<div class="shop_pingjia_form_list  appraise_li-list_top ">
											<div class="shop_pingjia_form_list_zong">标签:</div>
											<ul class="biaoqian">
												<?php 
												foreach ($product_category_tag_list as $key => $tmp) {
												?>
													<li>
														<input type="checkbox" class="ui-checkbox js-tag" id="tag_<?php echo $key ?>" style="background:#ff0000" value="<?php echo $key ?>" />
														<label for="tag_<?php echo $key ?>" ><?php echo $tmp ?></label>
													</li>
												<?php 
												}
												?>
											</ul>
										</div>
										<div class="textarea">
											<textarea name="content" cols="" rows="" class="form_textarea" onpaste="$(this).trigger('keyup')"></textarea>
										</div>
										<div class="shop_pingjia_form_list  appraise_li-list_top " style="border:0;">
											<div class="shop_pingjia_form_list_zong">图片:</div>
											<div class="shop_pingjia_list">
												<ul>
													<li id="shop_add">
														<form enctype="multipart/form-data" id="upload_image_form" target="iframe_upload_image" method="post" action="<?php echo url('comment:attachment') ?>">
															<div class="updat_pic"> <a href="javascript:" id="upload_message"><img src="<?php echo TPL_URL;?>/images/jiahao.png" /></a>
																<input type="file" name="file" class="ehdel_upload" id="upload_image">
																<p>0/10</p>
															</div>
														</form>
													</li>
												</ul>
											</div>
											
											<!--图片上传--> 
										</div>
										<iframe name="iframe_upload_image" style="width:0px; height:0px; display:none;"></iframe>
									</div>
									<div class="button">
										<div class="button_txt">
											<span>文明上网</span>
											<span>礼貌发帖</span>
											<span></span>
											<span class="js-word-number">0/300</span>
										</div>
										<input type="hidden" id="score" value="5" />
										<button class="form_button js_save">提交</button>
										<div style="clear:both"></div>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="shopping_right">
		<div class="shop_info_tab">
			<form onsubmit="return false;">
				<div class="shop_info_tab_top">
					<div class="shop_info_tab_img"> <img src="<?php echo $store['logo'] ?>" /> </div>
					<div  class="shop_info_tab_list">
						<ul>
							<li class="shop_info_tab_list_name">
								<a target="_blank" href="<?php echo url_rewrite('store:index', array('id' => $store['store_id'])) ?>">
									<?php echo htmlspecialchars($store['name']) ?>
								</a>
							</li>
							<li class="shop_info_tab_list_dec">(<?php echo $sale_category ?>)</li>
							<li>
								<div class="shop_info_tab_list_bor">
									<button onclick="userAttention(<?php echo $store['store_id'] ?>, 2)">关注我</button>
									<div class="shop_info_tab_list_txt store_attention_<?php echo $store['store_id'] ?>"><?php echo $store['attention_num'] ?>人</div>
								</div>
							</li>
							<li>
								<div class="shop_info_tab_list_bor">
									<button onclick="userCollect(<?php echo $store['store_id'] ?>, 2)">收藏我</button>
									<div class="shop_info_tab_list_txt store_collect_<?php echo $store['store_id'] ?>"><?php echo $store['collect'] ?>人</div>
								</div>
							</li>
							<li class="phone_number"><span></span><?php echo $store_contact['phone1'] ? $store_contact['phone1'] . '-' : '' ?><?php echo $store_contact['phone2'] ?></li>
						</ul>
					</div>
				</div>
				<div class="shop_info_tab_bottom">
					<style>
					.js-contact_shop {display: none;}
					</style>
					<button class="go_shop" onclick="location.href='<?php echo url_rewrite('store:index', array('id' => $product['store_id'])) ?>'">进入店铺</button>
					<button class="contact_shop js-contact_shop" open-url="<?php echo $imUrl;?>" data-tel="<?php echo $store['service_tel'] ?>">联系客服</button>
				</div>
			</form>
			<div class="content_conmment_list">
				<div class="content__cell content__cell--slider">
					<div class="component-index-slider">
						<div class="index-slider ui-slider log-mod-viewed">
							<?php 
							if (count($comment_list['comment_list']) > 0) { 
							?>
							<div class="pre-next">
								<a style="opacity: 1; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-previous sp-slide--previous  "> </a>
								<a style="opacity:1; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-next sp-slide--next "></a>
							</div>
							<div class="head ccf">
								<ul class="trigger-container ui-slider__triggers mt-slider-trigger-container">
									<li class="mt-slider-trigger"> </li>
									<li class="mt-slider-trigger"> </li>
									<li class="mt-slider-trigger"> </li>
									<li class="mt-slider-trigger"> </li>
									<li class="mt-slider-trigger"></li>
									<li class="mt-slider-trigger mt-slider-current-trigger"></li>
									<div style="clear:both"></div>
								</ul>
							</div>
							<ul class="content">
								<?php
								$i = 0;
								foreach ($comment_list['comment_list'] as $key => $tmp) {
									$display = 'none';
									if ($i == 0) {
										$display = 'block';
									}
									$i++;
								?>
									<li class="cf" style="opacity: 1; display: <?php echo $display ?>;">
										<div class="content_conmment">
											<div class="content_asit_img"><a href="###"><img src="<?php echo $comment_list['user_list'][$tmp['uid']]['avatar'] ?>" /></a></div>
											<div class="content_custom">
												<div class="content_time"><a href="###"><?php echo anonymous($comment_list['user_list'][$tmp['uid']]['nickname']) ?></a></div>
												<p><?php echo date('Y-m-d H:i:s', $tmp['dateline']) ?></p>
											</div>
											<div class="content_comment_txt"><?php echo htmlspecialchars($tmp['content']) ?></div>
										</div>
									</li>
								<?php 
								}
								?>
							</ul>
							<?php 
							} else {
								echo '<div style="padding-top:10px; padding-bottom:10px;">暂无评论</div>';
							}
							?>
						</div>
					</div>
				</div>
				<?php 
				if (count($comment_list['comment_list']) > 0) {
				?>
					<div class="conmmetn_switch"> </div>
				<?php 
				}
				?>
			</div>
		</div>
		<div class="shopping_list">
			<div class="shopping_list_title">猜你喜欢</div>
			<ul>
				<?php 
				$similar_product_count = count($similar_product_list);
				foreach ($similar_product_list as $key => $similar_product) {
					$border = '';
					if ($key == $similar_product_count) {
						$border = 'border:0';
					}
				?>
					<li style="<?php echo $border ?>">
						<a href="<?php echo url_rewrite('goods:index', array('id' => $similar_product['product_id'])) ?>">
							<div class="content_list_img">
								<img src="<?php echo $similar_product['image'] ?>" />
							</div>
							<div class="content_list_txt">
								<div class="content_shop_name"><?php echo htmlspecialchars($similar_product['name']) ?></div>
								<div class="content_shop_jion"><?php echo $similar_product['sales'] < 10 ? '10笔以内' : $similar_product['sales'] ?></div>
							</div>
						</a>
					</li>
				<?php 
				}
				?>
			</ul>
		</div>
		<div class="content_activity_asid ">
			<dl>
				<dt>
					<div class="content_activity_asid_title content_product_title ">分销动态</div>
				</dt>
				<dt> </dt>
				<?php
				$sns_count = count($sns_list);
				foreach ($sns_list as $key => $tmp) {
					$border = '';
					if ($key == $sns_count - 1) {
						$border = 'border:0';
					}
				?>
					<dd style="<?php echo $border ?>">
						<div class="content_conmment">
							<div class="content_asit_img"><a href=""><img src="<?php echo $tmp['logo'] ?>"></a></div>
							<div class="content_custom">
								<div class="content_time"><a href="###"><?php echo $tmp['name'] ?></a></div>
								<p>分销获得了<?php echo $tmp['profit'] ?>元利润</p>
							</div>
							<div class="content_comment_txt"><?php echo date('Y-m-d H:i:s', $tmp['add_time']) ?></div>
						</div>
					</dd>
				<?php 
				}
				?>
			</dl>
		</div>
	</div>
</div>
</div>
<?php include display( 'public:footer');?>

<script type="text/javascript">
(function(){
	
	function G(s){
		return document.getElementById(s);
	}
	
	function getStyle(obj, attr){
		if(obj.currentStyle){
			return obj.currentStyle[attr];
		}else{
			return getComputedStyle(obj, false)[attr];
		}
	}
	
	function Animate(obj, json){
		if(obj.timer){
			clearInterval(obj.timer);
		}
		obj.timer = setInterval(function(){
			for(var attr in json){
				var iCur = parseInt(getStyle(obj, attr));
				iCur = iCur ? iCur : 0;
				var iSpeed = (json[attr] - iCur) / 5;
				iSpeed = iSpeed > 0 ? Math.ceil(iSpeed) : Math.floor(iSpeed);
				obj.style[attr] = iCur + iSpeed + 'px';
				if(iCur == json[attr]){
					clearInterval(obj.timer);
				}
			}
		}, 30);
	}

	var oPic = G("picBox");
	var oList = G("listBox");
	
	var oPrev = G("prev");
	var oNext = G("next");
	var oPrevTop = G("prevTop");
	var oNextTop = G("nextTop");

	var oPicLi = oPic.getElementsByTagName("li");
	var oListLi = oList.getElementsByTagName("li");
	var len1 = oPicLi.length;
	var len2 = oListLi.length;
	
	var oPicUl = oPic.getElementsByTagName("ul")[0];
	var oListUl = oList.getElementsByTagName("ul")[0];
	var w1 = oPicLi[0].offsetWidth;
	var w2 = oListLi[0].offsetWidth;

	oPicUl.style.width = w1 * len1 + "px";
	oListUl.style.width = w2 * len2 + "px";

	var index = 0;
	
	var num = 5;
	var num2 = Math.ceil(num / 2);

	function Change(){

		Animate(oPicUl, {left: - index * w1});
		
		if(index < num2){
			Animate(oListUl, {left: 0});
		}else if(index + num2 <= len2){
			Animate(oListUl, {left: - (index - num2 + 1) * w2});
		}else{
			Animate(oListUl, {left: - (len2 - num) * w2});
		}

		for (var i = 0; i < len2; i++) {
			oListLi[i].className = "";
			if(i == index){
				oListLi[i].className = "on";
			}
		}
	}
	
	oNextTop.onclick = oNext.onclick = function(){
		index ++;
		index = index == len2 ? 0 : index;
		Change();
	}

	oPrevTop.onclick = oPrev.onclick = function(){
		index --;
		index = index == -1 ? len2 -1 : index;
		Change();
	}

	for (var i = 0; i < len2; i++) {
		oListLi[i].index = i;
		oListLi[i].onclick = function(){
			index = this.index;
			Change();
		}
	}
	
})()
</script>
</body>
</html>