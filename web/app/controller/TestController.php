<?php
namespace Controller;


use Common\BaseController;

class TestController extends BaseController
{
    public function test1Action()
    {
        $data = array('name'=>'stave');
        $this->output($data);
    }
}
