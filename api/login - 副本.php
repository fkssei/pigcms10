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
    $store_id = intval(trim($_POST['store_id']));
    unset($_POST['request_time']);
    unset($_POST['sign_key']);
    $_POST['salt'] = SIGN_SALT;
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1002;
        $error_msg = '签名无效';
        $return_url = '';
    } else {
        $users = D('User')->field('uid,password,token,session_id')->where(array('phone' => mysql_real_escape_string(trim($_POST['phone'])), 'app_id' => intval($_POST['app_id']), 'is_seller' => 1))->select();
        if (empty($users)) {
            $error_code = 1003;
            $error_msg = '用户不存在';
            $return_url = '';
        } else {
            $userinfo = array();
            $session_id = session_id();
            foreach ($users as $user) {
                if (trim($_POST['key']) == md5($user['password'] . SIGN_SALT)) {
                    $userinfo = $user;
                    D('User')->where(array('uid' => $userinfo['uid']))->data(array('session_id' => $session_id))->save();
                    break;
                }
            }
            if (empty($userinfo)) {
                $error_code = 1004;
                $error_msg = '密码错误';
                $return_url = '';
            } else {
                $error_code = 0;
                $error_msg = '登录成功';
                $return_url = $config['site_url'] . '/user.php?c=store&a=select&sessid=' . $session_id . '&token=' . $userinfo['token'];
            }
        }
    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $return_url = '';
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'return_url' => $return_url));
exit;