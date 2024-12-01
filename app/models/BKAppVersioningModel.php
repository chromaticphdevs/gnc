<?php 	

	class BKAppVersioningModel extends Base_model
	{
		public $table = 'bk_app_versioning';


		public function getByKey($versionKey)
		{	
			$data = [
		        $this->table ,
		        '*',
		        " version_key = '{$versionKey}'"
		      ];

			return $this->dbHelper->single(...$data);
		}
		public function getByVersion($version_number )
		{
			 $data = [
		        $this->table ,
		        '*',
		        " version_number  = '{$version_number }'"
		      ];

			return $this->dbHelper->single(...$data);
		}

		public function getLatest()
		{
			 $data = [
		        $this->table ,
		        '*',
		        " status  = 'latest'"
		      ];

			return $this->dbHelper->single(...$data);
		}
	}