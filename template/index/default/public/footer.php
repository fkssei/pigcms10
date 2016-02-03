<?php include display( 'public:activity_win');?>
<div class="footer1 ">
	<div class="footer_txt">
		<?php 
		if ($flink_list) {
		?>
			<div class="footer_list" style="text-align:center;">
				<ul style="text-align:center;">
					<?php 
					foreach ($flink_list as $key => $flink) {
					?>
						<li>
							<?php
							if ($key != 0) {
							?>
								<span>|</span>
							<?php
							}
							?>
							<a href="<?php echo $flink['url'] ?>" target="_blank"><?php echo $flink['name'] ?></a>
						</li>
					<?php
					}
					?>
				</ul>
			</div>
		<?php 
		}
		?>
		<div class="footer_txt">
			<?php echo $config['site_footer'] ?><?php echo $config['site_icp'] ?>  
		</div>
	</div>
</div>


<!--二维码弹出层-->



<style>
.right-red-radius {background-color: #cc0000; border-radius: 10px;}
.mui-mbar-tab-sup-bd {font-size:12px;}
</style>
<div class="content_rihgt" id="leftsead" style="position: fixed; top: 352px;">
	<ul>
		<li class="content_rihgt_shpping">
			<div id="cartbottom">
				<div class="right-red-radius" style="margin-top: 0px; color:#fff; position: absolute;z-index:2; width: 20px; height: 22px; font-size: 12px;line-height:22px;">
					<div class="mui-mbar-tab-sup-bd"><?php  if(($cart_number + 0)>99) {echo "99";}else{echo $cart_number + 0;} ?></div>
				</div>
			</div>
		</li>
		<li class="content_rihgt_erweima">
			<a href="javascript:void(0)">
				<div class="content_rihgt_erweima_img"><img src="<?php echo option('config.wechat_qrcode');?>"></div>
			</a>
		</li>
		<li class="content_rihgt_gotop"><a href="javascript:scroll(0,0)"></a></li>
	</ul>
</div>
<script>
<!-- 代码 结束 -->
function addCart_pf(event) {
	$("#leftsead").show();
	var offset = $('#cartbottom').offset(), flyer = $('<div class="right-red-radius" style="margin-top: 0px; color:#fff; position: absolute;z-index:9999; width: 20px; height: 22px; font-size: 12px;line-height:22px;"><div class="mui-mbar-tab-sup-bd"></div></div>');
	offset.top="352";
	
	flyer.fly({
		start: {left : event.pageX, top: event.clientY - 30},
		end: {left : offset.left, top : offset.top, width : 20, height : 20},
		onEnd: function() {
			var cart_number = parseInt($("#header_cart_number").text());
			if(cart_number > 99) {
				cart_number = 99;
			}
			$(".mui-mbar-tab-sup-bd").html(cart_number);
		}
	});
}
$(function () {
	$(".content_rihgt_shpping").css("cursor", "pointer");
	$(".content_rihgt_shpping").click(function () {
		location.href = "<?php echo url('cart:one') ?>";
	});
})
</script>