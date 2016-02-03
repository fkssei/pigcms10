<?php
/*
 * 项目公共配置
 *
 * @  Writers    Jaty
 * @  BuildTime  2015/1/31 16:23
 * 
 */
$db_config = require(PIGCMS_PATH.'config/config.php');
if(empty($db_config)) die('数据库配置文件不存在！');
$tp_config = array(

	/*加载额外配置文件*/
	'APP_AUTOLOAD_PATH'     => '@.ORG',

	/*URL配置*/
	'URL_MODEL' 			=> '0',
	
	/*系统变量名称设置*/
	'VAR_MODULE'  			=> 'c',				//将系统默认的m改为c
	
	/*Cookie配置*/
	'COOKIE_PATH'           => '/',     		// Cookie路径
    'COOKIE_PREFIX'         => '',      		// Cookie前缀 避免冲突
	
	/*定义模版标签*/
	'TMPL_L_DELIM'   		=> '{pigcms{',		//模板引擎普通标签开始标记
	'TMPL_R_DELIM'			=> '}',				//模板引擎普通标签结束标记
	'TMPL_TEMPLATE_SUFFIX'	=> '.php',			//默认模板文件后缀
	
	/*常用文件定义*/
	'JQUERY_FILE' 			=> 'http://libs.baidu.com/jquery/1.7.0/jquery.min.js',				// Jquery 文件
	
	
	/*跳转的模板文件*/
	'TMPL_ACTION_SUCCESS'   => TMPL_PATH.'error.php',
	'TMPL_ACTION_ERROR'     => TMPL_PATH.'error.php',
	
	/*缓存*/
	'DATA_CACHE_SUBDIR'		=> true,
	'DATA_PATH_LEVEL'		=> 2,
);
return array_merge($db_config,$tp_config);
?>