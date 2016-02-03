<?php
//狗扑源码社区 www.gope.cn
class base_controller extends controller
{
	public $user_session;
	public $store_session;
	public $allow_store_drp;
	public $allow_platform_drp;
	private $enabled_drp;

	public function __construct()
	{
		import('source.class.checkFunc');
		$checkFunc = new checkFunc();

		if (!function_exists('fdsrejsie3qklwewerzdagf4ds')) {
			exit('error-4');
		}

		$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		parent::__construct();
		if (!empty($_GET['sessid']) && !empty($_GET['token'])) {
			$_SESSION['sync_store'] = true;
			$user = M('User');
			$userinfo = $user->checkUser(array('session_id' => trim($_GET['sessid']), 'token' => trim($_GET['token'])));

			if (!empty($userinfo)) {
				$_SESSION['user'] = $userinfo;
			}

			if (!empty($_GET['store_id'])) {
				$tmp_store = M('Store')->getStoreById($_GET['store_id'], $userinfo['uid']);

				if ($tmp_store) {
					if (empty($tmp_store['logo'])) {
						$tmp_store['logo'] = 'default_shop_2.jpg';
					}

					$_SESSION['store'] = $tmp_store;
				}
				else {
					pigcms_tips('该店铺不存在！');
				}
			}

			setcookie('session', serialize($_SESSION), $_SERVER['REQUEST_TIME'] + 10000000, '/');
		}

		if (empty($_SESSION['user'])) {
			if (!empty($_COOKIE['session'])) {
				$_SESSION = unserialize($_COOKIE['session']);
			}
			else {
				redirect('./account.php');
			}
		}

		$this->store_session = $_SESSION['store'];
		$this->assign('store_session', $_SESSION['store']);
		$this->user_session = $_SESSION['user'];
		$this->assign('user_session', $_SESSION['user']);
		$open_store_drp = option('config.open_store_drp');
		if (!$this->checkFx(true) && !$open_store_drp) {
			$this->assign('enabled_drp', false);
			$this->enabled_drp = false;
		}
		else {
			$this->assign('enabled_drp', true);
			$this->enabled_drp = true;
		}
	}

	protected function checkDrp($return = false)
	{
		$open_store_drp = option('config.open_store_drp');
		$max_store_drp_level = option('config.max_store_drp_level');
		$this->allow_store_drp = false;
		if (!empty($open_store_drp) && (empty($this->store_session['drp_level']) || ($this->store_session['drp_level'] < $max_store_drp_level))) {
			$this->allow_store_drp = true;
		}

		if ($return) {
			return $this->allow_store_drp;
		}
		else {
			$this->assign('allow_store_drp', $this->allow_store_drp);
		}
	}

	protected function checkFx($return = false)
	{
		$open_platform_drp = option('config.open_platform_drp');

		if ($return) {
			return $this->open_platform_drp = $open_platform_drp;
		}
		else {
			$this->assign('allow_platform_drp', $open_platform_drp);
		}
	}

	protected function enabled_drp()
	{
		return $this->enabled_drp;
	}
}

?>
