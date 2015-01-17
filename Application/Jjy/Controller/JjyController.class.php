<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Jjy\Controller;
use Common\Controller\CheckLoginController;

class JjyController extends CheckLoginController {

	protected function _initialize() {
		parent::_initialize();
		$this -> assignTitle("k2868.com");
		//当前一级导航激活menu
		if (I('get.activemenuid', 0) !== 0) {
			session('activemenuid', I('get.activemenuid'));
			session('activesubmenuid', 0);
		}
		//当前三级导航
		if (I('get.activesubmenuid', 0) !== 0) {
			session('activesubmenuid', I('get.activesubmenuid'));
		}

		$this -> getConfig();

		$this -> assignPageVars();

		// 是否是超级管理员
		define('IS_ROOT', is_administrator());

		$this -> checkAllowIP();

		if (defined("APP_DEBUG") && APP_DEBUG) {
			define("APP_VERSION", time());
		} else {
			define("APP_VERSION", C('APP_VERSION'));
		}
	}

	public function checkAllowIP() {
		$allowIP = C('ADMIN_ALLOW_IP');
		if (!IS_ROOT && $allowIP) {
			// 检查IP地址访问
			if (!in_array(get_client_ip(), explode(',', $allowIP))) {
				$this -> error('403:禁止访问');
			}
		}
	}

	//页面上变量赋值
	public function assignPageVars() {
		$seo = array('title' => C('WEBSITE_TITLE'), 'keywords' => C('WEBSITE_KEYWORDS'), 'description' => C('WEBSITE_DESCRIPTION'));
		$vars = array('owner' => C('WEBSITE_OWNER'), 'statisticalcode' => C('WEBSITE_STATISTICAL_CODE'), 'theme' => C('DEFAULT_THEME'), );
		$this -> assignVars($seo, $vars);
	}

	/**
	 * 从数据库中取得配置信息
	 */
	protected function getConfig() {
		$config = S('config_' . session_id() . '_' . session("uid"));
		if ($config === false) {
			$map = array();
			$fields = 'type,name,value';
			$result = apiCall('Ucenter/Config/queryNoPaging', array($map, false, $fields));
			if ($result['status']) {
				$config = array();
				if (is_array($result['info'])) {
					foreach ($result['info'] as $value) {
						$config[$value['name']] = $this -> parse($value['type'], $value['value']);
					}
				}
				//缓存配置300秒
				S("config_" . session_id() . '_' . session("uid"), $config, 300);
			} else {
				LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
				$this -> error($result['info']);
			}
		}
		C($config);
	}

	/**
	 * 根据配置类型解析配置
	 * @param  integer $type  配置类型
	 * @param  string  $value 配置值
	 */
	private static function parse($type, $value) {
		switch ($type) {
			case 3 :
				//解析数组
				$array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
				if (strpos($value, ':')) {
					$value = array();
					foreach ($array as $val) {
						list($k, $v) = explode(':', $val);
						$value[$k] = $v;
					}
				} else {
					$value = $array;
				}
				break;
		}
		return $value;
	}

	//获取用户信息
	protected function getUserinfo($uid) {

		$user = session('global_user');
		if (is_null($user)) {
			$user = apiCall("Ucenter/Ucenter/getUserinfo", array($uid));
			if ($user === false) {
				if (session('?LOGIN_MOD')) {
					$this -> error(L('ERR_SESSION_TIMEOUT'), U("Public/logout"));
				} else {
					$this -> error(L('ERR_SESSION_TIMEOUT'), U(session("LOGIN_MOD") . "/Public/logout"));
				}
			} else {
				session('global_user_sign', data_auth_sign($user));
				session('global_user', $user);
			}
		}

		$this -> assign("user", $user);
		return $user;

	}

	//===========================重复代码

	/**
	 * 启用
	 */
	public function enable($suc_info = '') {
		$id = I('id', -1);
		$map = array("id"=>$id);
		$result = apiCall(MODULE_NAME . '/' . CONTROLLER_NAME . '/enable', array($map));
		if (empty($suc_info)) {
			$suc_info = L('RESULT_SUCCESS');
		}
		if ($result['status']) {
			$this -> success($suc_info);
		} else {
			$this -> error(L('RESULT_FAILED'));
		}
	}

	/**
	 * 禁用
	 */
	public function disable($suc_info = '') {
		$id = I('id', -1);
		$map = array("id"=>$id);
		$result = apiCall(MODULE_NAME . '/' . CONTROLLER_NAME . '/disable', array($map));
		if (empty($suc_info)) {
			$suc_info = L('RESULT_SUCCESS');
		}
		if ($result['status']) {
			$this -> success($suc_info);
		} else {
			$this -> error(L('RESULT_FAILED'));
		}
	}

	/**
	 * 分页查询结果处理
	 */
	public function queryResult($result) {
		if ($result['status']) {
			$this -> assign("show", $result['info']['show']);
			$this -> assign("list", $result['info']['list']);
			$this -> display();
		} else {
			LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
			$this -> error($result['info']);
		}
	}

	//===========================通用CRUD操作方法
	/**
	 * 增加菜单
	 * GET:显示
	 * @param $success_url 添加成功后跳转url
	 */
	public function add($entity, $success_url = false, $suc_info = '') {
		if (IS_GET) {
			$this -> display();
		} else {
			if ($success_url === false) {
				$success_url = U(MODULE_NAME . '/' . CONTROLLER_NAME . '/index');
			}
			$result = apiCall(MODULE_NAME . '/' . CONTROLLER_NAME . '/add', array($entity));
			if ($result['status'] === false) {
				LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
				$this -> error($result['info']);
			} else {
				if ($suc_info === '') {
					$suc_info = L('RESULT_SUCCESS');
				}
				$this -> success($suc_info, $success_url);
			}

		}
	}

	/**
	 * 查看
	 */
	public function view($primarykey = 'id') {
		$map = array($primarykey => I('get.id'));

		$result = apiCall(MODULE_NAME . '/' . CONTROLLER_NAME . '/getInfo', array($map));

		if ($result['status'] === false) {
			LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
			$this -> error(L('C_GET_NULLDATA'));
		} else {
			$this -> assign("entity", $result['info']);

			$this -> display();
		}
	}

	/**
	 * 编辑页面展示
	 */
	public function edit() {
		if (IS_GET) {
			$map = array('id' => I('get.id'));
			$result = apiCall(MODULE_NAME . '/' . CONTROLLER_NAME . '/getInfo', array($map));
			if ($result['status'] === false) {
				LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
				$this -> error(L('C_GET_NULLDATA'));
			} else {
				$this -> assign("entity", $result['info']);
				$this -> display();
			}
		}
	}

	/**
	 * 保存
	 */
	public function save($redirect_url = false, $entity = null, $primarykey = 'id') {
		if (I('get.' . $primarykey, 0) === 0) {
			$this -> error(L('ERR_PARAMETERS'));
		}
		if (IS_POST) {
			if ($redirect_url === false) {
				$redirect_url = U(MODULE_NAME . '/' . CONTROLLER_NAME . '/index');
			}
			if (is_null($entity)) {
				$entity = I('post.');
			}
			if ($primarykey == 'id') {
				$result = apiCall(MODULE_NAME . '/' . CONTROLLER_NAME . '/saveByID', array(I('get.' . $primarykey, 0), $entity));
			} else {
				$result = apiCall(MODULE_NAME . '/' . CONTROLLER_NAME . '/save', array(I('get.' . $primarykey, 0), $entity));
			}
			if ($result['status'] === false) {
				LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
				$this -> error($result['info']);
			} else {
				$this -> success(L('RESULT_SUCCESS'), $redirect_url);
			}

		}

	}

	/**
	 * 删除
	 * @param $success_url 删除成功后跳转
	 */
	public function delete($success_url = false) {
		if ($success_url === false) {
			$success_url = U(MODULE_NAME . '/' . CONTROLLER_NAME . '/index');
		}
		$map = array('id' => I('id', -1));

		$result = apiCall(MODULE_NAME . '/' . CONTROLLER_NAME . '/delete', array($map));

		if ($result['status'] === false) {
			LogRecord('[INFO]' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
			$this -> error($result['info']);
		} else {
			$this -> success(L('RESULT_SUCCESS'), $success_url);
		}
	}

	/**
	 * 批量删除
	 * @param $success_url 删除成功后跳转
	 */
	public function bulkDelete($success_url = false) {
		if ($success_url === false) {
			$success_url = U(MODULE_NAME . '/' . CONTROLLER_NAME . '/index');
		}
		$ids = I('ids', -1);
		if ($ids === -1) {
			$this -> error(L('ERR_PARAMETERS'));
		}
		$ids = implode(',', $ids);
		$map = array('id' => array('in', $ids));

		$result = apiCall(MODULE_NAME . '/' . CONTROLLER_NAME . '/delete', array($map));

		if ($result['status'] === false) {
			LogRecord('[INFO]' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
			$this -> error($result['info']);
		} else {
			$this -> success(L('RESULT_SUCCESS'), $success_url);
		}
	}

}
