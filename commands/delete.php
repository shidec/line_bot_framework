<?php
	$f = isset($_GET['f']) ? $_GET['f'] : '';
	
	$option = new Option();
	$active_app = $option->get('active_app');
	
	if($active_app != $f && file_exists('apps/' . $f . '.php')){
		unlink('apps/' . $f . '.php');
	}
	
	header('Location: page.php?p=editor');