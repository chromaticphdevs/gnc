<?php 	
	/*DONT DELETE THIS THIS IS PART OF THE SOCIAL NETWORK PAYOUT MODEL*/
	class PayrollModel extends Base_Model
	{
		public function getRecievers($payoutid)
		{
			$sql = "SELECT pc.payout_id as payoutid , cheque_img, pc.id as pcid , ui.id as userid , concat(firstname , ' ' ,lastname) as fullname , 
			amount from payout_cheque as pc 
			left join users as ui 
			on ui.id = pc.user_id

			where pc.payout_id = '$payoutid'

			and amount != 0";

			$this->db->query($sql);

			return $this->db->resultSet();
		}

		public function add_cheque_img($payrollInfo , $fileAttached)
		{
				extract($payrollInfo);

				$file = new File();

				$file->setFile($fileAttached)
				->setPrefix('IMAGE')
				->setDIR(PUBLIC_ROOT.DS.'assets')
				->upload();

				if(!empty($file->getErrors()))
				{
					Flash::set($file->getErrors()  , "danger");
					redirect('payouts/preview/'.$payoutid);
				}else{
					$filename = $file->getFileUploadName();

					$this->db->query("UPDATE payout_cheque set cheque_img  = '$filename' 
						where id = '$payrollid'");

					if($this->db->execute()) {
						Flash::set("File uploaded");
						redirect('payouts/preview/'.$payoutid);
					}else{
						Flash::set("Something happened"  , "danger");
						redirect('payouts/preview/'.$payoutid);
					}
				}
		}
	}