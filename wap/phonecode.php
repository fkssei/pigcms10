<?php
//狗扑源码社区 www.gope.cn
require_once dirname(__FILE__) . '/global.php';

if (IS_POST) {
	if (!in_array($_POST['type'], array('reg'))) {
		json_return(1000, '非法请求');
	}

	$_SESSION['wap_' . $_POST['type'] . '_code'] = 123456;
	json_return(0, $config['register_phone_again_time']);
}

?>
