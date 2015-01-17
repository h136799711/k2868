<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------
namespace Jjy\Controller;

class BankAccountController extends JjyController{
	
	
	protected function _initialize(){
		parent::_initialize();
		$this->assign("banks",C('BANK_TYPE'));
	}
	
	public function index(){
		
		$map = array();
		$page = array('curpage'=>I('p',0),'size'=>C('LIST_ROWS'));
		$order = 'update_time desc';
		$result = apiCall('Jjy/BankAccount/query',array($map,$page,$order));
		if($result['status']){
			$this->assign('show',$result['info']['show']);
			$this->assign('list',$result['info']['list']);
			$this->display();
		}else{
			$this->error(L('ERR_SYSTEM_BUSY'));
		}
		
	}
	
	public function add(){
		if(IS_GET){
			$this->display();
		}else{
			$entity = I('post.');
//			dump($entity);
			parent::add($entity,U('Jjy/BankAccount/index'));
		}
	}
	
	public function save(){
		parent::save(U('Jjy/BankAccount/index'));
	}
	
	/**
	 * 获取账号
	 * 根据banktype
	 */
	public function getAccounts(){
		if(IS_AJAX){
			$banktype = I('banktype','');
			$type = I('type','0');
			if($banktype === ''){
				$this->ajaxReturn(array('status'=>false,'info'=>L('ERR_PARAMETERS')));;
			}			
			$map = array('status'=>1,'bank_type'=>$banktype,'type'=>$type);
			$order = ' update_time desc ';
			$fields = "account,bank_name,bank_url,account_name";
			$result = apiCall("Jjy/BankAccount/queryNoPaging",array($map,$order,$fields));
			$this->ajaxReturn($result);
		}else{
			$this->error("请求错误！");
		}
	}
	
}

