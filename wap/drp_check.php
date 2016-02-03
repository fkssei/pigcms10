<?php
/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/5/11
 * Time: 10:29
 */
require_once dirname(__FILE__).'/global.php';

if (IS_POST && empty($_SESSION['wap_user'])) {
    json_return(10000, '操作失败，您还未登录');
} else if (empty($_SESSION['wap_user'])) {
    redirect('./login.php');
}

if (!option('config.open_store_drp')) { //未开启排他分销
    if (!empty($_COOKIE['wap_store_id'])) {
        redirect('./ucenter.php?id=' . $_COOKIE['wap_store_id']);
    } else {
        pigcms_tips('抱歉，您没有权限访问','none');
    }
}

$flag = true;
$tmp_store = D('Store')->field('uid,open_drp_limit,drp_limit_buy,drp_limit_share,drp_limit_condition')->where(array('store_id' => $_GET['id']))->find();
if (!empty($tmp_store['open_drp_limit']) && $_SESSION['wap_user']['uid'] != $tmp_store['uid']) { //分销限制
    if (!empty($tmp_store['drp_limit_buy'])) { //消费满多少
        $array = array();
        $array['store_id'] = intval($_GET['id']);
        $array['status']   = 4;
        if (!empty($_SESSION['wap_user']['uid'])) {
            $array['uid'] = $_SESSION['wap_user']['uid'];
        } else if (!empty($_COOKIE['uid'])) {
            $array['uid'] = $_COOKIE['uid'];
        } else if (session_id()) {
            $array['session_id'] = session_id();
        }
        $total = D('Order')->where($array)->sum('total');
        if ($total < $tmp_store['drp_limit_buy']) {
            $flag = false;
        }
    }
    $flag1 = true;
    /*if (!empty($tmp_store['drp_limit_share'])) { //分享满多少
        $flag1 = true;
    }*/
    //if (!empty($tmp_store['drp_limit_condition'])) { // 两个条件必须满足才可分销
        if (!($flag && $flag1)) {
            if (!empty($tmp_store['drp_limit_buy']) && !empty($tmp_store['drp_limit_share'])) {
                pigcms_tips('亲，还差一步哦，在本店消费满 ' . $tmp_store['drp_limit_buy'] . '元，同时分享本店 ' . $tmp_store['drp_limit_share'] . '次，即可申请成为本店分销商。', 'none');
            } else if (!empty($tmp_store['drp_limit_buy'])) {
                pigcms_tips('亲，还差一步哦，在本店消费满 ' . $tmp_store['drp_limit_buy'] . '元，即可申请成为本店分销商。', 'none');
            } else if (!empty($tmp_store['drp_limit_share'])) {
                pigcms_tips('亲，还差一步哦，分享本店 ' . $tmp_store['drp_limit_buy'] . '次，即可申请成为本店分销商。', 'none');
            }
        }
    /*} else {
        if (!($flag || $flag1)) {
            if (!empty($tmp_store['drp_limit_buy']) && !empty($tmp_store['drp_limit_share'])) {
                pigcms_tips('亲，还差一步哦，在本店消费满 ' . $tmp_store['drp_limit_buy'] . '元，或分享本店 ' . $tmp_store['drp_limit_share'] . '次，即可申请成为本店分销商。', 'none');
            } else if (!empty($tmp_store['drp_limit_buy'])) {
                pigcms_tips('亲，还差一步哦，在本店消费满 ' . $tmp_store['drp_limit_buy'] . '元，即可申请成为本店分销商。', 'none');
            } else if (!empty($tmp_store['drp_limit_share'])) {
                pigcms_tips('亲，还差一步哦，分享本店 ' . $tmp_store['drp_limit_buy'] . '次，即可申请成为本店分销商。', 'none');
            }
        }
    }*/
}