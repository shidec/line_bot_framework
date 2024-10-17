<?php
	if(isset($_POST['db_host'])){		
		$link = @mysqli_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_passwd'], $_POST['db_database']);
		if($link){
			mysqli_close($link);
			$server_url = trim($_POST['server_url']);
			$_SESSION['server_url'] = substr($server_url, -1, 1) === '/' ? $server_url : $server_url . '/';
			$_SESSION['db_host'] = $_POST['db_host'];
			$_SESSION['db_user'] = $_POST['db_user'];
			$_SESSION['db_passwd'] = $_POST['db_passwd'];
			$_SESSION['db_database'] = $_POST['db_database'];
			$_SESSION['step'] = 3;
			header('Location: install.php');
			exit;
		}
	}
?>
<html>
<head>
<title>Installation - Step 2. Server &amp; Database</title>
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script language="javascript">
	$(document).ready(function(){
		$('#btnNext').click(function(){
			$.post('install/test.php', $('#formDatabase').serialize(), function(data){
				if(data != null && data.result){
					$('#formDatabase').submit();
				}else{
					alert('Database Error: ' + data.message);
				}
			});
		});
	});
</script>
</head>
<body><br/>
<div class="box">
<h2>Step 2. Server &amp; Database</h2>
<br/>
<form name="formDatabase" id="formDatabase" method="post">
<table cellpadding="4">
	<tr><td colspan="2"><b>Server</b></td></tr>
	<tr><td>Base Url</td><td><input type="text" id="server_url" name="server_url" value="https://" size="40"/></td></tr>
	<tr><td colspan="2"><b>Database</td></tr>
	<tr><td>Host</td><td><input type="text" id="db_host" name="db_host" value="localhost" size="40"/></td></tr>
	<tr><td>User</td><td><input type="text" id="db_user" name="db_user" value="root" size="40"/></td></tr>
	<tr><td>Password</td><td><input type="text" id="db_passwd" name="db_passwd" value="" size="40"/></td></tr>
	<tr><td>Database</td><td><input type="text" id="db_database" name="db_database" value="bot_" size="40"/></td></tr>
</table><br/><br/>
</form>
<br/>
<form method="post" action="" name="frmNext">
<input type="button" name="submit" id="btnNext" value="Next" class="button"/>
</form><br/>
</div>
</body>
</html>	
	
	