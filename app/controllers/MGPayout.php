<?php

	class MGPayout extends Controller
	{
		public function __construct()
		{
			$this->mgPayoutModel = $this->model('MGPayoutModel');

			$this->mgPayinModel  = $this->model('LDPayinModel');

		}


		public function index()
		{
			$forPayout = $this->mgPayoutModel->get_for_payouts();

			$data = [
				'title' => 'Payout',
				'pageTable' => 'payout'
			];

			$data['forPayout'] = [
				'details'  => $forPayout['details'],
				'list'  => $forPayout['list'],
				'total' => $forPayout['total']
			];

			if(!empty($forPayout['list']))
			{
				$enddate = $data['forPayout']['details']->dateend ?? date('Y-m-d', strtotime('2018-1-12'));

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

			if(isset($_GET['content']))
			{
				if(strtolower($_GET['content']) == 'payin'){
					$data['title'] = 'Pay-Ins';
					$data['pageTable'] = 'pay-in';
				}
			}

			return $this->view('mgpayout/create' , $data);
		}

		public function exportExcel()
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
			}
		}

		public function createPayout()
		{
			if($this->request() !== 'POST'){
				Flash::set("Invalid Request");
				return request()->return();
			}

			$res = $this->mgPayoutModel->make_cheques();

			Flash::set("Payout created!");

			if(!$res) {
					Flash::set("SNAP! Something went wrong please send error to webmasters");
			}
			return redirect('MGPayout/');
		}

//with valid ID=---------------------------------------------------------------------------------------------
		public function create_payout_valid_id()
		{
			if($this->request() === 'POST')
			{
				die(var_dump($_POST['amount']));
				$res = $this->mgPayoutModel->make_cheques_valid_id($_POST['amount']);

				if($res)
				{
					Flash::set("Payout created!");
				}

				redirect('MGPayout/create_payout_valid_id');
			}else{

				$forPayout = $this->mgPayoutModel->get_for_payouts_valid_id($_GET['amount']);

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

			$this->view('mgpayout/create_with_valid_id' , $data);
			}
		}
//with valid ID=-------------END----------------------------------------------------------------------------------

		private function get_payin($datestart , $dateend)
		{
			$payinModel = $this->model('LDPayinModel');

			$payins = $payinModel->get_list($datestart , $dateend);

		}


		public function list()
		{
			$data =
			[
				'payoutList' => $this->mgPayoutModel->get_list_with_total()
			];

			$this->view('mgpayout/list' , $data);
		}
	}
