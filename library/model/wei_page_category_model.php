<?php
class wei_page_category_model extends base_model{
	/*分页得到微页面分类的列表*/
	public function get_list($store_id, $page_size = 15){
        $where = array();
        $where['store_id'] = $store_id;
        if (!empty($_REQUEST['keyword'])) {
            $where['cat_name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
		$list_count = $this->db->where($where)->count('cat_id');
		import('source.class.user_page');
		$p = new Page($list_count,$page_size);
		$cat_list = $this->db->field('`cat_id`,`cat_name`,`page_count`,`add_time`')->where($where)->order('`cat_id` DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$return['cat_list'] = $cat_list;
		$return['page'] = $p->show();
		return $return;
	}
	/*分页得到所有微页面分类的列表*/
	public function getAllList($page_size = 15){
        $where = array();
        if (!empty($_REQUEST['keyword'])) {
            $where['cat_name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
		$list_count = $this->db->where($where)->count('cat_id');
		import('source.class.user_page');
		$p = new Page($list_count,$page_size);
		$cat_list = $this->db->field('`cat_id`,`cat_name`,`page_count`,`add_time`')->where($where)->order('`cat_id` DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$return['cat_list'] = $cat_list;
		$return['page'] = $p->show();
		return $return;
	}
	public function get_all_list($store_id){
		$cat_list = $this->db->field('`cat_id`,`cat_name`')->where(array('store_id'=>$store_id))->order('`cat_id` DESC')->select();
		return $cat_list;
	}
	/*得到一个微页面分类*/
	public function get_category($store_id,$cat_id){
		$condition_category['store_id'] = $store_id;
		$condition_category['cat_id'] = $cat_id;
		$now_category = $this->db->where($condition_category)->find();
		return $now_category;
	}

	/*删除分类*/
	public function delete($where) {
		if (empty($where)) {
			return false;
		}

		$result = $this->db->where($where)->delete();
		return $result;
	}
}
?>