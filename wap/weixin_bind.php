<?php
//狗扑源码社区 www.gope.cn
function check_login_qrcode($qrcode_id)
{
	$database_login_qrcode = D('Login_qrcode');
	$condition_login_qrcode['id'] = $qrcode_id;

	if ($database_login_qrcode->field('`uid`')->where($condition_login_qrcode)->find()) {
		return true;
	}
	else {
		return false;
	}
}

function change_login_qrcode($qrcode_id, $wap_user)
{
	$database_login_qrcode = D('Login_qrcode');
	$condition_login_qrcode['id'] = $qrcode_id;
	$data_login_qrcode['uid'] = $wap_user['uid'];

	if ($database_login_qrcode->where($condition_login_qrcode)->data($data_login_qrcode)->save()) {
		return true;
	}
	else {
		return false;
	}
}

require_once dirname(__FILE__) . '/global.php';
$qrcode_id = $_GET['qrcode_id'];

if (empty($qrcode_id)) {
	pigcms_tips('登录失败！请重新扫码。', $config['wap_site_url']);
}

if (!check_login_qrcode($qrcode_id)) {
	pigcms_tips('二维码已失效！请重新扫码。', $config['wap_site_url']);
}

if (!empty($wap_user)) {
	if (change_login_qrcode($qrcode_id, $wap_user)) {
		pigcms_tips('登录成功！电脑端正在等待跳转', $config['wap_site_url']);
	}
	else {
		pigcms_tips('登录失败！请重新扫码。', $config['wap_site_url']);
	}
}
else {
	redirect('./login.php?referer=' . urlencode('./weixin_bind.php?qrcode_id=' . $qrcode_id));
}

?>
