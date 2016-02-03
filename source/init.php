<?php
//dezend by http://www.yunlu99.com/ QQ:270656184
function pigcms_tips($msg, $url = '', $isAutoGo = false, $showCopy = true)
{
	if (IS_AJAX) {
		echo json_encode(array('msg' => $msg, 'url' => $url));
	}
	else {
		if (empty($url)) {
			$url = 'javascript:history.back(-1);';
		}

		if ($msg == '404') {
			header('HTTP/1.1 404 Not Found');
			$msg = '抱歉，你所请求的页面不存在！';
		}

		include PIGCMS_PATH . 'source/sys_tpl/tip.php';
	}

	exit();
}

function appException($e)
{
	$error = array();
	$error['message'] = $e->getMessage();
	$trace = $e->getTrace();

	if ('throw_exception' == $trace[0]['function']) {
		$error['file'] = $trace[0]['file'];
		$error['line'] = $trace[0]['line'];
	}
	else {
		$error['file'] = $e->getFile();
		$error['line'] = $e->getLine();
	}

	halt($error);
}

function appError($errno, $errstr, $errfile, $errline)
{
	switch ($errno) {
	case 1:
	case 4:
	case 16:
	case 64:
	case 256:
		ob_end_clean();

		if (DEBUG) {
			pigcms_tips($errno . '' . $errstr . ' ' . $errfile . ' 第 ' . $errline . ' 行.', 'none');
		}
		else {
			pigcms_tips($errno . '' . $errstr . ' ' . basename($errfile) . ' 第 ' . $errline . ' 行.', 'none');
		}

		break;

	case 8:
	case 2048:
		break;

	case 2048:
	case 512:
	default:
		if (DEBUG) {
			pigcms_tips($errstr . ' ' . $errfile . ' 第 ' . $errline . ' 行.', 'none');
		}
		else {
			pigcms_tips($errstr . ' ' . basename($errfile) . ' 第 ' . $errline . ' 行.', 'none');
		}

		break;
	}
}

function fatalError()
{
	if ($e = error_get_last()) {
		switch ($e['type']) {
		case 1:
		case 4:
		case 16:
		case 64:
		case 256:
			ob_end_clean();

			if (DEBUG) {
				pigcms_tips('ERROR:' . $e['message'] . ' ' . $e['file'] . ' 第' . $e['line'] . ' 行.', 'none');
			}
			else {
				pigcms_tips('ERROR:' . $e['message'] . ' ' . basename($e['file']) . ' 第' . $e['line'] . ' 行.', 'none');
			}

			break;
		}
	}
}

function require_file($load_file)
{
	if (file_exists($load_file)) {
		return require $load_file;
	}
	else {
		$file = str_replace(PIGCMS_PATH, '', $load_file);
		pigcms_tips(PIGCMS_PATH . $file . ' 文件不存在。', 'none');
	}
}

if (!defined('PIGCMS_PATH')) {
	exit('deny access!');
}

require_file(PIGCMS_PATH . 'source/class/360_safe3.php');
register_shutdown_function('fatalError');
set_error_handler('appError');
set_exception_handler('appException');
defined('DEBUG') || define('DEBUG', true);

if (DEBUG == true) {
	error_reporting(1 | 2 | 4 | 8);
}
else {
	error_reporting(0);
}

header('Content-Type: text/html; charset=UTF-8');
header('X-Powered-By:pigcms.com');
date_default_timezone_set('Asia/Shanghai');
session_name('pigcms_sessionid');
session_start();
setcookie(session_name(), session_id(), $_SERVER['REQUEST_TIME'] + 63072000, '/');
defined('GROUP_NAME') || define('GROUP_NAME', 'index');
defined('MODULE_NAME') || define('MODULE_NAME', isset($_GET['c']) ? strtolower($_GET['c']) : 'index');
defined('ACTION_NAME') || define('ACTION_NAME', isset($_GET['a']) ? strtolower($_GET['a']) : 'index');
defined('DATA_PATH') || define('DATA_PATH', PIGCMS_PATH . 'cache/data/');
defined('CACHE_PATH') || define('CACHE_PATH', PIGCMS_PATH . 'cache/cache/');
defined('USE_FRAMEWORK') || define('USE_FRAMEWORK', false);
defined('IS_SUB_DIR') || define('IS_SUB_DIR', false);
define('NOW_TIME', $_SERVER['REQUEST_TIME']);
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
define('IS_GET', REQUEST_METHOD == 'GET' ? true : false);
define('IS_POST', REQUEST_METHOD == 'POST' ? true : false);
define('IS_PUT', REQUEST_METHOD == 'PUT' ? true : false);
define('IS_DELETE', REQUEST_METHOD == 'DELETE' ? true : false);
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true : false);
define('IM_SERVER_PATH', 'http://im-link.meihua.com');
require_file(PIGCMS_PATH . 'source/functions/common.php');

foreach ($_GET as &$get_value) {
	$get_value = htmlspecialchars(str_replace(array('<', '>', '\'', '"', '(', ')'), '', $get_value));
}

doStripslashes();
$_G['system'] = require_file(PIGCMS_PATH . 'config/config.php');
$config = F('config');

if (empty($config)) {
	$configs = D('Config')->field('`name`,`value`')->select();

	foreach ($configs as $key => $value) {
		$config[$value['name']] = $value['value'];
	}

	F('config', $config);
}

$_G['config'] = $config;
defined('TPL_PATH') || define('TPL_PATH', PIGCMS_PATH . 'template/');
defined('TPL_URL') || define('TPL_URL', !IS_SUB_DIR ? $config['site_url'] . '/template/' . GROUP_NAME . '/' . $_G['config']['theme_' . GROUP_NAME . '_group'] . '/' : $config['site_url'] . '/template/' . GROUP_NAME . '/' . $config['theme_' . GROUP_NAME . '_group'] . '/');
$_G['plugins'] = array();

if (!empty($_G['config']['active_plugins'])) {
	$active_plugins = json_decode($_G['config']['active_plugins'], true);

	if (is_array($active_plugins)) {
		foreach ($active_plugins as $plugin) {
			if (check_plugin($plugin) === true) {
				$_G['plugins'][$plugin] = true;
			}
		}
	}
}

if (USE_FRAMEWORK == true) {
	R(GROUP_NAME, MODULE_NAME, ACTION_NAME);
	echo ob_get_clean();
}

?>
