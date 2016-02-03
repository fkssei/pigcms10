<?php
//dezend by http://www.yunlu99.com/ QQ:270656184
class ajax_controller extends base_controller
{
	public function load()
	{
		$action = strtolower(trim($_GET['action']));
		if (in_array($action, array(
	$action,
	array('collect')
	)) || !isset($action)) {
			$uid = $this->user_session['uid'];

			if (!$uid) {
				echo json_return(400, '请登录后操作');
			}
		}

		if (empty($action)) {
			echo json_return(500, '非法操作');
		}

		switch ($action) {
		case 'collect':
			$this->_collect($uid);
			break;
		}
	}

	private function _collect($uid)
	{
		$type = $_GET['type'];
		$dataid = $_GET['dataid'];
		$time = time();
		if (!in_array($type, array(1, 2)) || !isset($dataid)) {
			echo json_return(501, '非法操作');
		}

		$data['user_id'] = $where['user_id'] = $uid;
		$data['type'] = $where['type'] = $type;
		$data['dataid'] = $where['dataid'] = $dataid;
		$data['add_time'] = $time;
		$collect = D('User_collect')->where($where)->find();

		if ($collect) {
			echo json_return(502, '已收藏');
		}

		if (D('User_collect')->data($data)->add()) {
			json_return(0, '保存成功');
		}
		else {
			json_return(503, '保存失败');
		}
	}
}

?>
