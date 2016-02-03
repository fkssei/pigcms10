<?php

/**
 * 账号
 * User: pigcms_21
 * Date: 2015/3/3
 * Time: 14:41
 */
class account_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		$user = M('User')->getUserById($this->user_session['uid']);
		$user['last_ip']=  long2ip($user['last_ip']);
		$this->assign('user', $user);
	}

	/**
	 * 会员帐号首页
	 */
	function index() {
		if (empty($this->user_session)) {
			$referer = url('account:index');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		if (IS_POST) {
			$data = array();
			// 有上传图片时进行图片处理
			if (!empty($_FILES['file']) && $_FILES['file']['error'] != 4) {
				$img_path_str = '';
				
				// 会员店铺侧用的是商铺的id,作为目录，此处如果没有店铺id,则用会员uid
				if (isset($this->store_session['store_id'])) {
					$img_path_str = sprintf("%09d", $this->store_session['store_id']);
				} else {
					$img_path_str = sprintf("%09d", $this->user_session['uid']);
				}
				
				// 产生目录结构
				$rand_num = 'images/' . substr($img_path_str, 0, 3) . '/' . substr($img_path_str, 3, 3) . '/' . substr($img_path_str, 6, 3) . '/' . date('Ym', $_SERVER['REQUEST_TIME']) . '/';

				$upload_dir = './upload/' . $rand_num;
				if (!is_dir($upload_dir)) {
					mkdir($upload_dir, 0777, true);
				}
				
				// 进行上传图片处理
				import('UploadFile');
				$upload = new UploadFile();
				$upload->maxSize = 1 * 1024 * 1024;
				$upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
				$upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
				$upload->savePath = $upload_dir;
				$upload->saveRule = 'uniqid';
				if ($upload->upload()) {
					$uploadList = $upload->getUploadFileInfo();
					$add_result = $this->attachment_add($uploadList[0]['name'], $rand_num . $uploadList[0]['savename'], $uploadList[0]['size']);
					if ($add_result['err_code']) {
						unlink($upload_dir . $uploadList[0]['name']);
					} else {
						$data['avatar'] = $rand_num . $uploadList[0]['savename'];

						$attachment_upload_type = option('config.attachment_upload_type');
						// 上传到又拍云服务器
						if ($attachment_upload_type == '1') {
							import('source.class.upload.upyunUser');
							upyunUser::upload('./upload/' . $data['avatar'], '/' . $rand_num . $uploadList[0]['savename']);
						}
					}
				}
			}

			$nickname = $_POST['nickname'];

			if (empty($nickname)) {
				echo json_encode(array('status' => false, 'msg' => '请填写昵称'));
				exit;
			}

			$data['nickname'] = $nickname;
			$data['intro'] = $_POST['intro'];
			M('User')->save_user(array('uid' => $this->user_session['uid']), $data);
			
			// 更新session数据
			$_SESSION['user']['nickname'] = $nickname;
			$_SESSION['user']['intro'] = $_POST['intro'];
			if (!empty($data['avatar'])) {
				$_SESSION['user']['avatar'] = getAttachmentUrl($data['avatar']);
			}
			

			echo json_encode(array('status' => true, 'msg' => '操作完成', 'data' => array('nexturl' => 'refresh')));
			exit;
		}

		//$user = M('User')->getUserById($this->user_session['uid']);
		//$this->assign('user', $user);
		$this->display();
	}

	/**
	 * 订单管理
	 */
	function order() {
		if (empty($this->user_session)) {
			$referer = url('account:order');
			redirect(url('account:login', array('referer' => $referer)));
			exit;	
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 10;

		// 实例化模型
		$order_model = M('Order');

		// 获取订单总数
		$count = $order_model->getOrderTotal(array('uid' => $this->user_session['uid']));

		// 修正页码
		$total_pages = ceil($count / $limit);
		$page = min($page, $total_pages);
		$offset = ($page - 1) * $limit;

		$order_list = array();
		$pages = '';
		if ($count > 0) {
			$order_list = $order_model->getOrders(array('uid' => $this->user_session['uid']), 'order_id desc, status asc', $offset, $limit);

			// 将相应的产品放到订单数组里
			foreach ($order_list as &$order) {
				$order_product_list = M('Order_product')->orderProduct($order['order_id']);
				$order['product_list'] = $order_product_list;
			}

			import('source.class.user_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		// 分配变量并显示模板
		$this->assign('order_list', $order_list);
		$this->assign('pages', $pages);
		$this->display();
	}

	/**
	 * 取消订单
	 */
	function cancl_order() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => true, 'msg' => '请先登录', 'data' => array('nexturl' => 'refresh')));
			exit;
		}

		$order_id = $_GET['order_id'];

		if (empty($order_id)) {
			echo json_encode(array('status' => false, 'msg' => '参数错误'));
			exit;
		}

		// 实例化order_model
		$order_model = M('Order');
		$order = $order_model->find($order_id);

		// 权限判断是否可以取消订单
		if ($order['uid'] != $this->user_session['uid']) {
			echo json_encode(array('status' => false, 'msg' => '您无权操作'));
			exit;
		}

		if ($order['status'] > 1) {
			echo json_encode(array('status' => false, 'msg' => '此订单不能取消'));
			exit;
		}

		// 更改订单状态
		$order_model->cancelOrder($order);

		echo json_encode(array('status' => true, 'msg' => '订单取消完成', 'data' => array('nexturl' => 'refresh')));
		exit;
	}

	/**
	 * 更改密码
	 */
	function password() {
		if (empty($this->user_session)) {
			$referer = url('account:password');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		// post，进行更改密码
		if (IS_POST) {
			$old_password = $_POST['old_password'];
			$password1 = $_POST['password1'];
			$password2 = $_POST['password2'];

			// 实例化user_model
			$user_model = M('User');

			$user = $user_model->getUserById($_SESSION['user']['uid']);

			// 判断原密码是否正确
			if ($user['password'] != md5($old_password)) {
				echo json_encode(array('status' => false, 'msg' => '原密码不正确'));
				exit;
			}

			if ($password1 != $password2) {
				echo json_encode(array('status' => false, 'msg' => '两次新密码不一样'));
				exit;
			}

			$user_model->save_user(array('uid' => $_SESSION['user']['uid']), array('password' => md5($password1)));


			echo json_encode(array('status' => true, 'msg' => '修改成功', 'data' => array('nexturl' => 'refresh')));
			exit;
		}

		$this->display();
	}

	/**
	 * 收货地址
	 */
	function address() {
		if (empty($this->user_session)) {
			$referer = url('account:address');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		// 实例化user_address_model
		$user_address_model = M('User_address');

		// 添加新收货地址
		if (IS_POST) {
			$name = $_POST['name'];
			$tel = $_POST['tel'];
			$province = $_POST['province'];
			$city = $_POST['city'];
			$area = $_POST['area'];
			$address = $_POST['address'];
			$default = $_POST['default'] + 0;

			if (empty($name)) {
				echo json_encode(array('status' => false, 'msg' => '收货人没有填写'));
				exit;
			}

			if (empty($tel) || !preg_match("/1[3458]{1}\d{9}$/", $tel)) {
				echo json_encode(array('status' => false, 'msg' => '手机号码格式不正确'));
				exit;
			}

			if (empty($province)) {
				echo json_encode(array('status' => false, 'msg' => '省份没有选择'));
				exit;
			}

			if (empty($city)) {
				echo json_encode(array('status' => false, 'msg' => '城市没有选择'));
				exit;
			}

			if (empty($area)) {
				echo json_encode(array('status' => false, 'msg' => '地区没有选择'));
				exit;
			}

			if (empty($address)) {
				echo json_encode(array('status' => false, 'msg' => '街道没有填写'));
				exit;
			}


			// 更新数据库操作，当有address_id时做更新操作，没有时做添加操作
			$data = array();
			$data['uid'] = $this->user_session['uid'];
			$data['name'] = $name;
			$data['tel'] = $tel;
			$data['province'] = $province;
			$data['city'] = $city;
			$data['area'] = $area;
			$data['address'] = $address;
			$data['default'] = $default;

			$address_id = $_POST['address_id'];
			$msg = '添加成功';
			if (!empty($address_id)) {
				$msg = '修改成功';
				// 更改记录条件
				$condition = array();
				$condition['uid'] = $this->user_session['uid'];
				$condition['address_id'] = $address_id;

				$user_address_model->save_address($condition, $data);
			} else {
				$data['add_time'] = time();
				$address_id = $user_address_model->add($data);
			}


			// 设置默认收货地址
			if ($default == 1) {
				$user_address_model->canelDefaultAaddress($this->user_session['uid'], $address_id);
			}


			import('area');
			$areaClass = new area();

			$data['province_txt'] = $areaClass->get_name($data['province']);
			$data['city_txt'] = $areaClass->get_name($data['city']);
			$data['area_txt'] = $areaClass->get_name($data['area']);
			$data['address_id'] = $address_id;

			echo json_encode(array('status' => true, 'msg' => $msg, 'data' => array('nexturl' => 'refresh', 'address' => $data)));
			exit;
		}



		$address_list = $user_address_model->getMyAddress($this->user_session['uid']);
		$this->assign('address_list', $address_list);
		$this->display();
	}

	/**
	 * 设置默认收货地址
	 */
	function default_address() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => true, 'msg' => '请先登录', 'data' => array('nexturl' => 'refresh')));
			exit;
		}

		$id = $_GET['id'];

		M('User_address')->canelDefaultAaddress($this->user_session['uid'], $id);

		echo json_encode(array('status' => true, 'msg' => '设置完成', 'data' => array('nexturl' => 'refresh')));
		exit;
	}

	/**
	 * 删除收货地址
	 */
	function delete_address() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => true, 'msg' => '请先登录', 'data' => array('nexturl' => 'refresh')));
			exit;
		}
		$id = $_GET['id'];

		M('User_address')->deleteAddress(array('address_id' => $id, 'uid' => $this->user_session['uid']));

		echo json_encode(array('status' => true, 'msg' => '删除完成', 'data' => array('nexturl' => 'refresh')));
		exit;
	}

	/**
	 * 登录页面
	 */
	function login() {
		if (!empty($this->user_session)) {
			$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
			redirect($referer);
		}


		// 登录处理
		if (IS_POST) {
			$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
			$password = isset($_POST['password']) ? trim($_POST['password']) : '';
			$referer = isset($_REQUEST['referer']) ? trim($_REQUEST['referer']) : '';

			if (empty($phone) || empty($password)) {
				echo json_encode(array('status' => false, 'msg' => '手机号或密码不能为空'));
				exit;
			}

			$data = array();
			$data['phone'] = $phone;
			$data['password'] = md5($password);

			$user = D('User')->where($data)->find();

			if (empty($user)) {
				echo json_encode(array('status' => false, 'msg' => '手机号或密码错误'));
				exit;
			}

			// 设置登录成功session
			$_SESSION['user'] = $user;


			$database_user = M('User');
			$save_result = $database_user->save_user(array('uid' => $user['uid']), array('login_count' => $user['login_count'] + 1, 'last_time' => $_SERVER['REQUEST_TIME'], 'last_ip' => ip2long(get_client_ip())));
			if ($save_result['err_code'] < 0) {
				json_encode(array('status' => false, 'msg' => '系统内部错误！请重试'));
			}
			if ($save_result['err_code'] > 0) {
				json_encode(array('status' => false, 'msg' => $save_result['err_msg']));
			}

			if (empty($referer)) {
				$referer = option('config.site_url');
			}

			echo json_encode(array('status' => true, 'msg' => '登录成功', 'data' => array('nexturl' => $referer)));
			exit;
		}

		$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
		$this->assign('referer', $referer);

		// 判断是否已经登录，登录就进入主页
		/**/

		
		  // 分配变量
		  $adver = M('adver');
		  $ad = $adver->get_adver_by_key('pc_login_pic', 1);		  
		  $this->assign('ad', $ad['0']);
			

		$this->assign('type', 'login');
		$this->display();
	}

	/**
	 * ajax login
	 */
	function ajax_login() {
		if (IS_POST) {
			$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
			$password = isset($_POST['password']) ? trim($_POST['password']) : '';

			if (empty($phone) || empty($password)) {
				echo json_encode(array('status' => false, 'msg' => '手机号或密码不能为空'));
				exit;
			}

			$data = array();
			$data['phone'] = $phone;
			$data['password'] = md5($password);

			$user = D('User')->where($data)->find();

			if (empty($user)) {
				echo json_encode(array('status' => false, 'msg' => '手机号或密码错误'));
				exit;
			}

			// 设置登录成功session
			$_SESSION['user'] = $user;
			//登录后的地理位置存入cookie
			//$long = "117.22895";
			//$lat = "31.866208";

			//$cookie_arr = array(
			//	'long' => $long,
			//	'lat' => $lat,
			//	'timestamp' => time()
			//);
			//setcookie("Web_user", json_encode($cookie_arr), time() + 3600 * 24 * 365);


			$database_user = M('User');
			$save_result = $database_user->save_user(array('uid' => $user['uid']), array('login_count' => $user['login_count'] + 1, 'last_time' => $_SERVER['REQUEST_TIME'], 'last_ip' => ip2long(get_client_ip())));
			if ($save_result['err_code'] < 0) {
				json_encode(array('status' => false, 'msg' => '系统内部错误！请重试'));
			}
			if ($save_result['err_code'] > 0) {
				json_encode(array('status' => false, 'msg' => $save_result['err_msg']));
			}

			echo json_encode(array('status' => true, 'msg' => '登录成功', 'data' => array('nickname' => $user['nickname'])));
			exit;
		}

		echo json_encode(array('status' => false, 'msg' => ''));
	}

	/**
	 * 注册页面
	 */
	function register() {
		if (!empty($this->user_session)) {
			$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
			redirect($referer);
		}

		// 提交注册
		if (IS_POST) {
			// 实例化user_model
			$user_model = M('User');
			$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
			$nickname = isset($_POST['nickname']) ? trim($_POST['nickname']) : '';
			$password = isset($_POST['password']) ? $_POST['password'] : '';


			if (empty($phone) || empty($nickname) || empty($password)) {
				echo json_encode(array('status' => false, 'msg' => '请完整填写注册信息'));
				exit;
			}

			if ($user_model->checkUser(array('phone' => $phone))) {
				echo json_encode(array('status' => false, 'msg' => '此手机号已经注册了'));
				exit;
			}

			/* if ($user_model->checkUser(array('nickname' => $nickname))) {
			  echo json_encode(array('status' => false, 'msg' => '此昵称已经注册了'));
			  exit;
			  } */

			$data = array();
			$data['nickname'] = $nickname;
			$data['phone'] = $phone;
			$data['password'] = md5($password);

			$user = $user_model->add_user($data);

			if ($user['err_code'] != 0) {
				echo json_encode(array('status' => false, 'msg' => '注册失败'));
				exit;
			}

			$user = $user_model->getUserById($user['err_msg']['uid']);
			$_SESSION['user'] = $user;

			echo json_encode(array('status' => true, 'msg' => '注册成功', 'data' => array('nexturl' => option('config.site_url'))));
			exit;
		}

		$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
		$this->assign('referer', $referer);

		// 判断是否已经登录，登录就进入主页
		/*
		  $adver = M('adver');
		  $ad = $adver->get_adver_by_key('pc_login_pic', 1);
		  // 分配变量
		  $this->assign('ad', $ad['0']);
		 */

		$this->assign('type', 'register');
		$this->display('login');
	}

	/**
	 * 用户退出登录
	 */
	function logout() {
		unset($_SESSION['user']);
		//清除cookie
		setcookie("Web_user","",time()-3600);
		$referer = $_SERVER['HTTP_REFERER'];
		if (empty($referer)) {
			$referer = url('index:index');
		}

		redirect($referer);
	}

	/**
	 * 插入会员素材图片
	 */
	public function attachment_add($name, $file, $size, $from = 0, $type = 0) {
		$data['uid'] = $this->user_session['uid'];
		$data['name'] = $name;
		$data['from'] = $from;
		$data['type'] = $type;
		$data['file'] = $file;
		$data['size'] = $size;
		$data['add_time'] = $_SERVER['REQUEST_TIME'];
		$data['ip'] = get_client_ip(1);
		$data['agent'] = $_SERVER['HTTP_USER_AGENT'];

		if ($type == 0) {
			list($data['width'], $data['height']) = getimagesize('./upload/' . $file);
		}
		if ($pigcms_id = D('Attachment_user')->data($data)->add()) {
			return array('err_code' => 0, 'pigcms_id' => $pigcms_id);
		} else {
			return array('err_code' => 1001, 'err_msg' => '图片添加失败！请重试');
		}
	}

	//收藏店铺
	public function collect_store() {
		if (empty($this->user_session)) {
			$referer = url('account:collect_store');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 20;

		$count = D('')->table(array('User_collect' => 'uc', 'Store' => 's'))->where("`uc`.`type` = '2' AND `uc`.`user_id` = '" . $this->user_session['uid'] . "' AND `uc`.`dataid` = `s`.`store_id`")->count("`uc`.`collect_id`");

		$store_list = array();
		$pages = '';
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;


			$store_list = D('')->table(array('User_collect' => 'uc', 'Store' => 's'))->where("`uc`.`type` = '2' AND `uc`.`user_id` = '" . $this->user_session['uid'] . "' AND `uc`.`dataid` = `s`.`store_id`")->order("`uc`.`collect_id` DESC")->limit($offset . ',' . $limit)->select();
			foreach ($store_list as &$store) {
				if (empty($store['logo'])) {
					$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
				} else {
					$store['logo'] = getAttachmentUrl($store['logo']);
				}
			}

			// 分页
			import('source.class.user_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		$this->assign('store_list', $store_list);
		$this->assign('pages', $pages);
		$this->display();
	}

	//收藏的商品
	public function collect_goods() {
		if (empty($this->user_session)) {
			$referer = url('account:collect_goods');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 20;

		//$count = D('User_collect')->where(array('type' => 1, 'user_id' => $this->user_session['uid']))->count('collect_id');
		$count = D('')->table(array('User_collect' => 'uc', 'Product' => 'p'))->where("`uc`.`type` = '1' AND `uc`.`user_id` = '" . $this->user_session['uid'] . "' AND `uc`.`dataid` = `p`.`product_id`")->count("`uc`.`collect_id`");

		$product_list = array();
		$pages = '';
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;


			$product_list = D('')->table(array('User_collect' => 'uc', 'Product' => 'p'))->where("`uc`.`type` = '1' AND `uc`.`user_id` = '" . $this->user_session['uid'] . "' AND `uc`.`dataid` = `p`.`product_id`")->order("`uc`.`collect_id` DESC")->limit($offset . ',' . $limit)->select();

			foreach ($product_list as &$product) {
				$product['image'] = getAttachmentUrl($product['image']);
			}
			// 分页
			import('source.class.user_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}


		$this->assign('product_list', $product_list);
		$this->assign('pages', $pages);
		$this->display();
	}

	//用户优惠券
	public function coupon() {
		$page = max(1, $_GET['page']);
		$type = $_GET['type'];
		$order = $_GET['order'];
		$sort = $_GET['sort'];
		$coupon_type = $_GET['coupon_type'];
		$limit = 10;
		$time = time();
		$keyword = $_GET['keyword'];
		$param_search = array();
		$param_search['keyword'] = $keyword;

		//券的不同状态  (未使用，已使用，已过期, 全部)
		$type_arr = array('not_used', 'used', 'expired', 'all');
		if (!in_array($type, $type_arr)) {
			$type = 'not_used';
		}
		$coupon_type_arr = array('0', '1', '2');  //0代表全部类型
		if (!in_array($coupon_type, $coupon_type_arr)) {
			$coupon_type = '0';
		}
		// 默认url条件
		$param['type'] = $type;
		$param['order'] = $order;
		$param['sort'] = $sort;
		$param['coupon_type'] = $coupon_type;


		// 修正排序
		$order_arr = array('end_time', 'face_money');
		$sort_arr = array('desc', 'asc');

		if (!in_array($order, $order_arr)) {
			$order = 'end_time';
		}

		if (!in_array($sort, $sort_arr)) {
			$sort = 'asc';
		}
		// 更改下次排序
		$sort = $sort == 'asc' ? 'desc' : 'asc';

		unset($where);

		switch ($type) {
			case 'not_used':
				$where['is_use'] = 0;
				$where['end_time'] = array('>', $time);
				break;

			case 'used':
				$where['is_use'] = 1;
				break;

			case 'expired':
				$where['is_use'] = 0;
				$where['end_time'] = array('<', $time);
				break;

			default:

				break;
		}
		if ($coupon_type == '0') {
			
		} else {

			$where['type'] = $coupon_type;
		}
		$where['delete_flg'] = '0';
		$where['uid'] = $this->user_session['uid'];


		// 过期时间
		$param_expired_time = $param;
		$param_expired_time['order'] = 'end_time';
		$param_expired_time['sort'] = $sort;
		$param_expired_time['type'] = $type;
		//优惠金额
		$param_money = $param;
		$param_money['order'] = 'face_money';
		$param_money['sort'] = $sort;
		$param_money['type'] = $type;

		//当前搜索的
		// 排序
		$search_param = $param;

		$count = D('User_coupon')->where($where)->count('id');

		$order_by = $order . ' ' . $sort;

		$pages = '';
		$total_pages = 0;
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;

			$coupon_list = M('User_coupon')->getList($where, $order_by, $limit, $offset);
			$store_id_list = array();
			foreach ($coupon_list as $coupon) {
				$store_id_list[$coupon['store_id']] = $coupon['store_id'];
			}
			$store_list = M('Store')->getStoreName($store_id_list);
			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		$this->assign('type', $type);
		$this->assign('coupon_list', $coupon_list);
		$this->assign('store_list', $store_list);
		$this->assign('coupon_type', $coupon_type);  //优惠券类型
		$this->assign('order', $order);
		$this->assign('pages', $pages);
		$this->assign('page_arr', array('current_page' => $page, 'total_pages' => $total_pages));
		$this->assign('param_end_time', $param_expired_time);
		$this->assign('param_money', $param_money);
		$this->assign('search_param', $search_param);
		$this->display();
	}

	//用户优惠券对应的产品list
	function productbycoupon() {
		$id = $_GET['id'];
		$page = max(1, $_GET['page']);
		$limit = 15;
		$coupon_to_prodcut = M("Coupon_to_product");
		if (empty($this->user_session)) {
			$referer = url('account:index');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}
		if (empty($id)) {
			echo json_encode(array('status' => false, 'msg' => '参数错误'));
			exit;
		}

		//获取用户领取的优惠券信息
		$where = array('id' => $id, 'delete_flg' => 0);
		$coupon_detail = M('User_coupon')->getOneCouponInfo($where);
		$store_id_list[$coupon_detail['store_id']] = $coupon_detail['store_id'];
		$store_list = M('Store')->getStoreName($store_id_list);
		$store_name = $store_list[$coupon_detail['store_id']];
		if (!$coupon_detail['id']) {
			$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
			redirect($referer);
		}
		$product = M('Product');
		//只显示自己名下 且数量大 的非分销商品
		unset($where);
		//dump($coupon_detail);
		if ($coupon_detail['is_all_product'] == '0') {
			//全店通用（自营商品）

			$where['quantity'] = array('>', 0);
			$where['store_id'] = $coupon_detail['store_id'];
			$where['supplier_id'] = 0;
			//商品数量
			$count = $product->getSellingTotal($where);
			if ($count > 0) {
				$order_by_field = "product_id";
				$order_by_method = "desc";
				$total_pages = ceil($count / $limit);
				$page = min($page, $total_pages);
				$offset = ($page - 1) * $limit;

				$product_list = $product->getSelling($where, $order_by_field, $order_by_method, $offset, $limit);
				import('source.class.user_page');
				$user_page = new Page($count, $limit, $page);
				$pages = $user_page->show();
			}
		} else {

			$where = "p.quantity > 0 and p.store_id = '" . $coupon_detail['store_id'] . "' and p.supplier_id = 0 ";
			//商品数量
			$count = $coupon_to_prodcut->getSellingCouponProductTotal($where);

			if ($count > 0) {
				$order_by_field = "p.product_id";
				$order_by_method = "desc";
				$total_pages = ceil($count / $limit);
				$page = min($page, $total_pages);
				$offset = ($page - 1) * $limit;

				$product_list = $coupon_to_prodcut->getSellingCouponProduct($where, $order_by_field, $order_by_method, $offset, $limit);
				import('source.class.user_page');
				$user_page = new Page($count, $limit, $page);
				$pages = $user_page->show();
			}
		}

		$param_search = array('id' => $id);

		$this->assign('store_name', $store_name);
		$this->assign('coupon', $coupon_detail);
		$this->assign('param_search', $param_search);
		$this->assign('product_list', $product_list);
		$this->assign('pages', $pages);
		$this->display();
	}

	//ajax删除用户的优惠券
	function deluserCoupon() {
		$id = $_GET['id'];
		if (empty($this->user_session)) {
			echo json_encode(array('status' => false, 'msg' => '请先登录', 'data' => array('nexturl' => 'refresh')));
			exit;
		}
		if (empty($id)) {
			echo json_encode(array('status' => false, 'msg' => '参数错误'));
			exit;
		}

		$data = array('delete_flg' => 1);
		$where = array(
			'uid' => $this->user_session['uid'],
			'id' => $id
		);
		if (D('User_coupon')->where($where)->data($data)->save()) {
			echo json_encode(array('status' => true, 'msg' => '操作完成', 'data' => array('nexturl' => url("account:coupon"))));
			exit;
		} else {
			echo json_encode(array('status' => false, 'msg' => '删除失败'));
			exit;
		}
	}

	//验证密码
	public function chk_password() {
		if (!IS_AJAX) {
			return false;
		}
		$old_password = $_POST['password'];
		$password = $_SESSION['user']['password'];

		if (md5($old_password) != $password) {
			echo json_encode(array('status' => false, 'msg' => '密码不一致'));
		} else {
			echo json_encode(array('status' => true, 'msg' => '密码一致'));
		}
	}

	public function chk_newpwd() {
		if (!IS_AJAX) {
			return false;
		}
		$password1 = $_POST['password'];
		if (strlen($password1) < 6 || strlen($password1) > 16) {
			echo json_encode(array('status' => false, 'msg' => '密码不能小于六位或大于十六位'));
		} else {
			echo json_encode(array('status' => true, 'msg' => '密码通过'));
		}
	}
	
	
	//关注的店铺
	public function attention_store() {
		
		if (empty($this->user_session)) {
			$referer = url('account:collect_store');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 10;

		$count = D('')->table(array('User_attention' => 'ua', 'Store' => 's'))->where("`ua`.`data_type` = '2' AND `ua`.`user_id` = '" . $this->user_session['uid'] . "' AND `ua`.`data_id` = `s`.`store_id`")->count("`ua`.`id`");
		
		$store_list = array();
		$pages = '';
		
		
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;

			$product_model = M('Product');
			$store_list = D('')->table(array('User_attention' => 'ua', 'Store' => 's'))->where("`ua`.`data_type` = '2' AND `ua`.`user_id` = '" . $this->user_session['uid'] . "' AND `ua`.`data_id` = `s`.`store_id`")->order("`ua`.`id` DESC")->limit($offset . ',' . $limit)->select();

			
			
			
			
			foreach ($store_list as &$store) {
				if (empty($store['logo'])) {
					$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
				} else {
					$store['logo'] = getAttachmentUrl($store['logo']);
				}
				//每个店铺获取 10个热销商品 10个新品
				// 店铺热销个产品
				$store['hot_list'] = $product_model->getSelling(array('store_id' => $store['store_id'], 'status' => 1), 'sales', 'desc', 0, 9);
				$store['hot_list_count'] = count($store['hot_list']);
				
				/*新品*/
				$store['news_list'] = $product_model->getSelling(array('store_id' => $store['store_id'], 'status' => 1), '', '', 0, 9);
				$store['news_list_count'] = count($store['news_list']);
				
				// 评论满意，一般，不满意数量，以及满意百分比
				$where = array();
				$where['type'] = 'STORE';
				$where['relation_id'] = $store['store_id'];
				$comment_type_count = M('Comment')->getCountList($where);
				$satisfaction_pre = '100%';
				if ($comment_type_count['total'] > 0) {
					$satisfaction_pre = round($comment_type_count['t3'] / $comment_type_count['total'] * 100) . '%';
				}
				$store['satisfaction_pre'] = $satisfaction_pre;				
				
				$store['imUrl'] = getImUrl($_SESSION['user']['uid'],$store['store_id']);
			}
			
			
			// 分页
			import('source.class.user_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		

		
		$this->assign('store_list', $store_list);
		$this->assign('pages', $pages);
		$this->display();
	}

}