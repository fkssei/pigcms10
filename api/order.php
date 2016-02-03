<?php
/**
 * 订单
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';
require_once 'functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $now = time();
    $timestamp = $_POST['request_time'];
    $sign_key = $_POST['sign_key'];
    unset($_POST['request_time']);
    unset($_POST['sign_key']);
    $_POST['salt'] = SIGN_SALT;
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
        $orders = array();
    } else {
        $user = M('User');
        $userinfo = $user->checkUser(array('token' => trim($_POST['token']), 'source_site_url' => trim($_POST['site_url']), 'is_seller' => 1));
        if (!empty($userinfo)) {
            $store = M('Store');
            $order = M('Order');

            $where = array();
            if (!empty($_POST['store_id'])) { //指定店铺订单
                $store_id = intval(trim($_POST['store_id']));
                $where['store_id'] = $store_id;
                $store_info = $store->getStoreById($store_id, $userinfo['uid']);
                $store_name = $store_info['name'];
            } else { //所有店铺订单
                $stores = $store->getAllStoresByUid($userinfo['uid']);
                $stores_id = array();
                foreach ($stores as $store_info) {
                    $stores_id[] = $store_info['store_id'];
                }
                $where['store_id'] = array('in', $stores_id);
                $store_id = 0;
                $store_name = '';
            }
            $where['status'] = array('in', array(2,3,4));
            $order_count = $order->getOrderTotal($where); //订单数量
            $order_amount = $order->getOrderAmount($where); //订单总额
            import('source.class.user_page');
            $page_size = !empty($_POST['page_size']) ? intval(trim($_POST['page_size'])) : 20;
            $page = new Page($order_count, $page_size);
            $tmp_orders = $order->getOrders($where, 'order_id DESC', $page->firstRow, $page->listRows);
            $orders = array(
                'uid'          => $userinfo['uid'],
                'nickname'     => $userinfo['nickname'],
                'store_id'     => $store_id,
                'store'        => $store_name,
                'order_count'  => $order_count,
                'order_amount' => $order_amount,
                'orders'       => $tmp_orders
            );
            $error_code = 0;
            $error_msg = '请求成功';
        } else {
            $error_code = 1004;
            $error_msg = '商家不存在';
            $orders = array();
        }
    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $orders = array();
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'orders' => $orders));
exit;