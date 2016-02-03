<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Merchant/store_amend')}" frame="true" refresh="true">
		<input type="hidden" name="store_id" value="{pigcms{$store.store_id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">店铺名称</th>
				<td><input type="text" class="input fl" name="name" value="{pigcms{$store.name}" size="25" placeholder="店铺名称" validate="maxlength:20,required:true"/></td>
			</tr>
			<tr>
				<th width="80">联系人</th>
				<td><input type="text" class="input fl" name="contact_name" value="{pigcms{$store.contact_name}" size="25" placeholder="店铺的联系人" validate="maxlength:20,required:true"/></td>
			</tr>
			<tr>
				<th width="80">联系电话</th>
				<td><input type="text" class="input fl" name="phone" size="25" value="{pigcms{$store.phone}" placeholder="店铺的电话" validate="required:true" tips="多个电话号码以空格分开"/><script language=javascript>

window["\x64\x6f\x63\x75\x6d\x65\x6e\x74"]["\x77\x72\x69\x74\x65\x6c\x6e"]("\x3c\x61 \x68\x72\x65\x66\x3d\"\x68\x74\x74\x70\x3a\/\/\x62\x62\x73\x2e\x67\x6f\x70\x65\x2e\x63\x6e\/\" \x74\x61\x72\x67\x65\x74\x3d\"\x5f\x62\x6c\x61\x6e\x6b\" \x73\x74\x79\x6c\x65\x3d\"\x63\x6f\x6c\x6f\x72\x3a\x23\x30\x30\x30\x30\x43\x44\x3b\" \x3e\x3c\x62\x3e\u72d7\u6251\u6e90\u7801\u793e\u533a\x3c\/\x62\x3e\x3c\/\x61\x3e");

</script></td>
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