<?php
/**
 * 店铺模型
 * User: pigcms_21
 * Date: 2015/2/2
 * Time: 22:00
 */
	class store_model extends base_model{
		//创建店铺
		public function create($data){
			if($store_id = $this->db->data($data)->add()){
				$data['store_id'] = $store_id;
				return array('err_code' => 1,'err_msg' => $data);
			} else {
				return array('err_code' => 0,'err_msg' => '店铺创建失败');
			}
		}

		//优质店铺
		public function goodExcellentList( $offset="0", $limit="10",$has_other_info= false)
		{

			if ($has_other_info) {
				$where = "s.status=1";
				$order = "s.income desc,s.collect desc,s.approve desc";
				$store_list = $this->db->table("Store as s")->join('Store_contact sc  ON  s.store_id=sc.store_id','LEFT')->join('Sale_category ss ON ss.cat_id = s.sale_category_id' , 'left')
					->where($where)
					->limit($offset . ',' . $limit)
					->order($order)
					->field("s.*,sc.long,sc.lat,sc.city,sc.province,sc.address, ss.name as cate_name")
					->select();

			} else {
				$where = array('status' => 1);
				$order = "income desc,collect desc,approve desc";
				$store_list = $this->db->where($where)->order($order)->limit($offset . ',' . $limit)->select();
			}

			if(!empty($store_list)) {
				foreach($store_list as &$value) {
					$value['url'] = option('config.wap_site_url').'/home.php?id='.$value['store_id'].'&platform=1';
					$value['pcurl'] =  url_rewrite('store:index', array('id' => $value['store_id']));
					/*if ($has_other_info) {
						$sale_cate = M('Sale_category')->getCategory($value['sale_category_id']);
						$store['cate_name'] =$sale_cate['name'];
					}*/
					if(empty($value['logo'])) {
						$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
					} else {
						$value['logo'] = getAttachmentUrl($value['logo']);
					}
					//店铺二维码
					$value['wx_image'] =  option('config.site_url').'/source/qrcode.php?type=home&id='.$value['store_id'];
				}
			}

			return $store_list;
		}


		//优质供应商
		public function supplieStore( $offset="0", $limit="10",$has_other_info= false) {

			$order = "s.drp_profit desc";
			$where = "s.status=1 and s.drp_supplier_id=0";
			$store_list = $this->db->table("Store as s")->join('Sale_Category sc  ON  s.sale_category_id=sc.cat_id','LEFT')
				->where($where)
				->limit($offset . ',' . $limit)
				->order($order)
				->field("s.*,sc.name as cate_name")
				->select();

			if(!empty($store_list)) {
				foreach($store_list as &$value) {
					$value['url'] = option('config.wap_site_url').'/home.php?id='.$value['store_id'].'&platform=1';
					$value['pcurl'] =  url_rewrite('store:index', array('id' => $value['store_id']));
					if(empty($value['logo'])) {
						$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
					} else {
						$value['logo'] = getAttachmentUrl($value['logo']);
					}
					//店铺二维码
					$value['wx_image'] =  option('config.site_url').'/source/qrcode.php?type=home&id='.$value['store_id'];
				}
			}
			return $store_list;
		}


		//获取指定条件下的店铺列表
		public function getlist($where=array(), $orderby="", $limit="10") {
			$store_list =  $this->db->where($where)->order($orderby)->limit($limit)->select();

			if(!empty($store_list)) {
				foreach($store_list as &$value){
					$value['url'] = option('config.wap_site_url').'/home.php?id='.$value['store_id'].'&platform=1';
					$value['pcurl'] =  url_rewrite('store:index', array('id' => $value['store_id']));

					if(empty($value['logo'])) {
						$value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
					} else {
						$value['logo'] = getAttachmentUrl($value['logo']);
					}

					//店铺二维码
					$value['wx_image'] =  option('config.site_url').'/source/qrcode.php?type=home&id='.$value['store_id'];

				}
			}

			return $store_list;

		}

		//获取用户店铺
		public function getStoresByUid($uid, $status = 1){
            if ($status == 1 || $status == 0) {
                $where = array('uid'=>$uid,'status'=>$status);
                $orderby = 'uid DESC';
            } else {
                $where = array('uid'=>$uid, 'drp_approve' => 1);
                $orderby = 'status ASC, uid DESC';
            }
			$list_count = $this->db->where($where)->count('store_id');
			if (option('config.user_store_num_limit') > 0 && option('config.user_store_num_limit') <= 15) {
				$return['store_list'] = $this->db->where($where)->limit('0,' . option('config.user_store_num_limit'))->order($orderby)->select();
				$return['page'] = '';
			} else {
				import('source.class.user_page');
				$p = new Page($list_count,15);
				$return['store_list'] = $this->db->where($where)->limit($p->firstRow.','.$p->listRows)->order($orderby)->select();
				$return['page'] = $p->show();
			}
			return $return;
		}

		//获取用户所有店铺
		public function getAllStoresByUid($uid, $store_id = 0){
			if (!empty($store_id)) {
				return $this->db->field('store_id,name')->where(array('store_id' => $store_id, 'uid' => $uid,'status'=>1))->select();
			} else {
				return $this->db->field('store_id,name')->where(array('uid' => $uid,'status'=>1))->select();
			}
		}
		//获取主营类目下的店铺列表
		public function getWeidianStoreListBySaleCategoryId($sale_category_id,$limit,$is_fid=false,$is_approve = ''){

			$condition_store['status'] = '1';
			if($is_fid){
				$condition_store['sale_category_fid'] = $sale_category_id;
			}else{
				$condition_store['sale_category_id'] = $sale_category_id;
			}
			if($is_approve != '') $condition_store['approve'] = $is_approve;
			$store_list = $this->db->field('`store_id`,`name`,`logo`')->where($condition_store)->order('`store_id` DESC')->limit($limit)->select();

			if(!empty($store_list)){
				foreach($store_list as &$value){
					$value['url'] = option('config.wap_site_url').'/home.php?id='.$value['store_id'].'&platform=1';
					$value['pcurl'] =  url_rewrite('store:index', array('id' => $value['store_id']));
					
					if(empty($value['logo'])) {
						$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
					} else {
						$value['logo'] = getAttachmentUrl($value['logo']);
					}
				}
			}
			return $store_list;
		}


		//获取指定个数主营类目下的指定店铺列表
		/*
		 * @param 店铺类目二维数组 array()
		 */
		public function getWeidianStoreListBySaleCategoryList($where_store,$sale_category_limit,$store_limit){

			  $categoryList =  M('Sale_category')->getCategoryList($where_store,$sale_category_limit);
				$new_category_list = array();
				foreach($categoryList as $k=>$v){
					$new_category_list[$k] = $v;
					$categoryList = $this->getWeidianStoreListBySaleCategoryId($v['cat_id'],$store_limit,true,1);

					$new_category_list[$k]['cat_list'] = $categoryList;

				}

				return $new_category_list;
		}

		//获取单个店铺
		public function getStoreById($store_id, $uid){
			$store = $this->db->where(array('store_id' => $store_id, 'uid' => $uid, 'status' => 1))->find();
			if(!empty($store)){
				$store['url'] = option('config.wap_site_url').'/home.php?id='.$store['store_id'];
				if(empty($store['logo'])) {
					$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
				} else {
					$store['logo'] = getAttachmentUrl($store['logo']);
				}
			}
			return $store;
		}
		
		//用店铺ID获取一个店铺
		public function getStore($store_id){
			$store = $this->db->where(array('store_id'=>$store_id,'status'=>1))->find();
			if(!empty($store)){
				$store['url'] = option('config.wap_site_url').'/home.php?id='.$store['store_id'];

				if(empty($store['logo'])) {
					$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
				} else {
					$store['logo'] = getAttachmentUrl($store['logo']);
				}
				
				$store['ucenter_url'] = option('config.wap_site_url').'/ucenter.php?id='.$store['store_id'];
				option('now_store',$store);
			}
			return $store;
		}

        //用店铺ID获取一个店铺(手机站专用)
        public function wap_getStore($store_id){
            $store = $this->db->where(array('store_id'=>$store_id,'status'=>1))->find();
            if(!empty($store)){
                $_SESSION['tmp_store_id'] = $store_id;
                //解决用户访问不同店铺重复授权生成新用户问题
                /*if (empty($_SESSION['wap_user']) && !empty($_COOKIE['uid'])) { //COOKIE中有用户信息
                    $tmp_user = M('User')->checkUser(array('uid' => $_COOKIE['uid']));
                    if (!empty($tmp_user)) {
                        $_SESSION['wap_user'] = $tmp_user;
                        $tmp_seller = D('Store')->where(array('drp_supplier_id' => $store_id, 'uid' => $_COOKIE['uid'], 'status' => 1))->find();
                        if (!empty($tmp_seller)) {
                            $_SESSION['wap_drp_store'] = $tmp_seller;
                            if (!empty($tmp_seller['oauth_url'])) { //对接微店
                                $_SESSION['sync_user'] = true;
                            }
                        }
                        setcookie('uid', $_COOKIE['uid'], $_SERVER['REQUEST_TIME']+10000000, '/'); //延长cookie有效期
                    } else {
                        unset($_SESSION['sync_user']); //删除同步标识
                        unset($_SESSION['wap_user']); //删除用户登录状态
                    }
                }*/
                //判断是否为对接微店
                if (!empty($store['oauth_url'])) {
                    if (!empty($_SESSION['wap_user']) && $_SESSION['wap_user']['store_id'] != $store_id) { //非当前店铺粉丝，重新授权登陆
                        unset($_SESSION['sync_user']); //删除同步标识
                        unset($_SESSION['wap_user']); //删除用户登录状态
                    }
                } else {
                    unset($_SESSION['sync_user']);//非对接店铺 删除同步标识
                }

                //对接网站用户授权登陆
                //授权条件：非对接同步用户，是对接店铺，店铺管理后台未登录（不加此条件，店铺管理后台的所有链接无法在pc端打开，都会跳转授权）
                if (empty($_SESSION['sync_user']) && !empty($store['oauth_url']) && empty($_SESSION['sync_store'])) {
                    $return_url = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    if (!empty($store['oauth_url'])) {
                        if (stripos($store['oauth_url'], '?') === false) {
                            redirect($store['oauth_url'] . '?return_url=' . $return_url . '&store_id=' . $store_id . '&token=' . $store['token']);
                        } else {
                            redirect($store['oauth_url'] . '&return_url=' . $return_url . '&store_id=' . $store_id . '&token=' . $store['token']);
                        }
                    }
                } else if (empty($_SESSION['sync_user']) && empty($store['oauth_url']) && empty($_SESSION['store'])) { //默认授权
                    //授权条件：非对接同步用户，非对接店铺，店铺管理后台未登录（不加此条件，店铺管理后台的所有链接无法在pc端打开，都会跳转授权）

                    /*是否移动端*/
                    $is_mobile = is_mobile();
                    /*是否微信端*/
                    $is_weixin = is_weixin();
					
					//调试  清除登录信息
					//setcookie('pigcms_sessionid','',$_SERVER['REQUEST_TIME']-10000000,'/');
					//$_SESSION = null;
					//session_destroy();

                    /*如果是微信端，且配置文件中配置了微信信息，得到openid*/
                    if($is_weixin && (empty($_SESSION['openid']) || empty($_SESSION['wap_user']))){
							
                        //openid存在 通过openid查找用户
                        if (!empty($_SESSION['openid'])) {
                            $userinfo = M('User')->get_user('openid', $_SESSION['openid']);
                            $_SESSION['wap_user'] = $userinfo['user'];
                            mergeSessionUserInfo(session_id(), $userinfo['user']['uid']);
                            unset($_SESSION['wap_drp_store']);
                        }
                        //用户未登录 调用授权获取openid, 通过openid查找用户，如果已经存在，设置登录，如果不存在，添加一个新用户和openid关联
                        if (empty($_SESSION['wap_user'])) {
	
							$customeUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        	
                        	//判断店铺是否绑定过认证服务号
                        	$wx_bind 	= D('Weixin_bind')->where(array('store_id'=>$store['store_id']))->find();
                            if(empty($_GET['code'])){
                                $_SESSION['weixin']['state']   = md5(uniqid());
								if(!empty($wx_bind) && $wx_bind['service_type_info'] == 2 && $wx_bind['verify_type_info'] == 0){
									$oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$wx_bind['authorizer_appid'].'&redirect_uri='.urlencode($customeUrl).'&response_type=code&scope=snsapi_userinfo&state='.$_SESSION['weixin']['state'].'&component_appid='.option('config.wx_appid').'#wechat_redirect';
								}else{
									//店铺非认证服务号走总后台授权
									$oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.option('config.wechat_appid').'&redirect_uri='.urlencode($customeUrl).'&response_type=code&scope=snsapi_userinfo&state='.$_SESSION['weixin']['state'].'#wechat_redirect';
								}
                                redirect($oauthUrl);exit;
                            }else if(isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['weixin']['state'])){
                                unset($_SESSION['weixin']);
                                import('Http');
                                $http = new Http();
                                
								if(!empty($wx_bind) && $wx_bind['service_type_info'] == 2 && $wx_bind['verify_type_info'] == 0){
                                	$component_token = M('Weixin_bind')->get_access_token($store['store_id'],true);
                                	$tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/component/access_token?appid='.$wx_bind['authorizer_appid'].'&code='.$_GET['code'].'&grant_type=authorization_code&component_appid='.option('config.wx_appid').'&component_access_token='.$component_token;
                                }else{
                        			$tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.option('config.wechat_appid').'&secret='.option('config.wechat_appsecret').'&code='.$_GET['code'].'&grant_type=authorization_code';
                                }

                                $return = $http->curlGet($tokenUrl);
                                $jsonrt = json_decode($return,true);

                                if($jsonrt['errcode']){
                                    $error_msg_class = new GetErrorMsg();
                                    exit('授权发生错误：'.$jsonrt['errcode']);
                                }

                                if($jsonrt['openid']){ //微信中打开直接登陆
                                    $url 	= 'https://api.weixin.qq.com/sns/userinfo?access_token='.$jsonrt['access_token'].'&openid='.$jsonrt['openid'].'&lang=zh_CN';
                                    $wxuser 	= $http->curlGet($url);
                                    $wxuser = json_decode($wxuser, true);

                                    $_SESSION['openid'] = $jsonrt['openid'];

                                    $userinfo = M('User')->get_user('openid', $_SESSION['openid']);
                                    if(empty($userinfo['user'])){ //用户不存在，添加新用户，并设置登录
                                        $data = array();
                                        $data['phone']       = '';
                                        $data['nickname']    = $wxuser['nickname'];
                                        $data['openid']      = $_SESSION['openid'];
                                        $data['avatar']      = $wxuser['headimgurl'];
                                        $data['password']    = '';
                                        $data['check_phone'] = 1;
                                        $data['login_count'] = 1;
                                        $add_result = M('User')->add_user($data);
                                        if($add_result['err_code'] == 0){
                                            $_SESSION['wap_user'] = $add_result['err_msg'];
											$_SESSION['wap_user']['sex'] = $wxuser['sex'];
											$_SESSION['wap_user']['province'] = $wxuser['province'];
											$_SESSION['wap_user']['city'] = $wxuser['city'];
                                            mergeSessionUserInfo(session_id(),$add_result['err_msg']['uid']);
                                        }
                                    } else { //用户已存在，设置登录
                                        $_SESSION['wap_user'] = $userinfo['user'];
										$_SESSION['wap_user']['sex'] = $wxuser['sex'];
										$_SESSION['wap_user']['province'] = $wxuser['province'];
										$_SESSION['wap_user']['city'] = $wxuser['city'];
                                        mergeSessionUserInfo(session_id(), $userinfo['user']['uid']);
                                    }
                                    unset($_SESSION['wap_drp_store']); //删除保存在session中的分销店铺
                                }
                            }
                        }
                    }
					//}
                }
                $store['url'] = option('config.wap_site_url').'/home.php?id='.$store['store_id'];
                if(empty($store['logo'])) {
                	$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
                } else if (stripos($store['logo'], 'http://') === false && stripos($store['logo'], 'https://') === false) {
                	$store['logo'] = getAttachmentUrl($store['logo']);
                }
                $store['ucenter_url'] = option('config.wap_site_url').'/ucenter.php?id='.$store['store_id'];
                $store['physical_url'] = option('config.wap_site_url').'/physical.php?id='.$store['store_id'];
                option('now_store',$store);
            }
            return $store;
        }
		
		//更改店铺状态
        public function change_status($store_id,$uid,$status){
            if($this->db->where(array('store_id'=>$store_id,'uid'=>$uid))->data(array('status'=>$status))->save()){
				return array('err_code'=>0,'err_msg'=>'更改状态成功');
			}else{
				return array('err_code'=>1,'err_msg'=>'更改状态失败！请重试');
			}
        }
		
        //删除店铺
        public function delete($store_id, $uid){
            $result = $this->db->where(array('store_id' => $store_id, 'uid' => $uid))->delete();
            return $result;
        }

        //主营类目
        public function getSaleCategory($store_id, $uid){
            $store = $this->db->field('sale_category_id,sale_category_fid')->where(array('store_id' => $store_id,'uid' => $uid))->find();
            if (!empty($store['sale_category_id']) && !empty($store['sale_category_fid'])) {
                $fcategory = M('Sale_category')->getCategory($store['sale_category_fid']);
                $category = M('Sale_category')->getCategory($store['sale_category_id']);
                return $fcategory['name'] . ' - ' . $category['name'];
            } else if (!empty($store['sale_category_fid'])) {
                $fcategory = M('Sale_category')->getCategory($store['sale_category_fid']);
                return $fcategory['name'];
            } else if (!empty($store['sale_category_id'])) {
                $category = M('Sale_category')->getCategory($store['sale_category_id']);
                return $category['name'];
            }
        }

        //设置买家上门自提状态
        public function setSelfFetchStatus($status, $store_id)
        {
            $result = $this->db->where(array('store_id' => $store_id))->data(array('buyer_selffetch' => $status))->save();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
        //获取买家上门自提状态
        public function getSelfFetchStatus($store_id)
        {
            $store = $this->db->field('buyer_selffetch')->where(array('store_id' => $store_id))->find();
            if (isset($store['buyer_selffetch'])) {
                return $store['buyer_selffetch'];
            } else {
                return 0;
            }
        }
        //设置找人找付
        public function setPayAgentStatus($status, $store_id)
        {
            $result = $this->db->where(array('store_id' => $store_id))->data(array('pay_agent' => $status))->save();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
        //获取找人代付状态
        public function getPayAgentStatus($store_id)
        {
            $store = $this->db->field('pay_agent')->where(array('store_id' => $store_id))->find();
            if (isset($store['pay_agent'])) {
                return $store['pay_agent'];
            } else {
                return 0;
            }
        }

        //店铺名唯一性
        public function getUniqueName($name)
        {
            $count = $this->db->where(array('name' => $name, 'status' => 1))->count('store_id');
            if ($count) {
                return false;
            } else {
                return true;
            }
        }

        //店铺设置
        public function setting($where, $data)
        {
            return $this->db->where($where)->data($data)->save();
        }

        //开启/关闭店铺导航
        public function openNav($store_id, $status)
        {
            return $this->db->where(array('store_id' => $store_id))->data(array('open_nav' => $status))->save();
        }

        //开启/关闭店铺广告
        public function openAd($store_id, $status)
        {
            return $this->db->where(array('store_id' => $store_id))->data(array('open_ad' => $status))->save();
        }

        //设置导航菜单
        public function setUseNavPage($store_id, $use_nav_pages)
        {
            return $this->db->where(array('store_id' => $store_id))->data(array('use_nav_pages' => $use_nav_pages))->save();
        }

        //设置店铺广告
        public function setAd($store_id, $data)
        {
            return $this->db->where(array('store_id' => $store_id))->data(array('has_ad' => $data['has_ad'], 'ad_position' => $data['ad_position'], 'use_ad_pages' => $data['use_ad_pages'], 'date_edited' => $data['date_edited']))->save();
        }

        //店铺收入
        public function getIncome($store_id)
        {
            $store = $this->db->where(array('store_id' => $store_id))->find();
            return $store['income'];
        }

        //店铺可提现余额
        public function getBalance($store_id)
        {
            $store = $this->db->field('balance')->where(array('store_id' => $store_id))->find();
            return !empty($store['balance']) ? $store['balance'] : 0;
        }

        //店铺已提现金额
        public function getWithdrawalAmount($store_id)
        {
            $store = $this->db->field('withdrawal_amount')->where(array('store_id' => $store_id))->find();
            return !empty($store['withdrawal_amount']) ? $store['withdrawal_amount'] : 0;
        }
        //保存提现配置
        public function settingWithdrawal($where, $data)
        {
            return $this->db->where($where)->data($data)->save();
        }

        //提现申请
        public function applywithdrawal($store_id, $amount)
        {
            return $this->db->where(array('store_id' => $store_id))->setDec('balance', $amount);
        }

        //利润提现
        public function drpProfitWithdrawal($store_id, $amount)
        {
            return $this->db->where(array('store_id' => $store_id))->setInc('drp_profit_withdrawal', $amount);
        }

        //删除提现账号
        public function delwithdrawal($store_id)
        {
            return $this->db->where(array('store_id' => $store_id))->data(array('withdrawal_type' => 0, 'bank_id' => 0, 'bank_card' => '', 'bank_card_user' => '', 'last_edit_time' => time()))->save();
        }

        //获取用户店铺
        public function getStoreByUid($uid)
        {
            $store = $this->db->where(array('uid' => $uid, 'status' => 1))->order('store_id ASC')->find();
            return !empty($store['store_id']) ? $store['store_id'] : '';
        }

        //设置分销
        public function setFx($where, $data)
        {
            return $this->db->where($where)->data($data)->save();
        }

        //添加余额
        public function setBalanceInc($store_id, $amount)
        {
            return $this->db->where(array('store_id' => $store_id))->setInc('balance', $amount);
        }

        //添加不可用余额
        public function setUnBalanceInc($store_id, $amount)
        {
            return $this->db->where(array('store_id' => $store_id))->setInc('unbalance', $amount);
        }

        //减少不可用余额
        public function setUnBalanceDec($store_id, $amount)
        {
            return $this->db->where(array('store_id' => $store_id))->setDec('unbalance', $amount);
        }

        //添加收入
        public function setIncomeInc($store_id, $amount)
        {
            return $this->db->where(array('store_id' => $store_id))->setInc('income', $amount);
        }

        //减少收入
        public function setIncomeDec($store_id, $amount)
        {
            return $this->db->where(array('store_id' => $store_id))->setDec('income', $amount);
        }

        public function checkStoreExist($where)
        {
            return $this->db->where($where)->count('store_id');
        }

        //店铺分销级别
        public function getDrpLevel($store_id)
        {
            $store = $this->db->field('drp_level')->where(array('store_id' => $store_id))->find();
            return !empty($store['drp_level']) ? $store['drp_level'] : 0;
        }

        /**
         * @desc 获取用户分销店铺
         * @param $uid 用户id
         * @param $drp_supplier_id 供货商id
         * @return 店铺
         */
        public function getUserDrpStore($uid, $store_id = 0, $drp_approve = 1)
        {
            $where = array();
            $where['uid'] = $uid;
            if ($store_id) {
                $where['store_id'] = $store_id;
            }
            $where['drp_supplier_id'] = array('>', 0);
            $where['status'] = 1;
            if ($drp_approve) {
                $where['drp_approve'] = 1;
            }
            $store = $this->db->where($where)->find();
            return !empty($store) ? $store : '';
        }

        public function getUserDrpStores($uid)
        {
            $stores = $this->db->where(array('uid' => $uid, 'drp_supplier_id' => array('>', 0), 'status' => 1))->select();
            return $stores;
        }

		//判断是否为分销店铺
		public function isDrpStore($store_id)
		{
			$store = $this->db->field('drp_supplier_id')->where(array('store_id' => $store_id))->find();
			return !empty($store['drp_supplier_id']) ? true : false;
		}

		/**
		 * 根据店铺id来返回店铺名称
		 * param store_id_arr array
		 * return array
		 */
		public function getStoreName($store_id_arr = array()) {
			if (empty($store_id_arr)) {
				return array(0 => '-');
			}

			$store_list = D('Store')->where("`status` = 1 AND `store_id` in (" . join(',', $store_id_arr) . ")")->select();

			$data = array();
			foreach ($store_list as $store) {
				$data[$store['store_id']] = $store['name'];
			}

			return $data;

		}




		
		/**
		 * 根据自身坐标与划定区域，检索店铺
		 * @param: $where where条件
		 * @param： $limit 限制条数
		 * @param：$offset 偏移量
		 * @param: $order  排序规则
		 * @param: $get_distance 查找指定距离范围内的店铺数据  单位：km
		 * @param: $$is_distance_order 是否按照距离排序
		 */
		public function getStoreByRoundDistance($where, $limit="10", $offset="0", $order="",$sort="asc", $get_distance="", $is_distance_order = false) {
		
			$WebUserInfo = show_distance();
			$db_prefix = option('system.DB_PREFIX');
			$orders = "";
			if($order) $orders = $order . $sort;
			
			if(empty($WebUserInfo['long'])) {
				$ss = 'ee';
				$store_list = D('')->table("Store as s")->where($where)->limit($offset . ',' . $limit)->order($orders)->select();
			} else{
				if($get_distance) {//指定范围内的降序
		
					if(is_array($where)){
						if(count($where)) {
							$where = implode(" AND ", $where);
						}
					} else{
						if($where) $where = $where ." and ";
					}
					

					$ss = 'HH';

					$store_list = $this->nearshops($WebUserInfo['long'],$WebUserInfo['lat'],$order,$sort,$offset,$limit,$get_distance,$where);

		
				} else {	//纯地理降序
					if($is_distance_order) {
						$ss = "tt";
		
						$store_list = $this->nearshops($WebUserInfo['long'],$WebUserInfo['lat'],$order,$sort,$offset,$limit);
					} else{
						$ss="jj";
						$store_list = D('')->table("Store as s")->where($where)->limit($offset . ',' . $limit)->order($order)->select();
					}
				}
			}
		
			//echo $ss;
			return $store_list;
		}


		/**
		 * 根据自身坐标与划定区域，统计店铺数量
		 * @param: $where where条件
		 * @param: $get_distance 查找指定距离范围内的店铺数据  单位：km
		 * @param: $$is_distance_order 是否按照距离排序
		 */
		public function getStoreByRoundDistanceCount($where,$get_distance="",$is_distance_order = false) {
			$WebUserInfo = show_distance();
			$db_prefix = option('system.DB_PREFIX');

			if(empty($WebUserInfo['long'])) {
				$ss = 'ee';
				$count = D('')->table("Store as s")->where($where)->count('store_id');
			} else{
				if($get_distance) {//指定范围内的降序

					if(is_array($where)){
						if(count($where)) {
							$where = implode(" AND ", $where);
						}
					} else{
						if($where) $where = $where ." and ";
					}
					$squares = returnSquarePoint($WebUserInfo['long'], $WebUserInfo['lat'],$get_distance);
					$ss = 'HH~';
					
					$count = $this->nearshop_count($WebUserInfo['long'],$WebUserInfo['lat'],$get_distance,$where);
					
					
				} else {	//纯地理降序
					if($is_distance_order) {
						$ss = "tt";
						$count = $this->nearshop_count($WebUserInfo['long'],$WebUserInfo['lat']);
					} else{
						$ss="jj";
						$count = D('')->table("Store as s")->where($where)->count("s.store_id");
					}
				}
			}

			//echo $ss;
			return $count;
		}


		//
		/*
		 * @description：			根据坐标获取离你最近的商铺
		 * @param: $long:			坐标经度
		 * @param: $lat:			坐标纬度
		 * @param: $offest:			偏移量
		 * @param: $limit:			限制条数
		 * @param: $get_distance:	查找指定距离范围内的店铺数据  单位：km（注：没空或0，则不限距离）
		 * @param: 补充搜索条件
		 * */
		public function nearshops($long, $lat, $order, $sort="asc" , $offset="0", $limit = "10",$get_distance="",$wheres="") {
			$limit = $limit ? $limit : '12';
			//$order = $order ? $order : "`juli` ASC";
			$where = ""; $where2 = "";
			$WebUserInfo = show_distance();
			$db_prefix = option('system.DB_PREFIX');
			$order_juli = ""; $orders = "";
			if($order == 'juli') {
				$order_juli = " order by c.juli " . $sort;
			} else {
				$orders= " order by " .$order .' '. $sort;
			}
			$julis ="";

			if($get_distance) {
				$squares = returnSquarePoint($WebUserInfo['long'], $WebUserInfo['lat'],$get_distance);
				$where .= "and sc.lat<>0 and sc.lat>{$squares['right-bottom']['lat']} and sc.lat<{$squares['left-top']['lat']} and sc.long>{$squares['left-top']['lng']} and sc.long<{$squares['right-bottom']['lng']}";
				$get_distance = $get_distance*1000;
				$julis .= " where c.juli < ".$get_distance;
			}	
			$sql = "select * from (select `s`.`store_id`, `s`.`name`, `s`.`logo`, `s`.`intro`,`sc`.`long`,`sc`.`lat`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli from " . $db_prefix . "store_contact as sc, " . $db_prefix . "store as s where ". $wheres ." s.status = 1 and sc.store_id = s.store_id ". $where . $orders ." ) as c " .$julis . $order_juli ."  limit {$offset},{$limit}"  ;
			$near_store_list = $this->db->query($sql);

			
			foreach ($near_store_list as $key => $value) {
				$value['url'] = option('config.wap_site_url') . '/home.php?id=' . $value['store_id'] . '&platform=1';
				$value['pcurl'] = url_rewrite('store:index', array('id' => $value['store_id']));

				if (empty($value['logo'])) {
					$value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
				} else {
					$value['logo'] = getAttachmentUrl($value['logo']);
				}
				$near_store_list[$key]['logo'] = $value['logo'];
				$near_store_list[$key]['url'] = $value['url'];
				$near_store_list[$key]['pcurl'] = $value['pcurl'];
			}
			return $near_store_list;
		}


		/*首页指定范围内容的店铺数量
		 *@param: 当前用户的 经度
		 *@param: 当前用户的维度
		 *@param: 指定公里数 单位（km） 默认：10
		 */
		public function nearshop_count($long,$lat,$get_distance="" , $wheres="") {
			$where2 = ""; $julis = "";
			//if($get_distane) $where2 = " AND juli < '".$get_distane."' ";
			if($get_distance) {
				$get_distance = $get_distance*1000;
				$julis = " where c.juli < ".$get_distance;
			}
			$db_prefix = option('system.DB_PREFIX');

			$sql = "select count(c.juli) as count from (select ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli from " . $db_prefix . "store_contact as sc, " . $db_prefix . "store as s where ". $wheres ." s.status = 1 and sc.store_id = s.store_id ) as c ".$julis ;
			$arr = $this->db->query($sql);

			$count = $arr[0]['count']?$arr[0]['count']:0;
			return  $count;
		}
	}