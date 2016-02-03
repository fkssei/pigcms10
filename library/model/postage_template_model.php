<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class postage_template_model extends base_model
{
	public function get_all_list($store_id)
	{
		$tpl_list = $this->db->field('`tpl_id`,`tpl_name`')->where(array('store_id' => $store_id))->order('`tpl_id` DESC')->select();
		return $tpl_list;
	}

	public function get_tpl_list($store_id)
	{
		$tpl_count = $this->db->where(array('store_id' => $store_id))->count('tpl_id');
		import('source.class.user_page');
		$p = new Page($tpl_count, 15);
		$tpl_list = $this->db->field('`tpl_id`,`tpl_name`,`tpl_area`,`last_time`,`copy_id`')->where(array('store_id' => $store_id))->order('`tpl_id` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();

		foreach ($tpl_list as &$value) {
			$area_arr = explode(';', $value['tpl_area']);

			foreach ($area_arr as $v) {
				if (!empty($v)) {
					$area_content_arr = explode(',', $v);
					$value['area_list'][] = $area_content_arr;
				}
			}
		}

		$return['tpl_list'] = $tpl_list;
		$return['page'] = $p->show();
		return $return;
	}

	public function get_tpl($tpl_id, $store_id)
	{
		$condition_postage_template['tpl_id'] = $tpl_id;
		$condition_postage_template['store_id'] = $store_id;
		$tpl = $this->db->field('`tpl_id`,`tpl_name`,`tpl_area`,`last_time`,`copy_id`')->where($condition_postage_template)->find();
		$area_arr = explode(';', $tpl['tpl_area']);

		foreach ($area_arr as $v) {
			if (!empty($v)) {
				$area_content_arr = explode(',', $v);
				$tpl['area_list'][] = $area_content_arr;
			}
		}

		return $tpl;
	}
}

?>
