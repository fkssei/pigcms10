<?php
/**
 *  文章内容详情页
 */
require_once dirname(__FILE__).'/global.php';

$pigcms_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
$nowImage = D('Image_text')->where(array('pigcms_id'=>$pigcms_id))->find();
if(empty($nowImage)){
	pigcms_tips('您访问的微杂志不存在','none');
}
//店铺资料
$now_store = M('Store')->wap_getStore($nowImage['store_id']);
if(empty($now_store)){
	pigcms_tips('您访问的店铺不存在','none');
}

$weixin = D('Weixin_bind')->where(array('store_id' => $nowImage['store_id']))->find();


//分享配置 start
$share_conf 	= array(
	'title' 	=> $now_store['name'].'-图文消息', // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''),  $now_store['intro']), // 分享描述
	'link' 		=> option('config.wap_site_url').'/imagetxt.php?id='.$pigcms_id, // 分享链接
	'imgUrl' 	=> $now_store['logo'], // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('imagetxt');

echo ob_get_clean();
?>