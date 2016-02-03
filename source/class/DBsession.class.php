<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class Session
{
	const db_host = '192.168.199.162';
	const db_user = 'mdy';
	const db_pwd = '123456';
	const db_name = 'weidian';
	const db_table = 'pigcms_session';

	private $db_handle;
	private $lifeTime;

	public function open($savePath, $sessName)
	{
		import('source.class.checkFunc');
		$checkFunc = new checkFunc();

		if (!function_exists('fdsrejsie3qklwewerzdagf4ds')) {
			exit('error-4');
		}

		$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$this->lifeTime = get_cfg_var('session.gc_maxlifetime');
		$db_handle = @mysql_connect(self::db_host, self::db_user, self::db_pwd);
		$dbSel = @mysql_select_db(self::db_name, $db_handle);
		if (!$db_handle || !$dbSel) {
			return false;
		}

		$this->db_handle = $db_handle;
		return true;
	}

	public function close()
	{
		$this->gc(ini_get('session.gc_maxlifetime'));
		return @mysql_close($this->db_handle);
	}

	public function read($sessID)
	{
		$res = @mysql_query('SELECT session_data AS d FROM ' . self::db_table . '' . "\r\n" . '                WHERE session_id = \'' . $sessID . '\'    ' . "\r\n" . '                AND session_expires > ' . time(), $this->db_handle);

		if ($row = @mysql_fetch_assoc($res)) {
			return $row['d'];
		}

		return '';
	}

	public function write($sessID, $sessData)
	{
		$newExp = time() + $this->lifeTime;
		$res = @mysql_query('SELECT * FROM ' . self::db_table . ' WHERE session_id = \'' . $sessID . '\'', $this->db_handle);

		if (@mysql_num_rows($res)) {
			@mysql_query('UPDATE ' . self::db_table . '' . "\r\n" . '                    SET session_expires = \'' . $newExp . '\',    ' . "\r\n" . '                    session_data = \'' . $sessData . '\'    ' . "\r\n" . '                    WHERE session_id = \'' . $sessID . '\'', $this->db_handle);

			if (@mysql_affected_rows($this->db_handle)) {
				return true;
			}
		}
		else {
			@mysql_query('INSERT INTO ' . self::db_table . ' (' . "\r\n" . '                    session_id,    ' . "\r\n" . '                    session_expires,    ' . "\r\n" . '                    session_data)    ' . "\r\n" . '                    VALUES(    ' . "\r\n" . '                        \'' . $sessID . '\',    ' . "\r\n" . '                        \'' . $newExp . '\',    ' . "\r\n" . '                        \'' . $sessData . '\')', $this->db_handle);

			if (@mysql_affected_rows($this->db_handle)) {
				return true;
			}
		}

		return false;
	}

	public function destroy($sessID)
	{
		@mysql_query('DELETE FROM ' . self::db_table . ' WHERE session_id = \'' . $sessID . '\'', $this->db_handle);

		if (@mysql_affected_rows($this->db_handle)) {
			return true;
		}

		return false;
	}

	public function gc($sessMaxLifeTime)
	{
		@mysql_query('DELETE FROM ' . self::db_table . ' WHERE session_expires < ' . time(), $this->db_handle);
		return @mysql_affected_rows($this->db_handle);
	}
}


?>
