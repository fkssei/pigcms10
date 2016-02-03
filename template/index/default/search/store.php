<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>店铺搜索-<?php echo $config['seo_title'] ?></title>
	<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
	<meta name="description" content="<?php echo $config['seo_description'] ?>" />
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet">
	<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
	<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet"
	<link href="<?php echo TPL_URL;?>css/index1.css" type="text/css" rel="stylesheet">
	<link href="<?php echo TPL_URL;?>css/store.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css">
	<link href=" " type="text/css" rel="stylesheet" id="sc">
	<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.lazyload.js"></script>
	<script src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
	<script src="<?php echo TPL_URL;?>js/common.js"></script>
	<script src="<?php echo TPL_URL;?>js/index.js"></script>
	<script src="<?php echo TPL_URL;?>js/store_list.js"></script>
	<script src="<?php echo TPL_URL;?>js/distance.js"></script>
	<script src="<?php echo TPL_URL;?>js/index2.js"></script>

	<!--[if lt IE 9]>
	<script src="<?php echo TPL_URL;?>js/html5shiv.min-min.v01cbd8f0.js"></script>
	<![endif]-->
	<!--[if IE 6]>
	<script  src="<?php echo TPL_URL;?>js/DD_belatedPNG_0.0.8a.js" mce_src="js/DD_belatedPNG_0.0.8a.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('*');</script>
	<style type="text/css">
		body{ behavior:url("csshover.htc");}
	</style>
	<![endif]-->
	<script>
		$(function () {
			$(".page_list a").click(function () {
				var page = $(this).attr("data-page-num");
				var url = "<?php echo url('search:store', $param_search) ?>&page=" + page;
				location.href = url;
			});
			//上一页
			$('.cata_left').click(function(){
				var page=<?php echo $_GET['page']?$_GET['page']:1 ?>;
				page--;

				if(page <= 0){
					return;
				}
				changePage(page);
			});
			//下一页
			$('.cata_right').click(function(){
				var page=<?php echo $_GET['page']?$_GET['page']:1 ?>;
				page++;
				changePage(page);
			});


			function changePage(page) {
				if (page.length == 0) {
					return;
				}
				var re = /^[0-9]*[1-9][0-9]*$/;
				if (!re.test(page)) {
					alert("请填写正确的页数");
					return;
				}
				var total_page = "<?php echo $current_page['total_page'];?>";
				if(page > total_page){page = total_page;}
				
				var url = "<?php echo url('search:store', $param) ?>";
				location.href = url + "&page=" + page;

			}

		});

		
		$(function(){




			//点击关闭类目属性
			$(".menu_content .condition li span.catname").click(function(){
				var dataid =  $(this).attr("data-id");
			
				location.href="<?php echo url('search:store',array('keyword'=>$param_category['keyword'],'distance'=>$distance)) ?>";
			})
			
			
			$(".menu_content .condition li span.distance").click(function(){
				var dataid =  $(this).attr("data-id");
				location.href="<?php echo url('search:store',array('keyword'=>$param_category['keyword'],'id'=>$id)) ?>";
			})			
			

			$(" .menu_content .condition .menu_clear a").click(function(){
				var dataid =  $(this).attr("data-id");

				location.href="<?php echo url('search:store',array('keyword'=>$param_category['keyword'])) ?>";
			})
		})



</script>
<style>
	.category .category_menu ul.menu_list li dl .menu_right {
	color: #191919;
	float: right;
	font-size: 12px;
	line-height: 20px;
	margin-top: 15px;
	width: 70px;
}
.category .cata_table dl dd.cata_curnt{color:#fff;}
.category .category_menu .condition ul li{margin:auto 5px;}
.category .category_menu .condition ul li span{cursor:pointer}
</style>	
</head>

<body>
<?php include display( 'public:header');?>
<div class="content category  shop_list">
<div class="menu_title">
	<dl>
		<dt>所有店铺</dt>
<!--
		<dd><span></span></dd>
		<dd><a href="###">宝宝用品<span></span></a></dd>
		<dd><span></span></dd>
		<dd><a href="###">纸尿裤<span></span></a></dd>
-->

		<?php if($categoryTree['tree']) {?>
		<dd><span></span></dd>
		<dd><a href="<?php echo url('search:store', array('id' => $categoryTree['tree']['cat_id'])) ?>"><?php echo $categoryTree['tree']['name']?></a></dd>
			<?php if($categoryTree['tree']['son']) {?>
				<dd><span></span></dd>
				<dd><a href="<?php echo url('search:store', array('id' => $categoryTree['tree']['son']['cat_id'])) ?>"><?php echo $categoryTree['tree']['son']['name']?></a></dd>
			<?php }?>
		<?php }?>
	</dl>
</div>
<div class="shop_list_left">
<div class="category_menu  ">
	<div class="menu_content">
		<div class="menu_content_title">
			<dl>
				<!--<dt>纸尿裤</dt>-->
				<dd><a href="javascript:void(0)">店铺筛选 </a></dd>
				<dd><a href="javascript:void(0)"><span>共<?php echo $shop_count;?>个店铺</span></a></dd>
			</dl>
		</div>
		<?php if($current_sale_category || $distance) {?>
		<div class="condition condition_shop_list" >
			<div class="condition_title"> 已选条件: </div>
			<ul>
			<!--
				<li>
					<dl>
						<dt>营业状态：</dt>
						<dd>营业中</dd>
					</dl>
					<span></span>
				</li>
			-->
				<?php if($current_sale_category) {?>
					<li>
						<dl>
							<dt>店铺类目：</dt>
							<dd><?php echo $current_sale_category['name'];?></dd>
						</dl>
						<span class="catname"></span>
					</li>
				<?php }?>
				

				<?php if($distance) {?>
					<?php foreach($distance_list as $k=>$v) {?>
						<?php if($distance == $v['key']) {?>
							<li>
								<dl>
									<dt>距离：</dt>
									<dd><?php echo $v[text]."以内";?></dd>
								</dl>
								<span class="distance"></span>
							</li>							
						<?php }?>
					<?php }?>
				<?php }?>
			
			</ul>
			<div class="menu_clear"><a href="javascript:void(0)">清除全部</a></div>
		</div>
		<?php }?>
		<ul class="menu_list">
			<!--
			<li>
				<dl>
					<dt>营业状态：</dt>
					<dd><a href="###">营业中</a></dd>
					<dd><a href="###">打烊了</a></dd>
					<dt class="menu_right">
					<div class="choice"><span></span>多选</div>
					<div class="more"><a href="###">更多<span></span></a></div>
					</dt>
				</dl>
			</li>
			-->

			<li class="menu-store">
				<dl>
					<dt>店铺类别：</dt>
					<div class="menu-store-div">
						<?php
							if (!empty($sale_category_list)) {
								foreach ($sale_category_list as $tmp) {
								$class = '';
									if ($tmp['cat_id'] == $id) {
										$class = 'class="navigation-current"';
									}
						?>
							<dd><a href="<?php echo url('search:store', array('id' => $tmp['cat_id'],'distance'=>$distance)) ?>" <?php echo $class ?>><?php echo $tmp['name'] ?></a></dd>
						<?php
								}
							}
						?>
					</div>
					<dt class="menu_right">
					<!--<div class="choice"><span></span>多选</div>-->
					<div class="more"><a href="javascript:">更多<span></span></a></div>
					</dt>
				</dl>
			</li>
			
			<?php 
				if($WebUserInfo['long']) {?>
			<li class="menu-store">
				<dl>
					<dt>距&#12288;&#12288;离：</dt>
					<div class="menu-store-div">
						<?php if(is_array($distance_list)) {?>
							<?php foreach($distance_list as $k=>$v){?>
								<dd><a href="<?php echo url('search:store', array('id' => $id,'distance'=>$v['key'])) ?>"  data="<?php echo $v['key'];?>"><?php echo $v["text"]?></a></dd>
							<?php }?>
						<?php }?>

						
					</div>
					<dt class="menu_right">
					<!--<div class="choice"><span></span>多选</div>-->
					<!--<div class="more"><a href="javascript:">更多<span></span></a></div>-->
					</dt>
				</dl>
			</li>
			<?php }?>			
			
		</ul>
	</div>
</div>
<div class="cata_table content_commodity">
<dl>
	<dd onclick="javascript:location.href='<?php echo url('search:store', $param) ?>'" class="cursor cata_table_li1 <?php echo !in_array($order,array('collect','distance')) ? 'cata_curnt' : '' ?> cata_table_li">默认</dd>
	<dd onclick="javascript:location.href='<?php echo url('search:store', $param_collect); ?>'" class="cursor cata_table_li <?php echo $order == 'collect' ? 'cata_curnt' : '' ?>"" ><a href="javascript:void(0)">人气</a></dd>
	<?php 
		if($WebUserInfo['long']) {?>
	<dd onclick="javascript:location.href='<?php echo url('search:store', $param_distance); ?>'"  class="cata_table_li distance <?php echo $order == 'distance' ? 'cata_curnt' : '' ?>""><span></span>距离</dd>
	<?php }?>
	<!--
	<dd>
		<form>
			<input placeholder="km">
			<span>-</span>
			<input placeholder="km">
			<button>确定</button>
		</form>
	</dd>-->
	<dt>
	<div class="cata_left"></div>
	<div class="cata_right"></div>
	</dt>
	<dt><span><?php echo $current_page['current_page']?></span>/<?php echo $current_page['total_page'];?></dt>
</dl>
<div class="content_list">
<ul class="content_list_ul">
	<!--
	<li> <a href="###">
			<div class="content_list_img"><img src="images/fenlei_03.png">
				<div class="shop_list">
					<form>
						<div class="shop_guanzhu">
							<button>关注店铺</button>
						</div>
						<div class="shop_shoucang">
							<button>收藏店铺</button>
						</div>
					</form>
				</div>
			</div>
			<div class="content_list_txt">
				<div class="content_list_pice">￥<span>78</span></div>
				<div class="content_list_dec"><span>已售出456双/</span>有234个分销商</div>
			</div>
			<div class="content_list_txt">
				<div class="content_list_day">预计2-3天内送达 </div>
				<div class="content_list_add"><span></span>9874km</div>
			</div>
			<div class="shop_info">
				<div class="content_shop_name">芋颜台湾甜品专家</div>
				<div class="content_shop_add">北京</div>
			</div>
		</a>
	</li>
	-->
	<?php
		if (!empty($store_list)) {
			foreach ($store_list as $store) {
	?>
	<li> <a href="<?php echo url_rewrite('store:index', array('id' => $store['store_id'])) ?>">
			<div class="content_list_img"><img class="lazys"  data-original="<?php echo TPL_URL;?>images/ico/grey.gif" src="<?php echo $store['logo']; ?>" onloads="AutoResizeImage(200,200,this)" width="200" height="200">
				<div class="shop_list">
					<form onsubmit="return false">
						<div class="shop_guanzhu">
							<button onclick="javascript:userAttention(<?php echo $store['store_id'];?>,2);">关注店铺</button>
						</div>

						<div class="shop_shoucang">
							<button onclick="javascript:userCollect(<?php echo $store['store_id'];?>,2);">收藏店铺</button>
						</div>
					</form>
				</div>
			</div>
			<div class="content_list_txt">
				<div class="content_list_pice"></div>
				<div class="content_list_dec"><span>已关注<?php echo $store['attention_num']?>/</span>已收藏<?php echo $store['collect']?></div>
			</div>
			<div class="content_list_txt js-express" data-lat="<?php echo $store_contact_info[$store['store_id']]['lat'] ?>" data-long="<?php echo $store_contact_info[$store['store_id']]['long'] ?>">
				<div class="content_list_day">计算中</div>
				<div class="content_list_add">计算中</div>
			</div>
			<div class="shop_info">
				<div class="content_shop_name"><a href="javascript:void(0)" title="<?php echo $store['name'];?>"><?php echo msubstr($store['name'],0,5); ?></a></div>
				<div class="content_shop_add">&nbsp;<?php if($cityname = $store_contact_info[$store['store_id']]['city_txt']){  echo "<a href='javascript:void(0)' title='".$cityname."'>".msubstr($cityname,0,3)."</a>";}?></div>
			</div>
		</a> </li>
	<?php
			}
		}
	?>
</ul>
</div>
</div>
<div class="page_list">
	<dl>
		<?php echo $pages ?>
	</dl>
</div>
</div>
<div class="shop_list_right">
<div  class="shop_list_right_top">
	<div class="shop_list_title">优质店铺</div>
	<ul>
		<?php if($excellent_list){?>
			<?php foreach($excellent_list as $k=>$v) {?>
				<li <?php if($k=='5'){ ?>style="border:0;"<?php }?> >
					<div class="shop_list_tab_top">
						<div class="shop_list_tab_top_img">
							<a href="<?php echo url_rewrite('store:index', array('id' => $v['store_id'])) ?>">
								<img src="<?php echo $v['logo'];?>" />
								<div class="shop_list_paimin">
									<p>Top</p>
									<p><?php echo $k+1;?></p>
								</div>
							</a>
						</div>
						<div class="shop_list_tab_top_list">
							<div class="shop_list_name"><a href="<?php echo url_rewrite('store:index', array('id' => $v['store_id'])) ?>"><?php echo $v['name'];?></a></div>
							<div class="shop_list_dec"><?php if($v['cate_name']){?>(主营<?php echo $v['cate_name']?>)<?php }?>&nbsp;</div>
							<div class="phone_number"><span></span><?php if($v['tel']) {echo $v['tel'];}else{echo "暂无联系方式";}?></div>
							<?php if($v['address']) {?>
								<div class="shop_list_add" title="<?php echo $v['address']?>">地址：<?php echo msubstr($v['address'],0,9,'utf-8');?></div>
							<?php }else{?>
								<div class="shop_list_add" >地址：暂未公开</div>
							<?php }?>
						</div>
					</div>
				</li>
			<?php }?>
		<?php }?>

	</ul>
</div>
<div class="shop_list_bottom">
<div class="shop_list_bottom_title">
	<div  class="shop_list_bottom_title_icon"></div>
	优质供应商</div>
<div class="shop_border"></div>
<div class="content__cell content__cell--slider">
<div class="component-index-slider">
<div class="index-slider ui-slider log-mod-viewed">
<div class="pre-next"> <a style="opacity: 0.6; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-previous sp-slide--previous"></a> <a style="opacity: 0.6; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-next sp-slide--next"></a> </div>
<div class="head ccf">
	<ul class="trigger-container ui-slider__triggers mt-slider-trigger-container" style="display:none;">
		<?php 
		$i = ceil(count($supplier_list) / 6);
		for ($j = 0; $j < $i; $j++) {
			$class = '';
			if ($j == 0) {
				$class = 'mt-slider-current-trigger';
			}
		?>
			<li class="mt-slider-trigger <?php echo $class ?>"></li>
		<?php 
		}
		?>
		<div style="clear:both"></div>
	</ul>
</div>
<ul class="content">
	<?php 
	if (is_array($supplier_list)) {
		$is_end = true;
		$is_start = false;
		foreach ($supplier_list as $key => $v) {
			$block = 'none';
			if ($key == 0) {
				$block = 'block';
			}
			if ($key % 6 == 0) {
				$is_start = true;
				$is_end = false;
			}
			if ($is_start) {
				$is_start = false;
	?>
				<li class="cf" style="opacity: 1; display: <?php echo $block ?>;">
					<dl>
	<?php 
			}
	?>
					<dd>
						<div class="dd_left_yuan"></div>
						<div class="dd_left_jian"></div>
						<div class="shop_list_tab_bottom">
							<div class="shop_list_tab_top_list">
								<div class="shop_list_name"><a href="<?php echo url_rewrite('store:index', array('id' => $v['store_id'])) ?>"><?php echo $v['name'];?></a></div>
								<div class="shop_list_dec"><?php if($v['cate_name']){?>(主营<?php echo $v['cate_name']?>)<?php }?>&nbsp;</div>
								<div class="shop_fenxiao"><a href="javascript:" class="wyfx" data-json="{'name':'<?php echo $v[name]?>','type':'store','zylm':'<?php echo $v[cate_name];?>','intro':'<?php echo $v[intro];?>','wx_image':'<?php echo $v[wx_image]?>','pszlr':'<?php echo $v[drp_profit];?>','fxsl':'<?php echo $v[drp_seller_qty]?>','fxlr':'<?php echo $v[drp_profit]; ?>'}"  >我要分销</a></div>
							</div>
							<div class="shop_list_tab_top_img">
								<a href="<?php echo url_rewrite('store:index', array('id' => $v['store_id'])) ?>">
									<img src="<?php echo $v['logo'];?>" />
								</a>
							 </div>
						</div>
					</dd>
			<?php 
			if ($key % 6 == 5) {
			?>
					</dl>
				</li>
			<?php 
				$is_end = true;
			}
			?>
	<?php 
		}
		if (!$is_end) {
	?>
				</dl>
			</li>
	<?php
		}
	}
	?>



</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include display('public:footer');?>
</body>
</html>