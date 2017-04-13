<?php

/**
* 
*/
class DbPool
{
   private static $initPoolSize = 5;
   private static $maxPoolSize = 20;
   private static $connectTime = 120;
   public static $container = array();
   public static $init = false;
   private static function createConn($transaction = false){
   		$conn = new PDO(DbConfig::getDsn(), DbConfig::getUsername(), DbConfig::getPassword());
    	$conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER, PDO::ERRMODE_EXCEPTION);
		$conn->setAttribute(PDO::ATTR_AUTOCOMMIT, $transaction == true ? 0 : 1);
    	return $conn;
   }
   private static function autoInit(){
		while(count(self::$container) < $initPoolSize){
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
    private function __construct()
	{
		#self::autoInit();
	}

	public static function release($id){
		if(isset(self::$container[''.$id]){
			$data = self::$container[''.$id];
			$c = $data['conn'];
			$c = null;
			self::$container[''.$id] = null;
		}
	}


	public static function getConn($transaction = false){

		if(!self::$init){
			self::autoInit();
			self::$init = true;
		}

		$conn = null;
		foreach ($container as $data) {
			if($data['busy'] == true){
				$data = self::autoReset($data);
				continue;
			}else{
				$data = self::autoReset($data);
				if(isset($data['conn']) && $data['conn'] != null){
					$data['busy'] = true;
					$data['auto'] =  $transaction == true ? false : true; //自动提交
					$data['conn']->setAttribute(PDO::ATTR_AUTOCOMMIT, $transaction == true ? 0 : 1);
				 	$conn = $data['conn'];
				}
				break;
			}
		}
		if($conn == null){
			if(count(self::$container) < $maxPoolSize){
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
}


	
	