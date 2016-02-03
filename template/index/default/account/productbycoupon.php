<?php include display( 'public:person_header');?>
<script>
$(function () {
	$(".del-btn").click(function () {
		if (!confirm("您确定要删除这个优惠券？")) {
			return;
		}
		deluserCoupon("<?php echo $coupon['id']?>");
	});

	$("#pages a").click(function () {
		var page = $(this).attr("data-page-num");
		var url = "<?php echo url("account:productbyCoupon",$param_search) ?>&page=" + page;
		location.href = url;
	});
});
</script>
<style type="text/css">
.youhui_list{ display:block}
.youhui_list .youhui_table .youhui_r{ border:0}
.youhui_list .youhui_table .youhui_r .youhui_r_list{ margin-top:30px; border:1px solid #d9d9d9;}
.youhui_list .youhui_table .youhui_r{ margin-top:0}
.content .content_list ul{width:100%;}
.content .content_commodity ul.content_list_ul li{ margin-right:15px;}
.youhuiquan_content .content_commodity li .content_shop_name{ float:none}
</style>
<div class="youhui_list">
                    <ul>
                        <li>
                            <div class="youhui_list_title">券编号:<span><?php echo $coupon['card_no']?></span> </div>
                            <div class="youhui_table clearfix">
                                <div class="youhuiquan_info  clearfix">
                                    <div class="youhiquan_linqu"><?php if((time()>$coupon['start_time']&&time()<$coupon['end_time'])&&($coupon['is_use']==0)){?>未过期<?php }else if($coupon['is_use']){?>已使用<?php }else{?>已过期<?php } ?></div>
                                    <div class="youhiquan_shuoming">订单金额满<?php if($coupon['limit_money'] > '0') {?>订单满￥<em><?php echo $coupon['limit_money'];?></em>可用<?php }else{?>无限制<?php }?></div>
                                    <div class="youhiquan_price">￥<span><?php echo $coupon['face_money']?></span></div>
                                    <div class="youhiquan_data">有效期限:<span><?php echo date("Y-m-d", $coupon['start_time']);?>至<?php echo date("Y-m-d", $coupon['end_time']);?>		</span></div>
                                </div>
                                <div class="youhui_c">
                                    <div class="youhui_c_list">•限购【<a target="_blank"  href="<?php echo url_rewrite('store:index', array('id' => $coupon['store_id'])) ?>"><?php echo $store_name;?></a>】店铺商品</div>
                                    <div class="youhui_c_list">•<?php if($coupon['is_all_product']=='0') {?>可在  全平台  使用<?php }else {?>可在  全平台部分商品中  使用<?php }?></div>
                                    <div  class="youhui_c_txt">来源:<span>店铺发放</span></div>
                                </div>
                                <div  class="youhui_r">
								<div  class="youhui_r_list"><a href="<?php echo url_rewrite('store:index', array('id' => $coupon['store_id'])) ?>">进入店铺</a></div>
                                    <div  class="youhui_r_list"><a href="#none" class="btn-9 del-btn" >删除优惠券</a></div>
                                    
                                </div>
                            </div>                    </ul>
                </div>
				
				<?php if(count($product_list)) {?>
<div class="content youhuiquan_content">
                            <div class="content_commodity content_woman" id="f1">
                                <div class="youhuiquan_content_title">可以使用优惠券的商品列表</div>
                                <div class="content_list">
								
                                    <ul class="content_list_ul">
									<?php foreach($product_list as $k => $v) {?>
											<li> <a href="<?php echo $v['link']?>">
                                            <div class="content_list_img"><img src="<?php echo $v['image']?>">
                                                <div class="content_list_erweima">
                                                    <div class="content_list_erweima_img"><img src="<?php echo  $config['site_url'].'/source/qrcode.php?type=good&id='.$v['product_id'];?>"></div>
                                                    <div class="content_shop_name"><?php echo $v['name'];?></div>
                                                </div>
                                            </div>
                                            <div class="content_list_txt">    <div class="content_shop_name"><?php echo $v['name'];?></div></div>
                                            <div class="content_list_txt">
                                                <div class="content_list_pice">￥<span><?php echo $v['price']?></span></div>
                                            
                                            </div>
                                            </a> </li>
											
											<?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
						<?php } ?>
				<?php include display( 'public:person_footer');?>