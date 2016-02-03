<?php
class wxapp_controller extends base_controller {
	public $apiUrl;
	public $SALT;
	public $synType 	= 'weidian';
	
	public function __construct() {
		parent::__construct();
		if(empty($_SESSION['user'])){
			exit('非法访问！');
		}
		$this->apiUrl 	= option('config.syn_domain');
		if(empty($this->apiUrl)){
			exit('你还没有配置');
		}
		$this->SALT 	= option('config.encryption') ? option('config.encryption') : 'pigcms';
	}
	
	public function api() {
		$action 	= $_GET['act'];
		$session_id = $this->getUserName($_SESSION['user']['uid']);
		$token  	= $this->getToken($_SESSION['store']['store_id']);

		$this->create_account();
		$synUrl 	= $this->apiUrl.'/index.php?g=Home&m=Auth&a=access&';
		$sign_arr	= array('token'=>$token, 'action'=>$action, 'session_id' => $_SESSION['session_id']);

		$sign_arr['sign'] 	= $this->getSign($sign_arr);

	 	$synUrl 	.= http_build_query($sign_arr);
		$this->assign('synUrl',$synUrl);
		$this->display();
	}
	
	public function create_account() {
		
		$now 		= time();
		
		$weixin 	= D('Weixin_bind')->where(array('store_id'=>$_SESSION['store']['store_id']))->find();

		//公众号类型4认证订阅号 3认证服务号 2服务号 1订阅号 -1未绑定公众号
		if(empty($weixin)){
			$wxtype = -1;
		}else if(($weixin['service_type_info'] == 0 || $weixin['service_type_info'] == 1) && $weixin['verify_type_info'] == 0) {
			$wxtype = 4;
		}else if($weixin['service_type_info'] == 2 && $weixin['verify_type_info'] == 0){
			$wxtype = 3;
		}else if($weixin['service_type_info'] == 2 && $weixin['verify_type_info'] == -1){
			$wxtype = 2;
		}else if(($weixin['service_type_info'] == 0 || $weixin['service_type_info'] == 1) && $verify_type == -1){
			$wxtype = 1;
		}

		$post_data 	= array(
			'userid' 	=> $_SESSION['user']['uid'],
			'username' 	=> $this->getUserName($_SESSION['user']['uid']),
			'type' 		=> $this->synType,
			'time' 		=> $now,
			'randstr' 	=> $this->randString(10,'mixed'),
			'wxuserid' 	=> $_SESSION['store']['store_id'],
			'domain' 	=> option('config.site_url'),
			'wxtype' 	=> $wxtype,
		);

		$post_data['sign'] 	= $this->getSign($post_data);
		$url 				= $this->apiUrl.'/index.php?g=Home&m=Auth&a=signup';
		$return 			=  api_curl_post($url,$post_data);

		if($return['errcode'] > 0){

			exit($return['errmsg']);

		}else{
			if (empty($_SESSION['session_id']) || $_SESSION['session_id_expire'] < $now) {
				$session_data 			= array(
					'username'=>$post_data['username'], 
					'userid'=>$post_data['userid'], 
					'type'=>$this->synType
				);
				$session_data['sign']	= $this->getSign($session_data);
				$session_url 			= $this->apiUrl.'/index.php?g=Home&m=Auth&a=signin';
				$result  				= api_curl_post($session_url,$session_data); 	//创建公众号
				
				if ('0' == $result['status']) {
					if(!isset($_SESSION['store']['pigcmsToken']) || $_SESSION['store']['pigcmsToken'] == ''){
						$_SESSION['store']['pigcmsToken'] = $pigcmsToken = $this->getToken($_SESSION['store']['store_id']);
						D('Store')->where(array('store_id'=>$_SESSION['store']['store_id']))->data(array('pigcmsToken'=>$pigcmsToken))->save();
					}
					$_SESSION['session_id'] = $result['session_id'];
					$_SESSION['session_id_expire'] = $now+1200;
				} else {	
					//var_dump($result);
				}

			}

		}
		
	}
	
	//创建账号名称
	public function getUserName($id){
		return $this->synType.'_'.substr(md5($id),8,10);
	}
	//模拟公众号token
	public function getToken($id){
		return substr(md5(option('config.site_url').$id.$this->synType),8,16);
	}
	
	private function getSign($data) {
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$validate[$key] = $this->getSign($value);
			} else {
				$validate[$key] = $value;
			}
			
		}
		$validate['salt'] = $this->SALT;
		sort($validate, SORT_STRING);
		return sha1(implode($validate));
	}
/*
	public function _getSign($data){

		$temp_data 			= $data;
		$temp_data['salt'] 	= $this->SALT;
		sort( $temp_data, SORT_STRING );
		$data['sign'] 	= sha1( implode( $temp_data ) );

		return $data;
	}*/
	
	function randString($length=4,$type="number"){
		$array = array(
				'number' => '0123456789',
				'string' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
				'mixed'  => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
		);
		$string = $array[$type];
		$count = strlen($string)-1;
		$rand = '';
		for ($i = 0; $i < $length; $i++) {
			$rand .= $string[mt_rand(0, $count)];
		}
		return $rand;
	}
}