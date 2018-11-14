<?php
	class Line_Apps{
		
		var $session;
		var $data;
		var $bot;
		
		public function __construct($profile, $bot = null){
			$this->bot = $bot;
			$this->profile = $profile;
			$this->session = new Session($profile->id);
			$data = $this->session->get('data');
			if(!$data){
				$this->init();
			}else{
				$this->data = unserialize($this->session->get('data'));
			}
		}
		
		protected function init(){
			$this->save();
		}
		
		protected function save(){
			$this->session->set('data', serialize($this->data));
		}
		
		function on_follow(){
			
		}
		
		function on_message($message){
			
		}
		
		function on_postback($data){
			
		}
		
		function on_unfollow(){
			$db = new Database();
			$db->query('UPDATE profiles SET `following` = 0 WHERE id = ' . $this->profile->id);
			$db->close();
		}
	}