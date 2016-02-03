<?php
class mysql{

	protected $db_prefix;	//表名的前缀
	protected $conn;	//内部数据连接对象

    protected $distinct=''; //去重复
	protected $where='';	//条件
	protected $table='';	//表名
	protected $field='';	//字段
	protected $order='';	//排序
	protected $group = '';	//分组
	protected $limit='';	//查询的数量
	protected $data='';		//存储的数据
    protected $join='';     //连接

	public  $select_count=0;	//查询出来的数量
	public $last_sql='';	//上一条SQL语句
	public $lastInsID = 0;
	 /**
	 * 初始时自动调用
	 */
	public function __construct($other=array()){
        import('source.class.checkFunc');
		$checkFunc=new checkFunc();
		if (!function_exists('fdsrejsie3qklwewerzdagf4ds')){exit('error-4');}
		$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		if (!function_exists('mysql_connect')){
			pigcms_tips('服务器空间PHP不支持MySql数据库','none');
		}

		if(empty($other)){
			global $_G;
		}else{
			$_G['system'] 	= $other;
		}

		$this->db_prefix = $_G['system']['DB_PREFIX'];
		if (!$this->conn = @mysqli_connect($_G['system']['DB_HOST'].':'.$_G['system']['DB_PORT'], $_G['system']['DB_USER'], $_G['system']['DB_PWD'])) {
            switch ($this->geterrno()){
                case 2005:
                    pigcms_tips('连接数据库失败，数据库地址错误或者数据库服务器不可用','none');
                    break;
                case 2003:
                    pigcms_tips('连接数据库失败，数据库端口错误','none');
                    break;
                case 2006:
                    pigcms_tips('连接数据库失败，数据库服务器不可用','none');
                    break;
                case 1045:
                    pigcms_tips('连接数据库失败，数据库用户名或密码错误','none');
                    break;
                default :
                    pigcms_tips('连接数据库失败，请检查数据库信息。错误编号：' . $this->geterrno(),'none');
                    break;
            }
		}
		if ($this->getMysqlVersion() > '4.1') {
			mysqli_query($this->conn,"SET NAMES 'utf8'");
		}
		@mysqli_select_db($this->conn,$_G['system']['DB_NAME']) OR pigcms_tips('连接数据库失败，未找到您填写的数据库 <b>'.$_G['system']['DB_NAME'].'</b>','none');
	}
    function table($table){
        if(is_array($table)){
            foreach($table as $key=>$value){
                $lower_name = strtolower($key);
                if($key != $lower_name){
                    $now_arr[] = '`'.$this->db_prefix.$lower_name.'` `'.$value.'`';
                }else{
                    $now_arr[] .= '`'.$key.'` `'.$value.'` ';
                }
            }
            $now_table = implode(',',$now_arr);
        }else{
            $lower_name = strtolower($table);

            $is_alias = strpos(" as ", $lower_name);
            if( $is_alias === true)   $table_arr =  preg_split('/(as)/',$lower_name);
            if($table != $lower_name){
                $now_table = ''.$this->db_prefix.$lower_name.'';
            }else{
                $now_table = ''.$table.'';
            }
        }
        $this->table = $now_table;
        return $this;
    }



    protected function parseKey(&$key) {
        return $key;
    }
     function parseTable($tables) {
        if(is_array($tables)) {// 支持别名定义
            $array = array();
            foreach ($tables as $table=>$alias){
                if(!is_numeric($table))
                    $array[] = $this->parseKey($table).' '.$this->parseKey($alias);
                else
                    $array[] = $this->parseKey($table);
            }
            $tables = $array;
        }elseif(is_string($tables)){
            $tables = explode(',',$tables);
            array_walk($tables, array(&$this, 'parseKey'));
        }
        return implode(',',$tables);
    }
	function field($field){
		$this->field = $field;
		return $this;
	}
	function where($where){
		if(empty($where)) return $this;
		if(is_array($where)){
			$connector = ' AND ';
			if($where['connector'] == 'OR'){
				$connector = ' OR ';
				unset($where['connector']);
			}
			foreach($where as $key=>$value){
				if(is_array($value)){
					if(is_array($value[0])){
						foreach($value as $k=>$v){
							$now_arr[] = '`'.$key.'`'.$v[0] . "'" . $v[1] . "'";
						}
					}else{
						if($value[0] == 'in'){
							$now_arr[] = '`'.$key.'` IN('.implode(',',$value[1]).')';
                        }  else if($value[0] == 'or') {
							$now_arr[] = '`'.$key.'` IN('.implode(',',$value[1]).')';

						}else if ($value[0] == 'not in') {
                            $now_arr[] = '`'.$key.'` NOT IN('.implode(',',$value[1]).')';
                        } else if($value[0] == 'like'){
							$now_arr[] = '`'.$key.'` LIKE \''.$value[1].'\'';
						} elseif($value[0] == 'find_in_set'){
                            $now_arr[] = "find_in_set('".$value[1]."',".$key.")";
                        }else{
							if($value[1] === '') $value[1] = "''";
							$now_arr[] = '`'.$key.'`'.$value[0]. "'" . $value[1] . "'";
						}
					}
				}elseif($key == '_string'){
					$now_arr[] = $value;
				}else{
					$now_arr[] = '`'.$key.'`='."'".$value."'";
				}
				
			}
			$now_where = implode($connector,$now_arr);
		}else{
			$now_where = $where;
		}
		$this->where = $now_where;
		return $this;
	}
	function data($data){
		$this->data = $data;
		return $this;
	}
	function save(){
		if(is_array($this->data)){
			foreach($this->data as $key=>$value){
				$now_arr[] = '`'.$key."`='$value'";
			}
			$now_data = implode(',',$now_arr);
		}else{
			$now_data = $this->data;
		}
		
		$sql = 'UPDATE '.$this->table.' SET '.$now_data;
		
		if(empty($this->where)){
			pigcms_tips('为了保证数据库的安全，没有条件的更新不允许执行','none');
		}
		$sql .= ' WHERE '.$this->where;
		$this->clear_data();
		return $this->execute($sql);
	}
	function add(){
		if(is_array($this->data)){
			foreach($this->data as $key=>$value){
				$key_str .= '`'.$key.'`,';
				$value_str .= '\''.$value.'\',';
			}
			$sql_str = '('.rtrim($key_str,',').') VALUES ('.rtrim($value_str,',').')';
		}else{
			$sql_str = $this->data;
		}
		
		$sql = 'INSERT INTO '.$this->table.' '.$sql_str;
		$rows = $this->execute($sql);
		if($this->lastInsID){
			return $this->lastInsID;
		}elseif($rows > 0){
			return $rows;
		}
	}
	function addAll(){
		if(!is_array($this->data[0])) return false;
		$tmp_fields = array_keys($this->data[0]);
		foreach($tmp_fields as $value){
			$fields[] = '`'.$value.'`';
		}
		foreach($this->data as $key=>$value){
			$value_str = '';
			foreach($value as $k=>$v){
				$value_str .= '\''.$v.'\',';
			}
			$sql_str[] = '('.rtrim($value_str,',').')';
		}
		$sql   =  'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES '.implode(',',$sql_str);
		return $this->execute($sql);
	}
    function distinct($flag = false)
    {
        $this->distinct = $flag;
        return $this;
    }
	function order($order){
		$this->order = $order;
		return $this;
	}
	function group($group) {
		$this->group = $group;
		return $this;
	}
     function join($join) {
        $joinStr = '';
        if(!empty($join)) {
            if(is_array($join)) {
                foreach ($join as $key=>$_join){
                    if(false !== stripos($_join,'JOIN'))
                        $joinStr .= ' '.$_join;
                    else
                        $joinStr .= ' LEFT JOIN ' .$_join;
                }
            }else{
             //   $joinStr .= ' LEFT JOIN '.$join;
                $lower_name = strtolower($join);
                if($join != $lower_name){

                    $joinStr .= ' LEFT JOIN '.$this->db_prefix.$lower_name;
                }else{
                    $joinStr .= ' LEFT JOIN '.$join;
                }
            }
        }
        //将__TABLE_NAME__这样的字符串替换成正规的表名,并且带上前缀和后缀
        // echo $this->db_prefix;
        $this->join .= preg_replace("/__([A-Z_-]+)__/",$this->db_prefix.".strtolower('$1')",$joinStr);
        return $this;
    }

	function limit($limit){
		$this->limit = $limit;
		return $this;
	}
	function find(){
		$this->limit = 1;
		$result_query = $this->fetch_array($this->dbselect());
		if(is_array($result_query)){
			return $result_query;
		}else{
			return array();
		}
	}
	function count($field){
        if ($this->distinct) {
            $field = 'DISTINCT(' . $field . ')';
        }
		$this->field = 'COUNT('.$field.') AS `pigcms_count`';
		$this->limit = '1';
		$row = $this->fetch_array($this->dbselect());
		return $row['pigcms_count'];
	}
    function sum($field){
        $this->field = 'SUM('.$field.') AS `pigcms_sum`';
        $this->limit = '1';
        $row = $this->fetch_array($this->dbselect());
        return $row['pigcms_sum'];
    }
	function max($field){
		$this->field = '`'.$field.'`';
		$this->limit = '1';
		$this->order = '`'.$field.'` DESC';
		$row = $this->fetch_array($this->dbselect());
		return $row["$field"];
	}
	function delete(){
		$sql = 'DELETE FROM '.$this->table;
		if(empty($this->where)){
			pigcms_tips('为了保证数据库的安全，没有条件的删除不允许执行','none');
		}
		$sql .= ' WHERE '.$this->where;
		$this->clear_data();
		return $this->execute($sql);
	}
	function select(){
		$result_query = $this->dbselect();
		return $this->getall($result_query);
	}
	function query($sql){
		//error_log($sql);
		$this->last_sql = $sql;
		$result_query = @mysqli_query($this->conn,$sql);
		return $this->getall($result_query);
	}
	function getall($result_query){
		if($result_query === false) return array();
		$num_rows = @mysqli_num_rows($result_query);
		$this->select_count = $num_rows;
		if($num_rows >0) {
            while($row = $this->fetch_array($result_query)){
                $result[] = $row;
            }
			return $result;
        }else{
			return array();
		}
	}
	function execute($sql){
		//error_log($sql);
		$this->last_sql = $sql;
		$result_query = @mysqli_query($this->conn,$sql);
		$this->lastInsID = mysqli_insert_id($this->conn);
		return mysqli_affected_rows($this->conn);
	}
	function setInc($field,$step=1){
		$sql = 'UPDATE '.$this->table.' SET `'.$field.'`=`'.$field.'`+'.$step;
		
		if($this->where){
			$sql .= ' WHERE '.$this->where;
		}
		return $this->execute($sql);
	}
	function setDec($field,$step=1){
		$sql = 'UPDATE '.$this->table.' SET `'.$field.'`=`'.$field.'`-'.$step;
		
		if($this->where){
			$sql .= ' WHERE '.$this->where;
		}
		return $this->execute($sql);
	}
	function setField($field,$value){
		$sql = 'UPDATE '.$this->table.' SET `'.$field."`='".$value."'";
		
		if($this->where){
			$sql .= ' WHERE '.$this->where;
		}
		return $this->execute($sql);
	}
	/**
	 * 发送查询语句供内部使用
	 *
	 */
	function dbselect(){
		$sql = 'SELECT ';
		if($this->field){
			$sql .= $this->field.' FROM '.$this->table;
		}else{
			$sql .= '* FROM '.$this->table;
		}
        if($this->join) {
            $sql .= '  '.$this->join;

        }
		if($this->where){
			$sql .= ' WHERE '.$this->where;
		}
		if ($this->group) {
			$sql .= ' GROUP BY ' . $this->group;
		}
		if($this->order){
			$sql .= ' ORDER BY '.$this->order;
		}
		if($this->limit){
			$sql .= ' LIMIT '.$this->limit;
		}
		$this->clear_data();
		//error_log($sql);
		$this->last_sql = $sql;
		$result = @mysqli_query($this->conn,$sql);
		return $result;
	}
	/**
	 * 清空使用到的所有资源，以便下次使用
	 *
	 */
	function clear_data(){
		$this->field		 = '';
		$this->where		 = '';
		$this->order		 = '';
        $this->join          = '';
		$this->limit		 = '';
		$this->data  		 = '';
	}
	/**
	 * 从结果集中取得一行作为关联数组/数字索引数组
	 *
	 */
	function fetch_array($query,$type=MYSQL_ASSOC){	
		if($query && mysqli_num_rows($query) > 0){
			return mysqli_fetch_array($query, $type);
		}else{
			return false;
		}
	}
	
	/**
	 * 获取mysql错误
	 */
	function geterror() {
		return mysql_error();
	}

    /**
	 * 获取mysql错误编码
	 */
	function geterrno() {
		return mysql_errno();
	}
	
	/**
	 * 取得数据库版本信息
	 */
	function getMysqlVersion() {
		return mysqli_get_server_info($this->conn);
		//return mysql_get_server_info();
	}
}
?>