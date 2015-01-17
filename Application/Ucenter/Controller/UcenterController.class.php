<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Ucenter\Controller;
use Common\Controller\CheckLoginController;

class UcenterController extends CheckLoginController {

	protected function _initialize() {
		parent::_initialize();
		$this->assign("user",session("global_user"));
		//当前一级导航激活menu
		if (I('get.activemenuid', 0) !== 0) {
			session('activemenuid', I('get.activemenuid'));
			session('activesubmenuid', 0);
		}
		//当前三级导航
		if (I('get.activesubmenuid', 0) !== 0) {
			session('activesubmenuid', I('get.activesubmenuid'));
		}
		//获取配置
		$this -> getConfig();
		//对页面一些配置赋值
		$this->assignPageVars();
		 // 是否是超级管理员
        define('IS_ROOT',   is_administrator());
        //检测IP是否受限制
		$this->checkAllowIP();
		
		//定义版本
		if(defined("APP_DEBUG") && APP_DEBUG){
			define("APP_VERSION",time());
		}else{
			define("APP_VERSION",C('APP_VERSION'));
		}
	}
	
	public function checkAllowIP(){
			$allowIP = C('ADMIN_ALLOW_IP');
			if(!IS_ROOT && $allowIP){
            // 检查IP地址访问
            if(!in_array(get_client_ip(),explode(',',$allowIP))){
                $this->error('403:禁止访问');
            }
        }
	}
	
	//页面上变量赋值
	public function assignPageVars(){
		$seo = array(
			'title'=>C('WEBSITE_TITLE'),
			'keywords'=>C('WEBSITE_KEYWORDS'),
			'description'=>C('WEBSITE_DESCRIPTION')
		);
		$vars = array(
			'owner'=>C('WEBSITE_OWNER'),
			'statisticalcode'=>C('WEBSITE_STATISTICAL_CODE'),
			'theme'=>C('DEFAULT_THEME'),
		);
		$this->assignVars($seo,$vars);
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
						$config[$value['name']] = $this->parse($value['type'], $value['value']);
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


	//===========================重复代码
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
	public function add($entity, $success_url = false) {
		if (IS_GET) {
			$this -> display();
		} else {
			if ($success_url === false) {
				$success_url = U('Ucenter/' . CONTROLLER_NAME . '/index');
			}
			$result = apiCall('Ucenter/' . CONTROLLER_NAME . '/add', array($entity));
			if ($result['status'] === false) {
				LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
				$this -> error($result['info']);
			} else {
				$this -> success(L('RESULT_SUCCESS'), $success_url);
			}

		}
	}

	/**
	 * 查看
	 */
	public function view() {
		$map = array('id' => I('get.id'));
		$result = apiCall('Ucenter/' . CONTROLLER_NAME . '/getInfo', array($map));
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
			$result = apiCall('Ucenter/' . CONTROLLER_NAME . '/getInfo', array($map));
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
	public function save($redirect_url = false) {

		if ($redirect_url === false) {
			$redirect_url = U('Ucenter/' . CONTROLLER_NAME . '/index');
		}

		$entity = I('post.');
		$result = apiCall('Ucenter/' . CONTROLLER_NAME . '/saveByID', array(I('get.id', 0), $entity));
		if ($result['status'] === false) {
			LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
			$this -> error($result['info']);
		} else {
			$this -> success(L('RESULT_SUCCESS'), $redirect_url);
		}

	}

	/**
	 * 删除
	 * @param $success_url 删除成功后跳转
	 */
	public function delete($success_url = false) {
		if ($success_url === false) {
			$success_url = U('Ucenter/' . CONTROLLER_NAME . '/index');
		}
		$map = array('id' => I('id', -1));

		$result = apiCall('Ucenter/' . CONTROLLER_NAME . '/delete', array($map));

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
			$success_url = U('Ucenter/' . CONTROLLER_NAME . '/index');
		}
		$ids = I('ids', -1);
		if ($ids === -1) {
			$this -> error(L('ERR_PARAMETERS'));
		}
		$ids = implode(',', $ids);
		$map = array('id' => array('in', $ids));

		$result = apiCall('Ucenter/' . CONTROLLER_NAME . '/delete', array($map));

		if ($result['status'] === false) {
			LogRecord('[INFO]' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
			$this -> error($result['info']);
		} else {
			$this -> success(L('RESULT_SUCCESS'), $success_url);
		}
	}

}
