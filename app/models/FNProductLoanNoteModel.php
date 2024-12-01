<?php 	

	class FNProductLoanNoteModel extends Base_model 
	{

		public $table = 'fn_product_release_notes';


		public function getByLoan($loanId)
		{
			$this->db->query(
				"SELECT * FROM $this->table 
					WHERE loanid = '$loanId' 
					ORDER BY id desc"
			);
			return $this->db->resultSet();
		}
	}