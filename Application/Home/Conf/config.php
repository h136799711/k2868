<?php
return array(
	"DEFAULT_THEME"=>"default",
	
	'TMPL_PARSE_STRING'  =>array(
	
     	'__CDN__' => __ROOT__.'/public/cdn', // 更改默认的/Public 替换规则
		'__M_VERSION__'=>'1000',//模块缓存版本
		'__JS__'     => __ROOT__.'/public/'.MODULE_NAME.'/js', // 增加新的JS类库路径替换规则
     	'__CSS__'     => __ROOT__.'/public/'.MODULE_NAME.'/css', // 增加新的JS类库路径替换规则
     	'__IMG__'     => __ROOT__.'/public/'.MODULE_NAME.'/imgs', // 增加新的JS类库路径替换规则	
     
	),	
);