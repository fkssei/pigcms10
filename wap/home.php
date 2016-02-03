<?php
/**
 *  店铺主页
 */
require_once dirname(__FILE__).'/global.php';

$store_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');

// 预览切换
if(!$is_mobile && $_SESSION['user'] && option('config.synthesize_store')) {
    if (isset($_GET['ps']) && $_GET['ps'] == '800') {
        $config = option('config');

        $url = $config['site_url'] . '/index.php?c=store&a=index&id='.$store_id.'&is_preview=1';
        echo redirect($url);
        exit;
    }
}

//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
if(empty($now_store)){
	pigcms_tips('您访问的店铺不存在','none');
}

//首页的微杂志
$homePage = D('Wei_page')->where(array('is_home'=>1,'store_id'=>$store_id))->find();
if(empty($homePage)){
	pigcms_tips('您访问的店铺没有首页','none');
}

setcookie('wap_store_id',$now_store['store_id'],$_SERVER['REQUEST_TIME']+10000000,'/');

//当前页面的地址
$now_url = $config['wap_site_url'].'/home.php?id='.$now_store['store_id'];

//微杂志的自定义字段
if($homePage['has_custom']){
	$homeCustomField = M('Custom_field')->getParseFields($store_id,'page',$homePage['page_id']);
}

//公共广告判断
$pageHasAd = false;
if($now_store['open_ad'] && !empty($now_store['use_ad_pages'])){
	$useAdPagesArr = explode(',',$now_store['use_ad_pages']);
	if(in_array('5',$useAdPagesArr)){
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

//店铺导航
if($now_store['open_nav'] && !empty($now_store['use_nav_pages'])){
	$useNavPagesArr = explode(',',$now_store['use_nav_pages']);
	if(in_array('1',$useNavPagesArr)){
		$storeNav = M('Store_nav')->getParseNav($now_store['store_id']);
	}
}

//会员头像
$drp_notice = false;
$is_seller = false; //是否是分销商
$drp_register_url = '';
$seller_name = ''; //分销商
if (!empty($_SESSION['wap_user']['uid']) && !empty($now_store['open_drp_guidance']) && $_SESSION['wap_user']['uid'] != $now_store['uid']) {
    $user = M('User');
    $avatar = $user->getAvatarById($_SESSION['wap_user']['uid']);
    //判断是否开启分销
    $allow_drp = option('config.open_store_drp');
    if ($allow_drp) {
        $store_supplier = M('Store_supplier');
        //最大分销级别
        $max_store_drp_level = option('config.max_store_drp_level'); //最大分销级别
        if ($now_store['uid'] != $_SESSION['wap_user']['uid']) { //他人店铺
            //判断是否已经是分销商
            $seller_store = D('Store')->where(array('drp_supplier_id' => $store_id, 'uid' => $_SESSION['wap_user']['uid'], 'status' => 1))->find();
            $seller = $store_supplier->getSeller(array('seller_id' => $store_id, 'type' => 1));
            if (!empty($seller_store)) {
                $seller_info = D('Store')->field('store_id,name')->where(array('store_id' => $seller_store['store_id']))->find();
                $seller_name = $seller_info['name'];
                $is_seller = true;
                $drp_notice = true;
                $drp_register_url = './drp_register.php?id=' . $seller_store['store_id'];
            } else if (((!empty($seller) && $seller['level'] <= $max_store_drp_level) || empty($seller)) && empty($seller_store)) { //在最大分销级别内
                $drp_notice = true;
                $drp_register_url = './drp_register.php?id=' . $store_id;
            }
        } else {//自己店铺
            //判断是否已经是分销商
            $seller_store = D('Store')->where(array('drp_supplier_id' => $store_id, 'uid' => $_SESSION['wap_user']['uid'], 'status' => 1))->find();
            if (!empty($seller_store)) {
                $seller_info = D('Store')->field('store_id,name')->where(array('store_id' => $seller_store['store_id']))->find();
                $seller_name = $seller_info['name'];
                $is_seller = true;
                $drp_notice = true;
                $drp_register_url = './drp_register.php?id=' . $seller_store['store_id'];
            }
        }


        if (!empty($now_store['open_drp_limit']) && !empty($now_store['drp_limit_buy'])) {
            $msg = '亲爱的 <span style="color:#26CB40">' . $_SESSION['wap_user']['nickname'] . '</span>，在本店消费满 <span style="color:red">' . $now_store['drp_limit_buy'] . '</span> 元，即可申请分销！';
        } else {
            $msg = '亲爱的 <span style="color:#26CB40">' . $_SESSION['wap_user']['nickname'] . '</span>，申请分销即可分销赚佣金！';
        }
    }
}

//分享配置 start
$share_conf 	= array(
	'title' 	=> $now_store['name'], // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), !empty($now_store['intro']) ? $now_store['intro'] : $now_store['name']), // 分享描述
	'link' 		=> $now_store['url'], // 分享链接
	'imgUrl' 	=> $now_store['logo'], // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('home');

echo ob_get_clean();
?>