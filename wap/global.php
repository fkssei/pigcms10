<?php

/* 手机端公共文件 */
define('PIGCMS_PATH', dirname(__FILE__).'/../');
define('DEBUG',true);
define('GROUP_NAME','wap');
define('IS_SUB_DIR',true);
require_once PIGCMS_PATH.'source/init.php';
/*用户信息*/
///////////////粉丝同步///////////////////
if (!empty($_GET['id'])) {
    if (stripos($_SERVER['REQUEST_URI'], 'good.php')) {
        $tmp_product = D('Product')->field('store_id')->where(array('product_id' => intval(trim($_GET['id']))))->find();
        $tmp_store_id = $tmp_product['store_id'];
    } else if (stripos($_SERVER['REQUEST_URI'], 'goodcat.php')) {
        $tmp_group = D('Product_group')->field('store_id')->where(array('group_id' => intval(trim($_GET['id']))))->find();
        $tmp_store_id = $tmp_group['store_id'];
    } else if (stripos($_SERVER['REQUEST_URI'], 'page.php')) {
        $tmp_page = D('Wei_page')->field('store_id')->where(array('page_id' => intval(trim($_GET['id']))))->find();
        $tmp_store_id = $tmp_page['store_id'];
    } else if (stripos($_SERVER['REQUEST_URI'], 'drp_product_share')) {
        $tmp_product = D('Product')->field('store_id')->where(array('product_id' => intval(trim($_GET['id']))))->find();
        $tmp_store_id = $tmp_product['store_id'];
    } else if (stripos($_SERVER['REQUEST_URI'], 'pay')) {
        $tmp_order = M('Order')->find($_GET['id']);
        $tmp_store_id = $tmp_order['store_id'];
    } else {
        $tmp_store_id = intval(trim($_GET['id']));
    }
} else if (!empty($_GET['store_id'])) {
    $tmp_store_id = intval(trim($_GET['store_id']));
}
if (!empty($tmp_store_id) && !empty($_GET['sessid']) && !empty($_GET['token'])) { //对接粉丝登录
    $user = M('User');
    $tmp_sessid = trim($_GET['sessid']);
    $tmp_token = trim($_GET['token']);
    $tmp_openid = trim($_GET['wecha_id']);
    $user = $user->checkUser(array('session_id' => $tmp_sessid, 'token' => $tmp_token, 'third_id' => $tmp_openid));
    if (!empty($user)) {
        $_SESSION['wap_user'] = $user;
        $_SESSION['wap_user']['store_id'] = $tmp_store_id;
        $_SESSION['sync_user'] = true;
        import('source.class.String');

        if (empty($_SESSION['sessid'])) {
            $session_id = String::keyGen();
            $_SESSION['sessid'] = $session_id;
        }
        D('User')->where(array('uid' => $user['uid']))->data(array('session_id' => $_SESSION['sessid']))->save();
    }
}
$php_self 	= php_self();
////////////////////////////////////

$wap_user = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();

//检测分销商是否存在
if (!empty($_SESSION['wap_drp_store']) && $_SESSION['wap_drp_store']['store_id'] != $tmp_store_id) {
    $store_exists = D('Store')->where(array('store_id' => $_SESSION['wap_drp_store']['store_id'], 'status' => 1))->find();
    if (empty($store_exists)) { //店铺不存在或已删除
        unset($_SESSION['wap_drp_store']); //删除保存在session中分销商
    }
}

/*是否移动端*/
$is_mobile = is_mobile();
/*是否微信端*/
$is_weixin = is_weixin();
//热门关键词
$hot_keyword 	= D('Search_hot')->where('1')->order('sort DESC')->limit(8)->select();

//合并SESSION和UID的购物车、订单、收货地址等信息
function mergeSessionUserInfo($sessionid,$uid){
	//购物车
	D('User_cart')->where(array('uid'=>0,'session_id'=>$sessionid))->data(array('uid'=>$uid,'session_id'=>''))->save();
	
	//订单
	$edit_rows = D('Order')->where(array('uid'=>0,'session_id'=>$sessionid))->data(array('uid'=>$uid,'session_id'=>''))->save();
	if($edit_rows && $_COOKIE['wap_store_id']){
        //分销订单
        D('Fx_order')->where(array('uid'=>0,'session_id'=>$sessionid))->data(array('uid'=>$uid,'session_id'=>''))->save();
		M('Store_user_data')->updateData($_COOKIE['wap_store_id'],$uid);
	}
	
	//收货地址 
	D('User_address')->where(array('uid'=>0,'session_id'=>$sessionid))->data(array('uid'=>$uid,'session_id'=>''))->save();
}

//访问统计
function Analytics($store_id, $module, $title, $id)
{
    $analytics = M('Store_analytics');
    $ip = bindec(decbin(ip2long($_SERVER['REMOTE_ADDR'])));
    $time = time();
    $analytics->add(array('store_id' => $store_id, 'module' => $module, 'title' => $title, 'page_id' => $id, 'visited_time' => $time, 'visited_ip' => $ip));
    if (strtolower($module) == 'goods') {
        $product = M('Product');
        $product->analytics(array('product_id' => $id, 'store_id' => $store_id));
    }
}
//获取当前文件名称 （公用菜单选中效果）
function php_self(){
    $php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
    return $php_self;
}
?>
