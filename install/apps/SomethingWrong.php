<?php
	class SomethingWrong extends Line_Apps{
				
		function on_follow(){
			$messages[] = "Hello";
			$messages[] = "I just want to show when something going wrong.";
			$messages[] = "Error will displayed in Emulator but it hidden on Line Messenger.";
			$messages[] = "Please type anything you want.";
			return $messages;
		}
		
		function on_message($message){
			//--please dont fix this error
			$messages = 'I\'m invisible :)';
			return $message;
		}
		
		function on_postback($data){
			//--write your code here
		}
	}