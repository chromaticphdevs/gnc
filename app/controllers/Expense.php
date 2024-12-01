<?php

	class Expense extends Controller
	{
		public function __construct()
		{
			$this->ExpenseModel = $this->model('ExpenseModel');
	
		}

		public function index()
		{

		}

		public function make_request()
		{
			if(Session::check('BRANCH_MANAGERS'))
			{	
				$user = Session::get('BRANCH_MANAGERS');

				if($this->request() === 'POST')
				{


				  $pathUpload = PATH_UPLOAD.DS.'expense_proof';

			      $file = upload_file('file' , $pathUpload);

			      if($file['status'] == 'failed')
			      {
			        Flash::set("File upload failed" , 'danger');
			        return request()->return();
			      }

			      $result = $this->ExpenseModel->store([
			        'userid'   => $user->id,
			        'amount'   => $_POST['amount'],
			        'branchid' => $user->branchid,
			        'filename' => $file['result']['name'],
			        'path'     => $file['result']['path'],
			        'note'     => $_POST['note']
			      ]);

			      if(!$result) {
			        Flash::set("Something went wrong." , 'danger');
			        return request()->return();
			      }

			      Flash::set("You're Expense Request is Now Pending");

			      return redirect("Expense/make_request");
		
				}else{
				
					$data = [
						'requestList' => $this->ExpenseModel->get_user_request($user->id)
					];

					$this->view('expense/request',$data);
				}
			
			}else{
				Flash::set("Please Login");
				return redirect("Users/login");
			}
		}

		public function change_status()
		{
			if($this->request() === 'POST')
			{	
			
				$processed_by = 0;
				if(isset($_POST['processed_by']))
				{	
					$processed_by = $_POST['processed_by'];
				}

				$note = $_POST['note'];
				if($_POST['status'] != "approved")
				{
					$note = null;
				}


				$result = $this->ExpenseModel->change_status($_POST['id'], $_POST['status'], $note, $processed_by);

				//deduct amount from cashier wallet
				if($_POST['status'] == 'released')
				{
					$this->ExpenseModel->wallet_deduction($_POST['id'], $processed_by);
				}
	
				// change status and record it
				if($_POST['status'] != 'canceled' && $_POST['status'] != 'pending')
				{
					$this->ExpenseModel->process_request($_POST['id'], $_POST['status'], $processed_by);
				}

				if($result)
				{
					Flash::set("Request is Now {$_POST['status']}");
		        	return request()->return();
				}else
				{
					Flash::set("Something went Wrong");
		        	return request()->return();
				}
			}
		}

	
		public function get_request()
		{	
			$branchid = $this->check_session();

			$data = [
					'List' => $this->ExpenseModel->get_list_all($branchid, 'pending'),
					'userid' => $this->get_userid()
				];

			$this->view('expense/list',$data);
		} 

		public function get_approved()
		{	
			$branchid = $this->check_session();
			$data = [
					'List' => $this->ExpenseModel->get_list_all($branchid, 'approved'),
					'userid' => $this->get_userid()
				];

			$this->view('expense/make_release',$data);
		} 

		public function get_released()
		{	
			$branchid = $this->check_session();
			$userid = Session::get('BRANCH_MANAGERS')->id;
			$data = [
					'List' => $this->ExpenseModel->get_released($branchid, $userid)
				];

			$this->view('expense/released_list',$data);
		} 

		public function get_approved_history()
		{	
			$branchid = $this->check_session();
			$data = [
					'List' => $this->ExpenseModel->get_approved_history($branchid, 'approved'),
					'userid' => $this->get_userid()
				];

			$this->view('expense/approved_list',$data);
		} 

		public function get_all_records()
		{	
			$branchid = $this->check_session();
			$data = [
					'List' => $this->ExpenseModel->get_all_records(),
					'userid' => $this->get_userid()
				];

			$this->view('expense/all_records',$data);
		} 

		private function check_session()
		{
			if(Session::check('BRANCH_MANAGERS'))
			{
				$user = Session::get('BRANCH_MANAGERS');
				$branchid = $user->branchid;
				return $branchid;

			}else if(Session::check('USERSESSION'))
			{
				$branchid = 8;
				return $branchid;

			}else{
				redirect('user/login');
			}
		}

		private function get_userid()
		{
			if(Session::check('BRANCH_MANAGERS'))
			{
				$user = Session::get('BRANCH_MANAGERS');
				$userid = $user->id;
				return $userid;

			}else if(Session::check('USERSESSION'))
			{
				$user = Session::get('USERSESSION');
				$userid = $user['id'];
				return $userid;

			}else{
				redirect('user/login');
			}
		}


	}
