<?php
header("Content-type: text/html; charset=utf-8");
define('PIGCMS_PATH', dirname(__FILE__).'/');
if(get_magic_quotes_gpc()){
	function stripslashes_deep($value){
		$value = is_array($value) ? array_map('stripslashes_deep',$value) : stripslashes($value);
		return $value;
	}
	$_POST = array_map('stripslashes_deep',$_POST);
	$_GET = array_map('stripslashes_deep',$_GET);
	$_COOKIE = array_map('stripslashes_deep',$_COOKIE);
}

define('APP_NAME','Project');	//项目名称
define('APP_PATH',PIGCMS_PATH.'source/tp/Project/');	//项目目录
define('CONF_PATH',PIGCMS_PATH.'source/tp/Project/conf/');	//配置文件地址
define('RUNTIME_PATH',PIGCMS_PATH.'cache/admin_runtime/');	//缓存文件地址
define('TMPL_PATH',APP_PATH.'tpl/');	//模板目录
define('APP_DEBUG',true);	//开启DEBUG
define('MEMORY_LIMIT_ON',function_exists('memory_get_usage'));

$runtime = '~runtime.php';
define('RUNTIME_FILE',RUNTIME_PATH.$runtime);
if(!APP_DEBUG && is_file(RUNTIME_FILE)){
    require RUNTIME_FILE;
}else{
    define('THINK_PATH', PIGCMS_PATH.'source/tp/');
    require THINK_PATH.'Common/runtime.php';
}
?>