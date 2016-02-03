<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class XMLParse
{
	public function extract($xmltext)
	{
		try {
			$xml = new DOMDocument();
			$xml->loadXML($xmltext);
			$array_e = $xml->getElementsByTagName('Encrypt');
			$array_a = $xml->getElementsByTagName('ToUserName');
			$encrypt = $array_e->item(0)->nodeValue;
			$tousername = $array_a->item(0)->nodeValue;
			return array(0, $encrypt, $tousername);
		}
		catch (Exception $e) {
			print($e . "\n");
			return array(ErrorCode::$ParseXmlError, NULL, NULL);
		}
	}

	public function generate($encrypt, $signature, $timestamp, $nonce)
	{
		$format = '<xml>' . "\r\n" . '<Encrypt><![CDATA[%s]]></Encrypt>' . "\r\n" . '<MsgSignature><![CDATA[%s]]></MsgSignature>' . "\r\n" . '<TimeStamp>%s</TimeStamp>' . "\r\n" . '<Nonce><![CDATA[%s]]></Nonce>' . "\r\n" . '</xml>';
		return sprintf($format, $encrypt, $signature, $timestamp, $nonce);
	}
}

include_once 'errorCode.php';

?>
