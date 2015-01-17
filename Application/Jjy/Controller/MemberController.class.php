<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Jjy\Controller;

class MemberController extends JjyController {

	/**
	 *
	 */
	public function index() {
		$map = array();
		$param = array();
		$map['status'] = 1;
		if (I('realname', '', "trim") != '') {
			$map['realname'] = array('like', '%' . I('realname', '', 'trim') . '%');
			$param = array('realname' => I('realname', '', 'trim'));
		}
		$page = array('curpage' => I('get.p', 0), 'size' => C('LIST_ROWS'));
		$order = 'reg_time desc';

		$result = apiCall('Jjy/Member/query', array($map, $page, $order, $param));
		if ($result['status']) {
			$this -> assign('show', $result['info']['show']);
			$this -> assign('list', $result['info']['list']);

			$this -> display();
		} else {
			$this -> error(L('ERR_SYSTEM_BUSY'));
		}
	}

	/**
	 * TODO:注册账号
	 */
	public function register() {
		if (IS_GET) {
			$this -> display();
		} elseif (IS_POST) {
			$user = I("post.");
			//创建一个uc_ucenter_member 数据
			//创建一个common_member 数据
		}
	}

	/**
	 * TODO:汇款记录查询
	 * 每个月
	 */
	public function remitHistory() {

		$this -> display();

	}

	public function view() {
		parent::view('uid');
	}

	/**
	 * 重置密码
	 */
	public function resetpwd() {
		$uid = I('get.id', 0);
		//TODO:权限检测
		$result = apiCall('Jjy/Member/getInfo', array('uid' => $uid));
		if ($result['status']) {
			$pwd = $this -> generatePwd();
			//TODO: 初步限制uid>2 以上的不能修改权限检测
			if (UID > 2) {
				$this -> error(L('ERR_NO_AUTHORITY'));
			} else {
				$result = apiCall('Uclient/User/updatePwd', array($uid, $pwd));
				if ($result['status']) {
					$this -> assign('password', $pwd);
					$this -> display();
				} else {
					$this -> error(L('ERR_RESET_FAIL'));
				}
			}
		} else {
			$this -> error(L('ERR_RESET_FAIL'));
		}
	}

	private function generatePwd() {
		return "123456konkon";
	}

	/**
	 * 修改密码
	 * 用户自己
	 */
	public function changepwd() {
		$uid = session("uid");
		//TODO:权限检测
		$result = apiCall('Jjy/Member/getInfo', array('uid' => $uid));
		if ($result['status']) {
			$oldpwd = I("post.old", '', 'trim');
			$pwd = I("post.password", '', 'trim');
			$repwd = I("post.repassword", '', 'trim');
			if (empty($oldpwd) || empty($pwd) || empty($repwd)) {
				$this -> error(L("ERR_PARAMETERS"));
			}

			//密码是否一致
			if ($pwd !== $repwd) {
				$this -> error(L("ERR_SAME_PASSWORD"));
			}

			$result = apiCall('Uclient/User/updateInfo', array($uid, $oldpwd, array("password" => $pwd)));
			if ($result['status']) {
				$this -> success(L('RESULT_SUCCESS'));
			} else {
				$this -> error(L('ERR_CHANGE_FAIL'));
			}

		} else {
			$this -> error(L('ERR_CHANGE_FAIL'));
		}
	}

	/**
	 * 保存
	 */
	public function save() {
		//		dump(I('post.'));
		$redirect_url = U('Jjy/Home/memberview');
		$entity = array('sex' => I('post.sex', 0), 'birthday' => I('post.birthday', "2015-01-01"), 'address' => I('post.address', '','trim'), 'email' => I('post.email', ""), 'remark'=>I('post.remark',''));
		if ($this -> checkDatetime($entity['birthday'], 'Y-m-d') === 0) {
			$this -> error(L('ERR_DATE_INVALID'));
		}
		
		parent::save($redirect_url, $entity, "uid");
	}
	
	/**
	 * 检测字符串是否为日期
	 */
	function checkDatetime($str, $format = "Y-m-d H:i:s") {
		$unixTime = strtotime($str);
		$checkDate = date($format, $unixTime);
		if ($checkDate == $str)
			return 1;
		else
			return 0;
	}

}
