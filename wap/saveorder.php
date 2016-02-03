<?php
/**
 *  处理订单
 */
require_once dirname(__FILE__).'/global.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'add';

switch($action){
	case 'add':
		if($_POST['type'] == 4){
			$product_price = (float)$_POST['price'];
		}else{
			//验证商品
			$nowProduct = D('Product')->field('`product_id`,`store_id`,`price`,`has_property`,`status`,`supplier_id`,`buyer_quota`, `weight`')->where(array('product_id'=>$_POST['proId']))->find();
			if(empty($nowProduct) || empty($nowProduct['status'])){
				json_return(1000,'商品不存在');
			}

			//限购
			$buy_quantity = 0;
			if (!empty($nowProduct['buyer_quota'])) {
				if (empty($_SESSION['wap_user'])) { //游客购买
					$session_id = session_id();
					$orders = D('Order')->field('order_id')->where(array('session_id' => $session_id))->select();
					if (!empty($orders)) {
						foreach ($orders as $order) {
							$products = D('Order_product')->field('pro_num')->where(array('product_id' => $nowProduct['product_id'], 'order_id' => $order['order_id']))->select();
							foreach ($products as $product) {
								$buy_quantity += $product['pro_num']; //购买数量
							}
						}
					}
				} else {
					$uid = $_SESSION['wap_user']['uid'];
					$orders = D('Order')->field('order_id')->where(array('uid' => $uid))->select();
					if (!empty($orders)) {
						foreach ($orders as $order) {
							$products = D('Order_product')->field('pro_num')->where(array('product_id' => $nowProduct['product_id'], 'order_id' => $order['order_id']))->select();
							foreach ($products as $product) {
								$buy_quantity += $product['pro_num']; //购买数量
							}
						}
					}
				}
				$tmp_quantity = intval(trim($_POST['quantity']));
				if (($buy_quantity + $tmp_quantity) > $nowProduct['buyer_quota']) { //限购
					json_return(1001,'商品限购，请修改购买数量');
				}
			}

			if(empty($nowProduct['has_property'])){
				$skuId = 0;
				$propertiesStr = '';
				$product_price = $nowProduct['price'];
			}else{
				$skuId = !empty($_POST['skuId']) ? intval($_POST['skuId']) : json_return(1001,'请选择商品属性');
				//判断库存是否存在
				$nowSku = D('Product_sku')->field('`sku_id`,`product_id`,`properties`,`price`')->where(array('sku_id'=>$skuId))->find();
				
				$tmpPropertiesArr = explode(';',$nowSku['properties']);
				$properties = $propertiesValue = $productProperties = array();
				foreach($tmpPropertiesArr as $value){
					$tmpPro = explode(':',$value);
					$properties[] = $tmpPro[0];
					$propertiesValue[] = $tmpPro[1];
				}
				if(count($properties) == 1){
					$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid'=>$properties[0]))->select();
					$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid'=>$propertiesValue[0]))->select();
				}else{
					$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid'=>array('in',$properties)))->select();
					$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid'=>array('in',$propertiesValue)))->select();
				}
				foreach($findPropertiesArr as $value){
					$propertiesArr[$value['pid']] = $value['name'];
				}
				foreach($findPropertiesValueArr as $value){
					$propertiesValueArr[$value['vid']] = $value['value'];
				}
				foreach($properties as $key=>$value){
					$productProperties[] = array('pid'=>$value,'name'=>$propertiesArr[$value],'vid'=>$propertiesValue[$key],'value'=>$propertiesValueArr[$propertiesValue[$key]]);
				}
				$propertiesStr = serialize($productProperties);
				if($nowProduct['product_id'] != $nowSku['product_id']) json_return(1002,'商品属性选择错误');
				
				$product_price = $nowSku['price'];
			}
			if($_POST['activityId']){
				$nowActivity = M('Product_qrcode_activity')->getActivityById($_POST['activityId']);
				if($nowActivity['product_id'] == $nowProduct['product_id']){
					if($nowActivity['type'] == 0){
						$product_price = round($product_price*$nowActivity['discount']/10,2);
					}else{
						$product_price = $product_price-$nowActivity['price'];
					}
				}
			}
		}
		
		
		$quantity = intval($_POST['quantity']) > 0 ? intval($_POST['quantity']) : json_return(1003,'请输入购买数量');
		
		if(empty($_POST['isAddCart'])){	//立即购买
			$order_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
			if($_POST['type'] == 4){
				$data_order['store_id'] = (int)$_POST['store_id'];
			}else{
				$data_order['store_id'] = $nowProduct['store_id'];
			}
			$data_order['order_no'] = $data_order['trade_no'] = $order_no;
			if(!empty($wap_user['uid'])){
				$data_order['uid'] = $wap_user['uid'];
			}else{
				$data_order['session_id'] = session_id();
			}
			$data_order['sub_total'] = ($product_price*100)*$quantity/100;
			$data_order['pro_num'] = $quantity;
			$data_order['pro_count'] = '1';
			$data_order['type'] = $_POST['type'] ? (int)$_POST['type'] : 0;
			$data_order['bak'] = $_POST['bak'] ? serialize($_POST['bak']) : '';
			$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
			$order_id = D('Order')->data($data_order)->add();
			if(empty($order_id)){
				json_return(1004,'订单产生失败，请重试');
			}
			$data_order_product['order_id'] = $order_id;
			$data_order_product['product_id'] = $nowProduct['product_id'];
			$data_order_product['sku_id'] = $skuId;
			$data_order_product['sku_data'] = $propertiesStr;
			$data_order_product['pro_num'] = $quantity;
			$data_order_product['pro_price'] = $product_price;
			$data_order_product['comment'] = !empty($_POST['custom']) ? serialize($_POST['custom']) : '';
			$data_order_product['pro_weight'] = $nowProduct['weight'];
            //分销商品
            if (!empty($nowProduct['supplier_id'])) {
                $data_order_product['is_fx'] = 1;
            }
            $product_info = D('Product')->field('product_id,store_id,original_product_id')->where(array('product_id' => $nowProduct['product_id']))->find();
            if (!empty($product_info['original_product_id'])) {
                $tmp_product_info = D('Product')->field('store_id')->where(array('product_id' => $product_info['original_product_id']))->find();
                $supplier_id = $tmp_product_info['store_id'];
                $original_product_id = $product_info['original_product_id'];
            } else {
                $supplier_id = $product_info['store_id'];
                $original_product_id = $product_info['product_id'];
            }
            $data_order_product['supplier_id'] = $supplier_id;
            $data_order_product['original_product_id'] = $original_product_id;
            $data_order_product['user_order_id'] = $order_id;
			if(D('Order_product')->data($data_order_product)->add()){
				if(!empty($wap_user['uid'])){
					M('Store_user_data')->upUserData($nowProduct['store_id'],$wap_user['uid'],'unpay');
				}
                if (!empty($supplier_id)) { //修改订单，设置分销商
                    $data = array();
                    $data['suppliers'] = $supplier_id;
                    if (!empty($supplier_id) && ($supplier_id != $nowProduct['store_id'])) {
                        $data['is_fx'] = 1;
                    }
                    D('Order')->where(array('order_id' => $order_id))->data($data)->save();
                }

                // 产生提醒
				import('source.class.Notify');
                Notify::createNoitfy($nowProduct['store_id'], option('config.orderid_prefix') . $order_no);

				json_return(0,$config['orderid_prefix'].$order_no);
			}else{
                D('Order')->where(array('order_id' => $order_id))->delete();
				json_return(1005,'订单产生失败，请重试');
			}
		}else{
			if(!empty($wap_user['uid'])){
				$data_user_cart['uid'] = $wap_user['uid'];
			}else{
				$data_user_cart['session_id'] = session_id();
			}
			$data_user_cart['product_id'] = $nowProduct['product_id'];
			$data_user_cart['store_id'] = $nowProduct['store_id'];
			$data_user_cart['sku_id'] = $skuId;
			$data_user_cart['sku_data'] = $propertiesStr;
			$data_user_cart['pro_num'] = $quantity;
			$data_user_cart['pro_price'] = $product_price;
			$data_user_cart['add_time'] = $_SERVER['REQUEST_TIME'];
			$data_user_cart['comment'] = !empty($_POST['custom']) ? serialize($_POST['custom']) : '';
            if (!empty($nowProduct['supplier_id'])) {
                $data_user_cart['is_fx'] = 1;
            }
			if(D('User_cart')->data($data_user_cart)->add()){
				json_return(0,'添加成功');
			}else{
				json_return(1005,'订单产生失败，请重试');
			}
		}
		break;
	case 'pay':
		$nowOrder = M('Order')->find($_POST['orderNo']);
		if(empty($nowOrder['total']))  json_return(1006,'订单异常，请稍后再试');
		$trade_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
		if($nowOrder['status'] > 1 && $nowOrder['payment_method'] == 'codpay') json_return(1008, './order.php?orderid=' . $nowOrder['order_id']);
		if($nowOrder['status'] > 1) json_return(1007,'该订单已支付或关闭<br/>不再允许付款');
		$offline_payment = false;
		if(empty($nowOrder['status'])){
			if(empty($nowOrder['order_id'])) json_return(1008,'该订单不存在');
			
			$store = M('Store')->wap_getStore($nowOrder['store_id']);
			if ($store['offline_payment']) {
				$offline_payment = true;
			}
			
			$condition_order['order_id'] = $nowOrder['order_id'];
			if($wap_user['uid']){
				$condition_order['uid'] = $wap_user['uid'];
			}else{
				$condition_order['session_id'] = session_id();
			}
			if($_POST['shipping_method'] == 'selffetch'){
				$selffetch_id = $_POST['selffetch_id'];
				$selffetch = array();
				if (strpos($selffetch_id, 'store')) {
					$store_contace = M('Store_contact')->get($nowOrder['store_id']);
					if (!empty($selffetch)) {
						$store = M('Store')->getStore($nowOrder['store_id']);
						$selffetch['tel'] = ($store_contace['phone1'] ? $store_contace['phone1'] . '-' : '') . $store_contace['phone2'];
						$selffetch['business_hours'] = '';
						$selffetch['name'] = $store['name'];
						$selffetch['physical_id'] = 0;
						$selffetch['store_id'] = $nowOrder['store_id'];
					}
				} else {
					$selffetch = M('Store_physical')->getOne($selffetch_id);
					if (!empty($selffetch) && $selffetch['store_id'] != $nowOrder['store_id']) {
						$selffetch = '';
					} else if (!empty($selffetch)) {
						$selffetch['tel'] = ($selffetch['phone1'] ? $selffetch['phone1'] . '-' : '') . $selffetch['phone2'];
						$selffetch['physical_id'] = $selffetch_id;
						$selffetch['store_id'] = $nowOrder['store_id'];
					}
				}
				
				//$selffetch = M('Trade_selffetch')->get_selffetch($_POST['selffetch_id'],$nowOrder['store_id']);
				if(empty($selffetch)) json_return(1009,'该门店不存在');
				$data_order['postage'] = '0';
				//$data_order['total'] = $nowOrder['sub_total'];
				$data_order['shipping_method'] = 'selffetch';
				$data_order['address_user'] = $_POST['selffetch_name'];
				$data_order['address_tel'] = $_POST['selffetch_phone'];
				$data_order['address'] = serialize(array(
					'name' => $selffetch['name'],
					'address' => $selffetch['address'],
					'province' => $selffetch['province_txt'],
					'province_code' => $selffetch['province'],
					'city' => $selffetch['city_txt'],
					'city_code' => $selffetch['city'],
					'area' => $selffetch['county_txt'],
					'area_code' => $selffetch['county'],
					'tel' => $selffetch['tel'],
					'long' => $selffetch['long'],
					'lat' => $selffetch['lat'],
					'business_hours' => $selffetch['business_hours'],
					'date' => $_POST['selffetch_date'],
					'time' => $_POST['selffetch_time'],
					'store_id' => $selffetch['store_id'],
					'physical_id' => $selffetch['physical_id'],
				));
				
				// 到自提点将邮费设置为0
				$nowOrder['postage'] = 0;
			} else if ($_POST['shipping_method'] == 'friend') {
				$friend_name = $_POST['friend_name'];
				$friend_phone = $_POST['friend_phone'];
				$province = $_POST['province'];
				$city = $_POST['city'];
				$county = $_POST['county'];
				$friend_address = $_POST['friend_address'];
				$friend_date = $_POST['friend_date'];
				$friend_time = $_POST['friend_time'];
				
				if (empty($friend_name)) {
					json_return(1009, '朋友姓名没有填写');
				}
				if(!preg_match("/\d{9,13}$/", $friend_phone)){
					json_return(1009, '请填写正确的手机号');
				}
				if (empty($province)) {
					json_return(1009, '请选择省份');
				}
				if (empty($city)) {
					json_return(1009, '请选择城市');
				}
				if (empty($county)) {
					json_return(1009, '请选择区县');
				}
				
				import('source.class.area');
				$area_class = new area();
				$province_txt = $area_class->get_name($province);
				$city_txt = $area_class->get_name($city);
				$county_txt = $area_class->get_name($county);
				
				if (empty($province_txt) || empty($city_txt)) {
					json_return(1009, '该地址不存在');
				}
				
				//$data_order['total'] = $nowOrder['sub_total'];
				$data_order['shipping_method'] = 'friend';
				$data_order['address_user'] = $friend_name;
				$data_order['address_tel'] = $friend_phone;
				$data_order['address'] = serialize(array(
						'address' => $friend_address,
						'province' => $province_txt,
						'province_code' => $province,
						'city' => $city_txt,
						'city_code' => $city,
						'area' => $county_txt,
						'area_code' => $county,
						'date' => $friend_date,
						'time' => $friend_time,
				));
			}else{
				$address = M('User_address')->getAdressById(session_id(),$wap_user['uid'],$_POST['address_id']);
				if(empty($address)) json_return(1009,'该地址不存在');
				$data_order['shipping_method'] = 'express';
				$data_order['address_user'] = $address['name'];
				$data_order['address_tel'] = $address['tel'];
				$data_order['address'] = serialize(array(
					'address' => $address['address'],
					'province' => $address['province_txt'],
					'province_code' => $address['province'],
					'city' => $address['city_txt'],
					'city_code' => $address['city'],
					'area' => $address['area_txt'],
					'area_code' => $address['area'],
				));
			}
			$data_order['status'] = '1';
			if(!empty($_POST['msg'])){
				$data_order['comment'] = $_POST['msg'];
			}
			$data_order['trade_no'] = $trade_no;
			if(!D('Order')->where($condition_order)->data($data_order)->save()) json_return(1010,'订单信息保存失败');

			// 保存满减，优惠券信息
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
					continue;
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
			// 第二步计算出用户购买原产品可以使用哪些优惠券
			$user_coupon_list = Appmarket::getCoupon($reward_list, $user_coupon_list);

			// 用户享受的优惠券
			$money = 0;
			$pro_num = 0;
			$pro_count = 0;
			if ($wap_user['uid']) {
				foreach ($reward_list as $key => $reward) {
					if ($key === 'product_price_list') {
						continue;
					}

					// 积分
					if ($reward['score'] > 0) {
						M('Store_user_data')->changePoint($nowOrder['store_id'], $wap_user['uid'], $reward['score']);
					}

					// 送赠品
					if (is_array($reward['present']) && count($reward['present']) > 0) {
						foreach ($reward['present'] as $present) {
							$data_order_product = array();
							$data_order_product['order_id'] = $nowOrder['order_id'];
							$data_order_product['product_id'] = $present['product_id'];

							// 是否有属性，有则随机挑选一个属性
							if ($present['has_property']) {
								$sku_arr = M('Product_sku')->getRandSku($present['product_id']);
								$data_order_product['sku_id'] = $sku_arr['sku_id'];
								$data_order_product['sku_data'] = $sku_arr['propertiey'];
							}

							$data_order_product['pro_num'] = 1;
							$data_order_product['pro_price'] = 0;
							$data_order_product['is_present'] = 1;

							$pro_num++;
							if (!in_array($present['product_id'], $product_id_arr)) {
								$pro_count++;
							}

							D('Order_product')->data($data_order_product)->add();
							unset($data_order_product);
						}
					}

					// 送优惠券
					if ($reward['coupon']) {
						$data_user_coupon = array();
						$data_user_coupon['uid'] = $wap_user['uid'];
						$data_user_coupon['store_id'] = $reward['coupon']['store_id'];
						$data_user_coupon['coupon_id'] = $reward['coupon']['id'];
						$data_user_coupon['card_no'] = String::keyGen();
						$data_user_coupon['cname'] = $reward['coupon']['name'];
						$data_user_coupon['face_money'] = $reward['coupon']['face_money'];
						$data_user_coupon['limit_money'] = $reward['coupon']['limit_money'];
						$data_user_coupon['start_time'] = $reward['coupon']['start_time'];
						$data_user_coupon['end_time'] = $reward['coupon']['end_time'];
						$data_user_coupon['is_expire_notice'] = $reward['coupon']['is_expire_notice'];
						$data_user_coupon['is_share'] = $reward['coupon']['is_share'];
						$data_user_coupon['is_all_product'] = $reward['coupon']['is_all_product'];
						$data_user_coupon['is_original_price'] = $reward['coupon']['is_original_price'];
						$data_user_coupon['description'] = $reward['coupon']['description'];
						$data_user_coupon['timestamp'] = time();
						$data_user_coupon['type'] = 2;
						$data_user_coupon['give_order_id'] = $nowOrder['order_id'];

						D('User_coupon')->data($data_user_coupon)->add();
					}

					$data = array();
					$data['order_id'] = $nowOrder['order_id'];
					$data['uid'] = $wap_user['uid'];
					$data['rid'] = $reward['rid'];
					$data['name'] = $reward['name'];
					$data['content'] = serialize($reward);
					$money += $reward['cash'];
					D('Order_reward')->data($data)->add();
				}

				// 用户使用的优惠券
				$coupon_id = $_POST['user_coupon_id'];
				foreach ($user_coupon_list as $user_coupon) {
					if ($user_coupon['id'] == $coupon_id) {
						$data = array();
						$data['order_id'] = $nowOrder['order_id'];
						$data['uid'] = $wap_user['uid'];
						$data['coupon_id'] = $user_coupon['coupon_id'];
						$data['name'] = $user_coupon['cname'];
						$data['user_coupon_id'] = $coupon_id;
						$data['money'] = $user_coupon['face_money'];

						$money += $user_coupon['face_money'];
						D('Order_coupon')->data($data)->add();

						// 将用户优惠券改为已使用
						$data = array();
						$data['is_use'] = 1;
						$data['use_time'] = time();
						$data['use_order_id'] = $nowOrder['order_id'];
						D('User_coupon')->where(array('id' => $coupon_id))->data($data)->save();
						break;
					}
				}
			}

			// 更改订单金额
			$total = max(0, $nowOrder['sub_total'] + $nowOrder['postage'] + $nowOrder['float_amount'] - $money);
			$pro_count = $nowOrder['pro_count'] + $pro_count;
			$pro_num = $nowOrder['pro_num'] + $pro_num;
			
			$data = array();
			$data['total'] = $total;
			$data['pro_count'] = $pro_count;
			$data['pro_num'] = $pro_num;
			$data['status'] = 1;
			if ($_POST['payType'] == 'offline' && $offline_payment) {
				$data['status'] = 2;
				$data['payment_method'] = 'codpay';
			}
			
			D('Order')->where(array('order_id' => $nowOrder['order_id']))->data($data)->save();
			$nowOrder['total'] = $total;
		}else{
			$store = M('Store')->wap_getStore($nowOrder['store_id']);
			if ($store['offline_payment']) {
				$offline_payment = true;
			}
			foreach ($nowOrder['proList'] as $product) {
				// 分销商品不参与满赠和使用优惠券
				if ($product['source_product_id'] != '0') {
					$offline_payment = false;
					break;
				}
			}
			
			$data_order = array();
			if ($_POST['payType'] == 'offline' && $offline_payment) {
				$data_order['status'] = 2;
				$data_order['payment_method'] = 'codpay';
			}
			
			$condition_order['order_id'] = $nowOrder['order_id'];
			$data_order['trade_no'] = $trade_no;
			if(!D('Order')->where($condition_order)->data($data_order)->save()) json_return(1010,'订单信息保存失败');
		}

		$nowOrder['trade_no'] = $trade_no;
		$payType = $_POST['payType'];
		
		if ($_POST['payType'] == 'offline' && !$offline_payment) {
			json_return(1012, '对不起，订单不支付货到付款');
		} else if($_POST['payType'] == 'offline' && $offline_payment) {
			json_return(0, '/wap/order.php?orderid=' . $nowOrder['order_id']);
		}
		
		$payMethodList = M('Config')->get_pay_method();
		if(empty($payMethodList[$payType])){
			json_return(1012,'您选择的支付方式不存在<br/>请更新支付方式');
		}
		$nowOrder['order_no_txt'] = option('config.orderid_prefix').$nowOrder['order_no'];
		switch($payType){
			case 'yeepay':
				import('source.class.pay.Yeepay');
				$payClass = new Yeepay($nowOrder,$payMethodList[$payType]['config'],$wap_user);
				$payInfo = $payClass->pay();
				if($payInfo['err_code']){
					json_return(1013,$payInfo['err_msg']);
				}else{
					json_return(0,$payInfo['url']);
				}
				break;
			case 'tenpay':
				import('source.class.pay.Tenpay');
				$payClass = new Tenpay($nowOrder,$payMethodList[$payType]['config'],$wap_user);
				$payInfo = $payClass->pay();
				if($payInfo['err_code']){
					json_return(1013,$payInfo['err_msg']);
				}else{
					json_return(0,$payInfo['url']);
				}
				break;
			case 'weixin':
				import('source.class.pay.Weixin');
				if($nowOrder['useStorePay']){
					$weixin_bind_info = D('Weixin_bind')->where(array('store_id'=>$nowOrder['store_id']))->find();
					if(empty($weixin_bind_info) || empty($weixin_bind_info['wxpay_mchid']) || empty($weixin_bind_info['wxpay_key'])){
						json_return(1014,'商家未配置正确微信支付');
					}
					$payMethodList[$payType]['config'] = array('pay_weixin_appid'=>$weixin_bind_info['authorizer_appid'],'pay_weixin_mchid'=>$weixin_bind_info['wxpay_mchid'],'pay_weixin_key'=>$weixin_bind_info['wxpay_key']);
					$openid = $nowOrder['storeOpenid'];
				}else{
					$openid = $_SESSION['openid'];
				}
				$payClass = new Weixin($nowOrder,$payMethodList[$payType]['config'],$wap_user,$openid);
				$payInfo = $payClass->pay();
				if($payInfo['err_code']){
					json_return(1013,$payInfo['err_msg']);
				}else{
					json_return(0,json_decode($payInfo['pay_data']));
				}
				break;
		}
		break;
	case 'cart_count':
		if(empty($_COOKIE['wap_store_id'])) json_return(1014,'访问异常');
		if($wap_user['uid']){
			$condition_user_cart['uid'] = $wap_user['uid'];
		}else{
			$condition_user_cart['session_id'] = session_id();
		}
		$condition_user_cart['store_id'] = $_COOKIE['wap_store_id'];
		$return['count'] = D('User_cart')->where($condition_user_cart)->count('pigcms_id');
		$return['store_id'] = $_COOKIE['wap_store_id'];
		json_return(0,$return);
    case 'test_pay':
        $nowOrder = M('Order')->find($_POST['orderNo']);
        if(empty($nowOrder['total']))  json_return(1006,'订单异常，请稍后再试');
        $trade_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
        if($nowOrder['status'] > 1) json_return(1007,'该订单已支付或关闭<br/>不再允许付款');
        if(empty($nowOrder['status'])){
            if(empty($nowOrder['order_id'])) json_return(1008,'该订单不存在');
            $condition_order['order_id'] = $nowOrder['order_id'];
            if($wap_user['uid']){
                $condition_order['uid'] = $wap_user['uid'];
            }else{
                $condition_order['session_id'] = session_id();
            }
            if($_POST['shipping_method'] == 'selffetch'){
                $selffetch_id = $_POST['selffetch_id'];
                $selffetch = array();
                if (strpos($selffetch_id, 'store')) {
                    $selffetch = M('Store_contact')->get($nowOrder['store_id']);
                    if (!empty($selffetch)) {
                        $store = M('Store')->getStore($nowOrder['store_id']);
                        $selffetch['tel'] = $selffetch['phone1'] ? $selffetch['phone1'] : $selffetch['phone2'];
                        $selffetch['business_hours'] = '';
                        $selffetch['name'] = $store['name'];
                        $selffetch['physical_id'] = 0;
                        $selffetch['store_id'] = $nowOrder['store_id'];
                    }
                } else {
                    $selffetch = M('Store_physical')->getOne($selffetch_id);
                    if (!empty($selffetch) && $selffetch['store_id'] != $nowOrder['store_id']) {
                        $selffetch = '';
                    } else if (!empty($selffetch)) {
                        $selffetch['tel'] = $selffetch['phone1'] ? $selffetch['phone1'] : $selffetch['phone2'];
                        $selffetch['physical_id'] = $selffetch_id;
                        $selffetch['store_id'] = $nowOrder['store_id'];
                    }
                }

                //$selffetch = M('Trade_selffetch')->get_selffetch($_POST['selffetch_id'],$nowOrder['store_id']);
                if(empty($selffetch)) json_return(1009,'该门店不存在');
                $data_order['postage'] = '0';
                $data_order['total'] = $nowOrder['sub_total'];
                $data_order['shipping_method'] = 'selffetch';
                $data_order['address_user'] = $_POST['selffetch_name'];
                $data_order['address_tel'] = $_POST['selffetch_phone'];
                $data_order['address'] = serialize(array(
                    'name' => $selffetch['name'],
                    'address' => $selffetch['address'],
                    'province' => $selffetch['province_txt'],
                    'province_code' => $selffetch['province'],
                    'city' => $selffetch['city_txt'],
                    'city_code' => $selffetch['city'],
                    'area' => $selffetch['county_txt'],
                    'area_code' => $selffetch['county'],
                    'tel' => $selffetch['tel'],
                    'long' => $selffetch['long'],
                    'lat' => $selffetch['lat'],
                    'business_hours' => $selffetch['business_hours'],
                    'date' => $_POST['selffetch_date'],
                    'time' => $_POST['selffetch_time'],
                    'store_id' => $selffetch['store_id'],
                    'physical_id' => $selffetch['physical_id'],
                ));
            }else{
                $address = M('User_address')->getAdressById(session_id(),$wap_user['uid'],$_POST['address_id']);
                if(empty($address)) json_return(1009,'该地址不存在');
                $data_order['shipping_method'] = 'express';
                $data_order['address_user'] = $address['name'];
                $data_order['address_tel'] = $address['tel'];
                $data_order['address'] = serialize(array(
                    'address' => $address['address'],
                    'province' => $address['province_txt'],
                    'city' => $address['city_txt'],
                    'area' => $address['area_txt'],
                ));
            }
            $data_order['status'] = '1';
            if(!empty($_POST['msg'])){
                $data_order['comment'] = $_POST['msg'];
            }
            $data_order['trade_no'] = $trade_no;
            if(!D('Order')->where($condition_order)->data($data_order)->save()) json_return(1010,'订单信息保存失败');

            // 保存满减，优惠券信息
            // 优惠活动
            $product_id_arr = array();
            $store_id = 0;
            $uid = 0;
            $total_price = 0;
            $product_price_arr = array();
            foreach ($nowOrder['proList'] as $product) {
                // 分销商品不参与满赠和使用优惠券
                if ($product['source_product_id'] != '0') {
                    continue;
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
            // 第二步计算出用户购买原产品可以使用哪些优惠券
            $user_coupon_list = Appmarket::getCoupon($reward_list, $user_coupon_list);

            // 用户享受的优惠券
            $money = 0;
            $pro_num = 0;
            $pro_count = 0;
            if ($wap_user['uid']) {
                foreach ($reward_list as $key => $reward) {
                    if ($key === 'product_price_list') {
                        continue;
                    }

                    // 积分
                    if ($reward['score'] > 0) {
                        M('Store_user_data')->changePoint($nowOrder['store_id'], $wap_user['uid'], $reward['score']);
                    }

                    // 送赠品
                    if (is_array($reward['present']) && count($reward['present']) > 0) {
                        foreach ($reward['present'] as $present) {
                            $data_order_product = array();
                            $data_order_product['order_id'] = $nowOrder['order_id'];
                            $data_order_product['product_id'] = $present['product_id'];

                            // 是否有属性，有则随机挑选一个属性
                            if ($present['has_property']) {
                                $sku_arr = M('Product_sku')->getRandSku($present['product_id']);
                                $data_order_product['sku_id'] = $sku_arr['sku_id'];
                                $data_order_product['sku_data'] = $sku_arr['propertiey'];
                            }

                            $data_order_product['pro_num'] = 1;
                            $data_order_product['pro_price'] = 0;
                            $data_order_product['is_present'] = 1;

                            $pro_num++;
                            if (!in_array($present['product_id'], $product_id_arr)) {
                                $pro_count++;
                            }

                            D('Order_product')->data($data_order_product)->add();
                            unset($data_order_product);
                        }
                    }

                    // 送优惠券
                    if ($reward['coupon']) {
                        $data_user_coupon = array();
                        $data_user_coupon['uid'] = $wap_user['uid'];
                        $data_user_coupon['store_id'] = $reward['coupon']['store_id'];
                        $data_user_coupon['coupon_id'] = $reward['coupon']['id'];
                        $data_user_coupon['card_no'] = String::keyGen();
                        $data_user_coupon['cname'] = $reward['coupon']['name'];
                        $data_user_coupon['face_money'] = $reward['coupon']['face_money'];
                        $data_user_coupon['limit_money'] = $reward['coupon']['limit_money'];
                        $data_user_coupon['start_time'] = $reward['coupon']['start_time'];
                        $data_user_coupon['end_time'] = $reward['coupon']['end_time'];
                        $data_user_coupon['is_expire_notice'] = $reward['coupon']['is_expire_notice'];
                        $data_user_coupon['is_share'] = $reward['coupon']['is_share'];
                        $data_user_coupon['is_all_product'] = $reward['coupon']['is_all_product'];
                        $data_user_coupon['is_original_price'] = $reward['coupon']['is_original_price'];
                        $data_user_coupon['description'] = $reward['coupon']['description'];
                        $data_user_coupon['timestamp'] = time();
                        $data_user_coupon['type'] = 2;
                        $data_user_coupon['give_order_id'] = $nowOrder['order_id'];

                        D('User_coupon')->data($data_user_coupon)->add();
                    }

                    $data = array();
                    $data['order_id'] = $nowOrder['order_id'];
                    $data['uid'] = $wap_user['uid'];
                    $data['rid'] = $reward['rid'];
                    $data['name'] = $reward['name'];
                    $data['content'] = serialize($reward);
                    $money += $reward['cash'];
                    D('Order_reward')->data($data)->add();
                }

                // 用户使用的优惠券
                $coupon_id = $_POST['user_coupon_id'];
                foreach ($user_coupon_list as $user_coupon) {
                    if ($user_coupon['id'] == $coupon_id) {
                        $data = array();
                        $data['order_id'] = $nowOrder['order_id'];
                        $data['uid'] = $wap_user['uid'];
                        $data['coupon_id'] = $user_coupon['coupon_id'];
                        $data['name'] = $user_coupon['cname'];
                        $data['user_coupon_id'] = $coupon_id;
                        $data['money'] = $user_coupon['face_money'];

                        $money += $user_coupon['face_money'];
                        D('Order_coupon')->data($data)->add();

                        // 将用户优惠券改为已使用
                        $data = array();
                        $data['is_use'] = 1;
                        $data['use_time'] = time();
                        $data['use_order_id'] = $nowOrder['order_id'];
                        D('User_coupon')->where(array('id' => $coupon_id))->data($data)->save();
                        break;
                    }
                }
            }

            // 更改订单金额
            $total = max(0, $nowOrder['sub_total'] + $nowOrder['postage'] + $nowOrder['float_amount'] - $money);
            $pro_count = $nowOrder['pro_count'] + $pro_count;
            $pro_num = $nowOrder['pro_num'] + $pro_num;
            D('Order')->where(array('order_id' => $nowOrder['order_id']))->data(array('status' => 1, 'total' => $total, 'pro_count' => $pro_count, 'pro_num' => $pro_num))->save();
            $nowOrder['total'] = $total;

        }else{
            $store = M('Store')->wap_getStore($nowOrder['store_id']);
            if ($store['offline_payment']) {
                $offline_payment = true;
            }

            foreach ($nowOrder['proList'] as $product) {
                // 分销商品不参与满赠和使用优惠券
                if ($product['source_product_id'] != '0') {
                    $offline_payment = false;
                    break;
                }
            }

            $data_order = array();
            if ($_POST['payType'] == 'offline' && $offline_payment) {
                $data_order['status'] = 2;
                $data_order['payment_method'] = 'codpay';
            }

            $condition_order['order_id'] = $nowOrder['order_id'];
            $data_order['trade_no'] = $trade_no;
            if(!D('Order')->where($condition_order)->data($data_order)->save()) json_return(1010,'订单信息保存失败');
        }
        import('source.class.Http');
        $data = array(
            'pay_money'      => $nowOrder['total'],
            'trade_no'       => $trade_no,
            'pay_type'       => 'test',
        );
        $payment_url = option('config.wap_site_url') . '/paynotice.php';
        $result = Http::curlPost($payment_url, $data);
        ob_clean();
        if (!empty($result['errcode'])) {
            json_return(1001, '支付失败');
        } else {
            json_return(0, option('config.wap_site_url') . '/order.php?orderno=' . option('config.orderid_prefix') . $nowOrder['order_no']);
        }
        break;
    case 'go_pay':
        $nowOrder = M('Order')->find($_POST['orderNo']);
        if(empty($nowOrder['total']))  json_return(1006,'订单异常，请稍后再试');
        $trade_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
        if($nowOrder['status'] > 1) json_return(1007,'该订单已支付或关闭<br/>不再允许付款');
        if(empty($nowOrder['status'])){
            if(empty($nowOrder['order_id'])) json_return(1008,'该订单不存在');
            $condition_order['order_id'] = $nowOrder['order_id'];
            if($wap_user['uid']){
                $condition_order['uid'] = $wap_user['uid'];
            }else{
                $condition_order['session_id'] = session_id();
            }
            if($_POST['shipping_method'] == 'selffetch'){
            	$selffetch_id = $_POST['selffetch_id'];
            	$selffetch = array();
            	if (strpos($selffetch_id, 'store')) {
            		$store_contace = M('Store_contact')->get($nowOrder['store_id']);
            		if (!empty($selffetch)) {
	            		$store = M('Store')->getStore($nowOrder['store_id']);
	            		$selffetch['tel'] = ($store_contace['phone1'] ? $store_contace['phone1'] . '-' : '') . $store_contace['phone2'];
	            		$selffetch['business_hours'] = '';
	            		$selffetch['name'] = $store['name'];
	            		$selffetch['physical_id'] = 0;
	            		$selffetch['store_id'] = $nowOrder['store_id'];
            		}
            	} else {
            		$store_physical = M('Store_physical')->getOne($selffetch_id);
            		if (!empty($store_physical) && $store_physical['store_id'] != $nowOrder['store_id']) {
            			$selffetch = '';
            		} else if (!empty($store_physical)) {
            			$selffetch['tel'] = ($store_physical['phone1'] ? $store_physical['phone1'] . '-' : '') . $store_physical['phone2'];
            			$selffetch['physical_id'] = $selffetch_id;
            			$selffetch['store_id'] = $nowOrder['store_id'];
            		}
            	}
            	
            	//$selffetch = M('Trade_selffetch')->get_selffetch($_POST['selffetch_id'],$nowOrder['store_id']);
            	if(empty($selffetch)) json_return(1009,'该门店不存在');
            	$data_order['postage'] = '0';
            	$data_order['total'] = $nowOrder['sub_total'];
            	$data_order['shipping_method'] = 'selffetch';
            	$data_order['address_user'] = $_POST['selffetch_name'];
            	$data_order['address_tel'] = $_POST['selffetch_phone'];
            	$data_order['address'] = serialize(array(
            			'name' => $selffetch['name'],
            			'address' => $selffetch['address'],
            			'province' => $selffetch['province_txt'],
            			'province_code' => $selffetch['province'],
            			'city' => $selffetch['city_txt'],
            			'city_code' => $selffetch['city'],
            			'area' => $selffetch['county_txt'],
            			'area_code' => $selffetch['county'],
            			'tel' => $selffetch['tel'],
            			'long' => $selffetch['long'],
            			'lat' => $selffetch['lat'],
            			'business_hours' => $selffetch['business_hours'],
            			'date' => $_POST['selffetch_date'],
            			'time' => $_POST['selffetch_time'],
            			'store_id' => $selffetch['store_id'],
            			'physical_id' => $selffetch['physical_id'],
            	));
            	
            	// 到自提点将邮费设置为0
            	$nowOrder['postage'] = 0;
            } else if ($_POST['shipping_method'] == 'friend') {
				$friend_name = $_POST['friend_name'];
				$friend_phone = $_POST['friend_phone'];
				$province = $_POST['province'];
				$city = $_POST['city'];
				$county = $_POST['county'];
				$friend_address = $_POST['friend_address'];
				$friend_date = $_POST['friend_date'];
				$friend_time = $_POST['friend_time'];
				
				if (empty($friend_name)) {
					json_return(1009, '朋友姓名没有填写');
				}
				if(!preg_match("/\d{9,13}$/", $friend_phone)){
					json_return(1009, '请填写正确的手机号');
				}
				if (empty($province)) {
					json_return(1009, '请选择省份');
				}
				if (empty($city)) {
					json_return(1009, '请选择城市');
				}
				if (empty($county)) {
					json_return(1009, '请选择区县');
				}
				
				import('source.class.area');
				$area_class = new area();
				$province_txt = $area_class->get_name($province);
				$city_txt = $area_class->get_name($city);
				$county_txt = $area_class->get_name($county);
				
				if (empty($province_txt) || empty($city_txt)) {
					json_return(1009, '该地址不存在');
				}
				
				$data_order['total'] = $nowOrder['sub_total'];
				$data_order['shipping_method'] = 'friend';
				$data_order['address_user'] = $friend_name;
				$data_order['address_tel'] = $friend_phone;
				$data_order['address'] = serialize(array(
						'address' => $friend_address,
						'province' => $province_txt,
						'province_code' => $province,
						'city' => $city_txt,
						'city_code' => $city,
						'area' => $county_txt,
						'area_code' => $county,
						'date' => $friend_date,
						'time' => $friend_time,
				));
			}else{
                $address = M('User_address')->getAdressById(session_id(),$wap_user['uid'],$_POST['address_id']);
                if(empty($address)) json_return(1009,'该地址不存在');
                $data_order['shipping_method'] = 'express';
                $data_order['address_user'] = $address['name'];
                $data_order['address_tel'] = $address['tel'];
                $data_order['address'] = serialize(array(
                    'address' => $address['address'],
                    'province' => $address['province_txt'],
                    'city' => $address['city_txt'],
                    'area' => $address['area_txt'],
                ));
            }
            $data_order['status'] = '1';
            if(!empty($_POST['msg'])){
                $data_order['comment'] = $_POST['msg'];
            }
            $data_order['trade_no'] = $trade_no;
            if(!D('Order')->where($condition_order)->data($data_order)->save()) json_return(1010,'订单信息保存失败');

            // 保存满减，优惠券信息
            // 优惠活动
            $product_id_arr = array();
            $store_id = 0;
            $uid = 0;
            $total_price = 0;
            $product_price_arr = array();
            foreach ($nowOrder['proList'] as $product) {
            	// 分销商品不参与满赠和使用优惠券
            	if ($product['source_product_id'] != '0') {
            		continue;
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
            // 第二步计算出用户购买原产品可以使用哪些优惠券
            $user_coupon_list = Appmarket::getCoupon($reward_list, $user_coupon_list);

            // 用户享受的优惠券
            $money = 0;
            $pro_num = 0;
            $pro_count = 0;
            if ($wap_user['uid']) {
            	foreach ($reward_list as $key => $reward) {
            		if ($key === 'product_price_list') {
            			continue;
            		}

            		// 积分
            		if ($reward['score'] > 0) {
            			M('Store_user_data')->changePoint($nowOrder['store_id'], $wap_user['uid'], $reward['score']);
            		}

            		// 送赠品
            		if (is_array($reward['present']) && count($reward['present']) > 0) {
            			foreach ($reward['present'] as $present) {
            				$data_order_product = array();
            				$data_order_product['order_id'] = $nowOrder['order_id'];
            				$data_order_product['product_id'] = $present['product_id'];

            				// 是否有属性，有则随机挑选一个属性
            				if ($present['has_property']) {
            					$sku_arr = M('Product_sku')->getRandSku($present['product_id']);
            					$data_order_product['sku_id'] = $sku_arr['sku_id'];
            					$data_order_product['sku_data'] = $sku_arr['propertiey'];
            				}

            				$data_order_product['pro_num'] = 1;
            				$data_order_product['pro_price'] = 0;
            				$data_order_product['is_present'] = 1;

            				$pro_num++;
            				if (!in_array($present['product_id'], $product_id_arr)) {
            					$pro_count++;
            				}

            				D('Order_product')->data($data_order_product)->add();
            				unset($data_order_product);
            			}
            		}

            		// 送优惠券
            		if ($reward['coupon']) {
            			$data_user_coupon = array();
            			$data_user_coupon['uid'] = $wap_user['uid'];
            			$data_user_coupon['store_id'] = $reward['coupon']['store_id'];
            			$data_user_coupon['coupon_id'] = $reward['coupon']['id'];
            			$data_user_coupon['card_no'] = String::keyGen();
            			$data_user_coupon['cname'] = $reward['coupon']['name'];
            			$data_user_coupon['face_money'] = $reward['coupon']['face_money'];
            			$data_user_coupon['limit_money'] = $reward['coupon']['limit_money'];
            			$data_user_coupon['start_time'] = $reward['coupon']['start_time'];
            			$data_user_coupon['end_time'] = $reward['coupon']['end_time'];
            			$data_user_coupon['is_expire_notice'] = $reward['coupon']['is_expire_notice'];
            			$data_user_coupon['is_share'] = $reward['coupon']['is_share'];
            			$data_user_coupon['is_all_product'] = $reward['coupon']['is_all_product'];
            			$data_user_coupon['is_original_price'] = $reward['coupon']['is_original_price'];
            			$data_user_coupon['description'] = $reward['coupon']['description'];
            			$data_user_coupon['timestamp'] = time();
            			$data_user_coupon['type'] = 2;
            			$data_user_coupon['give_order_id'] = $nowOrder['order_id'];

            			D('User_coupon')->data($data_user_coupon)->add();
            		}

            		$data = array();
            		$data['order_id'] = $nowOrder['order_id'];
            		$data['uid'] = $wap_user['uid'];
            		$data['rid'] = $reward['rid'];
            		$data['name'] = $reward['name'];
            		$data['content'] = serialize($reward);
            		$money += $reward['cash'];
            		D('Order_reward')->data($data)->add();
            	}

            	// 用户使用的优惠券
            	$coupon_id = $_POST['user_coupon_id'];
            	foreach ($user_coupon_list as $user_coupon) {
            		if ($user_coupon['id'] == $coupon_id) {
            			$data = array();
            			$data['order_id'] = $nowOrder['order_id'];
            			$data['uid'] = $wap_user['uid'];
            			$data['coupon_id'] = $user_coupon['coupon_id'];
            			$data['name'] = $user_coupon['cname'];
            			$data['user_coupon_id'] = $coupon_id;
            			$data['money'] = $user_coupon['face_money'];

            			$money += $user_coupon['face_money'];
            			D('Order_coupon')->data($data)->add();

            			// 将用户优惠券改为已使用
            			$data = array();
            			$data['is_use'] = 1;
            			$data['use_time'] = time();
            			$data['use_order_id'] = $nowOrder['order_id'];
            			D('User_coupon')->where(array('id' => $coupon_id))->data($data)->save();
            			break;
            		}
            	}
            }

            // 更改订单金额
            $total = max(0, $nowOrder['sub_total'] + $nowOrder['postage'] + $nowOrder['float_amount'] - $money);
            $pro_count = $nowOrder['pro_count'] + $pro_count;
            $pro_num = $nowOrder['pro_num'] + $pro_num;
            D('Order')->where(array('order_id' => $nowOrder['order_id']))->data(array('status' => 1, 'total' => $total, 'pro_count' => $pro_count, 'pro_num' => $pro_num))->save();
            $nowOrder['total'] = $total;

        }else{
        	$store = M('Store')->wap_getStore($nowOrder['store_id']);
        	if ($store['offline_payment']) {
        		$offline_payment = true;
        	}
        		
        	foreach ($nowOrder['proList'] as $product) {
        		// 分销商品不参与满赠和使用优惠券
        		if ($product['source_product_id'] != '0') {
        			$offline_payment = false;
        			break;
        		}
        	}
        		
        	$data_order = array();
        	if ($_POST['payType'] == 'offline' && $offline_payment) {
        		$data_order['status'] = 2;
        		$data_order['payment_method'] = 'codpay';
        	}
        	
            $condition_order['order_id'] = $nowOrder['order_id'];
            $data_order['trade_no'] = $trade_no;
            if(!D('Order')->where($condition_order)->data($data_order)->save()) json_return(1010,'订单信息保存失败');
        }

        //跳转支付
        $data = array(
            'store_id'       => $nowOrder['store_id'],
            'token'          => $_SESSION['wap_user']['token'],
            'wecha_id'       => $_SESSION['wap_user']['third_id'],
            'orderName'      => option('config.orderid_prefix') . $nowOrder['order_no'],
            'orderid' 		 => option('config.orderid_prefix') . $nowOrder['order_no'],
            'price'          => $nowOrder['total'],
            'pro_num'        => $nowOrder['pro_num'],
            'trade_no'       => $nowOrder['trade_no'],
            'notOffline'     => 1
        );
        $salt = option('config.weidian_key');
        $sort_data = $data;
        $sort_data['salt'] = !empty($salt) ? $salt : 'pigcms';
        ksort($sort_data);
        $sign_key = sha1(http_build_query($sort_data));
        $data['sign_key'] = $sign_key;
        $data['timestamp'] = time();
        $store = M('Store');
        $store = $store->getStore($nowOrder['store_id']);
        $payment_url = $store['payment_url'];
        $request_url = $payment_url;
        $params = http_build_query($data);
        $request_url .= '&' . $params;
        json_return(0, $request_url);
}
?>