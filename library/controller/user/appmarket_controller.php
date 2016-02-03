<?php
/**
 * 应用营销
 * User: pigcms_21
 * Date: 2015/6/15
 * Time: 10:42
 */
class appmarket_controller extends base_controller {
	//加载
	public function load() {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');

		switch ($action) {
			case 'dashboard_content': //应用营销概况
				$this->_index_content();
				break;
			case 'present_index':
				$this->_present_index();
				break;
			case 'present_create':
				$this->_present_create();
				break;
			case 'present_edit':
			$this->_present_edit();
			break;
			case 'product_list':
				$this->_product_list();
				breka;
			default:
			//满减/送
			case 'reward_index':
				$this->_reward_index();
			case 'reward_create':
				$this->_reward_create();
			default:

				break;
		}

		$this->display($_POST['page']);
	}

	public function dashboard() {
		$this->display();
	}

	public function present() {
		$this->display();
	}

	public function reward() {
		$this->display();
	}



	public function _index_content(){


	}

	//赠品
	private function _present_index() {
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

		$present_model = M('Present');
		$count = $present_model->getCount($where);

		$present_list = array();
		$pages = '';
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;

			$present_list = $present_model->getList($where);

			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		$this->assign('type', $type);
		$this->assign('pages', $pages);
		$this->assign('present_list', $present_list);
	}


	//添加赠品
	private function _present_create() {
		if (IS_POST && isset($_POST['is_submit'])) {
			$name = $_POST['name'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$expire_date = $_POST['expire_date'] + 0;
			$expire_number = $_POST['expire_number'] + 0;
			$product_id = $_POST['product_id'];

			if (empty($name)) {
				json_return(1001, '赠品名称没有填写，请填写');
			}

			if (empty($start_time)) {
				json_return(1001, '请选择赠品开始时间');
			}

			if (empty($end_time)) {
				json_return(1001, '请选择赠品结束时间');
			}

			if (empty($product_id)) {
				json_return(1001, '请至少选择一个产品作为赠品');
			}

			$product_id_arr = explode(',', $product_id);
			$where = array();
			$where['status'] = 1;
			$where['product_id'] = array('in', $product_id_arr);
			$where['store_id'] = $_SESSION['store']['store_id'];
			$where['quantity'] = array('>', 0);

			$product_list = D('Product')->where($where)->select();
			if (empty($product_list)) {
				json_return(1001, '您选择的产品不能作为赠品');
			}

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
			$data['dateline'] = time();
			$data['uid'] = $_SESSION['store']['uid'];
			$data['store_id'] = $_SESSION['store']['store_id'];
			$data['start_time'] = $start_time;
			$data['end_time'] = $end_time;
			$data['expire_date'] = $expire_date;
			$data['expire_number'] = $expire_number;

			$pid = D('Present')->data($data)->add();
			if ($pid) {
				foreach ($product_list as $product) {
					unset($data);
					$data['pid'] = $pid;
					$data['product_id'] = $product['product_id'];

					D('Present_product')->data($data)->add();
				}
				json_return(0, '添加成功');
			} else {
				json_return(1001, '添加失败，请重新');
			}
		}


		$product_group_list = M('Product_group')->get_all_list($_SESSION['store']['store_id']);
		$this->assign('product_group_list', $product_group_list);
	}

	// 编辑
	private function _present_edit() {
		$id = $_REQUEST['id'] + 0;

		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
			exit;
		}

		$present_model = M('Present');
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$present = $present_model->getPresent($where);

		if (empty($present)) {
			json_return(1001, '未找到相应的赠品');
			exit;
		}

		if (IS_POST && isset($_POST['is_submit'])) {
			$name = $_POST['name'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$expire_date = $_POST['expire_date'] + 0;
			$expire_number = $_POST['expire_number'] + 0;
			$product_id = $_POST['product_id'];

			if (empty($name)) {
				json_return(1001, '赠品名称没有填写，请填写');
			}

			if (empty($start_time)) {
				json_return(1001, '请选择赠品开始时间');
			}

			if (empty($end_time)) {
				json_return(1001, '请选择赠品结束时间');
			}

			if (empty($product_id)) {
				json_return(1001, '请至少选择一个产品作为赠品');
			}

			$product_id_arr = explode(',', $product_id);
			$where = array();
			$where['status'] = 1;
			$where['product_id'] = array('in', $product_id_arr);
			$where['store_id'] = $_SESSION['store']['store_id'];
			$where['quantity'] = array('>', 0);

			$product_list = D('Product')->where($where)->select();
			if (empty($product_list)) {
				json_return(1001, '您选择的产品不能作为赠品');
			}

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
			$data['uid'] = $_SESSION['store']['uid'];
			$data['store_id'] = $_SESSION['store']['store_id'];
			$data['start_time'] = $start_time;
			$data['end_time'] = $end_time;
			$data['expire_date'] = $expire_date;
			$data['expire_number'] = $expire_number;

			D('Present')->data($data)->where(array('id' => $id))->save();

			$present_model = M('Present_product');
			$present_model->delete(array('pid' => $id));

			foreach ($product_list as $product) {
				unset($data);
				$data['pid'] = $id;
				$data['product_id'] = $product['product_id'];

				D('Present_product')->data($data)->add();
			}
			json_return(0, '修改成功');
		}


		$present_product_list = M('Present_product')->getProductListByPid($id);
		$product_group_list = M('Product_group')->get_all_list($_SESSION['store']['store_id']);

		$this->assign('product_group_list', $product_group_list);
		$this->assign('present', $present);
		$this->assign('present_product_list', $present_product_list);
	}


	// 使失效
	public function disabled() {
		$id = $_GET['id'] + 0;

		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}

		$present_model = M('Present');

		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$present = $present_model->getPresent($where);

		if (empty($present)) {
			json_return(1001, '未找到相应的赠品');
		}

		$data = array();
		$data['status'] = 0;
		$present_model->save($data, array('id' => $present['id']));
		json_return(0, '操作完成');
	}

	// 删除
	public function delete() {
		$id = $_GET['id'] + 0;

		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}

		$present_model = M('Present');

		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$present = $present_model->getPresent($where);

		if (empty($present)) {
			json_return(1001, '未找到相应的赠品');
		}

		$present_model->delete(array('id' => $present['id']));
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
		$where['source_product_id'] = 0;
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



	//满减/送
	public function _reward_index(){



	}

	//添加赠品
	public function _reward_create() {

	}









}