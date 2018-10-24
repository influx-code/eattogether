<?php
/**
 * API请求结构体
 */

namespace Common;

use ConfigPhp;

class ApiRequestInfo
{
    private $_di;

    /** 接口路由key，对应$_POST['method'] */
    public $router;

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
    public $api_type_appapi;
    public $param;

    public function __construct()
    {
        $di = new \Phalcon\Di();
        $this->_di = $di->getDefault();
    }

    /**
     * 初始化API请求结构体
     * @param  array  &$param   $_POST
     * @param  Phalcon\Http\Response\Cookies &$cookie  cookie信息
     * @param  Phalcon\Session\Adapter\Files &$session session信息
     * @return [type]           [description]
     */
    public function init(&$param, &$cookie ,&$session)
    {
        $param['api_type_appapi'] = 1;
        $param['wechat_account'] = $this->_getWechatAccount($param['wechat_app_code']);
        // 小程序未绑定开发平台的unionid 拿不到默认有unionid
        $param['unionid'] = $param['unionid'] ? $param['unionid'] : '';

        //小程序的支付账号
        $param['payment_account'] = $param['wechat_account'];
        $param['payment_openid'] = $param['openid'];

        // 小程序活动账号配置
        $param['active_accounts'] = array('ACCOUNT' => $param['wechat_account'], 'EXPIRE' => -1);
        $param['active_wechat_account'] = $param['wechat_account'];
        $param['active_wechat_openid'] = $param['openid'];


        if (isset($param['method'])) {
            $this->router = $param['method'];
        }

        $this->param = $param;


        return true;
    }

    /**
     * 返回结构体的成员变量
     * @return array 
     */
    public function toArray(){
        $result = [
            'router' => $this->router,
            'openid' => $this->openid,
            'unionid' => $this->unionid,
            'sid' => $this->sid,
            'mtag' => $this->mtag,
            'source' => $this->source,
            'trick' => $this->trick,
            'wechat_account' => $this->wechat_account,
            'payment_account' => $this->payment_account,
            'payment_openid' => $this->payment_openid,
            'active_accounts' => $this->active_accounts,
            'active_wechat_account' => $this->active_wechat_account,
            'active_wechat_openid' => $this->active_wechat_openid,
            'api_type_appapi' => $this->api_type_appapi,
            'param' => $this->param,
        ];

        return $result;
    }

    /**
     * 根据appcode获取account
     * @param  string $wechat_app_code appcode
     * @return string                  account
     */
    private function _getWechatAccount($wechat_app_code)
    {
        $wechatConfig = $this->_di->get('config')->get('wechat');
        
        return $wechatConfig['wechat_app_code_hash'][$wechat_app_code];
    }

}
