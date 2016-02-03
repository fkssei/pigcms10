<?php include display( 'public:person_header');?>
<div id="con_one_4">
	<div class="danye_content_title">
		<div class="danye_suoyou"><a href="###"><span>修改密码</span></a></div>
	</div>
	<div class="common_div">
		<form id="edit_password" method="post" name="edit_password">
			<table cellspacing="0" cellpadding="0" border="0" class="form-table">
				<tbody>
					<tr>
						<td width="85" align="right" for="password">当前密码：</td>
						<td>
						<input type="password" class="txt-m txt-grey" name="old_password" id="old_password" tabindex="1" placeholder="请输入当前使用密码" style="color: rgb(102, 102, 102);">
						</td>
						
					</tr>
					<tr>
						<td height="50" align="right">新密码：</td>
						<td height="50"><input type="password" class="txt-m" style="ime-mode:disabled;" name="password1" tabindex="2" id="password1" maxlength="16"></td>
						<td height="50"><div id="password-tip" class="input-tip err">
								<!--<div class="input-tip-inner err" style="display: block;"><span></span>
									<p>请输入密码</p>
								</div>-->
							</div>
							
							<!-- <div id="password-strength"><div id="password-strength-inner"></div></div><span id="rating-msg"></span></div> -->
							
							<div id="pass_tip" class="pass_tip"> <span class="page_icon icon_pass_tip"><i></i>如何设置安全密码</span>
								<div class="icon_pass_tip_con">建议采用数字和字母混合<br>
									避免使用有规律的数字和字母<br>
									避免与账户名、手机号、生日等部分或完全相同 <span class="z">◆</span> <span class="y">◆</span> </div>
							</div></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2"><div class="password-state" id="password-state"> 
								<!-- <div class="input-tip-inner"><span class="reg_mes mes_pass_in"></span></div> -->
								<div class="password-state-inner txt-grey"><span>由字母、数字或符号组成的6-16位半角字符，区分大小写</span></div>
							</div></td>
					</tr>
					<tr>
						<td align="right">确认密码：</td>
						<td><input type="password" class="txt-m txt-grey" id="password2" name="password2" tabindex="3" placeholder="请再次输入新密码" style="color: rgb(102, 102, 102);"></td>
						<!--<td><div id="passwordagain-tip" class="input-tip err">
								<div class="input-tip-inner" style="display: block;"><span></span>
									<p>请输入确认密码</p>
								</div>
							</div></td>-->
					</tr>
					<tr>
						<td></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
					<td></td>
						<td><input type="submit" class="yellow_btn mt10" value="确认">
							<span style="color:#ff6600; position:relative; top:1px; display:none;" id="tel_submit_ing">&nbsp;&nbsp;提交中 <img src="/css/images/userchangepassword/movie.gif"></span></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
<script type="text/javascript">
chk_blur('old_password','<?php echo url("account:chk_password") ?>');
chk_blur('password1','<?php echo url('account:chk_newpwd') ?>');
function chk_blur(id,url){
	$('#'+id).blur(function(){
		var passsword=$('#'+id).val();
		$.post(url,{password:passsword},function(data){
			var sHtml='';
			if(data.status){
				sHtml='<span class="success">'+data.msg+'</span>';
			}else{
				sHtml='<span class="error">'+data.msg+'</span>';
			}
			$('#'+id).parent().find('span').remove();
			$('#'+id).parent().append(sHtml);
		},'json');
	});
}


$('#password2').blur(function(){
	var new_pwd=$('#password1').val();
	var re_pwd=$(this).val();
	
	var sHtml='';
	if(new_pwd!=re_pwd){
		sHtml='<span class="error">确认密码与新密码不一致</span>';
	}else{
		sHtml='<span class="success">密码通过</span>';
	}
	
	if($(this).val().length<6||$(this).val().length>16){
		sHtml='<span class="error">密码不能小于六位或大于十六位</span>';
	}
	$(this).parent().find('span').remove();
	$(this).parent().append(sHtml);
});

</script>
<?php include display( 'public:person_footer');?>