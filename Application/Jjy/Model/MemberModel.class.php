<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Jjy\Model;
use Think\Model;

class MemberModel extends Model{
	
	protected $_validate = array(
		/* 验证用户名 */
		array('realname','require',-1,self::MODEL_BOTH), 
		array('idnumber','require',-2,self::MODEL_BOTH), 
		array('mobile','require',-3,self::MODEL_BOTH),
		array('email','require',-4,self::MODEL_BOTH),
		array('remark','require',-5,self::MODEL_BOTH),
	);
	
	protected $_auto=array(
		array('last_login_time','time',self::MODEL_INSERT,'function'),
		array('reg_time','time',self::MODEL_INSERT,'function'),
		array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
		array('status','1',self::MODEL_INSERT)
	);
	/**
	 * 注册
	 */
	public function register($entity){
		
	 	/* 添加用户 */
	 	//指定插入状态否则自动完成不能实现
		if($this->create($entity,self::MODEL_INSERT)){
			$uid = $this->add();
			return $uid ? $uid : 0; //0-未知错误，大于0-注册成功
		} else {
			return $this->getError(); //错误详情见自动验证注释
		}
	}
	
	/**
	 * 
	 */
	public function login($uid){
		$result = $this->where(array('uid'=>$uid))->find();
		
		
		if(is_null($result) || $result === false){
			return false;
		}else{
			$this->updateLogin($uid);
			return $result;
		}
	}
	
	/**
	 * 更新用户登录信息
	 * @param  integer $uid 用户ID
	 */
	protected function updateLogin($uid){
		$data = array(
			'uid'              => $uid,
			'last_login_time' => NOW_TIME,
			'last_login_ip'   => get_client_ip(1),
		);
		$this->save($data);
	}
	
}
