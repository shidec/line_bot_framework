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
			$profile = check_profile($client, $source['userId']);
			$app = new $active_app($profile);
			$messages = array();
			if($event['type'] == 'follow'){
				$messages = process_messages($app->on_follow());
			}else if($event['type'] == 'message'){
				$messages = process_messages($app->on_message($event['message']['text']));
			}else if($event['type'] == 'postback'){
				$messages = process_messages($app->on_postback($event['postback']['data']));
			}else if($event['type'] == 'unfollow'){
				$app->on_unfollow();
			}
		}
	}
				
	if($messages){
		$client->replyMessage(array(
			'replyToken' => $event['replyToken'],
			'messages' => $messages
		));
	}
	
	
	