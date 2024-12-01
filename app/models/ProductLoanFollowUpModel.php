<?php   

    class ProductLoanFollowUpModel extends Base_model
    {

        public $table = 'product_loan_follow_ups';


        public function __construct()
        {
            parent::__construct();
            $this->user = model('User_model');
            $this->productRelease = model('FNProductBorrowerModel');
            $this->loanPayment = model('FNProductReleasePaymentModel');

            $this->socialMedia = model('UserSocialMediaModel');
        }

        private function fetchUserQuery($condition, $branchId , $status)
        {


            $WHERE = "WHERE product_release.branchId = '$branchId'
            AND product_release.status = '$status' {$condition}";
           
            //product release
             $this->productRelease->db->query(
                "SELECT product_release.*,  concat(u.firstname , ' ' , u.lastname ) 
                    AS fullname , u.username , u.email , u.mobile

                    FROM {$this->productRelease->table} as product_release 

                    LEFT JOIN users as u
                    ON u.id = product_release.userid 
                    {$WHERE}
                    ORDER BY product_release.id desc "
            );

             //store product release
            $productReleases = $this->productRelease->db->resultSet();

             //initiate payment table
            $paymentTable = $this->loanPayment->table;

            /*
            *Loop product release
            *store loanpayments [ total , list ]
            *store social media link
            */
            foreach($productReleases as $key => $productRelease) 
            {
                $productRelease->payment = [
                    'total' => 0 ,
                    'list'  => []
                ];

                /*GET ALL LOAN PAYMENTS WHERE ID */
                $this->loanPayment->db->query(
                    "SELECT * FROM {$paymentTable} as payment
                        WHERE payment.loanId = '{$productRelease->id}' "
                );
                //store payment list
                $productRelease->payment['list'] =  $this->loanPayment->db->resultSet();

                //add all payment list
                foreach($productRelease->payment['list'] as $key => $row) {
                    $productRelease->payment['total'] += $row->amount;
                }

                //preapre social media link
                $this->socialMedia->db->query(
                    "SELECT link FROM user_social_media WHERE userid = {$productRelease->userid} AND status='verified' AND type='Facebook' LIMIT 1"
                );

                //preapre social media link
                $socialMedia = $this->socialMedia->db->single();

                //if has valid social media then store link
                if($socialMedia) {
                    $productRelease->valid_social_media = $socialMedia->link;
                }else{
                    $productRelease->valid_social_media = 'no_link';
                }
            }

             return $productReleases;
        }

        public function getFirstLevel($branchId , $status)
        {
            $this->set_time_zone();

            $condition = " AND u.id not in (
                           SELECT user_id FROM {$this->table}
                           )";

            return $this->fetchUserQuery($condition, $branchId , $status);
        }

        public function getByLevel($level, $branchId , $status)
        {

           $condition = " AND u.id in (
                            SELECT user_id FROM {$this->table}
                                WHERE tagged_as = 'active'
                                AND level = '{$level}'
                        )  ";

            return $this->fetchUserQuery($condition, $branchId , $status);
        }


        public function getByTag($tag, $branchId , $status)
        {

            $condition = " AND u.id in (
                            SELECT user_id FROM {$this->table} 
                                WHERE tagged_as = '{$tag}'
                        ) ";

            return $this->fetchUserQuery($condition, $branchId , $status);
        }


        public function getUser($userId)
        {
            $this->db->query(
                "SELECT user.* , concat(firstname , ' ' , lastname) as fullname ,
                    follow_up.tagged_as  , follow_up.level as follow_up_level
                    FROM {$this->user->table} as user  
                    
                    LEFT JOIN {$this->table} as follow_up
                    ON follow_up.user_id = user.id
                    
                    WHERE user.id = '{$userId}'  "
            );

            return $this->db->single();
        }

        public function getUserNotes($loanId)
        {
            $this->db->query(
                "SELECT * FROM `product_loan_follow_up_logs` 
                 WHERE `loan_id` = '$loanId' 
                 ORDER BY `id` DESC"
            );

            return $this->db->resultSet();
        }

        public function updateTag($userId, $loanId, $tag , $note)
        {
            $currentLevel = $this->curLevel($userId);
            $approvedBy = whoIs()['id'];

            $returnStatus  = false;

            if( !$currentLevel )
            {
                $this->lastLevel = 2;

                $returnStatus = $this->dbHelper->insert($this->table , [
                    'user_id' => $userId,
                    'loan_id' => $loanId,
                    'level'   => 2 ,
                    'approved_by' => $approvedBy,
                    'tagged_as '  => $tag,
                    'note' => $note
                ]);
            }else
            {
                $this->lastLevel = $currentLevel->level;

                $returnStatus = $this->dbHelper->update($this->table , [
                    'approved_by' => $approvedBy,
                    'tagged_as '  => $tag,
                    'note' => $note
                ] , " loan_id = '{$loanId}' ");
            }

            $this->createTagRemark($approvedBy , $userId , $loanId, $tag , $note);

            return $currentLevel;
        }

        public function moveNextLevel($userId, $loanId,  $note)
        {
            $approvedBy = whoIs()['id'];
            //check if is in follow up
            $returnStatus = true;

            $currentLevel = $this->dbHelper->single($this->table , '*' , " loan_id = '{$loanId}' ");

            if(!$currentLevel) 
            {
                $this->lastLevel = 1;
                //moove to second level
                $returnStatus = $this->dbHelper->insert($this->table , [
                    'user_id' => $userId,
                    'loan_id' => $loanId,
                    'tagged_as' => 'active',
                    'level'   => 2 ,
                    'approved_by' => $approvedBy,
                    'note' => $note
                ]);

                $this->createLevelUpRemark($approvedBy , $userId ,$loanId, [1 , 2] , $note);
                
            }else
            {
                //
                $level = intval($currentLevel->level);

                $this->lastLevel = $level;

                $date = date('Y-m-d');

                if( isEqual ( get_date($currentLevel->updated_at , 'Y-m-d') , $date ) )
                {
                    $this->errString = "User has just been updated today, cannot perform action";
                    return false;
                }else
                {
                    $returnStatus = $this->dbHelper->update($this->table , [
                        'level'   => ++$level,
                        'approved_by' => $approvedBy,
                        'tagged_as' => 'active',
                        'note' => $note
                    ] , " loan_id = '{$loanId}' ");

                    $this->createLevelUpRemark($approvedBy , $userId ,$loanId, [$this->lastLevel , $level], $note);
                }
            }

            return $returnStatus;
        }

        public function userLevel($userId)
        {
            $userLevel = $this->dbHelper->single(...[

                $this->table, 
                '*',
                " user_id = '{$userId}' "
            ]);

            if(!$userLevel)
                return 0;
            return $userLevel->level;
        }

        public function curLevel($userId)
        {
            return $this->dbHelper->single($this->table , '*' , " user_id = '{$userId}' ");
        }

        public function getAllLevels()
        {
            $this->db->query(
                "SELECT level from $this->table 
                    group by level
                ORDER BY level"
            );
            
            return $this->db->resultSet();
        }

        /*
        *Get csr work summary
        */
        public function getUserSummary($userId)
        {
            $data = [
                'product_loan_follow_up_logs',
                '*',
                " approved_by  = '{$userId}' "
            ];

            $summaries = [

                'daily'   => 0,
                'weekly'  => 0,
                'monthly' => 0

            ];


            // $summariesPrevious = [

            //     'daily'   => [],
            //     'weekly'  => [],
            //     'monthly' => []

            // ];

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


        private function createLevelUpRemark($approvedBy , $userId ,$loanId, $levels = [], $note)
        {
            $userModel = model('User_model');

            //$user = $userModel->get_user($userId);
            $loan_info = $this->get_loan_info($loanId);

            $remarks =  " Loan #{$loan_info->code} has been moved from {$level[0]} to {$level[1]}";

            $this->dbHelper->insert(...[
                'product_loan_follow_up_logs',
                [   
                    'user_id' => $userId,
                    'loan_id' => $loanId,
                    'approved_by' => $approvedBy,
                    'remarks'  => $remarks,
                    'note' => $note
                ]
            ]);
        }

        private function createTagRemark($approvedBy , $userId ,$loanId, $remark, $note)
        {
            $userModel = model('User_model');

            //$user = $userModel->get_user($userId);
            $loan_info = $this->get_loan_info($loanId);

            $remarks =  " Loan #{$loan_info->code} has been tagged as <strong> {$remark} </strong> ";

            $this->dbHelper->insert(...[
                'product_loan_follow_up_logs',
                [   
                    'user_id' => $userId,
                    'loan_id' => $loanId,
                    'approved_by' => $approvedBy,
                    'remarks'  => $remarks,
                    'note' => $note
                ]
            ]);
        }

        public function get_loan_info($loanId)
        {
            $this->db->query(
                "SELECT *,
                 (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = '$loanId' AND status='Approved') as payment
                 FROM `fn_product_release` AS pr
                 WHERE id = '$loanId' "
            );
            return $this->db->single();
        }

        public function set_time_zone()
        {
            $this->db->query("SET time_zone = '+08:00'");
            $this->db->execute();
        }

        public function get_date_today()
        {
            date_default_timezone_set("Asia/Manila");
            return date("Y-m-d");
        }

    }