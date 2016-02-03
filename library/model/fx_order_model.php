<?php
//狗扑源码社区 www.gope.cn
class fx_order_model extends base_model
{
	public function add($data)
	{
		return $this->db->data($data)->add();
	}

	public function edit($where, $data)
	{
		return $this->db->where($where)->data($data)->save();
	}

	public function getOrderCount($where)
	{
		return $this->db->where($where)->count('fx_order_id');
	}

	public function getOrder($store_id, $order_id)
	{
		$order = $this->db->where(array('fx_order_id' => $order_id, 'store_id' => $store_id))->find();
		return $order;
	}

	public function getSupplierOrder($store_id, $order_id)
	{
		$order = $this->db->where(array('fx_order_id' => $order_id, 'supplier_id' => $store_id))->find();
		return $order;
	}

	public function getSellerOrder($store_id, $order_id)
	{
		$order = $this->db->where(array('order_id' => $order_id, 'store_id' => $store_id))->find();
		return $order;
	}

	public function getOrders($where, $offset = 0, $limit = 0)
	{
		if ($limit) {
			$orders = $this->db->where($where)->limit($offset . ',' . $limit)->order('fx_order_id DESC')->select();
		}
		else {
			$orders = $this->db->where($where)->order('fx_order_id DESC')->select();
		}

		return $orders;
	}

	public function status($key = 0)
	{
		$status = array(1 => '待付款', 2 => '待供货商发货', 3 => '供货商已发货', 4 => '已完成', 5 => '已关闭');

		if (!empty($key)) {
			return $status[$key];
		}
		else {
			return $status;
		}
	}

	public function status_text($key = 0)
	{
		$status = array('买家已付款', '等待分销商付款', '等待供货商发货', '供货商已发货', '订单已完成', '订单已取消');

		if (!empty($key)) {
			return $status[$key];
		}
		else {
			return $status;
		}
	}

	public function setPackaged($fx_order_id)
	{
		return $this->db->where(array('fx_order_id' => $fx_order_id))->data(array('status' => 3, 'supplier_sent_time' => time()))->save();
	}

	public function getOrderById($fx_order_id)
	{
		$order = $this->db->field('order_id,store_id')->where(array('fx_order_id' => $fx_order_id))->find();
		return $order;
	}

	public function setStatus($where, $data)
	{
		return $this->db->where($where)->data($data)->save();
	}

	public function getSales($where)
	{
		$sales = $this->db->where($where)->sum('total');
		return $sales;
	}
}

?>
