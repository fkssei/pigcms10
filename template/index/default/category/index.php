<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title><?php echo $config[ 'site_name'];?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css">
<link href="<?php echo TPL_URL;?>css/category_style.css" type="text/css" rel="stylesheet">
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/jquery.lazyload.min.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo TPL_URL;?>js/provice_city.js"></script>
<script src="<?php echo TPL_URL;?>js/category.js"></script>
<script src="<?php echo TPL_URL;?>js/distance.js"></script>

<script src="<?php echo TPL_URL;?>js/index2.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo TPL_URL;?>js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="<?php echo TPL_URL;?>js/DD_belatedPNG_0.0.8a.js" mce_src="<?php echo TPL_URL;?>js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css"> 
body{ behavior:url("csshover.htc");}
</style>
<![endif]-->
<style>
.menu_list li{height:51px;line-height:51px;}
.menu_list li.prop_show_more{height:auto}
.category .category_menu ul.menu_list li dl{overflow:hidden}
</style>
</head>

<body>
<?php include display( 'public:header');?>
<div class="content category">
	<div class="category_menu">
		<div class="menu_title"> 
			<div class="filter-breadcrumb ">
				<span class="breadcrumb__item">
					<a class="filter-tag filter_tag_style filter-tag--all" href="<?php echo url_rewrite('category:index', array('id' => 99999)) ?>">全部商品</a>
				</span>
				<?php
				if($_GET['id'] != 99999) {
				?>
					<span class="breadcrumb__crumb"></span> 
					<span class="breadcrumb__item" >
						<span class="breadcrumb_item__title filter-tag">
							<a href="<?php echo url_rewrite('category:index', array('id' => $v['cat_id'])) ?>">
								<?php echo $f_category['cat_name']?>
							</a>
							<i class="tri"></i>
						</span>
						<span class="breadcrumb_item__option">
							<span class="option-list--wrap inline-block">
								<span class="option-list--inner inline-block"><a href="<?php echo url_rewrite('category:index', array('id' => 99999)) ?>" class="log-mod-viewed">全部</a>
									<?php if($top_cate_list) {?>
									<?php foreach($top_cate_list as $v) {?>
									<a class="log-mod-viewed" href="<?php echo url_rewrite('category:index', array('id' => $v['cat_id'])) ?>"><?php echo $v['cat_name']?></a>
									<?php }} ?>
								</span>
							</span>
						</span>
					</span>
				<?php
				}
				?>
				<?php
				if($category_detail['cat_level']==2){
				?>
				<span class="breadcrumb__crumb"></span>
				<span class="breadcrumb__item">
					<div>
						<span class="breadcrumb_item__title filter-tag">
							<?php if($category_detail['cat_fid']){
							  echo $category_detail['cat_name'];
							 }?>
							<i class="tri"></i>
						</span>
						<span class="breadcrumb_item__option">
							<span class="option-list--wrap inline-block">
								<span class="option-list--inner inline-block"><a href="<?php echo url_rewrite('category:index', array('id' => $category_detail['cat_fid'])) ?>" class="<?php if($category_detail['cat_id']!=$_GET['id']){?>current<?php } ?> log-mod-viewed">全部</a>
									<?php foreach($s_category as $v) {?>
										<a class="<?php if($_GET['id']==$v['cat_id']){?>current<?php } ?> log-mod-viewed" href="<?php echo url_rewrite('category:index', array('id' => $v['cat_id'])) ?>"><?php echo $v['cat_name']?></a>
									<?php } ?>
								</span>
							</span>
						</span>
					</div>
				</span>
				<?php } ?>
			</div>
		</div>
		<div class="menu_content">
			<div class="menu_content_title"> 
				<dl>
					<dd>商品筛选</dd>
					<dd><a href="javascript:void(0)"><span>共<?php echo $product_count?>个商品</span></a></dd>
				</dl>
			</div>
			
			<?php 
			if ($prop_arr) {
			?>
				<style>
				#condition_content li {margin-right:5px;}
				</style>
				<div class="condition" style="display:block;">
					<div class="condition_title"> 已选条件: </div>
					<ul id="condition_content">
						<?php 
						foreach ($prop_arr as $tmp) {
						?>
							<li data-property_id="<?php echo $tmp ?>">
								<dl>
									<dd>加载中</dd>
								</dl>
								<span></span>
							</li>
						<?php 
						}
						?>
					</ul>
					<div class="menu_clear"><a href="<?php echo url_rewrite('category:index', array('id' => $_GET['id'])) ?>">清除全部</a></div>
				</div>
			<?php 
			}
			?>
			<ul class="menu_list js-property-value" data-property_id="">
				<?php
				if($_GET['id'] == 99999){
				?>
				<li index="0">
					<dl>
						<dt>类别：</dt>
						<dt class="menu_right">
							<div class="more" ><a href="javascript:void(0)">更多<span></span></a></div>
						</dt>
						<?php 
						foreach($top_cate_list as $k => $v) {
						?>
							<dd><a class="" href="<?php echo url_rewrite('category:index', array('id' => $v['cat_id'])) ?>" data-property_value="3"><?php echo $v['cat_name']; ?></a></dd>
						<?php
						}
						?>
					</dl>
				</li>
				<?php
				}
				?>
				<?php
				if($category_detail['cat_level'] == 1 && count($s_category) > 0) {
				?>
					<li index="0">
						<dl>
							<dt>类别：</dt>
							<dt class="menu_right">
								<div class="more" ><a href="javascript:void(0)">更多<span></span></a></div>
							</dt>
							<?php
							foreach($s_category as $k => $v) {
							?>
								<dd style="position:static;top:0px;clear:none;"> <a class="" href="<?php echo url_rewrite('category:index', array('id' => $v['cat_id'])) ?>" data-property_value="3"><?php echo $v['cat_name']; ?></a> </dd>
							<?php
							}
							?>
						</dl>
					</li>
				<?php
				}
				?>
				
				<?php
				if (!empty($property_list['property_list'])) {
					foreach($property_list['property_list'] as $k => $v) {
				?>
				<li index="<?php echo $k + 1; ?>" class="condition_li js-property-detail" tip="0">
					<dl >
						<dt><?php echo $v['name']?>：</dt>
						<dt class="menu_right">
							<div class="more" ><a href="javascript:void(0)">更多<span></span></a></div>
						</dt>
						<div style="width:auto;float:left">
						<?php
						if (isset($property_list['property_value_list'][$v['pid']]) && count($property_list['property_value_list'][$v['pid']]) > 0) {
							foreach($property_list['property_value_list'][$v['pid']] as $property_value) {
								$selected = '';
								if (in_array($property_value['vid'], $prop_arr)) {
									$selected = 'property-value-current';
								}
						?>
								<dd style="position:static;top:0px;clear:none;"><a class="property_value <?php echo $selected ?>" id="property_value_<?php echo $property_value['vid'] ?>" href="javascript:" data-property_value="<?php echo $property_value['vid'] ?>"><?php echo $property_value['value'] ?></a></dd>
						<?php
							}
						}
						?>
						</div>
					</dl>
				</li>
				<?php
					}
				}
				?>
			</ul>
		</div>
	</div>
	<div class="cata_table content_commodity">
		<form action="<?php  dourl('category:index',array('sort'=>$sort))?>">
		<dl>
		<dd class="<?php echo !isset($search_param['order']) ? 'cata_curnt' : '' ?> cata_table_li" onclick="location.href='<?php echo url_rewrite('category:index', $default_param) ?>'"><a data-sort="default" href="<?php echo url_rewrite('category:index', $default_param) ?>">默认</a></dd>
		<dd class="cata_table_li <?php echo isset($search_param['order']) && $search_param['order'] == 'sales' ? 'cata_curnt' : '' ?>" onclick="location.href='<?php echo url_rewrite('category:index', $hot_param) ?>'"><a title="点击后按月销量从高到低" data-sort="hot" href="<?php echo url_rewrite('category:index', $hot_param) ?>" class="<?php if($search_param['sort']=='asc') { echo "arrow_down"; } else {echo "arrow_up";}?>">热销</a></dd>
		<dd class="cata_table_li <?php echo isset($search_param['order']) && $search_param['order'] == 'price' ? 'cata_curnt' : '' ?>" onclick="location.href='<?php echo url_rewrite('category:index', $price_param) ?>'"><a data-sort="price-asc" href="<?php echo url_rewrite('category:index', $price_param) ?>">价格</a></dd>
		<dd class="cata_table_li <?php echo isset($search_param['order']) && $search_param['order'] == 'collect' ? 'cata_curnt' : '' ?>" onclick="location.href='<?php echo url_rewrite('category:index', $collect_param) ?>'"><a data-sort="collect" href="<?php echo url_rewrite('category:index', $collect_param) ?>">人气</a></dd>
		<!--<dd class="distance"><a data-sort="distance" href="<?php echo url_rewrite('category:index',$distance_param)?>"><span></span>距离</dd>-->
		
		<?php 
			if($WebUserInfo['long']) {?>
			<dd onclick="javascript:location.href='<?php echo url_rewrite('category:index', $distance_param); ?>'"  class="cata_table_li distance <?php echo isset($search_param['order']) && $search_param['order'] == 'distance' ? 'cata_curnt' : '' ?>""><span></span>距离</dd>
		<?php }?>
		
		
		
		<!--<form>-->
		<div class="price_btn">
			<input placeholder="￥" id="start_price">
			<span>-</span>
			<input placeholder="￥" id="end_price">
			<input type="button" value="确定" class="orangeBtn j_filterPriceSubmit" onclick="searchGoods()" />
			</div>
		<!--</form>-->
		</dd>
		<dt>
			<div class="cata_left"></div>
			<div class="cata_right"></div>
		</dt>
		<dt><span><?php echo $page_arr['current_page']; ?></span>/<?php echo $page_arr['total_pages']; ?></dt>
		</dl>
		</form>
		<div class="content_list">
			<ul class="content_list_ul">
				<?php 
				foreach ($product_list as $v) {
				?>
					<li>
						<a href="<?php echo $v['link']; ?>">
							<div class="content_list_img"><img onload="AutoResizeImage(224,224,this)" src="<?php echo $v['image']; ?>">
								<div class="shop_list">
									<form action="javascript:void(0)">
										<div class="shop_guanzhu">
											<button onclick="userAttention(<?php echo $v['product_id'] ?>, 1)">关注商品</button>
										</div>
										<div class="shop_shoucang">
											<button onclick="userCollect(<?php echo $v['product_id'] ?>, 1)">收藏商品</button>
										</div>
									</form>
								</div>
							</div>
							<div class="content_list_txt">
								<div class="content_list_pice">￥<span><?php echo $v['price'] ?></span></div>
								<div class="content_list_dec"><span>已售<?php echo $v['sales']; ?>/</span>分销<?php echo $v['drp_seller_qty']; ?></div>
							</div>
							<div class="content_list_txt js-express" data-lat="<?php echo $store_contact_info[$v['store_id']]['lat'] ?>" data-long="<?php echo $store_contact_info[$v['store_id']]['long'] ?>">
								<div class="content_list_day">计算中</div>
								<div class="content_list_add">计算中</div>
							</div>
							<div class="shop_info">
								<div class="content_shop_name"><?php echo $v['name']; ?></div>
								<?php
								if($store_contact_info[$v['store_id']]['city']) {
								?>
									<div class="content_shop_add"><script type="text/javascript">document.write(provice_city[<?php echo $store_contact_info[$v['store_id']]['city'] ?>][0].substr(0, 5))</script></div>
								<?php
								}
								?>
							</div>
						</a>
					</li>
				<?php
				}
				?>
			</ul>
		</div>
	</div>
	<!--分页-->
	<div style="display: block ;margin:auto" class="form mt20 page_list" id="J_form">
		<div class="pagination" id="pages">
			<?php echo $pages ?>
			<span>
				&nbsp;跳转到：&nbsp;<input type="text" value="" id="jump_page" name="currentPage" class="J_topage page-skip">
				<input type="submit" value="跳转" class="J_pageSubmit page-submit" onclick="jumpPage()">
			</span>
		</div>
		<div title="" style="display: none;" class="pagesNum"></div>
	</div>
	<!--分页--> 
</div>
<?php include display( 'public:footer');?>
<?php include display( 'public:alt_login');?>
<script type="text/javascript">

$('.breadcrumb__item').hover(function(){
	if($(this).find('.breadcrumb_item__option').html()){
		$(this).addClass('dropdown--open');
	}
},function(){
	$(this).removeClass('dropdown--open');
});

$('.category_list_img').mouseover(function(){
	$(this).find('.bmbox').css('display', 'block');
}).mouseout(function(){
	$(this).find('.bmbox').css('display', 'none');
});
<?php 
$catid = $category_detail['cat_id'] ? $category_detail['cat_id'] : 99999;
?>
var url = '<?php echo url_rewrite('category:index', array('id' => $catid)) ?>';
var search_url = '<?php if (empty($prop_arr)) { echo url_rewrite('category:index', array('id' => $catid)); } else { echo url_rewrite('category:index', array('id' => $catid, 'prop' => 'prop_' . join('_', $prop_arr))); } ?>';

function searchGoods() {
	var start_price = $("#start_price").val();
	var end_price 	= $("#end_price").val();

	if(start_price == '' || end_price == ''){
		tusi('价格区间必须填写');
	}else{
		var reg1 =  /^\d+$/;
		if(start_price.match(reg1) == null) {
			tusi('开始价格请用正整数');
			return;
		}

		if(end_price.match(reg1) == null) {
			tusi('结束价格请用正整数');
			return;
		}
			
		if(start_price < end_price){
			var start = start_price;
			var end_price = end_price;
		}else{
			var start = end_price;
			var end_price = start_price;
		}
		
		if (start_price.length > 0) {
			//url += "&start_price=" + start_price;
			search_url += '/'+start;
		}

		if (end_price.length > 0) {
			//url += "&end_price=" + end_price;
			search_url += '/'+end_price;
		}

		location.href = search_url;

	}
}

function changePage(page) {
	if (page.length == 0) {
		return;
	}

	var re = /^[0-9]*[1-9][0-9]*$/;
	if (!re.test(page)) {
		alert("请填写正确的页数");
		return;
	}
	
	var url = "<?php echo url_rewrite('category:index', $search_param) ?>";
	location.href = url + "/" + page;
}

$(function () {
	$("#pages a").click(function () {
		var page = $(this).attr("data-page-num");
		changePage(page);
	});
});

function jumpPage() {
	var page = $("#jump_page").val();
	changePage(page);
}

var property_list = {'property_113':40};
$(function () {
	
	$(".js_property_group").click(function () {
		if ($(this).parents('ul').attr("data-property_id").length == 0) {
			return;
		}
		$(this).parents('ul').attr("data-property_id", '');

		var property_value = '';
		$(".js-property-value").each(function () {
			if ($(this).attr("data-property_id").length > 0) {
				if (property_value.length == 0) {
					property_value = $(this).attr("data-property_id");
				} else {
					property_value += "_" + $(this).attr("data-property_id");
				}
			}
		});

		if (property_value.length > 0) {
			url = url + "/prop_" + property_value;
		}
		
		location.href = url;
	});
	
	$(".property-value-current").each(function () {
		var property_value = $(this).attr("data-property_value");
		$(this).parents('ul').attr("data-property_id", property_value);
	});
});

var cur_page=<?php echo $page_arr['current_page']; ?>;
var tol_page=<?php echo $page_arr['total_pages']; ?>;

if(cur_page>=tol_page){
	$('.cata_right').css('background-position','340px -82px');
}

if((cur_page==1)){
	$('.cata_left').css('background-position','367px -82px')
}
	
	
$('.cata_right').click(function(){
	var page=<?php echo $_GET['page']?$_GET['page']:1 ?>;
	page++;
	changePage(page);
});

$('.cata_left').click(function(){
	var page=<?php echo $_GET['page']?$_GET['page']:1 ?>;
	page--;
	
	if(page<=0){
		return;	
	}
	changePage(page);
});

var prop = "<?php echo join('_', $prop_arr) ?>";
if (prop.length > 0) {
	$("#condition_content li").each(function () {
		$(this).find("dd").html($("#property_value_" + $(this).data("property_id")).html());
	});
}
</script>
</body>
</html>