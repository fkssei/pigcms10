<?php
/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/6/9
 * Time: 9:29
 */
class Product_propertyAction extends BaseAction{


	//商品属性
	public function property(){

		$property = M('product_property');
		$propertyValue = M('product_property_value');
		$where = array();
		if ($this->_get('cat_id', 'trim,intval')) {
		//	$where['_string'] = "cat_id = '" . $this->_get('cat_id', 'trim,intval') . "' OR cat_fid = '" . $this->_get('cat_id', 'trim,intval') . "'";
		}
		$property_count = $property->where($where)->count('pid');

		import('@.ORG.system_page');
		$page = new Page($property_count, 30);
		$propertys2 = $property -> where($where)
							    -> order('pid ASC')
							    -> limit($page->firstRow, $page->listRows)
							    -> select();

		foreach($propertys2 as $k=>$v) {
			$arr = $propertyValue  -> where(array('pid'=>$v['pid']))
				 	        -> order('vid asc')
				            -> select();
			$v['property_value'] = $arr;
			$propertys[] = $v;
		}

		$this->assign('propertys', $propertys);

		$this->assign('page', $page->show());
		$this->display();
	}


	//修改商品属性类别的分类状态
	public function property_status()
	{
		$productProperty = M('productProperty');

		$pid = $this->_post('pid', 'trim,intval');
		$status = $this->_post('status', 'trim,intval');
		$productProperty->where(array('pid' => $pid))->save(array('status' => $status));
	}



	//商品属性的修改
	public function property_edit()
	{
		$productProperty = M('productProperty');

		if (IS_POST) {
			$pid = $this->_post('pid', 'trim,intval');

			$data = array();

			$data['name']   = $this->_post('name', 'trim');
			$data['status'] = $this->_post('status', 'trim,intval');
			$data['sort']   = $this->_post('sort','trim,intval');


			if ($productProperty->where(array('name'=>$data['name'],'pid'=>array('neq',$pid)))->find()){
				$this->frame_submit_tips(0,'该属性已经存在！');
			}

			if ($productProperty->where(array('pid' => $pid))->save($data)) {

				$this->frame_submit_tips(1,'修改成功！');
			} else {

				$this->frame_submit_tips(0,'修改失败！请重试~');
			}
		}

		$pid = $this->_get('pid', 'trim,intval');

		$property = $productProperty->find($pid);

		$this->assign('bg_color','#F3F3F3');

		$this->assign('property', $property);
		$this->display();
	}

	//删除商品属性
	public function property_del()
	{
		$productProperty = M('productProperty');

		$pid  = $this->_get('pid', 'trim,intval');
		if ($productProperty->delete($pid)) {
			$this->success('删除成功！');
		} else {
			$this->error('删除失败！请重试~');
		}
	}

	//添加商品属性
	public function property_add()
	{
		$property = M('product_property');

		if (IS_POST) {

			$data = array();
			$data['name']      = $this->_post('name', 'trim');
			$data['sort']      = $this->_post('sort', 'trim,intval');
			$data['status']    = $this->_post('status', 'trim,intval');
			//查询同意分类下 不允许相同的属性
			if($property->where(array('name' => $data['name']))->find()){
				$this->frame_submit_tips(0,'该属性已经存在！');
			}

			if ($cat_id = $property->add($data)) {
				$this->frame_submit_tips(1,'添加成功！');
			} else {
				$this->frame_submit_tips(0,'添加失败！请重试~');
			}
		}
		$this->assign('bg_color','#F3F3F3');

		$this->display();
	}




	//商品属性值
	public function propertyValue(){

		//$property = M('product_property');
		$property_value = M('productPropertyValue');

		$property = M('product_property');

		$where = array();
		if ($this->_get('cat_id', 'trim,intval')) {
			//	$where['_string'] = "cat_id = '" . $this->_get('cat_id', 'trim,intval') . "' OR cat_fid = '" . $this->_get('cat_id', 'trim,intval') . "'";
		}
		$property_value_count = $property_value->where($where)->count('vid');

		import('@.ORG.system_page');
		$page = new Page($property_value_count, 30);
		$property_values = $property_value-> alias('pv')
			-> join(C('DB_PREFIX')."product_property as pp on pp.pid=pv.pid")
			-> field("pv.*,pp.name,pp.status")
			-> where($where)
			-> order('pv.vid ASC')
			-> limit($page->firstRow, $page->listRows)
			-> select();
		//	echo $property->getLastSql();

		//所有分类
		//	$all_categories = $category->order('cat_path ASC')->select();

		$this->assign('propertyValues', $property_values);
		//$this->assign('propertys', $propertys);

		$this->assign('page', $page->show());
		$this->display();
	}

	//商品属性值
	public function getOnePropertyValueList(){

		$property_value = M('productPropertyValue');

		$property = M('product_property');

		$where = array();
		$pid = $this->_get('pid', 'trim,intval') ;
		$where['_string'] = "pp.pid='".$pid."'";

		$property_value_count = $property_value->alias('pp')->where($where)->count('vid');

	  	import('@.ORG.system_page');
		$page = new Page($property_value_count, 15);
		$property_values = $property_value -> alias('pv')
											-> join(C('DB_PREFIX')."product_property as pp on pp.pid=pv.pid")
											-> field("pv.*,pp.name,pp.status")
											-> where($where)
											-> order('pv.vid ASC')
											-> limit($page->firstRow, $page->listRows)
											-> select();

		$propertys =$property->where(array('pid'=>$pid))-> find();

		//所有分类
		$this->assign('propertyValues', $property_values);
		$this->assign('property', $propertys);
		$this->assign('page', $page->show());
		$this->display();
	}




	//商品属性值的修改
	public function propertyValue_edit()
	{
		$productPropertyValue = M('productPropertyValue');

		if (IS_POST) {
			$vid = $this->_post('vid', 'trim,intval');
			$data = array();
			$data['value']   = $this->_post('value', 'trim');

			if ($productPropertyValue->where(array('value'=>$data['value'],'vid'=>array('neq',$vid)))->find()){
				$this->frame_submit_tips(0,'该属性值已经存在！');
			}

			if ($productPropertyValue->where(array('vid' => $vid))->save($data)) {

				$this->frame_submit_tips(1,'修改成功！');
			} else {

				$this->frame_submit_tips(0,'修改失败！请重试~');
			}
		}

		$vid = $this->_get('vid', 'trim,intval');

		$propertyvalue = $productPropertyValue->find($vid);

		$this->assign('bg_color','#F3F3F3');

		$this->assign('propertyvalue', $propertyvalue);
		$this->display();
	}




	//删除商品属性值
	public function propertyValue_del()
	{
		$productPropertyValue = M('productPropertyValue');

		$vid  = $this->_get('vid', 'trim,intval');
		if ($productPropertyValue->delete($vid)) {
			$this->success('删除成功！');
		} else {
			$this->error('删除失败！请重试~');
		}
	}


}