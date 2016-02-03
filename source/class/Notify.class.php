<?php
/**
 * 提醒
 */
class Notify {
	static public function alert($msg) {
		if (empty($msg)) {
			return;
		}
		
		// 未交易提醒逻辑处理
		//error_log('alert');
	}
	
	/**
	 * 店铺产生订单后进行提醒操作
	 */
	static public function createNoitfy($store_id, $order_id) {
        return;
		// 各种提醒参数没有直接跳出
		if (empty($store_id) || empty($order_id)) {
			return;
		}
		
		$appid = option('config.notify_appid');
		$key = option('config.notify_appkey');

		if (empty($appid) || empty($key)) {
			return;
		}
		
		$trade_setting_model = M('Trade_setting');
		$trade_setting = $trade_setting_model->get_setting($store_id);
		
		// 店铺没有设置提醒，直接跳出
		if (empty($trade_setting)) {
			return;
		}
		
		// 没有提醒时间，直接跳出
		if (empty($trade_setting['pay_cancel_time']) && empty($trade_setting['pay_alert_time'])) {
			return;
		}
		
		$data = array();
		$data['order_id'] = $order_id;
		$data['alert_time'] = $trade_setting['pay_alert_time'];
		$data['cancel_time'] = $trade_setting['pay_cancel_time'];
		$data['domain'] = option('config.site_url');
		$data['appid'] = $appid;
		$md5 = Notify::encrypt_key($data, $key);
		
		// 提醒订单服务器地址
		$scheme = 'http://';
		$host = 'www.weidian.com';
		$params = '/notify/create_notify.php?order_id=' . $order_id . '&alert_time=' . $trade_setting['pay_alert_time'] . '&cancel_time=' . $trade_setting['pay_cancel_time'] . '&domain=' . option('config.site_url') . '&appid=' . $appid . '&auth_key=' . $md5;
		$url = $scheme . $host . $params;
		
		// 服务器通知
		Notify::fsock($host, $params);
		//Notify::getCurl($url);
		return;
	}
	
	// 用curl来通知，此方法需要等待1秒钟，对方服务器
	static public function getCurl($url) {
		$ch = curl_init();
		$headers[] = "Accept-Charset:utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		
		//获得内容
		$result = curl_exec($ch);
		
		//关闭curl
		curl_close($ch);
	}
	
	// 用socket来通知,无须等待对方服务器响影
	static public function fsock($host, $params = '') {
		$fp = fsockopen($host, 80, $errno, $errstr, 30);
		if (!$fp) {
			echo "$errstr ($errno)<br />\n";
		} else {
			$out = "Host: $host\r\n";
			$out .= "Connection: Close\r\n\r\n";
			fputs($fp,"GET $params HTTP/1.0\r\n");
			fwrite($fp, $out);
			
			stream_set_blocking($fp, true);   //重要，设置为非阻塞模式
			stream_set_timeout($fp, 1);
			fclose($fp);
		}
	}
	
	// 获得加密串
	static public function encrypt_key($array, $app_key) {
		$new_arr = array();
		ksort($array);
		foreach($array as $key=>$value) {
			$new_arr[] = $key . '=' . $value;
		}
		$new_arr[] = 'app_key=' . $app_key;
		
		$string = implode('&', $new_arr);
		return md5($string);
	}
}