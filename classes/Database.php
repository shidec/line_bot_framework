<?php

class Database{	
	
	public function __construct(){
		$this->mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_DATABASE);
	}
	
	function query($sql){
		return mysqli_query($this->mysqli, $sql);		
	}
	
	function close(){
		$this->mysqli->close();
	}
	
	function escape($param){
		return $this->mysqli->real_escape_string($param);
	}
}