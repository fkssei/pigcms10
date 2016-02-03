<?php
/**
 * 应用营销-满减/送
 * User: pigcms_21
 * Date: 2015/6/15
 * Time: 10:42
 */
class reward_controller extends base_controller {
	//加载
	public function load() {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		
		switch ($action) {
			case 'reward_list':
				$this->_reward_list();
				break;
			case 'product_list':
				$this->_product_list();
				break;
			case 'reward_create':
				$this->_reward_create();
				break;
			case 'reward_edit':
				$this->_reward_edit();
				break;
			default:
				
				break;
		}
		
		$this->display($_POST['page']);
	}
	
	public function reward_index() {
		$this->display();
	}
	
	
	//满减/送
	public function _reward_list(){
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
		
		$reward_model = M('Reward');
		$count = $reward_model->getCount($where);
		
		$reward_list = array();
		$pages = '';
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			
			$reward_list = $reward_model->getList($where, 'id desc', $limit, $offset);
			
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		$this->assign('keyword', $keyword);
		$this->assign('type', $type);
		$this->assign('pages', $pages);
		$this->assign('reward_list', $reward_list);
	}
	

	// 使失效
	public function disabled() {
		$id = $_GET['id'] + 0;
		
		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
		
		$reward_model = M('Reward');
		
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$reward = $reward_model->getReward($where);
		
		if (empty($reward)) {
			json_return(1001, '未找到相应的活动');
		}
		
		$data = array();
		$data['status'] = 0;
		$reward_model->save($data, array('id' => $reward['id']));
		json_return(0, '操作完成');
	}
	
	// 删除
	public function delete() {
		$id = $_GET['id'] + 0;
		
		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
		
		$reward_model = M('Reward');
	
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$reward = $reward_model->getReward($where);
		
		if (empty($reward)) {
			json_return(1001, '未找到相应的活动');
		}
		
		$reward_model->delete(array('id' => $id));
		M('Reward_condition')->delete(array('rid' => $id));
		M('Reward_product')->delete(array('rid' => $id));
		
		json_return(0, '操作完成');
	}
	
	// 搜索产品
	private function _product_list() {
		$rid = $_REQUEST['rid'];
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
		
		// 查找参与活动的产品列表
		$product_exist = '';
		$product_exist_other = array();
		$product_exist_own = array();
		$time = time();
		$where = array();
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['uid'] = $_SESSION['store']['uid'];
		$where['status'] = 1;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		$where['is_all'] = 1;
		if (!empty($rid)) {
			$where['id'] = array("!=", $rid);
		}
		
		$reward = M('Reward')->getReward($where);
		if (!empty($reward)) {
			$product_exist = 'ALL';
		} else {
			$product_exist = M('Reward_product')->getProductIDList();
			foreach ($product_exist as $key => $tmp) {
				list($tmp_rid, $tmp_product_id) = explode('_', $key);
				
				if ($tmp_rid == $rid) {
					$product_exist_own[] = $tmp;
				} else {
					$product_exist_other[] = $tmp;
				}
			}
		}
		
		$this->assign('rid', $rid);
		$this->assign('product_exist_other', $product_exist_other);
		$this->assign('product_exist_own', $product_exist_own);
		$this->assign('pages', $pages);
		$this->assign('product_list', $product_list);
	}
	
	//添加优惠活动
	private function _reward_create() {
		if (IS_POST && isset($_POST['is_submit'])) {
			$name = $_POST['name'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$is_all = $_POST['is_all'];
			$reward_str = $_POST['reward_str'];
			$product_id = $_POST['product_id'];
			
			if (empty($name)) {
				json_return(1001, '活动名称没有填写，请填写');
			}
			
			if (empty($start_time)) {
				json_return(1001, '请选择活动开始时间');
			}
				
			if (empty($end_time)) {
				json_return(1001, '请选择活动结束时间');
			}
			
			if (empty($reward_str)) {
				json_return(1001, '请至少设置一个优惠门槛');
			}
			
			// 查找参与活动的产品列表
			$product_exist = '';
			$time = time();
			$where = array();
			$where['store_id'] = $_SESSION['store']['store_id'];
			$where['uid'] = $_SESSION['store']['uid'];
			$where['status'] = 1;
			$where['start_time'] = array('<=', $time);
			$where['end_time'] = array('>=', $time);
			$where['is_all'] = 1;
			
			$reward = M('Reward')->getReward($where);
			if (!empty($reward)) {
				$product_exist = 'ALL';
			} else {
				$product_exist = M('Reward_product')->getProductIDList();
			}
			
			if ($product_exist == 'ALL') {
				json_return(1001, '您有其他正在进行的满就减活动，无法设置商品参与');
			} else if ($is_all == 'all' && !empty($product_exist)) {
				json_return(1001, '您有其他正在进行的满就减活动，无法设置商品参与');
			} else {
				$product_id_arr = explode(',', $product_id);
				if (array_intersect($product_id_arr, $product_exist)) {
					json_return(1001, '您有其他正在进行的满就减活动，无法设置商品参与');
				}
			}
			
			// 优惠门槛格式：12,cash:12,postage:1,score:12,coupon:11,present:1
			$reward_arr = explode('|', $reward_str);
			$reward_condition_arr = array();
			foreach ($reward_arr as $tmp) {
				$reward_each_arr = explode(',', $tmp);
				
				if (count($reward_each_arr) == 1 && $reward_each_arr[0] + 0 < 0) {
					json_return(1001, '您设置一个优惠门槛有误，请重新设置');
				}
				
				$data = array();
				foreach ($reward_each_arr as $key => $tmp) {
					if ($key == 0) {
						continue;
					}
					
					list($condition, $value) = explode(':', $tmp);
					$data[$condition] = $value;
					
					if ($condition == 'cash') {
						$value += 0;
						$value = max(0, $value);
						if (empty($value)) {
							json_return(1001, '请正确填写减的金额');
						}
						
						if ($value > $reward_each_arr[0]) {
							json_return(1001, '请正确填写减的金额,减现金必须小于满减金额');
						}
					} else if ($condition == 'score') {
						$value += 0;
						$value = ceil(max(0, $value));
						if (empty($value)) {
							json_return(1001, '请正确填写减的金额');
						}
					} else if ($condition == 'coupon') {
						$value += 0;
						$value = ceil(max(0, $value));
						if (empty($value)) {
							json_return(1001, '请正确选择优惠');
						}
					} else if ($condition == 'present') {
						$value += 0;
						$value = ceil(max(0, $value));
						if (empty($value)) {
							json_return(1001, '请正确选择赠品');
						}
					} 
				}
				
				$reward_condition_arr[] = array('money' => $reward_each_arr[0], 'data' => $data);
			}
			
			
			if ($is_all == 'part' && empty($product_id)) {
				json_return(1001, '请至少选择一个产品参与活动');
			} else if ($is_all == 'part') {
				$product_id_arr = explode(',', $product_id);
				$where = array();
				$where['status'] = 1;
				$where['product_id'] = array('in', $product_id_arr);
				$where['store_id'] = $_SESSION['store']['store_id'];
				$where['quantity'] = array('>', 0);
				
				$product_list = D('Product')->where($where)->select();
				if (empty($product_list)) {
					json_return(1001, '您选择的产品不能参加活动');
				}
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
			$data['type'] = count($reward_condition_arr) == 1 ? 1 : 2;
			$data['is_all'] = $is_all == 'part' ? 2 : 1;
			
			$rid = D('Reward')->data($data)->add();
			
			$key_arr = array('cash', 'postage', 'score', 'coupon', 'present');
			if ($rid) {
				foreach ($reward_condition_arr as $reward_condition) {
					$reward_condition_data = array();
					$reward_condition_data['rid'] = $rid;
					$reward_condition_data['money'] = $reward_condition['money'];
					
					foreach ($reward_condition['data'] as $key => $val) {
						if (!in_array($key, $key_arr)) {
							continue;
						}
						
						$reward_condition_data[$key] = $val;
					}
					
					D('Reward_condition')->data($reward_condition_data)->add();
					
				}
				
				if ($is_all == 'part') {
					foreach ($product_list as $product) {
						unset($data);
						$data['rid'] = $rid;
						$data['product_id'] = $product['product_id'];
						
						D('Reward_product')->data($data)->add();
					}
				}
				json_return(0, '添加成功');
			} else {
				json_return(1001, '添加失败，请重新');
			}
		}
		
		// 店铺产品分组
		$product_group_list = M('Product_group')->get_all_list($_SESSION['store']['store_id']);
		$this->assign('product_group_list', $product_group_list);
		
		$time = time();
		
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		// 优惠券
		$coupon_list = M('Coupon')->getList($where);
		
		// 店铺赠品
		$present_list = M('Present')->getList($where);
		$this->assign('coupon_list', $coupon_list);
		$this->assign('present_list', $present_list);
	}
	
	// 修改优惠活动
	private function _reward_edit() {
		$id = $_REQUEST['id'] + 0;
		
		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
			exit;
		}
		
		$reward_model = M('Reward');
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$reward = $reward_model->getReward($where);
		
		if (empty($reward)) {
			json_return(1001, '未找到相应的优惠活动');
			exit;
		}
		
		if (IS_POST && isset($_POST['is_submit'])) {
			$name = $_POST['name'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$is_all = $_POST['is_all'];
			$reward_str = $_POST['reward_str'];
			$product_id = $_POST['product_id'];
			
			if (empty($name)) {
				json_return(1001, '活动名称没有填写，请填写');
			}
			
			if (empty($start_time)) {
				json_return(1001, '请选择活动开始时间');
			}
			
			if (empty($end_time)) {
				json_return(1001, '请选择活动结束时间');
			}
			
			if (empty($reward_str)) {
				json_return(1001, '请至少设置一个优惠门槛');
			}
			
			// 查找参与活动的产品列表
			$product_exist = '';
			$time = time();
			$where = array();
			$where['store_id'] = $_SESSION['store']['store_id'];
			$where['uid'] = $_SESSION['store']['uid'];
			$where['status'] = 1;
			$where['start_time'] = array('<=', $time);
			$where['end_time'] = array('>=', $time);
			$where['is_all'] = 1;
			if (!empty($id)) {
				$where['id'] = array("!=", $id);
			}
			
			$reward = M('Reward')->getReward($where);
			if (!empty($reward)) {
				$product_exist = 'ALL';
			} else {
				$product_exist = M('Reward_product')->getProductIDList($id);
			}
			
			if ($product_exist == 'ALL') {
				json_return(1001, '您有其他正在进行的满就减活动，无法设置商品参与');
			} else if ($is_all == 'all' && !empty($product_exist)) {
				json_return(1001, '您有其他正在进行的满就减活动，无法设置商品参与');
			} else {
				$product_id_arr = explode(',', $product_id);
				if (array_intersect($product_id_arr, $product_exist)) {
					json_return(1001, '您有其他正在进行的满就减活动，无法设置商品参与');
				}
			}

			// 优惠门槛格式：12,cash:12,postage:1,score:12,coupon:11,present:1
			$reward_arr = explode('|', $reward_str);
			$reward_condition_arr = array();
			foreach ($reward_arr as $tmp) {
				$reward_each_arr = explode(',', $tmp);
				
				if (count($reward_each_arr) == 1 && $reward_each_arr[0] + 0 < 0) {
					json_return(1001, '您设置一个优惠门槛有误，请重新设置');
				}
				
				$data = array();
				foreach ($reward_each_arr as $key => $tmp) {
					if ($key == 0) {
						continue;
					}
					
					list($condition, $value) = explode(':', $tmp);
					$data[$condition] = $value;
					
					if ($condition == 'cash') {
						$value += 0;
						$value = max(0, $value);
						if (empty($value)) {
							json_return(1001, '请正确填写减的金额');
						}
					} else if ($condition == 'score') {
						$value += 0;
						$value = ceil(max(0, $value));
						if (empty($value)) {
							json_return(1001, '请正确填写减的金额');
						}
					} else if ($condition == 'coupon') {
						$value += 0;
						$value = ceil(max(0, $value));
						if (empty($value)) {
							json_return(1001, '请正确选择优惠');
						}
					} else if ($condition == 'present') {
						$value += 0;
						$value = ceil(max(0, $value));
						if (empty($value)) {
							json_return(1001, '请正确选择赠品');
						}
					}
				}
				
				$reward_condition_arr[] = array('money' => $reward_each_arr[0], 'data' => $data);
			}
			
			if ($is_all == 'part' && empty($product_id)) {
				json_return(1001, '请至少选择一个产品参与活动');
			} else if ($is_all == 'part') {
				$product_id_arr = explode(',', $product_id);
				$where = array();
				$where['status'] = 1;
				$where['product_id'] = array('in', $product_id_arr);
				$where['store_id'] = $_SESSION['store']['store_id'];
				$where['quantity'] = array('>', 0);
				
				$product_list = D('Product')->where($where)->select();
				if (empty($product_list)) {
					json_return(1001, '您选择的产品不能参加活动');
				}
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
			$data['type'] = count($reward_condition_arr) == 1 ? 1 : 2;
			$data['is_all'] = $is_all == 'part' ? 2 : 1;
			
			D('Reward')->where(array('id' => $id))->data($data)->save();
			
			$key_arr = array('cash', 'postage', 'score', 'coupon', 'present');
			// 删除之前的优惠条件
			M('Reward_condition')->delete(array('rid' => $id));
			
			foreach ($reward_condition_arr as $reward_condition) {
				$reward_condition_data = array();
				$reward_condition_data['rid'] = $id;
				$reward_condition_data['money'] = $reward_condition['money'];
				
				foreach ($reward_condition['data'] as $key => $val) {
					if (!in_array($key, $key_arr)) {
						continue;
					}
					
					$reward_condition_data[$key] = $val;
				}
				
				D('Reward_condition')->data($reward_condition_data)->add();
			}
			
			// 删除之前的优惠条件
			$reward_product_model = M('Reward_product');
			M('Reward_product')->delete(array('rid' => $id));
			if ($is_all == 'part') {
				foreach ($product_list as $product) {
					unset($data);
					$data['rid'] = $id;
					$data['product_id'] = $product['product_id'];
					
					D('Reward_product')->data($data)->add();
				}
			}
			json_return(0, '修改成功');
		}
		
		// 优惠条件
		$where = array();
		$where['rid'] = $id;
		$reward_condition_list = M('Reward_condition')->getList($where);
		
		// 优惠活动产品
		$product_list = M('Reward_product')->getProductListByRid($id);
		
		// 店铺产品分组
		$product_group_list = M('Product_group')->get_all_list($_SESSION['store']['store_id']);
		
		$time = time();
		
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		// 优惠券
		$coupon_list = M('Coupon')->getList($where);
		// 店铺赠品
		$present_list = M('Present')->getList($where);
		
		// 变量分配
		$this->assign('reward', $reward);
		$this->assign('reward_condition_list', $reward_condition_list);
		$this->assign('product_list', $product_list);
		$this->assign('product_group_list', $product_group_list);
		$this->assign('coupon_list', $coupon_list);
		$this->assign('present_list', $present_list);
	}
	
	// 优惠券select
	public function coupon_option() {
		$time = time();
		// 店铺赠品
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
	
		$coupon_list = M('Coupon')->getList($where);
		$data = array();
		foreach ($coupon_list as $coupon) {
			$tmp = array("id" => $coupon['id'], "name" => $coupon['name']);
			$data[] = $tmp;
		}
	
		if (empty($data)) {
			$tmp = array("id" => 0, "name" => '您还未创建赠品');
			$data[] = $tmp;
		}
	
		echo json_encode($data);
	}
	
	// 赠品select
	public function present_option() {
		$time = time();
		// 店铺赠品
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		
		$present_list = M('Present')->getList($where);
		$data = array();
		foreach ($present_list as $present) {
			$tmp = array("id" => $present['id'], "name" => $present['name']);
			$data[] = $tmp;
		}
		
		if (empty($data)) {
			$tmp = array("id" => 0, "name" => '您还未创建赠品');
			$data[] = $tmp;
		}
		
		echo json_encode($data);
	}
}