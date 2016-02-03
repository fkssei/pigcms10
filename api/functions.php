<?php
if(option('config.weidian_key')){
	define('SIGN_SALT', option('config.weidian_key'));
}else{
	defined('SIGN_SALT') or define('SIGN_SALT', 'pigcms');
}

//签名校验
function _checkSign($sign_key, $data)
{
    ksort($data);
    $new_sign_key = sha1(http_build_query($data));
    return $sign_key == $new_sign_key;
}

//用户注册
function _register($data)
{
    $user = M('User');
    return $user->addUser($data);
}