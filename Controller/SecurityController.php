<?php
 session_start();
 class SecurityController extends BaseController
 {


 		public function getSeed(){
 			$data = array('code'=>0);
 			$time = time();
 			$_SESSION[$time] = $this->getValue($time);
 			$data['seed'] = $time;
 			$this->jsonOutput($data);
 		}
 		//your own fx
 		private function getValue($seed){
 			return 'SmartPHP'.md5($seed);
 		}

 		public function check(){
 			$data = array('code'=>0);
 			if(isset($_REQUEST['seed']) && isset($_REQUEST['token'])){
 				$seed = trim($_REQUEST['seed']);
 				$token = trim($_REQUEST['token']);
 				if(isset($_SESSION[$seed])){
	 				if($_SESSION[$seed] == $token){
	 					$data['msg'] = '校验成功';
	 				}else{
	 					$data['code'] = 2;
	 					$data['msg'] = '验证失败';
	 				} 					
 					unset($_SESSION[$seed]);
 				}else{
 					$data['code'] = 3;
					$data['msg'] = "系统错误";
 				}
 			}else{
 				$data['code'] = 1;
				$data['msg'] = "参数错误";
 			}
 			#$this->jsonOutput($data);
 			if($data && isset($data['code']) && $data['code'] == 0){
 				return true;
 			}else{
 				return false;
 			}
 		}

 }	
