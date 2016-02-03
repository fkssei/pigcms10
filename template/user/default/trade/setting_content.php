<form class="form-horizontal ui-form">
	<div class="control-group">
		<label class="control-label">拍下未付款</label>
		<div class="controls">
			<input class="input-tiny" type="text" name="pay_cancel_time" value="<?php echo $setting['pay_cancel_time'];?>"/>
			分钟内未付款，自动取消该订单；
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">催付通知</label>
		<div class="controls">
			<input class="input-tiny" type="text" name="pay_alert_time" value="<?php echo $setting['pay_alert_time'];?>"/>
			分钟未付款，自动向微信粉丝发送催付；
		</div>
	</div>
	<div class="control-group hide">
		<label class="control-label">取消订单通知</label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" name="cancel_notice" value="1" <?php if($setting['cancel_notice']) echo 'checked="checked"';?>/>			
				卖家手动取消订单，自动向微信粉丝发送取消订单提醒;
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">支付成功通知</label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" name="sucess_notice" value="1" <?php if($setting['sucess_notice']) echo 'checked="checked"';?>/>		
				买家支付完成后，自动向微信粉丝发送支付成功提醒；
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">发货通知</label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" name="send_notice" value="1" <?php if($setting['send_notice']) echo 'checked="checked"';?>/>
				卖家点击“发货”之后，自动向微信粉丝发送发货提醒；
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">维权通知</label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" name="complain_notice" value="1" <?php if($setting['complain_notice']) echo 'checked="checked"';?> disabled="disabled"/>
				订单维权处理完成后，微信会主动通知粉丝是否同意。
			</label>
		</div>
	</div>
	<div class="control-group hide">
		<label class="control-label">消息通知模板</label>
		<div class="controls">
			<label class="radio inline">
				<input type="radio" name="message_template" value="0" checked=""/>				
				文本内容
			</label>
			<label class="radio inline">
				<input type="radio" name="message_template" value="1"/>
				微信模板
			</label>
		</div>
	</div>
	<div class="control-group hide">
		<label class="control-label">支付方式</label>
		<div class="controls">
			<label class="checkbox inline">
				<input class="js-not-autoupdate" type="checkbox" data-type="number" name="payment" value="1">微信安全支付
			</label>
			<label class="checkbox inline">
				<input class="js-not-autoupdate" type="checkbox" data-type="number" name="payment" value="2">支付宝支付
			</label>
			<label class="checkbox inline">
				<input class="js-not-autoupdate" type="checkbox" data-type="number" name="payment" value="3">银联支付
			</label>
		</div>
	</div>
	<div class="form-actions">
		<input class="btn btn-primary js-btn-save" type="submit" value="保 存"/>
	</div>
</form>