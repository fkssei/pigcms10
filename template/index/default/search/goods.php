<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge">

	<title>产品搜索-<?php echo $config['seo_title'] ?></title>
	<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
	<meta name="description" content="<?php echo $config['seo_description'] ?>" />
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet">
	<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/index1.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css">
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.lazyload.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
	<script src="<?php echo TPL_URL;?>js/distance.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script src="<?php echo $config['site_url'];?>/static/js/area/area.min.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo TPL_URL;?>js/index2.js"></script>
<script>
$(function () {
	// 统一计算距离与物流时间
	$(".js-express").each(function () {
		var lat = $(this).data("lat");
		var long = $(this).data("long");
		
		var express_distance = expressDistance(lat, long);
		
		$(this).find(".content_list_day").html(express_distance.express);
		$(this).find(".content_list_add").html("<span></span>" + express_distance.distance + "km");
	});
})
</script>
<style>
.category .cata_table dl dd.cata_curnt{color:#fff}
</style>

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
.category .category_menu .menu-store-more .menu-store-div {
	height: auto;
}
.content .content_commodity ul.content_list_ul li .content_list_img{height:224px;}


</style>
	<script>
		function searchGoods() {
			var start_price = $("#start_price").val();
			var end_price 	= $("#end_price").val();

			if(start_price == '' || end_price == ''){
				tusi('价格区间必须填写');
			}else{

				if(start_price < end_price){
					var start 		= start_price;
					var end_price 	= end_price;
				}else{
					var start 		= end_price;
					var end_price 	= start_price;
				}

				var url = '<?php echo url('search:goods', array('keyword' => $_GET['keyword'])) ?>';

				if (start_price.length > 0) {
					url += '&start_price=' + start;
				}

				if (end_price.length > 0) {
					url += '&end_price=' + end_price;
				}

				location.href = url;

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

			var url = "<?php echo url('search:goods', $param_search) ?>";

			location.href = url + "&page=" + page;
		}

		$(function () {
			$("#pages a").click(function () {
				var page = $(this).attr("data-page-num");
				changePage(page);
			});

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
		});

		function jumpPage() {
			var page = $("#jump_page").val();
			changePage(page);
		}

		$(function () {
			$(".js_product_collect").click(function () {
			//	alert('aaa');
			});
		});


$(function(){

	var url = "<?php echo url('search:goods', $param_search) ?>";

	$(".menu_list .more").click(function(){
		if($(this).closest(".menu_list").data("tip")) {
			$(this).removeClass("less");
			$(this).closest(".menu-type").removeClass("menu-store-more");
			$(this).find("a").html("更多<span></span>");
			$(this).closest(".menu_list").data("tip",0);
		} else {
			$(this).closest(".menu_list").data("tip",1);
			$(this).removeClass("less").addClass("less");
			$(this).closest(".menu-type").addClass("menu-store-more");
			$(this).find("a").html("收起<span></span>");
		}
	})


	//点击关闭类目属性
	$(".menu_content .condition li span, .menu_content .condition .menu_clear a").click(function(){
		var dataid =  $(this).attr("data-id");

		location.href="<?php echo url('search:goods',array('keyword'=>$param_category['keyword'])) ?>";
	})
})



	</script>
</head>

<body>
<?php include display( 'public:header');?>


<div class="content category">

<div class="menu_title">
        <dl>
            <dt><?php echo $categoryTree['tree']['cat_name']?></dt>
	        <?php  if($categoryTree['tree']['son']){?>
		        <dd><span></span></dd>
		        <dd style="border:0px;"><a  style="border:0px;width:auto;" href="<?php echo  $categoryTree['tree']['son']['link'];?>"><?php echo $categoryTree['tree']['son']['cat_name']?></a>
			</span>
		        </dd>
	        <?php }?>
	        <!--
            <dd><span></span></dd>
            <dd><a href="###">纸尿裤<span></span></a></dd>
            -->

        </dl>
    </div>
<script>
	$(".menu_clear,.xuanze_type").click(function(){


	})

</script>

    <div class="category_menu">
        <div class="menu_content">
            <div class="menu_content_title">
                <dl>
                   <!-- <dt>纸尿裤</dt>-->
                    <dd><a href="javascript:void(0)">商品筛选 </a></dd>
                    <dd><a href="javascript:void(0)"><span>共<?php echo $product_count;?>个商品</span></a></dd>
                </dl>
            </div>
	        <?php if( $categoryTree['current']['cat_name']){ ?>
            <div class="condition">
                <div class="condition_title"> 已选条件: </div>
                <ul>
                    <li>
                        <dl class="xuanze_type">
                            <dt>类别：</dt>
                            <dd><?php echo $categoryTree['current']['cat_name']?></dd>

                        </dl>
                        <span></span></li>
                </ul>
                <div class="menu_clear"><a href="javascript:void(0)">清除全部</a></div>
            </div>
	        <?php }?>
            <ul class="menu_list">
	            <li class="menu-type">
                    <dl>
                        <dt>分类：</dt>
	                    <div class="menu-store-div">
							<?php
								foreach ($s_category as $category) {
									$selected = '';
									if ($category['cat_id'] == $cid) {
										$selected = 'navigation-current';
									}
									$param_category['id'] = $category['cat_id'];
							?>
								<dd><a class="<?php echo $selected ?>" href="<?php echo url('search:goods', $param_category) ?>"><?php echo $category['cat_name'] ?></a></dd>
							<?php
								}
							?>
	                    </div>
                        <dt class="menu_right">
                            <!--<div class="choice"><span></span>多选</div>-->
                            <div class="more"><a href="javascript:void(0)">更多<span></span></a></div>
                        </dt>
                    </dl>
                </li>


            </ul>
        </div>
    </div>

    <div class="cata_table content_commodity">

	<!--排序搜索开始-->

		<dl>
			<form action="<?php  dourl('search:goods',array('sort'=>$sort))?>">
				<dd onclick="javascript:location.href='<?php echo url('search:goods', $params) ?>'" class="cursor cata_table_li <?php echo !isset($param_search['order']) || $param_search['order'] == 'sort' ? 'cata_curnt' : '' ?>" data-sort="default"><a href="javascript:void(0)"> 默认</a></dd>
				<dd onclick="javascript:location.href='<?php echo url('search:goods', $param_sales) ?>'" class="cursor cata_table_li <?php echo isset($param_search['order']) && $param_search['order'] == 'sales' ? 'cata_curnt' : '' ?>" data-sort="hot"><a href="javascript:void(0)">热销</a></dd>
				<dd onclick="javascript:location.href='<?php echo url('search:goods', $param_price) ?>'" class="cursor cata_table_li <?php echo isset($param_search['order']) && $param_search['order'] == 'price' ? 'cata_curnt' : '' ?>" data-sort="price-asc"><a href="javascript:void(0)">价格</a></dd>
				
				<!-- <dd class="cata_table_li">人气</dd> -->
				<?php 
					if($WebUserInfo['long']) {?>
						<dd onclick="javascript:location.href='<?php echo url('search:goods', $param_distance); ?>'"  class="cata_table_li distance <?php echo $param_search['order'] == 'juli' ? 'cata_curnt' : '' ?>""><span></span>距离</dd>
				<?php }?>
				
			</form>
			<dd>
				<form onsubmit="return false;">
					<input id="start_price"  placeholder="￥">
					<span>-</span>
					<input id="end_price"   placeholder="￥">
					<button onclick="searchGoods()">确定</button>
				</form>
			</dd>
            <dt>
                <div class="cata_left"></div>
                <div class="cata_right"></div>
            </dt>
            <dt><span><?php echo $page_arr['current_page'] ?></span>/<?php echo $page_arr['total_pages'] ?></dt>
        </dl>


        <div class="content_list">
            <ul class="content_list_ul">
				<?php
					foreach ($product_list as $product) {
				?>

						<li> <a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>">
								<div class="content_list_img"><img alt="<?php echo htmlspecialchars($product['name'])?>"  src="<?php echo $product['image'] ?>">
									<div class="shop_list">
										<form onsubmit="return false">
											<div class="shop_guanzhu">
												<button data-id="<?php echo $product['product_id'] ?>" onclick="javascript:userAttention(<?php echo $product['product_id'] ?>, 1)">关注商品</button>
											</div>
											<div class="shop_shoucang ">
												<button data-id="<?php echo $product['product_id'] ?>" onclick="javascript:userCollect(<?php echo $product['product_id'] ?>, 1)">收藏商品</button>
											</div>
										</form>
									</div>
								</div>
								<div class="content_list_txt">
									<div class="content_list_pice">￥<span><?php echo $product['price'] ?></span></div>
									<div class="content_list_dec"><span>已售<?php echo $product['sales']; ?>/</span>分销<?php echo $product['drp_seller_qty']; ?>次</div>
								</div>
								<div class="content_list_txt js-express" data-lat="<?php echo $store_contact_info[$product['store_id']]['lat'] ?>" data-long="<?php echo $store_contact_info[$product['store_id']]['long'] ?>">
									<div class="content_list_day">计算中</div>
									<div class="content_list_add">计算中</div>
								</div>
								<div class="shop_info">
									<div class="content_shop_name"><?php
										if (isset($store_list[$product['store_id']])) {
											?>
											<a  href="<?php echo url_rewrite('store:index', array('id' => $product['store_id'])) ?>"><?php echo $store_list[$product['store_id']] ?></a>
										<?php
										}
										?>
									</div>


									<div class="content_shop_add">&nbsp;
										<?php if($cityname = $store_contact_info[$product['store_id']]['city_txt']){ ?>
												<a href="javascript:void(0)" title="<?php echo $cityname;?>"><?php echo msubstr($cityname,0,4);?></a>
										
											<?php }?>
									</div>


								</div>
							</a> </li>



				<?php
					}
				?>


            </ul>
        </div>
    </div>

    <!--分页-->
    <div class="page_list" id="pages">
	    <dl>
		    <?php echo $pages ?>
		    <dt>
			    <form onsubmit="return false;">
				    <span>跳转到:</span>
				    <input type="text" value="" id="jump_page" name="currentPage" class="J_topage page-skip">
				    <button onclick="jumpPage()">GO</button>
			    </form>
		    </dt>
	    </dl>
    </div>
    <!--分页-->

</div>
<?php include display('public:footer');?>
</body>
</html>