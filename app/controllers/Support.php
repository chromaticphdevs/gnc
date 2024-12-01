<?php   

    class Support extends Controller
    {   
        public function __construct()
        {   
            $this->userModel = $this->model('LDUserModel');
        }
        public function update()
        {
            $requests = request()->inputs();

            if(isset($requests['userid'] , $requests['sponsorid'] , $requests['uplineid']))
            {
                $userid = $requests['userid'];
                $sponsorid = $requests['sponsorid'];
                $uplineid  = $requests['uplineid'];
                
                if(empty($requests['position']))
                {
                    $result = $this->userModel->update(
                        [
                            'direct_sponsor' => $sponsorid,
                            'upline' => $uplineid
                        ] , $userid
                    );
                }else{
                    $result = $this->userModel->update(
                        [
                            'direct_sponsor' => $sponsorid,
                            'upline' => $uplineid,
                            'L_R'    => strtoupper($requests['position'])
                        ] , $userid
                    );
                }
                

                if(!$result) {
                    Flash::set("Someting went wrong" , 'danger');

                    return request()->return();
                }

                Flash::set("Update Success");

                return redirect("Support/?page=sponsor_and_upline_desk");
            }else{

                Flash::set("Invalid Request Please select users first before saving" , 'danger');

                return validationFailed();
            }

        }
        public function index()
        {
            if(!isset($_GET['page']))
            {   
                Flash::set("Invalid request" , 'danger');
                return request()->return();
            }

            $page = $_GET['page'];

            switch($page)
            {
                case 'sponsor_and_upline_desk':
                    $data = [
                        'title' => 'Accont Sponsor and Upline Help Desk'
                    ];

                    $this->view('support/sponsor_and_upline_desk' , $data);
                break;
            }
        }
    }