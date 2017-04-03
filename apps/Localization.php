<?php
	class Localization extends Line_Apps{
				
		function on_follow(){
			return "Welcome {$this->profile->display_name}.";
		}
		
		function on_message($text){
			return strrev($text);
		}
	}