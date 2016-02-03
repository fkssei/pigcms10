<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Merchant/modify')}" frame="true" refresh="true">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">商户帐号</th>
				<td><input type="text" class="input fl" name="account" size="25" placeholder="商户平台的帐号" validate="maxlength:20,required:true" tips="设定之后，以后不能再修改！"/></td>
			</tr>
			<tr>
				<th width="80">商户密码</th>
				<td><input type="password" id="check_pwd" check_width="180" class="input fl" name="pwd" size="25" placeholder="商户平台的密码" validate="required:true,minlength:6" tips="商户的密码很重要，填写难度较强的密码有效保护商户的信息，也可以保护网站的数据安全。"/></td>
			</tr>
			<tr>
				<th width="80">商户名称</th>
				<td><input type="text" class="input fl" name="name" size="25" placeholder="商户的公司名或..." validate="maxlength:20,required:true"/></td>
			</tr>
			<tr>
				<th width="80">联系电话</th>
				<td><input type="text" class="input fl" name="phone" size="25" placeholder="联系人的电话" validate="required:true" tips="多个电话号码以空格分开"/></td>
			</tr>
			<tr>
				<th width="80">联系邮箱</th>
				<td><input type="text" class="input fl" name="email" size="25" placeholder="可不填写" validate="email:true" tips="只供管理员后台记录，前台不显示"/></td>
			</tr>
			<tr>
				<th width="80">商户状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable selected"><span>启用</span><input type="radio" name="status" value="1" checked="checked" /></label></span>
					<span class="cb-disable"><label class="cb-disable"><span>关闭</span><input type="radio" name="status" value="0" /></label></span>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>