<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title><?php echo htmlspecialchars($store['name']) ?>-<?php echo $config['seo_title'] ?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css">
<script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>

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
<style type="text/css">
.keyilin li{ margin:0}
.yuuhuiquan{ padding-top:0}
.content .content_commodity li .content_list_pice, .content .content_commodity li .content_shop_name{ float:none; text-align:left}
</style>
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

<div class="yuuhuiquan yuuhuiquan_info_list">
    <div class="youhuiquan_list clearfix">
        <div class="youhuiquan_title">可领取的优惠券</div>
        <ul class="keyilin clearfix">
            <li class="clearfix">
                <div class="youhuiquan_info  clearfix">
                    <div class="youhiquan_linqu"><?php if($coupon_detail['coupon_num']>0){?>已领取<?php }else{?>未领取<?php } ?></div>
                    <div class="youhiquan_shuoming">订单金额满<?php echo $coupon_detail['limit_money']?>元即可使用</div>
                    <div class="youhiquan_price">￥<span><?php echo $coupon_detail['face_money']?></span></div>
                    <div class="youhiquan_data">有效期限:<span><?php echo date('Y-m-d',$coupon_detail['start_time'])?></span>至<span><?php echo date('Y-m-d',$coupon_detail['end_time'])?></span></div>
                </div>
                <div class="youhuiquan_shop">
                    <div class="youhuiquan_shop_title">券类型</div>
                    <div class="youhuiquan_shop_list"><i>券类型:</i><span><?php if($coupon_detail['type']==1){?>优惠券<?php }else {?>赠送券<?php } ?></span></div>
                    <div class="youhuiquan_shop_list"><i>面额:</i>￥<span><?php echo $coupon_detail['face_money']?></span></div>
                    <div class="youhuiquan_shop_list"><i>使用门槛: </i><?php if($coupon_detail['limit_money'] == '0'){?>无使用限制<?php }else{?>	订单金额满<?php echo $coupon_detail['limit_money']?>元即可使用<?php } ?></div>
                    <div class="youhuiquan_shop_list"><i>有效期限:</i><span><?php echo date('Y-m-d',$coupon_detail['start_time'])?></span>至<span><?php echo date('Y-m-d',$coupon_detail['end_time'])?></span></div>
                </div>
            </li>
        </ul>
        
    </div>
</div>
<div class="content youhuiquan_content">
<div class="content_commodity content_woman" id="f1">
 <div class="youhuiquan_content_title">可以使用优惠券的商品列表</div>
        <div class="content_list">
		<?php if(count($product_list)) {?>
            <ul class="content_list_ul">
			<?php foreach($product_list as $k => $v) {?>
                <li> <a href="<?php echo $v['link']?>">
                    <div class="content_list_img"><img src="<?php echo $v['image']?>">
                        <div class="content_list_erweima">
                            <div class="content_list_erweima_img"><img src="<?php echo  $config['site_url'].'/source/qrcode.php?type=good&id='.$v['product_id'];?>"></div>
                            <div class="content_shop_name"><?php echo $v['name'];?></div>
                        </div>
                    </div>
                    <div class="content_list_txt">
                        <div class="content_list_pice">￥<span><?php echo $v['price']?>	</span></div>
                                  <div class="content_shop_name"><?php echo $v['name'];?></div>
                    </div>
                    <div class="content_list_txt">
                        <div class="content_list_day">成交<span><?php echo $v['sales']?></span>笔 </div>
               
                    </div>
                    </a> </li>
					<?php } ?>
            </ul>
			<?php } ?>
        </div>
    </div>



</div>
<?php include display( 'public:footer');?>
</body>
</html>