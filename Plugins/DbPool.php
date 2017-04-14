<?php
require_once("DbConfig.php");
/**
* 
*/
class DbPool
{
   private static $initPoolSize = 5;
   private static $maxPoolSize = 20;
   private static $connectTime = 120;
   private static $container = array();
   private static $init = false;
   private static function createConn($transaction = false){
   		$conn = new PDO(DbConfig::getDsn(), DbConfig::getUsername(), DbConfig::getPassword());
    	$conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->setAttribute(PDO::ATTR_AUTOCOMMIT, $transaction ? 0 : 1);
    	return $conn;
   }
   private static function autoInit(){
		while(count(self::$container) < self::$initPoolSize){
			$data = array();
			$data['conn'] = self::createConn();
			$data['busy'] = false; //是否可用
			$data['auto'] = true; //自动提交
			$data['time'] = time(); //创建时间
			self::$container[uniqid()] = $data;
		}
   }
   private static function autoReset($data){
		//判断是否超时
		if(isset($data['time'])){
			if(time()-$data['time'] >= self::$connectTime){
				//超时重置
				$c = $data['conn'];
				$c = null;
				$data['conn'] = self::createConn($transaction);
				$data['time'] = time();
				$data['busy'] = false;
			}
		}
		return $data;
   }
   	public static function getConn($transaction = false){
   		#error_log(1);
		if(!self::$init){
			self::autoInit();
			self::$init = true;
		}
		#error_log(2);
		$conn = null;
		foreach (self::$container as $data) {
			if($data['busy'] == true){
				$data = self::autoReset($data);
				continue;
			}else{
				$data = self::autoReset($data);
				if(isset($data['conn']) && $data['conn'] != null){
					$data['busy'] = true;
					$data['auto'] =  $transaction ? false : true; //自动提交
					$data['conn']->setAttribute(PDO::ATTR_AUTOCOMMIT, $transaction == true ? 0 : 1);
				 	$conn = $data['conn'];
				}
				break;
			}
		}
		if($conn == null){
			if(count(self::$container) < self::$maxPoolSize){
				$data = array();
				$data['conn'] = self::createConn($transaction);
				$data['busy'] = false; //是否可用
				$data['auto'] =  $transaction == true ? false : true; //自动提交
				$data['time'] = time(); //创建时间
				self::$container[uniqid()] = $data;
				$conn = $data['conn'];
			}else{
				return null;
			}
		}
		return $conn;
	}
	public static function releaseConn($id){
		if($id && is_array(self::$container) && array_key_exists($id, self::$container)){
			$data = self::$container[$id];
			$c = $data['conn'];
			$c = null;
			self::$container[$id] = null;
		}
	}
}


	
	