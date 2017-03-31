<?php
	if(!file_exists('includes/config.php')){
		header('Location: install.php');
		exit;
	}
	
	//--INCLUDES
	$includes = scandir('./includes');
	foreach($includes as $f){
		if($f != '.' && $f != '..'){
			require_once 'includes/' . $f;
		}
	}
	
	//--CLASSES
	require_once 'classes/Database.php';
	require_once 'classes/Line_Apps.php';
	require_once 'classes/LineBot.php';
	require_once 'classes/Session.php';
	require_once 'classes/Option.php';
	
	$option = new Option();
	$active_app = $option->get('active_app');
	$client = new LineBot($option->get('channel_access_token'), $option->get('channel_secret'));
	
	require_once './apps/' . $active_app  . '.php';
	
	
	foreach ($client->parseEvents() as $event) {
		$source = $event['source'];
		if($source['type'] == 'user'){
			$profile = checkProfile($client, $source['userId']);
			$app = new $active_app($profile);
			$messages = array();
			if($event['type'] == 'follow'){
				error_log('a:0');
				$message = $app->onfollow();
				if($message){
					error_log('a:1');
					$messages[] = array(
						'type' => 'text',
						'text' => $message
					);
				}
				break;
			}else if($event['type'] == 'message'){
				$message = $app->onmessage($event['message']['text']);
				if($message){
					$messages[] = array(
						'type' => 'text',
						'text' => $message
					);
				}
				break;
			}else if($event['type'] == 'postback'){
				$message = $app->onpostback($event['postback']['data']);
				if($message){
					$messages[] = array(
						'type' => 'text',
						'text' => $message
					);
				}
				break;
			}else if($event['type'] == 'unfollow'){
				$app->onunfollow();
				break;
			}
		}
	}
				
	if($messages){
		$client->replyMessage(array(
			'replyToken' => $event['replyToken'],
			'messages' => $messages
		));
	}
	
	
	