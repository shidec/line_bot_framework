<?php
	if(!file_exists('includes/config.php')){
		header('Location: install.php');
		exit;
	}
	
	session_start();
	
	if(!isset($_SESSION['logged']) || !$_SESSION['logged']){
		header('Location: index.php');
	}
	
	if(isset($_GET['a'])){
		$pages = array('followers', 'editor', 'emulator','setting');
		require_once 'includes/config.php';
		require_once 'includes/helper.php';
		require_once 'classes/Database.php';
		require_once 'classes/Option.php';		
		
		require_once 'commands/' . $_GET['a'] . '.php';
	}
?>