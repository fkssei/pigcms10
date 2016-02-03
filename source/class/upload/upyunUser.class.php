<?php
//狗扑源码社区 www.gope.cn
class upyunUser
{
	static public function upload($from_file, $target_file)
	{
		if (empty($from_file) || empty($target_file)) {
			return false;
		}

		$unlink = 0;

		if (function_exists('option')) {
			$bucket = option('config.attachment_up_bucket');
			$user = option('config.attachment_up_username');
			$pwd = option('config.attachment_up_password');
			$unlink = option('config.attachment_upload_unlink');
		}
		else {
			$bucket = C('config.attachment_up_bucket');
			$user = C('config.attachment_up_username');
			$pwd = C('config.attachment_up_password');
			$unlink = C('config.attachment_upload_unlink');
		}

		if (empty($bucket) || empty($user) || empty($pwd)) {
			error_log('no auth');
			return false;
		}

		$upyun = new UpYun($bucket, $user, $pwd);

		try {
			error_log($target_file);
			$fh = fopen($from_file, 'rb');
			$rsp = $upyun->writeFile($target_file, $fh, true);
			fclose($fh);

			if ($unlink) {
				@unlink($from_file);
			}

			return true;
		}
		catch (Exception $e) {
			error_log($e->getCode());
			error_log($e->getMessage());
			return false;
		}
	}

	static public function delete($file)
	{
		if (empty($file)) {
			return false;
		}

		if (function_exists('option')) {
			$bucket = option('config.attachment_up_bucket');
			$user = option('config.attachment_up_username');
			$pwd = option('config.attachment_up_password');
			$unlink = option('config.attachment_upload_unlink');
		}
		else {
			$bucket = C('config.attachment_up_bucket');
			$user = C('config.attachment_up_username');
			$pwd = C('config.attachment_up_password');
			$unlink = C('config.attachment_upload_unlink');
		}

		if (empty($bucket) || empty($user) || empty($pwd)) {
			return false;
		}

		if (empty($unlink)) {
			return false;
		}

		$upyun = new UpYun($bucket, $user, $pwd);

		try {
			error_log('upyunUser::delete:' . $file);
			$upyun->delete($file);
		}
		catch (Exception $e) {
			print_r($e);
		}
	}
}

class UpYun
{
	const VERSION = '2.0';
	const ED_AUTO = 'v0.api.upyun.com';
	const ED_TELECOM = 'v1.api.upyun.com';
	const ED_CNC = 'v2.api.upyun.com';
	const ED_CTT = 'v3.api.upyun.com';
	const CONTENT_TYPE = 'Content-Type';
	const CONTENT_MD5 = 'Content-MD5';
	const CONTENT_SECRET = 'Content-Secret';
	const X_GMKERL_THUMBNAIL = 'x-gmkerl-thumbnail';
	const X_GMKERL_TYPE = 'x-gmkerl-type';
	const X_GMKERL_VALUE = 'x-gmkerl-value';
	const X_GMKERL_QUALITY = 'x-gmkerl-quality';
	const X_GMKERL_UNSHARP = 'x-gmkerl-unsharp';

	private $_bucketname;
	private $_username;
	private $_password;
	private $_timeout = 30;
	/**
     * @deprecated
     */
	private $_content_md5;
	/**
     * @deprecated
     */
	private $_file_secret;
	/**
     * @deprecated
     */
	private $_file_infos;
	protected $endpoint;
	/**
     * @var string: UPYUN 请求唯一id, 出现错误时, 可以将该id报告给 UPYUN,进行调试
     */
	private $x_request_id;

	public function __construct($bucketname, $username, $password, $endpoint = NULL, $timeout = 30)
	{
		$this->_bucketname = $bucketname;
		$this->_username = $username;
		$this->_password = md5($password);
		$this->_timeout = $timeout;
		$this->endpoint = is_null($endpoint) ? self::ED_AUTO : $endpoint;
	}

	public function version()
	{
		return self::VERSION;
	}

	public function makeDir($path, $auto_mkdir = false)
	{
		$headers = array('Folder' => 'true');

		if ($auto_mkdir) {
			$headers['Mkdir'] = 'true';
		}

		return $this->_do_request('PUT', $path, $headers);
	}

	public function delete($path)
	{
		return $this->_do_request('DELETE', $path);
	}

	public function writeFile($path, $file, $auto_mkdir = false, $opts = NULL)
	{
		if (is_null($opts)) {
			$opts = array();
		}

		if (!is_null($this->_content_md5) || !is_null($this->_file_secret)) {
			if (!is_null($this->_content_md5)) {
				$opts[self::CONTENT_MD5] = $this->_content_md5;
			}

			if (!is_null($this->_file_secret)) {
				$opts[self::CONTENT_SECRET] = $this->_file_secret;
			}
		}

		if ($auto_mkdir === true) {
			$opts['Mkdir'] = 'true';
		}

		$this->_file_infos = $this->_do_request('PUT', $path, $opts, $file);
		return $this->_file_infos;
	}

	public function readFile($path, $file_handle = NULL)
	{
		return $this->_do_request('GET', $path, NULL, NULL, $file_handle);
	}

	public function getList($path = '/')
	{
		$rsp = $this->_do_request('GET', $path);
		$list = array();

		if ($rsp) {
			$rsp = explode("\n", $rsp);

			foreach ($rsp as $item) {
				@list($name, $type, $size, $time) = explode('	', trim($item));

				if (!empty($time)) {
					$type = ($type == 'N' ? 'file' : 'folder');
				}

				$item = array('name' => $name, 'type' => $type, 'size' => intval($size), 'time' => intval($time));
				array_push($list, $item);
			}
		}

		return $list;
	}

	public function getFolderUsage($path = '/')
	{
		$rsp = $this->_do_request('GET', '/?usage');
		return floatval($rsp);
	}

	public function getFileInfo($path)
	{
		$rsp = $this->_do_request('HEAD', $path);
		return $rsp;
	}

	private function sign($method, $uri, $date, $length)
	{
		$sign = $method . '&' . $uri . '&' . $date . '&' . $length . '&' . $this->_password;
		return 'UpYun ' . $this->_username . ':' . md5($sign);
	}

	protected function _do_request($method, $path, $headers = NULL, $body = NULL, $file_handle = NULL)
	{
		$uri = '/' . $this->_bucketname . $path;
		$ch = curl_init('http://' . $this->endpoint . $uri);
		$_headers = array('Expect:');
		if (!is_null($headers) && is_array($headers)) {
			foreach ($headers as $k => $v) {
				array_push($_headers, $k . ': ' . $v);
			}
		}

		$length = 0;
		$date = gmdate('D, d M Y H:i:s \\G\\M\\T');

		if (!is_null($body)) {
			if (is_resource($body)) {
				fseek($body, 0, SEEK_END);
				$length = ftell($body);
				fseek($body, 0);
				array_push($_headers, 'Content-Length: ' . $length);
				curl_setopt($ch, CURLOPT_INFILE, $body);
				curl_setopt($ch, CURLOPT_INFILESIZE, $length);
			}
			else {
				$length = @strlen($body);
				array_push($_headers, 'Content-Length: ' . $length);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			}
		}
		else {
			array_push($_headers, 'Content-Length: ' . $length);
		}

		array_push($_headers, 'Authorization: ' . $this->sign($method, $uri, $date, $length));
		array_push($_headers, 'Date: ' . $date);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		if (($method == 'PUT') || ($method == 'POST')) {
			curl_setopt($ch, CURLOPT_POST, 1);
		}
		else {
			curl_setopt($ch, CURLOPT_POST, 0);
		}

		if (($method == 'GET') && is_resource($file_handle)) {
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FILE, $file_handle);
		}

		if ($method == 'HEAD') {
			curl_setopt($ch, CURLOPT_NOBODY, true);
		}

		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($http_code == 0) {
			throw new UpYunException('Connection Failed', $http_code);
		}

		curl_close($ch);
		$header_string = '';
		$body = '';
		if (($method == 'GET') && is_resource($file_handle)) {
			$header_string = '';
			$body = $response;
		}
		else {
			list($header_string, $body) = explode('' . "\r\n" . '' . "\r\n" . '', $response, 2);
		}

		$this->setXRequestId($header_string);

		if ($http_code == 200) {
			if (($method == 'GET') && is_null($file_handle)) {
				return $body;
			}
			else {
				$data = $this->_getHeadersData($header_string);
				return 0 < count($data) ? $data : true;
			}
		}
		else {
			$message = $this->_getErrorMessage($header_string);
			if (is_null($message) && ($method == 'GET') && is_resource($file_handle)) {
				$message = 'File Not Found';
			}

			switch ($http_code) {
			case 401:
				throw new UpYunAuthorizationException($message);
				break;

			case 403:
				throw new UpYunForbiddenException($message);
				break;

			case 404:
				throw new UpYunNotFoundException($message);
				break;

			case 406:
				throw new UpYunNotAcceptableException($message);
				break;

			case 503:
				throw new UpYunServiceUnavailable($message);
				break;

			default:
				throw new UpYunException($message, $http_code);
			}
		}
	}

	private function _getHeadersData($text)
	{
		$headers = explode("\r\n", $text);
		$items = array();

		foreach ($headers as $header) {
			$header = trim($header);

			if (stripos($header, 'x-upyun') !== false) {
				list($k, $v) = explode(':', $header);
				$items[trim($k)] = in_array(substr($k, 8, 5), array('width', 'heigh', 'frame')) ? intval($v) : trim($v);
			}
		}

		return $items;
	}

	private function _getErrorMessage($header_string)
	{
		list($status, $stash) = explode("\r\n", $header_string, 2);
		list($v, $code, $message) = explode(' ', $status, 3);
		return $message . ' X-Request-Id: ' . $this->getXRequestId();
	}

	private function setXRequestId($header_string)
	{
		preg_match('~^X-Request-Id: ([0-9a-zA-Z]{32})~ism', $header_string, $result);
		$this->x_request_id = isset($result[1]) ? $result[1] : '';
	}

	public function getXRequestId()
	{
		return $this->x_request_id;
	}

	public function rmDir($path)
	{
		$this->_do_request('DELETE', $path);
	}

	public function deleteFile($path)
	{
		$rsp = $this->_do_request('DELETE', $path);
	}

	public function readDir($path)
	{
		return $this->getList($path);
	}

	public function getBucketUsage()
	{
		return $this->getFolderUsage('/');
	}

	public function setApiDomain($domain)
	{
		$this->endpoint = $domain;
	}

	public function setContentMD5($str)
	{
		$this->_content_md5 = $str;
	}

	public function setFileSecret($str)
	{
		$this->_file_secret = $str;
	}

	public function getWritedFileInfo($key)
	{
		if (!isset($this->_file_infos)) {
			return NULL;
		}

		return $this->_file_infos[$key];
	}
}

class UpYunException extends Exception
{
	public function __construct($message, $code, Exception $previous = NULL)
	{
		parent::__construct($message, $code);
	}

	public function __toString()
	{
		return 'UpYunException' . ': [' . $this->code . ']: ' . $this->message . "\n";
	}
}
class UpYunAuthorizationException extends UpYunException
{
	public function __construct($message, $code = 0, Exception $previous = NULL)
	{
		parent::__construct($message, 401, $previous);
	}
}
class UpYunForbiddenException extends UpYunException
{
	public function __construct($message, $code = 0, Exception $previous = NULL)
	{
		parent::__construct($message, 403, $previous);
	}
}
class UpYunNotFoundException extends UpYunException
{
	public function __construct($message, $code = 0, Exception $previous = NULL)
	{
		parent::__construct($message, 404, $previous);
	}
}
class UpYunNotAcceptableException extends UpYunException
{
	public function __construct($message, $code = 0, Exception $previous = NULL)
	{
		parent::__construct($message, 406, $previous);
	}
}
class UpYunServiceUnavailable extends UpYunException
{
	public function __construct($message, $code = 0, Exception $previous = NULL)
	{
		parent::__construct($message, 503, $previous);
	}
}

?>
