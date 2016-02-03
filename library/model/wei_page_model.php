<?php
class wei_page_model extends base_model{
	/*分页得到微页面的列表*/
	public function get_list($store_id, $page_size = 15){
        $where = array();
        $where['store_id'] = $store_id;
        if (!empty($_REQUEST['keyword'])) {
            $where['page_name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
		$list_count = $this->db->where($where)->count('page_id');
		import('source.class.user_page');
		$p = new Page($list_count,$page_size);
		$page_list = $this->db->where($where)->order('`page_id` DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$return['page_list'] = $page_list;
		$return['page'] = $p->show();
		return $return;
	}
	/*分页得到所有微页面的列表*/
	public function getAllList($page_size = 15){
        if (!empty($_REQUEST['keyword'])) {
            $where['page_name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
		$list_count = $this->db->where($where)->count('page_id');
		import('source.class.user_page');
		$p = new Page($list_count,$page_size);
		$page_list = $this->db->where($where)->order('`page_id` DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$return['page_list'] = $page_list;
		$return['page'] = $p->show();
		return $return;
	}
	/*得到分组下的微页面列表*/
	public function getCategoryPageList($cat_id,$first_sort='0',$second_sort='0'){
		switch($first_sort){
			case '0':
				$order .= ' `wp`.`page_id` DESC';
				break;
			case '1':
				$order .= ' `wp`.`hits` DESC';
		}
		switch($second_sort){
			case '0':
				$order .= ',`wp`.`add_time` DESC';
				break;
			case '1':
				$order .= ',`wp`.`add_time` ASC';
			case '2':
				if($first_sort != '1'){
					$order .= ',`wp`.`hits` DESC';
				}
		}
		$database = D('');
		$page_list = $database->table(array('Wei_page_to_category'=>'wptc','Wei_page'=>'wp'))->where("`wptc`.`cat_id`='$cat_id' AND `wptc`.`page_id`=`wp`.`page_id`")->order($order)->select();
		return $page_list;
	}
	/*得到分组下的指定数量的页面列表*/
	public function getCategoryPageNumberList($cat_id,$number){
		$page_list = D('')->table(array('Wei_page_to_category'=>'wptc','Wei_page'=>'wp'))->where("`wptc`.`cat_id`='$cat_id' AND `wptc`.`page_id`=`wp`.`page_id`")->order('`wp`.`page_id` DESC')->limit($number)->select();
		return $page_list;
	}
	/*得到一个微页面*/
	public function get_page($store_id,$page_id){
		$condition_page['store_id'] = $store_id;
		$condition_page['page_id'] = $page_id;
		return $this->db->where($condition_page)->find();	
	}

    //微页面数量
    public function get_wei_page_total($store_id)
    {
        return $this->db->where(array('store_id'=>$store_id))->count('page_id');
    }

    //店铺主页
    public function getHomePage($store_id)
    {
        $page = $this->db->where(array('store_id' => $store_id, 'is_home' => 1))->find();
        return !empty($page) ? $page : '';
    }
}
?>