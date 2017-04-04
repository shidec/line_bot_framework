<link rel="stylesheet" href="assets/css/emulator.css">
<script src="assets/js/jquery-3.2.0.min.js"></script>
<script type="application/javascript">
	$(document).ready(function(){

		sendFollowRequest();

		$('#btnSend').click(function(){
			message = $('#txtMessage').val().trim();
			$('#txtMessage').val('');
			if(message != ''){
				sendMessage(message);
			}
		});

	});
	
	function sendMessage(message){
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
			processMessages(data);
		});
	}

	function sendFollowRequest(){
		data = {
			events: [
				{
					replyToken: "000",
					timestamp: "123456",
					source:{
						type: "user",
						userId: "U0000EMU"
					},
					type: "follow"
				}
			]
		};

		$.post('webhook_emu.php', data, function(data){
			processMessages(data);
		});
	}

	function processMessages(data){
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
				}else if(item.type == 'image'){
					$('#messages').append("<div class='chat'><img src='" + item.previewImageUrl + "' alt='[image]' width='150' height='150'/></div><div class='nl'></div>");
				}else if(item.type == 'template'){
					processTemplate(item);
				}else{
					$('#messages').append("<div class='chat_ns'>" + item.type + "<br/>[not supported]</div><div class='nl'></div>");
				}
			});
			$('#messages').scrollTop($('#messages').prop("scrollHeight"));
		}
	}
	
	function attachTemplateEvent(){
		$('.chat_button').click(function(){
			sendMessage($(this).attr('pid'));
		});
	}
	
	function processTemplate(item){
		var html;
		if(item.template.type == 'confirm'){
			var btn_count = item.template.actions.length;
			var btn_size = 250 / btn_count;
			html = "<div class='chat'>";
			html += "<div class='chat_title'><b>" + item.template.text + "</b></div>";
			html += "<div>";
			$.each(item.template.actions, function(i, action){
				html += "<div class='chat_button' pid='" + action.text + "' style='width:" + btn_size + "px'>";
				html += action.label;
				html += "</div>";
			});
			html += "</div></div>";
		}else{
			html = "<div class='chat'>";
			html += "</div>";
		}		
		
		$('#messages').append(html);
		
		attachTemplateEvent();
	}
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
<div class="msg" style="width: 640px; margin-left: auto; margin-right: auto;">
<ul>
	<li>Current active app is <b><?php echo $active_app; ?></b>. You can change it via <a href="page.php?p=setting">Setting</a> page.</li>
	<li>Current object messages supported by emulator are <b>text</b>, <b>sticker</b>, <b>image</b>, and <b>template: confirm</b></li>
</ul>
</div><br/>
<div id="container">
	<div id="title"><?php echo $active_app; ?></div>
	<div id="messages"></div>
	<div>
		<input type="text" name="txtMessage" id="txtMessage"/>
		<img src="assets/img/send.png" id="btnSend" width="36" height="36">
	</div>
</div>