<?php

return array(
	 //1-常用
	 'ID'=>'ID',
     'UCENTER'=>'统一用户中心',
     'NAME'=>'标识',
     'TITLE'=>'标题',
     'SERIAL_NUMBER'=>'序号',
     'SORT'=>'排序',
     'OPERATOR'=>'操作',
     'UNKNOWN_ERR'=>'未知错误',
     'MENU'=>'菜单',
     'HOME_PAGE'=>'首页',
     'VIEW'=>'查看',
     'SELECT_ALL'=>'全选',
     'YES'=>'是',
     'NO'=>'否',
     'NO_DATA'=>'没有相关数据',
	 //Ucenter模块
	 
	 //3-各视图文件夹
	 'VIEW_VOLUME_NUMBERS'=>'卷数',
	 'VIEW_BACKUP_NAME'=>'备份名称',
	 'VIEW_BACKUP_TIME'=>'备份时间',
	 'VIEW_COMPRESS'=>'压缩',
	 'VIEW_ISHIDE'=>'隐藏',
	 'VIEW_TIP'=>'提示',
	 'VIEW_ISDEV'=>'是否开发者模式可见',
     'VIEW_URL'=>'链接地址',
     'VIEW_SUBMENU'=>'子菜单',
     'VIEW_DATETIME'=>'日期时间',
     'VIEW_INFO'=>'信息',
     'VIEW_LOG_SYSTEM'=>'系统日志',
     'VIEW_DATA_BACKUP'=>'数据备份',
     'VIEW_BACKUP_STATUS'=>'备份状态',
     'VIEW_CREATE_TIME'=>'创建时间',
     'VIEW_TABLE_NAME'=>'表名',
     'VIEW_DATA_LENGTH'=>'数据量',
     'VIEW_DATA_SIZE'=>'数据大小',
     'VIEW_WEEKLY'=>'最近7天',
     'VIEW_TODAY'=>'今天',
     'VIEW_YESTODAY'=>'昨天',
     'VIEW_MONTHLY'=>'最近30天',
     'VIEW_REMITTANCETIME'=>'存款日期',
     'VIEW_REMITTANCEREMARK'=>'存款预留信息',
     'VIEW_STATUS'=>'状态',
	 'VIEW_REMITTANCEUSERNAME'=>'存款人',
	 'VIEW_REMITTANCE_BANKACCOUNT'=>'存款银行',
	 'VIEW_REMITTANCEMONEY'=>'存款金额',
	 'VIEW_DEPOSIT_USERNAME'=>'收款人',
	 'VIEW_DEPOSIT_BANK_ACCOUNT'=>'收款银行',
	 'VIEW_DEPOSIT_BANK_ADDRESS'=>'收款银行开户地',
	 'VIEW_ACCOUNT_VIEW'=>'用户信息查看',
	 'VIEW_ACCOUNT_EDIT'=>'用户信息编辑',
	 'VIEW_PASSWORD'=>'密码',
     //4-model类里
  	 //Menu模型类
     'M_MENU_TIP_EXCEED_CHARS'=>'提示字符太长',
     'M_MENU_TITLE_REQUIRED'=>'标题不能为空',
     'M_MENU_SORT_NUMBER'=>'排序值必为数字',
	 'M_CONFIG_NAME'=>'配置名称',
	 'M_CONFIG_NAME_HELP'=>'用于C函数调用，只能使用英文且不能重复',
	 'M_CONFIG_TITLE'=>'配置说明',
	 'M_CONFIG_TITLE_HELP'=>'用于后台显示的配置标题',
	 'M_CONFIG_TYPE'=>'配置类型',
	 'M_CONFIG_TYPE_HELP'=>'系统会根据不同类型解析配置值',
	 'M_CONFIG_REMARK'=>'配置说明',
	 'M_CONFIG_REMARK_HELP'=>'配置详细说明',
	 'M_CONFIG_SORT'=>'排序',
	 'M_CONFIG_SORT_HELP'=>'用于分组显示的顺序',
	 'M_CONFIG_VALUE'=>'配置值',
	 'M_CONFIG_VALUE_HELP'=>'配置值',
	 'M_CONFIG_GROUP'=>'分组',
	 'M_CONFIG_GROUP_HELP'=>'配置分组 用于批量设置 不分组则不会显示在系统设置中',
	 'M_CONFIG_EXTRA'=>'配置项',
	 'M_CONFIG_EXTRA_HELP'=>'如果是枚举型 需要配置该项',
	 'M_MEMBER_REALNAME'=>'用户姓名',
	 'M_MEMBER_USERNAME'=>'登录账号',
	 'M_MEMBER_MOBILE'=>'手机号码',
	 'M_MEMBER_PASSWORD'=>'登录密码',
	 'M_MEMBER_IDNUMBER'=>'身份证号',
	 'M_MEMBER_ORGCODE'=>'机构代码',
	 'M_MEMBER_MOBILE'=>'手机号码',
	 'M_MEMBER_EMAIL'=>'邮箱',
	 'M_MEMBER_NICKAME'=>'昵称',
	 //bank_account
	 'M_BANKACCOUNT_ACCOUNT'=>'银行账户名',
	 'M_BANKACCOUNT_PEPOLENAME'=>'收款人姓名',
	 'M_BANKACCOUNT_BANKNAME'=>'开户银行地址',
	 'M_BANK_URL'=>'银行网站链接',
	 'M_BANK_TYPE'=>'银行类别',
	 'M_BANK_STATUS'=>'账号状态',
	 'M_BANK_USETYPE'=>'账号使用场景',
	 
	 //5-操作结果
	 'RESULT_SUCCESS'=>'操作成功',
	 'RESULT_FAILED'=>'操作失败',
	 
	 //6-页面上的placeholder
	 'PLACEHOLDER_USERNAME'=>'请输入用户名',
	 'PLACEHOLDER_PASSWORD'=>'请输入密码',
	 'PLACEHOLDER_TITLE'=>'请输入标题',
	 'PLACEHOLDER_URL'=>'请输入链接地址',
	 'PLACEHOLDER_NAME'=>'请输入名称',
	 'PLACEHOLDER_VALUE'=>'请输入值',
	 'PLACEHOLDER_EXTRA'=>'请输入配置项',
	 'PLACEHOLDER_BANKACCOUNT_BANKNAME'=>'请输入开户银行名称',
	 'PLACEHOLDER_BANKACCOUNT_PEPOLENAME'=>'请输入开户人姓名',
	 'PLACEHOLDER_BANKACCOUNT_ACCOUNT'=>'请输入卡号',
	 'PLACEHOLDER_BANK_URL'=>'请输入银行网站链接',
	 //7-按钮	 
     'BTN_EXIT'=>'退出',
     'BTN_LOGOUT'=>'登出',
     'BTN_MY_CENTER'=>'个人中心',
     'BTN_MODIFY_PWD'=>'修改密码',
     'BTN_FULLSCREEN'=>'全屏',
     'BTN_DELETE'=>'删除',
     'BTN_EDIT'=>'编辑',
     'BTN_ADD'=>'添加',
     'BTN_SEARCH'=>'查询',
	 'BTN_VIEW'=>'查看',
	 'BTN_SAVE'=>'保存',
	 'BTN_CANCEL'=>'取消',
     'BTN_REGISTER'=>'注册',
     'BTN_LOGIN'=>'登录',
     'BTN_FORGET_PWD'=>'忘记密码了？',
     'BTN_BACK'=>'返回',
     'BTN_BACKUP'=>'立即备份',
     'BTN_TABLE_REPAIR'=>'修复表',
     'BTN_TABLE_OPTIMIZE'=>'优化表',
     'BTN_SELECTED_DELETE'=>'选中项删除',
     'BTN_REDUCTION'=>'还原',
     'BTN_PASS'=>'通过',
     'BTN_NOTPASS'=>'不通过',
     'BTN_RESET_PWD'=>'重置密码',
     'BTN_OPEN'=>'开启',
     'BTN_CLOSE'=>'关闭',
     
	 //控制器内
	 'C_GET_NULLDATA'=>'获取数据出错！',
	 'C_CONFIG'=>'系统配置',
	 //成功
	 'SUC_LOGIN'=>'登录成功',
	 //错误
	 'ERR_DATE_INVALID'=>'日期参数格式错误',
	 'ERR_PARAMETERS'=>'参数错误',
	 'ERR_SYSTEM_BUSY'=>'系统繁忙',
	 'ERR_SESSION_TIMEOUT'=>'会话超时',
	 'ERR_RESET_FAIL'=>'重置密码失败',
	 'ERR_CHANGE_FAIL'=>'修改失败',
	 'ERR_NO_AUTHORITY'=>'非法操作,没有权限',
	 'ERR_SAME_PASSWORD'=>'密码不一致',
	 'ERR_REGISTER_ERROR'=>'注册出错',
	 'ERR_PASSWORD'=>'密码错误',
	 'ERR_NOUSER'=>'用户不存在或禁用',
	 'ERR_LOGIN'=>'登录失败',
	 'ERR_DISABLE_USER'=>'账号被禁用',
	 'ERR_VERIFY'=>'验证码错误',
	 'ERR_PLEASE_LOGIN'=>'请登录之后再操作',
	 //模型验证错误信息
	 'MV_CONFIG_TITLE'=>'配置名称不能为空',
	 'MV_CONFIG_NAME'=>'配置标识不能为空',
	 'MV_CONFIG_GROUP'=>'分组非法',
	 'MV_CONFIG_TYPE'=>'类型非法',
	 //提示
	 'TIP_CONFIG_CHANGE_MUST_CLEAR_CACHE'=>'如果配置更改一般需要5分钟后才能生效，想立即生效的话请清除缓存',
	 'STATUS_NO_BACKUP'=>'未备份',
);