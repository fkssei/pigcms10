<?php
//狗扑源码社区 www.gope.cn
class ExpressAction extends BaseAction
{
	public function index()
	{
		$express = M('Express');
		$express_count = $express->count('pigcms_id');
		import('@.ORG.system_page');
		$page = new Page($express_count, 20);
		$expresses = $express->order('`sort` DESC,`pigcms_id` DESC')->limit($page->firstRow, $page->listRows)->select();
		$this->assign('expresses', $expresses);
		$this->assign('page', $page->show());
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
			$_POST['add_time'] = $_SERVER['REQUEST_TIME'];
			$database_express = D('Express');

			if ($database_express->data($_POST)->add()) {
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
		$database_express = D('Express');
		$condition_express['pigcms_id'] = intval($_GET['id']);
		$express = $database_express->field(true)->where($condition_express)->find();
		$this->assign('express', $express);
		$this->display();
	}

	public function amend()
	{
		if (IS_POST) {
			$_POST['add_time'] = $_SERVER['REQUEST_TIME'];
			$database_express = M('Express');

			if ($database_express->data($_POST)->save()) {
				$this->success('修改成功！');
			}
			else {
				$this->error('修改失败！请检查是否有过修改后重试~');
			}
		}
		else {
			$this->error('非法提交,请重新提交~');
		}
	}

	public function del()
	{
		if (IS_POST) {
			$database_express = D('Express');
			$condition_express['pigcms_id'] = intval($_POST['id']);

			if ($database_express->where($condition_express)->delete()) {
				S('express_list', NULL);
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
