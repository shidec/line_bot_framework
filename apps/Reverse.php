<?php
	class Reverse extends Line_Apps{
				
		function onfollow(){
			return "Welcome {$this->profile->display_name}";
		}
		
		function onmessage($text){
			return strrev($text);
		}
	}