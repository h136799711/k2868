<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Ucenter\Api;

abstract class Api {

	/**
	 * API调用模型实例
	 * @access  protected
	 * @var object
	 */
	protected $model;

	/**
	 * 构造方法，检测相关配置
	 */
	public function __construct() {
		$this -> _init();
	}

	/**
	 * 抽象方法，用于设置模型实例
	 */
	abstract protected function _init();
	
	/**
	 * 返回错误结构
	 * @return array('status'=>boolean,'info'=>Object)
	 */
	protected function apiReturnErr($info){
		return array('status'=>false,'info'=>$info);
	}
	/**
	 * 返回成功结构
	 * @return array('status'=>boolean,'info'=>Object)
	 */
	protected function apiReturnSuc($info){
		return array('status'=>true,'info'=>$info);
	}
	
	/**
	 * 返回结构
	 * @return array('status'=>boolean,'info'=>Object)
	 */
	protected function apiReturn($status,$info){
		return array('status'=>$status,'info'=>$info);
	}

	/**
	 * get model
	 */
	public function getModel() {
		return $this -> model;
	}

	/**
	 * 禁用
	 * 必须有status字段 ，－1 为禁用状态
	 */
	public function disable($map) {
		return $this -> save($map, array('status' => -1));
	}

	/**
	 * 启用
	 * 必须有status字段，1 为启用状态
	 */
	public function enable($map) {
		return $this -> save($map, array('status' => 1));
	}

	/**
	 * 假删除
	 * 必须有status字段，且 －2 为删除状态
	 */
	public function pretendDelete($map) {
		return $this -> save($map, array('status' =>   －2));
	}

	/**
	 * 根据id保存数据
	 */
	public function saveByID($ID, $entity) {
		unset($entity['id']);
		
		return $this -> save(array('id' => $ID), $entity);
	}

	/**
	 * 保存
	 * @return status|boolean , info 错误信息或更新条数
	 */
	public function save($map, $entity) {
//		dump($entity);
//		dump($map);
//		exit();
		$result = $this -> model -> where($map) -> save($entity);
		if ($result === false) {
			$error = $this -> model -> getDbError();
			return $this->apiReturnErr($error);
		} else {
			return $this->apiReturnSuc($result);
		}
	}

	/**
	 * 获取数据find
	 */
	public function getInfo($map) {
		$result = $this -> model -> where($map) -> find();
		if ($result === false) {
			$error = $this -> model -> getDbError();
			return $this->apiReturnErr($error);
		} else {
			return $this->apiReturnSuc($result);
		}
	}

	/**
	 * 删除
	 * @map 条件
	 * @result array('status'=>'false|true',$info=>'错误信息|删除数据数')
	 */
	public function delete($map) {
		//		dump($map);
		//		exit();
		$result = $this -> model -> where($map) -> delete();
		if ($result === false) {
			$error = $this -> model -> getDbError();
			return $this->apiReturnErr($error);
		} else {
			return $this->apiReturnSuc($result);
		}
	}

	/**
	 * add 添加
	 * @return boolean |
	 */
	public function add($menu) {

		$result = $this -> model -> create($menu);

		if ($result === false) {
			$error = $this -> model -> getError();
			return $this->apiReturnErr($error);
		} else {
			$result = $this -> model -> add();
			if ($result === false) {
				return $this->apiReturnErr($this -> model -> getDbError());
			}
			return $this->apiReturnSuc($result);
		}
	}

	/**
	 * query 不分页
	 * @param $map 查询条件
	 * @param $order 排序条件
	 * @param $fields 只获取指定字段
	 */
	public function queryNoPaging($map, $order = false, $fields = false) {

		if ($order === false) {
			if ($fields === false) {
				$list = $this -> model -> where($map) -> select();
			} else {
				$list = $this -> model -> field($fields) -> where($map) -> select();
			}
		} else {
			if ($fields === false) {
				$list = $this -> model -> where($map) -> order($order) -> select();
			} else {
				$list = $this -> model -> field($fields) -> where($map) -> order($order) -> select();
			}

		}
		if ($list === false) {
			$error = $this -> model -> getDbError();
			return $this->apiReturnErr($error);
		}

		return $this->apiReturnSuc($list);

	}

	/**
	 * query
	 * @param map 查询条件
	 * @param page 分页参数
	 * @param order 排序参数
	 * @param params 点击分页时带参数
	 */
	public function query($map, $page = array('curpage'=>0,'size'=>10), $order = false, $params = false) {
		
		if ($order === false) {
			$list = $this -> model -> where($map) -> page($page['curpage'] . ',' . $page['size']) -> select();
		} else {
			$list = $this -> model -> where($map) -> order($order) -> page($page['curpage'] . ',' . $page['size']) -> select();
		}
		if ($list === false) {
			$error = $this -> model -> getDbError();
			return $this->apiReturnErr($error);
		}

		$count = $this -> model -> where($map) -> count();
		// 查询满足要求的总记录数
		$Page = new \Think\Page($count, $page['size']);

		//分页跳转的时候保证查询条件
		if ($params !== false) {
			foreach ($params as $key => $val) {
				$Page -> parameter[$key] = urlencode($val);
			}
		}

		// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page -> show();

		return $this->apiReturnSuc(array("show" => $show, "list" => $list));
	}

}
