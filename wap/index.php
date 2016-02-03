<?php
/**
 *  店铺主页
 */
require_once dirname(__FILE__).'/global.php';

if(option('config.is_diy_template')){
	//模板类型

	//微杂志的自定义字段
	if($homePage['has_custom']){
		$homeCustomField = M('Custom_field')->getParseFields(0,'page',$homePage['page_id']);
	}

	//首页幻灯片
	$slide 	= M('Adver')->get_adver_by_key('wap_index_slide_top',5);

	//首页自定义导航
	$slider_nav =  M('Slider')->get_slider_by_key('wap_index_nav',16);

	//热门品牌下方广告
	$hot_brand_slide = M('Adver')->get_adver_by_key('wap_index_brand',2);

	//首页分类
	$cat 	= D('Product_category')->where("cat_status = 1 and cat_level = 2 and cat_pic != ''")->order('cat_sort ASC,cat_id DESC')->limit('12')->select();
	foreach($cat as $key=>$value){
		$cat[$key]['cat_pic'] = getAttachmentUrl($value['cat_pic']);
	}
	//品牌
	$brand 	= D('Store')->where(array('status'=>1,'approve'=>1))->field('`store_id`,`name`,`logo`')->order('`store_id` DESC')->limit(12)->select();
	foreach($brand as $key=>$value){
		$brand[$key]['url'] =  'home.php?id='.$value['store_id'];
		if (empty($value['logo'])) {
			$brand[$key]['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
		} else {
			$brand[$key]['logo'] = getAttachmentUrl($value['logo']);
		}
	}
	//首页推荐商品
	$product_list = M('Product')->getSelling('quantity>0 AND status=1 AND is_recommend = 1', '', '', 0, 4);//D('Product')->where('quantity>0 AND status=1 AND is_recommend = 1')->limit('4')->select();
	//首页推荐活动
	$active_list = D('Activity_recommend')->order("is_rec desc,ucount desc")->limit(4)->select();
	$activity =  M('activity');
	foreach($active_list as $k=> $value) {
		$active_list[$k]["url"] = $activity->createUrl($value,$value['model'],'1');
		$active_list[$k]["image"] = getAttachmentUrl($value['image']);
		
	}
	
}else{
	if(empty($config['platform_mall_index_page'])){
		pigcms_tips('请管理员在管理后台【系统设置】=》【站点配置】=》【平台商城配置】选取微页面','none');
	}

	//首页的微杂志
	$homePage = D('Wei_page')->where(array('page_id'=>$config['platform_mall_index_page']))->find();
	if(empty($homePage)){
		pigcms_tips('您访问的店铺没有首页','none');
	}
}
$imUrl 	= getImUrl($_SESSION['wap_user']['uid'],$store_id);

$is_have_activity = option('config.is_have_activity');

//分享配置 start
$share_conf 	= array(
	'title' 	=> option('config.site_name'), // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), option('config.seo_description')), // 分享描述
	'link' 		=> option('config.wap_site_url'), // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('index');

echo ob_get_clean();
?>