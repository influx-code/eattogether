<?php
/**
 * 业务基类
 *
 * 目前只提供Di
 */

namespace Common;

class BaseBusiness
{
	private $_di;

	public function __construct() {
		$di = new \Phalcon\Di();

		$this->_di = $di->getDefault();
	}

	public function __get($name) {
		return $this->_di->get($name);
	}



}
