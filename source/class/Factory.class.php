<?php
abstract class Factory {
	static protected $_instances = null;
	// Single
	static protected function single($class = null) {
		if (is_array($class)) {
			foreach ($class as $cls) {
				if (!isset(self::$_instances[$cls])) {
					self::$_instances[$cls] = new $cls;
				}
				$instances[$cls] = self::$_instances[$cls];
			}
			return $instances;
		} else {
			if (!isset(self::$_instances[$class])) {
				self::$_instances[$class] = new $class;
			}
			return self::$_instances[$class];
		}
	}
	static public function mergeParams($params, $selfParams, $fields) {
		foreach ($fields as $field) {
			$params[$field] = isset($params[$field]) ? $params[$field] : '';
			$newParams[$field] = empty($selfParams[$field]) ? $params[$field] : $selfParams[$field];
		}
		return $newParams;
	}
	static public function method($params, $class = null) {
		$instances = self::single($class);
		$instances = is_array($instances) ? $instances : array($instances);
		foreach ($instances as $key => $instance) {
			$instance->setParams($params);
			$data[$key] = $instance->method();
		}
		return is_array($class) ? $data : $data[$key];
	}
}