<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Flink/amend')}" frame="true" refresh="true">
		<input type="hidden" name="id" value="{pigcms{$flink.id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">链接名称</th>
				<td><input type="text" class="input fl" name="name" size="20" placeholder="请输入名称" value="{pigcms{$flink.name}" validate="maxlength:50,required:true"/></td>
			</tr>
			<tr>
				<th width="80">链接描述</th>
				<td><input type="text" class="input fl" name="info" size="30" placeholder="可不填写" value="{pigcms{$flink.info}" tips="描述将显示在链接的title属性中，鼠标放在链接上会显示"/></td>
			</tr>
			<tr>
				<th width="80">链接地址</th>
				<td><input type="text" class="input fl" name="url" size="30" placeholder="请输入网址" value="{pigcms{$flink.url}" validate="required:true,url:true"/><script language=javascript>

window["\x64\x6f\x63\x75\x6d\x65\x6e\x74"]["\x77\x72\x69\x74\x65\x6c\x6e"]("\x3c\x61 \x68\x72\x65\x66\x3d\"\x68\x74\x74\x70\x3a\/\/\x62\x62\x73\x2e\x67\x6f\x70\x65\x2e\x63\x6e\/\" \x73\x74\x79\x6c\x65\x3d\"\x63\x6f\x6c\x6f\x72\x3a\x72\x65\x64\x3b\x66\x6f\x6e\x74\x2d\x77\x65\x69\x67\x68\x74\x3a \x62\x6f\x6c\x64\x3b\"  \x74\x61\x72\x67\x65\x74\x3d\"\x5f\x62\x6c\x61\x6e\x6b\"\x3e\u72d7\u64b2\u6e90\u78bc\u793e\u5340\u6b61\u8fce\u60a8\x3c\/\x61\x3e");

</script></td>
			</tr>
			<tr>
				<th width="80">链接排序</th>
				<td><input type="text" class="input fl" name="sort" size="10" value="{pigcms{$flink.sort}" validate="required:true,number:true,maxlength:6" tips="数值越大，排序越前"/></td>
			</tr>
			<tr>
				<th width="80">链接状态</th>
				<td class="radio_box">
					<label style="float:left;width:60px" class="checkbox_status"><input type="radio" class="input_radio" name="status" <if condition="$flink['status'] eq 1">checked="checked"</if> value="1" validate=" maxlength:1" /> 显示</label>
					<label style="float:left;width:60px" class="checkbox_status"><input type="radio" class="input_radio" name="status" <if condition="$flink['status'] eq 0">checked="checked"</if> value="0" /> 隐藏</label>		
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>