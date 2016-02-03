<?php
//狗扑源码社区 www.gope.cn
class Http
{
	static public function curlGet($url)
	{
		$ch = curl_init();
		$headers[] = 'Accept-Charset:utf-8';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	static public function curlPost($url, $data)
	{
		$ch = curl_init();
		$headers[] = 'Accept-Charset: utf-8';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($result, true);

		if (isset($result['errcode'])) {
			import('source.class.GetErrorMsg');
			$errmsg = GetErrorMsg::wx_error_msg($result['errcode']);
			return array('errcode' => $result['errcode'], 'errmsg' => $errmsg);
		}
		else {
			$result['errcode'] = 0;
			return $result;
		}
	}

	static public function curlDownload($remote, $local)
	{
		$cp = curl_init($remote);
		$fp = fopen($local, 'w');
		curl_setopt($cp, CURLOPT_FILE, $fp);
		curl_setopt($cp, CURLOPT_HEADER, 0);
		curl_exec($cp);
		curl_close($cp);
		fclose($fp);
	}

	static public function fsockopenDownload($url, $conf = array())
	{
		$return = '';

		if (!is_array($conf)) {
			return $return;
		}

		$matches = parse_url($url);
		!isset($matches['host']) && $matches['host'] = '';
		!isset($matches['path']) && $matches['path'] = '';
		!isset($matches['query']) && $matches['query'] = '';
		!isset($matches['port']) && $matches['port'] = '';
		$host = $matches['host'];
		$path = ($matches['path'] ? $matches['path'] . ($matches['query'] ? '?' . $matches['query'] : '') : '/');
		$port = (!empty($matches['port']) ? $matches['port'] : 80);
		$conf_arr = array('limit' => 0, 'post' => '', 'cookie' => '', 'ip' => '', 'timeout' => 15, 'block' => true);

		foreach (array_merge($conf_arr, $conf) as $k => $v) {
			$$k = $v;
		}

		if ($post) {
			if (is_array($post)) {
				$post = http_build_query($post);
			}

			$out = 'POST ' . $path . ' HTTP/1.0' . "\r\n" . '';
			$out .= 'Accept: */*' . "\r\n" . '';
			$out .= 'Accept-Language: zh-cn' . "\r\n" . '';
			$out .= 'Content-Type: application/x-www-form-urlencoded' . "\r\n" . '';
			$out .= 'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
			$out .= 'Host: ' . $host . "\r\n";
			$out .= 'Content-Length: ' . strlen($post) . "\r\n";
			$out .= 'Connection: Close' . "\r\n" . '';
			$out .= 'Cache-Control: no-cache' . "\r\n" . '';
			$out .= 'Cookie: ' . $cookie . '' . "\r\n" . '' . "\r\n" . '';
			$out .= $post;
		}
		else {
			$out = 'GET ' . $path . ' HTTP/1.0' . "\r\n" . '';
			$out .= 'Accept: */*' . "\r\n" . '';
			$out .= 'Accept-Language: zh-cn' . "\r\n" . '';
			$out .= 'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
			$out .= 'Host: ' . $host . "\r\n";
			$out .= 'Connection: Close' . "\r\n" . '';
			$out .= 'Cookie: ' . $cookie . '' . "\r\n" . '' . "\r\n" . '';
		}

		$fp = @fsockopen($ip ? $ip : $host, $port, $errno, $errstr, $timeout);

		if (!$fp) {
			return '';
		}
		else {
			stream_set_blocking($fp, $block);
			stream_set_timeout($fp, $timeout);
			@fwrite($fp, $out);
			$status = stream_get_meta_data($fp);

			if (!$status['timed_out']) {
				while (!feof($fp)) {
					if (($header = @fgets($fp)) && (($header == "\r\n") || ($header == "\n"))) {
						break;
					}
				}

				$stop = false;

				while (!feof($fp) && !$stop) {
					$data = fread($fp, ($limit == 0) || (8192 < $limit) ? 8192 : $limit);
					$return .= $data;

					if ($limit) {
						$limit -= strlen($data);
						$stop = $limit <= 0;
					}
				}
			}

			@fclose($fp);
			return $return;
		}
	}

	static public function download($filename, $showname = '', $content = '', $expire = 180)
	{
		if (is_file($filename)) {
			$length = filesize($filename);
		}
		else if (is_file(UPLOAD_PATH . $filename)) {
			$filename = UPLOAD_PATH . $filename;
			$length = filesize($filename);
		}
		else if ($content != '') {
			$length = strlen($content);
		}
		else {
			throw_exception($filename . L('下载文件不存在！'));
		}

		if (empty($showname)) {
			$showname = $filename;
		}

		$showname = basename($showname);

		if (!empty($filename)) {
			$type = mime_content_type($filename);
		}
		else {
			$type = 'application/octet-stream';
		}

		header('Pragma: public');
		header('Cache-control: max-age=' . $expire);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expire) . 'GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . 'GMT');
		header('Content-Disposition: attachment; filename=' . $showname);
		header('Content-Length: ' . $length);
		header('Content-type: ' . $type);
		header('Content-Encoding: none');
		header('Content-Transfer-Encoding: binary');

		if ($content == '') {
			readfile($filename);
		}
		else {
			echo $content;
		}

		exit();
	}

	static public function getHeaderInfo($header = '', $echo = true)
	{
		ob_start();
		$headers = getallheaders();

		if (!empty($header)) {
			$info = $headers[$header];
			echo $header . ':' . $info . "\n";
		}
		else {
			foreach ($headers as $key => $val) {
				echo $key . ':' . $val . "\n";
			}
		}

		$output = ob_get_clean();

		if ($echo) {
			echo nl2br($output);
		}
		else {
			return $output;
		}
	}

	static public function sendHttpStatus($code)
	{
		static $_status = array(100 => 'Continue', 101 => 'Switching Protocols', 200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content', 300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Found', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 307 => 'Temporary Redirect', 400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 407 => 'Proxy Authentication Required', 408 => 'Request Timeout', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 413 => 'Request Entity Too Large', 414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 417 => 'Expectation Failed', 500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 504 => 'Gateway Timeout', 505 => 'HTTP Version Not Supported', 509 => 'Bandwidth Limit Exceeded');

		if (isset($_status[$code])) {
			header('HTTP/1.1 ' . $code . ' ' . $_status[$code]);
		}
	}
}

if (!function_exists('mime_content_type')) {
	function mime_content_type($filename)
	{
		static $contentType = array('ai' => 'application/postscript', 'aif' => 'audio/x-aiff', 'aifc' => 'audio/x-aiff', 'aiff' => 'audio/x-aiff', 'asc' => 'application/pgp', 'asf' => 'video/x-ms-asf', 'asx' => 'video/x-ms-asf', 'au' => 'audio/basic', 'avi' => 'video/x-msvideo', 'bcpio' => 'application/x-bcpio', 'bin' => 'application/octet-stream', 'bmp' => 'image/bmp', 'c' => 'text/plain', 'cc' => 'text/plain', 'cs' => 'text/plain', 'cpp' => 'text/x-c++src', 'cxx' => 'text/x-c++src', 'cdf' => 'application/x-netcdf', 'class' => 'application/octet-stream', 'com' => 'application/octet-stream', 'cpio' => 'application/x-cpio', 'cpt' => 'application/mac-compactpro', 'csh' => 'application/x-csh', 'css' => 'text/css', 'csv' => 'text/comma-separated-values', 'dcr' => 'application/x-director', 'diff' => 'text/diff', 'dir' => 'application/x-director', 'dll' => 'application/octet-stream', 'dms' => 'application/octet-stream', 'doc' => 'application/msword', 'dot' => 'application/msword', 'dvi' => 'application/x-dvi', 'dxr' => 'application/x-director', 'eps' => 'application/postscript', 'etx' => 'text/x-setext', 'exe' => 'application/octet-stream', 'ez' => 'application/andrew-inset', 'gif' => 'image/gif', 'gtar' => 'application/x-gtar', 'gz' => 'application/x-gzip', 'h' => 'text/plain', 'h++' => 'text/plain', 'hh' => 'text/plain', 'hpp' => 'text/plain', 'hxx' => 'text/plain', 'hdf' => 'application/x-hdf', 'hqx' => 'application/mac-binhex40', 'htm' => 'text/html', 'html' => 'text/html', 'ice' => 'x-conference/x-cooltalk', 'ics' => 'text/calendar', 'ief' => 'image/ief', 'ifb' => 'text/calendar', 'iges' => 'model/iges', 'igs' => 'model/iges', 'jar' => 'application/x-jar', 'java' => 'text/x-java-source', 'jpe' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'jpg' => 'image/jpeg', 'js' => 'application/x-javascript', 'kar' => 'audio/midi', 'latex' => 'application/x-latex', 'lha' => 'application/octet-stream', 'log' => 'text/plain', 'lzh' => 'application/octet-stream', 'm3u' => 'audio/x-mpegurl', 'man' => 'application/x-troff-man', 'me' => 'application/x-troff-me', 'mesh' => 'model/mesh', 'mid' => 'audio/midi', 'midi' => 'audio/midi', 'mif' => 'application/vnd.mif', 'mov' => 'video/quicktime', 'movie' => 'video/x-sgi-movie', 'mp2' => 'audio/mpeg', 'mp3' => 'audio/mpeg', 'mpe' => 'video/mpeg', 'mpeg' => 'video/mpeg', 'mpg' => 'video/mpeg', 'mpga' => 'audio/mpeg', 'ms' => 'application/x-troff-ms', 'msh' => 'model/mesh', 'mxu' => 'video/vnd.mpegurl', 'nc' => 'application/x-netcdf', 'oda' => 'application/oda', 'patch' => 'text/diff', 'pbm' => 'image/x-portable-bitmap', 'pdb' => 'chemical/x-pdb', 'pdf' => 'application/pdf', 'pgm' => 'image/x-portable-graymap', 'pgn' => 'application/x-chess-pgn', 'pgp' => 'application/pgp', 'php' => 'application/x-httpd-php', 'php3' => 'application/x-httpd-php3', 'pl' => 'application/x-perl', 'pm' => 'application/x-perl', 'png' => 'image/png', 'pnm' => 'image/x-portable-anymap', 'po' => 'text/plain', 'ppm' => 'image/x-portable-pixmap', 'ppt' => 'application/vnd.ms-powerpoint', 'ps' => 'application/postscript', 'qt' => 'video/quicktime', 'ra' => 'audio/x-realaudio', 'rar' => 'application/octet-stream', 'ram' => 'audio/x-pn-realaudio', 'ras' => 'image/x-cmu-raster', 'rgb' => 'image/x-rgb', 'rm' => 'audio/x-pn-realaudio', 'roff' => 'application/x-troff', 'rpm' => 'audio/x-pn-realaudio-plugin', 'rtf' => 'text/rtf', 'rtx' => 'text/richtext', 'sgm' => 'text/sgml', 'sgml' => 'text/sgml', 'sh' => 'application/x-sh', 'shar' => 'application/x-shar', 'shtml' => 'text/html', 'silo' => 'model/mesh', 'sit' => 'application/x-stuffit', 'skd' => 'application/x-koan', 'skm' => 'application/x-koan', 'skp' => 'application/x-koan', 'skt' => 'application/x-koan', 'smi' => 'application/smil', 'smil' => 'application/smil', 'snd' => 'audio/basic', 'so' => 'application/octet-stream', 'spl' => 'application/x-futuresplash', 'src' => 'application/x-wais-source', 'stc' => 'application/vnd.sun.xml.calc.template', 'std' => 'application/vnd.sun.xml.draw.template', 'sti' => 'application/vnd.sun.xml.impress.template', 'stw' => 'application/vnd.sun.xml.writer.template', 'sv4cpio' => 'application/x-sv4cpio', 'sv4crc' => 'application/x-sv4crc', 'swf' => 'application/x-shockwave-flash', 'sxc' => 'application/vnd.sun.xml.calc', 'sxd' => 'application/vnd.sun.xml.draw', 'sxg' => 'application/vnd.sun.xml.writer.global', 'sxi' => 'application/vnd.sun.xml.impress', 'sxm' => 'application/vnd.sun.xml.math', 'sxw' => 'application/vnd.sun.xml.writer', 't' => 'application/x-troff', 'tar' => 'application/x-tar', 'tcl' => 'application/x-tcl', 'tex' => 'application/x-tex', 'texi' => 'application/x-texinfo', 'texinfo' => 'application/x-texinfo', 'tgz' => 'application/x-gtar', 'tif' => 'image/tiff', 'tiff' => 'image/tiff', 'tr' => 'application/x-troff', 'tsv' => 'text/tab-separated-values', 'txt' => 'text/plain', 'ustar' => 'application/x-ustar', 'vbs' => 'text/plain', 'vcd' => 'application/x-cdlink', 'vcf' => 'text/x-vcard', 'vcs' => 'text/calendar', 'vfb' => 'text/calendar', 'vrml' => 'model/vrml', 'vsd' => 'application/vnd.visio', 'wav' => 'audio/x-wav', 'wax' => 'audio/x-ms-wax', 'wbmp' => 'image/vnd.wap.wbmp', 'wbxml' => 'application/vnd.wap.wbxml', 'wm' => 'video/x-ms-wm', 'wma' => 'audio/x-ms-wma', 'wmd' => 'application/x-ms-wmd', 'wml' => 'text/vnd.wap.wml', 'wmlc' => 'application/vnd.wap.wmlc', 'wmls' => 'text/vnd.wap.wmlscript', 'wmlsc' => 'application/vnd.wap.wmlscriptc', 'wmv' => 'video/x-ms-wmv', 'wmx' => 'video/x-ms-wmx', 'wmz' => 'application/x-ms-wmz', 'wrl' => 'model/vrml', 'wvx' => 'video/x-ms-wvx', 'xbm' => 'image/x-xbitmap', 'xht' => 'application/xhtml+xml', 'xhtml' => 'application/xhtml+xml', 'xls' => 'application/vnd.ms-excel', 'xlt' => 'application/vnd.ms-excel', 'xml' => 'application/xml', 'xpm' => 'image/x-xpixmap', 'xsl' => 'text/xml', 'xwd' => 'image/x-xwindowdump', 'xyz' => 'chemical/x-xyz', 'z' => 'application/x-compress', 'zip' => 'application/zip');
		$type = strtolower(substr(strrchr($filename, '.'), 1));

		if (isset($contentType[$type])) {
			$mime = $contentType[$type];
		}
		else {
			$mime = 'application/octet-stream';
		}

		return $mime;
	}
}

if (!function_exists('image_type_to_extension')) {
	function image_type_to_extension($imagetype)
	{
		if (empty($imagetype)) {
			return false;
		}

		switch ($imagetype) {
		case IMAGETYPE_GIF:
			return '.gif';
		case IMAGETYPE_JPEG:
			return '.jpg';
		case IMAGETYPE_PNG:
			return '.png';
		case IMAGETYPE_SWF:
			return '.swf';
		case IMAGETYPE_PSD:
			return '.psd';
		case IMAGETYPE_BMP:
			return '.bmp';
		case IMAGETYPE_TIFF_II:
			return '.tiff';
		case IMAGETYPE_TIFF_MM:
			return '.tiff';
		case IMAGETYPE_JPC:
			return '.jpc';
		case IMAGETYPE_JP2:
			return '.jp2';
		case IMAGETYPE_JPX:
			return '.jpf';
		case IMAGETYPE_JB2:
			return '.jb2';
		case IMAGETYPE_SWC:
			return '.swc';
		case IMAGETYPE_IFF:
			return '.aiff';
		case IMAGETYPE_WBMP:
			return '.wbmp';
		case IMAGETYPE_XBM:
			return '.xbm';
		default:
			return false;
		}
	}
}

?>
