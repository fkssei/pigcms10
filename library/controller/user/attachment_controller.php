<?php
class attachment_controller extends base_controller{
	public function __construct(){
		parent::__construct();
		if(empty($this->store_session)) json_return(999,'会话超时，请刷新页面重试');
	}
	public function img_download(){
		$url = $_POST['url'];
		if(IS_POST && !empty($url)){
			$ext_name = strrchr($url,'.');
			if($ext_name != '.gif' && $ext_name != '.jpg' && $ext_name != '.png' && $ext_name != '.jpeg') { 
				json_return(1000,'为了网站安全考虑，<br/>网址应以(gif、jpg、png或jpeg)结尾');
			}
			import('Http');
			$http_class = new Http();
			$image_content = $http_class->curlGet($url);
			if(empty($image_content)){
				json_return(1001,'没有获取到内容，请重试');
			}
			$img_store_id = sprintf("%09d",$this->store_session['store_id']);
			$rand_num = 'images/'.substr($img_store_id,0,3).'/'.substr($img_store_id,3,3).'/'.substr($img_store_id,6,3).'/'.date('Ym',$_SERVER['REQUEST_TIME']).'/';		
			$upload_dir = './upload/'.$rand_num; 
			if(!is_dir($upload_dir)){
				mkdir($upload_dir,0777,true);
			}
			$filename = uniqid().$ext_name;
			if(file_put_contents($upload_dir.$filename,$image_content)){
				$info = getimagesize($upload_dir.$filename);
				$ext = image_type_to_extension($info['2']);
				if(!in_array($ext,array('.gif','.jpg','.jpeg','.png'))){
					unlink($upload_dir.$filename);
					json_return(1002,'图片格式不允许<br/>只允许上传(gif、jpg、png或jpeg)格式的图片');
				}
				$add_result = $this->attachment_add($filename,$rand_num.$filename,filesize($upload_dir.$filename));
				if($add_result['err_code']){
					unlink($upload_dir.$filename);
				}else{
					// 上传到又拍云服务器
					$attachment_upload_type = option('config.attachment_upload_type');
					if ($attachment_upload_type == '1') {
						import('source.class.upload.upyunUser');
						upyunUser::upload('./upload/' . $rand_num . $filename, '/' . $rand_num . $filename);
					}

					json_return(0,array('url'=>getAttachmentUrl($rand_num . $filename),'pigcms_id'=>$add_result['pigcms_id']));
				}
			}else{
				json_return(1001,'图片保存失败，请重试');
			}
			
		}
	}
	public function img_upload(){
		$dom_id = $_POST['id'];
		if(!empty($_FILES['file']) && $_FILES['file']['error'] != 4){
			$img_store_id = sprintf("%09d",$this->store_session['store_id']);
			$rand_num = 'images/'.substr($img_store_id,0,3).'/'.substr($img_store_id,3,3).'/'.substr($img_store_id,6,3).'/'.date('Ym',$_SERVER['REQUEST_TIME']).'/';
		
			$upload_dir = './upload/'.$rand_num; 
			if(!is_dir($upload_dir)){
				mkdir($upload_dir,0777,true);
			}
			import('UploadFile');
			$upload = new UploadFile();
			$upload->maxSize = $_POST['maxsize']*1024*1024;
			$upload->allowExts = array('jpg','jpeg','png','gif');
			$upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
			$upload->savePath = $upload_dir;
			$upload->saveRule = 'uniqid';
			if($upload->upload()){
				$uploadList = $upload->getUploadFileInfo();
				$add_result = $this->attachment_add($uploadList[0]['name'],$rand_num.$uploadList[0]['savename'],$uploadList[0]['size']);
				if($add_result['err_code']){
					unlink($upload_dir.$uploadList[0]['name']);
					die('{"jsonrpc":"2.0","result":{"error_code":'.$add_result['err_code'].',"err_msg":"'.$add_result['err_msg'].'"},"id":"'.$dom_id.'"}');
				}

				// 上传到又拍云服务器
				$attachment_upload_type = option('config.attachment_upload_type');
				if ($attachment_upload_type == '1') {
					import('source.class.upload.upyunUser');
					upyunUser::upload('./upload/' . $rand_num . $uploadList[0]['savename'], '/' . $rand_num . $uploadList[0]['savename']);
				}

				die('{"jsonrpc":"2.0","result":{"error_code":0,"url":"'. getAttachmentUrl($rand_num.$uploadList[0]['savename']) .'","pigcms_id":'.$add_result['pigcms_id'].'},"id":"'.$dom_id.'"}');
			}else{
				die('{"jsonrpc":"2.0","result":{"error_code":999,"err_msg":"'.$upload->getErrorMsg().'"},"id":"'.$dom_id.'"}');
			}
		}else{
			die('{"jsonrpc":"2.0","result":{"error_code":999,"err_msg":"没有选择图片"},"id":"'.$dom_id.'"}');
		}
	}
	public function attachment_del(){
		if(IS_POST && !empty($_POST['pigcms_id'])){
			$database_attachment = D('Attachment');
			$condition_attachment['store_id'] = $this->store_session['store_id'];
			$condition_attachment['pigcms_id'] = $_POST['pigcms_id'];
			$now_attachment = $database_attachment->field('`pigcms_id`,`file`')->where($condition_attachment)->find();
			if(!empty($now_attachment)){
				@unlink('./upload/'.$now_attachment['file']);
				$database_attachment->where($condition_attachment)->delete();

				// 删除又拍云服务器
				$attachment_upload_type = option('config.attachment_upload_type');
				if ($attachment_upload_type == '1') {
					import('source.class.upload.upyunUser');
					upyunUser::delete('/' . $now_attachment['file']);
				}

				json_return(0,'删除成功');
			}else{
				json_return(1,'文件不存在');
			}
		}else{
			json_return(1,'非法访问');
		}
	}
	public function audio_upload(){
		set_time_limit(0);
		$dom_id = $_POST['id'];
		if( !empty($_FILES['file']) && $_FILES['file']['error'] != 4){
			$img_store_id = sprintf("%09d",$this->store_session['store_id']);
			$rand_num = 'audio/'.substr($img_store_id,0,3).'/'.substr($img_store_id,3,3).'/'.substr($img_store_id,6,3).'/'.date('Ym',$_SERVER['REQUEST_TIME']).'/';
		
			$upload_dir = './upload/'.$rand_num; 
			if(!is_dir($upload_dir)){
				mkdir($upload_dir,0777,true);
			}
			import('UploadFile');
			$upload = new UploadFile();
			$upload->maxSize = $_POST['maxsize']*1024*1024;
			$upload->allowExts = array('amr','mp3');
			$upload->allowTypes = array('audio/mp3','audio/amr');
			$upload->savePath = $upload_dir;
			$upload->saveRule = 'uniqid';
			if($upload->upload()){
				$uploadList = $upload->getUploadFileInfo();
				$add_result = $this->attachment_add($uploadList[0]['name'],$rand_num.$uploadList[0]['savename'],$uploadList[0]['size'],0,1);
				if($add_result['err_code']){
					die('{"jsonrpc":"2.0","result":{"error_code":'.$add_result['err_code'].',"err_msg":"'.$add_result['err_msg'].'"},"id":"'.$dom_id.'"}');
				}

				// 上传到又拍云服务器
				$attachment_upload_type = option('config.attachment_upload_type');
				if ($attachment_upload_type == '1') {
					import('source.class.upload.upyunUser');
					upyunUser::upload('./upload/' . $rand_num . $uploadList[0]['savename'], '/' . $rand_num . $uploadList[0]['savename']);
				}

				die('{"jsonrpc":"2.0","result":{"error_code":0,"url":"' . getAttachmentUrl($rand_num.$uploadList[0]['savename']) .'","pigcms_id":'.$add_result['pigcms_id'].'},"id":"'.$dom_id.'"}');
			}else{
				die('{"jsonrpc":"2.0","result":{"error_code":999,"err_msg":"'.$upload->getErrorMsg().'"},"id":"'.$dom_id.'"}');
			}
		}else{
			die('{"jsonrpc":"2.0","result":{"error_code":999,"err_msg":"没有选择图片"},"id":"'.$dom_id.'"}');
		}
	}
	
	public function attachment_add($name,$file,$size,$from=0,$type=0){
		$data_attachment['store_id'] = $this->store_session['store_id'];
		$data_attachment['name'] = $name;
		$data_attachment['from'] = $from;
		$data_attachment['type'] = $type;
		$data_attachment['file'] = $file;
		$data_attachment['size'] = $size;
		$data_attachment['add_time'] = $_SERVER['REQUEST_TIME'];
		$data_attachment['ip'] = get_client_ip(1);
		$data_attachment['agent'] = $_SERVER['HTTP_USER_AGENT'];


		if($type == 0){
			list($data_attachment['width'],$data_attachment['height']) =getimagesize('./upload/'.$file);
		}
		if($pigcms_id = D('Attachment')->data($data_attachment)->add()){
			return array('err_code'=>0,'pigcms_id'=>$pigcms_id);
		}else{
			return array('err_code'=>1001,'err_msg'=>'图片添加失败！请重试');
		}
	}
	public function getImgList(){
		$database_attachment = D('Attachment');
		$condition_attachment['store_id'] = $this->store_session['store_id'];
		$condition_attachment['status'] = '1';
		$condition_attachment['type'] = '0';
		$count = $database_attachment->where($condition_attachment)->count('pigcms_id');
		import('user_page');
		$p = new Page($count,27);
		$image_list = $database_attachment->field('`pigcms_id`,`name`,`file`,`size`,`width`,`height`')->where($condition_attachment)->order('`pigcms_id` DESC')->limit($p->firstRow.','.$p->listRows)->select();
		foreach($image_list as &$value){
			$value['file'] = getAttachmentUrl($value['file']);
		}
		$err_msg['image_list'] = $image_list;
		$err_msg['page_bar'] = $p->show();
		$err_msg['count'] = $count;
		json_return(0,$err_msg);
	}
}
?>