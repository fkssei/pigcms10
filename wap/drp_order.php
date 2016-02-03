<?php
/**
 * 分销订单
 * User: pigcms_21
 * Date: 2015/4/22
 * Time: 18:13
 */
require_once dirname(__FILE__).'/drp_check.php';

if (empty($_SESSION['wap_drp_store'])) {
    pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

if (IS_GET && $_GET['a'] == 'index') { //本店订单
    $order = M('Order');
    $fx_order = M('Fx_order');

    $store = $_SESSION['wap_drp_store'];

    //待付款订单数
    //$not_paid_orders = $order->getOrderCountByStatus(array('store_id' => $store['store_id'], 'status' => 1));
    $not_paid_orders = $fx_order->getOrderCount(array('store_id' => $store['store_id'], 'status' => 1));
    //已付款订单数
    //$paid_orders = $order->getOrderCountByStatus(array('store_id' => $store['store_id'], 'status' => array('in', array(2,3,4))));
    $paid_orders = $fx_order->getOrderCount(array('store_id' => $store['store_id'], 'status' => array('in', array(2,3,4))));

    include display('drp_order_index');
    echo ob_get_clean();

} else if (IS_POST && $_POST['type'] == 'get') {
    $order = M('Order');
    $fx_order = M('Fx_order');
    $user = M('User');

    $store = $_SESSION['wap_drp_store'];
    $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : '';
    $page_size = isset($_POST['pagesize']) ? intval(trim($_POST['pagesize'])) : 10;
    if ($status == 2) {
        $status = array('in', array(2,3,4));
    }
    //$order_count = $order->getOrderCountByStatus(array('store_id' => $store['store_id'], 'status' => $status));
    $order_count = $fx_order->getOrderCount(array('store_id' => $store['store_id'], 'status' => $status));
    import('source.class.user_page');
    $page = new Page($order_count, $page_size);
    //$orders = $order->getOrdersByStatus(array('store_id' => $store['store_id'], 'status' => $status), $page->firstRow, $page->listRows);
    $orders = $fx_order->getOrders(array('store_id' => $store['store_id'], 'status' => $status), $page->firstRow, $page->listRows);
    $html = '';
    foreach ($orders as $order) {
        if (!empty($order['delivery_user'])) {
            $fans = $order['delivery_user'];
        } else if (!empty($order['uid'])) {
            $userinfo = $user->getUserById($order['uid']);
            $fans = !empty($userinfo['nickname']) ? $userinfo['nickname'] : $userinfo['phone'];
        } else {
            $fans = '游客';
        }
        $html .= '<tr>';
        $html .= '    <td class="left">' . $order['order_id'] . '</td>';
        $html .= '    <td class="left">' . $fans .'</td>';
        $html .= '    <td class="right">' . number_format($order['total'], 2, '.', '') . '</td>';
        $html .= '    <td align="center">' . date('Y-m-d', $order['add_time']) . '</td>';
        $html .= '</tr>';
    }
    echo json_encode(array('count' => count($orders), 'data' => $html));
}