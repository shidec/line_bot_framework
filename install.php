<?php
	if(file_exists('includes/config.php')) {
		header('Location: index.php');
		exit;
	}
	
	session_start();
	$step = isset($_SESSION['step']) ? $_SESSION['step'] : '1'; 
	
	if(isset($_GET['a']) && $_GET['a'] == 'run' && $step == 5){
		require_once 'install/run.php';
	}else{
		require_once 'install/step_' . $step . '.php';
	}