<?php
class Express {
	// 从快递100里返回信息
	static public function kuadi100($url) {
		import('class.Http');
		$content = Http::curlGet($url);
		return $content;
	}
}