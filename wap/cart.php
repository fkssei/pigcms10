<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
if(empty($action)){
	$store_id = $_GET['id'];
	//店铺资料
	$now_store = M('Store')->wap_getStore($store_id);
	if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
	
	$cart_where = "`uc`.`store_id`='$store_id' AND `uc`.`product_id`=`p`.`product_id`";
	if($wap_user['uid']){
		$cart_where .= " AND `uc`.`uid`='".$wap_user['uid']."'";
	}else{
		$cart_where .= " AND `uc`.`session_id`='".session_id()."'";
	}
	$cartList = D('')->field('`uc`.`pigcms_id`,`uc`.`product_id`,`uc`.`pro_num`,`uc`.`pro_price`,`uc`.`sku_id`,`uc`.`sku_data`,`p`.`name`,`p`.`image`,`p`.`quantity`,`p`.`status`,`p`.`buyer_quota`')->table(array('User_cart'=>'uc','Product'=>'p'))->where($cart_where)->order('`pigcms_id` DESC')->select();

	$database_product_sku = D('Product_sku');
	foreach($cartList as $key=>$value){
        //限购
        if (!empty($value['buyer_quota'])) {
            if (empty($_SESSION['wap_user'])) { //游客购买
                $session_id = session_id();
                $orders = D('Order')->field('order_id')->where(array('session_id' => $session_id))->select();
                $quantity = 0;
                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        $products = D('Order_product')->field('pro_num')->where(array('product_id' => $value['product_id'], 'order_id' => $order['order_id']))->select();
                        foreach ($products as $product) {
                            $quantity += $product['pro_num']; //购买数量
                        }
                    }
                }
            } else {
                $uid = $_SESSION['wap_user']['uid'];
                $orders = D('Order')->field('order_id')->where(array('uid' => $uid))->select();
                $quantity = 0;
                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        $products = D('Order_product')->field('pro_num')->where(array('product_id' => $value['product_id'], 'order_id' => $order['order_id']))->select();
                        foreach ($products as $product) {
                            $quantity += $product['pro_num']; //购买数量
                        }
                    }
                }
            }
            $cartList[$key]['buy_quantity'] = $quantity;
        } else {
            $cartList[$key]['buy_quantity'] = 0;
        }
		$cartList[$key]['sku_num'] = 0;
		if($value['sku_id'] && $value['quantity'] && $value['status'] == 1){
			$nowSku = $database_product_sku->field('`quantity`')->where(array('sku_id'=>$value['sku_id']))->find();
			$cartList[$key]['sku_num'] = $nowSku['quantity'];
		}else if($value['quantity']){
			$cartList[$key]['sku_num'] = $value['quantity'];
		}
		$cartList[$key]['image'] = getAttachmentUrl($value['image']);
	}

	//分享配置 start  
	$share_conf 	= array(
		'title' 	=> $now_store['name'], // 分享标题
		'desc' 		=> str_replace(array("\r","\n"), array('',''),  $now_store['intro']), // 分享描述
		'link' 		=> $now_store['url'], // 分享链接
		'imgUrl' 	=> $now_store['logo'], // 分享图片链接
		'type'		=> '', // 分享类型,music、video或link，不填默认为link
		'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
	);
	import('WechatShare');
	$share 		= new WechatShare();
	$shareData 	= $share->getSgin($share_conf);
	//分享配置 end
	
	include display('cart');
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
		$now_cart = D('')->field('`uc`.*,`p`.`quantity`,`p`.`status`, `p`.`weight`')->table(array('User_cart'=>'uc','Product'=>'p'))->where($cart_where." AND `uc`.`pigcms_id`='$value'")->find();
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
    $database_product = D('Product');
	$data_order_product['order_id'] = $order_id;
    $suppliers = array();
	foreach($cartList as $value){
        $product_info = $database_product->field('store_id,original_product_id')->where(array('product_id' => $value['product_id']))->find();
        if (!empty($product_info['original_product_id'])) {
            $tmp_product_info = $database_product->field('store_id')->where(array('product_id' => $product_info['original_product_id']))->find();
            $supplier_id = $tmp_product_info['store_id'];
            $original_product_id = $product_info['original_product_id'];
        } else {
            $supplier_id = $product_info['store_id'];
            $original_product_id = $value['product_id'];
        }
        $suppliers[] = $supplier_id;
		$data_order_product['product_id'] = $value['product_id'];
		$data_order_product['sku_id'] = $value['sku_id'];
		$data_order_product['sku_data'] = $value['sku_data'];
		$data_order_product['pro_num'] = $value['pro_num'];
		$data_order_product['pro_price'] = $value['pro_price'];
		$data_order_product['comment'] = !empty($value['comment']) ? $value['comment'] : '';
        $data_order_product['is_fx'] = $value['is_fx']; //是否是分销商品
        $data_order_product['supplier_id'] = $supplier_id; //供货商id
        $data_order_product['original_product_id'] = $original_product_id;
        $data_order_product['user_order_id'] = $order_id;
        $data_order_product['pro_weight'] = $value['weight'];
		$database_order_product->data($data_order_product)->add();
	}
    $suppliers = array_unique($suppliers); //分销商
    $suppliers = implode(',', $suppliers);
    if (!empty($suppliers)) { //修改订单，设置分销商
        $data = array();
        $data['suppliers'] = $suppliers;
        if (!empty($suppliers) && ($suppliers != $_POST['storeId'])) {
            $data['is_fx'] = 1;
        }
        $database->where(array('order_id' => $order_id))->data($data)->save();
    }
	//删除购物车商品
	$condition_user_cart['pigcms_id'] = array('in',$_POST['ids']);
	if(!empty($wap_user['uid'])){
		$condition_user_cart['uid'] = $wap_user['uid'];
	}else{
		$condition_user_cart['session_id'] = session_id();
	}
	D('User_cart')->where($condition_user_cart)->delete();
	
	// 产生提醒
	import('source.class.Notify');
	Notify::createNoitfy($_POST['storeId'], option('config.orderid_prefix') . $order_no);
	
	json_return(0,$config['orderid_prefix'].$order_no);
}
echo ob_get_clean();
?>