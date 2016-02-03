<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class trade_setting_model extends base_model
{
	public function get_setting($store_id)
	{
		$setting = $this->db->where(array('store_id' => $store_id))->find();

		if (empty($setting)) {
			$setting = $this->add_setting($store_id);

			if (empty($setting)) {
				return NULL;
			}
		}

		return $setting;
	}

	public function add_setting($store_id)
	{
		$data_trade_setting['store_id'] = $store_id;
		$data_trade_setting['pay_cancel_time'] = option('config.trade_pay_cancel_time');
		$data_trade_setting['pay_alert_time'] = option('config.trade_pay_alert_time');
		$data_trade_setting['sucess_notice'] = option('config.trade_sucess_notice');
		$data_trade_setting['send_notice'] = option('config.trade_send_notice');
		$data_trade_setting['complain_notice'] = option('config.trade_complain_notice');
		$data_trade_setting['last_time'] = $_SERVER['REQUEST_TIME'];

		if ($this->db->data($data_trade_setting)->add()) {
			return $data_trade_setting;
		}
		else {
			return NULL;
		}
	}
}

?>
