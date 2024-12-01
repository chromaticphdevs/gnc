<?php   

    class CompanyCustomerFollowUpModel extends Base_model
    {

        public $table = 'company_customer_follow_ups';

        public $tableLogs = 'company_customer_follow_up_logs';

        public function __construct()
        {
            parent::__construct();
            $this->user = model('User_model');
        }


        /*
        *@valid Parameters
        *userId is the customer id 
        *processedBy the user who do the action
        *remarks action happened to the user
        *notes any details you want to enter about the customer
        */
        public function createLogs($params = [])
        {
            //create checks here..

            //endof checks

            $this->dbHelper->insert(...[
                $this->tableLogs,
                [   
                    'user_id' => $params['userId'],
                    'process_by' => $params['processedBy'],
                    'remarks'  => $params['remarks'],
                    'note' => $params['notes']
                ]
            ]);
            
            
        }


        private function fetchUserQuery($condition , $limit = null)
        {
            if(!is_null($limit))
                $limit = ' LIMIT '.$limit;

             $this->db->query(
                "SELECT user.*, user.id as UserId,
                concat(user.firstname , ' ' , user.lastname) as fullname,
                ifnull(user_on_call.user_id , 0) as on_call

                FROM users as user

                LEFT JOIN user_on_call 
                ON user_on_call.user_id = user.id
                
                {$condition}
                ORDER BY user.id desc 
                {$limit}"
            );

            
            $results = $this->db->resultSet();

            foreach($results as $key => $row) 
            {
                $row->fb_link = $this->dbHelper->single(...[
                    'user_social_media',
                    'link',
                    " userid = {$row->UserId} and type = 'Facebook' and status = 'verified' "
                ]);

                $this->db->query(
                    "SELECT count(id) as total_valid_id FROM users_uploaded_id
                        WHERE userid = '{$row->UserId}' and status = 'verified' "
                );

                $row->total_valid_id = $this->db->single()->total_valid_id ?? 0;
            }

            return $results;
        }

        public function getFirstLevel()
        {
            $userid = whoIs()['id'];

            return $this->fetchUserQuery(
                " WHERE user.status = 'pre-activated'
                  AND user.id not in (
                    SELECT user_id FROM {$this->table})" , 10
            );
        }

        public function getCompanyCustomers()
        {
            return $this->fetchUserQuery(
                " WHERE user.status = 'pre-activated' 
                  AND account_tag = 'main_account'  
                  AND username != 'duplicate' AND firstname not like 'duplicate%'
                  AND user.id not in (SELECT user_id FROM {$this->table}) 
                  AND user_on_call.id is NULL " , 1
                
            );
        }

        public function getByLevel($level)
        {
            $userid = whoIs()['id'];

            return $this->fetchUserQuery(
                "WHERE user.status = 'pre-activated'
                  AND user.id in (
                    SELECT user_id FROM {$this->table}
                        WHERE tagged_as = 'active'
                        AND level = '{$level}')"
            );
        }


        public function getByTag($tag)
        {   
            $userid = whoIs()['id'];

            return $this->fetchUserQuery(
                " WHERE user.status = 'pre-activated' 
                  AND user.id in (
                    SELECT user_id FROM {$this->table} 
                        WHERE tagged_as = '{$tag}')"
            );
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

            $user_info = $this->db->single();

            $user_info->fb_link = $this->dbHelper->single(...[
                    'user_social_media',
                    'link',
                    " userid = {$userId} and type = 'Facebook' and status = 'verified' "
                ]);

            $this->db->query(
                "SELECT count(id) as total_valid_id FROM users_uploaded_id
                    WHERE userid = '{$userId}' and status = 'verified' "
            );

            $user_info->total_valid_id = $this->db->single()->total_valid_id ?? 0;
  
            return $user_info;
        }

        public function getUserNotes($userId)
        {
            $this->db->query(
                "SELECT *, process_by as called_by_id,(SELECT CONCAT(firstname , ' ', lastname ) FROM users WHERE users.id =called_by_id) as called_by
                 FROM $this->tableLogs 
                 WHERE `user_id` = '$userId' 
                 ORDER BY `id` DESC"
            );

            return $this->db->resultSet();
        }

        public function updateTag($userId, $tag , $note)
        {
            $currentLevel = $this->curLevel($userId);
            $approvedBy = whoIs()['id'];

            $returnStatus  = false;

            if( !$currentLevel )
            {
                $this->lastLevel = 2;

                $returnStatus = $this->dbHelper->insert($this->table , [
                    'user_id' => $userId,
                    'level'   => 2 ,
                    'process_by' => $approvedBy,
                    'tagged_as '  => $tag,
                    'note' => $note
                ]);
            }else
            {
                $this->lastLevel = $currentLevel->level;

                $returnStatus = $this->dbHelper->update($this->table , [
                    'process_by' => $approvedBy,
                    'tagged_as '  => $tag,
                    'note' => $note
                ] , " user_id = '{$userId}' ");
            }

            $this->createTagRemark($approvedBy , $userId , $tag , $note);

            return $currentLevel;
        }

        /*
        *do not set caller is not set
        *it will be automatically set to who is data
        */
        public function moveNextLevelWithTimeSheet($userId , $note = '')
        {
            $this->userOnCall = model('UserCallModel');

            $caller = $this->caller;
            
            $res = $this->userOnCall->getAndDropCall($userId , $caller['callerId'] , $caller['type']);
            
            return $isMovedToNxtLevel = $this->moveNextLevel($userId , $note);
        }

        public function setCaller($caller)
        {
            if( is_null($caller) )
            {
                $whoIs = whoIs();

                $this->caller = [
                    'callerId' => $whoIs['id'],
                    'type'     => $whoIs['whoIs']
                ]; 
            }else{

                if( is_object($caller) )
                    $caller = (array) $caller;

                $this->caller = $caller;
            }
        }



        public function moveNextLevel($userId, $note , $approvedBy = null)
        {
            if( is_null($approvedBy) ) {
                $approvedBy = whoIs()['id'];
            }
            //check if is in follow up
            $returnStatus = false;

            $currentLevel = $this->dbHelper->single($this->table , '*' , " user_id = '{$userId}' ");
            
            if(!$currentLevel) 
            {
                $this->lastLevel = 1;
                //moove to second level
                $returnStatus = $this->dbHelper->insert($this->table , [
                    'user_id' => $userId,
                    'tagged_as' => 'active',
                    'level'   => 2 ,
                    'process_by' => $approvedBy,
                    'note' => $note
                ]);

                if($returnStatus) {
                    $this->addError( " NA LAGAY SA COMPANY FOLLOW UP ");
                }

                $this->createLevelUpRemark($approvedBy , $userId , [1 , 2] , $note);
                
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
                        'process_by' => $approvedBy,
                        'tagged_as' => 'active',
                        'note' => $note
                    ] , " user_id = '{$userId}' ");

                    $this->createLevelUpRemark($approvedBy , $userId , [$this->lastLevel , $level], $note);
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
            $userid = whoIs()['id'];

            $this->db->query(
                "SELECT level from $this->table 
                 WHERE process_by = '$userid'
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
                $this->tableLogs,
                '*',
                " process_by  = '{$userId}' "
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


        private function createLevelUpRemark($approvedBy , $userId , $levels = [], $note)
        {
            $userModel = model('User_model');

            $user = $userModel->get_user($userId);

            $remarks =  " User {$user->fullname} has been moved from {$levels[0]} to {$levels[1]}";

            $this->dbHelper->insert(...[
                $this->tableLogs,
                [   
                    'user_id' => $userId,
                    'process_by' => $approvedBy,
                    'remarks'  => $remarks,
                    'note' => $note
                ]
            ]);
        }

        private function createTagRemark($approvedBy , $userId , $remark, $note)
        {
            $userModel = model('User_model');

            $user = $userModel->get_user($userId);

            $remarks =  " User {$user->fullname} has been tagged as <strong> {$remark} </strong> ";

            $this->dbHelper->insert(...[
                $this->tableLogs,
                [   
                    'user_id' => $userId,
                    'process_by' => $approvedBy,
                    'remarks'  => $remarks,
                    'note' => $note
                ]
            ]);
        }


        public function createNote($userId,  $approvedBy, $note)
        {

            $remarks =  "Only added a note. position not moved";

            $this->dbHelper->insert(...[
                $this->tableLogs,
                [   
                    'user_id' => $userId,
                    'process_by' => $approvedBy,
                    'remarks'  => $remarks,
                    'note' => $note
                ]
            ]);
        }


    }