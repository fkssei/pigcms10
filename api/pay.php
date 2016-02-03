<?php
/**
 *  订单
 */

define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';
require_once 'functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'get') {
    $now = time();
    $timestamp = trim($_GET['timestamp']);
    $sign_key = trim($_GET['sign_key']);
    unset($_GET['timestamp']);
    unset($_GET['sign_key']);
    $_GET['salt'] = SIGN_SALT;
    if (($now - $timestamp) > 360 || $now < $timestamp){
        $error_code = 1003;
        $error_msg = '请求已过期';
        $return_url = '';
    } else if (!_checkSign($sign_key, $_GET)) {
        $error_code = 1004;
        $error_msg = '签名无效';
        $return_url = '';
    } else {

    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $return_url = '';
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'return_url' => $return_url));
exit;

?>