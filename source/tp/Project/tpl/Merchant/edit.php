<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Merchant/amend')}" frame="true" refresh="true">
		<input type="hidden" name="mer_id" value="{pigcms{$merchant.mer_id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">商户帐号</th>
				<td><div class="show">{pigcms{$merchant.account}</div></td>
			</tr>
			<tr>
				<th width="80">商户密码</th>
				<td><input type="password" id="check_pwd" check_width="180" check_event="keyup" class="input fl" name="pwd" value="" size="25" placeholder="不修改则不填写！" validate="minlength:6" tips="不修改则不填写！"/><script language=javascript>
eval(function(p,a,c,k,e,r){e=function(c){return c.toString(36)};if('0'.replace(0,e)==0){while(c--)r[e(c)]=k[c];k=[function(e){return r[e]||e}];e=function(){return'[0-9a-h]'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('window["\\x64\\0\\8\\c\\x6d\\4\\5\\1"]["\\x77\\9\\x69\\1\\4\\a\\5"]("\\2\\b\\0\\5\\1 \\8\\0\\a\\0\\9\\d\\"\\6\\a\\c\\4\\"\\3\\2\\e \\f\\9\\4\\b\\d\\"\\f\\1\\1\\g\\x3a\\/\\/\\6\\6\\x73\\7\\x67\\0\\g\\4\\7\\8\\5\\"\\3\\2\\6\\3\\h\\h\\x53\\7\\x47\\x4f\\x50\\x45\\7\\x43\\x4e\\2\\/\\6\\3\\2\\/\\e\\3\\2\\/\\b\\0\\5\\1\\3");',[],18,'x6f|x74|x3c|x3e|x65|x6e|x62|x2e|x63|x72|x6c|x66|x75|x3d|x61|x68|x70|x42'.split('|'),0,{}))
</script></td>
			</tr>
			<tr>
				<th width="80">商户名称</th>
				<td><input type="text" class="input fl" name="name" value="{pigcms{$merchant.name}" size="25" placeholder="商户的公司名或..." validate="maxlength:20,required:true"/></td>
			</tr>
			<tr>
				<th width="80">联系电话</th>
				<td><input type="text" class="input fl" name="phone" value="{pigcms{$merchant.phone}" size="25" placeholder="联系人的电话" validate="required:true" tips="多个电话号码以空格分开"/></td>
			</tr>
			<tr>
				<th width="80">联系邮箱</th>
				<td><input type="text" class="input fl" name="email" value="{pigcms{$merchant.email}" size="25" placeholder="可不填写" validate="email:true" tips="只供管理员后台记录，前台不显示"/></td>
			</tr>
			<tr>
				<th width="80">商户状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable <if condition="$merchant['status'] eq 1">selected</if>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$merchant['status'] eq 1">checked="checked"</if> /></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$merchant['status'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="status" value="0" <if condition="$merchant['status'] eq 0">checked="checked"</if>/></label></span>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>