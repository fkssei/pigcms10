<?php
define('PIGCMS_PATH', dirname(dirname(__FILE__)).'/');
require_once PIGCMS_PATH.'source/init.php';

$t_configs = D('Config')->field('`name`,`value`')->select();
foreach($t_configs as $key=>$value){
	$t_config[$value['name']] = $value['value'];
}

$_G['config'] = $t_config;

$action = isset($_GET['a']) ? addslashes($_GET['a']) : 'index';
import("source.class.Wechat");
$wechat = new Wechat($t_config);

if ($action == 'index') {
	$data = $wechat->request();
	list($content, $type) = reply($data);
	$wechat->response($content, $type);
} elseif ($action == 'get_ticket') {
	//获取 component_verify_ticket 每十分钟微信服务本服务器请求一次
	$data = $wechat->request();
	if(isset($data['InfoType'])) {
		if ($data['InfoType'] == 'component_verify_ticket') {
			if (isset($data['ComponentVerifyTicket']) && $data['ComponentVerifyTicket']) {
				if ($config = D('Config')->where("`name`='wx_componentverifyticket'")->find()) {
					D('Config')->where("`name`='wx_componentverifyticket'")->data(array('value' => $data['ComponentVerifyTicket']))->save();
				} else {
					D('Config')->data(array('name' => 'wx_componentverifyticket', 'value' => $data['ComponentVerifyTicket'], 'type' => 'type=text', 'gid' => 0, 'tab_id' => 0))->add();
				}
				F('config', null);
				exit('success');
			}
		} elseif ($data['InfoType'] == 'unauthorized') {
			if (isset($data['AuthorizerAppid']) && $data['AuthorizerAppid']) {
				$weixin_bind = D('Weixin_bind')->where("`authorizer_appid`='{$data['AuthorizerAppid']}'")->find();
				if (!empty($weixin_bind)) {
					D('Weixin_bind')->where("`authorizer_appid`='{$data['AuthorizerAppid']}'")->delete();
					D('Store')->data(array('open_weixin' => '0'))->where(array('store_id' => $weixin_bind['store_id']))->save();
				}
				exit('success');
			}
		}
	}
}


function reply($data)
{
	$user_name = $data['ToUserName'];
	$keyword = isset($data['Content']) ? $data['Content'] : (isset($data['EventKey']) ? $data['EventKey'] : '');
	if($data['ToUserName'] == 'gh_3c884a361561'){
		if ($data['MsgType'] == 'event') {
			return array($data['Event'] . 'from_callback', 'text');
		}
	
		if ($keyword == 'TESTCOMPONENT_MSG_TYPE_TEXT') {
			return array('TESTCOMPONENT_MSG_TYPE_TEXT_callback', 'text');
		}
		if (strstr($keyword, 'QUERY_AUTH_CODE:')) {
			$t = explode(':', $keyword);
			$query_auth_code = $t[1];
			$access_token = get_access_token($query_auth_code);
			$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $access_token;
			$str = '{"touser":"'. $data['FromUserName'] .'", "msgtype":"text", "text":{"content":"' . $query_auth_code . '_from_api"}}';
			import('source.class.Http');
			Http::curlPost($url, $str);
		}
	}
	
// 	$user_name = $data['FromUserName'];
	$weixin_bind = D('Weixin_bind')->where(array('user_name' => $user_name))->find();
	if ($data['MsgType'] == 'event') {
		$id = $data['EventKey'];
		switch (strtoupper($data['Event'])) {
			case 'SCAN':
// 				return $this->scan($id, $data['FromUserName']);
				break;
			case 'CLICK':
				
				if ($menu = D('Diymenu_class')->where(array('store_id' => $weixin_bind['store_id'], 'title' => $id))->find()) {
					switch ($menu['type']) {
						case 0:
							return array($menu['content'], 'text');
							break;
						case 1:
							$source = D('Source_material')->where(array('pigcms_id' => $menu['fromid']))->find();
							$it_ids = unserialize($source['it_ids']);
							$images = D('Image_text')->where(array('pigcms_id' => array('in', $it_ids)))->select();
							$return = array();
							foreach ($images as $im) {
								$return[] = array($im['title'], $im['digest'], getAttachmentUrl($im['cover_pic']), $im['url']);
							}
							return array($return, 'news');
							break;
					}
				}
				return array('系统暂时不能给出对应的回复', 'text');
				
				break;
			case 'SUBSCRIBE'://首次关注的回复
// 				if (isset($data['Ticket'])) {		//扫描二维码时关注 后对应的信息
// 					$id = substr($data['EventKey'], 8);
// 					return $this->scan($id, $data['FromUserName']);
// 				}
				if ($rule = D("Rule")->where(array('store_id' => $weixin_bind['store_id'], 'type' => 1))->find()) {
					return special_keyword($rule['pigcms_id'], $weixin_bind['store_id']);
				} else {
					return array("感谢您的关注，我们将竭诚为您服务！", 'text');
				}
				break;
			case 'UNSUBSCRIBE'://取消关注
				return array("BYE-BYE", 'text');
				break;
			case 'LOCATION':
// 				if ($long_lat = D("User_long_lat")->field(true)->where(array('open_id' => $data['FromUserName']))->find()) {
// 					D("User_long_lat")->where(array('open_id' => $data['FromUserName']))->save(array('long' => $data['Longitude'], 'lat' => $data['Latitude'], 'dateline' => time()));
// 				} else {
// 					D("User_long_lat")->add(array('long' => $data['Longitude'], 'lat' => $data['Latitude'], 'dateline' => time(), 'open_id' => $data['FromUserName']));
// 				}
				break;
			default:
		}
	} elseif ($data['MsgType'] == 'text') {//文本
		$content = $data['Content'];
		if ($keyword = D('Keyword')->where(array('content' => $content, 'store_id' => $weixin_bind['store_id']))->find()) {
			return special_keyword($keyword['from_id'], $weixin_bind['store_id']);
		}
		return array('系统暂时不能找到[' . $content . ']关键词对应的回复', 'text');
	} elseif ($data['MsgType'] == 'location') {//发送坐标的时候回复的内容
// 		return array($return, 'news');
	} else {
	}
	return false;
}



function get_access_token($auth_code)
{
	import('source.class.Http');
	$url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
	$data = array('component_appid' => option('config.wx_appid'), 'component_appsecret' => option('config.wx_appsecret'), 'component_verify_ticket' => option('config.wx_componentverifyticket'));
	$result = Http::curlPost($url, json_encode($data));
	if ($result['errcode']) {
		return false;
	}
	//获取 authorizer_appid
	$url = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=' . $result['component_access_token'];//
	$data = array('component_appid' => option('config.wx_appid'), 'authorization_code' => $auth_code);
	$result1 = Http::curlPost($url, json_encode($data));

	if ($result1['errcode']) {
		return false;
	}
	return $result1['authorization_info']['authorizer_access_token'];
}

function special_keyword($rule_id, $store_id)
{
	$reply_relation = D('Reply_relation')->where(array('rid' => $rule_id, 'store_id' => $store_id))->select();
	$index = array_rand($reply_relation);
	$reply = $reply_relation[$index];
	switch ($reply['type']) {
		case 0:
			$tail = '';
			if ($reply_tail = D('Reply_tail')->where(array('store_id' => $store_id))->find()) {
				if ($reply_tail['is_open']) {
					$tail = ' 『' . $reply_tail['content'] . '』';
				}
			}
			$text = D('Text')->where(array('pigcms_id' => $reply['cid']))->find();
			return array($text['content'] . $tail, 'text');
			break;
		case 1:
			$source = D('Source_material')->where(array('pigcms_id' => $reply['cid']))->find();
			$it_ids = unserialize($source['it_ids']);
			$images = D('Image_text')->where(array('pigcms_id' => array('in', $it_ids)))->select();
			$return = array();
			foreach ($images as $im) {
				$return[] = array($im['title'], $im['digest'], getAttachmentUrl($im['cover_pic']), $im['url']);
			}
			return array($return, 'news');
			break;
			case 2:
				//TODO operate music
				break;
			case 3:
				if ($product = D('Product')->where(array('store_id' => $reply['store_id'], 'product_id' => $reply['cid']))->find()) {
					$return[] = array($product['name'], $product['image'], option('config.wap_site_url') . '/good.php?id=' . $product['product_id']);
					return array($return, 'news');
				}
				break;
			case 4:
				if ($group = D('Product_group')->where(array('store_id' => $reply['store_id'], 'group_id' => $reply['cid']))->find()) {
					$return[] = array($group['group_name'],'', '', option('config.wap_site_url') . '/goodcat.php?id=' . $group['group_id']);
					return array($return, 'news');
				}
				break;
			case 5:
				if ($page = D('Wei_page')->where(array('store_id' => $reply['store_id'], 'page_id' => $reply['cid']))->find()) {
					$return[] = array($page['page_name'],'', '', option('config.wap_site_url') . '/page.php?id=' . $page['page_id']);
					return array($return, 'news');
				}
				break;
			case 6:
				if ($category = D('Wei_page_category')->where(array('store_id' => $reply['store_id'], 'cat_id' => $reply['cid']))->find()) {
					$return[] = array($category['cat_name'],'', '', option('config.wap_site_url') . '/pagecat.php?id=' . $category['cat_id']);
					return array($return, 'news');
				}
				break;
			case 7:
				$return[] = array('店铺主页','', '', option('config.wap_site_url') . '/home.php?id=' . $reply['cid']);
				return array($return, 'news');
			case 8:
				$return[] = array('会员主页','', '', option('config.wap_site_url') . '/ucenter.php?id=' . $reply['cid']);
				return array($return, 'news');
				break;
	}
}
