<?php
/**
 * (c) Copyright 2014 hebidu. All Rights Reserved. 
 */
 

return array(
	//唯一管理员用户配置	
   'USER_ADMINISTRATOR' => 1, //管理员用户ID
   'MODULE_DENY_LIST'      =>  array('Common','Runtime','Uclient'),
   'URL_CASE_INSENSITIVE' =>false,
	//程序版本
	//DONE:移到数据库中
	//显示运行时间
	'SHOW_RUN_TIME'=>true,
//	'SHOW_ADV_TIME'=>true,
	//显示数据库操作次数
//	'SHOW_DB_TIMES'=>true,
	//显示操作缓存次数
//	'SHOW_CACHE_TIMES'=>true,
	//显示使用内存
//	'SHOW_USE_MEM'=>true,
	//显示调用函数次数
//	'SHOW_FUN_TIMES'=>true,
	//伪静态配置
	'URL_HTML_SUFFIX'=>'shtml'	,
    // 路由配置
    'URL_MODEL'                 =>  1, // 如果你的环境不支持PATHINFO 请设置为3
    // 数据库配置
    'DB_TYPE'                   =>  'mysql',
    'DB_HOST'                   =>  'localhost',
    'DB_NAME'                   =>  'hebidu_rbac',
    'DB_USER'                   =>  'root',
    'DB_PWD'                    =>  '1',
    'DB_PORT'                   =>  '3306',
    'DB_PREFIX'                 =>  'rbac_',
   //调试
    'LOG_RECORD' => true, // 开启日志记录
    'LOG_TYPE'              =>  'Db',
	'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误
    'LOG_DB_CONFIG'=>array(
		'dsn'=>'mysql://root:1@127.0.0.1:3306/hebidu_rbac' //本地日志数据库
	),
    // Session 配置
    'SESSION_PREFIX' => 'oauth_'
);
