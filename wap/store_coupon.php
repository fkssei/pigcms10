<?php
/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/06/29
 * Time: 16:23
 * descrption: 店铺优惠券
 */
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user))  {
	redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}


function shows($store_id) {
	$store_id = isset($store_id) ? $store_id : pigcms_tips('您输入的网址有误','none');
	//店铺资料
	$now_store = M('Store')->wap_getStore($store_id);
	if(empty($now_store)) {
		pigcms_tips('您访问的店铺不存在','none');
	}

	$action = isset($_GET['action']) ? $_GET['action'] :'all';

	$orderList = array();
	include display('store_coupon');
	echo ob_get_clean();
}


//ajax 领取
function user_get_coupon($wuser,$store_id) {
	$uid = $wuser['uid'];

	if (empty($uid)) {
		echo json_encode(array('status' => false, 'msg' => '请先登录','data' => array('error' => 'login')));
	}
	$id = $_GET['couponid'];
	$time = time();


	if (empty($id)) {
		json_return('1001','缺少最基本的参数');
	}

	$coupon = D('Coupon')->where(array('id' => $id))->find();
	//查看是否已经领取

	if ($coupon['total_amount'] <= $coupon['number']) {
		json_return('1002','该优惠券已经全部发放完了');
	}

	if ($coupon['status'] == '0') {
		json_return('1003','该优惠券已失效!');
	}

	if ($time > $coupon['end_time'] || $time < $coupon['start_time']) {
		json_return('1004','该优惠券未开始或已结束!');
	}

	if ($coupon['type'] == '2') {
		json_return('1005','不可领取赠送券!');
	}

	$user_coupon = D('User_coupon')->where(array('uid' => $uid, 'coupon_id' => $id))->field("count(id) as count")->find();

	//查看当前用户是否达到最大领取限度
	if ($coupon['most_have'] != '0') {
		if ($user_coupon['count'] >= $coupon['most_have']) {
			json_return('1006','您已达到该优惠券允许的最大单人领取限额!');
		}
	}
	//领取
	if(M('User_coupon')->add($uid,$coupon)){
		//修改优惠券领取信息
		unset($where);unset($data);

		$where = array('id'=>$id);
		D('Coupon')->where($where)->setInc('number',1);
		json_return('0','领取成功!');
	} else{
		json_return('1111','领取失败!');
	}

}

//ajax 获取数据并分页
function get_usercoupon_list($wap_user,$store_id) {
	$store_id = isset($store_id) ? $store_id : pigcms_tips('您输入的网址有误','none');
	$page = $_POST['page'] ? $_POST['page']:'1';
	$type = $_REQUEST['type'];
	$time = time();

	//$type = 'used';
	$type_arr = array('all', 'used', 'unused');
	if (!in_array($type, $type_arr)) {
		$type = 'all';
	}

	$where = array();



	//$where['uid'] = $wap_user['uid'];
	$where['store_id'] = $store_id;
	$where['status'] = 1;
	$where['type'] = 1;
	$where['total_amount'] = array('>',number);
	$where['start_time'] = array('<',$time);
	$where['end_time'] = array('>',$time);

	if($page == 1){
		$json_return['count'] = D('Coupon')->where($where)->count('id');
	}
	//$order_by = "";
	$limit = 10;
	$offset = ($page - 1) * $limit;
	$order_by='';
	$coupon_list = M('Coupon')->getList($where, $order_by, $limit, $offset);

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
$store_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
//dump($wap_user);
switch($action){
	case 'get_usercoupon_list':
		get_usercoupon_list($wap_user,$store_id);
		break;

	case 'user_get_coupon':    //ajax用户领取优惠券
		user_get_coupon($wap_user,$store_id);
		break;

	default:
		shows($store_id);
		break;

}

echo ob_get_clean();
?>