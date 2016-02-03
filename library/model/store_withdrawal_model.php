<?php
//狗扑源码社区 www.gope.cn
class store_withdrawal_model extends base_model
{
	public function add($data)
	{
		return $this->db->data($data)->add();
	}

	public function getWithdrawalCount($where)
	{
		$sql = 'SELECT COUNT(sw.pigcms_id) AS count FROM ' . option('system.DB_PREFIX') . 'store_withdrawal sw, ' . option('system.DB_PREFIX') . 'bank b, ' . option('system.DB_PREFIX') . 'user u, ' . option('system.DB_PREFIX') . 'store s WHERE sw.bank_id = b.bank_id AND sw.uid = u.uid AND sw.store_id = s.store_id';

		if ($where) {
			foreach ($where as $key => $value) {
				if ($key == '_string') {
					$sql .= ' AND ' . $value;
				}
				else {
					$sql .= ' AND ' . $key . ' = \'' . $value . '\'';
				}
			}
		}

		$result = $this->db->query($sql);
		return !empty($result[0]['count']) ? $result[0]['count'] : 0;
	}

	public function getWithdrawals($where, $offset, $limit)
	{
		$sql = 'SELECT sw.*,b.name AS bank,u.nickname,s.tel,s.name AS store FROM ' . option('system.DB_PREFIX') . 'store_withdrawal sw, ' . option('system.DB_PREFIX') . 'bank b, ' . option('system.DB_PREFIX') . 'user u, ' . option('system.DB_PREFIX') . 'store s WHERE sw.bank_id = b.bank_id AND sw.uid = u.uid AND sw.store_id = s.store_id';

		if ($where) {
			foreach ($where as $key => $value) {
				if ($key == '_string') {
					$sql .= ' AND ' . $value;
				}
				else {
					$sql .= ' AND ' . $key . ' = \'' . $value . '\'';
				}
			}
		}

		$sql .= ' ORDER BY sw.pigcms_id DESC LIMIT ' . $offset . ', ' . $limit;
		$withdrawals = $this->db->query($sql);
		return $withdrawals;
	}

	public function getWithdrawalStatus($key = NULL)
	{
		$status = array(1 => '申请中', 2 => '银行处理中', 3 => '提现成功', 4 => '提现失败');

		if (is_null($key)) {
			return $status;
		}
		else {
			return $status[$key];
		}
	}
}

?>
