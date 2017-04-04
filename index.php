<?php
	if(!file_exists('includes/config.php')){
		header('Location: install.php');
		exit;
	}
	
	session_start();
	
	if(isset($_SESSION['logged']) && $_SESSION['logged']){
		header('Location: page.php');
	}
	
	if(isset($_POST['login'])){
		require_once 'includes/config.php';
		require_once 'classes/Database.php';
		require_once 'classes/Option.php';
		
		$option = new Option();
		if($_POST['username'] == $option->get('admin_name') && md5($_POST['userpasswd']) == $option->get('admin_passwd')){
			$_SESSION['logged'] = 1;
			header('Location: page.php');
		}else{
			$error = 'Login failed';
		}
	}
?>
<html>
<head>
<title>Bot Framework - Login</title>
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/jquery-3.2.0.min.js"></script>
</head>
<body>
<br/><br/>
<?php
	if(isset($_GET['installed'])){
?>
<div class="msg">instalation complete. It's better to remove 'install' directory.</div>
<?php		
	}
?>
<br/><br/><br/>
<div align="center">
	<?php echo (isset($error) ? '<div class="error">' . $error . '</div>' : ''); ?><br/>
	<form name="formLogin" id="formLogin" method="post" action="index.php">
	<table width="400">
		<tr>
			<td>Username</td>
			<td><input type="text" name="username" id="username"/></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="userpasswd" id="userpasswd"/></td>
		</tr>
		<tr>
		<td colspan="2">
			<input type="submit" name="login" id="login" value="Login" class="button"/>
		</td>
		</tr>
	</table>
	</form>
</div>
</body>
</head>