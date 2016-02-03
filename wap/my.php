<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

$now_hour = date('H',$_SERVER['REQUEST_TIME']);
if($now_hour>22 || $now_hour<4){
	$time_tip = '午夜好';
}else if($now_hour < 9){
	$time_tip = '早上好';
}else if($now_hour < 12){
	$time_tip = '上午好';
}else if($now_hour < 19){
	$time_tip = '下午好';
}else{
	$time_tip = '晚上好';
}

//分享配置 start  
$share_conf 	= array(
	'title' 	=> option('config.site_name').'-用户中心', // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''),   option('config.seo_description')), // 分享描述
	'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('index_my');

echo ob_get_clean();
?>