<?php

/**
* 
*/
class MD5
{
	
	function __construct()
	{
		
	}
	
	function extends_md5($source_str,$username,$createtime)
	{
		$string_md5 = md5(md5($source_str).$username.$createtime);
		$front_string = substr($string_md5,0,31);
		$end_string = 's'.$front_string;
		return $end_string;
	}
}


	
	// echo extends_md5("123456","aaaa","1444816206");
	
	