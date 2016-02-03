<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class systemwidget_controller extends controller
{
	public function page()
	{
		$page_result = M('Wei_page')->getAllList(8);
		$this->assign('wei_pages', $page_result['page_list']);
		$this->assign('page', $page_result['page']);

		if (IS_POST) {
			$this->display('ajax_page');
		}
		else {
			$this->display();
		}
	}
}

?>
