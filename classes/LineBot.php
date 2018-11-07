<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

/*
 * This polyfill of hash_equals() is a modified edition of https://github.com/indigophp/hash-compat/tree/43a19f42093a0cd2d11874dff9d891027fc42214
 *
 * Copyright (c) 2015 Indigo Development Team
 * Released under the MIT license
 * https://github.com/indigophp/hash-compat/blob/43a19f42093a0cd2d11874dff9d891027fc42214/LICENSE
 */
if (!function_exists('hash_equals')) {
    defined('USE_MB_STRING') or define('USE_MB_STRING', function_exists('mb_strlen'));

    function hash_equals($knownString, $userString)
    {
        $strlen = function ($string) {
            if (USE_MB_STRING) {
                return mb_strlen($string, '8bit');
            }

            return strlen($string);
        };

        // Compare string lengths
        if (($length = $strlen($knownString)) !== $strlen($userString)) {
            return false;
        }

        $diff = 0;

        // Calculate differences
        for ($i = 0; $i < $length; $i++) {
            $diff |= ord($knownString[$i]) ^ ord($userString[$i]);
        }
        return $diff === 0;
    }
}

class LineBot
{
    public function __construct($channelAccessToken, $channelSecret)
    {
        $this->channelAccessToken = $channelAccessToken;
        $this->channelSecret = $channelSecret;
    }

    public function parseEvents()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            error_log("Method not allowed");
            exit();
        }

        $entityBody = file_get_contents('php://input');

        if (strlen($entityBody) === 0) {
            http_response_code(400);
            error_log("Missing request body");
            exit();
        }

        if (!hash_equals($this->sign($entityBody), $_SERVER['HTTP_X_LINE_SIGNATURE'])) {
            http_response_code(400);
            error_log("Invalid signature value");
            exit();
        }

        $data = json_decode($entityBody, true);
        if (!isset($data['events'])) {
            http_response_code(400);
            error_log("Invalid request body: missing events property");
            exit();
        }
        return $data['events'];
    }
	
	function multiCast($message){
    	$header = array(
            "Content-Type: application/json",
            'Authorization: Bearer ' . $this->channelAccessToken,
        );
	
        $ch   = curl_init('https://api.line.me/v2/bot/message/multicast');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($message));
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		if($response === false){
			error_log("Error: connection");
		}else{
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$header = substr($response, 0, $header_size);
			$body = substr($response, $header_size);
			if($body){
				return json_decode($body);
			}else{
				error_log("Error: " . $header);
			}
		}
    }

    function pushMessage($uid, $messages){
        error_log("pushMessage");
        $header = array(
            "Content-Type: application/json",
            'Authorization: Bearer ' . $this->channelAccessToken,
        );
    
        $post = array('to' => $uid, 'messages' => $messages);
        
        error_log(json_encode($post));
        $ch   = curl_init('https://api.line.me/v2/bot/message/push');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($post));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        error_log("Push: " . $response);
        if($response === false){
            error_log("Error: connection");
        }else{
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $header_size);
            $body = substr($response, $header_size);
            if($body){
                return json_decode($body);
            }else{
                error_log("Error: " . $header);
            }
        }
    }
	
	function replyMessage($message){
    	$header = array(
            "Content-Type: application/json",
            'Authorization: Bearer ' . $this->channelAccessToken,
        );
	
        $ch   = curl_init('https://api.line.me/v2/bot/message/reply');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($message));
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		if($response === false){
			error_log("Error: connection");
		}else{
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$header = substr($response, 0, $header_size);
			$body = substr($response, $header_size);
			if($body){
				error_log("Body: " . $body);
				return json_decode($body);
			}else{
				error_log("Error: " . $header);
			}
		}
    }


	function getProfil($userId){
    	$header = array(
            "Content-Type: application/json",
            'Authorization: Bearer ' . $this->channelAccessToken,
        );
	
        $ch   = curl_init('https://api.line.me/v2/bot/profile/' . $userId);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		if($response === false){
			error_log("Error: connection");
		}else{
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$header = substr($response, 0, $header_size);
			$body = substr($response, $header_size);
			if($body){
				error_log("Body: " . $body);
				return json_decode($body);
			}else{
				error_log("Error: " . $header);
			}
		}
    }

    private function sign($body)
    {
        $hash = hash_hmac('sha256', $body, $this->channelSecret, true);
        $signature = base64_encode($hash);
        return $signature;
    }
}
