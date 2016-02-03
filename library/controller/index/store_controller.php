<?php
/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/5/23
 * Time: 15:24
 */

class store_controller extends base_controller{
	
	public function __construct(){
		parent::__construct();
	
	}
	
	
	public function index(){
		$id = $_GET['id'];
		$page = max(1, $_GET['page']);
		$limit = 120;
		
		if (empty($id)) {
			pigcms_tips('缺少最基本的参数', 'none');
		}
		
		$store_model = M('Store');
		$store = $store_model->getStore($id);
		
		if (empty($store)) {
			pigcms_tips('未找到相应的店铺', 'none');
		}

		$is_preview = $_GET['is_preview'];
		
		if (!is_mobile() && $this->user_session && $id == $_SESSION['store']['store_id']) {
			$homePage = D('Wei_page')->where(array('is_home'=>1,'store_id'=>$_SESSION['store']['store_id']))->find();
			$this->assign('homePage', $homePage);
			$this->assign('is_preview', $is_preview);
		}

		$product_model = M('Product');
		
		// 抽出店铺产品
		$where = array();
		$where['store_id'] = $id;
		$where['status'] = 1;
		$count = $product_model->getSellingTotal($where);
		
		$product_list = array();
		$pages = '';
		$total_pages = ceil($count / $limit);
		if ($count > 0) {
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;
			
			$product_list = $product_model->getSelling($where, 'sort', 'desc', $offset, $limit);
			
			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		// 主营分类
		$sale_category = M('Store')->getSaleCategory($id, $store['uid']);
		
		// 检查是否已经收藏
		$user_collect = array('click' => 'userCollect', 'title' => '收藏店铺');
		if (!empty($this->user_session)) {
			$collect = D('User_collect')->where(array('type' => 2, 'user_id' => $this->user_session['uid'], 'dataid' => $id))->find();
				
			if (!empty($collect)) {
				$user_collect = array('click' => 'cancelCollect', 'title' => '取消收藏');
			}
		}

		//该店铺下分享链接的：优惠券列表
		$Coupon_model = M('Coupon');
		$where = array();
		$where['store_id'] = $id;
		$where['type'] = 1;
		$where['status'] = 1;
		//$where['is_share'] = 1;
		$couponlist_count = $Coupon_model->getCount($where);
		
		// 店铺满减
		$where = array();
		$where['status'] = 1;
		$where['store_id'] = $id;
		$where['start_time'] = array('<=', time());
		$where['end_time'] = array('>=', time());
		$reward_list = M('Reward')->getList($where);
		
		// 店铺联系信息
		$store_contact = M('Store_contact')->get($id);
		
		// 评论满意，一般，不满意数量，以及满意百分比
		$where = array();
		$where['type'] = 'STORE';
		$where['relation_id'] = $id;
		$comment_type_count = M('Comment')->getCountList($where);
		$satisfaction_pre = '100%';
		if ($comment_type_count['total'] > 0) {
			$satisfaction_pre = round($comment_type_count['t3'] / $comment_type_count['total'] * 100) . '%';
		}
		$comment_type_count['satisfaction_pre'] = $satisfaction_pre;
		
		$this->assign('imUrl',getImUrl($_SESSION['user']['uid'],$store['store_id']));
		$this->assign('product_count', $count);
		$this->assign('pages', $pages);
		$this->assign('store', $store);
		$this->assign('product_list', $product_list);
		$this->assign('sale_category', $sale_category);
		$this->assign('user_collect', $user_collect);
		$this->assign('couponlist_count', $couponlist_count);
		$this->assign('reward_list', $reward_list);
		$this->assign('store_contact', $store_contact);
		$this->assign('comment_type_count', $comment_type_count);

		$this->display();
	}
	
	// 店铺的分销动态
	public function financial() {
		$store_id = $_GET['store_id'];
		$page = max(1, $_GET['page']);
		$limit = 10;
		
		$financial_record_model = M('Financial_record');
		$count = $financial_record_model->snsCount(array('store_id' => $store_id));
		
		$pages = '';
		$total_pages = 0;
		$financial_record_list = array();
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;
			
			$where = array();
			$where['store_id'] = $store_id;
			$financial_record_list = $financial_record_model->sns($where, $limit, $offset);
			
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		$this->assign('pages', $pages);
		$this->assign('total_pages', $total_pages);
		$this->assign('financial_record_list', $financial_record_list);
		$this->display();
	}
	
	// 店铺产品
	public function goods() {
		$store_id = $_GET['store_id'];
		$sort = $_GET['sort'];
		$page = max(1, $_GET['page']);
		
		$pages = '';
		$total_pages = 0;
		$product_list = array();
		$store_contact_list = array();
		$limit = 16;
		if (!empty($store_id)) {
			$product_model = M('Product');
			$where = array();
			$where['status'] = 1;
			$where['store_id'] = $store_id;
			
			$sort_arr = array('default', 'sales', 'price');
			if (!in_array($sort, $sort_arr)) {
				$sort = 'default';
			}
			
			if ($sort == 'default') {
				$sort = '';
			}
			
			
			$count = $product_model->getSellingTotal($where);
			
			if ($count > 0) {
				$total_pages = ceil($count / $limit);
				$page = min($page, $total_pages);
				$offset = ($page - 1) * $limit;
				
				$product_list = $product_model->getSelling($where, $sort, 'desc', $offset, $limit);
				
				import('source.class.user_page');
				$user_page = new Page($count, $limit, $page);
				$pages = $user_page->show();
			}
			
			// 供货商ID列表，用于取出供货商的经纬度
			$supplier_id_arr = array($store_id => $store_id);
			foreach ($product_list as $product) {
				if ($product['supplier_id']) {
					$supplier_id_arr[$product['supplier_id']] = $product['supplier_id'];
				}
			}
			
			$store_contact_list = M('Store_contact')->get_store_contact_info($supplier_id_arr);
		}
		
		$this->assign('current_page_arr', array('page' => $page, 'total_pages' => $total_pages));
		$this->assign('sort', $sort);
		$this->assign('pages', $pages);
		$this->assign('product_list', $product_list);
		$this->assign('store_contact_list', $store_contact_list);
		
		$this->display();
	}
	
	
	//店铺列表页
	public function store_list(){
		$id = $_GET['id'] + 0;
		$distance 	= $_GET['distance'] ? $_GET['distance'] : '';
		$order = $_GET['order'];
		$sort = $_GET['sort'];
		$page = max(1, $_GET['page']);
		$limit = 20;
		$WebUserInfo = $this->user_location;
		
		if($id) {
			$categoryTree = M('Sale_category')->getOneCategoryTree($id);
			//dump($CategoryTree);
			$this->assign('categoryTree', $categoryTree);
		}
		
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
		
		
		$sale_title = '<a href="' . url('store:store_list') . '">所有分类</a>';
		
		$where_sql = '`s`.`status` = 1';

		if (!empty($id)) {
			$where_sql .= " AND (`s`.`sale_category_fid` = '" . $id . "' or `s`.`sale_category_id` = '" . $id . "')";
		}
		
		$is_distance_order = ($order == 'distance')? 1 : 0;
		
		$count = M('Store')->getStoreByRoundDistanceCount($where_sql,$distance,$is_distance_order);
		
		$store_list = array();
		$pages = '';
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
			

			//距离 位置
			$store_id_list = array();
			
			// 查找总产品数和抽出4个推荐产品						
			foreach ($store_list as &$store) {
				if(empty($store['logo'])) {
					$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
				} else {
					$store['logo'] = getAttachmentUrl($store['logo']);
				}
				// 产品数量
			//	$store['product_number'] = $product_model->getSellingTotal(array('store_id' => $store['store_id'], 'status' => 1));
				// 店铺推荐4个产品
				//$store['product_list'] = $product_model->getSelling(array('store_id' => $store['store_id'], 'status' => 1), 'is_recommend desc, sales', 'desc', 0, 4);
				// 主营分类
				//$store['sale_category'] = M('Store')->getSaleCategory($store['store_id'], $store['uid']);

				$store_id_list[$store['store_id']] = $store['store_id'];
			}

			$store_contact_info = M('store_contact')->get_store_contact_info($store_id_list);

			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		// 热销排序参数
		$param_collect = array();
		$param = array();
		$param_collect['order'] = 'collect';
/* 		if (!empty($id)) {
			$param_collect['id'] = $id;
			$param['id'] = $id;
		} */
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
			$param['order'] = 'collect';
			$param['sort'] = $sort;
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


		$this->assign('current_sale_category', $current_sale_category);
		
		$this->assign('id', $id);
		$this->assign('distance', $distance);
		$this->assign('shop_count', $count);		
		$this->assign('order', $order);
		$this->assign('sale_title', $sale_title);
		$this->assign('store_contact_info', $store_contact_info);
		$this->assign('sale_category_list', $sale_category_list);
		$this->assign('distance_list', $distance_arr);		
		$this->assign('pages', $pages);
		$this->assign('current_page',$current_page);
		$this->assign('store_list', $store_list);
		$this->assign('excellent_list', $excellent_list);
		$this->assign('supplier_list', $supplier_list);
		$this->assign('param_collect', $param_collect);
		$this->assign('param_distance', $param_distance);
		$this->assign('param', $param);
		$this->display();
	}
	
	
	//店铺优惠券列表
	function couponlist(){
	
		if (empty($this->user_session['uid'])) {
			$referer = url('account:index');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}
		$id = $_GET['storeid']; //store_id
		$page = max(1, $_GET['page']);
		$limit = 12;
	
		if (empty($id)) {
			pigcms_tips('缺少最基本的参数', 'none');
		}
	
		$store_model = M('Store');
		$store = $store_model->getStore($id);
	
		if (empty($store)) {
			pigcms_tips('未找到相应的店铺', 'none');
		}
	
		// 检查是否已经收藏
		$user_collect = array('click' => 'userCollect', 'title' => '收藏店铺');
		if (!empty($this->user_session)) {
			$collect = D('User_collect')->where(array('type' => 2, 'user_id' => $this->user_session['uid'], 'dataid' => $id))->find();
			if (!empty($collect)) {
				$user_collect = array('click' => 'cancelCollect', 'title' => '取消收藏');
			}
		}
		
	
		//该店铺下分享链接的：优惠券列表
		$Coupon_model = M('Coupon');
		$where = array();
		$where['store_id'] = $id;
		$where['type'] = 1;
		$where['status'] = 1;
		//$where['is_share'] = 1;
		$count = $Coupon_model->getCount($where);
		
	
		$coupon_list = array();
		$pages = '';
		$total_pages = ceil($count / $limit);
		if ($count > 0) {
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;
			$coupon_list = $Coupon_model->getList($where, 'id desc', $limit, $offset);
	
			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
	

		//该店铺下分享链接的：优惠券列表
		$Coupon_model = M('Coupon');
		$where = array();
		$where['store_id'] = $id;
		$where['type'] = 1;
		$where['status'] = 1;
		//$where['is_share'] = 1;
		$couponlist_count = $Coupon_model->getCount($where);
		
		// 店铺满减
		$where = array();
		$where['status'] = 1;
		$where['store_id'] = $id;
		$where['start_time'] = array('<=', time());
		$where['end_time'] = array('>=', time());
		$reward_list = M('Reward')->getList($where);
		
		// 店铺联系信息
		$store_contact = M('Store_contact')->get($id);	
		//	dump($coupon_list);
		
		// 抽出店铺产品
		$where = array();
		$where['store_id'] = $id;
		$where['status'] = 1;
		$product_count = M('Product')->getSellingTotal($where);
	
		$this->assign('pages', $pages);
		$this->assign('count', $count);
		$this->assign('total_pages',$total_pages);
		$this->assign('couponlist_count',$couponlist_count);
		$this->assign('store_contact', $store_contact);
		$this->assign('coupon_list', $coupon_list);
		$this->assign('user_collect', $user_collect);
		$this->assign('store', $store);
		$this->assign('product_count', $product_count);
		$this->display();
	}
	
	
	//ajax 领取优惠券
	function addcoupon_by_storeid()
	{
	
		if (empty($this->user_session['uid'])) {
			echo json_encode(array('status' => false, 'msg' => '请先登录','data' => array('error' => 'login')));
		}
		$id = $_GET['couponid'];
		$time = time();
		$userid = $this->user_session['uid'];
		if (empty($id)) {
			echo json_encode(array('status' => false, 'msg' => '缺少最基本的参数'));
			exit;
		}
	
		$coupon = D('Coupon')->where(array('id' => $id))->find();
		//查看是否已经领取
	
		if ($coupon['total_amount'] <= $coupon['number']) {
			echo json_encode(array('status' => false, 'msg' => '该优惠券已经全部发放完了！'));
			exit;
		}
	
		if ($coupon['status'] == '0') {
			echo json_encode(array('status' => false, 'msg' => '该优惠券已失效！'));
			exit;
		}
	
		if ($time > $coupon['end_time'] || $time < $coupon['start_time']) {
			echo json_encode(array('status' => false, 'msg' => '该优惠券未开始或已结束！'));
			exit;
		}
	
		if ($coupon['type'] == '2') {
			echo json_encode(array('status' => false, 'msg' => '不可领取赠送券！'));
			exit;
		}
	
		$user_coupon = D('User_coupon')->where(array('uid' => $userid, 'coupon_id' => $id))->field("count(id) as count")->find();
	
		//查看当前用户是否达到最大领取限度
		if ($coupon['most_have'] != '0') {
			if ($user_coupon['count'] >= $coupon['most_have']) {
				echo json_encode(array('status' => false, 'msg' => '您已达到该优惠券允许的最大单人领取限额！'));
				exit;
			}
		}
		//领取
		if(M('User_coupon')->add($userid,$coupon)){
			//修改优惠券领取信息
			unset($where);
			unset($data);
			$where = array('id'=>$id);
			D('Coupon')->where($where)->setInc('number',1);
	
			echo json_encode(array('status' => true, 'msg' => '领取成功', 'data' => array('nexturl' => '')));
		} else{
	
			echo json_encode(array('status' => false, 'msg' => '领取失败', 'data' => array('nexturl' => '')));
		}
	}
	
	
	//优惠券详情
	function coupon_detail() {
		$id = $_GET['id'];
		$page = max(1, $_GET['page']);
		$limit = 15;
		$coupon_to_prodcut = M("Coupon_to_product");
		//查看优惠券及其适用的产品范围
		$product = M('Product');
	
		//只显示有库存 的非分销商品
		$where = array('id'=>$id);
		$coupon_detail = M('Coupon')->getCoupon($where);
	
		unset($where);
	
		//商铺信息
		$store_model = M('Store');
		$store = $store_model->getStore($coupon_detail['store_id']);
                
                $store_contact = M('Store_contact')->get($coupon_detail['store_id']);
	
		if (empty($store)) {
			pigcms_tips('未找到相应的店铺', 'none');
		}
	
		if($coupon_detail['is_all_product'] =='0') {
			//全店通用（自营商品）
	
			$where['quantity'] = array('>', 0);
			$where['store_id'] = $coupon_detail['store_id'];
			$where['supplier_id'] = 0;
			//商品数量
			$count = $product->getSellingTotal($where);
			if($count>0) {
				$order_by_field = "product_id";
				$order_by_method = "desc";
				$total_pages = ceil($count / $limit);
				$page = min($page, $total_pages);
				$offset = ($page - 1) * $limit;
	
				$product_list = $product->getSelling($where,$order_by_field,$order_by_method,$offset,$limit);
				import('source.class.user_page');
				$user_page = new Page($count, $limit, $page);
				$pages = $user_page->show();
	
			}
	
		} else {
	
			$where = "p.quantity > 0 and p.store_id = '". $coupon_detail['store_id']."' and p.supplier_id = 0 ";
			//商品数量
			$count = $coupon_to_prodcut->getSellingCouponProductTotal($where);
	
			if($count>0) {
				$order_by_field = "p.product_id";
				$order_by_method = "desc";
				$total_pages = ceil($count / $limit);
				$page = min($page, $total_pages);
				$offset = ($page - 1) * $limit;
	
				$product_list = $coupon_to_prodcut->getSellingCouponProduct($where,$order_by_field,$order_by_method,$offset,$limit);
				import('source.class.user_page');
				$user_page = new Page($count, $limit, $page);
				$pages = $user_page->show();
	
	
			}
	
		}
                
                //查看是否已领取
                //$coupon_detail['coupon_num'] = D('User_coupon')->where(array('uid' => $_SESSION['user']['uid'], 'coupon_id' => $id))->field("count(id) as coupon_num")->find();
                $coupon_detail['coupon_num'] = M('User_coupon')->getCount(array('uid' => $_SESSION['user']['uid'], 'coupon_id' => $id));
		$param_search = array('id'=> $id);
		// 检查是否已经收藏
		$user_collect = array('click' => 'userCollect', 'title' => '收藏店铺');
		if (!empty($this->user_session)) {
			$collect = D('User_collect')->where(array('type' => 2, 'user_id' => $this->user_session['uid'], 'dataid' => $id))->find();
	
			if (!empty($collect)) {
				$user_collect = array('click' => 'cancelCollect', 'title' => '取消收藏');
			}
		}
		
		// 抽出店铺产品
		$where = array();
		$where['store_id'] = $store['store_id'];
		$where['status'] = 1;
		$product_count = M('Product')->getSellingTotal($where);

		$this->assign('coupon_detail', $coupon_detail);
                $this->assign('store_contact', $store_contact);
		$this->assign('product_list', $product_list);
		$this->assign('store', $store);
		$this->assign('param_search', $param_search);
		$this->assign('user_collect', $user_collect);
		$this->assign('pages', $pages);
		$this->assign('product_count', $product_count);
		$this->display();
	}	


}