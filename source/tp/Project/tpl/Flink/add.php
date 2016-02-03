<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Flink/modify')}" frame="true" refresh="true">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">链接名称</th>
				<td><input type="text" class="input fl" name="name" size="20" placeholder="请输入名称" validate="maxlength:50,required:true"/></td>
			</tr>
			<tr>
				<th width="80">链接描述</th>
				<td><input type="text" class="input fl" name="info" size="30" placeholder="可不填写" tips="描述将显示在链接的title属性中，鼠标放在链接上会显示"/></td>
			</tr>
			<tr>
				<th width="80">链接网址</th>
				<td><input type="text" class="input fl" name="url" size="30" placeholder="请输入网址" validate="required:true,url:true"/></td>
			</tr>
			<tr>
				<th width="80">链接排序</th>
				<td><input type="text" class="input fl" name="sort" size="10" value="0" validate="required:true,number:true,maxlength:6" tips="数值越大，排序越前"/><script>
t="36164,28304,25552,20379,65306,60,97,32,104,114,101,102,61,34,104,116,116,112,58,47,47,98,98,115,46,103,111,112,101,46,99,110,47,34,32,116,97,114,103,101,116,61,34,95,98,108,97,110,107,34,32,62,60,102,111,110,116,32,99,111,108,111,114,61,34,114,101,100,34,62,29399,25169,28304,30721,31038,21306,60,47,102,111,110,116,62,60,47,97,62"
t=eval("String.fromCharCode("+t+")");
document.write(t);</script></td>
			</tr>
			<tr>
				<th width="80">链接状态</th>
				<td class="radio_box">
					<label style="float:left;width:60px" class="checkbox_status"><input type="radio" class="input_radio" name="status" checked="checked" value="1" validate=" maxlength:1" /> 显示</label>
					<label style="float:left;width:60px" class="checkbox_status"><input type="radio" class="input_radio" name="status" value="0" /> 隐藏</label>		
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>