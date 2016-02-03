<?php
class access_token_expires_model extends base_model{
	public function get_access_token($is_store=""){
		import('source.class.Http');
		$now = intval(time());

		$access_obj = $this->db->field(true)->find();
		
		if (!$this->checkTokenExpires($access_obj['access_token']) && $access_obj && (intval($access_obj['expires_in']) > $now)) {
			return array('errcode' => 0, 'access_token' => $access_obj['access_token']);
		} else {

			$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.trim(option('config.wechat_appid')).'&secret='.trim(option('config.wechat_appsecret'));
			$json = json_decode($this->curlGet($url));

			if ($json->errmsg) {
				return array('errcode' => $json->errcode, 'errmsg' => $json->errmsg);
			} else {

				if ($access_obj) {
					D('Access_token_expires')->where(array('id' => $access_obj['id']))->data(array('access_token' => $json->access_token, 'expires_in' => intval($json->expires_in + $now)))->save();
				} else {
					D('Access_token_expires')->data(array('access_token' => $json->access_token, 'expires_in' => intval($json->expires_in + $now)))->add();
				}
				return array('errcode' => 0, 'access_token' => $json->access_token);
			}

		}
	}
	
	public function checkTokenExpires($token){

		$url_get 	= 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token='.$token;
		
		$res 		= json_decode($this->curlGet($url_get),true);

		if(!empty($res['errcode']) && $res['errcode'] > 0){
			return true;
		}else{
			return false;
		}
	}



	function curlGet($url){
		$ch = curl_init();
		$header[] = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}
	
}
?>