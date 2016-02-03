<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class ConfigModel extends Model
{
	public function get_config()
	{
		$config = S('config');

		if (empty($config)) {
			$configs = $this->field('`name`,`value`')->select();

			foreach ($configs as $key => $value) {
				$config[$value['name']] = $value['value'];
			}

			$domain_array = parse_url($config['site_url']);
			$config['top_domain'] = $this->get_domain($domain_array['host']);
			S('config', $config);
		}

		return $config;
	}

	public function get_gid_config($gid)
	{
		$condition_config['gid'] = $gid;
		$config = $this->field(true)->where($condition_config)->select();
		return $config;
	}

	protected function get_domain($host)
	{
		$host = strtolower($host);
		$two_suffix = array('.com.cn', '.gov.cn', '.net.cn', '.org.cn', '.ac.cn');

		foreach ($two_suffix as $key => $value) {
			preg_match('#(.*?)' . $value . '$#', $host, $match_arr);

			if (!empty($match_arr)) {
				$match_array = $match_arr;
				break;
			}
		}

		$host_arr = explode('.', $host);

		if (!empty($match_array)) {
			$host_arr_last1 = array_pop($host_arr);
			$host_arr_last2 = array_pop($host_arr);
			$host_arr_last3 = array_pop($host_arr);
			return $host_arr_last3 . '.' . $host_arr_last2 . '.' . $host_arr_last1;
		}
		else {
			$host_arr_last1 = array_pop($host_arr);
			$host_arr_last2 = array_pop($host_arr);
			return $host_arr_last2 . '.' . $host_arr_last1;
		}
	}

	public function get_pay_method($have_online = 1, $have_offline = 1, $is_wap = false)
	{
		$tmp_config_list = $this->get_gid_config(7);

		foreach ($tmp_config_list as $key => $value) {
			$config_list[$value['tab_id']]['name'] = $value['tab_name'];
			$config_list[$value['tab_id']]['config'][$value['name']] = $value['value'];
		}

		foreach ($config_list as $key => $value) {
			$pigcms_key = 'pay_' . $key . '_open';
			if (empty($value['config'][$pigcms_key]) || ($is_wap && ($key == 'chinabank'))) {
				unset($config_list[$key]);
			}
		}

		return $config_list;
	}
}

?>
