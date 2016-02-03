<?php
/**
 *  微店后台登录
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';
require_once 'functions.php';
$session_id = '';
if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $now = time();
    $timestamp = $_POST['request_time'];
    $sign_key = trim($_POST['sign_key']);
    unset($_POST['request_time']);
    unset($_POST['sign_key']);
    $_POST['salt'] = SIGN_SALT;
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1002;
        $error_msg = '签名无效';
        $return_url = '';
    } else if (empty($_POST['username'])) {
        $error_code = 1003;
        $error_msg = '用户名为空';
        $return_url = '';
    } else if (empty($_POST['password'])) {
        $error_code = 1005;
        $error_msg = '密码为空';
        $return_url = '';
    } else {
        $userinfo = D('User')->field('uid,login_count')->where(array('phone' => mysql_real_escape_string(trim($_POST['username'])), 'password' => mysql_real_escape_string(trim($_POST['password']))))->order('uid ASC')->find();
        if (empty($userinfo)) {
            $error_code = 1006;
            $error_msg = '用户名或密码不正确';
            $return_url = '';
        } else {
            $session_id = session_id();
            $login_count = $userinfo['login_count'] + 1;
            D('User')->where(array('uid' => $userinfo['uid']))->data(array('session_id' => $session_id, 'last_time' => time(), 'last_ip' => get_client_ip(1), 'login_count' => $login_count))->save();
            $error_code = 0;
            $error_msg = '登录成功';
            $return_url = $config['site_url'] . '/user.php?c=store&a=select&sessid=' . $session_id;
        }
    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $return_url = '';
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'return_url' => $return_url));
exit;