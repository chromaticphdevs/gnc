<?php 	

	class LDGeneologyObj
	{
		public $id;

		public function __construct($user = null)
		{
			if(!$user)
			{
				$this->init_properties();
			}else{

				$this->id        = $user->id;
				$this->dbbi_id   = $user->dbbi_id;
				$this->uplineid  = $user->upline;
				$this->username  = $user->username;
				$this->firstname = $user->firstname;
				$this->lastname  = $user->lastname;
				$this->position  = $user->L_R;
			}
		}

		private function init_properties()
		{
			$this->id = null;
			$this->uplineid = null;
		}
	}