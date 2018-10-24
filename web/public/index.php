<?php

error_reporting(E_ALL & ~E_NOTICE);
/** Define absolute path constants */
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CACHE_PATH', BASE_PATH . '/cache');
define('CORE_PATH', BASE_PATH . '/core');
define('LIBRARY_PATH', BASE_PATH . '/libraries');

/** require core */
require_once CORE_PATH . "/Bootstrap.php";

try {
	$bootstrap = new \Core\Bootstrap();
	$bootstrap->run();
} catch (Exception $e) {
	echo $e->getMessage();
	echo $e->getTraceAsString();
}

