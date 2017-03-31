<?php

	class Option{
		
		var $data;
		function Option(){
			$this->read();
		}
		
		function get($key){
			if(array_key_exists($key, $this->data)){
				return $this->data[$key];
			}else{
				return '';
			}
		}
		
		function set($key, $value){
			$this->data[$key] = $value;
			$db = new Database();
			$r = $db->query("SELECT * FROM options WHERE option_name = '{$key}'");
			if($r->num_rows){
				$db->query("UPDATE options SET option_value = '{$value}' WHERE option_name = '{$key}'");
			}else{
				$db->query("INSERT INTO options (option_name, option_value) VALUES ('{$key}','{$value}')");
			}
			$r->free();
			$db->close();
		}
		
		private function read(){
			$this->data = array();
			$db = new Database();
			$r = $db->query("SELECT * FROM options");
			if($r->num_rows){
				while($dt = $r->fetch_object()){
					$this->data[$dt->option_name] = $dt->option_value;
				}
			}
			$r->free();
			$db->close();
		}
	}
