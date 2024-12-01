<?php

	class ISP extends Controller
	{
		public function __construct()
		{
			// if(Session::get('USERSESSION')['type'] != '1')
			// {
			// 	err_404();
			// }

			$this->isp_model = $this->model('isp_model');

		}
		public function index()
		{
			Authorization::setAccess(['admin']);
			if(isset($_GET['userid']))
			{
				$user_id = $_GET['userid'];

				$this->user_model = $this->model('user_model');

				$data = [
					'isp' => $this->isp_model->get_info($user_id) ,
					'user' => $this->user_model->get_user_by_id($user_id)
				];

				$this->view('isp/index' , $data);
			}else{

				$data = [
					'isp' => $this->isp_model->get_info(NULL)
				];

				$this->view('isp/index' , $data);

			}
		}

		public function top($level = 100)
		{
			Authorization::setAccess(['admin']);
			//get highest money
			$this->user_model = $this->model('user_model');

			$user_list_money = $this->isp_model->get_user_total_desc($level);

			foreach($user_list_money as $user_money)
			{
				$user = $this->user_model->get_user($user_money->user_id);

				if($user)
				{
					$user_money->fullname = $user->fullname;
					$user_money->username = $user->username;
				}
				// var_dump_pre($user_money->commission);	
			}
			$data = [
				'isp_list' => $user_list_money,
				'level'    => $level
			];

			$this->view('isp/top' , $data);
		}

		// public function top()
		// {
		// 	$isp_list = $this->isp_model->get_users_total(NULL);

		// 	$user_list = array();
		// 	$transactions = array();
		// 	$trans_amount = 0;
		// 	foreach($isp_list as $isp)
		// 	{
		// 		if(!isset($id))
		// 		{
		// 			$id = $isp->user_id;
		// 		}

		// 		if($id == $isp->user_id)
		// 		{
		// 			array_push($transactions,['transaction'=>$isp->trans, 'instance'=>$isp->instance , 'amount'=>$isp->total_amount]);
		// 			$trans_amount += $isp->total_amount; 

		// 		}else if($id != $isp->user_id)
		// 		{
		// 			$user = new stdClass();

		// 			$user->id = $isp->user_id;
		// 			$user->fullname = $isp->fullname;
		// 			$user->username = $isp->username;

		// 			$user->transaction_list = $transactions;
		// 			$user->total_amount = $trans_amount;

		// 			array_push($user_list,$user);

		// 			$transactions = array();
		// 			$trans_amount = 0;
		// 			$id = $isp->user_id;
		// 		}
		// 	}


			// $user_list = $this->merge_sort($user_list);

			// $user_list = array_reverse($user_list);

		// 	$data = [
		// 		'isp_list' => $user_list
		// 	];

		// 	$this->view('isp/top' , $data);
		// }

		public function merge_sort($my_array){
			if(count($my_array) == 1 ) return $my_array;

			$mid = count($my_array) / 2;

		    $left  = array_slice($my_array, 0, $mid);
		    $right = array_slice($my_array, $mid);

			$left  =  $this->merge_sort($left);
			$right = $this->merge_sort($right);

			return $this->merge($left, $right);
		}

		public function merge($left, $right){
			$res = array();

			while (count($left) > 0 && count($right) > 0){
				if(strtotime($left[0]->total_amount) > strtotime($right[0]->total_amount)){
					$res[] = $right[0];
					$right = array_slice($right , 1);
				}else{
					$res[] = $left[0];
					$left = array_slice($left, 1);
				}
			}
			while (count($left) > 0){
				$res[] = $left[0];
				$left = array_slice($left, 1);
			}
			while (count($right) > 0){
				$res[] = $right[0];
				$right = array_slice($right, 1);
			}
			return $res;
		}
	}