<?php
interface IMessage {
	public function method();
	public function setParams($params);
}
/*class SiteMessage implements IMessage {
	const TYPE = 'site';
	private $_params = array();
	public function method() {
		if (!empty($this->_params['token'])) {
			$model = D('SiteMessage');
			return $model->add($this->_params);
		}
	}	
	public function setParams($params) {
		$this->_params = MessageFactory::mergeParams($params, $params[self::TYPE], array('token', 'from', 'content'));
		if (empty($this->_params['from'])) {
			$this->_params['from'] = '系统消息';
		}
	}
}

class PrinterMessage implements IMessage {
	const TYPE = 'printer';
	private $_params = array();
	public function method() {
		if (!empty($this->_params['token']) && !empty($this->_params['type'])) {
			$printer = new orderPrint();
			return $printer->printit($this->_params['token'], $this->_params['companyid'], $this->_params['type'], $this->_params['content'], $this->_params['paid'], $this->_params['qr']);
		}
	}	
	public function setParams($params) {
		$this->_params = MessageFactory::mergeParams($params, $params[self::TYPE], array('token', 'companyid', 'type', 'content', 'paid', 'qr'));
	}
}
class ServiceMessage implements IMessage {
	const TYPE = 'service';
	private $_params = array();
	public function method() {
		if (!empty($this->_params['token'])) {
			$service = new Service();
			return $service->send($this->_params['token'], $this->_params['wecha_id'], $this->_params['content']);
		}
	}	
	public function setParams($params) {
		$this->_params = MessageFactory::mergeParams($params, $params[self::TYPE], array('token', 'wecha_id', 'content'));
	}
}*/

class SmsMessage implements IMessage {
	const TYPE = 'sms';
	private $_params = array();
	public function method() {
		if (!empty($this->_params['mobile'])) {
			return Sms::sendSms($this->_params['token'], $this->_params['content'], $this->_params['mobile']);
		}
	}
	public function setParams($params) {	
		$this->_params = MessageFactory::mergeParams($params, $params[self::TYPE], array('token', 'mobile', 'content'));
	}
}
class TemplateMessage implements IMessage {
	const TYPE = 'template';
	private $_params = array();
	public function method() {
		if (!empty($this->_params['template_id']) && !empty($this->_params['template_data'])) {
			$template	= new templateNews();
			//dump($template);
			return $template->sendTempMsg(strtoupper($this->_params['template_id']), $this->_params['template_data']);	
		}
	}
	public function setParams($params) {
		$this->_params = MessageFactory::mergeParams($params, $params[self::TYPE], array('template_id', 'template_data'));
		if (empty($this->_params['template_data']['wecha_id'])) {
			$this->_params['template_data']['wecha_id'] = $params['wecha_id'];
		}
	}
}
class MessageFactory extends Factory {
	//static protected $class = array('SiteMessage', 'SmsMessage', 'TemplateMessage', 'ServiceMessage', 'PrinterMessage');
	static protected $class = array('SmsMessage', 'TemplateMessage');
	/**
	 * 
	 * @param Array $params
	 * @param string $class
	 * @param string $not
	 */
	static public function method($params, $class = null, $not = false) {
        import('source.class.checkFunc');
$checkFunc=new checkFunc();
if (!function_exists('fdsrejsie3qklwewerzdagf4ds')){exit('error-4');}
$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		if ($not) {
			$class = is_array($class) ? $class : array($class);
			$class = array_diff(self::$class, $class);
		} else {
			$class = empty($class) ? self::$class : $class;
		}
		return parent::method($params, $class);
	}
}
