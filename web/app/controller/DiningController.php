<?php

namespace Controller;


use Common\BaseController;
use Model\Users;
use Model\Invites;
use Model\Dinings;
use Model\DiningTables;


/**
 * 约饭信息&操作
 */
class DiningController extends BaseController
{
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

	}

	/**
	 * 获取当前约饭详情
	 * @method GET
	 * @param  string $uid
	 * @return array
	 */
	public function infoAction($uid)
	{

	}

	/**
	 * 约饭操作：接受/拒绝
	 * @param   string $uid
	 * @param   string $diningTableId
	 * @return  array
	 */
	public function dealAction($uid, $diningTableId)
	{

	}
}