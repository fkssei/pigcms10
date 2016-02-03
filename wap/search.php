<?php
/**
 *  商品搜索
 */
require_once dirname(__FILE__).'/global.php';

$store_id = isset($_GET['store_id']) ? $_GET['store_id'] : pigcms_tips('您输入的网址有误','none');

//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');

//当前搜索词
$key = $_GET['q'];

//当前分页
$page = intval($_GET['page']);
if($page < 1) $page=1;

//商品搜索
$goodList = M('Product')->getSearchGroupGoodList($key,$page,$store_id);

//当前页面的地址
$now_url = $config['wap_site_url'].'/search.php?store_id='.$now_store['store_id'].'&q='.urlencode($key).'&page='.$page;

//店铺导航
if($now_store['open_nav'] && !empty($now_store['use_nav_pages'])){
	$useNavPagesArr = explode(',',$now_store['use_nav_pages']);
	if(in_array('5',$useNavPagesArr)){
		$storeNav = M('Store_nav')->getParseNav($now_store['store_id']);
	}
}

//分享配置 start
$share_conf 	= array(
	'title' 	=> $now_store['name'], // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), $now_store['intro']), // 分享描述
	'link' 		=> option('config.wap_site_url').'/home.php?id=' . $now_store['store_id'], // 分享链接
	'imgUrl' 	=> $now_store['logo'], // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('search');

echo ob_get_clean();
?>