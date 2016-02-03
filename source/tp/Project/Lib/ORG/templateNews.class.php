<?php
//狗扑源码社区 www.gope.cn
class templateNews
{
	public $thisWxUser;
	public $appid;
	public $appsecret;

	public function __construct($appid = NULL, $appsecret = NULL)
	{
		$this->appid = $appid;
		$this->appsecret = $appsecret;
	}

	public function sendTempMsg($tempKey, $dataArr)
	{
		$dbinfo = M('Tempmsg')->where(array('tempkey' => $tempKey))->find();

		if ($dbinfo['status']) {
			$access_token_array = D('Access_token_expires')->get_access_token();

			if ($access_token_array['errcode']) {
				exit('获取access_token发生错误：错误代码' . $access_token_array['errcode'] . ',微信返回错误信息：' . $access_token_array['errmsg']);
			}

			$access_token = $access_token_array['access_token'];
			$requestUrl = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;
			$data = $this->getData($tempKey, $dataArr, $dbinfo['textcolor']);
			$sendData = '{"touser":"' . $dataArr['wecha_id'] . '","template_id":"' . $dbinfo['tempid'] . '","url":"' . $dataArr['href'] . '","topcolor":"' . $dbinfo['topcolor'] . '","data":' . $data . '}';
			$this->postCurl($requestUrl, $sendData);
		}
	}

	public function getData($key, $dataArr, $color)
	{
		$tempsArr = $this->templates();
		$data = $tempsArr[$key]['vars'];
		$data = array_flip($data);
		$jsonData = '';

		foreach ($dataArr as $k => $v) {
			if (in_array($k, array_flip($data))) {
				$jsonData .= '"' . $k . '":{"value":"' . $v . '","color":"' . $color . '"},';
			}
		}

		$jsonData = rtrim($jsonData, ',');
		return '{' . $jsonData . '}';
	}

	public function templates()
	{
		return array(
	'OPENTM201752540' => array(
		'name'    => '订单支付成功通知',
		'vars'    => array('first', 'keyword1', 'keyword2', 'keyword3', 'keyword4', 'remark'),
		'content' => '' . "\r\n" . '{{first.DATA}}' . "\r\n" . '订单商品：{{keyword1.DATA}}' . "\r\n" . '订单编号：{{keyword2.DATA}}' . "\r\n" . '支付金额：{{keyword3.DATA}}' . "\r\n" . '支付时间：{{keyword4.DATA}}' . "\r\n" . '{{remark.DATA}}'
		),
	'OPENTM201682460' => array(
		'name'    => '订单生成通知',
		'vars'    => array('first', 'keyword1', 'keyword2', 'keyword3', 'remark'),
		'content' => '' . "\r\n" . '{{first.DATA}}' . "\r\n" . '时间：{{keyword1.DATA}}' . "\r\n" . '商品名称：{{keyword2.DATA}}' . "\r\n" . '订单号：{{keyword3.DATA}}' . "\r\n" . '{{remark.DATA}}'
		),
	'TM00356'         => array(
		'name'    => '待办工作提醒',
		'vars'    => array('first', 'work', 'remark'),
		'content' => '' . "\r\n" . '{{first.DATA}}' . "\r\n" . '待办工作：{{work.DATA}}' . "\r\n" . '{{remark.DATA}}'
		),
	'OPENTM202521011' => array(
		'name'    => '订单完成通知',
		'vars'    => array('first', 'keyword1', 'keyword2', 'remark'),
		'content' => '' . "\r\n" . '{{first.DATA}}' . "\r\n" . '订单号：{{keyword1.DATA}}' . "\r\n" . '完成时间：{{keyword2.DATA}}' . "\r\n" . '{{remark.DATA}}'
		)
	);
	}

	public function postCurl($url, $data)
	{
		$ch = curl_init();
		$header = 'Accept-Charset: utf-8';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);
		$errorno = curl_errno($ch);

		if ($errorno) {
			return array('rt' => false, 'errorno' => $errorno);
		}
		else {
			$js = json_decode($tmpInfo, 1);

			if ($js['errcode'] == '0') {
				return array('rt' => true, 'errorno' => 0);
			}
			else {
				return array('rt' => false, 'errorno' => $js['errcode'], 'errmsg' => $js['errmsg']);
			}
		}
	}

	public function curlGet($url)
	{
		$ch = curl_init();
		$header = 'Accept-Charset: utf-8';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}
}


?>
