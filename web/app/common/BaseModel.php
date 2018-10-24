<?php
/**
 * Created by PhpStorm.
 * User: zhengzezhan
 * Date: 2018/7/5
 * Time: 下午7:29
 */

namespace Common;

class BaseModel
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

