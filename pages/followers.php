<?php
	$db = new Database();
	$r = $db->query('SELECT * FROM profiles WHERE following = 1 ORDER BY id DESC LIMIT 25');
?><br/><br/>
<table align="center" width="600" cellspacing="0">
	<tr>
		<th>Display Name</th>
		<th width="140">Joined</th>
		<th width="30">Following</th>
	</tr>
	<?php
		while($dt = $r->fetch_object()){
	?>
	<tr>
		<td><?php echo $dt->display_name; ?></th>
		<td align="center"><?php echo $dt->joined; ?></td>
		<td align="center"><?php echo $dt->following; ?></td>
	</tr>
	<?php
		}
	?>
</table>