<?php
require_once('db.php');
$data = array();
if(isset($_REQUEST['name'])){
    $db = new DbTemplate();  
    if(isset($_REQUEST['money']) && isset($_REQUEST['status']) && isset($_REQUEST['time'])){
        $sql = "select id from log where name  = :name  and money = :money ";
        $row = $db->queryRow($sql, array(":name"=>trim($_REQUEST['name']),":money"=>$_REQUEST['money']));  
        if($row){
           $rs = $db->update("update log set status = :status where id = :id",array(":status"=>$_REQUEST['status'],":id"=>$row['ID']));
        }else{
           $rs = $db->update("insert into log(name,type,time,status,create_time,money) values (:name,0,:time,:status,:create_time,:money)",
		   array(":name"=>trim($_REQUEST['name']),":time"=>$_REQUEST['time'],":status"=>$_REQUEST['status'],
		   ":create_time"=>date("Y-m-d H:i:s"),":money"=>$_REQUEST['money']));
        }
        if($rs){
          $data['code'] = 0;
          $data['msg'] = '添加成功';        
        }else{
           $data['code'] = 3;
           $data['msg'] = '系统错误';
        }
    }else{
        $data['code'] = 2;
        $data['msg'] = '请求参数异常';
    }
}else{
    $data['code'] = 1;
    $data['msg'] = '请求参数异常';
}

echo json_encode($data, true);