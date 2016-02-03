<?php
//狗扑源码社区 www.gope.cn
class Yeepay
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
		if (empty($this->pay_config['pay_yeepay_merchantaccount']) || empty($this->pay_config['pay_yeepay_merchantprivatekey']) || empty($this->pay_config['pay_yeepay_merchantpublickey']) || empty($this->pay_config['pay_yeepay_yeepaypublickey']) || empty($this->pay_config['pay_yeepay_productcatalog'])) {
			return array('err_code' => 1, 'err_msg' => '易宝支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}

		import('source.class.pay.Yeepay.yeepayMPay');
		$yeepay = new yeepayMPay($this->pay_config['pay_yeepay_merchantaccount'], $this->pay_config['pay_yeepay_merchantpublickey'], $this->pay_config['pay_yeepay_merchantprivatekey'], $this->pay_config['pay_yeepay_yeepaypublickey']);
		$order_id = $this->order_info['trade_no'];
		$transtime = $_SERVER['REQUEST_TIME'];
		$product_catalog = $this->pay_config['pay_yeepay_productcatalog'];
		$identity_id = session_id();
		$identity_type = 0;
		$user_ip = $_SERVER['REMOTE_ADDR'];
		$user_ua = $_SERVER['HTTP_USER_AGENT'];
		$callbackurl = option('config.wap_site_url') . '/paynotice.php?pay_type=yeepay';
		$fcallbackurl = option('config.wap_site_url') . '/paycallback.php?orderno=' . $this->order_info['order_no_txt'];
		$product_name = '订单号：' . $this->order_info['order_no_txt'];
		$product_desc = '订单号：' . $this->order_info['order_no_txt'] . '；订单数量：' . $this->order_info['pro_num'];
		$other = '';
		$amount = floatval($this->order_info['total'] * 100);
		$url = $yeepay->webPay($order_id, $transtime, $amount, $product_catalog, $identity_id, $identity_type, $user_ip, $user_ua, $callbackurl, $fcallbackurl, $currency = 156, $product_name, $product_desc, $other);
		return array('err_code' => 0, 'url' => $url);
	}

	public function notice()
	{
		if (empty($this->pay_config['pay_yeepay_merchantaccount']) || empty($this->pay_config['pay_yeepay_merchantprivatekey']) || empty($this->pay_config['pay_yeepay_merchantpublickey']) || empty($this->pay_config['pay_yeepay_yeepaypublickey']) || empty($this->pay_config['pay_yeepay_productcatalog'])) {
			return array('err_code' => 1, 'err_msg' => '易宝支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}

		import('source.class.pay.Yeepay.yeepayMPay');
		$yeepay = new yeepayMPay($this->pay_config['pay_yeepay_merchantaccount'], $this->pay_config['pay_yeepay_merchantpublickey'], $this->pay_config['pay_yeepay_merchantprivatekey'], $this->pay_config['pay_yeepay_yeepaypublickey']);

		try {
			$return = $yeepay->callback($_POST['data'], $_POST['encryptkey']);
			$order_param['trade_no'] = $return['orderid'];
			$order_param['pay_type'] = 'yeepay';
			$order_param['third_id'] = $return['yborderid'];
			$order_param['pay_money'] = $return['amount'] / 100;
			$order_param['third_data'] = $return;
			return array('err_code' => 0, 'order_param' => $order_param);
		}
		catch (yeepayMPayException $e) {
			return array('err_code' => 1, 'err_msg' => '支付时发生错误！<br/>错误提示：' . $e->GetMessage() . '<br/>错误代码：' . $e->Getcode());
		}
	}
}


?>
