<?php
	use Services\UserSocialMediaService;
	load(['UserSocialMediaService'], APPROOT.DS.'services');

	class UserSocialMediaModel extends Base_model
	{

		public $table = 'user_social_media';

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

		public function count_manager_work()
		{
			$this->set_time_zone();
			$today = $this->get_date_today();

			$processBy = whoIs()['id'];

			$this->db->query(
                "SELECT
				(SELECT COUNT(*) FROM user_social_media 
				WHERE status = 'verified' AND DATE(date_time)='$today'  AND userid_verifier = '$processBy') as approved,
				(SELECT COUNT(*) FROM user_social_media 
				WHERE status = 'deny' AND DATE(date_time)='$today' AND userid_verifier = '$processBy'  ) as denied
				FROM `user_social_media` 
				
				LIMIT 1"               
            );



            return $this->db->single();
		}

		public function count_manager_work_week($days)
		{
			$this->set_time_zone();
			$today = $this->get_date_today();

			$processBy = whoIs()['id'];

			$this->db->query(
                "SELECT
				(SELECT COUNT(*) FROM user_social_media 
				WHERE status = 'verified' AND DATEDIFF('$today', DATE(date_time)) <= {$days}  AND userid_verifier = '$processBy') as approved,
				(SELECT COUNT(*) FROM user_social_media 
				WHERE status = 'deny' AND DATEDIFF('$today', DATE(date_time)) <= {$days}  AND userid_verifier = '$processBy') as denied
				FROM `user_social_media`
				 LIMIT 1"               
            );

            return $this->db->single();
		}

		public function get_user_uploaded_social_media_link($userid)
		{
			$this->db->query(
                "SELECT * 
				FROM `user_social_media` 
				WHERE userid = '$userid'  
				ORDER BY id desc"               
            );

            return $this->db->resultSet();

		}

		public function get($params = []) {
			return $this->getAll($params)[0] ?? false;
		}
		public function getAll($params = []) {
			$where = null;
			$order = null;
			$limit = null;

			if(!empty($params['where'])) {
				$where = " WHERE " . parent::convertWhere($params['where']);
			}

			if(!empty($params['order'])) {
				$order = " ORDER BY  {$params['order']}";
			}

			if(!empty($params['limit'])) {
				$limit = " LIMIT {$params['limit']} ";
			}
			$this->db->query(
				"SELECT user_social.*,
					concat(user.firstname, ' ',user.lastname) as fullname ,
					user.username as user_username,
					user.is_user_verified 
					FROM {$this->table} as user_social
					INNER JOIN users as user
						ON user.id = user_social.userid
					{$where} {$order} {$limit}"
			);

			return $this->db->resultSet();
		}

		public function add_link($info, $userid)
		{
			extract($info);
			$cutLink = explode("/",$link);
			$messengerLink = '';
			
			$facebookChecker = strpos($cutLink[2],"facebook");
			if($facebookChecker)  {
				$messengerLink = $cutLink[0]."//m.me/".$cutLink[3]."/";
			}

			if(!empty($messengerLink)) {
				//search messenger link
				$messengerLinkData = parent::dbget([
					'userid' => $userid,
					'link'   => $messengerLink,
					'type'   => UserSocialMediaService::MESSENGER
				]);

				if($messengerLinkData) {
					//update
					parent::dbupdate([
						'userid'  => $userid,
						'link'  => $messengerLink,
						'type'  => UserSocialMediaService::MESSENGER
					], $messengerLinkData->id);

				} else {
					//create
					parent::store([
						'userid'  => $userid,
						'link'  => $messengerLink,
						'type'  => UserSocialMediaService::MESSENGER
					]);
				}
			}

			$entryData = parent::dbget([
				'userid' => $userid,
				'link'   => $link,
				'type'  => $type,
				'status' => 'unverified'
			]);

			if($entryData) {
				//update if unverified entry found
				return parent::dbupdate([
					'userid' => $userid,
					'link'   => $link,
					'type'  => $type,
				], $entryData->id);
			} else {
				return parent::store([
					'userid' => $userid,
					'link'   => $link,
					'type'  => $type
				]);
			}
		}

		public function remove_link($type, $userid)
		{

			$this->db->query(
					"UPDATE `user_social_media` SET `status`='deny'
					 WHERE type='$type' AND userid='$userid'"
				);

			if($this->db->execute())
			{
				return true;
			}else{
				return false;
			}

		}

		public function get_user_social_media_link_all()
		{	
			$this->set_time_zone();

			$this->db->query(
                "SELECT social.id as link_id ,username, 
                CONCAT(firstname, ' ', lastname ) as fullname,address, 
                link, type, date_time
                FROM `user_social_media` as social INNER JOIN users as user 
                WHERE social.userid = user.id and social.status = 'unverified'
                ORDER BY social.date_time DESC"               
            );

            return $this->db->resultSet();

		}



		public function verified_list($status)
		{

			$this->set_time_zone();

			$this->db->query(
                "SELECT user_social.id as uploaded_social ,username, 
                CONCAT(firstname, ' ', lastname ) as fullname,address, 
                type, date_time,link,mobile
                FROM `user_social_media` as user_social INNER JOIN users as user 
                WHERE user_social.userid = user.id and user_social.status = '$status'"               
            );

            return $this->db->resultSet();

		}

		public function get_user_fb_link($userid)
		{	

			$this->db->query(
                "SELECT *
                FROM `user_social_media`
                WHERE status = 'verified'
                and userid = '$userid'"               
            );

            return $this->db->resultSet();

		}

		
		public function get_messenger_link($userid)
		{	
			$this->db->query(
                "SELECT *
                FROM `user_social_media`
                WHERE userid = '$userid' AND
                type = 'Messenger'  ORDER BY `date_time` DESC"               
            );

            return $this->db->single();
		}

		public function get_fb_link($userid)
		{	
			$this->db->query(
                "SELECT *
                FROM `user_social_media`
                WHERE userid = '$userid' AND
                type = 'Facebook' ORDER BY `date_time` DESC"               
            );

            return $this->db->single();
		}


	    public function get_user_all($condition)
		{	
			$this->set_time_zone();

			$this->db->query(
                "SELECT social.id as link_id ,username,  user.id as userID,
                CONCAT(firstname, ' ', lastname ) as fullname,address,
                (SELECT chat_bot_link FROM `users_chat_bot` WHERE `userid` = user.id LIMIT 1) as chat_bot_link, 
                (SELECT COUNT(*) FROM users WHERE direct_sponsor = user.id ) as total_direct_ref,
                link, type, date_time
                FROM `user_social_media` as social INNER JOIN users as user 
                WHERE social.userid = user.id and social.status = 'verified' AND social.type = 'Facebook' AND
                user.`status` != 'pre-activated' AND user.`status` != 'loan_approved' AND (SELECT count(userid) FROM `users_chat_bot` WHERE `userid` = user.id) $condition 1
                ORDER BY total_direct_ref DESC"               
            );

            return $this->db->resultSet();

		}

		public function upload_chat_bot_link($userid, $link)
		{
			$this->db->query(
					"INSERT INTO `users_chat_bot`(`userid`, `chat_bot_link`) 
					 VALUES ('$userid', '$link')"
				);

			if($this->db->execute())
			{
				return true;
			}else{
				return false;
			}
		}


		public function get_chat_bot_link($userid)
		{
			$this->db->query(
                "SELECT `chat_bot_link` FROM `users_chat_bot` WHERE userid = '$userid' "               
            );

            return $this->db->single();
		}


		public function check_duplication_link($link,$type)
		{
			$cut_link = explode("/",$link);

			$this->db->query(
                "SELECT userid,link,type FROM `user_social_media` 
                WHERE (`link` LIKE '%$cut_link[3]%' OR `link`='$link') AND status != 'deny' LIMIT 1"               
            );

			$result = $this->db->single();

			if(empty($result))
			{
				return false;
			}

			$link_explode = explode("/",$result->link);


			if($cut_link[3] == $link_explode[3]){
				return true;
			}else{
				return false;
			}
            
		}


		public function change_status($status, $link_id, $comment)
		{

			$processBy = whoIs()['id'];

			$session_type = get_session_type();

			$this->db->query(
			   "UPDATE `user_social_media` 
			    SET `status`='$status', `comment`='$comment',
			        `userid_verifier`='$processBy', `verifier_type` = '$session_type'
				WHERE id='$link_id'"
			);

			if($this->db->execute())
			{
				return true;
			}else{
				return false;
			}
			
		}

		public function count_user_social_link($userid)
		{
			$this->db->query(
                "SELECT COUNT(*) as total FROM `user_social_media` 
                 WHERE userid ='$userid' 
                 AND status ='verified'"               
            );

            return $this->db->single()->total;
		}

		public function check_social_media_link($userid)
		{

			$this->db->query(
                "SELECT COUNT(*) as total FROM `user_social_media` 
                 WHERE userid ='$userid' 
                 AND (status ='verified' OR status ='unverified')"               
            );

            $result1 = $this->db->single()->total;

            $this->db->query(
                "SELECT address FROM `users` 
                 WHERE id ='$userid'"               
            );

            $result2 = $this->db->single()->address;
       		
            $notif = 0;

            if($result1 <= 0){

            	if(empty($result2)){

            		 $notif = 1;
            	}else{
            		$notif = 2;
            	}
            	
            }else if(!empty($result2)){

            	if($result1 >= 0){

            		 $notif = 4;
            	}else{
            		$notif = 3;
            	}

            	
            }


            return $notif;

           

		}



	}