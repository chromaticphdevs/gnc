<?php   
    
    class NewUserFollowUps extends Controller
    {

        public function __construct()
        {
            $this->followUp = model('NewUserFollowUpModel');
            $this->profiling = model('UserProfilingModel');
            $this->uploadedId = model('UserIdVerificationModel');
            $this->social_media = model('UserSocialMediaModel');
            $this->CallCenterModel = $this->model('CallCenterModel');
            $this->user_model = $this->model('User_model');
            Authorization::setAccess(['admin' , 'customer-service-representative']);
        }

        public function index()
        {   

            $clients  = [];
            $level = 1;
            $number_days = 7;

            if(isset($_GET['level']) && intval($_GET['level']) > 1)
            {
                $level = $_GET['level'];
                $clients = $this->followUp->getByLevel($_GET['level']);
            }else if(isset($_POST['days']) || isset($_GET['level']))
            {   
                $days = $_POST['days'] ?? 7;
                $number_days = $days;
                $clients = $this->followUp->getFirstLevel($days);
                Session::remove('SEARCHDATA');
            }else{
                
                $clients = $this->followUp->getFirstLevel($number_days);
            }
            
            $data = [
                'clients' => $clients,
                'level'   => $level,
                'number_days' => $number_days,
                'activeLevels'  => $this->followUp->getAllLevels($number_days)
            ];

            // $data = $this->filterData($clients , $level);

            return $this->view('new_user_followup/index' , $data);
        }


        public function getByAddress()
        {

            $clients  = [];
            $level = 1;

            $search_data = Session::get('SEARCHDATA') ?? "";

            
            if(empty(Session::get('SEARCHDATA')))
            {
                $address = $_POST['address'] ?? "";
                Session::set('SEARCHDATA' , $address);
            }else{

                if(!empty($_POST['address']))
                {
                     $address = $_POST['address'];
                     Session::set('SEARCHDATA' , $address);
                }else{
                     $address = $search_data;
                }
            }

            $clients = $this->followUp->getByAddress($address);    


            $data = [
                'clients' => $clients,
                'level'   => $level,
                'activeLevels'  => $this->followUp->getAllLevels()
            ];

             return $this->view('new_user_followup/by_address' , $data);
        }

         public function getByAddress_sorted()
        {

            $clients  = [];
            $level = 1;

            $search_data = Session::get('SEARCHDATA') ?? "";

            
            if(empty(Session::get('SEARCHDATA')))
            {
                $address = $_POST['address'] ?? "";
                Session::set('SEARCHDATA' , $address);
            }else{

                if(!empty($_POST['address']))
                {
                     $address = $_POST['address'];
                     Session::set('SEARCHDATA' , $address);
                }else{
                     $address = $search_data;
                }
            }

            $clients = $this->followUp->getByAddress_sorted($address);    

        
            $data = [
                'clients' => $clients,
                'level'   => $level,
                'activeLevels'  => $this->followUp->getAllLevels()
            ];

             return $this->view('new_user_followup/by_address_sorted' , $data);
        }

         public function getByAddress_sorted_globe()
        {

            $clients  = [];
            $level = 1;

            $search_data = Session::get('SEARCHDATA_GLOBE') ?? "";

            
            if(empty(Session::get('SEARCHDATA_GLOBE')))
            {
                $address = $_POST['address'] ?? "";
                Session::set('SEARCHDATA_GLOBE' , $address);
            }else{

                if(!empty($_POST['address']))
                {
                     $address = $_POST['address'];
                     Session::set('SEARCHDATA_GLOBE' , $address);
                }else{
                     $address = $search_data;
                }
            }

            $clients = $this->followUp->getByAddress_sorted($address);    

        
            $data = [
                'clients' => $clients,
                'level'   => $level,
                'activeLevels'  => $this->followUp->getAllLevels()
            ];

             return $this->view('new_user_followup/by_address_sorted_globe' , $data);
        }


        private function filterData($clients , $level)
        {
            $maxData = 100;
            $offset  = $_GET['offset'] ?? 0;

            $clients = array_splice($clients , intval($offset) , intval($offset + $maxData));

            return [
                'clients' => $clients,
                'level'   => $level,
                'activeLevels'  => $this->followUp->getAllLevels('7'),
                'maxData'  => $maxData,
                'offset'  => $offset
            ];
        }

        public function show($userIdSealed)
        {
               

            $userId = unseal($userIdSealed);

            $user = $this->followUp->getUser($userId);
            $userNotes = $this->followUp->getUserNotes($userId);
            $uploaded_id = $this->uploadedId->get_user_uploaded_id_info($userId);
            $total_social_link = $this->social_media->count_user_social_link($userId);
            $total_ds = $this->user_model->get_direct_sponsor_total($userId);

            $data = [
                'user' => $user,
                'userNotes' =>  $userNotes,
                'userIdSealed' => $userIdSealed,
                'userLevel'   => $this->followUp->userLevel($userId),
                'uploaded_id' => $uploaded_id,
                'total_social_link' => $total_social_link,
                'total_ds' => $total_ds,
                'user_profiling_info' => $this->profiling->get_user_profiling_info($userId)
            ];

            return $this->view('new_user_followup/show' , $data);
        }


        public function update()
        {

            if(isset($_POST['move_next_level']))
            {
                $this->moveNextLevel();
            }

            if(isset($_POST['do_not_follow_up']))
            {
                $this->tagUpdate('dont-follow-up');
            }

        }

        public function tagUpdate($tag)
        {   

            $userId = $_POST['user_id'] ?? 0;

            $userId = unseal($userId);

            $this->CallCenterModel->end_call($userId, $_POST['mobile']);

            $note = $_POST['note'];

            $tagUpdate = $this->followUp->updateTag($userId , $tag , $note);

            if($tagUpdate) {
                Flash::set('Tag Updated' , 'danger');
            }

            $level = $this->followUp->lastLevel;

            if(!empty(Session::get('SEARCHDATA_GLOBE')))
            {    
                 $address = Session::get('SEARCHDATA_GLOBE') ?? "";

                 $clients = $this->followUp->getByAddress_sorted($address);  

                 if(count($clients) != 0)
                 {
                    $next = null;
                    $counter = 0;
                    foreach ($clients as $key => $value) 
                    {
                       $network_sim = sim_network_identification($value->mobile);

                       if($network_sim == "Globe or TM")
                       {
                            $counter++;

                            if($counter==1)
                            {
                                 $next = seal($value->id);
                            }
                       }
                    }

                    if($counter > 0 AND !empty($next) )
                    {
                        return redirect("/NewUserFollowUps/show/{$next}");
                    }
                 }
                
                 return redirect("NewUserFollowUps/getByAddress_sorted_globe");

            }if(!empty(Session::get('SEARCHDATA')))
            {
                 return redirect("NewUserFollowUps/getByAddress");
            }else
            {
                 return redirect("NewUserFollowUps/index?level={$level}");
            }

           
        }

        public function moveNextLevel()
        {
            $userId = $_POST['user_id'] ?? 0;

            $note = $_POST['note'];

            if(!$userId) {
                Flash::set("Invalid User" , 'danger');
                return request()->return();
            }

            $userId = unseal($userId);

            $this->CallCenterModel->end_call($userId, $_POST['mobile']); 

            $info = $this->profiling->save_user_profiling($_POST, $userId);
            
            $result = $this->followUp->moveNextLevel($userId , $note);

            if($result) {
                Flash::set("User moved to next level");
            }else{
                Flash::set($this->followUp->errString , 'danger');
                return request()->return();
            }
            //get users last level
            $level = $this->followUp->lastLevel;

            if(!empty(Session::get('SEARCHDATA_GLOBE')))
            {
                
                 $address = Session::get('SEARCHDATA_GLOBE') ?? "";

                 $clients = $this->followUp->getByAddress_sorted($address);  
              
                 if(count($clients) != 0)
                 {
                    $next = null;
                    $counter = 0;
                    foreach ($clients as $key => $value) 
                    {
                       $network_sim = sim_network_identification($value->mobile);

                       if($network_sim == "Globe or TM")
                       {
                            $counter++;

                            if($counter==1)
                            {
                                 $next = seal($value->id);
                            }
                       }
                    }

                    if($counter > 0 AND !empty($next) )
                    {
                        return redirect("/NewUserFollowUps/show/{$next}");
                    }
                 }
                
                 return redirect("NewUserFollowUps/getByAddress_sorted_globe");

            }if(!empty(Session::get('SEARCHDATA')))
            {
                 return redirect("NewUserFollowUps/getByAddress");
            }else
            {
                 return redirect("NewUserFollowUps/index?level={$level}");
            }

           
        }


        public function archives()
        {
            $data = [
                'clients' => $this->followUp->getByTag('dont-follow-up'),
                'activeLevels'  => $this->followUp->getAllLevels()
            ];

            return $this->view('new_user_followup/index' , $data);

        }
    }