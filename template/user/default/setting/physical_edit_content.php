<form class="form-horizontal" style="">
	 <input type="hidden" name="pigcms_id" value="<?php echo $store_physical['pigcms_id']?>"/>
	<div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            门店名称：
        </label>
        <div class="controls">
            <input type="text" name="name" placeholder="门店名称最长支持20个字符" maxlength="20" value="<?php echo $store_physical['name']?>">
        </div>
    </div>
	<div class="control-group">
		<label class="control-label">
			<em class="required">*</em>
			联系电话：
		</label>
		<div class="controls">
			<input type="text" class="span1 text-center" name="phone1" placeholder="区号" value="<?php echo $store_physical['phone1']?>" maxlength="6"/>&nbsp;&nbsp;-&nbsp;&nbsp;
			<input type="text" name="phone2" placeholder="请输入电话号码（区号可留空）" value="<?php echo $store_physical['phone2']?>" maxlength="15"/>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">
			<em class="required">*</em>
			所属区域：
		</label>
		<div class="controls ui-regions js-regions-wrap" data-province="<?php echo $store_physical['province']?>" data-city="<?php echo $store_physical['city']?>" data-county="<?php echo $store_physical['county']?>">
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
			<input type="text" class="span6 js-address-input" name="address" value="<?php echo $store_physical['address']?>" placeholder="请填写详细地址，以便买家联系；（勿重复填写省市区信息）" maxlength="80"/>
			<button type="button" class="btn js-search">搜索地图</button>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">
			<em class="required">*</em>
			地图定位：
		</label>
		<div class="controls">
			<input type="hidden" class="span6 js-address-input" name="map_long" id="map_long" value="<?php echo $store_physical['long']?>"/>
			<input type="hidden" class="span6 js-address-input" name="map_lat" id="map_lat" value="<?php echo $store_physical['lat']?>"/>
			<div class="shop-map-container">
				<div class="left hide">
					<ul class="place-list js-place-list"></ul>
				</div>
				<div class="map js-map-container large" id="cmmap"></div>
				<button type="button" class="ui-btn select-place js-select-place">点击地图标注位置</button>
			</div>
		</div>
	</div>
	<div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            门店照片：
        </label>
        <div class="controls">
            <div class="control-action js-picture-list-wrap">
				<ul class="app-image-list clearfix">
					<div class="js-img-list" style="display:inline-block">
						<?php foreach($store_physical['images_arr'] as $value){ ?>
							<li class="upload-preview-img"><a href="<?php echo $value;?>" target="_blank"><img src="<?php echo $value;?>"></a><a class="js-delete-picture close-modal small hide">×</a></li>
						<?php } ?>
					</div>
					<li class="js-picture-btn-wrap" style="display:inline-block;float:none;vertical-align:top;">
						<a href="javascript:;" class="add js-add-physical-picture">+加图</a>
					</li>
				</ul>
			</div>
        </div>
    </div>
	<div class="control-group">
        <label class="control-label">
            运营时间：
        </label>
        <div class="controls">
            <input type="text" name="business_hours" placeholder="如10:00-22:00" value="<?php echo $store_physical['business_hours']?>" maxlength="20"/>
        </div>
    </div>
	<div class="control-group">
        <label class="control-label">
            商家推荐：
        </label>
        <div class="controls">
            <textarea name="description" placeholder="你可以简述门店的推荐商品或者活动，也可以像买家陈述特色服务，例如，免费停车和、WiFi。" class="span4" maxlength="300" cols="50" rows="4"><?php echo $store_physical['description']?></textarea>
        </div>
    </div>	
	<div class="form-actions" style="margin-top:50px">
		<button type="button" class="ui-btn ui-btn-primary js-physical-edit-submit">保存</button>
	</div>
</form>