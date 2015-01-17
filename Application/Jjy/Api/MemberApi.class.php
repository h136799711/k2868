<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Jjy\Api;
use Jjy\Model\MemberModel;

class MemberApi extends Api{
	
	protected function _init(){
		$this->model = D('Member');// new MemberModel();
	}
	
	public function login($uid){
		$result = $this->model->login($uid);
		if($result === false){
			$error = $this -> model -> getDbError();
			if(empty($error)){
				$error = "登录失败！";
			}
			return $this->apiReturnErr($error);
		}else{
			return $this->apiReturnSuc($result);
		}
	}
	
	/**
	 * Jjy系统的账号注册
	 */
	public function register($entity){
		
		$result = $this->model->register($entity);
		if ($result > 0) {
			return $this->apiReturnSuc($result);
		} else {
			$error = $this->getRegisterError($result);
			if($error === false){
				$error = $this -> model -> getDbError();
			}
			return $this->apiReturnErr($error);
		}
	}
	
	/**
	 * 获取注册时错误的人性化表述
	 */
	protected function getRegisterError($result){
		$errDesc = false;
		switch($result){
			case -1:
				$errDesc = "姓名必需";
				break;
			case -2:
				$errDesc = "身份证必需";
				break;
			case -3:
				$errDesc = "预留信息必需";
				break;
			default:
				break;
		}
		
		return $errDesc;
	}
	
}
