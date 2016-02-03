<?php
/**
 * 站外商品
 * User: pigcms_21
 * Date: 2015/6/5
 * Time: 11:06
 */
require_once dirname(__FILE__).'/global.php';

$product_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');

$product = D('Product')->field('buy_url')->where(array('product_id' => $product_id))->find();
if(empty($product)) pigcms_tips('您访问的商品不存在','none');

include display('outside_good');

echo ob_get_clean();