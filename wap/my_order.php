<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));


// 获取基本参数
$page = max(1, $_GET['page']);
$limit = 5;

//店铺资料
$action = isset($_GET['action']) ? $_GET['action'] : 'all';
$uid = $wap_user['uid'];
$where_sql = "`uid` = '" . $uid . "'";

$page_url = 'my_order.php?action=' . $action;
switch($action){
	case 'unpay':
		$pageTitle = '待付款的订单';
		$where_sql .= " AND `status` <= '1'";
		break;
	case 'unsend':
		$pageTitle = '待发货的订单';
		$where_sql .= " AND `status` = '2'";
		break;
	case 'send':
		$pageTitle = '已发货的订单';
		$where_sql .= " AND `status` = '3'";
		break;
	case 'complete':
		$pageTitle = '已完成的订单';
		$where_sql .= " AND `status`='4'";
		break;
	default:
		$where_sql .= " AND `status`<5";
		$pageTitle = '全部订单';
}


$order_model = M('Order');
// 查询订单总数
$count = $order_model->getOrderTotal($where_sql);

// 修正页码
$total_pages = ceil($count / $limit);
$page = min($page, $total_pages);
$offset = ($page - 1) * $limit;

// 查找相应的订单
$order_list = array();
$pages = '';
$physical_id_arr = array();
$store_id_arr = array();
$physical_list = array();
$store_contact_list = array();
if ($count > 0) {
	$order_list = $order_model->getOrders($where_sql, 'status asc, order_id desc', $offset, $limit);
	
	$order_product_model = M('Order_product');
	// 将相应的产品放到订单数组里
	foreach ($order_list as &$order_tmp) {
		$order_product_list = $order_product_model->orderProduct($order_tmp['order_id']);
		
		if($order_tmp['total'] == '0.00'){
			$order_tmp['total'] = $order_tmp['sub_total'];
		}
		$order_tmp['address'] = unserialize($order_tmp['address']);
		$order_tmp['order_no_txt'] = option('config.orderid_prefix') . $order_tmp['order_no'];
		if($order_tmp['status'] < 2){
			$order_tmp['url'] = './pay.php?id='.$order_tmp['order_no_txt'];
		}else{
			$order_tmp['url'] = './order.php?orderid=' . $order_tmp['order_id'];
		}

		// 获取图片地址
		foreach ($order_product_list as &$order_product) {
			$order_product['url'] = 'good.php?id=' . $order_product['product_id'];
		}

		$order_tmp['product_list'] = $order_product_list;
		
		if ($order_tmp['shipping_method'] == 'selffetch') {
			if ($order_tmp['address']['physical_id']) {
				$physical_id_arr[$order_tmp['address']['physical_id']] = $order_tmp['address']['physical_id'];
			} else if ($order_tmp['address']['store_id']) {
				$store_id_arr[$order_tmp['address']['store_id']] = $order_tmp['address']['store_id'];
			}
		}
	}
		
	// 分页
	import('source.class.user_page');
	
	$user_page = new Page($count, $limit, $page);
	$pages = $user_page->show();
	
	if (!empty($store_id_arr)) {
		$store_contact_list = M('Store_contact')->storeContactList($store_id_arr);
	}
	
	if (!empty($physical_id_arr)) {
		$physical_list = M('Store_physical')->getListByIDList($physical_id_arr);
	}
}

//分享配置 start  
$share_conf 	= array(
	'title' 	=> option('config.site_name').'-全部订单', // 分享标题
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

include display('my_order');

echo ob_get_clean();
?>