<?php
/**
 * 微信登录
 */
class wxlogin_controller extends base_controller{
	public function ajax_weixin_login(){
		session_write_close();
		for($i=0;$i<8;$i++){
			$database_login_qrcode = D('Login_qrcode');
			$condition_login_qrcode['id'] = $_GET['qrcode_id'];
			$now_qrcode = $database_login_qrcode->field('`uid`')->where($condition_login_qrcode)->find();
			if(!empty($now_qrcode['uid'])){
				if($now_qrcode['uid'] == -1){
					$data_login_qrcode['uid'] = 0;
					$database_login_qrcode->where($condition_login_qrcode)->data($data_login_qrcode)->save();
					exit('reg_user');
				}
				$database_login_qrcode->where($condition_login_qrcode)->delete();
				$result = M('User')->autologin('uid',$now_qrcode['uid']);
				if(empty($result['error_code'])){
					session_start();
					$_SESSION['user'] = $result['user'];
					if($now_qrcode['lng']) {		
						//写入cookie
						$cookie_arr = array(
							'long' => $now_qrcode['lng'],
							'lat' => $now_qrcode['lat'],
							'timestamp' => time()
						);
						setcookie("Web_user", json_encode($cookie_arr), time() + 3600 * 24 * 365);		
					}
					
					
					
					exit('true');
				}else if($result['error_code'] == 1001){
					exit('no_user');
				}else if($result['error_code']){
					exit('false');
				}
			}
			if($i==7){
				exit('false');
			}
			sleep(3);
		}
	}
}