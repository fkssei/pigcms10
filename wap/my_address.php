<?php
/**
 *  我的地址
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

//分享配置 start
$share_conf 	= array(
	'title' 	=> option('config.site_name').'-收货地址', // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''),  option('config.seo_description')), // 分享描述
	'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

//店铺资料
$action = isset($_GET['action']) ? $_GET['action'] : 'all';
if($action == 'all'){
	$address_list = M('User_address')->getMyAddress($wap_user['uid']);
	include display('my_address');
}else if($action == 'add'){
	include display('my_address_add');
}else if($action == 'edit'){
	$address_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
	$now_address = M('User_address')->getAdressById('',$wap_user['uid'],$address_id);
	if(empty($now_address)){
		pigcms_tips('您编辑的收货地址不存在','none');
	}
	include display('my_address_edit');
}

echo ob_get_clean();
?>