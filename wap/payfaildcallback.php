<?php
/**
 *  支付同步通知
 */
require_once dirname(__FILE__).'/global.php';

$orderno = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('非法访问！','none');
$error_code = !empty($_GET['error_code']) ? $_GET['error_code'] : 1;
$error_msg = !empty($_GET['error_msg']) ? $_GET['error_msg'] : '订单支付失败';

$nowOrder = M('Order')->findSimple($_GET['id']);
if(empty($nowOrder)) pigcms_tips('该订单不存在','none');

//店铺资料
$now_store = M('Store')->getStore($nowOrder['store_id']);
if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');

if((!empty($nowOrder['session_id']) && $nowOrder['session_id']!=session_id()) || (!empty($nowOrder['uid']) && $nowOrder['uid'] != $wap_user['uid'])) redirect($now_store['url']);


include display('payfaildcallback');

echo ob_get_clean();
?>