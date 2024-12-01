<?php 	
	class Admin extends Controller
	{
		/*ADMINISTRATOR PASSSWORD 5641231
		LIVE:5641231*/
		private $user_id;
		private $user_type;
		
		public function __construct()
		{
			parent::__construct();


			if(is_logged_in()){
				$this->user_id = Session::get('USERSESSION')['id'];
				$this->user_type = Session::get('USERSESSION')['type'];
			}

			$this->user_model = $this->model('user_model');

			$this->transaction_model = $this->model('transaction_model');

			
		}

		public function index()
		{	
			Authorization::setAccess(['admin']);
			
			$this->DeviceModel = $this->model('DeviceModel');

			$data  = [
				'title' => 'Admin',
				'device_state' => $this->DeviceModel->get_device_state()
			];


			if($this->request() === 'POST')
			{
				

				$data['today'] = [
						'account' => 
						[
							'list'   =>  $this->user_model->get_activated_users_today($_POST),
							'total'  =>  $this->user_model->get_activated_users_total_today($_POST),
							'device_state' => $this->DeviceModel->get_device_state()
						]
					];
	
			}else{

				

				$number =[
					'number_of_days'	=> 1
				];

				$data['today'] = [
						'account' => 
						[
							'list'   =>  $this->user_model->get_activated_users_today($number),
							'total'  =>  $this->user_model->get_activated_users_total_today($number),
							'device_state' => $this->DeviceModel->get_device_state()
						]
					];
			}
			$this->view('admin/index' , $data);

		}


		public function login()
		{
			if( isEqual($this->request() , 'POST') ) 
			{
				$username = $_POST['username'];
				$password = $_POST['password'];

				$res = $this->user_model->user_login($username , $password , 1);

				if(!$res) {
					Flash::set("User not found" , 'danger');
					return request()->return();
				}

				if( !password_verify($password, $res->password) ){
					Flash::set("Passowrd unmatched" , 'danger');
					return request()->return();
				}

				$user_session = [
					'id'           => $res->id ,
					'type'         => $res->user_type,
					'selfie'       => $res->selfie,
					'firstname'    => $res->firstname,
					'lastname'     => $res->lastname,
					'username'     => $res->username,
					'status'       => $res->status,
					'is_activated'    => $res->is_activated,
					'branchId'   => $res->branchId,
					'account_tag' => $res->account_tag
				];
				
				Session::set('USERSESSION' , $user_session);

				set_logged_in();//set user login

				Flash::set("Welcome back {$res->firstname}");
				return redirect('/FNCashAdvance/index');
			}else{

				// if(!isset($_GET['token'])){
				// 	Flash::set('invalid request' , 'danger');
				// 	return request()->return();
				// }

				// if( !isEqual($_GET['token'] , 'my-token-admin')){
				// 	Flash::set('unmatched token' , 'danger');
				// 	return request()->return();
				// }

				return $this->view('admin/login');
			}
		}
		
		private function call_order_model()
		{
			$this->order_model = $this->model('order_model');
		}


        function CallAPI_itexmo($data = false)
        {	
        	$url = "https://www.itexmo.com/php_api/apicode_info.php?apicode=ST-BREAK884834_MERSX";
            $method = 'GET';

            $curl = curl_init();
            switch ($method)
            {
                case "POST":
                    curl_setopt($curl, CURLOPT_POST, 1);

                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                case "PUT":
                    curl_setopt($curl, CURLOPT_PUT, 1);
                    break;
                default:
                    if ($data)
                        $url = sprintf("%s?%s", $url, http_build_query($data));
            }


            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($curl);

            curl_close($curl);

			$obj = json_decode($result);

			if(!empty($obj))
			{
		 		foreach($obj as $key => $value) {
				    echo $value->MessagesLeft;
				}
			}else{
				echo '0';
			}
			
        }
	}