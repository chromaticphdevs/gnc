<?php
	class Commissions extends Controller{

		private $_userId;

		public function __construct()
		{

			$this->_userId = Session::get('USERSESSION')['id'];

			$this->commission_model =  $this->model('commission_model');
			$this->binarypv_model = $this->model('binarypv_model');
		}

		// get total drc, binary, unilvl, mentor by date
		public function getToday()
		{
			Authorization::setAccess(['admin']);

			$this->_userId = Session::get('USERSESSION')['id'];

			$number_of_days = 1;

			if($this->request() === 'POST')
			{
				$number_of_days =  $_POST['number_of_days'];

				$bCommissions  = $this->binarypv_model->pair_tracker_by_date($this->_userId, $_POST);

				$dsCommissions = $this->commission_model->getSponsorCommission_by_date($this->_userId, $_POST);

			}else
			{
				$number =[
					'number_of_days'	=> 1
				];

				$bCommissions  = $this->binarypv_model->pair_tracker_by_date($this->_userId, $number);

				$dsCommissions = $this->commission_model->getSponsorCommission_by_date($this->_userId, $number);


			}

			$allCommissions = $this->combineArray([$bCommissions , $dsCommissions]);

			$data = [
				'commissions' => $this->comSort($allCommissions),
				'number_of_days' => $number_of_days
			];
			$this->view('commission/today' , $data);
		}



		public function index()
		{
			Authorization::setAccess(['admin' , 'user']);

			$this->commissionModel = $this->model('CommissionTransactionModel');

			$user = Session::get('USERSESSION');

			if($user['type'] == '1') {
				$data['commissions'] = $this->commissionModel->get_commissions();

			}else{
				$data['commissions'] = $this->commissionModel->get_commissions($user['id']);
			}

			if(isset($_GET['filter']))
			{
				$startDate = $_GET['start_date'];
				$endDate = $_GET['end_date'];
				$commissionType = $_GET['type'];

				$user   = isset($_GET['user']) ? $_GET['user'] : Session::get('USERSESSION')['username'];

				$data['commissions'] = $this->commissionModel->getFiltered($commissionType , $user , $startDate , $endDate);
			}

			$data['commissionTypes'] = [
				'DRC',
				'UNILEVEL',
				'BINARY',
				'MENTOR',
				'CA_PAYMENT',
				'ALL'
			];

			return $this->view('commission/all' , $data);
		}

		public function get_list()
		{
			Authorization::setAccess(['admin' , 'user']);

			$userid = Session::get('USERSESSION')['id'];

			$this->commissionModel = $this->model('CommissionTransactionModel');

			$result = [];

			if(isset($_GET['type']))
			{
				$type = $_GET['type'];

				switch ($type) {
					case 'drc':
						$result = $this->commissionModel->get_commissions_by_type($userid , 'drc');
						break;
					case 'unilevel':
						$result = $this->commissionModel->get_commissions_by_type($userid , 'unilevel');
						break;
					case 'mentor':
						$result = $this->commissionModel->get_commissions_by_type($userid , 'mentor');
						break;
					case 'binary':
						$result = $this->commissionModel->get_commissions_by_type($userid , 'binary');
						break;
				}

				$data = [
					'title' => 'Commissions' ,
					'type'  => ucwords($type),
					'commissionList' => $result
				];

				return $this->view('commission/list' , $data);
			}else{

				die('Something went wrong');
			}
		}

		private function combineArray(?array $to_combine)
		{
			$combined = array();

			foreach($to_combine as $array)
			{
				foreach($array as $values)
				{
					array_push($combined, $values);
				}
			}
			return $combined;
		}
		private function comSort(?array $commissions)
		{
			$sorted = $commissions;

			if(count($commissions) > 1)
			{
				for($x = 0 ; $x < count($sorted) ;$x++)
				{
					for($y = 0 ; $y < count($sorted) ;$y++)
					{
						if($sorted[$x]->dt > $sorted[$y]->dt)
						{
							$tmp = $sorted[$x];
							$sorted[$x] = $sorted[$y];
							$sorted[$y] = $tmp;
						}
					}
				}
			}

			return $sorted;

		}
		public function binaryCommissions()
		{
			Authorization::setAccess(['admin' , 'user']);
			$userid = Session::get('USERSESSION')['id'];
			$this->commissionModel = $this->model('CommissionTransactionModel');

			$data = [
				'title'       => 'Binary Commissions',
				'commissions' => $this->commissionModel->get_commissions_by_type($userid , 'binary')
			];

			$this->view('commission/all' , $data);

		}

		public function directsponsors($user_id = null)
		{
			Authorization::setAccess(['admin' , 'user']);

			if(Auth::user_position() === '1')
			{
				if($user_id != null)
				{
					$this->_userId = $user_id;
				}else{
					$this->_userId = Session::get('USERSESSION')['id'];
				}
			}
			else{
				//
				$this->_userId = Session::get('USERSESSION')['id'];
			}

			$data = [
				'dsCommissions' => $this->getSponsorCommission($this->_userId)
			];

			$this->view('commission/index' , $data);
		}
		private function getSponsorCommission($user_id)
		{
			return $this->commission_model->getSponsorCommission($user_id);
		}
		private function getBinaryPoints($user_id)
		{
			return $this->commission_model->getBinaryPoints($user_id);
		}
	}
