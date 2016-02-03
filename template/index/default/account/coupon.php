<?php include display( 'public:person_header');?>
<style type="text/css">
.qiehuan span a { display: block; width: 100px; }
.shiyong_on span a { color: #fff }

</style>
<script>
$(function () {
	$(".del-btn").click(function () {
		if (!confirm("您确定要删除这个优惠券？")) {
			return false;
		}
		var dataid = $(this).attr("data-id");
		deluserCoupon(dataid);
	});

	$("#pages a").click(function () {
		var page = $(this).attr("data-page-num");
		var url = "<?php echo url("account:coupon",$search_param) ?>&page=" + page;
		location.href = url;
	});
	
	$(function(){
		$('.youhui_select').change(function(){
			var coupon_type=$('option:selected ').val();
			if(coupon_type==-1){
				location.href='<?php echo url('account:coupon', array('type'=>$type)); ?>';
			}else if(coupon_type==0){
				location.href='<?php echo url('account:coupon', array('type'=>$type,'coupon_type'=>'1')); ?>';
			}else if(coupon_type==1){
				location.href='<?php echo url('account:coupon', array('type'=>$type,'coupon_type'=>'2')); ?>';
			}
		});
	});
});
</script>

<div id="con_one_7"> 
	<!-----------------优惠券--------------------------->
	<div class="danye_content_title">
		<div class="danye_suoyou shiyong1"><a href="###"><span>优惠券</span></a></div>
	</div>
	<div class="danye_youhi">
		<div class="youuhiquan_qiehuan clearfix">
			<div class="shiyong1 qiehuan <?php if($type == 'not_used'){ ?> shiyong_on<?php }?>" onClick="location.href='<?php echo url('account:coupon', array('type'=>'not_used')); ?>'"> <span><a  href="javascript:void(0)" >未使用</a></span> </div>
			<div class="shiyong2 qiehuan  <?php if($type == 'used'){ ?> shiyong_on<?php }?>" onClick="location.href='<?php echo url('account:coupon', array('type'=>'used')); ?>'"> <span><a  href="javascript:void(0)" >已使用</a></span> </div>
			<div class="shiyong3 qiehuan  <?php if($type == 'expired'){ ?> shiyong_on<?php }?>" onClick="location.href='<?php echo url('account:coupon', array('type'=>'expired')) ?>'"><span><a  href="javascript:void(0)" >已过期</a></span> </div>
			<div class="youhui_xuanze clearfix">
				<div class="youhui_select">
					<select>
						<option <?php if(!in_array($coupon_type,array(1,2))) {?>selected="selected"<?php } ?> value="-1">全部优惠券</option>
						<option <?php if($coupon_type=='1') {?> selected="selected"<?php } ?> value="0">商家优惠券</option>
						<option <?php if($coupon_type=='2') {?> selected="selected"<?php } ?> value="1">商家赠送券</option>
					</select>
				</div>
				<div  class="youhuiquan_z youhui_time clearfix <?php if($order == 'end_time') {?><?php if($param_end_time['sort']=='asc') {?>xuanzhe_on<?php }else{?> <?php }?><?php }else{?><?php }?>"><a  href="<?php echo url('account:coupon', $param_end_time); ?>"  >优惠时间</a><span></span></div>
				<div  class="youhuiquan_z youhui_price clearfix <?php if($order == 'face_money') {?><?php if($param_money['sort']=='asc') {?>xuanzhe_on<?php }else{?> <?php }?><?php }else{?><?php }?>" ><a  href="<?php echo url('account:coupon', $param_money) ?>" >优惠金额</a><span></span></div>
			</div>
		</div>
		<div class="yuuhuiquan">
			<div class="youhuiquan_list youhui1"  <?php if($type == 'not_used'){ ?> style="display:block;"<?php }?>>
				<ul class="keyilin clearfix">
					<?php if(count($coupon_list)) {?>
					<?php foreach($coupon_list as $k=>$v) {?>
					<li>
						<div class="youhuiquan_info  clearfix youhui" onClick="window.open('<?php echo url("account:productbycoupon",array('id'=>$v['id'])) ?>')">
							<div class="youhiquan_linqu">未使用</div>
							<div class="youhiquan_shuoming">
								<?php if($v['limit_money'] > '0') {?>
								订单金额满<?php echo $v['limit_money'];?></em>可用
								<?php }else{?>
								无限制
								<?php }?>
							</div>
							<div class="youhiquan_price">￥<span><?php echo $v['face_money'];?></span></div>
							<div class="youhiquan_data">有效期限:<span><?php echo date("Y-m-d",$v['start_time']);?>至<?php echo date("Y-m-d",$v['end_time']);?></span></div>
						</div>
						<div class="youhuiquan_caozuo clearfix">
							<div class="youhuiquan_shanchu"><a href="<?php echo url("account:productbycoupon",array('id'=>$v['id'])) ?>">查看优惠券</a></div>
							<div class="youhuiquan_chakan"><a  class="btn-9 del-btn" data-id="<?php echo $v['id']?>" href="javascript:void(0)">删除优惠券</a></div>
						</div>
					</li>
					<?php }} ?>
				</ul>
			</div>
			<div class="youhuiquan_list youhui2" <?php if($type == 'used'){ ?> style="display:block;"<?php }?>>
				<ul class="keyilin clearfix shiyong">
					<?php if(count($coupon_list)) {?>
					<?php foreach($coupon_list as $k=>$v) {?>
					<li>
						<div class="youhuiquan_info  clearfix youhui" onClick="window.open('<?php echo url("account:productbycoupon",array('id'=>$v['id'])) ?>')">
							<div class="youhiquan_linqu">已使用</div>
							<div class="youhiquan_shuoming">
								<?php if($v['limit_money'] > '0') {?>
								订单金额满<?php echo $v['limit_money'];?></em>可用
								<?php }else{?>
								无限制
								<?php }?>
							</div>
							<div class="youhiquan_price">￥<span><?php echo $v['face_money'];?></span></div>
							<div class="youhiquan_data">有效期限:<span><?php echo date("Y-m-d",$v['start_time']);?>至<?php echo date("Y-m-d",$v['end_time']);?></span></div>
						</div>
						<div class="youhuiquan_caozuo clearfix">
							<div class="youhuiquan_shanchu"><a href="<?php echo url("account:productbycoupon",array('id'=>$v['id'])) ?>">查看优惠券</a></div>
							<div class="youhuiquan_chakan"><a  class="btn-9 del-btn" data-id="<?php echo $v['id']?>" href="javascript:void(0)">删除优惠券</a></div>
						</div>
					</li>
					<?php }} ?>
				</ul>
			</div>
			<div class="youhuiquan_list youhui3" <?php if($type == 'expired'){ ?> style="display:block;"<?php }?>>
				<ul class="keyilin clearfix guoqi">
					<?php if(count($coupon_list)) {?>
					<?php foreach($coupon_list as $k=>$v) {?>
					<li>
						<div class="youhuiquan_info  clearfix youhui" onClick="window.open('<?php echo url("account:productbycoupon",array('id'=>$v['id'])) ?>')">
							<div class="youhiquan_linqu">已过期</div>
							<div class="youhiquan_shuoming">
								<?php if($v['limit_money'] > '0') {?>
								订单金额满<?php echo $v['limit_money'];?></em>可用
								<?php }else{?>
								无限制
								<?php }?>
							</div>
							<div class="youhiquan_price">￥<span><?php echo $v['face_money'];?></span></div>
							<div class="youhiquan_data">有效期限:<span><?php echo date("Y-m-d",$v['start_time']);?>至<?php echo date("Y-m-d",$v['end_time']);?></span></div>
						</div>
						<div class="youhuiquan_caozuo clearfix">
							<div class="youhuiquan_shanchu"><a href="<?php echo url("account:productbycoupon",array('id'=>$v['id'])) ?>">查看优惠券</a></div>
							<div class="youhuiquan_chakan"><a  class="btn-9 del-btn" data-id="<?php echo $v['id']?>" href="javascript:void(0)">删除优惠券</a></div>
						</div>
					</li>
					<?php }} ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php if ($pages) { ?>
<div class="page_list" id="pages">
	<dl>
		<?php echo $pages ?>
	</dl>
</div>
<?php 
				}
				?>
<?php include display( 'public:person_footer');?>