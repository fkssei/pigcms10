<?php

/**
 * 订单
 * User: pigcms_21
 * Date: 2015/2/5
 * Time: 10:42
 */
class order_controller extends base_controller {
	public function index() {
		$this->display();
	}

	public function load() {
		$action = strtolower(trim($_POST['page']));
		$status = isset($_POST['status']) ? trim($_POST['status']) : ''; //订单状态
		$shipping_method = isset($_POST['shipping_method']) ? strtolower(trim($_POST['shipping_method'])) : ''; //运送方式 快递发货 上门自提
		$payment_method = isset($_POST['payment_method']) ? strtolower(trim($_POST['payment_method'])) : ''; //支付方式
		$type = isset($_POST['type']) ? $_POST['type'] : '*'; //订单类型 普通订单 代付订单
		$orderbyfield = isset($_POST['orderbyfield']) ? trim($_POST['orderbyfield']) : '';
		$orderbymethod = isset($_POST['orderbymethod']) ? trim($_POST['orderbymethod']) : '';
		$page = isset($_POST['p']) ? intval(trim($_POST['p'])) : 1;
		$order_no = isset($_POST['order_no']) ? trim($_POST['order_no']) : '';
		$trade_no = isset($_POST['trade_no']) ? trim($_POST['trade_no']) : '';
		$user = isset($_POST['user']) ? trim($_POST['user']) : ''; //收货人
		$tel = isset($_POST['tel']) ? trim($_POST['tel']) : ''; //收货人手机
		$time_type = isset($_POST['time_type']) ? trim($_POST['time_type']) : '';
		$start_time = isset($_POST['start_time']) ? trim($_POST['start_time']) : '';
		$stop_time = isset($_POST['stop_time']) ? trim($_POST['stop_time']) : '';
		$weixin_user = isset($_POST['weixin_user']) ? trim($_POST['weixin_user']) : '';

		$data = array(
			'status' => $status,
			'orderbyfield' => $orderbyfield,
			'orderbymethod' => $orderbymethod,
			'page' => $page,
			'order_no' => $order_no,
			'trade_no' => $trade_no,
			'user' => $user,
			'tel' => $tel,
			'time_type' => $time_type,
			'start_time' => $start_time,
			'stop_time' => $stop_time,
			'weixin_user' => $weixin_user,
			'type' => $type,
			'payment_method' => $payment_method,
			'shipping_method' => $shipping_method
		);
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		
		switch ($action) {
			case 'dashboard_content': //订单概况
				$this->_dashboard();
				break;
			case 'statistics_content':
				$this->_statistics_content(array('start_time' => $start_time, 'stop_time' => $stop_time));
				break;
			case 'selffetch_content': //到店自提
				$this->_selffetch_content($data);
				break;
			case 'detail_content':
				$this->_detail_content();
				break;
			case 'all_content':
				$this->_all_content($data);
				break;
			case 'codpay_content':
				$this->_codpay_content($data);
				break;
			case 'buy_agent_content':
				$this->_buy_agent_content($data);
				break;
			case 'star_content':
				$this->_star_content($data);
				break;
			case 'pay_agent_content':
				$this->_pay_agent_content($data);
				break;
			case 'check': case 'check_content':	//对账概况
				$type_check = isset($_POST['type_check']) ? $_POST['type_check'] : 'all'; //订单类型 普通订单 代付订单
				$data['type_check'] = $type_check; 
				$this->_check_content($data);	
				break;	
			default:
				break;
		}
	
		$this->display($_POST['page']);
	}

	//订单概况
	public function dashboard() {
		$this->display();
	}

	//订单详细
	public function detail() {
		$this->display();
	}

	//订单详细页面
	private function _detail_content() {
		$order = M('Order');
		$order_product = M('Order_product');
		$user = M('User');
		$package = M('Order_package');

		$order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
		$order = $order->getOrder($this->store_session['store_id'], $order_id);
		$products = $order_product->getProducts($order_id);
		if (empty($order['uid'])) {
			$order['is_fans'] = false;
			$is_fans = false;
			$order['buyer'] = '';
		} else {
			//$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
			$order['is_fans'] = true;
			$is_fans = true;
			$user_info = $user->checkUser(array('uid' => $order['uid']));
			$order['buyer'] = $user_info['nickname'];
		}

		$is_supplier = false;
		if (!empty($order['suppliers'])) { //订单供货商
			$suppliers = explode(',', $order['suppliers']);
			if (in_array($this->store_session['store_id'], $suppliers)) {
				$is_supplier = true;
			}
		}
		$order['is_supplier'] = $is_supplier;

		$comment_count = 0;
		$product_count = 0;
		$tmp_products = array();
		foreach ($products as $product) {
			if (!empty($product['comment'])) {
				$comment_count++;
			}
			$product_count++;

			$tmp_products[] = $product['original_product_id'];
		}

		$status = M('Order')->status();
		$payment_method = M('Order')->getPaymentMethod();

		if (empty($order['address'])) {
			$status[0] = '未填收货地址';
		} else {
			$status[1] = '已填收货地址';
		}
		if (!empty($order['user_order_id'])) {
			$user_order_id = $order['user_order_id'];
		} else {
			$user_order_id = $order['order_id'];
		}
		$where = array();
		$where['user_order_id'] = $user_order_id;
		$tmp_packages = $package->getPackages($where);
		$packages = array();
		foreach ($tmp_packages as $package) {
			$package_products = explode(',', $package['products']);
			if (array_intersect($package_products, $tmp_products)) {
				$packages[] = $package;
			}
		}
		
		// 查看满减送
		$order_ward_list = M('Order_reward')->getByOrderId($order['order_id']);
		// 使用优惠券
		$order_coupon = M('Order_coupon')->getByOrderId($order['order_id']);
		$this->assign('is_fans', $is_fans);
		$this->assign('order', $order);
		$this->assign('products', $products);
		$this->assign('rows', $comment_count + $product_count);
		$this->assign('comment_count', $comment_count);
		$this->assign('status', $status);
		$this->assign('payment_method', $payment_method);
		$this->assign('packages', $packages);
		$this->assign('order_ward_list', $order_ward_list);
		$this->assign('order_coupon', $order_coupon);
	}

	public function detail_json() {
		$order = M('Order');
		$order_product = M('Order_product');

		$order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
		$order = $order->getOrder($this->store_session['store_id'], $order_id);
		$order['address'] = !empty($order['address']) ? unserialize($order['address']) : '';
		$tmp_products = $order_product->getProducts($order_id);
		$products = array();
		foreach ($tmp_products as $product) {
			$products[] = array(
				'product_id' => $product['product_id'],
				'name'	   => $product['name'],
				'price'	  => $product['pro_price'],
				'quantity'   => $product['pro_num'],
				'skus'	   => !empty($product['sku_data']) ? unserialize($product['sku_data']) : '',
				'url'		=> $this->config['wap_site_url'].'/good.php?id='.$product['product_id'],
			);
		}
		$order['products'] = $products;

		// 查看满减送
		$order_ward_list = M('Order_reward')->getByOrderId($order['order_id']);
		// 使用优惠券
		$order_coupon = M('Order_coupon')->getByOrderId($order['order_id']);
		$money = 0;
		foreach ($order_ward_list as $order_ward) {
			$money += $order_ward['content']['cash'];
		}

		if (!empty($order_coupon)) {
			$money += $order_coupon['money'];
		}

		$order['reward_money'] = round($money, 2);

		echo json_encode($order);
		exit;
	}

	//订单浮动金额
	public function float_amount() {
		$order = M('Order');

		$store_id = $this->store_session['store_id'];
		$order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
		$float_amoumt = isset($_POST['float_amount']) ? floatval(trim($_POST['float_amount'])) : 0;
		$postage = isset($_POST['postage']) ? floatval(trim($_POST['postage'])) : 0;
		$sub_total = isset($_POST['sub_total']) ? floatval(trim($_POST['sub_total'])) : 0;

		// 查看满减送
		$order_ward_list = M('Order_reward')->getByOrderId($order_id);
		// 使用优惠券
		$order_coupon = M('Order_coupon')->getByOrderId($order_id);
		$money = 0;
		foreach ($order_ward_list as $order_ward) {
			$money += $order_ward['content']['cash'];
		}

		if (!empty($order_coupon)) {
			$money += $order_coupon['money'];
		}

		$total = $sub_total + $postage + $float_amoumt - $money;
		$result = $order->setFields($store_id, $order_id, array('postage' => $postage, 'float_amount' => $float_amoumt, 'total' => $total));
		if ($result || $result === 0) {
			json_return(0, array('total' => $total, 'postage' => $postage));
		} else {
			json_return(1001, '修改失败！');
		}
	}

	//所有订单
	public function all() {
		$this->display();
	}

	private function _all_content($data) {
		$order = M('Order');
		$order_product = M('Order_product');
		$user = M('User');
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		if ($data['status'] != '*') {
			$where['status'] = intval($data['status']);
		} else { //所有订单（不包含临时订单）
			$where['status'] = array('>', 0);
		}
		if ($data['order_no']) {
			$where['order_no'] = $data['order_no'];
		}
		if (is_numeric($data['type'])) {
			$where['type'] = $data['type'];
		}
		if (!empty($data['user'])) {
			$where['address_user'] = $data['user'];
		}
		if (!empty($data['tel'])) {
			$where['address_tel'] = $data['tel'];
		}
		if (!empty($data['payment_method'])) {
			$where['payment_method'] = $data['payment_method'];
		}
		if (!empty($data['shipping_method'])) {
			$where['shipping_method'] = $data['shipping_method'];
		}
		$field = '';
		if (!empty($data['time_type'])) {
			$field = $data['time_type'];
		}
		if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
			$where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
		} else if (!empty($data['start_time']) && !empty($field)) {
			$where[$field] = array('>=', strtotime($data['start_time']));
		} else if (!empty($data['stop_time']) && !empty($field)) {
			$where[$field] = array('<=', strtotime($data['stop_time']));
		}
		//排序
		if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
			$orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
		} else {
			$orderby = '`order_id` DESC';
		}
		$order_total = $order->getOrderTotal($where);
		import('source.class.user_page');
		$page = new Page($order_total, 15);
		$tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

		$orders = array();
		foreach ($tmp_orders as $tmp_order) {
			$products = $order_product->getProducts($tmp_order['order_id']);
			$tmp_order['products'] = $products;
			if (empty($tmp_order['uid'])) {
				$tmp_order['is_fans'] = false;
				$tmp_order['buyer'] = '';
			} else {
				//$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
				$tmp_order['is_fans'] = true;
				$user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
				$tmp_order['buyer'] = $user_info['nickname'];
			}
			$is_supplier = false;
			if (!empty($tmp_order['suppliers'])) { //订单供货商
				$suppliers = explode(',', $tmp_order['suppliers']);
				if (in_array($this->store_session['store_id'], $suppliers)) {
					$is_supplier = true;
				}
			}
			$tmp_order['is_supplier'] = $is_supplier;
			$has_my_product = false;
			foreach ($products as &$product) {
				$product['image'] = getAttachmentUrl($product['image']);
				if (empty($product['is_fx'])) {
					$has_my_product = true;
				}
			}

			$tmp_order['products'] = $products;
			$tmp_order['has_my_product'] = $has_my_product;
			if (!empty($tmp_order['user_order_id'])) {
				$order_info = D('Order')->field('store_id')->where(array('order_id' => $tmp_order['user_order_id']))->find();
				$seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
				$tmp_order['seller'] = $seller['name'];
			}
			$orders[] = $tmp_order;
		}

		//订单状态
		$order_status = $order->status();

		//支付方式
		$payment_method = $order->getPaymentMethod();

		$this->assign('order_status', $order_status);
		$this->assign('status', $data['status']);
		$this->assign('payment_method', $payment_method);
		$this->assign('orders', $orders);
		$this->assign('page', $page->show());
	}

	//到店自提
	public function selffetch() {
		$this->display();
	}

	//货到付款订单 cash on delivery
	public function codpay() {
		$this->display();
	}

	//代付的订单
	public function pay_agent() {
		$this->display();
	}

	//订单概况
	public function check() {
		$this->display();
	}
	
	
	//加星订单
	public function star() {
		$this->display();
	}	

	//订单概况
	private function _dashboard() {
		$order = M('Order');
		$financial_record = M('Financial_record');

		$days = array();
		for($i=7; $i>=1; $i--){
			$day = date("Y-m-d",strtotime('-'.$i.'day'));
			$days[] = $day;
		}
		//7天下单笔数
		$where = array();
		//开始时间
		$start_time = strtotime($days[0] . ' 00:00:00');
		//结束时间
		$stop_time = strtotime($days[count($days)-1] . '23:59:59');
		$where['store_id'] = $this->store_session['store_id'];
		$where['status'] = array('>', 0);
		$where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
		$week_orders = $order->getOrderCount($where);

		$this->assign('start_time', date('Y-m-d H:i:s', $start_time));
		$this->assign('stop_time', date('Y-m-d H:i:s', $stop_time));

		//待付款订单数
		$not_paid_orders = $order->getOrderCount(array('store_id' => $this->store_session['store_id'], 'status' => 1));
		//待发货订单数
		$not_send_orders = $order->getOrderCount(array('store_id' => $this->store_session['store_id'], 'status' => 2));
		//已发货订单数
		$send_orders = $order->getOrderCount(array('store_id' => $this->store_session['store_id'], 'status' => 3));

		//7天收入
		$where = array();
		//开始时间
		$start_time = strtotime($days[0] . ' 00:00:00');
		//结束时间
		$stop_time = strtotime($days[count($days)-1] . '23:59:59');
		$where['store_id'] = $this->store_session['store_id'];
		$where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
		$days_7_income = $financial_record->getTotal($where);
		$days_7_income = number_format($days_7_income, 2, '.', '');

		//昨日下单笔数
		$where = array();
		$day = date("Y-m-d",strtotime('-1 day'));
		//开始时间
		$start_time = strtotime($day . ' 00:00:00');
		//结束时间
		$stop_time = strtotime($day . ' 23:59:59');
		$where['store_id'] = $this->store_session['store_id'];
		$where['status'] = array('>', 0);
		$where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
		$yesterday_orders = $order->getOrderCount($where);
		$this->assign('yesterday_start_time', date('Y-m-d H:i:s', $start_time));
		$this->assign('yesterday_stop_time', date('Y-m-d H:i:s', $stop_time));

		//昨日付款订单
		$where['status'] = array('in', array(2,3,4));
		$where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
		$yesterday_paid_orders = $order->getOrderCount($where);

		//昨日发货订单
		$where['status'] = array('in', array(3,4));
		$where['_string'] = "sent_time >= '" . $start_time . "' AND sent_time <= '" . $stop_time . "'";
		$yesterday_send_orders = $order->getOrderCount($where);

		//七天下单、付款、发货订单笔数
		$days_7_orders = array();
		$days_7_paid_orders = array();
		$days_7_send_orders = array();
		$tmp_days = array();
		foreach ($days as $day) {
			//开始时间
			$start_time = strtotime($day . ' 00:00:00');
			//结束时间
			$stop_time = strtotime($day . ' 23:59:59');
			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			$where['status'] = array('>', 0);
			$where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
			$days_7_orders[] = $order->getOrderCount($where);

			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			$where['status'] = array('in', array(2,3,4));
			$where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
			$days_7_paid_orders[] = $order->getOrderCount($where);

			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			$where['status'] = array('in', array(3,4));
			$where['_string'] = "sent_time >= '" . $start_time . "' AND sent_time <= '" . $stop_time . "'";
			$days_7_send_orders[] = $order->getOrderCount($where);

			$tmp_days[] = "'" . $day . "'";
		}
		$days = '[' . implode(',', $tmp_days) . ']';
		$days_7_orders = '[' . implode(',', $days_7_orders) . ']';
		$days_7_paid_orders = '[' . implode(',', $days_7_paid_orders) . ']';
		$days_7_send_orders = '[' . implode(',', $days_7_send_orders) . ']';

		$this->assign('week_orders', $week_orders);
		$this->assign('not_paid_orders', $not_paid_orders);
		$this->assign('not_send_orders', $not_send_orders);
		$this->assign('send_orders', $send_orders);
		$this->assign('yesterday_orders', $yesterday_orders);
		$this->assign('yesterday_paid_orders', $yesterday_paid_orders);
		$this->assign('yesterday_send_orders', $yesterday_send_orders);
		$this->assign('days', $days);
		$this->assign('days_7_orders', $days_7_orders);
		$this->assign('days_7_paid_orders', $days_7_paid_orders);
		$this->assign('days_7_send_orders', $days_7_send_orders);
		$this->assign('days_7_income', $days_7_income);
	}

	//到店自提
	private function _selffetch_content($data) {
		$order = M('Order');
		$order_product = M('Order_product');
		$user = M('User');
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		$where['shipping_method'] = 'selffetch';
		if ($data['status'] != '*') {
			$where['status'] = intval($data['status']);
		} else { //所有订单（不包含临时订单）
			$where['status'] = array('>', 0);
		}
		if ($data['order_no']) {
			$where['order_no'] = $data['order_no'];
		}
		if (is_numeric($data['type'])) {
			$where['type'] = $data['type'];
		}
		if (!empty($data['user'])) {
			$where['address_user'] = $data['user'];
		}
		if (!empty($data['tel'])) {
			$where['address_tel'] = $data['tel'];
		}
		if (!empty($data['payment_method'])) {
			$where['payment_method'] = $data['payment_method'];
		}
		if (!empty($data['shipping_method'])) {
			$where['shipping_method'] = $data['shipping_method'];
		}
		$field = '';
		if (!empty($data['time_type'])) {
			$field = $data['time_type'];
		}
		if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
			$where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
		} else if (!empty($data['start_time']) && !empty($field)) {
			$where[$field] = array('>=', strtotime($data['start_time']));
		} else if (!empty($data['stop_time']) && !empty($field)) {
			$where[$field] = array('<=', strtotime($data['stop_time']));
		}
		//排序
		if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
			$orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
		} else {
			$orderby = '`order_id` DESC';
		}
		$order_total = $order->getOrderTotal($where);
		import('source.class.user_page');
		$page = new Page($order_total, 15);
		$tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

		$orders = array();
		foreach ($tmp_orders as $tmp_order) {
			$products = $order_product->getProducts($tmp_order['order_id']);
			$tmp_order['products'] = $products;
			if (empty($tmp_order['uid'])) {
				$tmp_order['is_fans'] = false;
			} else {
				$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
			}
			$is_supplier = false;
			if (!empty($tmp_order['suppliers'])) { //订单供货商
				$suppliers = explode(',', $tmp_order['suppliers']);
				if (in_array($this->store_session['store_id'], $suppliers)) {
					$is_supplier = true;
				}
			}
			$tmp_order['is_supplier'] = $is_supplier;
			$has_my_product = false;
			foreach ($products as &$product) {
				$product['image'] = getAttachmentUrl($product['image']);
				if (empty($product['is_fx'])) {
					$has_my_product = true;
				}
			}
			$tmp_order['products'] = $products;
			$tmp_order['has_my_product'] = $has_my_product;
			$orders[] = $tmp_order;
			
		}
		
		$order_status = $order->status();

		$payment_method = $order->getPaymentMethod();

		$this->assign('order_status', $order_status);
		$this->assign('status', $data['status']);
		$this->assign('payment_method', $payment_method);
		$this->assign('orders', $orders);
		$this->assign('page', $page->show());
	}

	private function _codpay_content($data) {
		$order = M('Order');
		$order_product = M('Order_product');
		$user = M('User');
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		$where['payment_method'] = 'codpay';
		if ($data['status'] != '*') {
			$where['status'] = intval($data['status']);
		} else { //所有订单（不包含临时订单）
			$where['status'] = array('>', 0);
		}
		if ($data['order_no']) {
			$where['order_no'] = $data['order_no'];
		}
		if (is_numeric($data['type'])) {
			$where['type'] = $data['type'];
		}
		if (!empty($data['user'])) {
			$where['address_user'] = $data['user'];
		}
		if (!empty($data['tel'])) {
			$where['address_tel'] = $data['tel'];
		}
		if (!empty($data['payment_method'])) {
			$where['payment_method'] = $data['payment_method'];
		}
		if (!empty($data['shipping_method'])) {
			$where['shipping_method'] = $data['shipping_method'];
		}
		$field = '';
		if (!empty($data['time_type'])) {
			$field = $data['time_type'];
		}
		if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
			$where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
		} else if (!empty($data['start_time']) && !empty($field)) {
			$where[$field] = array('>=', strtotime($data['start_time']));
		} else if (!empty($data['stop_time']) && !empty($field)) {
			$where[$field] = array('<=', strtotime($data['stop_time']));
		}
		//排序
		if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
			$orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
		} else {
			$orderby = '`order_id` DESC';
		}
		$order_total = $order->getOrderTotal($where);
		import('source.class.user_page');
		$page = new Page($order_total, 15);
		$tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

		$orders = array();
		foreach ($tmp_orders as $tmp_order) {
			$products = $order_product->getProducts($tmp_order['order_id']);
			$tmp_order['products'] = $products;
			if (empty($tmp_order['uid'])) {
				$tmp_order['is_fans'] = false;
				$tmp_order['buyer'] = '';
			} else {
				//$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
				$tmp_order['is_fans'] = true;
				$user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
				$tmp_order['buyer'] = $user_info['nickname'];
			}
			$is_supplier = false;
			if (!empty($tmp_order['suppliers'])) { //订单供货商
				$suppliers = explode(',', $tmp_order['suppliers']);
				if (in_array($this->store_session['store_id'], $suppliers)) {
					$is_supplier = true;
				}
			}
			$tmp_order['is_supplier'] = $is_supplier;
			$has_my_product = false;
			foreach ($products as &$product) {
				$product['image'] = getAttachmentUrl($product['image']);
				if (empty($product['is_fx'])) {
					$has_my_product = true;
				}
			}
			$tmp_order['products'] = $products;
			$tmp_order['has_my_product'] = $has_my_product;
			$orders[] = $tmp_order;
		}

		$order_status = $order->status();

		$payment_method = $order->getPaymentMethod();

		$this->assign('order_status', $order_status);
		$this->assign('status', $data['status']);
		$this->assign('payment_method', $payment_method);
		$this->assign('orders', $orders);
		$this->assign('page', $page->show());
	}

	private function _pay_agent_content($data) {
		$order = M('Order');
		$order_product = M('Order_product');
		$user = M('User');
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		$where['type'] = 1;
		if ($data['status'] != '*') {
			$where['status'] = intval($data['status']);
		} else { //所有订单（不包含临时订单）
			$where['status'] = array('>', 0);
		}
		if ($data['order_no']) {
			$where['order_no'] = $data['order_no'];
		}
		if (is_numeric($data['type'])) {
			$where['type'] = $data['type'];
		}
		if (!empty($data['user'])) {
			$where['address_user'] = $data['user'];
		}
		if (!empty($data['tel'])) {
			$where['address_tel'] = $data['tel'];
		}
		if (!empty($data['payment_method'])) {
			$where['payment_method'] = $data['payment_method'];
		}
		if (!empty($data['shipping_method'])) {
			$where['shipping_method'] = $data['shipping_method'];
		}
		$field = '';
		if (!empty($data['time_type'])) {
			$field = $data['time_type'];
		}
		if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
			$where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
		} else if (!empty($data['start_time']) && !empty($field)) {
			$where[$field] = array('>=', strtotime($data['start_time']));
		} else if (!empty($data['stop_time']) && !empty($field)) {
			$where[$field] = array('<=', strtotime($data['stop_time']));
		}
		//排序
		if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
			$orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
		} else {
			$orderby = '`order_id` DESC';
		}
		$order_total = $order->getOrderTotal($where);
		import('source.class.user_page');
		$page = new Page($order_total, 15);
		$tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

		$orders = array();
		foreach ($tmp_orders as $tmp_order) {
			$products = $order_product->getProducts($tmp_order['order_id']);
			$tmp_order['products'] = $products;
			if (empty($tmp_order['uid'])) {
				$tmp_order['is_fans'] = false;
				$tmp_order['buyer'] = '';
			} else {
				//$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
				$tmp_order['is_fans'] = true;
				$user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
				$tmp_order['buyer'] = $user_info['nickname'];
			}
			$is_supplier = false;
			if (!empty($tmp_order['suppliers'])) { //订单供货商
				$suppliers = explode(',', $tmp_order['suppliers']);
				if (in_array($this->store_session['store_id'], $suppliers)) {
					$is_supplier = true;
				}
			}
			$tmp_order['is_supplier'] = $is_supplier;
			$has_my_product = false;
			foreach ($products as &$product) {
				$product['image'] = getAttachmentUrl($product['image']);
				if (empty($product['is_fx'])) {
					$has_my_product = true;
				}
			}
			$tmp_order['products'] = $products;
			$tmp_order['has_my_product'] = $has_my_product;
			$orders[] = $tmp_order;
		}

		$order_status = $order->status();

		$payment_method = $order->getPaymentMethod();

		$this->assign('order_status', $order_status);
		$this->assign('status', $data['status']);
		$this->assign('payment_method', $payment_method);
		$this->assign('orders', $orders);
		$this->assign('page', $page->show());
	}

	private function _star_content($data) {
		$order = M('Order');
		$order_product = M('Order_product');
		$user = M('User');
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		$where['star'] = array('>', 0);
		if ($data['status'] != '*') {
			$where['status'] = intval($data['status']);
		} else { //所有订单（不包含临时订单）
			$where['status'] = array('>', 0);
		}
		if ($data['order_no']) {
			$where['order_no'] = $data['order_no'];
		}
		if (is_numeric($data['type'])) {
			$where['type'] = $data['type'];
		}
		if (!empty($data['user'])) {
			$where['address_user'] = $data['user'];
		}
		if (!empty($data['tel'])) {
			$where['address_tel'] = $data['tel'];
		}
		if (!empty($data['payment_method'])) {
			$where['payment_method'] = $data['payment_method'];
		}
		if (!empty($data['shipping_method'])) {
			$where['shipping_method'] = $data['shipping_method'];
		}
		$field = '';
		if (!empty($data['time_type'])) {
			$field = $data['time_type'];
		}
		if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
			$where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
		} else if (!empty($data['start_time']) && !empty($field)) {
			$where[$field] = array('>=', strtotime($data['start_time']));
		} else if (!empty($data['stop_time']) && !empty($field)) {
			$where[$field] = array('<=', strtotime($data['stop_time']));
		}
		//排序
		if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
			$orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
		} else {
			$orderby = '`order_id` DESC';
		}
		$order_total = $order->getOrderTotal($where);
		import('source.class.user_page');
		$page = new Page($order_total, 15);
		$tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

		$orders = array();
		foreach ($tmp_orders as $tmp_order) {
			$products = $order_product->getProducts($tmp_order['order_id']);
			$tmp_order['products'] = $products;
			if (empty($tmp_order['uid'])) {
				$tmp_order['is_fans'] = false;
				$tmp_order['buyer'] = '';
			} else {
				//$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
				$tmp_order['is_fans'] = true;
				$user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
				$tmp_order['buyer'] = $user_info['nickname'];
			}
			$is_supplier = false;
			if (!empty($tmp_order['suppliers'])) { //订单供货商
				$suppliers = explode(',', $tmp_order['suppliers']);
				if (in_array($this->store_session['store_id'], $suppliers)) {
					$is_supplier = true;
				}
			}
			$tmp_order['is_supplier'] = $is_supplier;
			$has_my_product = false;
			foreach ($products as &$product) {
				$product['image'] = getAttachmentUrl($product['image']);
				if (empty($product['is_fx'])) {
					$has_my_product = true;
				}
			}
			$tmp_order['products'] = $products;
			$tmp_order['has_my_product'] = $has_my_product;
			$orders[] = $tmp_order;
		}

		$order_status = $order->status();

		$payment_method = $order->getPaymentMethod();

		$this->assign('order_status', $order_status);
		$this->assign('status', $data['status']);
		$this->assign('payment_method', $payment_method);
		$this->assign('orders', $orders);
		$this->assign('page', $page->show());
	}

	//订单备注
	public function save_bak() {
		$order = M('Order');

		$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
		$bak = isset($_POST['bak']) ? trim($_POST['bak']) : '';

		if ($order->setBak($order_id, $bak)) {
			json_return(0, '保存成功');
		} else {
			json_return(1001, '保存失败');
		}
	}

	//订单加星
	public function add_star() {
		$order = M('Order');

		$order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
		$star = isset($_POST['star']) ? intval(trim($_POST['star'])) : 0;

		if ($order->addStar($order_id, $star)) {
			json_return(0, '加星成功');
		} else {
			json_return(1001, '加星失败');
		}
	}

	//取消订单
	public function cancel_status() {
		$order = M('Order');

		$store_id = $this->store_session['store_id'];
		$order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
		$time = time();

		$order_detail = $order->get(array('store_id' => $store_id, 'order_id' => $order_id));

		if ($order->cancelOrder($order_detail, 1)) {
			json_return(0, date('Y-m-d H:i:s', $time));
		} else {
			json_return(1001, date('Y-m-d H:i:s', $time));
		}
	}

	//订单统计
	public function statistics() {
		$this->display();
	}

	public function _statistics_content($data) {
		$order = M('Order');

		$days = array();
		if (empty($data['start_time']) && empty($data['stop_time'])) {
			for($i=7; $i>=1; $i--){
				$day = date("Y-m-d",strtotime('-'.$i.'day'));
				$days[] = $day;
			}
		} else if (!empty($data['start_time']) && !empty($data['stop_time'])) {
			$start_unix_time = strtotime($data['start_time']);
			$stop_unix_time = strtotime($data['stop_time']);
			$tmp_days = round(($stop_unix_time - $start_unix_time) / 3600 / 24);
			$days = array($data['start_time']);
			if ($data['stop_time'] >$data['start_time']) {
				for($i=1; $i<$tmp_days; $i++){
					$days[] = date("Y-m-d",strtotime($data['start_time'] . ' +'.$i.'day'));
				}
				$days[] = $data['stop_time'];
			}
		} else if (!empty($data['start_time'])) { //开始时间到后6天的数据
			$stop_time = date("Y-m-d",strtotime($data['start_time']. ' +7 day'));
			$days = array($data['start_time']);
			for($i=1; $i<=6; $i++){
				$day = date("Y-m-d",strtotime($data['start_time'] .' +' . $i . 'day'));
				$days[] = $day;
			}
		} else if (!empty($data['stop_time'])) { //结束时间前6天的数据
			$start_time = date("Y-m-d",strtotime($data['stop_time']. ' -6 day'));
			$days = array($start_time);
			for($i=1; $i<=6; $i++){
				$day = date("Y-m-d",strtotime($start_time .' +' . $i . 'day'));
				$days[] = $day;
			}
		}

		//七天下单、付款、发货订单笔数和付款金额
		$days_7_orders = array();
		$days_7_paid_orders = array();
		$days_7_send_orders = array();
		$days_7_paid_total = array();
		$tmp_days = array();
		foreach ($days as $day) {
			//开始时间
			$start_time = strtotime($day . ' 00:00:00');
			//结束时间
			$stop_time = strtotime($day . ' 23:59:59');
			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			$where['status'] = array('>', 0);
			$where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
			$days_7_orders[] = $order->getOrderCount($where);

			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			$where['status'] = array('in', array(2,3,4));
			$where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
			$days_7_paid_orders[] = $order->getOrderCount($where);

			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			$where['status'] = array('in', array(3,4));
			$where['_string'] = "sent_time >= '" . $start_time . "' AND sent_time <= '" . $stop_time . "'";
			$days_7_send_orders[] = $order->getOrderCount($where);

			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			$where['status'] = array('in', array(2, 3, 4));
			$where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
			$amount = $order->getOrderAmount($where);
			$days_7_paid_total[] = number_format($amount, 2, '.', '');

			$tmp_days[] = "'" . $day . "'";
		}
		$days = '[' . implode(',', $tmp_days) . ']';
		$days_7_orders = '[' . implode(',', $days_7_orders) . ']';
		$days_7_paid_orders = '[' . implode(',', $days_7_paid_orders) . ']';
		$days_7_send_orders = '[' . implode(',', $days_7_send_orders) . ']';
		$days_7_paid_total = '[' . implode(',', $days_7_paid_total) . ']';

		$this->assign('days', $days);
		$this->assign('days_7_orders', $days_7_orders);
		$this->assign('days_7_paid_orders', $days_7_paid_orders);
		$this->assign('days_7_send_orders', $days_7_send_orders);
		$this->assign('days_7_paid_total', $days_7_paid_total);
	}

	//商品打包
	public function package_product() {
		$order = M('Order');
		$order_product = M('Order_product');
		$express = M('Express');

		//快递公司
		$express = $express->getExpress();

		$order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
		$data = array();
		$order = $order->getOrder($this->store_session['store_id'], $order_id);
		$tmp_products = $order_product->getUnPackageProducts($order_id);
		$products = array();
		foreach ($tmp_products as $tmp_product) {
			$products[] = array(
				'product_id' => $tmp_product['product_id'],
				'name' => $tmp_product['name'],
				'pro_num' => $tmp_product['pro_num'],
				'skus' => unserialize($tmp_product['sku_data'])
			);
		}
		$address = unserialize($order['address']);
		$data['address'] = $address;
		$data['products'] = $products;
		$data['express'] = $express;
		echo json_encode($data);
		exit;
	}

	//创建包裹
	public function create_package() {
		$order = M('Order');
		$fx_order = M('Fx_order');
		$order_product = M('Order_product');
		$order_package = M('Order_package');

		$data = array();
		$data['store_id']		= $this->store_session['store_id'];
		$data['order_id']		= isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
		$data['products']		= isset($_POST['products']) ? trim($_POST['products']) : 0;
		$data['express_company'] = isset($_POST['express_company']) ? trim($_POST['express_company']) : '';
		$data['express_no']	  = isset($_POST['express_no']) ? trim($_POST['express_no']) : '';
		$data['express_code']	= isset($_POST['express_id']) ? trim($_POST['express_id']) : '';
		$data['status']		  = 1; //已发货
		$order_info = $order->getOrder($data['store_id'], $data['order_id']);
		$data['user_order_id']   = !empty($order_info['user_order_id']) ? $order_info['user_order_id'] : $order_info['order_id'];
		$where = array();
		$where['_string'] = "order_id = '" . $data['user_order_id'] . "' OR user_order_id = '" . $data['user_order_id'] . "'";
		$orders = D('Order')->field('order_id,suppliers')->where($where)->select();
		if ($order_package->add($data)) {
			$where = array();
			$where['order_id']   = $data['order_id'];
			$where['product_id'] = array('in', explode(',', $data['products']));
			$result = $order_product->setPackageInfo($where, array('is_packaged' => 1, 'in_package_status' => 1));
			if ($result) {
				$where = array();
				$where['user_order_id'] = $data['user_order_id'];
				$where['original_product_id'] = array('in', explode(',', $data['products']));
				D('Order_product')->where($where)->data(array('is_packaged' => 1, 'in_package_status' => 1))->save();
			}
			/*$package_products = explode(',', $data['products']);
			if (!empty($package_products)) { //打包的商品
				foreach ($package_products as $product_id) {
					$this->_package_product($product_id, $orders);
				}
			}*/

			//获取未打包的商品
			$un_package_products = $order_product->getUnPackageProducts($data['order_id']);
			if (count($un_package_products) == 0) { //已全部打包发货
				$time = time();
				$where = array();
				$where['order_id'] = $data['order_id'];
				$where['status'] = array('!=', 4);
				$order->editStatus($where, array('status' => 3, 'sent_time' => $time));
				/*//单供货商
				$where = array();
				$where['_string'] = "suppliers = '" . $this->store_session['store_id'] . "' AND (order_id = '" . $order_info['user_order_id'] . "' OR user_order_id = '" . $order_info['user_order_id'] . "')";
				$order->editStatus($where, array('status' => 3, 'sent_time' => $time));
				//多供货商
				$where = array();
				$where['_string'] = "FIND_IN_SET(" . $this->store_session['store_id'] . ", suppliers) AND suppliers != '" . $this->store_session['store_id'] . "' AND  (order_id = '" . $order_info['user_order_id'] . "' OR user_order_id = '" . $order_info['user_order_id'] . "') AND packaging = 1";
				$order->editStatus($where, array('status' => 3, 'sent_time' => $time));
				//设置状态为打包中
				$where = array();
				$where['_string'] = "FIND_IN_SET(" . $this->store_session['store_id'] . ", suppliers) AND suppliers != '" . $this->store_session['store_id'] . "' AND  (order_id = '" . $order_info['user_order_id'] . "' OR user_order_id = '" . $order_info['user_order_id'] . "') AND packaging = 0";
				$order->editStatus($where, array('packaging' => 1, 'sent_time' => $time));*/
				//设置订单商品状态为已打包
				foreach ($orders as $tmp_order_info) {
					//查找供货是当前店铺的订单
					if (!empty($tmp_order_info['suppliers']) && in_array($this->store_session['store_id'], explode(',', $tmp_order_info['suppliers']))) {
						//修改订单商品状态
						$where = array();
						$where['order_id']   = $tmp_order_info['order_id'];
						$where['original_product_id'] = array('in', explode(',', $data['products']));
						$order_product->setPackageInfo($where, array('is_packaged' => 1, 'in_package_status' => 1));
					}
				}
				$un_package_product_count = $order_product->getUnPackageProductCount(array('user_order_id' => $data['user_order_id'], 'is_packaged' => 0));
				if ($un_package_product_count == 0) {
					$where = array();
					$where['_string'] = "(order_id = '" . $data['user_order_id'] . "' OR user_order_id = '" . $data['user_order_id'] . "') AND status != 4";
					$order->editStatus($where, array('status' => 3, 'sent_time' => $time));

					if ($order->getOrderCount(array('order_id' => $data['user_order_id'], 'status' => array('in', array(3, 4))))) {
						$user_order_info = $order->get(array('order_id' => $data['user_order_id']));
						M('Store_user_data')->upUserData($user_order_info['store_id'],$user_order_info['uid'],'send'); //修改已发货订单数
					}
				}
				if (!empty($order_info['fx_order_id'])) {
					$fx_order->setPackaged($order_info['fx_order_id']); //设置分销订单状态为已打包
				}
				/*$order->setOrderStatus($data['store_id'], $data['order_id'], array('status' => 3, 'sent_time' => $time)); //修改订单状态为已发货
				if (!empty($order_info['user_order_id'])) { //统一修改订单发货状态
					$where = array();
					//判断订单是否含有店铺自有商品
					$store_products = $order_product->getStoreProduct($order_info['user_order_id']);
					if (!empty($store_products)) { //含有店铺自有商品（不修改发货状态，分销商自行修改）
						$where['_string'] = "order_id != '" . $order_info['user_order_id'] . "' AND user_order_id = '" . $order_info['user_order_id'] . "'";
					} else {
						$where['_string'] = "order_id = '" . $order_info['user_order_id'] . "' OR user_order_id = '" . $order_info['user_order_id'] . "'";
					}
					$order->editStatus($where, array('status' => 3, 'sent_time' => $time));
					//用户订单(判断是否有分销订单)
					$user_order_info = $order->get(array('order_id' => $order_info['user_order_id'], 'is_fx' => 1));
					if (!empty($user_order_info)) {
						$fx_order->setStatus(array('user_order_id' => $order_info['user_order_id']), array('status' => 3, 'supplier_sent_time' => $time));
					}
				}
				if (!empty($order_info['fx_order_id'])) {
					//设置分销订单状态为已打包
					if ($fx_order->setPackaged($order_info['fx_order_id'])) {
						$fx_order_info = $fx_order->getOrderById($order_info['fx_order_id']); //分销商订单
						$where = array();
						$where['order_id']   = $fx_order_info['order_id'];
						$where['product_id'] = array('in', explode(',', $data['products']));
						$order_product->setPackageInfo($where, array('is_packaged' => 1, 'in_package_status' => 1));
						//获取未打包的商品
						$un_package_products = $order_product->getUnPackageProducts($fx_order_info['order_id']);
						if (count($un_package_products) == 0) { //已全部打包发货
							$order->setOrderStatus($fx_order_info['store_id'], $fx_order_info['order_id'], array('status' => 3, 'sent_time' => time())); //修改订单状态为已发货
						}
					}
				}*/
			}
			json_return(0, '包裹创建成功');
		} else {
			json_return(1001, '包裹创建失败');
		}
	}

	//交易完成
	public function complate_status() {
		if (IS_POST) {
			$order = M('Order');
			$order_product = M('Order_product');
			$store = M('Store');
			$fx_order = M('Fx_order');
			$fx_order_product = M('Fx_order_product');
			$store_supplier = M('Store_supplier');
			$financial_record = M('Financial_record');
			$product = M('Product');

			$order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
			if ($order->setFields($this->store_session['store_id'], $order_id, array('status' => 4, 'complate_time' => time()))) {
				//把订单金额添加到商家余额中
				$order_info = $order->getOrder($this->store_session['store_id'], $order_id);
				$fx_order_id = $order_info['fx_order_id']; //分销订单id
				$user_order_id = 0;
				if ($fx_order_id) { //分销订单
					//判断分销商
					$seller = $store_supplier->getSeller(array('seller_id' => $this->store_session['store_id'], 'type' => 1));
					if (empty($seller) && empty($this->store_session['drp_supplier_id'])) { //不是分销商
						$user_order_id = $order_info['user_order_id'];
						$incomes = $financial_record->getOrderIncome($user_order_id);
						//排除订单中分销商自有商品
						$user_order_complated = false; //订单已完成
						$user_order = $order->get(array('order_id' => $user_order_id, 'order', 'is_fx' => 1));
						$order_amount = 0;
						$store_id = 0;
						if (!empty($user_order)) {
							$fx_order_info = $fx_order->getSellerOrder($user_order['store_id'], $user_order['order_id']);
							$fx_order_total = $fx_order_info['total']; //分销商品总额
							$order_amount = $user_order['total'] - $fx_order_total; //店铺自有商品总额
							$store_id = $fx_order_info['store_id'];
							if ($user_order['status'] == 4) {
								$user_order_complated = true;
							}
						}
						$fx_orders = array(); //多供货订单
						//返还分销佣金时需排除店铺自有商品总额
						foreach ($incomes as $income) {
							$tmp_store_id = $income['store_id'];
							$tmp_income = $income['income'];
							//店铺自有商品
							$tmp_fx_order = $fx_order->getSellerOrder($income['store_id'], $income['order_id']);
							$tmp_fx_order_id = $tmp_fx_order['fx_order_id'];
							$tmp_fx_products = $fx_order_product->getProducts($tmp_fx_order_id);
							//订单分销商品
							foreach ($tmp_fx_products as $tmp_fx_product) {
								if (!empty($tmp_fx_product['original_product_id'])) {
									$product_info = $product->get(array('product_id' => $tmp_fx_product['original_product_id']), 'store_id,supplier_id');
									if (!empty($product_info['supplier_id'])) {
										$supplier_id = $product_info['supplier_id']; //商品供货商
									} else {
										$supplier_id = $product_info['store_id']; //商品供货商
									}
								} else {
									$supplier_id = $tmp_fx_product['store_id']; //商品供货商
								}
								if ($supplier_id != $this->store_session['store_id']) { //商品供货商和当前供货商不同
									$tmp_income = $tmp_income - $tmp_fx_product['profit']; //佣金返还交由其他供货商处理
									$fx_orders[] = $income['order_id'];
								}
							}
							//运费
							$tmp_order_info = $order->getOrder($income['store_id'], $income['order_id']);
							$fx_postages = array();
							$fx_postage = 0;
							if (!empty($tmp_order_info['fx_postage'])) {
								$fx_postages = unserialize($tmp_order_info['fx_postage']);
							}
							if (!empty($fx_postages[$tmp_order_info['store_id']])) {
								$fx_postage = !empty($fx_postages[$tmp_order_info['store_id']]) ? $fx_postages[$tmp_order_info['store_id']] : 0; //运费
							}

							//查看当前订单是否有自有商品
							if ($income['store_id'] != $this->store_session['store_id']) {
								$amount = $order_product->getStoreProductAmount($income['order_id']);
								if ($amount > 0) {
									$tmp_income = $tmp_income - $amount - $fx_postage;
									$fx_orders[] = $income['order_id'];
								}
							}
							if ($income['store_id'] == $store_id && $order_amount > 0) {
								$tmp_income = $income['income'] - $order_amount;
							}
							if ($store->setBalanceInc($tmp_store_id, $tmp_income)) {
								//从不可用余额中减去
								$store->setUnBalanceDec($tmp_store_id, $tmp_income);
							}
							//分销利润
							if (!empty($income['profit'])) {
								D('Store')->where(array('store_id' => $tmp_store_id))->setInc('drp_profit', $income['profit']);
							}
						}

						$time = time();
						//修改订单交易状态为“交易完成”
						if ($order_amount == 0 && (empty($fx_orders) || (!empty($fx_orders) && !in_array($user_order_id, $fx_orders)))) { //订单含店铺自有商品
							$order->editStatus(array('order_id' => $user_order_id), array('status' => 4, 'complate_time' => $time));
						}
						if (!empty($fx_orders)) {
							$order->editStatus(array('user_order_id' => $user_order_id, 'order_id' => array('not in', $fx_orders)), array('status' => 4, 'complate_time' => $time));
						} else {
							$order->editStatus(array('user_order_id' => $user_order_id), array('status' => 4, 'complate_time' => $time));
						}
						//修改当前订单状态
						if (!empty($fx_orders)  && in_array($order_id, $fx_orders)) {
							$order->editStatus(array('store_id' => $this->store_session['store_id'], 'order_id' => $order_id, 'status' => array('!=', 4)), array('status' => 3, 'complate_time' => ''));
						}
						//修改分销订单状态为“交易完成”
						$fx_order->setStatus(array('user_order_id' => $user_order_id), array('status' => 4, 'complate_time' => $time));
						//修改交易记录状态
						$where = array();
						if ($order_amount != 0 && $user_order_complated == false) { //订单含店铺自有商品
							$where['order_id'] = array('!=', $user_order_id);
						}
						$where['user_order_id'] = $user_order_id;
						$financial_record->editStatus($where, array('status' => 3));
						//修改已完成订单数
						if ($order->getOrderCount(array('order_id' => $user_order_id, 'status' => 4))) {
							$user_order_info = $order->get(array('order_id' => $user_order_id));
							M('Store_user_data')->upUserData($user_order_info['store_id'],$user_order_info['uid'],'complete');
						};
					} else { //分销商
						//查看当前订单是否有自有商品
						$user_order_id = $order_info['user_order_id'];

						$fx_postages = array();
						$fx_postage = 0;
						if (!empty($order_info['fx_postage'])) {
							$fx_postages = unserialize($order_info['fx_postage']);
						}
						//总运费
						$postage_total = $order_info['postage'];
						if (!empty($fx_postages[$order_info['store_id']])) {
							$fx_postage = $fx_postages[$order_info['store_id']]; //运费
						}
						$other_fx_postage = $postage_total - $fx_postage; //其它供货商运费
						$incomes = $financial_record->getOrderIncome($user_order_id);
						$fx_orders = array(); //多供货订单
						//返还分销佣金时需排除店铺自有商品总额
						foreach ($incomes as $income) {
							$tmp_store_id = $income['store_id'];
							$tmp_income = $income['income'];
							$tmp_fx_order = $fx_order->getSellerOrder($income['store_id'], $income['order_id']);
							$tmp_fx_order_id = $tmp_fx_order['fx_order_id'];
							$tmp_fx_products = $fx_order_product->getProducts($tmp_fx_order_id);
							//订单分销商品
							if (!empty($tmp_fx_products)) {
								$profit = 0;
								foreach ($tmp_fx_products as $tmp_fx_product) {
									if (!empty($tmp_fx_product['original_product_id'])) {
										$product_info = $product->get(array('product_id' => $tmp_fx_product['original_product_id']), 'store_id,supplier_id');
										$supplier_id = $product_info['store_id']; //商品供货商
									} else {
										$supplier_id = $tmp_fx_product['store_id']; //商品供货商
									}
									if ($supplier_id == $this->store_session['store_id']) { //当前供货商
										$profit += $tmp_fx_product['profit']; //分销商品利润
									}
								}

								//商品成本（含运费）
								if ($tmp_store_id == $this->store_session['store_id']) {
									$amount = $order_product->getStoreProductAmount($income['order_id']); //当前店铺自有商品
									$amount = $amount + $fx_postage;
									//添加余额
									if ($store->setBalanceInc($tmp_store_id, $amount)) {
										//从不可用余额中减去
										$store->setUnBalanceDec($tmp_store_id, $amount);
									}
								} else {
									$amount = $order_product->getStoreProductAmount($income['order_id']);
									if ($amount > 0) {
										/*$tmp_fx_postage = $postage_total - (!empty($fx_postages[$tmp_store_id]) ? $fx_postages[$tmp_store_id] : 0);
										$amount = $tmp_income - $amount - $tmp_fx_postage;
										if ($store->setBalanceInc($tmp_store_id, $amount)) {
											//从不可用余额中减去
											$store->setUnBalanceDec($tmp_store_id, $amount);
										}*/
										$fx_orders[] = $income['order_id'];
									}
								}

								//分销利润
								if (!empty($profit)) {
									//添加余额
									if ($store->setBalanceInc($tmp_store_id, $profit)) {
										//从不可用余额中减去
										$store->setUnBalanceDec($tmp_store_id, $profit);
									}
									//分销利润
									if (!empty($income['profit'])) {
										D('Store')->where(array('store_id' => $tmp_store_id))->setInc('drp_profit', $income['profit']);
									}
								}
							} else if (empty($tmp_fx_products) && $tmp_store_id == $this->store_session['store_id']) { //供货商
								//添加余额
								$tmp_income = $tmp_income - $other_fx_postage; //减其他供货商运费
								if ($store->setBalanceInc($tmp_store_id, $tmp_income)) {
									//从不可用余额中减去
									$store->setUnBalanceDec($tmp_store_id, $tmp_income);
								}
								//分销利润
								if (!empty($income['profit'])) {
									D('Store')->where(array('store_id' => $tmp_store_id))->setInc('drp_profit', $income['profit']);
								}
							}
						}

						$time = time();
						$where = array();
						if (!empty($fx_orders)) {
							$where['order_id'] = array('not in', $fx_orders);
						}
						$where['_string'] = "(order_id = '" . $user_order_id . "' OR user_order_id = '" . $user_order_id . "') AND FIND_IN_SET(" . $this->store_session['store_id'] . ", suppliers)";
						$orders = $order->getAllOrders($where);
						if (!empty($orders)) {
							$order->editStatus($where, array('status' => 4, 'complate_time' => $time));
							foreach ($orders as $tmp_order) {
								$where = array();
								$where['order_id'] = $tmp_order['order_id'];
								$where['_string'] = "FIND_IN_SET(" . $this->store_session['store_id'] . ", suppliers)";
								$fx_order->setStatus($where, array('status' => 4, 'complate_time' => $time));
								$financial_record->editStatus(array('order_id' => $tmp_order['order_id']), array('status' => 3));
							}
						}

						//修改已完成订单数
						if ($order->getOrderCount(array('order_id' => $user_order_id, 'status' => 4))) {
							$user_order_info = $order->get(array('order_id' => $user_order_id));
							M('Store_user_data')->upUserData($user_order_info['store_id'],$user_order_info['uid'],'complete');
						};
					}
					//计算商品的分销总利润
					if (!empty($user_order_id)) {
						//查找订单中的分销商品
						$fx_products = D('Order_proudct')->field('pro_price,pro_num,original_product_id')->where(array('order_id' => $user_order_id, 'is_fx' => 1))->select();
						if (!empty($fx_products)) {
							foreach ($fx_products as $fx_product) {
								if ($fx_product['sku_data']) {
									$sku_data = unserialize($fx_product['sku_data']);
									$skus = array();
									foreach($sku_data as $sku) {
										$skus[] = $sku['pid'] . ':' . $sku['vid'];
									}
									$properties = implode(';', $skus);
									$sku = M('Product_sku')->getSku($fx_product['original_product_id'], $properties);
									$cost_price = !empty($sku['cost_price']) ? $sku['cost_price'] : 0;
								} else {
									$original_product = D('Product')->field('cost_price')->where(array('product_id' => $fx_product['original_product_id']))->find();
									$cost_price = !empty($original_product['cost_price']) ? $original_product['cost_price'] : 0;
								}
								$fx_profit_total = ($fx_product['pro_price'] - $cost_price) * $fx_product['pro_num'];
								if ($fx_profit_total > 0) {
									D('Product')->where(array('product_id' => $fx_product['original_product_id']))->setInc('drp_profit', $fx_profit_total);
								}
							}
						}
					}
				} else if ($order_info['is_fx']) { //有分销商的订单(去除分销金额，分销部分由供货商处理)
					//订单总金额
					$order_total = $order_info['total'];
					$fx_order_info = $fx_order->getSellerOrder($this->store_session['store_id'], $order_id);
					$fx_order_total = $fx_order_info['total'];
					$order_amount = $order_total - $fx_order_total; //普通商品金额
					if ($order_amount > 0) {
						//添加余额
						if ($store->setBalanceInc($this->store_session['store_id'], $order_amount)) {
							//从不可用余额中减去
							$store->setUnBalanceDec($this->store_session['store_id'], $order_amount);
						}
						//修改交易记录状态
						M('Financial_record')->setStatus($this->store_session['store_id'], $order_id, 3);
					}
				} else { //普通订单
					$order_amount = $order_info['total'];
					$order_amount = !empty($order_amount) ? $order_amount : 0;
					//添加余额
					if ($store->setBalanceInc($this->store_session['store_id'], $order_amount)) {
						//从不可用余额中减去
						$store->setUnBalanceDec($this->store_session['store_id'], $order_amount);

						//修改订单交易状态为“交易完成”
						//M('Order')->setStatus($this->store_session['store_id'], $order_info['order_id'], 4);
						//修改交易记录状态
						M('Financial_record')->setStatus($this->store_session['store_id'], $order_id, 3);
						//修改已完成订单数
						M('Store_user_data')->upUserData($order_info['store_id'],$order_info['uid'],'complete');
					}
				}
				/*if (empty($user_order_id)) {
					//修改订单交易状态为“交易完成”
					M('Order')->setStatus($this->store_session['store_id'], $order_info['order_id'], 4);
					//修改分销订单状态为“交易完成”
					M('Fx_order')->setStatus(array('fx_order_id' => $fx_order_id), array('status' => 4, 'complate_time' => time()));
					//修改交易记录状态
					M('Financial_record')->setStatus($this->store_session['store_id'], $order_id, 3);
				}*/

				require_once PIGCMS_PATH . 'api/msg.php';
				$store = M('Store');
				$store = $store->getStore($order_info['store_id']);
				$user = M('User');
				$seller = $user->getUserById($store['uid']);
				$buyer = $user->getUserById($order_info['uid']);
				if (!empty($seller['token']) && !empty($buyer['third_id']) && !empty($order_info['address_tel'])) {
					send($seller['notify_url'], $buyer['third_id'], $seller['token'], 3, '', '订单完成通知', $order_info['address_tel'], $this->store_session['tel'], $order_info, '', '测试订单');
				}

				// 如果 是货到付款，交易完成更改库存和销量
				if ($order_info['payment_method'] == 'codpay') {
					$product_list = M('Order_product')->orderProduct($order_info['order_id']);
					$database_product = D('Product');
					$database_product_sku = D('Product_sku');
					
					if (!empty($product_list)) {
						foreach ($product_list as $value) {
							if($value['sku_id']){
								$condition_product_sku['sku_id'] = $value['sku_id'];
								$database_product_sku->where($condition_product_sku)->setInc('sales',$value['pro_num']);
								$database_product_sku->where($condition_product_sku)->setDec('quantity',$value['pro_num']);
							}
							$condition_product['product_id'] = $value['product_id'];
							$database_product->where($condition_product)->setInc('sales',$value['pro_num']);
							$database_product->where($condition_product)->setDec('quantity',$value['pro_num']);
						}
					}
				}
				
				json_return(0, '订单状态修改成功');
			} else {
				json_return(1001, '订单状态修改失败');
			}
		}
	}

	/*private function _package_product($product_id, $orders)
	{
		//分销源商品
		$product = M('Product')->get(array('source_product_id' => $product_id), 'product_id,source_product_id');
		if (!empty($product['source_product_id'])) {
			foreach ($orders as $order) {
				D('Order_product')->where(array('order_id' => $order['order_id'], 'product_id' => $product_id))->data(array('is_packaged' => 1, 'in_package_status' => 1))->save();
			}
			$this->_package_product($product['product_id'], $orders);
		} else {
			foreach ($orders as $order) {
				D('Order_product')->where(array('order_id' => $order['order_id'], 'product_id' => $product_id))->data(array('is_packaged' => 1, 'in_package_status' => 1))->save();
			}
		}
	}*/
	
   //订单概况
	private function _check_content($data) {
		
		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$type = $_REQUEST['type_check'];
		$keyword = $_REQUEST['keyword'];
		$limit = 1;


		switch($type) {
			
			case 'check':
					$data['is_check'] = 2;
				break;
			
			case 'uncheck':
					$data['is_check'] = 1;
				break;	
			
		}
	
		$order = M('Order');
		$order_product = M('Order_product');
		$user = M('User');
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];

		
		$where['status'] = array('in',array('4'));
		if($data['is_check']) $where['is_check'] = $data['is_check'];
		
		
		if ($data['order_no']) {
			$where['order_no'] = $data['order_no'];
		}
		if (is_numeric($data['type'])) {
			$where['type'] = $data['type'];
		}
		if (!empty($data['user'])) {
			$where['address_user'] = $data['user'];
		}
		if (!empty($data['tel'])) {
			$where['address_tel'] = $data['tel'];
		}
		if (!empty($data['payment_method'])) {
			$where['payment_method'] = $data['payment_method'];
		}
		if (!empty($data['shipping_method'])) {
			$where['shipping_method'] = $data['shipping_method'];
		}
		$field = '';
		if (!empty($data['time_type'])) {
			$field = $data['time_type'];
		}
		if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
			$where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
		} else if (!empty($data['start_time']) && !empty($field)) {
			$where[$field] = array('>=', strtotime($data['start_time']));
		} else if (!empty($data['stop_time']) && !empty($field)) {
			$where[$field] = array('<=', strtotime($data['stop_time']));
		}
		//排序
		if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
			$orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
		} else {
			$orderby = '`order_id` DESC';
		}
	
		$order_total = $order->getOrderTotal($where);
		
		import('source.class.user_page');
		$page = new Page($order_total, 15);
		$tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

		$orders = array();
		
		
		
		foreach ($tmp_orders as $tmp_order) {
			$products = $order_product->getProducts($tmp_order['order_id']);
			$tmp_order['products'] = $products;
			if (empty($tmp_order['uid'])) {
				$tmp_order['is_fans'] = false;
				$tmp_order['buyer'] = '';
			} else {
				//$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
				$tmp_order['is_fans'] = true;
				$user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
				$tmp_order['buyer'] = $user_info['nickname'];
			}
			$is_supplier = false;
			if (!empty($tmp_order['suppliers'])) { //订单供货商
				$suppliers = explode(',', $tmp_order['suppliers']);
				if (in_array($this->store_session['store_id'], $suppliers)) {
					$is_supplier = true;
				}
			}
			$tmp_order['is_supplier'] = $is_supplier;
			$has_my_product = false;
			foreach ($products as &$product) {
				$product['image'] = getAttachmentUrl($product['image']);
				if (empty($product['is_fx'])) {
					$has_my_product = true;
				}
			}

			$tmp_order['products'] = $products;
			$tmp_order['has_my_product'] = $has_my_product;
			if (!empty($tmp_order['user_order_id'])) {
				$order_info = D('Order')->field('store_id')->where(array('order_id' => $tmp_order['user_order_id']))->find();
				$seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
				$tmp_order['seller'] = $seller['name'];
			}
			$orders[] = $tmp_order;
		}

		//订单状态
		$order_status = $order->status();

		//支付方式
		$payment_method = $order->getPaymentMethod();

		$this->assign('order_status', $order_status);
		$this->assign('status', $data['status']);
		$this->assign('payment_method', $payment_method);
		$this->assign('orders', $orders);
		$this->assign('page', $page->show());

		

	//	$this->assign('type', $type);
	//	$this->assign('pages', $pages);
	//	$this->assign('unique_person_have', $unique_person_have);
	//	$this->assign('keyword', $keyword);
	//	$this->assign('coupon_list', $coupon_list);
	}	
}