<?php
  class ClientPaymentSearch extends Controller
  {

  	 public function __construct()
    {
      $this->userModel = $this->model('User_model');
      $this->fnproductBorrower = $this->model('FNProductBorrowerModel');
      $this->fnproductRelease = $this->model('FNProductReleaseModel');
      $this->fnproductReleasePayment = $this->model('FNProductReleasePaymentModel');
    }


    public function index()
    {

    	return $this->view('client_payment_search/index');
    }

    public function getUserProductLoan()
    {
    	check_session();
        $data = [];


        if(!isset($_GET['user_id']) || empty($_GET['user_id'])) {
          Flash::set("Invalid Request, a user must be set" , 'danger');
          return request()->return();
        }

        $user_id = $_GET['user_id'];

        $user = $this->userModel->get_user($user_id);

        $data = [
          'userInfo' => $user,
          'loans' => $this->fnproductBorrower->get_user_unpaid_loans($user_id)
        ];

        return $this->view('client_payment_search/client_loans' , $data);

    }
  }