<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<div class="js-logistics">
    <div class="js-logistics-board">
		<div class="widget-app-board ui-box">
			<div class="widget-app-board-info">
				<h3>物流配送功能</h3>
				<div>
					<p>
						启用物流配送功能后，用户下订单才能选择物流方式配送。<br />
						<span style="color:red">当关闭此功能，只有用户全部购买了您的自营产品，才不能使用物流配送</span>
					</p>
				</div>
			</div>
			<div class="widget-app-board-control">
				<label class="js-switch js-logistics-status ui-switch <?php if ($store['open_logistics']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?> right"></label>
			</div>
		</div>
	</div>
</div>