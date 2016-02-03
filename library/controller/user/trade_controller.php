<?php

/*
 * 物流相关
 */

class trade_controller extends base_controller{
	public function index(){
		$this->display();
	}
	public function _empty(){
		include display();
	}
	public function delivery(){
		$this->display();
	}
	public function delivery_load(){
		if(empty($_POST['page'])) pigcms_tips('非法访问！','none');
		if($_POST['page'] == 'delivery_list'){
			$postage = M('Postage_template')->get_tpl_list($this->store_session['store_id']);
			$this->assign('postage_list',$postage);
		}else if($_POST['page'] == 'delivery_edit'){
			$tpl_id = !empty($_POST['tpl_id']) ? $_POST['tpl_id'] : pigcms_tips('请携带运费模板ID');
			$postage = M('Postage_template')->get_tpl($tpl_id,$this->store_session['store_id']);
			if(empty($postage)) pigcms_tips('该运费模板不存在');
			$this->assign('postage',$postage);
		}else if($_POST['page'] == 'setting_content'){
			$setting = M('Trade_setting')->get_setting($this->store_session['store_id']);
			$this->assign('setting',$setting);
		}else if($_POST['page'] == 'selffetch_content'){
			//$selffetch = M('Trade_selffetch')->get_list($this->store_session['store_id']);
			//$this->assign('selffetch',$selffetch);
			$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
			$this->assign('store_physical',$store_physical);
			//买家上门自提状态
			$store = M('Store')->getStore($this->store_session['store_id']);
			$selfFetchStatus = $store['buyer_selffetch'];
			$this->assign('selfFetchStatus', $selfFetchStatus);
			$this->assign('store', $store);
		} else if ($_POST['page'] == 'pay_agent_content') {

			//找人代付
			$store = M('Store');
			$payAgentStatus = $store->getPayAgentStatus($this->store_session['store_id']);
			$this->assign('payAgentStatus', $payAgentStatus);
		} else if ($_POST['page'] == 'income_content') { //我的收入
			$this->_income_content();
		} else if ($_POST['page'] == 'waitsettled_content') { //待结算
			$this->_waitsettled_content();
		} else if ($_POST['page'] == 'inoutdetail_content') { //收支明细
			$this->_inoutdetail_content();
		} else if ($_POST['page'] == 'withdraw_content') { //提现记录
			$this->_withdraw_content();
		} else if ($_POST['page'] == 'settingwithdrawal_content') { //设置提现账号
			$this->_settingwithdrawal_content();
		} else if ($_POST['page'] == 'editwithdrawal_content') {
			$this->_editwithdrawal_content();
		} else if ($_POST['page'] == 'applywithdrawal_content') { //申请提现
			$this->_applywithdrawal_content();
		} else if ($_POST['page'] == 'trade_content') { //交易记录
			$this->_trade_content();
		}

		$this->display($_POST['page']);
	}
	public function delivery_modify(){
		if(IS_POST){
			$data_postage_template['store_id'] = $this->store_session['store_id'];
			$data_postage_template['tpl_name'] = !empty($_POST['name']) ? $_POST['name'] : json_return(4091,'模板名称不能为空');
			$area = !empty($_POST['area']) ? $_POST['area'] : json_return(4092,'至少要有一个配送区域');
			$area_arr = explode(';',$area);
			foreach($area_arr as $key=>$value){
				if($value != ''){
					$area_content_arr = explode(',',$value);
					$province = rtrim($area_content_arr[0],'&');
					$new_area_arr[] = $province.','.$area_content_arr[1].','.$area_content_arr[2].','.$area_content_arr[3].','.$area_content_arr[4];
				}
			}
			$data_postage_template['tpl_area'] = !empty($new_area_arr) ? implode(';',$new_area_arr) : json_return(4093,'配送区域解析失败');
			$data_postage_template['last_time'] = $_SERVER['REQUEST_TIME'];
			$database_postage_template = D('Postage_template');
			if($database_postage_template->data($data_postage_template)->add()){
				json_return(0,'添加成功');
			}else{
				json_return(4094,'添加失败！请重试。');
			}
		}else{
			json_return(999,'非法访问！');
		}
	}
	public function delivery_copy(){
		if(IS_POST){
			$condition_postage_template['tpl_id'] = $_POST['tpl_id'];
			$condition_postage_template['store_id'] = $this->store_session['store_id'];
			$database_postage_template = D('Postage_template');
			$postage_template = $database_postage_template->where($condition_postage_template)->find();
			if(!empty($postage_template)){
				$postage_template['copy_id'] = $postage_template['tpl_id'];
				$postage_template['last_time'] = $_SERVER['REQUEST_TIME'];
				unset($postage_template['tpl_id']);
				if($database_postage_template->data($postage_template)->add()){
					json_return(0,'复制成功');
				}else{
					json_return(4097,'复制失败，请重试');
				}
			}else{
				json_return(4096,'该运费模板不存在');
			}
		}else{
			json_return(999,'非法访问！');
		}
	}
	public function delivery_amend(){
		if(IS_POST){
			$condition_postage_template['tpl_id'] = $_POST['tpl_id'];
			$condition_postage_template['store_id'] = $this->store_session['store_id'];
			$data_postage_template['tpl_name'] = !empty($_POST['name']) ? $_POST['name'] : json_return(4091,'模板名称不能为空');
			$area = !empty($_POST['area']) ? $_POST['area'] : json_return(4092,'至少要有一个配送区域');
			$area_arr = explode(';',$area);
			foreach($area_arr as $key=>$value){
				if($value != ''){
					$area_content_arr = explode(',',$value);
					$province = rtrim($area_content_arr[0],'&');
					if(!empty($area_content_arr[2]) && $area_content_arr[2] != '0.00' && empty($area_content_arr[1])){
						json_return(4095,'您设置了首重运费，首重数不能填 0');
					}
					if(!empty($area_content_arr[4]) && $area_content_arr[2] != '0.00' && empty($area_content_arr[3])){
						json_return(4095,'您设置了续重运费，续重数不能填 0');
					}
					$new_area_arr[] = $province.','.$area_content_arr[1].','.$area_content_arr[2].','.$area_content_arr[3].','.$area_content_arr[4];
				}
			}
			$data_postage_template['tpl_area'] = !empty($new_area_arr) ? implode(';',$new_area_arr) : json_return(4093,'配送区域解析失败');
			$data_postage_template['last_time'] = $_SERVER['REQUEST_TIME'];
			$data_postage_template['copy_id'] = '0';
			$database_postage_template = D('Postage_template');
			if($database_postage_template->where($condition_postage_template)->data($data_postage_template)->save()){
				json_return(0,'修改成功');
			}else{
				json_return(4094,'修改失败！请重试。');
			}
		}else{
			json_return(999,'非法访问！');
		}
	}
	public function delivery_delete(){
		if(IS_POST){
			$condition_postage_template['tpl_id'] = $_POST['tpl_id'];
			$condition_postage_template['store_id'] = $this->store_session['store_id'];
			$database_postage_template = D('Postage_template');
			if($database_postage_template->where($condition_postage_template)->delete()){
				json_return(0,'删除成功');
			}else{
				json_return(4095,'删除失败！请重试。');
			}
		}else{
			json_return(999,'非法访问！');
		}
	}
	
	/*交易物流通知*/
	public function setting(){
		$this->display();
	}
	public function setting_amend(){
		$condition_trade_setting['store_id'] = $this->store_session['store_id'];
		$data_trade_setting['pay_cancel_time'] = intval($_POST['pay_cancel_time']);
		$data_trade_setting['pay_alert_time'] = intval($_POST['pay_alert_time']);
		$data_trade_setting['sucess_notice'] = intval($_POST['sucess_notice']);
		$data_trade_setting['send_notice'] = intval($_POST['send_notice']);
		//$data_trade_setting['complain_notice'] = intval($_POST['complain_notice']);  //维权通知必须开启
		$data_trade_setting['last_time'] = $_SERVER['REQUEST_TIME'];
		if(D('Trade_setting')->where($condition_trade_setting)->data($data_trade_setting)->save()){
			json_return(0,'保存成功');
		}else{
			json_return(4098,'保存失败！请重试。');
		}
	}
	
	/*买家上门自提*/
	public function selffetch(){
		$this->display();
	}
	public function selffetch_modify(){
		$data_trade_selffetch['store_id'] = $this->store_session['store_id'];
		$data_trade_selffetch['name'] = $_POST['name'];
		$data_trade_selffetch['province'] = intval($_POST['province']);
		$data_trade_selffetch['city'] = intval($_POST['city']);
		$data_trade_selffetch['county'] = intval($_POST['county']);
		$data_trade_selffetch['address'] = $_POST['address_detail'];
		$data_trade_selffetch['tel'] = $_POST['tel'];
		$data_trade_selffetch['last_time'] = $_SERVER['REQUEST_TIME'];
		if(D('Trade_selffetch')->data($data_trade_selffetch)->add()){
			json_return(0,'保存成功');
		}else{
			json_return(4099,'保存失败！请重试');
		}
	}
	public function selffetch_get(){
		$selffetch = M('Trade_selffetch')->get_selffetch($_POST['pigcms_id'],$this->store_session['store_id']);
		if($selffetch){
			json_return(0,$selffetch);
		}else{
			json_return(4099,'查询失败！请重试');
		}
	}
	public function selffetch_amend(){
		$condition_trade_selffetch['pigcms_id'] = $_POST['pigcms_id'];
		$condition_trade_selffetch['store_id'] = $this->store_session['store_id'];
		$data_trade_selffetch['name'] = $_POST['name'];
		$data_trade_selffetch['province'] = intval($_POST['province']);
		$data_trade_selffetch['city'] = intval($_POST['city']);
		$data_trade_selffetch['county'] = intval($_POST['county']);
		$data_trade_selffetch['address'] = $_POST['address_detail'];
		$data_trade_selffetch['tel'] = $_POST['tel'];
		$data_trade_selffetch['last_time'] = $_SERVER['REQUEST_TIME'];
		if(D('Trade_selffetch')->where($condition_trade_selffetch)->data($data_trade_selffetch)->save()){
			json_return(0,'保存成功');
		}else{
			json_return(4099,'保存失败！请重试');
		}
	}

	public function selffetch_status()
	{
		$status = intval(trim($_POST['status']));
		$store_id = $this->store_session['store_id'];

		$store = M('Store');
		$result = $store->setSelfFetchStatus($status, $store_id);
		if ($result) {
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}

	//自提点删除
	public function selffetch_delete()
	{
		$pigcms_id = intval(trim($_POST['pigcms_id']));
		$store_id = $this->store_session['store_id'];
		if (D('Trade_selffetch')->where(array('pigcms_id' => $pigcms_id, 'store_id' => $store_id))->delete()) {
			json_return(0, '删除成功！');
		} else {
			json_return(1001, '删除失败，请重试！');
		}
	}
	
	/**
	 * 货到付款
	 */
	public function offline_payment(){
		$this->display();
	}
	
	public function offline_payment_load() {
		if(empty($_POST['page'])) pigcms_tips('非法访问！','none');
		if($_POST['page'] == 'offline_payment_content'){
			$store = M('Store')->getStore($this->store_session['store_id']);
			$this->assign('store',$store);
		}
		
		$this->display($_POST['page']);
	}
	
	public function offline_payment_status() {
		$status = intval(trim($_POST['status']));
		$store_id = $this->store_session['store_id'];

		$result = D('Store')->where(array('store_id' => $store_id))->data(array('offline_payment' => $status))->save();
		if ($result) {
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}
	
	/**
	 * 找人代付
	 */
	public function pay_agent()
	{
		$this->display();
	}
	
	/**
	 * 找人代付状态
	 */
	public function pay_agent_status()
	{
		$status = intval(trim($_POST['status']));
		$store_id = $this->store_session['store_id'];

		$store = M('Store');
		$result = $store->setPayAgentStatus($status, $store_id);
		if ($result) {
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}

	/**
	 * 找人代付发起人
	 */
	public function pay_agent_content_buyer()
	{
		$help = M('Store_pay_agent');
		$helps = $help->getBuyerHelps($this->store_session['store_id']);

		$this->assign('helps', $helps);
		$this->display();
	}

	/**
	 * 找人代付代付人
	 */
	public function pay_agent_content_payer()
	{
		$comment = M('Store_pay_agent');
		$comments = $comment->getPayerComments($this->store_session['store_id']);

		$this->assign('comments', $comments);
		$this->display();
	}

	/**
	 * 找人代付-发起人求助/代付人留言添加
	 */
	public function pay_agent_content_add()
	{
		$pay_agent = M('Store_pay_agent');

		$data = array();
		$data['store_id'] = $this->store_session['store_id'];
		$data['type']	 = intval($_POST['type']);
		$data['nickname'] = trim($_POST['nickname']);
		$data['content']  = trim($_POST['content']);

		if ($pay_agent->add($data))
		{
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}

	/**
	 * 找人代付-发起人求助/代付人留言修改
	 */
	public function pay_agent_content_edit()
	{
		$pay_agent = M('Store_pay_agent');

		$where = array();
		$data = array();
		$where['agent_id'] = intval(trim($_GET['agent_id']));
		$where['store_id'] = $this->store_session['store_id'];
		$data['type']	 = intval($_POST['type']);
		$data['nickname'] = trim($_POST['nickname']);
		$data['content']  = trim($_POST['content']);

		if ($pay_agent->edit($data, $where))
		{
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}
	/**
	 * 找人代付-发起人求助/代付人留言删除
	 */
	public function pay_agent_content_del()
	{
		$pay_agent = M('Store_pay_agent');

		$where = array();
		$where['agent_id'] = intval(trim($_GET['agent_id']));
		$where['store_id'] = $this->store_session['store_id'];

		if ($pay_agent->del($where))
		{
			json_return(0, '删除成功！');
		} else {
			json_return(4099, '删除失败，请重试！');
		}
	}

	/**
	 * 收入提现
	 */
	public function income()
	{

		$this->display();
	}

	private function _income_content()
	{
		$store = M('Store');
		$financial_record = M('Financial_record');

		$store = $store->getStore($this->store_session['store_id']);

		//七天收入
		$start_day = date("Y-m-d",strtotime('-7 day'));
		$end_day = date('Y-m-d', strtotime('-1 day'));
		$start_time = strtotime($start_day . ' 00:00:00');
		$end_time = strtotime($end_day . ' 23:59:59');
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		$where['type'] = array('in', array(1,5));
		$where['_string'] = " add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
		$day_7_income = $financial_record->getTotal($where);

		if (!empty($store['bank_id']) && !empty($store['bank_card'])) {
			$this->assign('bind_bank_card', true);
		} else {
			$this->assign('bind_bank_card', false);
		}

		$this->assign('day_7_income', number_format($day_7_income, 2, '.', ''));
		$this->assign('store', $store);
	}

	//待结算
	private function _waitsettled_content()
	{

	}

	//收支明细
	private function _inoutdetail_content()
	{
		$order = M('Order');
		$financial_record = M('Financial_record');

		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		if (!empty($_POST['order_no'])) {
			$where['order_no'] = trim($_POST['order_no']);
		}
		if (!empty($_POST['type'])) {
			$where['type'] = trim($_POST['type']);
		}
		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string'] = "add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		} else if (!empty($_POST['start_time'])) {
			$where['add_time'] = array('<=', strtotime(trim($_POST['start_time'])));
		} else if (!empty($_POST['stop_time'])) {
			$where['add_time'] = array('>=', strtotime(trim($_POST['stop_time'])));
		}
		$record_total = $financial_record->getRecordCount($where);
		import('source.class.user_page');
		$page = new Page($record_total, 20);
		$records = $financial_record->getRecords($where, $page->firstRow, $page->listRows);

		//订单类型
		$record_types = $financial_record->getRecordTypes();
		//支付方式
		$payment_methods = $order->getPaymentMethod();

		$this->assign('records', $records);
		$this->assign('page', $page->show());
		$this->assign('record_types', $record_types);
		$this->assign('payment_methods', $payment_methods);
	}

	//
	public function settingwithdrawal()
	{
		$store = M('Store');

		if (IS_POST) {
			/*if (empty($_POST['verify_code']) || empty($_POST['tel']) || empty($_SESSION['captcha'][$_POST['tel']]) || $_SESSION['captcha'][$_POST['tel']] != md5(trim($_POST['verify_code']))) {
				json_return(1000, '短信验证码错误');
			}*/

			$data = array();
			$data['withdrawal_type'] = isset($_POST['withdrawal_type']) ? intval(trim($_POST['withdrawal_type'])) : 0;
			$data['bank_id'] = isset($_POST['bank_id']) ? intval(trim($_POST['bank_id'])) : 0;
			$data['opening_bank'] = isset($_POST['opening_bank']) ? trim($_POST['opening_bank']) : '';
			$data['bank_card'] = isset($_POST['bank_card']) ? trim($_POST['bank_card']) : '';
			$data['bank_card_user'] = isset($_POST['bank_card_user']) ? trim($_POST['bank_card_user']) : '';
			$data['last_edit_time'] = time();
			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			if ($store->settingWithdrawal($where, $data)) {
				unset($_SESSION['captcha'][$_POST['tel']]);
				json_return(0, '设置成功');
			} else {
				json_return(1001, '设置失败');
			}
		}
	}

	//设置提现账号
	private function _settingwithdrawal_content()
	{
		$bank = M('Bank');
		$banks = $bank->getEnableBanks();

		$this->assign('store', $this->store_session);
		$this->assign('banks', $banks);
	}

	//修改提现账号
	private function _editwithdrawal_content()
	{
		$bank = M('Bank');
		$store = M('Store');

		$banks = $bank->getEnableBanks();
		$store = $store->getStore($this->store_session['store_id']);

		$this->assign('param', !empty($_POST['param']) ? $_POST['param'] : '');
		$this->assign('store', $this->store_session);
		$this->assign('banks', $banks);
		$this->assign('withdrawal_type', $store['withdrawal_type']);
		$this->assign('bank_id', $store['bank_id']);
		$this->assign('opening_bank', $store['opening_bank']);
		$this->assign('bank_card', $store['bank_card']);
		$this->assign('bank_card_user', $store['bank_card_user']);
	}

	//添加提现申请
	public function applywithdrawal()
	{
		if (IS_POST) {
			$store = M('Store');
			$store_withdrawal = M('Store_withdrawal');

			$data = array();
			$data['trade_no']		= date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
			$data['uid']			 = $this->user_session['uid'];
			$data['store_id']		= $this->store_session['store_id'];
			$data['bank_id']		 = isset($_POST['bank_id']) ? intval(trim($_POST['bank_id'])) : 0;
			$data['opening_bank']	= isset($_POST['opening_bank']) ? trim($_POST['opening_bank']) : '';
			$data['bank_card']	   = isset($_POST['bank_card']) ? trim($_POST['bank_card']) : '';
			$data['bank_card_user']  = isset($_POST['bank_card_user']) ? trim($_POST['bank_card_user']) : '';
			$data['withdrawal_type'] = isset($_POST['withdrawal_type']) ? intval(trim($_POST['withdrawal_type'])) : 0;
			$data['amount']		  = isset($_POST['amount']) ? floatval(trim($_POST['amount'])) : 0;
			$data['status']		  = 1;
			$data['add_time']		= time();

			if ($store_withdrawal->add($data)) {
				$store->applywithdrawal($data['store_id'], $data['amount']);
				$store_info = $store->getStore($data['store_id']);
				if (!empty($store_info['drp_profit']) && $store_info['drp_profit'] > $store_info['drp_profit_withdrawal']) {
					if (($store_info['drp_profit_withdrawal'] + $data['amount']) <= $store_info['drp_profit']) {
						D('Store')->where(array('store_id' => $data['store_id']))->setInc('drp_profit_withdrawal', $data['amount']);
					} else {
						D('Store')->where(array('store_id' => $data['store_id']))->data(array('drp_profit_withdrawal' => $store_info['drp_profit']))->save();
					}
				}
				json_return(0, '提现申请成功');
			} else {
				json_return(1001, '提现申请失败');
			}
		}
	}

	//申请提现
	private function _applywithdrawal_content()
	{
		$bank = M('Bank');
		$store = M('Store');

		$store = $store->getStore($this->store_session['store_id']);
		$bank = $bank->getBank($store['bank_id']);

		$this->assign('balance', number_format($store['balance'], 2, '.', ''));
		$this->assign('bank', $bank['name']);
		$this->assign('store', $store);
	}

	//删除提现账号
	public function delwithdrawal()
	{
		$store = M('Store');

		if ($store->delwithdrawal($this->store_session['store_id'])) {
			json_return(0, '删除成功');
		} else {
			json_return(1001, '删除失败');
		}
	}

	//提现记录
	private function _withdraw_content()
	{
		$withdrawal = M('Store_withdrawal');

		$where = array();
		$where['sw.store_id'] = $this->store_session['store_id'];
		if (!empty($_POST['status'])) {
			$where['sw.status'] = $_POST['status'];
		}
		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string'] = "sw.add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND sw.add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		} else if (!empty($_POST['start_time'])) {
			$where['_string'] = "sw.add_time >= '" . strtotime(trim($_POST['start_time'])) . "'";
		} else if (!empty($_POST['stop_time'])) {
			$where['_string'] = "sw.add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		}
		$withdrawal_count = $withdrawal->getWithdrawalCount($where);
		import('source.class.user_page');
		$page = new Page($withdrawal_count, 20);
		$withdrawals = $withdrawal->getWithdrawals($where, $page->firstRow, $page->listRows);

		$status = $withdrawal->getWithdrawalStatus();

		$this->assign('withdrawals', $withdrawals);
		$this->assign('page', $page->show());
		$this->assign('status', $status);
	}

	//交易记录
	private function _trade_content()
	{
		$status = array(
			1 => '进行中',
			2 => '退款',
			3 => '成功',
			4 => '失败'
		);

		$status_text = array(
			1 => '进行中',
			2 => '退款',
			3 => '交易完成',
			4 => '交易失败'
		);
		$order = M('Order');
		$financial_record = M('Financial_record');

		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		if (!empty($_POST['order_no'])) {
			$where['order_no'] = trim($_POST['order_no']);
		}
		if (!empty($_POST['status'])) {
			$where['status'] = trim($_POST['status']);
		} else if (!empty($_POST['param'])) {
			$where['status'] = trim($_POST['param']);
		}
		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string'] = "add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		} else if (!empty($_POST['start_time'])) {
			$where['add_time'] = array('<=', strtotime(trim($_POST['start_time'])));
		} else if (!empty($_POST['stop_time'])) {
			$where['add_time'] = array('>=', strtotime(trim($_POST['stop_time'])));
		}
		$record_total = $financial_record->getRecordCount($where);
		import('source.class.user_page');
		$page = new Page($record_total, 15);
		$records = $financial_record->getRecords($where, $page->firstRow, $page->listRows);

		$this->assign('records', $records);
		$this->assign('page', $page->show());
		$this->assign('status', $status);
		$this->assign('status_text', $status_text);
	}
	
	public function buyer_selffetch_name() {
		$buyer_selffetch_name = $_POST['buyer_selffetch_name'];
		$result = D('Store')->where(array('store_id' => $this->store_session['store_id']))->data(array('buyer_selffetch_name' => $buyer_selffetch_name))->save();
		
		json_return(0, '操作成功');
	}
}
?>