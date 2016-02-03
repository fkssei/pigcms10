<?php
//狗扑源码社区 www.gope.cn
class Weixin
{
	protected $order_info;
	protected $pay_config;
	protected $user_info;
	protected $openid;

	public function __construct($order_info, $pay_config, $user_info, $openid)
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
		$this->openid = $openid;
	}

	public function pay()
	{
		if (empty($this->pay_config['pay_weixin_appid']) || empty($this->pay_config['pay_weixin_mchid']) || empty($this->pay_config['pay_weixin_key'])) {
			return array('err_code' => 1, 'err_msg' => '微信支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}

		if (empty($this->openid)) {
			return array('err_code' => 1, 'err_msg' => '没有获取到用户的微信资料，无法使用微信支付');
		}

		import('source.class.pay.Weixinnewpay.WxPayPubHelper');
		$jsApi = new JsApi_pub($this->pay_config['pay_weixin_appid'], $this->pay_config['pay_weixin_mchid'], $this->pay_config['pay_weixin_key']);
		$unifiedOrder = new UnifiedOrder_pub($this->pay_config['pay_weixin_appid'], $this->pay_config['pay_weixin_mchid'], $this->pay_config['pay_weixin_key']);
		$unifiedOrder->setParameter('openid', $this->openid);
		$unifiedOrder->setParameter('body', $this->order_info['order_no_txt']);
		$unifiedOrder->setParameter('out_trade_no', $this->order_info['trade_no']);
		$unifiedOrder->setParameter('total_fee', floatval($this->order_info['total'] * 100));
		$unifiedOrder->setParameter('notify_url', option('config.wap_site_url') . '/paynotice.php');
		$unifiedOrder->setParameter('trade_type', 'JSAPI');
		$unifiedOrder->setParameter('attach', 'weixin');
		$prepay_result = $unifiedOrder->getPrepayId();

		if ($prepay_result['return_code'] == 'FAIL') {
			return array('err_code' => 1, 'err_msg' => '没有获取微信支付的预支付ID，请重新发起支付！<br/><br/>微信支付错误返回：' . $prepay_result['return_msg']);
		}

		if ($prepay_result['err_code']) {
			return array('err_code' => 1, 'err_msg' => '没有获取微信支付的预支付ID，请重新发起支付！<br/><br/>微信支付错误返回：' . $prepay_result['err_code_des']);
		}

		$jsApi->setPrepayId($prepay_result['prepay_id']);
		return array('err_code' => 0, 'pay_data' => $jsApi->getParameters());
	}

	public function notice()
	{
		$array_data = json_decode(json_encode(simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA)), true);

		if ($array_data) {
			$nowOrder = D('Order')->field('`store_id`,`useStorePay`,`storeOpenid`')->where(array('trade_no' => $array_data['out_trade_no']))->find();

			if ($nowOrder['useStorePay']) {
				$weixin_bind_info = D('Weixin_bind')->where(array('store_id' => $nowOrder['store_id']))->find();
				if (empty($weixin_bind_info) || empty($weixin_bind_info['wxpay_mchid']) || empty($weixin_bind_info['wxpay_key'])) {
					return array('err_code' => 1, 'err_msg' => '商家未配置正确微信支付');
				}

				$this->pay_config = array('pay_weixin_appid' => $weixin_bind_info['authorizer_appid'], 'pay_weixin_mchid' => $weixin_bind_info['wxpay_mchid'], 'pay_weixin_key' => $weixin_bind_info['wxpay_key']);
			}
		}

		if (empty($this->pay_config['pay_weixin_appid']) || empty($this->pay_config['pay_weixin_mchid']) || empty($this->pay_config['pay_weixin_key'])) {
			return array('err_code' => 1, 'err_msg' => '微信支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}

		import('source.class.pay.Weixinnewpay.WxPayPubHelper');
		$notify = new Notify_pub($this->pay_config['pay_weixin_appid'], $this->pay_config['pay_weixin_mchid'], $this->pay_config['pay_weixin_key']);
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$notify->saveData($xml);

		if ($notify->checkSign() == false) {
			$notify->setReturnParameter('return_code', 'FAIL');
			$notify->setReturnParameter('return_msg', '签名失败');
			return array('err_code' => 1, 'err_msg' => $notify->returnXml());
		}
		else {
			$notify->setReturnParameter('return_code', 'SUCCESS');
			if (($notify->data['return_code'] == 'SUCCESS') && ($notify->data['result_code'] == 'SUCCESS')) {
				$order_param['trade_no'] = $notify->data['out_trade_no'];
				$order_param['pay_type'] = 'weixin';
				$order_param['third_id'] = $notify->data['transaction_id'];
				$order_param['pay_money'] = $notify->data['total_fee'] / 100;
				$order_param['third_data'] = $notify->data;
				$order_param['echo_content'] = $notify->returnXml();
				return array('err_code' => 0, 'order_param' => $order_param);
			}
			else {
				return array('err_code' => 1, 'err_msg' => '支付时发生错误！<br/>错误提示：' . $e->GetMessage() . '<br/>错误代码：' . $e->Getcode());
			}
		}
	}
}


?>
