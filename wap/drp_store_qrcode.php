<?php
/**
 * 店铺二维码
 * User: pigcms_21
 * Date: 2015/4/24
 * Time: 10:57
 */

require_once dirname(__FILE__).'/drp_check.php';

if (empty($_SESSION['wap_drp_store'])) {
    pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

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

$store = $_SESSION['wap_drp_store'];
$store_url = option('config.wap_site_url') . '/home.php?id=' . $store['store_id'];

include display('drp_store_qrcode');
echo ob_get_clean();