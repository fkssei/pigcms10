<?php

class recognition_controller extends base_controller{
	public function see_login_qrcode(){
		$qrcode_return = M('Recognition')->get_login_qrcode();
		if($qrcode_return['error_code']){
			echo '<html><head></head><body>'.$qrcode_return['msg'].'<br/><br/><font color="red">请关闭此窗口再打开重试。</font></body></html>';
		}else{
			$this->assign($qrcode_return);
			$this->display();
		}
	}
	public function see_register_qrcode(){
		$qrcode_return = M('Recognition')->get_login_qrcode();
		if($qrcode_return['error_code']){
			echo '<html><head></head><body>'.$qrcode_return['msg'].'<br/><br/><font color="red">请关闭此窗口再打开重试。</font></body></html>';
		}else{
			$this->assign($qrcode_return);
			$this->display();
		}
	}	
	public function see_tmp_qrcode(){
		if(empty($_GET['qrcode_id'])){
			json_return(1,'无法得到二维码图片！');
		}
		$qrcode_return = M('Recognition')->get_tmp_qrcode($_GET['qrcode_id']);
		json_return(0,$qrcode_return);
	}
}