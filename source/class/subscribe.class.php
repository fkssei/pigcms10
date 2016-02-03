<?php
class subscribe {
	public function sub($openid){
        import('source.class.checkFunc');
$checkFunc=new checkFunc();
if (!function_exists('fdsrejsie3qklwewerzdagf4ds')){exit('error-4');}
$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$access_token_array = D('Access_token_expires')->get_access_token();
		$access_token = $access_token_array['access_token'];

		$url='https://api.weixin.qq.com/cgi-bin/user/info?openid=' . $openid . '&access_token=' . $access_token;
		$content = $this->curlGet($url);
		$classData = json_decode($content);
		
		if ($classData->subscribe && $classData->subscribe==1){
			$user = M('User')->where(array('openid' => $classData->openid))->find();
			$data = array();
				$data['nickname'] = str_replace(array("'","\\"),array(''),$classData->nickname);
				
				
				
				$data['last_time'] = time();
				$data['last_ip'] = get_client_ip(1);
				$data['avatar'] = $classData->headimgurl;
				$data['is_weixin'] = 1;
			if (empty($user)) {
				$data['reg_time'] = time();
				$data['openid'] = $classData->openid;
				$data['reg_ip'] = get_client_ip(1);
				M('User')->add($data);
				
			}else{
				M('User')->where(array('openid'=>$openid))->data($data)->save();
			}
		}
	}

	public function unsub(){
		M('Userinfo')->where(array('token'=>$this->token,'wecha_id'=>$this->wecha_id))->setField('issub', '-1');
	}

	public function curlGet($url,$method='get',$data=''){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}
}
