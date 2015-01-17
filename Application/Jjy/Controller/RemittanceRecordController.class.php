<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------
namespace Jjy\Controller;

class RemittanceRecordController extends JjyController {

	private $startdatetime = '';
	private $enddatetime = '';

	protected function __initailize() {
		parent::__initialze();
		//TODO:权限校验
	}
	
	public function needcheck() {
		//TODO:权限校验
//		$range = getDataRange(I('get.datarange', '-1'));
//		$this -> startdatetime = $range["0"];
//		$this -> enddatetime = $range["1"];
//
//		//分页时带参数get参数
//		$params = array('startdatetime' => $this -> startdatetime, 'enddatetime' => $this -> enddatetime);
//
//		$this -> startdatetime = strtotime($this -> startdatetime);
//		$this -> enddatetime = strtotime($this -> enddatetime);
//
//		if ($this -> startdatetime === FALSE || $this -> enddatetime === FALSE) {
//			LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
//			$this -> error(L('ERR_DATE_INVALID'));
//		}
		$map = array();
//		$map['create_time'] = array( array('EGT', $this -> startdatetime), array('elt', $this -> enddatetime), 'and');
		$map['status'] = 2;
		$params['status'] = 2;
		$page = array('curpage' => I('p', 0), 'size' => C('LIST_ROWS'));
		$order = 'create_time desc';
		$result = apiCall('Jjy/RemittanceRecord/query', array($map, $page, $order, $params));
		if ($result['status']) {
//			$this -> assign('startdatetime', $this -> startdatetime);
//			$this -> assign('enddatetime', $this -> enddatetime);
			$this -> assign('show', $result['info']['show']);
			$this -> assign('list', $result['info']['list']);
			$this -> display();
		} else {
			$this -> error(L('ERR_SYSTEM_BUSY'));
		}
	}
	

	public function index() {
		//TODO:权限校验
		$status = I('status', '');
		$remitname = I('remitname', '');
		$range = getDataRange(I('get.datarange', '-1'));
		$this -> startdatetime = $range["0"];
		$this -> enddatetime = $range["1"];

		//分页时带参数get参数
		$params = array('startdatetime' => $this -> startdatetime, 'enddatetime' => $this -> enddatetime);

		$this -> startdatetime = strtotime($this -> startdatetime);
		$this -> enddatetime = strtotime($this -> enddatetime);

		if ($this -> startdatetime === FALSE || $this -> enddatetime === FALSE) {
			LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
			$this -> error(L('ERR_DATE_INVALID'));
		}
		$map = array();
		$map['create_time'] = array( array('EGT', $this -> startdatetime), array('elt', $this -> enddatetime), 'and');
		if (!empty($status)) {
			$map['status'] = $status;
			$params['status'] = $status;
			$this -> assign('status', $status);
		}
		if (!empty($remitname)) {
			$map['username'] = array('like', '%' . $remitname . '%');
			$params['remitname'] = $remitname;
		}
		$page = array('curpage' => I('p', 0), 'size' => C('LIST_ROWS'));
		$order = 'create_time desc';
		$result = apiCall('Jjy/RemittanceRecord/query', array($map, $page, $order, $params));
		if ($result['status']) {
			$this -> assign('startdatetime', $this -> startdatetime);
			$this -> assign('enddatetime', $this -> enddatetime);
			$this -> assign('show', $result['info']['show']);
			$this -> assign('list', $result['info']['list']);
			$this -> display();
		} else {
			$this -> error(L('ERR_SYSTEM_BUSY'));
		}
	}
	
	
	
	public function pass() {
		//TODO:权限校验
		$map = array('id' => I('get.id', -1));
		$result = apiCall('Jjy/RemittanceRecord/pass', array($map));
		if ($result['status']) {
			$entity = apiCall('Jjy/RemittanceRecord/getInfo', array($map));
			if($entity['status']){
				$money = $entity['info']['money'];
				$userid = $entity['info']['userid'];
				if($money > 0){
					//余额增加
					$addResult = apiCall('Jjy/Member/setInc', array(array("uid"=>$userid),'goldcoin',$money));
					if($addResult['status'] === true){
						if($addResult['info'] === 0){
							//没影响记录
							//TODO:操作记录，余额变更记录
							LogRecord("ID:$userid账户余额增加失败,汇款记录ID为".$map['id'], __FILE__.__LINE__);
						}						
					}else{
						LogRecord($addResult['info'], __FILE__.__LINE__);
					}
				}
			}else{
				//TODO:记录日志
				LogRecord($entity['info'], __FILE__.__LINE__);
			}
			$success_url = U('Jjy/RemittanceRecord/needcheck');
			$this -> success(L('RESULT_SUCCESS'), $success_url);
		} else {
			LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
			$this -> error($result['info']);
		}
	}
	
	public function notpass() {
		//TODO:权限校验
		$map = array('id' => I('get.id', -1));
		$redirect=I('get.redirect','needcheck','trim');
		$result = apiCall('Jjy/RemittanceRecord/notpass', array($map));
		if ($result['status']) {
			$success_url = U('Jjy/RemittanceRecord/'.$redirect);
			$this -> success(L('RESULT_SUCCESS'), $success_url);
		} else {
			LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
			$this -> error($result['info']);
		}
	}
	
	/**
	 * 添加一条记录
	 */
	public function add(){
		//TODO:权限校验
		$entity = array(
			'currency'=>0,
			'userid'=>session("uid"),
			'deposit_username'=>I('post.deposit_username',''),
			'deposit_bank_address'=>I('post.deposit_bank_address',''),
			'deposit_bank_account'=>I('post.deposit_bank_account',''),
			'money'=>I('post.money',0,'floatval'),
			'username'=>I('post.username','','trim'),
			'remark'=>I('post.remark','','trim'),
			'transaction_date'=>I('post.transaction_date',time(),'strtotime'),
			'deposit_type'=>I('post.depositType',0,'trim'),
			
		);
		
		if(!is_float($entity['money'])){
			$this->error('存款金额有错，请检查！');//ERR_DATA_MONEY
		}
		
		if(empty($entity['deposit_username']) || empty($entity['deposit_bank_address'])
		||empty($entity['deposit_bank_account'])){
			$this->error('参数错误，请重新操作！');//ERR_DATA_MONEY
		}
		
		//TODO:数据合法性校验
		parent::add($entity,U('Jjy/Home/remitHistory'),'保存成功，请等候审核！');
	}
	
	/**
	 * 导出excel
	 */
	public function export(){
		//
		//TODO:权限校验
		$status = I('status', '');
		$remitname = I('remitname', '');
		$range = getDataRange(I('get.datarange', '-1'));
		$this -> startdatetime = $range["0"];
		$this -> enddatetime = $range["1"];

		//分页时带参数get参数
		
		$this -> startdatetime = strtotime($this -> startdatetime);
		$this -> enddatetime = strtotime($this -> enddatetime);

		if ($this -> startdatetime === FALSE || $this -> enddatetime === FALSE) {
			LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
			$this -> error(L('ERR_DATE_INVALID'));
		}
		$map = array();
		$map['create_time'] = array( array('EGT', $this -> startdatetime), array('elt', $this -> enddatetime), 'and');
		if (!empty($status)) {
			$map['status'] = $status;
			$params['status'] = $status;
		}
		if (!empty($remitname)) {
			$map['username'] = array('like', '%' . $remitname . '%');
			$params['remitname'] = $remitname;
		} 
		
		// 获取数据内容	
		$fields = "money,deposit_type,userid,username,remark,transaction_date,create_time,status";
		$order = 'status desc';
		$result = apiCall('Jjy/RemittanceRecord/queryNoPaging', array($map, $order, $fields));
		if($result['status']){
			$exceldata = $this->getExcelData($result['info']);
			
			$excelid = date("Y_m_d",$this -> startdatetime)."_".date("Y_m_d",$this -> enddatetime)."_数据";
			S(session_id().'_exceldata_'.$excelid,$exceldata,300);
			$this->success("导出成功！",U('Jjy/RemittanceRecord/download',array('excelid'=>$excelid)));
		}else{
			$this->error("导出失败，请重试！");
		}	
		//导出excel
		
		
	}
	
	/**
	 * 对数据库中查询的数据进行处理
	 */
	private function getExcelData($list){
		
		// money 汇款金额
		// deposit_type  存款方式
		// username 汇款账号姓名
		// remark 汇款预留信息
		// transaction_date 汇款时间
		// create_time 汇款时间
		$excelData = [];
		foreach($list as $key=>$vo){
			array_push($excelData,array(
							'id'=>$key+1,
							'money'=>$vo['money'],
							'deposit_type'=> getDepositType($vo['deposit_type']),
							'username'=>$vo['username'],
							 'transaction_date'=>date('Y-m-d H:i:s',$vo['transaction_date']),
							 'create_time'=>date('Y-m-d H:i:s',$vo['create_time']),
							'remark'=>$vo['remark'],
							'status'=>getStatus($vo['status']),
						));
		}
		
		return $excelData;
		
	}
	
	public function download(){
		$excelid = I('get.excelid',0);
		if($excelid === 0){
			$this->error("参数错误！");
		}
		$exceldata = S(session_id().'_exceldata_'.$excelid);
		if(	$exceldata != false){
			phpExcelExportRemittanceRecord($exceldata,array('序号','存款金额','存款方式','姓名','汇款时间','记录时间','备注信息','数据状态'),$excelid,$excelid);
//			exportToExcel($exceldata,array('序号','存款金额','存款方式','姓名','     \t汇款时间','\t记录时间            ','备注信息'),$excelid);
		}else{
			$this->error("没有相关数据");
		}
exit();
		
	}
	
}
