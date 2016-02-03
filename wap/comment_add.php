<?php
/**
 *  评论添加
 */
require_once dirname(__FILE__).'/global.php';

if (empty($wap_user)) {
	redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
}

$type = $_REQUEST['type'];
$id = $_REQUEST['id'];
if (empty($id)) {
	pigcms_tips('您输入的网址有误','none');
	exit;
}

$type_arr = array('PRODUCT', 'STORE');
if (!in_array($type, $type_arr)) {
	pigcms_tips('您输入的网址有误','none');
	exit;
}

$tag_list = array();
if ($type == 'PRODUCT') {
	$product = M('Product')->get(array('product_id' => $id, 'status' => 1));
	if (empty($product)) {
		pigcms_tips('未找到要评论的产品','none');
		exit;
	}
	
	// 查找系统评论TAG
	$product_category = M('Product_category')->getCategory($product['category_id']);
	if (!empty($product_category['tag_str'])) {
		$where = array();
		$where['id'] = array('in', explode(',', $product_category['tag_str']));
		$tag_list = M('System_tag')->geNameList($where);
	}
} else {
	$store = M('Store')->getStore($id);
	if (empty($store)) {
		pigcms_tips('未找到要评论的店铺','none');
		exit;
	}
}

if (IS_POST) {
	$relation_id = $_POST['id'];
	$type = $_POST['type'];
	$score = ceil($_POST['score'] + 0);
	$images_id_str = $_POST['images_id_str'];
	$content = $_POST['content'];
	$tag_id_str = $_POST['tag_id_str'];
	
	// debug score
	if ($score < 0 || $score > 5) {
		$score = 5;
	}
	
	$order_product = array();
	if ($type == 'PRODUCT') {
		// 查找是否有评论权限，判断标准为
		$order_product = M('Order_product')->isComment($relation_id);
		if (!$order_product) {
			//echo json_encode(array('status' => false, 'msg' => '购买后才能评论'));
			//exit;
		}
			
		//产品即管理其店铺id
		$product_arr = D('Product')->where(array('product_id'=>$relation_id))->find();
		$store_id = $product_arr['store_id'];
			
			
	} else if ($type == 'STORE') {
		// 逻辑处理
		$store_id = $relation_id;
	} else {
		exit;
	}
	
	if (!empty($content)) {
		$content = M('Ng_word')->filterNgWord($content);
	}
	
	$attachment_user_list = array();
	if (!empty($image_id_str)) {
		$images_id_arr = explode(',', $images_id_str);
		if (!empty($images_id_arr)) {
			print_r($images_id_arr);exit;
			$attachment_user_list = M('Attachment_user')->getList(array('pigcms_id' => array('in', $images_id_arr), 'uid' => $wap_user['uid']));
		}
	}
	
	$data = array();
	$data['dateline'] = time();
	$data['order_id'] = $order_product['order_id'];
	$data['relation_id'] = $relation_id;
	$data['uid'] = $wap_user['uid'];
	$data['store_id'] = $store_id;
	$data['score'] = $score;
	$data['type'] = $type;
	$data['status'] = option('config.ischeck_to_show_by_comment');
	$data['content'] = $content;
	$data['has_image'] = empty($attachment_user_list) ? 0 : 1;
	
	$cid = D('Comment')->data($data)->add();
	if (empty($cid)) {
		echo json_encode(array('status' => false, 'msg' => '发表评论失败'));
		exit;
	}
	
	// 插入评论附件表
	foreach ($attachment_user_list as $attachment_user) {
		$data = array();
		$data['cid'] = $cid;
		$data['uid'] = $wap_user['uid'];
		$data['type'] = $attachment_user['type'];
		$data['file'] = $attachment_user['file'];
		$data['size'] = $attachment_user['size'];
		$data['width'] = $attachment_user['width'];
		$data['height'] = $attachment_user['height'];
			
		D('Comment_attachment')->data($data)->add();
	}
	
	// 插入评论TAG表
	if (!empty($tag_id_str)) {
		$tag_id_arr = explode(',', $tag_id_str);
			
		foreach ($tag_id_arr as $tag_id) {
			$tag_id += 0;
			if (empty($tag_id) || $tag_id <= 0) {
				continue;
			}
	
			$data = array();
			$data['cid'] = $cid;
			$data['tag_id'] = $tag_id;
			$data['relation_id'] = $relation_id;
			$data['type'] = $type;
			$data['status'] = 1;
			D('Comment_tag')->data($data)->add();
		}
	}
	
	// 更改相应订单的产品为已评论
	if ($type == 'PRODUCT') {
		D('Order_product')->where(array('pigcms_id' => $order_product['pigcms_id']))->data(array('is_comment' => 1))->save();
	}
	
	echo json_encode(array('status' => true, 'msg' => '评论成功'));
	exit;
}

include display('comment_add');
echo ob_get_clean();
?>