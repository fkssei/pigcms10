<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$pigcms_id = isset($_GET['id']) ? $_GET['id'] : '';
$store_id = isset($_GET['store_id']) ? $_GET['store_id'] : '';

if (empty($pigcms_id) && empty($store_id)) {
	pigcms_tips('您输入的网址有误','none');
}

$store_physical = array();
if (!empty($pigcms_id)) {
	//当前门店
	$store_physical = M('Store_physical')->getOne($pigcms_id);
	if(empty($store_physical)){
		pigcms_tips('您访问的地址不存在','none');
	}
} else {
	$store_contact = M('Store_contact')->get($store_id);
	if (empty($store_contact)) {
		pigcms_tips('您访问的地址不存在','none');
	} else {
		$store_physical = $store_contact;
	}
}

//店铺资料
$now_store = M('Store')->wap_getStore($store_physical['store_id']);
if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');

if (empty($pigcms_id)) {
	$store_physical['name'] = $now_store['name'];
	$store_physical['images_arr'] = array('0' => $now_store['logo']);
}


setcookie('wap_store_id',$now_store['store_id'],$_SERVER['REQUEST_TIME']+10000000,'/');

//当前页面的地址
$now_url = $config['wap_site_url'].'/physical_detail.php?id='.$now_store['store_id'];

include display('physical_detail');

echo ob_get_clean();
?>