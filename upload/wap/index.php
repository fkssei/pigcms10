<?php
/**
 *  店铺主页
 */
require_once dirname(__FILE__).'/global.php';

if(empty($config['platform_mall_index_page'])){
	pigcms_tips('请管理员在管理后台【系统设置】=》【站点配置】=》【平台商城配置】选取微页面','none');
}
//首页的微杂志
$homePage = D('Wei_page')->where(array('page_id'=>$config['platform_mall_index_page']))->find();
if(empty($homePage)){
	pigcms_tips('您访问的店铺没有首页','none');
}

//模板类型

//微杂志的自定义字段
if($homePage['has_custom']){
	$homeCustomField = M('Custom_field')->getParseFields(0,'page',$homePage['page_id']);
}

//首页幻灯片
$slide 	= M('Adver')->get_adver_by_key('wap_index_slide_top',5);

//首页自定义导航
$slider_nav =  M('Slider')->get_slider_by_key('wap_index_nav',4);

//热门品牌下方广告
$hot_brand_slide = M('Adver')->get_adver_by_key('wap_index_brand',2);

//首页分类
$cat 	= D('Product_category')->where(array('cat_status'=>1,'cat_level'=>2))->order('cat_sort ASC,cat_id DESC')->limit('12')->select();

//品牌
$brand 	= D('Sale_category')->where('1')->field('* ')->order('order_by ASC,cat_id ASC')->limit('8')->select();
foreach($brand as $key=>$value){
	$brand[$key]['cat_pic'] = getAttachmentUrl('category/'.$value['cat_pic']);
}
//首页推荐商品
//$goods 	= D('Product')->where('quantity>0 AND status=1')->field('*, CONCAT("./upload/", image) AS image')->limit('12')->select();


include display('index');

echo ob_get_clean();
?>