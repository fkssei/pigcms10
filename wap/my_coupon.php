<?php
/**
 *  您拥有的优惠券
 */
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user))  {
	redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}


function shows() {
	$store_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
	//店铺资料
	$now_store = M('Store')->wap_getStore($store_id);
	if(empty($now_store)) {
		pigcms_tips('您访问的店铺不存在','none');
	}

	$action = isset($_GET['action']) ? $_GET['action'] :'all';

	$orderList = array();
	include display('my_coupon');
	echo ob_get_clean();
}


//ajax 获取数据并分页
function get_usercoupon_list($wap_user) {

	$page = $_POST['page'] ? $_POST['page']:'1';
	$type = $_REQUEST['type'];
	$time = time();

	//$type = 'used';
	$type_arr = array('all', 'used', 'unused');
	if (!in_array($type, $type_arr)) {
		$type = 'all';
	}

	$where = array();
	switch($type) {
		case 'unused':
			$where['is_use'] = 0;
			$where['end_time'] = array('>',$time);
			break;

		case 'used':
			$where['is_use'] = 1;
			break;

		case 'expired':
			$where['is_use'] = 0;
			$where['end_time'] = array('<', $time);
			break;

		default:

			break;

	}
	$where['delete_flg'] = '0';
	$where['uid'] = $wap_user['uid'];

	if($page == 1){
		$json_return['count'] = D('User_coupon')->where($where)->count('id');
	}
	//$order_by = "";
	$limit = 10;
	$offset = ($page - 1) * $limit;
	$order_by='';
	$coupon_list = M('User_coupon')->getList($where, $order_by, $limit, $offset);

	$store_id_list = array();
	foreach ($coupon_list as $coupon) {
		$store_id_list[$coupon['store_id']] = $coupon['store_id'];
	}
	$store_list = M('Store')->getStoreName($store_id_list);
	$json_return['list'] = $coupon_list;

	if(count($json_return['list']) < 10){
		$json_return['noNextPage'] = true;
	}

	json_return(0, $json_return);

}


/********************控制*************************/
$action = isset($_GET['action']) ? $_GET['action']:'';
//dump($wap_user);
	switch($action){
	case 'get_usercoupon_list':
		get_usercoupon_list($wap_user);
		break;

	default:
		shows();
		break;

}

echo ob_get_clean();
?>