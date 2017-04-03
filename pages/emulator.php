<link rel="stylesheet" href="assets/css/emulator.css">
<script src="assets/js/jquery-3.2.0.min.js"></script>
<script type="application/javascript">
	$(document).ready(function(){
		$('#btnSend').click(function(){
			message = $('#txtMessage').val();
			$('#txtMessage').val('');
			if(message.trim() != ''){
				$('#messages').append("<div class='chat_self'>" + message + "</div><div class='nl'></div>");
				$('#messages').scrollTop($('#messages').prop("scrollHeight"));
				
				data = {
					events: [
						{
							replyToken: "000",
							timestamp: "123456",
							source:{
								type: "user",
								userId: "U0000EMU"
							},
							type: "message",
							message: {
								"id": "0000",
								"type": "text",
								"text": message
							}
						}	
					]
				};

				$.post('webhook_emu.php', data, function(data){
					var json = null;
					try{
						json = JSON.parse(data);
					}catch(e){
						
					}
					if(json == null || json.messages == null){
						$('#messages').append("<div class='chat_error'>" + data + "</div><div class='nl'></div>");
						$('#messages').scrollTop($('#messages').prop("scrollHeight"));
					}else{
						$.each(json.messages, function(i, item){
							if(item.type == 'text'){
								$('#messages').append("<div class='chat'>" + item.text + "</div><div class='nl'></div>");
							}else if(item.type == 'sticker'){
								$('#messages').append("<div class='chat'><img src='assets/img/stickers/" + item.packageId + "/" + item.stickerId + ".png' alt='[sticker]'/></div><div class='nl'></div>");
							}else{
								$('#messages').append("<div class='chat_ns'>" + item.type + "<br/>[not supported]</div><div class='nl'></div>");
							}
						});
						$('#messages').scrollTop($('#messages').prop("scrollHeight"));
					}
				});
			}
		});
		
	});
</script>
<?php
	$option = new Option();
	$active_app = $option->get('active_app');
	require_once 'classes/Line_Apps.php';
	require_once 'classes/Session.php';
	require_once './apps/' . $active_app  . '.php';
	
	$app = new $active_app(emu_profile());
	
	$messages = process_messages($app->on_follow());
?>
<div id="container">
	<div id="title"><?php echo $active_app; ?></div>
	<div id="messages">
		<?php
			if($messages){
				foreach($messages as $m){
					if($m['type'] == 'text'){
						echo "<div class='chat'>" . $m['text'] . "</div><div class='nl'></div>";
					}
				}
			}
		?>
	</div>
	<div>
		<input type="text" name="txtMessage" id="txtMessage"/>
		<img src="assets/img/send.png" id="btnSend" width="36" height="36">
	</div>
</div>