<?php

 /**
 * 
 */
 class CardController extends BaseController
 {
 	function __construct()
	{
		parent::__construct();
	}


	function getCard(){
		$data = array('code'=>0);
		if(!$this->security->check()){
			$data['code'] = 1;
			$data['msg'] = "参数错误";
			$this->jsonOutput($data);
			return;
		} 
		if (isset($_REQUEST['card_no']) && isset($_REQUEST['card_passwd'])) {
			$card_no = trim($_REQUEST['card_no']);
			$card_passwd = trim($_REQUEST['card_passwd']);
			$param = array(':card_no'=>$card_no , ':card_passwd' => $card_passwd);
			$sql = "select card_id,card_type from card where card_no = :card_no and card_passwd = :card_passwd and status = 0";
			$row = $this->db_tool->queryRow($sql,$param);
			if($row){
				$data = array_merge($data,$row);
				$data['msg'] = "";
			}else{
				$data['code'] = 2;
				$data['msg'] = "用户名不存在可以创建";
			}
		}else{
			$data['code'] = 1;
			$data['msg'] = "参数错误";
		}
		$this->jsonOutput($data);
	}

	function recharge(){
		$data = array('code'=>0);
		if(!$this->security->check()){
			$data['code'] = 1;
			$data['msg'] = "参数错误";
			$this->jsonOutput($data);
			return;
		} 		
		if(isset($_REQUEST['uname']) && isset($_REQUEST['card_id']) && isset($_REQUEST['card_type']) ){
			$uname = trim($_REQUEST['uname']);
			$card_id = trim($_REQUEST['card_id']);
			$card_type = trim($_REQUEST['card_type']);
			#error_log($card_type);
			$conn = $this->db_tool->getConnection();
			$conn->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
			$conn->beginTransaction();
			try {
				$stmt = $conn->prepare("update card set status=1,uname= :uname,utime = now() where card_id = :card_id");
		        $stmt->execute(array(':uname' => $uname,':card_id' => $card_id));
		        $affected_rows = $stmt->rowCount();
		        if(!$affected_rows)
					throw new PDOException("失败1");
				if($card_type != null){
					$sql = "";
					if($card_type == "1"){
						$sql = "update user set expiration = DATE_ADD(expiration,INTERVAL 1 YEAR) where name = :uname";
					}else if ($card_type == "0"){
						$sql = "update user set expiration = DATE_ADD(expiration,INTERVAL 1 MONTH) where name = :uname";
					}else{
						throw new PDOException("失败2");
					}
					$stmt = $conn->prepare($sql);
			        $stmt->execute(array(':uname' => $uname));
			        $affected_rows = $stmt->rowCount();
			        if(!$affected_rows)
						throw new PDOException("失败3");					

				}else{
					throw new PDOException("失败4");
				}
				$conn->commit();
				$data['code'] = 0;
          		$data['msg'] = '添加成功'; 
			} catch (PDOException $e) {
				$conn->rollback();
				$data['code'] = 3;
           		$data['msg'] = '系统错误' . $e->getMessage();
			}
			$conn->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
		}else{
			$data['code'] = 1;
			$data['msg'] = "参数错误";
		}
		$this->jsonOutput($data);
	}

 }
