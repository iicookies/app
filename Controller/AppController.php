<?php

 /**
 * 
 */
 class AppController extends BaseController
 {
 	function version(){
 		$data = array('code'=>0);
		$data['version'] = "1.4";
		$data['url'] = "http://www.mandywed.com/program/ac.exe";
		$this->jsonOutput($data);
 	}
 }
