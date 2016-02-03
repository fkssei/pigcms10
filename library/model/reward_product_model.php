<?php
/**
 * 赠品产品model
 */
class reward_product_model extends base_model{
	/**
	 * 根据条件获到赠品产品列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getList($where, $order_by = '', $limit = 0, $offset = 0) {
		$this->db->where($where);
		if (!empty($order_by)) {
			$this->db->order($order_by);
		}
		
		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$present_list = $this->db->select();
		
		return $present_list;
	}
	
	/**
	 * 根据店铺返回，所有参加活动产品ID列表
	 * 参数$rid，去除$rid的活动产品ID列表
	 */
	public function getProductIDList($rid = 0) {
		$time = time();
		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT rp.product_id, r.id FROM `" . $db_prefix . "reward_product` AS rp LEFT JOIN `" . $db_prefix . "reward` AS r ON `rp`.`rid` = `r`.`id` WHERE r.store_id = '" . $_SESSION['store']['store_id'] . "' AND r.uid = '" . $_SESSION['store']['uid'] . "' AND r.start_time <= '" . $time . "' AND r.end_time >= '" . $time . "' AND r.status = '1'";
		if (!empty($rid)) {
			$sql .= " AND r.id != '" . $rid . "'";
		}
		$product_id_list = $this->db->query($sql);
		
		$data = array();
		foreach ($product_id_list as $tmp) {
			$data[$tmp['id'] .'_' . $tmp['product_id']] = $tmp['product_id'];
		}
		return $data;
	}
	
	/**
	 * 根据活动ID查寻出所有相关产品
	 */
	public function getProductListByRid($rid) {
		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT p.* FROM `" . $db_prefix . "reward_product` AS rp LEFT JOIN `" . $db_prefix . "product` AS p ON `rp`.`product_id` = `p`.`product_id` WHERE `rp`.`rid` = '" . $rid . "'";
		$product_list = $this->db->query($sql);
		
		foreach ($product_list as &$product) {
			$product['image'] = getAttachmentUrl($product['image']);
		}
		
		return $product_list;
	}
	
	/**
	 * 新增活动产品
	 */
	function add($data) {
		$this->db->data($data)->add();
	}
	
	/**
	 * 更改参与活动产品,条件一般指的是ID
	 */
	public function save($data, $where) {
		$this->db->data($data)->where($where)->save();
	}
	
	/**
	 * 删除
	 */
	public function delete($where) {
		$this->db->where($where)->delete();
	}
}