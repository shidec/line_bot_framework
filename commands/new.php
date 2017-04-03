<?php
	$app_name = $_POST['appName'];
	$text = '<?php
	class ' . $app_name . ' extends Line_Apps{
				
		function on_follow(){
			//--write your code here
		}
		
		function on_message($text){
			//--write your code here
		}
		
		function on_postback($data){
			//--write your code here
		}
	}';
	
	file_put_contents('apps/' . $app_name . '.php', $text);
	
	header("Content-type:application/json");	
	echo json_encode(array(
				'result' => 'true',
				'message' => 'File saved.'));