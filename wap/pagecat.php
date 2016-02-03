<?php
/**
 *  微页面分类
 */
require_once dirname(__FILE__).'/global.php';

$cat_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
$nowCategory = D('Wei_page_category')->where(array('cat_id'=>$cat_id))->find();
if(empty($nowCategory)){
	pigcms_tips('您访问的微杂志分类不存在','none');
}

$store_id = $nowCategory['store_id'];
//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
if(empty($now_store)){
	pigcms_tips('您访问的店铺不存在','none');
}

setcookie('wap_store_id',$now_store['store_id'],$_SERVER['REQUEST_TIME']+10000000,'/');

//当前页面的地址
$now_url = $config['wap_site_url'].'/pagecat.php?id='.$nowCategory['cat_id'];

//微杂志分类下的杂志列表
if($nowCategory['page_count'] > 0){
	$pageList = M('Wei_page')->getCategoryPageList($nowCategory['cat_id'],$nowCategory['first_sort'],$nowCategory['second_sort']);
}

//微杂志分类的自定义字段
if($nowCategory['has_custom']){
	$homeCustomField = M('Custom_field')->getParseFields($store_id,'page_cat',$nowCategory['cat_id']);
}

//公共广告判断
$pageHasAd = false;
if($now_store['open_ad'] && !empty($now_store['use_ad_pages'])){
	$useAdPagesArr = explode(',',$now_store['use_ad_pages']);
	if(in_array('1',$useAdPagesArr)){
		$pageAdFieldArr = M('Custom_field')->getParseFields($store_id,'common_ad',$store_id);
		if(!empty($pageAdFieldArr)){
			$pageAdFieldCon = '';
			foreach($pageAdFieldArr as $value){
				$pageAdFieldCon .= $value['html'];
			}
			$pageHasAd = true;
		}
		$pageAdPosition = $now_store['ad_position'];
	}
}

//店铺导航
if($now_store['open_nav'] && !empty($now_store['use_nav_pages'])){
	$useNavPagesArr = explode(',',$now_store['use_nav_pages']);
	if(in_array('2',$useNavPagesArr)){
		$storeNav = M('Store_nav')->getParseNav($now_store['store_id']);
	}
}

//分享配置 start  
$share_conf 	= array(
	'title' 	=> $nowCategory['cat_name'], // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''),  strip_tags($nowCategory['cat_desc'])), // 分享描述
	'link' 		=> $now_url, // 分享链接
	'imgUrl' 	=> $now_store['logo'], // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('pagecat');

echo ob_get_clean();
?>