<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
defined('THINK_PATH') || exit();
class ViewModel extends Model
{
	protected $viewFields = array();

	protected function _checkTableInfo()
	{
	}

	public function getTableName()
	{
		if (empty($this->trueTableName)) {
			$tableName = '';

			foreach ($this->viewFields as $key => $view) {
				if (isset($view['_table'])) {
					$tableName .= $view['_table'];
				}
				else {
					$class = $key . 'Model';
					$Model = (class_exists($class) ? new $class() : M($key));
					$tableName .= $Model->getTableName();
				}

				$tableName .= (!empty($view['_as']) ? ' ' . $view['_as'] : ' ' . $key);
				$tableName .= (!empty($view['_on']) ? ' ON ' . $view['_on'] : '');
				$type = (!empty($view['_type']) ? $view['_type'] : '');
				$tableName .= ' ' . strtoupper($type) . ' JOIN ';
				$len = strlen($type . '_JOIN ');
			}

			$tableName = substr($tableName, 0, 0 - $len);
			$this->trueTableName = $tableName;
		}

		return $this->trueTableName;
	}

	protected function _options_filter(&$options)
	{
		if (isset($options['field'])) {
			$options['field'] = $this->checkFields($options['field']);
		}
		else {
			$options['field'] = $this->checkFields();
		}

		if (isset($options['group'])) {
			$options['group'] = $this->checkGroup($options['group']);
		}

		if (isset($options['where'])) {
			$options['where'] = $this->checkCondition($options['where']);
		}

		if (isset($options['order'])) {
			$options['order'] = $this->checkOrder($options['order']);
		}
	}

	private function _checkFields($name, $fields)
	{
		if (false !== $pos = array_search('*', $fields)) {
			$fields = array_merge($fields, M($name)->getDbFields());
			unset($fields[$pos]);
		}

		return $fields;
	}

	protected function checkCondition($where)
	{
		if (is_array($where)) {
			$view = array();

			foreach ($this->viewFields as $key => $val) {
				$k = (isset($val['_as']) ? $val['_as'] : $key);
				$val = $this->_checkFields($key, $val);

				foreach ($where as $name => $value) {
					if (false !== $field = array_search($name, $val, true)) {
						$_key = (is_numeric($field) ? $k . '.' . $name : $k . '.' . $field);
						$view[$_key] = $value;
						unset($where[$name]);
					}
				}
			}

			$where = array_merge($where, $view);
		}

		return $where;
	}

	protected function checkOrder($order = '')
	{
		if (is_string($order) && !empty($order)) {
			$orders = explode(',', $order);
			$_order = array();

			foreach ($orders as $order) {
				$array = explode(' ', $order);
				$field = $array[0];
				$sort = (isset($array[1]) ? $array[1] : 'ASC');

				foreach ($this->viewFields as $name => $val) {
					$k = (isset($val['_as']) ? $val['_as'] : $name);
					$val = $this->_checkFields($name, $val);

					if (false !== $_field = array_search($field, $val, true)) {
						$field = (is_numeric($_field) ? $k . '.' . $field : $k . '.' . $_field);
						break;
					}
				}

				$_order[] = $field . ' ' . $sort;
			}

			$order = implode(',', $_order);
		}

		return $order;
	}

	protected function checkGroup($group = '')
	{
		if (!empty($group)) {
			$groups = explode(',', $group);
			$_group = array();

			foreach ($groups as $field) {
				foreach ($this->viewFields as $name => $val) {
					$k = (isset($val['_as']) ? $val['_as'] : $name);
					$val = $this->_checkFields($name, $val);

					if (false !== $_field = array_search($field, $val, true)) {
						$field = (is_numeric($_field) ? $k . '.' . $field : $k . '.' . $_field);
						break;
					}
				}

				$_group[] = $field;
			}

			$group = implode(',', $_group);
		}

		return $group;
	}

	protected function checkFields($fields = '')
	{
		if (empty($fields) || ('*' == $fields)) {
			$fields = array();

			foreach ($this->viewFields as $name => $val) {
				$k = (isset($val['_as']) ? $val['_as'] : $name);
				$val = $this->_checkFields($name, $val);

				foreach ($val as $key => $field) {
					if (is_numeric($key)) {
						$fields[] = $k . '.' . $field . ' AS ' . $field;
					}
					else if ('_' != substr($key, 0, 1)) {
						if ((false !== strpos($key, '*')) || (false !== strpos($key, '(')) || (false !== strpos($key, '.'))) {
							$fields[] = $key . ' AS ' . $field;
						}
						else {
							$fields[] = $k . '.' . $key . ' AS ' . $field;
						}
					}
				}
			}

			$fields = implode(',', $fields);
		}
		else {
			if (!is_array($fields)) {
				$fields = explode(',', $fields);
			}

			$array = array();

			foreach ($fields as $key => $field) {
				if (strpos($field, '(') || strpos(strtolower($field), ' as ')) {
					$array[] = $field;
					unset($fields[$key]);
				}
			}

			foreach ($this->viewFields as $name => $val) {
				$k = (isset($val['_as']) ? $val['_as'] : $name);
				$val = $this->_checkFields($name, $val);

				foreach ($fields as $key => $field) {
					if (false !== $_field = array_search($field, $val, true)) {
						if (is_numeric($_field)) {
							$array[] = $k . '.' . $field . ' AS ' . $field;
						}
						else if ('_' != substr($_field, 0, 1)) {
							if ((false !== strpos($_field, '*')) || (false !== strpos($_field, '(')) || (false !== strpos($_field, '.'))) {
								$array[] = $_field . ' AS ' . $field;
							}
							else {
								$array[] = $k . '.' . $_field . ' AS ' . $field;
							}
						}
					}
				}
			}

			$fields = implode(',', $array);
		}

		return $fields;
	}
}

?>
