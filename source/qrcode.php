<?php
/* 验证码页面 */

define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';

$type = isset($_GET['type']) ? $_GET['type'] : redirect($_G['config']['site_url'].'/static/images/no_qrcode.png');
$id = isset($_GET['id']) ? $_GET['id'] : redirect($_G['config']['site_url'].'/static/images/no_qrcode.png');
switch($type){
	case 'home':
		$url = $_G['config']['wap_site_url'].'/home.php?id='.$id;
		break;
	case 'page_cat':
		$url = $_G['config']['wap_site_url'].'/pagecat.php?id='.$id;
		break;
	case 'page':
		$url = $_G['config']['wap_site_url'].'/page.php?id='.$id;
		break;
	case 'good_cat':
		$url = $_G['config']['wap_site_url'].'/goodcat.php?id='.$id;
		break;
	case 'good':
		$url = $_G['config']['wap_site_url'].'/good.php?id='.$id.(isset($_GET['activity']) ? '&activity='.$_GET['activity'] : '');
		break;
	case 'ucenter':
		$url = $_G['config']['wap_site_url'].'/ucenter.php?id='.$id;
		break;
	case 'activity':
		$url = urldecode($_GET['url']);
		break;
	default:
		redirect($_G['config']['site_url'].'/static/images/no_qrcode.png');
}

$url = str_replace('&amp;', '&', $url);

import('phpqrcode');
QRcode::png(urldecode($url),false,2,7,2);
?>