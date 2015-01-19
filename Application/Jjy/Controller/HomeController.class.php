<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Jjy\Controller;
use Common\Controller\BaseController;

class HomeController extends BaseController {
	
//	protected $PREFIX = "GCG";
	
	protected function _initialize() {
		parent::_initialize();
		$this->assignTitle("k2868.com");
		$this->assign("banks",C('BANK_TYPE'));
//		$this->assign("prefix",$this->PREFIX);
	}
	
	public function remitrecord(){
		$this->redirect("Home/membercenter");
	}
	
	/**
	 * 检测登录
	 */
	protected function checkLogin(){
		
		if (session('?uid') && is_login() !== 0) {
			
			$this->assign("user",session('global_user'));
		}else{
			$this -> error(L('ERR_PLEASE_LOGIN'),U("Jjy/Public/logout"));
		}
	}
	
	/**
	 * 登录前的用户首页
	 */
	public function index() {
		$this->display();
	}
	
	/**
	 * 注册页面
	 */
//	public function register(){
//		if(IS_POST){
			
//			
//			$verify = I('post.code', '', 'trim');
//			if(!$this->check_verify($verify,2)){
//              $this->error(L('ERR_VERIFY'));
//          }
//			
//			$username = I('post.username', '', 'trim');
//			$email = I('post.email', '', 'trim');
//			$password = I('post.password', '', 'trim');
//			$mobile = I('post.mobile', '', 'trim');
//			$realname = I('post.realname', '', 'trim');
//			$orgcode = I('post.orgcode', '', 'trim');
//			$idnumber = I('post.idnumber', '', 'trim');
//			$nickname = I('post.nickname',$realname, 'trim');
//			$remark = I('post.remark', '', 'trim');
//			
//			//TODO:需要严格验证数据合法性
//			if ($username == '' || $email == '' || $password == '' || $mobile == '' || $realname == '' ||  $idnumber == '' || $nickname == '' || $remark == '') {
//				$this -> error(L('ERR_PARAMETERS'));
//			}
//			
//			if (I('post.repassword', '') != $password) {
//				$this -> error(L('ERR_SAME_PASSWORD'));
//			}
//			
////			$username = $this->PREFIX.$username;
//			//===============验证完毕
//			$result = apiCall("Uclient/User/register", array($username, $password, $email, $mobile));
//			
//			if ($result['status']) {
//				$entity = array('uid' => $result['info'], 'realname' => $realname, 'orgcode' => $orgcode, 'idnumber' => $idnumber,'remark'=>$remark,'address'=>"", 'nickname' => $nickname, 'mobile' => $mobile, 'email' => $email);
//			
//				$result = apiCall("Jjy/Member/register", array($entity));
//
//				if ($result['status']) {
//					$this -> success("注册成功，请登录！", U('Jjy/Public/login'));
//				} else {
//					LogRecord($result['info'], __FILE__ . __LINE__);
//					//TODO:删除用户中心中刚注册的
//					//apiCall("Uclient/User/delete",array("id"=>$uid));
//					$this -> error(L('ERR_REGISTER_ERROR'));
//				}
//
//			} else {
//				$this -> error($result['info']);
//			}
//
//			
//		}else{
//			$this->display();
//		}
//	}
	 
	 

	/**
	 * TODO:查询汇款记录历史
	 */
	public function remitHistory() {
		redirect(U('Home/manualdeposit'));
//		$this->checkLogin();
//		
//		$status = I('status', '');
//		$range = getDataRange(I('get.datarange', '-1'));
//		$this -> startdatetime = $range["0"];
//		$this -> enddatetime = $range["1"];
//		
//		//分页时带参数get参数
//		$params = array('startdatetime' => $this -> startdatetime, 'enddatetime' => $this -> enddatetime);
//
//		$this -> startdatetime = strtotime($this -> startdatetime);
//		//限制只能查询30天以内的记录
//		if(time() - $this -> startdatetime > 30*24*3600){
//			$this -> startdatetime = time() - 30*24*3600;
//		}
//		
//		$this -> enddatetime = strtotime($this -> enddatetime)+24*3600;
//		
//		if($this->enddatetime - time() >= 2*24*3600 ){
//				$this->enddatetime = time()+24*3600;
//		}
//		
//		if ($this -> startdatetime === FALSE || $this -> enddatetime === FALSE) {
//			LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
//			$this -> error(L('ERR_DATE_INVALID'));
//		}
//		$map = array();
//		$map['create_time'] = array( array('EGT', $this -> startdatetime), array('elt', $this -> enddatetime), 'and');
//		$map['userid'] = session("uid");
//		if (!empty($status)) {
//			$map['status'] = $status;
//			$params['status'] = $status;
//			$this -> assign('status', $status);
//		}
//		
//		$page = array('curpage' => I('p', 0), 'size' => C('LIST_ROWS'));
//		$order = 'create_time desc';
//		$result = apiCall('Jjy/RemittanceRecord/query', array($map, $page, $order, $params));
//		if ($result['status']) {
//			$this -> assign('startdatetime', $this -> startdatetime);
//			$this -> assign('enddatetime', $this -> enddatetime);
//			$this -> assign('show', $result['info']['show']);
//			$this -> assign('list', $result['info']['list']);
//			$this -> display();
//		} else {
//			$this -> error(L('ERR_SYSTEM_BUSY'));
//		}
	}
	/**
	 * 选择存款方式
	 */
	public function choose() {
		$this->checkLogin();

		$this->display();
	}
	/**
	 * 手工存款
	 */
	public function manualdeposit(){
		$this->checkLogin();
		$result = $this->getOnlyOneBank(0);
		
		if($result['status']){
			$this->assign("bankaccount",$result['info']);
			$this->display();
		}else{
			$this->error(L('ERR_SYSTEM_BUSY'));
		}
	}
	 
	 /**
	 * 工行速汇
	 */
	public function speeddeposit(){
		$this->checkLogin();
		
		$result = $this->getOnlyOneBank(1);
		
		if($result['status']){
			$this->assign("bankaccount",$result['info']);
			$this->display();
		}else{
			$this->error(L('ERR_SYSTEM_BUSY'));
		}
	}
		
	
	/**
	 * 在线支付
	 */
	public function recharge(){
		$this->checkLogin();
		
		$result = $this->getOnlyOneBank(1);
		if($result['status']){
			$this->assign("bankaccount",$result['info']);
			$this->display();
		}else{
			$this->error(L('ERR_SYSTEM_BUSY'));
		}
	}
	
	
	//0是手动
	//1是在线
	private function getOnlyOneBank($type=0){
		$map = array('type'=>$type,'status'=>1);
		$result = apiCall('Jjy/BankAccount/getInfo',array($map));
		
		return $result;
		
	}
	
	/**
	 * 在线支付
	 */
	public function payment(){
		$this->checkLogin();
		$money = I('post.money',0);
		$accountid = I("post.bankaccountid",-1);
		$map = array('id'=>$accountid,'status'=>1);

		$result = apiCall('Jjy/BankAccount/getInfo',array($map));
		
		if($result['status']){
			$this->assign("bank",$result['info']);
			$this->assign("money",$money);
			$this->display();
		}else{
			$this->error(L('ERR_SYSTEM_BUSY'));
		}
//		$this->display();
	}
	/**
	 * 会员信息查看
	 */
	public function memberview(){
		refreshSessionUser();
		$this->checkLogin();
		
		$this->display();		
	}
	
	
	/**
	 * 校验验证码是否正确
	 * @return Boolean
	 */
	private function check_verify($code, $id = 1) {

		$config = array('fontSize' => 10, // 验证码字体大小
		'length' => 4, // 验证码位数
		'useNoise' => false, // 关闭验证码杂点
		'reset'=>false,
		);
		$Verify = new \Think\Verify($config);
		return $Verify -> check($code, $id);
	}
	
	
}
