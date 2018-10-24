<?php
/**
 * 单例特性
 * 
 * 使用方法: 
 * class SomeClass {
 *     use \Common\instanceTrait;
 * }
 */

namespace Common;

trait instanceTrait {
    /** 静态变量保存全局实例 */
    private static $_instance = null;

    /**
     * 静态方法，单例统一访问入口
     * @return Business\Orders\OrdersManager
     */
    static public function instance() {
        if (is_null(self::$_instance) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}