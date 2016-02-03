<?php
	require_once dirname(__FILE__).'./global.php';

	$condition = authArray($_GET['source']);
	$store = D('Store')->where($condition)->field('store_id')->find();
	if(!$store){
		pigcms_tips('该店铺没有开启任何活动！','none');
	}
	$orderData = json_encode(array(
		'quantity'=>1,
		'isAddCart'=>0,
		'skuId'=>0,
		'store_id'=>$store['store_id'],
		'price'=>(float)$_GET['price'],
		'bak'=>bakData(htmlspecialchars($_GET['source'])),
		'type'=>4
	));
	$orderName = htmlspecialchars($_GET['orderName']);
	function bakData($type){
		$return = array();
		switch($type){
			case 'pigcms':
			$return = array(
				'token'=>htmlspecialchars($_GET['token']),
				'wecha_id'=>htmlspecialchars($_GET['wecha_id']),
				'orderid'=>htmlspecialchars($_GET['orderid']),
				'from'=>'pigcms_'.htmlspecialchars($_GET['from']),
			);
		}
		return $return;
	}
	function authArray($source){
		$condition = array();
		switch($source){
			case 'pigcms':
				$condition['pigcmsToken'] = htmlspecialchars($_GET['token']);
				break;
		}
		return $condition;
	}

	include display('otherPay');
	echo ob_get_clean();
?>
