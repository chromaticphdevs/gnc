<?php 	

	class LevelSettingModel extends Base_model
	{
		public $table = 'level_settings';

		public static function getByLevel($level)
		{
			$database = Database::getInstance();

			$table = 'level_settings';

			$database->query(
				"SELECT * FROM $table where level = '{$level}'"
			);

			return $database->single();
		}


		public function all()
		{
			$this->db->query(
				"SELECT * FROM $this->table 
					order by hierarchy asc "
			);
			
			return $this->db->resultSet();
		}
	}