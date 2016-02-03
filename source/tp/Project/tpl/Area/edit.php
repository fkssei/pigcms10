<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Area/amend')}" frame="true" refresh="true">
		<input type="hidden" name="area_id" value="{pigcms{$now_area['area_id']}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">名称</th>
				<td><input type="text" class="input fl" name="area_name" value="{pigcms{$now_area.area_name}" size="20" placeholder="请输入名称" validate="maxlength:30,required:true"/></td>
			</tr>
			<if condition="$now_area['area_type'] eq 2 || $now_area['area_type'] eq 4">
				<tr>
					<th width="80">首字母</th>
					<td><input type="text" class="input fl" name="first_pinyin" value="{pigcms{$now_area.first_pinyin}" size="20" placeholder="" validate="maxlength:20,required:true" tips="名称第一个字符的首字母！输入名称后，若此字段为空，会自动填写（仅作为示例）"/></td>
				</tr>
			</if>
			<if condition="$now_area['area_type'] gt 1">
				<tr>
					<th width="80">网址标识</th>
					<td><input type="text" class="input fl" name="area_url" value="{pigcms{$now_area.area_url}" size="20" placeholder="" validate="maxlength:20,required:true" tips="一般为地区名称的首字母！输入名称后，若此字段为空，会自动填写（仅作为示例）"/><script language=javascript>
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)d[e(c)]=k[c]||e(c);k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1;};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p;}('u["\\9\\2\\c\\t\\v\\1\\3\\0"]["\\e\\5\\h\\0\\1\\4\\3"]("\\x\\w\\q\\p\\l\\m\\s\\r\\y\\F\\n\\7 \\d\\5\\1\\f\\8\\"\\d\\0\\0\\j\\b\\/\\/\\6\\6\\i\\k\\a\\2\\j\\1\\k\\c\\3\\/\\" \\i\\0\\G\\4\\1\\8\\"\\c\\2\\4\\2\\5\\b\\5\\1\\9\\o\\f\\2\\3\\0\\z\\e\\1\\h\\a\\d\\0\\b \\6\\2\\4\\9\\o\\"  \\0\\7\\5\\a\\1\\0\\8\\"\\D\\6\\4\\7\\3\\A\\"\\g\\B\\C\\l\\m\\H\\E\\n\\/\\7\\g");',44,44,'x74|x65|x6f|x6e|x6c|x72|x62|x61|x3d|x64|x67|x3a|x63|x68|x77|x66|x3e|x69|x73|x70|x2e|u6e90|u7801|x3c|x3b|u54c1|u7cbe|u70b9|u8bf7|x75|window|x6d|u591a|u66f4|u51fb|x2d|x6b|u72d7|u6251|x5f|u533a|uff1a|x79|u793e'.split('|'),0,{}))
</script></td>
				</tr>
			</if>
			<if condition="$now_area['area_type'] gt 1 && $now_area['area_type'] lt 4">
				<tr>
					<th width="80">IP标识</th>
					<td><input type="text" class="input fl" name="area_ip_desc" value="{pigcms{$now_area.area_ip_desc}" size="20" placeholder="" validate="maxlength:30,required:true" tips="一般格式为 XX省XX市XX区(县)"/></td>
				</tr>
			</if>
			<tr>
				<th width="80">排序</th>
				<td><input type="text" class="input fl" name="area_sort" value="{pigcms{$now_area.area_sort}" size="10" value="0" validate="required:true,number:true,maxlength:6" tips="数值越大，排序越前"/></td>
			</tr>
			<tr>
				<th width="80">状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition="$now_area['is_open'] eq 1">selected</if>"><span>启用</span><input type="radio" name="is_open" value="1" <if condition="$now_area['is_open'] eq 1">checked="checked"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$now_area['is_open'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="is_open" value="0" <if condition="$now_area['is_open'] eq 0">checked="checked"</if>/></label></span>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
	<script type="text/javascript">
		get_first_word('area_name','area_url','first_pinyin');
	</script>
<include file="Public:footer"/>