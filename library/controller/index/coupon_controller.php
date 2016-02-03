<?php
/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/6/25
 * Time: 11:10
 */

class coupon_controller extends base_controller{


	public function __construct() {

		parent::__construct();
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


		//	dump($coupon_list);

		$this->assign('pages', $pages);
		$this->assign('count', $count);
		$this->assign('coupon_list', $coupon_list);
		$this->assign('user_collect', $user_collect);
		$this->assign('store', $store);
		$this->display();
	}


	//ajax 领取优惠券
	function addCouponBystoreid()
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
	function detail() {
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
		$param_search = array('id'=> $id);
		// 检查是否已经收藏
		$user_collect = array('click' => 'userCollect', 'title' => '收藏店铺');
		if (!empty($this->user_session)) {
			$collect = D('User_collect')->where(array('type' => 2, 'user_id' => $this->user_session['uid'], 'dataid' => $id))->find();

			if (!empty($collect)) {
				$user_collect = array('click' => 'cancelCollect', 'title' => '取消收藏');
			}
		}

		$this->assign('coupon_detail', $coupon_detail);
		$this->assign('product_list', $product_list);
		$this->assign('store', $store);
		$this->assign('param_search', $param_search);
		$this->assign('user_collect', $user_collect);
		$this->assign('pages', $pages);
		$this->display();
	}
} 