<?php
	if(!file_exists('includes/config.php')){
		header('Location: install.php');
		exit;
	}
	
	session_start();
	
	if(!isset($_SESSION['logged']) || !$_SESSION['logged']){
		header('Location: index.php');
	}
	
	$p = isset($_GET['p']) ? $_GET['p'] : 'followers';
	
	$pages = array('followers', 'editor', 'emulator','setting');
	
	require_once 'includes/config.php';
	require_once 'includes/helper.php';
	require_once 'classes/Database.php';
	require_once 'classes/Option.php';
?>
<html>
<head>
<title>Bot Framework - Dashboard</title>
<link rel="stylesheet" href="assets/css/style.css">
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
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
	<a href="command.php?a=logout">Logout</a>
</div>
<div id="content"><br/>
	<?php include_once 'pages/' . $p . '.php'; ?>
	
</div>
</body>
</html>