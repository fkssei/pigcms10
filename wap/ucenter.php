<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';
//setcookie('pigcms_sessionid','',$_SERVER['REQUEST_TIME']-10000000,'/');
$store_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');

setcookie('wap_store_id',$now_store['store_id'],$_SERVER['REQUEST_TIME']+10000000,'/');

//当前页面的地址
$now_url = $config['wap_site_url'].'/ucenter.php?id='.$now_store['store_id'];

//会员中心配置
$now_ucenter = D('Ucenter')->where(array('store_id'=>$now_store['store_id']))->find();
if(empty($now_ucenter)){
	$now_ucenter['page_title'] = $config['ucenter_page_title'];
	$now_ucenter['bg_pic']     = $config['site_url'].'/upload/images/'.$config['ucenter_bg_pic'];
	$now_ucenter['show_level'] = $config['ucenter_show_level'];
	$now_ucenter['show_point'] = $config['ucenter_show_point'];
}else{
	$now_ucenter['bg_pic'] = trim($now_ucenter['bg_pic'], '.');
}

//会员中心的自定义字段
if($now_ucenter['has_custom']){
	$homeCustomField = M('Custom_field')->getParseFields($store_id,'ucenter',$store_id);
}

//公共广告判断
$pageHasAd = false;
if($now_store['open_ad'] && !empty($now_store['use_ad_pages'])){
	$useAdPagesArr = explode(',',$now_store['use_ad_pages']);
	if(in_array('4',$useAdPagesArr)){
		$pageAdFieldArr = M('Custom_field')->getParseFields($store_id,'common_ad',$store_id);
		if(!empty($pageAdFieldArr)){
			$pageAdFieldCon = '';
			foreach($pageAdFieldArr as $value){
				$pageAdFieldCon .= $value['html'];
			}
			$pageHasAd = true;
		}
		$pageAdPosition = $now_store['ad_position'];
	}
}

//会员对应店铺的数据
M('Store_user_data')->updateData2($store_id,$wap_user['uid']);
$storeUserData = M('Store_user_data')->getUserData($now_store['store_id'],$wap_user['uid']);

//店铺导航
if($now_store['open_nav'] && !empty($now_store['use_nav_pages'])){
	$useNavPagesArr = explode(',',$now_store['use_nav_pages']);
	if(in_array('2',$useNavPagesArr)){
		$storeNav = M('Store_nav')->getParseNav($now_store['store_id']);
	}
}

$store = M('Store');
$store_supplier = M('Store_supplier');
$drp_link = false;
$store_info = $store->getStore($store_id);
$allow_drp = option('config.open_store_drp');
if ($allow_drp) {
    $max_store_drp_level = option('config.max_store_drp_level'); //最大分销级别
    $seller = $store_supplier->getSeller(array('seller_id' => $store_id));
    $tmp_store_info = $store->getUserDrpStore($_SESSION['wap_user']['uid'], 0, 0); //有分销店铺
    if ((!empty($seller) && $seller['level'] <= $max_store_drp_level) || !empty($tmp_store_info)) { //分销级别没有超出最大限制
        $drp_link = true;
    }
    if ($store_info['uid'] == $_SESSION['wap_user']['uid']) {
        $drp_link_url = './drp_register.php?id=' . $store_id;
    } else {
        $seller_store = D('Store')->field('store_id')->where(array('drp_supplier_id' => $store_id, 'uid' => $_SESSION['wap_user']['uid'], 'status' => 1))->find();
        if (!empty($seller_store)) { //当前店铺的分销商优先
            $drp_link_url = './drp_register.php?id=' . $seller_store['store_id'];
        } else {
            $drp_link_url = './drp_register.php';
        }
    }
}

//分享配置 start
$share_conf 	= array(
	'title' 	=> $now_store['name'].'-用户中心', // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''),  $now_store['intro']), // 分享描述
	'link' 		=> $now_url, // 分享链接
	'imgUrl' 	=> $now_store['logo'], // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('ucenter');
echo ob_get_clean();
?>