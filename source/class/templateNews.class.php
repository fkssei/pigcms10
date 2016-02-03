<?php
class templateNews{

	public function __construct(){
        import('source.class.checkFunc');
$checkFunc=new checkFunc();
if (!function_exists('fdsrejsie3qklwewerzdagf4ds')){exit('error-4');}
$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
	}


	public function sendTempMsg($tempKey, $dataArr)
	{
		$store_id 	= $_SESSION['tmp_store_id'];
		$dbinfo = D('Tempmsg')->where(array('tempkey'=>"$tempKey"))->find();
		if ($dbinfo['status']) {
			//	获取access_token  $json->access_token
			$access_token_array = M('Weixin_bind')->get_access_token($store_id);
			if ($access_token_array['errcode']) {
				exit('获取access_token发生错误：错误代码' . $access_token_array['errcode'] .',微信返回错误信息：' . $access_token_array['errmsg']);
			}
			$access_token = $access_token_array['access_token'];

			// 准备发送请求的数据 
			$requestUrl = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
	
			$data = $this->getData($tempKey,$dataArr,$dbinfo['textcolor']);
			//dump($tempKey);
			//dump($data);die;
			$sendData = '{"touser":"'.$dataArr["wecha_id"].'","template_id":"'.$dbinfo["tempid"].'","url":"'.$dataArr["href"].'","topcolor":"'.$dbinfo["topcolor"].'","data":'.$data.'}';

			$this->postCurl($requestUrl,$sendData);
		}
	}

// Get Data.data
	public function getData($key,$dataArr,$color){


		$tempsArr = $this->templates();

		$data = $tempsArr["$key"]['vars'];
		$data = array_flip($data);
        $jsonData = '';
		foreach($dataArr as $k => $v){
			if(in_array($k,array_flip($data))){
				$jsonData .= '"'.$k.'":{"value":"'.$v.'","color":"'.$color.'"},';
			}
		}

		$jsonData = rtrim($jsonData,',');

		return "{".$jsonData."}"; 
	}

	
	public function templates(){

		return array(

            'OPENTM201752540' => array(
                'name'    => '订单支付成功通知',
                'vars'    => array('first', 'keyword1', 'keyword2', 'keyword3', 'keyword4', 'remark'),
                'content' => '
{{first.DATA}}
订单商品：{{keyword1.DATA}}
订单编号：{{keyword2.DATA}}
支付金额：{{keyword3.DATA}}
支付时间：{{keyword4.DATA}}
{{remark.DATA}}'),

            'OPENTM205213550' => array(
                'name'    => '订单生成通知',
                'vars'    => array('first', 'keyword1', 'keyword2', 'keyword3', 'remark'),
                'content' => '
{{first.DATA}}
时间：{{keyword1.DATA}}
商品名称：{{keyword2.DATA}}
订单号：{{keyword3.DATA}}
{{remark.DATA}}'),

            'OPENTM202521011' => array(
                'name'    => '订单完成通知',
                'vars'    => array('first', 'keyword1', 'keyword2', 'remark'),
                'content' => '
{{first.DATA}}
订单号：{{keyword1.DATA}}
完成时间：{{keyword2.DATA}}
{{remark.DATA}}'),

            'OPENTM206547887' => array(
                'name'    => '分销订单通知',
                'vars'    => array('first', 'keyword1', 'keyword2', 'keyword3', 'keyword4', 'keyword5', 'remark'),
                'content' => '
{{first.DATA}}
订单编号：{{keyword1.DATA}}
商品名称：{{keyword2.DATA}}
下单时间：{{keyword3.DATA}}
下单金额：{{keyword4.DATA}}
分销商名称：{{keyword5.DATA}}
{{remark.DATA}}'),

            'OPENTM206328960' => array(
                'name'    => '分销订单支付成功通知',
                'vars'    => array('first', 'keyword1', 'keyword2', 'keyword3', 'remark'),
                'content' => '
{{first.DATA}}
商品名称：{{keyword1.DATA}}
商品佣金：{{keyword2.DATA}}
订单状态：{{keyword3.DATA}}
{{remark.DATA}}'),

            'OPENTM206328970' => array(
                'name'    => '分销订单下单成功通知',
                'vars'    => array('first', 'keyword1', 'keyword2', 'keyword3', 'keyword4', 'remark'),
                'content' => '
{{first.DATA}}
商品名称：{{keyword1.DATA}}
商品佣金：{{keyword2.DATA}}
下单时间：{{keyword3.DATA}}
订单状态：{{keyword4.DATA}}
{{remark.DATA}}'),

            'OPENTM220197216' => array(
                'name'    => '分销订单提成通知',
                'vars'    => array('first', 'keyword1', 'keyword2', 'keyword3', 'keyword4', 'remark'),
                'content' => '
{{first.DATA}}
订单号：{{keyword1.DATA}}
订单金额：{{keyword2.DATA}}
分成金额：{{keyword3.DATA}}
时间：{{keyword4.DATA}}
{{remark.DATA}}'),

            'OPENTM207126233' => array(
                'name'    => '分销商申请成功提醒',
                'vars'    => array('first', 'keyword1', 'keyword2', 'keyword3', 'remark'),
                'content' => '
{{first.DATA}}
分销商名称：{{keyword1.DATA}}
分销商电话：{{keyword2.DATA}}
申请时间：{{keyword3.DATA}}
{{remark.DATA}}')

		);
	}

// Post Request// 支付方式：{{keyword4.DATA}}
	function postCurl($url, $data){
		$ch = curl_init();
		$header = array("Accept-Charset: utf-8");
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);
		$errorno=curl_errno($ch);

		if ($errorno) {
			return array('rt'=>false,'errorno'=>$errorno);
		}else{
			$js=json_decode($tmpInfo,1);
			if ($js['errcode']=='0'){
				return array('rt'=>true,'errorno'=>0);
			}else {
				//exit('模板消息发送失败。错误代码'.$js['errcode'].',错误信息：'.$js['errmsg']);
				return array('rt'=>false,'errorno'=>$js['errcode'],'errmsg'=>$js['errmsg']);

			}
		}
	}




// Get Access_token Request
	function curlGet($url){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}



}