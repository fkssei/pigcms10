<?php
/**
 *  评论
 */
require_once dirname(__FILE__).'/global.php';
$product_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : pigcms_tips('您输入的网址有误','none');




//获取评论并分页 ajax
function get_pinlun_list($product_id) {
	require_once dirname(__FILE__).'/global.php';
	$page = $_GET['page'] + 0;
	$id = $_GET['id'];
	$type = $_GET['type'];
	$tab = $_GET['tab'];
	$has_image = $_GET['has_image'];
	
	if (empty($id)) {
		echo json_encode(array('status' => false, 'msg' => '参数错误'));
		exit;
	}
	
	$type_arr = array('PRODUCT', 'STORE');
	if (!in_array($type, $type_arr)) {
		echo json_encode(array('status' => false, 'msg' => '参数错误'));
		exit;
	}
	
	$where = array();
	$where['type'] = $type;
	if (!empty($has_image)) {
		$where['has_image'] = 1;
	}
	$where['relation_id'] = $id;
	$where['status'] = 1;
	$where['delete_flg'] = 0;
	switch($tab) {
		case 'HAO' :
			$where['score'] = array('>=', 4);
			break;
		case 'ZHONG' :
			$where['score'] = 3;
			break;
		case 'CHA' :
			$where['score'] = array('<=', 2);
			break;
		default :
			break;
	}
	
	$comment_model = M('Comment');
	$count = $comment_model->getCount($where);
	
	$comment_list = array();
	$pages = '';
	$limit = 10;
	$total_page = ceil($count / $limit);
	if ($count > 0) {
		$page = min($page, ceil($count / $limit));
		$offset = ($page - 1) * $limit;
		$comment_list = $comment_model->getList($where, 'id desc', $limit, $offset, true);
	}
	
	$user_list = array();
	if ($comment_list['user_list']) {
		foreach ($comment_list['user_list'] as $key => $user) {
			$tmp = array();
			$tmp['nickname'] = anonymous($user['nickname']);
			$tmp['avatar'] = $user['avatar'];
			
			$user_list[$key] = $tmp;
		}
	}
	
	$list = array();
	if ($comment_list['comment_list']) {
		foreach ($comment_list['comment_list'] as $tmp) {
			$tmp['content'] = htmlspecialchars($tmp['content']);
			$list[] = $tmp;
		}
	}
	
	$json_return['list'] = $list;
	//$json_return['tag_list'] = $comment_list['comment_tag_list'];
	$json_return['userlist'] = $user_list;
	$json_return['count'] = $count;
	$json_return['maxpage'] = ceil($count / $limit);
	
	$json_return['noNextPage'] = false;
	if(count($json_return['list']) < $limit || $total_page <= $page){
		$json_return['noNextPage'] = true;
	}
	
	json_return(0, $json_return);	
}




/********************控制*************************/
// 预览切换
if(!$is_mobile && $_SESSION['user'] && option('config.synthesize_store')) {
	if (isset($_GET['ps']) && $_GET['ps'] == '800') {
		$config = option('config');
		
		$url = $config['site_url'] . '/index.php?c=goods&a=index&id=' . $product_id . '&is_preview=1';
		echo redirect($url);
		exit;
	}
}



$action = isset($_GET['action']) ? $_GET['action']:'';
//dump($wap_user);
	switch($action){
	case 'get_pinlun_list':
		get_pinlun_list($product_id);
		break;
}

echo ob_get_clean();











?>