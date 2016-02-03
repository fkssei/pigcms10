<?php
/**
 *  返现信息
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) redirect('./login.php');

$store_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
if(empty($now_store)){
	pigcms_tips('您访问的店铺不存在','none');
}

$orderList = array();

//分享配置 start
$share_conf 	= array(
	'title' 	=> option('config.site_name').'-我的返现', // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), option('config.seo_description')), // 分享描述
	'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('back');
echo ob_get_clean();
?>