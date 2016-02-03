<?php
/**
 *  用户登录
 */
require_once dirname(__FILE__).'/global.php';

if(IS_POST){
	$action = isset($_GET['action']) ? $_GET['action'] : 'login';
	switch($action){
		case 'login':
			if(empty($_POST['phone'])) json_return(1000,'请填写您的手机号码');
			if(empty($_POST['pwd'])) json_return(1001,'请填写您的密码');
			
			$database_user = M('User');
			$get_result = $database_user->get_user('phone',$_POST['phone']);
			if($get_result['err_code'] != 0) json_return($get_result['err_code'],$get_result['err_msg']);
			if(empty($get_result['user'])) json_return(1022,'用户不存在');
			if($get_result['user']['password'] != md5($_POST['pwd'])) json_return(1023,'密码不正确');
			
			$save_user_data = array('login_count'=>$get_result['user']['login_count']+1,'last_time'=>$_SERVER['REQUEST_TIME'],'last_ip'=>ip2long($_SERVER['REMOTE_ADDR']));
			if(!empty($_SESSION['openid'])){
				array_push($save_user_data,array('openid'=>$_SESSION['openid']));
			}
			$save_result = $database_user->save_user(array('uid'=>$get_result['user']['uid']),$save_user_data);
			if($save_result['err_code'] < 0) json_return(1009,'系统内部错误，请重试');
			if($save_result['err_code'] > 0) json_return($save_result['err_code'],$save_result['err_msg']);
			$_SESSION['wap_user'] = $get_result['user'];		
			mergeSessionUserInfo(session_id(),$get_result['user']['uid']);
			json_return(0,'登录成功');
			break;
		case 'reg':
			if(empty($_POST['phone'])) json_return(1010,'请填写您的手机号码');
			if(empty($_POST['pwd'])) json_return(1011,'请填写您的密码');
			//if(empty($_POST['code'])) json_return(1012,'请填写6位短信验证码');
			//if($_POST['code'] != $_SESSION['wap_reg_code']) json_return(1013,'短信验证码填写错误');
			$database_user = D('User');
			if($database_user->field('`uid`')->where(array('phone'=>$_POST['phone']))->find()) json_return(1014,'手机号码已存在');
            $data = array();
            $data['phone']       = trim($_POST['phone']);
            $data['nickname']    = '';
            $data['password']    = md5(trim($_POST['pwd']));
            $data['check_phone'] = 1;
            $data['login_count'] = 1;
			if(!empty($_SESSION['openid'])){
				$data['openid'] = $_SESSION['openid'];
			}
			$add_result = M('User')->add_user($data);
			if($add_result['err_code'] == 0){
				$_SESSION['wap_user'] = $add_result['err_msg'];
				mergeSessionUserInfo(session_id(),$add_result['err_msg']['uid']);
				json_return(0,'注册成功');
			}else{
				json_return(1,$add_result['err_msg']);
			}
			
	}
}else{
	//回调地址
	$redirect_uri = $_GET['referer'] ? $_GET['referer'] : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : ($_COOKIE['wap_store_id'] ? './home.php?id='.$_COOKIE['wap_store_id'] : $config['site_url']));

    if (!empty($_SESSION['wap_user'])) {
        redirect($redirect_uri);
    }

	include display('login');
	
	echo ob_get_clean();
}
?>