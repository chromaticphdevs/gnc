
<?php 	

	class UserListModel extends Base_model
	{

		public function get_activation_today()
		{		
			$today=$this->get_date_today();	
			$this->set_time_zone();

			$this->db->query(
                "
                SELECT * FROM `users` INNER JOIN fn_off_code_inventories as fn_code 
				WHERE fn_code.userid = users.id AND users.status != 'pre-activated' 
				AND DATE(fn_code.created_at) =  '$today' AND fn_code.status = 'used'
				ORDER BY fn_code.created_at DESC"               
            );

            return $this->db->resultSet();
			
		}

		public function get_registration_today()
		{	
			$today=$this->get_date_today();	
			$this->set_time_zone();

			$this->db->query(
                "SELECT * FROM `users`
                 WHERE status = 'pre-activated' 
                 AND DATE(created_at) = '$today'"               
            );

            return $this->db->resultSet();
			
		}

		public function get_registration_a_week($days)
		{	
			$today=$this->get_date_today();

			$this->set_time_zone();

			$UserList = [];

			$this->db->query(
                "SELECT * FROM `users`
                 WHERE status = 'pre-activated' 
                 AND DATEDIFF('$today', DATE(created_at)) <= {$days}
                 ORDER BY created_at DESC"               
            );

            $data = $this->db->resultSet();

            foreach ($data as $key => $value) 
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

	    		$UserList [] = (object) [
	    				'id' => $value->id,
	    			 	'username'=> $value->username,
	    			 	'firstname' => $value->firstname,
	    				'lastname' => $value->lastname,
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

			return $UserList;
			
		}

		public function get_login_today()
		{	
			$today=$this->get_date_today();
			$this->set_time_zone();

			$this->db->query(

                "SELECT * FROM `user_login_logger` INNER JOIN `users` 
                 WHERE `user_login_logger`.userid = `users`.id AND DATE(date_time) = '$today'"               
            );

            return $this->db->resultSet();
			
		}

		public function get_product_release_today($category)
		{
		
			$today=$this->get_date_today();	
			$this->set_time_zone();

			$this->db->query(
                "SELECT *,
                (SELECT name FROM fn_branches WHERE id=pr.branchid) as branch_name 
                FROM `fn_product_release` as pr INNER JOIN `users` as u 
                WHERE  u.id=pr.userid AND DATE(date_time) = '$today' AND category='$category' 
                ORDER BY date_time DESC"               
            );

            return $this->db->resultSet();	
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