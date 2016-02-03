<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
if(empty($action)){
	if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
	
	$cart_where = "`uc`.`store_id`=`s`.`store_id` AND `uc`.`product_id`=`p`.`product_id`";
	$cart_where .= " AND `uc`.`uid`='".$wap_user['uid']."'";
	$cartList = D('')->field('`s`.`store_id`,`s`.`name` AS `store_name`,`uc`.`pigcms_id`,`uc`.`product_id`,`uc`.`pro_num`,`uc`.`pro_price`,`uc`.`sku_id`,`uc`.`sku_data`,`p`.`name`,`p`.`image`,`p`.`quantity`,`p`.`status`')->table(array('User_cart'=>'uc','Product'=>'p','Store'=>'s'))->where($cart_where)->order('`pigcms_id` DESC')->select();
	
	$storeCartList = array();
	$database_product_sku = D('Product_sku');
	foreach($cartList as &$value){
		$value['sku_num'] = 0;
		if($value['sku_id'] && $value['quantity'] && $value['status'] == 1){
			$nowSku = $database_product_sku->field('`quantity`')->where(array('sku_id'=>$value['sku_id']))->find();
			$value['sku_num'] = $nowSku['quantity'];
		}else if($value['quantity']){
			$value['sku_num'] = $value['quantity'];
		}
		$storeCartList[$value['store_id']]['store_id'] = $value['store_id'];
		$storeCartList[$value['store_id']]['store_name'] = $value['store_name'];
		$storeCartList[$value['store_id']]['cart_list'][] = $value;
	}
	if(isset($_GET['id']) && !empty($storeCartList[$_GET['id']])){
		$now_store_cart = $storeCartList[$_GET['id']];
		unset($storeCartList[$_GET['id']]);
	}else if(isset($_COOKIE['wap_store_id']) && !empty($storeCartList[$_COOKIE['wap_store_id']])){
		$now_store_cart = $storeCartList[$_COOKIE['wap_store_id']];
		unset($storeCartList[$_COOKIE['wap_store_id']]);
	}else{
		$now_store_cart = array_shift($storeCartList);
	}

	//分享配置 start
	$share_conf 	= array(
		'title' 	=> option('config.site_name').'-购物车', // 分享标题
		'desc' 		=> str_replace(array("\r","\n"), array('',''),  option('config.seo_description')), // 分享描述
		'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
		'imgUrl' 	=> option('config.site_logo'), // 分享图片链接
		'type'		=> '', // 分享类型,music、video或link，不填默认为link
		'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
	);
	import('WechatShare');
	$share 		= new WechatShare();
	$shareData 	= $share->getSgin($share_conf);
	//分享配置 end

	include display('my_cart');
}else if($action == 'quantity'){
	if(empty($_POST['id'])) json_return(1,'数据异常');
	if(!empty($_POST['skuId'])){
		$condition_product_sku['sku_id'] = $_POST['skuId'];
		$product_sku = D('Product_sku')->field('`quantity`')->where($condition_product_sku)->find();
		$quantity = $product_sku['quantity'];
	}else if(!empty($_POST['proId'])){
		$condition_product['product_id'] = $_POST['proId'];
		$product = D('Product')->field('`quantity`')->where($condition_product)->find();
		$quantity = $product['quantity'];
	}else{
		json_return(1,'数据异常');
	}
	$condition_user_cart['pigcms_id'] = $_POST['id'];
	if($wap_user['uid']){
		$condition_user_cart['uid'] = $wap_user['uid'];
	}else{
		$condition_user_cart['session_id'] = session_id();
	}
	$data_user_cart['pro_num'] = $_POST['num'] < $quantity ? intval($_POST['num']) : $quantity;
	D('User_cart')->where($condition_user_cart)->data($data_user_cart)->save();
	json_return(0,$quantity);
}else if($action == 'del'){
	if(empty($_POST['ids'])){
		json_return(1000,'请勾选一些内容');
	}
	$condition_user_cart['pigcms_id'] = array('in',$_POST['ids']);
	$condition_user_cart['store_id'] = $_POST['storeId'];
	if($wap_user['uid']){
		$condition_user_cart['uid'] = $wap_user['uid'];
	}else{
		$condition_user_cart['session_id'] = session_id();
	}
	if(D('User_cart')->where($condition_user_cart)->delete()){
		json_return(0,'删除成功');
	}else{
		json_return(1001,'删除失败，请重试');
	}
}else if($action == 'pay'){
	if(empty($_POST['ids'])){
		json_return(1000,'请勾选一些内容');
	}
	if($wap_user['uid']){
		$cart_where = "`uc`.`product_id`=`p`.`product_id` AND `uc`.`uid`='".$wap_user['uid']."' AND `uc`.`store_id`='".$_POST['storeId']."'";
	}else{
		$cart_where = "`uc`.`product_id`=`p`.`product_id` AND `uc`.`session_id`='".session_id()."' AND `uc`.`store_id`='".$_POST['storeId']."'";
	}
	$cartList = array();
	$pro_num = $pro_count = $pro_money = 0;
	foreach($_POST['ids'] as $value){
		$now_cart = D('')->field('`uc`.*,`p`.`quantity`,`p`.`status`')->table(array('User_cart'=>'uc','Product'=>'p'))->where($cart_where." AND `uc`.`pigcms_id`='$value'")->find();
		if(empty($now_cart)){
			json_return(1001,'您选中的商品已下架');
		}
		//检测库存
		if(!empty($now_cart['sku_id'])){
			$condition_product_sku['sku_id'] = $now_cart['sku_id'];
			$product_sku = D('Product_sku')->field('`quantity`')->where($condition_product_sku)->find();
			$quantity = $product_sku['quantity'];
		}else{
			$quantity = $now_cart['quantity'];
		}
		if($quantity < $now_cart['pro_num']){
			json_return(1001,'您选中的商品库存不足');
		}
		$cartList[] = $now_cart;
		$pro_num += $now_cart['pro_num'];
		$pro_money += ($now_cart['pro_price']*100)*$now_cart['pro_num']/100;
		$pro_count++;
	}
	
	$order_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
	$data_order['store_id'] = $_POST['storeId'];
	$data_order['order_no'] = $data_order['trade_no'] = $order_no;
	if(!empty($wap_user['uid'])){
		$data_order['uid'] = $wap_user['uid'];
	}else{
		$data_order['session_id'] = session_id();
	}
	$data_order['sub_total'] = $pro_money;
	$data_order['pro_num'] = $pro_num;
	$data_order['pro_count'] = $pro_count;
	$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
	$database = D('Order');
	$order_id = $database->data($data_order)->add();
	if(empty($order_id)){
		json_return(1004,'订单产生失败，请重试');
	}
	if(!empty($wap_user['uid'])){
		M('Store_user_data')->upUserData($data_order['store_id'],$wap_user['uid'],'unpay');
	}
	$database_order_product = D('Order_product');
	$data_order_product['order_id'] = $order_id;
	foreach($cartList as $value){
		$data_order_product['product_id'] = $value['product_id'];
		$data_order_product['sku_id'] = $value['sku_id'];
		$data_order_product['sku_data'] = $value['sku_data'];
		$data_order_product['pro_num'] = $value['pro_num'];
		$data_order_product['pro_price'] = $value['pro_price'];
		$data_order_product['comment'] = !empty($value['comment']) ? $value['comment'] : '';
		$database_order_product->data($data_order_product)->add();
	}
	
	//删除购物车商品
	$condition_user_cart['pigcms_id'] = array('in',$_POST['ids']);
	if(!empty($wap_user['uid'])){
		$condition_user_cart['uid'] = $wap_user['uid'];
	}else{
		$condition_user_cart['session_id'] = session_id();
	}
	D('User_cart')->where($condition_user_cart)->delete();
	
	json_return(0,$config['orderid_prefix'].$order_no);
}


echo ob_get_clean();
?>