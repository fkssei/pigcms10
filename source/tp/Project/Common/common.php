<?php
/*
 * 截取中文字符串	
 */
function msubstr($str,$start=0,$length,$suffix=true,$charset="utf-8"){
    if(function_exists("mb_substr")){
        if ($suffix && strlen($str)>$length)
            return mb_substr($str, $start, $length, $charset)."...";
        else
            return mb_substr($str, $start, $length, $charset);
    }elseif(function_exists('iconv_substr')) {
        if ($suffix && strlen($str)>$length)
            return iconv_substr($str,$start,$length,$charset)."...";
        else
            return iconv_substr($str,$start,$length,$charset);
    }
    $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    if($suffix) return $slice."…";
    return $slice;
}

function arr_htmlspecialchars(&$value){
	$value = htmlspecialchars($value);
}

function fulltext_filter($value){
	return htmlspecialchars_decode($value);
}

/**
 * 得到附件的网址
 * is_remote,是否是远程，否时直接用本地图片
 */
function getAttachmentUrl($fileUrl, $is_remote = true){
	if(empty($fileUrl)){
		return '';
	}else{
		// 如果已经是完整url地址，则不做处理
		if (strstr($fileUrl, 'http://') !== false) {
			return $fileUrl;
		}

		$attachment_upload_type = C('config.attachment_upload_type');
		$url = C('config.site_url') . '/upload/';
		if ($attachment_upload_type == '1' && $is_remote) {
			$url = 'http://' . C('config.attachment_up_domainname') . '/';
		}

		return $url . $fileUrl;
	}
}
?>