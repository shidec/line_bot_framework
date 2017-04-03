<?php
	$app_name = $_POST['appName'];
	$text = $_POST['text'];
	
	file_put_contents('apps/' . $app_name . '.php', $text);
	
	header("Content-type:application/json");	
	echo json_encode(array(
				'result' => 'true',
				'message' => 'File saved.'));