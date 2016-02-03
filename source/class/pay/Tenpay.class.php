<?php
//狗扑源码社区 www.gope.cn
class Tenpay
{
	protected $order_info;
	protected $pay_config;
	protected $user_info;

	public function __construct($order_info, $pay_config, $user_info)
	{
		import('source.class.checkFunc');
		$checkFunc = new checkFunc();

		if (!function_exists('fdsrejsie3qklwewerzdagf4ds')) {
			exit('error-4');
		}

		$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$this->order_info = $order_info;
		$this->pay_config = $pay_config;
		$this->user_info = $user_info;
	}

	public function pay()
	{
		if (empty($this->pay_config['pay_tenpay_partnerid']) || empty($this->pay_config['pay_tenpay_partnerkey'])) {
			return array('err_code' => 1, 'err_msg' => '财付通支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}

		import('source.class.pay.Tenpay.RequestHandler');
		import('source.class.pay.Tenpay.client.ClientResponseHandler');
		import('source.class.pay.Tenpay.client.TenpayHttpClient');
		$reqHandler = new RequestHandler();
		$reqHandler->init();
		$reqHandler->setKey($this->pay_config['pay_tenpay_partnerkey']);
		$reqHandler->setGateUrl('http://wap.tenpay.com/cgi-bin/wappayv2.0/wappay_init.cgi');
		$httpClient = new TenpayHttpClient();
		$resHandler = new ClientResponseHandler();
		$callback_url = option('config.wap_site_url') . '/paycallback.php?orderno=' . $this->order_info['order_no_txt'];
		$notify_url = option('config.wap_site_url') . '/paynotice.php';
		$desc = '订单号：' . $this->order_info['order_no_txt'] . '；订单数量：' . $this->order_info['pro_num'];
		$reqHandler->setParameter('total_fee', floatval($this->order_info['total'] * 100));
		$reqHandler->setParameter('spbill_create_ip', $_SERVER['REMOTE_ADDR']);
		$reqHandler->setParameter('ver', '2.0');
		$reqHandler->setParameter('bank_type', '0');
		$reqHandler->setParameter('callback_url', $callback_url);
		$reqHandler->setParameter('bargainor_id', $this->pay_config['pay_tenpay_partnerid']);
		$reqHandler->setParameter('sp_billno', $this->order_info['trade_no']);
		$reqHandler->setParameter('notify_url', $notify_url);
		$reqHandler->setParameter('desc', $desc);
		$reqHandler->setParameter('attach', 'tenpay');
		$httpClient->setReqContent($reqHandler->getRequestURL());

		if ($httpClient->call()) {
			$resHandler->setContent($httpClient->getResContent());

			if ($resHandler->parameters['err_info']) {
				return array('err_code' => 1, 'err_msg' => '财付通异常返回：<b>' . $resHandler->parameters['err_info'] . '</b>');
			}

			$token_id = $resHandler->getParameter('token_id');
			$reqHandler->setParameter('token_id', $token_id);
			$reqUrl = 'http://wap.tenpay.com/cgi-bin/wappayv2.0/wappay_gate.cgi?token_id=' . $token_id;
			return array('err_code' => 0, 'url' => $reqUrl);
		}
		else {
			return array('err_code' => 1, 'err_msg' => '财付通信息校验失败，请重试。');
		}
	}

	public function notice()
	{
		if (empty($this->pay_config['pay_tenpay_partnerid']) || empty($this->pay_config['pay_tenpay_partnerkey'])) {
			return array('err_code' => 1, 'err_msg' => '财付通支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}

		import('source.class.pay.Tenpay.ResponseHandler');
		import('source.class.pay.Tenpay.WapNotifyResponseHandler');
		$resHandler = new WapNotifyResponseHandler();
		$resHandler->setKey($this->pay_config['pay_tenpay_partnerkey']);

		if ($resHandler->isTenpaySign()) {
			$order_param['trade_no'] = $resHandler->getParameter('sp_billno');
			$order_param['pay_type'] = 'tenpay';
			$order_param['third_id'] = $resHandler->getParameter('transaction_id');
			$pay_money = $resHandler->getParameter('total_fee');
			$order_param['pay_money'] = $pay_money / 100;
			$pay_result = $resHandler->getParameter('pay_result');

			if ('0' == $pay_result) {
				$order_param['third_data'] = array('transaction_id' => $resHandler->getParameter('transaction_id'), 'total_fee' => $resHandler->getParameter('total_fee'), 'fee_type' => $resHandler->getParameter('fee_type'), 'bargainor_id' => $resHandler->getParameter('bargainor_id'), 'bank_type' => $resHandler->getParameter('bank_type'), 'bank_billno' => $resHandler->getParameter('bank_billno'), 'purchase_alias' => $resHandler->getParameter('purchase_alias'));
				return array('err_code' => 0, 'order_param' => $order_param);
			}
			else {
				exit('fail');
			}
		}
		else {
			exit('fail');
		}
	}
}


?>
