<?php
/**
 * 公共方法
 */
 

/**
 * 去除多余的转义字符
 */
function doStripslashes(){
	if(get_magic_quotes_gpc()){
		$_GET = stripslashesDeep($_GET);
		$_POST = stripslashesDeep($_POST);
		$_COOKIE = stripslashesDeep($_COOKIE);
		$_REQUEST = stripslashesDeep($_REQUEST);
	}
}

/**
 * 递归去除转义字符
 */
function stripslashesDeep($value){
	$value = is_array($value) ? array_map('stripslashesDeep', $value) : stripslashes($value);
	return $value;
}

/**
 * URL重定向
 * @param string $url 重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string $msg 重定向前的提示信息
 * @return void
 */
function redirect($url, $time=0, $msg=''){
    //多行URL地址支持
    $url        = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
        $msg    = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()){
        // redirect
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    } else {
        $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
            $str .= $msg;
        exit($str);
    }
}

/**
 * 得到网站的网址
 */
function getWebUrl() {
	$phpself = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
	if(preg_match("/^.*\//", $phpself, $matches)){
		return 'http://' . $_SERVER['HTTP_HOST'] . $matches[0];
	}else{
		return '';
	}
}
/**
 * 得到网址的顶级域名
 */
function getUrlTopDomain($url){
	$domain_array = parse_url($url);
	$host = strtolower($domain_array['host']);
	$two_suffix = array('.com.cn','.gov.cn','.net.cn','.org.cn','.ac.cn');
	foreach($two_suffix as $key=>$value){
		preg_match('#(.*?)'.$value.'$#',$host,$match_arr);
		if(!empty($match_arr)){
			$match_array = $match_arr;
			break;
		}
	}
	$host_arr = explode('.',$host);
	if(!empty($match_array)){
		$host_arr_last1 = array_pop($host_arr);
		$host_arr_last2 = array_pop($host_arr);
		$host_arr_last3 = array_pop($host_arr);
		
		return $host_arr_last3.'.'.$host_arr_last2.'.'.$host_arr_last1;
	}else{
		$host_arr_last1 = array_pop($host_arr);
		$host_arr_last2 = array_pop($host_arr);
		return $host_arr_last2.'.'.$host_arr_last1;
	}
}
/**
 * 得到网址的域名
 */
function getUrlDomain($url){
	$domain_array = parse_url($url);
	$host = strtolower($domain_array['host']);
	return $host;
}

/**
 * 快速文件数据读取和保存 针对简单类型数据 字符串、数组
 * @param string $name 缓存名称
 * @param mixed $value 缓存值
 * @param string $path 缓存路径
 * @return mixed
 */
function F($name, $value='', $path = DATA_PATH){
    static $_cache  = array();
    $filename       = $path . $name . '.php';
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            return false !== strpos($name,'*')?array_map("unlink", glob($filename)):unlink($filename);
        } else {
            // 缓存数据
            $dir            =   dirname($filename);
            // 目录不存在则创建
            if (!is_dir($dir))
                mkdir($dir,0755,true);
            $_cache[$name]  =   $value;
            return file_put_contents($filename, strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
        }
    }
    if (isset($_cache[$name]))
        return $_cache[$name];
    // 获取缓存数据
    if (is_file($filename)) {
        $value          =   include $filename;
        $_cache[$name]  =   $value;
    } else {
        $value          =   false;
    }
    return $value;
}

/**
 * 快速哈希文件数据读取和保存 针对简单类型数据 字符串、数组
 * @param string $name 缓存名称
 * @param mixed $value 缓存值
 * @param mixed $level 缓存的目录数
 * @param string $path 缓存路径
 * @return mixed
 */
function S($name, $value='',$time=0,$level=2,$path=CACHE_PATH){
    static $_scache  = array();
	$name = md5($name);
	$haxi_dir = '';
	for($i=0;$i<$level;$i++){
		$haxi_dir .= $name[$i].'/';
	}
    $filename = $path . $haxi_dir . $name . '.php';
	
    if ('' !== $value) {
        if (is_null($value)){
            // 删除缓存
            return false !== strpos($name,'*') ? array_map("unlink",glob($filename)) : unlink($filename);
        } else {
            // 缓存数据
            $dir  =  dirname($filename);
			
            // 目录不存在则创建
            if (!is_dir($dir))
                mkdir($dir,0755,true);
			
			$save_file['content'] = $value;
			if($time > 0){
				$save_file['expire_time'] = $_SERVER['REQUEST_TIME'] + $time;
			}
            $_scache[$name]  =   $value;
            return file_put_contents($filename, strip_whitespace("<?php\treturn " . var_export($save_file, true) . ";?>"));
        }
    }
    if (isset($_scache[$name]))
        return $_scache[$name];
    // 获取缓存数据
    if (is_file($filename)) {
        $value          =   include $filename;
		if(!empty($value['expire_time']) && $value['expire_time']<$_SERVER['REQUEST_TIME']){
			strpos($name,'*') ? array_map("unlink",glob($filename)) : unlink($filename);
			 $return = false;
		}
		$return = $value['content'];
        $_scache[$name]  =   $return;
    } else {
        $return = false;
    }
    return $return;
}

/**
 * 去除代码中的空白和注释
 * @param string $content 代码内容
 * @return string
 */
function strip_whitespace($content){
    $stripStr   = '';
    //分析php源码
    $tokens     = token_get_all($content);
    $last_space = false;
    for ($i = 0, $j = count($tokens); $i < $j; $i++) {
        if (is_string($tokens[$i])) {
            $last_space = false;
            $stripStr  .= $tokens[$i];
        } else {
            switch ($tokens[$i][0]) {
                //过滤各种PHP注释
                case T_COMMENT:
                case T_DOC_COMMENT:
                    break;
                //过滤空格
                case T_WHITESPACE:
                    if (!$last_space) {
                        $stripStr  .= ' ';
                        $last_space = true;
                    }
                    break;
                case T_START_HEREDOC:
                    $stripStr .= "<<<THINK\n";
                    break;
                case T_END_HEREDOC:
                    $stripStr .= "THINK;\n";
                    for($k = $i+1; $k < $j; $k++) {
                        if(is_string($tokens[$k]) && $tokens[$k] == ';') {
                            $i = $k;
                            break;
                        } else if($tokens[$k][0] == T_CLOSE_TAG) {
                            break;
                        }
                    }
                    break;
                default:
                    $last_space = false;
                    $stripStr  .= $tokens[$i][1];
            }
        }
    }
    return $stripStr;
}

/**
 * 自动加载
 */
function __autoload($class){
	if(file_exists(PIGCMS_PATH.'library/controller/'.GROUP_NAME.'/'.$class.'.php')){
		require_once(PIGCMS_PATH.'library/controller/'.GROUP_NAME.'/'.$class.'.php');
		return;
	}else if(file_exists(PIGCMS_PATH.'library/controller/'.$class.'.php')) {
		require_once(PIGCMS_PATH.'library/controller/'.$class.'.php');
		return;
	}else if(file_exists(PIGCMS_PATH.'library/model/'.$class.'.php')){
		require_once(PIGCMS_PATH.'library/model/'.$class.'.php');
		return;
	}else if(file_exists(PIGCMS_PATH.'library/class/'.$class.'.class.php')){
		require_once(PIGCMS_PATH.'library/class/'.$class.'.class.php');
		return;
	}else if(file_exists(PIGCMS_PATH.'source/class/'.$class.'.class.php')){
		require_once(PIGCMS_PATH.'source/class/'.$class.'.class.php');
		return;
	}

	$class = strtolower($class);
	if(file_exists(PIGCMS_PATH.'library/controller/'.GROUP_NAME.'/'.$class.'.php')){
		require_once(PIGCMS_PATH.'library/controller/'.GROUP_NAME.'/'.$class.'.php');
	}else if(file_exists(PIGCMS_PATH.'library/controller/'.$class.'.php')) {
		require_once(PIGCMS_PATH.'library/controller/'.$class.'.php');
	}else if(file_exists(PIGCMS_PATH.'library/model/'.$class.'.php')){
		require_once(PIGCMS_PATH.'library/model/'.$class.'.php');
	}else if(file_exists(PIGCMS_PATH.'library/class/'.$class.'.class.php')){
		require_once(PIGCMS_PATH.'library/class/'.$class.'.class.php');
	}else if(file_exists(PIGCMS_PATH.'source/class/'.$class.'.class.php')){

		require_once(PIGCMS_PATH.'source/class/'.$class.'.class.php');
	}else{
		pigcms_tips($class . ' 类不存在。','none');
	}
}

/**
 * 加载文件
 *
 */
function import($file){
	$file_arr = explode('.',$file);
	$file_arr_count = count($file_arr);
	if(class_exists($file_arr[$file_arr_count-1],false)) return false;
	switch($file_arr_count){
		case 1:
			if(substr($file_arr[0],0,1) == '@'){
				$load_file = PIGCMS_PATH.'library/class/'.substr($file_arr[0],1).'.class.php';
			}else{
				$load_file = PIGCMS_PATH.'source/class/'.$file_arr[0].'.class.php';
			}
			break;
		case 2:
			if(substr($file_arr[0],0,1) == '@'){
				$load_file = PIGCMS_PATH.'library/'.substr($file_arr[0],1).'/'.$file_arr[1].'.class.php';
			}else{
				$load_file = PIGCMS_PATH.'source/'.$file_arr[0].'/'.$file_arr[1].'.class.php';
			}
			break;
		case 3:
			$load_file = PIGCMS_PATH.$file_arr[0].'/'.$file_arr[1].'/'.$file_arr[2].'.class.php';
			break;
		default:
			$file_data = '';
			foreach($file_arr as $val){
				if($file_data == ''){
					$file_data = $val;
				}else{
					$file_data .= '/'.$val;
				}
			}
			$load_file = PIGCMS_PATH.$file_data.'.class.php';
	}
	require_file($load_file);
}

/**
 * 调用数据库类
 */
function D($table='',$other=array()){
	static $db_list;
	import('source.class.mysql');
	if(empty($other)){
		if (!empty($table) && isset($db_list[$table])) {
			return $db_list[$table];
		}
		$db = new mysql();

		if($table){
			$db_list[$table] = $db;
			$db->table($table);
		}
	}else{
		$db = new mysql($other);
		$db->table($table);
	}


	return $db;
}

/**
 * 引入并使用控制器的方法
 */
function R($group,$mode,$action){
	$mode = strtolower($mode);
	$mode_file = PIGCMS_PATH.'library/controller/'.$group.'/'.$mode.'_controller.php';
	if(file_exists($mode_file)){
		$mode_name = $mode.'_controller';
		require($mode_file);
		if(!class_exists($mode_name)){
			pigcms_tips($mode_name.' 类不存在。','none');
		}
		$mode_obj = new $mode_name;
		if(!method_exists($mode_obj,$action)){
			if(method_exists($mode_obj,'_empty')){
				$action = '_empty';
			}else{
				pigcms_tips($action.' 方法不存在。','none');
			}
		}
		$mode_obj->$action();
	}else if(file_exists(TPL_PATH.'/'.ACTION_NAME.'.php')){
		display();
	}else{
		if(DEBUG){
			pigcms_tips($mode_file.' 控制器文件不存在。','none');
		}else{
			pigcms_tips($group.'分组 控制器 '.$mode.' 文件不存在。','none');
		}
	}
}
/**
 * 获得系统参数
 */
function option($name=null,$value=null){
	global $_G;
	 // 无参数时获取所有
	if(empty($name)){
		return $_G;
	}
	// 优先执行设置获取或赋值
    if(is_string($name)){
        if (!strpos($name,'.')) {
            $name = strtolower($name);
            if (is_null($value))
                return isset($_G[$name]) ? $_G[$name] : null;
            $_G[$name] = $value;
            return;
        }
        // 二维数组设置和获取支持
        $name = explode('.', $name);
        $name[0]   =  strtolower($name[0]);
        if (is_null($value))
            return isset($_G[$name[0]][$name[1]]) ? $_G[$name[0]][$name[1]] : null;
        $_G[$name[0]][$name[1]] = $value;
        return;
    }
    return null; // 避免非法参数
}
/**
 * 引入并实例化MODEL类
 */
function M($model){
	$lower_model = strtolower($model);
	$model_file = PIGCMS_PATH.'library/model/'.$lower_model.'_model.php';
	if(file_exists($model_file)){
		$model_name = $lower_model.'_model';
		if(!class_exists($model_name,false)){
			require($model_file);
			if(!class_exists($model_name)){
				pigcms_tips($model_name.' 类不存在。','none');
			}
		}
		$model_obj = new $model_name($model);
		return $model_obj;
	}else{
		pigcms_tips($model_file.' 文件不存在。','none');
	}
}

function datetime($unix_time){
	return date('Y-m-d H:i:s',$unix_time);
}

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

/**
 * 引入模板显示模板
 */
function display($tpl=''){
	global $_G;
	$now_group = GROUP_NAME;
	$now_module = MODULE_NAME;
	$now_action = ACTION_NAME;
	$now_theme = $_G['config']['theme_'.$now_group.'_group'];


	if(empty($now_theme)) $now_theme = 'default';
	if(empty($tpl)){
		$tpl_file = $now_group.'/'.$now_theme.'/'.$now_module.'/'.$now_action.'.php';
	}else{
		$tpl_arr = explode(':',$tpl);
		$tpl_arr_count = count($tpl_arr);
		switch($tpl_arr_count){
			case 1:
				if($now_group == 'wap' && option('config.is_diy_template')){

					if(file_exists(TPL_PATH.$now_group.'/'.$now_theme.'/theme/'.$tpl_arr[$tpl_arr_count-1].'.php')){
						if(USE_FRAMEWORK){
							$tpl_file = $now_group.'/'.$now_theme.'/'.$now_module.'/'.'/theme/'.$tpl_arr[$tpl_arr_count-1].'.php';
						}else{
							$tpl_file = $now_group.'/'.$now_theme.'/theme/'.$tpl_arr[$tpl_arr_count-1].'.php';
						}
					}else{

						if(USE_FRAMEWORK){
							$tpl_file = (strpos($tpl_arr[0],'/')===false) ? $now_group.'/'.$now_theme.'/'.$now_module.'/'.$tpl_arr[0].'.php' : $tpl_arr[0];
						}else{
							$tpl_file = (strpos($tpl_arr[0],'/')===false) ? $now_group.'/'.$now_theme.'/'.$tpl_arr[0].'.php' : $tpl_arr[0];
						}

					}

				}else{

					if(USE_FRAMEWORK){
						$tpl_file = (strpos($tpl_arr[0],'/')===false) ? $now_group.'/'.$now_theme.'/'.$now_module.'/'.$tpl_arr[0].'.php' : $tpl_arr[0];
					}else{
						$tpl_file = (strpos($tpl_arr[0],'/')===false) ? $now_group.'/'.$now_theme.'/'.$tpl_arr[0].'.php' : $tpl_arr[0];
					}

				}

				break;
			case 2:
				$tpl_file = $now_group.'/'.$now_theme.'/'.$tpl_arr[0].'/'.$tpl_arr[1].'.php';
				break;
			case 3:
				$tpl_file = $tpl_arr[0].'/'.$_G['config']['theme_'.$tpl_arr[0].'_group'].'/'.$tpl_arr[1].'/'.$tpl_arr[2].'.php';
				break;
			default:
				pigcms_tips('参数过多，无法实例化模板！');
		}
		if($tpl_arr_count == 1){
			
		}else if($tpl_arr_count == 2){
			
		}else if($tpl_arr_count == 3){
			
		}
	}


	if(file_exists(TPL_PATH.$tpl_file)){
		return TPL_PATH.$tpl_file;
	}else{
		if(DEBUG){
			pigcms_tips('模板文件 template/'.$tpl_file.' 文件不存在。','none');
		}else{
			pigcms_tips('模板文件 不存在！');
		}
	}
}

/**
 * 生成URL
 */
function url($url='',$param=array(),$showDomain=false){
	global $_G;
	if($showDomain){
		$return_url = $_G['config']['site_url'].'/';
	}else{
		$return_url = getWebUrl();
	}
	$url_arr = explode(':',$url);

	$url_arr_count = count($url_arr);
	switch($url_arr_count){
		case 1:
//			$return_url .= ltrim($_SERVER['SCRIPT_NAME'],'/').'?c='.MODULE_NAME.'&a='.$url_arr[0];
//			break;
			$return_url .= explode('/',ltrim($_SERVER['SCRIPT_NAME'],'/'))[1].'?c='.MODULE_NAME.'&a='.$url_arr[0];
			break;
		case 2:
//			$return_url .= ltrim($_SERVER['SCRIPT_NAME'],'/').'?c='.$url_arr[0].'&a='.$url_arr[1];
//			break;
			$return_url .= explode('/',ltrim($_SERVER['SCRIPT_NAME'],'/'))[1].'?c='.$url_arr[0].'&a='.$url_arr[1];
			break;
		case 3:
			$return_url .= $url_arr[0].'.php'.'?c='.$url_arr[1].'&a='.$url_arr[2];
			break;
		case 4:
			pigcms_tips('参数过多，只允许接收3个参数！');
	}
	if($param){
		$return_url .= '&'.http_build_query($param);
	}
	return $return_url;
}

//将url转换成静态url  
function url_rewrite($file,$params = array (),$html = "",$rewrite = true) {    
	 if ($rewrite) {
		if(strpos($file,':')){
			$file 	= substr($file, 0, strpos($file, ':'));
			$url = option('config.site_url').'/' . $file;
		}else{
			$url = ($file == 'index') ? '' : '/' . $file;  
		}

		if (!empty ($html)) {  
		 	$url .= '.' . $html;  
		}

		if (!empty ($params) && is_array($params)) {  
			$url .= '/' . implode('/', $params);  
		}

		if($file == 'goods' || $file == 'store'){
			$url .= '.' . 'html'; 
		}

		/*foreach ($params as $key => $value) {
			$url .= '/'.$key.'/'.$value;
		}*/

	 } else {
		$url 	= url($file,$params);
	}
	return $url;
}

/**
 * 生成URL并输出
 */
function dourl($url='',$param=array(),$showDomain=false){
    echo url($url,$param,$showDomain);
}

/**
 * 得到字符串的一部分
 */
function msubstr($str, $start=0, $length,$suffix=true,$charset="utf-8"){
    if(function_exists("mb_substr")){
        if ($suffix && strlen($str)>$length)
            return mb_substr($str, $start, $length, $charset)."...";
        else
            return mb_substr($str, $start, $length, $charset);
    }
    elseif(function_exists('iconv_substr')) {
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

/**
 * 得到字符串的utf8格式
 */
function get_utf8($word){ 
	if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true){ 
		return $word; 
	}else{ 
		return iconv('gbk','utf-8',$word); 
	} 
}

/**
 * JSON返回
 *
 * param err_code 返回的错误编码
 * param err_msg  返回的错误信息
 * param err_dom  返回的DOM标识
 */
function json_return($err_code,$err_msg='',$err_dom=''){
	$json_arr['err_code'] = $err_code;
	if($err_msg) $json_arr['err_msg'] = $err_msg;
	if($err_dom) $json_arr['err_dom'] = $err_dom;
	if(!headers_sent()) header('Content-type:application/json');
	exit(json_encode($json_arr));
}
 
 
/**
 * 检测插件是否存在
 *
 * @param string $plugin 插件名称
 * @param string $attr 参数
 */
function check_plugin($plugin){
	if (is_string($plugin) && file_exists(PIGCMS_PATH.'source/plugins/'.$plugin.'/'.$plugin.'.php')){
		return true;
	}else{
		return false;
	}
}


/**
 * 得到插件的url
 *
 * @param string $plugin 插件名称
 * @param string $attr 参数 
 */
function url_plugin($plugin,$attr=''){
	global $_G;
	if(!defined('IS_MOBILE')){
		$site_url = $_G['config']['site_url'];
	}else{
		$site_url = $_G['config']['mobile_site_url'];
	}
	if(!empty($attr)){
		return $site_url.'/index.php?plugin='.$plugin.'&'.$attr;
	}else{
		return $site_url.'/index.php?plugin='.$plugin;
	}
}

/**
 * 得到文件的大小
 */
function getSize($size){
	$kb = 1024;
    $mb = 1024*$kb;
    $gb = 1024*$mb;
    $tb = 1024*$gb;
	if($size<$kb){ 
        return $size." B";
    }else if($size<$mb){ 
        return round($size/$kb,2)." KB";
    }else if($size<$gb){ 
        return round($size/$mb,2)." MB";
    }else if($size<$tb){ 
        return round($size/$gb,2)." GB";
    }else{ 
        return round($size/$tb,2)." TB";
    }
}

/**
 * 判断是否手机访问
 */
function is_mobile(){
	if(preg_match('/(iphone|ipad|ipod|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))){
		return true;
	}else{
		return false;
	}
}
/**
 * 判断是否微信访问
 */
function is_weixin(){
	if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false){
		return true;
	}else{
		return false;
	}
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

		$attachment_upload_type = option('config.attachment_upload_type');
		$url = option('config.site_url') . '/upload/';
		if ($attachment_upload_type == '1' && $is_remote) {
			$url = 'http://' . option('config.attachment_up_domainname') . '/';
		}

		return $url . $fileUrl;
	}
}
/**
 * 得到附件相对应网站目录的文件地址
 */
function getAttachmentFilePath($fileUrl){
	return PIGCMS_PATH.'upload/'.$fileUrl;
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
	$type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}


/**
 * 等比例绽放图片大小
 */
 function drawImg($from,$w=100,$h=100,$newfile){

    $info = getimagesize($from);

    switch ($info[2]){
        case 1:
            $im = imagecreatefromgif($from);
            break;

        case 2:
            $im = imagecreatefromjpeg($from);
            break;

        case 3:
            $im = imagecreatefrompng($from);
            break;

        default:
            exit('不支持的图像格式');
            break;
    }

    $temp = pathinfo($from);
    $name = $temp["basename"];//文件名
    $dir = $temp["dirname"];//文件所在的文件夹
    $extension = $temp["extension"];//文件扩展名
    $width = $info[0];//获取图片宽度
    $height = $info[1];//获取图片高度
    $per1 = round($width/$height,2);//计算原图长宽比
    $per2 = round($w/$h,2);//计算缩略图长宽比

    //计算缩放比例
    if($per1>$per2||$per1==$per2) {
        //原图长宽比大于或者等于缩略图长宽比，则按照宽度优先
        $per=$w/$width;
    }

    if($per1<$per2) {
        //原图长宽比小于缩略图长宽比，则按照高度优先
        $per=$h/$height;
    }
    $temp_w = intval($width*$per);//计算原图缩放后的宽度
    $temp_h = intval($height*$per);//计算原图缩放后的高度
    $dst_im = imagecreatetruecolor($temp_w, $temp_h);

    //调整大小
    imagecopyresized($dst_im, $im, 0, 0, 0, 0, $temp_w, $temp_h, $width, $height);
    //输出缩小后的图像
    //exit($newfile);

    imagejpeg($dst_im,$dir.'/'.$newfile);
    imagedestroy($dst_im);
    imagedestroy($im);
}

/**
 * 获取图片不包含域名，如果未使用远程存储，将upload目录一并去掉
 */
function getAttachment($file) {
	if (empty($file)) {
		return;
	}

	$search = trim(option('config.site_url'), '/') . '/upload/';
	$attachment_upload_type = option('config.attachment_upload_type');
	if ($attachment_upload_type == '1') {
		$search = trim('http://' . option('config.attachment_up_domainname'), '/') . '/';
	}

	$file = trim(str_replace($search, '', $file), '/');
	return $file;
}


//im聊天相关
/**
 *   加密串
 */
function get_encrypt_key($array,$app_key){
	$new_arr = array();
	ksort($array);
	foreach($array as $key=>$value){
		$new_arr[] = $key.'='.$value;
	}
	$new_arr[] = 'app_key='.$app_key;

	$string = implode('&',$new_arr);
	return md5($string);
}

/**
 * CURL POST
 *
 * param url 抓取的URL
 * param data post的数组
 */
function curl_post($url,$data){
	$ch = curl_init();
	$headers[] = "Accept-Charset: utf-8";
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);

	//关闭curl
	curl_close($ch);
	
	return $result;
}
/**
 * 微信API CURL POST
 *
 * param url 抓取的URL
 * param data post的数组
 */
function api_curl_post($url,$data){
	$result = curl_post($url,$data);

	$result_arr = json_decode($result,true);
	return $result_arr;
}

/**
 * JSON返回
 *
 * param err_code 返回的错误编码
 * param err_msg  返回的错误信息
 * param err_dom  返回的DOM标识
 */
function error_json_return($err_code,$err_msg){
	$json_arr['err_code'] = $err_code;
	$json_arr['err_msg'] = $err_msg;
	exit(json_encode($json_arr));
}
function ok_json_return($json_arr){
	$json_arr['err_code'] = 0;
	exit(json_encode($json_arr));
}
function ok_jsonp_return($json_arr){
	$json_arr['err_code'] = 0;
	exit($_GET['callback'].'('.json_encode($json_arr).')');
}
//获取im聊天url
function getImUrl($userId,$storeId){
	$is_service 	= D('Service')->where("status = 1 AND openid != '' AND store_id=$storeId")->find();
	
	if(!empty($is_service) && $_SESSION['wap_user']['app_id'] == 0){
		$key = get_encrypt_key(array('app_id'=>option('config.im_appid'),'openid'=>$userId),option('config.im_appkey'));
		$url = IM_SERVER_PATH.'?app_id='.option('config.im_appid').'&openid='.$userId.'&key='.$key.'#serviceList_'.$storeId;
	}else{
		$store = D('Store')->where("status = 1 AND store_id = '" . $storeId . "'")->find();
		$user_tmp = $_SESSION['wap_user'];
		
		/*if (empty($_SESSION['wap_user'])) {
			$user_tmp = D('User')->where("uid = '" . $store['uid'] . "'")->find();
		}*/
		
		if ($user_tmp['app_id'] == 1 && !empty($store['open_service']) && !empty($store['source_site_url']) && !empty($store['token'])) {
			$url = $store['source_site_url'] . '/index.php?g=Wap&m=Service&a=index&token=' . $store['token'] . '&wecha_id=';
		} else if ($user_tmp['app_id'] == 2 && !empty($store['open_service'])) {
			$url = $store['source_site_url'] . '/wap.php?c=Weidian&a=getImUrl&token='.$store['token'].'&wecha_id='.$_SESSION['wap_user']['third_id'];
		} else {
			$url 	= '';
		}
	}
	
	return $url;
}

/**
 * 根据时间，返回状态
 * 当前时间在两个时间内:正在进行，当前时间大于开始时间:未开始，当前时间大于结束时间：已结束
 */
function getTimeType($start_time, $end_time) {
	if (empty($start_time) && empty($end_time)) {
		return '';
	}

	// 时间修正
	if ($start_time > $end_time) {
		$tmp = $end_time;
		$end_time = $start_time;
		$start_time = $tmp;
	}

	$time = time();
	if ($time >= $start_time && $time <= $end_time) {
		return '正在进行';
	} else if ($time < $start_time) {
		return '未开始';
	} else if ($time > $end_time) {
		return '已结束';
	}

	return '';
}

/**
 * 根据满减/送信息，返回格式化字条串
 */
function getRewardStr($reward) {
	global $config;

	$str = '满' . $reward['money'];

	if ($reward['cash']) {
		$str .= ',减' . $reward['cash'] . '元';
	}

	if ($reward['postage']) {
		$str .= ',免邮费';
	}

	if ($reward['score']) {
		$str .= ',送' . $reward['score'] . '积分';
	}

	if ($reward['coupon']) {
		$str .= '，送优惠券';

		$url = '';
		if (GROUP_NAME != 'wap') {
			$url = url('coupon:index', array('id' => $reward['coupon']['id']));
		} else {
			$url = $config['wap_site_url'] . '/coupon_detail.php?id=' . $reward['coupon']['id'];
		}
		$str .= '<a href="' . $url . '" target="_blank">' . $reward['coupon']['name'] . '</a>';
	}

	if ($reward['present']) {
		$str .= ',赠送产品：';
		foreach ($reward['present'] as $product) {
			$url = '';
			if (GROUP_NAME != 'wap') {
				$url = url_rewrite('goods:index', array('id' => $product['product_id']));
			} else {
				$url = $config['wap_site_url'] . '/good.php?id=' .  $product['product_id'];
			}
			$str .= '<a href="' . $url . '" target="_blank">' . $product['name'] . '</a> ';
		}
	}

	return $str;
}



//对象转换为数组
function object_array($array) {
	if(is_object($array)) {
		$array = (array)$array;
	} if(is_array($array)) {
		foreach($array as $key=>$value) {
			$array[$key] = object_array($value);
		}
	}
	return $array;
}


//获取用户当前登录位置
function show_distance(){

	if($_COOKIE['Web_user']) {
		$array = object_array(json_decode($_COOKIE['Web_user']));
		$array['status'] = true;
	} else {
		$array = array('status'=>false);
	}
	return $array;
}

// 隐藏评论人信息
function anonymous($str, $len1 = 2, $len2 = 1) {
	if (mb_strlen($str, 'utf-8') < 4) {
		$return_str = mb_substr($str, 0, 1, 'utf-8');
		$return_str .= '**';
	} else {
		$return_str = mb_substr($str, 0, $len1, 'utf-8');
		$return_str .= '**';
		$return_str .= mb_substr($str, -1 * $len2, $len2, 'utf-8');
	}
	return $return_str;
}


/**
 * @desc 获取querystring
 * @param $url
 * @return array|string
 */
function convertUrlQuery($url) {
    $arr = parse_url($url);
    $query = $arr['query'];
    if (!empty($query)) {
        $queryParts = explode('&', $query);

        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
    } else {
        $params = '';
    }
    return $params;
}




/**
 *计算某个经纬度的周围某段距离的正方形的四个点
 *
 *@param lng float 经度
 *@param lat float 纬度
 *@param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
 *@return array 正方形的四个点的经纬度坐标
*/
function returnSquarePoint($lng, $lat,$distance = 0.5){
	define(EARTH_RADIUS, 6371);//地球半径，平均半径为6371km
	$dlng =  2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
	$dlng = rad2deg($dlng);

	$dlat = $distance/EARTH_RADIUS;
	$dlat = rad2deg($dlat);

	return array(
			'left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
			'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
			'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
			'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
	);
}


?>