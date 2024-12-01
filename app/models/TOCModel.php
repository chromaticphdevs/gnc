<?php   

    class TOCModel extends Base_model
    {

        public $table = 'toc_passers';

        public function __construct()
        {
            parent::__construct();

            $this->borrowerCXModel = model('FNProductBorrowerCXModel');
        }

        public function getByUser($userId)
        {
            $data = [
                $this->table,
                '*',
                " userid = '$userId'"
            ];

            return $this->dbHelper->single( ...$data );
        }
        public function standBy($userId)
        {
            //get userid
            $isExists = $this->getByUser($userId);

            if($isExists) 
            {
                $updateData = [
                    $this->table,
                    [
                        'is_standby' => true
                    ],
                    " userid = '{$userId}' "
                ];

                return  $this->dbHelper->update( ...$updateData );
            }else
            {
                $today = today();
                //get previous step
                //create step
                $data = [
                    $this->table,
                    [
                        'userid'   => $userId,
                        'position' => 1,
                        'loanId'   => $loanId,
                        'is_paid'  => false,
                        'is_standby' => true
                    ]
                ];
                return $this->dbHelper->insert(...$data);
            }
            
        }

        public function remove_standBy($userId)
        {
            $updateData = [
                $this->table,
                [
                    'is_standby' => false
                ],
                " userid = '{$userId}' "
            ];

            return  $this->dbHelper->update( ...$updateData );
        }

        public function moveToNextStep($userId , $loanId)
        {
            $today = today();
            //get previous step
            $currentStep = $this->getCurrentStep($userId);
            
           // dump($currentStep);
            $position = 2;
            //create step
            if( !$currentStep )
            {   
                $data = [
                    $this->table,
                    [
                        'userid'   => $userId,
                        'position' => $position,
                        'loanId'   => $loanId,
                        'is_paid'  => false,
                    ]
                ];
                $result = $this->dbHelper->insert(...$data);
            }else
            {
                $position = (int) $currentStep->position;
                
                //move to next step
                $updateData = [
                    $this->table,
                    [
                        'position' => ++$position,
                        'loanId'   => $loanId,
                        'is_paid'  => false,
                        'is_standby' => false
                    ],

                    " id = '{$currentStep->id}' "
                ];

                $result =  $this->dbHelper->update( ...$updateData );
            }

            if($result)
            {
                $remarks = " User moved to step {$position} on {$today}";
                
                $this->createLog($userId , $loanId, $remarks);

            }else
            {
                die("Something went wrong");
            }
        }


        public function move($userId , $loanId)
        {
            $today = today();
            //get previous step
            //create step

            $isExists = $this->getByUser($userId);


            if(!$isExists){
                $data = 
                [
                    $this->table,
                    [
                        'userid'   => $userId,
                        'position' => 1,
                        'loanId'   => $loanId,
                        'is_paid'  => false,
                    ]
                ];

                return $this->dbHelper->insert(...$data);
            }

            return $isExists->id;
            
        }

        public function moveToShipping($userId , $loanId)
        {
            $tocId = $this->move($userId , $loanId);
            
            return parent::dbupdate([
                'is_for_shipment' => true
            ] , $tocId);
        }

        public function update($val , $userId)
        {
            return $this->dbHelper->update(...[
                $this->table,
                $val,
                " userid = '$userId'"
            ]);
        }


        public function updateById($val , $id)
        {
            return parent::dbupdate($val , $id);
        }


        public function getCurrentStep($userId)
        {
            $data = [
                $this->table,
                '*',
                " userid = '{$userId}' "
            ];

            return $this->dbHelper->single( ...$data);
        }


        private function createLog($userId , $loanId , $remarks)
        {
            $approvedBy = get_userid();

            $data = [
                'toc_passers_logs',
                [
                    'userid' => $userId,
                    'remarks' => $remarks,
                    'approved_by' => $approvedBy,
                    'loanId'   => $loanId
                ]
            ];
            return $this->dbHelper->insert(...$data);
        }


        public function getByPosition($position)
        {
            $this->loan = model('FNProductReleaseModel');
            $this->loanPayment = model('FNProductReleasePaymentModel');

            $data = [
                $this->table,
                '*',
                " position = '{$position}'  AND is_standby = 0"
            ];

            $tocPassers = $this->dbHelper->resultSet( ...$data );

            foreach($tocPassers as $key => $row)
            {
                $loanPayment = $this->loanPayment->getTotal($row->userid);
                $loan = $this->loan->getTotal($row->userid);

                $row->borrow = $this->borrowerCXModel->getBorrowDetails($row->userid , $row->loanId);
                
                $row->remarks = $this->getRemarks($row->userid);
                $row->loan = $loan;
                $row->loanPayment = $loanPayment;
                $row->balance =  ($loan->total - $loanPayment);

                // get total direct sponsor
                $this->db->query(
                       "SELECT id FROM users WHERE direct_sponsor = {$row->userid}"
                    );
                $direct_ref = $this->db->resultSet();
                $row->total_direct_ref = count($direct_ref);
            }

            return $tocPassers;
        }


        public function getAllPosition()
        {
            $this->loan = model('FNProductReleaseModel');
            $this->loanPayment = model('FNProductReleasePaymentModel');
            $userAddress = model('UserAddressesModel');
            $this->User_model = model('User_model');

            $data = [
                $this->table,
                '*',
                " position > '1'  AND is_standby = 0 ORDER BY position"
            ];

            $tocPassers = $this->dbHelper->resultSet( ...$data );

            foreach($tocPassers as $key => $row)
            {
                $loanPayment = $this->loanPayment->getTotal($row->userid);
                $loan = $this->loan->getTotal($row->userid);

                $row->borrow = $this->borrowerCXModel->getBorrowDetails($row->userid , $row->loanId);
                
                $userDetails =  $this->User_model->getPublic($row->userid); 

                $row->remarks = $this->getRemarks($row->userid);
                $row->loan = $loan;
                $row->loanPayment = $loanPayment;
                $row->balance =  (@$loan->total - $loanPayment);

                $row->id_sealed = seal($row->userid);


                //get package_id and qty to be send
                $package_id = 1;
                $quantity = 1;
                $qty_list = array("x","x", "x", "5", "6", "7", "8", "9", "10", "12", "14", "16", "18", "20", "24", "28", "30", "36", "36","60");

                if($row->position == 1)
                {
                   $package_id = 17;
                }else if($row->position  == 2)
                {
                  $package_id = 1;
                }else if($row->position  >=3 && $row->position  <=19)
                {
                   $package_id = 5;
                   $quantity =  $qty_list[$row->position];
                }

                $row->package_id = $package_id;
                $row->quantity =   $quantity;

                //get productAutoloan
                $row->productAutoloan2 = mGetCodeLibraries($package_id);

                
                // get total direct sponsor
                $this->db->query(
                       "SELECT id FROM users WHERE direct_sponsor = {$row->userid}"
                    );

                $direct_ref = $this->db->resultSet();

                $row->total_direct_ref = count($direct_ref);

                $check_cop =  $userAddress->getCOP( $row->userid );
              
                if(!empty($check_cop))
                {
                    $row->cop =  $check_cop;
                }else
                {
                    $row->cop =  @$userDetails->address;
                }

            }

            return $tocPassers;
        }


        public function getByStandby()
        {
            $userModel = model('User_model');

            $data = [
                $this->table,
                '*',
                'is_standby = true'
            ];

            $tocPassers = $this->dbHelper->resultSet( ...$data );

            foreach($tocPassers as $key => $row)
            {
                $row->user =  $userModel->get_user( $row->userid );

                $row->remarks = $this->getRemarks($row->userid);
            }

           return $tocPassers;
        }


        public function getRemarks($userId)
        {
            $data = [
                'toc_passers_logs',
                '*',
                " userid = '$userId' "
            ];

            return $this->dbHelper->resultSet(...$data);
        }

        /*
        *Get csr work summary
        */

        public function getUserSummary($userId)
        {
            $data = [
                'toc_passers_logs',
                '*',
                " approved_by  = '{$userId}' "
            ];

            $summaries = [

                'daily'   => 0,
                'weekly'  => 0,
                'monthly' => 0

            ];

            $results = $this->dbHelper->resultSet( ...$data );
            
            $today = date('Y-m-d');

            $lastWeek = date('Y-m-d',strtotime("-7 days"));
            
            foreach($results as $key => $row)
            {
                $updatedAt = get_date($row->created_at , 'Y-m-d');

                if( isEqual($today ,  $updatedAt) ){
                    $summaries['daily']++;
                }

                //check if weekly

                if( $updatedAt >= $lastWeek && $updatedAt < $today ) 
                {
                    $summaries['weekly']++;
                }

            }

            return $summaries;
        }    

         public function updateLoanId($userId, $loanId)
        {
            $updateData = [
                $this->table,
                [
                    'loanId' => $loanId
                ],
                " userid = '{$userId}' "
            ];

            return  $this->dbHelper->update( ...$updateData );
        }  


        public function moving_to_next_step($userId , $loanId, $position)
        {

            $today = today();
            //get previous step
            $currentStep = $this->getCurrentStep($userId);
            
            //create step
            if( !$currentStep )
            {   
                $data = [
                    $this->table,
                    [
                        'userid'   => $userId,
                        'position' => $position,
                        'loanId'   => $loanId,
                        'is_paid'  => false,
                    ]
                ];
                $result = $this->dbHelper->insert(...$data);
            }else
            {
               
                //move to next step
                $updateData = [
                    $this->table,
                    [
                        'position' => $position,
                        'loanId'   => $loanId,
                        'is_paid'  => false,
                        'is_standby' => false
                    ],

                    " userid = '{$userId}' "
                ];

                $result =  $this->dbHelper->update( ...$updateData );
            }

            if($result)
            {
                $remarks = " User moved to step {$position} on {$today}";
                
                $this->createLog($userId , $loanId, $remarks);

            }else
            {
                die("Something went wrong");
            }
            
        }


        public function change_position($userId , $position)
        {
            $today = today();
            
            $data = [
                $this->table,
                [
                    'userid'   => $userId,
                    'position' => $position,
                    'is_for_shipment'  => true,
                ],
                " userid = '{$userId}' "
            ];
            $result = $this->dbHelper->update(...$data);

            if($result)
            {
                $remarks = " User moved to step {$position} on {$today}";
                
                $this->createLog($userId , "", $remarks);

            }else
            {
                die("Something went wrong");
            }
        }

        public function haha()
        {
            //get total direct sponsor
            $this->db->query(
                       "SELECT userid as userid, (SELECT COUNT(*) FROM user_social_media WHERE user_social_media.userid = fn_product_release.userid and status = 'verified') as fb_link FROM `fn_product_release` GROUP BY userid"
                    );
             
            $data =  $this->db->resultSet();


            $count_zero = 0;

            foreach ($data as $key => $value) {
               if($value->fb_link == 0)
               {
									$count_zero++;
               }
            }

            dump($count_zero);
        }

    }