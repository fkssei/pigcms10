<?php
/**
 * 分销商品分享
 * User: pigcms_21
 * Date: 2015/7/9
 * Time: 13:54
 */

require_once dirname(__FILE__).'/global.php';

$product_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');

$product_model = M('Product');
$user = M('User');

$product = $product_model->get(array('product_id' => $product_id, 'uid' => $_SESSION['wap_user']['uid']));

$store = M('Store')->wap_getStore($product['supplier_id']);
if(empty($store)){
    pigcms_tips('您访问的店铺不存在','none');
}
if (empty($product)) {
    pigcms_tips('您访问的商品不存在','none');
}

$source_product = $product_model->get(array('product_id' => $product['source_product_id']), 'cost_price');
$original_product = $product_model->get(array('product_id' => $product['original_product_id']), 'sales,drp_seller_qty,drp_profit');

$profit = $product['price'] - $source_product['cost_price'];
if ($profit < 0) {
    $profit = 0;
}
$profit = !empty($profit) ? number_format($profit, 2, '.', '') : '0.00';
$sales = !empty($original_product['sales']) ? $original_product['sales'] : 0;
$drp_seller_qty = !empty($original_product['drp_seller_qty']) ? $original_product['drp_seller_qty'] : 0;
$drp_profit = !empty($original_product['drp_profit']) ? number_format($original_product['drp_profit'], 2, '.', '') : '0.00';

$avater = $user->getAvatarById($_SESSION['wap_user']['uid']);
$username = !empty($_SESSION['wap_user']['nickname']) ? $_SESSION['wap_user']['nickname'] : '游客';

//分享配置 start
/*$share_conf 	= array(
	'title' 	=> $product['name'], // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), !empty($product['intro']) ? $product['intro'] : $product['name']), // 分享描述
	'link' 		=> option('config.wap_site_url') . 'good.php?id=' . $product_id, // 分享链接
	'imgUrl' 	=> getAttachmentUrl($product['image']), // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);*/
//分享配置 end

include display('drp_product_share');

echo ob_get_clean();