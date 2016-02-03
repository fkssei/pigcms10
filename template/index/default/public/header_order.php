<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<div class="header">
	<div class="header_header">
		<div class="header_top">
			<ul class="header_login">
				<li>欢迎 <?php echo $user_session['nickname'] ?></li>
				<li><a href="<?php echo url('account:logout') ?>">退出</a></li>
			</ul>
			<ul class="header_list">
				<li><a href="/account.php" class="header_list_cur">我要开店</a></li>
				<li><span>|</span></li>
				<li><a href="<?php echo url('account:order') ?>">我的订单</a></li>
				<li><span>|</span></li>
				<li><a href="###">微信版</a></li>
				<li><span>|</span></li>
				<li><a href="###">手机版</a></li>
			</ul>
		</div>
	</div>
</div>
<div class="danye_menu">
	<ul>
		<li class="danye_index"><a href="/"><img src="<?php echo option('config.pc_usercenter_logo');?>" /></a></li>
		<li class="danye_list"><a href="<?php echo url('account:index') ?>">会员首页</a></li>
		<li class="danye_list"><a href="<?php echo url('account:index') ?>">个人资料</a></li>
		<li class="fanhui"><a href="/">返回首页<span></span></a></li>
	</ul>
</div>