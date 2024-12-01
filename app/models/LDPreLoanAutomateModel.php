<?php 	

	class LDPreLoanAutomateModel extends Base_model
	{
		public function setBorrower($userid , $branchid , $groupid)
		{
			$this->userid   = $userid;
			$this->branchid = $branchid;
			$this->groupid  = $groupid;

		}

		public function auto_loan_cash($cashloanObj)
		{

			$userid   = $this->userid;
			$groupid  = $this->groupid;
			$branchid = $this->branchid;
			$loginuserid = Session::get('user')['id'];

			$loanAmountList = $cashloanObj->generate_cash_loan();

			$query_maker = "INSERT INTO ld_cash_advances(userid, groupid, created_by, branch_id,amount , date , time , status,
			notes) VALUES";


			$counter = 0;

			foreach($loanAmountList as $key => $amount) 
			{
				if($counter < $key) {
					$query_maker .=" , ";
					$counter++;
				}

				$query_maker .= "('$userid' , '$groupid' , '$loginuserid' , '$branchid' , '$amount' , 
				date(now()) , time(now()),'pending' , 'Automated loan')";
			}


			try
			{
				$this->db->query($query_maker);

				$this->db->execute();

				return true;
			}catch(Exception $e) 
			{
				die($e->getMessage());


				return false;
			}
		}

		public function auto_loan_product($productid)
		{
			$userid   = $this->userid;
			$groupid  = $this->groupid;
			$branchid = $this->branchid;
			$loginuserid = Session::get('user')['id'];

			/*subquery to get the product amount*/			
			$this->db->query(
				"INSERT INTO ld_product_advances(userid , groupid , created_by , branch_id , productid , amount , date , 
				time , approved_by , status , notes)

				VALUES('$userid' , '$groupid' , '$loginuserid' , '$branchid' , '$productid' ,
				(SELECT price from products where id  = '{$productid}'), date(now()) , 
				time(now()) , '0' , 'pending' , 'Automated loan')"
			);

			try{

				$this->db->execute();

				return true;

			}catch(Exception $e)
			{
				die($e->getMessage());
			}
		}
	}