<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__).'/global.php';

$cat_id 	= intval($_GET['cat_id']);

if($cat_id){
	$where 	= array('cat_id'=>$cat_id);
}
$sale_category_list = M('Sale_category')->getAllCategory($where);
$model_store = M('Store');
$son_cat_store_list = array();
foreach($sale_category_list as $key=>$value){
	if(empty($value['stores'])){
		unset($sale_category_list[$key]);
	}else if(empty($value['cat_list'])){
		$tmp_store_list = $model_store->getWeidianStoreListBySaleCategoryId($value['cat_id'],6,true);
		if(empty($tmp_store_list)){
			unset($sale_category_list[$key]);
		}else{
			$sale_category_list[$key]['store_list'] = $tmp_store_list;
		}
	}else{
		foreach($value['cat_list'] as $son_cat_key=>$son_cat_value){
			if(empty($son_cat_value['stores'])){
				unset($sale_category_list[$key]['cat_list'][$son_cat_key]);
			}else{
				$tmp_store_list = $model_store->getWeidianStoreListBySaleCategoryId($son_cat_value['cat_id'],6);
				if(empty($tmp_store_list)){
					unset($sale_category_list[$key]['cat_list'][$son_cat_key]);
				}else{
					$sale_category_list[$key]['cat_list'][$son_cat_key]['store_list'] = $tmp_store_list;
					$son_cat_store_list[$son_cat_value['cat_id']] = $tmp_store_list;
				}
			}
		}
		$sale_category_list[$key]['cat_list'] = array_values($sale_category_list[$key]['cat_list']);
	}
}


//分享配置 start
$share_conf 	= array(
	'title' 	=> option('config.site_name'), // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), option('config.seo_description')), // 分享描述
	'link' 		=> option('config.wap_site_url').'/weidian.php', // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('index_weidian');

echo ob_get_clean();
?>