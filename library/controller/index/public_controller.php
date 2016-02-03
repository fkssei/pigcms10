<?php
//dezend by http://www.yunlu99.com/ QQ:270656184
class public_controller extends base_controller
{
	public function __construct()
	{
		parent::__construct();
		$action = ACTION_NAME;
		$require_login = array('dologin');
	}

	public function dologin()
	{
		$return_url = $_GET['return_url'];
		$url = $_SERVER['HTTP_REFERER'];
		$url = ($return_url ? $return_url : $url);
		$this->display();
	}
}

?>
