<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<meta name="apple-mobile-web-app-title" content="小猪cms">
<title>首页</title>
<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
<meta name="description" content="<?php echo $config['seo_description'];?>" />
<link href="favicon.ico"  rel="icon" />
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/style.css?time=<?php echo time();?>" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/swiper.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/index.css"  type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/gonggong.css"  type="text/css">
<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script src="<?php echo TPL_URL;?>theme/js/swiper.min.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/mobile-common.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/app-m-main-common.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/mobile-download-banner.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/m-performance.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/-mod-wepp-module-event-0.2.1-wepp-module-event.js,-mod-wepp-module-overlay-0.3.0-wepp-module-overlay.js,-mod-wepp-module-toast-0.3.0-wepp-module-toast.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/mobile-common-search.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/-mod-hippo-1.2.8-hippo.js,-mod-cookie-0.2.0-cookie.js,-mod-cookie-0.1.2-cookie.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/app-m-dianping-index.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/nugget-mobile.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/swipe.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/openapp.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/app-m-style.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/util-m-monitor.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/xss.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/whereami.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/index.js?time=<?php echo time();?>"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>theme/js/example.js"></script>
<script src="http://api.map.baidu.com/api?v=1.2" type="text/javascript"></script>
<script>
</script>
</head>

<body>
<header class="index-head" style="position:absolute;">
	<a class="logo" href="./index.php"><img src="<?php echo TPL_URL;?>images/danye_03.png" /></a>
	<div class="search J_search">
		<span class="js_product_search"></span><input placeholder="输入商品名" class="search_input s-combobox-input" />
	</div>
	<a href="./my.php" class="me"></a>
	<div id="J_toast" class="toast ">你可以在这输入商品名称</div>
</header>
<script >
$(function(){
	$(".toast").fadeTo(5000,0, function () {
		$(this).hide();
	});
	$(".s-combobox-input").val("");
	$('.s-combobox-input').keyup(function(e){
		var val = $.trim($(this).val());
		if(e.keyCode == 13){
			if(val.length > 0){
				window.location.href = './category.php?keyword='+encodeURIComponent(val);
			}else{
				return;
				motify.log('请输入搜索关键词');
			}
		}
		$('.j_PopSearchClear').show();
	});

	$(".js_product_search").click(function () {
		var val = $.trim($(".s-combobox-input").val());
		if (val.length == 0) {
			return;
		} else {
			window.location.href = './category.php?keyword='+encodeURIComponent(val);
		}
	});
})
</script>
<?php 
if ($slide) {
?>
	<div class="banner">
		<div class="swiper-container s1 swiper-container-horizontal">
			<div class="swiper-wrapper">
				<?php 
				foreach ($slide as $key => $value) {
					$class = '';
					if ($key == 0) {
						$class = 'swiper-slide-active';
					} else{
						$class = 'swiper-slide-next';
					}
					
				?>
					<div class="swiper-slide blue-slide pulse <?php echo $class ?>">
						<a href="<?php echo $value['url'] ?>">
							<img src="<?php echo $value['pic'];?>" alt="<?php echo $value['name'];?>" />
						</a>
					</div>
				<?php 
				}
				?>
			</div>
			<div class="swiper-pagination p1 swiper-pagination-clickable">
				<?php 
				foreach ($slide as $key => $value) {
					$class = '';
					if ($key == 0) {
						$class = 'swiper-pagination-bullet-active';
					}
				?>
					<span class="swiper-pagination-bullet <?php echo $class ?>"></span>
				<?php 
				}
				?>
			</div>
		</div>
	</div>
	<script>
	var mySwiper = new Swiper('.s1',{
	loop: false,
	autoplay: 3000,
		 pagination: '.p1',
		paginationClickable: true
	});
	</script> 
<?php 
}
if ($slider_nav) {
?>
	<div class="index-category Fix">
		<div class="swiper-container s2 swiper-container-horizontal">
			<div class="swiper-wrapper">
				<?php
				$is_div_end = true;
				$i = 0;
				foreach($slider_nav as $key => $value){
					$class = 'swiper-slide-next';
					if ($key == 0) {
						$class = 'swiper-slide-active';
					}
					
					if ($key % 8 == 0) {
						$i == 0;
						$is_div_end = false;
						echo '<div class="swiper-slide blue-slide   pulse ' . $class . '" style="width: 414px;">';
						echo '	<div class="Fix page icon_list" data-index="0" style="  left: 0px; transition-duration: 300ms; -webkit-transition-duration: 300ms; -webkit-transform: translate(0px, 0px) translateZ(0px);">';
					}
					$i++;
				?>
							<a href="<?php echo $value['url'];?>" class="item" >
								<div class="icon fadeInLeft yanchi<?php echo $i ?>" style="background:url(<?php echo $value['pic'] ?>); background-size:44px 44px; background-repeat:no-repeat;"> </div>
								<?php echo $value['name'] ?>
							</a>
				<?php 
					if ($key % 8 == 7) {
						echo '	</div>';
						echo '</div>';
						$is_div_end = true;
					}
				}
				if (!$is_div_end) {
					echo '	</div>';
					echo '</div>';
				}
				?>
			</div>
			<div class="swiper-pagination p2 swiper-pagination-clickable">
				<?php 
				for ($i = 0; $i < ceil(count($slider_nav) / 8); $i++) {
					$class = '';
					if ($i == 0) {
						$class = 'swiper-pagination-bullet-active';
					}
				?>
				<span class="swiper-pagination-bullet <?php echo $class ?>"></span>
				<?php 
				}
				?>
			</div>
		</div>
		<script>
		var mySwiper = new Swiper('.s1',{
		loop: false,
		autoplay: 3000,
			 pagination: '.p1',
			paginationClickable: true
		});
		var mySwiper = new Swiper('.s2',{
		loop: false,
		autoplay:6500,
				pagination: '.p2',
				paginationClickable: true
	  }); 
		</script> 
	</div>
<?php 
}
if ($hot_brand_slide) {
?>
	<div class="index-event">
		<div class="bord"></div>
		<div class="cnt">
			<?php 
			foreach($hot_brand_slide as $key=>$value) {
			?>
				<a class="item" href="<?php echo $value['url'] ?>">
					<img src="<?php echo $value['pic'] ?>" alt="<?php echo $value['name'] ?>" />
				</a>
			<?php 
			}
			?>
		</div>
	</div>
<?php 
}
?>
<div class="bord"></div>
<div class="index-rec J_reclist">
	<?php 
	if ($cat) {
	?>
		<div class="home-tuan-list" id="home-tuan-list">
			<div class="market-floor" id="J_MarketFloor">
				<h3 class="modules-title"> 热门分类 </h3>
				<div class="modules-content market-list">
					<?php
					$is_ul_end = true;
					foreach($cat as $key => $value) {
						if ($key % 2 == 0) {
							$is_ul_end = false;
							echo '<ul class="mui-flex">';
						}
					?>
							<li class="region-block cell">
								<a href="./category.php?keyword=<?php echo $value['cat_name'] ?>&id=<?php echo $value['cat_id'] ?>">
									<em class="main-title"><?php echo $value['cat_name'] ?></em>
									<span class="sub-title"> </span>
									<img class="market-pic" src="<?php echo $value['cat_pic'] ?>" width="50" height="50">
								</a>
							</li>
					<?php 
						if ($key % 2 == 1) {
							echo '</ul>';
							$is_ul_end = true;
						}
					}
					if (!$is_ul_end) {
						echo '</ul>';
					}
					?>
				</div>
			</div>
		</div>
	<?php 
	}
	?>
	<div class="bord"></div>
	<div class=" title_list">
	<!--
		<ul class="title_tab">
			<li class="nar_shop product_on">附近店铺</li>
			<li class="nar_activity">附近活动</li>			
			<li class="nar_product">附近商品</li>
		</ul>
		-->
        <ul class="title_tab" id="example-one" >
 
            <li class="nar_shop product_on current_page_item" style="width:<?php echo $is_have_activity == '1' ? '33%' : '50%' ?>"><a href="javascript:;">附近店铺</a></li>
            <li class="nar_activity" style="display:<?php echo $is_have_activity == '1' ? 'block' : 'none;' ?>"><a href="javascript:;"> 附近活动</a> </li>
            <li class="nar_product" style="width:<?php echo $is_have_activity == '1' ? '33%' : '50%' ?>"><a href="javascript:;">附近商品</a></li>
        </ul>		
		
	</div>
	<ul class="product_list js-near-content" style="overflow:hidden">
		<li class="pro_shop" style="display:block;">
			<div class="home-tuan-list js-store-list" data-type="default">
				<?php 
				if ($brand) {
					foreach ($brand as $key => $value) {
					if ($key >= 4) {
						break;
					}
				?>
						<a href="<?php echo $value['url'] ?>&platform=1" class="item Fix">
							<div class="cnt"> <img class="pic" src="<?php echo $value['logo'] ?>">
								<div class="wrap">
									<div class="wrap2">
										<div class="content">
											<div class="shopname"><?php echo $value['name'] ?></div>
											<div class="title"><?php echo msubstr($value['intro'], 0 , 20,'utf-8') ?></div>
											<div class="info"><span><i></i>请设置位置</span></div>
										</div>
									</div>
								</div>
							</div>
						</a>
				<?php 
					}
				}
				?>
			</div>
		</li>
		 <li class="pro_activity">
			<div class="home-tuan-list js-active-list"  data-type="default">
			
				<?php 
			
				if($active_list) {
					foreach($active_list as $value) {
				
				?>
				<a href="<?php echo $value['url']?>" class="item Fix">
				<div class="cnt"> <img class="pic" src="<?php echo $value['image'];?>">
					<div class="wrap">
						<div class="wrap2">
							<div class="content">
								<div class="shopname"><?php echo msubstr($value['title'], 0 , 12,'utf-8');?></div>
								<div class="title"><?php echo msubstr($value['info'], 0 , 20,'utf-8');?></div>
								<div class="info"> 参与人数:<?php echo msubstr($value['ucount'], 0 , 20,'utf-8');?>人&#12288;<span><i></i>请设置位置</span></div>
							</div>
						</div>
					</div>
				</div>
				</a> 
				<?php 
					}
				}
				?>

				
				</div>
		</li>
		<li class="pro_product">
			<div class="home-tuan-list js-goods-list" data-type="default">
				<?php 
				if ($product_list) {
					foreach ($product_list as $value) {
				?>
					<a href="./good.php?id=<?php echo $value['product_id'] ?>&platform=1" class="item Fix">
						<div class="cnt"> <img class="pic" src="<?php echo $value['image'] ?>">
							<div class="wrap">
								<div class="wrap2">
									<div class="content">
										<div class="shopname"><?php echo $value['name'] ?></div>
										<div class="title"><?php echo msubstr($value['intro'], 0 , 20,'utf-8');?></div>
										<div class="info">
											<span class="symbol">¥</span>
											<span class="price"><?php echo $value['price'] ?></span>
											<del class="o-price">¥<?php $value['original_price'] = ($value['price'] >= $value['original_price'] ? $value['price'] : $value['original_price']); echo $value['original_price']; ?></del>
											<span class="sale">立减<?php echo $value['original_price'] - $value['price'] ?>元</span> <span class="distance"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</a>
				<?php
					} 
				}
				?>
				
			</div>
		</li>
	</ul>
</div>
<script>
	$(function() {
	$(".nar_shop").click(function() {
		aaa('pro_activity', 'pro_product', 'pro_shop');
		$(this).addClass("product_on").siblings().removeClass("product_on")
	});
	$(".nar_activity").click(function() {
		aaa('pro_product', 'pro_shop', 'pro_activity');
		$(this).addClass("product_on").siblings().removeClass("product_on")
	});
	 $(".nar_product").click(function() {
		aaa('pro_activity', 'pro_shop', 'pro_product');
		$(this).addClass("product_on").siblings().removeClass("product_on")
	});


	function aaa(sClass1, sClass2, sClass3) {
		$('.' + sClass1).hide();
		$('.' + sClass2).hide();
		$('.' + sClass3).show();
	}
});
</script> 
<br /><br /><br />
<?php include display('public_search');?>
<?php include display('public_menu');?>
<?php echo $shareData;?>
</body>
</html>