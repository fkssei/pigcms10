<?php
//dezend by http://www.yunlu99.com/ QQ:270656184
class controller
{
	public $arrays = array();
	public $config;
	public $_G;

	public function __construct()
	{
		import('source.class.checkFunc');
		$checkFunc = new checkFunc();

		if (!function_exists('fdsrejsie3qklwewerzdagf4ds')) {
			exit('error-4');
		}

		$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
	}

	public function assign($field, $value = '')
	{
		if (!empty($value)) {
			$this->arrays[$field] = $value;
		}
		else if (is_array($field)) {
			foreach ($field as $key => $value) {
				$this->arrays[$key] = $value;
			}
		}
		else {
			$this->arrays[$field] = $value;
		}
	}

	public function display($tpl = '')
	{
		foreach ($this->arrays as $key => $value) {
			$$key = $value;
		}

		include display($tpl);
	}

	public function clear_html($array, $exception = '')
	{
		$exception = explode(',', $exception);

		foreach ($array as $key => $value) {
			if (in_array($key, $exception)) {
				$array[$key] = stripslashes($value);
			}
			else {
				$array[$key] = trim(htmlspecialchars($value));
			}
		}

		return $array;
	}
}


?>
