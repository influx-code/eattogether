<?php
/**
 * 配置加载类
 * 避免业务中通过路径进行配置文件的加载
 */

namespace Core;

use Phalcon\Config\Adapter\Php as ConfigPhp;
use Exception;

class ConfigLoader {
	private $_env = NULL;

	public function __construct($env) {
		/** 设置环境变量 */
		if (isset($env) && !empty($env)) {
			$this->_env = $env;
		}
	}

	public function get($configName) {
		$ext = pathinfo($configName, PATHINFO_EXTENSION);
		$configName .= ($ext == '') ? '.php' : '';
		/** load the env config first */
		if ($this->_env) {
			/** check if the env config file exists */
			$configPath = APP_PATH . '/config/' . $this->_env . "/{$configName}";
		}

		/** load default config if env config not exists */
		if (!isset($configPath) || file_exists($configPath) !== TRUE) {
			/** check if the default config file exists */
			$configPath = APP_PATH . "/config/{$configName}";

			if (file_exists($configPath) !== TRUE) {
	            throw new Exception('Configuration file not found');
	        }
		}

        $config = new ConfigPhp($configPath);

		return $config;
	}
}