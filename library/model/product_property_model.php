<?php
/**
 * 商品属性模型
 * User: pigcms_16
 * Date: 2015/2/5
 * Time: 20:28
 */

class product_property_model extends base_model{
	public function get_list($property_type_id= array()){

		if(count($property_type_id)) { //查询指定属性类别的属性
			//$property_type_id = implode(',',$property_type_id);
			$map['property_type_id'] = array('in',$property_type_id);
			$list = $this->db->order('`pid` ASC')->where($map)->select();
			//echo $this->db->lastsql;
		} else {
			$list = $this->db->order('`pid` ASC')->select();
		}

		return $list;
	}

	public function getName($pid) {
		$property = $this->db->field('name')->where(array('pid' => $pid))->find();
		return !empty($property['name']) ? $property['name'] : '';
	}
	
	
	/**
	 * 获取分类及分类值
	 * 根据cat_id
	 */
	public function getPropertyAndValue($cat_id_arr) {
		if (empty($cat_id_arr)) {
			return array();
		}
	
		if (!is_array($cat_id_arr)) {
			$cat_id_arr = explode(',', $cat_id_arr);
		}
	
		$property_list = $this->db->where(array('pid' => array('in', $cat_id_arr)))->select();
		
		if (empty($property_list)) {
			$property_list = array();
		}
		
		$property_value_model = M('Product_property_value');
		$property_value_list = $property_value_model->getList(array('pid' => array('in', $cat_id_arr)));
		
		$property_value_data = array();
		foreach ($property_value_list as $tmp) {
			$property_value_data[$tmp['pid']][] = $tmp;
		}
		
		return array('property_list' => $property_list, 'property_value_list' => $property_value_data);
	}
}