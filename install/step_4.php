<?php
	if(isset($_POST['admin_name'])){
		if($_POST['admin_name'] && $_POST['admin_passwd']){
			$_SESSION['admin_name'] = $_POST['admin_name'];
			$_SESSION['admin_passwd'] = $_POST['admin_passwd'];
			$_SESSION['step'] = 5;
			header('Location: install.php');
			exit;
		}
	}
?>
<html>
<head>
<title>Installation - Step 4. Administrator Account</title>
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/jquery-3.2.0.min.js"></script>
<script language="javascript">
	$(document).ready(function(){
		$('#btnNext').click(function(){
			if($('#admin_name').val().trim() == ''){
				alert('Username required.');
				$('#admin_name').focus();
				return false;
			}
			if($('#admin_passwd').val().trim() == ''){
				alert('Password required.');
				$('#admin_passwd').focus();
				return false;
			}
			
			if($('#admin_passwd').val().trim() != $('#admin_confirm').val().trim()){
				alert('Password not match.');
				$('#admin_confirm').focus();
				return false;
			}
			$('#formAdmin').submit();
		});
	});
</script>
</head>
<body><br/>
<div class="box">
<h2>Step 4. Administrator Account</h2>
<br/>
<form name="formAdmin" id="formAdmin" method="post">
<table cellpadding="4">
	<tr>
		<td>Username</td>
		<td><input type="text" size="40" id="admin_name" name="admin_name" value=""/></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" size="40" id="admin_passwd" name="admin_passwd" value=""/></textarea></td>
	</tr>
	<tr>
		<td>Password Confirmation</td>
		<td><input type="password" size="40" id="admin_confirm" name="admin_confirm" value=""/></textarea></td>
	</tr>
</table><br/><br/>
<br/>
<input type="button" name="btnNext" id="btnNext" value="Next" class="button"/>
</form><br/>
</div>
</body>
</html>	
	
	