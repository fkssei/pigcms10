<?php
class order_controller extends base_controller{
	// 添加订单
	function add() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => false, 'msg' => 'nologin'));
			exit;
		}
		
		// 参数获取
		$product_id = $_POST['product_id'];
		$sku_id = $_POST['sku_id'];
		$quantity = $_POST['quantity'];
		
		//验证商品
		$product = D('Product')->field('`product_id`,`store_id`,`price`,`has_property`,`status`,`supplier_id`,`quantity`, `buyer_quota`, `weight`')->where(array('product_id'=>$product_id))->find();
		if(empty($product) || empty($product['status'])){
			echo json_encode(array('status' => false, 'msg' => '商品不存在'));
			exit;
		}
		
		// 限购
		if ($product['buyer_quota']) {
			$number = M('Order_product')->getProductPronum($product_id, $this->user_session['uid']);
			// 如果加入购物车，得计算购物车里同产品数量
			if ($_POST['type'] != 'add') {
				$user_cart_num = D('User_cart')->field('pro_num')->where(array('uid' => $this->user_session['uid'], 'product_id' => $product_id))->find();
				$number += $user_cart_num['pro_num'];
			}
			
			if ($number + $quantity > $product['buyer_quota']) {
				echo json_encode(array('status' => false, 'msg' => '对不起，您超出了限购'));
				exit;
			}
		}
		
		if(empty($product['has_property'])){
			$sku_id = 0;
			$propertiesStr = '';
			$product_price = $product['price'];
			
			if ($product['quantity'] < $quantity) {
				echo json_encode(array('status' => false, 'msg' => '商品库存不足'));
				exit;
			}
			
		}else{
			if (empty($sku_id)) {
				echo json_encode(array('status' => false, 'msg' => '请选择商品属性'));
				exit;
			}
			
			//判断库存是否存在
			$nowSku = D('Product_sku')->field('`sku_id`,`product_id`,`properties`,`price`, `quantity`')->where(array('sku_id' => $sku_id))->find();

			if ($nowSku['quantity'] < $quantity) {
				echo json_encode(array('status' => false, 'msg' => '商品库存不足'));
				exit;
			}
			
				
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
			if($product['product_id'] != $nowSku['product_id']) {
				echo json_encode(array('status' => false, 'msg' => '商品属性选择错误'));
				exit;
			}
				
			$product_price = $nowSku['price'];
		}
		if($_POST['activityId']){
			$nowActivity = M('Product_qrcode_activity')->getActivityById($_POST['activityId']);
			if($nowActivity['product_id'] == $product['product_id']){
				if($nowActivity['type'] == 0){
					$product_price = round($product_price*$nowActivity['discount']/10,2);
				}else{
					$product_price = $product_price-$nowActivity['price'];
				}
			}
		}
		
		if (empty($quantity)) {
			echo json_encode(array('status' => false, 'msg' => '请输入购买数量'));
			exit;
		}
		
		if($_POST['type'] == 'add'){	//立即购买
			$order_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
			$data_order['store_id'] = $product['store_id'];
			$data_order['order_no'] = $data_order['trade_no'] = $order_no;
			$data_order['uid'] = $this->user_session['uid'];
			$data_order['sub_total'] = ($product_price*100)*$quantity/100;
			$data_order['pro_num'] = $quantity;
			$data_order['pro_count'] = '1';
			$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
			
			
			// 收货地址
			/*$address = M('User_address')->getAdressById('', $this->user_session['uid'], $address_id);
			
			$address_arr = array();
			if (!empty($address)) {
				$address_arr['address'] = $address['address'];
				$address_arr['province'] = $address['province_txt'];
				$address_arr['province_code'] = $address['province'];
				$address_arr['city'] = $address['city_txt'];
				$address_arr['city_code'] = $address['city'];
				$address_arr['area'] = $address['area_txt'];
				$address_arr['area_code'] = $address['area'];
			}
			
			
			$address_list = M('User_address')->getMyAddress($this->user_session['uid']);
			// 收货地址
			$address = array();
			if (!empty($address_list)) {
				$address = $address_list[0];
			}
			
			$address_arr = array();
			if (!empty($address)) {
				$address_arr['address'] = $address['address'];
				$address_arr['province'] = $address['province_txt'];
				$address_arr['province_code'] = $address['province'];
				$address_arr['city'] = $address['city_txt'];
				$address_arr['city_code'] = $address['city'];
				$address_arr['area'] = $address['area_txt'];
				$address_arr['area_code'] = $address['area'];
			}
			
			$data_order['address'] = serialize($address_arr);
			$data_order['address_user'] = $address['name'];
			$data_order['address_tel'] = $address['tel'];*/
			
			$order_id = D('Order')->data($data_order)->add();
			if(empty($order_id)){
				echo json_encode(array('status' => false, 'msg' => '订单产生失败，请重试'));
				exit;
			}
			
			$data_order_product['order_id'] = $order_id;
			$data_order_product['product_id'] = $product['product_id'];
			$data_order_product['sku_id'] = $sku_id;
			$data_order_product['sku_data'] = $propertiesStr;
			$data_order_product['pro_num'] = $quantity;
			$data_order_product['pro_price'] = $product_price;
			$data_order_product['comment'] = !empty($_POST['custom']) ? serialize($_POST['custom']) : '';
			$data_order_product['pro_weight'] = $product['weight'];
			//分销商品
			if (!empty($product['supplier_id'])) {
				$data_order_product['is_fx'] = 1;
			}
			$product_info = D('Product')->field('product_id,store_id,original_product_id')->where(array('product_id' => $product['product_id']))->find();
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
				if(!empty($this->user_session['uid'])){
					M('Store_user_data')->upUserData($product['store_id'],$this->user_session['uid'],'unpay');
				}
				if (!empty($supplier_id)) { //修改订单，设置分销商
					D('Order')->where(array('order_id' => $order_id))->data(array('suppliers' => $supplier_id))->save();
				}
				
				echo json_encode(array('status' => true, 'msg' => '订单添加成功', 'data' => array('order_no' => option('config.orderid_prefix') . $order_no)));
				// 产生提醒
				import('source.class.Notify');
				Notify::createNoitfy($product['store_id'], option('config.orderid_prefix') . $order_no);
				exit;
			}else{
				
				echo json_encode(array('status' => false, 'msg' => '订单产生失败，请重试'));
				exit;
			}
		}else{
			// 查找购物车里是否有相应的产品
			$user_cart = D('User_cart')->where(array('uid' => $this->user_session['uid'], 'product_id' => $product['product_id'], 'store_id' => $product['store_id'], 'sku_id' => $sku_id))->find();
			if (!empty($user_cart)) {
				if (D('User_cart')->where(array('pigcms_id' => $user_cart['pigcms_id']))->setInc('pro_num', $quantity)) {
					// 查找购物车数量
					$pro_num = D('User_cart')->where(array('uid' => $this->user_session['uid']))->sum('pro_num');
					
					echo json_encode(array('status' => true, 'msg' => '添加购物车成功', 'data' => array('number' => $pro_num)));
					exit;
				} else {
					echo json_encode(array('status' => false, 'msg' => '添加购物车失败'));
					exit;
				}
			}
			
			
			$data_user_cart['uid'] = $this->user_session['uid'];
			$data_user_cart['product_id'] = $product['product_id'];
			$data_user_cart['store_id'] = $product['store_id'];
			$data_user_cart['sku_id'] = $sku_id;
			$data_user_cart['sku_data'] = $propertiesStr;
			$data_user_cart['pro_num'] = $quantity;
			$data_user_cart['pro_price'] = $product_price;
			$data_user_cart['add_time'] = $_SERVER['REQUEST_TIME'];
			$data_user_cart['comment'] = !empty($_POST['custom']) ? serialize($_POST['custom']) : '';
			if (!empty($product['supplier_id'])) {
				$data_user_cart['is_fx'] = 1;
			}
			if(D('User_cart')->data($data_user_cart)->add()){
				// 查找购物车数量
				$pro_num = D('User_cart')->where(array('uid' => $this->user_session['uid']))->sum('pro_num');
				
				echo json_encode(array('status' => true, 'msg' => '添加购物车成功', 'data' => array('number' => $pro_num)));
				exit;
			}else{
				echo json_encode(array('status' => false, 'msg' => '添加购物车失败'));
				exit;
			}
		}

	}
	
	function address() {
		$order_id = $_GET['order_id'];
		
		if (empty($order_id)) {
			pigcms_tips('缺少最基本的参数');
		}
		
		$order = M('Order')->find($order_id);
		// 有收货地址不给更改收货地址
		if ($order['address']) {
			redirect(url('order:detail', array('order_id' => $order_id)));
		}
		
		if (empty($order)) {
			pigcms_tips('未找到相应的订单');
		}
		
		if ($order['uid'] != $this->user_session['uid']) {
			pigcms_tips('请您操作自己的订单');
		}
		
		if ($order['status'] > 1) {
			redirect(url('order:detail', array('order_id' => $order_id)));
		}
		
		$store = M('Store')->getStore($order['store_id']);
		
		// 优惠活动
		$product_id_arr = array();
		$store_id = 0;
		$uid = 0;
		$total_price = 0;
		$product_price_arr = array();
		$offline_payment = $store['offline_payment'];
		$is_all_selfproduct = true;
		$is_all_supplierproduct = true;
		foreach ($order['proList'] as $product) {
			// 分销商品不参与满赠和使用优惠券
			if ($product['source_product_id'] != '0') {
				$offline_payment = 0;
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
		//print_r($reward_list);exit;
		if (IS_POST) {
			$shipping_method = $_POST['shipping_method'];
			$selffetch_id = $_POST['selffetch_id'];
			$address_user = $_POST['address_user'];
			$address_tel = $_POST['address_tel'];
			$address_time = $_POST['address_time'];
			$address_id = $_POST['address_id'];
			$comment = $_POST['comment'];
			$coupon_id = $_POST['coupon_id'];
			
			// 是否支付货到付款
			if ((!$store['offline_payment'] || !$is_all_selfproduct) && $_POST['payment_method'] == 'off') {
				echo json_encode(array('status' => false, 'msg' => '此订单不支持货到付款'));
				exit;
			}
			
			if (!empty($address_id) || !empty($selffetch_id) || $shipping_method == 'friend') {
				$data_order = array();
				if ($shipping_method == 'selffetch') {
					//$selffetch = M('Trade_selffetch')->get_selffetch($selffetch_id, $order['store_id']);
					
					// 判断是否为全部自营产品
					if (!$is_all_selfproduct || !$store['buyer_selffetch']) {
						$buyer_selffetch_name = $store['buyer_selffetch_name'] ? $store['buyer_selffetch_name'] : '上门自提';
						echo json_encode(array('status' => false, 'msg' => '此订单不支持' . $buyer_selffetch_name));
						exit;
					}
					
					$selffetch = array();
					if (strpos($selffetch_id, 'store')) {
						$selffetch = M('Store_contact')->get($order['store_id']);
						if (!empty($selffetch)) {
							$store = M('Store')->getStore($order['store_id']);
							$selffetch['tel'] = ($selffetch['phone1'] ? $selffetch['phone1'] . '-' : '') . $selffetch['phone2'];
							$selffetch['business_hours'] = '';
							$selffetch['name'] = $store['name'];
							$selffetch['physical_id'] = 0;
							$selffetch['store_id'] = $order['store_id'];
						}
					} else {
						$selffetch = M('Store_physical')->getOne($selffetch_id);
						if (!empty($selffetch) && $selffetch['store_id'] != $order['store_id']) {
							$selffetch = array();
						} else if(!empty($selffetch)) {
							$selffetch['tel'] = ($selffetch['phone1'] ? $selffetch['phone1'] . '-' : '') . $selffetch['phone2'];
							$selffetch['physical_id'] = $selffetch_id;
							$selffetch['store_id'] = $order['store_id'];
						}
					}
					
					if(empty($selffetch)) {
						echo json_encode(array('status' => false, 'msg' => '该门店不存在'));
						exit;
					}
					$data_order['postage'] = '0';
					$data_order['shipping_method'] = 'selffetch';
					$data_order['address_user'] = $address_user;
					$data_order['address_tel'] = $address_tel;
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
							'date' => substr($address_time, 0, 10),
							'time' => substr($address_time, 11),
							'long' => $selffetch['long'],
							'lat' => $selffetch['lat'],
							'business_hours' => $selffetch['business_hours'],
							'store_id' => $selffetch['store_id'],
							'physical_id' => $selffetch['physical_id'],
					));
					$data_order['comment'] = $comment;
					$data_order['postage'] = 0;
					
					// 到自提点将邮费设置为0
					$order['postage'] = 0;
				} else if ($shipping_method == 'friend') {
					if ($_POST['payment_method'] == 'off') {
						echo json_encode(array('status' => false, 'msg' => '"送朋友"订单不支持货到付款'));
						exit;
					}
					
					if (!$store['open_friend']) {
						echo json_encode(array('status' => false, 'msg' => '店铺没有开启"送朋友"功能'));
						exit;
					}
					
					if (empty($_POST['provinceId']) || empty($_POST['cityId']) || empty($_POST['areaId'])) {
						echo json_encode(array('status' => false, 'msg' => '没有相应的收货地址'));
						exit;
					}
					
					import('source.class.area');
					$area_class = new area();
					
					$address_arr = array();
					$address_arr['address'] = $_POST['address'];
					$address_arr['province'] = $area_class->get_name($_POST['provinceId']);
					$address_arr['province_code'] = $_POST['provinceId'];
					$address_arr['city'] = $area_class->get_name($_POST['cityId']);
					$address_arr['city_code'] = $_POST['cityId'];
					$address_arr['area'] = $area_class->get_name($_POST['areaId']);
					$address_arr['area_code'] = $_POST['areaId'];
					
					$data_order = array();
					$data_order['address'] = serialize($address_arr);
					$data_order['address_user'] = $_POST['address_user'];
					$data_order['address_tel'] = $_POST['address_tel'];
					$data_order['comment'] = $comment;
					$data_order['shipping_method'] = 'friend';
				} else if ($shipping_method == 'express') {
					$address = M('User_address')->getAdressById('', $this->user_session['uid'], $address_id);
					
					if (empty($address)) {
						echo json_encode(array('status' => false, 'msg' => '没有相应的收货地址'));
						exit;
					}
					
					$address_arr = array();
					$address_arr['address'] = $address['address'];
					$address_arr['province'] = $address['province_txt'];
					$address_arr['province_code'] = $address['province'];
					$address_arr['city'] = $address['city_txt'];
					$address_arr['city_code'] = $address['city'];
					$address_arr['area'] = $address['area_txt'];
					$address_arr['area_code'] = $address['area'];
					
					$data_order = array();
					$data_order['address'] = serialize($address_arr);
					$data_order['address_user'] = $address['name'];
					$data_order['address_tel'] = $address['tel'];
					$data_order['comment'] = $comment;
					$data_order['shipping_method'] = 'express';
				} else {
					echo json_encode(array('status' => false, 'msg' => '确认收货地址失败'));
					exit;
				}
				
				if (!empty($data_order)) {
					$result = D('Order')->data($data_order)->where(array('order_id' => $order['order_id']))->save();
					
					if ($result) {
						// 用户享受的优惠券
						$money = 0;
						$pro_num = 0;
						$pro_count = 0;
						foreach ($reward_list as $key => $reward) {
							if ($key === 'product_price_list') {
								continue;
							}
							
							// 积分
							if ($reward['score'] > 0) {
								M('Store_user_data')->changePoint($order['store_id'], $this->user_session['uid'], $reward['score']);
							}
							
							// 送赠品
							if (is_array($reward['present']) && count($reward['present']) > 0) {
								foreach ($reward['present'] as $present) {
									$data_order_product = array();
									$data_order_product['order_id'] = $order['order_id'];
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
								$data_user_coupon['uid'] = $this->user_session['uid'];
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
								$data_user_coupon['give_order_id'] = $order['order_id'];
								
								D('User_coupon')->data($data_user_coupon)->add();
							}
							
							$data = array();
							$data['order_id'] = $order['order_id'];
							$data['uid'] = $this->user_session['uid'];
							$data['rid'] = $reward['rid'];
							$data['name'] = $reward['name'];
							$data['content'] = serialize($reward);
							$money += $reward['cash'];
							D('Order_reward')->data($data)->add();
						}
						
						// 用户使用的优惠券
						foreach ($user_coupon_list as $user_coupon) {
							if ($user_coupon['id'] == $coupon_id) {
								$data = array();
								$data['order_id'] = $order['order_id'];
								$data['uid'] = $this->user_session['uid'];
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
								$data['use_order_id'] = $order['order_id'];
								D('User_coupon')->where(array('id' => $coupon_id))->data($data)->save();
								
								// 更新店铺相应优惠券使用数量
								M('User_coupon')->updateCouponInfo($user_coupon['coupon_id']);
								break;
							}
						}
						
						// 更改订单金额
						$total = max(0, $order['sub_total'] + $order['postage'] + $order['float_amount'] - $money);
						$pro_count = $order['pro_count'] + $pro_count;
						$pro_num = $order['pro_num'] + $pro_num;
						$trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
						
						$data = array();
						$data['trade_no'] = $trade_no;
						$data['status'] = 1;
						$data['total'] = $total;
						$data['pro_count'] = $pro_count;
						$data['pro_num'] = $pro_num;
						
						if ($_POST['payment_method'] == 'off') {
							$data['payment_method'] = 'codpay';
							$data['status'] = 2;
						}
						
						D('Order')->where(array('order_id' => $order['order_id']))->data($data)->save();
						
						echo json_encode(array('status' => true, 'msg' => '确认收货地址成功', 'data' => array('nexturl' => url('order:pay', array('order_id' => $order_id)))));
						exit;
					} else {
						echo json_encode(array('status' => false, 'msg' => '确认收货地址失败'));
						exit;
					}
				} else {
					echo json_encode(array('status' => false, 'msg' => '确认收货地址失败'));
					exit;
				}
			} else {
				echo json_encode(array('status' => false, 'msg' => '确认收货地址失败'));
				exit;
			}
		}
		
		$address_list = '';
		if ($store['open_logistics']) {
			$address_list = M('User_address')->getMyAddress($this->user_session['uid']);
		}
		
		//店铺资料
		if(empty($store)) {
			pigcms_tips('您访问的店铺不存在', 'none');
		}
		//上门自提
		if($store['buyer_selffetch'] && $is_all_selfproduct){
			$selffetch_list = array();// M('Trade_selffetch')->getListNoPage($now_store['store_id']);
			
			$store_contact = M('Store_contact')->get($store['store_id']);
			$store_physical = M('Store_physical')->getList($store['store_id']);
			
			if ($store_contact) {
				$data = array();
				$data['pigcms_id'] = '99999999_store';
				$data['name'] = $store['name'] . '';
				$data['tel'] = ($store_contact['phone1'] ? $store['phone1'] . '-' : '') . $store_contact['phone2'];
				$data['province_txt'] = $store_contact['province_txt'] . '';
				$data['city_txt'] = $store_contact['city_txt'] . '';
				$data['county_txt'] = $store_contact['area_txt'] . '';
				$data['address'] = $store_contact['address'] . '';
				$data['business_hours'] = '';
					
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
						
					$selffetch_list[] = $data;
				}
			}
			//$selffetch_list = M('Trade_selffetch')->getListNoPage($store['store_id']);
			$this->assign('selffetch_list', $selffetch_list);
		}
		
		$this->assign('address_list', $address_list);
		$this->assign('order', $order);
		$this->assign('reward_list', $reward_list);
		$this->assign('user_coupon_list', $user_coupon_list);
		$this->assign('store', $store);
		$this->assign('offline_payment', $offline_payment);
		$this->assign('is_all_selfproduct', $is_all_selfproduct);
		$this->assign('is_all_supplierproduct', $is_all_supplierproduct);
		$this->display();
	}

	// 订单支付
	function pay() {
		$order_id = $_GET['order_id'];	
		if (empty($order_id)) {
			pigcms_tips('缺少最基本的参数');
		}	
		$order_model = M('Order');
		$order = $order_model->find($order_id);
		if (empty($order)) {
			pigcms_tips('未找到要付款的订单');
		}
		if (empty($order['address'])) {
			redirect(url('order:address', array('order_id' => $order_id)));
		}
		
		if ($order['status'] > 1 && $order['payment_method'] != 'codpay') {
			pigcms_tips('此订单无需支付');
		}
		
		if ($order['shipping_method'] == 'selffetch') {
			$store = M('Store')->getStore($order['store_id']);
			$this->assign('store', $store);
		}
		
		$this->assign('order', $order);
		$this->display();
	}


	/**
	 * 订单详情表
	 * 只能查看自己的订单
	 */
	public function detail() {
		$order_id = $_GET['order_id'];
		if (!isset($order_id)) {
			pigcms_tips('缺少最基本的参数');
		}
		
		if (empty($this->user_session)) {
			$referer = url('order:detail', array('order_id' => $order_id));
			redirect(url('account:login', array('referer' => $referer)));
			pigcms_tips('您无权查看此订单', url('account:login'));
		}
		
		
		
		// 只能查看自己的订单
		$order_model = M('Order');
		$order = $order_model->find($order_id);
		
		if (empty($order)) {
			pigcms_tips('未找到相应的订单');
		}
		
		if ($order['uid'] != $this->user_session['uid']) {
			pigcms_tips('您无权查看此订单');
		}
		
		// 查看物流信息
		$order_package = D('Order_package')->where(array('user_order_id' => $order['order_id']))->select();
		
		// 店铺信息
		$store = M('Store')->getStore($order['store_id']);
		
		// 查看满减送
		$order_ward_list = M('Order_reward')->getByOrderId($order['order_id']);
		// 使用优惠券
		$order_coupon = M('Order_coupon')->getByOrderId($order['order_id']);
		
		$this->assign('order', $order);
		$this->assign('store', $store);
		$this->assign('order_package', $order_package);
		$this->assign('order_ward_list', $order_ward_list);
		$this->assign('order_coupon', $order_coupon);
		$this->display();
	}
	
	/**
	 * JSON检测订单状态
	 */
	public function check(){
		$order_id = $_GET['order_id'];
		if (!isset($order_id)) {
			pigcms_tips('缺少最基本的参数');
		}
		
		// 只能查看自己的订单
		$order = M('Order')->find($order_id);
		if($order['status'] > 1){
			json_return(0,'ok');
		}else{
			json_return(1,'error');
		}
	}
	
	/**
	 * 获取物流信息
	 */
	public function express() {
		$type = $_GET['type'];
		$order_no = $_GET['order_no'];
		$express_no = $_GET['express_no'];
		
		if (empty($type) || empty($express_no) || empty($order_no)) {
			echo json_encode(array('status' => false));
			exit;
		}
		
		$express = D('Express')->where(array('code' => $type))->find();
		if (empty($express)) {
			echo json_encode(array('status' => false));
			exit;
		}
		
		$url = 'http://www.kuaidi100.com/query?type=' . $type . '&postid=' . $express_no . '&id=1&valicode=&temp=' . time() . rand(100000, 999999);
		import('class.Express');
		//$content = Http::curlGet($url);
		$content = Express::kuadi100($url);
		$content_arr = json_decode($content, true);
		
		if (empty($content_arr)) {
			echo json_encode(array('status' => false));
			exit;
		} else {
			echo json_encode(array('status' => true, 'data' => $content_arr));
			exit;
		}
	}
}