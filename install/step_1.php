<?php
	$mysqli = function_exists('mysqli_connect');
	$curl = function_exists('curl_init');
	$completed = $mysqli && $curl;
	
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
<script language="javascript">
</script>
</head>
<body><br/>
<div class="box">
<h2>Step 1. System Requirements</h2>
<br/>
<ul>
	<li>Mysqli Library [<?php echo ($mysqli ? '<span class="success">Installed</span>' : '<span class="error">Not Installed</span>'); ?>]</li>
	<li>Curl [<?php echo ($curl ? '<span class="success">Installed</span>' : '<span class="error">Not Installed</span>'); ?>]</li>
</ul>
<br/><br/>
<form method="post" action="" name="frmNext">
<input type="submit" name="submit" value="Next" <?php echo ($completed ? '' : 'disabled="disabled"'); ?> class="button"/>
</form><br/>
</div>
</body>
</html>	
	
	