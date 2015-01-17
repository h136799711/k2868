<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Jjy\Controller;
use Common\Controller\BaseController;
use User\Api\UserApi;

class PublicController extends BaseController {


	/**
	 * 初始化
	 */
	protected function _initialize() {
		parent::_initialize();
	}

	/**
	 * 注销\登出
	 */
	public function logout() {
		//转发登录
		if(session("?LOGIN_MOD")){
			$redirect_url = session("LOGIN_MOD").'/Public/login';
		}else{
			$redirect_url = "Public/login";
		}
		//
		session(null);		
		session('[destroy]');
		
		//转发登录
		$this -> redirect($redirect_url);
	}
	
	/**
	 * 登录检测
	 */
	public function checkLogin() {

		if (IS_POST) {
			
			$username = I('post.username', '','trim');
			
			if(empty($username) || $username == '请输入交易平台账号'){
				$this->error("交易平台账号不能为空");
			}
			
			session('global_user_sign', data_auth_sign($username));
			session('global_user', $username);
			session("uid", $username);
			//登录模块
			session("LOGIN_MOD",MODULE_NAME);
			$this -> success(L('SUC_LOGIN'), U('Jjy/Home/choose'));
			
		}
	}
	
	/**
	 * GET 登录
	 */
	public function login() {
		$this -> assignTitle("账号-登录");

		if (IS_GET) {
			//显示登录界面
			$this -> redirect('Jjy/Home/index');
		}
	}
	
	/**
	 * TODO:注册页面
	 *
	 * @return 注册页面
	 * @author beibei hebiduhebi@126.com
	 */
//	public function register() {
//		if (IS_GET) {
//			$this -> assignTitle("注册");
//			$this -> redirect('Jjy/Home/register');
//		} else {
//			
//		}
//	}
	
	/**
	 * 检测用户名是否被占用
	 * @return true被占用  false未占用
	 */
//	public function check_username($username){
//		$result = apiCall("Uclient/User/checkUsername",array($username));
//		if($result['status']){
//			echo "true";
//		}else{
//			echo "false";
//		}
//	}
	/**
	 * 检测邮箱是否被占用
	 * @return true被占用  false未占用
	 */
//	public function check_email($email){
//		$result = apiCall("Uclient/User/checkEmail",array($email));
//		if($result['status']){
//			echo "true";
//		}else{
//			echo "false";
//		}
//	}
	
	/**
	 * 注册时验证验证码是否正确
	 * @return true正确  false不正确
	 */
//	public function checkVerify($code){
//		
//		$result = $this->check_verify($code,2);
//		if($result){
//			echo "true";
//		}else{			
//			echo "false";
//		}
//	}
	
	/**
	 * 校验验证码是否正确
	 * @return Boolean
	 */
//	private function check_verify($code, $id = 1) {
//
//		$config = array('fontSize' => 10, // 验证码字体大小
//		'length' => 4, // 验证码位数
//		'useNoise' => false, // 关闭验证码杂点
//		);
//		$Verify = new \Think\Verify($config);
//		return $Verify -> check($code, $id);
//	}

	/**
	 * 获取验证码
	 */
//	public function verify() {
//		$config = array('fontSize' => 14, // 验证码字体大小
//		'length' => 4, // 验证码位数
//		'useNoise' => false, // 关闭验证码杂点
//		'useCurve'=>false,
//		'imageW' => '90', 'imageH' => '30');
//		$Verify = new \Think\Verify($config);
//		$Verify -> codeSet = 'abcdefghijklmnopqrstuvxyzwQWERTYUIOPASDFGHJKLZXCVBNM';
//		$Verify -> entry(1);
//	}
	
	/**
	 * 获取验证码
	 */
//	public function verifylg() {
//		$config = array('fontSize' => 20, // 验证码字体大小
//		'length' => 4, // 验证码位数
//		'useNoise' => false, // 关闭验证码杂点
//		'useCurve'=>true,
//		'reset'=>false,
//		'imageW' => '140', 'imageH' => '40');
//		$Verify = new \Think\Verify($config);
//		$Verify -> codeSet = 'abcdefghijklmnopqrstuvxyzwQWERTYUIOPASDFGHJKLZXCVBNM';
//		$Verify -> entry(2);
//	}
}
