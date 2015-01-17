<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Jjy\Api;
use Jjy\Model\BankAccountModel;

class BankAccountApi extends Api{
		
	protected function _init(){
		$this->model = new BankAccountModel();
	}
	
}
