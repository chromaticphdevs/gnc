<?php


class UserToolsModel extends Base_model
{

	public function get_top_performer($limit,$account_status)
	{	
		
		$today=$this->get_date_today();	
		$this->set_time_zone();

		$activated_or_not = "";
		if($account_status == "All")
		{
			$activated_or_not = "";
		}else{

			$activated_or_not = "AND status != 'pre-activated' AND status != 'approved_loan'";

		}


		if($limit=="today")
		{
			$sub_query ="SELECT COUNT(*) FROM `users` as u WHERE direct_sponsor = users.id and DATE(created_at)='$today' {$activated_or_not}";
			$this->db->query(
				"SELECT id as userid,username, CONCAT(firstname,' ',lastname) as fullname,mobile,email,
				 ({$sub_query})as total_DS
				 FROM `users` WHERE  ({$sub_query}) > 0
				 ORDER BY total_DS DESC "                  
	        );
	        return $this->db->resultSet();

		}elseif(substr($limit, 0 , 4)=="days")
		{
			$days=trim($limit,"days");

			$sub_query ="SELECT COUNT(*) FROM `users` as u WHERE direct_sponsor =  users.id and DATEDIFF('$today', DATE(created_at)) <= {$days} {$activated_or_not}";

			$this->db->query(
				"SELECT id as userid,username, CONCAT(firstname,' ',lastname) as fullname,mobile,email,
				 ({$sub_query})as total_DS
				 FROM `users` WHERE  ({$sub_query}) > 0
				 ORDER BY total_DS DESC "                  
	        );

	        return $this->db->resultSet();

		}else{
			
			$this->db->query(
				"SELECT id as userid,username, CONCAT(firstname,' ',lastname) as fullname,mobile,email,
				 (SELECT COUNT(*) FROM `users` WHERE direct_sponsor = userid  {$activated_or_not} ) as total_DS
				 FROM `users` 
				 ORDER BY total_DS DESC LIMIT $limit"                  
	        );


	        return $this->db->resultSet();
		}
		
	}


	public function user_search_tool($address, $level)
	{
		$this->db->query(
			"SELECT * FROM `users` 
			 WHERE `address` LIKE '%$address%'  
			 AND `status` = '$level' AND account_tag='main_account'"                  
        );

        return $this->db->resultSet();
	}

	public function get_user_invites($userlist)
	{	
		$today=$this->get_date_today();	
		$UserData = [];
		
    	foreach ($userlist as $key => $value){

				
				$userid = $value;
				//get user info 
				$this->db->query(
					"SELECT username, CONCAT(firstname,' ',lastname) as fullname
					 FROM `users` WHERE id = '{$userid}'"                  
		        );

		        $user_info =  $this->db->single();

		
		        $this->set_time_zone();	
	        	//get user total invites by 30days 
				$this->db->query(
					"SELECT COUNT(*) as total_DS  FROM `users` 
					 WHERE direct_sponsor = '{$userid}'
					 AND DATEDIFF('$today', DATE(created_at)) <= 30"                  
		        );

		        $month =  $this->db->single()->total_DS;

		        $this->set_time_zone();
		        //get user total invites by 7days 
				$this->db->query(
					"SELECT COUNT(*) as total_DS  FROM `users` 
					 WHERE direct_sponsor = '{$userid}'
					 AND DATEDIFF('$today', DATE(created_at)) <= 7"                  
		        );

		        $week =  $this->db->single()->total_DS;

		        $this->set_time_zone();

		        //get user yesterday invites by today
				$this->db->query(
					"SELECT COUNT(*) as total_DS  FROM `users` 
					 WHERE direct_sponsor = '{$userid}'
					 AND DATEDIFF('$today', DATE(created_at)) = 1"                  
		        );

		        $yesterday =  $this->db->single()->total_DS;

		        //get user total invites by today
				$this->db->query(
					"SELECT COUNT(*) as total_DS  FROM `users` 
					 WHERE direct_sponsor = '{$userid}'
					 AND  DATE(created_at)='$today'"                  
		        );

		        $today_ds =  $this->db->single()->total_DS;
		     

				$userObject = (object) [
				 	'userid' 	=>  $userid,
					'username'	=>  $user_info->username,
					'fullname' 	=>  $user_info->fullname,
					'month' 	=>	$month,
					'week' 	=>	$week,
					'yesterday' =>  $yesterday,
					'today' 	=>	$today_ds,
					'array_index' 	=> $key
    			];

    			array_unshift($UserData, $userObject);

		
    	}

    	return $UserData;
	}

	public function get_saved_report()
	{
		$this->db->query(
			"SELECT userid FROM `user_performer`"                  
        );

       $list = $this->db->resultSet();

       $UserList = [];

       foreach ($list as $key => $data) {
       		array_push($UserList, $data->userid);
       }

      return  $UserList;
     
	}

	public function add_to_list_sql($userid)
	{
		
		$this->db->query(
			"INSERT INTO `user_performer` (`userid`) 
			 VALUES  ('{$userid}')"                  
        );

        return $this->db->execute();
	}

	public function delete_to_list_sql($userid)
	{
		$this->db->query(
			"DELETE FROM `user_performer` WHERE userid = {$userid}"                  
        );

        return $this->db->execute();
	}

	public function check_to_list_sql($userid)
	{
		
		$this->db->query(
			"SELECT * FROM `user_performer` 
			 WHERE userid = {$userid}"                  
        );

        return $this->db->single();
	}

	public function reset_list_sql()
	{
		$this->db->query(
			"TRUNCATE TABLE user_performer;"                  
        );

       return $this->db->execute();
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

?>
