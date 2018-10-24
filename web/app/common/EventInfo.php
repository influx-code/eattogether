<?php

namespace Common;

class EventInfo
{
    public $router;//order.submit 前端提交的方法，用于路由

    public $openid;
    public $unionid;
    public $sid;
    public $mtag;
    public $source;
    public $trick;
    public $wechat_account;
    public $payment_account;
    public $payment_openid;
    public $active_accounts;
    public $active_wechat_account;
    public $active_wechat_openid;
    public $para;

    public function init($requestInfo)
    {

    }

}
