<?php
/**
 * 店铺分丝
 * User: pigcms_21
 * Date: 2015/4/21
 * Time: 13:18
 */
require_once dirname(__FILE__).'/drp_check.php';

//分享配置 start  
$share_conf     = array(
    'title'     => $_SESSION['wap_drp_store']['name'].'-分销管理', // 分享标题
    'desc'      => str_replace(array("\r","\n"), array('',''), $_SESSION['wap_drp_store']['intro']), // 分享描述
    'link'      => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
    'imgUrl'    => $_SESSION['wap_drp_store']['logo'], // 分享图片链接
    'type'      => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'   => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share      = new WechatShare();
$shareData  = $share->getSgin($share_conf);
//分享配置 end

if (IS_GET && $_GET['a'] == 'index') {
    $user = M('User');

    $store = $_SESSION['wap_drp_store'];
    //粉丝总数
    $where = array();
    $where['u.drp_store_id'] = $store['store_id'];
    $fans = $user->getFansCount($where);
    //今日新增粉丝
    $start_time = strtotime(date('Y-m-d') . ' 00:00:00');
    $end_time = strtotime(date('Y-m-d') . ' 23:59:59');
    $where = array();
    $where['u.drp_store_id'] = $store['store_id'];
    $where['_string'] = "u.reg_time >= '" . $start_time . "' AND u.reg_time <= '" . $end_time . "'";
    $today_fans = $user->getFansCount($where);
    //昨日新增粉丝
    $start_time = strtotime(date("Y-m-d",strtotime("-1 day")) . ' 00:00:00');
    $end_time = strtotime(date("Y-m-d",strtotime("-1 day")) . ' 23:59:59');
    $where = array();
    $where['u.drp_store_id'] = $store['store_id'];
    $where['_string'] = "u.reg_time >= '" . $start_time . "' AND u.reg_time <= '" . $end_time . "'";
    $yesterday_fans = $user->getFansCount($where);

    include display('drp_store_fans_index');
    echo ob_get_clean();
} else if (IS_GET && $_GET['a'] == 'list') {
    $user = M('User');

    $store = $_SESSION['wap_drp_store'];
    $date = isset($_GET['date']) ? strtolower(trim($_GET['date'])) : '';
    $where = array();
    $where['u.drp_store_id'] = $store['store_id'];
    if ($date == 'today') { //今日
        $start_time = strtotime(date('Y-m-d') . ' 00:00:00');
        $end_time = strtotime(date('Y-m-d') . ' 23:59:59');
        $where['_string'] = "u.reg_time >= '" . $start_time . "' AND u.reg_time <= '" . $end_time . "'";
    } else if ($date == 'yesterday') { //昨日
        $start_time = strtotime(date("Y-m-d",strtotime("-1 day")) . ' 00:00:00');
        $end_time = strtotime(date("Y-m-d",strtotime("-1 day")) . ' 23:59:59');
        $where['_string'] = "u.reg_time >= '" . $start_time . "' AND u.reg_time <= '" . $end_time . "'";
    }
    $fans_count = $user->getFansCount($where);
    //import('source.class.user_page');
    //$page = new Page($fans_count, 20);
    //$fans = $user->getFans($where, $page->firstRow, $page->listRows);
    //$page = $page->show();

    include display('drp_store_fans_list');
    echo ob_get_clean();
} else if (IS_POST && $_GET['a'] == 'list') {
    $user = M('User');

    $store = $_SESSION['wap_drp_store'];
    $date = isset($_GET['date']) ? strtolower(trim($_GET['date'])) : '';
    $where = array();
    $where['u.drp_store_id'] = $store['store_id'];
    if ($date == 'today') { //今日
        $start_time = strtotime(date('Y-m-d') . ' 00:00:00');
        $end_time = strtotime(date('Y-m-d') . ' 23:59:59');
        $where['_string'] = "u.reg_time >= '" . $start_time . "' AND u.reg_time <= '" . $end_time . "'";
    } else if ($date == 'yesterday') { //昨日
        $start_time = strtotime(date("Y-m-d",strtotime("-1 day")) . ' 00:00:00');
        $end_time = strtotime(date("Y-m-d",strtotime("-1 day")) . ' 23:59:59');
        $where['_string'] = "u.reg_time >= '" . $start_time . "' AND u.reg_time <= '" . $end_time . "'";
    }
    $sort = !empty($_POST['sort']) ? trim($_POST['sort']) : '';
    switch ($sort) {
        case 'x1':
            $order = "order_count ASC";
            break;
        case 'x2':
            $order = "order_count DESC";
            break;
        case 'y1':
            $order = "order_total ASC";
            break;
        case 'y2':
            $order = "order_total DESC";
        default:
            $order = 'u.uid DESC';
            break;
    }
    $page_size = !empty($_POST['pagesize']) ? intval(trim($_POST['pagesize'])) : 20;
    $fans_count = $user->getFansCount($where);
    import('source.class.user_page');
    $page = new Page($fans_count, $page_size);
    $fans = $user->getFans($where, $page->firstRow, $page->listRows, $order);
    $html = '';

    $html = '';
    foreach ($fans as $fan) {
        $html .= '<tr>';
        $html .= '    <td style="text-align: left">' . (!empty($fan['nickname']) ? $fan['nickname'] : $fan['phone']) . '</td>';
        $html .= '    <td style="text-align: right">' . (!empty($fan['order_count']) ? $fan['order_count'] : 0) . '</td>';
        $html .= '    <td style="text-align: right">' . (!empty($fan['order_total']) ? number_format($fan['order_total'], 2, '.', '') : '0.00') . '</td>';
        $html .= '</tr>';
    }
    echo json_encode(array('count' => count($fans), 'data' => $html));
    exit;
}