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
<?php
	$option = new Option();
	$active_app = $option->get('active_app');
?>

<script language="javascript">
	var base_url = '<?php echo $option->get('base_url'); ?>';
	var editor, app;
	$(document).ready(function(){
		var left = ($(document).width() - 400) / 2;
		$('#tblNewApps').css('top', '96px');
		$('#tblNewApps').css('left', (left + 'px'));
		
		var left = ($(document).width() - 800) / 2;
		$('#tblEditor').css('top', '16px');
		$('#tblEditor').css('left', (left + 'px'));
		
		$('#btnNewApps').click(function(){
			$('#tblNewApps').show();
		});
		
		$('#btnCreate').click(function(){
			var data = {
					appName: $('#txtAppName').val()
				};
				
			$.post('command.php?a=new', data, function(json){
				if(json.result){
					$('#tblNewApps').hide();
					window.location.reload();
				}
			});
			
		});
		
		$('#btnCloseNew').click(function(){
			$('#tblNewApps').hide();
		});
		
		$('#btnCloseEditor').click(function(){
			$('#tblEditor').hide();
		});
		
		$('#btnSave').click(function(){
			var data = {
					appName: app,
					text: editor.getValue()
				};
			
			$.post('command.php?a=save', data, function(json){
				alert(json.message);
				$('#tblEditor').hide();
			});
		});
		
		$('#txtAppName').keypress(function(event){
			var keyCode = (typeof event.which == "number") ? event.which : event.keyCode;
			return  ((keyCode > 64 && keyCode < 91) || (keyCode > 96 && keyCode < 123) || keyCode == 8)
		});
		
		attachEvent();
	});
	
	function attachEvent(){
		$('.btnEdit').click(function(){
			app = $(this).attr('pid');
			var url = 'command.php?a=get&f=' + app + '&t=' + Date.now();
			$.get(url, function(data){
				$('#thTitle').html(app);
				$('#tblEditor').show();
				editor.setValue(data);
			});	
			
			return false;
		});
		
		$('.btnDelete').click(function(){
			if(confirm('Are you sure want to delete this app?')){
				app = $(this).attr('pid');
				window.location.href = 'command.php?a=delete&f=' + app;
			}
			return false;
		});
	}
</script>
<?php
	
	$files = scandir('./apps');
	$apps = array();
	foreach($files as $f){
		if($f != '.' && $f != '..'){
			$f = substr($f, 0, strripos($f, '.'));
			$apps[$f] = $f;
		}
	}
?><br/><br/>
<div align="center">
<table width="500">
	<tr>
		<td width="34" align="center"><img src="assets/img/folder.png"/></td>
		<td colspan="2">
			<b>Apps</b>
			<!-- <input type="button" id="btnNewFolder" value="New Folder" class="right"/> -->
			<input type="button" id="btnNewApps" value="New Apps" class="right"/>
		</td>
	</tr>
	<?php
		foreach($files as $f){
			if($f != '.' && $f != '..'){
				$f = substr($f, 0, strripos($f, '.'));
	?>
	<tr>
		<td align="center">&nbsp;&nbsp;<img src="assets/img/file.png"/></td>
		<td><b><?php echo $f; ?></b></td>
		<td align="center" width="100">
			<a class="btnEdit" href="#" pid="<?php echo $f; ?>">Edit</a>
			<?php if($active_app != $f) { ?>
			<a class="btnDelete" href="#" pid="<?php echo $f; ?>">Delete</a>
			<?php } ?>
		</td>
	</tr>
	<?php	
			}
		}
	?>
</table>
<table width="400" id="tblNewApps" class="dialog" style="display: none;">
	<tr>
		<th colspan="2">
			New App
			<input type="button" id="btnCloseNew" value="X" class="right"/>
		</th>
	</tr>
	<tr><td>App Name</td><td><input type="text" size="30" id="txtAppName"/></td></tr>
	<tr><td colspan="2"><input type="button" id="btnCreate" value="Create" class="right"/></td></tr>
</table>
<table width="800" id="tblEditor" class="dialog" style="display: none;">
	<tr>
		<th  id="thTitle"></th>
		<th width="20">
			<input type="button" id="btnCloseEditor" value="X" class="right"/>
		</th></tr>
	<tr>
		<td colspan="2">
			<div style="width: 800px; border: 1px solid #aaa; margin-left: auto; margin-right: auto; ">
			<textarea id="code" name="code" rows="40"></textarea>
			</div>
			<script language="javascript">
				editor = CodeMirror.fromTextArea(document.getElementById("code"), {
					lineNumbers: true,
					matchBrackets: true,
					mode: "application/x-httpd-php",
					indentUnit: 4,
					indentWithTabs: true
				  });

				editor.setSize(800, 440);
			</script>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="button" name="btnSave" id="btnSave" value="Save" class="button"/>
		</td>
	</tr>
</table>