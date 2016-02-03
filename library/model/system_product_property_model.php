<?php
/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/6/15
 * Time: 11:26
 */
class system_product_property_model extends base_model{
	
	//查找栏目属性值
	public function get_list_to_value($property_arr) {
		$property_str = implode(',',$property_arr);
		$property_list = $this->db -> table("System_product_property as p")
								   -> join("system_property_value pv On p.pid = pv.pid")
								   -> where("p.pid in(".$property_str.")")
								   -> field("p.*,pv.*")
								   -> select();
			$arr = array();
			foreach($property_list as $k=>$v){
				if($v['value']) {
					$arr[$v['pid']]['name'] = $v['name'];
					$arr[$v['pid']]['pid'] = $v['pid'];
					$arr[$v['pid']]['property_type_id'] = $v['property_type_id'];

					$arr[$v['pid']]['property_value'][] = $v;
				}
			}

		$property_list = array_values($arr);

		return $property_list;
	}

	public function get_list($property_type_id= array()){

		if(count($property_type_id)) { //查询指定属性类别的属性
			//$property_type_id = implode(',',$property_type_id);
			$map['property_type_id'] = array('in',$property_type_id);
			$list = $this->db->order('`pid` ASC')->where($map)->select();

		} else {
			$list = $this->db->order('`pid` ASC')->select();
		}

		return $list;
	}

	public function getName($pid)
	{
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
		
		$property_value_model = M('System_property_value');
		$property_value_list = $property_value_model->getList(array('pid' => array('in', $cat_id_arr)));
		
		$property_value_data = array();
		foreach ($property_value_list as $tmp) {
			$property_value_data[$tmp['pid']][] = $tmp;
		}
	
		return array('property_list' => $property_list, 'property_value_list' => $property_value_data);
	}
}