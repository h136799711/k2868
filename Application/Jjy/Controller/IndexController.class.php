<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Jjy\Controller;
use Common\Controller\BaseController;

class IndexController extends BaseController{
	
	
	/**
	 * 管理平台首页
	 */
	public function index(){
		$needCheckCnt = $this->countRemittance();
		$userCnt = $this->countUsers();
		$this->assign('needCheckCnt',$needCheckCnt);
		$this->assign('userCnt',$userCnt);
		$this->display();
	}
	/**
	 * 总用户数
	 */
	protected function countUsers(){
		$map = array();
		$result = apiCall('Jjy/Member/count',array($map));
		if($result['status']){
			return $result['info'];
		}else{
			LogRecord($result['info'],__FILE__.__LINE__);
		}
	}
	/**
	 * 待审核数
	 */
	protected function countRemittance($status=2){
		$result = apiCall('Jjy/RemittanceRecord/needCheckCnt',array());
		if($result['status']){
			return $result['info'];
		}else{
			LogRecord($result['info'],__FILE__.__LINE__);
		}
	}
	
	/**
	 * 注册
	 */
	public function register(){
		$this->display();
	}
	
	/**
	 * 检测登录
	 */
	public function checkLogin(){
		if(IS_AJAX){
			
		}
	}
	
}
