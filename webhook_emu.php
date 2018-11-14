<?php
	if(!file_exists('includes/config.php')){
		header('Location: install.php');
		exit;
	}
	
	ini_set('display_errors', '1');
	
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
	require_once 'classes/Session.php';
	require_once 'classes/Option.php';

	$option = new Option();
	$active_app = $option->get('active_app');

	require_once './apps/' . $active_app  . '.php';
	
	if(isset($_POST['events'])){
		$messages = array();
		foreach($_POST['events'] as $event){

			$source = $event['source'];

			if($source['type'] == 'user'){
				$profile = emu_profile();
				$app = new $active_app($profile);

				if($event['type'] == 'follow'){
					$messages = process_messages($app->on_follow());
				}else if($event['type'] == 'message'){
					$messages = process_messages($app->on_message($event['message']));
				}else if($event['type'] == 'postback'){
					$messages = process_messages($app->on_postback($event['postback']['data']));
				}else if($event['type'] == 'unfollow'){
					$app->on_unfollow();
				}
			}
		}

		//header("Content-type:application/json");
		echo json_encode(array(
			'replyToken' => $event['replyToken'],
			'messages' => $messages
		));
	}

