<?php

/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string
 */
function think_ucenter_md5($str, $key = 'UCenter') {
	return '' === $str ? '' : md5(sha1($str) . $key);
}

/**
 * 获取链接
 * 传入U方法可接受的参数或以http开头的完整链接地址
 * @return 链接地址
 */
function getURL($str, $param = '') {
	if (trim($str) == '#') {
		return '#';
	}
	if (strpos($str, '?') === false) {
		$str = $str . '?' . $param;
	} else {
		$str = $str . '&' . $param;
	}
	if (strpos($str, "http") === 0) {
		return $str;
	}

	return U($str);
}

/**
 * 判断链接是否激活
 * 根据session来检测
 * @return ''|'active'
 */
function isActiveMenuURL($id) {
	$activemenuid = session('activemenuid');
	if ($activemenuid === $id) {
		return 'active';
	}
	return '';
}

/**
 * 判断链接是否激活
 * 根据session来检测
 * @return ''|'active'
 */
function isActiveSubMenuURL($id) {
	$activesubmenuid = session('activesubmenuid');
	if ($activesubmenuid === $id) {
		return 'active';
	}
	return '';
}

// 分析枚举类型配置值 格式 a:名称1,b:名称2
function parse_config_attr($string) {
	$array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
	if (strpos($string, ':')) {
		$value = array();
		foreach ($array as $val) {
			list($k, $v) = explode(':', $val);
			$value[$k] = $v;
		}
	} else {
		$value = $array;
	}
	return $value;
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
	$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	for ($i = 0; $size >= 1024 && $i < 5; $i++)
		$size /= 1024;
	return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 获取存款方式
 */
function getDepositType($type) {
	$depositType = '';
	switch($type) {
		case 0 :
			$depositType = "柜台转帐";
			break;
		case 1 :
			$depositType = "ATM转帐";
			break;
		case 2 :
			$depositType = "网银转帐";
			break;
		case 3 :
			$depositType = "电话转账";
			break;
		case 4 :
			$depositType = "跨行网银转账";
			break;
		case 5 :
			$depositType = "自动终端机";
			break;
		case 6 :
			$depositType = "手机转账";
			break;
		case 7 :
			$depositType = "支付宝转账";
			break;
		case 8 :
			$depositType = "其他方式";
			break;
		default :
			break;
	}

	return $depositType;

}

/**
 * 获取银行卡名称
 * 
 */
function getBankNameBy($type){
	$arr = getBankType($type);
	
	return $arr['name'];
}
/**
 * 获取银行卡类型名称与网站
 */
function getBankType($type) {

	switch($type) {
		case 0 :
			return array('name' => '中国工商银行', 'homepage' => 'http://www.icbc.com.cn');
			break;
		case 1 :
			return array('name' => '中国建设银行', 'homepage' => 'http://www.ccb.com');
			break;
		case 2 :
			return array('name' => '招商银行', 'homepage' => 'http://www.cmbchina.com');
			break;
		case 3 :
			return array('name' => '中国银行', 'homepage' => 'http://www.boc.cn');
			break;
		case 4 :
			return array('name' => '中国邮政储蓄银行', 'homepage' => 'http://www.psbc.com');
			break;
		case 5 :
			return array('name' => '交通银行', 'homepage' => 'http://www.bankcomm.com');
			break;
		case 6 :
			return array('name' => '华夏银行', 'homepage' => 'http://www.hxb.com.cn');
			break;
		case 7 :
			return array('name' => '中信银行', 'homepage' => 'http://bank.ecitic.com');
			break;
		default :
			return array('name' => '未知', 'homepage' => 'http://www.gcg123.com');
			break;
	}
	return array('name' => '未知', 'homepage' => 'http://www.gcg123.com');
}

function refreshSessionUser() {
	
	$result = apiCall('Jjy/Member/getInfo', array(array("uid"=>session("uid"))));
	
	if ($result['status'] && !is_null($result['info'])) {
		$user = array_merge(session("global_user"),$result['info']);
		//存入session
		session('global_user_sign', data_auth_sign($user));
		session('global_user', $user);
	}
}

function getBankAccountUseType($usetype){
	if($usetype == 0){
		return "手动存款";
	}else{
		return "速汇账号";
	}
}



/**
 * PHPExcel类库方式导出
 * @param $data 数组
 * @param $title 标题
 * @param $fileName 导出文件名称
 */
function phpExcelExportRemittanceRecord($data = array(), $header = array(), $fileName='EXPORT',$title) {

	//导入PHPExcel类库
	import("Common.Org.PHPExcel");
	import("Common.Org.PHPExcel.Writer.Excel5");
	import("Common.Org.PHPExcel.IOFactory.php");
	//对数据进行检验
	if (empty($data) || !is_array($data)) {
		die("data must be a array");
	}

	//创建PHPExcel对象，注意，不能少了\
	$objPHPExcel = new \PHPExcel();
	$objProps = $objPHPExcel -> getProperties();

	$objActSheet = $objPHPExcel -> getActiveSheet();
	$objPHPExcel -> getActiveSheet() -> getStyle() -> getFont() -> setName('微软雅黑');
	//设置字体
	$objPHPExcel -> getActiveSheet() -> getDefaultRowDimension() -> setRowHeight(25);
	//设置默认高度

	$objPHPExcel -> getActiveSheet() -> getColumnDimension('A') -> setWidth('5');
	//设置列宽
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('B') -> setWidth('22');
	//设置列宽
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('C') -> setWidth('22');
	//设置列宽
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('D') -> setWidth('22');
	//设置列宽
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('E') -> setWidth('22');
	//设置列宽
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('F') -> setWidth('22');
	//设置列宽
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('G') -> setWidth('22');
	//设置列宽
	$objPHPExcel -> getActiveSheet() -> getColumnDimension('H') -> setWidth('12');
	//设置列宽

	//设置边框
	$sharedStyle1 = new \PHPExcel_Style();
	$sharedStyle1 -> applyFromArray(array('borders' => array('allborders' => array('style' => \PHPExcel_Style_Border::BORDER_THIN))));
	
	$column = 1;
	//设置标题
	$objPHPExcel -> getActiveSheet() -> mergeCells("A{$column}:H{$column}");
	//合并单元格
	$objPHPExcel -> getActiveSheet() -> getStyle("A{$column}:H{$column}") -> getFont() -> setSize(12);
	//字体
	$objPHPExcel -> getActiveSheet() -> getStyle("A{$column}:H{$column}") -> getFont() -> setBold(true);
	//粗体

	//背景色填充
	$objPHPExcel -> getActiveSheet() -> getStyle("A1:H1") -> getFill() -> setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel -> getActiveSheet() -> getStyle("A1:H1") -> getFill() -> getStartColor() -> setARGB('FFB8CCE4');
	//===================================================================================
	
	$objActSheet -> setCellValue('A1', $title);
	
	++$column;
	$span = ord("A");
	foreach ($header as $key => $row) {
		// 列写入
		$j = chr($span);
		$objActSheet -> setCellValue($j . $column, $row);
		$span++;
	}
	
	++$column;
	foreach ($data as $key => $row) {
		
		//垂直居中
		$objPHPExcel -> getActiveSheet() -> getStyle("A{$column}:J{$column}") -> getAlignment() -> setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//换行
		$objPHPExcel -> getActiveSheet() -> getStyle("A{$column}:J{$column}") -> getAlignment() -> setWrapText(true);
		
		$span = ord("A");
		foreach ($row as $keyName => $value) {
			// 列写入
			$j = chr($span);
			$objActSheet -> setCellValue($j . $column, $value);
			$span++;
		}
		$column++;

	}

	$fileName = iconv("utf-8", "gb2312", $fileName);
	//设置活动单指数到第一个表,所以Excel打开这是第一个表
	$objPHPExcel -> setActiveSheetIndex(0);
	//创建人
	$objPHPExcel -> getProperties() -> setCreator("绍兴古睿信息科技有限公司");
	//最后修改人
	$objPHPExcel -> getProperties() -> setLastModifiedBy("绍兴古睿信息科技有限公司");
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename=\"$fileName\"");
	header('Cache-Control: max-age=0');
	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter -> save('php://output');
	//文件通过浏览器下载
	exit ;

}

