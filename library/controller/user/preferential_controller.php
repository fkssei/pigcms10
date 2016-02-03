<?php
/**
 * Created by PhpStorm.
 * description:  优惠券&优惠码 controller
 * User: pigcms-s
 * Date: 2015/6/17
 * Time: 10:35
 */

class preferential_controller extends base_controller {

	public function __construct(){
		parent::__construct();
		if(empty($this->store_session)) redirect(url('index:index'));
	}

	//加载
	public function load() {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');

		switch ($action) {
			//优惠券
			case 'coupon_index':
				$this->_coupon_index();
				break;
			//优惠券添加
			case 'coupon_create':
				$this->_coupon_create();
				break;

			case 'coupon_edit':
				$this->_coupon_edit();
				break;

			case 'fetchlist':
				$this->_fetchlist();
				break;

			default:

				break;
		}

		$this->display($_POST['page']);
	}

	public function coupon() {
		$this->display();
	}

	//优惠券首页
	public function _coupon_index(){


		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$type = $_REQUEST['type'];
		$keyword = $_REQUEST['keyword'];
		$limit = 20;

		$type_arr = array('future', 'on', 'end', 'all');
		if (!in_array($type, $type_arr)) {
			$type = 'all';
		}

		$uid = $_SESSION['store']['uid'];
		$store_id = $_SESSION['store']['store_id'];

		$where = array();
		$where['uid'] = $uid;
		$where['store_id'] = $store_id;

		if (!empty($keyword)) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}

		$time = time();
		if ($type == 'future') {
			$where['start_time'] = array('>', $time);
			$where['status'] = 1;
		} else if ($type == 'on') {
			$where['start_time'] = array('<', $time);
			$where['end_time'] = array('>', $time);
			$where['status'] = 1;
		} else if ($type == 'end') {
			$where = "`uid` = '" . $uid . "' AND `store_id` = '" . $store_id . "' AND (`end_time` < '" . $time . "' OR `status` = '0')";
		}

		$coupon_model = M('Coupon');
		$count = $coupon_model->getCount($where);

		$coupon_list = array();
		$pages = '';
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$order_by = "";
			//$offset = "";
			$coupon_list = $coupon_model->getList($where,$order_by,$limit,$offset);

			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		$coupon_arr = array();
		foreach($coupon_list as $k=>$v) {
			$coupon_arr[] = $v['id'];

		}

		//已有多少 人(唯一) 领取
		$ucoupon_model = M('User_coupon');
		$unique_person_have = $ucoupon_model -> getPeopleCountByCoupon($coupon_arr);
		unset($coupon_arr);

		$this->assign('type', $type);
		$this->assign('pages', $pages);
		$this->assign('unique_person_have', $unique_person_have);
		$this->assign('keyword', $keyword);
		$this->assign('coupon_list', $coupon_list);
	}


	//查看指定优惠券的领取人listinfo
	function _fetchlist(){
		$coupon_id = $_REQUEST['coupon_id'] + 0;
		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$limit = 20;

		if (empty($coupon_id)) {
			json_return(1001, '缺少最基本的参数ID');
			exit;
		}

		$where = array();
		//$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['coupon_id'] = $coupon_id;

		$User_coupon_model = M('User_coupon');
		$count = $User_coupon_model->getCount($where);
		if($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$order_by = "";
			//$offset = "";
			unset($where);
			$where['_string'] = "uc.store_id='".$_SESSION['store']['store_id']."' AND uc.coupon_id = '".$coupon_id."'";
			$person_list = $User_coupon_model->getuserList($where,$order_by,$limit,$offset);

			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();



		}else {


		}
		//dump($person_list);
		$this->assign('pages', $pages);
		$this->assign('person_list', $person_list);
	}


	//添加优惠券
	public function _coupon_create() {
		if (IS_POST && isset($_POST['is_submit'])) {

			$name = $_POST['name'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$face_money = $_POST['face_money'];
			$limit_money = $_POST['limit_money'];
			$most_have = $_POST['most_have'];
			$total_amount = $_POST['total_amount'];
			$is_expire_notice = $_POST['is_expire_notice'];
			$is_share = $_POST['is_share'];
			$is_all_product = $_POST['is_all_product'];
			$is_original_price = $_POST['is_original_price'];
			$description = $_POST['description'];
			$product_id = $_POST['product_id'];
			$type = $_POST['coupon_type'];

			$product_id_str = $_POST['product_id'];
			if (!in_array($type,array(1,2))) {
				json_return(1001, '券类型品没有填写，请填写');
			}
			if (empty($name)) {
				json_return(1001, '优惠券名称品名称没有填写，请填写');
			}
			if (empty($face_money)) {
				json_return(1001, '优惠券的面值不能为空！');
			}
			if (empty($start_time)) {
				json_return(1001, '请选择优惠券生效开始时间');
			}

			if (empty($end_time)) {
				json_return(1001, '请选择优惠结束时间');
			}
			if ($is_all_product == 1) {  //部分商品使用优惠券
				if (empty($product_id_str)) {
					json_return(1001, '请至少选择一个产品作为商品作为优惠券使用的对象');
				}
				$product_id_arr = explode("-", $product_id_str);
			}

			/*******/
			// 查找参与活动的产品列表
			/*
			$product_exist = '';
			$time = time();
			$where1 = array();
			$where1['store_id'] = $_SESSION['store']['store_id'];
			$where1['uid'] = $_SESSION['store']['uid'];
			$where1['status'] = 1;
			$where1['start_time'] = array('<=', $time);
			$where1['end_time'] = array('>=', $time);
			$where1['is_all_product'] = 0;

			$coupon = M('Coupon')->getCoupon($where1);

			if (!empty($coupon)) {
				$product_exist = 'ALL';
			} else {
				$product_exist = M('Coupon_to_product')->getProductIDList();
			}
			$product_id_arr = explode("-", $product_id_str);
			if ($product_exist == 'ALL') {
				json_return(1001, '您有其他正在进行的优惠券活动，无法设置商品参与');
			} else if ($is_all_product == '0' && !empty($product_exist)) {
				json_return(1001, '您有其他正在进行的优惠券活动，无法设置商品参与');
			} else {
				if (array_intersect($product_id_arr, $product_exist)) {
					json_return(1001, '您有其他正在进行的优惠券活动，无法设置商品参与');
				}
			}
			*/

			if ($is_all_product == 1) { //选择部分商品时查询
				$where = array();
				$where['status'] = 1;
				$where['product_id'] = array('in', $product_id_arr);
				$where['store_id'] = $_SESSION['store']['store_id'];
				$where['quantity'] = array('>', 0);

				$product_list = D('Product')->where($where)->select();

				if (empty($product_list)) {
					json_return(1001, '您选择的产品不能作为优惠券使用的商品范畴');
				}
			} else {$product_list = array();}

			// 有效期修正
			$start_time = strtotime($start_time);
			$end_time = strtotime($end_time);
			if ($start_time > $end_time) {
				$tmp = $end_time;
				$end_time = $start_time;
				$start_time = $tmp;
			}

			// 插入数据库
			$data = array();
			$data['name'] = $name;
			$data['timestamp'] = time();
			$data['uid'] = $_SESSION['store']['uid'];
			$data['store_id'] = $_SESSION['store']['store_id'];
			$data['face_money'] = $face_money;
			$data['limit_money'] = $limit_money;
			$data['most_have'] = $most_have;
			$data['total_amount'] = $total_amount;
			$data['is_expire_notice'] = $is_expire_notice;
			$data['is_share'] = $is_share;
			$data['is_all_product'] = $is_all_product;
			$data['is_original_price'] = $is_original_price;
			$data['description'] = $description;
			$data['start_time'] = $start_time;
			$data['end_time'] = $end_time;
			$data['type'] = $type;

			$coupon_id = D('Coupon')->data($data)->add();
			if ($coupon_id) {
				foreach ($product_list as $product) {
					unset($data);
					$data['coupon_id'] = $coupon_id;
					$data['product_id'] = $product['product_id'];

					D('Coupon_to_product')->data($data)->add();
				}



				json_return(0, '添加成功');
			} else {
				json_return(1001, '添加失败，请重新');
			}
		}
	}


	//修改优惠券
	public function _coupon_edit(){
		$coupon_id = $_REQUEST['coupon_id'] + 0;

		if (empty($coupon_id)) {
			json_return(1001, '缺少最基本的参数ID');
			exit;
		}

		$coupon_model = M('Coupon');
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $coupon_id;
		$coupon = $coupon_model->getCoupon($where);

		if (empty($coupon)) {
			json_return(1001, '未找到相应的优惠券');
			exit;
		}

		if (IS_POST && isset($_POST['is_submit'])) {
			$name = $_POST['name'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$face_money = $_POST['face_money'];
			$limit_money = $_POST['limit_money'];
			$most_have = $_POST['most_have'];
			$total_amount = $_POST['total_amount'];
			$is_expire_notice = $_POST['is_expire_notice'];
			$is_share = $_POST['is_share'];
			$is_all_product = $_POST['is_all_product'];
			$is_original_price = $_POST['is_original_price'];
			$description = $_POST['description'];
			$product_id = $_POST['product_id'];
			$product_id_str = $_POST['product_id'];
			$type = $_POST['coupon_type'];

			if (!in_array($type,array(1,2))) {
				json_return(1001, '券类型品没有填写，请填写');
			}
			if (empty($name)) {
				json_return(1001, '优惠券名称品名称没有填写，请填写');
			}
			if (empty($face_money)) {
				json_return(1001, '优惠券的面值不能为空！');
			}
			if (empty($start_time)) {
				json_return(1001, '请选择优惠券生效开始时间');
			}

			if (empty($end_time)) {
				json_return(1001, '请选择优惠结束时间');
			}
			if ($is_all_product == 1) {  //部分商品使用优惠券
				if (empty($product_id_str)) {
					json_return(1001, '请至少选择一个产品作为商品作为优惠券使用的对象');
				}
				$product_id_arr = explode("-", $product_id_str);
			}

			if ($is_all_product == 1) { //选择部分商品时查询
				$where = array();
				$where['status'] = 1;
				$where['product_id'] = array('in', $product_id_arr);
				$where['store_id'] = $_SESSION['store']['store_id'];
				$where['quantity'] = array('>', 0);

				$product_list = D('Product')->where($where)->select();

				if (empty($product_list)) {
					json_return(1001, '您选择的产品不能作为优惠券使用的商品范畴');
				}
			} else {
				$product_list = "";
			}

//
			/*
			$where2['uid'] = $_SESSION['store']['uid'];
			$where2['store_id'] = $_SESSION['store']['store_id'];
			if (!empty($coupon_id)) $where2['id'] = array("!=", $coupon_id);
			$where2['is_all_product'] = 0;

			$coupon2 = $coupon_model->getCoupon($where2);
			if (!empty($coupon2)) {
				$product_exist = 'ALL';
			} else {
				$product_exist = M('Coupon_to_product')->getProductIDList($coupon_id);
			}

			if ($product_exist == 'ALL') {
				json_return(1001, '1您有其他正在进行的优惠券活动，无法设置商品参与');
			} else if ($is_all_product == '0' && !empty($product_exist)) {
				json_return(1001, '2您有其他正在进行的优惠券活动，无法设置商品参与');
			} else {
				$product_id_arr = explode('-', $product_id_str);
				if (array_intersect($product_id_arr, $product_exist)) {
					json_return(1001, '3您有其他正在进行的优惠券活动，无法设置商品参与');
				}
			}
			*/
//


			// 有效期修正
			$start_time = strtotime($start_time);
			$end_time = strtotime($end_time);
			if ($start_time > $end_time) {
				$tmp = $end_time;
				$end_time = $start_time;
				$start_time = $tmp;
			}

			// 修改进数据库
			$data = array();
			$data['name'] = $name;
			$data['timestamp'] = time();
			$data['uid'] = $_SESSION['store']['uid'];
			$data['store_id'] = $_SESSION['store']['store_id'];
			$data['face_money'] = $face_money;
			$data['limit_money'] = $limit_money;
			$data['most_have'] = $most_have;
			$data['total_amount'] = $total_amount;
			$data['is_expire_notice'] = $is_expire_notice;
			$data['is_share'] = $is_share;
			$data['is_all_product'] = $is_all_product;
			$data['is_original_price'] = $is_original_price;
			$data['description'] = $description;
			$data['start_time'] = $start_time;
			$data['end_time'] = $end_time;
			$data['type'] = $type;

			D('Coupon')->data($data)->where(array('id' => $coupon_id))->save();

			$coupon_model = M('Coupon_to_product');
			//修改时：如果更改 部分商品=> 全部商品 清除已经存在的数据
			$coupon_model->delete(array('coupon_id' => $coupon_id));
			if($is_all_product == '1') {
				foreach ($product_list as $product) {
					unset($data);
					$data['coupon_id'] = $coupon_id;
					$data['product_id'] = $product['product_id'];

					D('Coupon_to_product')->data($data)->add();
				}
			}
			json_return(0, '修改成功');
		}

		$coupon_product_list = M('Coupon_to_product')->getProductListByPid($coupon_id);

		foreach($coupon_product_list as $k=>$v) {
			$id_arr[] = $v['product_id'];
		}

		if(is_array($id_arr)) {
			$product_id_str = implode("-",$id_arr);
			$this->assign('product_id_str', $product_id_str);
		}
		//dump($coupon_product_list);
		$this->assign('coupon', $coupon);
		$this->assign('coupon_product_list', $coupon_product_list);
	}



	// 使失效
	public function disabled() {
		$id = (int)$_GET['id'];

		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
		$coupon_model = M('Coupon');

		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$coupon = $coupon_model->getCoupon($where);

		if (empty($coupon)) {
			json_return(1001, '未找到相应的优惠券');
		}

		$data = array();
		$data['status'] = 0;
		$coupon_model->save($data, array('id' => $coupon['id']));
		json_return(0, '操作完成');
	}


	// 删除
	public function delete() {
		$id = $_GET['id'] + 0;

		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}

		$coupon_model = M('Coupon');
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$coupon = $coupon_model->getCoupon($where);

		if (empty($coupon)) {
			json_return(1001, '未找到相应的优惠券');
		}

		$coupon_model->delete(array('id' => $coupon['id']));
		M('Coupon_to_product')->delete(array('coupon_id' => $id));
		json_return(0, '操作完成');
	}

	// 搜索产品
	private function _product_list() {
		$group_id = $_REQUEST['group_id'] + 0;
		$type = $_REQUEST['type'];
		$title = $_REQUEST['title'];
		$page = max(1, $_REQUEST['p']);
		$limit = 6;

		$type_arr = array('title', 'no');
		if (!in_array($type, $type_arr)) {
			$type = 'title';
		}

		$product_model = M('Product');

		// 设置搜索条件
		$where = array();
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		$where['quantity'] = array('>', 0);
		if (!empty($group_id)) {
			$where['group_id'] = $group_id;
		}
		if (!empty($title)) {
			if ($type == 'title') {
				$where['name'] = array('like', '%' . $title . '%');
			} else {
				$where['code'] = array('like', '%' . $title . '%');
			}
		}

		$count = $product_model->getSellingTotal($where);

		$pages = '';
		$product_list = array();
		if ($count > 0) {
			$offset = ($page - 1) * $limit;
			$product_list = $product_model->getSelling($where, '', '', $offset, $limit);
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		$this->assign('pages', $pages);
		$this->assign('product_list', $product_list);
	}


} 