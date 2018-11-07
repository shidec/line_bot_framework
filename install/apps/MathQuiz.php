<?php
	class MathQuiz extends Line_Apps{
				
		function on_follow(){
			$messages = array("Welcomes {$this->profile->display_name}.",
							  "Let's play Math Quiz. Answer math question within a minute.",
							  "Type 'start' to play.");
			$messages[] = array(
								'type' => 'image',
								'originalContentUrl' => 'http://localhost/git/line_bot_framework/samples/affa.jpg',
								'previewImageUrl' => 'http://localhost/git/line_bot_framework/samples/affa.jpg'
							);
			$this->session->set('mq_status', 0);
			
			return $messages;
		}
		
		function on_message($message){
			//--mq_status 0: none, 1: play
			$text = strtolower($message['text']);
			if($this->session->get('mq_status') == 0 && $text == 'start'){
				$this->session->set('mq_status', 1);
				$this->session->set('mq_start_time', time());
				$this->session->set('mq_question_count', 0);
				$this->session->set('mq_answer_count', 0);
				
				$this->generateQuestion();
				$messages = $this->session->get('mq_question');
			}else if($this->session->get('mq_status') == 1){
				//--check answer
				if($text == $this->session->get('mq_answer')){
					$this->session->set('mq_answer_count', $this->session->get('mq_answer_count') + 1);
					$messages = array();
					$messages[] = array('type' => 'text', 'text' => 'Correct!');
					$messages[] = array('type' => 'sticker', 'packageId' => '1', 'stickerId' => '2');
				}else{
					$messages = array(
									'Wrong answer!',
									'The answer is ' . $this->session->get('mq_answer')
									);
				}
				
				//--check time
				if(time() - $this->session->get('mq_start_time') > 60){
					$this->session->set('mq_status', 0);
					$messages[] = 'Time is over.';
					
					$messages[] = 'You answer ' . $this->session->get('mq_answer_count') . 
									' of ' . $this->session->get('mq_question_count') . ' correctly.';
				}else{
					$this->generateQuestion();
					$messages[] = $this->session->get('mq_question');
				}
				
			}else{
				$messages[] = "Type 'start' to play.";
			}
			return $messages;
		}
		
		private function generateQuestion(){
			$ops = array(' * ',' + ',' - ');
			$q = rand(5,20) . $ops[rand(0,2)] . rand(5, 20);
			eval('$a = ' . $q . ';');
			
			$this->session->set('mq_question', $q);
			$this->session->set('mq_answer', $a);
			$this->session->set('mq_question_count', $this->session->get('mq_question_count') + 1);
		}
	}