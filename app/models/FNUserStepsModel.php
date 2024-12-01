<?php 
	class FNUserStepsModel extends Base_model
	{

		public function __construct()
		{

			parent::__construct();
			$this->productRelease = model('FNProductBorrowerModel');
			$this->loanPayment = model('FNProductReleasePaymentModel');

			$this->socialMedia = model('UserSocialMediaModel');

			$this->noteModel = model('FNProductLoanNoteModel');
			$this->cx = model('FNProductBorrowerCXModel');

		}

		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
       		$this->db->execute();
		}


		public function insert_step1_users()
		{	
			$branchId = 8;
			$status = 'Paid';
			$data = $this->cx->getMeta(compact(['branchId' , 'status']));
			foreach ($data as $key => $value) {


				if($value->payment['total'] >= 1500)
				{
					$this->db->query("INSERT INTO `toc_passers`( `userid`, `position`, `is_paid`)   		
						VALUES ('$value->userid', '1', true ) ");
					$this->db ->execute();
				}	
			}
		}

		public function get_position1($branchId)
		{
			$this->set_time_zone();
			$status = 'Paid';
			$data = $this->cx->getMeta(compact(['branchId' , 'status']));

			foreach ($data as $key => $value) {

				$this->db->query("SELECT *
								  FROM toc_passers 
								  WHERE userid = '$value->userid'");
				$check_data = $this->db->single();


				if(!empty($check_data))
				{	
					if($check_data->is_standby == true || $check_data->position)
					{
						unset($data[$key]);
					}
				}

				
			}
			return $data;
		}


		public function getProductBorrowerUser($userId)
		{
			$userAddressModel = model('UserAddressesModel');

	
			$this->db->query(
			   "SELECT users_uploaded_id.*,COUNT(users_uploaded_id.id) as total_valid_id,
				users.username as username,
				CONCAT(users.firstname,' ',users.lastname)as fullname,
				users.email as email,
				users.mobile as mobile,
				users.address as address,
				users.created_at as registered_at,
				users_uploaded_id.id as uploaded_id_id,userid,
				users_uploaded_id.date_time as date_time
				FROM `users_uploaded_id` INNER JOIN `users`
				WHERE users.id = '{$userId}'
				group by userid ORDER BY users_uploaded_id.date_time DESC"
			);

			$value = $this->db->single();

			/**/
			$copAddress = $userAddressModel->getCOP($value->userid);

			// check if there is as social media
			$this->db->query(
				   "SELECT
				    (SELECT COUNT(*) FROM user_social_media 
				    WHERE userid = {$value->userid} 
				    AND status='verified') as total_valid_link , 
				   link as valid_link 
				   FROM user_social_media 
				   WHERE userid = {$value->userid} AND status='verified' AND type='Facebook'"
			);

    		$social_link_info = $this->db->single();

    		$reason = '';

    		// get total direct sponsor
			$this->db->query(
				   "SELECT COUNT(*) as total FROM users WHERE direct_sponsor = {$value->userid}"
				);

    		$total_direct_ref = $this->db->single()->total ?? 0;

			$reason = "";

			$userObject = (object) [
			 	'uploaded_id_id'=> $value->uploaded_id_id,
			 	'userid' => $value->userid,
				'username' => $value->username,
				'fullname' => $value->fullname,
				'email' =>$value->email,
				'mobile' =>$value->mobile,
				'address' =>$value->address,
				'address_cop' => $copAddress,
				'created_at' => $value->registered_at,
				'total_valid_id' =>$value->total_valid_id,
				'date_time' =>$value->date_time,
				'valid_link' =>$social_link_info->valid_link,
				'total_valid_link' =>$social_link_info->total_valid_link,
				'reason' => $reason ?? 'N/A',
				'id_card' => $value->id_card,
				'id_card_back' => $value->id_card_back,
				'type' => $value->type,
				'total_direct_ref' => $total_direct_ref
			];


			return $userObject;
		}

		public function get_product_borrower($branchId)
		{
			$userAddressModel = model('UserAddressesModel');

			$this->db->query(
					   "SELECT users_uploaded_id.*,COUNT(users_uploaded_id.id) as total_valid_id,
						users.username as username,
						CONCAT(users.firstname,' ',users.lastname)as fullname,
						users.email as email,
						users.mobile as mobile,
						users.address as address,
						users.created_at as registered_at,
						users_uploaded_id.id as uploaded_id_id,userid,
						users_uploaded_id.date_time as date_time
						FROM `users_uploaded_id` INNER JOIN `users`
						WHERE users.id = users_uploaded_id.userid AND
						users_uploaded_id.status = 'verified' AND
						users.branchId = '$branchId' group by userid ORDER BY users_uploaded_id.date_time DESC"
					);

	    	$data = $this->db->resultSet();
				
			$UserList = [];

			foreach ($data as $key => $value) 
			{
				$copAddress = $userAddressModel->getCOP($value->userid);

				//check if there is a product release
				$this->db->query(
				   "SELECT COUNT(*) as total FROM fn_product_release WHERE userid = {$value->userid}"
				);
    			$total_product_release = $this->db->single()->total;

    			if($total_product_release)
    				continue;
    			
				// check if there is as social media
				$this->db->query(
					   "SELECT (SELECT COUNT(*) FROM user_social_media WHERE userid = {$value->userid} AND status='verified') as total_valid_link , link as valid_link FROM user_social_media WHERE userid = {$value->userid} AND status='verified' AND type='Facebook'"
				);
	    		$social_link_info = $this->db->single();

	    		//check if there is a valid social link
	    		if(!isset($social_link_info->total_valid_link))
	    			continue;

	    		$reason = '';

	    		// get total direct sponsor
				$this->db->query(
					   "SELECT COUNT(*) as total FROM users WHERE direct_sponsor = {$value->userid}"
					);
	    		$total_direct_ref = $this->db->single()->total ?? 0;

				$reason = "";
				$userObject = (object) [
				 	'uploaded_id_id'=> $value->uploaded_id_id,
				 	'userid' => $value->userid,
					'username' => $value->username,
					'fullname' => $value->fullname,
					'email' =>$value->email,
					'mobile' =>$value->mobile,
					'address' =>$value->address,
					'address_cop' => $copAddress,
					'created_at' => $value->registered_at,
					'total_valid_id' =>$value->total_valid_id,
					'date_time' =>$value->date_time,
					'valid_link' =>$social_link_info->valid_link,
					'total_valid_link' =>$social_link_info->total_valid_link,
					'reason' => $reason,
					'id_card' => $value->id_card,
					'id_card_back' => $value->id_card_back,
					'type' => $value->type,
					'total_direct_ref' => $total_direct_ref
    			];

    			array_unshift($UserList, $userObject);
			}

			return $UserList;



		}


	}