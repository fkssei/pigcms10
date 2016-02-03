<?php
class user_address_model extends base_model{
	/*查找一条记录*/
	public function find($session_id,$uid){
		if(!empty($uid)){
			$condition['uid'] = $uid;
		}else{
			$condition['session_id'] = $session_id;
		}
		$oneAddress = $this->db->where($condition)->order('`default` DESC,`address_id` ASC')->find(); 
		if(!empty($oneAddress)){
			import('area');
			$areaClass = new area();
			$oneAddress['province_txt'] = $areaClass->get_name($oneAddress['province']);
			$oneAddress['city_txt'] 	= $areaClass->get_name($oneAddress['city']);
			$oneAddress['area_txt'] 	= $areaClass->get_name($oneAddress['area']);
		}
		return $oneAddress;
	}
	/*查找一条记录*/
	public function getAdressById($session_id,$uid,$address_id){
		if(!empty($uid)){
			$condition['uid'] = $uid;
		}else{
			$condition['session_id'] = $session_id;
		}
		$condition['address_id'] = $address_id;
		$oneAddress = $this->db->where($condition)->find(); 
		if(!empty($oneAddress)){
			import('area');
			$areaClass = new area();
			$oneAddress['province_txt'] = $areaClass->get_name($oneAddress['province']);
			$oneAddress['city_txt'] 	= $areaClass->get_name($oneAddress['city']);
			$oneAddress['area_txt'] 	= $areaClass->get_name($oneAddress['area']);
		}
		return $oneAddress;
	}
	/*查找用户记录*/
	public function select($session_id,$uid){
		if(!empty($uid)){
			$condition['uid'] = $uid;
		}else{
			$condition['session_id'] = $session_id;
		}
		$address_list = $this->db->where($condition)->order('`default` DESC,`address_id` ASC')->select(); 
		if(!empty($address_list)){
			import('area');
			$areaClass = new area();
			foreach($address_list as &$value){
				$value['province_txt'] = $areaClass->get_name($value['province']);
				$value['city_txt'] 	= $areaClass->get_name($value['city']);
				$value['area_txt'] 	= $areaClass->get_name($value['area']);
			}	
		}
		return $address_list;
	}

    //
    public function getMyAddress($uid)
    {
        $addresses = $this->db->where(array('uid' => $uid))->select();
		if(!empty($addresses)){
			import('area');
			$areaClass = new area();
			foreach($addresses as &$value){
				$value['province_txt'] = $areaClass->get_name($value['province']);
				$value['city_txt'] 	= $areaClass->get_name($value['city']);
				$value['area_txt'] 	= $areaClass->get_name($value['area']);
			}	
		}
        return $addresses;
    }

    public function add($data)
    {
        return $this->db->data($data)->add();
    }

    public function getAddress($address_id)
    {
        $address = $this->db->where(array('address_id' => $address_id))->find();
        return $address;
    }

	// 设置默认收货地址
	public function canelDefaultAaddress($uid, $address_id) {
		$this->db->where(array('uid' => $uid))->data(array('default' => 0))->save();
		$this->db->where(array('uid' => $uid, 'address_id' => $address_id))->data(array('default' => 1))->save();
	}

	// 删除收货地址
	public function deleteAddress($condition) {
		// 为了防止全部删除
		if (empty($condition)) {
			return true;
		}

		$this->db->where($condition)->delete();
	}

	/*更改记录*/
	public function save_address($condition, $data){
		return array('err_code'=>0,'err_msg'=>$this->db->where($condition)->data($data)->save());
	}
}
?>