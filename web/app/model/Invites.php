<?php

namespace Model;

use Common\DbModel;

class Invites extends DbModel
{
    public function checkExpire($limit_time){
        $time = time();
        $sql = "update invites set `status`=5,`updated`=$time where created<=$limit_time and `status` not in (1,2)";
        $result = $this->getReadConnection()->query($sql);
        return $result;
    }

    /**
     * 修改状态
     * @param $uid
     * @param $diningTableId
     * @param $status
     * @return mixed
     */
    public function dealAction($uid, $diningTableId, $status){
        $condition = 'user_id = :id: and dining_table_id = :dining_table_id: and status <> 2';
        $query = [
            $condition,
            'bind' => ['user_id' => $uid,'dining_table_id' => $diningTableId],
        ];
        $invite = self::findFirst($query);
        $ret = $invite->toArray();
        if(empty($ret)){
            return FALSE;
        }
        $invite->status = $this->_exchangeStatus($status);
        return $invite->update();
    }

    public function getSource() {
        return 'invites';
    }

    /**
     * 状态映射
     * @param $status
     * @return int
     */
    private function _exchangeStatus($status){
        switch ($status){
            case 0:
                return 1;
            case 1:
                return 4;
        }
    }

}