<?php 	

	class TestingPage extends Controller{

		public function __construct()
		{

			$this->testing_model = $this->model('testing_model');
			$this->binarypv_model = $this->model('binarypv_model');
			$this->sponsor_model = $this->model('sponsor_model');
			$this->wallet_model   = $this->model('wallet_model');

		}

		public function commission()
		{	
			$user = isset($_GET['user']) ? $_GET['user']: null;
			
			if($user == null)
			{
				$data = [
					'users' => $this->testing_model->user_list()
				];

				$this->view('testing/commission' , $data);
			}
			else{
				$data = [
					'user' => $this->testing_model->user($user) , 
					'binarypv' => $this->binarypv_model->get_bpv($user),
					'all_wallet' => $this->wallet_model->wallet_balance($user),
					'wallet_balance' => $this->wallet_model->get_wallet_balance($user),
					'withdraw_total'  => $this->wallet_model->get_withraw_total($user) ,


					'w_tracker'     => $this->wallet_model->withdrawals($user),
					'point_tracker' => $this->binarypv_model->point_tracker($user),
					'pair_tracker'  => $this->binarypv_model->pair_tracker($user),

					'drc_tracker'   => $this->sponsor_model->get_drc($user) ,
					'unilvl_tracker' => $this->sponsor_model->get_unilvl($user)
				];

				$this->view('testing/commission' , $data);
			}
			
		}
	}