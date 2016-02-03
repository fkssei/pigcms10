<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
if($_GET['action'] == 'clear'){
	setcookie('good_history','',$_SERVER['REQUEST_TIME']-86400*365,'/');
	redirect('./my_recently.php');
}else{
	$good_history = $_COOKIE['good_history'];
	if(!empty($good_history)){
		$good_history_arr = json_decode($good_history,true);
		if(is_array($good_history_arr)){
			foreach($good_history_arr as &$value){
				$tmp_time = $_SERVER['REQUEST_TIME'] - $value['time'];
				if($tmp_time < 60){
					$value['time_txt'] = $tmp_time.'秒前';
				}else if($tmp_time < 3600){
					$value['time_txt'] = floor($tmp_time/60).'分钟前';
				}else if($_SERVER['REQUEST_TIME'] - $value['time'] < 86400){
					$value['time_txt'] = floor($tmp_time/3600).'小时前';
				}else if($_SERVER['REQUEST_TIME'] - $value['time'] < 86400){
					$value['time_txt'] = floor($tmp_time/86400).'天前';
				}
			}
		}
	}
}

//分享配置 start
$share_conf 	= array(
	'title' 	=> $_SESSION['store']['name'].'-浏览记录', // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''),  $_SESSION['store']['intro']), // 分享描述
	'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('my_recently');
	
echo ob_get_clean();
?>