<?php 	

	class LDGroupModel extends Base_model
	{

		private $table_name = 'ld_groups';
		
		public function create($groupInfo)
		{
			extract($groupInfo);

			$data = [

				$this->table_name , 
				[
					'group_name' => $group_name ,
					'branchid'   => $branchid
				]
				
			];


			return $this->dbHelper->insert(...$data);
		}

		public function get_list()
		{

			$this->db->query(
				"SELECT grp.* , ld.branch_name FROM $this->table_name as grp 
				left join ld_branch as ld 
				on ld.id = grp.branchid ORDER BY group_name desc"
			);

			return $this->db->resultSet();

			// $data = [
			// 	$this->table_name , 
			// 	'*',
			// 	null,
			// 	' group_name asc'
			// ];

			// return $this->dbHelper->resultSet(...$data);
		}

		public function get_group($groupid)
		{
			$data = [
				$this->table_name , 
				'*' , 
				"id = '{$groupid}'"
			];

			return $this->dbHelper->single(...$data);
		}
	}