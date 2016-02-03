<?php
//狗扑源码社区 www.gope.cn
require_once dirname(__FILE__) . '/global.php';

if (empty($wap_user)) {
	redirect('./login.php');
}

$store_id = (isset($_COOKIE['wap_store_id']) ? $_COOKIE['wap_store_id'] : pigcms_tips('您输入的网址有误', 'none'));
$now_store = M('Store')->wap_getStore($store_id);

if (empty($now_store)) {
	pigcms_tips('您访问的店铺不存在', 'none');
}

$action = (isset($_GET['action']) ? $_GET['action'] : 'all');
$orderList = array();
include display('coupon');
echo ob_get_clean();

?>
