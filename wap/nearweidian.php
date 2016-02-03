<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__).'/global.php';

//分享配置 start
$share_conf 	= array(
	'title' 	=> option('config.site_name').'-附近店铺', // 分享标题
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



$domain = $_GET['domain'];
$keyword = $_GET['keyword'];
if(empty($keyword)){
	include display('index_near_weidian');
}else{
	include display('index_near_weidian_search');
}

echo ob_get_clean();
?>