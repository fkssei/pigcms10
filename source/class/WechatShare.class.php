<?php 
class WechatShare 
{
	public $appid 		= '';
	public $appsecret 	= '';
	public $error 		= array();
	//构造函数获取access_token
	function __construct(){
        import('source.class.checkFunc');
$checkFunc=new checkFunc();
if (!function_exists('fdsrejsie3qklwewerzdagf4ds')){exit('error-4');}
$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$this->appid 		= option('config.wechat_appid');
		$this->appsecret 	= option('config.wechat_appsecret');
	}

	public function getSgin($share_conf){
	
		import('WechatApi');

		$tokenObj 	= new WechatApi(array('appid'=>$this->appid,'appsecret'=>$this->appsecret));
		
		$access_token 	= $tokenObj->get_access_token();
        file_put_contents('token.txt', $access_token);
		$ticket 	= $this->getTicket($access_token['access_token']);

		$url 		= "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		$sign_data 	= $this->addSign($ticket,$url);

		$share_html = $this->createHtml($sign_data,$share_conf);

		return $share_html;
	}

	public function getError(){
		dump($this->error);
	}
	
	public function addSign($ticket,$url){
		$timestamp = time();
		$nonceStr  = rand(100000,999999);
		$array 	= array(
			"noncestr"		=> $nonceStr,		
			"jsapi_ticket"	=> $ticket,
			"timestamp"		=> $timestamp,
			"url"			=> $url,
		);

		ksort($array);
		$signPars	= '';
	
		foreach($array as $k => $v) {
			if("" != $v && "sign" != $k) {
				if($signPars == ''){
					$signPars .= $k . "=" . $v;
				}else{
					$signPars .=  "&". $k . "=" . $v;
				}
			}
		}
		
		$result = array(
			'appId' 	=> $this->appid,
			'timestamp' => $timestamp,
			'nonceStr'  => $nonceStr,
			'url' 		=> $url,
			'signature' => SHA1($signPars),
		);

		return $result;
	}



	public function getUrl(){
 		$url 	= "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		if(isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == 'oauth')){
			$url 		= $this->clearUrl($url);
			if(isset($_GET['wecha_id'])){
				$url .= '&wecha_id='.$this->wecha_id;
			}
			return $url;
		}else{
			return $url;
		}

	}
	
	public function clearUrl($url){
		$param 	= explode('&', $url);
		for ($i=0,$count=count($param); $i < $count; $i++) {
			if(preg_match('/^(code=|state=|wecha_id=).*/', $param[$i])){
				unset($param[$i]);
			}
		}
		return join('&',$param);
	}
	
	//获取token
	public function  getToken(){
		//$url 	= "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appId."&secret=".$this->appsecret;
		//return $this->https_request($url);
	}

	public function getTicket($token){
		$now 	= time();
		$ticketData 	= S($this->appid.'_shareTicket');

		if($ticketData['ticket'] == '' || $ticketData['expires_in'] < $now ){

			$url 	= "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$token."&type=jsapi";
			$res 	= $this->https_request($url);

			if($res['errcode'] 	> 0){
				return array('errcode'=>$res['errcode'],'errmsg'=>$res['errMsg']);
			}else{
				S($this->appid.'_shareTicket',array('ticket'=>$res['ticket'],'expires_in'=>$res['expires_in']+$now));
				return $res['ticket'];
			}

		}else{

			return $ticketData['ticket'];

		}
	}


	/*创建分享html*/
	public function createHtml($sign_data,$share_conf){

	$html 	= <<<EOM
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
		wx.config({
		  debug: false,
		  appId: 	'{$sign_data['appId']}',
		  timestamp: {$sign_data['timestamp']},
		  nonceStr: '{$sign_data['nonceStr']}',
		  signature: '{$sign_data['signature']}',
		  jsApiList: [
	    	'checkJsApi',
		    'onMenuShareTimeline',
		    'onMenuShareAppMessage',
		    'onMenuShareQQ',
		    'onMenuShareWeibo',
			'openLocation',
			'getLocation',
			'addCard',
			'chooseCard',
			'openCard',
			'hideMenuItems',
			'getLocation'
		  ]
		});
	</script>
	<script type="text/javascript">
	wx.ready(function () {
	  // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
	  /*document.querySelector('#checkJsApi').onclick = function () {
	    wx.checkJsApi({
	      jsApiList: [
	        'getNetworkType',
	        'previewImage'
	      ],
	      success: function (res) {
	        //alert(JSON.stringify(res));
	      }
	    });
	  };*/
	  // 2. 分享接口
	  // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
	    wx.onMenuShareAppMessage({
			title: '{$share_conf['title']}',
			desc: '{$share_conf['desc']}',
			link: '{$share_conf['link']}',
			imgUrl: '{$share_conf['imgUrl']}',
		    type: '', // 分享类型,music、video或link，不填默认为link
		    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		    success: function () { 
				//shareHandle('frined');
		    },
		    cancel: function () { 
		        //alert('分享朋友失败');
		    }
		});


	  // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
		wx.onMenuShareTimeline({
			title: '{$share_conf['title']}',
			link: '{$share_conf['link']}',
			imgUrl: '{$share_conf['imgUrl']}',
		    success: function () { 
				//shareHandle('frineds');
		        //alert('分享朋友圈成功');
		    },
		    cancel: function () { 
		        //alert('分享朋友圈失败');
		    }
		});	

	  // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
		wx.onMenuShareWeibo({
			title: '{$share_conf['title']}',
			desc: '{$share_conf['desc']}',
			link: '{$share_conf['link']}',
			imgUrl: '{$share_conf['imgUrl']}',
		    success: function () { 
				//shareHandle('weibo');
		       	//alert('分享微博成功');
		    },
		    cancel: function () { 
		        //alert('分享微博失败');
		    }
		});
		wx.error(function (res) {
			/*if(res.errMsg == 'config:invalid signature'){
				wx.hideOptionMenu();
			}else if(res.errMsg == 'config:invalid url domain'){
				wx.hideOptionMenu();
			}else{
				wx.hideOptionMenu();
				//alert(res.errMsg);
			}*/
			if(res.errMsg){
				wx.hideOptionMenu();
			}
		});
	});
		
	function shareHandle(to) {
		/*
		var submitData = {
			module: window.shareData.moduleName,
			moduleid: window.shareData.moduleID,
			token:'{$this->wxuser['token']}',
			wecha_id:'{$this->wecha_id}',
			url: window.shareData.sendFriendLink,
			to:to
		};

		$.post('index.php?g=Wap&m=Share&a=shareData&token={$this->wxuser['token']}&wecha_id={$this->wecha_id}',submitData,function (data) {},'json')
		*/
	}
</script>
EOM;
		return $html;
	}
	
	//https请求（支持GET和POST）
	protected function https_request($url, $data = null)
	{
		$curl = curl_init();
		$header = array("Accept-Charset: utf-8");
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		//curl_setopt($curl, CURLOPT_SSLVERSION, 3);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		if (!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		$errorno= curl_errno($curl);
		if ($errorno) {
			return array('curl'=>false,'errorno'=>$errorno);
		}else{
			$res = json_decode($output,1);

			if ($res['errcode']){
				return array('errcode'=>$res['errcode'],'errmsg'=>$res['errmsg']);
			}else{
				return $res;
			}
		}
		curl_close($curl);
	}
	
	/**
	 * 分享
	 * @param Array $params
	 * @return string
	 */
	public function getShareData($params = array()) {
		$params['moduleName'] = empty($params['moduleName']) ? MODULE_NAME : $params['moduleName'];
		$params['moduleID'] = empty($params['moduleID']) ? 0 : $params['moduleID'];
		$params['imgUrl'] = empty($params['imgUrl']) ? '' : $params['imgUrl'];
		if (empty($params['sendFriendLink'])) {
			$params['sendFriendLink'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$parseUrl = parse_url($params['sendFriendLink']);
			parse_str(htmlspecialchars_decode($parseUrl['query']), $query);
			$wecha_id = isset($query['wecha_id']) ? $query['wecha_id'] : '';
			if (1 == count($query)) {
				$wecha_id = '\?wecha_id='.$wecha_id;
			} else {
				$wecha_id = '&wecha_id='.$wecha_id.'|'.'wecha_id='.$wecha_id.'&';
			}
			$params['sendFriendLink'] =  preg_replace("/$wecha_id/i", '', $params['sendFriendLink']);
		} else {
			$params['sendFriendLink'] = stripslashes($params['sendFriendLink']);
		}
		$params['tTitle'] = empty($params['tTitle']) ? '' : shareFilter($params['tTitle']);
		$params['tContent'] = empty($params['tContent']) ? $params['tTitle'] : shareFilter($params['tContent']);		
		$shareData = str_replace('\\/', '/',  json_encode($params));
		$html 	= <<<EOM
		<script type="text/javascript">
				window.shareData = $shareData;
		</script>
EOM;
		return $html;
	}
}

?>