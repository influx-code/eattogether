<?php

namespace Common;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{

    protected function output(&$data) {
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($data);
        }
        exit;
        return null;
    }

}
