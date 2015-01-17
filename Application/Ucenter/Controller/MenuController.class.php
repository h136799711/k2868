<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2015, http://www.gooraye.net. All Rights Reserved.
// |-----------------------------------------------------------------------------------

namespace Ucenter\Controller;

class MenuController extends UcenterController {

	protected function _initialize() {
		parent::_initialize();
		//
		if (I('get.pid', 0) != 0) {
			$result = apiCall("Ucenter/Menu/getInfo", array( array('id' => I('get.pid'))));
			if ($result['status']) {
				$this -> assign('parentMenu', $result['info']);
			} else {
				LogRecord('INFO:' . $result['info'], '[FILE] ' . __FILE__ . ' [LINE] ' . __LINE__);
				$this -> error(L('UNKNOWN_ERR'));
			}
		}
	}

	/**
	 * 菜单
	 */
	public function index() {
		$map = array();
		$map['pid'] = I('get.pid', 0);

		$page = array('curpage' => I('get.p', 0), 'size' => C('LIST_ROWS'));
		$order = "sort desc";
		$result = apiCall("Ucenter/Menu/query", array($map, $page, $order));

		parent::queryResult($result);

	}

	/**
	 * 保存
	 */
	public function save() {
		parent::save(U('Ucenter/Menu/index', array('pid' => I('post.pid', 0))));
	}

	/**
	 * 增加菜单
	 */
	public function add() {
		if(IS_GET){
			$this->display();
		}else{
			$menu = I('post.');
			$menu['pid'] = I('get.pid', 0);
			parent::add($menu, U('Ucenter/Menu/index', array('pid' => I('post.pid', 0))));
		}
	}

	/**
	 * 删除菜单
	 */
	public function delete() {
		parent::delete(U('Ucenter/Menu/index', array('pid' => I('post.pid', 0))));
	}

}
