<?php
/**
 *  支付订单
 */
require_once dirname(__FILE__).'/global.php';

$nowOrder = M('Order')->find($_GET['id']);
if(empty($nowOrder)) pigcms_tips('该订单号不存在','none');

if($nowOrder['status'] > 1 && $nowOrder['payment_method'] != 'codpay') redirect('./order.php?orderno='.$_GET['id']);
if($nowOrder['status'] > 1 && $nowOrder['payment_method'] == 'codpay') redirect('./order.php?orderid=' . $nowOrder['order_id']);

//店铺资料
$now_store = M('Store')->wap_getStore($nowOrder['store_id']);
if($nowOrder['uid'] && empty($_SESSION['wap_user'])) redirect('./login.php');

if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
setcookie('wap_store_id',$now_store['store_id'],$_SERVER['REQUEST_TIME']+10000000,'/');

// 货到付款
$offline_payment = false;
if ($now_store['offline_payment']) {
	$offline_payment = true;
}
$is_all_selfproduct = true;
$is_all_supplierproduct = true;

if($nowOrder['status'] < 1){
	//用户地址
	$userAddress = M('User_address')->find(session_id(),$wap_user['uid']);
	//上门自提
	if($now_store['buyer_selffetch']){
		$selffetch_list = array();// M('Trade_selffetch')->getListNoPage($now_store['store_id']);
		
		$store_contact = M('Store_contact')->get($now_store['store_id']);
		$store_physical = M('Store_physical')->getList($now_store['store_id']);
		if ($store_contact) {
			$data = array();
			$data['pigcms_id'] = '99999999_store';
			$data['name'] = $now_store['name'] . '';
			$data['tel'] = ($store_contact['phone1'] ? $store_contact['phone1'] . '-' : '') . $store_contact['phone2'];
			$data['province_txt'] = $store_contact['province_txt'] . '';
			$data['city_txt'] = $store_contact['city_txt'] . '';
			$data['county_txt'] = $store_contact['area_txt'] . '';
			$data['address'] = $store_contact['address'] . '';
			$data['business_hours'] = '';
			$data['logo'] = $now_store['logo'];
			$data['description'] = '';
			$data['store_id'] = $now_store['store_id'];
			$data['long'] = $store_contact['long'];
			$data['lat'] = $store_contact['lat'];
			
			$selffetch_list[] = $data;
		}
		
		if ($store_physical) {
			foreach ($store_physical as $physical) {
				$data = array();
				$data['pigcms_id'] = $physical['pigcms_id'];
				$data['name'] = $physical['name'] . '';
				$data['tel'] = ($physical['phone1'] ? $physical['phone1'] . '-' : '') . $physical['phone2'];
				$data['province_txt'] = $physical['province_txt'] . '';
				$data['city_txt'] = $physical['city_txt'] . '';
				$data['county_txt'] = $physical['county_txt'] . '';
				$data['address'] = $physical['address'] . '';
				$data['business_hours'] = $physical['business_hours'] . '';
				$data['logo'] = $physical['images_arr'][0];
				$data['description'] = $physical['description'];
				$data['long'] = $physical['long'];
				$data['lat'] = $physical['lat'];
					
				$selffetch_list[] = $data;
			}
		}
	}
	
	// 抽出可以享受的优惠信息与优惠券
	// 优惠活动
	$product_id_arr = array();
	$store_id = 0;
	$uid = 0;
	$total_price = 0;
	$product_price_arr = array();
	foreach ($nowOrder['proList'] as $product) {
		// 分销商品不参与满赠和使用优惠券
		if ($product['source_product_id'] != '0') {
			$offline_payment = false;
			$is_all_selfproduct = false;
			continue;
		} else {
			$is_all_supplierproduct = false;
		}
			
		$product_id_arr[] = $product['product_id'];
		$store_id = $product['store_id'];
		$uid = $product['uid'];
		// 单个商品总价
		$product_price_arr[$product['product_id']]['price'] = $product['pro_price'];
		// 每个商品购买数量
		$product_price_arr[$product['product_id']]['pro_num'] = $product['pro_num'];
		// 所有商品价格
		$total_price += $product['pro_price'] * $product['pro_num'];
	}
	import('source.class.Appmarket');
	
	$reward_arr = array();
	$reward_arr['product_id_arr'] = $product_id_arr;
	$reward_arr['store_id'] = $store_id;
	$reward_arr['uid'] = $uid;
	
	$product_arr = array();
	$product_arr['product_price_arr'] = $product_price_arr;
	$product_arr['total_price'] = $total_price;
	$reward_list = Appmarket::getAeward($reward_arr, $product_arr);
	// 第一步抽出用户购买的产品有哪些优惠券
	$user_coupon_list = M('User_coupon')->getListByProductId($reward_list['product_price_list'], $store_id, $uid);
	//print_r($user_coupon_list);
	// 第二步计算出用户购买原产品可以使用哪些优惠券
	$user_coupon_list = Appmarket::getCoupon($reward_list, $user_coupon_list);
}else{
	$nowOrder['address'] = unserialize($nowOrder['address']);
	$selffetch_list = true;
	// 查看满减送
	$reward_list = M('Order_reward')->getByOrderId($nowOrder['order_id']);
	// 使用优惠券
	$user_coupon = M('Order_coupon')->getByOrderId($nowOrder['order_id']);
	
	foreach ($nowOrder['proList'] as $product) {
		// 分销商品不参与满赠和使用优惠券
		if ($product['source_product_id'] != '0') {
			$is_all_selfproduct = false;
		} else {
			$is_all_supplierproduct = false;
		}
	}
}

if (!empty($nowOrder['float_amount'])) {
	$nowOrder['sub_total'] += $nowOrder['float_amount'];
	$nowOrder['sub_total'] = number_format($nowOrder['sub_total'], 2, '.', '');
}

// dump($nowOrder);
//付款方式
$payMethodList = M('Config')->get_pay_method();
$payList = array();
$useStorePay = false;
$storeOpenid = '';
if($is_weixin && $_SESSION['openid']){
	// dump($nowOrder);
	if($now_store['wxpay'] && (empty($nowOrder['suppliers']) || $nowOrder['suppliers'] == $now_store['store_id'])){
		// dump($_SESSION);
		$weixin_bind_info = D('Weixin_bind')->where(array('store_id'=>$now_store['store_id']))->find();
		// dump($weixin_bind_info);
		if($weixin_bind_info && $weixin_bind_info['wxpay_mchid'] && $weixin_bind_info['wxpay_key']){
			if(empty($_GET['code'])){
				$_SESSION['store_weixin_state']   = md5(uniqid());
				//代店铺发起获取openid
				redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$weixin_bind_info['authorizer_appid'].'&redirect_uri='.urlencode($config['site_url'].$_SERVER['REQUEST_URI']).'&response_type=code&scope=snsapi_base&state='.$_SESSION['store_weixin_state'].'&component_appid='.$config['wx_appid'].'#wechat_redirect');
			}else if(isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['store_weixin_state'])){
				import('Http');
				$component_access_token_arr = M('Weixin_bind')->get_access_token($now_store['store_id'],true);
				if($component_access_token_arr['errcode']){
					pigcms_tips('与微信通信失败，请重试。');
				}
				$result = Http::curlGet('https://api.weixin.qq.com/sns/oauth2/component/access_token?appid='.$weixin_bind_info['authorizer_appid'].'&code='.$_GET['code'].'&grant_type=authorization_code&component_appid='.$config['wx_appid'].'&component_access_token='.$component_access_token_arr['component_access_token']);
				$result = json_decode($result,true);
				if($result['errcode']){
					pigcms_tips('微信返回系统繁忙，请稍候再试。微信错误信息：'.$result['errmsg']);
				}
				$storeOpenid = $result['openid'];
				if(!D('Order')->where(array('order_id'=>$nowOrder['order_id']))->data(array('useStorePay'=>'1','storeOpenid'=>$storeOpenid,'trade_no'=>date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999)))->save()){
					pigcms_tips('订单信息保存失败，请重试。');
				}
				$payMethodList['weixin']['name'] = '微信安全支付';
				$payList[0] = $payMethodList['weixin'];
				$useStorePay = true;
			}
		}
	}else{
		if(!D('Order')->where(array('order_id'=>$nowOrder['order_id']))->data(array('useStorePay'=>'0','storeOpenid'=>'0','trade_no'=>date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999)))->save()){
			pigcms_tips('订单信息保存失败，请重试。');
		}
	}
	if($payMethodList['weixin']){
		$payMethodList['weixin']['name'] = '微信安全支付';
		$payList[0] = $payMethodList['weixin'];
	}
}else if($payMethodList['alipay']){
	$payList[0] = $payMethodList['alipay'];
}
if(empty($useStorePay)){
	if($payMethodList['tenpay']){
		$payList[1] = $payMethodList['tenpay'];
	}
	if($payMethodList['yeepay']){
		$payList[2] = $payMethodList['yeepay'];
	}else if($payMethodList['allinpay']){
		$payList[2] = $payMethodList['allinpay'];
	}
	if($payList[2]) $payList[2]['name'] = '银行卡支付';

	if($now_store['pay_agent']){
		$payList[] = array('name'=>'找人代付','type'=>'peerpay');
	}
}

if ($offline_payment) {
	$payList[] = array('name' => '货到付款', 'type' => 'offline');
}

//同步到微店的用户
if (!empty($_SESSION['sync_user'])) {
    $sync_user = true;
}

include display('pay');
echo ob_get_clean();
?>
