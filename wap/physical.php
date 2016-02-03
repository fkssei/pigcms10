<?php
//狗扑源码社区 www.gope.cn
require_once dirname(__FILE__) . '/global.php';
$store_id = (isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误', 'none'));
$now_store = M('Store')->wap_getStore($store_id);

if (empty($now_store)) {
	pigcms_tips('您访问的店铺不存在', 'none');
}

setcookie('wap_store_id', $now_store['store_id'], $_SERVER['REQUEST_TIME'] + 10000000, '/');
$now_url = $config['wap_site_url'] . '/physical.php?id=' . $now_store['store_id'];
$store_physical = M('Store_physical')->getList($now_store['store_id']);
include display('physical');
echo ob_get_clean();

?>
