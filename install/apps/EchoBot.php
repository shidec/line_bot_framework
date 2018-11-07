<?php
	class EchoBot extends Line_Apps{
				
		function on_follow(){
			return "Hi!";
		}
		
		function on_message($message){
			return "Echo: " . $message['text'];
		}
	}