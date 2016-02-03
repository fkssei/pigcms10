<?php
    header("Content-Type: text/html;charset='UTF-8'");

    $data = array(
        'token'      => 'ejbeia1419231799',
        'site_url'   => 'http://www.pigcms.com',
        'timestamp'  => time(),
        'wxname'     => '12345678900',
        'server_key' => 'KKgybUkzUqrBGwCTgnAhKmqJmrzfZajJUnZenBZEVQN'
    );
    $sort_data = $data;
    ksort($sort_data);
    $sign_key = sha1(http_build_query($sort_data));
    $data['sign_key'] = $sign_key;
    $data['request_time'] = time();
    $request_url = "http://www.weidian.com/api/oauth.php";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $json = curl_exec($ch);
    $arr = json_decode($json, true);
    $return_url = $arr['return_url'];
    if (empty($arr['error_code']) && !empty($arr['return_url'])) {
        header('Location:' . $return_url);
    } else {
        echo $arr['error_msg'];
    }

?>