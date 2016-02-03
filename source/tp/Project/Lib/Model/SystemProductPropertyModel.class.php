<?php
/**
 * Created by PhpStorm.
 * @description:  商品属性操作
 * User: pigcms-s
 * Date: 2015/6/9
 * Time: 11:30
 */

class SystemProductPropertyModel extends Model {


	//获取 所有商品类型开启的 所有商品属性
	public function get_property_list(){


		$arr =$this->alias("p")->join(C('DB_PREFIX').'system_property_type ppt ON ppt.type_id=p.property_type_id','LEFT')
							->order("p.pid asc")
							->select();

		foreach ($arr as $val)
		{
			$list[$val['property_type_id']][] = array($val['pid']=>$val['name']);
		}

		return $list;
	}
} 