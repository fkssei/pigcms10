<?php
/*
 * 后台管理基础类
 *
 * @  Writers    Jaty
 * @  BuildTime  2014/11/05 15:28
 * 
 */
class BaseAction extends Action{
	protected $system_session;
	protected $static_path;
	protected $static_public;
    protected function _initialize(){
        import('checkFunc','./source/class');
$checkFunc=new checkFunc();
if (!function_exists('fdsrejsie3qklwewerzdagf4ds')){exit('error-4');}
$checkFunc->cfdwdgfds3skgfds3szsd3idsj();

		$this->system_session = session('system');
		if(empty($this->system_session)){
			header("Location: ".U('Login/index'));
		}
		$this->assign('system_session',$this->system_session);
		
		$this->config = D('Config')->get_config();
		$this->assign('config',$this->config);
		C('config',$this->config);
		
		$this->static_path   = './source/tp/Project/tpl/Static/';
		$this->static_public = './static/';
		$this->assign('static_path',$this->static_path);
		$this->assign('static_public',$this->static_public);
	}
	
	public function _empty(){
		exit('抱歉，您访问的页面不存在！');
	}
	
	protected function frame_main_ok_tips($tips,$time=3,$href=''){
		if($href == ''){
			$tips = '<font color=\"red\">'.$tips.'</font>';
			$href = 'javascript:history.back(-1);';
			$tips .= '<br/><br/>系统正在跳转到上一个页面。';
		}
		if($time != 3){
			$tips .= $time.'秒后会提示将自动关闭，可手动关闭！';
		}
		exit('<html><head><script>window.top.msg(1,"'.$tips.'",true,'.$time.');window.parent.frames[\'main\'].location.href="'.$href.'";</script></head></html>');
	}
	protected function error_tips($tips,$time=3,$href=''){
		if($href == ''){
			$tips = '<font color=\"red\">'.$tips.'</font>';
			$href = 'javascript:history.back(-1);';
			$tips .= '<br/><br/>系统正在跳转到上一个页面。';
		}
		if($time != 3){
			$tips .= $time.'秒后会提示将自动关闭，可手动关闭！';
		}
		exit('<html><head><script>window.top.msg(0,"'.$tips.'",true,'.$time.');location.href="'.$href.'";</script></head></html>');
	}
	protected function frame_error_tips($tips,$time=3){
		exit('<html><head><script>window.top.msg(0,"'.$tips.'",true,'.$time.');window.top.closeiframe();</script></head></html>');
	}
	protected function frame_submit_tips($type,$tips,$time=3){

		switch($type){

			case '1':
				exit('<html><head><script>window.top.msg(1,"'.$tips.'",true,'.$time.');window.top.main_refresh();window.top.closeiframe();</script></head></html>');
				break;

			case '2':
				exit('<html><head><script>window.top.msg(1,"'.$tips.'",true,'.$time.');window.history.back().reload();</script></head></html>');
				break;

			default:
				exit('<html><head><script>window.top.msg(0,"'.$tips.'",true,'.$time.');window.top.frames["Openadd"].history.back();window.top.closeiframebyid("form_submit_tips");</script></head></html>');

		}




	}
}