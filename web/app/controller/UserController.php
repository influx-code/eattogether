<?php
/**
 * Created by PhpStorm.
 * User: liye
 * Date: 2018/10/24
 * Time: 下午1:18
 */
namespace Controller;

use Common\BaseController;
use Model\Users;

class UserController extends BaseController
{
    /**
     * 登录接口
     * @param $mobile
     */
    public function login($mobile){
        $user_model = new Users();
        $result = $user_model->login($mobile);
        if(empty($result)){
            $res = array(
                'msg' => '登录失败',
                'result' => '0'
            );
            $this->output($res);
        }else{
            $res = array(
                'msg' => '登录成功',
                'result' => '1',
                'uid' => $result['id']
            );
            $this->output($res);

        }

    }

    /**
     * 获取好友列表
     * @param $token
     * @return array
     */
    public function getFriendsList($token){
        //token解析,当前token就是uid

        $uid = $token;

        $user_model = new Users();
        $result = $user_model->checkExist($uid);
        if(!$result){
            return array(
                'msg' => '用户不存在',
            );
        }

        $users = $user_model->getUsersList($uid);
        if(empty($users)){
            return array(
                'msg' => '没有好友信息',
            );
        }else{
            $result = array();
            foreach ($users as $user){
                $info['uid'] = $user['id'];
                $info['name'] = $user['username'];
                $result[] = $info;
            }
            $res = array(
                'msg' => 'ok',
                'rowset' => $result
            );
            $this->output($res);
        }
    }
}