<?php
class weixin_controller extends base_controller
{
	private $face = array(1 => '[微笑]', '[撇嘴]','[色]','[发呆]','[得意]','[流泪]','[害羞]','[闭嘴]','[睡]','[大哭]','[尴尬]','[发怒]','[调皮]','[呲牙]','[惊讶]','[难过]','[酷]','[冷汗]','[抓狂]','[吐]','[偷笑]','[愉快]','[白眼]','[傲慢]','[饥饿]','[困]','[惊恐]','[流汗]','[憨笑]','[悠闲]','[奋斗]','[咒骂]','[疑问]','[嘘]','[晕]','[疯了]','[衰]','[骷髅]','[敲打]','[再见]','[擦汗]','[抠鼻]','[鼓掌]','[糗大了]','[坏笑]','[左哼哼]','[右哼哼]','[哈欠]','[鄙视]','[委屈]','[快哭了]','[阴险]','[亲亲]','[吓]','[可怜]','[菜刀]','[西瓜]','[啤酒]','[篮球]','[乒乓]','[咖啡]','[饭]','[猪头]','[玫瑰]','[凋谢]','[嘴唇]','[爱心]','[心碎]','[蛋糕]','[闪电]','[炸弹]','[刀]','[足球]','[瓢虫]','[便便]','[月亮]','[太阳]','[礼物]','[拥抱]','[强]','[弱]','[握手]','[胜利]','[抱拳]','[勾引]','[拳头]','[差劲]','[爱你]','[NO]','[OK]','[爱情]','[飞吻]','[跳跳]','[发抖]','[怄火]','[转圈]','[磕头]','[回头]','[跳绳]','[投降]','[激动]','[乱舞]','[献吻]','[左太极]','[右太极]');
	private $face_key = array(1 => "/::)", "/::~", "/::B", "/::|", "/:8-)", "/::<", "/::$", "/::X", "/::Z", "/::'(", "/::-|", "/::@", "/::P", "/::D", "/::O", "/::(", "/::+", "/:--b", "/::Q", "/::T", "/:,@P", "/:,@-D", "/::d", "/:,@o", "/::g", "/:|-)", "/::!", "/::L", "/::>", "/::,@", "/:,@f", "/::-S", "/:?", "/:,@x", "/:,@@", "/::8", "/:,@!", "/:!!!", "/:xx", "/:bye", "/:wipe", "/:dig", "/:handclap", "/:&amp;-(", "/:B-)", "/:<@", "/:@>", "/::-O", "/:>-|", "/:P-(", "/::'|", "/:X-)", "/::*", "/:@x", "/:8*", "/:pd", "/:<W>", "/:beer", "/:basketb", "/:oo", "/:coffee", "/:eat", "/:pig", "/:rose", "/:fade", "/:showlove", "/:heart", "/:break", "/:cake", "/:li", "/:bome", "/:kn", "/:footb", "/:ladybug", "/:shit", "/:moon", "/:sun", "/:gift", "/:hug", "/:strong", "/:weak", "/:share", "/:v", "/:@)", "/:jj", "/:@@", "/:bad", "/:lvu", "/:no", "/:ok", "/:love", "/:<L>", "/:jump", "/:shake", "/:<O>", "/:circle", "/:kotow", "/:turn", "/:skip", "/:oY", "/:#-0", "/:hiphot", "/:kiss", "/:<&amp;", "/:&amp;>");
	private $face_image = array();
	private $weixin_bind_info = array();

	public function __construct()
	{
		parent::__construct();
		$bind = D('Weixin_bind')->where(array('store_id' => $this->store_session['store_id']))->find();
		if (!in_array(ACTION_NAME, array('auth', 'get_url', 'auth_back')) && empty($bind)) {
			header('Location:' . $this->config['site_url'] . '/user.php?c=weixin&a=auth');
			exit();
		} elseif (ACTION_NAME == 'auth' && $bind) {
			header('Location:' . $this->config['site_url'] . '/user.php?c=weixin&a=index');
			exit();
		}
		
		$this->weixin_bind_info = $bind;
		$this->assign('weixin_bind_info',$this->weixin_bind_info);

		for ($i = 1; $i < 106; $i++) $this->face_image[$i] = '<img src="/static/images/qq/' . $i . '.gif" />';
	}
	
	public function index()
	{
		$this->display();
	}
	public function load()
	{
		$count = D('Source_material')->where(array('store_id' => $this->store_session['store_id']))->count('pigcms_id');
		import('source.class.user_page');
		$p = new Page($count, 10);
		$list = D('Source_material')->where(array('store_id' => $this->store_session['store_id']))->order('pigcms_id DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$it_ids = array();
		$temp = array();
		foreach ($list as $l) {
			foreach (unserialize($l['it_ids']) as $id) {
				if (!in_array($id, $it_ids)) $it_ids[] = $id;
				$temp[$id] = $l;
			}
		}
		
		$result = array();
		$image_text = D('Image_text')->field('pigcms_id, title')->where(array('pigcms_id' => array('in', $it_ids)))->order('pigcms_id asc')->select();
		foreach ($image_text as $txt) {
			if (!isset($result[$temp[$txt['pigcms_id']]['pigcms_id']])) {
				$result[$temp[$txt['pigcms_id']]['pigcms_id']] = $temp[$txt['pigcms_id']];//$txt;
			}
			$result[$temp[$txt['pigcms_id']]['pigcms_id']]['list'][] = $txt;
		}
		$this->assign('list', $result);
		$this->assign('page', $p->show());
		$this->assign('info_url', $this->config['wap_site_url'] . '/imagetxt.php?id=');
		$this->display();
	}
	
	public function one()
	{
		$pigcms_id = isset($_GET['pigcms_id']) ? intval($_GET['pigcms_id']) : 0;
		$image_text = array('title' => '标题', 'cover_pic' => '', 'author' => '', 'content' => '', 'digest' => '', 'url' => '', 'dateline' => time(), 'pigcms_id' => 0);
		if ($data = D('Source_material')->where(array('pigcms_id' => $pigcms_id, 'store_id' => $this->store_session['store_id']))->find()) {
			$it_ids = unserialize($data['it_ids']);
			$id = isset($it_ids[0]) ? intval($it_ids[0]) : 0;
			$image_text = D('Image_text')->where(array('pigcms_id' => $id, 'store_id' => $this->store_session['store_id']))->find();
		}
		$this->assign('pigcms_id', $pigcms_id);
		$this->assign('image_text', $image_text);
		$this->display();
	}
	
	public function multi()
	{
		$pigcms_id = isset($_GET['pigcms_id']) ? intval($_GET['pigcms_id']) : 0;
		$contents = array(array('title' => '', 'cover_pic' => '', 'author' => '', 'content' => '', 'digest' => '', 'url' => '', 'url_title' => '', 'id' => 0), array('title' => '', 'cover_pic' => '', 'author' => '', 'content' => '', 'digest' => '', 'url' => '', 'url_title' => '', 'id' => 0));
		$image_text = array();
		if ($data = D('Source_material')->where(array('pigcms_id' => $pigcms_id, 'store_id' => $this->store_session['store_id']))->find()) {
			$it_ids = unserialize($data['it_ids']);
			$image_text = D('Image_text')->where(array('pigcms_id' => array('in', $it_ids)))->order('pigcms_id asc')->select();
			$contents  = array();
			foreach ($image_text as $t) {
				$t['id'] = $t['pigcms_id'];
				unset($t['store_id'], $t['dateline'], $t['pigcms_id']);
				$contents[] = $t;
			}
		}
		$this->assign('contents', json_encode($contents));
		$this->assign('text_list', $image_text);
		$this->assign('pigcms_id', $pigcms_id);
		$this->display();
	}
	
	public function fetch_wentu()
	{
		$pigcms_id = isset($_GET['pigcms_id']) ? intval($_GET['pigcms_id']) : 0;
		$image_text = array();
		if ($data = D('Source_material')->where(array('pigcms_id' => $pigcms_id, 'store_id' => $this->store_session['store_id']))->find()) {
			$it_ids = unserialize($data['it_ids']);
			if ($data['type'] == 0) {
				$id = isset($it_ids[0]) ? intval($it_ids[0]) : 0;
				$image_text = D('Image_text')->where(array('pigcms_id' => $id, 'store_id' => $this->store_session['store_id']))->find();
				$image_text['info_url'] = $this->config['wap_site_url'] . '/imagetxt.php?id=' . $image_text['pigcms_id'];
				$image_text['date'] = date('Y-m-d');
			} else {
				$image_text = D('Image_text')->where(array('pigcms_id' => array('in', $it_ids)))->order('pigcms_id asc')->select();
				foreach ($image_text as &$val) {
					$val['info_url'] = $this->config['wap_site_url'] . '/imagetxt.php?id=' . $val['pigcms_id'];
				}
			}
			exit(json_encode(array('error' => 0, 'data' => $image_text, 'type' => $data['type'], 'pigcms_id' => $pigcms_id)));
		} else {
			exit(json_encode(array('error' => 1, 'msg' => 'ok')));
		}
	}
	
	public function save_image_text()
	{
		$pigcms_id = isset($_POST['pigcms_id']) ? intval($_POST['pigcms_id']) : 0;
		$thisid = isset($_POST['thisid']) ? intval($_POST['thisid']) : 0;
		$data['content'] = isset($_POST['content']) ? $_POST['content'] : '';
		$data['title'] = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
		$data['author'] = isset($_POST['author']) ? htmlspecialchars($_POST['author']) : '';
		$data['url'] = isset($_POST['url']) ? htmlspecialchars($_POST['url']) : '';
		$data['url_title'] = isset($_POST['url_title']) ? htmlspecialchars($_POST['url_title']) : '';
		$data['cover_pic'] = isset($_POST['cover_pic']) ? htmlspecialchars($_POST['cover_pic']) : '';
		$data['digest'] = isset($_POST['digest']) ? htmlspecialchars($_POST['digest']) : '';
		$data['is_show'] = isset($_POST['is_show']) ? intval($_POST['is_show']) : 0;
		if (empty($data['title'])) {
			exit(json_encode(array('error_code' => 1, 'msg' => '标题不能为空')));
		}
		if (empty($data['cover_pic'])) {
			exit(json_encode(array('error_code' => 1, 'msg' => '必须得有封面图')));
		}
		$data['cover_pic'] = str_replace(array('./',$this->config['site_url'].'/'),'',$data['cover_pic']);
		if (empty($data['content'])) {
			exit(json_encode(array('error_code' => 1, 'msg' => '内容不能为空')));
		}
		$data['dateline'] = time();
		$data['store_id'] = $this->store_session['store_id'];
		if ($pigcms_id && $thisid) {
			if (D('Image_text')->where(array('pigcms_id' => $thisid, 'store_id' => $this->store_session['store_id']))->data($data)->save()) {
				D('Source_material')->where(array('pigcms_id' => $pigcms_id, 'store_id' => $this->store_session['store_id']))->data(array('it_ids' => serialize(array($thisid)), 'store_id' => $this->store_session['store_id'], 'dateline' => time()))->save();
				exit(json_encode(array('error_code' => 0, 'msg' => 'ok')));
			} else {
				exit(json_encode(array('error_code' => 1, 'msg' => '操作失败稍后重试！')));
			}
		} else {
			if ($id = D('Image_text')->data($data)->add()) {
				D('Source_material')->data(array('it_ids' => serialize(array($id)), 'store_id' => $this->store_session['store_id'], 'dateline' => time()))->add();
				exit(json_encode(array('error_code' => 0, 'msg' => 'ok')));
			} else {
				exit(json_encode(array('error_code' => 1, 'msg' => '操作失败稍后重试！')));
			}
		}
	}
	
	public function save_multi_image_text()
	{
		$id = 0;
		$pigcms_id = isset($_POST['pigcms_id']) ? intval($_POST['pigcms_id']) : 0;
		$data = isset($_POST['data']) ? $_POST['data'] : '[]';
		$data = json_decode($data, true);
		if (empty($data)) exit(json_encode(array('error_code' => 1, 'msg' => '数据为空', 'index' => -1)));
		foreach ($data as $i => $val) {
			if (empty($val['title'])) {
				exit(json_encode(array('error_code' => 1, 'msg' => '标题不能为空', 'index' => $i)));
			}
			if (empty($val['cover_pic'])) {
				exit(json_encode(array('error_code' => 1, 'msg' => '必须选择一张图片', 'index' => $i)));
			}
			if (empty($val['content'])) {
				exit(json_encode(array('error_code' => 1, 'msg' => '正文不能为空', 'index' => $i)));
			}
		}
		$flag = false;
		$delete_ids = $ids = array();
		$now_time = time();
		foreach ($data as $d) {
			$d['dateline'] = $now_time;
			$d['store_id'] = $this->store_session['store_id'];
			$d['title'] = htmlspecialchars($d['title']);
			$d['author'] = htmlspecialchars($d['author']);
			$d['cover_pic'] = $d['cover_pic'] ? substr(htmlspecialchars($d['cover_pic']), 1) : '';
			$d['digest'] = htmlspecialchars($d['digest']);
			$d['url'] = htmlspecialchars($d['url']);

			if ($d['url'] == 'homepage') {
				$d['url'] = $this->config['wap_site_url'] . '/home.php?id=' . $this->store_session['store_id'];
			}
			if ($d['url'] == 'usercenter') {
				$d['url'] = $this->config['wap_site_url'] . '/ucenter.php?id=' . $this->store_session['store_id'];
			}
			
			$d['url_title'] = htmlspecialchars($d['url_title']);
			if ($d['id'] && $pigcms_id) {
				if (D('Image_text')->where(array('pigcms_id' => $d['id'], 'store_id' => $this->store_session['store_id']))->data($d)->save()) {
					$ids[] = $d['id'];
				} else {
					$flag = true;
					break;
				}
			} else {
				unset($d['id']);
				$id = D('Image_text')->data($d)->add();
				if (empty($id)) {
					$flag = true;
					break;
				} else {
					$ids[] = $id;
					$delete_ids[] = $id;
				}
			}
		}
		if ($flag) {
			if ($delete_ids) {
				D('Image_text')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => array('in', $delete_ids)))->delete();
			}
			exit(json_encode(array('error_code' => 1, 'msg' => '操作失败稍后重试！', 'index' => -1)));
		} else {
			if ($pigcms_id) {
				D('Source_material')->where(array('pigcms_id' => $pigcms_id, 'store_id' => $this->store_session['store_id']))->data(array('it_ids' => serialize($ids), 'store_id' => $this->store_session['store_id'], 'dateline' => $now_time, 'type' => 1))->save();
			} else {
				D('Source_material')->data(array('it_ids' => serialize($ids), 'store_id' => $this->store_session['store_id'], 'dateline' => $now_time, 'type' => 1))->add();
			}
			exit(json_encode(array('error_code' => 0, 'msg' => 'ok')));
		}
	}
	
	public function delete_source_material()
	{
		$pigcms_id = isset($_GET['pigcms_id']) ? intval($_GET['pigcms_id']) : 0;
		if ($source_material = D('Source_material')->where(array('pigcms_id' => $pigcms_id, 'store_id' => $this->store_session['store_id']))->find()) {
			D('Image_text')->where(array('pigcms_id' => array('in', unserialize($source_material['it_ids'])), 'store_id' => $this->store_session['store_id']))->delete();
			D('Source_material')->where(array('pigcms_id' => $pigcms_id, 'store_id' => $this->store_session['store_id']))->delete();
			exit(json_encode(array('error_code' => 0, 'msg' => '删除图文素材成功')));
		} else {
			exit(json_encode(array('error_code' => 1, 'msg' => '删除图文素材失败，稍后重试！')));
		}
	}
	
	
	public function get_wentu()
	{
		$where = array('store_id' => $this->store_session['store_id']);
		if (isset($_POST['type'])) {
			$where['type'] = intval($_POST['type']);
		}
		$count = D('Source_material')->where($where)->count('pigcms_id');
		import('source.class.user_page');
		$p = new Page($count, 3);
		$list = D('Source_material')->where($where)->order('pigcms_id DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$it_ids = array();
		$temp = array();
		foreach ($list as $l) {
			$l['dateline'] = date('Y-m-d <br> H:i:s', $l['dateline']);
			foreach (unserialize($l['it_ids']) as $id) {
				$it_ids[] = $id;
				$temp[$id] = $l;
			}
		}
		$result = array();
		$image_text = D('Image_text')->field('pigcms_id, title')->where(array('pigcms_id' => array('in', $it_ids)))->order('pigcms_id asc')->select();
		foreach ($image_text as $txt) {
			$txt['info_url'] = $this->config['wap_site_url'] . '/imagetxt.php?id=' . $txt['pigcms_id'];
			if (!isset($result[$temp[$txt['pigcms_id']]['pigcms_id']])) {
				$result[$temp[$txt['pigcms_id']]['pigcms_id']] = $temp[$txt['pigcms_id']];//$txt;
			}
			$result[$temp[$txt['pigcms_id']]['pigcms_id']]['list'][] = $txt;
		}
		exit(json_encode(array('data' => $result, 'page' => $p->show())));
	}
	public function auto()
	{
		
		$this->assign('home_url', $this->config['wap_site_url'] . '/home.php?id=' . $this->store_session['store_id']);
		$this->assign('member_url', $this->config['wap_site_url'] . '/ucenter.php?id=' . $this->store_session['store_id']);
		$this->display();
	}
	
	public function auto_load()
	{
		$keyword = isset($_POST['keyword']) ? htmlspecialchars($_POST['keyword']) : '';
		$where = array('store_id' => $this->store_session['store_id'], 'type' => 0);
		if ($keyword) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}
		$this->assign('keyword', $keyword);
		$count = D('Rule')->where($where)->count('pigcms_id');
		import('source.class.user_page');
		$p = new Page($count, 10);
		$list = D('Rule')->where($where)->order('pigcms_id DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$rids = array();
		foreach ($list as $l) {
			$rids[] = $l['pigcms_id'];
		}
		if ($rids) {
			$keywords = D('Keyword')->where(array('store_id' => $this->store_session['store_id'], 'from_id' => array('in', $rids)))->select();
			$k_list = array();// = array(rid => array(), ...)
			foreach ($keywords as $key) {
				$key['show_content'] = str_replace($this->face_key, $this->face_image, $key['content']);
				if (isset($k_list[$key['from_id']])) {
					$k_list[$key['from_id']][] = $key;
				} else {
					$k_list[$key['from_id']] = array($key);
				}
			}
			
			$c_ids = array();//type [0:文本，1：图文，2：音乐，3：商品，4：商品分类，5：微页面，6：微页面分类，7：店铺主页，8：会员主页]
			$v0_list = $v1_list = $v2_list = $v3_list = $v4_list = $v5_list = $v6_list = $v7_list = $v8_list = array();// = array(rid => cid, ...)
			$r_list = array();// = array(rid => array(), ...)
			
			$reply_relations = D('Reply_relation')->where(array('store_id' => $this->store_session['store_id'], 'rid' => array('in', $rids)))->select();
			foreach ($reply_relations as $re) {
				$c_ids[$re['type']][] = $re['cid'];
// 				if ($re['type'] == 0) {
				${"v{$re['type']}_list"}[$re['cid']]['rule'] = $re['rid'];//内容id 对应规则id
				${"v{$re['type']}_list"}[$re['cid']]['reply'] = $re['pigcms_id'];//内容id 对应规则id
// 				} elseif ($re['type'] == 1) {
// 					$v1_list[$re['cid']]['rule'] = $re['rid'];//内容id 对应规则id
// 					$v1_list[$re['cid']]['reply'] = $re['pigcms_id'];//内容id 对应规则id
// 				}
			}
			//0:文本
			if (isset($c_ids[0]) && $c_ids[0]) {
				$texts = D('Text')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => array('in', $c_ids[0])))->select();
				foreach ($texts as $text) {
					$text['show_content'] = str_replace($this->face, $this->face_image, $text['content']);
					$text['reply_type'] = 0;
					$text['cid'] = $text['pigcms_id'];
					$text['reply_id'] = $v0_list[$text['pigcms_id']]['reply'];
					$r_list[$v0_list[$text['pigcms_id']]['rule']][] = $text;
				}
			}
			//1:图文
			if (isset($c_ids[1]) && $c_ids[1]) {
				$lists = D('Source_material')->where(array('pigcms_id' =>  array('in', $c_ids[1]), 'store_id' => $this->store_session['store_id']))->select();
				$temp = array();// array(image_text_id => source_material_id, ...)
				foreach ($lists as $l) {
					$tids = unserialize($l['it_ids']);
					if (isset($tids[0]) && $tids[0]) {
						$it_ids[] = $tids[0];
						$temp[$tids[0]] = $l['pigcms_id']; //cid  sid
					}
				}
				
				if ($it_ids) {
					$image_text_list = array();
					$image_texts = D('Image_text')->where(array('pigcms_id' => array('in', $it_ids), 'store_id' => $this->store_session['store_id']))->select();
					foreach ($image_texts as $image) {
						$image['info_url'] = $this->config['wap_site_url'] . '/imagetxt.php?id=' . $image['pigcms_id'];
						$image_text_list[$temp[$image['pigcms_id']]] = $image;
					}
					foreach ($image_text_list as $sid => $val) {
						$val['reply_type'] = 1;
						$val['cid'] = $sid;
						$val['reply_id'] = $v1_list[$sid]['reply'];
						$r_list[$v1_list[$sid]['rule']][] = $val;
					}
				}
			}
			
			//3:商品
			if (isset($c_ids[3]) && $c_ids[3]) {
				$products = D('Product')->where(array('store_id' => $this->store_session['store_id'], 'product_id' => array('in', $c_ids[3])))->select();
				foreach ($products as $product) {
					$product['reply_type'] = 3;
					$product['cid'] = $product['product_id'];
					$product['title'] = $product['name'];
					$product['info_url'] = $this->config['wap_site_url'] . '/good.php?id=' . $product['product_id'];
					$product['reply_id'] = $v3_list[$product['product_id']]['reply'];
					$r_list[$v3_list[$product['product_id']]['rule']][] = $product;
				}
			}
			//4:商品分类
			if (isset($c_ids[4]) && $c_ids[4]) {
				$groups = D('Product_group')->where(array('store_id' => $this->store_session['store_id'], 'group_id' => array('in', $c_ids[4])))->select();
				foreach ($groups as $group) {
					$group['reply_type'] = 4;
					$group['cid'] = $group['group_id'];
					$group['title'] = $group['group_name'];
					$group['info_url'] = $this->config['wap_site_url'] . '/goodcat.php?id=' . $group['group_id'];
					$group['reply_id'] = $v4_list[$group['group_id']]['reply'];
					$r_list[$v4_list[$group['group_id']]['rule']][] = $group;
				}
			}
			
			//5:微页面
			if (isset($c_ids[5]) && $c_ids[5]) {
				$pages = D('Wei_page')->where(array('store_id' => $this->store_session['store_id'], 'page_id' => array('in', $c_ids[5])))->select();
				foreach ($pages as $page) {
					$page['reply_type'] = 5;
					$page['cid'] = $page['page_id'];
					$page['title'] = $page['page_name'];
					$page['reply_id'] = $v5_list[$page['page_id']]['reply'];
					$page['info_url'] = $this->config['wap_site_url'] . '/page.php?id=' . $page['page_id'];
					$r_list[$v5_list[$page['page_id']]['rule']][] = $page;
				}
			}
			//6:微页面分类
			if (isset($c_ids[6]) && $c_ids[6]) {
				$categorys = D('Wei_page_category')->where(array('store_id' => $this->store_session['store_id'], 'cat_id' => array('in', $c_ids[6])))->select();
				foreach ($categorys as $category) {
					$category['reply_type'] = 6;
					$category['cid'] = $category['cat_id'];
					$category['title'] = $category['cat_name'];
					$category['info_url'] = $this->config['wap_site_url'] . '/pagecat.php?id=' . $category['cat_id'];
					$category['reply_id'] = $v6_list[$category['cat_id']]['reply'];
					$r_list[$v6_list[$category['cat_id']]['rule']][] = $category;
				}
			}
			//7:店铺主页
			if (isset($c_ids[7]) && $c_ids[7]) {
				foreach ($c_ids[7] as $xid) {
					$r_list[$v7_list[$this->store_session['store_id']]['rule']][] = array('info_url' => $this->config['wap_site_url'] . '/home.php?id=' . $this->store_session['store_id'], 'title' => '店铺主页', 'cid' => $this->store_session['store_id'], 'reply_type' => 7, 'reply_id' => $v7_list[$this->store_session['store_id']]['reply']);
				}
			}
			//8:会员主页
			if (isset($c_ids[8]) && $c_ids[8]) {
				foreach ($c_ids[8] as $xid) {
					$r_list[$v8_list[$this->store_session['store_id']]['rule']][] = array('info_url' => $this->config['wap_site_url'] . '/ucenter.php?id=' . $this->store_session['store_id'], 'title' => '会员主页', 'cid' => $this->store_session['store_id'], 'reply_type' => 8, 'reply_id' => $v8_list[$this->store_session['store_id']]['reply']);
				}
			}
			foreach ($list as &$li) {
				$li['keylist'] = isset($k_list[$li['pigcms_id']]) ? $k_list[$li['pigcms_id']] : array();
				$li['vallist'] = isset($r_list[$li['pigcms_id']]) ? $r_list[$li['pigcms_id']] : array();
			}
		}
		
// 		echo "<pre/>";
// 		print_r($list);die;
		$this->assign('list', $list);
		$this->assign('page', $p->show());
		$this->display();
	}
	
	public function auto_reply()
	{
		
		$this->assign('home_url', $this->config['wap_site_url'] . '/home.php?id=' . $this->store_session['store_id']);
		$this->assign('member_url', $this->config['wap_site_url'] . '/ucenter.php?id=' . $this->store_session['store_id']);
		$this->display();
	}
	public function auto_reply_load()
	{
		if (!($rule = D('Rule')->where(array('store_id' => $this->store_session['store_id'], 'type' => 1))->find())) {
			$rule = array('store_id' => $this->store_session['store_id'], 'type' => 1, 'name' => '关注后自动回复', 'dateline' => time());
			D('Rule')->data($rule)->add();
		}

		$keywords = D('Keyword')->where(array('store_id' => $this->store_session['store_id'], 'from_id' => $rule['pigcms_id']))->select();
		$k_list = array();// = array(rid => array(), ...)
		foreach ($keywords as $key) {
			$key['show_content'] = str_replace($this->face_key, $this->face_image, $key['content']);
			if (isset($k_list[$key['from_id']])) {
				$k_list[$key['from_id']][] = $key;
			} else {
				$k_list[$key['from_id']] = array($key);
			}
		}
		
		$c_ids = array();//type [0:文本，1：图文，2：音乐，3：商品，4：商品分类，5：微页面，6：微页面分类，7：店铺主页，8：会员主页]
		$v0_list = $v1_list = $v2_list = $v3_list = $v4_list = $v5_list = $v6_list = $v7_list = $v8_list = array();// = array(rid => cid, ...)
		$r_list = array();// = array(rid => array(), ...)
		
		
		$reply_relations = D('Reply_relation')->where(array('store_id' => $this->store_session['store_id'], 'rid' => $rule['pigcms_id']))->select();
		foreach ($reply_relations as $re) {
			$c_ids[$re['type']][] = $re['cid'];
			${"v{$re['type']}_list"}[$re['cid']]['rule'] = $re['rid'];//内容id 对应规则id
			${"v{$re['type']}_list"}[$re['cid']]['reply'] = $re['pigcms_id'];//内容id 对应规则id
		}
		//0:文本
		if (isset($c_ids[0]) && $c_ids[0]) {
			$texts = D('Text')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => array('in', $c_ids[0])))->select();
			foreach ($texts as $text) {
				$text['show_content'] = str_replace($this->face, $this->face_image, $text['content']);
				$text['reply_type'] = 0;
				$text['cid'] = $text['pigcms_id'];
				$text['reply_id'] = $v0_list[$text['pigcms_id']]['reply'];
				$r_list[$v0_list[$text['pigcms_id']]['rule']][] = $text;
			}
		}
		//1:图文
		if (isset($c_ids[1]) && $c_ids[1]) {
			$lists = D('Source_material')->where(array('pigcms_id' =>  array('in', $c_ids[1]), 'store_id' => $this->store_session['store_id']))->select();
			$temp = array();// array(image_text_id => source_material_id, ...)
			foreach ($lists as $l) {
				$tids = unserialize($l['it_ids']);
				if (isset($tids[0]) && $tids[0]) {
					$it_ids[] = $tids[0];
					$temp[$tids[0]] = $l['pigcms_id']; //cid  sid
				}
			}
			if ($it_ids) {
				$image_text_list = array();
				$image_texts = D('Image_text')->where(array('pigcms_id' => array('in', $it_ids), 'store_id' => $this->store_session['store_id']))->select();
				foreach ($image_texts as $image) {
					$image['info_url'] = $this->config['wap_site_url'] . '/imagetxt.php?id=' . $image['pigcms_id'];
					$image_text_list[$temp[$image['pigcms_id']]] = $image;
				}
				foreach ($image_text_list as $sid => $val) {
					$val['reply_type'] = 1;
					$val['cid'] = $sid;
					$val['reply_id'] = $v1_list[$sid]['reply'];
					$r_list[$v1_list[$sid]['rule']][] = $val;
				}
			}
		}
		
		//3:商品
		if (isset($c_ids[3]) && $c_ids[3]) {
			$products = D('Product')->where(array('store_id' => $this->store_session['store_id'], 'product_id' => array('in', $c_ids[3])))->select();
			foreach ($products as $product) {
				$product['reply_type'] = 3;
				$product['cid'] = $product['product_id'];
				$product['title'] = $product['name'];
				$product['info_url'] = $this->config['wap_site_url'] . '/good.php?id=' . $product['product_id'];
				$product['reply_id'] = $v3_list[$product['product_id']]['reply'];
				$r_list[$v3_list[$product['product_id']]['rule']][] = $product;
			}
		}
		//4:商品分类
		if (isset($c_ids[4]) && $c_ids[4]) {
			$groups = D('Product_group')->where(array('store_id' => $this->store_session['store_id'], 'group_id' => array('in', $c_ids[4])))->select();
			foreach ($groups as $group) {
				$group['reply_type'] = 4;
				$group['cid'] = $group['group_id'];
				$group['title'] = $group['group_name'];
				$group['info_url'] = $this->config['wap_site_url'] . '/goodcat.php?id=' . $group['group_id'];
				$group['reply_id'] = $v4_list[$group['group_id']]['reply'];
				$r_list[$v4_list[$group['group_id']]['rule']][] = $group;
			}
		}
		
		//5:微页面
		if (isset($c_ids[5]) && $c_ids[5]) {
			$pages = D('Wei_page')->where(array('store_id' => $this->store_session['store_id'], 'page_id' => array('in', $c_ids[5])))->select();
			foreach ($pages as $page) {
				$page['reply_type'] = 5;
				$page['cid'] = $page['page_id'];
				$page['title'] = $page['page_name'];
				$page['reply_id'] = $v5_list[$page['page_id']]['reply'];
				$page['info_url'] = $this->config['wap_site_url'] . '/page.php?id=' . $page['page_id'];
				$r_list[$v5_list[$page['page_id']]['rule']][] = $page;
			}
		}
		//6:微页面分类
		if (isset($c_ids[6]) && $c_ids[6]) {
			$categorys = D('Wei_page_category')->where(array('store_id' => $this->store_session['store_id'], 'cat_id' => array('in', $c_ids[6])))->select();
			foreach ($categorys as $category) {
				$category['reply_type'] = 6;
				$category['cid'] = $category['cat_id'];
				$category['title'] = $category['cat_name'];
				$category['info_url'] = $this->config['wap_site_url'] . '/pagecat.php?id=' . $category['cat_id'];
				$category['reply_id'] = $v6_list[$category['cat_id']]['reply'];
				$r_list[$v6_list[$category['cat_id']]['rule']][] = $category;
			}
		}
		//7:店铺主页
		if (isset($c_ids[7]) && $c_ids[7]) {
			foreach ($c_ids[7] as $xid) {
				$r_list[$v7_list[$this->store_session['store_id']]['rule']][] = array('info_url' => $this->config['wap_site_url'] . '/home.php?id=' . $this->store_session['store_id'], 'title' => '店铺主页', 'cid' => $this->store_session['store_id'], 'reply_type' => 7, 'reply_id' => $v7_list[$this->store_session['store_id']]['reply']);
			}
		}
		//8:会员主页
		if (isset($c_ids[8]) && $c_ids[8]) {
			foreach ($c_ids[8] as $xid) {
				$r_list[$v8_list[$this->store_session['store_id']]['rule']][] = array('info_url' => $this->config['wap_site_url'] . '/ucenter.php?id=' . $this->store_session['store_id'], 'title' => '会员主页', 'cid' => $this->store_session['store_id'], 'reply_type' => 8, 'reply_id' => $v8_list[$this->store_session['store_id']]['reply']);
			}
		}
		
// 		foreach ($list as &$li) {
		$rule['keylist'] = isset($k_list[$rule['pigcms_id']]) ? $k_list[$rule['pigcms_id']] : array();
		$rule['vallist'] = isset($r_list[$rule['pigcms_id']]) ? $r_list[$rule['pigcms_id']] : array();
// 		}
		$this->assign('list', $rule);
// 		$this->assign('page', $p->show());
		$this->display();
	}
	
	public function save_rule()
	{
		$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
		$pigcms_id = isset($_POST['pigcms_id']) ? intval($_POST['pigcms_id']) : 0;
		if (empty($name)) {
			exit(json_encode(array('err_code' => 1, 'err_msg' => '规则名不能为空')));
			json_return(1, '规则名不能为空');
		}
		if ($name == '关注后自动回复') json_return(1, '规则名已存在');
		
		if ($rule = D('Rule')->where("`store_id`='{$this->store_session['store_id']}' AND `name`='{$name}' AND `pigcms_id`<>'{$pigcms_id}'")->find()) {
			json_return(1, '规则名已存在');
		}
		$now_time = time();
		if($pigcms_id && ($rule = D('Rule')->where("`store_id`='{$this->store_session['store_id']}' AND `pigcms_id`='{$pigcms_id}'")->find())) {
			if ($flag = D('Rule')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $pigcms_id))->data(array('name' => $name, 'dateline' => $now_time))->save()) {
				exit(json_encode(array('err_code' => 0, 'err_msg' => '规则名修改成功', 'ruleid' => $pigcms_id, 'iskeyword' => 0)));
				json_return(0, '规则名修改成功');
			} else {
				json_return(1, '规则名修改失败，稍后重试');
			}
		} else {
			if($rid = D('Rule')->data(array('store_id' => $this->store_session['store_id'], 'name' => $name, 'dateline' => $now_time))->add()) {
				$keyword = D('Keyword')->where("`store_id`='{$this->store_session['store_id']}' AND `content`='{$name}'")->find();
				if (empty($keyword)) {
					D('Keyword')->data(array('store_id' => $this->store_session['store_id'], 'content' => $name, 'from_id' => $rid))->add();
					exit(json_encode(array('err_code' => 0, 'err_msg' => '规则名增加成功', 'ruleid' => $rid, 'iskeyword' => 1)));
				}
				exit(json_encode(array('err_code' => 0, 'err_msg' => '规则名增加成功', 'ruleid' => $rid, 'iskeyword' => 0)));
			} else {
				json_return(1, '规则名增加失败，稍后重试');
			}
		}
	}
	
	public function delete_rule()
	{
		$rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;
		if ($rule = D('Rule')->where("`store_id`='{$this->store_session['store_id']}' AND `pigcms_id`='{$rid}'")->find()) {
			D('Keyword')->where(array('store_id' => $this->store_session['store_id'], 'from_id' => $rid))->delete();
			$txtids = array();
			$reply_relations = D('Reply_relation')->where(array('store_id' => $this->store_session['store_id'], 'rid' => $rid))->select();
			foreach ($reply_relations as $re) {
				if ($re['type'] == 0) {
					$txtids[] = $re['cid'];//文本内容ID
				}
// 				$c_ids[$re['type']][] = $re['cid'];
// 				$v_list[$re['cid']] = $re['rid'];//内容id 对应规则id
			}
			if ($txtids) {
				D('Text')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => array('in', $txtids)))->delete();
			}
			D('Reply_relation')->where(array('store_id' => $this->store_session['store_id'], 'rid' => $rid))->delete();
			D('Rule')->where("`store_id`='{$this->store_session['store_id']}' AND `pigcms_id`='{$rid}'")->delete();
			json_return(0, '规则名删除成功');
		} else {
			json_return(1, '规则名删除失败，稍后重试');
		}
	}
	public function save_keyword()
	{
		$rid = isset($_POST['rid']) ? intval($_POST['rid']) : 0;
		$kid = isset($_POST['kid']) ? intval($_POST['kid']) : 0;
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		if (empty($content))json_return(1, '关键词不能为空');
		$rule = D('Rule')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $rid))->find();
		if (empty($rule))json_return(1, '不存在的规则');
		if ($keyword = D('Keyword')->where("`store_id`='{$this->store_session['store_id']}' AND `content`='{$content}' AND `pigcms_id`<>'{$kid}'")->find()) {
			json_return(1, '关键词已经存在');
		} else {
			$keyword = str_replace($this->face_key, $this->face_image, $content);
			if ($kid) {
				D('Keyword')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $kid))->data(array('content' => $content))->save();
				
				exit(json_encode(array('err_code' => 0, 'err_msg' => '关键词修改成功', 'kid' => $kid, 'keyword' => $keyword)));
				json_return(0, '关键词修改成功');
			} else {
				$count = D('Keyword')->where(array('store_id' => $this->store_session['store_id'], 'from_id' => $rid))->count('pigcms_id');
				if ($count >= 20) {
					json_return(1, '一个规则最多二十个关键词');
				}
				if ($kid = D('Keyword')->data(array('store_id' => $this->store_session['store_id'], 'content' => $content, 'from_id' => $rid))->add()) {
					exit(json_encode(array('err_code' => 0, 'err_msg' => '关键词增加成功', 'kid' => $kid, 'keyword' => $keyword)));
					json_return(0, '关键词增加成功');
				} else {
					json_return(1, '关键词增加失败，稍后重试');
				}
			}
		}
	}
	
	public function delete_keyword()
	{
		$kid = isset($_GET['kid']) ? intval($_GET['kid']) : 0;
		D('Keyword')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $kid))->delete();
		json_return(0, '删除关键词成功');
	}
	public function save_reply()
	{
		//type [0:文本，1：图文，2：音乐，3：商品，4：商品分类，5：微页面，6：微页面分类，7：店铺主页，8：会员主页]
		$notes = array('文本', '图文', '音乐', '商品', '商品分类', '微页面', '微页面分类', '店铺主页', '会员主页');
		$rid = isset($_POST['rid']) ? intval($_POST['rid']) : 0;//规则ID
		$replyid = isset($_POST['replyid']) ? intval($_POST['replyid']) : 0;//回复内容的关系表ID
		$type = isset($_POST['type']) ? intval($_POST['type']) : 0;
		$rule = D('Rule')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $rid))->find();
		if (empty($rule))json_return(1, '不存在的规则');
		$count = D('Reply_relation')->where(array('store_id' => $this->store_session['store_id'], 'rid' => $rid))->count('pigcms_id');
		if ($count >= 10) json_return(1, '最多十条回复');
		$keyword = '';
		$relation = D('Reply_relation')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $replyid))->find();
		
		$cid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
		switch ($type) {
			case 0:
				$cid = 0;
				$content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
				if (empty($content))json_return(1, '内容不能为空');
				$keyword = str_replace($this->face, $this->face_image, $content);
				if ($relation) {
					if ($relation['type'] == 0) {
						$cid = $relation['cid'];
						D('Text')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $relation['cid']))->data(array('content' => $content))->save();
						
					} elseif ($relation['type'] == 2) {
						//TODO delete music
					} else {
						//add
						$cid = D('Text')->data(array('store_id' => $this->store_session['store_id'], 'content' => $content))->add();
					}
				} else {
					$cid = D('Text')->data(array('store_id' => $this->store_session['store_id'], 'content' => $content))->add();
				}
				break;
			case 1:
// 				$cid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
				if ($source_material = D('Source_material')->where(array('pigcms_id' => $cid, 'store_id' => $this->store_session['store_id']))->find()) {
					$tids = unserialize($source_material['it_ids']);
					if (isset($tids[0]) && $tids[0]) {
						$image_text = D('Image_text')->where(array('pigcms_id' => $tids[0], 'store_id' => $this->store_session['store_id']))->find();
						$keyword = $image_text['title'];
						$info_url = $this->config['wap_site_url'] . '/imagetxt.php?id=' . $image_text['pigcms_id'];
					}
				} else {
					json_return(1, '不存在的图文');
				}
				break;
			case 2:
				//TODO operate music
				break;
			case 3:
				if ($product = D('Product')->where(array('store_id' => $this->store_session['store_id'], 'product_id' => $cid))->find()) {
					$keyword = $product['name'];
					$info_url = $this->config['wap_site_url'] . '/good.php?id=' . $product['product_id'];
				} else {
					json_return(1, '不存在的商品');
				}
				break;
			case 4:
				if ($group = D('Product_group')->where(array('store_id' => $this->store_session['store_id'], 'group_id' => $cid))->find()) {
					$keyword = $group['group_name'];
					$info_url = $this->config['wap_site_url'] . '/goodcat.php?id=' . $group['group_id'];
				} else {
					json_return(1, '不存在的商品分类');
				}
				break;
			case 5:
				if ($page = D('Wei_page')->where(array('store_id' => $this->store_session['store_id'], 'page_id' => $cid))->find()) {
					$keyword = $page['page_name'];
					$info_url = $this->config['wap_site_url'] . '/page.php?id=' . $page['page_id'];
				} else {
					json_return(1, '不存在的微页面');
				}
				break;
			case 6:
				if ($category = D('Wei_page_category')->where(array('store_id' => $this->store_session['store_id'], 'cat_id' => $cid))->find()) {
					$keyword = $category['cat_name'];
					$info_url = $this->config['wap_site_url'] . '/pagecat.php?id=' . $category['cat_id'];
				} else {
					json_return(1, '不存在的商品分类');
				}
				break;
			case 7:
				$info_url = $this->config['wap_site_url'] . '/home.php?id=' . $this->store_session['store_id'];
				$cid = $this->store_session['store_id'];
				break;
			case 8:
				$info_url = $this->config['wap_site_url'] . '/ucenter.php?id=' . $this->store_session['store_id'];
// 				if ($isreply = D('Reply_relation')->where(array('store_id' => $this->store_session['store_id'], 'rid' => $rid, 'cid' => $this->store_session['store_id'], 'type' => $type))->find()) {
// 					json_return(1, '已经存在相同的回复');
// 				}
				
				$cid = $this->store_session['store_id'];
				break;
		}
		
		if ($cid) {
			if ($type && $type != 2) {
				if ($relation['type'] == 0) {
					D('Text')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $relation['cid']))->delete();
				} elseif ($relation['type'] == 2);
			}
			if ($relation) {
				D('Reply_relation')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $replyid))->data(array('cid' => $cid, 'rid' => $rid, 'type' => $type))->save();
				$err_msg = '回复内容修改成功';
			} else {
				$replyid = D('Reply_relation')->data(array('store_id' => $this->store_session['store_id'], 'cid' => $cid, 'rid' => $rid, 'type' => $type))->add();
				$err_msg = '回复内容增加成功';
			}
			exit(json_encode(array('err_code' => 0, 'err_msg' => $err_msg, 'replyid' => $replyid, 'info_url' => $info_url, 'cid' => $cid, 'content' => $keyword, 'note' => $notes[$type])));
		} else {
			json_return(1, '回复内容增加失败，稍后重试');
		}
	}
	
	public function delete_reply()
	{
		$rid = isset($_GET['rid']) ? intval($_GET['rid']) : 0;//规则ID
		$replyid = isset($_GET['replyid']) ? intval($_GET['replyid']) : 0;//回复内容的关系表ID
		$rule = D('Rule')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $rid))->find();
		if (empty($rule))json_return(1, '不存在的规则');
		$relation = D('Reply_relation')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $replyid, 'rid' => $rid))->find();
		if (empty($relation))json_return(1, '无效的参数');
		if ($relation['type'] == 0) {
			D('Text')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $relation['cid']))->delete();
		} elseif ($relation['type'] == 2) {
			//TODO delete music
		}
		D('Reply_relation')->where(array('store_id' => $this->store_session['store_id'], 'pigcms_id' => $replyid, 'rid' => $rid))->delete();
		json_return(0, '删除回复成功');
	}
	
	public function auth()
	{
		import('source.class.Http');
		$result = $_SESSION['component_access_token'];
		if ($result && $result[0] > time()) {
			$result['component_access_token'] = $result[1];
		} else {
			$url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
			$data = array('component_appid' => $this->config['wx_appid'], 'component_appsecret' => $this->config['wx_appsecret'], 'component_verify_ticket' => $this->config['wx_componentverifyticket']);
			$result = Http::curlPost($url, json_encode($data));
			if (empty($result['errcode'])) {
				$_SESSION['component_access_token'] = array($result['expires_in'] + time(), $result['component_access_token']);
			} else {
// 				json_return(1, '获取授权地址失败');
			}
		}
		$url = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=' . $result['component_access_token'];//
		$data = array('component_appid' => $this->config['wx_appid']);
		$auth_code = Http::curlPost($url, json_encode($data));
		if (empty($auth_code['errcode'])) {
			$url = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid='.$this->config['wx_appid'].'&pre_auth_code='.$auth_code['pre_auth_code'].'&redirect_uri=' . urlencode($this->config['site_url'] . '/user.php?c=weixin&a=auth_back');
			$this->assign('url', $url);
		}
		
		$this->display();
	}
	public function get_url()
	{
		import('source.class.Http');
		$result = $_SESSION['component_access_token'];
		if ($result && $result[0] > time()) {
			$result['component_access_token'] = $result[1];
		} else {
			$url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
			$data = array('component_appid' => $this->config['wx_appid'], 'component_appsecret' => $this->config['wx_appsecret'], 'component_verify_ticket' => $this->config['wx_componentverifyticket']);
			$result = Http::curlPost($url, json_encode($data));
			if (empty($result['errcode'])) {
				$_SESSION['component_access_token'] = array($result['expires_in'] + time(), $result['component_access_token']);
			} else {
				json_return(1, '获取授权地址失败');
			}
		}
		$url = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=' . $result['component_access_token'];//
		$data = array('component_appid' => $this->config['wx_appid']);
		$auth_code = Http::curlPost($url, json_encode($data));
		if (empty($auth_code['errcode'])) {
			$url = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid='.$this->config['wx_appid'].'&pre_auth_code='.$auth_code['pre_auth_code'].'&redirect_uri=' . urlencode($this->config['site_url'] . '/user.php?c=weixin&a=auth_back');
			json_return(0, $url);
		}
		json_return(1, '获取授权地址失败');
	}
	public function auth_back()
	{
		if (isset($_GET['auth_code']) && isset($_GET['expires_in'])){
			
			//获取 component_access_token
			import('source.class.Http');
			
			$result = $_SESSION['component_access_token'];
			if ($result && $result[0] > time()) {
				$result['component_access_token'] = $result[1];
			} else {
				$url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
				$data = array('component_appid' => $this->config['wx_appid'], 'component_appsecret' => $this->config['wx_appsecret'], 'component_verify_ticket' => $this->config['wx_componentverifyticket']);
				$result = Http::curlPost($url, json_encode($data));
				if ($result['errcode']) {
					$this->assign('errmsg', $result['errmsg']);
					$this->display('fail');
					exit();
				}
			}
			
			//获取 authorizer_appid
			$url = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=' . $result['component_access_token'];//
			$data = array('component_appid' => $this->config['wx_appid'], 'authorization_code' => $_GET['auth_code']);
			$result1 = Http::curlPost($url, json_encode($data));
			if ($result1['errcode']) {
				$this->assign('errmsg', $result1['errmsg']);
				$this->display('fail');
				exit();
			}
			$_SESSION['authorizer_access_token'] = array($result1['authorization_info']['expires_in'] + time(), $result1['authorization_info']['authorizer_access_token']);
			$url = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token=' . $result['component_access_token'];
			$data = array('component_appid' => $this->config['wx_appid'], 'authorizer_appid' => $result1['authorization_info']['authorizer_appid']);
			$result2 = Http::curlPost($url, json_encode($data));
			if ($result2['errcode']) {
				$this->assign('errmsg', $result2['errmsg']);
				$this->display('fail');
				exit();
			} else {
				$data = array();
				$data = $result2['authorizer_info'];
				$data['service_type_info'] = $data['service_type_info']['id'];
				$data['verify_type_info'] = $data['verify_type_info']['id'];
				$pre = '';
				$func_info = '';
				foreach ($result2['authorization_info']['func_info'] as $val) {
					$func_info .= $pre . $val['funcscope_category']['id'];
					$pre = ',';
				}
				$data['func_info'] = $func_info;
				$data['authorizer_appid'] = $result1['authorization_info']['authorizer_appid'];
				$data['authorizer_refresh_token'] = $result1['authorization_info']['authorizer_refresh_token'];
				$data['store_id'] = $this->store_session['store_id'];
				unset($data['business_info']);
				if ($is_bind = D('Weixin_bind')->where(array('user_name' => $data['user_name']))->find()) {
					if ($is_bind['store_id'] != $this->store_session['store_id']) {
						$this->assign('errmsg', '该微信公众号已在其他店铺完成绑定，无法绑定到当前店铺！');
						$this->display('fail');
						exit();
					}
				}
				if ($weixin_bind = D('Weixin_bind')->where(array('store_id' => $this->store_session['store_id']))->find()) {
					D('Weixin_bind')->where(array('store_id' => $this->store_session['store_id']))->data($data)->save();
				} else {
					D('Weixin_bind')->data($data)->add();
				}
				
				D('Store')->data(array('open_weixin' => '1'))->where(array('store_id' => $this->store_session['store_id']))->save();
				$this->display('success');
			}
		} else {
			$this->assign('errmsg', '不合法的请求授权');
			$this->display('fail');
		}
	}
	
	public function class_send()
	{
		if (IS_GET) {
			$token_data = M('Weixin_bind')->get_access_token($this->store_session['store_id']);
			if ($token_data['errcode']) exit(json_encode($token_data));
			$data = '{"button":[';
			$class = D('Diymenu_class')->where(array('pid' => 0, 'store_id' => $this->store_session['store_id']))->limit(3)->order('sort asc')->select();//dump($class);
			$kcount = D('Diymenu_class')->where(array('pid' => 0, 'store_id' => $this->store_session['store_id']))->count('id');
			$k = 1;
			foreach ($class as $key => $vo) {
				//主菜单
				$data .= '{"name":"'.$vo['title'].'",';
				$c = D('Diymenu_class')->where(array('pid'=>$vo['id'], 'store_id' => $this->store_session['store_id']))->limit(5)->order('sort asc')->select();
				$count = D('Diymenu_class')->where(array('pid'=>$vo['id'], 'store_id' => $this->store_session['store_id']))->count('id');
				//子菜单
				if ($c != false) {
					$data .= '"sub_button":[';
				} else {
					if ($vo['url']) {
						$data .= '"type":"view","url":"'.$vo['url'].'"';
					} elseif($vo['keyword']) {
						$data .='"type":"click","key":"'.$vo['keyword'].'"';
					} elseif($vo['wxsys']) {
						$data .='"type":"'.$this->_get_sys('send',$vo['wxsys']).'","key":"'.$vo['wxsys'].'"';
					}
				}
				$i=1;
				foreach ($c as $voo) {
					if ($i == $count) {
						if ($voo['url']) {
							$data .= '{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"}';
						} elseif($voo['keyword']) {
							$data .= '{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"}';
						} elseif($voo['wxsys']) {
							$data .= '{"type":"'.$this->_get_sys('send',$voo['wxsys']).'","name":"'.$voo['title'].'","key":"'.$voo['wxsys'].'"}';
						}
					} else {
						if ($voo['url']) {
							$data .= '{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"},';
						} elseif($voo['keyword']) {
							$data .= '{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"},';
						} elseif($voo['wxsys']) {
							$data .= '{"type":"'.$this->_get_sys('send',$voo['wxsys']).'","name":"'.$voo['title'].'","key":"'.$voo['wxsys'].'"},';
						}
					}
					$i++;
				}
				if ($c != false) {
					$data .= ']';
				}
	
				if ($k == $kcount) {
					$data .= '}';
				} else {
					$data .= '},';
				}
				$k++;
			}
			$data .= ']}';
// 			$authorizer_access_token = $json->access_token;
			//file_get_contents('https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$token_data['access_token']);
			$url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token_data['access_token'];
			import('source.class.Http');
			$rt = Http::curlPost($url, $data);
// 			echo "<pre/>";
// 			print_r($rt);
// 			die;
			if ($rt['errcode']) {
				exit(json_encode($rt));
			} else {
				exit(json_encode(array('errcode' => 0, 'errmsg' => '自定义菜单生产成功')));
			}
		} else {
			exit(json_encode(array('errcode' => 1, 'errmsg' => '非法操作')));
		}
	}
	
	
// 	private function get_access_token()
// 	{
		
// 		$weixin_bind = D('Weixin_bind')->where(array('store_id' => $this->store_session['store_id']))->find();
// 		if (empty($weixin_bind)) return array('errcode' => 1, 'errmsg' => '公众授权异常，请重新授权');
// 		$access_token = $_SESSION['authorizer_access_token'];//session('authorizer_access_token');$_SESSION['authorizer_access_token']
// 		if ($access_token && $access_token[0] > time()) {
// 			$authorizer_access_token = $access_token[1];
// 		} else {
// 			import('source.class.Http');
// 			$result = $_SESSION['component_access_token'];//session('component_access_token');
// 			if ($result && $result[0] > time()) {
// 				$component_access_token = $result[1];
// 			} else {
// 				//获取component_access_token
// 				$url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
// 				$data = array('component_appid' => $this->config['wx_appid'], 'component_appsecret' => $this->config['wx_appsecret'], 'component_verify_ticket' => $this->config['wx_componentverifyticket']);
// 				$result = Http::curlPost($url, json_encode($data));
// 				if ($result['errcode']) {
// 					return $result;
// 				} else {
// 					$component_access_token = $result['component_access_token'];
// 				}
// 			}
// 			//利用刷新token 获取 authorizer_access_token
// 			$url = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=' . $component_access_token;
// 			$data = array();
// 			$data['component_appid'] = $this->config['wx_appid'];
// 			$data['authorizer_appid'] = $weixin_bind['authorizer_appid'];
// 			$data['authorizer_refresh_token'] = $weixin_bind['authorizer_refresh_token'];
// 			$access_data = Http::curlPost($url, json_encode($data));
// 			if ($access_data['errcode']) {
// 				return $access_data;
// 			} else {
// 				$authorizer_access_token = $access_data['authorizer_access_token'];
// 				$_SESSION['authorizer_access_token'] = array($access_data['expires_in'] + time(), $access_data['authorizer_access_token']);
// 			}
// 		}
// 		return array('errcode' => 0, 'access_token' => $authorizer_access_token);
// 	}
	private function _get_sys($type='',$key='')
	{
		$wxsys 	= array(
				'扫码带提示',
				'扫码推事件',
				'系统拍照发图',
				'拍照或者相册发图',
				'微信相册发图',
				'发送位置',
		);
	
		if($type == 'send'){
			$wxsys 	= array(
					'扫码带提示'=>'scancode_waitmsg',
					'扫码推事件'=>'scancode_push',
					'系统拍照发图'=>'pic_sysphoto',
					'拍照或者相册发图'=>'pic_photo_or_album',
					'微信相册发图'=>'pic_weixin',
					'发送位置'=>'location_select',
			);
			return $wxsys[$key];
			exit;
		}
		return $wxsys;
	}
	
	public function get_url_list()
	{
		$type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : 'feature';
		if ($type == 'feature') {
			$page_list = M('Wei_page')->get_list($this->store_session['store_id']);
			foreach ($page_list['page_list'] as &$v) {
				$v['add_time'] = date('Y-m-d <br/> H:i:s', $v['add_time']);
				$v['data_id'] = $v['page_id'];
				$v['url'] = $this->config['wap_site_url'] . '/page.php?id=' . $v['page_id'];
			}
		} elseif ($type == 'category') {
			$cat_list = M('Wei_page_category')->get_list($this->store_session['store_id']);
			$page_list['page_list'] = $cat_list['cat_list'];
			$page_list['page'] = $cat_list['page'];
			foreach ($page_list['page_list'] as &$v) {
				$v['add_time'] = date('Y-m-d <br/> H:i:s', $v['add_time']);
				$v['page_name'] = $v['cat_name'];
				$v['data_id'] = $v['cat_id'];
				$v['url'] = $this->config['wap_site_url'] . '/pagecat.php?id=' . $v['cat_id'];
			}
		} elseif ($type == 'goods') {
			$product = M('Product');
			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			$product_total = $product->getSellingTotal($where);
			import('source.class.user_page');
			$page = new Page($product_total, 15);
			$products = $product->getSelling($where, '', '', $page->firstRow, $page->listRows);
			$page_list = array('page' => $page->show());
			
			foreach ($products as $p) {
				$p['add_time'] = date('Y-m-d <br/> H:i:s', $p['date_added']);
				$p['page_name'] = $p['name'];
				$p['data_id'] = $p['product_id'];
				$p['url'] = $this->config['wap_site_url'] . '/good.php?id=' . $p['product_id'];
				$page_list['page_list'][] = $p;
			}
		} elseif ($type == 'tag') {
			$cat_list = M('Product_group')->get_list($this->store_session['store_id']);
			$page_list['page_list'] = $cat_list['group_list'];
			$page_list['page'] = $cat_list['page'];
			foreach ($page_list['page_list'] as &$v) {
				$v['add_time'] = date('Y-m-d <br/> H:i:s', $v['add_time']);
				$v['page_name'] = $v['group_name'];
				$v['data_id'] = $v['group_id'];
				$v['url'] = $this->config['wap_site_url'] . '/goodcat.php?id=' . $v['group_id'];
			}
		}
		exit(json_encode($page_list));
	}
	
	public function tail()
	{
		if (!($reply_tail = D('Reply_tail')->where(array('store_id' => $this->store_session['store_id']))->find())) {
			$reply_tail = array('content' => '', 'is_open' => 0);
		}
		$this->assign('reply_tail', $reply_tail);
		$this->display();
	}
	
	public function save_tail()
	{
		$content = isset($_POST['content']) ? strip_tags($_POST['content'], '<a>') : '';
		if (mb_strlen($content) > 200) json_return(1, '不多于200个字（含链接字符数）');
		if ($reply_tail = D('Reply_tail')->where(array('store_id' => $this->store_session['store_id']))->find()) {
			D('Reply_tail')->where(array('store_id' => $this->store_session['store_id']))->data(array('content' => $content))->save();
		} else {
			D('Reply_tail')->data(array('content' => $content, 'store_id' => $this->store_session['store_id']))->add();
		}
		json_return(0, '保存成功');
	}
	
	public function operation()
	{
		$is_open = isset($_POST['is_open']) ? intval($_POST['is_open']) : 0;
		if ($reply_tail = D('Reply_tail')->where(array('store_id' => $this->store_session['store_id']))->find()) {
			D('Reply_tail')->where(array('store_id' => $this->store_session['store_id']))->data(array('is_open' => $is_open))->save();
		} else {
			D('Reply_tail')->data(array('content' => '', 'is_open' => $is_open, 'store_id' => $this->store_session['store_id']))->add();
		}
		$is_open ? json_return(0, '开启成功') : json_return(0, '关闭成功');
	}
	
	public function menu_load()
	{
		$diymenus = D('Diymenu_class')->where(array('store_id' => $this->store_session['store_id']))->order('sort ASC')->select();
		$lists = array();
		foreach ($diymenus as $diy) {
			if ($diy['pid']) {
				if (!isset($lists[$diy['pid']]['list'])) {
					$lists[$diy['pid']]['list'] = array($diy);
				} else {
					$lists[$diy['pid']]['list'][] = $diy;
				}
			} else {
				if (isset($lists[$diy['id']])) {
					$lists[$diy['id']] = array_merge($lists[$diy['id']], $diy);
				} else {
					$lists[$diy['id']] = $diy;
				}
			}
		}
		
		$weixin = D('Weixin_bind')->where(array('store_id' => $this->store_session['store_id']))->find();
		$weixin || $weixin['nick_name'] = '';
		$this->assign('weixin', $weixin);
		$this->assign('lists', $lists);
		$this->assign('home_url', $this->config['wap_site_url'] . '/home.php?id=' . $this->store_session['store_id']);
		$this->assign('member_url', $this->config['wap_site_url'] . '/ucenter.php?id=' . $this->store_session['store_id']);
		$this->assign('info_url', $this->config['wap_site_url'] . '/imagetxt.php?id=');
		$this->display();
	}
	
	public function menu()
	{
		$diymenus = D('Diymenu_class')->where(array('store_id' => $this->store_session['store_id']))->order('sort ASC')->select();
		$lists = array();
		foreach ($diymenus as $diy) {
			if ($diy['pid']) {
				if (!isset($lists[$diy['pid']]['list'])) {
					$lists[$diy['pid']]['list'] = array($diy);
				} else {
					$lists[$diy['pid']]['list'][] = $diy;
				}
			} else {
				if (isset($lists[$diy['id']])) {
					$lists[$diy['id']] = array_merge($lists[$diy['id']], $diy);
				} else {
					$lists[$diy['id']] = $diy;
				}
			}
		}
		
		$weixin = D('Weixin_bind')->where(array('store_id' => $this->store_session['store_id']))->find();
		$weixin || $weixin['nick_name'] = '';
		$this->assign('weixin', $weixin);
		$this->assign('lists', $lists);
		
		$this->assign('home_url', $this->config['wap_site_url'] . '/home.php?id=' . $this->store_session['store_id']);
		$this->assign('member_url', $this->config['wap_site_url'] . '/ucenter.php?id=' . $this->store_session['store_id']);
		$this->assign('info_url', $this->config['wap_site_url'] . '/imagetxt.php?id=');
		$this->display();
	}
	
	public function save_menu()
	{
		$title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
		$content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
		$url = isset($_POST['url']) ? htmlspecialchars($_POST['url']) : '';
		if ($id && ($diy_menu = D('Diymenu_class')->where(array('id' => $id, 'store_id' => $this->store_session['store_id']))->find())) {
			$data = array();
			$title && $data['keyword'] = $data['title'] = $title;
			$content && $data['content'] = $content;
			$url && $data['url'] = $url;
			D('Diymenu_class')->where(array('id' => $id, 'store_id' => $this->store_session['store_id']))->data($data)->save();
			exit(json_encode(array('error' => 0, 'data' => $id, 'msg' => '更新成功!')));
		} else {
			$max = D('Diymenu_class')->where(array('store_id' => $this->store_session['store_id']))->max('sort');
			$data = array();
			$data['keyword'] = $data['title'] = $title;
			$data['content'] = $content;
			$data['url'] = $url;
			$data['pid'] = $pid;
			$data['sort'] = intval($max) + 1;
			$data['store_id'] = $this->store_session['store_id'];
			
			$count = D('Diymenu_class')->where(array('pid' => $pid, 'store_id' => $this->store_session['store_id']))->count('id');
			if ($pid && $count >= 5) {
				exit(json_encode(array('error' => 1, 'msg' => '二级菜单最多5个!')));
			} elseif (empty($pid) && $count >= 3) {
				exit(json_encode(array('error' => 1, 'msg' => '一级菜单最多3个!')));
			}
			if ($id = D('Diymenu_class')->data($data)->add()) {
				exit(json_encode(array('error' => 0, 'data' => $id, 'msg' => '创建成功!')));
			} else {
				exit(json_encode(array('error' => 1, 'msg' => '创建失败!')));
			}
		}
	}
	
	
	public function save_menu_content()
	{
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$fromid = isset($_POST['fromid']) ? intval($_POST['fromid']) : 0;
		$type = isset($_POST['type']) ? intval($_POST['type']) : 0;
		$url = isset($_POST['url']) ? htmlspecialchars($_POST['url']) : '';
		if ($type == 0) {
			$content = isset($_POST['content']) ? strip_tags($_POST['content'], '<a>,<img>') : '';
			for ($i = 1; $i < 106; $i++) {
				$t = $i < 10 ? '0' . $i : $i;
				$face_image[$i] = '<img src="'.$this->config['site_url'].'/static/js/ueditor/dialogs/emotion/images/qq/' . $t . '.gif"/>';
			}
			$content = str_replace($face_image, $this->face, $content);
		} else {
			$content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
		}
		if ($id && ($diy_menu = D('Diymenu_class')->where(array('id' => $id, 'store_id' => $this->store_session['store_id']))->find())) {
			$data = array();
			$data['content'] = $content;
			$data['url'] = $url;
			$data['type'] = $type;
			$data['fromid'] = $fromid;
			D('Diymenu_class')->where(array('id' => $id, 'store_id' => $this->store_session['store_id']))->data($data)->save();
			if ($type == 1) {
				$image_text = array();
				if ($data = D('Source_material')->where(array('pigcms_id' => $fromid, 'store_id' => $this->store_session['store_id']))->find()) {
					$it_ids = unserialize($data['it_ids']);
					$image_text = D('Image_text')->where(array('pigcms_id' => array('in', $it_ids)))->order('pigcms_id asc')->select();
// 					$contents  = array();
// 					foreach ($image_text as $t) {
// 						$t['id'] = $t['pigcms_id'];
// 						unset($t['store_id'], $t['dateline'], $t['pigcms_id']);
// 						$contents[] = $t;
// 					}
				}
				exit(json_encode(array('error' => 0, 'data' => $image_text, 'count' => count($image_text), 'content' => $content)));
			}
			exit(json_encode(array('error' => 0, 'data' => $id, 'content' => $content, 'msg' => '更新成功!')));
			
		} else {
			exit(json_encode(array('error' => 1, 'msg' => '不合法的参数!')));
		}
		
	}
	public function delete_menu()
	{
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		if ($diy = D('Diymenu_class')->where(array('id' => $id, 'store_id' => $this->store_session['store_id']))->find()) {
			D('Diymenu_class')->where(array('id' => $id, 'store_id' => $this->store_session['store_id']))->delete();
			D('Diymenu_class')->where(array('pid' => $id, 'store_id' => $this->store_session['store_id']))->delete();
			exit(json_encode(array('error' => 0, 'msg' => '删除成功')));
		} else {
			exit(json_encode(array('error' => 1, 'msg' => '不合法的数据')));
		}
	}
	
	public function chgorder()
	{
		$ids = isset($_POST['new_id']) ? $_POST['new_id'] : '';
		if (empty($ids))exit(json_encode(array('error' => 1, 'msg' => '不合法的数据')));
		$id_arr = json_decode($ids, true);
		$index = 0;
		foreach ($id_arr as $vals) {
			$keys = array_keys($vals);
			$pid = $keys[0];
			D('Diymenu_class')->where(array('id' => $pid, 'store_id' => $this->store_session['store_id']))->data(array('sort' => ++$index))->save();
			foreach ($vals[$pid] as $id) {
				D('Diymenu_class')->where(array('id' => $id, 'store_id' => $this->store_session['store_id']))->data(array('sort' => ++$index, 'pid' => $pid))->save();
			}
		}
		exit(json_encode(array('error' => 0, 'msg' => '保存排序成功')));
	}
	
	public function sendall()
	{
		$this->display();
	}
	
	
	public function send()
	{
		$token_data = M('Weixin_bind')->get_access_token($this->store_session['store_id']);
		if ($token_data['errcode']) exit(json_encode($token_data));
		$send_url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=' . $token_data['access_token'];
		//内容类型
		$type = isset($_POST['type']) ? intval($_POST['type']) : -1;
		import('source.class.Http');
		if ($type == -1) {
			exit(json_encode(array('errcode' => 1, 'errmsg' => '不合法的请求')));
		} else if ($type == 0) {
			$content = $_POST['content'];
			if (empty($content)) {
				exit(json_encode(array('errcode' => 1, 'errmsg' => '发送内容不能为空')));
			}
			$str = '{"filter":{"is_to_all":true}, "text":{"content":'.$content.'}, "msgtype":"text"}';
			$rt = Http::curlPost($send_url, $str);
			if ($rt['errcode']) {
				exit(json_encode($rt));
			} else {
				exit(json_encode(array('errcode' => 0, 'errmsg' => '群发成功')));
			}
		} elseif ($type == 1) {
			$url = isset($_POST['image']) ? htmlspecialchars($_POST['image']) : '';
			$url && $url = PIGCMS_PATH . substr($url, 2);
			if (empty($url) || !is_file($url)) exit(json_encode(array('errcode' => 1, 'errmsg' => '不是合法的图片')));
			$upload = Http::curlPost('http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$token_data['access_token'].'&type=image', array('media' => '@'. $url));
			if ($upload['errcode']) {
				exit(json_encode($upload));
			}
			//图片
			$str = '{"filter":{"is_to_all":true},"image":{"media_id":"'.$upload['media_id'].'"}, "msgtype":"image"}';
			$result = Http::curlPost($send_url, $str);
			if ($result['errcode']) {
				exit(json_encode($result));
			} else {
				exit(json_encode(array('errcode' => 0, 'errmsg' => '群发成功')));
			}
		} else {
			$pigcms_id = isset($_POST['source_id']) ? intval($_POST['source_id']) : 0;
			if ($data = D('Source_material')->where(array('pigcms_id' => $pigcms_id, 'store_id' => $this->store_session['store_id']))->find()) {
				$upload_url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$token_data['access_token'].'&type=image';
				$it_ids = unserialize($data['it_ids']);
				$comma = $send = '';
				$media = array();
				if ($data['type'] == 0) {
					$id = isset($it_ids[0]) ? intval($it_ids[0]) : 0;
					$image_text = D('Image_text')->where(array('pigcms_id' => $id, 'store_id' => $this->store_session['store_id']))->find();
					if ($image_text['cover_pic']) {
						$url = PIGCMS_PATH . substr($image_text['cover_pic'], 1);
						$media = Http::curlPost($upload_url, array('media' => '@'. $url));
						if ($media['errcode']) {
							exit(json_encode($media));
						}
					} else {
						$media['media_id'] = '';
					}
					$send = '{"thumb_media_id":"'.$media['media_id'].'","author":"'.$image_text['author'].'","title":"'.$image_text['title'].'","content_source_url":"'.$image_text['url'].'","content":"'.$image_text['content'].'","digest":"'.$image_text['digest'].'", "show_cover_pic":"'.$image_text['is_show'].'"}';
				} else {
					$image_text = D('Image_text')->where(array('pigcms_id' => array('in', $it_ids)))->order('pigcms_id asc')->select();
					foreach ($image_text as $image) {
						$media['media_id'] = '';
						if ($image['cover_pic']) {
							$url = PIGCMS_PATH . substr($image['cover_pic'], 1);
							$media = Http::curlPost($upload_url, array('media' => '@' . $url));
							if ($media['errcode']) {
								exit(json_encode($media));
							}
						}
						$send .= $comma . '{"thumb_media_id":"'.$media['media_id'].'","author":"'.$image['author'].'","title":"'.$image['title'].'","content_source_url":"'.$image['url'].'","content":"'.$image['content'].'","digest":"'.$image['digest'].'", "show_cover_pic":"'.$image['is_show'].'"}';
						$comma = ',';
					}
				}
				$uploadnews = Http::curlPost('https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token='.$token_data['access_token'], '{"articles": ['.$send.']}');
				if ($uploadnews['errcode']) {
					exit(json_encode($uploadnews));
				}
				$str = '{"filter":{"is_to_all":true}, "mpnews":{"media_id":"'.$uploadnews['media_id'].'"}, "msgtype":"mpnews"}';
				$result = Http::curlPost($send_url, $str);
				if ($result['errcode']) {
					exit(json_encode($result));
				} else {
					exit(json_encode(array('errcode' => 0, 'errmsg' => '群发成功')));
				}
			} else {
				exit(json_encode(array('errcode' => 1, 'errmsg' => '不是合法的参数')));
			}
		}
	}
	public function info(){
		$weixin_bind_type = M('Weixin_bind')->get_account_type_Bydata($this->weixin_bind_info);
		if($weixin_bind_type['errcode']){
			pigcms_tips($weixin_bind_type['errmsg']);
		}else{
			$this->weixin_bind_info['service_type_txt'] = $weixin_bind_type['errmsg'];
		}
		$this->assign('weixin_bind',$this->weixin_bind_info);
		$this->display();
	}
	public function wxpay(){
		$nowStore = M('Store')->getStore($this->store_session['store_id']);
		$this->assign('wxpay',$nowStore['wxpay']);
		$this->display();
	}
	public function open_wxpay(){
		$database_store = D('Store');
		if($database_store->where(array('store_id'=>$this->store_session['store_id']))->data(array('wxpay'=>$_POST['wxpay']))->save()){
			json_return(0,'ok');
		}else{
			json_return(1,'保存失败，请检查是否有过修改！');
		}
	}
	public function save_wxpay(){
		$post_data = array();
		foreach($_POST as $key=>$value){
			if(in_array($key,array('wxpay_appsecret','wxpay_mchid','wxpay_key','wxpay_test'))){
				$post_data[$key] = $value;
			}
		}
		if(!empty($post_data) && D('Weixin_bind')->where(array('store_id'=>$this->store_session['store_id']))->data($post_data)->save()){
			json_return(0,'ok');
		}else{
			json_return(1,'保存失败，请检查是否有过修改！');
		}
	}

	public function template_msg(){
		
		if(IS_POST){
			$data = array();
			$data['tempkey'] = $_REQUEST['tempkey'];
			$data['name'] = $_REQUEST['name'];
			$data['content'] = $_REQUEST['content'];
			$data['topcolor'] = $_REQUEST['topcolor'];
			$data['textcolor'] = $_REQUEST['textcolor'];
			$data['status'] = $_REQUEST['status'];
			$data['tempid'] = $_REQUEST['tempid'];

			foreach ($data as $key => $val){
				foreach ($val as $k => $v){
					$info[$k][$key] = $v;
				}
			}

			foreach ($info as $kk => $vv){
				if($vv['tempid'] == ''){
					$info[$kk]['status'] = 0;
				}
				$oauth_info 		= D('Weixin_bind')->where(array('store_id'=>$_SESSION['store']['store_id']))->field('authorizer_appid')->find();
 				$info[$kk]['token'] = $oauth_info['authorizer_appid'];
				$where = array('token'=>$oauth_info['authorizer_appid'],'tempkey'=>$info[$kk]['tempkey']);

				if(D('Tempmsg')->where($where)->field('id')->find()){
					D('Tempmsg')->where($where)->data($info[$kk])->save();
				}else{
					D('Tempmsg')->data($info[$kk])->add();
				}
			}
			json_return(0,'操作成功');
		} else {
			import('templateNews');
			$model = new templateNews();
			$templs = $model->templates();

			$list = D('Tempmsg')->field('id')->select();

			$keys = array_keys($list);
			$i=count($list);
			$j = 0;
			foreach ($templs as $k => $v){
				$dbtempls = D('Tempmsg')->where(array('tempkey' => $k))->find();
			
				if(empty($dbtempls)){
					$list[$i]['tempkey'] = $k;
					$list[$i]['name'] = $v['name'];
					$list[$i]['content'] = $v['content'];
					$list[$i]['topcolor'] = '#029700';
					$list[$i]['textcolor'] = '#000000';
					$list[$i]['status'] = 0;
					$i++;
				}else{
					$list[$j]['tempkey'] = $dbtempls['tempkey'];
				 	$list[$j]['name'] = $v['name'];
				 	$list[$j]['content'] = $v['content'];
				 	$list[$j]['tempid'] = $dbtempls['tempid'];
				 	$list[$j]['status'] = $dbtempls['status'];
				 	$j++;
				}
			}

			$this->assign('list',$list);
			$this->display();
		}
	}
}