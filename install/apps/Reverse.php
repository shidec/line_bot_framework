<?php
	class Reverse extends Line_Apps{
				
		function on_follow(){
			return "Welcome {$this->profile->display_name}.\nThis bot will respond with reversed words.";
		}
		
		function on_message($message){
			return strrev($message['text']);
		}
	}