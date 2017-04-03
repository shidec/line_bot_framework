<?php
	$mysqli = function_exists('mysqli_connect');
	$curl = function_exists('curl_init');
	$includes = is_writable('includes');
	$apps = is_writable('apps');
	$completed = $mysqli && $curl && $includes && $apps;
	
	if($completed && isset($_POST['submit'])){
		$_SESSION['step'] = 2;
		header('Location: install.php');
		exit;
	}
?>
<html>
<head>
<title>Installation - Step 1. System Requirements</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body><br/>
<div class="box">
<h2>Step 1. System Requirements</h2>
<br/>
<ul>
	<li>Mysqli Library [<?php echo ($mysqli ? '<span class="success">Installed</span>' : '<span class="error">Not Installed</span>'); ?>]</li>
	<li>Curl [<?php echo ($curl ? '<span class="success">Installed</span>' : '<span class="error">Not Installed</span>'); ?>]</li>
	<li>'includes' directory is writable [<?php echo ($includes ? '<span class="success">Yes</span>' : '<span class="error">No</span>'); ?>]</li>
	<li>'apps' directory is writable [<?php echo ($apps ? '<span class="success">Yes</span>' : '<span class="error">No</span>'); ?>]</li>
</ul>
<br/><br/>
<form method="post" action="" name="frmNext">
<input type="submit" name="submit" value="Next" <?php echo ($completed ? '' : 'disabled="disabled"'); ?> class="button"/>
</form><br/>
</div>
</body>
</html>	
	
	