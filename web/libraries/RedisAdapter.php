<?php

namespace Library;

use Core\iService;
use Redis;
use RedisException;
use Exception;

class RedisAdapter implements iService {

	public $_client;
	private $_prefix;

	/**
	 * 初始化服务，创建redis链接
	 * @param  array $config 配置信息
	 * @return RedisAdapter         
	 */
	public function init($config) {
		if (!$this->_client) {
			// host config
			if (empty($config['host'])) {
				throw new Exception("Failed to create redis connection. Invalid host string: {$config['host']}");
			}

			// default port config
			if (empty($config['port'])) {
				$config['port'] = 6379;
			}

			// prefix config
			if (!empty($config['prefix'])) {
				$this->_prefix = $config['prefix'];
			}

			$this->_client = new Redis();

			try {
				$re = $this->_client->connect($config['host'], $config['port']);

				if (!$re) {
					throw new Exception('Failed to connect redis server.');
				}

				if (!empty($config['password'])) {
					$auth = $this->_client->auth($config['password']);

					if (!$auth) {
						throw new Exception('Redis authorize failed.');
					}
				}

				$this->_client->setOption(Redis::OPT_PREFIX, $this->_prefix . ':');
			} catch (RedisException $e) {
				throw new Exception($e->getMessage());
			}
		}

		return $this;
	}

	/**
	 * 魔术方法实现redis方法调用
	 * @param  string $method    方法名
	 * @param  array  $arguments 参数
	 * @return mixed             
	 */
	function __call($method, $arguments) {
		return call_user_func_array([$this->_client, $method], $arguments);
	}

}