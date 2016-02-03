<?php
/**
 * 订单
 * User: pigcms_21
 * Date: 2015/3/18
 * Time: 10:32
 */

class OrderAction extends BaseAction
{
	
	public function _initialize() 
	{
		parent::_initialize();
		
		$this->check = array('1' => '未对账', '2' => '已对账');
	}
	
	
	//所有订单（不含临时订单）
	public function index ()
	{
		$this->_orders();
	}

	//到店自提订单（不含临时订单）
	public function selffetch()
	{
		$this->_orders(array('StoreOrder.shipping_method' => 'selffetch'));
	}

	//货到付款订单（不含临时订单）
	public function codpay()
	{
		$this->_orders(array('StoreOrder.payment_method' => 'codpay'));
	}

	//代付的订单（不含临时订单）
	public function payagent()
	{
		$this->_orders(array('StoreOrder.type' => 1));
	}



	
	//订单详细
	public function detail()
	{
		$order = D('OrderView');
		$order_product = D('OrderProductView');
		$package = D('OrderPackage');
		$user = D('User');

		//订单状态
		$status = $order->status();
		//支付方式
		$payment_method = $order->getPaymentMethod();

		$order_id = $this->_get('id');
		$order = $order->where(array('StoreOrder.order_id' => $order_id))->find();

		$products = $order_product->getProducts($order_id);
		$comment_count = 0;
		$product_count = 0;
		foreach ($products as &$product) {
			if (!empty($product['comment'])) {
				$comment_count++;
			}
			$product_count++;

			$product['image'] = getAttachmentUrl($product['image']);
		}

		if (empty($order['uid'])) {
			$is_fans = false;
		} else {
			$is_fans = $user->isWeixinFans($order['uid']);
		}

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
		//订单包裹
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
		$this->assign('is_fans', $is_fans);
		$this->assign('order', $order);
		$this->assign('products', $products);
		$this->assign('rows', $comment_count + $product_count);
		$this->assign('comment_count', $comment_count);
		$this->assign('status', $status);
		$this->assign('payment_method', $payment_method);
		$this->assign('packages', $packages);
		$this->display();
	}

	//订单数据
	private function _orders($where = array())
	{
		$order = D('OrderView');
		//搜索
		$condition = array();
		if(!empty($_GET['type']) && !empty($_GET['keyword'])){
			if($_GET['type'] == 'order_no'){
				$condition['StoreOrder.order_no'] = $_GET['keyword'];
			}else if($_GET['type'] == 'name'){
				$condition['Store.name'] = array('like','%'.$_GET['keyword'].'%');
			}else if($_GET['type'] == 'linkman'){
				$condition['Store.linkman'] = array('like','%'.$_GET['keyword'].'%');
			}
		}
		if (!empty($_GET['status'])) {
			$condition['StoreOrder.status'] = $_GET['status'];
		}
		if (!empty($_GET['is_check'])) {
			$condition['StoreOrder.is_check'] = $_GET['is_check'];
		}		

		//自定义查询条件
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$condition[$key] = $value;
			}
		}
		if ($this->_get('start_time', 'trim') && $this->_get('end_time', 'trim')) {
			$condition['_string'] = "StoreOrder.add_time >= '" . strtotime($this->_get('start_time', 'trim')) . "' AND StoreOrder.add_time <= '" . strtotime($this->_get('end_time')) . "'";
		} else if ($this->_get('start_time', 'trim')) {
			$condition['StoreOrder.add_time'] = array('egt', strtotime($this->_get('start_time', 'trim')));
		} else if ($this->_get('end_time', 'trim')) {
			$condition['StoreOrder.add_time'] = array('elt', strtotime($this->_get('end_time', 'trim')));
		}
		
		//不含临时订单
		$order_count = $order->where($condition)->count();
		import('@.ORG.system_page');
		$page = new Page($order_count, 10);
		$orders = $order->where($condition)->order("StoreOrder.order_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
		
		//订单状态
		$status = $order->status();
		//unset($status[0]);
		$this->assign('page', $page->show());
		$this->assign('orders', $orders);
		$this->assign('status', $status);
	 
		$this->assign('check', $this->check);
		$this->display();
	}

	
	
	public function check() {
		
		$order = D('OrderView');
		//搜索
		$condition = array();
		if(!empty($_GET['type']) && !empty($_GET['keyword'])){
			if($_GET['type'] == 'order_no'){
				$condition['StoreOrder.order_no'] = $_GET['keyword'];
			}else if($_GET['type'] == 'name'){
				$condition['Store.name'] = array('like','%'.$_GET['keyword'].'%');
			}else if($_GET['type'] == 'linkman'){
				$condition['Store.linkman'] = array('like','%'.$_GET['keyword'].'%');
			}
		}
		if (!empty($_GET['status'])) {
			$condition['StoreOrder.status'] = $_GET['status'];
		} else {
			$condition['StoreOrder.status'] = array('gt', 0);
		}
		if (!empty($_GET['is_check'])) {
			$condition['StoreOrder.is_check'] = $_GET['is_check'];
		} else {
			$condition['StoreOrder.is_check'] = array('gt', 0);
		}
		
		//自定义查询条件
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$condition[$key] = $value;
			}
		}
		if ($this->_get('start_time', 'trim') && $this->_get('end_time', 'trim')) {
			$condition['_string'] = "StoreOrder.add_time >= '" . strtotime($this->_get('start_time', 'trim')) . "' AND StoreOrder.add_time <= '" . strtotime($this->_get('end_time')) . "'";
		} else if ($this->_get('start_time', 'trim')) {
			$condition['StoreOrder.add_time'] = array('egt', strtotime($this->_get('start_time', 'trim')));
		} else if ($this->_get('end_time', 'trim')) {
			$condition['StoreOrder.add_time'] = array('elt', strtotime($this->_get('end_time', 'trim')));
		}
		//不含临时订单
		$order_count = $order->where($condition)->count();
		import('@.ORG.system_page');
		$page = new Page($order_count, 10);
		$orders = $order->where($condition)->order("StoreOrder.order_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
		
		//订单状态
		$status = $order->status();
		unset($status[0]);
		$this->assign('page', $page->show());
		$this->assign('orders', $orders);
		$this->assign('status', $status);
		
		$this->assign('check', $this->check);
		$this->display();
	}
	
	
	//对账日志
	public function checklog() {
		$order_check_log = D('OrderCheckLog');
		$condition = array();
		
		
		
		if(!empty($_GET['type']) && !empty($_GET['keyword'])){
			if($_GET['type'] == 'realname'){
				$condition['a.realname'] = array('like','%'.$_GET['keyword'].'%');
			}else if($_GET['type'] == 'account'){
				$condition['a.account'] = array('like','%'.$_GET['keyword'].'%');
			}
		}		
		
		
		
		
		
		
		$order_check_count = $order_check_log->alias("logs")->join(C('DB_PREFIX')."admin a ON a.id = logs.admin_uid")->where($condition)->count('logs.id');
		import('@.ORG.system_page');
		$page = new Page($order_check_count, 20);
		//$OrderCheckList = $order_check_log->where($condition)->limit($page->firstRow, $page->listRows)->order("id desc,timestamp desc")->select();
		$OrderCheckList = $order_check_log->alias("logs")->join(C('DB_PREFIX')."admin a ON a.id = logs.admin_uid")->field("logs.*,a.account,a.realname,a.last_ip")->where($condition)->limit($page->firstRow, $page->listRows)->order("logs.id desc,logs.timestamp desc")->select();
		//echo $order_check_log->getLastSql();

		
		$this->assign('page', $page->show());
		$this->assign('array',$OrderCheckList);
		$this->display();		
		
	}
	
	
	//详细对账抽成比例
	public function alert_check(){
		
		$order = D('OrderView');
		$order_product = D('OrderProductView');
		$package = D('OrderPackage');
		$user = D('User');
		
		//订单状态
		$status = $order->status();
		//支付方式
		$payment_method = $order->getPaymentMethod();
		
		$order_id = $this->_get('id');
		$order = $order->where(array('StoreOrder.order_id' => $order_id))->find();
		
		$products = $order_product->getProducts($order_id);
		$comment_count = 0;
		$product_count = 0;
		foreach ($products as &$product) {
			if (!empty($product['comment'])) {
				$comment_count++;
			}
			$product_count++;
		
			$product['image'] = getAttachmentUrl($product['image']);
		}
		
		if (empty($order['uid'])) {
			$is_fans = false;
		} else {
			$is_fans = $user->isWeixinFans($order['uid']);
		}
		
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
		//订单包裹
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
		$this->assign('is_fans', $is_fans);
		$this->assign('order', $order);
		$this->assign('products', $products);
		$this->assign('rows', $comment_count + $product_count);
		$this->assign('comment_count', $comment_count);
		$this->assign('status', $status);
		$this->assign('payment_method', $payment_method);
		$this->assign('packages', $packages);
		$this->display();
		
	} 
	
	//更改：出账状态
	public function check_status() {
		$order_id = $this->_post('order_id');
		$order_no = $this->_post('order_no');
		$is_check = $this->_post('is_check');
		$store_id = $this->_post('store_id');
		$order = D('Order');
		
		if(empty($order_id) || empty($order_no) || empty($is_check)){
			exit(json_encode(array('error' => 1,'message' =>'缺少必要参数')));
		}
		
		$where = array(
			'order_id' => $order_id,
			'order_no' => $order_no,				
		);
		$order->where($where)->save(array('is_check'=>$is_check));	
		
		$log_where = $where;
		$log_where['store_id'] = $store_id;
		
		
		$this->set_check_log($log_where);
		exit(json_encode(array('error' => 0,'message' =>'已出账')));

		
	}
	
	
	/*description:记录出账日志
	 * 
	 * @arr : 必须包含： order_id,order_no
	 */
	public function set_check_log($arr) {
		
		$check_log = D('OrderCheckLog');
		
		$thisUser = $this->system_session;

		if(empty($arr['order_id']) || empty($arr['order_no']) || empty($thisUser['id'])) {
			
			return false;
		}
		
		$description = "";
		
		$data = array(
			'timestamp' => time(),
			'admin_uid' => 	$thisUser['id'],
			'order_id' => $arr['order_id'],
			'order_no' => $arr['order_no'],
			'ip' => ip2long($_SERVER['REMOTE_ADDR']),
			'description' => $description
		);
		
		if($check_log->add($data)){
			return true;
		}else{
			return false;
		}
		
	}
	
	
} 