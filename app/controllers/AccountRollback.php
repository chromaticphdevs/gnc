<?php 	
	
	class AccountRollback extends Controller
	{

		public function __construct()
		{
			$this->user = model('User_model');
		}

		public function rollback()
		{
			if(!isEqual($this->request() , 'post')){

				Flash::set("Invalid Request Failed", 'danger');
				return request()->return();
			}

			$post = request()->inputs();
			$errors = [];

			if( empty($post['upline']) ) {
				$errors[] = " Invalid Upline";
			}
			if( empty($post['directSponsor']) ){
				$errors[] = "Invalid Direct Sponsor";
			}

			if(!empty($errors)) {
				$message = implode(',' , $errors) . "<strong> IMPORTANT : Please Report to the administrators </strong>";
				Flash::set( $message , 'danger');
				return request()->return();
			}

			$password = password_hash('123456', PASSWORD_DEFAULT);
			
			$result = $this->user->dbupdate([
				'upline' => $post['upline'],
				'direct_sponsor' => $post['directSponsor'],
				'password'  => $password
			] , $post['userid']);


			Flash::set("Upline and Sponsor Rolled Back");

			if(!$result)
				Flash::set("SOMETHING WENT WRONG <strong> IMPORTANT : Please Report to the administrators </strong>");

			return request()->return();
		}
	}