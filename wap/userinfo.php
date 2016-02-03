<?php
//狗扑源码社区 www.gope.cn
require_once dirname(__FILE__) . '/global.php';

if (IS_POST) {
	$action = (isset($_GET['action']) ? $_GET['action'] : 'checkPhone');

	if ($action == 'checkPhone') {
		if (empty($_POST['phone'])) {
			json_return(1000, '请输入手机号码');
		}

		$get_result = M('User')->get_user('phone', $_POST['phone']);

		if ($get_result['err_code'] != 0) {
			json_return($get_result['err_code'], $get_result['err_msg']);
		}

		if (!empty($get_result['user'])) {
			json_return(0, array('uid' => $get_result['user']['uid']));
		}
		else {
			json_return(0, array('uid' => 0));
		}
	}
}

?>
