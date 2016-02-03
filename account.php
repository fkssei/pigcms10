<?php

/* 注册登录页面 */

define('PIGCMS_PATH', dirname(__FILE__) . '/');
define('GROUP_NAME', 'user');
require_once PIGCMS_PATH . 'source/init.php';

//$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';
$action = isset($_GET['a']) ? addslashes($_GET['a']) : '';
if ($action == 'register') {
    if (IS_POST) {
//        $phone = isset($_POST['phone']) ? $_POST['phone'] : json_return(1006, '请输入手机号码！', 'phone');
//        $nickname = isset($_POST['nickname']) ? $_POST['nickname'] : json_return(1007, '请输入昵称！', 'nickname');
//        $password = isset($_POST['password']) ? $_POST['password'] : json_return(1008, '请输入密码！', 'password');

        $phone = $_POST['phone'];
        $nickname = $_POST['nickname'];
        $password = $_POST['password'];
        if (!isset($phone)) {
            echo json_encode(array('status' => false, 'msg' => '请输入手机号码！'));
            exit;
        }

        if (!isset($nickname)) {
            echo json_encode(array('status' => false, 'msg' => '请输入昵称！'));
            exit;
        }

        if (!isset($password)) {
            echo json_encode(array('status' => false, 'msg' => '请输入密码！'));
            exit;
        }

        $database_user = D('User');
        if ($database_user->field('`uid`')->where(array('phone' => $phone))->find()) {
            //json_return(1001, '这个手机号码已经注册过了，请直接登录或者更换手机号码！', 'phone');
            echo json_encode(array('status' => false, 'msg' => '这个手机号码已经注册过了，请直接登录或者更换手机号码！'));
            exit;
        }

        if ($database_user->field('`uid`')->where(array('nickname' => $nickname))->find()) {
            //json_return(1002, '这个昵称已经注册过了，请更换昵称！', 'nickname');
            echo json_encode(array('status' => false, 'msg' => '这个昵称已经注册过了，请更换昵称！'));
            exit;
        }


        $pwd_len = strlen($password);
        if ($pwd_len < 6 || $pwd_len > 20) {
            //json_return(1003, '密码为6-20个字符，目前为 ' . $pwd_len . ' 个长度！', 'password');
            echo json_encode(array('status' => false, 'msg' => '密码为6-20个字符，目前为 ' . $pwd_len . ' 个长度！'));
            exit;
        }
        if ($_G['config']['register_check_phone']) {
            $_SESSION['register_user'] = array(
                'phone' => $phone,
                'nickname' => $nickname,
                'password' => md5($password),
                'check_phone' => '1',
            );
            json_return(1004, array('tips' => '手机绑定', 'again_time' => $_G['config']['register_phone_again_time']));
        }

        $add_result = add_user(array('phone' => $phone, 'nickname' => $nickname, 'password' => md5($password)));
        if ($add_result['err_code'] == 0) {
            unset($_SESSION['register_user']);
            //json_return(0,'注册成功！');
            echo json_encode(array('status' => true, 'msg' => '注册成功', 'data' => array('nexturl' => '/user.php?c=store&a=select')));
            exit;
        } else {
            //json_return($add_result['err_code'], $add_result['err_msg']);
            echo json_encode(array('status' => false, 'msg' => $add_result['err_msg'], 'data' => array('err_code' => $add_result['err_code'])));
            exit;
        }
    } else {
        if (!empty($_SESSION['user']))
            redirect(url('user:store:select'));
        include display('user:account:register');
    }
}else if ($action == 'register_getcode') {
    if (empty($_SESSION['register_user']))
        json_return(1005, '会话超时！请重新注册。');
    $_SESSION['register_user']['check_code'] = '123456';
    json_return(0, '发送成功！');
}else if ($action == 'register_checkcode') {
    if (empty($_SESSION['register_user']))
        json_return(1005, '会话超时！请重新注册。');
    if ($_POST['code'] != $_SESSION['register_user']['check_code'])
        json_return(1006, '手机验证码错误，请查收我们发到您手机上的短信。如果没有收到，请点击重发短信！');

    $add_result = add_user($_SESSION['register_user']);
    if ($add_result['err_code'] == 0) {
        unset($_SESSION['register_user']);
        //json_return(0,'注册成功！');
        echo json_encode(array('status' => true, 'msg' => '注册成功', 'data' => array('nexturl' => option('config.site_url'))));
    } else {
        json_return($add_result['err_code'], $add_result['err_msg']);
    }
} else if ($action == 'logout') {
    unset($_SESSION['user']);
    session_destroy();
    redirect('./account.php');
} else {
    if (IS_POST) {
//        $phone = isset($_POST['phone']) ? $_POST['phone'] : json_return(1006, '请输入手机号码！', 'phone');
//        $password = isset($_POST['password']) ? $_POST['password'] : json_return(1008, '请输入密码！', 'password');

        $phone = $_POST['phone'];
        $password = $_POST['password'];

        $database_user = M('User');
        $get_result = $database_user->get_user('phone', $phone);
        if ($get_result['err_code'] < 0) {
            //json_return(1009, '系统内部错误！请重试。', 'password');
            echo json_encode(array('status' => false, 'msg' => '系统内部错误！请重试！'));
            exit;
        }

        if ($get_result['err_code'] > 0) {
            //json_return($get_result['err_code'], $get_result['err_msg']);
            echo json_encode(array('status' => false, 'msg' => $get_result["err_msg"]));
            exit;
        }

        if (empty($get_result['user'])) {
            //json_return(1010, '用户不存在！');
            echo json_encode(array('status' => false, 'msg' => '用户不存在！'));
            exit;
        }

        if ($get_result['user']['password'] != md5($password)) {
            //json_return(1011, '密码不正确！', 'password');
            echo json_encode(array('status' => false, 'msg' => '密码不正确！'));
            exit;
        }


        $save_result = $database_user->save_user(array('uid' => $get_result['user']['uid']), array('login_count' => $get_result['user']['login_count'] + 1, 'last_time' => $_SERVER['REQUEST_TIME'], 'last_ip' => ip2long(get_client_ip())));
        if ($save_result['err_code'] < 0) {
            //json_return(1009, '系统内部错误！请重试。', 'password');
            echo json_encode(array('status' => false, 'msg' => '系统内部错误！请重试。'));
            exit;
        }
        if ($save_result['err_code'] > 0) {
            //json_return($save_result['err_code'], $save_result['err_msg']);
            echo json_encode(array('status' => false, 'msg' => $save_result['err_msg']));
            exit;
        }

        $_SESSION['user'] = $get_result['user'];
        //json_return(0,'登录成功！');
        echo json_encode(array('status' => true, 'msg' => '登录成功', 'data' => array('nexturl' => './user.php?c=store&a=select')));
    } else {
        if (!empty($_SESSION['user']))
            redirect(url('user:store:select'));
        include display('user:account:login');
    }
}

function add_user($user) {
    $add_result = M('User')->add_user($user);
    if ($add_result['err_code'] == 0) {
        $_SESSION['user'] = $add_result['err_msg'];
    }
    return $add_result;
}

echo ob_get_clean();
?>