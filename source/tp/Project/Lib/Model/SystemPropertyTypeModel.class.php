<?php
/**
 * Created by PhpStorm.
 * 商品属性的 类别操作
 * User: pigcms-s
 * Date: 2015/6/9
 * Time: 11:10
 */

class SystemPropertyTypeModel extends Model{



	//获指定商品类别id的 商品类型select表
	public function get_PropertyType_list($property_type_id){

		$PropertyTypelist = $this->where(array('type_status'=>'1'))->select();
		$lst = '';
		foreach($PropertyTypelist as $k => $v) {

			$lst .= "<option value='$v[type_id]'";
			$lst .= ($property_type_id == $v['type_id']) ? ' selected="true"' : '';
			$lst .= '>' . htmlspecialchars($v['type_name']). '</option>';

		}



		return $lst;
	}


}