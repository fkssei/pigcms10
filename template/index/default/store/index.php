<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>欢迎光临<?php echo htmlspecialchars($store['name']) ?>-<?php echo $config['seo_title'] ?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link rel="icon"  href="favicon.ico" type="image/x-icon" />
<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/fancybox.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css" />
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.form.min.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.fancybox-1.3.1.pack.js"></script>
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script src="<?php echo TPL_URL;?>js/index2.js"></script>


<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo TPL_URL;?>js/store.js"></script>
<script src="<?php echo TPL_URL;?>js/distance.js"></script>
<script>
var store_id = "<?php echo $store['store_id'] ?>";
var goods_url = "<?php echo url('store:goods') ?>";
var comment_url = "<?php echo url('comment:index') ?>";
var financial_url = "<?php echo url('store:financial') ?>";
var comment_add = "<?php echo url('comment:add') ?>";
var financial_url = "<?php echo url('store:financial') ?>";
var is_login = <?php echo $_SESSION['user'] ? 'true' : 'false' ?>;
</script>
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
.infoWindow-content .address{overflow:hidden;max-height:32px;font-size:12px;line-height:1.5;}
.infoWindow-content .navi{position:absolute;right:0;bottom:0;}
.infoWindow-content .navi .navi-to{position:absolute;top:-10px;left:-10px;width:80px;height:50px;}
#shop-detail-container{margin-top:0;margin-bottom:-1px;}
.map-apps-container a{margin-bottom:10px;}
.map-apps-container a:last-child{margin-bottom:0;}
#js-transportation .trans-mode{height:60px;line-height:60px;}
.content .content_shear .content_list_shear ul li .content_show {
    background: rgba(255, 255, 255, 0.5) none repeat scroll 0 0;word-wrap: break-word;}
    .category .category_menu ul.menu_list li dl .menu_right {
    color: #191919;
    float: right;
    font-size: 12px;
    line-height: 20px;
    margin-top: 15px;
    width: 70px;
}
</style>
</head>

<body>
<?php 
if ($is_preview) {
	include display( 'public:preview_header');
}
?>
<?php include display( 'public:header');?>
<div class="shop_header">
	<div class="shop_header_left">
		<div class="shop_header_left_img"> <img src="<?php echo $store['logo'] ?>" /> </div>
		<div class="shop_header_left_list">
			<ul>
				<li>
					<div class="shop_name"><?php echo htmlspecialchars($store['name']) ?></div>
					<div class="shop_comment"><div class="shop_comment_bg" style="width:<?php echo $comment_type_count['satisfaction_pre'] ?>;"> </div></div>
					<?php
					if ($store['approve']) {
					?>
						<div class="shop_rengzheng">认证商家</div>
					<?php
					}
					?>
				</li>
				<li>
					<div class="shop_list_txt">地址:</div>
					<div class="shop_list_txt"><?php echo $store_contact['province_txt'] . $store_contact['city_txt'] . $store_contact['area_txt'] . $store_contact['address'] ?></div>
					<div class="shop_list_txt"><a href="javascript:viewMap()"><span>地图中查看</span></a></div>
				</li>
				<li>
					<div class="shop_list_txt">电话:</div>
					<div class="shop_list_txt"><?php echo $store_contact['phone1'] ? $store_contact['phone1'] . '-' : '' ?><?php echo $store_contact['phone2'] ?></div>
				</li>
				<li>
					<div class="shop_yingye">入驻时间</div>
					<div class="shop_list_txt"><?php echo date('Y-m-d', $store['date_added']) ?></div>
					<div class="shop_list_txt"></div>
				</li>
				<li>
					<dl class="js-store-operation">
						<!--<dd><a href="###">分享店铺</a></dd>-->
						<dd><a href="javascript:userCollect('<?php echo $store['store_id'] ?>', '2')">收藏店铺</a></dd>
						<dd><a href="javascript:userAttention('<?php echo $store['store_id'] ?>', '2')">关注店铺</a></dd>
					</dl>
				</li>
			</ul>
		</div>
	</div>
	<div class="shop_header_content">
		<ul>
			<li class="peisong">
				<p>收藏数</p>
				<p><em class="store_collect_<?php echo $store['store_id'] ?>"><?php echo $store['collect'] ?></em></p>
			</li>
			<li class="qijia">
				<p>关注数</p>
				<p><em class="store_attention_<?php echo $store['store_id'] ?>"><?php echo $store['attention_num'] ?></em></p>
			</li>
			<li class="songda">
				<p>商品数</p>
				<p><em><?php echo $product_count ?></em></p>
			</li>
		</ul>
	</div>
	<div class="shop_header_right"><img src="/source/qrcode.php?type=home&id=<?php echo $store['store_id'] ?>" style="width:120px; height:119px;" />
		<p>微信访问</p>
	</div>
</div>
<?php
if (!empty($reward_list)) {
?>
	<div class="shop_activity_list">
		<ul>
			<?php
			foreach ($reward_list as $reward) {
			?>
			<li><span class="zeng">满</span>
				<div class="shop_activity_list_txt"><?php echo $reward['name'] ?></div>
			</li>
			<?php
			}
			?>
		</ul>
	</div>
<?php
}
?>
 
<div class="shop_content content category ">
	<div class="tab1 " id="tab1">
		<div class="menu js-menu">
			<ul>
				<li class="off" data-type="product"><div class="menu_border">商品货架 </div></li>
				<li data-type="map"><div class="menu_border">查看地图 </div></li>
				<li data-type="comment"><div class="menu_border">网友点评 </div></li>
				<li data-type="fx"><div class="menu_border">分销动态</div></li>
				<li data-type="coupon cursor" onclick="javascript:location.href='<?php echo url('store:couponlist',array('storeid'=>$store['store_id'])) ?>'">优惠券</li>
			</ul>
		</div>
		<div class="content_commodity menudiv  shop_list shopping js-content">
			<div class="js-content-detail" style="display:; ">
				<div class="fenxiao js-default"  style="border:0px; width:100%">加载中</div>
			</div>
			<div id="con_one_3" class="js-content-detail" style="display:none;">
				<div class="shop_map" style="border:0px;">
					<div class="shop_map_title"><?php echo $store['name'] ?></div>
					<div class="shop_map_img" id="js-map"></div>
					<div class="shop_map_dec">注:地图位置坐标仅供参考,具体以实际道路标志为准</div>
				</div>
			</div>
			<div id="con_one_4" style="display:none;" class="shopping_comment js-content-detail">
				<div class="shopping_conmment_content">
					<div class="shopping_conmment_top">
						<div class="shopping_conmment_top_left">
							<p><span><?php echo $comment_type_count['satisfaction_pre'] ?></span></p>
							<p>满意度</p>
						</div>
						<div class="shopping_conmment_top_content">
							<dl>
								满意度计算方式：满意数/总评数
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
											<input type="checkbox" class="ui-checkbox" id="has_image">
											<span>有照片</span>
										</form>
									</div>
								</div>
							</div>
							<div class="content_tab">
								<ul>
									<li style="display: ;"><div style="height:24px; line-height:24px; padding-top:20px;" class="js_default">加载中</div></li>
									<li style="display: none;"><div style="height:24px; line-height:24px; padding-top:20px;" class="js_default">加载中</div></li>
									<li style="display: none"><div style="height:24px; line-height:24px; padding-top:20px;" class="js_default">加载中</div></li>
									<li style="display: none;"><div style="height:24px; line-height:24px; padding-top:20px;" class="js_default">加载中</div></li>
								</ul>
							</div>
							<div class="shop_pingjia"> <a name="fabiao"></a>
								<div class="shop_pinjiga_title">发表评价</div>
								<div class="shop_pinjgia_form">
									<div class="shop_pingjia_form_list  appraise_li-list_top ">
										<div class="shop_pingjia_form_list_zong">总体评价:</div>
										<ul>
											<li class="red">
												<div class="appraise_li-list_top_icon manyi">
												<input type="radio" name="manyi" class="ui-checkbox" id="refund-reason00" checked="checked" value="5" /><label for="refund-reason00" ><span>满意</span></label>
												</div>
											</li>
											<li class="yellow">
												<div class="appraise_li-list_top_icon yiban">
													 <input type="radio" name="manyi" class="ui-checkbox" id="refund-reason001" value="3" /><label for="refund-reason001" ><span>一般</span></label>
												</div>
											</li>
											<li class="gray">
												<div class="appraise_li-list_top_icon bumanyi">
													<input type="radio" name="manyi" class="ui-checkbox" id="refund-reason002" value="1" /><label for="refund-reason002" ><span>不满意</span></label>
												</div>
											</li>
											<div style="clear:both"></div>
										</ul>
									</div>
									<div class="textarea">
										<textarea name="content" cols="" rows="" class="form_textarea"></textarea>
									</div>
									<div class="shop_pingjia_form_list  appraise_li-list_top " style="border:0;">
										<div class="shop_pingjia_form_list_zong">图片:</div>
										<div class="shop_pingjia_list">
											<ul>
												<li id="shop_add">
													<form enctype="multipart/form-data" id="upload_image_form" target="iframe_upload_image" method="post" action="<?php echo url('comment:attachment') ?>">
														<div class="updat_pic"><img src="<?php echo TPL_URL;?>/images/jiahao.png" />
															<input type="file" name="file" class="ehdel_upload" id="upload_image">
															<p>0/10</p>
														</div>
													</form>
												</li>
											</ul>
										</div>
										<iframe name="iframe_upload_image" style="width:0px; height:0px; display:none;"></iframe>
										<!--图片上传--> 
									</div>
								</div>
								<div class="button">
									<div class="button_txt"><span>文明上网</span><span>礼貌发帖</span><span></span><span class="js-word-number">0/300</span></div>
									<button class="form_button js_save">提交</button>
									<div style="clear:both"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="con_one_5" style="display:none;" class="js-content-detail">
				<div class="fenxiao js-default" style="border:0px; width:100%">加载中</div>
			</div>
		</div>
	</div>
</div>
<?php include display( 'public:footer');?>

<!-- script type="text/javascript" src="http://api.map.baidu.com/api?type=quick&ak=4c1bb2055e24296bbaef36574877b4e2&v=1.0"></script-->
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>

<!-- script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("js-map");			// 创建Map实例
	map.centerAndZoom(new BMap.Point(<?php echo $store_contact['long'] ?>, <?php echo $store_contact['lat'] ?>), 19);				 // 初始化地图,设置中心点坐标和地图级别。
	map.addControl(new BMap.ZoomControl());	  //添加地图缩放控件	

	var marker = new BMap.Marker(new BMap.Point(<?php echo $store_contact['long'];?>,<?php echo $store_contact['lat'];?>));  //创建标注
	map.addOverlay(marker);				 // 将标注添加到地图中
	
	var infoWindow = new BMap.InfoWindow('<div class="infoWindow-content"><div class="address"><?php echo $store_contact['province_txt'];?><?php echo $store_contact['city_txt'];?><?php echo $store_contact['county_txt'];?> <?php echo $store_contact['address'];?></div><div class="navi"><a class="tag">到这里去</a><div class="js-navi-to navi-to"></div></div></div>',{title:'<?php echo $store['name'];?>',width:220,height:80,offset:{width:0,height:15}});
	infoWindow.addEventListener("open",function(e){
		$('.tag').click(function(){
			window.location.href = 'http://map.baidu.com/mobile/webapp/search/search/qt=s&wd=<?php echo urlencode($store_contact['province_txt'].$store_contact['city_txt'].$store_contact['county_txt'].$store_contact['address']);?>/?third_party=uri_api';
		});
	});
	marker.openInfoWindow(infoWindow);
	marker.addEventListener("click",function(e){
		marker.openInfoWindow(infoWindow);
	});
</script-->
<script type="text/javascript">
	//创建和初始化地图函数：
	function initMap(){
		createMap();//创建地图
		setMapEvent();//设置地图事件
		addMapControl();//向地图添加控件
		addMarker();//向地图中添加marker
	}
	
	//创建地图函数：
	function createMap(){
		var map = new BMap.Map("js-map");//在百度地图容器中创建一个地图
		var point = new BMap.Point(<?php echo $store_contact['long'] ?>, <?php echo $store_contact['lat'] ?>);//定义一个中心点坐标
		map.centerAndZoom(point, 19);//设定地图的中心点和坐标并将地图显示在地图容器中
		window.map = map;//将map变量存储在全局
	}
	
	//地图事件设置函数：
	function setMapEvent(){
		map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
		map.enableScrollWheelZoom();//启用地图滚轮放大缩小
		map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
		map.enableKeyboard();//启用键盘上下左右键移动地图
	}
	
	//地图控件添加函数：
	function addMapControl(){
		//向地图中添加缩放控件
		var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
		map.addControl(ctrl_nav);
		//向地图中添加缩略图控件
		var ctrl_ove = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:1});
		map.addControl(ctrl_ove);
		//向地图中添加比例尺控件
		var ctrl_sca = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
		map.addControl(ctrl_sca);
	}
	
	//标注点数组			
	var markerArr = [{title:"<?php echo $store['name'];?>",address:"<?php echo $store_contact['province_txt'];?><?php echo $store_contact['city_txt'];?><?php echo $store_contact['county_txt'];?> <?php echo $store_contact['address'];?>",content:"电话：<?php echo $store['service_tel'] ?>",point:"<?php echo $store_contact['long'] ?>|<?php echo $store_contact['lat'] ?>",isOpen:1,icon:{w:23,h:25,l:46,t:21,x:9,lb:12}}];
	//创建marker
	function addMarker(){
		for(var i=0;i<markerArr.length;i++){
			var json = markerArr[i];
			var p0 = json.point.split("|")[0];
			var p1 = json.point.split("|")[1];
			var point = new BMap.Point(p0,p1);
			var iconImg = createIcon(json.icon);
			var marker = new BMap.Marker(point,{icon:iconImg});
			var iw = createInfoWindow(i);
			var label = new BMap.Label(json.title,{"offset":new BMap.Size(json.icon.lb-json.icon.x+10,-20)});
			marker.setLabel(label);
			map.addOverlay(marker);
			label.setStyle({
						borderColor:"#808080",
						color:"#333",
						cursor:"pointer"
			});
			
			(function(){
				var index = i;
				var _iw = createInfoWindow(i);
				var _marker = marker;
				_marker.addEventListener("click",function(){
					this.openInfoWindow(_iw);
				});
				_iw.addEventListener("open",function(){
					_marker.getLabel().hide();
				})
				_iw.addEventListener("close",function(){
					_marker.getLabel().show();
				})
				label.addEventListener("click",function(){
					_marker.openInfoWindow(_iw);
				})
				if(!!json.isOpen){
					label.hide();
					_marker.openInfoWindow(_iw);
				}
			})()
		}
	}
	//创建InfoWindow
	function createInfoWindow(i){
		var json = markerArr[i];
		var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>"+json.address+"</div><div class='iw_poi_content'>"+json.content+"</div>");
		return iw;
	}
	//创建一个Icon
	function createIcon(json){
		var icon = new BMap.Icon("http://app.baidu.com/map/images/us_mk_icon.png", new BMap.Size(json.w,json.h),{imageOffset: new BMap.Size(-json.l,-json.t),infoWindowOffset:new BMap.Size(json.lb+5,1),offset:new BMap.Size(json.x,json.h)})
		return icon;
	}
</script>
</body>
</html>