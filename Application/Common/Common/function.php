<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------
/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 */
function is_login() {
	$user = session('global_user');
	if (empty($user)) {
		return 0;
	} else {
		return session('global_user_sign') == data_auth_sign($user) ? session('uid') : 0;
	}
}

/**
 * 检测当前用户是否为管理员
 * @return boolean true-管理员，false-非管理员
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function is_administrator($uid = null) {
	$uid = is_null($uid) ? is_login() : $uid;
	return $uid && (intval($uid) === C('USER_ADMINISTRATOR'));
}

/**
 * apiCall
 */
function apiCall($url, $vars, $layer = 'Api') {
	//TODO:考虑使用func_get_args 获取参数数组
	return R($url, $vars, $layer);
}

/**
 * 记录日志，系统运行过程中可能产生的日志
 * Level取值如下：
 * EMERG 严重错误，导致系统崩溃无法使用
 * ALERT 警戒性错误， 必须被立即修改的错误
 * CRIT 临界值错误， 超过临界值的错误
 * WARN 警告性错误， 需要发出警告的错误
 * ERR 一般性错误
 * NOTICE 通知，程序可以运行但是还不够完美的错误
 * INFO 信息，程序输出信息
 * DEBUG 调试，用于调试信息
 * SQL SQL语句，该级别只在调试模式开启时有效
 */
function LogRecord($msg, $location, $level = 'ERR') {
	Think\Log::write($location . $msg, $level);
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 */
function data_auth_sign($data) {
	//数据类型检测
	if (!is_array($data)) {
		$data = (array)$data;
	}
	ksort($data);
	//排序
	$code = http_build_query($data);
	//url编码并生成query字符串
	$sign = sha1($code);
	//生成签名
	return $sign;
}

/**
 * 获取一个日期时间段
 * 如果有查询参数包含startdatetime，enddatetime，则优先使用否则生成
 * @param $type 0|1|2|其它
 * @return array("0"=>开始日期,"1"=>结束日期)
 */
function getDataRange($type) {
	$result = array();
	switch($type) {
		case 0 :
			//今天之内
			$result['0'] = I('startdatetime', date('Y/m/d 00:00', time()), 'urldecode');
			break;
		case 1 :
			//昨天
			$result['0'] = I('startdatetime', date('Y/m/d 00:00:00', time() - 24 * 3600), 'urldecode');
			$result['1'] = I('enddatetime', date('Y/m/d 00:00:00', time()), 'urldecode');
			break;
		case 2 :
			//最近7天
			$result['0'] = I('startdatetime', date('Y/m/d H:i:s', time() - 24 * 3600 * 7), 'urldecode');
			break;
		case 3 :
			//最近30天
			$result['0'] = I('startdatetime', date('Y/m/d H:i:s', time() - 24 * 3600 * 30), 'urldecode');
			break;
		default :
			$result['0'] = I('startdatetime', date('Y/m/d 00:00:00', time() - 24 * 3600), 'urldecode');
			break;
	}
	if (!isset($result['1'])) {
		$result['1'] = I('enddatetime', date('Y/m/d H:i:s', time() + 10), 'urldecode');
	}
	return $result;
}

/**
 * 返回 是|否
 * @param $param 一个值|对象等
 * @return 空|false|0 时返回否，否则返回是
 */
function yesorno($param) {
	if (is_null($param) || $param === false || $param == 0 || $param == "0") {
		return L("NO");
	} else {
		return L('YES');
	}
}

/**
 * 返回数据状态的含义
 * @status $status 一个数字 -1,0,1,2,3 其它值都是未知
 * @return 描述字符串
 */
function getStatus($status) {
	$desc = '未知状态';
	switch($status) {
		case -1 :
			$desc = "已删除";
			break;
		case 0 :
			$desc = "禁用";
			break;
		case 1 :
			$desc = "正常";
			break;
		case 2 :
			$desc = "待审核";
			break;
		case 3 :
			$desc = "通过";
			break;
		case 4 :
			$desc = "不通过";
			break;
		default :
			break;
	}
	return $desc;
}

/**
 * 导出数据为excel表格
 *@param $data    一个二维数组,结构如同从数据库查出来的数组
 *@param $title   excel的第一行标题,一个数组,如果为空则没有标题
 *@param $filename 下载的文件名
 *@param $type 0=普通 1=phpexcel库导出
 *@examlpe
 $stu = M ('User');
 $arr = $stu -> select();
 exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
 */
function exportToExcel($data = array(), $title = array(), $filename = 'report') {

	header("Content-type:application/octet-stream");
	header("Accept-Ranges:bytes");
	header("Content-type:application/vnd.ms-excel");
	header("Content-Disposition:attachment;filename=" . $filename . ".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	//导出xls 开始
	if (!empty($title)) {
		foreach ($title as $k => $v) {
			$title[$k] = iconv("UTF-8", "GB2312//IGNORE", $v);
		}
		$title = implode("\t", $title);
		echo "$title\n";
	}
	if (!empty($data)) {
		foreach ($data as $key => $val) {
			foreach ($val as $ck => $cv) {
				$data[$key][$ck] = iconv("UTF-8", "GB2312//IGNORE", $cv);
			}
			$data[$key] = implode("\t", $data[$key]);

		}
		echo implode("\n", $data);
	}

}

