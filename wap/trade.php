<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$store_id = $_GET['id'];
$page = max(1, $_GET['page']);
$limit = 5;

//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');

$uid = $wap_user['uid'];
$session_id = session_id();
/*if($uid){
	$condition_order = "(`o`.`uid`='$uid' OR `o`.`session_id`='$session_id')";
}else{
	$condition_order = "`o`.`session_id`='$session_id'";
}
$condition_order .= " AND `o`.`store_id`='$store_id' AND `o`.`order_id`=`op`.`order_id` AND `op`.`product_id`=`p`.`product_id` AND `o`.`status`<5 GROUP BY `o`.`order_id`";
$orderList = D('')->field('`o`.`order_id`,`o`.`order_no`,`o`.`total`,`o`.`sub_total`,`o`.`pro_count`,`o`.`status`,`op`.`pro_num`,`op`.`pro_price`,`op`.`sku_data`,`p`.`image`,`p`.`name`')->table(array('Order'=>'o','Order_product'=>'op','Product'=>'p'))->where($condition_order)->order('`o`.`order_id` DESC')->select();
foreach($orderList as &$value){
	if($value['sku_data']){
		$value['sku_data_arr'] = unserialize($value['sku_data']);
	}
	if($value['comment']){
		$value['comment_arr'] = unserialize($value['comment']);
	}
	$value['order_no_txt'] = option('config.orderid_prefix').$value['order_no'];
	$value['image'] = getAttachmentUrl($value['image']);
	if($value['status'] < 2){
		$value['url'] = './pay.php?id='.$value['order_no_txt'];
	}else{
		$value['url'] = './order.php?orderid='.$value['order_id'];
	}
}
*/

$where_sql = '';
if ($uid) {
	$where_sql .= "(`uid` = '$uid' OR `session_id` = '$session_id')";
} else {
	$where_sql .= "`session_id` = '$session_id'";
}
$where_sql .= " AND `store_id` = '" . $store_id . "' AND `status` < 5";

$count = D('Order')->where($where_sql)->count('order_id');

$orderList = array();
$pages = '';
$physical_list = array();
$store_contact_list = array();
if ($count > 0) {
	$page = min($page, ceil($count / $limit));
	$offset = ($page - 1) * $limit;

	$orderList = D('Order')->where($where_sql)->order('order_id desc')->limit($offset . ', ' . $limit)->select();
	$order_id_arr = array();
	$store_id_arr = array();
	$physical_id_arr = array();
	foreach ($orderList as &$value) {
		if($value['sku_data']){
			$value['sku_data_arr'] = unserialize($value['sku_data']);
		}
		
		if ($value['comment']) {
			$value['comment_arr'] = unserialize($value['comment']);
		}
			
		$value['address'] = unserialize($value['address']);
		$value['order_no_txt'] = option('config.orderid_prefix').$value['order_no'];
			
		if ($value['status'] < 2) {
			$value['url'] = './pay.php?id='.$value['order_no_txt'];
		} else {
			$value['url'] = './order.php?orderid='.$value['order_id'];
		}
			
		$order_id_arr[$value['order_id']] = $value['order_id'];
			
		if ($value['shipping_method'] == 'selffetch') {
			if ($value['address']['physical_id']) {
				$physical_id_arr[$value['address']['physical_id']] = $value['address']['physical_id'];
			} else if ($value['address']['store_id']) {
				$store_id_arr[$value['address']['store_id']] = $value['address']['store_id'];
			}
		}
			
		$value['order_product_list'] = M('Order_product')->orderProduct($value['order_id']);
	}
	
	if (!empty($store_id_arr)) {
		$store_contact_list = M('Store_contact')->storeContactList($store_id_arr);
	}

	if (!empty($physical_id_arr)) {
		$physical_list = M('Store_physical')->getListByIDList($physical_id_arr);
	}

	// 分页
	import('source.class.user_page');
	$user_page = new Page($count, $limit, $page);
	$pages = $user_page->show();
}
//print_r($orderList);exit;

//分享配置 start
$share_conf 	= array(
	'title' 	=> option('config.site_name').'-用户中心', // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''),  option('config.seo_description')), // 分享描述
	'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('trade');
echo ob_get_clean();
?>