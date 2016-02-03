<?php 
class WechatApi 
{
	public $appid = '';
	public $appsecret = '';
	public $error 	= array();
	//构造函数获取access_token
	function __construct($config){
        import('source.class.checkFunc');
$checkFunc=new checkFunc();
if (!function_exists('fdsrejsie3qklwewerzdagf4ds')){exit('error-4');}
$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$this->appid 		= $config['appid'];
		$this->appsecret 	= $config['appsecret'];
	}

	public function get_access_token($type=0)
	{
	
	   
		$access_obj = D('Access_token_expires')->where('1')->find();
		$now = intval(time());
		//file_put_contents('times.txt',$access_obj['expires_in'].'_'.time());
		if ($access_obj && intval($access_obj['expires_in']) > ($now + 1200)&&!$this->checkTokenExpires($access_obj['access_token'])) {
			return array('errcode' => 0, 'access_token' => $access_obj['access_token']);
		} else {
		   	//file_put_contents('/phpstudy_web/web/v.meihua.com/cache/data/token.txt', $json->access_token.'-admin-' . date('Y-m-d H:i:s', time()) . ":start\n", FILE_APPEND);
			$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.trim($this->appid).'&secret='.trim($this->appsecret);
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
		$header = array("Accept-Charset: utf-8");
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}
	


}

?>