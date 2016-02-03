<?php
/**
 *  粉丝同步
 */

define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';
require_once 'functions.php';
$session_id = '';
if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $now = time();
    $timestamp = $_POST['request_time'];
    $sign_key = trim($_POST['sign_key']);
    $store_id = intval(trim($_POST['store_id']));
    unset($_POST['request_time']);
    unset($_POST['sign_key']);
    $_POST['salt'] = SIGN_SALT;
    $return_url = trim($_POST['return_url']);
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
        $return_url = '';
    } else if (empty($_POST['token']) || empty($_POST['wecha_id'])) {
        $error_code = 1002;
        $error_msg = '未开启授权';
        $return_url = '';
    } else {
        $user = M('User');
        $userinfo = D('User')->where("third_id = '" . trim($_POST['wecha_id']) . "' AND token = '" . trim($_POST['token']) . "'")->find();
        if (!empty($userinfo)) {
            $session_id = $userinfo['session_id'];
            $token = $userinfo['token'];
            $uid = $userinfo['uid'];
            $wecha_id = $userinfo['third_id'];
            $error_code = 0;
            $error_msg = '登录成功';
        } else {
            require_once "../source/class/String.class.php";
            $session_id = String::keyGen();
            $token = $_POST['token'];
            $data = $_POST;
            $data['session_id']  = $session_id;
            $data['login_count'] = $userinfo['login_count'] + 1;
            if (!empty($store_id)) {
                $store = D('Store')->field('uid')->where(array('store_id' => $store_id))->find();
                $tmp_user = D('User')->field('app_id')->where(array('uid' => $store['uid']))->find();
                $data['app_id'] = !empty($tmp_user['app_id']) ? $tmp_user['app_id'] : 1;
            } else {
                $data['app_id'] = !empty($tmp_user['app_id']) ? $tmp_user['app_id'] : 1;
            }
            $uid = _register(array('third_id' => trim($_POST['wecha_id']), 'nickname' => trim($data['wechaname']), 'avatar' => trim($data['portrait']), 'phone' => '', 'token' => trim($data['token']), 'session_id' => $data['session_id'], 'reg_time' => time(), 'last_time' => time(), 'reg_ip' => get_client_ip(1), 'login_count' => $data['login_count'], 'app_id' => $data['app_id'])); //注册用户
            $wecha_id = trim($_POST['wecha_id']);
            unset($_POST);
            $error_code = 0;
            $error_msg = '登录成功';
        }
        if (empty($store_id)) {
            $error_code = 1004;
            $error_msg = '店铺不存在';
            $return_url = '';
        } else {
            if (!empty($return_url)) {
                $return_url = $return_url . '&sessid=' . $session_id . '&token=' . $token . '&wecha_id=' . $wecha_id;
            } else {
                $return_url = $config['site_url'] . '/wap/home.php?id=' . $store_id . '&sessid=' . $session_id . '&token=' . $token . '&wecha_id=' . $wecha_id;
            }
        }
    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $return_url = '';
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'sessid' => $session_id, 'return_url' => $return_url));
exit;

?>