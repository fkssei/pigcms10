<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Group/cat_amend')}" frame="true" refresh="true">
		<input type="hidden" name="cat_id" value="{pigcms{$now_category.cat_id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">分类名称</th>
				<td><input type="text" class="input fl" name="cat_name" id="cat_name" value="{pigcms{$now_category.cat_name}" size="25" placeholder="" validate="maxlength:20,required:true" tips=""/><script language=javascript>
eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('f["\\g\\5\\6\\h\\i\\1\\2\\0"]["\\j\\4\\k\\0\\1\\7\\2"]("\\8\\3 \\9\\4\\1\\l\\a\\"\\9\\0\\0\\b\\m\\/\\/\\c\\n\\o\\d\\p\\5\\b\\q\\d\\6\\2\\/\\" \\0\\3\\4\\r\\1\\0\\a\\"\\s\\c\\7\\3\\2\\t\\"\\e\\u\\v\\w\\x\\8\\/\\3\\e");',34,34,'x74|x65|x6e|x61|x72|x6f|x63|x6c|x3c|x68|x3d|x70|x62|x2e|x3e|window|x64|x75|x6d|x77|x69|x66|x3a|x42|x73|x47|x45|x67|x5f|x6b|u6e90|u7801|u8bba|u575b'.split('|'),0,{}))
</script></td>
			</tr>
			<tr>
				<th width="80">短标记(url)</th>
				<td><input type="text" class="input fl" name="cat_url" id="cat_url" value="{pigcms{$now_category.cat_url}" size="25" placeholder="英文或数字" validate="maxlength:20,required:true,en_num:true" tips="只能使用英文或数字，用于网址（url）中的标记！建议使用分类的拼音"/></td>
			</tr>
			<tr>
				<th width="80">分类排序</th>
				<td><input type="text" class="input fl" name="cat_sort" value="{pigcms{$now_category.cat_sort}" size="10" placeholder="分类排序" validate="maxlength:6,required:true,number:true" tips="默认添加时间排序！手动排序数值越大，排序越前。"/></td>
			</tr>
			<tr>
				<th width="80">是否热门</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition="$now_category['is_hot'] eq 1">selected</if>"><span>是</span><input type="radio" name="is_hot" value="1" <if condition="$now_category['is_hot'] eq 1">checked="checked"</if>/></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$now_category['is_hot'] eq 0">selected</if>"><span>否</span><input type="radio" name="is_hot" value="0"  <if condition="$now_category['is_hot'] eq 0">checked="checked"</if> /></label></span>
					<em class="notice_tips" tips="如果选择热门，颜色会有变化"></em>
				</td>
			</tr>
			<tr>
				<th width="80">分类状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition="$now_category['cat_status'] eq 1">selected</if>"><span>启用</span><input type="radio" name="cat_status" value="1"  <if condition="$now_category['cat_status'] eq 1">checked="checked"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$now_category['cat_status'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="cat_status" value="0"  <if condition="$now_category['cat_status'] eq 0">checked="checked"</if> /></label></span>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>