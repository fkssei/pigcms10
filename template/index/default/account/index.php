<?php include display( 'public:person_header');?>
<script>
    $(document).ready(function () {
    	$('#profile').ajaxForm({
    		beforeSubmit: showRequest,
    		success: showResponse,
    		dataType: 'json'
    	});

    });

   
	function showRequest() {
		var nickname = $("#nickname").val();

		if (nickname.length == 0) {
			tusi("请填写昵称");
			$("#nickname").focus();
			return false;
		}

		return true;
	}
    </script>
<!------------个人资料-------------->

<div class="danye_content_title">
	<div class="danye_suoyou"><a href="###"><span>个人资料</span></a></div>
</div>
<div id="tabChangeBox" class="common_div">
	<form name="editForm" id="profile" method="post" enctype="multipart/form-data" action="">
	<div id="J_editFormPane" class="kd-edit-form">
		<input type="hidden" name="nickname" id="nickname" value="<?php echo $user['nickname']; ?>" />
		<input type="hidden" name="intro" id="intro" value="<?php echo $user['intro']; ?>" />
		<div class="common-w1 user_message">
			<div class="user" id="avatar_area">
				<div class="u-icon picture">
					<div style="display: none;" class="hide" id="modifyheader">
						<div class="upper fore" id="modUserImgbox"></div>
						<a class="fore" href="###" target="_blank">修改头像</a> </div>
					<img alt="用户头像"  src="<?php if (!empty($user['avatar'])) { ?><?php echo getAttachmentUrl($user['avatar']) ?><?php } else { ?><?php echo TPL_URL;?>/images/avatar.png<?php } ?>" id="userImg"> </div>
			</div>
			<div  class="pr" style="position: absolute;right: 170px;top: 120px;width: 260px;">
                                            <input type="file" name="file" value="" style="border:none" /><br/>
                                            <p class="mt20">图片尺寸请大于300x300像素，大小小于 1M</p>
                                            <p>JPG、JPEG、GIF、PNG文件格式</p>
                                        </div>
			<table class="form-table3" cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td colspan="2" class="tit">联系方式</td>
					</tr>
					<tr>
						<td width="72"><label> <span class="red">*</span> 手机号： </label></td>
						<td width="500"><span id="tel_old"><?php echo $user['phone'] ?></span>&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" class="tit pt10">个人信息</td>
					</tr>
					<tr>
						<td><label>昵称：</label></td>
						<td>
							<span class="td_nickname">
								<p id="nick_show" class="show_item"> 
								<span><?php echo $user['nickname'] ?></span>
								&nbsp;&nbsp; 
								<a href="JavaScript:void(0);" class="change_detail_edit cgreen" onclicks="change_input(this,true,'nikename')"   >修改</a>
								 <span class="grey">个性昵称</span> &nbsp;&nbsp; <span class="grey"></span> </p>
							 
							 </span>
							 <span class="td_nickname" style="display:none">
							 	<input type="text" id="td_nickname_input"  /><a id="modtel" class="cgreen" href="javascript:void(0)">完成</a>
							 </span>
							 
							 
						</td>
					</tr>
					<tr>
						<td><label>个性签名：</label></td>
						<td><p id="postcode_show" class="show_item2"><span><?php echo $user['intro']; ?></span> <a href="JavaScript:void(0);" class="change_detail cgreen" >修改</a> <span class="grey"></span> &nbsp;&nbsp; <span class="grey"></span> </p> <span class="show_item2" style="display:none">
							 	<input type="text" id="postcode_show_input"  /><a class="cgreen" href="javascript:void(0)">完成</a>
							 </span></td>
						
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td height="36"><div id="J_editError" class="kd-form-error"></div>
                                    <input id="editValidate" class="orangeBtn large" type="submit" value="保存设置">
                                    <input type="hidden" name="isSubmit" value="true"></td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
	</form>
</div>
<script type="text/javascript">
			$(".change_detail_edit").click(function(){
				$(".td_nickname").hide().eq(1).show();
				var values = $("#nick_show").find('span').html();
				$('#td_nickname_input').val(values);
				$('#td_nickname_input').focus();
			})
	
			
		//显示修改	
		$(".td_nickname #modtel").live("click",function(){
			$(".td_nickname").hide().eq(0).show();
			var values = $("#nick_show").find('span').html();
			$("#nick_show span").eq(0).html(values);
			
			
		})
		$(".td_nickname #td_nickname_input").live("blur",function(){
			$(".td_nickname").hide().eq(0).show();
			var values = $("#td_nickname_input").val();
			$("#nick_show span").eq(0).html(values);
			$('#td_nickname_input').focus();
			$('#nickname').val(values);
			
		});
		
		$('.change_detail').click(function(){
			$(".show_item2").hide().eq(1).show();
			var values=$('#postcode_show span').eq(0).html();
			$('#postcode_show_input').val(values);
			$('#postcode_show_input').focus();
		});
		
		$('#postcode_show_input').blur(function(){
			var value=$('#postcode_show_input').val();
			$(".show_item2").hide().eq(0).show();
			$('#postcode_show span').eq(0).html(value);

			$('#intro').val(value);
		});

		
						
					</script> 
<!------------个人资料-------------------->
<?php include display( 'public:person_footer');?>