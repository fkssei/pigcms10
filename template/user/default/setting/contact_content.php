<form class="form-horizontal" style="">
	<div class="control-group">
		<label class="control-label">
			<em class="required">*</em>
			客服电话：
		</label>
		<div class="controls">
			<input type="text" class="span1 text-center" name="phone1" placeholder="区号" value="<?php echo $store_contact['phone1']?>" maxlength="6"/>&nbsp;&nbsp;-&nbsp;&nbsp;
			<input type="text" name="phone2" placeholder="请输入电话号码（区号可留空）" value="<?php echo $store_contact['phone2']?>" maxlength="15"/>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">
			<em class="required">*</em>
			所属区域：
		</label>
		<div class="controls ui-regions js-regions-wrap" data-province="<?php echo $store_contact['province']?>" data-city="<?php echo $store_contact['city']?>" data-county="<?php echo $store_contact['county']?>">
			<span><select name="province" id="s1"></select></span>
			<span><select name="city" id="s2"><option value="">选择城市</option></select></span>
			<span><select name="county" id="s3"><option value="">选择地区</option></select></span>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">
			<em class="required">*</em>
			联系地址：
		</label>
		<div class="controls">
			<input type="text" class="span6 js-address-input" name="address" value="<?php echo $store_contact['address']?>" placeholder="请填写详细地址，以便买家联系；（勿重复填写省市区信息）" maxlength="80"/>
			<button type="button" class="btn js-search">搜索地图</button>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">
			<em class="required">*</em>
			地图定位：
		</label>
		<div class="controls">
			<input type="hidden" class="span6 js-address-input" name="map_long" id="map_long" value="<?php echo $store_contact['long']?>"/>
			<input type="hidden" class="span6 js-address-input" name="map_lat" id="map_lat" value="<?php echo $store_contact['lat']?>"/>
			<div class="shop-map-container">
				<div class="left hide">
					<ul class="place-list js-place-list"></ul>
				</div>
				<div class="map js-map-container large" id="cmmap"></div>
				<button type="button" class="ui-btn select-place js-select-place">点击地图标注位置</button>
			</div>
		</div>
	</div>

	<div class="form-actions" style="margin-top:50px">
		<button type="button" class="ui-btn ui-btn-primary js-contact-submit" data-text-loading="保存中...">保存</button>
	</div>

</form>