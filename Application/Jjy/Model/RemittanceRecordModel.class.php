<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Jjy\Model;
use Think\Model;

class RemittanceRecordModel extends Model{
	
    
	protected $_auto = array(
		array('create_time',NOW_TIME,self::MODEL_INSERT),
		array('update_time',NOW_TIME,self::MODEL_BOTH),
		array('status','2',self::MODEL_INSERT),
	);
	
	
}
