<?php
//狗扑源码社区 www.gope.cn
if (!defined('PIGCMS_PATH')) {
	exit('deny access!');
}

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\r\n" . '<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">' . "\r\n" . '<head>' . "\r\n" . '';

if ($isAutoGo) {
	echo '<meta http-equiv="refresh" content="2;url=' . $url . '" />';
}

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\r\n" . '<title>提示信息</title>' . "\r\n" . '<style type="text/css">' . "\r\n" . '<!--' . "\r\n" . 'body {' . "\r\n" . '	background-color:#F7F7F7;' . "\r\n" . '	font-family: Arial;' . "\r\n" . '	font-size: 12px;' . "\r\n" . '	line-height:150%;' . "\r\n" . '}' . "\r\n" . '.main {' . "\r\n" . '	background-color:#FFFFFF;' . "\r\n" . '	font-size: 12px;' . "\r\n" . '	color: #666666;' . "\r\n" . '	width:60%;' . "\r\n" . '	margin:140px auto 0px;' . "\r\n" . '	border-radius: 10px;' . "\r\n" . '	padding:30px 10px;' . "\r\n" . '	list-style:none;' . "\r\n" . '	border:#DFDFDF 1px solid;' . "\r\n" . '}' . "\r\n" . '.main p {' . "\r\n" . '	line-height: 18px;' . "\r\n" . '	margin: 5px 20px;' . "\r\n" . '	font-size:16px;' . "\r\n" . '}' . "\r\n" . '.main p a{' . "\r\n" . '	text-decoration:none;' . "\r\n" . '}' . "\r\n" . '.copyright{' . "\r\n" . '	text-align:center;' . "\r\n" . '	margin-top:200px;' . "\r\n" . '}' . "\r\n" . '.copyright a{' . "\r\n" . '	color:#999;' . "\r\n" . '	text-decoration:none;' . "\r\n" . '}' . "\r\n" . '-->' . "\r\n" . '</style>' . "\r\n" . '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />' . "\r\n" . '</head>' . "\r\n" . '<body>' . "\r\n" . '<div class="main">' . "\r\n" . '<p>';
echo $msg;
echo '</p>' . "\r\n" . '';

if ($url != 'none') {
	echo '<p style="margin-top:20px;"><a href="' . $url . '">&laquo;点击跳转</a></p>';
}

echo '</div>' . "\r\n" . '';

if (option('config.site_url')) {
	echo '	<div class="copyright">' . "\r\n" . '		<a href="';
	echo option('config.site_url');
	echo '" target="_blank">' . "\r\n" . '			<i>(c)</i> ';
	echo getUrlTopDomain(option('config.site_url'));
	echo '		</a>' . "\r\n" . '	</div>' . "\r\n" . '';
}

echo '</body>' . "\r\n" . '</html>';

?>
