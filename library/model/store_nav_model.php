<?php
class store_nav_model extends base_model{
	public function getStoreNav($store_id){
		$nav = $this->db->where(array('store_id' => $store_id))->find();
		return $nav;
	}

	public function add($data){
		return $this->db->data($data)->add();
	}

	public function edit($where, $data){
		return $this->db->where($where)->data($data)->save();
	}
	public function getParseNav($store_id){
		$nav = $this->getStoreNav($store_id);
		if(empty($nav)) return '';
		$navData = unserialize($nav['data']);
		if(empty($navData)) return '';
		$storeNav = '';
		switch($nav['style']){
			case '1':
				$storeNav.= '<div class="js-navmenu js-footer-auto-ele shop-nav nav-menu nav-menu-1 has-menu-'.count($navData).'">';
				$storeNav.= '<div class="nav-special-item nav-item"><a href="./home.php?id='.$store_id.'" class="home">主页</a></div>';
                foreach($navData as $value){
                    $flag = true;
                    $style = '';
					switch($value['url']){
						case 'ucenter':
							$value['url'] = './ucenter.php?id='.$store_id;
							break;
                        case 'drp':
                            if (!option('config.open_store_drp')) { //未开启排他分销
                                continue 2;
                            }
                            if ((!empty($_SESSION['store']) || !empty($_SESSION['user'])) && empty($_SESSION['store']['drp_supplier_id'])) { //禁止分销自己的店铺
                                $flag = false;
                            }
                            if (!empty($store_id)) { //指定分销分销店铺
                                $store = D('Store')->field('uid')->where(array('store_id' => $store_id))->find();
                                if ($_SESSION['wap_user']['uid'] == $store['uid']) { //自己店铺
                                    $drp_store = M('Store')->getUserDrpStore($_SESSION['wap_user']['uid'], intval(trim($store_id)), 0, 0);
                                } else { //他人店铺（供货商）
                                    $drp_store = D('Store')->where(array('drp_supplier_id' => $store_id, 'uid' => $_SESSION['wap_user']['uid'], 'status' => 1))->find();
                                }
                            }
                            if (!empty($_SESSION['wap_drp_store']) && $_SESSION['wap_drp_store']['uid'] != $_SESSION['wap_user']['uid']) {
                                unset($_SESSION['wap_drp_store']);
                            }
                            if ((!empty($_SESSION['wap_drp_store']) && $_SESSION['wap_drp_store']['drp_supplier_id'] == $store_id) || (!empty($_SESSION['wap_user']) && !empty($drp_store))) {
                                if (!empty($_SESSION['wap_drp_store'])) {
                                    $fx_store_id = $_SESSION['wap_drp_store']['store_id'];
                                } else {
                                    $_SESSION['wap_drp_store'] = $drp_store;
                                    $fx_store_id = $drp_store['store_id'];
                                }
                                $value['name'] = '分销管理';
                                $value['url'] = './drp_register.php?id=' . $fx_store_id;
                            } else {
                                if (!empty($_SESSION['wap_user']['uid'])) {
                                    $tmp_store = D('Store')->field('uid')->where(array('store_id' => $store_id))->find();
                                    if (!empty($tmp_store['uid']) && $tmp_store['uid'] == $_SESSION['wap_user']['uid']) {
                                        $flag = false;
                                    }
                                }
                                if ($flag) {
                                    if (!empty($_SESSION['wap_user']['uid'])) {
                                        $value['url'] = './drp_register.php?id=' . $store_id;
                                    } else {
                                        $value['url'] = './login.php?referer=' . urlencode(option('config.wap_site_url') . '/drp_register.php?id=' . $store_id);
                                    }
                                } else {
                                    $value['url'] = 'javascript:void(0);';
                                    $style = 'style="color:lightgray;cursor:no-drop;"';
                                }
                            }
                            break;
                        case 'home':
                            $value['url'] = './home.php?id='.$store_id;
                            break;
                        case 'cart':
                            $value['url'] = './cart.php?id=' . $store_id;
                            break;
					}
					$storeNav.= '<div class="nav-item">';
					$storeNav.= '<a class="mainmenu js-mainmenu" href="'.(!empty($value['url']) ? $value['url'] : 'javascript:void(0);').'">'.(!empty($value['submenu']) ? '<i class="arrow-weixin"></i>' : '').'<span class="mainmenu-txt" ' . $style . '>'.$value['name'].'</span></a>';
					if(!empty($value['submenu'])){
						$storeNav.= '<div class="submenu js-submenu"><span class="arrow before-arrow"></span><span class="arrow after-arrow"></span><ul>';
                        $style = '';
                        foreach($value['submenu'] as $k=>$v){
                            $flag = true;
                            if (strtolower($v['url']) == 'drp') {
                                if (!option('config.open_store_drp')) { //未开启排他分销
                                    continue 2;
                                }
                                if ((!empty($_SESSION['store']) || !empty($_SESSION['user'])) && empty($_SESSION['store']['drp_supplier_id'])) { //禁止分销自己的店铺
                                    $flag = false;
                                }
                                if (!empty($store_id)) { //指定分销分销店铺
                                    $store = D('Store')->field('uid')->where(array('store_id' => $store_id))->find();
                                    if ($_SESSION['wap_user']['uid'] == $store['uid']) { //自己店铺
                                        $drp_store = M('Store')->getUserDrpStore($_SESSION['wap_user']['uid'], intval(trim($store_id)), 0, 0);
                                    } else { //他人店铺（供货商）
                                        $drp_store = D('Store')->where(array('drp_supplier_id' => $store_id, 'uid' => $_SESSION['wap_user']['uid'], 'status' => 1))->find();
                                    }
                                }
                                if (!empty($_SESSION['wap_drp_store']) && $_SESSION['wap_drp_store']['uid'] != $_SESSION['wap_user']['uid']) {
                                    unset($_SESSION['wap_drp_store']);
                                }
                                if ((!empty($_SESSION['wap_drp_store']) && $_SESSION['wap_drp_store']['drp_supplier_id'] == $store_id) || (!empty($_SESSION['wap_user']) && !empty($drp_store))) {
                                    if (!empty($_SESSION['wap_drp_store'])) {
                                        $fx_store_id = $_SESSION['wap_drp_store']['store_id'];
                                    } else {
                                        $_SESSION['wap_drp_store'] = $drp_store;
                                        $fx_store_id = $drp_store['store_id'];
                                    }
                                    $v['name'] = '分销管理';
                                    $v['url'] = './drp_ucenter.php?id=' . $fx_store_id;
                                } else {
                                    if (!empty($_SESSION['wap_user']['uid'])) {
                                        $tmp_store = D('Store')->field('uid')->where(array('store_id' => $store_id))->find();
                                        if (!empty($tmp_store['uid']) && $tmp_store['uid'] == $_SESSION['wap_user']['uid']) {
                                            $flag = false;
                                        }
                                    }
                                    if ($flag) {
                                        if (!empty($_SESSION['wap_user']['uid'])) {
                                            $v['url'] = './drp_register.php?id=' . $store_id;
                                        } else {
                                            $v['url'] = './login.php?referer=' . urlencode(option('config.wap_site_url') . '/drp_register.php?id=' . $store_id);
                                        }
                                    } else {
                                        $v['url'] = 'javascript:void(0);';
                                        $style = 'style="color:lightgray;cursor:no-drop;"';
                                    }
                                }
                            } else if (strtolower($v['url']) == 'ucenter') {
                                $v['url'] = './ucenter.php?id=' . $store_id;
                            } else if (strtolower($v['url']) == 'home') {
                                $v['url'] = './home.php?id='.$store_id;
                            }
                            $storeNav.= ' <li><a href="'.(!empty($v['url']) ? $v['url'] : 'javascript:void(0);').'" ' . $style . '>'.$v['name'].'</a></li>';
							if($k != count($value['submenu'])-1){
								$storeNav.= '<li class="line-divide"></li>';
							}
						}
						$storeNav.= '</ul></div>';
					}
					$storeNav.= '</div>';
				}
				
				$storeNav .= '</div>';
				break;
			case '2':
                foreach($navData as $value){
                    $flag = true;
                    $style = '';
					switch($value['url']){
						case 'ucenter':
							$value['url'] = './ucenter.php?id='.$store_id;
							break;
                        case 'drp':
                            if (!option('config.open_store_drp')) { //未开启排他分销
                                continue 2;
                            }
                            if ((!empty($_SESSION['store']) || !empty($_SESSION['user'])) && empty($_SESSION['store']['drp_supplier_id'])) { //禁止分销自己的店铺
                                $flag = false;
                            }
                            if (!empty($_GET['id'])) { //指定分销分销店铺
                                $drp_store = M('Store')->getUserDrpStore($_SESSION['wap_user']['uid'], intval(trim($_GET['id'])));
                            }
                            if (!empty($_SESSION['wap_drp_store']) || (!empty($_SESSION['wap_user']) && !empty($drp_store))) {
                                if (!empty($_SESSION['wap_drp_store'])) {
                                    $fx_store_id = $_SESSION['wap_drp_store']['store_id'];
                                } else {
                                    $fx_store_id = $drp_store['store_id'];
                                }
                                $value['name'] = '分销管理';
                                $value['url'] = './drp_register.php?id=' . $fx_store_id;
                            } else {
                                if (!empty($_SESSION['wap_user']['uid'])) {
                                    $tmp_store = D('Store')->field('uid')->where(array('store_id' => $store_id))->find();
                                    if (!empty($tmp_store['uid']) && $tmp_store['uid'] == $_SESSION['wap_user']['uid']) {
                                        $flag = false;
                                    }
                                }
                                if ($flag) {
                                    if (!empty($_SESSION['wap_user']['uid'])) {
                                        $value['url'] = './drp_register.php?id=' . $store_id;
                                    } else {
                                        $value['url'] = './login.php?referer=' . urlencode(option('config.wap_site_url') . '/drp_register.php?id=' . $store_id);
                                    }
                                } else {
                                    $value['url'] = 'javascript:void(0);';
                                    $style = 'style="color:lightgray;cursor:no-drop;"';
                                }
                            }
                            break;
                        case 'home':
                            $value['url'] = './home.php?id='.$store_id;
                            break;
                        case 'cart':
                            $value['url'] = './cart.php?id=' . $store_id;
                            break;
					}
					if(!empty($value['image1']) && (substr($value['image1'],0,9) == './upload/' || substr($value['image1'],0,11) == './template/')){
						$value['image1'] = str_replace('./upload/',option('config.site_url').'/upload/',$value['image1']);
						$value['image1'] = str_replace('./template/',option('config.site_url').'/template/',$value['image1']);
					}
					if(!empty($value['image2']) && (substr($value['image2'],0,9) == './upload/' || substr($value['image2'],0,11) == './template/')){
						$value['image2'] = str_replace('./upload/',option('config.site_url').'/upload/',$value['image2']);
						$value['image2'] = str_replace('./template/',option('config.site_url').'/template/',$value['image2']);
					}
					$newNavData[] = $value;
				}
                if (!empty($nav['bgcolor'])) {
                    $background_color = $nav['bgcolor'];
                } else {
                    $background_color = '#2B2D30';
                }
				$storeNav.= '<div class="js-navmenu js-footer-auto-ele shop-nav nav-menu nav-menu-2 has-menu-'.(count($newNavData)).'" style="background-color:' . $background_color . ';">';
				$storeNav.= '<ul class="clearfix">';
				foreach($newNavData as $key=>$value){
					$storeNav.= '<li><a href="'.($value['url'] ? $value['url'] : 'javascript:;').'" style="background-image:url('.$value['image1'].');" title="'.$value['text'].'"></a></li>';
				}
				$storeNav .= '</ul>';
				$storeNav .= '</div>';
				break;
			case '3':
                foreach($navData as $value){
                    $flag = true;
                    $style = '';
					switch($value['url']){
						case 'ucenter':
							$value['url'] = './ucenter.php?id='.$store_id;
							break;
                        case 'drp':
                            if (!option('config.open_store_drp')) { //未开启排他分销
                                continue 2;
                            }
                            if ((!empty($_SESSION['store']) || !empty($_SESSION['user'])) && empty($_SESSION['store']['drp_supplier_id'])) { //禁止分销自己的店铺
                                $flag = false;
                            }
                            if (!empty($_GET['id'])) { //指定分销分销店铺
                                $drp_store = M('Store')->getUserDrpStore($_SESSION['wap_user']['uid'], $store_id);
                            }
                            if (!empty($_SESSION['wap_drp_store']) || (!empty($_SESSION['wap_user']) && !empty($drp_store))) {
                                if (!empty($_SESSION['wap_drp_store'])) {
                                    $fx_store_id = $_SESSION['wap_drp_store']['store_id'];
                                } else {
                                    $fx_store_id = $drp_store['store_id'];
                                }
                                $value['name'] = '分销管理';
                                $value['url'] = './drp_register.php?id=' . $fx_store_id;
                            } else {
                                if (!empty($_SESSION['wap_user']['uid'])) {
                                    $tmp_store = D('Store')->field('uid')->where(array('store_id' => $store_id))->find();
                                    if (!empty($tmp_store['uid']) && $tmp_store['uid'] == $_SESSION['wap_user']['uid']) {
                                        $flag = false;
                                    }
                                }
                                if ($flag) {
                                    if (!empty($_SESSION['wap_user']['uid'])) {
                                        $value['url'] = './drp_register.php?id=' . $store_id;
                                    } else {
                                        $value['url'] = './login.php?referer=' . urlencode(option('config.wap_site_url') . '/drp_register.php?id=' . $store_id);
                                    }
                                } else {
                                    $value['url'] = 'javascript:void(0);';
                                    $style = 'style="color:lightgray;cursor:no-drop;"';
                                }
                            }
                            break;
                        case 'home':
                            $value['url'] = './home.php?id='.$store_id;
                            break;
                        case 'cart':
                            $value['url'] = './cart.php?id=' . $store_id;
                            break;
					}
					if(!empty($value['image1']) && (substr($value['image1'],0,9) == './upload/' || substr($value['image1'],0,11) == './template/')){
						$value['image1'] = str_replace('./upload/',option('config.site_url').'/upload/',$value['image1']);
						$value['image1'] = str_replace('./template/',option('config.site_url').'/template/',$value['image1']);
					}
					if(!empty($value['image2']) && (substr($value['image2'],0,9) == './upload/' || substr($value['image2'],0,11) == './template/')){
						$value['image2'] = str_replace('./upload/',option('config.site_url').'/upload/',$value['image2']);
						$value['image2'] = str_replace('./template/',option('config.site_url').'/template/',$value['image2']);
					}
					$newNavData[] = $value;
				}
                if (!empty($nav['bgcolor'])) {
                    $background_color = $nav['bgcolor'];
                } else {
                    $background_color = '#2B2D30';
                }
				$storeNav.= '<div class="js-navmenu js-footer-auto-ele shop-nav nav-menu nav-menu-3 has-menu-'.(count($newNavData)-1).'">';
				foreach($newNavData as $key=>$value){
                    if($key > 0) {
                        $storeNav.= '<div class="nav-item"><a href="'.($value['url'] ? $value['url'] : 'javascript:;').'" style="background-image:url('.$value['image1'].');" title="'.$value['text'].'"></a></div>';
                    }
                    if (count($newNavData) == 1) {
                        $storeNav.= '<div class="nav-item"><a href="'.($value['url'] ? $value['url'] : 'javascript:;').'" style="background-image:url('.$value['image1'].');" title="'.$value['text'].'"></a></div>';
                    }
                    if(($key == 0 && count($newNavData) == 1) || ($key == 2 && count($newNavData) > 3) || ($key == 1 && count($newNavData) == 2) || ($key == 1 && count($newNavData) == 3)){
                        $storeNav.= '<div class="nav-special-item nav-item"><a href="'.($newNavData[0]['url'] ? $newNavData[0]['url'] : 'javascript:;').'" style="background-image:url('.$newNavData[0]['image1'].');border-color:#2B2D30;" title="'.$newNavData[0]['text'].'"></a></div>';
					}
				}
				$storeNav .= '</div>';
				break;
		}
		return $storeNav;
	}
}