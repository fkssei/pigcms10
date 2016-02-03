<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css"/>
		<title>后台管理 - <?php echo ($config["site_name"]); ?></title>
		<script type="text/javascript">if(self!=top){window.top.location.href = "<?php echo U('Index/index');?>";}var selected_module="<?php echo strval($_GET['module']);?>",selected_action="<?php echo strval($_GET['action']);?>",selected_url="<?php echo urldecode(strval(htmlspecialchars_decode($_GET['url'])));?>";</script>
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/artdialog/jquery.artDialog.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/artdialog/iframeTools.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
	</head>
	<body style="background:#E2E9EA">
		<div id="header" class="header">
			<div class="logo"><a href="http://www.pigcms.com" target="_blank"><img src="<?php echo ($static_path); ?>images/logo-pigcms.png" width="180"/></a></div>
			<div class="nav f_r"><a href="<?php echo U('Index/cache');?>" target="main" style="color:red;">&#28165;&#31354;&#32531;&#23384;</a> <i>|</i> <a href="http://www.pigcms.com" target="_blank">&#23448;&#26041;&#32593;&#31449;</a> <i>|</i> <a href="http://www.pigcms.com" target="_blank">&#24110;&#21161;&#25991;&#26723;</a> &nbsp;&nbsp; &nbsp;&nbsp;</div>
			<div class="nav">&nbsp;&nbsp;&nbsp;&nbsp;&#27426;&#36814;&#24744;！<?php echo ($system_session["account"]); ?>  <i>|</i> [超级管理员]  <i>|</i> <a href="<?php echo U('Login/logout');?>" target="_top" style="color:red;">[安全退出]</a>  <i>|</i> <a href="<?php echo ($config["site_url"]); ?>" target="_blank">浏览网站</a> <i>|</i> <!--<a href="/user.php?c=store&a=select" target="_blank"><?php if(!$_SESSION['user']['stores']){?>创建官方店铺<?php }else{ ?>设置官方店铺<?php } ?></a>--> <a href="/admin.php?c=Index&a=offical_tore" target="_blank"><?php if(!$_SESSION['user']['stores']){?>&#21019;&#24314;&#23448;&#26041;&#24215;&#38138;<?php }else{ ?>&#35774;&#32622;&#23448;&#26041;&#24215;&#38138;<?php } ?></a>&nbsp; </div>
			<div class="topmenu">
				<ul>
					<?php if(is_array($system_menu)): $i = 0; $__LIST__ = $system_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['id'] != ''): ?><li><span <?php if($i == 1): ?>class="current"<?php endif; ?>><a href="javascript:void(0);" menu_id="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></a></span></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<div class="header_footer"></div>
		</div>
		<div id="Main_content">
			<div id="MainBox" >
				<div class="main_box">
					<div id="sx" onclick="main_refresh();" title="刷新框架"></div>
					<iframe name="main" id="Main" src="<?php echo U('Index/main');?>" frameborder="false" scrolling="auto"  width="100%" height="auto" allowtransparency="true"></iframe>
				</div>
			</div>
			<div id="leftMenuBox">
				<div id="leftMenu">
					<div style="padding-left:12px;_padding-left:10px;">	
						<?php if(is_array($system_menu)): $i = 0; $__LIST__ = $system_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl id="nav_<?php echo ($vo["id"]); ?>">
								<dt><?php echo ($vo["name"]); ?></dt>
								<?php if(is_array($vo['menu_list'])): $i = 0; $__LIST__ = $vo['menu_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><dd><span url="<?php echo U(ucfirst($voo['module']).'/'.$voo['action']);?>" id="leftmenu_<?php echo ucfirst($voo['module']);?>_<?php echo ($voo['action']); ?>"><?php echo ($voo["name"]); ?></span></dd><?php endforeach; endif; else: echo "" ;endif; ?>
							</dl><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
				<div id="Main_drop">
					<a  href="javascript:toggleMenu(1);" class="on"><img src="<?php echo ($static_path); ?>images/admin_barclose.gif" width="11" height="60" border="0"/></a>   
					<a  href="javascript:toggleMenu(0);" class="off" style="display:none;"><img src="<?php echo ($static_path); ?>images/admin_baropen.gif" width="11" height="60" border="0"/></a>
				</div>
			</div>
		</div>
		<div id="footer" class="footer" >技术支持：<span>吾爱源码BBS.52CODES.NET</span>
</div>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/index.js"></script>
	</body>
</html>