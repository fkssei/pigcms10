<?php
/**
 * 赠品产品model
 */
class present_product_model extends base_model{
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
	 * 根据赠品ID查寻出所有相关产品
	 */
	public function getProductListByPid($pid) {
		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT p.product_id, p.name, p.quantity, p.price, p.original_price, p.image, p.has_property FROM `" . $db_prefix . "present_product` AS pp LEFT JOIN `" . $db_prefix . "product` AS p ON `PP`.`product_id` = `p`.`product_id` WHERE `pp`.`pid` = '" . $pid . "' AND p.status = '1' AND p.quantity > 0";
		$product_list = $this->db->query($sql);
		
		foreach ($product_list as &$product) {
			$product['image'] = getAttachmentUrl($product['image']);
		}
		
		return $product_list;
	}
	
	/**
	 * 新增赠品产品
	 */
	function add($data) {
		$this->db->data($data)->add();
	}
	
	/**
	 * 更改赠品,条件一般指的是ID
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