<?php
	require_once dirname(__FILE__).'/global.php';
	import('source.class.Http');
	
	$condition = authArray($_GET['source']);
	$store = D('Store')->where($condition)->field('store_id')->find();
	if(!$store){
		pigcms_tips('该店铺没有开启任何活动！','none');
	}
	M('Store')->wap_getStore($store['store_id']);
	switch($_GET['source']){
		case 'pigcms':
			$apiUrl 	= option('config.syn_domain') ? rtrim(option('config.syn_domain'),'/').'/' : 'http://svn.404.cn/';
			$salt 		= option('config.encryption') ? option('config.encryption') : 'pigcms';
		
			$token = htmlspecialchars($_GET['token']);
			$return['wecha_id'] = $_SESSION['openid'];
			$return['token'] = $token;
			$return['sex'] = $_SESSION['wap_user']['sex'];
			$return['issub'] = isSub($_SESSION['openid']);
			$return['portrait'] = $_SESSION['wap_user']['avatar'];
			$return['wechaname'] = $return['truename'] = $_SESSION['wap_user']['nickname'];
			$return['province'] = $_SESSION['wap_user']['province'];
			$return['city'] = $_SESSION['wap_user']['city'];
			$postData = array(
				'option' => array(
					'where' => array(
						'wecha_id' => $return['wecha_id'],
						'token' => $token
					),
					'order' => 'id DESC',
					'limit' => '1',
				),
				'data' => $return,
				'model' => 'Userinfo',
				'token' => $token,
				'debug' => true
			);
			$postData['sign'] = getSign($postData,$salt);
			
			$result = api_curl_post($apiUrl.'index.php?g=Home&m=Auth&a=insert', $postData);
			if($result['status'] == 0){
				header('Location:'.$apiUrl.'index.php?g=Home&m=Auth&a=oauth2&token='.$token.'&wechat_id='.$return['wecha_id']);
			}else{
				pigcms_tips($result['message'],'none');
			}
			break;
	}
	function getSign($data,$salt) {
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$validate[$key] = getSign($value,$salt);
			} else {
				$validate[$key] = $value;
			}			
		}
		$validate['salt'] = $salt;
		sort($validate, SORT_STRING);
		return sha1(implode($validate));
	}
	function isSub($openid){
		import('WechatApi');
		$tokenObj 	= new WechatApi(array('appid'=>option('config.wechat_appid'),'appsecret'=>option('config.wechat_appsecret')));
		$access_token 	= $tokenObj->get_access_token();
		$url='https://api.weixin.qq.com/cgi-bin/user/info?openid='.$openid.'&access_token='.$access_token['access_token'];
		$classData=json_decode(Http::curlGet($url));
		if ($classData->subscribe == 0) {
			//没有关注
			return 0;
		}else{
			return 1;
		}
	}
	function authArray($source){
		$condition = array();
		switch($source){
			case 'pigcms':
				$condition['pigcmsToken'] = htmlspecialchars($_GET['token']);
				break;
		}
		return $condition;
	}
?>