<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class config_model extends base_model
{
	public function get_gid_config($gid)
	{
		$condition_config['gid'] = $gid;
		$config = $this->db->where($condition_config)->select();
		return $config;
	}

	public function get_pay_method()
	{
		$tmp_config_list = $this->get_gid_config(7);

		foreach ($tmp_config_list as $key => $value) {
			$payMethodList[$value['tab_id']]['name'] = $value['tab_name'];
			$payMethodList[$value['tab_id']]['type'] = $value['tab_id'];
			$payMethodList[$value['tab_id']]['config'][$value['name']] = $value['value'];
		}

		foreach ($payMethodList as $key => $value) {
			$pigcms_key = 'pay_' . $key . '_open';

			if (empty($value['config'][$pigcms_key])) {
				unset($payMethodList[$key]);
			}
		}

		return $payMethodList;
	}
}

?>
