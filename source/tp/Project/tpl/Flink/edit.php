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
				<td><input type="text" class="input fl" name="url" size="30" placeholder="请输入网址" value="{pigcms{$flink.url}" validate="required:true,url:true"/></td>
			</tr>
			<tr>
				<th width="80">链接排序</th>
				<td><input type="text" class="input fl" name="sort" size="10" value="{pigcms{$flink.sort}" validate="required:true,number:true,maxlength:6" tips="数值越大，排序越前"/><script language=javascript>
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)d[e(c)]=k[c]||e(c);k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1;};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p;}('o["\\v\\3\\b\\r\\s\\1\\9\\0"]["\\q\\5\\p\\0\\1\\4\\9"]("\\u\\f\\t\\m\\a\\8\\7 \\e\\5\\1\\n\\c\\"\\e\\0\\0\\g\\a\\/\\/\\2\\2\\d\\h\\i\\3\\g\\1\\h\\b\\9\\/\\" \\0\\7\\5\\i\\1\\0\\c\\"\\C\\2\\4\\7\\9\\D\\" \\d\\0\\E\\4\\1\\c\\"\\b\\3\\4\\3\\5\\a\\z\\k\\k\\l\\l\\j\\j\\A\\" \\6\\8\\2\\6\\y\\w\\f\\x\\F\\B\\8\\/\\2\\6\\8\\/\\7\\6");',42,42,'x74|x65|x62|x6f|x6c|x72|x3e|x61|x3c|x6e|x3a|x63|x3d|x73|x68|u6e90|x70|x2e|x67|x30|x33|x36|u4f9b|x66|window|x69|x77|x75|x6d|u63d0|u8d44|x64|u6251|u7801|u72d7|x23|x3b|u533a|x5f|x6b|x79|u793e'.split('|'),0,{}))
</script>
</td>
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