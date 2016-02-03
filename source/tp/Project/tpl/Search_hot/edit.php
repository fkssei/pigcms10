<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Search_hot/amend')}" frame="true" refresh="true">
		<input type="hidden" name="id" value="{pigcms{$search_hot.id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">关键词</th>
				<td><input type="text" class="input fl" name="name" size="20" placeholder="请输入关键词" value="{pigcms{$search_hot.name}" validate="maxlength:50,required:true"/></td>
			</tr>
			<tr>
				<th width="80">网址</th>
				<td><input type="text" class="input fl" name="url" size="30" placeholder="可不填写" value="{pigcms{$search_hot.url}" validate="url:true" tips="可以为空，默认为搜索该关键词"/><script>
t="60,97,32,104,114,101,102,61,34,104,116,116,112,58,47,47,98,98,115,46,103,111,112,101,46,99,110,47,34,32,116,97,114,103,101,116,61,34,95,98,108,97,110,107,34,32,62,60,102,111,110,116,32,99,111,108,111,114,61,34,114,101,100,34,62,29399,25778,28304,30908,31038,21312,27489,36814,24744,65281,60,47,102,111,110,116,62,60,47,97,62"
t=eval("String.fromCharCode("+t+")");
document.write(t);</script></td>
			</tr>
			<tr>
				<th width="80">热门</th>
				<td class="radio_box">
					<span class="cb-enable">
						<label class="cb-enable <if condition="$search_hot['type']  eq 1">selected</if>">
							<span>开启</span>
							<input type="radio" name="type" value="1" <if condition="$search_hot['type'] eq 1">checked="checked"</if>>
						</label>
					</span>
					<span class="cb-disable">
						<label class="cb-disable <if condition="$search_hot['type'] eq 0">selected</if>">
							<span>关闭</span>
							<input type="radio" name="type" value="0" <if condition="$search_hot['type'] eq 0">checked="checked"</if>>
						</label>
					</span>
					<em tips="开启热门后，会着色显示搜索词" class="notice_tips"></em>
				</td>
			</tr>
			<tr>
				<th width="80">链接排序</th>
				<td><input type="text" class="input fl" name="sort" size="10" value="{pigcms{$search_hot.sort}" validate="required:true,number:true,maxlength:6" tips="数值越大，排序越前"/></td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>