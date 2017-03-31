<?php
	if(!file_exists('includes/config.php')){
		header('Location: install.php');
		exit;
	}
	
	session_start();
	
	if(!isset($_SESSION['logged']) || !$_SESSION['logged']){
		header('Location: index.php');
	}
	
	$p = isset($_GET['p']) ? $_GET['p'] : 'setting';
	
	$pages = array('setting', 'editor', 'emulator');
	
	require_once 'includes/config.php';
	require_once 'includes/helper.php';
	require_once 'classes/Database.php';
	require_once 'classes/Option.php';
?>
<html>
<head>
<title>Bot Framework - Dashboard</title>
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/jquery-3.2.0.min.js"></script>
</head>
<body>
<div id="nav">
	<?php 
		foreach($pages as $pg){
			if($p == $pg){
				echo ucfirst($pg) . ' | ';
			}else{
				echo '<a href="page.php?p=' . $pg . '">' . ucfirst($pg) . '</a> | ';
			}
		}
	?>
	<a href="logout.php">Logout</a>
</div>
<div id="content"><br/>
	<?php include_once 'pages/' . $p . '.php'; ?>
</div>
</body>
</head>