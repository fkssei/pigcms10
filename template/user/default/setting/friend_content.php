<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<div class="js-friend">
    <div class="js-friend-board">
		<div class="widget-app-board ui-box">
			<div class="widget-app-board-info">
				<h3>送朋友功能</h3>
				<div>
					<p>
						启用送朋友功能后，用户下订单可以通过物流方式将产品配送给朋友，此功能受物流配送是否开启影响。<br />
						<span style="color:red">用户选择“送朋友”功能后，是不能使用货到付款功能</span>
					</p>
				</div>
			</div>
			<div class="widget-app-board-control">
				<label class="js-switch js-friend-status ui-switch <?php if ($store['open_friend']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?> right"></label>
			</div>
		</div>
	</div>
</div>