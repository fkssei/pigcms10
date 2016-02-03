<?php
class weixin_bind_model extends base_model
{
	public function get_access_token($store_id,$get_component_access_token = false)
	{
		$weixin_bind = D('Weixin_bind')->where(array('store_id' => $store_id))->find();
		if (empty($weixin_bind)) return array('errcode' => 1, 'errmsg' => '公众授权异常，请重新授权');

		if($get_component_access_token){
			$component_access_token = $this->get_component_access_token($store_id);
			return $component_access_token;
			exit();
		}
		
		$authorizer_access_tokenName = $store_id.'_authorizer_access_token';
		$access_token = S($authorizer_access_tokenName);

		if ($access_token && $access_token[0] > time()) {
			$authorizer_access_token = $access_token[1];
		} else {
			import('source.class.Http');
			$component_access_token = $this->get_component_access_token($store_id);

			//利用刷新token 获取 authorizer_access_token
			$url = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=' . $component_access_token;

			$data = array();
			$data['component_appid'] = option('config.wx_appid');
			$data['authorizer_appid'] = $weixin_bind['authorizer_appid'];
			$data['authorizer_refresh_token'] = $weixin_bind['authorizer_refresh_token'];
			$access_data = Http::curlPost($url, json_encode($data));

			if ($access_data['errcode']) {
				return $access_data;
			} else {
				$authorizer_access_token = $access_data['authorizer_access_token'];
				S($authorizer_access_tokenName,array($access_data['expires_in'] + time(), $access_data['authorizer_access_token']),$access_data['expires_in'] + time());
			}
		}
		return array('errcode' => 0, 'access_token' => $authorizer_access_token);
	}
	
	public function get_component_access_token($store_id){
		import('source.class.Http');
		$component_access_tokenName = $store_id.'_component_access_token';
		$result = S($component_access_tokenName);

		if ($result && $result[0] > time()) {
			return $result[1];
		} else {
			//获取component_access_token
			$url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
			$data = array('component_appid' => option('config.wx_appid'), 'component_appsecret' => option('config.wx_appsecret'), 'component_verify_ticket' => option('config.wx_componentverifyticket'));
			$result = Http::curlPost($url, json_encode($data));
			if ($result['errcode']) {
				return $result;
			}else{
				S($component_access_tokenName,array($result['expires_in'] + time(), $result['component_access_token']),$result['expires_in'] + time());
				return $result['component_access_token'];
			}
		}
	}

	public function get_account_type($store_id){
		if ($weixin_bind = D('Weixin_bind')->where(array('store_id' => $store_id))->find()) {
			return $this->get_account_type_Bydata($weixin_bind);
		} else {
			return array('errcode' => 1, 'errmsg' => '公众授权异常，请重新授权');
		}
	}
	
	public function get_account_type_Bydata($weixin_bind){
		if ($weixin_bind['service_type_info'] != 2){
			if($weixin_bind['verify_type_info'] != -1){
				return array('errcode' => 0, 'errmsg' => '认证的订阅号', 'code' => 1);
			}else{
				return array('errcode' => 0, 'errmsg' => '未认证的订阅号', 'code' => 0);
			}
		} else {
			if ($weixin_bind['verify_type_info'] != -1) {
				return array('errcode' => 0, 'errmsg' => '认证服务号', 'code' => 2);
			}else{
				return array('errcode' => 0, 'errmsg' => '未认证服务号', 'code' => 3);
			}
		}
	}
}
?>