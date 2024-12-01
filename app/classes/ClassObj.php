<?php 

	class ClassObj
	{
		public $id ,$day ,$time, $name;
		public $branch;
		public $notes;
		public $created_by;
		public $group_status;
		public $created_on;


		public $nigga = 'blackDude';

		public function getMonthSchedule(){
			return getDayMonthOccurence(date('m') , dayNumericToShort($this->day));
		}

	}
