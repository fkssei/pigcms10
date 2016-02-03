<?php
/**
 * 提醒
 * User: pigcms_21
 * Date: 2015/3/3
 * Time: 14:41
 */
class notify_controller extends base_controller{
	function notify() {
		$order_id = $_GET['order_id'];
		$type = strtolower($_GET['type']);
		
		$type_arr = array('cancel', 'alert');
		if (!in_array($type, $type_arr)) {
			echo 'no_type';
			exit;
		}
		
		$order_model = M('Order');
		// 查找订单
		$order = $order_model->find($order_id);
		
		if (empty($order)) {
			echo 'no_order';
			exit;
		}
		
		if ($order['status'] > 1) {
			echo 'type_error';
			exit;
		}
		
		// 更改订单状态
		if ($type == 'cancel') {
			$order_model->setStatus($order['store_id'], $order['order_id'], 5);
			echo 'ok';
			exit;
		}
		
		if ($type == 'alert') {
			import('source.class.Notify');
			Notify::alert('尊敬的会员' . $order['address_user'] . '您好，您的订单号：' . $order_id . '未付款，请及时付款');
		}
	}
}