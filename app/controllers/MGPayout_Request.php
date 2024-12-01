<?php 	

	class MGPayout_Request extends Controller
	{
		public function __construct()
		{
			$this->RequestModel = $this->model('MGPayout_RequestModel');
			$this->mgPayinModel  = $this->model('LDPayinModel');
			$this->FNProductBorrowerModel = $this->model('FNProductBorrowerModel');

			$this->payoutRequest = model('PayoutRequestModel');

		}	

		public function index()
		{

		}

		public function make_request()
		{
			//updated from get to post

			if( !isEqual(request()->method() , 'post') )
			{
				die("Invalid Request ");
			}

			$post = request()->inputs();

			$result = $this->payoutRequest->requestAndMoveToPeraBank($post['userid'] , $post['amount']);

			Flash::set("Request Sent");

			if(!$result) {
				Flash::set($this->payoutRequest->error , 'info');

				if(count($this->payoutRequest->errors) > 1)
					Flash::set(implode(',' , $this->payoutRequest->errors) , 'warning' , 'warnings');
			}
			return request()->return();
		}

		public function cancel_request($userid)
		{

			$res = $this->RequestModel->request_change_status($userid,'cancel');
			
			if($res) 
			{
				Flash::set("Successfully Canceled!",'danger');
			}

			redirect('users/index');

		}


		public function create_payout()
		{
			if($this->request() === 'POST') 
			{	
			
				$res = $this->RequestModel->make_cheques();
				
				if($res) 
				{
					Flash::set("Payout created!");
				}

				redirect("MGPayout_Request/create_payout");
			}else{

				$forPayout = $this->RequestModel->get_payouts();

			
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
				
			$this->view('mgpayout/create_with_request' , $data);
			}
		}



	}