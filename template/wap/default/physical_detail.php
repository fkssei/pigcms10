<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<?php if($is_weixin){ ?>
			<title>门店地图</title>
		<?php }else{ ?>
			<title>门店地图 - <?php echo $now_store['name'];?></title>
		<?php } ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/offline_shop.css"/>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.waterfall.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/physical_detail.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="map-container">
				<div class="map" id="js-map"></div>
				<!--div class="btn-view-all" id="js-view-all">查看全部</div-->
			</div>
			<div class="block block-order" id="shop-detail-container">
				<div class="name-card name-card-3col name-card-store clearfix">
					<a href="javascript:;" class="thumb js-view-image-list">						
						<?php foreach($store_physical['images_arr'] as $image_key=>$image_arr){ ?>
							<img class="js-view-image-item <?php if($image_key != 0){ echo 'hide';}?>" src="<?php echo $image_arr?>"/>
						<?php } ?>
					</a>
					<a href="tel:<?php if($store_physical['phone1']){ echo $store_physical['phone1'];}?><?php echo $store_physical['phone2'];?>"><div class="phone"></div></a>
					<div class="detail">
						<h3><?php echo $store_physical['province_txt'];?><?php echo $store_physical['city_txt'];?><?php echo $store_physical['county_txt'];?> <?php echo $store_physical['address'];?></h3>

						<p class="c-gray-dark ellipsis" style="margin-top: 1px">	
							<?php if($store_physical['business_hours']){ ?>营业时间：<?php echo $store_physical['business_hours'];?><br/><?php } ?>				
							联系电话：<?php if($store_physical['phone1']){ echo $store_physical['phone1'].'-';}?><?php echo $store_physical['phone2'];?>
						</p>

					</div>
				</div>
			</div>
			<?php include display('footer');?>
		</div>
		<script type="text/javascript" src="http://api.map.baidu.com/api?type=quick&ak=4c1bb2055e24296bbaef36574877b4e2&v=1.0"></script>
		<script type="text/javascript">
			$('#js-map').height($(window).height()-$('#shop-detail-container').height());
			
			// 百度地图API功能
			var map = new BMap.Map("js-map");            // 创建Map实例
			map.centerAndZoom(new BMap.Point(<?php echo $store_physical['long'];?>,<?php echo $store_physical['lat'];?>),19);                 // 初始化地图,设置中心点坐标和地图级别。
			map.addControl(new BMap.ZoomControl());      //添加地图缩放控件	

			var marker = new BMap.Marker(new BMap.Point(<?php echo $store_physical['long'];?>,<?php echo $store_physical['lat'];?>));  //创建标注
			map.addOverlay(marker);                 // 将标注添加到地图中
			
			var infoWindow = new BMap.InfoWindow('<div class="infoWindow-content"><div class="address"><?php echo $store_physical['province_txt'];?><?php echo $store_physical['city_txt'];?><?php echo $store_physical['county_txt'];?> <?php echo $store_physical['address'];?></div><div class="navi"><a class="tag">到这里去</a><div class="js-navi-to navi-to"></div></div></div>',{title:'<?php echo $store_physical['name'];?>',width:220,height:80,offset:{width:0,height:15}});
			infoWindow.addEventListener("open",function(e){
				$('.js-navi-to').click(function(){
					window.location.href = 'http://map.baidu.com/mobile/webapp/search/search/qt=s&wd=<?php echo urlencode($store_physical['province_txt'].$store_physical['city_txt'].$store_physical['county_txt'].$store_physical['address']);?>/?third_party=uri_api';
				});
			});
			marker.openInfoWindow(infoWindow);
			marker.addEventListener("click",function(e){
				marker.openInfoWindow(infoWindow);
			});	
			
			<?php if($is_weixin){ ?>
				$('.js-view-image-list').click(function(){
					var t = [];
					$.each($(this).find('.js-view-image-item'),function(i,item){
						t[i] = $(item).attr('src');
					});
					var i = t[0];
					window.WeixinJSBridge && window.WeixinJSBridge.invoke("imagePreview",{current:i,urls:t});
				});
			<?php } ?>
		</script>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>