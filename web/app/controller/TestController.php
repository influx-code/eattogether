<?php
namespace Controller;


use Common\BaseController;

class TestController extends BaseController
{
    public function test1Action()
    {
		$cacheKey = 'LINSIST_DEBUG';
		$this->redis->set($cacheKey, 'debug');
    }
}
