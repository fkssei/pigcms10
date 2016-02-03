<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__).'/global.php';
$keyword = $_GET['keyword'];

//分享配置 start
$share_conf 	= array(
	'title' 	=> option('config.site_name'), // 分享标题
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

if(empty($keyword)){
	include display('index_category');
}else{
	$key_id = intval($_GET['id']);

	// 顶级分类和子分类
	$product_category_model = M('Product_category');
	$category_detail = $product_category_model->getCategory($key_id);

	$property_list = array();
	if (!empty($category_detail)) {
		$property_list = M('System_product_property')->getPropertyAndValue($category_detail['filter_attr']);
	}

	include display('index_category_detail');
}
echo ob_get_clean();
?>