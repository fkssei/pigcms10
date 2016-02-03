<?php

/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/6/9
 * Time: 9:29
 */
class Sys_product_propertyAction extends BaseAction {

    //ajax 获取指定属性类别的属性
    public function getOnePropertyTypeValue() {

        $property_type_id = $this->_post('property_type_id', 'trim,intval');
        $cat_id = $this->_post('cat_id', 'trim,intval');
        if (!isset($property_type_id)) {
            return false;
        }
        if (!$cat_id) {
            return false;
        }

        //处理选项
//        $category_info = M('ProductCategory')->where(array('cat_id' => $cat_id))->find();
//        if ($category_info['cat_fid'] == 0) {
//            $s_category = M('ProductCategory')->where(array('cat_fid' => $category_info['cat_id']))->select();
//            $new_filter_str = '';
//            foreach ($s_category as $v) {
//                if ($v['filter_attr']) {
//                    $new_filter_str.=$v['filter_attr'];
//                }
//            }
//            $new_filter_arr = explode(',', $new_filter_str);
//        }


        $property = M('SystemProductProperty');
        $where = array('property_type_id' => $property_type_id);
        $property_arr = $property->where($where)->select();


        /*
         * 判断父类，子类的相关属性处理
         */
        $cat_fid = M('ProductCategory')->where(array('cat_id' => $cat_id))->getField('cat_fid');
        if ($cat_fid != 0) {
            $filterAttr_arr = $this->_searchFilterAttr($cat_fid);
            foreach ($property_arr as $k => $v) {
                if (in_array($v['pid'], explode(',', $filterAttr_arr))) {
                    unset($property_arr[$k]);
                }
            }
        } else {
            $category_info = M('ProductCategory')->where(array('cat_id' => $cat_id))->find();
            $s_category = M('ProductCategory')->where(array('cat_fid' => $category_info['cat_id']))->select();
            $new_filter_str = '';
            foreach ($s_category as $v) {
                if ($v['filter_attr']) {
                    $new_filter_str.=$v['filter_attr'];
                }
            }
            $new_filter_arr = explode(',', $new_filter_str);
            array_push($new_filter_arr, $category_info['filter_attr']);
            array_merge($new_filter_arr, $category_info['filter_attr']);
            foreach ($property_arr as $k => $v) {
                foreach ($new_filter_arr as $val) {
                    if ($v['pid'] == $val) {
                        unset($property_arr[$k]);
                    }
                }
            }
        }


        echo json_encode($property_arr);
    }

	public function get_type_value() {
		$property_type_id = $this->_post('property_type_id', 'trim,intval');
		if (!isset($property_type_id)) {
			return false;
		}

		$property = M('SystemProductProperty');
		$where = array('property_type_id' => $property_type_id);
		$property_arr = $property->where($where)->select();
		echo json_encode($property_arr);
	}

    //修改商品属性类别的分类状态
    public function propertytype_status() {
        $systemPropertyType = M('systemPropertyType');
        $type_id = $this->_post('type_id', 'trim,intval');
        $type_status = $this->_post('type_status', 'trim,intval');
        $systemPropertyType->where(array('type_id' => $type_id))->save(array('type_status' => $type_status));
    }

    //商品属性类别
    public function propertyType() {

        $PropertyType = M('systemPropertyType');

        $where = array();
        $propertyType_count = $PropertyType->where($where)->count('type_id');
        import('@.ORG.system_page');
        $page = new Page($propertyType_count, 15);
        $propertytype = $PropertyType->where($where)->order('type_id ASC')->limit($page->firstRow, $page->listRows)->select();

        $this->assign('page', $page->show());
        $this->assign('propertytype', $propertytype);
        $this->display();
    }

    //商品属性类别的添加
    public function propertyType_add() {
        $systemPropertyType = M('systemPropertyType');

        if (IS_POST) {

            $data = array();
            $data['type_name'] = $this->_post('name', 'trim');
            $data['type_status'] = $this->_post('status', 'trim,intval');


            if ($propertyType_id = $systemPropertyType->add($data)) {

                $this->frame_submit_tips(1, '添加成功！');
            } else {
                $this->frame_submit_tips(0, '添加失败！请重试~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');



        $this->display();
    }

    //商品属性类别的修改
    public function propertyType_edit() {
        $systemPropertyType = M('systemPropertyType');

        if (IS_POST) {
            $type_id = $this->_post('type_id', 'trim,intval');
            $now_cat = $systemPropertyType->find($type_id);
            $data = array();

            $data['type_name'] = $this->_post('name', 'trim');
            $data['type_status'] = $this->_post('status', 'trim,intval');

            if ($systemPropertyType->where(array('type_id' => $type_id))->save($data)) {

                $this->frame_submit_tips(1, '修改成功！');
            } else {
                $this->frame_submit_tips(0, '修改失败！请重试~');
            }
        }

        $type_id = $this->_get('type_id', 'trim,intval');

        $propertytype = $systemPropertyType->find($type_id);

        $this->assign('bg_color', '#F3F3F3');

        $this->assign('propertytype', $propertytype);
        $this->display();
    }

    //删除商品属性类别分类
    public function propertyType_del() {
        $systemPropertyType = M('systemPropertyType');

        $type_id = $this->_get('type_id', 'trim,intval');
        if ($systemPropertyType->delete($type_id)) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！请重试~');
        }
    }

    //商品属性
    public function property() {

        $property = M('System_product_property');
        $propertyValue = M('System_property_value');

        //查询对应属性
        $poroerty_type_id = $this->_get('poroerty_type_id', 'trim,intval');

        $where = array();
        if ($this->_get('cat_id', 'trim,intval')) {
            //	$where['_string'] = "cat_id = '" . $this->_get('cat_id', 'trim,intval') . "' OR cat_fid = '" . $this->_get('cat_id', 'trim,intval') . "'";
        }

        if ($poroerty_type_id)
            $where['pt.type_id'] = $poroerty_type_id;



        $property_count = $property->where($where)->count('pid');

        import('@.ORG.system_page');
        $page = new Page($property_count, 30);
        $propertys2 = $property->alias('p')
                ->join(C('DB_PREFIX') . "system_property_type as pt on pt.type_id=p.property_type_id")
                ->field("p.*,pt.type_name,pt.type_status,pt.type_id")
                ->where($where)
                ->order('p.pid ASC')
                ->limit($page->firstRow, $page->listRows)
                ->select();

        foreach ($propertys2 as $k => $v) {

            $arr = $propertyValue->where(array('pid' => $v['pid']))
                    ->order('vid asc')
                    ->select();
            $v['property_value'] = $arr;
            $propertys[] = $v;
        }

        //dump($propertys);
        //所有分类
        //	$all_categories = $category->order('cat_path ASC')->select();
        //$this->assign('categories', $categories);

        $this->assign('propertys', $propertys);

        $this->assign('page', $page->show());
        $this->display();
    }

    //修改商品属性类别的分类状态
    public function property_status() {
        $productProperty = M('systemProductProperty');

        $pid = $this->_post('pid', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        $productProperty->where(array('pid' => $pid))->save(array('status' => $status));
        echo $productProperty->getLastSql();
        exit;
    }

    //商品属性的修改
    public function property_edit() {
        $productProperty = M('systemProductProperty');

        if (IS_POST) {
            $pid = $this->_post('pid', 'trim,intval');

            $data = array();

            $data['name'] = $this->_post('name', 'trim');
            $data['status'] = $this->_post('status', 'trim,intval');
            $data['sort'] = $this->_post('sort', 'trim,intval');


            if ($productProperty->where(array('name' => $data['name'], 'pid' => array('neq', $pid)))->find()) {
                $this->frame_submit_tips(0, '该属性已经存在！');
            }

            if ($productProperty->where(array('pid' => $pid))->save($data)) {

                $this->frame_submit_tips(1, '修改成功！');
            } else {

                $this->frame_submit_tips(0, '修改失败！请重试~');
            }
        }

        $pid = $this->_get('pid', 'trim,intval');

        $property = $productProperty->find($pid);

        $this->assign('bg_color', '#F3F3F3');

        $this->assign('property', $property);
        $this->display();
    }

    //删除商品属性
    public function property_del() {
        $productProperty = M('systemProductProperty');

        $pid = $this->_get('pid', 'trim,intval');
        if ($productProperty->delete($pid)) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！请重试~');
        }
    }

    //添加商品属性
    public function property_add() {
        $property = M('systemProductProperty');
        $property_type = M('systemPropertyType');

        if (IS_POST) {

            $data = array();
            $data['name'] = $this->_post('name', 'trim');
            $data['sort'] = $this->_post('sort', 'trim,intval');
            $data['status'] = $this->_post('status', 'trim,intval');
            $data['property_type_id'] = $this->_post('property_type_id', 'trim,intval');

            //查询同意分类下 不允许相同的属性
            if ($property->where(array('name' => $data['name'], 'property_type_id' => $data['property_type_id']))->find()) {
                $this->frame_submit_tips(0, '该属性已经存在！');
            }

            if ($cat_id = $property->add($data)) {

                $this->frame_submit_tips(1, '添加成功！');
            } else {
                $this->frame_submit_tips(0, '添加失败！请重试~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');

        //获取属性类别
        $property_type = $property_type->where(array('type_status' => 1))->select();

        $this->assign('property_type', $property_type);
        $this->display();
    }

    //商品属性值
    public function propertyValue() {

        //$property = M('product_property');
        $property_value = M('systemPropertyValue');

        $property = M('systemProductProperty');

        $where = array();
        if ($this->_get('cat_id', 'trim,intval')) {
            //	$where['_string'] = "cat_id = '" . $this->_get('cat_id', 'trim,intval') . "' OR cat_fid = '" . $this->_get('cat_id', 'trim,intval') . "'";
        }
        $property_value_count = $property_value->where($where)->count('vid');

        import('@.ORG.system_page');
        $page = new Page($property_value_count, 30);
        $property_values = $property_value->alias('pv')
                ->join(C('DB_PREFIX') . "system_product_property as pp on pp.pid=pv.pid")
                ->field("pv.*,pp.name,pp.status")
                ->where($where)
                ->order('pv.vid ASC')
                ->limit($page->firstRow, $page->listRows)
                ->select();


        //所有分类
        //	$all_categories = $category->order('cat_path ASC')->select();

        $this->assign('propertyValues', $property_values);
        //$this->assign('propertys', $propertys);

        $this->assign('page', $page->show());
        $this->display();
    }

    //商品属性值
    public function getOnePropertyValueList() {
        $property_value = M('systemPropertyValue');
        $property_type = M('systemPropertyType');
        $property = M('systemProductProperty');

        $where = array();
        $pid = $this->_get('pid', 'trim,intval');
        $where['_string'] = "pp.pid='" . $pid . "'";

        $property_value_count = $property_value->alias('pp')->where($where)->count('vid');

        import('@.ORG.system_page');
        $page = new Page($property_value_count, 15);
        $property_values = $property_value->alias('pv')
                ->join(C('DB_PREFIX') . "system_product_property as pp on pp.pid=pv.pid")
                ->field("pv.*,pp.name,pp.status")
                ->where($where)
                ->order('pv.vid ASC')
                ->limit($page->firstRow, $page->listRows)
                ->select();

        //所有分类
        $this->assign('propertyValues', $property_values);
        if (is_array($property_values)) {
            
        }
        $propertys = $property_type->alias('pt')
                ->join(C('DB_PREFIX') . "system_product_property as pp on pp.property_type_id=pt.type_id")
                ->field("pt.*,pp.*")
                ->where(array('pp.pid' => $pid))
                ->find();


        $this->assign('property', $propertys);
        $this->assign('page', $page->show());
        $this->display();
    }

    //添加商品属性值
    public function propertyValue_add() {

        $property = M('system_product_property');
        $property_Type = M('systemPropertyType');
        $property_value = M('systemPropertyValue');

        if (IS_POST) {

            $data = array();
            $values = $this->_post('values', 'trim');
            $data['pid'] = $this->_post('pid', 'trim,intval');
            $values_arr = explode("\n", $values);

            //查询同意分类下 不允许相同的属性
            foreach ($values_arr as $tmp) {
                $tmp = trim($tmp);
                if ($property_value->where(array('value' => $tmp, 'pid' => $data['pid']))->find()) {

                    $this->frame_submit_tips(0, '该属性值已经存在！');
                }

                $data['value'] = $tmp;
                $property_value->add($data);
            }

            $this->frame_submit_tips(2, '添加成功!');
        }
        $this->assign('bg_color', '#F3F3F3');

        //获取属性类别
        $property_type = $property_Type->where(array('type_status' => 1))->select();

        $this->assign('property_type', $property_type);
        $this->display();
    }

    //商品属性值的修改
    public function propertyValue_edit() {
        $productPropertyValue = M('systemPropertyValue');

        if (IS_POST) {
            $vid = $this->_post('vid', 'trim,intval');
            $data = array();
            $data['value'] = $this->_post('value', 'trim');

            if ($productPropertyValue->where(array('value' => $data['value'], 'vid' => array('neq', $vid)))->find()) {
                $this->frame_submit_tips(0, '该属性值已经存在！');
            }

            if ($productPropertyValue->where(array('vid' => $vid))->save($data)) {

                $this->frame_submit_tips(1, '修改成功！');
            } else {

                $this->frame_submit_tips(0, '修改失败！请重试~');
            }
        }

        $vid = $this->_get('vid', 'trim,intval');

        $propertyvalue = $productPropertyValue->find($vid);

        $this->assign('bg_color', '#F3F3F3');

        $this->assign('propertyvalue', $propertyvalue);
        $this->display();
    }

    //删除商品属性值
    public function propertyValue_del() {
        $productPropertyValue = M('systemPropertyValue');

        $vid = $this->_get('vid', 'trim,intval');
        if ($productPropertyValue->delete($vid)) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！请重试~');
        }
    }

    //递归处理查找父元素
    private function _searchFilterAttr($cat_id) {
        static $Ids = '';
        $res = M('ProductCategory')->where(array('cat_id' => $cat_id))->find();
        $Ids .= $res['filter_attr'];
        if ($res['cat_fid'] != 0) {
            $this->_searchParent($res['cat_fid']);
        }
        return $Ids;
    }

}