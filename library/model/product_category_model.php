<?php

/**
 * 商品分类模型
 * User: pigcms_21
 * Date: 2015/2/2
 * Time: 18:19
 */
class product_category_model extends base_model {

	/*
	 * @param： limit  限制显示数量()
	 * @param: is_show_son   是否显示子集(如果显示则：查出顶级分类 和子分类的数据)
	 * */
	public function getAllCategory($limit="",$is_show_son=false) {
		$new_category_list = array();
		if($limit) {$limits = $limit;} else {$limits='';}

		if($is_show_son) {
			$where["_string"] = " cat_fid=0 and cat_status=1 and cat_level=1";			
		} else {
			$where = array(
				'cat_status' => 1	
			);
		}
		
		$category_list = $this->db->where($where)->order('`cat_fid` ASC,`cat_sort` DESC,`cat_id` ASC')->limit($limits)->select();
		if($is_show_son) {
			
			foreach($category_list as $k=>$v) {
				if ($v['cat_pic']) {
					$v['cat_pic'] = getAttachmentUrl($v['cat_pic']);
				}
				if ($v['cat_pc_pic']) {
					$v['cat_pc_pic'] = getAttachmentUrl($v['cat_pc_pic']);
				}


				
				
				$levelArray = $this->getCategories("cat_fid='".$v['cat_id']."' and cat_status = 1");
				//dump($levelArray);exit;
			
				if (is_array($levelArray)) {
					foreach($levelArray as $key => $value) {
						if ($value['cat_pic']) {
							$levelArray[$key]['cat_pic'] = getAttachmentUrl($value['cat_pic']);
						}
						if ($value['cat_pc_pic']) {
							$levelArray[$key]['cat_pc_pic'] = getAttachmentUrl($value['cat_pc_pic']);
						}
					}
				}
				$v['larray'] = $levelArray;

				$array[] = $v;
			}
			
		} else {
			
			foreach ($category_list as $value) {
				if ($value['cat_pic']) {
					$value['cat_pic'] = getAttachmentUrl($value['cat_pic']);
				}
				if ($value['cat_pc_pic']) {
					$value['cat_pc_pic'] = getAttachmentUrl($value['cat_pc_pic']);
				}
				if (empty($value['cat_fid'])) {
					$array[$value['cat_id']] = $value;
				} else {
					$array[$value['cat_fid']]['cat_list'][] = $value;
				}
			}
			
			
		}
		
	
		return $array;
	}

	//根据商品分类id 获取所在的tree
	public function getOneCategoryTree($category_id) {
		$details = $this->getCategory($category_id);

		if($details['cat_fid']) {
			$detail2 = $this->getCategory($details['cat_fid']);
			$detail2['son'] = $details;
			$detail = $detail2;
		} else {
			$detail = $details;
		}
		$return = array(
			'tree' => $detail,	  //类别树
			'current'=> $details	//当前的店铺类目类别
		);
		return $return;
	}


	public function getOneTreeCategory($category_id) {
		$new_category_list = array();
		$category_id = sprintf("%02d", $category_id);
		$category_list = $this->db->where("find_in_set('" . $category_id . "',cat_path)")->order('`cat_fid` ASC,`cat_sort` DESC,`cat_id` ASC')->select();

		foreach ($category_list as $value) {
			if ($value['cat_pic']) {
				$value['cat_pic'] = getAttachmentUrl($value['cat_pic']);
			}
			if ($value['cat_pc_pic']) {
				$value['cat_pc_pic'] = getAttachmentUrl($value['cat_pc_pic']);
			}
			if (empty($value['cat_fid'])) {
				$new_category_list[$value['cat_id']] = $value;
				$arrs[$value['cat_id']] = $value;
			} else {
				$new_category_list[$value['cat_fid']]['cat_list'][] = $value;
			}
		}

		return $new_category_list;
	}

	public function getCategory($category_id) {
		$category = $this->db->where(array('cat_id' => $category_id))->find();
		return $category;
	}

	public function getCategories($wheres =array()) {
		$categories = $this->db->where($wheres)->order('cat_path ASC')->select();
		return $categories;
	}

	public  function categorySelect($where = array()) {
		$categories = $this->db->where($where)->order('cat_path ASC')->find();
		
		return $categories;
		
	}

}