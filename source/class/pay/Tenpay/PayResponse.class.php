<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
require_once 'common/CommonResponse.class.php';
class PayResponse extends CommonResponse
{
	public $NOTIFYID = 'notify_id';

	public function PayResponse($secretKey)
	{
		try {
			unset($this->parameters);
			$this->secretKey = $secretKey;

			foreach ($_GET as $k => $v) {
				$this->setParameter($k, $v);
			}

			foreach ($_POST as $k => $v) {
				$this->setParameter($k, $v);
			}

			$this->CommonResponse($this->parameters, $this->secretKey, false);
		}
		catch (SDKRuntimeException $e) {
			exit($e->errorMessage());
		}

		$this->NOTIFYID = $this->getParameter('notify_id');
		unset($this->parameters);
	}

	public function acknowledgeSuccess()
	{
		echo 'success';
		return true;
	}

	public function getNotifyId()
	{
		return $this->NOTIFYID;
	}
}

?>
