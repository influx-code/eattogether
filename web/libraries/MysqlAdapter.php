<?php

namespace Library;

use Core\iService;
use \Phalcon\Db\Adapter\Pdo\Mysql;

class MysqlAdapter implements iService {

	private $_client = null;

    /**
     * @param array $config
     * @return mixed|null|Mysql
     */
	public function init($config) {
		if (!$this->_client) {
			$this->_client = new Mysql($config);
            $this->_client->connect();
		}
		return $this->_client;
	}
}