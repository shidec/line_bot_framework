<?php

	class Session{		
		var $sessionId;
		var $data;
		
		function Session($id){
			$this->sessionId = $id;
			$this->read();
		}
		
		function get($key){
			if($key == 'id'){
				return $this->sessionId;
			}else{
				if(array_key_exists($key, $this->data)){
					return $this->data[$key];
				}else{
					return '';
				}
			}
		}
		
		function set($key, $value){
			$this->data[$key] = $value;
			$this->save();
		}
		
		private function read(){
			$db = new Database();
			$r = $db->query("SELECT * FROM profiles WHERE id = '{$this->sessionId}'");
			if($r->num_rows){
				$dt = $r->fetch_object();
				if($dt->session_data){
					$this->data = unserialize($dt->session_data);
				}else{
					$this->data = array();
				}
			}else{
				$this->data = array();
			}
			$r->free();
			$db->close();
		}
		
		private function save(){
			$data = serialize($this->data);
			$db = new Database();
			$db->query("UPDATE profiles SET session_data = '{$data}' WHERE id = '{$this->sessionId}'");
			$db->close();
		}
	}
