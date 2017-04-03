<?php		
	$link = @mysqli_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_passwd'], $_POST['db_database']);
	$result['result'] = $link ? true : false;
	$result['message'] = mysqli_connect_error();
	if($link) mysqli_close($link);
	
	header("Content-type:application/json");
	echo json_encode($result);