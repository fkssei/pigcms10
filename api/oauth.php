<?php
/**
 *  登陆
 */

define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';
require_once 'functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $sync_login_key = $config['sync_login_key'];
    $now = time();
    $timestamp = $_POST['request_time'];
    $sign_key = $_POST['sign_key'];
    unset($_POST['request_time']);
    unset($_POST['sign_key']);
    $_POST['salt'] = SIGN_SALT;
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
        $return_url = '';
    } else {
        $user = M('User');
        $site_url = trim($_POST['site_url']);
        //处理同一域名是否有www
        if (stripos('://wwww.', $site_url) !== false) {
            $site_url2 = str_replace('://wwww.', '', $site_url);
        } else if (stripos('://wwww.', $site_url) === false) {
            $site_url2 = str_replace('://', '://www.', $site_url);
        }
        $where = array();
        $where['_string'] = "token = '" . trim($_POST['token']) . "' AND is_seller = 1 AND status = 1 AND (source_site_url = '" . $site_url . "' OR source_site_url = '" . $site_url2 . "')";
        $userinfo = $user->checkUser($where);
        //$userinfo = $user->checkUser(array('token' => trim($_POST['token']), 'source_site_url' => trim($_POST['site_url']), 'is_seller' => 1, 'status' => 1));
        if (!empty($userinfo)) {
            $session_id = $userinfo['session_id'];
            $token = $userinfo['token'];
        } else {
            $session_id = session_id();
            $token = $_POST['token'];
            $data = $_POST;
            $data['session_id']  = $session_id;
            $data['login_count'] = $userinfo['login_count'] + 1;
            if (!empty($_POST['phone'])) {
                $data['tel']         = trim($_POST['phone']);
            } else {
                $data['tel']         = '';
            }
            if (empty($data['app_id'])) {
                if (stripos($_POST['login_url'], 'Micrstore') > 0) { //pigcms
                    $data['app_id'] = 1;
                } else if (stripos($_POST['login_url'], 'type=weidian') > 0) { //o2o
                    $data['app_id'] = 2;
                } else {
                    $data['app_id'] = 0;
                }
            }
            _register(array('nickname' => trim($data['wxname']), 'phone' => trim($data['tel']), 'token' => trim($data['token']), 'source_site_url' => trim($data['site_url']), 'payment_url' => trim($data['payment_url']), 'notify_url' => trim($data['notify_url']), 'oauth_url' => trim($data['login_url']), 'session_id' => trim($data['session_id']), 'reg_time' => time(), 'last_time' => time(), 'reg_ip' => get_client_ip(1), 'login_count' => $data['login_count'], 'is_seller' => 1, 'app_id' => $data['app_id'])); //注册用户
            unset($_POST);
        }
        $error_code = 0;
        $error_msg = '登录成功';
        //$return_url = $config['site_url'] . '/user.php?c=store&a=select&sessid=' . $session_id . '&timestamp=' . time() . '&scope=login';
        $return_url = $config['site_url'] . '/user.php?c=store&a=select&sessid=' . $session_id;
    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $return_url = '';
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'return_url' => $return_url));
exit;
