<?php
/**
 *  店铺主页
 */
require_once dirname(__FILE__).'/global.php';

$product_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');

// 预览切换
if(!$is_mobile && $_SESSION['user'] && option('config.synthesize_store')) {
    if (isset($_GET['ps']) && $_GET['ps'] == '800') {
        $config = option('config');

        $url = $config['site_url'] . '/index.php?c=goods&a=index&id=' . $product_id . '&is_preview=1';
        echo redirect($url);
        exit;
    }
}

	//商品默认展示
	$nowProduct = D('Product')->where(array('product_id'=>$product_id))->find();
	if(empty($nowProduct)) pigcms_tips('您访问的商品不存在','none');

	if($nowProduct['image_size'] == '0'){
		$nowProduct['image_size'] = array();
	}else if($nowProduct['image_size']){
		$nowProduct['image_size'] = unserialize($nowProduct['image_size']);
	}else{
		$nowProduct['image_size'] = D('Attachment')->field('`width`,`height`')->where(array('file' => $nowProduct['image']))->find();
		D('Product')->where(array('product_id'=>$product_id))->data(array('image_size'=>serialize($nowProduct['image_size'])))->save();
	}
	$nowProduct['image'] = getAttachmentUrl($nowProduct['image']);
	$nowProduct['images'] = M('Product_image')->getImages($product_id,true);
	$nowProduct['images_num'] = count($nowProduct['images']);
	if($nowProduct['has_property']){
		//库存信息
		$skuList = D('Product_sku')->field('`sku_id`,`properties`,`quantity`,`price`')->where(array('product_id'=>$product_id,'quantity'=>array('!=','0')))->order('`sku_id` ASC')->select();
		//如果有库存信息并且有库存，则查库存关系表
		if(!empty($skuList)){
			$skuPriceArr = $skuPropertyArr = array();
			foreach($skuList as $value){
				$skuPriceArr[] = $value['price'];
				$skuPropertyArr[$value['properties']] = true;
			}
			if(!empty($skuPriceArr)){
				$minPrice = min($skuPriceArr);
				$maxPrice = max($skuPriceArr);
			}else{
				$nowProduct['quantity'] = 0;
			}
			$tmpPropertyList = D('')->field('`pp`.`pid`,`pp`.`name`')->table(array('Product_to_property'=>'ptp','Product_property'=>'pp'))->where("`ptp`.`product_id`='$product_id' AND `pp`.`pid`=`ptp`.`pid`")->order('`ptp`.`pigcms_id` ASC')->select();
			if(!empty($tmpPropertyList)){
				$tmpPropertyValueList = D('')->field('`ppv`.`vid`,`ppv`.`value`,`ppv`.`pid`')->table(array('Product_to_property_value'=>'ptpv','Product_property_value'=>'ppv'))->where("`ptpv`.`product_id`='$product_id' AND `ppv`.`vid`=`ptpv`.`vid`")->order('`ptpv`.`pigcms_id` ASC')->select();
				if(!empty($tmpPropertyValueList)){
					foreach($tmpPropertyValueList as $value){
						$propertyValueList[$value['pid']][] = array(
								'vid'=>$value['vid'],
								'value'=>$value['value'],
						);
					}
					foreach($tmpPropertyList as $value){
						$newPropertyList[] = array(
								'pid'=>$value['pid'],
								'name'=>$value['name'],
								'values'=>$propertyValueList[$value['pid']],
						);
					}
					if(count($newPropertyList) == 1){
						foreach($newPropertyList[0]['values'] as $key=>$value){
							$tmpKey = $newPropertyList[0]['pid'].':'.$value['vid'];
							if(empty($skuPropertyArr[$tmpKey])){
								unset($newPropertyList[0]['values'][$key]);
							}
						}
					}
				}
			}
		}
	}else{
		$minPrice = $nowProduct['price'];
		$maxPrice = 0;
	}
	if($nowProduct['postage_type']){
		if (!empty($nowProduct['original_product_id'])) { //分销商品
			$tmp_product_info = D('Product')->field('store_id')->where(array('product_id' => $nowProduct['original_product_id']))->find();
			$supplier_id = $tmp_product_info['store_id'];
		} else {
			$supplier_id = $nowProduct['store_id'];
		}
		$postage_template = M('Postage_template')->get_tpl($nowProduct['postage_template_id'], $supplier_id);
		if($postage_template['area_list']){
			foreach($postage_template['area_list'] as $value){
				if(!isset($min_postage)){
					$min_postage = $max_postage = $value[2];
				}else if($value[2] < $min_postage){
					$min_postage = $value[2];
				}else if($value[2] > $max_postage){
					$max_postage = $value[2];
				}
			}
		}
		if($min_postage == $max_postage){
			$nowProduct['postage'] = $min_postage;
		}else{
			$nowProduct['postage_tpl'] = array('min'=>$min_postage,'max'=>$max_postage);
		}
	}

	//扫码优惠
	if(!empty($_GET['activity'])){
		$nowActivity = M('Product_qrcode_activity')->getActivityById($_GET['activity']);
		if(empty($nowActivity) || $nowActivity['product_id'] != $nowProduct['product_id']){
			unset($nowActivity);
		}
	}

	$store_id = $nowProduct['store_id'];
	//店铺资料
	$now_store = M('Store')->wap_getStore($store_id);
	if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
	setcookie('wap_store_id',$now_store['store_id'],$_SERVER['REQUEST_TIME']+10000000,'/');

	//当前页面的地址
	$now_url = $config['wap_site_url'].'/good.php?id='.$nowProduct['product_id'];

	//商品的自定义字段
	if($nowProduct['has_custom']){
		$homeCustomField = M('Custom_field')->getParseFields($store_id,'good',$nowProduct['product_id']);
	}

	//公共广告判断
	$pageHasAd = false;
	if($now_store['open_ad'] && !empty($now_store['use_ad_pages'])){
		$useAdPagesArr = explode(',',$now_store['use_ad_pages']);
		if(in_array('2',$useAdPagesArr)){
			$pageAdFieldArr = M('Custom_field')->getParseFields($store_id,'common_ad',$store_id);
			if(!empty($pageAdFieldArr)){
				$pageAdFieldCon = '';
				foreach($pageAdFieldArr as $value){
					$pageAdFieldCon .= $value['html'];
				}
				$pageHasAd = true;
			}
			$pageAdPosition = $now_store['ad_position'];
		}
	}

	$good_history = $_COOKIE['good_history'];
	if(empty($good_history)){
		$new_history = true;
	}else{
		$good_history = json_decode($good_history,true);
		if(!is_array($good_history)){
			$new_history = true;
		}else{
			$new_good_history = array();
			foreach($good_history as &$history_value){
				if($history_value['id'] != $nowProduct['product_id']){
					$new_good_history[] = $history_value;
				}
			}
			if(!empty($new_good_history)){
				array_push($new_good_history,array('id'=>$nowProduct['product_id'],'name'=>$nowProduct['name'],'image'=>$nowProduct['image'],'price'=>$nowProduct['price'],'url'=>$now_url,'time'=>$_SERVER['REQUEST_TIME']));
			}else{
				$new_history = true;
			}
		}
	}
	if($new_history){
		$new_good_history[] = array(
				'id'=>$nowProduct['product_id'],
				'name'=>$nowProduct['name'],
				'image'=>$nowProduct['image'],
				'price'=>$nowProduct['price'],
				'url'=>$now_url,
				'time'=>$_SERVER['REQUEST_TIME']
		);
	}
	setcookie('good_history',json_encode($new_good_history),$_SERVER['REQUEST_TIME']+86400*365,'/');

	//限购
	$buyer_quota = false;
	if (!empty($nowProduct['buyer_quota'])) {
		if (empty($_SESSION['wap_user'])) { //游客购买
			$session_id = session_id();
			$buy_quantity = 0;
			//购物车
			$carts = D('User_cart')->field('pro_num')->where(array('product_id' => $nowProduct['product_id'], 'store_id' => $store_id, 'session_id' => $session_id))->select();
			if (!empty($carts)) {
				foreach ($carts as $cart) {
					$buy_quantity += $cart['pro_num'];
				}
			}
			$orders = D('Order')->field('order_id')->where(array('session_id' => $session_id))->select();
			if (!empty($orders)) {
				foreach ($orders as $order) {
					$products = D('Order_product')->field('pro_num')->where(array('product_id' => $nowProduct['product_id'], 'order_id' => $order['order_id']))->select();
					foreach ($products as $product) {
						$buy_quantity += $product['pro_num']; //购买数量
					}
				}
			}
			if ($buy_quantity >= $nowProduct['buyer_quota']) {
				$buyer_quota = true;
			}
		} else {
			$uid = $_SESSION['wap_user']['uid'];
			$quantity = 0;
			//购物车
			$carts = D('User_cart')->field('pro_num')->where(array('product_id' => $nowProduct['product_id'], 'store_id' => $store_id, 'uid' => $uid))->select();
			if (!empty($carts)) {
				foreach ($carts as $cart) {
					$buy_quantity += $cart['pro_num'];
				}
			}
			$orders = D('Order')->field('order_id')->where(array('uid' => $uid))->select();
			if (!empty($orders)) {
				foreach ($orders as $order) {
					$products = D('Order_product')->field('pro_num')->where(array('product_id' => $nowProduct['product_id'], 'order_id' => $order['order_id']))->select();
					foreach ($products as $product) {
						$buy_quantity += $product['pro_num']; //购买数量
					}
				}
			}
			if ($buy_quantity >= $nowProduct['buyer_quota']) {
				$buyer_quota = true;
			}
		}
	}

	// 查看本产品是否参与活动
	$reward = '';
	if ($nowProduct['source_product_id'] == 0) {
		$reward = M('Reward')->getRewardByProduct($nowProduct);
	}

	$allow_drp = false;
	$open_drp = option('config.open_store_drp');
	$store_supplier = M('Store_supplier');
	$is_fx = 0; //是否已经分销该商品，如果已经分销返回分销商品id
	$is_new_seller = false; //是否是新分销商
	if ($nowProduct['is_fx'] && $open_drp && $_SESSION['wap_user']['uid'] != $now_store['uid']) {
		//获取商品分销信息
		$cost_price = $nowProduct['cost_price']; //成本
		$min_fx_price = number_format($nowProduct['min_fx_price'] - $cost_price, 2, '.', ''); //最低分销价
		$max_fx_price = number_format($nowProduct['max_fx_price'] - $cost_price, 2, '.', ''); //最高分销价
		$max_fx_price = max(array($min_fx_price, $max_fx_price));
		//$allow_drp = true;
		if ($_SESSION['wap_user']['uid'] != $now_store['uid']) {
			$uid = $_SESSION['wap_user']['uid'];
			//查看是否已经是当前店铺的分销商
			$seller_store = D('Store')->field('store_id')->where(array('uid' => $uid, 'drp_supplier_id' => $store_id))->find();
			if (!empty($seller_store)) {
				//查看是否已经分销过此商品
				$fx_product = D('Product')->where(array('source_product_id' => $nowProduct['product_id'], 'supplier_id' => $store_id, 'store_id' => $seller_store['store_id']))->find();
				if (!empty($fx_product)) {
					$is_fx = $fx_product['product_id'];
				}
				$allow_drp = true;
			} else {
				$allow_drp = true;
				$is_new_seller = true;
			}

			//最大分销级别
			$max_store_drp_level = option('config.max_store_drp_level'); //最大分销级别
			$seller = $store_supplier->getSeller(array('seller_id' => $store_id, 'type' => 1));
			if (((!empty($seller) && $seller['level'] <= $max_store_drp_level) || empty($seller))) { //在最大分销级别内
				$allow_drp = true;
			} else {
				$allow_drp = false;
			}
		}
	}
	
	if ($now_store['open_drp_guidance'] != 1) {
		$allow_drp = false;
	}
	
	if ($allow_drp) {
		if (!empty($is_new_seller)) { //注册分销商
			$drp_register_url = './drp_register.php?id=' . $store_id;
		} else if (!empty($is_fx)) { //已分销过的商品
			$drp_register_url = './drp_product_share.php?id=' . $is_fx;
		} else { //已经是当前店铺分销商，但未分销过此商品
			$drp_register_url = './drp_register.php?id=' . $store_id . '&product_id=' . $nowProduct['product_id'] . '&a=share';
		}
	}


    $imUrl 	= getImUrl($_SESSION['wap_user']['uid'],$store_id);
    //分享配置 start
    $share_conf 	= array(
        'title' 	=> $nowProduct['name'], // 分享标题
        'desc' 		=> str_replace(array("\r","\n"), array('',''), !empty($nowProduct['intro']) ? $nowProduct['intro'] : $nowProduct['name']), // 分享描述
        'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
        'imgUrl' 	=> $nowProduct['images'][0]['image'], // 分享图片链接
        'type'		=> '', // 分享类型,music、video或link，不填默认为link
        'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
    );

    import('WechatShare');
    $share 		= new WechatShare();
    $shareData 	= $share->getSgin($share_conf);
    //分享配置 end

    include display('good');

    echo ob_get_clean();
?>