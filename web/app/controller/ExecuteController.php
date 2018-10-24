<?php
/**
 * Created by PhpStorm.
 * User: liye
 * Date: 2018/10/24
 * Time: 下午4:16
 */
namespace Controller;

use Common\BaseController;
use Model\Invites;

class ExecuteController extends BaseController
{
    public function checkInviteExpire(){
        $hour = intval(date('H'));
        if($hour > 22){
            $limit_time = time();
        }elseif($hour > 14 ){
            $limit_time = strtotime(date('Y-m-d').' 14:00:00');
        }else{
            $limit_time = strtotime(date('Y-m-d'));
        }

        $invite_model = new Invites();
        $invite_model->checkExpire($limit_time);
        echo '执行成功';
    }
}