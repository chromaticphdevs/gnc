<?php 	

	class Office_model extends Base_model
	{

		private $table_name = 'tk_offices';

		public function create($office)
		{
			extract($office);
			//temporary id;
			$userid = 1;
			
			$this->db->query(
				"INSERT INTO $this->table_name(userid , name , location , description)
				VALUES('$userid' , '$officename' , '$location' , '$description')"
			);

			$this->db->insert();
		}

		public function getList()
		{
			$this->db->query(
				"SELECT * from $this->table_name"
			);


			return $this->db->resultSet();
		}
	}