<?php
//����Դ������ www.gope.cn
class String
{
	static public function uuid()
	{
		$charid = md5(uniqid(mt_rand(), true));
		$hyphen = chr(45);
		$uuid = chr(123) . substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12) . chr(125);
		return $uuid;
	}

	static public function keyGen()
	{
		return str_replace('-', '', substr(String::uuid(), 1, -1));
	}

	static public function isUtf8($str)
	{
		$c = 0;
		$b = 0;
		$bits = 0;
		$len = strlen($str);

		for ($i = 0; $i < $len; $i++) {
			$c = ord($str[$i]);

			if (128 < $c) {
				if (254 <= $c) {
					return false;
				}
				else if (252 <= $c) {
					$bits = 6;
				}
				else if (248 <= $c) {
					$bits = 5;
				}
				else if (240 <= $c) {
					$bits = 4;
				}
				else if (224 <= $c) {
					$bits = 3;
				}
				else if (192 <= $c) {
					$bits = 2;
				}
				else {
					return false;
				}

				if ($len < ($i + $bits)) {
					return false;
				}

				while (1 < $bits) {
					$i++;
					$b = ord($str[$i]);
					if (($b < 128) || (191 < $b)) {
						return false;
					}

					$bits--;
				}
			}
		}

		return true;
	}

	static public function msubstr($str, $start = 0, $length, $charset = 'utf-8', $suffix = true)
	{
		if (function_exists('mb_substr')) {
			$slice = mb_substr($str, $start, $length, $charset);
		}
		else if (function_exists('iconv_substr')) {
			$slice = iconv_substr($str, $start, $length, $charset);
		}
		else {
			$re['utf-8'] = '/[-]|[?�][�-�]|[?�][�-�]{2}|[?�][�-�]{3}/';
			$re['gb2312'] = '/[-]|[?�][?�]/';
			$re['gbk'] = '/[-]|[?�][@-�]/';
			$re['big5'] = '/[-]|[?�]([@-~]|?�])/';
			preg_match_all($re[$charset], $str, $match);
			$slice = join('', array_slice($match[0], $start, $length));
		}

		return $suffix ? $slice . '...' : $slice;
	}

	static public function randString($len = 6, $type = '', $addChars = '')
	{
		$str = '';

		switch ($type) {
		case 0:
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
			break;

		case 1:
			$chars = str_repeat('0123456789', 3);
			break;

		case 2:
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
			break;

		case 3:
			$chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
			break;

		case 4:
			$chars = '们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休�? . $addChars;
			break;

		default:
			$chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
			break;
		}

		if (10 < $len) {
			$chars = ($type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5));
		}

		if ($type != 4) {
			$chars = str_shuffle($chars);
			$str = substr($chars, 0, $len);
		}
		else {
			for ($i = 0; $i < $len; $i++) {
				$str .= self::msubstr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1, 'utf-8', false);
			}
		}

		return $str;
	}

	static public function buildCountRand($number, $length = 4, $mode = 1)
	{
		if (($mode == 1) && ($length < strlen($number))) {
			return false;
		}

		$rand = array();

		for ($i = 0; $i < $number; $i++) {
			$rand[] = self::randString($length, $mode);
		}

		$unqiue = array_unique($rand);

		if (count($unqiue) == count($rand)) {
			return $rand;
		}

		$count = count($rand) - count($unqiue);

		for ($i = 0; $i < ($count * 3); $i++) {
			$rand[] = self::randString($length, $mode);
		}

		$rand = array_slice(array_unique($rand), 0, $number);
		return $rand;
	}

	static public function buildFormatRand($format, $number = 1)
	{
		$str = array();
		$length = strlen($format);

		for ($j = 0; $j < $number; $j++) {
			$strtemp = '';

			for ($i = 0; $i < $length; $i++) {
				$char = substr($format, $i, 1);

				switch ($char) {
				case '*':
					$strtemp .= String::randString(1);
					break;

				case '#':
					$strtemp .= String::randString(1, 1);
					break;

				case '$':
					$strtemp .= String::randString(1, 2);
					break;

				default:
					$strtemp .= $char;
					break;
				}
			}

			$str[] = $strtemp;
		}

		return $number == 1 ? $strtemp : $str;
	}

	static public function randNumber($min, $max)
	{
		return sprintf('%0' . strlen($max) . 'd', mt_rand($min, $max));
	}

	static public function autoCharset($string, $from = 'gbk', $to = 'utf-8')
	{
		$from = (strtoupper($from) == 'UTF8' ? 'utf-8' : $from);
		$to = (strtoupper($to) == 'UTF8' ? 'utf-8' : $to);
		if ((strtoupper($from) === strtoupper($to)) || empty($string) || (is_scalar($string) && !is_string($string))) {
			return $string;
		}

		if (is_string($string)) {
			if (function_exists('mb_convert_encoding')) {
				return mb_convert_encoding($string, $to, $from);
			}
			else if (function_exists('iconv')) {
				return iconv($from, $to, $string);
			}
			else {
				return $string;
			}
		}
		else if (is_array($string)) {
			foreach ($string as $key => $val) {
				$_key = self::autoCharset($key, $from, $to);
				$string[$_key] = self::autoCharset($val, $from, $to);

				if ($key != $_key) {
					unset($string[$key]);
				}
			}

			return $string;
		}
		else {
			return $string;
		}
	}
}


?>
