<?php   

    class FollowUpModel extends Base_model
    {

        public $table = 'follow_ups';


        public function __construct()
        {
            parent::__construct();
            $this->user = model('User_model');
        }

        private function fetchUserQuery($condition)
        {
            $this->db->query(
                "SELECT user.* , concat(firstname , ' ' , lastname) as fullname ,
                    follow_up.tagged_as , follow_up.level as follow_up_level
                    FROM {$this->user->table} as user  
                    
                    LEFT JOIN {$this->table} as follow_up
                    ON follow_up.user_id = user.id 
                    
                    {$condition}"
            );

            $results = $this->db->resultSet();

            $userLists = [];

            foreach ($results as $key => $value) 
            {
                // check if there is as social media
                $this->db->query(
                       "SELECT  link as valid_link FROM user_social_media WHERE userid = {$value->id} AND status='verified' AND type='Facebook'"
                );
                $social_link_info = $this->db->single();



                // check if there is as Id
                $this->db->query(
                       "SELECT  * FROM users_uploaded_id  
                        WHERE users_uploaded_id.status = 'verified' AND userid = {$value->id}"
                );
                
                $uploaded_id_info = $this->db->single();

                $userLists [] = (object) [
                        'id' => $value->id,
                        'username'=> $value->username,
                        'firstname' => $value->firstname,
                        'lastname' => $value->lastname,
                        'fullname' => $value->firstname . ' '.$value->lastname,
                        'email' => $value->email,
                        'mobile' =>$value->mobile,
                        'address' =>$value->address,
                        'status' =>$value->status,
                        'created_at' =>$value->created_at,
                        'uploaded_id' =>$uploaded_id_info->id ?? 'no_id',
                        'id_card' => $uploaded_id_info->id_card ?? '',
                        'id_card_back' => $uploaded_id_info->id_card_back ?? '',
                        'link' => $social_link_info->valid_link ?? 'no_link'
                    ];
            }

            return $userLists;
        }

        public function getFirstLevel()
        {
            return $this->fetchUserQuery(
                " WHERE user.id not in (
                    SELECT user_id FROM {$this->table}
                ) AND account_tag = 'main_account' 
                LIMIT 200"
            );
        }

        public function getByLevel($level)
        {
            return $this->fetchUserQuery(
                " WHERE user.id in (
                    SELECT user_id FROM {$this->table}
                        WHERE tagged_as = 'active'
                        AND level = '{$level}'
                ) AND account_tag = 'main_account' "
            );
        }


        public function getByTag($tag)
        {
            return $this->fetchUserQuery(
                " WHERE user.id in (
                    SELECT user_id FROM {$this->table} 
                        WHERE tagged_as = '{$tag}'
                ) "
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

            return $this->db->single();
        }

        public function updateTag($userId, $tag)
        {
            $currentLevel = $this->curLevel($userId);

            $returnStatus  = false;

            if( !$currentLevel )
            {
                $this->lastLevel = 2;

                $returnStatus = $this->dbHelper->insert($this->table , [
                    'user_id' => $userId,
                    'level'   => 2 ,
                    'approved_by' => $approvedBy,
                    'tagged_as '  => $tag
                ]);
            }else
            {
                $this->lastLevel = $currentLevel->level;

                $returnStatus = $this->dbHelper->update($this->table , [
                    'approved_by' => $approvedBy,
                    'tagged_as '  => $tag
                ] , " user_id = '{$userId}' ");
            }

            $this->createTagRemark($approvedBy , $userId , $tag);

            return $currentLevel;
        }


        /*
        *do not set caller is not set
        *it will be automatically set to who is data
        */
        public function moveNextLevelWithTimeSheet($userId)
        {
            $this->userOnCall = model('UserCallModel');

            $caller = $this->caller;

            $this->userOnCall->getAndDropCall($userId , $caller['callerId'] , $caller['type']);

            $isMovedToNxtLevel = $this->moveNextLevel($userId);
            return $isMovedToNxtLevel;
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

        /*
        *Review this piece of code if 
        *will be modified
        */
        public function moveNextLevel($userId)
        {
            $approvedBy = whoIs()['id'];
            //check if is in follow up
            $returnStatus = true;

            $currentLevel = $this->dbHelper->single($this->table , '*' , " user_id = '{$userId}' ");
            
            if(!$currentLevel) 
            {
                $this->lastLevel = 1;
                //moove to second level
                $returnStatus = $this->dbHelper->insert($this->table , [
                    'user_id' => $userId,
                    'tagged_as' => 'active',
                    'level'   => 2 ,
                    'approved_by' => $approvedBy
                ]);

                $this->createLevelUpRemark($approvedBy , $userId , [1 , 2]);
                
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
                    ] , " user_id = '{$userId}' ");

                    $this->createLevelUpRemark($approvedBy , $userId , [$this->lastLevel , ++$level]);
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
                'follow_up_logs',
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


        private function createLevelUpRemark($approvedBy , $userId , $levels = [])
        {
            $userModel = model('User_model');

            $user = $userModel->get_user($userId);

            $remarks =  " User {$user->fullname} has been moved from {$levels[0]} to {$levels[1]}";

            $this->dbHelper->insert(...[
                'follow_up_logs',
                [
                    'approved_by' => $approvedBy,
                    'remarks'  => $remarks
                ]
            ]);
        }

        private function createTagRemark($approvedBy , $userId , $remark)
        {
            $userModel = model('User_model');

            $user = $userModel->get_user($userId);

            $remarks =  " User {$user->fullname} has been tagged as <strong> {$remark} </strong> ";

            $this->dbHelper->insert(...[
                'follow_up_logs',
                [
                    'approved_by' => $approvedBy,
                    'remarks'  => $remarks
                ]
            ]);
        }
    }