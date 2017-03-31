<?php
	if(!file_exists('includes/config.php')){
		header('Location: install.php');
		exit;
	}
	
	session_start();
	
	if(isset($_SESSION['logged']) && $_SESSION['logged']){
		$f = isset($_GET['f']) ? $_GET['f'] : '';
		if(file_exists('apps/' . $f . '.php')){
			echo file_get_contents('apps/' . $f . '.php');
		}
	}