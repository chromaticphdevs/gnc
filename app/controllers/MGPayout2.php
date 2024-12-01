<?php 	

	class MGPayout2 extends Controller
	{
		public function __construct()
		{
			$this->mgPayoutModel = $this->model('MGPayoutModel2');
			$this->mgPayinModel  = $this->model('LDPayinModel');
			$this->FNProductBorrowerModel = $this->model('FNProductBorrowerModel');

		}

		public function create_payout()
		{
			if($this->request() === 'POST') 
			{	

				$res = $this->mgPayoutModel->make_cheques();
				
				if($res) 
				{
					Flash::set("Payout created!");
				}

				redirect('MGPayout2/create_payout');
			}else{

			
				$forPayout = $this->mgPayoutModel->get_for_payouts();

				$data = [
					'title' => 'Generate Payout'
				];

				$data['forPayout'] = [
					'details'  => $forPayout['details'],
					'list'  => $forPayout['list'],
					'total' => $forPayout['total']
				];

				if(!empty($forPayout['list']))
				{
					$enddate = $data['forPayout']['details']->dateend ?? date('Y-m-d h:i:s');

					$datenow = date('Y-m-d h:i:s');

					$payins = $this->mgPayinModel->get_payins($enddate , $datenow);

					$data['payins'] = [
						'list' => $payins['list'],
						'total' => $payins['total']
					];
				}

				/*temporary*/
				if(isset($data['payins']['list']))
				{
					/*calculate percentage*/

					$totalPayout = $data['forPayout']['total'];

					$totalPayins = $data['payins']['total'];
					
					if($totalPayins <= 0) {
						$payoutPercentage = "No Pay-ins gathered";
					}else{
						$payoutPercentage = ceil(($totalPayout / $totalPayins) * 100);
					}

					$data['payoutPercentage'] = $payoutPercentage;
					
				}
				
			$this->view('mgpayout/create2' , $data);
			}	
		}





//with valid ID=---------------------------------------------------------------------------------------------
		public function create_payout_valid_id()
		{
			if($this->request() === 'POST') 
			{	
				$amount =$_POST['amount'];
				$res = $this->mgPayoutModel->make_cheques_valid_id($amount);
				
				if($res) 
				{
					Flash::set("Payout created!");
				}

				redirect("MGPayout2/create_payout_valid_id?amount={$amount}");
			}else{

				$forPayout = $this->mgPayoutModel->get_for_payouts_valid_id($_GET['amount']);

			
				$unpaid_amount_count = $this->FNProductBorrowerModel->group_by_amount('8', '7');
				// get total unpaid product
				$product_paid = $this->FNProductBorrowerModel->get_released_product_all('8', '7');
			
				$total_not_paid = 0;
				foreach ($product_paid as $key => $value) 
		        {
		       		if($value->status == "Approved")
		        	{
		        		 $total_not_paid += $value->amount;	
		        	}
		        }
		        // end
		        $products_amount_count = $this->mgPayinModel->group_by_amount();
				$data = [
					'title' => 'Generate Payout',
					'total_not_paid' => $total_not_paid,
					'products_amount_count' => $products_amount_count,
					'unpaid_amount_count' => $unpaid_amount_count
				];

				$data['forPayout'] = [
					'details'  => $forPayout['details'],
					'list'  => $forPayout['list'],
					'total' => $forPayout['total']
				];

				if(!empty($forPayout['list']))
				{
					$enddate = $data['forPayout']['details']->dateend ?? date('Y-m-d h:i:s');

					$datenow = date('Y-m-d h:i:s');

					$payins = $this->mgPayinModel->get_payins($enddate , $datenow);

					$data['payins'] = [
						'list' => $payins['list'],
						'total' => $payins['total']
					];
				}

				/*temporary*/
				if(isset($data['payins']['list']))
				{
					/*calculate percentage*/

					$totalPayout = $data['forPayout']['total'];

					$totalPayins = $data['payins']['total'];
					
					if($totalPayins <= 0) {
						$payoutPercentage = "No Pay-ins gathered";
					}else{
						$payoutPercentage = ceil(($totalPayout / $totalPayins) * 100);
					}

					$data['payoutPercentage'] = $payoutPercentage;
					
				}
				
			$this->view('mgpayout/create_with_valid_id2' , $data);
			}
		}
//with valid ID=-------------END----------------------------------------------------------------------------------


		public function get_payins_with_option()
		{
			if($this->request() === 'POST') 
			{	

				$payins = $this->mgPayinModel->get_payins_with_option($_POST['days']);

				$data['payins'] = [
					'list' => $payins['list'],
					'total' => $payins['total']
				];	

			}else{
				
				$datenow = date('Y-m-d h:i:s');
				$payins = $this->mgPayinModel->get_payins_with_option($datenow);

				$data['payins'] = [
					'list' => $payins['list'],
					'total' => $payins['total']
				];			
			}	

			$this->view('mgpayout/pay_ins_with_options' , $data);
		}



		public function export()
        {
            if($this->request() === 'POST')
            {
                $exportData = (array) unserialize(base64_decode($_POST['users']));


                $result = objectAsArray($exportData);

                $header = [
                    'username'  => 'Username',
                    'fullname' => 'Fullname',
                    'amount'  => 'Amount Payout'           
                ];

                export($result , $header);

               // redirect('FNProductBorrower/get_product_borrower');
            }
        }


		private function get_payin($datestart , $dateend)
		{
			$payinModel = $this->model('LDPayinModel');

			$payins = $payinModel->get_list($datestart , $dateend);

		}


		public function list()
		{	
			$payoutList =  $this->mgPayoutModel->get_all_payouts();
			$total_payout=0;

			foreach ($payoutList as $key => $value) {
					$total_payout = $total_payout+$value->amount;
			}


			$data = 
			[
				'payoutList' => $payoutList,
				'total_payout' => $total_payout
			];

			$this->view('mgpayout/list' , $data);
		}
	}