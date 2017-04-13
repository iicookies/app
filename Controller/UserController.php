<?php

/**
* 
*/
class UserController extends BaseController
{
	

	function __construct()
	{
		parent::__construct();
	}

	function checkName(){
		$data = array('code'=>0);
		if(isset($_REQUEST['name'])){
			$name = trim($_REQUEST['name']);
			$param = array(':name'=>$name);
			$sql = "select id from user where name = :name";
			$row = $this->$db_tool->queryRow($sql,$param);
			if($row){
				$data = array_merge($data,$row);
				$data['code'] = 2;
				$data['msg'] = "用户名已存在";
			}else{
				$data['code'] = 0;
				$data['msg'] = "用户名不存在可以创建";
			}
		}else{
			$data['code'] = 1;
			$data['msg'] = "参数错误";
		}
		$this->jsonOutput($data);
	}


	function register(){
		$data = array('code'=>0);
		if(isset($_REQUEST['name']) && isset($_REQUEST['passwd']) && isset($_REQUEST['expiration']) && isset($_REQUEST['serial_num'])){
			$name = trim($_REQUEST['name']);
			$passwd = trim($_REQUEST['passwd']);
			$expiration = trim($_REQUEST['expiration']);
			$serial_num = trim($_REQUEST['serial_num']);
			$param = array(':name'=>$name , ':passwd'=>$passwd, ':expiration'=>$expiration, 'serial_num'=>$serial_num);
			$sql = "insert into user(name,passwd,expiration,serial_num) values(:name,:passwd,:expiration,:serial_num) ";
			$row = $this->$db_tool->update($sql,$param);
			if($row){
				$data['code'] = 0;
          		$data['msg'] = '添加成功'; 
			}else{
 				$data['code'] = 3;
           		$data['msg'] = '系统错误';
			}
		}else{
			$data['code'] = 1;
			$data['msg'] = "参数错误";
		}
		$this->jsonOutput($data);
	}



	function check(){
		$data = array('code'=>0);

		if(isset($_REQUEST['name']) && isset($_REQUEST['passwd'])){

			$name = trim($_REQUEST['name']);
			$passwd = trim($_REQUEST['passwd']);
			$param = array(':name'=>$name , ':passwd'=>$passwd);
			$sql = "select id,name,expiration,task,serial_num from user where name = :name and passwd = :passwd";
			$row = $this->$db_tool->queryRow($sql,$param);
			if($row){
				$data = array_merge($data,$row);
			}else{
				$data['code'] = 2;
				$data['msg'] = "用户名或密码错误";
			}
		}else{
			$data['code'] = 1;
			$data['msg'] = "参数错误";
		}


		$this->jsonOutput($data);
	}

	function test(){
		echo "test";
	}


}