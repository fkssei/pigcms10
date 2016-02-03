<?php
/**
 * 提醒
 * User: pigcms_21
 * Date: 2015/3/3
 * Time: 14:41
 */
ini_set('error_log', 'd:/workspace/weidian/logs/php_error.log');
define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';

// 参数获得
$order_id = $_GET['order_id'];
$type = strtolower($_GET['type']);
$appid = $_GET['appid'];
$auth_key = $_GET['auth_key'];

$type_arr = array('cancel', 'alert');
if (!in_array($type, $type_arr)) {
	echo 'no_type';
	exit;
}

if (empty($appid)) {
	echo 'no_auth';
	exit;
}

// 通知的app参数
$notify_appid = option('config.notify_appid');
$notify_key = option('config.notify_appkey');

if ($appid != $notify_appid) {
	echo 'auth appid error';
	exit;
}
import('source.class.Notify');
// md5进行验证
$data = array();
$data['order_id'] = $order_id;
$data['type'] = $type;
$data['appid'] = $appid;
$md5 = Notify::encrypt_key($data, $notify_key);

if ($md5 != $auth_key) {
	echo 'auth error';
	exit;
}

$order_model = M('Order');
// 查找订单
$order = $order_model->find($order_id);

if (empty($order)) {
	echo 'no_order';
	exit;
}

if ($order['status'] > 1) {
	echo 'type_error';
	exit;
}

// 更改订单状态
if ($type == 'cancel') {
	$order_model->cancelOrder($order, 0);
	echo 'ok';
	exit;
}

if ($type == 'alert') {
	Notify::alert('尊敬的会员' . $order['address_user'] . '您好，您的订单号：' . $order_id . '未付款，请及时付款');
}
