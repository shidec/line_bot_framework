<?php
	if(isset($_POST['ch_secret'])){
		if($_POST['ch_secret'] && $_POST['ch_token']){
			$_SESSION['ch_secret'] = $_POST['ch_secret'];
			$_SESSION['ch_token'] = $_POST['ch_token'];
			$_SESSION['step'] = 4;
			header('Location: install.php');
			exit;
		}
	}
?>
<html>
<head>
<title>Installation - Step 3. Channel Secret &amp; Token</title>
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/jquery-3.2.0.min.js"></script>
<script language="javascript">
	$(document).ready(function(){
		$('#btnNext').click(function(){
			if($('#ch_secret').val().trim() == ''){
				alert('Channel Secret required.');
				$('#ch_secret').focus();
				return false;
			}
			if($('#ch_token').val().trim() == ''){
				alert('Channel Access Token required.');
				$('#ch_token').focus();
				return false;
			}
			$('#formSecret').submit();
		});
	});
</script>
</head>
<body><br/>
<div class="box">
<h2>Step 3. Channel Secret &amp; Token</h2>
<br/>
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
<input type="button" name="btnNext" id="btnNext" value="Next" class="button"/>
</form><br/>
</div>
</body>
</html>	
	
	