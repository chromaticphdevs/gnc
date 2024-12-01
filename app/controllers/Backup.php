<?php 	

	class Backup extends Controller
	{
		public function __construct()
		{
			$this->backupModel = $this->model('backupModel');
		} 

		public function get_geneology()
		{
			$usersForBackup = $this->backupModel->get_binary_structure(11028);

			$this->backupModel->insert_users($usersForBackup);
		}
	}