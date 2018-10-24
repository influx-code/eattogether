<?php

namespace Core;

/**
 * 类库的封装需实现该接口
 */
interface iService {

	/**
	 * 初始化服务类
	 * @param  array $config 配置信息
	 * @return mixed         通常情况下需返回当前实例($this)
	 */
	public function init($config);
}
