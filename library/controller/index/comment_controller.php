<?php
/**
 * 评论
 * User: pigcms_21
 * Date: 2015/3/3
 * Time: 14:41
 */
class comment_controller extends base_controller{
	// 默认状态值，1：通过审核，0：未通过审核
	var $status = 1;
	/**
	 * 返回的评论
	 */
	public function index() {
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
			$where['has_image']  = 1;
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
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$comment_list = $comment_model->getList($where, 'id desc', $limit, $offset, true);
			
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		$data = array();
		$data['tab'] = $tab;
		$data['comment_list'] = $comment_list['comment_list'];
		$data['user_list'] = $comment_list['user_list'];
		$data['comment_tag_list'] = $comment_list['comment_tag_list'];
		$data['pages'] = $pages;
		$data['total_pages'] = ceil($count / $limit);
		
		if (empty($comment_list['comment_list'])) {
			echo '<div style="height:24px; line-height:24px; padding-top:20px;">暂无数据</div>';
			exit;
		}
		
		$this->assign($data);
		$this->display();
	}
	
	/**
	 * 添加
	 */
	public function add() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => false, 'msg' => 'nologin'));
			exit;
		}
		$this->status = option('config.ischeck_to_show_by_comment');
		
		$relation_id = $_POST['id'];
		$type = $_POST['type'];
		$score = ceil($_POST['score'] + 0);
		//$logistics_score = min(1, max(5, $_POST['logistics_score']));
		//$description_score = min(1, max(5, $_POST['description_score']));
		//$speed_score = min(1, max(5, $_POST['speed_score']));
		//$service_score = min(1, max(5, $_POST['service_score']));
		$images_id_str = $_POST['images_id_str'];
		$content = $_POST['content'];
		$tag_id_str = $_POST['tag_id_str'];
		
		$type_arr = array('PRODUCT', 'STORE');
		if (!in_array($type, $type_arr)) {
			echo json_encode(array('status' => false, 'msg' => '来源错误'));
			exit;
		}
		
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
		error_log('image:' . $images_id_str);
		$attachment_user_list = array();
		if (!empty($images_id_str)) {
			$images_id_arr = explode(',', $images_id_str);
			if (!empty($images_id_arr)) {
				$attachment_user_list = M('Attachment_user')->getList(array('pigcms_id' => array('in', $images_id_arr), 'uid' => $this->user_session['uid']));
			}
		}

		$data = array();
		$data['dateline'] = time();
		$data['order_id'] = $order_product['order_id'];
		$data['relation_id'] = $relation_id;
		$data['uid'] = $this->user_session['uid'];
		$data['store_id'] = $store_id;
		$data['score'] = $score;
		//$data['logistics_score'] = $logistics_score;
		//$data['description_score'] = $description_score;
		//$data['speed_score'] = $speed_score;
		//$data['service_score'] = $service_score;
		$data['type'] = $type;
		$data['status'] = $this->status;
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
			$data['uid'] = $this->user_session['uid'];
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
				$data['status'] = $this->status;
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
	
	// 图片添加
	public function attachment() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => false, 'msg' => 'nologin'));
			exit;
		}
		
		if(!empty($_FILES['file']) && $_FILES['file']['error'] != 4){
			$img_path_str = '';
		
			// 用会员uid
			$img_path_str = sprintf("%09d",$this->user_session['uid']);
		
			// 产生目录结构
			$rand_num = 'images/' . substr($img_path_str, 0, 3) . '/' . substr($img_path_str, 3, 3) . '/' . substr($img_path_str, 6, 3) . '/' . date('Ym', $_SERVER['REQUEST_TIME']) . '/';
				
			$upload_dir = './upload/' . $rand_num;
			if(!is_dir($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
		
			// 进行上传图片处理
			import('UploadFile');
			$upload = new UploadFile();
			$upload->maxSize = 1 * 1024 * 1024;
			$upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
			$upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
			$upload->savePath = $upload_dir;
			$upload->saveRule = 'uniqid';
			if($upload->upload()) {
				$uploadList = $upload->getUploadFileInfo();
				$pigcms_id = $this->_attachmentAdd($uploadList[0]['name'], $rand_num . $uploadList[0]['savename'], $uploadList[0]['size']);
				if(!$pigcms_id){
					unlink($upload_dir . $uploadList[0]['name']);
					
					echo json_encode(array('status' => false, 'msg' => '图片上传失败'));
					exit;
				} else {
					$attachment_upload_type = option('config.attachment_upload_type');
					// 上传到又拍云服务器
					if ($attachment_upload_type == '1') {
						import('source.class.upload.upyunUser');
						upyunUser::upload('./upload/' . $rand_num . $uploadList[0]['savename'], '/' . $rand_num . $uploadList[0]['savename']);
					}
					
					echo json_encode(array('status' => true, 'msg' => '上传成功', 'data' => array('id' => $pigcms_id, 'file' => getAttachmentUrl($rand_num . $uploadList[0]['savename']))));
					exit;
				}
			} else {
				echo json_encode(array('status' => false, 'msg' => '图片上传失败'));
				exit;
			}
		} else {
			echo json_encode(array('status' => false, 'msg' => '未找到要上传文件'));
			exit;
		}
	}
	
	public function reply() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => false, 'msg' => 'nologin'));
			exit;
		}
		
		$cid = $_REQUEST['cid'];
		$content = $_REQUEST['content'];
		
		if (empty($cid) || empty($content)) {
			echo json_encode(array('status' => false, 'msg' => '参数错误'));
			exit;
		}
		
		$data = array();
		$data['dateline'] = time();
		$data['cid'] = $cid;
		$data['uid'] = $this->user_session['uid'];
		$data['content'] = M('Ng_word')->filterNgWord($content);
		$data['status'] = $this->status;
		
		$id = D('Comment_reply')->data($data)->add();
		if ($id) {
			echo json_encode(array('status' => true, 'msg' => '评论成功'));
			exit;
		} else {
			echo json_encode(array('status' => false, 'msg' => '评论失败'));
			exit;
		}
	}
	
	/**
	 * 插入会员素材图片
	 */
	private function _attachmentAdd($name, $file, $size, $from=0, $type=0){
		$data['uid'] = $this->user_session['uid'];
		$data['name'] = $name;
		$data['from'] = $from;
		$data['type'] = $type;
		$data['file'] = $file;
		$data['size'] = $size;
		$data['add_time'] = $_SERVER['REQUEST_TIME'];
		$data['ip'] = get_client_ip(1);
		$data['agent'] = $_SERVER['HTTP_USER_AGENT'];
	
		if($type == 0) {
			list($data['width'], $data['height']) = getimagesize('./upload/' . $file);
		}
		
		if($pigcms_id = M('Attachment_user')->add($data)) {
			return $pigcms_id;
		} else {
			return false;
		}
	}
}