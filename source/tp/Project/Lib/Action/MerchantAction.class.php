<?php
//狗扑源码社区 www.gope.cn
class MerchantAction extends BaseAction
{
	public function index()
	{
		if (!empty($_GET['keyword'])) {
			if ($_GET['searchtype'] == 'mer_id') {
				$condition_merchant['mer_id'] = $_GET['keyword'];
			}
			else if ($_GET['searchtype'] == 'account') {
				$condition_merchant['account'] = array('like', '%' . $_GET['keyword'] . '%');
			}
			else if ($_GET['searchtype'] == 'name') {
				$condition_merchant['name'] = array('like', '%' . $_GET['keyword'] . '%');
			}
			else if ($_GET['searchtype'] == 'phone') {
				$condition_merchant['phone'] = array('like', '%' . $_GET['keyword'] . '%');
			}
		}

		$database_merchant = D('Merchant');
		$count_merchant = $database_merchant->where($condition_merchant)->count();
		import('@.ORG.system_page');
		$p = new Page($count_merchant, 15);
		$merchant_list = $database_merchant->field(true)->where($condition_merchant)->order('`mer_id` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
		$this->assign('merchant_list', $merchant_list);
		$pagebar = $p->show();
		$this->assign('pagebar', $pagebar);
		$this->display();
	}

	public function add()
	{
		$this->assign('bg_color', '#F3F3F3');
		$this->display();
	}

	public function modify()
	{
		if (IS_POST) {
			$_POST['pwd'] = md5($_POST['pwd']);
			$_POST['reg_time'] = $_SERVER['REQUEST_TIME'];
			$_POST['reg_ip'] = ip2long($_SERVER['REMOTE_ADDR']);
			$_POST['from'] = '1';
			$database_merchant = D('Merchant');

			if ($database_merchant->data($_POST)->add()) {
				$this->success('添加成功！');
			}
			else {
				$this->error('添加失败！请重试~');
			}
		}
		else {
			$this->error('非法提交,请重新提交~');
		}
	}

	public function edit()
	{
		$this->assign('bg_color', '#F3F3F3');
		$database_merchant = D('Merchant');
		$condition_merchant['mer_id'] = intval($_GET['mer_id']);
		$merchant = $database_merchant->field(true)->where($condition_merchant)->find();

		if (empty($merchant)) {
			$this->frame_error_tips('数据库中没有查询到该商户的信息！');
		}

		$this->assign('merchant', $merchant);
		$this->display();
	}

	public function amend()
	{
		if (IS_POST) {
			if ($_POST['pwd']) {
				$_POST['pwd'] = md5($_POST['pwd']);
			}
			else {
				unset($_POST['pwd']);
			}

			$database_merchant = D('Merchant');

			if ($database_merchant->data($_POST)->save()) {
				$this->success('修改成功！');
			}
			else {
				$this->error('修改失败！请检查内容是否有过修改（必须修改）后重试~');
			}
		}
		else {
			$this->error('非法提交,请重新提交~');
		}
	}

	public function del()
	{
		if (IS_POST) {
			$database_merchant = D('Merchant');
			$condition_merchant['mer_id'] = intval($_POST['mer_id']);

			if ($database_merchant->where($condition_merchant)->delete()) {
				$this->success('删除成功！');
			}
			else {
				$this->error('删除失败！请重试~');
			}
		}
		else {
			$this->error('非法提交,请重新提交~');
		}
	}

	public function merchant_login()
	{
		$database_merchant = D('Merchant');
		$condition_merchant['mer_id'] = $_GET['mer_id'];
		$now_merchant = $database_merchant->field(true)->where($condition_merchant)->find();
		if (empty($now_merchant) || ($now_merchant['status'] != 1)) {
			exit('<html><head><script>window.top.toggleMenu(0);window.top.msg(0,"该商户的状态不存在！请查阅。",true,5);window.history.back();</script></head></html>');
		}

		if (!empty($now_merchant['last_ip'])) {
			import('ORG.Net.IpLocation');
			$IpLocation = new IpLocation();
			$last_location = $IpLocation->getlocation(long2ip($now_merchant['last_ip']));
			$now_merchant['last']['country'] = iconv('GBK', 'UTF-8', $last_location['country']);
			$now_merchant['last']['area'] = iconv('GBK', 'UTF-8', $last_location['area']);
		}

		session('merchant', $now_merchant);

		if ($_GET['group_id']) {
			redirect($this->config['site_url'] . '/merchant.php?c=Group&a=frame_edit&group_id=' . $_GET['group_id']);
		}
		else {
			redirect($this->config['site_url'] . '/merchant.php');
		}
	}

	public function store()
	{
		$database_merchant = D('Merchant');
		$condition_merchant['mer_id'] = intval($_GET['mer_id']);
		$merchant = $database_merchant->field(true)->where($condition_merchant)->find();

		if (empty($merchant)) {
			$this->error_tips('数据库中没有查询到该商户的信息！', 5, U('Merchant/index'));
		}

		$this->assign('merchant', $merchant);
		$database_merchant_store = D('Merchant_store');
		$condition_merchant_store['mer_id'] = $merchant['mer_id'];
		$count_store = $database_merchant_store->where($condition_merchant_store)->count();
		import('@.ORG.system_page');
		$p = new Page($count_store, 15);
		$store_list = $database_merchant_store->field(true)->where($condition_merchant_store)->order('`sort` DESC,`store_id` ASC')->limit($p->firstRow . ',' . $p->listRows)->select();
		$this->assign('store_list', $store_list);
		$pagebar = $p->show();
		$this->assign('pagebar', $pagebar);
		$this->display();
	}

	public function store_add()
	{
		$database_merchant = D('Merchant');
		$condition_merchant['mer_id'] = intval($_GET['mer_id']);
		$merchant = $database_merchant->field(true)->where($condition_merchant)->find();

		if (empty($merchant)) {
			$this->frame_error_tips('数据库中没有查询到该商户的信息！无法添加店铺。', 5);
		}

		$this->assign('merchant', $merchant);
		$this->assign('bg_color', '#F3F3F3');
		$this->display();
	}

	public function store_modify()
	{
		if (IS_POST) {
			$long_lat = explode(',', $_POST['long_lat']);
			$_POST['long'] = $long_lat[0];
			$_POST['lat'] = $long_lat[1];
			$_POST['last_time'] = $_SERVER['REQUEST_TIME'];
			$_POST['add_from'] = '1';
			$database_merchant_store = D('Merchant_store');

			if ($database_merchant_store->data($_POST)->add()) {
				$this->success('添加成功！');
			}
			else {
				$this->error('添加失败！请重试~');
			}
		}
		else {
			$this->error('非法提交,请重新提交~');
		}
	}

	public function store_edit()
	{
		$database_merchant_store = D('Merchant_store');
		$condition_merchant_store['store_id'] = intval($_GET['store_id']);
		$store = $database_merchant_store->field(true)->where($condition_merchant_store)->find();

		if (empty($store)) {
			$this->frame_error_tips('数据库中没有查询到该店铺的信息！', 5);
		}

		$this->assign('store', $store);
		$this->assign('bg_color', '#F3F3F3');
		$this->display();
	}

	public function store_amend()
	{
		if (IS_POST) {
			$long_lat = explode(',', $_POST['long_lat']);
			$_POST['long'] = $long_lat[0];
			$_POST['lat'] = $long_lat[1];
			$_POST['last_time'] = $_SERVER['REQUEST_TIME'];
			$database_merchant_store = D('Merchant_store');

			if ($database_merchant_store->data($_POST)->save()) {
				$this->success('修改成功！');
			}
			else {
				$this->error('修改失败！请检查内容是否有过修改（必须修改）后重试~');
			}
		}
		else {
			$this->error('非法提交,请重新提交~');
		}
	}

	public function store_del()
	{
		if (IS_POST) {
			$database_merchant_store = D('Merchant_store');
			$condition_merchant_store['store_id'] = intval($_POST['store_id']);

			if ($database_merchant_store->where($condition_merchant_store)->delete()) {
				$this->success('删除成功！');
			}
			else {
				$this->error('删除失败！请重试~');
			}
		}
		else {
			$this->error('非法提交,请重新提交~');
		}
	}

	public function news()
	{
		$database_merchant_news = D('Merchant_news');
		$news_list = $database_merchant_news->order('`is_top` DESC,`add_time` DESC')->select();
		$this->assign('news_list', $news_list);
		$this->display();
	}

	public function news_add()
	{
		$this->assign('bg_color', '#F3F3F3');
		$this->display();
	}

	public function news_modify()
	{
		$database_merchant_news = D('Merchant_news');
		$_POST['add_time'] = $_SERVER['REQUEST_TIME'];

		if ($database_merchant_news->data($_POST)->add()) {
			$this->success('添加成功！');
		}
		else {
			$this->error('添加失败！');
		}
	}

	public function news_edit()
	{
		$database_merchant_news = D('Merchant_news');
		$condition_merchant_news['id'] = $_GET['id'];
		$now_news = $database_merchant_news->field(true)->where($condition_merchant_news)->find();

		if (empty($now_news)) {
			$this->frame_error_tips('数据库中没有查询到该条公告！', 5);
		}

		$this->assign('now_news', $now_news);
		$this->assign('bg_color', '#F3F3F3');
		$this->display();
	}

	public function news_amend()
	{
		$database_merchant_news = D('Merchant_news');
		$_POST['add_time'] = $_SERVER['REQUEST_TIME'];

		if ($database_merchant_news->data($_POST)->save()) {
			$this->success('编辑成功！');
		}
		else {
			$this->error('编辑失败！');
		}
	}

	public function news_del()
	{
		if (IS_POST) {
			$database_merchant_news = D('Merchant_news');
			$condition_merchant_news['id'] = $_POST['id'];

			if ($database_merchant_news->where($condition_merchant_news)->delete()) {
				$this->success('删除成功！');
			}
			else {
				$this->error('删除失败！请重试~');
			}
		}
		else {
			$this->error('非法提交,请重新提交~');
		}
	}
}

?>
