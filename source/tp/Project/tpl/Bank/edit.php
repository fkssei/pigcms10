<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Bank/amend')}" frame="true" refresh="true">
		<input type="hidden" name="bank_id" value="{pigcms{$bank.bank_id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">名称</th>
				<td><input type="text" class="input fl" name="name" size="20" placeholder="请输入名称" value="{pigcms{$bank.name}" validate="maxlength:50,required:true"/></td>
			</tr>
			<tr>
				<th width="80">状态</th>
				<td class="radio_box">
					<span class="cb-enable"><label class="cb-enable <if condition="$bank['status'] eq 1">selected</if>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$bank['status'] eq 1">checked="checked"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$bank['status'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="status" value="0" <if condition="$bank['status'] eq 0">checked="checked"</if> /></label></span>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>