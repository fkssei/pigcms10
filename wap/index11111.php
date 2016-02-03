<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
require_once dirname(__FILE__) . '/global.php';
$cat_list = D('Product_category')->where(array('cat_fid' => 0))->order('`cat_sort` DESC')->select();
include display('index');
echo ob_get_clean();

?>
