<?php
	class GuessTheLogo extends Line_Apps{
		
		var $image_url = 'http://localhost/lbf/samples/' ;

		function on_follow(){
			$messages = array("Welcomes {$this->profile->display_name}.",
							  "Let's play Guess the logos.",
							  "Type 'play' to play.");
			
			$this->session->set('gl_question_count', 0);
			$this->session->set('gl_answer_count', 0);
			
			return $messages;
		}
		
		function on_message($message){
			//--mq_status 0: none, 1: play
			$text = strtolower($message['text']);
			if($text == 'play'){				
				$messages = $this->generateQuestion();
			}else{
				//--check answer
				if($text == $this->session->get('gl_answer')){
					$this->session->set('gl_answer_count', $this->session->get('gl_answer_count') + 1);
					$messages[] = 'Correct!';
					$messages[] = array('type' => 'template',
										  'altText' => 'confirm play again',
										  'template'=> array(
											  'type'=> 'confirm',
											  'text'=> 'Play again?',
											  'actions'=> array(
													array('type'=> 'message','label'=> 'Yes','text'=> 'play'),
													array('type'=> 'message','label'=> 'No','text'=> 'no')
													)
										  )
									);
				}else if($text == 'no'){
					$messages[] = 'Thanks!';
				}else{
					$messages = array(
									'Wrong!',
									'The answer is \'' . $this->session->get('gl_answer') . '\'',
									array('type' => 'template',
										  'altText' => 'confirm play again',
										  'template'=> array(
											  'type'=> 'confirm',
											  'text'=> 'Play again?',
											  'actions'=> array(
													array('type'=> 'message','label'=> 'Yes','text'=> 'play'),
													array('type'=> 'message','label'=> 'No','text'=> 'no')
													)
										  )
									)
								);
				}
			}
			return $messages;
		}
		
		private function generateQuestion(){			
			//--sample questions, you can load it from database
			$questions = array(
					array('name' => 'chevrolet', 'logo' => 'chevrolet.png'),
					array('name' => 'playboy', 'logo' => 'playboy.png'),
					array('name' => 'shell', 'logo' => 'shell.png'),
					array('name' => 'java', 'logo' => 'java.png'),
					array('name' => 'mysql', 'logo' => 'mysql.png'),
					array('name' => 'postgresql', 'logo' => 'postgresql.png'),
					array('name' => 'chrome', 'logo' => 'chrome.png'),
					array('name' => 'firefox', 'logo' => 'firefox.png'),
					array('name' => 'bluetooth', 'logo' => 'bluetooth.png'),
					array('name' => 'twitter', 'logo' => 'twitter.png')
				);
				
			$index = rand(0, count($questions) - 1);
			
			$this->session->set('gl_answer', $questions[$index]['name']);
			
			return array(
							'type' => 'image',
							'originalContentUrl' => $this->image_url . $questions[$index]['logo'],
							'previewImageUrl' => $this->image_url . $questions[$index]['logo']
						);
		}
		
		function on_postback($data){
			//--write your code here
		}
	}