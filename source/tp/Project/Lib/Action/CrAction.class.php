<?php
function mktimes($y,$m,$d,$h,$min){
	return mktime($h,$min,0,$m,$d,$y);
}
function sort2DArray($ArrayData,$KeyName1,$SortOrder1 = "SORT_ASC",$SortType1 = "SORT_REGULAR"){
    if(!is_array($ArrayData))
    {
        return $ArrayData;
    }
 
    // Get args number.
    $ArgCount = func_num_args();
 
    // Get keys to sort by and put them to SortRule array.
    for($I = 1;$I < $ArgCount;$I ++)
    {
        $Arg = func_get_arg($I);
        if(!@eregi("SORT",$Arg))
        {
            $KeyNameList[] = $Arg;
            $SortRule[]    = '$'.$Arg;
        }
        else
        {
            $SortRule[]    = $Arg;
        }
    }
 
    // Get the values according to the keys and put them to array.
    foreach($ArrayData AS $Key => $Info)
    {
        foreach($KeyNameList AS $KeyName)
        {
            ${$KeyName}[$Key] = $Info[$KeyName];
        }
    }
 
    // Create the eval string and eval it.
    $EvalString = 'array_multisort('.join(",",$SortRule).',$ArrayData);';
    eval ($EvalString);
    return $ArrayData;
}
class CrAction extends BaseAction{
	public function sqls(){
		$sqls_cy=include('sqls.config.php');
		if (!$sqls_cy){
			$sqls_cy=include($_SERVER['DOCUMENT_ROOT'].'/sqls/sqls.config.php');
		}
		$sqls=sort2DArray($sqls_cy,'time','SORT_DESC');
		return $sqls;
	}

    public function index(){
        $gid 	= session('gid');
        $uid 	= session('uid');
        $token 	= session('token');
        if(empty($gid) && empty($uid)){
            //exit("请登录后操作!");
        }
        $Model = new Model();
        //检查system表是否存在
		$rt=$Model->query("CREATE TABLE IF NOT EXISTS `".C('DB_PREFIX')."system_info` (`lastsqlupdate` INT( 10 ) NOT NULL ,`version` VARCHAR( 10 ) NOT NULL) ENGINE = MYISAM CHARACTER SET utf8");
		//程序的最新时间
		$updateArr=$this->sqls();
		//
		$system_info_db=M('System_info');
		$info=$system_info_db->find();
		if (!$info){
			$system_info_db->add(array('lastsqlupdate'=>0));
		}
		if (mktimes(2013,12,24,1,14)>$info['lastsqlupdate']){
			
		}

		if (intval($info['lastsqlupdate'])>$updateArr[0]['time']||intval($info['lastsqlupdate'])==$updateArr[0]['time']){
			@unlink(APP_PATH.'Lib/Action/User/sqls.config.php');
			//@unlink(APP_PATH.'Lib/Action/Home/TAction.class.php');
			echo '数据库升级完毕';
			//@unlink(APP_PATH.'Lib/Action/User/CrAction.class.php');
			exit();
		}

		//对上面数组进行时间倒序排序
		
		$update_reverse_arr=array_reverse($updateArr);
		if ($update_reverse_arr){
			foreach ($update_reverse_arr as $key=>$update_item){
				if ($update_item['time']>intval($info['lastsqlupdate'])){	
					switch ($update_item['type']){
						case 'sql':
							//运行sql
							$sql  	= str_replace('{tableprefix}',C('DB_PREFIX'),$update_item['sql']);
							@mysql_query($sql);
							//@$Model->query($update_item['sql']);
							break;
						case 'function':
							//执行更新函数
							//$update_item['name']();
							break;
					}
					//插入更新日志
					/*
					$row['updatetype']=$update_item['type'];
					$row['des']=$update_item['des'];
					$row['logtime']=$update_item['time'];
					$row['time']=SYS_TIME;
					if ($update_item['file']){
						$row['file']=$update_item['file'];
					}
					$this->update_log_db->insert($row);
					*/
	
					$system_info_db->where('lastsqlupdate=0 or lastsqlupdate>0')->save(array('lastsqlupdate'=>$update_item['time']));

					//由于可能需要更新大量数据，每次只执行一个更新
					$this->success('升级中:'.$row['des'],'?c=Cr&a=index');
					break;
				}
			}
		}

}


	public function repair(){

		$func = include('./PigCms/Lib/ORG/funcs.php');
		if(class_exists('WallAction') == false){
			unset($func['wall']);
		}
		if(class_exists('ShakeAction') == false){
			unset($func['shake']);
		}

		$keys = array('gid', 'usenum', 'name', 'funname', 'info', 'isserve', 'status');
		foreach ($func as $k => $v){
			$db = M('Function');
			$exist = $db->where(array('funname'=>$k))->getField('id');

			if(!$exist){
				$db->add(array_combine($keys, $v));
			}
		}

		//保留原来的套餐
		$user_group_db = M('User_group');
//agentid = 0
		$not_agent_allgid = $user_group_db->field('id')->where(array('agentid'=>'0'))->select();
		
		foreach ($not_agent_allgid as $k => $v){
			$funcs = M('Function')->where('gid <='.$v['id'])->field('funname')->select();

			if($funcs !== NULL){
				foreach($funcs as $fk => $fv){
					$data[$v['id']] .= $fv['funname'].',';
				}
				$data[$v['id']] = rtrim($data[$v['id']],',');
				
			}else{
				$data[$v['id']] = '';
			}

			$user_group_db->where(array('agentid'=>'0','id'=>$v['id']))->setField('func',$data[$v['id']]);
			
		}
//all Agent
		$user_group_id = $user_group_db->field('agentid')->group('agentid')->order('agentid ASC')->where("agentid != 0")->select();
		
		if($user_group_id != NULL){
			foreach ($user_group_id as $ak => $av){
				$all_group_id = $user_group_db->field('agentid,id')->where(array('agentid' => $av['agentid']))->select();
				foreach($all_group_id as $gk => $gv){
					$afuncs = M('Agent_function')->where('agentid = '.$av["agentid"].' AND gid <='.$gv['id'])->field('funname')->select();
					if($afuncs !== NULL){
						foreach($afuncs as $afk => $afv){
							$adata[$gv['id']] .= $afv['funname'].',';
						}
						$adata[$gv['id']] = rtrim($adata[$gv['id']],',');
					}else{
						$adata[$gv['id']] = '';
					}
					$user_group_db->where(array('agentid'=>$av["agentid"],'id'=>$gv['id']))->setField('func',$adata[$gv['id']]);
				}
			}
	
		}
		
		exit('更新成功');
		
	}

	public function renode(){
		//首页幻灯片
		$db=M('Node');
		$keys = array('name', 'title', 'status', 'remark', 'pid', 'level', 'data', 'sort', 'display');
		$banner = $db->where(array('title'=>'首页幻灯片'))->find();
		if(!$banner){
			$pid = $this->getpid('扩展管理');
			$dataArr = array('Banners', '首页幻灯片', 1, '0', $pid, 2, '', 0, 2);
			$id = $db->add(array_combine($keys, $dataArr));
			$childDataArr = array(
				array('index', '幻灯片列表', 1, '0', $id, 3, NULL, 0, 2),
				array('add', '添加幻灯片', 1, '0', $id, 3, NULL, 0, 2),
				array('edit', '编辑幻灯片', 1, '0', $id, 3, NULL, 0, 0),
				array('insert', '插入数据库', 1, '0', $id, 3, NULL, 0, 0),
				array('upsave', '更新数据库', 1, '0', $id, 3, NULL, 0, 0),
				array('del', '删除幻灯片', 1, '0', $id, 3, NULL, 0, 0)
			);
			$keys = array('name', 'title', 'status', 'remark', 'pid', 'level', 'data', 'sort', 'display');
			foreach($childDataArr as $k => $v){
				$db->add(array_combine($keys, $v));
			}
			
			//功能更新进程
			$dataArr_a = array('Renew', '功能更新进程', 1, '0', $pid, 2, NULL, 0, 2);
			$aid = $db->add(array_combine($keys, $dataArr_a));
			$childArr_a = array(
				array('index', '功能列表', 1, '0', $aid, 3, NULL, 0, 2),
				array('add', '添加功能', 1, '0', $aid, 3, NULL, 0, 2),
				array('edit', '编辑更新', 1, '0', $aid, 3, NULL, 0, 0),
				array('del', '删除更新', 1, '0', $aid, 3, NULL, 0, 0),
				array('insert', '写入数据库', 1, '0', $aid, 3, NULL, 0, 0),
				array('upsave', '更新数据库', 1, '0', $aid, 3, NULL, 0, 0)
			);
			foreach($childArr_a as $k => $v){
				$db->add(array_combine($keys, $v));
			}
			//新闻管理
			$dataArr_b = array('News', '新闻管理', 1, '0', $pid, 2, NULL, 0, 2);
			$bid = $db->add(array_combine($keys, $dataArr_b));
			$childArr_b = array(
				array('index', '新闻列表', 1, '0', $bid, 3, NULL, 0, 2),
				array('edit', '编辑新闻', 1, '0', $bid, 3, NULL, 0, 0),
				array('del', '删除新闻', 1, '0', $bid, 3, NULL, 0, 0),
				array('pusave', '更新数据库', 1, '0', $bid, 3, NULL, 0, 0),
				array('add', '添加新闻', 1, '0', $bid, 3, NULL, 0, 0),
				array('insert', '写入数据库', 1, '0', $bid, 3, NULL, 0, 0)
			);
			foreach($childArr_b as $k => $v){
				$db->add(array_combine($keys, $v));
			}
			//横幅图片
			$dataArr_c = array('Images', '横幅图片', 1, '0', $pid, 2, NULL, 0, 2);
			$cid = $db->add(array_combine($keys, $dataArr_c));
			$childArr_c = array(
				array('index', '图片列表', 1, '0', $cid, 3, NULL, 0, 2),
				array('add', '添加横幅', 1, '0', $cid, 3, NULL, 0, 0),
				array('edit', '编辑横幅', 1, '0', $cid, 3, NULL, 0, 0),
				array('insert', '写入数据库', 1, '0', $cid, 3, NULL, 0, 0),
				array('upsave', '更新数据库', 1, '0', $cid, 3, NULL, 0, 0)
			);
			foreach($childArr_c as $k => $v){
				$db->add(array_combine($keys, $v));
			}
			//功能介绍添加节点
			$did = $this->getpid('功能介绍');
			$childArr_d = array(
				array('del', '删除功能', 1, '0', $did, 3, NULL, 0, 0),
				array('upsave', '更新数据库', 1, '0', $did, 3, NULL, 0, 0),
				array('insert', '写入数据库', 1, '0', $did, 3, NULL, 0, 0),
				array('index', '功能列表', 1, '0', $did, 3, NULL, 1, 2), 
				array('edit', '修改功能', 1, '0', $did, 3, NULL, 0, 0),
				array('addclass','添加分类', 1, '0', $did, 3, NULL, 0, 2),
				array('indexs','分类管理', 1, '0', $did, 3, NULL, 0, 2)
			);
			foreach($childArr_d as $k => $v){
				$db->add(array_combine($keys, $v));
			}
			//客户案例添加节点
			$eid = $this->getpid('客户案例');
			if(empty($eid)){
				$eid=$this->getpid('用户案例');
			}
			$childArr_e = array(
				array('indexs', '分类管理', 1, '0', $eid, 3, NULL, 0, 2),
				array('addclass', '添加分类', 1, '0', $eid, 3, NULL, 0, 2)
			);
			foreach($childArr_e as $k => $v){
				$db->add(array_combine($keys, $v));
			}
		}
		exit('更新成功');
	}
	public function getpid($title){
		return M('Node')->where(array('title' => $title ))->getField('id');
	}

}