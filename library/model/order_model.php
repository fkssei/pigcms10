<?php

/**
 * 订单数据模型
 */
class order_model extends base_model{
	/*得到一个订单信息,包含订单里的商品*/
	public function find($order_no){
		$nowOrder = $this->findSimple($order_no);
		if(!empty($nowOrder)){
			$nowOrder['proList'] = M('Order_product')->orderProduct($nowOrder['order_id']);
			return $nowOrder;
		}else{
			return array();
		}
	}
	/*得到一个订单信息*/
	public function findSimple($order_no){
		$order_no = preg_replace('#'.option('config.orderid_prefix').'#','',$order_no,1,$count);
		if($count == 0) return array();
		$nowOrder = $this->db->where(array('order_no'=>$order_no))->find();
		if(!empty($nowOrder)){
			$nowOrder['order_no_txt'] = option('config.orderid_prefix').$nowOrder['order_no'];
			if($nowOrder['payment_method']) $nowOrder['pay_type_txt'] = $this->get_pay_name($nowOrder['payment_method']);
			return $nowOrder;
		}else{
			return array();
		}
	}
	public function get_pay_name($pay_type){
		switch($pay_type){
			case 'alipay':
				$pay_type_txt = '支付宝';
				break;
			case 'tenpay':
				$pay_type_txt = '财付通';
				break;
			case 'yeepay':
				$pay_type_txt = '易宝支付';
				break;
			case 'allinpay':
				$pay_type_txt = '通联支付';
				break;
			case 'chinabank':
				$pay_type_txt = '网银在线';
				break;
			case 'weixin':
				$pay_type_txt = '微信支付';
				break;
			case 'offline':
				$pay_type_txt = '货到付款';
				break;
            case 'CardPay':
                $pay_type_txt = '会员卡支付';
			default:
				$pay_type_txt = '余额支付';
		}
		return $pay_type_txt;
	}

    public function getPaymentMethod()
    {
        return $payment_method = array(
            'alipay'    => '支付宝',
            'tenpay'    => '财付通',
            'yeepay'    => '易宝支付',
            'allinpay'  => '通联支付',
            'chinabank' => '网银在线',
            'weixin'    => '微信支付',
            'offline'   => '货到付款',
            'balance'   => '余额支付',
            'CardPay'   => '会员卡支付'
        );
    }

    public function status($status = -1)
    {
		$order_status = array(
			0 => '临时订单',
			1 => '等待买家付款',
			2 => '等待卖家发货',
			3 => '卖家已发货',
			4 => '交易完成',
			5 => '订单关闭',
			6 => '退款中'
		);
		if($status == -1){
			return $order_status;
		}else{
			return $order_status[$status];
		}
    }

    public function getOrders($where, $orderby, $offset, $limit)
    {
        $orders = $this->db->where($where)->order($orderby)->limit($offset . ',' . $limit)->select();
        return $orders;
    }

    public function getOrder($store_id, $order_id)
    {
        $order = $this->db->where(array('order_id' => $order_id, 'store_id' => $store_id))->find();
        return $order;
    }

    public function getOrderTotal($where)
    {
        $order_count = $this->db->where($where)->count('order_id');
        return $order_count;
    }

    //添加备注
    public function setBak($order_id, $bak)
    {
        return $this->db->where(array('order_id' => $order_id))->data(array('bak' => $bak))->save();
    }

    //加星
    public function addStar($order_id, $star)
    {
        return $this->db->where(array('order_id' => $order_id))->data(array('star' => $star))->save();
    }

    //设置订单状态
    public function setOrderStatus($store_id, $order_id, $data)
    {
        return $this->db->where(array('order_id' => $order_id, 'store_id' => $store_id))->data($data)->save();
    }

    public function setFields($store_id, $order_id, $data)
    {
        return $this->db->where(array('store_id' => $store_id, 'order_id' => $order_id))->data($data)->save();
    }

    public function getOrderCount($where)
    {
        return $this->db->where($where)->count('order_id');
    }

    public function getOrderAmount($where)
    {
        return $this->db->where($where)->sum('total');
    }


    //标识为分销订单（订单中包含分销商品）
    public function setFxOrder($store_id, $order_id)
    {
        return $this->db->where(array('order_id' => $order_id, 'store_id' => $store_id))->data(array('is_fx' => 1))->save();
    }

    public function add($data)
    {
        return $this->db->data($data)->add();
    }

    public function setStatus($store_id, $order_id, $status)
    {
        return $this->db->where(array('order_id' => $order_id, 'store_id' => $store_id))->data(array('status' => $status))->save();
    }

    public function editStatus($where, $data)
    {
        return $this->db->where($where)->data($data)->save();
    }
	
	public function findOrderById($orderid){
		$nowOrder = $this->db->where(array('order_id'=>$orderid))->find();
		if(!empty($nowOrder)){
			$nowOrder['status_txt'] = $this->status($nowOrder['status']);
			$nowOrder['order_no_txt'] = option('config.orderid_prefix').$nowOrder['order_no'];
			if($nowOrder['payment_method']) $nowOrder['pay_type_txt'] = $this->get_pay_name($nowOrder['payment_method']);
			//地址
			if($nowOrder['address']){
				$nowOrder['address_arr'] = array(
					'address' => unserialize($nowOrder['address']),
					'user'    => $nowOrder['address_user'],
					'tel'    => $nowOrder['address_tel'],
				);
			}
			//包裹
			if($nowOrder['sent_time']){
				$nowOrder['package_list'] = M('Order_package')->getPackages(array('user_order_id' => $nowOrder['order_id']));
			}
			$nowOrder['proList'] = M('Order_product')->orderProduct($nowOrder['order_id']);
			return $nowOrder;
		}else{
			return array();
		}
	}

    //获取分销商订单
    public function getSellerOrder($seller_uid, $fx_order_id)
    {
        $order = $this->db->where(array('uid' => $seller_uid, 'fx_order_id' => $fx_order_id))->find();
        return $order;
    }

    public function getOrdersByStatus($where, $offset = 0, $limit = 0, $order = 'order_id DESC')
    {
        $orders = $this->db->where($where)->order($order)->limit($offset . ',' . $limit)->select();
        return $orders;
    }

    public function getOrderCountByStatus($where)
    {
        return $this->db->where($where)->count('order_id');
    }

    public function get($where)
    {
        $order = $this->db->where($where)->find();
        return $order;
    }

    public function getAllOrders($where)
    {
        $orders = $this->db->where($where)->select();
        return $orders;
    }

	/**
	 * 根据订单取消订单
	 * 删除送给用户的积分和优惠券
	 * $cancel_mothod 订单取消方式 0过期自动取消 1卖家手动取消 2买家手动取消
	 */
	public function cancelOrder($order, $cancel_mothod = 2) {
		// 查看满减送
		$order_ward_list = M('Order_reward')->getByOrderId($order['order_id']);

		$score = 0;
		$uid = $order['uid'];
		foreach ($order_ward_list as $order_ward) {
			$score += $order_ward['content']['score'];
		}

		// 用户减相应的积分
		if ($score) {
			$score = -1 * $score;
			M('Store_user_data')->changePoint($order['store_id'], $uid, $score);
		}

		// 退还使用过的优惠券
		$order_coupon = M('Order_coupon')->getByOrderId($order['order_id']);
		if (!empty($order_coupon)) {
			$where = array();
			$where['id'] = $order_coupon['user_coupon_id'];
			$data = array();
			$data['is_use'] = 0;
			$data['use_time'] = 0;
			$data['use_order_id'] = 0;
			$data['is_valid'] = 1;
			$data['delete_flg'] = 0;

			M('User_coupon')->save($data, $where);
		}

		// 更改此订单获得的优惠券,手机端游客下订单，是没有积分
		if (!empty($uid)) {
			M('User_coupon')->invaild(array('store_id' => $order['store_id'], 'uid' => $uid, 'give_order_id' => $order['order_id']));
		}

		// 更改订单状态
		return $this->editStatus(array('order_id' => $order['order_id']), array('status' => 5, 'cancel_time' => time(), 'cancel_method' => $cancel_mothod));
	}
}
?>