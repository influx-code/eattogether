<?php

namespace Controller;


use Common\BaseController;
use Common\Constants;
use Model\Users;
use Model\Invites;
use Model\Dinings;
use Model\DiningTables;

/**
 * 约饭信息&操作
 */
class DiningController extends BaseController
{

	const SMS_QUEUE = 'SMS_QUEUE';

	private static $statusList = [
		Constants::INVITE_STATUS_WRITING,
		Constants::INVITE_STATUS_YES,
		Constants::INVITE_STATUS_SENDED,
	];

	/**
	 * 提交约饭申请
	 * @method POST
	 * @param  string 	$uid
	 * @param  int 		$pay_mode
	 * @param  int 		$number_limit
	 * @param  array    $targets
	 * @return array
	 */
	public function applyAction()
	{
		$fail = ['result' => -1, 'msg' => '发起约饭失败'];
		$success = ['result' => 0, 'msg' => '发起成功，请等待用户确认'];

		$data = $this->reqeuest->getPost();
		// 判断参数合法性
		$require = ['uid', 'pay_mode', 'number_limit', 'targets'];
		foreach ($require as $item) {
			if (!array_key_exists($item, $data)) {
				$fail['msg'] = '缺少参数';
				$this->output($fail);
			}
			if ($item == 'targets' && count($data['targets'])) {
				$fail['msg'] = '请至少选择一位邀请人';
				$this->output($fail);
			}
		}
		if ($data['pay_mode'] != Constants::PAY_MODE_AA && $data['pay_mode'] != Constants::PAY_MODE_TREAT) {
			$fail['msg'] = '非法支付方式';
			$this->output($fail);
		}

		$newTable = new DiningTables();
		$newInvite = new Invites();

		$diningData = [
			'user_id' => $data['uid'],
			'pay_mode' => $data['pay_mode'],
			'number_limit' => $data['number_limit'],
			'number_ready' => 0,
			'created' => time(),
			'updated' => time()
		];
		$result = $newTable->save($diningData, array_keys($diningData));
		if (!$result) {
			$this->output($fail);
		}
		$diningTableId = $newTable->dining_table_id;
		$flag = false;

		// 统计需要随机的个数
		$inviteUids = $data['targets'];
		$needRandom = array_count_values($data['targets']);
		$needRandom = $needRandom[0];
		if ($needRandom) {
			$userList = Users::find([
				'conditions' => 'id NOT IN ({exists:array})',
				'bind' => ['exists' => $data['targets']]
			])->toArray();
			$uids = array_column($userList, 'id');
			$randomList = Invites::findFirst([
				'conditions' => 'user_id IN ({uids:array}) AND status IN ({status:array})',
				'bind' => ['uids' => $uids,'status' => self::$statusList],
				'limit' => count($needRandom),
			]);
			$randomUids = [];
			if ($randomList->count()) {
				$randomList = $randomList->toArray();
				$randomUids = array_column($randomList, 'user_id');
			}

			// 合并需要邀请的uid
			$inviteUids = array_merge($inviteUids, $randomUids);
		}

		// 初始化插入数据
		$newInvite->dining_table_id = $diningTableId;
		$newInvite->type = 0;
		$newInvite->status = Constants::INVITE_STATUS_SENDED;
		$newInvite->created = time();
		$newInvite->updated = time();
		$pay_mode = $data['pay_mode'] == self::PAY_MODE_AA ? 'AA吃饭' : '我要吃饭';
		$currentHour = date('G');
		$type = $currentHour > 14 ? '午饭' : '晚饭';
		foreach ($inviteUids as $item) {
			if (!$item) {
				$newInvite->id = NULL;
				$newInvite->user_id = $item;
				$newInvite->save();

				// 推送队列
				$task = [
					'mail' => 'linsist@influx.io',
					'template_param' => [
						'path' => '',
						'name' => Users::findFirst($item)->username,
						'mode' => $pay_mode,
						'type' => $type
					],
				];
				$this->redis->lpush(self::SMS_QUEUE, json_encode($task));
			}
		}
		if ($flag) {
			$this->output($success);
		} else {
			$this->output($fail);
		}
	}

	/**
	 * 获取当前用户约饭详情
	 * @method GET
	 * @param  string $uid
	 * @return array
	 */
	public function infoAction($uid)
	{
		$fail = ['result' => -1, 'msg' => '未知错误'];
		$success = ['result' => 0, 'msg' => 'ok', 'dining_table' => [], 'dining_table_id' => 0];
		$result = Invites::findFirst([
			'conditions' => 'user_id = :uid: AND status IN ({status:array})',
			'bind' => ['uid' => $uid, 'status' => self::$statusList]
		]);

		if (!$result) {
			$fail['msg'] = '目前没有被约饭';
			$this->output($fail);
		} else {
			$tableInfo = Invites::find([
				'conditions' => 'dining_table_id = :table_id:',
				'bind' => ['table_id' => $result->dining_table_id]
			]);
			$diningTableInfo = [];
			if ($tableInfo->count()) {
				foreach ($tableInfo as $item) {
					$diningTableInfo[] = [
						'uid' => $item->user_id,
						'name' => Users::findFirst($item->user_id)->username,
						'status' => $item->status,
						'status_invite' => Constants::$statusMap[$item->status]
					];
				}
			}
			$success['dining_table'] = $diningTableInfo;
			$success['dining_table_id'] = $result->dining_table_id;

			$this->output($success);
		}
	}

	/**
	 * 约饭操作：接受/拒绝
	 * @param   string $uid
	 * @param   string $diningTableId
	 * @return  array
	 */
	public function dealAction($uid, $diningTableId, $status)
	{
        $invite_model = new Invites();
        $result = $invite_model->dealAction($uid,$diningTableId,$status);
        if($result){
            $res = array(
                'msg' => 'ok',
            );
        }else{
            $res = array(
                'msg' => '操作失败，请重试',
            );
        }
        $this->output($res);
	}
}