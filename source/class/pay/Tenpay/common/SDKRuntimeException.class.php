<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class SDKRuntimeException extends Exception
{
	public function errorMessage()
	{
		return $this->getMessage();
	}
}

?>
