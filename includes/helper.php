<?php

function drop_down($id, $items, $selected){
	$result = '<select id="' . $id . '" name="' . $id . '">';
	foreach($items as $k => $i){
		$result .= '<option value="' . $k . '" ' . ($k == $selected ? 'selected="selected"' : '') . '>' . $i . '</option>';
	}
	$result .= '</select>';
	
	return $result;
}

function checkProfile($client, $userId){
		$db = new Database();
		$r = $db->query("SELECT * FROM profiles WHERE user_id = '{$userId}'");
		if($r->num_rows){
			$result = $r->fetch_object();
		}else{
			$profile = $client->getProfil($userId);
			if($profile){
				$db->query("INSERT INTO profiles (user_id, display_name, picture_url) 
					VALUES ('{$userId}', '" . $db->mysqli->real_escape_string($profile->displayName) . "','" . $db->mysqli->real_escape_string($profile->pictureUrl) . "')");
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
