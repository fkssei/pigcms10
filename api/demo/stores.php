<?php
    header("Content-Type: text/html;charset='UTF-8'");

    $data = array(
        'token'      => 'ejbeia1419231799',
        'site_url'   => 'http://www.pigcms.com'
    );
    $sort_data = $data;
    $sort_data['salt'] = 'pigcms';
    ksort($sort_data);
    $sign_key = sha1(http_build_query($sort_data));
    $data['sign_key'] = $sign_key;
    $data['request_time'] = time();
    $request_url = "http://www.weidian.com/api/store.php";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $json = curl_exec($ch);
    $arr = json_decode($json, true);
    print_r($arr);
?>