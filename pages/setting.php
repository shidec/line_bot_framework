<?php
	$option = new Option();
	$files = scandir('./apps');
	$apps = array();
	foreach($files as $f){
		if($f != '.' && $f != '..'){
			$f = substr($f, 0, strripos($f, '.'));
			$apps[$f] = $f;
		}
	}
	
	if(isset($_POST['save'])){
		$option->set('base_url', $_POST['server_url']);
		$option->set('channel_secret', $_POST['ch_secret']);
		$option->set('channel_access_token', $_POST['ch_token']);
		$option->set('active_app', $_POST['active_app']);
	}
?>
<form name="formSetting" id="formSetting" method="post" action="">
<table align="center" width="600">
	<tr><td colspan="2"><b>Server</b></td></tr>
	<tr>
		<td>Active App</td>
		<td><?php echo drop_down('active_app', $apps, $option->get('active_app')); ?></td>
	</tr>
	<tr>
		<td>Base Url</td>
		<td><input type="text" name="server_url" id="server_url" size="50" value="<?php echo $option->get('base_url'); ?>"/></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2"><b>Messaging API Token</b></td></tr>
	<tr>
		<td>Channel Secret</td>
		<td><input type="text" name="ch_secret" id="ch_secret" size="40" value="<?php echo $option->get('channel_secret'); ?>"/></td>
	</tr>
	<tr>
		<td>Channel Token</td>
		<td><textarea id="ch_token" cols="38" rows="7" name="ch_token"/><?php echo $option->get('channel_access_token'); ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" name="save" id="save" value="Save" class="button"/></td>
	</tr>
</table>
</form>