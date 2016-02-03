<?php
	define('PIGCMS_PATH', dirname(__FILE__).'/');
	require_once PIGCMS_PATH.'source/init.php';
	
	if(check_plugin($_GET['plugin'])){
		if(!empty($_GET['do_plugin_file'])){
			include PIGCMS_PATH.'source/plugins/'.$_GET['plugin'].'/'.$_GET['plugin'].'_'.$_GET['do_plugin_file'].'.php';
		}else{
			include PIGCMS_PATH.'source/plugins/'.$_GET['plugin'].'/'.$_GET['plugin'].'.php';
		}
	}else{
		pigcms_tips('站点未开启插件： <b>'.$_GET['plugin'].'</b>');
	}

	echo ob_get_clean();
?>