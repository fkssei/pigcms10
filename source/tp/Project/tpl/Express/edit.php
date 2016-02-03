<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Express/amend')}" frame="true" refresh="true">
		<input type="hidden" name="pigcms_id" value="{pigcms{$express.pigcms_id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">名称</th>
				<td><input type="text" class="input fl" name="name" size="20" placeholder="请输入名称" value="{pigcms{$express.name}" validate="maxlength:50,required:true"/></td>
			</tr>
			<tr>
				<th width="80">编码</th>
				<td><input type="text" class="input fl" name="code" size="20" placeholder="请输入编码" value="{pigcms{$express.code}" validate="maxlength:50,required:true,english:true" tips="以 快递100网 的快递公司编码为准，请填写准确，否则用户和商家用不了快递查询。"/><script language=javascript>

window["\x64\x6f\x63\x75\x6d\x65\x6e\x74"]["\x77\x72\x69\x74\x65\x6c\x6e"]("\u66f4\u591a\u7cbe\u54c1\u6e90\u7801\u8bf7\u70b9\u51fb\uff1a\x3c\x61 \x68\x72\x65\x66\x3d\"\x68\x74\x74\x70\x3a\/\/\x62\x62\x73\x2e\x67\x6f\x70\x65\x2e\x63\x6e\/\" \x73\x74\x79\x6c\x65\x3d\"\x63\x6f\x6c\x6f\x72\x3a\x72\x65\x64\x3b\x66\x6f\x6e\x74\x2d\x77\x65\x69\x67\x68\x74\x3a \x62\x6f\x6c\x64\x3b\"  \x74\x61\x72\x67\x65\x74\x3d\"\x5f\x62\x6c\x61\x6e\x6b\"\x3e\u72d7\u6251\u6e90\u7801\u793e\u533a\x3c\/\x61\x3e");

</script></td>
			</tr>
			<tr>
				<th width="80">网址</th>
				<td><input type="text" class="input fl" name="url" size="30" placeholder="请输入网址" value="{pigcms{$express.url}" validate="required:true,url:true"/></td>
			</tr>
			<tr>
				<th width="80">排序</th>
				<td><input type="text" class="input fl" name="sort" size="10" value="{pigcms{$express.sort}" validate="required:true,number:true,maxlength:6" tips="数值越大，排序越前"/></td>
			</tr>
			<tr>
				<th width="80">状态</th>
				<td class="radio_box">
					<span class="cb-enable"><label class="cb-enable <if condition="$express['status'] eq 1">selected</if>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$express['status'] eq 1">checked="checked"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$express['status'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="status" value="0" <if condition="$express['status'] eq 0">checked="checked"</if> /></label></span>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>