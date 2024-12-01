<?php 	

	class MigrationLoan extends Controller
	{

		public function __construct()
		{
			$this->fnCashAdvance = model('FNCashAdvanceModel');
		}


		public function index()
		{
			$db = $this->fnCashAdvance->db;

			$db->query(
				"SELECT * FROM {$this->fnCashAdvance->table}
					WHERE date is not null and time is not null "
			);
			

			$results = $db->resultSet();

			$resultsFile = [];

			$isUpdated = [];

			foreach($results as $key => $row)
			{
				$db->query(
					"SELECT * FROM {$this->fnCashAdvance->table}
						WHERE userid = '$row->userid'
						AND status = 'pending'"
				);

				$rs = $db->single();

				if($rs)
					$isUpdated [] = $this->fnCashAdvance->dbupdate([
						'created_on' => $rs->created_on
					] , $rs->id);
			}

			dump($results);
		}
	}