<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class trade_selffetch_model extends base_model
{
	public function get_list($store_id)
	{
		$list_count = $this->db->where(array('store_id' => $store_id))->count('pigcms_id');
		import('source.class.user_page');
		$p = new Page($list_count, 15);
		$selffetch_list = $this->db->where(array('store_id' => $store_id))->order('`pigcms_id` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();

		if ($selffetch_list) {
			import('source.class.area');
			$area_class = new area();

			foreach ($selffetch_list as &$value) {
				$value['province_txt'] = $area_class->get_name($value['province']);
				$value['city_txt'] = $area_class->get_name($value['city']);
				$value['county_txt'] = $area_class->get_name($value['county']);
			}
		}

		$return['selffetch_list'] = $selffetch_list;
		$return['page'] = $p->show();
		return $return;
	}

	public function getListNoPage($store_id)
	{
		$selffetch_list = $this->db->where(array('store_id' => $store_id))->order('`pigcms_id` DESC')->select();

		if ($selffetch_list) {
			import('source.class.area');
			$area_class = new area();

			foreach ($selffetch_list as &$value) {
				$value['province_txt'] = $area_class->get_name($value['province']);
				$value['city_txt'] = $area_class->get_name($value['city']);
				$value['county_txt'] = $area_class->get_name($value['county']);
			}
		}

		return $selffetch_list;
	}

	public function get_selffetch($pigcms_id, $store_id)
	{
		$condition_trade_selffetch['pigcms_id'] = $pigcms_id;
		$condition_trade_selffetch['store_id'] = $store_id;
		$selffetch = $this->db->where($condition_trade_selffetch)->find();

		if ($selffetch) {
			import('source.class.area');
			$area_class = new area();
			$selffetch['province_txt'] = $area_class->get_name($selffetch['province']);
			$selffetch['city_txt'] = $area_class->get_name($selffetch['city']);
			$selffetch['county_txt'] = $area_class->get_name($selffetch['county']);
		}

		return $selffetch;
	}
}

?>
