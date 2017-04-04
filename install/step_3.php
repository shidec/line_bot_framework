<?php
	if(isset($_POST['btnNext'])){
		$_SESSION['ch_secret'] = $_POST['ch_secret'];
		$_SESSION['ch_token'] = $_POST['ch_token'];
		$_SESSION['step'] = 4;
		header('Location: install.php');
		exit;
	}
?>
<html>
<head>
<title>Installation - Step 3. Channel Secret &amp; Token</title>
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/jquery-3.2.0.min.js"></script>
</head>
<body><br/>
<div class="box">
<h2>Step 3. Channel Secret &amp; Token</h2>
<br/>
<div class="msg">
<ul>
<li>Fill it with Channel Secret &amp; Token you got from Line Messaging API.</li>
<li>You can skip this step and fill it later in Setting Page.</li>
<li>Read about Line Messaging API <a href="https://developers.line.me/messaging-api/getting-started">here</a>.</li>
</ul>
</div>
<form name="formSecret" id="formSecret" method="post">
<table cellpadding="4">
	<tr>
		<td>Channel Secret</td>
		<td><input type="text" size="40" id="ch_secret" name="ch_secret" value=""/></td>
	</tr>
	<tr>
		<td>Channel Access Token</td>
		<td><textarea id="ch_token" cols="38" rows="7" name="ch_token"/></textarea></td>
	</tr>
</table><br/><br/>
<br/>
<input type="submit" name="btnNext" id="btnNext" value="Next" class="button"/>
</form><br/>
</div>
</body>
</html>	
	
	