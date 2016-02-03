<?php
/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/6/15
 * Time: 11:26
 */
class system_property_value_model extends base_model{
	/**
	 * 根据条件返回列表
	 * 以后有更多的查询条件可以在此扩展
	 */
	public function getList($where) {
		$property_value_list = $this->db->where($where)->select();
		return $property_value_list;
	}
}