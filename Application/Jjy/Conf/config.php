<?php


return array(
	//自定义配置
	"DEFAULT_THEME"=>"default",
	'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
	'LANG_LIST'        => 'zh-cn', // 允许切换的语言列表 用逗号分隔
	'VAR_LANGUAGE'     => 'l', // 默认语言切换变量
	//多语言
	'LANG_SWITCH_ON'=>true,
	'TMPL_PARSE_STRING'  =>array(
     	'__CDN__' => __ROOT__.'/Public/cdn', // 更改默认的/Public 替换规则
		'__JS__'     => __ROOT__.'/Public/'.MODULE_NAME.'/js', // 增加新的JS类库路径替换规则
     	'__CSS__'     => __ROOT__.'/Public/'.MODULE_NAME.'/css', // 增加新的JS类库路径替换规则
     	'__IMG__'     => __ROOT__.'/Public/'.MODULE_NAME.'/imgs', // 增加新的JS类库路径替换规则	
     
	),	
	
    // 数据库配置
    'DB_TYPE'                   =>  'mysql',
    'DB_HOST'                   =>  'localhost',
    'DB_NAME'                   =>  'jjy',
    'DB_USER'                   =>  'root',
    'DB_PWD'                    =>  '1',
    'DB_PORT'                   =>  '3306',
    'DB_PREFIX'                 =>  'jjy_',
    
	'BANK_TYPE'=>array(
		'0'=>array('name'=>'中国工商银行','homepage'=>'http://www.icbc.com.cn'),
		'1'=>array('name'=>'中国建设银行','homepage'=>'http://www.ccb.com'),
		'2'=>array('name'=>'招商银行','homepage'=>'http://www.cmbchina.com'),
		'3'=>array('name'=>'中国银行','homepage'=>'http://www.boc.cn'),
		'4'=>array('name'=>'中国邮政储蓄银行','homepage'=>'http://www.psbc.com'),
		'5'=>array('name'=>'交通银行','homepage'=>'http://www.bankcomm.com'),
		'6'=>array('name'=>'华夏银行','homepage'=>'http://www.hxb.com.cn'),
		'7'=>array('name'=>'中信银行','homepage'=>'http://bank.ecitic.com'),
	)
);
