<?php
//狗扑源码社区 www.gope.cn
require_once dirname(__FILE__) . '/global.php';
$cat_id = (isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误', 'none'));
$database_product_category = D('Product_category');
$now_cat = $database_product_category->where(array('cat_id' => $cat_id))->find();
$first_cat_list = $database_product_category->field('`cat_id`,`cat_name`')->where(array('cat_fid' => 0))->order('`cat_sort` DESC')->select();
$two_cat_list = $database_product_category->field('`cat_id`,`cat_name`')->where(array('cat_fid' => $cat_id))->order('`cat_sort` DESC')->select();
$product_list = D('Product')->field('`product_id`,`name`,`image`,`price`,`original_price`,`sales`')->where(array('category_fid' => $cat_id))->order('`product_id` DESC')->limit(10)->select();
include display('category');
echo ob_get_clean();

?>
