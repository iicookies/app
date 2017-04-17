<?php

 /**
 * 
 */
 class TestController extends BaseController
 {
 	function http(){
		$password = md5("onlyzcx");
		$seed = time();
		$token = $this->security->getValue($seed);
		$data = array(
			// 'C'=>'App',
			// 'M'=>'version',
			'C'=>'User',
			'M'=>'checkName',
			'name'=>'iicookies',
			'passwd'=> $password,
			'seed'=>$seed,
			'token' => $token
		);
		$str = http_build_query($data);
		#echo $str;
		 $ret = $this->request_by_curl("127.0.0.1/app/index.php",$str);

		 if(!empty($ret)){
		 	//echo $ret;
			$result = json_decode($ret,true);

			/*
			if($result['data'] != null){
				while(list($key,$val)= each($result['data'])) { 
					$result[$key] = $val;
				}
			}
			unset($result['data']);
			*/
			$this->jsonOutput($result);
		 }else{
			unset($result['data']);
			 echo $ret; 
		 }
 	}
 	function json(){
		$password = md5("#123456gugu");
		$data = array(
			'faceid'=>'001',
			'param'=>"{\"phone\":\"1393****780\",\"password\":\"$password\"}",
		);
		 $str = json_encode($data);
		 $ret = $this->request_by_curl("127.0.0.1/app/?C=User&M=check",$str);
		 if(!empty($ret)){
			$result = json_decode($ret,true);
			/*
			if($result['data'] != null){
				while(list($key,$val)= each($result['data'])) { 
					$result[$key] = $val;
				}
			}
			unset($result['data']);
			*/
			$this->jsonOutput($result);
		 }else{
			unset($result['data']);
			 echo $ret; 
		 }
 	}
	/** 
	* Curl版本 
	* 使用方法： 
	* $post_string = "app=request&version=beta"; 
	* request_by_curl('http://facebook.cn/restServer.php',$post_string); 
	*/
	function request_by_curl($remote_server, $post_string)
	{    
		$ch = curl_init();    
		// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		// 'Content-Type:text/html;charset=utf-8',
		// 'Content-Length: '.strlen($post_string))
		// );
		curl_setopt($ch, CURLOPT_URL, $remote_server);    
		curl_setopt($ch, CURLOPT_POSTFIELDS,  $post_string);    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
		curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_HEADER, 0);  
		//curl_setopt($ch, CURLOPT_USERAGENT, "Jimmy's CURL Example beta");    
		$data = curl_exec($ch);    
		curl_close($ch);    
		return $data;
	} 
 }
