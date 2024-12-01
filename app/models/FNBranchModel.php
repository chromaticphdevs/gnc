<?php

	class FNBranchModel extends Base_model
	{

		private $table_name = 'fn_branches';
		public $table = 'fn_branches';
		
		public function make_branch($branchinfo)
		{
			extract($branchinfo);

			$data = [
				$this->table_name ,
				[
					'name' => $name ,
					'address' => $address,
					'notes'  => $notes
				]
			];

			return
				$this->dbHelper->insert(...$data);
		}

		public function get_list()
		{
			$data = [
				$this->table_name,
				'*',
				null,
				'id desc'
			];

			return
				$this->dbHelper->resultSet(...$data);
		}

		/**
		 * Used on inventory module
		 * fetch all order by asc
		 */
		public function get_list_asc($field , $where = null)
		{
			$data = [
				$this->table_name,
				'*',
				$where,
				" $field asc "
			];

			return
				$this->dbHelper->resultSet(...$data);
		}


		public function get_main_branch()
		{

			$data = [
				$this->table_name,
				'*',
				'id = 1'
			];

			return
				$this->dbHelper->resultSet(...$data);

		}

		public function get_branch($branchid)
		{
			$data = [
				$this->table_name ,
				'*',
				" id = '$branchid'"
			];

			return
				$this->dbHelper->single(...$data);
		}

		public function update_branch($branchinfo)
		{
			extract($branchinfo);

			$data = [
				$this->table_name ,
				[
					'name' => $name ,
					'address' => $address,
					'notes' => $notes,
				],

				" id  = '$branchid'"
			];

			return
				$this->dbHelper->update(...$data);
		}
	}
?>
