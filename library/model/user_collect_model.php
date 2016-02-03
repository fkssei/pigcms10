<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class user_collect_model extends base_model
{
	public function add($uid, $id, $type)
	{
		if (!in_array($type, array(1, 2))) {
			return false;
		}

		$param = array();
		$param['user_id'] = $uid;
		$param['dataid'] = $id;
		$param['add_time'] = time();
		$param['type'] = $type;
		$result = D('User_collect')->data($param)->add();

		if ($result) {
			if ($type == 1) {
				$result = D('Product')->where(array('product_id' => $id))->setInc('collect');
			}
			else {
				$result = D('Store')->where(array('store_id' => $id))->setInc('collect');
			}

			if ($result) {
				return true;
			}
			else {
				return false;
			}
		}

		return false;
	}

	public function cancel($uid, $id, $type)
	{
		if (!in_array($type, array(1, 2))) {
			return false;
		}

		$result = D('User_collect')->where(array('user_id' => $uid, 'dataid' => $id, 'type' => $type))->delete();

		if ($result) {
			if ($type == 1) {
				$result = D('Product')->where(array('product_id' => $id))->setInc('collect', -1);
			}
			else {
				$result = D('Store')->where(array('store_id' => $id))->setInc('collect', -1);
			}

			if ($result) {
				return true;
			}
			else {
				return false;
			}
		}

		return false;
	}
}

?>
