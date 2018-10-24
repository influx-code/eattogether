<?php

namespace Core;

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Exception;

require_once dirname(__DIR__) . "/libraries/helpers.php";
require_once "iService.php";
require_once "ConfigLoader.php";

class Bootstrap {

	private $_application;
	private $_loader;
    /**
     * @var FactoryDefault
     */
	private $_di;
	private $_config;

	private $_env;

	/**
	 * run the application
	 * @return NULL
	 */
	public function run() {

		$this->initEnvironment();
		$this->initLoader();
		$this->initDi();
		$this->initConfig();
		$this->initAutoload();
		$this->initService();
        $this->initApplication();
        $this->registerProviders();
		$this->_application->handle();
	}

	/**
	 * initializes the environment setting
	 * @return NULL
	 */
	private function initEnvironment() {
		$env = getenv('APP_ENV');

		$this->_env = ($env !== FALSE) ? $env : 'development';
	}

	/**
	 * initializes the Config container
	 * @return  NULL
	 */
	private function initConfig() {
		$configLoader = new ConfigLoader($this->_env);

        /** set config to Di container */
        $this->_di->set('config', $configLoader, TRUE);
        $this->_config = $configLoader;
	}

	/**
	 * initializes the Di container
	 * @return NULL
	 */
	private function initDi() {
		$this->_di = new FactoryDefault();
	}

	/**
	 * initializes the Loader container
	 * @return NULL
	 */
	private function initLoader() {
        $this->_loader = new Loader();
	}

	/**
	 * initializes autoload
	 * @return NULL
	 */
	private function initAutoload() {
		/** check if config->autoload exists */
		$config = $this->_config->get('config');
		if (!property_exists($config, 'autoload')) {
			throw new Exception('Configuration file requires "autoload" filed');
		}

        $autoload = $config->autoload->toArray();

        $this->_loader->registerDirs($autoload['dirs']);
        $this->_loader->registerNamespaces($autoload['namespaces']);

        $this->_loader->register();
	}

	/**
	 * initializes service by dependency injection
	 * @return NULL
	 */
	private function initService() {
		/** check if config->service exists */
		$config = $this->_config->get('config');
		if (!property_exists($config, 'service')) {
			throw new Exception('Configuration file requires "service" filed');
		}

        $services = $config->service->toArray();

        /** inject service into Di container */
        foreach ($services as $name => $options) {
        	$bootstarp = $this;
        	$shared = $options['shared'] ? : FALSE;

        	$this->_di->set($name, function() use ($bootstarp, $options) {
        		if (!class_exists($options['lib'])) {
        			throw new Exception('Class "' . $options['lib'] .'" is not found');
        		}

        		/** check if there is a specify config file */
        		$config = NULL;
        		if (!empty($options['config'])) {
					/** get config */
					$config = $bootstarp->_config->get($options['config'])->toArray();
        		}

        		/** check if the class implements with the interface iService */
        		$instance = new $options['lib']();
        		if (!$instance instanceof iService) {
        			throw new Exception('class ' . $options['lib'] . ' not implements with interface iService');
        		}

        		/** init service */
        		return $instance->init($config);
        	}, $shared);
        }
	}

    /**
     * Registers available services
     *
     * @return void
     */
	private function registerProviders()
    {
        $config = $this->_config->get('config');
        if (!empty($config->providers)) {
            $providers = $config->providers->toArray();
            foreach ($providers as $provider) {
                (new $provider())->register($this->_di);
            }
        }
    }

	/**
	 * initializes application 
	 * @return Micro
	 */
	private function initApplication() {
		$this->_application = new Micro($this->_di);
        $this->_di->setShared('application', $this->_application);
	}
}