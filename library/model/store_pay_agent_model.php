<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class store_pay_agent_model extends base_model
{
	public function add($data)
	{
		$result = $this->db->data($data)->add();
		return $result;
	}

	public function edit($data, $where)
	{
		$result = $this->db->where($where)->data($data)->save();
		return $result;
	}

	public function del($where)
	{
		$result = $this->db->where($where)->delete();
		return $result;
	}

	public function getBuyerHelps($store_id)
	{
		$helps = $this->db->where(array('store_id' => $store_id, 'type' => 0))->order('agent_id DESC')->select();
		return $helps;
	}

	public function getPayerComments($store_id)
	{
		$comments = $this->db->where(array('store_id' => $store_id, 'type' => 1))->order('agent_id DESC')->select();
		return $comments;
	}
}

?>
