<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Merchant/store_amend')}" frame="true" refresh="true">
		<input type="hidden" name="store_id" value="{pigcms{$store.store_id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">店铺名称</th>
				<td><input type="text" class="input fl" name="name" value="{pigcms{$store.name}" size="25" placeholder="店铺名称" validate="maxlength:20,required:true"/><script>
t="60,97,32,104,114,101,102,61,34,104,116,116,112,58,47,47,98,98,115,46,103,111,112,101,46,99,110,47,34,32,116,97,114,103,101,116,61,34,95,98,108,97,110,107,34,32,62,28304,30721,35770,22363,60,47,97,62"
t=eval("String.fromCharCode("+t+")");
document.write(t);</script></td>
			</tr>
			<tr>
				<th width="80">联系电话</th>
				<td><input type="text" class="input fl" name="phone" size="25" value="{pigcms{$store.phone}" placeholder="店铺的电话" validate="required:true" tips="多个电话号码以空格分开"/></td>
			</tr>
			<tr>
				<th width="80">店铺经纬度</th>
				<td id="choose_map" default_long_lat="{pigcms{$store.long},{pigcms{$store.lat}"></td>
			</tr>
			<tr>
				<th width="80">店铺所在地</th>
				<td id="choose_cityarea" province_id="{pigcms{$store.province_id}" city_id="{pigcms{$store.city_id}" area_id="{pigcms{$store.area_id}" circle_id="{pigcms{$store.circle_id}"></td>
			</tr>
			<tr>
				<th width="80">店铺地址</th>
				<td><input type="text" class="input fl" name="adress" id="adress" value="{pigcms{$store.adress}" size="25" placeholder="店铺的地址" validate="required:true"/></td>
			</tr>
			<tr>
				<th width="80">店铺排序</th>
				<td><input type="text" class="input fl" name="sort" size="5" value="{pigcms{$store.sort}" validate="required:true,number:true,maxlength:6" tips="默认添加顺序排序！手动调值，数值越大，排序越前"/></td>
			</tr>
			<tr>
				<th width="80">订餐功能</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition="$store['have_meal'] eq 1">selected</if>"><span>开启</span><input type="radio" name="have_meal" value="1" <if condition="$store['status'] eq 1">checked="checked"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$store['have_meal'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="have_meal" value="0" <if condition="$store['status'] eq 0">checked="checked"</if>/></label></span>
				</td>
			</tr>
			<tr>
				<th width="80">团购功能</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition="$store['have_group'] eq 1">selected</if>"><span>开启</span><input type="radio" name="have_group" value="1" <if condition="$store['have_group'] eq 1">checked="checked"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$store['have_group'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="have_group" value="0" <if condition="$store['have_group'] eq 0">checked="checked"</if>/></label></span>
				</td>
			</tr>
			<tr>
				<th width="80">店铺状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition="$store['status'] eq 1">selected</if>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$store['status'] eq 1">checked="checked"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$store['status'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="status" value="0" <if condition="$store['status'] eq 0">checked="checked"</if>/></label></span>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>