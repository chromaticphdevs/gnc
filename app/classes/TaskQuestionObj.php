<?php 	

	class TaskQuestionObj
	{
		public $id;
		public $taskid;
		public $question;
		public $type;
		public $choices;
		public $answer;
		public $created_on;


		public function get_choices()
		{
			if($this->type == 'multiple choice')
			{
				$choices = $this->choices;
				try{
					$choices = json_decode(unserialize($choices));

					if(is_null($choices)){
						return '';
					}else{
						$html    = '';
						foreach($choices as $key => $choice)
						{
							$key++;
							$html .= $key . '.' . $choice . '<br/>';
						}
						return $html;
					}
				}catch(Exception $e)
				{
					return 'No Result';
				}
				
			}else{
				return 'No Result';
			}
		}


		public function get_choices_array()
		{
			try{
				$choices = $this->choices;
				
				return json_decode(unserialize($choices));
			}catch(Exception $e)
			{
				return [];
			}
			
		}
	}