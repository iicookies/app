<?php
 /**
 * 
 */
 class BaseController 
 {
 	protected $db_tool;

 	function __construct()
	{
		if(!$this->db_tool){
			$this->db_tool = new DbTemplate();
		}
	}

 	function jsonOutput($data){
 		echo json_encode($data,true);
 	}

 }
