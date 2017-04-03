<?php
	$f = isset($_GET['f']) ? $_GET['f'] : '';
	$filename = 'apps/' . $f . '.php';
	if(file_exists($filename)){
		header("Content-type:plain/text");
		echo file_get_contents($filename);
		
	}