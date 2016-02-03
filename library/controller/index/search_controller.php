<?php
/**
 * 搜索
 * User: pigcms_21
 * Date: 2015/5/28
 * Time: 14:41
 */
class search_controller extends base_controller{
	/**
	 * 搜索店铺页
	 */
	function store() {
		// 搜索条件
		$id 		= $_GET['id'] + 0;
		$distance 	= $_GET['distance'] ? $_GET['distance'] : '';
		$keyword 	= trim($_GET['keyword']);
		$page 		= max(1, $_GET['page']);
		$order 		= $_GET['order'];
		$sort 		= $_GET['sort'];
		$limit	 	= 20;
		$crumb 	= array();
		$WebUserInfo = $this->user_location;
		
		/*if (empty($keyword)) {
			pigcms_tips('没有搜索关键词');
		}*/
		
		//距离数组demo
		$distance_arr = array(
				"0"  => array("key"=>"0",  "text"=>"不限"),
				"1"  => array("key"=>"0.5", "text"=>"500m"),
				"2"  => array("key"=>"1", "text"=>"1km"),
				"3"  => array("key"=>"2", "text"=>"2km"),
				"4" => array("key"=>"5", "text"=>"5km"),
				"5" => array("key"=>"10", "text"=>"10km"),
		);		
		foreach($distance_arr as $k=>$v) {
			$distance_arr_key[] = $v['key'];
		}
	
		if($id) {
			$categoryTree = M('Sale_category')->getOneCategoryTree($id);
			$this->assign('categoryTree', $categoryTree);
		}
			
			if (empty($order) || !in_array($order, array('date', 'collect','distance'))) {
			$order = 'date';
		}
		
		//距离排序 默认升序
		if($order == 'distance') {
			if (empty($sort) || !in_array($sort, array('asc', 'desc'))) {
				$sort = "asc";
			}
			
		}
		if (empty($sort) || !in_array($sort, array('asc', 'desc'))) {
			if($distance) {
				$sort = "asc";
			} else {
				$sort = 'desc';
			}
		}
	
		if (empty($distance) || !in_array($distance, $distance_arr_key)) {
			$distance = "";
		}	
		
		if(!$WebUserInfo['long']) {
			if($order == "distance") {$order = "date";}
			$distance = "";
		}		
		
		
		
		$sale_category_model = M('Sale_category');
		// 第一步抽出分类
		$sale_category_list = $sale_category_model->getCategories($id);
		
		// 如果分类为空时，选择与他同级的分类
		if (empty($sale_category_list)) {
			$current_sale_category = $sale_category_model->getCategory($id);
			$sale_category_list = $sale_category_model->getCategories($current_sale_category['parent_id']);
		} else{
			if($id) {
				$current_sale_category = $sale_category_model->getCategory($id);
			}
		}

		
		$sale_title = '<a href="' . url('search:store', array('keyword' => $keyword)) . '">所有分类</a>';
		$where_sql = "`s`.`status` = 1";

		if(!empty($keyword)) {
			$where_sql 	.= " AND `s`.`name` LIKE '%" . $keyword . "%'";
			$this->assign('searchKeyword',$keyword);
		}

		if (!empty($id)) {
			$where_sql .= " AND (`s`.`sale_category_fid` = '" . $id . "' or `s`.`sale_category_id` = '" . $id . "')";
		}
		
		$is_distance_order = ($order == 'distance')? 1 : 0;
		
		$count = M('Store')->getStoreByRoundDistanceCount($where_sql,$distance,$is_distance_order);
		
		$store_list = array();
		$pages = '';
		$total_pages = 0;
		if ($count > 0) {
			
			$total_pages = ceil($count / $limit);
			
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;
				
			$order_sort = '';
			if ($order == 'date') {
				$orders = 's.date_added ';
			} elseif($order == 'distance'){
				$orders = " juli ";
			} else {
				$orders = ' s.collect ';
			}
			
			$store_list = M('Store')->getStoreByRoundDistance($where_sql,$limit,$offset,$orders,$sort,$distance,$is_distance_order);
			
			$product_model = M('Product');
				
			// 查找总产品数和抽出4个推荐产品
			
			//距离 位置
			$store_id_list = array();
			
			foreach ($store_list as &$store) {
				if(empty($store['logo'])) {
					$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
				} else {
					$store['logo'] = getAttachmentUrl($store['logo']);
				}
				// 产品数量
				//$store['product_number'] = $product_model->getSellingTotal(array('store_id' => $store['store_id'], 'status' => 1));
				// 店铺推荐4个产品
				//$store['product_list'] = $product_model->getSelling(array('store_id' => $store['store_id'], 'status' => 1), 'is_recommend desc, sales', 'desc', 0, 4);
				// 主营分类
				//$store['sale_category'] = M('Store')->getSaleCategory($store['store_id'], $store['uid']);
				
				$store_id_list[] = $store['store_id'];

			}
			
			$store_contact_info = M('store_contact')->get_store_contact_info($store_id_list);

			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		// 热销排序参数
		$param_collect = array();
		$param_distance = array();
		$param = array();
		$param_search = array();
		$param['keyword'] = $keyword;
		$param_search['keyword'] = $keyword;
		$param_collect['order'] = 'collect';	
		$param_collect['keyword'] = $keyword;	
		$param_distance['order'] = 'distance';
		$param_distance['keyword'] = $keyword;


		
		if (!empty($id)) {
			$param_collect['id'] = $id;
			$param['id'] = $id;
			$param_search['id'] = $id;
			$param_distance['id'] = $id;
		}
		
 		if(!empty($distance)) {
 			$param_distance['distance'] = $distance;
 			$param['distance'] = $distance;
 			$param_search['distance'] = $distance;
 			$param_collect['distance'] = $distance;
 		} 
		
		
		if ($order == 'collect') {
			$param_collect['sort'] = $sort == 'asc' ? 'desc' : 'asc';
			$param_search['order'] = 'collect';
			$param_search['sort'] = $sort;
		}
		
		if ($order == 'distance') {
			$param_distance['sort'] = $sort == 'asc' ? 'desc' : 'asc';
			$param_search['order'] = 'distance';
			$param_search['sort'] = $sort;			
		}

	
		//优质店铺
		$excellent_list = M('Store')->goodExcellentList(0,6,true);
		//优质供应商
		$supplier_list = M('Store')->supplieStore(0,18,true);
		
		//当前页码
		$current_page = array(
			'total_page'=> $total_pages,
			'current_page'=> $page
		);


		
		//$search_param_type = 
		//$categoryTree  = M('Product_category')->getOneCategoryTree($id);
		//$this->assign('categoryTree', $categoryTree);		
		
		//dump($current_sale_category);
		$this->assign('current_sale_category', $current_sale_category);
		$this->assign('WebUserInfo', $WebUserInfo);
		$this->assign('id', $id);
		$this->assign('distance', $distance);
		$this->assign('order', $order);
		$this->assign('shop_count', $count);
		$this->assign('sale_title', $sale_title);
		$this->assign('sale_category_list', $sale_category_list);
		$this->assign('distance_list', $distance_arr);
		$this->assign('store_contact_info', $store_contact_info);
		$this->assign('pages', $pages);
		$this->assign('store_list', $store_list);
		$this->assign('param_collect', $param_collect);
		$this->assign('param_distance', $param_distance);		
		$this->assign('param', $param);
		$this->assign('param_search', $param_search);
		$this->assign('page_arr', array('current_page' => $page, 'total_pages' => $total_pages));
		$this->assign('current_page',$current_page);
		$this->assign('excellent_list', $excellent_list);
		$this->assign('supplier_list', $supplier_list);
		$this->display();
	}
	
	/**
	 * 搜索产品页
	 */
	function goods() {
		$id = $_GET['id'];
		$keyword = $_GET['keyword'];
		$start_price = $_GET['start_price'];
		$end_price = $_GET['end_price'];
		$page = max(1, $_GET['page']);
		$order = $_GET['order'];
		$sort = $_GET['sort'];
		$limit = 20;
		$WebUserInfo = $this->user_location;

		if (empty($keyword)) {
			pigcms_tips('请输入搜索关键词');
		}
		if($order == 'juli') {
			if(!$WebUserInfo['long']) {
				$order = "";
			}
		}
		
		// 产品分类
		if (!empty($id)) {
			// 顶级分类和子分类
			$product_category_model = M('Product_category');
			$category_detail = $product_category_model->getCategory($id);

			
			// 目前产品分类只支持两级
			$cid = $category_detail['cat_id'];
			
			// 当访问的不是首分类时，修正为父级分类ID
			if ($category_detail['cat_fid'] != 0) {
				$cid = $category_detail['cat_fid'];
			}
			
			// 父类分类
			$f_category = array();
			$s_category = array();
			// 搜索分类id
			$search_cat_id_arr = array();
			
			$s_category = D('Product_category')->where(array('cat_fid' => $cid))->order('cat_sort desc, cat_id asc')->select();
			if ($cid == $category_detail['cat_id']) {
				$f_category = $category_detail;
					
				foreach ($s_category as $tmp) {
					$search_cat_id_arr[] = $tmp['cat_id'];
				}
				$search_cat_id_arr[] = $cid;
			} else {
				$f_category = $product_category_model->getCategory($cid);
			}
		} else {
			$s_category = D('Product_category')->where(array('cat_fid' => 0))->order('cat_sort desc, cat_id asc')->select();
		}
		
		// 修正排序
		$order_arr = array('sort', 'sales', 'price','juli');
		$sort_arr = array('desc', 'asc');
		
		if (!in_array($order, $order_arr)) {
			$order = 'sort';
		}
		
		if (!in_array($sort, $sort_arr)) {
			$sort = 'asc';
		}
		
		if (!empty($start_price) && !empty($end_price) && $start_price > $end_price) {
			$tmp_price = $start_price;
			$start_price = $end_price;
			$end_price = $tmp_price;
		}
		
		$where_sql = "`status` = 1 AND `name` like '%" . $keyword . "%'";
		$where_sql2[] = "  `p`.`name` like '%" . $keyword . "%'";

		if (!empty($start_price)) {
			$where_sql .= " AND `price` >= '" . $start_price . "'";
			$where_sql2[] = "  `p`.`price` >= '" . $start_price . "'";
		}
		if (!empty($end_price)) {
			$where_sql .= " AND `price` <= '" . $end_price . "'";
			$where_sql2[] = "  p.`price` <= '" . $end_price . "'";
		}
		
		if (!empty($id)) {
			if (empty($search_cat_id_arr)) {
				$where_sql .= " AND `category_id` = '" . $id . "'";
				$where_sql2[]= "  `p`.`category_id` = '" . $id . "'";
			} else {
				$where_sql .= " AND `category_id` in (" . join(',', $search_cat_id_arr) . ")";
				$where_sql2[]= " `p`.`category_id` in (" . join(',', $search_cat_id_arr) . ")";
			}
		}
		
		// 不出现分销
		$where_sql .= " AND `supplier_id` = '0'";
		//$where_sql2 .= " AND p.`supplier_id` = '0'";
		if($order == 'juli') {
			if($where_sql2) $where_sql2 = implode(" and ",$where_sql2);
			$count = M('Product')->getSellingBydistanceCount($where_sql2);
		} else {
			$count = D('Product')->where($where_sql)->count('product_id');
		}
		$product_list = array();
		$store_list = array();
		$pages = '';
		$total_pages = 0;
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;

			if($order == 'juli') {
				$orders =" juli ";
				
				$product_list = M('Product')->getSellingBydistance($where_sql2, $orders, $sort, $offset, $limit);
			} else {
				$product_list = M('Product')->getSelling($where_sql, $order, $sort, $offset, $limit);
			}
			// 查找店铺
			$store_id_list = array();
			foreach ($product_list as $product) {
				$store_id_list[$product['store_id']] = $product['store_id'];
			}
				
			$store_list = M('Store')->getStoreName($store_id_list);
			
			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		
		// 默认搜索条件
		$param = array();
		$param['keyword'] = $keyword;
		if (!empty($start_price)) {
			$param['start_price'] = $start_price;
		}
		if (!empty($end_price)) {
			$param['end_price'] = $end_price;
		}
		if (!empty($id)) {
			$param['id'] = $id;
		}
		
		// 分类搜索
		$param_category = $param;
		if (!empty($f_category)) {
			$param_category['id'] = $f_category['cat_id'];
		}
		//unset($param_category['id']);
		
		// 当前搜索条件
		$param_search = $param;
		if ($order != 'sort') {
			$param_search['order'] = $order;
			$param_search['sort'] = $sort;
		}
		
		// 更改下次排序
		$sort = $sort == 'asc' ? 'desc' : 'asc';
		
		// 热销搜索条件
		$param_sales = $param;
		$param_sales['order'] = 'sales';
		$param_sales['sort'] = $sort;
		
		// 价格搜索条件
		$param_price = $param;
		$param_price['order'] = 'price';
		$param_price['sort'] = $sort;
		
		// 距离搜索条件
		$param_distance = $param;
		$param_distance['order'] ="juli";
		$param_distance['sort'] = $sort;		

///////////////
		$store_id_list = array();

		foreach ($product_list as &$product) {
			$store_id_list[$product['store_id']] = $product['store_id'];
		}

		//$store_list = M('Store')->getStoreName($store_id_list);
		
		$store_contact_info = M('store_contact')->get_store_contact_info($store_id_list);
//////////////
		//获取树
		$count = $count ? $count:0;

		$this->assign('param', $param);
		$this->assign('params', $param);
		$this->assign('searchKeyword',$keyword);
		$this->assign('cid', $id);
		$this->assign('WebUserInfo', $WebUserInfo);
		$this->assign('f_category', $f_category);
		$this->assign('s_category', $s_category);
		$this->assign('product_list', $product_list);
		$this->assign('store_list', $store_list);
		$this->assign('pages', $pages);
	
		$this->assign('param_search', $param_search);
		$this->assign('param_distance', $param_distance);
		$this->assign('param_sales', $param_sales);
		$this->assign('param_price', $param_price);
		$this->assign('store_contact_info', $store_contact_info);
		
		$this->assign('param_category', $param_category);
		$this->assign('product_count',$count);
		$this->assign('page_arr', array('current_page' => $page, 'total_pages' => $total_pages));
		$this->display();
	}
	
	

}