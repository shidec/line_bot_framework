<?php

function process_messages($messages){
	if(empty($messages)) return false;
	
	if(!is_array($messages)){
		return array(process_message($messages));
	}else{
		if(array_key_exists('type', $messages)){
			return array($messages);
		}else{
			$result = array();
			foreach($messages as $m){
				if(!is_array($m)){
					$result[] =  process_message($m);
				}else{
					$result[] = $m; 
				}
			}
			
			return $result;
		}
	}
}

function process_message($message){
	return array(
					'type' => 'text', 
					'text' => $message
				);
}

function emu_profile(){
	$result = new StdClass();
	$result->id = 1;
	$result->user_id = 'U0000EMU';
	$result->display_name = 'Emulator';
	$result->picture_url = '';
			
	return $result;
}

function check_profile($client, $userId){
	$db = new Database();
	$r = $db->query("SELECT * FROM profiles WHERE user_id = '{$userId}'");
	if($r->num_rows){
		$result = $r->fetch_object();
	}else{
		$profile = $client->getProfil($userId);
		if($profile){
			$db->query("INSERT INTO profiles (user_id, display_name, picture_url) 
				VALUES ('{$userId}', '" . $db->escape($profile->displayName) . "','" . $db->escape($profile->pictureUrl) . "')");
			$result = new stdClass(); 
			$result->id = $db->mysqli->insert_id;
			$result->user_id = $userId;
			$result->display_name = $profile->displayName;
			$result->picture_url = $profile->pictureUrl;
		}else{
			$result = new stdClass();
		}
	}
	
	$r->free();
	$db->close();
	return $result;
}

function drop_down($id, $items, $selected){
	$result = '<select id="' . $id . '" name="' . $id . '">';
	foreach($items as $k => $i){
		$result .= '<option value="' . $k . '" ' . ($k == $selected ? 'selected="selected"' : '') . '>' . $i . '</option>';
	}
	$result .= '</select>';
	
	return $result;
}
