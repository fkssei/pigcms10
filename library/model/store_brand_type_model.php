<?php
/**
 * 店铺品牌类别model
 * User: pigcms-s
 * Date: 2015/07/07
 * Time: 11:40
 */

class store_brand_type_model extends base_model{

	//获取指定类别的品牌
	public function getBrandTypeList($where = array(),$order_by="", $limit="10") {
		if(!is_array($where)) return false;

		$where1 = array(
			'status' => 1,
		);
		if(empty($order_by)) $order_by = "order_by asc,type_id asc";

		$where = array_merge($where,$where1);

		$return = $this->db->where($where)->limit($limit)->select();
		return $return;
	}


}