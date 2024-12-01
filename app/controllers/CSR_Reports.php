<?php   

    class CSR_Reports extends Controller
    {
        
        public function __construct()
        {
           parent::__construct();
           $this->CSR_ReportsModel = model('CSR_ReportsModel');
           $this->csr = model('CSR_TimesheetModel');
        }

        public function index()
        {   
            $condition  = "ALL";

            $sorted_call_duration = "";

            if(isset($_GET['user_id']))
            {
                 $condition = unseal($_GET['user_id']);

                 $csr_list = $this->CSR_ReportsModel->get_call_history($condition, $_GET['account_type']);

                 $sorted_call_duration = $this->CSR_ReportsModel->get_sorted_duration($condition, $_GET['account_type']);

            }else
            {
                 $csr_list = $this->CSR_ReportsModel->get_call_history($condition);
            }

            foreach($csr_list as $key => $value) 
            {
                if($value->account_type == "user")
                {
                    $value->wallet = $this->csr->getTotal($value->user_id);
                }else
                {
                     $value->wallet = $value->allowance;
                }
                
            }

          
            $data = [
                  'get_call_history'  => $csr_list,
                  'condition' =>  $condition,
                  'sorted_call_duration' => $sorted_call_duration,
                  'navigationHelper' => $this->navigationHelper
            ];
            
            return $this->view('csr/report_chart', $data);
            
        }


        public function get_chart()
        {   
            $account_type = "";

            if(Session::check('BRANCH_MANAGERS'))
            {
                $account_type = "manager";

            }else if(Session::check('USERSESSION'))
            {
                $account_type = "user";
            }

            if($this->request() === 'POST')
            {        
                $user_id  = unseal($_POST['user_id']);
   
                $this->CSR_ReportsModel->get_chart($user_id,$account_type);
            }
        }


        public function get_todays_report()
        {   
            $sorted_call_duration = "";

            if($this->request() === 'POST')
            { 
                $date = $_POST['picked_date'];
                $call_history_today = $this->CSR_ReportsModel->get_call_history_today($date);
                $data = [
                      'get_call_history'  => $call_history_today,
                      'date_search'  =>  $date,
                      'sorted_call_duration' => $this->CSR_ReportsModel->get_sorted_duration_today( $date , $call_history_today )
                    ];
            }else
            {   
                $date = date("Y-m-d");
                $call_history_today = $this->CSR_ReportsModel->get_call_history_today($date);
                $data = [
                      'get_call_history'  => $call_history_today,
                      'date_search'  =>  $date,
                      'sorted_call_duration' => $this->CSR_ReportsModel->get_sorted_duration_today($date, $call_history_today ) ,
                      'navigationHelper' => $this->navigationHelper
                ];
        
            }

             return $this->view('csr/report_chart_today', $data);
        }



        /*public function get_todays_chart()
        {
            if($this->request() === 'POST')
            {      
                $user_id  = unseal($_POST['user_id']);
   
                $this->CSR_ReportsModel->get_chart($user_id);
            }
        }*/
    }