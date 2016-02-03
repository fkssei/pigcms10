<?php
class OrderModel extends Model{

	//获取指定条件下的订单总数
    public function getOrderTotal($where) {
    
        $order_count = $this->where($where)->count('order_id');
        return $order_count;
    }
	
	
	

}

?>