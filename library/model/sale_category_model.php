<?php
/**
 * 主营类目数据模型
 * User: pigcms_21
 * Date: 2015/2/13
 * Time: 13:57
 */
class sale_category_model extends base_model{
	public function getCategory($category_id){
		$category = $this->db->where(array('cat_id' => $category_id))->find();
		return $category;
	}

	public function getCategories($parent_id = 0){
		$categories = $this->db->where(array('parent_id' => $parent_id, 'status' => 1))->order('order_by DESC')->select();
		return $categories;
	}
	
	public function getCategoriesValid($parent_id = 0){
		$categories = $this->db->where(array('parent_id' => $parent_id, 'status' => 1))->order('order_by DESC')->select();
		return $categories;
	}

	//根据店铺类目id 获取所在的tree
	public function getOneCategoryTree($category_id) {
		$details = $this->getCategory($category_id);
		if($details['parent_id']) {
			$detail2 = $this->getCategory($details['parent_id']);
			$detail2['son'] = $details;
			$detail = $detail2;
		} else {
			$detail = $details;
		}
		$return = array(
			'tree' => $detail,      //类别树
			'current'=> $details    //当前的店铺类目类别
		);
		return $return;
	}

	public function getAllCategory($where = array()) {
		$category_list = $this->db->where($where)->order('`parent_id` ASC,`order_by` DESC,`cat_id` ASC')->select();

		$new_category_list = array();
		foreach($category_list as $value){
			if($value['cat_pic']){
				$value['cat_pic'] = getAttachmentUrl($value['cat_pic']);
			}
			if(empty($value['parent_id'])){
				$new_category_list[$value['cat_id']] = $value;
			}else{
				$new_category_list[$value['parent_id']]['cat_list'][] = $value;
			}
		}
		return $new_category_list;
	}

	public function getCategoryList($where = array(),$limit){
		$category_list = $this->db->where($where)->order('`order_by` DESC,`parent_id` ASC')->limit($limit)->select();

		return $category_list;
	}

    //店铺数加1
    public function setStoreInc($category_id)
    {
        return $this->db->where(array('cat_id' => $category_id))->setInc('stores', 1);
    }
    //店铺数减1
    public function setStoreDec($category_id)
    {
        return $this->db->where(array('cat_id' => $category_id))->setDec('stores', 1);
    }

}