<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Jjy\Controller;
use Common\Controller\BaseController;

class TestController extends BaseController{
	public function test(){
		$userid = 27;
		$money = -50;
		$addResult = apiCall('Jjy/Member/setInc', array(array("uid"=>$userid),'goldcoin',$money));
		dump($addResult);
		$addResult = apiCall('Jjy/Member/getInfo', array(array("uid"=>$userid)));
		dump($addResult);
	}
}
