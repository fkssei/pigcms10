<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>欢迎光临<?php echo htmlspecialchars($store['name']) ?>-<?php echo $config['seo_title'] ?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/public.css">
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/store.css">
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css">
<script type="text/javascript" src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
<script src="<?php echo TPL_URL;?>js/bootstrap.min.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>

<script src="<?php echo TPL_URL;?>js/distance.js"></script>
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script src="<?php echo TPL_URL;?>js/index2.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo TPL_URL;?>js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="js/DD_belatedPNG_0.0.8a.js" mce_src="<?php echo TPL_URL;?>js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css"> 
body{ behavior:url("csshover.htc");}

</style>
<![endif]-->
<style>
.keyilin li{position:relative}
.youhiquan_shuoming {font-size: 16px;left: 91px; position: absolute;text-align: left;top: 14px;}
	#pageflip2 {RIGHT: 0px; FLOAT: right; POSITION: relative; TOP: 6px; }
	.pageflip .pageflipimg {Z-INDEX: 99; RIGHT: 0px; WIDTH: 0px; POSITION: absolute; TOP: 6px; HEIGHT: 0px; ms-interpolation-mode: bicubic}
	.pageflip .msg_block { z-index:2;RIGHT: 0px; BACKGROUND: url(<?php echo TPL_URL;?>images/ico/subscribe.png) no-repeat right top; OVERFLOW: hidden; WIDTH: 0px; POSITION: absolute; TOP: 6px; HEIGHT: 0px}

.youhiquan_linqu {
    font-size: 17px;
    left: 24px;
    line-height: 41px;
    margin-left: 10px;
    position: absolute;
    top: 24px;
    width: 27px;
}

.keyilin li {
    float: left;
    margin: 7px 11px 26px;
    width: 378px;
}
</style>
	<SCRIPT type=text/javascript>
		$(function(){
			$(".pageflip").hover(function() {
				var index = $(".pageflip").index($(this));
				$(this).find(".msg_block,.pageflipimg").stop().animate({
					width: '80px',
					height: '80px'
				}, 500);
			} , function() {
				$(".pageflipimg").stop().animate({
						width: '0',
						height: '0'
					}, 220);
				$(".msg_block").stop().animate({
						width: '0',
						height: '0'
					}, 200);
			});
			//url跳转
			$("#pages a").click(function () {
				var page = $(this).attr("data-page-num");
				changePage(page);

			});



		});

		
		function jumpPage() {
			var page = $("#jump_page").val();
			changePage(page);
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
			var tpage = "<?php echo $total_pages;?>";
			if(page > tpage) {page = tpage;}

			
			var url = "<?php echo url('store:couponlist',array('storeid' => $store['store_id'])) ?>&page=" + page;
		
			location.href = url;
		}	
	</SCRIPT>
</head>

<body>
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



 <div class="yuuhuiquan">
	<div class="youhuiquan_list">
		<div class="youhuiquan_title">可领取的优惠券<?php if(!count($coupon_list)) {?><span style="padding-left:20px; font-size:14px;">暂无</span><?php } ?></div>
		<?php if(count($coupon_list)>0) {?>
		<ul class="keyilin clearfix">
			<?php foreach($coupon_list as $k=>$v) {?>
				<li class="pageflip">
				<a href="<?php echo url("store:coupon_detail",array('id'=>$v['id']))?>" target="_blank"><IMG class="pageflipimg" alt="" src="/template/index/default/js/page_flip.png"></a>
				<div class=msg_block></div>
				<a href="javascript:void(0)" onclick="javascript:addCoupon(<?php echo $v['id'];?>)"">
					<div class="youhuiquan_info  clearfix">
						<div class="youhiquan_linqu">点击领取</div>
						<div class="youhiquan_shuoming">订单金额满<?php echo $v['limit_money'];?>元即可使用</div>
						<div class="youhiquan_price">￥<span><?php echo $v['face_money']?></span></div>
						<div class="youhiquan_data">有效期限:<span><?php echo date("Y-m-d", $v['start_time']);?> </span>至<span><?php echo date("Y-m-d", $v['end_time']);?> </span></div>
					</div></a>
				</li>
			<?php }?>
		</ul>
		<?php }?>	
		<?php if(count($coupon_list)>0) {?>
		    <div class="page_list" id="pages">
			    <dl>
				    <?php echo $pages ?>
				    <dt>
					    <form onsubmit="return false;">
						    <span>跳转到:</span>
						    <input type="text" value="" id="jump_page" name="currentPage" class="J_topage page-skip">
						    <button onclick="javascript:jumpPage()">GO</button>
					    </form>
				    </dt>
			    </dl>
		    </div>
		<?php }?>
	</div>
</div>


<?php include display( 'public:footer');?>

</body></html>