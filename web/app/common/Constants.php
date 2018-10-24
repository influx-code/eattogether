<?php

namespace Common;

class Constants
{
	/** AA吃饭 */
	const PAY_MODE_AA = 0;
	/** 我要请客吃饭 */
	const PAY_MODE_TREAT = 1;

	/** 接受邀请 */
	const INVITE_YES = 0;
	/** 拒绝邀请 */
	const INVITE_NO  = 1;

	/** 待邀请 */
	const INVITE_STATUS_WRITING = 0;
	/** 接受邀请 */
	const INVITE_STATUS_YES = 1;
	/** 已删除 */
	const INVITE_STATUS_DELETE = 2;
	/** 已发送邀请 */
	const INVITE_STATUS_SENDED = 3;
	/** 拒绝邀请 */
	const INVITE_STATUS_NO = 4;
	/** 已过期 */
	const INVITE_STATUS_OVERDUE = 5;


	public static $statusMap = [
		self::INVITE_STATUS_WRITING => '待邀请',
		self::INVITE_STATUS_YES => '接受邀请',
		self::INVITE_STATUS_DELETE => '已删除',
		self::INVITE_STATUS_SENDED => '已发送邀请',
		self::INVITE_STATUS_NO => '拒绝邀请',
		self::INVITE_STATUS_OVERDUE => '已过期',
	];
}