<?php
/**
* 
*/
class Person 
{
	private $name;
	private $id;
	function __construct($id = 0,$name = '')
	{
		$this->id = $id;
		$this->name = $name;
	}
	function getName(){
		return $this->name;
	}

	function getId(){
		return $this->id;
	}

	function setName($name){
		$this->name = $name;
	}

	function setId($id){
		$this->id = $id;
	}

}
