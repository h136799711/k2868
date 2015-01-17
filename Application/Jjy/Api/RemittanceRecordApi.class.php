<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Jjy\Api;
use Jjy\Model\RemittanceRecordModel;

class RemittanceRecordApi extends Api{
		
	protected function _init(){
		$this->model = new RemittanceRecordModel();
	}
	
	/**
	 * 返回待审核记录数
	 */
	public function needCheckCnt(){
		$result = $this->model->where(array('status'=>2))->count();
		
		if($result === false){
			return $this->apiReturnErr($this->model->getDbError());
		}
		else{
			return $this->apiReturnSuc($result);
		}
	}
	
	/**
	 * 通过审核
	 */
	public function pass($map){
		$result = parent::pass($map);
		
		if($result === false){
			return $this->apiReturnErr($this->model->getDbError());
		}
		else{
			return $this->apiReturnSuc($result);
		}
		
	}
	
	/**
	 * 不通过审核
	 */
	public function notPass($map){
		$result = parent::notPass($map);
		
		if($result === false){
			return $this->apiReturnErr($this->model->getDbError());
		}
		else{
			return $this->apiReturnSuc($result);
		}
	}
}
