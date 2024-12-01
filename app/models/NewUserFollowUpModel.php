<?php   

    class NewUserFollowUpModel extends Base_model
    {

        public $table = 'new_user_follow_ups';


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

        public function getFirstLevel($days)
        {
            $today=$this->get_date_today(); 
            $this->set_time_zone();

            return $this->fetchUserQuery(
                " WHERE user.id not in (
                    SELECT user_id FROM {$this->table}
                ) AND account_tag = 'main_account' 
                  AND user.status = 'pre-activated'
                  AND DATEDIFF('$today', DATE(user.created_at)) <= {$days}
                  ORDER BY user.created_at DESC"
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


        public function getByAddress($address)
        {           
            return $this->fetchUserQuery(
                " WHERE user.id not in (
                    SELECT user_id FROM {$this->table}
                ) AND `address` LIKE '%$address%'  
                  AND username != 'breakthrough' AND username != 'duplicate'
                  AND user.status = 'pre-activated'
                  AND account_tag = 'main_account'
                  ORDER BY user.created_at DESC 
                  LIMIT 20"
            );
        }

        public function getByAddress_sorted($address)
        {           
            return $this->fetchUserQuery(
                " WHERE user.id not in (
                    SELECT user_id FROM {$this->table}
                ) 
                  AND (user.id in (
                        SELECT userid FROM users_uploaded_id
                        WHERE status != 'deny'
                  )  OR
                  user.id in (
                        SELECT userid FROM user_social_media
                        WHERE status != 'deny'
                  ) )

                  AND `address` LIKE '%$address%'  
                  AND username != 'breakthrough' AND username != 'duplicate'
                  AND user.status = 'pre-activated'
                  AND account_tag = 'main_account'
                  ORDER BY user.created_at DESC 
                  LIMIT 20"
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

        public function getUserNotes($userId)
        {
            $this->db->query(
                "SELECT * FROM `new_user_follow_up_logs` 
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
                    'approved_by' => $approvedBy,
                    'tagged_as '  => $tag,
                    'csr_note' => $note
                ]);
            }else
            {
                $this->lastLevel = $currentLevel->level;

                $returnStatus = $this->dbHelper->update($this->table , [
                    'approved_by' => $approvedBy,
                    'tagged_as '  => $tag,
                    'csr_note' => $note
                ] , " user_id = '{$userId}' ");
            }

            $this->createTagRemark($approvedBy , $userId , $tag , $note);

            return $currentLevel;
        }

        public function moveNextLevel($userId, $note)
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
                    'approved_by' => $approvedBy,
                    'csr_note' => $note
                ]);

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
                        'approved_by' => $approvedBy,
                        'tagged_as' => 'active',
                        'csr_note' => $note
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
                'new_user_follow_up_logs',
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


        private function createLevelUpRemark($approvedBy , $userId , $levels = [], $note)
        {
            $userModel = model('User_model');

            $user = $userModel->get_user($userId);

            $remarks =  " User {$user->fullname} has been moved from {$level[0]} to {$level[1]}";

            $this->dbHelper->insert(...[
                'new_user_follow_up_logs',
                [   
                    'user_id' => $userId,
                    'approved_by' => $approvedBy,
                    'remarks'  => $remarks,
                    'csr_note' => $note
                ]
            ]);
        }

        private function createTagRemark($approvedBy , $userId , $remark, $note)
        {
            $userModel = model('User_model');

            $user = $userModel->get_user($userId);

            $remarks =  " User {$user->fullname} has been tagged as <strong> {$remark} </strong> ";

            $this->dbHelper->insert(...[
                'new_user_follow_up_logs',
                [   
                    'user_id' => $userId,
                    'approved_by' => $approvedBy,
                    'remarks'  => $remarks,
                    'csr_note' => $note
                ]
            ]);
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