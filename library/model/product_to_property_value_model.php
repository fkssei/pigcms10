<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class product_to_property_value_model extends base_model
{
	public function add($data)
	{
		$result = $this->db->data($data)->add();
		return $result;
	}

	public function getVids($store_id, $product_id, $pid, $fields = 'vid')
	{
		$vids = $this->db->field($fields)->where(array('pid' => $pid, 'product_id' => $product_id, 'store_id' => $store_id))->order('order_by ASC')->select();
		return $vids;
	}

	public function getPropertyValues($store_id, $product_id)
	{
		return $this->db->where(array('store_id' => $store_id, 'product_id' => $product_id))->select();
	}
}

?>
