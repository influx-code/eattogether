<?php

namespace Model;

use Common\DbModel;

class Users extends DbModel
{
    /**
     * 用户登录
     * @param $mobile
     * @return array
     */
    public function login($mobile){
        $condition = 'mobile = :mobile:';
        $query = [
            $condition,
            'bind' => ['mobile' => $mobile],
            'columns' => 'id,username,mobile',
        ];
        $result = self::findFirst($query);
        $ret = $result->toArray();
        return $ret;
    }

    /**
     * 检查用户是否存在
     * @param $uid
     * @return bool
     */
    public function checkExist($uid){
        $condition = 'id = :id:';
        $query = [
            $condition,
            'bind' => ['id' => $uid],
            'columns' => 'id,username,mobile',
        ];
        $result = self::findFirst($query);
        $ret = $result->toArray();
        if(empty($ret)){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    /**
     * 获取联系人姓名
     * @return mixed
     */
    public function getUsersList($uid){
        $condition = 'id <> :id:';
        $query = [
            $condition,
            'bind' => ['id' => $uid],
            'columns' => 'id,username',
        ];
        $result = self::find($query);
        $ret = $result->toArray();
        return $ret;
    }

    public function getSource() {
        return 'users';
    }
}