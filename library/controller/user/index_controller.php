<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class index_controller extends base_controller
{
	public function index()
	{
		if (empty($this->store_session)) {
			$stores = M('Store')->getStoresByUid($this->user_session['uid']);

			if (empty($stores)) {
				redirect(url('team'));
			}
			else {
				redirect(url('store:select'));
			}
		}

		$this->display();
	}

	public function team()
	{
		$this->display();
	}
}

?>
