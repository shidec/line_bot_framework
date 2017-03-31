<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/codemirror.css">
<script src="assets/js/jquery-3.2.0.min.js"></script>
<script src="assets/js/codemirror/codemirror.js"></script>
<script src="assets/js/codemirror/php.js"></script>
<script src="assets/js/codemirror/matchbrackets.js"></script>
<script src="assets/js/codemirror/htmlmixed.js"></script>
<script src="assets/js/codemirror/xml.js"></script>
<script src="assets/js/codemirror/javascript.js"></script>
<script src="assets/js/codemirror/clike.js"></script>
<script src="assets/js/codemirror/css.js"></script>
<script language="javascript">
	$(document).ready(function(){
		$('#trEditor, #trSave').hide();
		
		$('#btnOpen').click(function(){
			$.get('get.php?f=' + $('#active_app').val(), function(data){
				$('#trEditor, #trSave').show();
				editor.setValue(data);
			});			
		});
	});
</script>
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
?>
<div align="center">
<table width="500">
	<tr>
		<td width="50">Apps</td>
		<td>
			<?php echo drop_down('active_app', $apps, $option->get('active_app')); ?>
			<input type="button" name="btnOpen" id="btnOpen" value="Edit" class="button"/>
		</td>
	</tr>
	<tr id="trEditor">
		<td colspan="2">
			<div style="width: 500px; border: 1px solid #aaa; margin-left: auto; margin-right: auto; ">
			<textarea id="code" name="code"></textarea>
			</div>
			<script language="javascript">
				var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
					lineNumbers: true,
					matchBrackets: true,
					mode: "application/x-httpd-php",
					indentUnit: 4,
					indentWithTabs: true
				  });
			</script>
			</div>
		</td>
	</tr>
	<tr id="trSave">
		<td colspan="2">
			<input type="button" name="btnSave" id="btnSave" value="Save" class="button"/>
		</td>
	</tr>
</table>