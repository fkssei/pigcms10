<?php
/**
 * 收入提现
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
    $withdrawals = array();
    $withdrawal_status = array();
    $withdrawal_count = 0;
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
    } else {
        $user = M('User');
        $withdrawal = M('Store_withdrawal');
        //$userinfo = $user->checkUser(array('token' => trim($_POST['token']), 'source_site_url' => trim($_POST['site_url']), 'is_seller' => 1));

        //if (!empty($_POST['id']) && !empty($_POST['status']) && !empty($_POST['store_id'])) { //修改提现状态
        if (!empty($_POST['id']) && !empty($_POST['status'])) { //修改提现状态
            $data = array();
            $data['status'] = intval(trim($_POST['status']));
            if (intval(trim($_POST['status'])) == 3) {
                $data['complate_time'] = time();
            }
            //if (!D('Store_withdrawal')->where(array('pigcms_id' => intval(trim($_POST['id'])), 'store_id' => intval(trim($_POST['store_id']))))->data($data)->save()) {
            if (!D('Store_withdrawal')->where(array('pigcms_id' => intval(trim($_POST['id']))))->data($data)->save()) {
                $error_code = 1004;
                $error_msg = '提现状态修改失败';
            }
        } else { //分销商提现记录
            $tmp_stores = D('Store')->field('store_id')->where(array('token' => trim($_POST['token']), 'source_site_url' => trim($_POST['site_url'])))->select();
            $stores = array();
            foreach ($tmp_stores as $store) {
                $stores[] = $store['store_id'];
            }
            $where = array();
            if (!empty($_POST['store_id'])) { //指定店铺提现记录
                $where['sw.store_id'] = intval(trim($_POST['store_id']));
            } else {
                $where['_string'] = " sw.store_id in (" . implode(',', $stores) . ")";
            }
            $withdrawal_count = $withdrawal->getWithdrawalCount($where);
            import('source.class.user_page');
            $page_size = !empty($_POST['page_size']) ? intval(trim($_POST['page_size'])) : 20;
            $page = new Page($withdrawal_count, $page_size);
            $withdrawals = array();
            $tmp_withdrawals = $withdrawal->getWithdrawals($where, $page->firstRow, $page->listRows);
            foreach ($tmp_withdrawals as $tmp_withdrawal) {
                $tmp_withdrawal['user'] = $tmp_withdrawal['nickname'];
                $tmp_withdrawal['status'] = $withdrawal->getWithdrawalStatus($tmp_withdrawal['status']);
                $withdrawals[] = $tmp_withdrawal;
            }
            $withdrawal_status = $withdrawal->getWithdrawalStatus();
        }
        $error_code = 0;
        $error_msg = '请求成功';

    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'withdrawals' => $withdrawals, 'withdrawal_count' => $withdrawal_count, 'withdrawal_status' => $withdrawal_status));
exit;