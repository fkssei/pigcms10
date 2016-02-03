<?php
    header("Content-Type: text/html;charset='UTF-8'");

    $arr = array(
        'wecha_id' => '',
        'token' => 'njwvmx1426578883',
        'wechaname' => '',
        'portrait' => '',
        'tel' => '',
        'address' => ''
    );
    $arr['salt'] = 'pigcms';
    ksort($arr);
    echo $sign_key = sha1(http_build_query($arr));
exit;
    $data = array(
        'wecha_id'   => '123456789',
        'token'      => 'ejbeia1419231799',
        'wechaname'  => '',
        'portrait'   => '',
        'tel'        => '',
        'address'    => ''
    );
    $sort_data = $data;
    $sort_data['salt'] = 'pigcms';
    ksort($sort_data);
    $sign_key = sha1(http_build_query($sort_data));
    $data['sign_key'] = $sign_key;
    $data['request_time'] = time();
    $request_url = "http://www.weidian.com/api/fans.php";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    echo $json = curl_exec($ch);exit;
    $arr = json_decode($json, true);
    $return_url = $arr['return_url'];
    if (empty($arr['error_code']) && !empty($arr['return_url'])) {
        header('Location:' . $return_url);
    } else {
        echo $arr['error_msg'];
    }

?>