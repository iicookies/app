<?php
 /**
 * 
 */
 class BaseController 
 {
 	protected $db_tool;
 	protected $security;

 	function __construct()
	{
		if(!$this->db_tool){
			$this->db_tool = new DbTemplate();
		}
		if(!$this->security){
			$this->security = new SecurityController();
		}
	}

 	function jsonOutput($data){
 		echo json_encode($data,true);
 	}

 }
