<?php
/**
 * 店铺线下门店
 */

class store_physical_model extends base_model{
	public function getOne($pigcms_id){
        $store_physical = $this->db->where(array('pigcms_id'=>$pigcms_id))->find();
		
		import('source.class.area');
		$area_class = new area();
		
		$store_physical['images_arr'] = explode(',',$store_physical['images']);
		foreach($store_physical['images_arr'] as &$image_value){
			$image_value = getAttachmentUrl($image_value);
		}

		$store_physical['province_txt'] = $area_class->get_name($store_physical['province']);
		$store_physical['city_txt'] = $area_class->get_name($store_physical['city']);
		$store_physical['county_txt'] = $area_class->get_name($store_physical['county']);

		return $store_physical;
    }
    public function getList($store_id){
        $store_physical = $this->db->where(array('store_id'=>$store_id))->select();
		
		import('source.class.area');
		$area_class = new area();
		
		foreach($store_physical as &$physical_value){
			$physical_value['images_arr'] = explode(',',$physical_value['images']);
			foreach($physical_value['images_arr'] as &$image_value){
				$image_value = getAttachmentUrl($image_value);
			}

			$physical_value['province_txt'] = $area_class->get_name($physical_value['province']);
			$physical_value['city_txt'] = $area_class->get_name($physical_value['city']);
			$physical_value['county_txt'] = $area_class->get_name($physical_value['county']);
		}
		return $store_physical;
	}
	
	// 根据id列表返回门店信息
	public function getListByIDList($physical_id_list) {
		if (empty($physical_id_list) || !is_array($physical_id_list)) {
			return array();
		}
		
		//$store_physical_list = $this->db->where(array('pigcms_id' => array('in', $physical_id_list)))->select();
		
		$store_physical_list = D('')->field("`s`.`buyer_selffetch_name`, `sp`.*")->table(array('Store' => 's', 'Store_physical' => 'sp'))->where("`s`.`store_id` = `sp`.`store_id` AND `sp`.`pigcms_id` in (" . join(',', $physical_id_list) . ")")->select();
		
		import('source.class.area');
		$area_class = new area();
		$return_data = array();
		foreach ($store_physical_list as $value) {
			$value['images_arr'] = explode(',',$value['images']);
			foreach ($value['images_arr'] as &$image_value) {
				$image_value = getAttachmentUrl($image_value);
			}
			
			$value['province_txt'] = $area_class->get_name($value['province']);
			$value['city_txt'] = $area_class->get_name($value['city']);
			$value['county_txt'] = $area_class->get_name($value['county']);
			
			$return_data[$value['pigcms_id']] = $value;
		}
		
		return $return_data;
	}
} 