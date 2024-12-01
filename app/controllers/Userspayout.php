<?php

	class Userspayout extends Controller
	{
		public function __construct()
		{
			$this->user_payout_model = $this->model('user_payout_model');
			$this->binarypv_model  = $this->model('binarypv_model');
			$this->sponsor_model = $this->model('sponsor_model');
		}


		public function index()
		{
			$user_id = Session::get('USERSESSION')['id'];

			$res = $this->user_payout_model->getPayouts($user_id);

			$data = [
				'lists' => $res
			];
			$this->view('userpayout/index' , $data);
		}


		public function preview($payout_id)
		{
			$user_id = Session::get('USERSESSION')['id'];
			//payout details

			$p_out_details = $this->user_payout_model->getPayoutId($payout_id , $user_id);

			$start = $p_out_details->date_from;
			$end   = $p_out_details->date_to;

			$bnary_com   = $this->binarypv_model->getCommissionDate($start , $end , $user_id);
			$sponsor_com = $this->sponsor_model->getCommission($start,$end,$user_id);

			$data = [
				'payout' => $p_out_details , 
				'bnary'  => $bnary_com,
				'sponsor' => $sponsor_com
			];

			$this->view('userpayout/view' , $data);
		}
		// public function index($cheque_id)
		// {
		// 	$this->user_payout_model($cheque_id);
		// }
	}