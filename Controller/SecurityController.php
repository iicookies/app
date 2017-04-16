<?php
/**
* 接口调用保护策略
*/
 class SecurityController
 {
 		//your own fx
 		public function getValue($seed){
 			return 'prefix'.md5($seed.'#');
 		}

 		public function check(){
 			$data = array('code'=>0);
 			if(isset($_REQUEST['seed']) && isset($_REQUEST['token'])){
 				$seed = trim($_REQUEST['seed']);
 				$token = trim($_REQUEST['token']);
 				if($this->getValue($seed) != $token){
 					$data['code'] = 1;
 				}
 			}else{
 				$data['code'] = 1;
 			}
 			if($data && isset($data['code']) && $data['code'] == 0){
 				return true;
 			}else{
 				return false;
 			}
 		}

 }	
