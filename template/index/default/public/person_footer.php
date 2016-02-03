</div>
</div>
<div class="footer1 js-preson-footer " style="border-bottom:none; background:none; clear:both;">
	<div class="footer_txt">
		<?php 
		if ($flink_list) {
		?>
			<div class="footer_list" style="text-align:center;">
				<ul style="text-align:center;">
					<?php 
					foreach ($flink_list as $key => $flink) {
					?>
						<li>
							<?php
							if ($key != 0) {
							?>
								<span>|</span>
							<?php
							}
							?>
							<a href="<?php echo $flink['url'] ?>" target="_blank"><?php echo $flink['name'] ?></a>
						</li>
					<?php
					}
					?>
				</ul>
			</div>
		<?php 
		}
		?>
		<div class="footer_txt">
			<?php echo $config['site_footer'] ?><?php echo $config['site_icp'] ?>
		</div>
	</div>
</div>

<script type="text/javascript">

//延迟加载图片
		$(function(){
			//$("img.lazy").show().lazyload();

			$.get("/index.php?c=index&a=user", function (data) {
				try {
					if (data.status == true) {

						var login_info = '<li>Hi，<a href="<?php echo url('account:index') ?>" class="header_login_cur"><em>' + data.data.nickname + '</em></a></li>';
						login_info += '<li><a target="_top" href="index.php?c=account&a=logout" class="sn-register">退出</a></li>';


						$("#login-info").html(login_info);

						$("#header_cart_number").html(data.data.cart_number);
						$(".mui-mbar-tab-sup-bd").html(data.data.cart_number);
					}
				} catch (e) {

				}
			}, "json");
			

	$('#edit_password').ajaxForm({
		beforeSubmit: showRequest,
		success: showResponse,
		dataType: 'json'
	});

	$("#old_password").focus();

   
	function showRequest() {
		var old_password = $("#old_password").val();
		var password1 = $("#password1").val();
		var password2 = $("#password2").val();

		if (old_password.length == 0) {
			tusi('原密码没有填写');
			$("#old_password").focus();
			return false;
		}

		if (password1.length == 0) {
			tusi('新密码没有填写');
			$("#password1").focus();
			return false;
		}

		if (password2.length == 0) {
			tusi('确认新密码没有填写');
			$("#password2").focus();
			return false;
		}

		if (password1 != password2) {
			tusi('两次新密码不一致');
			$("#password1").focus();
			return false;
		}

		return true;
	}
		})
		
		$("#pages a").click(function () {
		var page = $(this).attr("data-page-num");
		location.href = "<?php echo url('account:order') ?>&page=" + page;
	});
		
		
</script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/common.js"></script>
</body></html>