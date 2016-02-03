<?php
/**
 * Created by PhpStorm.
 * description: 购物车
 * User: pigcms-s
 * Date: 2015/5/23
 * Time: 9:50
 */

class cart_controller extends base_controller{
	function __construct() {
		parent::__construct();
	}
	
	
	public function one() {
		if (empty($this->user_session)) {
			$referer = url('cart:one');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}
		
		// 查出购物车里的产品
		$cart_list = D('')->field('c.pigcms_id, c.store_id, c.product_id, c.pro_num, c.pro_price, c.sku_id, c.sku_data, p.name, p.image')->table(array('Product' => 'p', 'User_cart' => 'c'))->where("`p`.`product_id` = `c`.`product_id` AND c.uid = '" . $this->user_session['uid'] . "'")->select();
		
		if (empty($cart_list)) {
			//pigcms_tips('你的购物为空', '');
		}
		
		// 对产品按商铺进行分组
		$cart_store_list = array();
		$stort_id_list = array();
		$total = 0;
		$total_money = 0;
		foreach ($cart_list as $cart) {
			$cart['sku_data'] = unserialize($cart['sku_data']);
			$cart['image'] = getAttachmentUrl($cart['image']);
			$cart_store_list[$cart['store_id']][] = $cart;
			
			$stort_id_list[$cart['store_id']] = $cart['store_id'];
			
			$total += $cart['pro_num'];
			$total_money += $cart['pro_num'] * $cart['pro_price'];
		}
		
		$store_name_list = M('Store')->getStoreName($stort_id_list);
		
		$this->assign('cart_store_list', $cart_store_list);
		$this->assign('store_name_list', $store_name_list);
		$this->assign('total', $total);
		$this->assign('total_money', $total_money);
		$this->assign('step', 'one');
		$this->display();
	}
	
	public function two() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => false, 'msg' => 'nologin'));
			exit;
		}
		
		$id = $_POST['id'];
		
		if (empty($id)) {
			echo json_encode(array('status' => false, 'msg' => '提交信息不正确'));
			exit;
		}
		
		$user_cart_list = D('User_cart')->where(array('pigcms_id' => array('in', $id), 'uid' => $this->user_session['uid']))->select();
		if (empty($user_cart_list)) {
			echo json_encode(array('status' => false, 'msg' => '提交的购物车为空'));
			exit;
		}
		
		$store_id = 0;
		$total = 0;
		$total_money = 0;
		$product_list = array();
		foreach ($user_cart_list as $key => &$user_cart) {
			if ($key == 0) {
				$store_id = $user_cart['store_id'];
			} else if ($store_id != $user_cart['store_id']) {
				echo json_encode(array('status' => false, 'msg' => '暂时只支持单店铺提交订单'));
				exit;
			}
			
			
			$product = D('Product')->where(array('product_id' => $user_cart['product_id'], 'status' => 1))->find();
			if (empty($product)) {
				echo json_encode(array('status' => false, 'msg' => '未找到相应的产品'));
				exit;
			}
			
			// 限购
			if ($product['buyer_quota']) {
				$number = M('Order_product')->getProductPronum($product['product_id'], $this->user_session['uid']);
				
				if ($number + $user_cart['pro_num'] > $product['buyer_quota']) {
					echo json_encode(array('status' => false, 'msg' => '对不起，您超出了限购'));
					exit;
				}
			}
			
			$sku = array();
			// 查找库存
			if ($product['has_property'] == 0) {
				if ($product['quantity'] < $user_cart['pro_num']) {
					echo json_encode(array('status' => false, 'msg' => $product['name'] . '的库存不足'));
					exit;
				}
			} else {
				$sku = D('Product_sku')->where(array('sku_id' => $user_cart['sku_id']))->find();
				if ($sku['quantity'] < $user_cart['pro_num']) {
					echo json_encode(array('status' => false, 'msg' => $product['name'] . '的库存不足'));
					exit;
				}
			}
			
			$product_list[$product['product_id']] = $product['product_id'];
			
			$total += $user_cart['pro_num'];
			$total_money += $user_cart['pro_price'] * $user_cart['pro_num'];
			
			$user_cart['product'] = $product;
			$user_cart['sku'] = $sku;
			$user_cart['sku_data'] = $user_cart['sku_data'];
		}
		
		$store = M('Store')->getStore($store_id);
		if (empty($store['buyer_selffetch']) && empty($store['open_logistics'])) {
			echo json_encode(array('status' => false, 'msg' => '店铺未设置物流配送方式，暂时不能购买'));
			exit;
		}
		
		//-----------------------------------------------------
		// 在提交购物车的内容手就产生订单，无须到第二步确认订单
		// 生成订单
		$order_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000,999999);
		$data_order['store_id'] = $store_id;
		$data_order['order_no'] = $data_order['trade_no'] = $order_no;
		$data_order['uid'] = $this->user_session['uid'];
		$data_order['sub_total'] = $total_money;
		$data_order['pro_num'] = $total;
		$data_order['pro_count'] = count($product_list);
		$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
				
		$database = D('Order');
		$order_id = $database->data($data_order)->add();
		if(empty($order_id)){
			echo json_encode(array('status' => false, 'msg' => '订单产生失败'));
			exit;
		}
		
		M('Store_user_data')->upUserData($data_order['store_id'], $this->user_session['uid'], 'unpay');
		
		$database_order_product = D('Order_product');
		$database_product = D('Product');
		$data_order_product['order_id'] = $order_id;
		$suppliers = array();
		foreach($user_cart_list as $value){
			$product_info = $database_product->field('store_id, original_product_id, weight')->where(array('product_id' => $value['product_id']))->find();
			if (!empty($product_info['original_product_id'])) {
				$tmp_product_info = $database_product->field('store_id')->where(array('product_id' => $product_info['original_product_id']))->find();
				$supplier_id = $tmp_product_info['store_id'];
				$original_product_id = $product_info['original_product_id'];
			} else {
				$supplier_id = $product_info['store_id'];
				$original_product_id = $value['product_id'];
			}
			
			$data_order_product['supplier_id'] = $supplier_id;
			$data_order_product['original_product_id'] = $original_product_id;
			$data_order_product['user_order_id'] = $order_id;
			$suppliers[] = $supplier_id;
			$data_order_product['product_id'] = $value['product_id'];
			$data_order_product['sku_id'] = $value['sku_id'];
			$data_order_product['sku_data'] = $value['sku_data'];
			$data_order_product['pro_num'] = $value['pro_num'];
			$data_order_product['pro_price'] = $value['pro_price'];
			$data_order_product['comment'] = !empty($value['comment']) ? $value['comment'] : '';
			$data_order_product['is_fx'] = $value['is_fx']; //是否是分销商品
			$data_order_product['pro_weight'] = $product_info['weight'];
			$database_order_product->data($data_order_product)->add();
		}
		
		
		$suppliers = array_unique($suppliers); //分销商
		$suppliers = implode(',', $suppliers);
		if (!empty($suppliers)) { //修改订单，设置分销商
			$database->where(array('order_id' => $order_id))->data(array('suppliers' => $suppliers))->save();
		}
		
		$condition_user_cart = array('uid' => $this->user_session['uid'], 'pigcms_id' => array('in', $id));
		D('User_cart')->where($condition_user_cart)->delete();
		
		// 产生提醒
		import('source.class.Notify');
		Notify::createNoitfy($product['store_id'], option('config.orderid_prefix') . $order_no);
		
		//redirect(url('order:address', array('order_id' => option('config.orderid_prefix') . $order_no)));
		echo json_encode(array('status' => true, 'data' => array('order_no' => option('config.orderid_prefix') . $order_no)));
		exit;
		//----------------------------------------------------
		
		
		
		$user_address_list = M('User_address')->select('', $this->user_session['uid']);
		$this->assign('user_address_list', $user_address_list);
		$this->assign('user_cart_list', $user_cart_list);
		$this->assign('total', $total);
		$this->assign('total_money', $total_money);
		$this->assign('step', 'two');
		$this->display();
	}
	
	// 产生订单过程
	public function three() {
		$id = $_POST['id'];
		$address_id = $_POST['address_id'];
		
		if (empty($id)) {
			pigcms_tips('提交信息不正确', url('cart:one'));
		}
		
		$user_cart_list = D('User_cart')->where(array('pigcms_id' => array('in', $id), 'uid' => $this->user_session['uid']))->select();
		$store_id = 0;
		$total = 0;
		$total_money = 0;
		$count = 0;
		
		foreach ($user_cart_list as $key => &$user_cart) {
			if ($key == 0) {
				$store_id = $user_cart['store_id'];
			} else if ($store_id != $user_cart['store_id']) {
				pigcms_tips('暂时只支持单店铺提交订单', url('cart:one'));
			}
				
				
			$product = D('Product')->where(array('product_id' => $user_cart['product_id'], 'status' => 1))->find();
			if (empty($product)) {
				pigcms_tips('未找到相应的产品', url('cart:one'));
			}
				
			$sku = array();
			// 查找库存
			if ($product['has_property'] == 0) {
				if ($product['quantity'] < $user_cart['pro_num']) {
					pigcms_tips($product['name'] . '的库存不足', url('cart:one'));
				}
			} else {
				$sku = D('Product_sku')->where(array('sku_id' => $user_cart['sku_id']))->find();
				if ($sku['quantity'] < $user_cart['pro_num']) {
					pigcms_tips($product['name'] . '的库存不足', url('cart:one'));
				}
			}
				
			$total += $user_cart['pro_num'];
			$total_money += $user_cart['pro_price'] * $user_cart['pro_num'];
			$count++;
			
				
			$user_cart['product'] = $product;
			$user_cart['sku'] = $sku;
			$user_cart['sku_data'] = unserialize($user_cart['sku_data']);
		}
		
		// 收货地址
		$address = M('User_address')->getAdressById('', $this->user_session['uid'], $address_id);
		
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
		
		// 生成订单
		$order_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000,999999);
		$data_order['store_id'] = $store_id;
		$data_order['order_no'] = $data_order['trade_no'] = $order_no;
		$data_order['uid'] = $this->user_session['uid'];
		$data_order['sub_total'] = $total_money;
		$data_order['pro_num'] = $total;
		$data_order['pro_count'] = $count;
		$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
		$data_order['address'] = serialize($address_arr);
		$data_order['address_user'] = $address['name'];
		$data_order['address_tel'] = $address['tel'];
		
		$database = D('Order');
		$order_id = $database->data($data_order)->add();
		if(empty($order_id)){
			pigcms_tips('订单产生失败', url('cart:one'));
		}

		M('Store_user_data')->upUserData($data_order['store_id'], $this->user_session['uid'], 'unpay');
		
		$database_order_product = D('Order_product');
		$database_product = D('Product');
		$data_order_product['order_id'] = $order_id;
		$suppliers = array();
		foreach($user_cart_list as $value){
			$product_info = $database_product->field('store_id, original_product_id')->where(array('product_id' => $value['product_id']))->find();
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
			$database_order_product->data($data_order_product)->add();
		}
		
		
		$suppliers = array_unique($suppliers); //分销商
		$suppliers = implode(',', $suppliers);
		if (!empty($suppliers)) { //修改订单，设置分销商
			$database->where(array('order_id' => $order_id))->data(array('suppliers' => $suppliers))->save();
		}
		
		$condition_user_cart = array('uid' => $this->user_session['uid'], 'pigcms_id' => array('in', $id));
		D('User_cart')->where($condition_user_cart)->delete();
		
		// 添加成功后进行跳转
		redirect(url('order:pay', array('order_id' => option('config.orderid_prefix') . $order_no)));
	}

	// 更改购物车数量
	public function change() {
		$id = $_GET['id'] + 0;
		$number = $_GET['number'] + 0;
		
		
		if (empty($id)) {
			echo json_encode(array('status' => false, 'msg' => '参数错误'));
			exit;
		}
		
		$user_cart = D('User_cart')->where(array('uid' => $this->user_session['uid'], 'pigcms_id' => $id))->find();
		if (empty($user_cart)) {
			echo json_encode(array('status' => false, 'msg' => '购物车未找到产品'));
			exit;
		}
		
		// 直接删除
		if ($number == 0) {
			D('User_cart')->where(array('uid' => $this->user_session['uid'], 'pigcms_id' => $id))->delete();
			
			echo json_encode(array('status' => true, 'msg' => '删除购买此产品完成', 'data' => array('nexturl' => 'refresh')));
			exit;
		}
		
		$product = D('Product')->where(array('product_id' => $user_cart['product_id']))->find();
		if (empty($product)) {
			echo json_encode(array('status' => false, 'msg' => '未找到相应产品'));
			exit;
		}
		
		// 限购
		if ($product['buyer_quota']) {
			// 查找已经购买的数量
			$order_product_number = M('Order_product')->getProductPronum($user_cart['product_id'], $this->user_session['uid']);
			
			if ($number + $order_product_number > $product['buyer_quota']) {
				echo json_encode(array('status' => false, 'msg' => '对不起，您超出了限购'));
				exit;
			}
		}
		
		// 查找库存,如果sku_id为0时，也就是没有属性，直接查找产品表的库存
		
		if ($user_cart['sku_id'] == 0) {
			if ($product['quantity'] < $number) {
				echo json_encode(array('status' => false, 'msg' => '库存不足'));
				exit;
			}
			
		} else {
			$product_sku = D('Product_sku')->where(array('sku_id' => $user_cart['sku_id']))->find();
			if ($product_sku['quantity'] < $number) {
				echo json_encode(array('status' => false, 'msg' => '库存不足'));
				exit;
			}
		}
		
		D('User_cart')->data(array('pro_num' => $number))->where(array('uid' => $this->user_session['uid'], 'pigcms_id' => $id))->save();
		
		// 查出购物车里的产品
		//$user_cart_count = D('User_cart')->field('sum(pro_num) as total, sum(pro_num * pro_price) as money')->where("uid = '" . $this->user_session['uid'] . "'")->find();

		//$data['total'] = $user_cart_count['total'] + 0;
		//$data['money'] = $user_cart_count['money'] + 0;
		echo json_encode(array('status' => true, 'msg' => '更改完成'));
		exit;
	}
	
	
	// 清空购物车
	public function clear() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => false, 'msg' => '请先登录', 'data' => array('nexturl' => 'login')));
		}
		D('User_cart')->where(array('uid' => $this->user_session['uid']))->delete();
		
		echo json_encode(array('status' => true, 'msg' => '清空购物车成功'));
	}

    public function load() {
        parent::__construct();
        $action = strtolower(trim($_GET['action']));
;
        if (empty($action)) pigcms_tips('非法访问！', 'none');
        switch ($action) {

            case 'cartone': //购物车第一步
                $this->_cartOne();
                break;

            case 'carttwo': //购物车第二步
                $this->_cartTwo();
                break;

            case 'cartthree': //购物车第三步
                $this->_cartThree();
                break;
        }

        $this->assign('step',$action);

        $this->display($_GET['action']);

    }



    //加入购物车
    public function addCart() {


    }

    //清除出购物车
    private function delCart() {


    }

    //购物车第一步
    private function  _cartOne(){
      //  echo "购物车";
       // $this->display();
    }



    //购物车第二步
    private  function _cartTwo(){



    }


    //购物车第三步
    private  function _cartThree(){



    }








}