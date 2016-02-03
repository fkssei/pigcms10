<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class product_qrcode_activity_model extends base_model
{
	public function add($data)
	{
		return $this->db->data($data)->add();
	}

	public function save($where, $data)
	{
		return $this->db->where($where)->data($data)->save();
	}

	public function delete($store_id, $product_id, $activity_id)
	{
		return $this->db->where(array('store_id' => $store_id, 'product_id' => $product_id, 'pigcms_id' => $activity_id))->delete();
	}

	public function getActivities($store_id, $product_id)
	{
		$activities = $this->db->where(array('store_id' => $store_id, 'product_id' => $product_id))->select();
		return $activities;
	}

	public function getActivity($store_id, $product_id, $activity_id)
	{
		$activity = $this->db->where(array('pigcms_id' => $activity_id, 'product_id' => $product_id, 'store_id' => $store_id))->find();
		return $activity;
	}

	public function getActivityById($activity_id)
	{
		$activity = $this->db->where(array('pigcms_id' => $activity_id))->find();
		return $activity;
	}
}

?>
