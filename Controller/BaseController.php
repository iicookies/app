<?php

 /**
 * 
 */
 class BaseController 
 {
 	 
	protected static $db_tool;
 	function __construct()
 	{
 		if(!self::$db_tool){
 			self::$db_tool = new DbTemplate();
 		}
 	}

 	function jsonOutput($data){
 		echo json_encode($data,true);
 	}


 }
