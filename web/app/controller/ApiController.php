<?php
namespace Controller;


use Common\BaseController;
use Common\ApiRequestInfo;
use Business\ApiRouter;

class ApiController extends BaseController
{
    /**
     * API接口网关
     */
    public function gatewayAction()
    {
        $data = $this->request->getPost();

        if ($data['influx_error']) {
            $GLOBALS['debug'] = true;
            ini_set('opcache.enable', 0);
        }

        $requestInfo = new ApiRequestInfo();
        $requestInfo->init($data, $this->cookies, $this->session);

        $ret = ApiRouter::instance()->handleRequest($requestInfo);

        $this->output($ret);
    }

}
