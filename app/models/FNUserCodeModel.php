<?php 	

	class FNUserCodeModel extends Base_model
	{

		private $table_name = 'fn_off_code_inventories';

		public function update_status($codeid , $status)
		{
			$data = [
				$this->table_name , 
				[
					'status' => $status
				],

				"codeid = '{$codeid}'"
			];

			return 	
				$this->dbHelper->update(...$data);
		}
	}