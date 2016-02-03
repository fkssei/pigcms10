<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class bank_model extends base_model
{
	public function getEnableBanks()
	{
		$banks = $this->db->where(array('status' => 1))->select();
		return $banks;
	}

	public function getBank($bank_id)
	{
		$bank = $this->db->where(array('bank_id' => $bank_id))->find();
		return $bank;
	}
}

?>
